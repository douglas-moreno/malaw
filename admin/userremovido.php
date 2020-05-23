<?php
    include "../../mysql/mysqli.class.php";
    $DB1 = new mysql;
    $connec = $DB1->Connect("mcape067_maladb");

    $codigo = $_GET['id'];

    $ssql4 = "DELETE FROM users WHERE id = $codigo";

    $remove4 = $DB1->Query($ssql4);

    $DB1->Close();

    $texto = "<h2 align='center'>Usuário Removido com Sucesso</h2>
             <a href='getUsuario.php' class='button round'>OK</a>";
    
    //echo $texto;
?>

<!DOCTYPE html> 
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]--> 
<html class="no-js" lang="en" > 
    <head> 
        <meta charset="utf-8"> 
        <!-- If you delete this meta tag World War Z will become a reality --> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Web Mala</title> 
        <!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like --> 
        <link rel="stylesheet" href="../../css/normalize.css"> 
        <link rel="stylesheet" href="../../css/foundation.css">
        <link rel="stylesheet" href="../../foundation-icons/foundation-icons.css">

        <script src="../js/vendor/modernizr.js"></script>
    </head> 
    <body>
        <?php echo $texto; ?>

        <script src="../js/vendor/jquery.js"></script>
        <script src="../js/foundation.min.js"></script>
        <script> $(document).foundation();</script>
    </body>
</html>