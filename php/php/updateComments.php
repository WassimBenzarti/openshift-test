<?php
require 'connect.php';

$req=json_decode(file_get_contents("https://graph.facebook.com/355698711291842/photos/uploaded?fields=comments.limit(0).summary(true),id&limit(25)&access_token=".FBTOKEN));
$query="UPDATE artphotos SET comments =
  CASE";
for($i=0;$i<count($req->data);$i++){
  $query.="
   WHEN (fbid=".$req->data[$i]->id.") THEN ".$req->data[$i]->comments->summary->total_count;

}
$query.=" END";

$data = $db->prepare($query);
$data->execute();

?>
