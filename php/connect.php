<?php
ignore_user_abort(true);
define('databaseName','wassim');
define('databaseData',array(
        'url' => $_SERVER["OPENSHIFT_MYSQL_DB_HOST"],
        'port' => $_SERVER["OPENSHIFT_MYSQL_DB_PORT"],
        'user' => $_SERVER["OPENSHIFT_MYSQL_DB_USERNAME"],
        'pass' => $_SERVER["OPENSHIFT_MYSQL_DB_PASSWORD"]
));
echo var_dump(databaseData['url']);
define('SERVERROOTPATH',dirname(dirname(__FILE__)));
define('SERVERMENUPATH',SERVERROOTPATH."/menu.php");
define('SERVERFOOTERPATH',SERVERROOTPATH."/footer.php");
define('SERVERHEADPATH',SERVERROOTPATH."/inc/common/head.php");
define('FBTOKEN',"CAAXnZBDdib2sBAI7NuQogPZCJUstQgTRQiVjoBSzZBZCwoBkY4kH7SdvlYRmxICWZCyO47SBAc5ZAU3xhpsjIO0oeWzP8ofledmrESFlWIrGcvDLWjcxjN2ZAEr93JAtJuEuuRseU2NQ7L7myspWLhrQuutBZBXR4oUY5l38tnXsschWHvgNY9B4Wwm80qnQzDIZD");
$db = new PDO('mysql:host=127.13.162.130:3306;dbname='.databaseName,'adminpjV2Bj9','TdeU3Y7mtfQH');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

?>
