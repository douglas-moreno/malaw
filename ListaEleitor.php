<?php
    // Verifica se as variáveis existe
    $nome      = $_GET["txtnome"];
    $pag       = $_GET["txtpag"];
    $ende      = $_GET["txtende"];
    $regiao    = $_GET["txtregiao"];
    $bairro    = $_GET["txtbairro"];
    $prestador = $_GET["txtprestador"];
    $cep       = $_GET["txtcep"];
    $f         = $_GET["f"];
    $parametro = 0;
    $sql       = "";

    if (!empty($nome) || !empty($ende) || !empty($regiao) || !empty($cep) || !empty($bairro) || !empty($prestador)) {
        // Conexao com o banco de dados
        include "../mysql/mysqli.class.php";
        include 'formatatudo.class.php';

        $p = new FormataTudo();
        $DB = new mysql;
        $connec = $DB->Connect("mcape067_maladb");
        $sql = "Select e.Cod_Cliente, e.Nome, e.Aniversario, de.Endereco, de.Num, de.Bairro from Cliente e 
        inner join Endereco de on e.Cod_Cliente = de.Cod_Cliente";
        
        if($prestador != "") {
            $sql.= " inner join Servico_Prestado sp on e.Cod_Cliente = sp.Cod_Cliente"
                 . " inner join Prestador pr on sp.Cod_Prestador = pr.Codigo_Prestador"
                 . " where pr.Prestador like '%" . $prestador . "%'";
            $parametro = 1;
        }
        if ($nome != "") {
            if ($parametro == 0)
            {
                $sql.= " where e.Nome like '%" . $nome . "%'";
                $parametro = 1;
            }
            else {
                $sql.= " and e.Nome like '%" . $nome . "%'";
            }
        }
        if ($ende != "") {
            if ($parametro == 0)
            {
                $sql.= " where de.Endereco like '%" . $ende . "%'";
                $parametro = 1;
            }
            else {
                $sql.= " and de.Endereco like '%" . $ende . "%'";
            }
        }
        if ($regiao != "") {
            if ($parametro == 0)
            {
                $sql.= " where de.Regiao like '%" . $regiao . "%'";
                $parametro = 1;
            }
            else {
                $sql.= " and de.Regiao like '%" . $regiao . "%'";
            }
        }
        if ($bairro != "") {
            if ($parametro == 0)
            {
                $sql.= " where de.Bairro like '%" . $bairro . "%'";
                $parametro = 1;
            }
            else {
                $sql.= " and de.Bairro like '%" . $bairro . "%'";
            }
        }
        if ($cep != "") {
            if ($parametro == 0)
            {
                $sql.= " where de.CEP = '" . $cep . "'";
                $parametro = 1;
            }
            else {
                $sql.= " and de.CEP = '" . $cep . "'";
            }
        }
        
        $sql.= " Order By de.Endereco, de.Num, e.Nome";
        
        $query = $DB->Query($sql);
        $cont = $DB->FetchNum($query);
        if ($cont > 0) {
        // Atribui o código HTML para montar uma tabela
        $tabela = "<p>$cont registro(s) encontrado(s)</p><table class='responsive' role='grid'>
                    <thead>
                        <tr>
                            <th>Detalhes</th>
                            <th>Eleitor</th>
                            <th>Aniversário</th>
                            <th>Endereço</th>
                            <th>Número</th>
                            <th>Bairro</th>
                        </tr>
                    </thead>
                    <tbody>";
        $return = "$tabela";
        while ($linha = $DB->FetchArray($query)) {
            if ($pag == 1) {
                $return.= "<tr><td><a href='detalhe.php?codcli=" . $linha["Cod_Cliente"] . "' class='button tiny round'>Abrir</a></td>";
            }
            else {
                $return.= "<tr><td><a href='salvaAgregado.php?codcli=" . $linha["Cod_Cliente"] . "&f=$f' class='button tiny round'>Adicionar</a></td>";
            }
            $return.= "<td>" . $linha["Nome"] . "</td>";
            $return.= "<td>" . $p->formatar($linha["Aniversario"], 'data') . "</td>";
            $return.= "<td>" . $linha["Endereco"] . "</td>";
            $return.= "<td>" . $linha["Num"] . "</td>";
            $return.= "<td>" . $linha["Bairro"] . "</td>";
            $return.= "</tr>";
        }
        echo $return."</tbody></table>";
        $DB->Close();
        }
        else {
            echo 'Não foram encontrados registros';
        }
    }
    else {
        // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
        echo "Informe um Parâmetro";
}
?>