<?php
ignore_user_abort(true);
define('databaseName','wassim');
define('SERVERROOTPATH',$_SERVER['DOCUMENT_ROOT']);
echo getenv("OPENSHIFT_DATA_DIR")."<br>";
echo getenv("OPENSHIFT_REPO_DIR")."<br>";
echo getenv("DOCUMENT_ROOT")."<br>";
define('SERVERMENUPATH',SERVERROOTPATH."/menu.php");
define('SERVERFOOTERPATH',SERVERROOTPATH."/footer.php");
define('SERVERHEADPATH',SERVERROOTPATH."/inc/common/head.php");
define('FBTOKEN',"CAAXnZBDdib2sBAI7NuQogPZCJUstQgTRQiVjoBSzZBZCwoBkY4kH7SdvlYRmxICWZCyO47SBAc5ZAU3xhpsjIO0oeWzP8ofledmrESFlWIrGcvDLWjcxjN2ZAEr93JAtJuEuuRseU2NQ7L7myspWLhrQuutBZBXR4oUY5l38tnXsschWHvgNY9B4Wwm80qnQzDIZD");
$db = new PDO("mysql:host=".getenv("OPENSHIFT_MYSQL_DB_HOST").":".getenv("OPENSHIFT_MYSQL_DB_PORT").";dbname=".databaseName,getenv("OPENSHIFT_MYSQL_DB_USERNAME"),getenv("OPENSHIFT_MYSQL_DB_PASSWORD"));
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>
