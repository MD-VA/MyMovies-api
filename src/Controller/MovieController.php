<?php
namespace src\Controller;

// use src\TableGateways\MovieGateway;
use src\TableGateways\ImbdGateway;

class MovieController {


    private $apikey;

    private $db;
    private $requestMethod;
    private $userId;
    private $movieGateway;
    private $imbGateaway;

    public function __construct($db, $requestMethod, $userId, $requestRoute, $params)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->requestRoute = $requestRoute;
        $this->params = $params;
        $this->apikey = "046720553f711abd5a48ddf1b60db681";
    }


    // The database routes
    private function moviesRoute()
    {
        echo 'empty';
    }
    

    // Routes for the movie API
    private function apiRoutes(){
                if (isset($this->params['search'])) {
                    print_r($this->userId);
                    $get_data = $this->callAPI('GET', "https://api.themoviedb.org/3/search/movie?api_key=" .$this->apikey. "&query=" .$this->params['search']. "&page=1", false);
                    $response = json_decode($get_data, true);
                    $errors = $response;
                    $data = $response;
                    echo json_encode($data);
                } else if ($this->userId) {
                    // get movies details
                    print_r($this->userId);
                    $get_data = $this->callAPI('GET', "https://api.themoviedb.org/3/movie/" .$this->userId.  "?api_key=" .$this->apikey. "&language=en-US", false);
                    $response = json_decode($get_data, true);
                    $errors = $response;
                    $data = $response;
                    echo json_encode($data);

                } else {
                    // get movies list
                    $page = null;
                    if (isset($this->params['page'])) {
                        $page = $this->params['page'];
                    }else{
                        $page = 1;
                    }
                    print_r($this->userId);
                    $get_data = $this->callAPI('GET', "https://api.themoviedb.org/3/movie/popular?api_key=" .$this->apikey. "&language=en-US&page=" .$page , false);
                    $response = json_decode($get_data, true);
                    $errors = $response;
                    $data = $response;
                    echo json_encode($data);
                };
          

  
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
