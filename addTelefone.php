<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo();
    
    $codigo = $_POST["codcli"];
    $nome   = $_POST["nomecli"];
    $ddd    = $_POST["dddcli"];
    $numero = $_POST["numerocli"];
    $num = $p->formatar($numero, "celular", "banco");
    
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    
    $sql = "Insert into Telefone (Cod_Cliente, Nome, ddd, Numero) Values ($codigo, '$nome', $ddd, $num)";
    $query = $DB->Query($sql);
    
    $DB->Close();
    
    $pag = "telefone.php?c=" . $codigo;
    header('Location:' . $pag);
?>