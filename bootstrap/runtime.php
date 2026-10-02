<?php
/*
Runtime initialization for timezone, CORS and shared app state.

@author Victor Beser
*/

if (!function_exists('maxiter_bootstrap_runtime')) {
    function maxiter_bootstrap_runtime()
    {
        if (defined('MAXITER_RUNTIME_BOOTSTRAPPED')) {
            return;
        }

        define('MAXITER_RUNTIME_BOOTSTRAPPED', true);

        $timezone = EnvModel::env('DEFAULT_TIMEZONE');
        if ($timezone !== 'Invalid env name!' && $timezone !== '') {
            date_default_timezone_set($timezone);
        }

        CorsModel::setCors();
    }
}
