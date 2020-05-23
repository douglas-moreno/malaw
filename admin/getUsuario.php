<?php
    require('../makeSecure.php');
    if ($_SESSION['Admin'] != 1) {        
        redirect("../home.php");
    }
    include_once "../../mysql/mysqli.class.php";

    $sql = "Select id, name, username, email, Admin FROM users where id <> 16";
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    $queryuser = $DB->Query($sql);
    $cont = $DB->FetchNum($queryuser);
    $codigo = 0;

    $tabela = "<p>$cont registro(s) encontrado(s)</p>
        <p align='center'><a href='addUser.php' class='button round tiny'>Adicionar</a></p>
        <table align='center' class='responsive' role='grid'>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Usuário</th>
                <th>E-mail</th>
                <th>Admin</th>
                <th colspan='2'>Ação</th>
            </tr>
        </thead>
        <tbody>";
    while ($linha = $DB->FetchArray($queryuser)) {
        $tabela.= "<tr><td>". $linha["name"]. "</td>";
        $tabela.= "<td><strong>". $linha["username"]. "</strong></td>";
        $tabela.= "<td>". $linha["email"]. "</td>";
        if($linha["Admin"] == 1){
            $tabela.= "<td><i class='fi-check'></i></td>";
        }
        else{
            $tabela.= "<td><i class='fi-x'></i></td>";
        }
        $tabela .= "<td><a href='updateUser.php?id=" . $linha["id"] . "'><i class='fi-page-edit'></i></a></td>";
        $tabela .= "<td><a onClick=\"return confirm('Confirma Deletar o usuário?')\" href='userremovido.php?id=" . $linha["id"] . "'><i class='fi-trash'></i></a></td></tr>";
    }
    //echo $tabela;
    $DB->Close();
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

        <h2 align='center'>Lista de Usuários</h2>

        <div class='row'>
            <div class='small-12 small-centered columns'>
                <?php echo $tabela; ?>
            </div>
        </div>

        <script src="../js/vendor/jquery.js"></script>
        <script src="../js/foundation.min.js"></script>
        <script> $(document).foundation();</script>

    </body>
</html>