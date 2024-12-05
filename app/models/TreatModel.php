<?php
/*
The Treat model apply some treatments for you, like the escape function
return all array data with char escape.

@author Victor Béser
*/
class TreatModel {

    public static function escape(array $data) {
        $response = array();
        foreach ($data as $key => $value) {
            $response[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $response;
    }
    

}