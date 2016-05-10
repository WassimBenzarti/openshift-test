<?php
  require('connect.php');
  $limit = (empty($_GET['nb']))?20:$_GET['nb'];
  $page = (empty($_GET['pg']))?0:$_GET['pg'];
  $count = (isset($_GET['count']))?";SELECT COUNT(*) 'c' FROM projects":'';
  $res = $db->prepare("SELECT * FROM projects ORDER BY created_time DESC LIMIT :limit OFFSET :page ".$count);
  $res->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
  $res->bindValue(':page', (int) $page, PDO::PARAM_INT);
  $res->execute();
  $final['result'] = $res->fetchAll(PDO::FETCH_CLASS);
  if(isset($_GET['count'])){
    $res->nextRowset();
    $count = $res->fetchAll(PDO::FETCH_CLASS);

    $final['count']=$count[0]->c;
  }
  if(sizeof($final)<2){
    $final = $final['result'];
  }
  echo json_encode($final);
?>
