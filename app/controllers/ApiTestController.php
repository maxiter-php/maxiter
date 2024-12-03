<?php
/*
The API controller file handles user input and interaction. It processes requests,
invokes business logic, and returns as needed.

@author Victor Béser
*/
require __DIR__ . '/../models/LoadModel.php';

class ApiTestController {

    public function info() {
        // Your code here
        ResponseModel::json(true, "Your Api Route Is Working Successfully!");
    }
    public function helloWorld() {
        // Your code here
        ResponseModel::json(true, "Hello World!");
    }
    public function withMiddleware() {
        // Your code here
        ResponseModel::json(true, "You're authorized!");
    }

}