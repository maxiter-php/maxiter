<?php
/*
The controller file handles user input and interaction. It processes requests,
invokes business logic, and updates the model as needed.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';
require __DIR__ . '/../models/SecureRequestModel.php';

class UsersController
{

    // Login function
    public function main()
    {
        // CPF here is the ID for the user in this example

        // Escaping special chars with TreatModel
        $data = TreatModel::escape($_POST);
        $cpf = preg_replace('/\D/', '', $data['cpf']);
        $password = TreatModel::hash($data['password'], "md5"); // Hashing password with TreatModel, you could use 'md5' or 'hash'

        // Searching for an especific cpf in database using DatabaseModel with params
        $query = "SELECT user.*, user_role.role AS authority FROM user INNER JOIN user_role ON user_role.id = user.role WHERE user.cpf = :cpf AND user.password = :pass";
        $result = DatabaseModel::connection(EnvModel::env("DB"))->execute($query, array(
            ":cpf" => $cpf,
            ":pass" => $password
        ));

        $resultFetch = $result->fetch(PDO::FETCH_ASSOC);

        // Returning JSON with ResponseModel
        if ($result->rowCount() != 0) {
            $_SESSION['logged'] = true; // Set authentication
            $_SESSION['userContext'] = array( // Set user infos
                "id" => $resultFetch["id"],
                "name" => $resultFetch["name"],
                "email" => $resultFetch["email"],
                "cpf" => $resultFetch["cpf"],
                "phone" => $resultFetch["phone"],
            );
            $_SESSION["authorities"] = $resultFetch["authority"]; // Set authorization

            // LogModel::log("Login success");
            ResponseModel::json(true, array("authority" => strtolower($resultFetch["authority"]), "id" => $resultFetch["id"]));
        } else {
            // LogModel::log("Login fail");
            ResponseModel::json(false, "User or pass not found!");
        }

    }


    public function getUsers()
    {

        $result = DatabaseModel::connection(EnvModel::env("DB"))->execute("SELECT * FROM users");

        $response = array();
        while ($resultFetch = $result->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $resultFetch;
        }

        ResponseModel::json(true, $response);

    }

}

$controller = new UsersController();
(isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
