<?php
require('../makeSecure.php');
require('../settings.php');

	if(isset($_GET['msg']))
		{
			switch($_GET['msg'])
			{
				case 1: echo "Preencher campos obrigatórios.";
				break;
				
				case 2: echo "Usuário adicionado com sucesso!";
				break;
				
			}
		}

if(isset($_POST['Submit']))
{

	if((!$_POST['Username']) || (!$_POST['Password']))
	{
		// display error message
		header('location: addUser.php?msg=1');
		exit;
	}
	include_once "../../pdo/mypdo.class.php";
	//$connection = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Unable to connect to MySQL");
	//mysql_select_db($dbname, $connection) or die("Unable to select DB!");
	$DB = new pdoDatabase("../settings.php");
	//$DB = new pdoDatabase();
    //$connec = $DB->Connect("mcape067_maladb");

	$pw = md5($_POST['Password']);
	$username = $_POST['Username'];
	$nomecomp = $_POST['nome'];
	$email = $_POST['Email'];
	$adm = $_POST['adm'];
	//$criado = new Datetime();
	
	$sql = "INSERT INTO users (username, password, password_salt, name, email, created, Admin) VALUES ('$username', '$pw', 'mala', '$nomecomp', '$email', now(), '$adm')";
	//$sql = "INSERT INTO users (username, password, name, email, created) VALUES ('$username', '$pw', '$nomecomp', '$email', $criado)";
	
	$DB->query($sql);
	$DB->execute();
    //$result = $DB->FetchNum($queryAdd);

	//mysql_query($sql) or die('Error Inserting Values');
	
	header('location: addUser.php?msg=2');
	exit();
	
}

/**
 * Cleans a string for input into a MySQL Database.
 * Gets rid of unwanted characters/SQL injection etc.
 * 
 * @return string
 */
function clean($con, $str)
{
	// Only remove slashes if it's already been slashed by PHP
	//if(get_magic_quotes_gpc())
	//{
	//	$str = stripslashes($str);
	//}
	// Let MySQL remove nasty characters.
	$strScape = mysqli_real_escape_string($con, $str);
		
	return $strScape;
}

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
        <link rel="stylesheet" href="../css/normalize.css"> 
        <link rel="stylesheet" href="../css/foundation.css">
        <link rel="stylesheet" href="../../foundation-icons/foundation-icons.css">
        <link type="text/css" media="screen" rel="stylesheet" href="../../tables/responsive-tables.css" />

        <script type="text/javascript" src="../../tables/responsive-tables.js"></script>
        <script src="../js/vendor/modernizr.js"></script>
    </head> 
    <body>
    <div class='row'>
            <div class='small-2 small-centered columns'>
                <a href='../home.php'><img align='center' height='120' width='120' alt='Logo' src='../img/mala.png'></a>
            </div>
        </div>
        <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
                <li class="name"><!-- Leave this empty --></li>
                <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
            </ul>
            <section class="top-bar-section">
                <ul class="left">
                    <li><a href="../novoEleitor.php">Novo Eleitor</a></li>
                    <li><a href="../home.php">Nova Consulta</a></li>
                    <li><a href="../impressao.php">Impressão</a></li>
                    <li><a href="../backup.php">Backup</a></li>
                </ul>
                <ul class="right">
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </section>
        </nav>

        <dl class="sub-nav">
            <dt>Admin:</dt>
            <dd class="active"><a href="getUsuario.php">Usuário</a></dd>
            <dd><a href="getTipo.php">Tipo</a></dd>
            <dd><a href="getRegiao.php">Região</a></dd>
			<dd><a href="getPrestador.php">Prestador</a></dd>
        </dl>

        <div class='row'>
            <div class='small-12 small-centered columns'>
                <h2 align='center'>Novo Usuário</h2>
            </div>
        </div>
 
	<div class="row">
		<div class="small-12 column">
			<form data-abide action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="addUserForm">
				<div class="name-field">
					<label> Nome Completo <small> *</small>
						<input required pattern="[a-zA-Z]+" type="text" placeholder="Nome Completo" name="nome"/>
					</label>
					<small class="error">Nome Obrigatorio e somente Letras</small>
				</div>
				<div class="name-field">
					<label> Usuario <small> *</small>
						<input required type="text" placeholder="Usuario" name="Username"/>
					</label>
					<small class="error">Nome de Usuario Obrigatorio</small>
				</div>
				<div class="name-field">
					<label> Senha <small> *</small>
						<input required type="password" placeholder="Senha" name="Password" >
					</label>
					<small class="error">Senha Obrigatoria</small>
				</div>
				<div class="email-field">
					<label> E-mail <small> *</small>
						<input required type="email" placeholder="exemplo@abc.com.br" name="Email" />
					</label>
					<small class="error">Digite um E-mail valido</small>
				</div>
				<div class="name-field">
					<label> Administrador <small> *</small>
						<select id="adm" name="adm">
							<option value="0">Não</option>
							<option value="1">Sim</option>
						</select>
					</label>
					<small class="error">Senha Obrigatoria</small>
				</div>
				<small>* = Campos Obrigatorios</small><br/>
				<input name="Submit" type="submit" class="button tiny round" value="Adicionar" />
				<a class="button tiny round secondary" href="getUsuario.php">Cancelar</a>
			</form>
		</div>
	</div>
	
	<div class="row">
    <div class="small-4 columns">.</div>
    <div class="small-4 columns">
      <?php
        if(isset($_GET['msg']))
        {
          switch($_GET['msg'])
          {        
            case 1: echo "<span class='secondary round label'>Por favor preencha campos.</span>";
              break;
        
              case 2: echo "<span class='success round label'>Usuario Adicionado com Sucesso</span>";
              break;
          }
        }
      ?>
    </div>    
    <div class="small-4 columns">.</div>
  
  </div>

	<script src="../js/vendor/jquery.js"></script> 
	<script src="../js/foundation.min.js"></script> 
	<script> $(document).foundation(); </script> 
</body> 
</html>