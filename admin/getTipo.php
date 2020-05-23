<?php
    require('../makeSecure.php');
    if ($_SESSION['Admin'] != 1) {        
        redirect("../home.php");
    }
    include_once "../../mysql/mysqli.class.php";

    $sql = "Select Cod_Tipo, Tipo, Ativo FROM Tipo order by Tipo";
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    $querytipo = $DB->Query($sql);
    $cont = $DB->FetchNum($querytipo);

    $tabela = "<p>$cont registro(s) encontrado(s)</p>
    <p align='center'><a href='addTipo.php' class='button round tiny'>Adicionar</a></p>
    <table id='mytab1' class='display' align='center'>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Ativo</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>";
    while ($linha = $DB->FetchArray($querytipo)) {
        $tabela.= "<tr><td>". $linha["Tipo"]. "</td>";
        if($linha["Ativo"] == 1){
            $tabela.= "<td><i class='fi-check'></i></td>";
            $tabela .= "<td><a onClick=\"return confirm('Confirma Desativar Tipo?')\" href='tiporemovido.php?id=" . $linha["Cod_Tipo"] . "&ativo=" . $linha["Ativo"] . "'><i class='fi-loop'></i></a></td></tr>";
        }
        else{
            $tabela.= "<td><i class='fi-x'></i></td>";
            $tabela .= "<td><a onClick=\"return confirm('Confirma Ativar Tipo?')\" href='tiporemovido.php?id=" . $linha["Cod_Tipo"] . "&ativo=" . $linha["Ativo"] . "'><i class='fi-loop'></i></a></td></tr>";
        }
    }
    $tabela.= "</tbody></table>";
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/jquery-3.3.1.js">
  
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
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
            <dd class="active"><a href="getTipo.php">Tipo</a></dd>
            <dd><a href="getRegiao.php">Região</a></dd>
            <dd><a href="getPrestador.php">Prestador</a></dd>
        </dl>

        <div class='row'>
            <div class='small-2 small-centered columns'>
                <h2 align='center'>Tipos</h2>
            </div>
        </div>
        
        <div class='row'>
            <div class='small-12 small-centered columns'>
                <?php echo $tabela; ?>
            </div>
        </div>
        
        <script src="../js/foundation.min.js"></script>
        <script> $(document).foundation();</script>
        <script src="https://cdn.datatables.net/fixedheader/3.1.3/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script> $(document).ready(function() {
            $('#mytab1').DataTable();
            });
        </script>

    </body>
</html>