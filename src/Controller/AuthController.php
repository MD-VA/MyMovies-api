<?php

namespace src\Controller;

class AuthController{

    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function signupUser($arrayInfo){
        try{

            // Check if email already used
            $stmt = $this->db->prepare("CALL checkIfEmailUsed(?)");
            $stmt->bindParam('email' ,$arrayInfo["email"], \PDO::PARAM_STR);
            $rs = $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if($result[0] == 0){
                $hashedPwd = password_hash($arrayInfo["password"], PASSWORD_DEFAULT);
                $stmt2 = $this->db->prepare("CALL createUser(?)");
                $stmt2->bindParam($arrayInfo["username"], $hashedPwd, $arrayInfo["firstname"], $arrayInfo["lastname"], $arrayInfo["email"], $arrayInfo["phonenumber"], $arrayInfo["adress1"], $arrayInfo["adress2"], $arrayInfo["city"], $arrayInfo["zip"]);
                $rs2 = $stmt2->execute();

                header("HTTP/1.1 500 User Created");
                exit();
            }else{
                header("HTTP/1.1 404 Not Found");
                exit();
            }
        }catch(\Exception $e){
            print($e->getMessage());
        }
    }


    public function signInUser($arrayInfo){
        $stmt = $this->db->prepare("CALL findUserByEmail(?)");
        $stmt->bindParam( 'email',$arrayInfo["email"], \PDO::PARAM_STR);
        $rs = $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(password_verify( 'password',$arrayInfo["password"], $result[0]["password"])){
            header("HTTP/1.1 500 User loged");
            exit();
        }else{
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

}
?>