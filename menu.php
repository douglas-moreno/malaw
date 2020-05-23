<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name"><!-- Leave this empty --></li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
    </ul>
    <section class="top-bar-section">
        <ul class="left">
            <li><a href="novoEleitor.php">Novo Eleitor</a></li>
            <li><a href="home.php">Nova Consulta</a></li>
            <?php
                if($_SESSION['Admin'] == 1) {
                    echo "<li><a href=\"impressao.php\">Impressão</a></li>";
                }
            ?>
            <li><a href="backup.php">Backup</a></li>
            <?php
                if(isset($_GET['codcli'])) {
                    echo "<li><a href='#' data-reveal-id='removeModal'>Remover</a></li>";
                }
            ?>
        </ul>
        <ul class="right">
            <?php
                if($_SESSION['Admin'] == 1) {
                    echo "<li><a href='admin/index.php'>Admin</a></li>";
                }
            ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </section>
</nav>