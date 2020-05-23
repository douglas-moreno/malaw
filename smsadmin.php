<?php 
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    require_once 'functions.php';
    require_once "formatatudo.class.php";
    
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
    
    $p = new FormataTudo();
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    
    $sqlbase = baseCondicao('nosms', $eten, $dia, $niver, $dia2, $niver2, $cepc, $nome, $regiao, $bairro, $prestador, $tipos, $filho, $ordem, $numeros, $cadastro1, $cadastro2);
    $sqlsms = baseCondicao('sms', $eten, $dia, $niver, $dia2, $niver2, $cepc, $nome, $regiao, $bairro, $prestador, $tipos, $filho, $ordem, $numeros, $cadastro1, $cadastro2);
    $query = $DB->Query($sqlbase);
    $cont = $DB->FetchNum($query);
    
?>

<!DOCTYPE html> 
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]--> 
<html class="no-js" lang="en" > 
<head> 
	<meta charset="utf-8"> 
	<!-- If you delete this meta tag World War Z will become a reality --> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Web Mala</title> 
	<!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like --> 
	<link rel="stylesheet" href="css/normalize.css"> 
	<link rel="stylesheet" href="css/foundation.css"> 

	<script src="js/vendor/modernizr.js"></script>
        <script language="JavaScript">
            function contador(Campo) {
                var caracteresDigitados = 155 - Campo.value.length;
                document.getElementById("caracteres").innerHTML = caracteresDigitados;
            };
        </script>
</head> 
<body> 
    <?php
        require_once('cabeca.php'); 
        require_once('menu.php');
    ?>
    <div class="row">
        <div class="medium-12 columns">
            <h2 align="center">SMS</h2>
        </div>
    </div>
    <form method="post" action="gerarcsv.php">
        <div class="row">
            <div class="medium-12 columns">
                <fieldset>
                    <legend>Salvar CSV</legend>
                    <!--
                    <label>Campanha
                        <input type="text" name="campanha">
                    </label>
                    <label>Mensagem
                        <textarea id="Txtmensagem" name="Txtmensagem" rows="5" cols="50" onkeyup="contador(this)"></textarea>
                    </label>
                    <small class="caracteres" id="caracteres">155</small><small> Restantes</small><br>
                    -->
                    <button class="button round tiny" value="Enviar">Salvar</button>
                    <a href="impressao.php" class="button round tiny warning">Voltar</a>
                </fieldset>
            </div>
        </div>
        <input type="hidden" name="sqlsms" value="<?php echo $sqlsms; ?>">
    </form>
    <div class="row">
        <div class="medium-12 columns">
            <fieldset>
                <legend>Contatos</legend>
                <?php
                    if ($cont > 0) {
                    $tabela = "<p>$cont registro(s) encontrado(s)</p><table class='responsive' role='grid'>
                                <thead>
                                    <tr>
                                        <th>Detalhes</th>
                                        <th>Eleitor</th>
                                        <th>Aniversário</th>
                                        <th>Endereço</th>
                                        <th>Número</th>
                                        <th>Bairro</th>
                                        <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>";
                    $return = "$tabela";
                    while ($linha = $DB->FetchArray($query)) {
                        $return.= "<tr><td><a href='detalhe.php?codcli=" . $linha["Cod_Cliente"] . "' class='button tiny round'>Abrir</a></td>";
                        $return.= "<td>" . $linha["Nome"] . "</td>";
                        $return.= "<td>" . $p->formatar($linha["Aniversario"], 'data') . "</td>";
                        $return.= "<td>" . $linha["Endereco"] . "</td>";
                        $return.= "<td>" . $linha["Num"] . "</td>";
                        $return.= "<td>" . $linha["Bairro"] . "</td>";
                        $cel = ddD($linha["ddd4"]) . $p->formatar($linha["Celular"],'celular','banco');
                        $return.= "<td>" . $cel . "</td>";
                        $return.= "</tr>";
                    }
                    echo $return."</tbody></table>";
                    $DB->Close();
                    }
                    else {
                        echo 'Não foram encontrados registros';
                    }
                ?>
            </fieldset>
        </div>
    </div>


    <script src="js/vendor/jquery.js"></script> 
    <script src="js/foundation.min.js"></script> 
    <script> $(document).foundation(); </script> 
</body> 
</html>