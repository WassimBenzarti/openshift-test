<?php
require 'connect.php';
session_start();
if(empty($_GET['id'])){die();}
$liked=(empty($_COOKIE['liked']))?"[]":$_COOKIE['liked'];
$liked = json_decode($liked);
if(!is_array($liked)){$liked=[];}
if(!in_array($_GET['id'],$liked)){
  $liked[count($liked)]=$_GET['id'];
  $dbdata = $db->prepare("UPDATE artphotos SET likes=likes+1 WHERE fbid=:id");
  $d=['id' => $_GET['id']];
  $dbdata->execute($d);
}else{
  $liked=array_diff($liked,[$_GET['id']]);
}
setcookie('liked',json_encode($liked),strtotime('+20 years'),'/');
?>
