<?php
/*
Legacy compatibility bridge for the centralized Maxiter bootstrap.
New runtime initialization now lives in /bootstrap/app.php.

@author Victor Béser
*/

require_once dirname(dirname(__DIR__)) . '/bootstrap/app.php';
