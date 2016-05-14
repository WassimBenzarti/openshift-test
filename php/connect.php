<?php
ignore_user_abort(true);
define('SERVERROOTPATH',(getenv("OPENSHIFT_REPO_DIR")==false) ? $_SERVER['DOCUMENT_ROOT'] : getenv("OPENSHIFT_REPO_DIR")."php");

define('SERVERDATAPATH',(getenv("OPENSHIFT_DATA_DIR")==false) ? $_SERVER['DOCUMENT_ROOT']."src" : SERVERROOTPATH."/src");
define('SERVERMENUPATH',SERVERROOTPATH."/menu.php");
define('SERVERFOOTERPATH',SERVERROOTPATH."/footer.php");
define('SERVERHEADPATH',SERVERROOTPATH."/head.php");
define('FBTOKEN',"EAAEPz5DjZAhUBANRkWM5qhdzV6mppteUPd57upnpsVEMbvZCp4302MsER7u18DePlF9jl76YZB3NOHUbA7WjLMWRoPU6CRKjRbUanV0szIgX8LI9MHrbj2S3XZCdiRTxjVDTQQBkZBXXQwFq4mzDI65skXPPm8LTsEch7KuA61AZDZD");
$db_host = getenv("OPENSHIFT_MYSQL_DB_HOST");
$db_port = getenv("OPENSHIFT_MYSQL_DB_PORT");
$db_name = 'wassim';
$db_user = getenv("OPENSHIFT_MYSQL_DB_USERNAME");
$db_pass = getenv("OPENSHIFT_MYSQL_DB_PASSWORD");
$db = new PDO("mysql:host=".$db_host.":".$db_port.";dbname=".$db_name,$db_user,$db_pass);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
?>
