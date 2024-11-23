<?php
/*
This file should be part of the header "require" in all controller files.
It will deny any url direct access.

@author Victor Béser
*/
class SecureRequestModel {

    public static function init() {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            die('Acesso negado.');
        }
    }

}

SecureRequestModel::init();