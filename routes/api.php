<?php
/*
Here is where you will configure all your API Routes,
follow the instructions in docs or just feel 
how it works and happy hacking!

@author Victor Béser
*/
isset($_SESSION['api-route']) ? "" : die("Denied");
$urlParsed = $_SESSION['api-route'];
unset($_SESSION['api-route']);
$urlParts = explode('/', $urlParsed['path']);

// LoadModel
require __DIR__ . '/../app/models/LoadModel.php';

if ($urlParts[0] === 'api' || $urlParts[0] === 'api/' && $urlParts[1] != null) {
    if (count($urlParts) > 1) {
        $url = "/" . implode("/", array_slice($urlParts, 1));
    } else {
        ResponseModel::json(false, "404 not found");
    }
} else {
    ResponseModel::json(false, "404 not found");
}
// Middleware
require __DIR__ . "/../app/middlewares/BearerAuthorizationMiddleware.php";

// Include your Controllers
include __DIR__ . "/../app/controllers/ApiTestController.php";

class Api {

    public function routes($url) {
        $routes = array(
            
            // Your routes
            '/info'  => array('controller' => 'ApiTestController', 'function' => 'info', 'middleware' => null),
            '/hello' => array('controller' => 'ApiTestController', 'function' => 'helloWorld', 'middleware' => null),
            '/auth'  => array('controller' => 'ApiTestController', 'function' => 'withMiddleware', 'middleware' => 'BearerAuthorizationMiddleware'),

        );
        $url = rtrim($url,"/");
        if (isset($routes[$url])) {
            $route = $routes[$url];
            ApiModel::route($url, $url, $route['controller'], $route['function'], $route['middleware']);
        } else {
            ResponseModel::json(false, "404 not found");
        }
    }
}


$api = new Api();
$api->routes($url);