<?php
/*
The controller file handles user input and interaction. It processes requests,
invokes business logic, and updates the model as needed.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';
//require __DIR__ . '/../models/SecureRequestModel.php'; // Remove this if it's a route for an API

class ApiTestController {

    public function main() {
        // Your code here
        ResponseModel::json(true, "Your Api Route Is Working Successfully!");
    }
    public function helloWorld() {
        // Your code here
        ResponseModel::json(true, "Hello World!");
    }

}

$controller = new ApiTestController();
// (isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
