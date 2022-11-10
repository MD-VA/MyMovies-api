<?php
require "../bootstrap.php";
use src\Controller\MovieController;
use src\Controller\ImbdController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /movie
// everything else results in a 404 Not Found
if ($uri[1] !== 'movie' && $uri[1] !== 'api') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller;
// pass the request method and user ID to the PersonController and process the HTTP request:
// switch ($uri[1]) {
//     case 'movie':
//         $controller = new MovieController($dbConnection, $requestMethod, $userId);
//         break;
//     case 'api':
//         $controller = new ImbdController($dbConnection, $requestMethod, $userId);
//         break;
    
//     default:
//         # code...
//         break;
// }
$controller = new MovieController($dbConnection, $requestMethod, $userId, $uri[1]);
$controller->processRequest('movie');

// $apiController = new ImbdController($dbConnection, $requestMethod, $userId);
// // $apicontroller->processRequest('/api');
// $apiController->processRequest('api');