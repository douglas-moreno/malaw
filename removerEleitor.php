<?php
	include "../mysql/mysqli.class.php";
	$DB = new mysql;
	$connec = $DB->Connect("mcape067_maladb");

	$codigo = $_GET['codcli'];

	$ssql1 = "DELETE FROM Cliente WHERE Cod_Cliente = $codigo";
	$ssql2 = "DELETE FROM Endereco WHERE Cod_Cliente = $codigo";
	$ssql3 = "DELETE FROM Outras WHERE Cod_Cliente = $codigo";
	$ssql4 = "DELETE FROM Servico_Prestado WHERE Cod_Cliente = $codigo";

	$remove1 = $DB->Query($ssql1);
	$remove2 = $DB->Query($ssql2);
	$remove3 = $DB->Query($ssql3);
	$remove4 = $DB->Query($ssql4);

	$DB->Close();

	$texto = "<h2>Eleitor removido com sucesso</h2>
                <a href='home.php' class='button round'>OK</a>";
	echo $texto;

	//header('location: home.php');

?>