<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    $c = $_GET['c'];
    $f = $_GET['f'];
    
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    
    $sql = "DELETE FROM Agregado where Cod_Familia = $f and Cod_Cliente = $c";
    $query = $DB->Query($sql);
    
    $pagina = "familia.php?c=$c&f=$f";
    header('Location: ' . $pagina);
?>