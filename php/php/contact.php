<?php
session_start();
if(isset($_SESSION['attempt']) && isset($_SESSION['fAttempt'])){
  if($_SESSION['attempt'] >= 3 && time()<$_SESSION['fAttempt']){
    die(json_encode(['error'=>-1,'msg'=>'Please comeback later']));
  }else{
    $_SESSION['attempt']++;
  }
}else{$_SESSION['attempt']=1;$_SESSION['fAttempt']=strtotime('+5 mins');}

$data['error']=0;
$rexSafety = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";
if (preg_match($rexSafety, $_POST['name'])) {
    $data['error']=1;
}
if(strlen($_POST['msg'])>1000 || strlen($_POST['msg'])<10 ){
  $data['error']=2;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  $data['error']=3;
}



echo json_encode($data);
?>
