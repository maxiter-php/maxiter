<?php
/*
The ApiModel file configure the route for API in your project,
don't touch it =)

@author Victor Béser
*/

class ApiModel {

    public static function route($string, $url, $controller, $function = null) {
        if(strtolower($string) == strtolower($url)) {
            $controllerInstance = new $controller();

            if($function) {
                ResponseModel::json(true, $controllerInstance->$function());
            } else {
                ResponseModel::json(true, $controllerInstance->main());
            }

        }

        // If no route matches, return 404 response
        ResponseModel::json(false, "404 not found");
    }

}