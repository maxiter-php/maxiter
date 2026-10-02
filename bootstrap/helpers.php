<?php
/*
Core helper functions shared by Maxiter bootstrap files.

@author Victor Beser
*/

if (!function_exists('maxiter_project_root')) {
    function maxiter_project_root()
    {
        return dirname(__DIR__);
    }
}

if (!function_exists('maxiter_project_path')) {
    function maxiter_project_path($path)
    {
        $path = trim((string) $path, "\\/");

        if ($path === '') {
            return maxiter_project_root();
        }

        return maxiter_project_root() . DIRECTORY_SEPARATOR . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    }
}
