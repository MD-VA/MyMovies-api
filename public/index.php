<?php
require "../bootstrap.php";
use src\Controller\MovieController;
use src\Controller\AuthController;
use src\Controller\PlaylistFilmController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// Use parse_url() function to parse the URL
// and return an associative array which
// contains its various components
$url_components = parse_url($_SERVER['REQUEST_URI']);
 
// Use parse_str() function to parse the
// string passed via URL
parse_str($url_components['query'], $params);
     
// Display result
// echo ' Hi '.$params['page'];
// print_r($params);


// all of our endpoints start with /movie
// everything else results in a 404 Not Found
if ($uri[1] !== 'movie' && $uri[1] !== 'api' && $uri[1] !== 'auth' && $uri[1] !== 'playlist') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// the user id is, of course, optional and must be a number:
$userId = null;
$pageID = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
    $pageID = $uri[2];
}


// echo $uri[1];

$requestMethod = $_SERVER["REQUEST_METHOD"];


switch ($uri[1]) {
    case 'api':
        $controller = new MovieController($dbConnection, $requestMethod, $userId, $uri[1], $params);
        $controller->processRequest();
        break;
    case 'movie':
        $controller = new MovieController($dbConnection, $requestMethod, $userId, $uri[1], $params);
        $controller->processRequest();
        break;
    case 'auth':
        echo 'auth';
        $controller = new AuthController($dbConnection);
        if ($pageID == 'signin') {
            $controller->signInUser($params);
        }elseif ($pageID == 'register') {
            $controller->signupUser($params);
        }
        break;
    case 'playlist':
        echo 'function';
        $controller = new PlaylistFilmController($dbConnection);
        if ($pageID == 'create') {
            $controller->createPlaylist($params['name'], $params['public'], $params['user_id']);
        }elseif ($pageID == 'add') {
            $controller->addFilmToPlaylist($params['playlist_id'], $params['film_id']);
        }
        break;
    default:
        echo 'fail';
        header("HTTP/1.1 404 Not Found");
        exit();
    break;
}

