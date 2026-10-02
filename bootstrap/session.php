<?php
/*
Session bootstrap for Maxiter runtime.

@author Victor Beser
*/

require_once __DIR__ . '/helpers.php';

if (!function_exists('maxiter_session_directory')) {
    function maxiter_session_directory()
    {
        return maxiter_project_path('src/sessions');
    }
}

if (!function_exists('maxiter_prepare_session_path')) {
    function maxiter_prepare_session_path($projectRoot)
    {
        $sessionPath = session_save_path();

        if (strpos($sessionPath, ';') !== false) {
            $parts = explode(';', $sessionPath);
            $sessionPath = end($parts);
        }

        if ($sessionPath !== '' && is_dir($sessionPath)) {
            return $sessionPath;
        }

        $fallbackPath = rtrim($projectRoot, '\\/') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'sessions';

        if (!is_dir($fallbackPath)) {
            @mkdir($fallbackPath, 0777, true);
        }

        if (is_dir($fallbackPath)) {
            session_save_path($fallbackPath);
            return $fallbackPath;
        }

        return $sessionPath;
    }
}

if (!function_exists('maxiter_start_session')) {
    function maxiter_start_session($projectRoot)
    {
        if (session_id() !== '') {
            return;
        }

        maxiter_prepare_session_path($projectRoot);
        @session_start();
    }
}
