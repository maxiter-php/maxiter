<?php

$projectRoot = dirname(dirname(__DIR__));

$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH);

if ($requestPath === false || $requestPath === null) {
    $requestPath = '/';
}

$requestPath = rawurldecode($requestPath);
$filePath = $projectRoot . str_replace('/', DIRECTORY_SEPARATOR, $requestPath);
$blockedFiles = array('/env.ini', '/.env', '/.env-example', '/.env.example');

if (in_array(strtolower($requestPath), $blockedFiles, true)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

if ($requestPath !== '/' && is_file($filePath)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $projectRoot . DIRECTORY_SEPARATOR . 'index.php';

$routePath = trim($requestPath, '/');

if ($routePath !== '') {
    $_GET['url'] = $routePath;
} else {
    unset($_GET['url']);
}

require $projectRoot . DIRECTORY_SEPARATOR . 'index.php';
