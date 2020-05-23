<?php
    include "../mysql/mysqli.class.php";
    include 'formatatudo.class.php';
    
    $p = new FormataTudo();
    $codigoCli = $_POST['codic'];
    $tipo = $_POST['ntipo'];
    $tipodesc = $_POST['tipo_desc'];
    $descri = $_POST['ndesc'];
    $presta = $_POST['nprestador'];
    $data = $p->formatar(date("d/m/y"), 'data', 'banco');
    
    $ssql = "insert into Servico_Prestado (Cod_Cliente, Cod_Prestador, Cod_Tipo, Tipo, Data, Descricao) values('$codigoCli','$presta','$tipo','$tipodesc','$data','$descri')";
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