<?php
/*
The controller file handles user input and interaction. It processes requests,
invokes business logic, and updates the model as needed.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';
require __DIR__ . '/../models/SecureRequestModel.php';

class UsersController {

    public function main() {
        
        // Your code here
        $result = DatabaseModel::connection("maxiter")->execute("SELECT * FROM users");
        $compactData = [];
        while($resultFetch = $result->fetch(PDO::FETCH_ASSOC)) {
            $compactData[] = $resultFetch;
        }
        
        ResponseModel::json( true, $compactData);

    }

}

$controller = new UsersController();
(isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
