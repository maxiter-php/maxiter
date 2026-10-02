<?php
/*
Main application bootstrap entrypoint for Maxiter.

@author Victor Beser
*/

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/request.php';

$autoloadPath = maxiter_project_path('vendor/autoload.php');
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

maxiter_start_session(maxiter_project_root());

require_once __DIR__ . '/models.php';
require_once __DIR__ . '/runtime.php';

maxiter_bootstrap_runtime();
