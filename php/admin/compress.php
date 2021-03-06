<?php
require_once "../connect.php";
function output_image ( $image_file ) {
    header("Content-type: image/jpeg");
    header('Content-Length: ' . filesize($image_file));
    ob_clean();
    flush();
    readfile($image_file);
}

ini_set("memory_limit",-1);
if(isset($_GET['URL'])){
	
  $filename = SERVERROOTPATH."/".$_GET['URL'];
  $image;
  switch ( strtolower(explode("?",end(explode(".",$_GET['URL'])))[0]) ) {
      case 'jpeg':
          $image = imagecreatefromjpeg($filename);
      break;	
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

  imagejpeg($image,$tmpfname,15);

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
	
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . strlen($buffer));
	header("Content-Disposition: attachment; filename=image.jpg");

	/* Send our file... */
  echo $buffer;
}
ini_restore("memory_limit");
?>
