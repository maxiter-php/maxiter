<?php
/*
This is an example of how implement unit test with PHPUnit into Maxiter.
Check out the /tests/ folder with the unit test for this controller.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';
require __DIR__ . '/../models/SecureRequestModel.php';

class UnitTestController {

    public function main() {
        // Your code here
    }

    public function postSum() {

        // Example of a simple calculator a + b
        $a = $_POST["a"];
        $b = $_POST["b"];
        ResponseModel::json(true, $a + $b); 

    }

}

$controller = new UnitTestController();
(isset($_POST['controller']) && !empty($_POST['controller'])) ? $controller->{$_POST['controller']}() : $controller->main();
