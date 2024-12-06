<?php
/*
The Treat model apply some treatments for you, like the escape function
return all array data with char escape.

@author Victor Béser
*/
class TreatModel
{

    public static function escape(array $data)
    {
        $response = array();
        foreach ($data as $key => $value) {
            $response[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $response;
    }

    public static function hash(string $password, string $method = "md5")
    {

        $pass = htmlspecialchars(trim($password), ENT_QUOTES, 'UTF-8');
        $method = strtolower($method);
        $response = null;
        switch ($method) {
            case 'md5':
                $response = md5(trim($pass));
                break;

            case 'hash':
                $response = password_hash(trim($pass), PASSWORD_DEFAULT);
                break;

            default:
                $response = "Not a valid method! Use md5 or hash.";
                break;
        }
        return $response;

    }


}