<?php
require_once(CONNECTOR);
$data = file_get_contents("https://graph.facebook.com/225811101085640?fields=id,name,likes,personal_info,about,cover{source}&access_token=".FBTOKEN);
echo ($data);
?>
