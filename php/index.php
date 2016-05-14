<?php
//define('SERVERROOTPATH',);
//echo $_SERVER['DOCUMENT_ROOT'];
//echo SERVERROOTPATH;

echo (empty(getenv("OPENSHIFT_REPO_DIR")) ? $_SERVER['DOCUMENT_ROOT'] : getenv("OPENSHIFT_REPO_DIR"));
?>
