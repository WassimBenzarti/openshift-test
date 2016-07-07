<?php
  if(!isset($argv[1]) || !$argv[1]=="cronjob" || !isset($argv[1]) || !$argv[1]=="upload"){die();}
  echo "working...";
  require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
  $old = $db->prepare("UPDATE facebookpics SET done = 1, posted = 1 WHERE id = :id");

  date_default_timezone_set('Africa/Tunis');
  $date = date("Y-m-d H:i:s");
  $date2 = date("Y-m-d H:i:s", strtotime(' -1 day'));
  $get = $db->prepare("SELECT * FROM facebookpics WHERE date BETWEEN '$date2' AND '$date' AND done = 0 AND posted=0 LIMIT 1");
  $get->execute();
  $img = $get->fetchAll();
  ini_set("memory_limit",-1);
  define('UTOKEN','access_token=EAAPOFeYQ0EcBANBbWXegV957pKywE8FSykreknTxxMBCTARXPoCq3f11GNzY8T3JgETZCC5qWPZCvuYrm5nDUsadJBLrVFRNDZAFZA5QwFJZAcDyVDgiKQfHYMZAMyocW0QldKJBcbVZABQMe5huUzINC3gMlygM5gZD');
  define('testUTOKEN','access_token=EAAG9k5MGFPYBAEqt0joNXxAllDiOXV2YmGWCPZAiMmNIezsWjZCORcGqroUOvmuHlNJwyKQimJTeJYPZCZC6iYWcmFT1ayCr31qZAb4bNxu5LXSCQLJKRaVk1MtDGVLnnenfBwLGC6IUGDA63eSrCVIe857b2DdwZD');
  define('PTOKEN','access_token=EAAPOFeYQ0EcBAC2VB4yqvpGrtn1Ehj3roj4DtNqJ3VIFvhZBeJBc5GrQaE8x4x1TxvHAxZCXJZAZCToMAQS6gPoWXTXZBaKfepYFVMZAON4AqZBlMiYG29On3eLIZACh90JyLU6M2SKqKkiUefmrSRGim43HvPyEBDA9zZCoc1xgcBQZDZD');
  define('testPTOKEN','access_token=EAAXnZBDdib2sBAFcwEZAozOKZCaUEZBQoAviQIODZCfplFgB1pcjuTRSYOzbzwfnoZBYr7HZCgP3lJdzOYTXM0WEqeF5Om4hu5xstjch2wl5yez1Nko58fAsJLAl0HxeHKswut0F9dJe2oCrkUEWzaDZBO3Wv8aogV6iAjqolQe2ggZDZD');
  function share($img,$url,$image,$old){

    if(!isset($img[0]['caption'])){$caption = "";}else{
        $caption = $img[0]['caption'];
      }
    echo $caption;
    $data = array('caption' => $caption, 'url' =>$image);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    echo "<pre>";
    echo var_dump($img);
    echo "<pre>";
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $succ = ($result !== FALSE);
    echo "<br>URL = ".$image;
    if($result !== FALSE){
      $result = json_decode($result);
      $old->execute(['id' => $img[0]['id']]);
      echo "<br>SUCCESS : ".$result->id;
    }else{
      echo "<br>ERROR : ".var_dump($result);
    }

    return ['success'=>$succ,'result'=>$result];
  }
  if( sizeof($img) >0){

    $res = share($img,"https://graph.facebook.com/me/photos?".PTOKEN,"https://wassim-benzarti.rhcloud.com".$img[0]['url'],$old);
    $img[0]['caption'] .= "

    Welcome to other side of the world : https://www.fb.com/art.daydream/";
    $res = share($img,"https://graph.facebook.com/me/photos?".UTOKEN,"https://wassim-benzarti.rhcloud.com".$img[0]['url'],$old);
    die();
  }else{
    echo "NOTHING in here\n";
    echo $date." ######## ".$date2;
  }
  ini_restore("memory_limit");
  ?>
