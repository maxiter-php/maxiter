<?php
/*
This is an usefull example of how authenticate users in your project.
This is usually a common way to do it but you could try any other ways to do it as your wish.

@author Victor Béser
*/
class AuthModel {

    private static $contextData;

    public static function verify() {

        if(isset($_SESSION['logged'])) {

            return true;

        } else {

            return false;

        }

    }

    public static function getContext($contextData) {

        if(isset($_SESSION['logged'])) {
            self::$contextData = $contextData;
            return $_SESSION[self::$contextData];

        }

    }

}