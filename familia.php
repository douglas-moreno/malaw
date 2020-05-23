<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo();
    
    $c = $_GET['c'];
    $f = $_GET['f'];
    
    
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
        <link rel="stylesheet" href="../foundation-icons/foundation-icons.css">

	<script src="js/vendor/modernizr.js"></script> 
</head> 
<body> 
    <?php require_once('cabeca.php'); ?>
    <script type="text/javascript" src="ajax.js"></script>
    <div class="row">
        <div class="medium-12 columns">
            <?php require_once 'menu.php'; ?>
        </div>
    </div>
    <?php 
        if ($f == 0){
            $telaf = "
                <div class='row'>
                <div class='medium-12 columns'>
                    <h1 align='center'>Família</h1>
                </div>
            </div>
            <div class='row'>
                <div class='medium-12 columns'>
                    <form name='formCadFamilia' method='post' action='addFamilia.php' data-abide>
                        <input type='hidden' value='$c' name='codcli'>
                        <div class='row'>
                            <div class='medium-12 columns'>
                                <label>Nome da Família
                                    <input type='text' name='nomeFamilia' required pattern='[a-zA-Z]+' autofocus />
                                    <small class='error'>Campo Obrigatorio - Somente Letras</small>
                                </label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='medium-12 columns'>
                                <a href='detalhe.php?codcli=$c' class='round tiny button'>Voltar</a>
                                <input class='button round tiny' type='Submit' value='Salvar'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>";
            echo $telaf;
        }
        else {
            $DB = new mysql();
            $connec = $DB->Connect("mcape067_maladb");
            $sqlf = "Select Nome_Familia FROM Familia where Cod_Familia = $f";
            $queryf = $DB->Query($sqlf);
            $linha = $DB->FetchArray($queryf);
            
            $sqlag =  "Select Agregado.Cod_Cliente, Principal, Nome, Aniversario, Data FROM Agregado "
                    . "inner join Cliente on (Agregado.Cod_Cliente = Cliente.Cod_Cliente) "
                    . "where Cod_Familia = $f order by Principal DESC, Nome ASC";
            
            $queryag = $DB->Query($sqlag);
            
            $telaf = "<div class='row'>
                <div class='medium-12 columns'>
                    <h1 align='center'>Família " . $linha['Nome_Familia'] ." </h1>
                </div>
            </div>";
            echo $telaf;
            
            if($DB->FetchNum($queryag) > 0) {
                $tabela2 = "<div class='row'><div class='medium-12 columns'>";
                $tabela2 .= "<table class='responsive' align='center'>
                            <thead><tr>
                                <th>Detalhe</th>
                                <th>Nome</th>
                                <th>Aniversário</th>
                                <th>Data de Cadastro</th>
                                <th>Principal</th>
                                <th>Opcão</th>
                                </tr>
                            </thead><tbody>";
                while ($linha3 = $DB->FetchArray($queryag)) {
                    $tabela2 .= "<tr><td><a href='detalhe.php?codcli=" . $linha3["Cod_Cliente"] . "' class='button tiny round'>Abrir</a></td>";
                    $tabela2 .= "<td>" . $linha3["Nome"] . "</td>";
                    $tabela2 .= "<td>" . $p->formatar($linha3["Aniversario"], 'data') . "</td>";
                    $tabela2 .= "<td>" . $p->formatar($linha3["Data"], 'data') . "</td>";
                    if ($linha3['Principal'] == 1) {
                        $tabela2 .= "<td><i class='fi-check'></i></td>";
                    }
                    else {
                        $tabela2 .= "<td>&nbsp;</td>";
                    }
                    $tabela2 .= "<td><a href='removeAgregado.php?c=" . $linha3["Cod_Cliente"] . "&f=". $f . "'><i class=\"fi-trash\"></i></a></td></tr>";
                }
                echo $tabela2 . "</tbody></table></div></div>";
            }
            $telaaddfam = " <div class='row'>
                                <div class='medium-12 columns'>
                                    <a href='detalhe.php?codcli=$c' class='round tiny button'>Voltar</a>
                                    <a href='addAgregado.php?f=$f' class='button tiny round'>Adicionar</a>
                                </div>
                            </div>";
            echo $telaaddfam;
        }
    ?>
    
    
    
    <script src="js/vendor/jquery.js"></script> 
    <script src="js/foundation.min.js"></script> 
    <script> $(document).foundation(); </script> 
</body> 
</html>