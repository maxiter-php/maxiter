<?php
/*

This is the Route system of your project.
Suggestion: DON'T CHANGE ANYTHING HERE.


@ author Victor Béser
*/
class Routes {

    public function routes($url) {
        $pageUrl = !empty($url) ? $url : "home";
        $part = explode('/', $pageUrl);
        $page = $part[0];

        $pagePath = __DIR__ . "/resources/views/pages/$page/$page.php";

        if (is_file($pagePath)) {
            include $pagePath;
        } else {
            header('Location: ./error');
            exit();
        }
    }
}

$url = isset($_GET['url']) ? htmlspecialchars(trim($_GET['url'])) : null;

$routes = new Routes();
$routes->routes($url);


