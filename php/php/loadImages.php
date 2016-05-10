<?php
require_once(CONNECTOR);
$limit = (empty($_GET['nb']))?1:$_GET['nb'];
$page = (empty($_GET['pg']))?0:$_GET['pg'];

$count= (isset($_GET['count']))?";SELECT COUNT(*) 'c' FROM artphotos":"";
$like= (isset($_GET['like']))?";SELECT SUM(likes) 'c' FROM artphotos":"";
$comment= (isset($_GET['comment']))?";SELECT COUNT(*) 'c' FROM artphotoscomments":"";

$res = $db->prepare("SELECT title,created_time,height,fbid id,images,color,link,status,width,blurry,likes,comments FROM artphotos ORDER BY created_time DESC LIMIT :limit OFFSET :page".$count.$like.$comment);
$res->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
$res->bindValue(':page', (int) $page, PDO::PARAM_INT);
$res->execute();
$final = $res->fetchAll(PDO::FETCH_CLASS);
$final = ['result'=>$final];
if(isset($_GET['count'])){
  $res->nextRowset();
  $count = $res->fetchAll(PDO::FETCH_CLASS);
  $final['count']=$count[0]->c;
}
if(isset($_GET['like'])){
  $res->nextRowset();
  $count = $res->fetchAll(PDO::FETCH_CLASS);
  $final['like']=$count[0]->c;
}
if(isset($_GET['comment'])){
  $res->nextRowset();
  $count = $res->fetchAll(PDO::FETCH_CLASS);
  $final['comment']=$count[0]->c;
}
if(sizeof($final)<2){
  $final = $final['result'];
}
echo json_encode($final);
?>
