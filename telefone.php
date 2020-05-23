<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo();
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    
    $codigo = $_GET['c'];
    $sqlTel = "Select * FROM Telefone where Cod_Cliente = $codigo";
    $queryTel = $DB->Query($sqlTel);
    

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
        <link type="text/css" media="screen" rel="stylesheet" href="../tables/responsive-tables.css" />

        <script type="text/javascript" src="../tables/responsive-tables.js"></script>

	<script src="js/vendor/modernizr.js"></script> 
</head> 
<body> 
    <?php require_once('cabeca.php'); ?>
    <div class="row">
        <div class="medium-12 columns">
            <?php require_once 'menu.php'; ?>
        </div>
    </div>
    <div class="row">
        <div class="medium-12 columns">
            <h1 align="center">Telefone</h1>
        </div>
    </div>
    <div class="row">
        <div class="medium-6 columns">
            <form action="addTelefone.php" method="post" data-abide>
                <input type='hidden' value='<?php echo $codigo ?>' name='codcli'>
                <input type="text" name="nomecli" placeholder="Nome" required>     
        </div>
        <div class="medium-1 columns">
            <input type="text" value="11" name="dddcli" required>
        </div>
        <div class="medium-4 columns">
            <input type="text" name="numerocli" placeholder="Numero" required>
        </div>
        <div class="medium-1 columns">
            <input class="button tiny round" type="submit" value="+" name="submit" onclick="return confirm('Adicionar Telefone ?')">
        </div>
        </form>
        
    </div>
    <?php
        while ($linhaTel = $DB->FetchArray($queryTel)) {
            echo ("<div class=\"row\">
                <div class=\"medium-6 columns\">"
                    .$linhaTel["Nome"].
                "</div>
                <div class=\"medium-1 columns\">"
                    .$linhaTel["ddd"].
                "</div>
                <div class=\"medium-4 columns\">"
                    .$p->formatar($linhaTel["Numero"], 'celular').
                "</div>
                <div class=\"medium-1 columns\">
                    <a href=\"removeTelefone.php?c=" . $codigo . "&t=" . $linhaTel["Numero"] . "\" onclick=\"return confirm('Remover Telefone ?')\"><i class=\"fi-trash\"></i></a>
                </div>
            </div>");
        }
    ?>
    <div class="row">
        <div class="medium-12 columns">
            <?php echo "<a href='detalhe.php?codcli=". $codigo . "' class='button tiny round'>Voltar</a>"; ?>
        </div>
    </div>
    <script src="js/vendor/jquery.js"></script> 
    <script src="js/foundation.min.js"></script> 
    <script> $(document).foundation(); </script> 
</body> 
</html>
