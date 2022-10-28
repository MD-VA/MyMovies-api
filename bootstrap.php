<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

use src\System\DatabaseConnector;


// $dotenv = new Dotenv(__DIR__);
// $dotenv->load();

// test code, should output:
// api://default
// when you run $ php bootstrap.php
echo getenv('OKTAAUDIENCE');

$dbConnection = (new DatabaseConnector())->getConnection();

