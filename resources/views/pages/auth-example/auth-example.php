<!-- 
This is your new page, it's already routed in Maxiter application
and everything you need is included here.
Happy Coding!

@author Victor Béser
-->
<?php include __DIR__ . "/../_header/header.php"; ?>

<!-- 
Unauthorized example, this will redirect to 
the home page if user has no "administrator" or 
"manager" role after login in UsersController 
 
Use the AuthModel::verify(null, ["role"]) to
not redirect the user, like giving some 
especific view permission or let all null
to check if the user is logged only;
 -->
<?php AuthModel::verify("home", array("administrator", "manager")); ?>

<!-- Page Title -->
<?php PagesTitleModel::title("Maxiter - Auth-example"); ?>
<link rel="stylesheet" href="<?php echo EnvModel::env("APP_BASE_URL") ?>/resources/views/pages/auth-example/css/auth-example.css">
<!--**********************************
        Main wrapper start
***********************************-->
<div id="main-wrapper">

    <!-- NAVBAR -->
    <?php include __DIR__ . "/../_navbar/navbar.php"; ?>
    <!-- NAVBAR -->

    <!-- SIDEBAR -->
    <?php include __DIR__ . "/../_sidenav/sidenav.php"; ?>
    <!-- SIDEBAR -->

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">

            <!-- CARDS -->
            <?php include __DIR__ . "/../_cards/cards.php"; ?>
            <!-- CARDS -->

            <div class="row">
                <div class="col-xl-12 col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo EnvModel::env("APP_NAME") ?> - Auth-example</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div style="text-align:justify;" class="col-xl-12 col-lg-8">
                                    <!-- CODE HERE HERE -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!--**********************************
            Content body end
        ***********************************-->

</div>
<!--**********************************
        Main wrapper end
    ***********************************-->

<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/pages/auth-example/js/auth-example.js"></script>
<?php include __DIR__ . "/../_footer/footer.php"; ?>