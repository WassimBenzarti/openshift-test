<?php
  require_once(CONNECTOR);
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
