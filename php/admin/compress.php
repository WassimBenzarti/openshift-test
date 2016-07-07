<?php
require_once "../connect.php";
function output_image ( $image_file ) {
    header("Content-type: image/jpeg");
    header('Content-Length: ' . filesize($image_file));
    ob_clean();
    flush();
    readfile($image_file);
}


if(isset($_GET['URL'])){
  $filename = SERVERROOTPATH.$_GET['URL'];
  $image;
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
  $tmpfname = tempnam(SERVERDATAPATH, 'FOO');

  imagejpeg($image,$tmpfname,50);

  //output_image($tmpfname);
  $buffer = file_get_contents($tmpfname,FILE_USE_INCLUDE_PATH);

  /* Force download dialog... */
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");

  /* Don't allow caching... */
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	/* Set data type, size and filename */
	header("Content-Type: application/octet-stream");
  // header("Content-Type: jpeg");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . strlen($buffer));
	header("Content-Disposition: attachment; filename=$tmpfname");

	/* Send our file... */
  echo $buffer
}

?>
