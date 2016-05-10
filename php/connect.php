<?php
ignore_user_abort(true);
define('databaseName','wassim');
define('SERVERROOTPATH',getenv("OPENSHIFT_REPO_DIR")."php");
define('SERVERDATAPATH',getenv("OPENSHIFT_DATA_DIR"));
define('SERVERMENUPATH',SERVERROOTPATH."/menu.php");
define('SERVERFOOTERPATH',SERVERROOTPATH."/footer.php");
define('SERVERHEADPATH',SERVERROOTPATH."/inc/common/head.php");
define('FBTOKEN',"EAAEPz5DjZAhUBANRkWM5qhdzV6mppteUPd57upnpsVEMbvZCp4302MsER7u18DePlF9jl76YZB3NOHUbA7WjLMWRoPU6CRKjRbUanV0szIgX8LI9MHrbj2S3XZCdiRTxjVDTQQBkZBXXQwFq4mzDI65skXPPm8LTsEch7KuA61AZDZD");
$db = new PDO("mysql:host=".getenv("OPENSHIFT_MYSQL_DB_HOST").":".getenv("OPENSHIFT_MYSQL_DB_PORT").";dbname=".databaseName,getenv("OPENSHIFT_MYSQL_DB_USERNAME"),getenv("OPENSHIFT_MYSQL_DB_PASSWORD"));
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>
