<?php
/*
A middleware is a function that processes incoming requests 
before they reach the main application or route handler. 
It can modify requests, responses, or handle tasks like 
authentication, logging, and error handling.

@author Victor Béser
*/
class BearerAuthorizationMiddleware {

    public static function handle() {
        $headers = getallheaders();
        if (isset($headers["Authorization"])) {
            $authorizationHeader = $headers["Authorization"]; 
            if(EnvModel::env('BEARER_TOKEN') === $authorizationHeader) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}