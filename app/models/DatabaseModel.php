<?php
/*
This is the database connection file, where you will get your connections and will be able to
use pdo method to get your selects and any whatever statement you want.

@author Victor Béser
*/
class DatabaseModel
{

    private static $driver;
    private static $host;
    private static $port;
    private static $user;
    private static $pass;
    private static $db;
    private static $pdo;

    public static function connection($db)
    {

        self::$db = $db;
        $config = json_decode(EnvModel::database(self::$db), true);

        self::$driver = $config['driver'];
        self::$port = $config['port'];
        self::$host = $config['host'];
        self::$user = $config['user'];
        self::$pass = $config['pass'];

        try {
            self::$pdo = new PDO(self::$driver . ":host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db . "", self::$user, self::$pass);
        } catch (PDOException $e) {
            die("Error while connecting database: " . $e->getMessage());
        }

        return new self();


    }

    public static function execute($query, $bindParams = null)
    {
        $result = self::$pdo->prepare($query);

        if ($bindParams != null) {
            foreach ($bindParams as $key => $value) {
                $result->bindValue($key, $value); 
            }
        }

        $result->execute();
        return $result;
    }


    public static function pdo()
    {
        return self::$pdo;
    }

    public static function closeConnection()
    {
        self::$pdo = null;
    }

}
