<?php
/*
The API controller file handles user input and interaction. It processes requests,
invokes business logic, and returns as needed.

@author Victor Béser
*/

require __DIR__ . '/../models/LoadModel.php';
require __DIR__ . '/../models/SecureRequestModel.php';

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

    public function indexUsers() {
        ResponseModel::json(true, array(
            'resource' => 'users',
            'method' => 'GET',
            'action' => 'index',
        ));
    }

    public function storeUser() {
        ResponseModel::json(true, array(
            'resource' => 'users',
            'method' => 'POST',
            'action' => 'store',
        ));
    }

    public function showUser($id) {
        ResponseModel::json(true, array(
            'user_id' => $id,
            'resource' => 'users',
            'method' => 'GET',
            'action' => 'show',
        ));
    }

    public function updateUser($id) {
        ResponseModel::json(true, array(
            'user_id' => $id,
            'resource' => 'users',
            'method' => 'PUT',
            'action' => 'update',
        ));
    }

    public function destroyUser($id) {
        ResponseModel::json(true, array(
            'user_id' => $id,
            'resource' => 'users',
            'method' => 'DELETE',
            'action' => 'destroy',
        ));
    }

    public function showPostComment($postId, $commentId) {
        ResponseModel::json(true, array(
            'post_id' => $postId,
            'comment_id' => $commentId,
            'resource' => 'comments',
            'method' => 'GET',
            'action' => 'show',
        ));
    }

}
