<?php
    include "../mysql/mysqli.class.php";
    include "formatatudo.class.php";
    
    $p = new FormataTudo();
    $codigoCli = $_POST['codic'];
    $codServico = $_POST['codservico'];
    $tipo = $_POST['ntipo'];
    $descri = $_POST['ndesc'];
    $presta = $_POST['nprestador'];
    $data = $p->formatar(date("d/m/y"), 'data', 'banco');
        
    $ssql = "UPDATE Servico_Prestado set Descricao = '$descri' where Cod_Servico = $codServico";
    $DB = new mysql;
    $connec = $DB->Connect("mcape067_maladb");
    $query = $DB->Query($ssql);
    $DB->Close();
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'detalhe.php?codcli='.$codigoCli;
    $url = "http://".$host.$uri."/".$extra;
	
    redirect($url);

    function redirect($url){
       if (headers_sent()){
        die('<script type="text/javascript">window.location=\''.$url.'\';</script>');
       }
       else{
        header('Location: ' . $url);
        die();
       }
    }
//header("Location: http://$host$uri/$extra");   
?>	