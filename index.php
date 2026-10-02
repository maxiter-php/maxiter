<?php
/*

This is the Route system of your project.
Suggestion: DON'T CHANGE ANYTHING HERE.

@ author Victor Béser
*/

require_once __DIR__ . '/bootstrap/session.php';
require_once __DIR__ . '/bootstrap/request.php';

maxiter_start_session(__DIR__);

class Routes {
    
    public function routes($url) {
        $pageUrl = !empty($url) ? $url : "home";
        $part = explode('/', $pageUrl);
        $page = $part[0];

        if($page === "api") {
            maxiter_store_api_route($url);
            $pagePath = __DIR__ . "/bootstrap/api.php";
        } else {
            $pagePath = __DIR__ . "/resources/views/pages/$page/$page.php";
        }
        
        if (is_file($pagePath)) {
            include $pagePath;
        } else {
            header('Location: ./error');
            exit();
        }
    }
}

$url = maxiter_detect_route_url();
$routes = new Routes();
$routes->routes($url); // Remove this line for PHP Legacy Versions and add the $url variable to the new Routes() above: $routes new Routes($url);
