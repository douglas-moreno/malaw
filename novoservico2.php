<?php
    require('makeSecure.php');
    //include "cabecalho.php";
    include "../mysql/mysqli.class.php";
    include "formatatudo.class.php";

    $p = new FormataTudo();
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");

    
    $codigocli = $_GET['codi'];
    
    $sqlCliente = "Select * FROM Cliente WHERE Cod_Cliente = $codigocli";
    $queryCli = $DB->Query($sqlCliente);
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
        
        <script language="JavaScript">
            function pegaValorti(valor) {
                document.getElementById("tipo_desc").value = valor;
            }
        </script>

	<script src="js/vendor/modernizr.js"></script> 
</head> 
<body> 
    <?php require_once 'cabeca.php'; ?>
	<div class="row">
		<div class="medium-11 columns">
			<?php
				$linha = $DB->FetchArray($queryCli);
				$mostracli = "<label>Nome
				<input type='text' disabled name='nome' value='";
				$mostracli.= $linha["Nome"];
				$mostracli.= "'></label>";
				echo $mostracli;
			?>		
		</div>
		<div class="medium-1 columns">
			<?php									
				$mostracli = "<label>Sexo
				<input type='text' disabled name='sexo' value='";
				$mostracli.= $linha["Sexo"];
				$mostracli.= "'></label>";
				echo $mostracli;
			?>
		</div>
	</div>						
	<div class="row">
		<div class="medium-2 column">
			<?php
				$mostracli = "<label>Aniversário
				<input type='text' disabled name='aniversario' value='";
				$mostracli.= $p->formatar($linha["Aniversario"], 'data'). "'></label>";
				echo $mostracli;
			?>
		</div>
		<div class="medium-2 column">
			<?php
				$mostracli = "<label>Título de Eleitor
				<input type='text' disabled name='titulo' value='";
				$mostracli.= $linha["Titulo"]. "'></label>";
				echo $mostracli;
			?>
		</div>
                <div class="medium-2 column">
			<?php
				$mostracli = "<label>Zona
				<input type='text' disabled name='zona' value='";
				$mostracli.= $linha["Zona"]. "'></label>";
				echo $mostracli;
			?>
		</div>
                <div class="medium-2 column">
			<?php
				$mostracli = "<label>Secão
				<input type='text' disabled name='secao' value='";
				$mostracli.= $linha["Secao"]. "'></label>";
				echo $mostracli;
			?>
		</div>
		<div class="medium-2 column">
			<?php
				$mostracli = "<label>Tipo
				<input type='text' disabled name='tipo' value='";
				$mostracli.= $linha["Tipo"]. "'></label>";
				echo $mostracli;
			?>
		</div>
		<div class="medium-2 column">
			<?php
				$mostracli = "<label>Filho(a)
				<input type='text' disabled name='filho' value='";
				$mostracli.= $linha["Filho"]. "'></label>";
				echo $mostracli;
			?>
		</div>							
	</div>
	<?php	
	
	
	if(isset($_GET['codi']))
	{
		
		$sqlprestador = "Select * FROM Prestador where Ativo = 1 Order By Prestador";
		$sqlTipo = "Select * FROM Tipo where Ativo = 1 order by Tipo";
		
    	$queryPre = $DB->Query($sqlprestador);
    	$querytipo = $DB->Query($sqlTipo); ?>

    	<div class="row">
    		<div class="medium-12">
    		<div class="panel">
    			<?php
		    	$tela = "<h2 align='center'>Novo Serviço</h2><form id='formserv' action='addnovoservico.php' method='post'>
		    		<label>Tipo
					<select id='ntipo' name='ntipo' onchange='pegaValorti(this.options[this.selectedIndex].innerHTML)'>";
				echo $tela;
					while ($linha = $DB->FetchArray($querytipo))
					{
						echo "<option value='".$linha["Cod_Tipo"]."'>".$linha["Tipo"]."</option>";
					}
				$tela = "</select></label>
                                        <input type='hidden' id='tipo_desc' name='tipo_desc' />
					<label>Descrição
					<textarea rows='4' name='ndesc' placeholder='Descreva o serviço prestado'></textarea></label>
					<label>Prestador
					<select name='nprestador'>";
				echo $tela;
					while ($linha = $DB->FetchArray($queryPre))
					{
						echo "<option value='".$linha["Codigo_Prestador"]."'>".$linha["Prestador"]."</option>";
					}
				$tela ="</select></label>
					<input type='hidden' name='codic' value=" . $codigocli . ">
					<input type='submit' value='Adicionar' class='button round tiny'>
					<a href='javascript:window.history.go(-1)' class='button tiny round'>Cancelar</a>
					</form>";		
				echo $tela;
				$DB->CLose();
	}
	else
	{
		echo "nao tem codigo = ". $codigocli;
	}
?>		
			</div>
    		</div>
    	</div>

    	

	<script src="js/vendor/jquery.js"></script> 
	<script src="js/foundation.min.js"></script> 
	<script> $(document).foundation(); </script> 
</body> 
</html>