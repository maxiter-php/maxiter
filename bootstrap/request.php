<?php
/*
HTTP request helpers for route resolution.

@author Victor Beser
*/

require_once __DIR__ . '/helpers.php';

if (!function_exists('maxiter_detect_route_url')) {
    function maxiter_detect_route_url()
    {
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            return htmlspecialchars(trim($_GET['url']));
        }

        if (PHP_SAPI === 'cli-server' && isset($_SERVER['REQUEST_URI'])) {
            $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestPath = trim($requestPath, '/');

            if ($requestPath !== '') {
                return htmlspecialchars($requestPath);
            }
        }

        return 'home';
    }
}

if (!function_exists('maxiter_store_api_route')) {
    function maxiter_store_api_route($url)
    {
        $parsedUrl = parse_url($url);
        $GLOBALS['maxiter_api_route'] = $parsedUrl;

        if (session_id() !== '') {
            $_SESSION['api-route'] = $parsedUrl;
        }

        return $parsedUrl;
    }
}

if (!function_exists('maxiter_resolve_api_route')) {
    function maxiter_resolve_api_route()
    {
        if (isset($GLOBALS['maxiter_api_route']) && is_array($GLOBALS['maxiter_api_route'])) {
            return $GLOBALS['maxiter_api_route'];
        }

        if (isset($_SESSION['api-route']) && is_array($_SESSION['api-route'])) {
            return $_SESSION['api-route'];
        }

        $currentUrl = maxiter_detect_route_url();
        if (strpos($currentUrl, 'api') === 0) {
            return parse_url($currentUrl);
        }

        return null;
    }
}
