<?php
  require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>My Projects</title>
    <?php require_once(SERVERHEADPATH); ?>
  </head>
  <body class="loading" bgcolor="#1B1B1B">
    <?php require_once(SERVERMENUPATH); ?>
    <div id="mainContainer">
      <video id="liveBackground" style="display:none" preload="none" muted loop>
        <source src="/src/Design/projects.webm" type="video/webm">
        <source src="/src/Design/projects.mp4" type="video/mp4">
      </video>
      <link rel="stylesheet" href="projects.css">
      <script src="/js/loadingCircle.js"></script>
      <script src="/js/projectLoader.js"></script>
      <script src="projects.js"></script>
      <section id="HEAD">
        <div class="logo"></div>
        <div class="title">PROJECTS</div>
        <span class="counter"><span>0</span>PROJECTS</span>
      </section>
      <section id="PROJECTS">
      </section>
    </div>

<?php require_once(SERVERFOOTERPATH); ?>
