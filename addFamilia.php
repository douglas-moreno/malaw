<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    
    $codigo = $_POST["codcli"];
    $nomefamilia = $_POST["nomeFamilia"];
    
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    
    $sql = "Insert into Familia (Nome_Familia) Values ('$nomefamilia')";
    $query = $DB->Query($sql);
    
    $sql2 = "Select Cod_Familia FROM Familia order by Cod_Familia DESC LIMIT 1";
    $query2 = $DB->Query($sql2);
    $linha = $DB->FetchArray($query2);
    $newcod = $linha['Cod_Familia'];
    
    $sql3 = "Insert into Agregado (Cod_Familia, Cod_Cliente, Principal) Values ($newcod, $codigo, 1)";
    $query3 = $DB->Query($sql3);
    
    $DB->Close();
    
    $pag = "familia.php?c=" . $codigo. "&f=" . $newcod;
    header('Location:' . $pag);
?>