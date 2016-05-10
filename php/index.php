<?php
  require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CoDesign</title>
    <?php require_once(SERVERHEADPATH); ?>
  </head>

  <body id="body" class="loading" bgcolor="#1B1B1B">
    <?php require_once(SERVERMENUPATH); ?>
    <div id="mainContainer">
      <link rel="stylesheet" href="css/index.css" charset="utf-8">
      <script src="/js/firewall.min.js"></script>
      <script src="/js/imageLoader.js"></script>
      <script src="/js/soundcloud.js"></script>
      <script src="/js/projectLoader.js"></script>
      <script src="/js/loadingCircle.js"></script>
      <script src="/js/index.js"></script>

      <section class="section1">
        <video id="liveBackground" style="display:none" preload="none" muted loop>
          <source src="/src/Design/main-video.webm" type="video/webm">
          <source src="/src/Design/main-video.mp4" type="video/mp4">
        </video>
        <div class="logo"></div>
        <center>
          <div class="titleLogo"></div>
          <h2>&nbsp;WHEN CODE & DESIGN MEET TOGETHER</h2>
        </center>
      </section>
      <section class="section2">
      </section>
      <section class="section3">
        <h1>SOME OF MY ARTWORKS</h1>
        <div id="firewallContainer" class="freewall"> </div>
        <div data-number=9 class="loadMoreBtn">
          <span onclick="artImages.loadMoreClick(this)">
            MORE
          </span>
        </div>
      </section>
      <section class="section4">
        <h1>SOME OF THE MUSIC I LIKE</h1>
        <div id="musicList" class="freewall">

        </div>
        <div class="loadMoreBtn">
          <span onclick="SC.getTracks(true)">
            MORE
          </span>
        </div>
      </section>
      <section class="PROJECTS">
        <h1>PROJECTS I MADE</h1>
        <div id="projectList">

        </div>
        <a href="/projects/" class="link">SEE MORE OF MY PROJECTS</a>
      </section>
    </div>

<?php require_once(SERVERFOOTERPATH); ?>
