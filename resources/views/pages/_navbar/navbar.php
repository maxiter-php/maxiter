<!--**********************************
            Nav header start
        ***********************************-->
<div class="nav-header">
    <a href="../index/" class="brand-logo">
        <!-- <img class="logo-abbr" src="../../images/logo.png" alt="">
        <img class="logo-compact" src="../../images/logo-text.png" alt="">
        <img class="brand-title" src="../../images/logo-text.png" alt=""> -->
        <h4 style="color:white;"><?= EnvModel::env("APP_NAME") ?></h4>
        <!-- <h4 class="logo-compact" style="color:white;">CGRS</h4> -->
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
            Nav header end
        ***********************************-->

<!--**********************************
            Header start
        ***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                            <i class="mdi mdi-magnify"></i>
                        </span>
                        <div class="dropdown-menu p-0 m-0">
                            <form>
                               
                                <!-- <h2>TESTE</h2> -->
                                <input class="form-control" type="search" placeholder="Search..."
                                    aria-label="Search">
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <div class="pulse-css"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-unstyled">
                                <li class="media dropdown-item">
                                    <span class="success"><i class="ti-user"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Martin</strong> has added a <strong>customer</strong>
                                                Successfully
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-shopping-cart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="danger"><i class="ti-bookmark"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-heart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="success"><i class="ti-image"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong> James.</strong> has added a<strong>customer</strong>
                                                Successfully
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                            </ul>
                            <a class="all-notification" href="#">See all notifications <i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </li>
                    <a href="./login">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                <i class="mdi mdi-account"></i>
                            </a>


                            <!-- A classic way to Authenticate users with Maxiter example -->
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if (AuthModel::verify()): ?>
                                    <a href="./home" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2"><?= AuthModel::getContext("username"); ?> </span>
                                    </a>
                                    <a href="#" id="btn-logout" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                <?php else: ?>
                                    <a href="./login" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Login Page </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </a>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!--**********************************
            Header end ti-comment-alt
        ***********************************-->