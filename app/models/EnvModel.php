<?php
/* 
This file loads environment data from env.ini and/or .env to use statically in your project.
Feel free to create new functions to get new data from the environment configuration files.

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
        if (!function_exists('maxiter_load_env_config')) {
            require_once dirname(dirname(__DIR__)) . '/bootstrap/config.php';
        }

        self::$env = maxiter_load_env_config();

    }

    public static function env($key)
    {
        if ($key === 'APP_BASE_URL') {
            return AppUrlModel::baseUrl();
        }

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
        $sectionName = $database;

        if (!isset(self::$env[$sectionName]) || !is_array(self::$env[$sectionName])) {
            foreach (self::$env as $section => $values) {
                if (is_array($values) && isset($values['DB']) && $values['DB'] === $database) {
                    $sectionName = $section;
                    break;
                }
            }
        }

        self::$driver = isset(self::$env[$sectionName]['DRIVER']) ? self::$env[$sectionName]['DRIVER'] : null;
        self::$port = isset(self::$env[$sectionName]['PORT']) ? self::$env[$sectionName]['PORT'] : null;
        self::$host = isset(self::$env[$sectionName]['HOST']) ? self::$env[$sectionName]['HOST'] : null;
        self::$user = isset(self::$env[$sectionName]['USER']) ? self::$env[$sectionName]['USER'] : null;
        self::$pass = isset(self::$env[$sectionName]['PASS']) ? self::$env[$sectionName]['PASS'] : null;

        return json_encode(array(
            "driver" => self::$driver,
            "port" => self::$port,
            "host" => self::$host,
            "user" => self::$user,
            "pass" => self::$pass,
        ));

    }


}

EnvModel::init();
