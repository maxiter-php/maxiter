<!--**********************************
            Footer start
        ***********************************-->
<?php

// LOG TO GET WHICH PAGE USER IS ACCESSING
// $uri = $_SERVER['REQUEST_URI'];
// $uri = parse_url($uri, PHP_URL_PATH); 

// $segments = explode('/', trim($uri, '/')); 
// $lastSegment = end($segments);

// LogModel::log("Acess in page: $lastSegment");

?>


<script>
    // Page Title Definition
    document.querySelector("#page_title").innerHTML = <?php echo json_encode(PagesTitleModel::getTitle()); ?>
</script>

<div class="footer">
    <div class="copyright">
        <p><strong>Maxiter</strong> | Copyright © Designed &amp; Developed by <a href="https://quinzeconto.com.br/" target="_blank">QuinzeConto</a></p>
    </div>
</div>
<!--**********************************
            Footer end
        ***********************************-->

<!--**********************************
        Scripts
    ***********************************-->

<!-- PATH JS -->
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>path.js"></script>

<!-- Cards JS -->
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/js/cards.js"></script>

<!-- Navbar JS -->
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/pages/_navbar/js/navbar.js"></script>

<!-- Required vendors -->
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/vendor/global/global.min.js"></script>
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/js/quixnav-init.js"></script>
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/js/custom.min.js"></script>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SWAL FUNCTION JS -->
<script src="<?php echo EnvModel::env("APP_BASE_URL") ?>swal.js"></script>

<!-- JS XLSX -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
    integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>