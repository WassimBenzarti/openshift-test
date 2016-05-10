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
      <script src="/js/loadingCircle.js"></script>
      <link rel="stylesheet" href="contact.css">
      <script src="contact.js"></script>
      <section id="HEAD">
        <div class="logo"></div>
      </section>
      <section id="CONTACT">
        <form onsubmit="return validate(this);">
          <div id="phrase" class="prev"><h2>If you have an interesting project, or just need some help, feel free to mail me. I’m available lately.</h2></div>
          <div id="question" data-nb="0" class="now">
            <div class="textbox"><h2>What's your name ?</h2><input autocomplete=off name=name onkeyup="focusTextBoxKey(this,event)" onfocus="focusTextBox(this,true)" onblur="focusTextBox(this,false)" type="text"></div>
          </div>
          <div id="question" data-nb="1" class="next">
            <div class="textbox"><h2>What do you want to tell me ?</h2><textarea name=msg onfocus="focusTextBox(this,true)" onblur="focusTextBox(this,false)" type="text"></textarea></div>
          </div>
          <div id="phrase" class="prev"><h2>If you have an interesting project, or just need some help, feel free to mail me. I’m available lately.</h2></div>
          <div id="question" data-nb="2">
            <div class="textbox"><h2>What's your email ?</h2><input autocomplete=off name=email onkeyup="focusTextBoxKey(this,event)" onfocus="focusTextBox(this,true)" onblur="focusTextBox(this,false)" type="text"></div>
          </div>
          <div id="button">
            <input type="submit" value="Send">
            <svg height="100" width="100">
              <circle cx="50" cy="50" r="20" stroke="black" stroke-width="3" fill="none"></circle>
              <polyline x="50" y="50" points="30,35 50,60 80,20" stroke="green" fill="none" stroke-width="3"></polyline>
              <path d="M30 30 L80 80 M80 30 L30 80" stroke="red" stroke-width="3"></path>
            </svg>
          </div>
        </form>
        <div id="pageDot"></div>
        <div id="contactInfo">
        </div>
      </section>
    </div>
<?php require_once(SERVERFOOTERPATH); ?>
