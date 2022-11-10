<?php
namespace src\Controller;

use src\TableGateways\MovieGateway;
use src\TableGateways\ImbdGateway;

class MovieController {


    private $apikey;

    private $db;
    private $requestMethod;
    private $userId;
    private $movieGateway;
    private $imbGateaway;

    public function __construct($db, $requestMethod, $userId, $requestRoute)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->requestRoute = $requestRoute;
        $this->apikey = "046720553f711abd5a48ddf1b60db681";


        $this->movieGateway = new MovieGateway($db);
        // $this->imbGateaway = new ImbdGateway($db);
    }


    // The database routes
    private function moviesRoute()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    // $response = $this->getUser($this->userId);
                    $response = "api works";
                } else {
                    // $response = $this->getAllUsers();
                    $response = "api works";
                };
                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
         // header($response['status_code_header']);
         if ($response) {
            echo $response;
        }
    }
    

    // Routes for the movie API
    private function apiRoutes(){
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    // $response = $this->getUser($this->userId);
                    // $response = "get from the api";
                    $get_data = $this->callAPI('GET', "https://api.themoviedb.org/3/movie/popular?api_key=" .$this->apikey. "&language=en-US&page=1", false);
                    $response = json_decode($get_data, true);
                    $errors = $response['response']['errors'];
                    $data = $response['response']['data'][0];
                    echo 'tested';
                    echo json_encode($data);

                } else {
                    // $response = $this->getAllUsers();
                    $get_data = $this->callAPI('GET', "https://api.themoviedb.org/3/movie/popular?api_key=" .$this->apikey. "&language=en-US&page=1", false);
                    $response = json_decode($get_data, true);
                    $errors = $response;
                    $data = $response;
                    echo json_encode($data);
                    // $response = "get data from the api";
                };
                break;
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteUser($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
    
         header($response['status_code_header']);
         if ($response) {
            echo `https://api.themoviedb.org/3/movie/popular?api_key=`.$this->apikey."&language=en-US&page=1";
            echo 'efsfefs';
            echo json_encode($data);

        }else {
            echo `https://api.themoviedb.org/3/movie/popular?api_key=`.$this->apikey."&language=en-US&page=1";

            echo json_encode($errors);
        }
    }

    public function processRequest()
    {

        if ($this->requestRoute == 'movie') {
           $this->moviesRoute();
        }
        elseif ($this->requestRoute == 'api') {
            $this->apiRoutes();
        }
        else{
            echo "no route found";
        }
       
       
    }

    private function getAllUsers()
    {
        $result = $this->movieGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getUser($id)
    {
        $result = $this->movieGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateMovie($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->movieGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateUserFromRequest($id)
    {
        $result = $this->movieGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateMovie($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->movieGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteUser($id)
    {
        $result = $this->movieGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->movieGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateMovie($input)
    {
        if (! isset($input['firstname'])) {
            return false;
        }
        if (! isset($input['lastname'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'APIKEY: 111111111111111111111',
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
     }

}
