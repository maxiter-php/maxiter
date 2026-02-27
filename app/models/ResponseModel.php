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
    private static $code;

    public static function json($status, $data, $code = null) {
        self::$status = $status;
        self::$data = $data;
        self::$code = $code;

        http_response_code(self::$code);
        echo json_encode(array(
            "status" => self::$status,
            "data" => self::$data,
        ));

        if (php_sapi_name() !== 'cli' || !defined('PHPUNIT_RUNNING')) {
            exit();
        } 

    }

    public static function http($code) {
        self::$code = $code;

        http_response_code(self::$code);

        if (php_sapi_name() !== 'cli' || !defined('PHPUNIT_RUNNING')) {
            exit();
        } 

    }

}