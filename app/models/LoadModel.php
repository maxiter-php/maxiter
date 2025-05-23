<?php
/*
This is the LoadModel, where you will call for all your pages Models to use or general configurations.
Every Model will be used to do something, like EnvModel will use all env.ini informations in your project.
Don't forget, this file should be used in header of all controller files using "require".

@author Victor Béser
*/
session_start();

// Vendor Composer
require __DIR__ . "/../../vendor/autoload.php";

// Required Models
require __DIR__ . "/EnvModel.php";
require __DIR__ . "/DatabaseModel.php";
require __DIR__ . "/AuthModel.php";
require __DIR__ . "/LogModel.php";
require __DIR__ . "/ResponseModel.php";
require __DIR__ . "/PagesTitleModel.php";
require __DIR__ . "/CorsModel.php";
require __DIR__ . "/ApiModel.php";
require __DIR__ . "/TreatModel.php";
// Required Models

// Set the default timezone in env.ini file
date_default_timezone_set(EnvModel::env("DEFAULT_TIMEZONE"));

// Set CORS (change the CorsModel.php file to configure cors)
CorsModel::setCors();