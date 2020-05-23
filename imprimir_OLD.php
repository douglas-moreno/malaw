<?php
    require('makeSecure.php');
    require '../fpdf17/fpdf.php';
    include "../mysql/mysqli.class.php";
    require "formatatudo.class.php";
    require_once "functions.php";
    
class PDF extends FPDF {
    
    function Header() {
        if($_POST["eten"]==3 || $_POST["eten"]==4) {
            // Select Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Move to the right
            $this->Cell(80);
            // Framed title
            $this->Cell(30, 0, 'Mala WEB', 0, 0, 'C');
            // Line break
            $this->Ln(5);
        }
    }
    
    function Footer() {
        if($_POST["eten"]==3 || $_POST["eten"]==4) {
            // Go to 1 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            $this->Cell(0,10,'Mala WEB Pag. '.$this->PageNo().' de {nb}',0,0,'C');
        }
    }
}
    
    $eten   = $_POST["eten"];
    $dia    = $_POST["dia"];
    $niver  = $_POST["mes"];
    $dia2   = $_POST["dia2"];
    $niver2 = $_POST["mes2"];
    $cepc   = $_POST["cep"];
    $nome   = $_POST["nome"];
    $regiao = $_POST["regiao"];
    $bairro = $_POST["bairro"];
    $prestador = $_POST["prestadors"];
    $tipos  = $_POST["tipos"];
    $filho  = $_POST["filho1"];
    $ordem  = $_POST["ord"];
    $numeros = $_POST["numeross"];
    $cadastro1 = $_POST["cadastro1"];
    $cadastro2 = $_POST["cadastro2"];
    $indica = 0;
    $condipresta = 0;
    $condicao = "";

    
    $sqlbase = baseCondicao($eten, $dia, $niver, $dia2, $niver2, $cepc, $nome, $regiao, $bairro, $prestador, $tipos, $filho, $ordem, $numeros, $cadastro1, $cadastro2);
    
    if($eten=="1") {
        $pdf = new PDF("P","mm","A4");
        $pdf->Open();
        $pdf->AddPage();
        etiqueta($pdf, $sqlbase);
    }
    elseif ($eten=="2") {
        $pdf = new PDF("L","mm","A4");
        $pdf->Open();
        envelope($pdf, $sqlbase);
    }
    elseif($eten=="3") {
        $pdf = new PDF("P","mm","A4");
        $pdf->AliasNbPages();
        $pdf->Open();
        $pdf->AddPage();
        lista($pdf, $sqlbase);
    }    
    elseif($eten=="4") {
        $pdf = new PDF("P","mm","A4");
        $pdf->AliasNbPages();
        $pdf->SetTopMargin(10);
        $pdf->Open();
        $pdf->AddPage();
        listaDetalhe($pdf, $sqlbase);
    }

    function etiqueta($pdf, $base){
        $pdf->SetFont('Arial','',7);        
        $sql = $base;
        $DB = new mysql();
        $connec = $DB->Connect("mcape067_maladb");
        $queryet = $DB->Query($sql);
        $p = new FormataTudo();
        
        $mesq = 6.35; // Margem Esquerda (mm)
        $mdir = 6.35; // Margem Direita (mm)
        $msup = 18; // Margem Superior (mm)
        $leti = 72; // Largura da Etiqueta (mm)
        $aeti = 26; // Altura da Etiqueta (mm)
        $ehet = 74; // Espaço horizontal entre as Etiquetas (mm)

        // Variaveis pro Loop

        $coluna = 0;
        $linha = 0;

        //MONTA A ARRAY PARA ETIQUETAS
        while($dados = $DB->FetchArray($queryet)) {
            $nome = utf8_decode($dados["Nome"]);
            $ende = utf8_decode($dados["Endereco"]) . ", " . $dados["Num"];
            $cida = utf8_decode($dados["Cidade"]);
            $local = empty($dados["Complemento"]) ? $cida : utf8_decode($dados["Complemento"]) . " - " . $cida  . " ";
            $bairro = utf8_decode($dados["Bairro"]);
            $cep = $bairro . " - " . $p->formatar($dados["CEP"], "cep");
            if(strlen($ende) > 30) {
                $posicao = strpos(mb_substr($ende,30),' ') + 30;
                $local = mb_substr($ende,$posicao) . "-" . $local;
                $ende = mb_substr($ende, 0, $posicao);
            }

            if($coluna == "3") { // Se for a terceira coluna
                $coluna = 0; // $coluna volta para o valor inicial
                $linha = $linha +1; // $linha é igual ela mesma +1
            }

            if($linha == "10") { // Se for a última linha da página
                $pdf->AddPage(); // Adiciona uma nova página
                $linha = 0; // $linha volta ao seu valor inicial
            }

            $posicaoV = $linha*$aeti;
            $posicaoH = $coluna*$leti;

            if($coluna == "0") { // Se a coluna for 0
                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
            } else { // Senão
                $somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
            }

            if($linha == "0") { // Se a linha for 0
                $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
            $pdf->Text($somaH,$somaV+4,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
            $pdf->Text($somaH,$somaV+8,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
            $pdf->Text($somaH,$somaV+12,$cep); // Imprime o cep da pessoa de acordo com as coordenadas

            $coluna = $coluna+1;
        }
        $pdf->Output(); // encerra o arquivo PDF
                   
    }

   function envelope($pdf, $base){
        $pdf->SetFont('Arial','',24);
        $sql = $base;
        $DB = new mysql();
        $connec = $DB->Connect("mcape067_maladb");
        $queryet = $DB->Query($sql);
        $p = new FormataTudo();
        
        $mesq = 6.35; // Margem Esquerda (mm)
        $mdir = 6.35; // Margem Direita (mm)
        $msup = 14; // Margem Superior (mm)
        $leti = 65; // Largura da Etiqueta (mm)
        $aeti = 25; // Altura da Etiqueta (mm)
        $ehet = 65; // Espaço horizontal entre as Etiquetas (mm)

        // Variaveis pro Loop

        $coluna = 0;
        $linha = 0;

        //MONTA A ARRAY PARA ETIQUETAS
        while($dados = $DB->FetchArray($queryet)) {
            $pdf->AddPage();
            $nome = utf8_decode($dados["Nome"]);
            $ende = utf8_decode($dados["Endereco"]) . ", " . $dados["Num"];
            $cida = utf8_decode($dados["Cidade"]);
            $local = empty($dados["Complemento"]) ? $cida : utf8_decode($dados["Complemento"]) . " - " . $cida;
            $bairro = utf8_decode($dados["Bairro"]);
            $cep = $bairro . " - " . $p->formatar($dados["CEP"], "cep") ;

            $pdf->Text(10,100,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
            $pdf->Text(10,109,$ende); // Imprime o endereço da pessoa de acordo com as coordenadas
            $pdf->Text(10,118,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
            $pdf->Text(10,127,$cep); // Imprime o cep da pessoa de acordo com as coordenadas
        }
        $pdf->Output(); // encerra o arquivo PDF
    }
   
    function lista($pdf, $base){
        $pdf->SetFont('Arial','',12);
        $p = new FormataTudo();
        $sql = $base;
        $DB = new mysql();
        $connec = $DB->Connect("mcape067_maladb");
        $queryet = $DB->Query($sql);
        
        $mesq = 6.35; // Margem Esquerda (mm)
        $mdir = 6.35; // Margem Direita (mm)
        $msup = 14; // Margem Superior (mm)
        $leti = 200; // Largura da Etiqueta (mm)
        $aeti = 31; // Altura da Etiqueta (mm)
        $ehet = 5; // Espaço horizontal entre as Etiquetas (mm)

        // Variaveis pro Loop

        $coluna = 0;
        $linha = 0;
        
        //$qtde = $DB->FetchNum($queryet);
        while($dados = $DB->FetchArray($queryet)) {
            if (empty($dados["Tipo"])) {
                $nome = utf8_decode($dados["Nome"]);
            }
            else {
                $nome = utf8_decode($dados["Nome"]) . " - " . utf8_decode($dados["Tipo"]);
            }
            $aniversario = "Aniversario: " . $p->formatar($dados["Aniversario"],"data");
            $ende = utf8_decode($dados["Endereco"]) . ", " . $dados["Num"];
            $cida = utf8_decode($dados["Cidade"]) . " - " . utf8_decode($dados["Regiao"]);
            $local = empty($dados["Complemento"]) ? $cida : utf8_decode($dados["Complemento"]) . " - " . $cida;
            $bairro = utf8_decode($dados["Bairro"]);
            $cep = $bairro . " - " . $p->formatar($dados["CEP"],"cep");
            if(strlen($dados["Tel1"])==8) {
                $telefone = "Tel: (" . $dados["ddd"] . ") " . $p->formatar($dados["Tel1"],"telefone");
            }
            else {
                $telefone = "Tel: (" . $dados["ddd"] . ") " . $p->formatar($dados["Tel1"],"celular");
            }
            
            $titulo = "Titulo: ". $dados["Titulo"] . " Zona: " . $dados["Zona"] . " Secao: " . $dados["Secao"];
            $celular = "Cel: (" . $dados["ddd4"] . ") " . $p->formatar($dados["Celular"],"celular");
            $outroTel1 = "Tel2: (" . $dados["ddd2"] . ") " . $p->formatar($dados["OTel1"],"telefone");
            $outroTel2 = "Tel3: (" . $dados["ddd3"] . ") " . $p->formatar($dados["Tel2"],"telefone");
            $filho="";
            if($dados["Filho"]=="Sim") {
                $filho = "Possui Filho: Sim";
            }
            elseif($dados["Filho"]=="Nao") {
                $filho = "Possui Filho: Nao";
            }
            else {
                $filho = "Possui Filho: Sem Resposta";
            }
             
            if($linha == 9) { // Se for a última linha da página  
                $pdf->AddPage(); // Adiciona uma nova página
                $linha = 0; // $linha volta ao seu valor inicial
            }

            $posicaoV = $linha*$aeti;
            $posicaoH = $coluna*$leti;

            if($coluna == 0) { // Se a coluna for 0
                $somaH = $mesq; // Soma Horizontal é apenas a margem da esquerda inicial
            } else { // Senão
                $somaH = $mesq+$posicaoH; // Soma Horizontal é a margem inicial mais a posiçãoH
            }

            if($linha == 0) { // Se a linha for 0
                $somaV = $msup; // Soma Vertical é apenas a margem superior inicial
            } else { // Senão
                $somaV = $msup+$posicaoV; // Soma Vertical é a margem superior inicial mais a posiçãoV
            }

            $pdf->Text($somaH,$somaV,$nome); // Imprime o nome da pessoa de acordo com as coordenadas
            $pdf->Text($somaH+140,$somaV,$aniversario);
            $pdf->Text($somaH,$somaV+5,$titulo); // Imprime o endereço da pessoa de acordo com as coordenadas
            $pdf->Text($somaH+140,$somaV+5,$telefone);
            $pdf->Text($somaH,$somaV+10,$ende);
            $pdf->Text($somaH+140,$somaV+10,$celular);
            $pdf->Text($somaH,$somaV+15,$local); // Imprime a localidade da pessoa de acordo com as coordenadas
            $pdf->Text($somaH,$somaV+20,$cep); // Imprime o cep da pessoa de acordo com as coordenadas
            $pdf->Text($somaH+140,$somaV+20,$filho); // Imprime se a pessoa tem filho
            $pdf->Text($somaH,$somaV+25,$outroTel1);
            $pdf->Text($somaH+140,$somaV+25,$outroTel2);
            $pdf->Line($somaH,$somaV+27,$somaH+195,$somaV+27); // Linha horizontal

            $linha = $linha + 1;
            
        }        
        $pdf->Output(); // encerra o arquivo PDF
    }
    
    function listaDetalhe($pdf, $base){
        #echo "Entrou na funcao Lista Det.<br>";
        $p = new FormataTudo();
        $sql = $base;   
        #echo $sql;
        $DB = new mysql();
        $connec = $DB->Connect("mcape067_maladb");
        $queryet = $DB->Query($sql);
          
        $mesq = $pdf->GetX(); // 6.35; // Margem Esquerda (mm)
        $mdir = 6.35; // Margem Direita (mm)
        $msup = 14; // Margem Superior (mm)
        $leti = 200; // Largura da Etiqueta (mm)
        $aeti = 28; // Altura da Etiqueta (mm)
        $ehet = 5; // Espaço horizontal entre as Etiquetas (mm)

        // Variaveis pro Loop

        $coluna = 0;
        $linha = 0;
        
        #echo "Entrando no Loop 1<br>";
        //$qtde = $DB->FetchNum($queryet);
        while($dados = $DB->FetchArray($queryet)) {
            $pdf->SetFont('Arial','',12);
            $pdf->SetX($mesq);
            if (empty($dados["Tipo"])) {
                $nome = utf8_decode($dados["Nome"]);
            }
            else {
                $nome = utf8_decode($dados["Nome"]) . " - " . utf8_decode($dados["Tipo"]);
            }
            if(empty($dados["Cod_Cliente"])){
                $codcli = 0;
            }
            else {
                $codcli = $dados["Cod_Cliente"];
            }
            $aniversario = "Aniversario: " . $p->formatar($dados["Aniversario"],"data");
            $ende = utf8_decode($dados["Endereco"]) . ", " . $dados["Num"];
            $cida = utf8_decode($dados["Cidade"]) . " - " . utf8_decode($dados["Regiao"]);
            $local = empty($dados["Complemento"]) ? $cida : utf8_decode($dados["Complemento"]) . " - " . $cida;
            $bairro = utf8_decode($dados["Bairro"]);
            $cep = $bairro . " - " . $p->formatar($dados["CEP"],"cep");
            if (strlen($dados["Tel1"])==8) {
                $telefone = "Tel: (" . $dados["ddd"] . ") " . $p->formatar($dados["Tel1"],"telefone");
            }
            else {
                $telefone = "Tel: (" . $dados["ddd"] . ") " . $p->formatar($dados["Tel1"],"celular");
            }
            $titulo = "Titulo: ". $dados["Titulo"] . " Zona: " . $dados["Zona"] . " Secao: " . $dados["Secao"];
            $celular = "Cel: (" . $dados["ddd4"] . ") " . $p->formatar($dados["Celular"],"celular");
            $outroTel1 = "Tel2: (" . $dados["ddd2"] . ") " . $p->formatar($dados["OTel1"],"telefone");
            $outroTel2 = "Tel3: (" . $dados["ddd3"] . ") " . $p->formatar($dados["Tel2"],"telefone");
            $filho="";
            if($dados["Filho"]=="Sim") {
                $filho = "Possui Filho: Sim";
            }
            elseif($dados["Filho"]=="Nao") {
                $filho = "Possui Filho: Nao";
            }
            else {
                $filho = "Possui Filho: Sem Resposta";
            }
            #echo "Gerou os dados linha 1<br>";
            $pdf->Cell(0,5,$nome,'T',0,'L');
            $pdf->Cell(0,5,$aniversario,0,1,'R');
            $pdf->Cell(0,5,$titulo,0,0,'L');
            $pdf->Cell(0,5,$telefone,0,1,'R');
            $pdf->Cell(0,5,$ende,0,0,'L');
            $pdf->Cell(0,5,$celular,0,1,'R');
            $pdf->Cell(0,5,$local,0,1,'L');
            $pdf->Cell(0,5,$cep,0,0,'L');
            $pdf->Cell(0,5,$filho,0,1,'R');
            $pdf->Cell(0,5,$outroTel1,0,0,'L');
            $pdf->Cell(0,5,$outroTel2,0,1,'R');
            $pdf->ln(5);
            
            #echo "Gerando segundo select ...<br>";
            $sqldet = "Select Servico_Prestado.*, Prestador.Prestador FROM Servico_Prestado";
            $sqldet.= " inner join Prestador on (Servico_Prestado.Cod_Prestador = Prestador.Codigo_Prestador)";
            $sqldet.= " WHERE Servico_Prestado.Cod_Cliente = " . $codcli;
            $sqldet.= " order by Data";
            #echo $sqldet . "<br>";
            $querydet = $DB->Query($sqldet);
            
            
            while($dados2 = $DB->FetchArray($querydet)) {
                
                $prestador = utf8_decode($dados2['Prestador']);
                $dia = $p->formatar($dados2['Data'],'data');
                $tipo = utf8_decode($dados2['Tipo']);
                $descricao = utf8_decode($dados2['Descricao']);
                
                $pdf->SetFont('Times','BI',12);
                $pdf->SetX($mesq+5);
                $pdf->SetFillColor(224,224,224);
                $pdf->Cell(0,5,$prestador,0,1,'L');
                $pdf->SetFont('Times','',11);
                $pdf->SetX($mesq+5);
                $pdf->Cell(20,5,$dia,'B',0,'L',1);
                $pdf->Cell(0,5,$tipo,0,1,'L');
                $pdf->SetX($mesq+26.5);
                $pdf->MultiCell(0,5,$descricao,0,'J');
                $pdf->ln();
            
                //$linha = $linha + 1;
            } 
            //$pdf->Line($somaH,$somaV+39,$somaH+195,$somaV+39); // Linha horizonta
        }
        $pdf->Output(); // encerra o arquivo PDF
    }
?>