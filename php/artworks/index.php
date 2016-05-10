<?php
  require_once("../php/connect.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>My Artworks</title>
    <?php require_once(SERVERHEADPATH); ?>
  </head>
  <body class="loading" bgcolor="#1B1B1B">
    <?php require_once(SERVERMENUPATH); ?>
    <div id="mainContainer">
      <link rel="stylesheet" href="artworks.css">
      <script src="/js/loadingCircle.js"></script>
      <script src="artworks.js"></script>
      <section id="HEAD">
        <div class="logo"></div>
        <div class="titleAnim"></div>
      </section>
      <section id="GALLERY">
        <div id="counters" class="onScroll">
          <div class="timeLine"></div>
          <span class="likes">0<span>Likes</span></span>
          <span class="images">0<span>Images</span></span>
          <span class="comments">0<span>Comments</span></span>
        </div>
        <div id="firewall" class="onScroll load" data-nb=9 data-pg=0></div>
      </section>
    </div>

<?php require_once(SERVERFOOTERPATH); ?>
