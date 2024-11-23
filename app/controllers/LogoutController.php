<?php
/*
The controller file handles user input and interaction. It processes requests,
invokes business logic, and updates the model as needed.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';
require __DIR__ . '/../models/SecureRequestModel.php';

class LogoutController {

    public function main() {
        // Your code here
        session_start();
        session_unset();
        session_destroy();

        ResponseModel::json(true, "Logout!");
    }

}

$controller = new LogoutController();
(isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
