<?php require __DIR__ . "/../../../../app/models/LoadModel.php"; ?>
<?php PagesTitleModel::title("Maxiter - Login Page"); ?>
<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo PagesTitleModel::getTitle() ?></title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/images/favicon.png">
    <link href="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Login Page</h4>
                                    <form id="login-form">
                                        <div class="form-group">
                                            <label><strong>User</strong></label>
                                            <input required name="user" type="text" class="form-control"
                                                placeholder="Your user...">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input required name="password" type="password" class="form-control"
                                                placeholder="Your passoword...">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- PATH JS -->
    <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>path.js"></script>
    
    <!-- Required vendors -->
    <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/vendor/global/global.min.js"></script>
    <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/js/quixnav-init.js"></script>
    <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/js/custom.min.js"></script>
    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/pages/login/js/login.js"></script>
</body>

</html>