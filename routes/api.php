<?php
/*
Here is where you will configure all your API Routes,
follow the instructions in docs or just feel 
how it works and happy hacking!

@author Victor Béser
*/
// LoadModel
require __DIR__ . '/../app/models/LoadModel.php';

if (!isset($_SESSION['api-route']) || !is_array($_SESSION['api-route'])) {
    ResponseModel::json(false, "404 not found", 404);
}

$urlParsed = $_SESSION['api-route'];
unset($_SESSION['api-route']);

ApiModel::reset();
ApiModel::loadRoutesFromDirectory(__DIR__ . '/api');
ApiModel::dispatch($urlParsed);
