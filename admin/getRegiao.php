<?php
    include_once "../../mysql/mysqli.class.php";

    //echo "<h2 align='center'>Lista de Regiões</h2>";

    $sql = "Select * FROM Regiao";
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    $querytipo = $DB->Query($sql);
    $cont = $DB->FetchNum($querytipo);

    $tabela = "<p>$cont registro(s) encontrado(s)</p>
    <p align='center'><a href='addRegiao.php' class='button round tiny'>Adicionar</a></p>
    <table align='center' class='responsive' role='grid'>
        <thead>
            <tr>
                <th>Região</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>";
    while ($linha = $DB->FetchArray($querytipo)) {
        $tabela.= "<tr><td>". $linha["Regiao"]. "</td>";
        $tabela .= "<td><a onClick=\"return confirm('Confirma Remover Região?')\" href='regiaoremovido.php?id=" . $linha["Cod_Regiao"] . "'><i class='fi-trash'></i></a></td></tr>";
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
            <dd><a href="getUsuario.php">Usuário</a></dd>
            <dd><a href="getTipo.php">Tipo</a></dd>
            <dd class="active"><a href="getRegiao.php">Região</a></dd>
            <dd><a href="getPrestador.php">Prestador</a></dd>
        </dl>

        <div class='row'>
            <div class='small-2 small-centered columns'>
                <h2 align='center'>Região</h2>
            </div>
        </div>
        
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