<?php
    require('../makeSecure.php');
    if ($_SESSION['Admin'] != 1) {        
        redirect("../home.php");
    }
    include_once "../../mysql/mysqli.class.php";

    if(isset($_POST['Submit'])){
        $id = $_POST["id"];
    }
    else{
        $id = $_GET["id"];
    }

    $sql = "Select id, name, username, email, Admin, password FROM users where id = $id";
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    $queryuser = $DB->Query($sql);
    $fetchuser = $DB->FetchArray($queryuser);
    $nome = $fetchuser['name'];
    $usuario = $fetchuser['username'];
    $email2 = $fetchuser['email'];
    $admin = $fetchuser['Admin'];
    $password = $fetchuser['password'];

    if(isset($_POST['Submit'])){
        $adm = $_POST['adm'];
        if($_POST['Password'] <> ""){
            $pw = md5($_POST['Password']);
            $pwn = md5($_POST['NewPassword']);
            $pwrn = md5($_POST['ReNewPassword']);

            if($pw == $password){
                if($pwn == $pwrn){
                    $sqlat = "Update users SET password='$pwn', Admin='$adm' where id = $id";
                    $queryAtu = $DB->Query($sqlat);
                    redirect("getUsuario.php");
                }
                else{
                    echo "Nova Senha Inválida";
                }
            }
            else {
                echo "Senha Atual Incorreta";
            }
        }
        else{
            $sqlat = "Update users SET Admin = '$adm' where id = $id";
            $queryAtu = $DB->Query($sqlat);
            echo "Usuário Atualizado com Sucesso";
            redirect("getUsuario.php");
        }
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
                <h2 align='center'>Editar Usuário</h2>
            </div>
        </div>
 
	<div class="row">
		<div class="small-12 column">
			<form data-abide action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="editUserForm">
            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
				<div class="name-field">
					<label> Nome Completo <small> *</small>
						<input pattern="[a-zA-Z]+" type="text" disabled value="<?php echo ($nome); ?>" name="nome"/>
					</label>
					<small class="error">Nome Obrigatorio e somente Letras</small>
				</div>
				<div class="name-field">
					<label> Usuario <small> *</small>
						<input type="text" disabled value="<?php echo ($usuario); ?>" name="Username"/>
					</label>
					<small class="error">Nome de Usuario Obrigatorio</small>
				</div>
                <div class="email-field">
					<label> E-mail <small> *</small>
						<input type="email" disabled value="<?php echo ($email2); ?>" name="Email" />
					</label>
					<small class="error">Digite um E-mail valido</small>
				</div>
				<div class="name-field">
					<label> Senha <small> *</small>
						<input type="password" placeholder="Senha" name="Password" >
					</label>
					<small class="error">Senha Obrigatoria</small>
				</div>

                <div class="name-field">
					<label> Nova Senha <small> *</small>
						<input type="password" placeholder="Nova Senha" name="NewPassword" >
					</label>
					<small class="error">Senha Obrigatoria</small>
				</div>

                <div class="name-field">
					<label> Repete Nova Senha <small> *</small>
						<input type="password" placeholder="Nova Senha" name="ReNewPassword">
					</label>
					<small class="error">Senha Obrigatoria</small>
				</div>
                
                <div class="name-field">
					<label for="adm"> Administrador <small> *</small>
						<select id="adm" name="adm">
                            <?php 
                            if($admin == 1){
                                echo "<option selected value='1'>Sim</option><option value='0'>Não</option>";
                            }
                            else{
                                echo "<option value='1'>Sim</option><option selected value='0'>Não</option>";
                            }
                            ?>
                        </select>
					</label>
					<small class="error">Administrador</small>
				</div>

                
				
                <small>* = Campos Obrigatorios</small><br/>
				<input name="Submit" type="submit" class="button tiny round" value="Atualizar" />
				<a class="button tiny round secondary" href="getUsuario.php">Cancelar</a>
			</form>
		</div>
	</div>

    <script src="../js/vendor/jquery.js"></script> 
	<script src="../js/foundation.min.js"></script> 
	<script> $(document).foundation(); </script> 
</body> 
</html>