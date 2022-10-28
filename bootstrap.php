<?php
require('vendor/autoload.php');
// use Dotenv\Dotenv;

use src\System\DatabaseConnector;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dbConnection = (new DatabaseConnector())->getConnection();

echo('rofjoer');

?>