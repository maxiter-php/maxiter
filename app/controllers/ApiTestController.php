<?php
/*
The API controller file handles user input and interaction. It processes requests,
invokes business logic, and returns as needed.

@author Victor Béser
*/

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

    public function user($id) {
        return array(
            'user_id' => $id,
            'message' => 'Dynamic route parameter working',
        );
    }

    public function postComment($postId, $commentId) {
        return array(
            'post_id' => $postId,
            'comment_id' => $commentId,
        );
    }

}
