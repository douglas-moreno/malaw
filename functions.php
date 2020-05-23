<?php
    function baseCondicao($v0, $v1, $v2, $v3, $v4, $v5, $v6, $v7, $v8, $v9, $v10, $v11, $v12, $v13, $v14, $v15, $v16) {
        
        $eten   = $v1;
        $dia    = $v2;
        $niver  = $v3;
        $dia2   = $v4;
        $niver2 = $v5;
        $cepc   = $v6;
        $nome   = $v7;
        $regiao = $v8;
        $bairro = $v9;
        $prestador = $v10;
        $tipos  = $v11;
        $filho  = $v12;
        $ordem  = $v13;
        $numeros = $v14;
        $cadastro1 = dataCadastro($v15);
        $cadastro2 = dataCadastro($v16);
        $indica = 0;
        $condipresta = 0;
        $condicao = "";
        $pagina = $v0;
        $base = "";
        
        if ($pagina == 'sms') {
            $base = "Select CONCAT(Outras.ddd4, Outras.Celular) as Numero, Cliente.Nome FROM Cliente "
                    . " left join Endereco on (Cliente.Cod_Cliente = Endereco.Cod_Cliente) "
                    . " left join Outras on (Cliente.Cod_Cliente = Outras.Cod_Cliente) ";
        } 
        else {
            $base = "Select Cliente.*, Endereco.*, Outras.ddd2, Outras.ddd3, Outras.ddd4, Outras.Tel1 as OTel1, Outras.Tel2, Celular From Cliente 
                    left join Endereco on (Cliente.Cod_Cliente = Endereco.Cod_Cliente)
                    left join Outras on (Cliente.Cod_Cliente = Outras.Cod_Cliente) ";
        }
        if(!empty($tipos)) {
            if($condipresta==0) {
                $base.= " left join Servico_Prestado on (Cliente.Cod_Cliente = Servico_Prestado.Cod_Cliente)";
                $base.= " left join Prestador on (Servico_Prestado.Cod_Prestador = Prestador.Codigo_Prestador)";
            }
            if($indica == 0){
                $condicao.= " where Servico_Prestado.Cod_Tipo in (" . $tipos . ")";
                $indica = 1;
            }
            else {
                $condicao.= " and Servico_Prestado.Cod_Tipo in (" . $tipos . ")";
            }
        }
        
        if(!empty($prestador)) {
            //$condipresta = 1;
            //$base.= " left join Servico_Prestado on (Cliente.Cod_Cliente = Servico_Prestado.Cod_Cliente)";
            //$base.= " left join Prestador on (Servico_Prestado.Cod_Prestador = Prestador.Codigo_Prestador)";
            if($indica == 0){
                $condicao.= " where Cliente.Cod_Prestador in (" . $prestador . ")";
                $indica = 1;
            }
            else {
                $condicao.= " and Cliente.Cod_Prestador in (" . $prestador . ")";
            }
        }
        
        if(!empty($numeros)) {
            if($indica == 0) {
                $condicao.= " where Endereco.Num in (" . $numeros . ")";
                $indica = 1;
            }
            else {
                $condicao.= " and Endereco.Num in (" . $numeros . ")";
            }
        }
        
        if(!empty($cadastro1) and !empty($cadastro2)){
            //echo $cadastro1 . "<br>" . $cadastro2  ."<br>";
            if($indica == 0) {
                $condicao.= " where Cliente.Data BETWEEN '$cadastro1' AND '$cadastro2'";
                $indica = 1;
            }
            else {
                $condicao.= " and Cliente.Data BETWEEN '$cadastro1' AND '$cadastro2'";
            }
        }
        if($eten=="0") {
            echo "<h1 align='center'>Por favor selecione o TIPO de impressè´™o</h1><br>"
            . "Clique <a href='#' onclick='self.close()'> aqui </a> para fechar esta janela";
            exit();
        }
        if ($niver!="0") {
            if($dia!="0"){
                if($indica == 0){
                    $condicao.= " where MONTH(Cliente.Aniversario) BETWEEN $niver AND $niver2 and DAY(Cliente.Aniversario) BETWEEN $dia AND $dia2";
                    $indica = 1;
                }
                else {
                    $condicao.= " and MONTH(Cliente.Aniversario) BETWEEN $niver AND $niver2 and DAY(Cliente.Aniversario) BETWEEN $dia AND $dia2";
                }
            }
        }
        if ($cepc!="") {
            if($indica==0){
                $condicao .= " where Endereco.CEP = '" . $cepc ."'";
                $indica = 1;
            }
            else {
                $condicao .= " and Endereco.CEP = '" . $cepc ."'";
            }
        }
        if ($regiao!="0") {
            if($regiao == "9999") {
                if($indica==0){
                    $condicao.= " where Endereco.Regiao = '' ";
                    $indica = 1;
                }
                else {
                    $condicao.= " and Endereco.Regiao = '' ";
                }
            }
            else {
                if($indica==0) {
                    $condicao.= " where Endereco.Regiao like '%" . $regiao . "%'";
                    $indica =1;
                }
                else {
                    $condicao.= " and Endereco.Regiao like '%" . $regiao . "%'";
                }
            }
        }
        if ($nome!="") {
            if($indica==0) {
                $condicao.= " where Cliente.Nome like '%" . $nome . "%'";
                $indica = 1;
            }
            else {
                $condicao.= " and Cliente.Nome like '%" . $nome . "%'";
            }
        }
        if ($filho==1) {
            if($indica==0){
                $condicao.= " where Cliente.Filho='Sim' and Cliente.Sexo='F'";
                $indica = 1;
            }
            else {
                $condicao.= " and Cliente.Filho='Sim' and Cliente.Sexo='F'";
            }
        }
        elseif ($filho==2) {
            if($indica==0) {
                $condicao.= " where Cliente.Filho='Sim' and Cliente.Sexo='M'";
                $indica = 1;
            }
            else {
                $condicao.= " and Cliente.Filho='Sim' and Cliente.Sexo='M'";
            }
        }
        if ($bairro!=""){
            if($indica==0) {
                $condicao.= " where Endereco.Bairro like '%" .$bairro . "%'";
                $indica = 1;
            }
            else {
                $condicao.= " and Endereco.Bairro like '%" .$bairro . "%'";
            }
        }
        
        if($eten=="5") {
            if($indica==0) {
                $condicao.= " where Outras.Celular is not null and Outras.Celular != '' ";
                $indica = 1;
            }
            else {
                $condicao.= " and Outras.Celular is not null and Outras.Celular != '' ";
            }
        }
        if($ordem==1){
            if($indica==0) {
                $condicao.=" where Cliente.Negra = 0 Order By Endereco.Endereco ASC, Endereco.Num ASC"; # limit 0, 50";
                $indica = 1;
            }
            else {
                $condicao.=" and Cliente.Negra = 0 Order By Endereco.Endereco, Endereco.Num";
            }
        }
        else {
            if($indica==0) {
                $condicao.=" where Cliente.Negra = 0 Order By Cliente.Nome";
                $indica = 1;
            }
            else {
                $condicao.=" and Cliente.Negra = 0 Order By Cliente.Nome";
            }
        }
        
        return $base . $condicao;
    }
    
    function redirect($pagina){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = $pagina;
        $url = "http://".$host.$uri."/".$extra;    
        if (headers_sent()){
            die('<script type="text/javascript">window.location=\''.$url.'\';</script>');
        }
        else{
            header('Location: ' . $pagina);
            die();
        }
    }
    
    function ddD($valor) {
        if($valor == '' or empty($valor) or $valor == 0) {
            return "11";
        }
        else {
            return $valor;
        }
    }
    
    function dataCadastro($valor) {
        if (!empty($valor)) {
            $temp1 = explode("/", $valor);
            $datacad = $temp1[2] . "-" . $temp1[1] . "-" . $temp1[0];
            return $datacad;
        }
    }
?>