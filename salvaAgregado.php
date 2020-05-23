<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    
    $cod     = $_GET['codcli'];
    $familia = $_GET['f'];
    
    $sqlqtde = "SELECT Count(Cod_Familia) as qtde FROM Agregado where Cod_Familia = $familia and Cod_Cliente = $cod";
    $queryqtde = $DB->Query($sqlqtde);
    $linha = $DB->FetchArray($queryqtde);
    if($linha['qtde']==0) {
        $sql = "INSERT into Agregado (Cod_Familia, Cod_Cliente, Principal) Values ($familia, $cod, 0)";
        $query = $DB->Query($sql);
    }
    $DB->Close();
    $pagina = "detalhe.php?codcli=$cod";
    header('Location: ' . $pagina);
?>