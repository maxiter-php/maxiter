<?php
/*
The Treat model apply some treatments for you, like the escape function
return all array data with char escape.

@author Victor Béser
*/
class TreatModel
{

    public static function escape($data)
    {
        if (is_array($data)) {
            $response = array();
            foreach ($data as $key => $value) {
                $response[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
            return $response;
        } else {
            $response = htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
            return $response;
        }
    }

    public static function isNull(array $data, $exception = null)
    {
        if (!empty($exception)) {
            if (is_array($exception)) {
                foreach ($exception as $key) {
                    if (array_key_exists($key, $data)) {
                        unset($data[$key]);
                    }
                }
            } elseif (array_key_exists($exception, $data)) {
                unset($data[$exception]);
            }
        }

        $filtered = array_filter($data, function ($value) {
            return $value === null || empty($value);
        });

        return count($filtered) > 0;
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