<?php
require_once(CONNECTOR);
$limit = (empty($_GET['nb']))?3:$_GET['nb'];
$pgFB = (empty($_GET['pgFB']))?0:$_GET['pgFB'];
$pgDB = (empty($_GET['pgDB']))?0:$_GET['pgDB'];

$pgFB=0;
$pgDB=0;

if(empty($_GET['fbid'])){die(json_encode(['error'=>1]));}
//////////// INSERT COMMENTS ////////////////////
if(isset($_POST['set'])){
  if(strlen($_POST['set']) < 1000 && strlen($_POST['set']) > 0){
    $dbdata = $db->prepare("INSERT INTO artphotoscomments(photoid,message,created_time) VALUES(:id,:message,:time)");
    $d = ['id'=>$_GET['fbid'],
          'message'=>$_POST['set'],
          'time'=>date('Y-m-d H:i:s')];
    $dbdata->execute($d);
  }else{die(json_encode(['error'=>1]));}
  die();
}

@$fbdata = json_decode(file_get_contents("https://graph.facebook.com/".$_GET['fbid']."/comments?limit=".$limit."&offset=".$pgFB."&fields=message,id,created_time,from&access_token=".FBTOKEN)) or die(json_encode(['error'=>1]));
/*
echo '<h1>FROM FACEBOOK</h1><pre>';
var_dump($fbdata);
echo '</pre><br>';
*/
$dbdata = $db->prepare("SELECT id,message,created_time FROM artphotoscomments WHERE photoid=".$_GET['fbid']." ORDER BY created_time DESC LIMIT ".$limit." OFFSET ".$pgDB);
$dbdata->execute();
$dbdata = $dbdata->fetchAll(PDO::FETCH_CLASS);
/*
echo '<br><h1>FROM DATABASE</h1><pre>';
var_dump($dbdata);
echo '</pre><br>';
*/
function cb($a, $b) {
  return strtotime($a->created_time) - strtotime($b->created_time);
}
$j=0;$i=0;

while($j<sizeof($dbdata) && ($i<$limit)){
  if((!isset($fbdata->data[$i]) || cb($dbdata[$j],$fbdata->data[$i])>0 )){
    array_splice($fbdata->data,$i,0,array($dbdata[$j]));

    //echo "adding db[$j] to fb[$i]<br>";
    $j++;
  }
  $i++;
}
if(isset($fbdata->paging)){unset($fbdata->paging);}
$fbdata->data=array_slice($fbdata->data,0,$limit);
//echo "<h2>number from facebook=".(sizeof($fbdata->data)-$j)."  ////////  number from DataBase=$j</h2>";

$fbdata->next=$_GET['fbid']."&pgFB=".($pgFB+sizeof($fbdata->data)-$j)."&pgDB=".($pgDB+$j);
/*
echo("<a href=?".$fbdata->next." >next</a>");

echo '<br><h1>RESULT</h1><pre>';
var_dump($fbdata);
echo '</pre><br>';
*/
if(count($fbdata->data) <1){
  die(json_encode(['error'=>1]));
}
echo json_encode(['error'=>0,'data'=>$fbdata->data,'next'=>$fbdata->next]);
?>
