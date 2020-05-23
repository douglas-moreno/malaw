<?php
    include 'vendor/autoload.php';
    include 'settings.php';
    use League\Csv\Writer;
    
    $sql = $_POST["sqlsms"];
    $dsn = "mysql:host=localhost;dbname=$dbname";
    $db = new PDO($dsn, $dbuser, $dbpassword);
    $sth = $db->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute();
    
    $csv = Writer::createFromFileObject(new SplTempFileObject());
    $csv->setDelimiter(';');
    $csv->setNewline("\r\n");
    $csv->insertOne(['Celular', 'Nome']);
    $csv->insertAll($sth);
    $csv->output('Lista_Celular.csv');
    die;
?>