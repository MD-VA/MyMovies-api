<?php
namespace src\System;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        
        $host ='localhost:3306';
        $port = 3306;
        $db   = 'mymovies';
        $user = 'tester';
        $pass = 'root';

        try {
            $this->dbConnection = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
        } catch (\PDOException $e) {
            echo $user;
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
