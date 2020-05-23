<?php
    include "../mysql/mysqli.class.php";

    $id = $_GET["txtcep"];
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");

    $sqlterm = "Select Distinct Num from Endereco where CEP = $id order by Num";
    $sqlquery = $DB->Query($sqlterm);

    $caixa2 = "<select name='nume' id='nume' multiple='multiple' autofocus onfocus='numerocep()' onchange='pegaValorn()'>";
    while($array = $DB->FetchArray($sqlquery))
        {
            $caixa2.= "<option value='". $array['Num']. "'>" . $array["Num"]. "</option>";
        }
        $caixa2.= "</select>";
        echo $caixa2;
    $DB->Close();
?>