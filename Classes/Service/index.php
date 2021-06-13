<?php
require "../bootstrap.php";

use Data\PersonController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri[1] !== 'person') {
    header("HTTP/1.1 404 Not Found");
    exit();
}
$flag = 0; //1 - login, 2 - msg
// the user id is, of course, optional and must be a number:
$userId = null;
if (isset($uri[2]) && isset($uri[3])  == false) {
    $userId = (int) $uri[2];
    $flag =1;
} else {
    $flag = 2;
}
$controller= new PersonController($flag, $requestMethod, $userId, $key);

if ($usersValidation->authenticate($userId)) {
    header("HTTP/1.1 401 Unauthorized");
    exit('Unauthorized');
}
$requestMethod = $_SERVER["REQUEST_METHOD"];
$usersValidation->processRequest();