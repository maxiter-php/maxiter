<?php include __DIR__ . '/../_header/header.php'; ?>

<!-- Page Title -->

<?php PagesTitleModel::title('Maxiter - Home Page'); ?>

<link rel='stylesheet' href='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/home/css/home.css'>

<body>
  <div class="grid"></div>
  <div class="glow" id="glow"></div>

  <header>
    <a class="brand" href="#" aria-label="Maxiter">
      <img src="<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/assets/maxiter-logo.png" alt="">
      <strong>MAXITER</strong>
    </a>
    <span class="status"><i></i> project ready</span>
  </header>

  <main>
    <section class="welcome">
      <div class="mark">
        <img src="<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/assets/maxiter-logo.png" alt="Maxiter">
      </div>

      <p class="eyebrow">MAXITER / PHP FRAMEWORK</p>
      <h1>It works.</h1>
      
      <p class="lead">
        Your Maxiter project is ready.<br>
        Now build something amazing. 
      </p>

      <div class="actions">
        <a
          class="primary"
          href="https://maxiter-docs.vercel.app/"
          target="_blank"
          rel="noreferrer"
        >
          Documentations <span>↗</span>
        </a>

        <a
          class="secondary"
          href="https://github.com/maxiter-php/maxiter"
          target="_blank"
          rel="noreferrer"
        >
          GitHub
        </a>
      </div>

      <div class="terminal" aria-label="Project information">
        <div class="terminal-top">
          <span></span>
          <span></span>
          <span></span>
          <b>maxiter</b>
        </div>
        
        <div class="terminal-body">
          <span class="prompt">❯</span>
          <span>application status</span>
          <strong>READY</strong>
          <i class="cursor"></i>
        </div>
      </div>
    </section>
  </main>

<script src='<?php echo EnvModel::env('APP_BASE_URL') ?>resources/views/pages/home/js/home.js'></script>

<?php include __DIR__ . '/../_footer/footer.php'; ?>