<?php
    require('makeSecure.php');
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
        <!--
        <link type="text/css" media="screen" rel="stylesheet" href="../tables/responsive-tables.css" />

        <script type="text/javascript" src="../tables/responsive-tables.js"></script>
        -->
	<script src="js/vendor/modernizr.js"></script> 

</head> 
<body> 
    <?php 
        require_once 'cabeca.php';
        require_once 'menu.php';
    ?>
	<script type="text/javascript" src="ajax.js"></script>	
        <form id="formhome">
            <input type="hidden" value="1" name="txtpagina" id="txtpagina" />
            <input type="hidden" value="0" name="f" id="f" />
	<div class="panel">
            <div class="row">		
                <div class="medium-1 column">
                    <label for="txtnome" class="left inline">Eleitor</label>
                </div>
                <div class="medium-11 columns">					
                    <input type="text" required name="txtnome" id="txtnome" placeholder="Pesquisa por Nome" autofocus />
                </div>                
            </div>
            <div class="row">
                <div class="medium-1 columns">
                    <label for="txtende" class="left inline">Endereço</label>
                </div>
                <div class="medium-11 columns">
                    <input type="search" name="txtende" id="txtende" placeholder="Pesquisa por Endereço" />
                </div>
            </div>
            <div class="row">
                <div class="medium-1 columns">
                    <label for="txtregiao" class="left inline">Região</label>
                </div>
                <div class="medium-11 columns">
                    <input type="search" name="txtregiao" id="txtregiao" placeholder="Pesquisa por Região" />
                </div>
            </div>
            <div class="row">
                <div class="medium-1 columns">
                    <label for="txtbairro" class="left inline">Bairro</label>
                </div>
                <div class="medium-11 columns">
                    <input type="search" name="txtbairro" id="txtbairro" placeholder="Pesquisa por Bairro" />
                </div>
            </div>
            <div class="row">
                <div class="medium-1 columns">
                    <label for="txtprestador" class="left inline">Prestador</label>
                </div>
                <div class="medium-11 columns">
                    <input type="search" name="txtprestador" id="txtprestador" placeholder="Pesquisa por Prestador" />
                </div>
            </div>
            <div class="row">
                <div class="medium-1 columns">
                    <label for="txtcep" class="left inline">CEP</label>
                </div>
                <div class="medium-9 columns">
                    <input type="search" name="txtcep" id="txtcep" placeholder="Pesquisa por CEP" />
                </div>
                <div class="medium-1 columns">
                    <input type="button" name="btnPesquisar" onclick="getDados();" class="button tiny round" value="Procurar" />
                </div>
                <div class="medium-1 columns">
                    <a href="home.php" class="button tiny round">Limpar</a>
                </div>
            </div>
	</div>
        </form>
	<div id="Resultado"><b>Lista de Eleitor</b></div>

	<script src="js/vendor/jquery.js"></script> 
	<script src="js/foundation.min.js"></script> 
	<script> $(document).foundation(); </script> 
</body> 
</html>