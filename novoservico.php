<?php
	include "../mysql/mysqli.class.php";
	$codigocli = "";
	if(isset($_GET['codi']))
	{
		$codigocli = $_GET['codi'];
		$sqlprestador = "Select * FROM Prestador Order By Prestador";
		$sqlTipo = "Select * FROM Tipo order by Tipo";
		$DB = new mysql;
    	$connec = $DB->Connect("mcape067_maladb");    	
    	$queryPre = $DB->Query($sqlprestador);
    	$querytipo = $DB->Query($sqlTipo);
    	$tela = "<h2 align='center'>Novo Serviço</h2><form id='formserv' action='addnovoservico.php' method='post'>
    		<label>Tipo
			<select name='ntipo'>";
		echo $tela;
			while ($linha = $DB->FetchArray($querytipo))
			{
				echo "<option value='".$linha["Tipo"]."'>".$linha["Tipo"]."</option>";
			}
		$tela = "</select></label>
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
			<input type='button' value='Adicionar' class='button round tiny' onClick='addServico()'>
			</form>			
			<a class='close-reveal-modal'>&#215;</a>";		
		echo $tela;
		$DB->CLose();
	}
	else
	{
		echo "nao tem codigo = ". $codigocli;
	}
?>