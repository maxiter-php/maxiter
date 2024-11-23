<?php
/*
ResponseModel it's going to facilitate your life, it returns back a
JSON encode with two args, 'status' and 'data'. Status should be
a bool true or false and data you should send arrays or strings or
whatever you want to. Use it like ResponseModel::json(true, $my_array_data)
or something.

@author Victor Béser
*/
class ResponseModel {

    private static $status;
    private static $data;

    public static function json($status, $data) {
        self::$status = $status;
        self::$data = $data;

        echo json_encode([
            "status" => self::$status,
            "data" => self::$data,
        ]);exit();


    }

}