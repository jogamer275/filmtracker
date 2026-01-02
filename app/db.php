<?php
$config = require __DIR__ . '/config.php';

function getDatabaseConnection($config){

    $host = $config['db_host'];
    $db = $config['db_name'];
    $user = $config['db_user'];
    $password = $config['db_pass'];
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";


    return new PDO($dsn, $user, $password);
}
