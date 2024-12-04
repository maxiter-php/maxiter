<?php
/*
The model represents the application's data and business logic. It manages data retrieval, 
storage, and manipulation, often interacting with the database. 
The model encapsulates rules and validation to ensure data integrity.

@author Victor Béser
*/
class CorsModel
{

    public static function setCors()
    {
        // Your code here
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Credentials: true");

    }

}