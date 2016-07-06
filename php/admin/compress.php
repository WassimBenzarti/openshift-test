<?php

if(isset($_GET['URL'])){
  $filename = $_GET['URL'];
  switch ( strtolower(explode("?",end(explode(".",$filename)))[0]) ) {
      case 'jpeg':
          $image = imagecreatefromjpeg($filename);
      case 'jpg':
          $image = imagecreatefromjpeg($filename);
      break;
      case 'png':
          $image = imagecreatefrompng($filename);
      break;
      case 'gif':
        $image = imagecreatefromgif($filename);
      break;
  }
  $tmpfname = tempnam(getenv('OPENSHIFT_TMP_DIR'), 'FOO');
  die($tmpfname);
  imagejpeg($image,$tmpfname,75)

}

?>
