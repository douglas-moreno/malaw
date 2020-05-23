<?php
include "../mysql/mysqli.class.php";

$pessoa = $_POST["user"];
$senha = $_POST["password"];

$DB1 = new mysql;
$connec = $DB1->Connect("mcape067_maladb");
$sql = "Select * from usuario where usuario = '" . $pessoa . "'";
$query = $DB1->Query($sql);

while ($linha = $DB1->FetchArray($query))
{
    if($linha['senha'] == $senha)
    {
        $DB1->Close();
        header("location:index2.php");
        //$teach_name = $linha['firstName'];
    }
    else
        header("location:index.php?erro=sim");
}



$DB1->Close();

?>
