<?php
	include "../mysql/mysqli.class.php";
	include "formatatudo.class.php";        
        date_default_timezone_set('America/Sao_Paulo');

	$f = new FormataTudo;
	$DB = new mysql;
	$connec = $DB->Connect("mcape067_maladb");

	$nome 		= $_POST['nome'];
	$sexo 		= $_POST['sexo'];
	$aniversario 	= $f->formatar($_POST['aniversario'],'data','banco');
	$titulo		= $_POST['titulo'];
        $zona           = $_POST['zona'];
        $secao          = $_POST['secao'];
	$tipo 		= $_POST['tipo'];
	$filho 		= $_POST['filho'];
	$endereco	= $_POST['endereco'];
	$numero 	= $_POST['numero'];
	$bairro 	= $_POST['bairro'];
	$complemento 	= $_POST['complemento'];
	$cidade 	= $_POST['cidade'];
	$estado 	= $_POST['estado'];
	$regiao 	= $_POST['regiao'];
	$cep 		= $f->formatar($_POST['cep'],'cep','banco');
	$ddd            = $_POST['ddd'];
        $telefone	= $f->formatar($_POST['telefone'],'telefone','banco');
	$email 		= $_POST['email'];
	$ddd2           = $_POST['ddd2'];
        $tel2 		= $f->formatar($_POST['tel2'],'telefone','banco');
	$ddd3           = $_POST['ddd3'];
        $tel3 		= $f->formatar($_POST['tel3'],'telefone','banco');
	$ddd4           = $_POST['ddd4'];
        $celular	= $f->formatar($_POST['celular'],'celular','banco');
	$obs 		= $_POST['obs'];
        $data           = $f->formatar(date("d/m/y"), 'data', 'banco');
        

	$ssql = "INSERT INTO Cliente (Nome, Titulo, Zona, Secao, Sexo, Tipo, Aniversario, Filho, Data, Negra) VALUES ('$nome','$titulo','$zona','$secao','$sexo','$tipo','$aniversario','$filho','$data', 0)";

	$registro = "SELECT Cod_Cliente from Cliente order by Cod_Cliente desc limit 1";

	$salvaCli = $DB->Query($ssql);
	$pegaUltimo = $DB->Query($registro);

	$linha = $DB->FetchArray($pegaUltimo);
	$id = $linha["Cod_Cliente"];

	$ssql2 = "INSERT INTO Endereco (Cod_Cliente,Endereco,Num,Bairro,Complemento,Cidade,Estado,email,Regiao,CEP,ddd,Tel1) VALUES ($id,'$endereco','$numero','$bairro','$complemento','$cidade','$estado','$email','$regiao','$cep','$ddd','$telefone')";

	$salvaEndereco = $DB->Query($ssql2);

	$ssql3 = "INSERT INTO Outras (Cod_Cliente,ddd2,Tel1,ddd3,Tel2,ddd4,Celular,Obs) VALUES ($id,'$ddd2','$tel2','$ddd3','$tel3','$ddd4','$celular','$obs')";

	$salvaOutras = $DB->Query($ssql3);

	$DB->Close();

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'detalhe.php?codcli='.$id;
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

	//header('location: detalhe.php?codcli=$id)';
?>