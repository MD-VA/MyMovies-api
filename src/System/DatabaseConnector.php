<?php
namespace src\System;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        // $host = getenv('DB_HOST');
        // $port = getenv('DB_PORT');
        // $db   = getenv('DB_DATABASE');
        // $user = getenv('DB_USERNAME');
        // $pass = getenv('DB_PASSWORD');  
        
        $host ='localhost:3306';
        $port = 3306;
        $db   = 'mymovies';
        $user = 'tester';
        $pass = 'root';
        // $conn = $pdo->open();


        try {
            // $this->dbConnection = new \PDO(
            //     "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
            //     $user,
            //     $pass
            // );
            $this->dbConnection = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
            // set the PDO error mode to exception
            // $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
            
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
