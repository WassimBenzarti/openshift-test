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
      <link rel="stylesheet" href="about.css">
      <script src="/js/loadingCircle.js"></script>
      <script src="/js/progressbar.js"></script>
      <script src="about.js"></script>
      <section id="HEAD">
        <div class="logo"></div>
      </section>
      <img id="pagePic" class="onScroll load">
      <section id="ABOUT">
        <div id="info">
          <h4>Hi, I'm</h4>
          <h2 class="name">Wassim</h2>
          <h2 class="lastName">Benzarti</h2>
          <span class="dots"></span>
          <h4 class="job">Developer & Digital Designer</h4>
          <span class="dots"></span>
          <h4 class="speech"></h4>
          <script>$("#ABOUT").find(".age").html(parseInt(timeAgo('12/11/1996'))+' Years')</script>

        </div>
        <h2 class="subtitle">Skills</h2>
        <div id="skills"></div>
        <h2 class="subtitle">The Story of my life</h2>
        <div id="timeline" class="onScroll Sfade load"><div class="line"></div></div>
        <h2 class="subtitle">Clients</h2>
        <div id="clients"></div>
        <h2 class="subtitle">Hey, Hire me !</h2>
        <h4>And you decide the price :) </h4>
        <h5 class="button hireMe"><span>Hire Me<span></h5><br>
        <h4 class="quote">Dude. Anyone can say they are a good developper & designer<br>I know.<br>
          Therefore let me show you a few of my previous projects</h4>
        <a href="/projects" class="button"><span>See my recent projects<span></a><br>
      </section>
    </div>

<?php require_once(SERVERFOOTERPATH); ?>
