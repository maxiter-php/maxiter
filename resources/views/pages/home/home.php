<?php include __DIR__ . "/../_header/header.php"; ?>

<!-- Page Title -->
<?php PagesTitleModel::title("Maxiter - Home Page"); ?>
<link rel="stylesheet" href="./resources/views/pages/home/css/home.css">

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
                            <h4 class="card-title"><?= EnvModel::env("APP_NAME") ?> -
                                <?= EnvModel::env("APP_DESCRIPTION") ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div style="text-align:justify;" class="col-xl-12 col-lg-8">
                                    <!-- CODE HERE HERE -->
                                    <p> Maxiter is an intuitive PHP framework designed for seamless platform
                                        development, allowing you to build robust applications with remarkable
                                        efficiency. Whether you are a seasoned developer or just embarking on your
                                        coding journey, Maxiter provides a straightforward yet powerful foundation for
                                        your projects. </p>
                                    <p> To facilitate your development process, we've included a basic template to
                                        kickstart your work. However, we encourage you to explore your creativity by
                                        customizing this template or even creating a new one from scratch. The
                                        flexibility offered by Maxiter empowers you to tailor the user experience to
                                        your specific needs, ensuring that your platform stands out. </p>
                                    <p> To modify an existing template or create a new one, navigate to the
                                        <strong>resources/views/</strong> directory. This is where the magic begins.
                                        Inside this folder, you will find the <strong>pages/</strong> subdirectory,
                                        which is crucial for your project’s structure. It is essential to organize your
                                        content effectively to take full advantage of our streamlined routing system.
                                    </p>
                                    <p> For optimal organization, ensure that all your view files are placed within the
                                        <strong>resources/views/pages/</strong> folder. The naming convention we
                                        recommend follows the structure of
                                        <strong>/pages/{pageName}/{pageName}.php</strong>. For instance, if you are
                                        developing a homepage, it should be located at
                                        <strong>/pages/home/home.php</strong>. Similarly, for a login page, use
                                        <strong>/pages/login/login.php</strong>. Adhering to this format allows our
                                        routing system to seamlessly recognize and manage your views.
                                    </p>
                                    <p> As you delve into your project, consider the various elements that will enhance
                                        user engagement and functionality. From integrating responsive design principles
                                        to implementing dynamic features, the possibilities are endless. Maxiter is
                                        equipped with the tools you need to create a modern, user-friendly interface
                                        that captivates your audience. </p>
                                    <p> We encourage you to explore the extensive documentation provided with Maxiter,
                                        which covers best practices, advanced features, and additional resources to
                                        elevate your development skills. Your journey with Maxiter promises to be
                                        rewarding, and we look forward to seeing the innovative solutions you create.
                                    </p>
                                    <p> In conclusion, Maxiter is not just a framework; it is a canvas for your ideas.
                                        Embrace the opportunity to craft unique and powerful applications that meet the
                                        demands of today's users. Happy coding! </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-6 col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Something Else?</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-8">
                                    <!-- CODE HERE HERE -->
                                    <p>Let us show you a little bit about the files of Maxiter:</p>

                                    <p>
                                        <strong>/src/tables/</strong> you will find some SQL example for this
                                        template.

                                    </p>
                                    <p>
                                        <strong>app/controllers/</strong> you will find all the controllers
                                        of the Maxiter.

                                    </p>
                                    <p>
                                        <strong>app/models/</strong> you will find all the models
                                        of the Maxiter.
                                    </p>
                                    <p>
                                        <strong>.htaccess</strong> you will find all the htaccess configurations for
                                        routing.

                                    </p>
                                    <p>
                                        <strong>env.ini</strong> you will find all the environment variables
                                        of the Maxiter.

                                    </p>
                                    <p>
                                        <strong>./index.php</strong> you will find all the route configurations for
                                        redirecting pages.

                                    </p>
                                    <p>
                                        Okay that's it! Don't forget to rename change all (dot) for a real dot, like
                                        <strong>.</strong>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-6 col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">IUFD</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-8">
                                    <!-- CODE HERE HERE -->
                                    <p>
                                        This template uses the <strong>Included Underscore File Divisor</strong> (or
                                        just <strong>IUFD</strong> ) method, what is marked by using a underscore (_)
                                        before a folder to
                                        symbolize that some file could be included using the <strong>include</strong>
                                        method of PHP as a
                                        <strong>component</strong> of your application.
                                    </p>
                                    <p>
                                        This simple way to componentize your application facilitate to create new
                                        components and use them without any problems. Also it will help you to view in a
                                        good way your components.
                                    </p>

                                    <p>
                                        And if you have any trubles using Maxiter please try out the
                                        <strong>documentation</strong> by <a href="#">clicking here</a>.
                                    </p>
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

<script src="./resources/views/pages/home/js/home.js"></script>
<?php include __DIR__ . "/../_footer/footer.php"; ?>