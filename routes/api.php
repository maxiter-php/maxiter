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

if ($urlParts[0] === 'api' && $urlParts[1] != null) {
    if (count($urlParts) > 1) {
        $url = "/" . implode("/", array_slice($urlParts, 1));
    } else {
        header('Location: ../home');exit();
    }
} else {
    header('Location: ../home');exit();
}

// echo $url;exit();

// Include your Controllers
include __DIR__ . "/../app/controllers/ApiTestController.php";

class Api {

    public function routes($url) {

        // Your routes
        // ApiModel::route("/info", $url, "ApiTestController");
        
        ApiModel::route("/info/teste", $url, "ApiTestController", "helloWorld");
    }

}


$api = new Api();
$api->routes($url);