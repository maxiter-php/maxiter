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
        
        // Escaping special chars with TreatModel
        $data = TreatModel::escape($_POST);
        $user = $data['user'];
        $password = $data['password'];

        // Searching for an especific user in database using DatabaseModel with params
        $result = DatabaseModel::connection(EnvModel::env("DB"))->execute("SELECT * FROM users WHERE username = :user AND password = :pass", array(
            ":user" => $user,
            ":pass" => $password
        ));

        // Returning JSON with ResponseModel
        if($result->rowCount() != 0) {
            ResponseModel::json( true, "User is ok!");
        } else {
            ResponseModel::json( false, "User is not ok!");
        }

    }

}

$controller = new UsersController();
(isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
