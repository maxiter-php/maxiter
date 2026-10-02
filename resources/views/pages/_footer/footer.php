<script>

                            // Page Title Definition 

                            document.querySelector('#page_title').innerHTML = <?php echo json_encode(PagesTitleModel::getTitle()); ?>

                        </script>
  <footer>
    <span>MAXITER</span>
    <span>PHP FRAMEWORK</span>
  </footer>

  <script src="<?php echo EnvModel::env("APP_BASE_URL") ?>resources/views/./assets/js/script.js"></script>
</body>
</html>
