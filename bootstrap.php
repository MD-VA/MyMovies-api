<?php
require 'vendor/autoload.php';
use src\System\DatabaseConnector;

// use Dotenv\Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// test code, should output:
// api://default
// when you run $ php bootstrap.php
echo getenv('OKTAAUDIENCE');

$dbConnection = (new DatabaseConnector())->getConnection();

