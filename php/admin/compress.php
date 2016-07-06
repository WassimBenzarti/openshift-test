<?php

if(isset($_GET['URL'])){
  $filename = $_GET['URL'];
  echo  ( strtolower(explode("?",end(explode(".",$filename)))[0]) );
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

  imagejpeg($image,$tmpfname,50);
  $buffer = file_get_contents($tmpfname);
  /* Force download dialog... */
	// header("Content-Type: application/force-download");
	// header("Content-Type: application/octet-stream");
	// header("Content-Type: application/download");

  /* Don't allow caching... */
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	/* Set data type, size and filename */
	//header("Content-Type: application/octet-stream");
  //header("Content-Type: image/jpeg");
	// header("Content-Transfer-Encoding: binary");
	// header("Content-Length: " . strlen($buffer));
	// header("Content-Disposition: attachment; filename=$tmpfname");

	/* Send our file... */
	echo $buffer;
}

?>
