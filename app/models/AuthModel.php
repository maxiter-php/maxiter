<?php
/*
This is an usefull example of how authenticate users in your project.
This is usually a common way to do it but you could try any other ways to do it as your wish.

@author Victor Béser
*/
class AuthModel
{

    private static $contextData;

    public static function verify($redirectPage = null, $authority = null)
    {
        // Check if user exists
        $isLogged = isset($_SESSION['logged']) && $_SESSION['logged'] === true;

        if (!$isLogged) {
            if ($redirectPage !== null) {
                header("Location: " . EnvModel::env("APP_BASE_URL") . $redirectPage);
                exit();
            }
            return false;
        }

        // Check if there's any authority
        if ($authority !== null) {
            // $_SESSION["authorities"] must be an array
            $userAuthorities = array();
            if (isset($_SESSION["authorities"])) {
                if (is_array($_SESSION["authorities"])) {
                    $userAuthorities = array_map('strtolower', $_SESSION["authorities"]);
                } else {
                    // If it's a string
                    $userAuthorities = array(strtolower($_SESSION["authorities"]));
                }
            }

            // Normalize the entry 
            $requiredAuthorities = is_array($authority) ? $authority : array($authority);
            $requiredAuthorities = array_map('strtolower', $requiredAuthorities);

            // Check if exists any valid authority
            $hasAuthority = count(array_intersect($requiredAuthorities, $userAuthorities)) > 0;

            if (!$hasAuthority) {
                if ($redirectPage !== null) {
                    header("Location: " . EnvModel::env("APP_BASE_URL") . $redirectPage);
                    exit();
                }
                return false;
            }
        }

        // User is Authorized and Authenticated
        return true;
    }

    public static function getContext($contextData)
    {

        if (isset($_SESSION['logged'])) {
            self::$contextData = $contextData;

            $userContext = $_SESSION['userContext'];

            return $userContext[self::$contextData];

        }

    }

}