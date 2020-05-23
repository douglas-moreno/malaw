<?php
    include "../mysql/mysqli.class.php";
    $DB1 = new mysql;
    $connec = $DB1->Connect("mcape067_maladb");

    $codigo = $_GET['codicli'];

    $ssql4 = "DELETE FROM Servico_Prestado WHERE Cod_Servico = $codigo";

    $remove4 = $DB1->Query($ssql4);

    $DB1->Close();

    $texto = "<h2>Serviço Removido com Sucesso</h2>
             <a href='javascript:window.history.go(-1)' class='button round'>OK</a>";
    
    echo $texto;
?>