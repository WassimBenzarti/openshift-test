<?php
require_once(CONNECTOR);
if(isset($_GET['skills'])){
  $res = $db->prepare("SELECT s.name,s.val,f.fieldname 'field' FROM skills s, skillfields f WHERE f.fieldname=s.field ORDER BY f.val DESC, s.val DESC");
  $res->execute();
  $skills = $res->fetchAll(PDO::FETCH_CLASS);
  echo json_encode($skills);
}
if(isset($_GET['timeline'])){
  $res = $db->prepare("SELECT date,title,story FROM timeline");
  $res->execute();
  $timeline = $res->fetchAll(PDO::FETCH_CLASS);
  echo json_encode($timeline);
}
if(isset($_GET['clients'])){
  $res = $db->prepare("SELECT * FROM clients");
  $res->execute();
  //var_dump($res);
  $cls = $res->fetchAll(PDO::FETCH_CLASS);
  echo json_encode($cls);
}
if(isset($_GET['contact'])){
  $res = $db->prepare("SELECT * FROM contact ORDER BY type DESC");
  $res->execute();
  //var_dump($res);
  $cls = $res->fetchAll(PDO::FETCH_CLASS);
  echo json_encode($cls);
}
?>
