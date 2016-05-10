<?php
require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
$data = file_get_contents("https://graph.facebook.com/225811101085640?fields=id,name,likes,personal_info,about,cover{source}&access_token=".FBTOKEN);
echo ($data);
?>
