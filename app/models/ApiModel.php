<?php
/*
The ApiModel file configure the route for API in your project,
don't touch it =)

@author Victor Béser
*/
class ApiModel {

    public static function route($string, $url, $controller, $function, $middleware = null) {

        if($middleware) {
            $handle = $middleware::handle();
            if($handle) {
                if(strtolower(str_replace("/", "", $string)) == strtolower(str_replace("/", "", $url))) {
                    $controllerInstance = new $controller();
        
                    if($function) {
                        ResponseModel::json(true, $controllerInstance->$function());
                    } else {
                        ResponseModel::json(true, $controllerInstance->main());
                    }
        
                }
            } else {
                ResponseModel::json(false, "Unauthorized");
            }
        } else {
            if(strtolower(str_replace("/", "", $string)) == strtolower(str_replace("/", "", $url))) {
                $controllerInstance = new $controller();
    
                if($function) {
                    ResponseModel::json(true, $controllerInstance->$function());
                } else {
                    ResponseModel::json(true, $controllerInstance->main());
                }
    
            }
        }

        ResponseModel::json(false, "404 not found");
    }

}