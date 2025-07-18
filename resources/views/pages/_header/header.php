<?php require __DIR__."/../../../../app/models/LoadModel.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title id="page_title"></title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/images/favicon.ico">

    <!-- Main CSS -->
    <link href="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/css/style.css" rel="stylesheet">



</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->