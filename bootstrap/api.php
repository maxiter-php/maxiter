<?php
/*
Centralized API bootstrap and dispatcher for Maxiter.

@author Victor Beser
*/

require_once __DIR__ . '/app.php';

$urlParsed = maxiter_resolve_api_route();

if ($urlParsed === null) {
    ResponseModel::json(false, "404 not found", 404);
}

if (isset($_SESSION['api-route'])) {
    unset($_SESSION['api-route']);
}

ApiModel::reset();

$apiRoutesFile = maxiter_project_path('routes/api.php');
if (!file_exists($apiRoutesFile)) {
    ResponseModel::json(false, "API routes file not found", 500);
}

require $apiRoutesFile;

ApiModel::dispatch($urlParsed);
