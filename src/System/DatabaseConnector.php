<?php
namespace Src\System;
use Src\System\PDO;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        // $host = getenv('DB_HOST');
        // $port = getenv('DB_PORT');
        // $db   = getenv('DB_DATABASE');
        // $user = getenv('DB_USERNAME');
        // $pass = getenv('DB_PASSWORD');  
        
        $host ='localhost:8889';
        $port = 8889;
        $db   = 'mymovies';
        $user = 'test';
        $pass = 'tester';
        // $conn = $pdo->open();


        try {
            // $this->dbConnection = new \PDO(
            //     "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
            //     $user,
            //     $pass
            // );
            $conn = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
