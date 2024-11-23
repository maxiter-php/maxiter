<?php
/* 
This file get all the env.ini data and convert in to use statically in your project.
Feel free to create new functions to get new data from env.ini file!

@author Victor Béser
*/
class EnvModel
{

    private static $env;
    private static $title;
    private static $token;
    private static $driver;
    private static $port;
    private static $host;
    private static $user;
    private static $pass;
    private static $db;

    public static function init()
    {
        self::$env = parse_ini_file(__DIR__ . "/../../env.ini", true);

    }

    public static function env($key)
    {
        if (array_key_exists($key, self::$env)) {
            return self::$env[$key];
        }
        foreach (self::$env as $section) {
            if (array_key_exists($key, $section)) {
                return $section[$key];
            }
        }

        return "Invalid env name!";
    }

    public static function database($database)
    {

        self::$driver = self::$env[$database]['DRIVER'];
        self::$port = self::$env[$database]['PORT'];
        self::$host = self::$env[$database]['HOST'];
        self::$user = self::$env[$database]['USER'];
        self::$pass = self::$env[$database]['PASS'];

        return json_encode([
            "driver" => self::$driver,
            "port" => self::$port,
            "host" => self::$host,
            "user" => self::$user,
            "pass" => self::$pass,
        ]);

    }


}

EnvModel::init();