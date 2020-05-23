<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    $c = $_GET['c'];
    $t = $_GET['t'];
    
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    
    $sql = "DELETE FROM Telefone where Cod_Cliente = $c and Numero = $t";
    $query = $DB->Query($sql);
    
    $pagina = "telefone.php?c=$c";
    header('Location: ' . $pagina);
?>