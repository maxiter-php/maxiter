<?php
/*
Routes Model will help you to set up your paths in your hrefs.
Use it like: <a href="RoutesModel::path('home')">Click here to go home</a>

@author Victor Béser
*/
class RoutesModel {

    public static function path($page) {
        
        $path = EnvModel::env("APP_BASE_URL") . "/$page";
        return $path;

    }

}