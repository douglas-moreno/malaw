<?php
	include "../mysql/mysqli.class.php";
	include "formatatudo.class.php";

	$f = new FormataTudo();
	$DB = new mysql();
	$connec = $DB->Connect("mcape067_maladb");

	$codigo		= $_POST['codcli'];
	$nome 		= $_POST['nome'];
	$sexo 		= $_POST['sexo'];
	$aniversario    = $f->formatar($_POST['aniversario'],'data','banco');
	$titulo 	= $_POST['titulo'];
        $zona           = $_POST['zona'];
        $secao          = $_POST['secao'];
	$tipo 		= $_POST['tipo'];
	$filho 		= $_POST['filho'];
	$endereco 	= $_POST['endereco'];
	$numero 	= $_POST['numero'];
	$bairro 	= $_POST['bairro'];
	$complemento    = $_POST['complemento'];
	$cidade 	= $_POST['cidade'];
	$estado 	= $_POST['estado'];
	$regiao 	= $_POST['regiao'];
	$cep 		= $f->formatar($_POST['cep'],'cep','banco');
	$ddd            = $_POST['ddd'];
        $telefone 	= $f->formatar($_POST['telefone'],'telefone','banco');
	$email 		= $_POST['email'];
	$ddd2           = $_POST['ddd2'];
        $tel2 		= $f->formatar($_POST['tel2'],'telefone','banco');
	$ddd3           = $_POST['ddd3'];
        $tel3 		= $f->formatar($_POST['tel3'],'telefone','banco');
	$ddd4           = $_POST['ddd4'];
        $celular 	= $f->formatar($_POST['celular'],'telefone','banco');
	$obs 		= $_POST['obs'];
        $pp             = $_POST['pp'];
        if(isset($_POST['negra'])){
            $negra = 1;
        }
        else {
            $negra = 0;
        }
        $ssql = "UPDATE Cliente SET Nome='$nome', Negra='$negra', Titulo='$titulo', Zona='$zona', Secao='$secao', Sexo='$sexo', Tipo='$tipo', Aniversario='$aniversario', Filho='$filho', Cod_Prestador='$pp' WHERE Cod_Cliente=$codigo";

	$salvaCli = $DB->Query($ssql);

	$ssqlteste2 = "Select * FROM Endereco where Cod_Cliente=$codigo";
	$query2 = $DB->Query($ssqlteste2);
        $qtd2 = $DB->FetchNum($query2);
        $ssql2 = "";
        if($qtd2>0){
            $ssql2 = "UPDATE Endereco SET Endereco='$endereco',Num='$numero',Bairro='$bairro',Complemento='$complemento',Cidade='$cidade',Estado='$estado',email='$email',Regiao='$regiao',CEP='$cep',ddd='$ddd',Tel1='$telefone' WHERE Cod_Cliente=$codigo";
        }
        else {
            $ssql2 = "INSERT INTO Endereco (Cod_Cliente,Endereco,Num,Bairro,Complemento,Cidade,Estado,email,Regiao,CEP,ddd,Tel1) VALUES ($codigo,'$endereco','$numero','$bairro','$complemento','$cidade','$estado','$email','$regiao','$cep','$ddd','$telefone')";
        }
	$salvaEndereco = $DB->Query($ssql2);

	$ssqlteste3 = "Select * FROM Outras where Cod_Cliente=$codigo";
	$query3 = $DB->Query($ssqlteste3);
        $qtd3 = $DB->FetchNum($query3);
        $ssql3 = "";
        if ($qtd3>0){
            $ssql3 = "UPDATE Outras SET ddd2='$ddd2',Tel1='$tel2',ddd3='$ddd3',Tel2='$tel3',ddd4='$ddd4',Celular='$celular',Obs='$obs' WHERE Cod_Cliente=$codigo";
        }
        else {
            $ssql3 = "INSERT INTO Outras (Cod_Cliente,ddd2,Tel1,ddd3,Tel2,ddd4,Celular,Obs) VALUES ($codigo,'$ddd2','$tel2','$ddd3','$tel3','$ddd4','$celular','$obs')";
        }
        $salvaOutras = $DB->Query($ssql3);
        
	$DB->Close();

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'detalhe.php?codcli='.$codigo;
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