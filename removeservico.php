<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    include "formatatudo.class.php";

    $p = new FormataTudo();
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    
    $codigocli = $_GET['codcli'];
    $codservico = $_GET["codservico"];
    
    $sqlCliente = "Select * FROM Cliente WHERE Cod_Cliente = $codigocli";    
    $queryCli = $DB->Query($sqlCliente);
    
    $sqlservico = "Select sp.*, pr.Prestador FROM Servico_Prestado sp"
            . " inner join Prestador pr on sp.Cod_Prestador = pr.Codigo_Prestador"
            . " where sp.Cod_Servico = $codservico";
    $queryserv = $DB->Query($sqlservico);
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
        
    	<div class="row">
            <div class="medium-12 columns">
    		<div class="panel">
		    <h2 align='center'>Remover Serviço</h2>
                    <form id="formserv" action="#" method='post'>
                        <div class="row">
                            <div class="medium-1 columns">
                                <label>Tipo</label>
                            </div>
                            <div class="medium-11 columns">
                                <?php 
                                    $linha = $DB->FetchArray($queryserv);
                                    echo "<input disabled type='text' name='ntipo' disabled value='".$linha["Tipo"]."'/>";
                                ?>
                            </div>
                            <div class="medium-1 columns">
                                <label>Descrição</label>
                            </div>
                            <div class="medium-11 columns">
                                <?php echo "<textarea disabled rows='6' name='ndesc'>".$linha["Descricao"]."</textarea>";?>
                            </div>
                            <div class="medium-1 columns">
                                <label>Prestador</label>
                            </div>
                            <div class="medium-11 columns">
                                <?php echo "<input disabled type=\"text\" disabled name='nprestador' value='".$linha["Prestador"]."'/>";?>
                            </div>
                            <div class="row">
                                <div class="medium-12 columns">
                                    <?php 
                                        echo "<input type='hidden' name='codic' value='$codigocli'>";
                                        echo "<input type='hidden' name='codservico' value='$codservico'>"; 
                                    ?>
                                    <input type='submit' value='Salvar' class='button round tiny'>
                                    <a href='javascript:window.history.go(-1)' class='button tiny round'>Cancelar</a>
                                </div>
                            </div>
                        </div>        
                    </form>
                </div>
            </div>
        </div>
    
    <a href="#" data-reveal-id="removserv">.</a>
    <div id="removserv" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle">Remover Serviço</h2>
        <a href="servicoremovido.php?codicli=<?php echo $codservico; ?>" data-reveal-id="sucesso" class="button round tiny" data-reveal-ajax="true">Confirmar</a>
        <a href="javascript:window.history.go(-1)" class="button round tiny">Cancelar</a>
    </div>
    <div id="sucesso" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        
    </div>

	<script src="js/vendor/jquery.js"></script> 
	<script src="js/foundation.min.js"></script> 
	<script> $(document).foundation(); </script> 
        <script> $('#removserv').foundation('reveal', 'open');</script>
</body> 
</html>