<?php
  if(!isset($argv[1]) || !$argv[1]=="cronjob" || !isset($argv[1]) || !$argv[1]=="upload"){die();}
  require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
  $old = $db->prepare("UPDATE facebookpics SET done = 1 WHERE id = :id");

  date_default_timezone_set('Africa/Tunis');
  $date = date("Y-m-d H:i:s");
  $date2 = date("Y-m-d H:i:s", strtotime(' -1 day'));
  $get = $db->prepare("SELECT * FROM facebookpics WHERE date BETWEEN '$date2' AND '$date' AND done = 0 LIMIT 1");
  $get->execute();
  $img = $get->fetchAll();
  echo "<pre>";
  var_dump($img);
  echo "</pre>";
  ini_set("memory_limit",-1);
  define('UTOKEN','access_token=EAACoSoJeH3wBAAJpxTzTyZAFpGrktOaE6C37QfpzINj0kbDZCuocLhfJdpXet0YomQ5xQqWefBgDoAK1wa4Ts4ASmxUUWbHZB8aWmZArTmGDZByHTI8WyRHeFcrUTuHmiaIWSNKdfcy9ZCmVZCJNlZA3OMlUYZBJvkvgZD');
  define('testUTOKEN','access_token=EAAG9k5MGFPYBAIRic40ZBf6tuq7XWy8gPRUqEZAxW6VBLgMJdeGcZBLZCvXviIveAZAsbfGMgLhFKeTSIhIuCPhoE48lLelTL8tYTc4pnIfWhkSR8Wp029VVq6H24rL8AZCSEC4dScZBvjdjRrk6knHpLuZB7ZBrjGqMZD');
  define('PTOKEN','access_token=EAAEPz5DjZAhUBAC8sZBYriqZBiy8dWo3TwZCiA9ApvklbXBT8ro0lZC3pvN4gNZCKOX7JZC9e58i8KLrWMpyM6OhNTrUIaZB1vqZCCijFbA2XM2hYDZB6yjzyopMqOAp6VqPEGNLZAHmJqTo6QDwbu5ejc5eGbCYSYhMFFKUAKNejmvwwZDZD');
  define('testPTOKEN','access_token=EAAXnZBDdib2sBAFcwEZAozOKZCaUEZBQoAviQIODZCfplFgB1pcjuTRSYOzbzwfnoZBYr7HZCgP3lJdzOYTXM0WEqeF5Om4hu5xstjch2wl5yez1Nko58fAsJLAl0HxeHKswut0F9dJe2oCrkUEWzaDZBO3Wv8aogV6iAjqolQe2ggZDZD');
  function share($img,$url,$caption,$image,$old){
    if(!isset($caption)){$caption = "";}
    $data = array('caption' => $caption, 'url' =>$image);
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $succ = 0;
    if ($result !== FALSE) { /* Handle error */
      $succ = 1;

      $old->execute(['id' => $img[0]['id']]);

      return ['success'=>$succ];
    }
    return ['success'=>$succ];
  }
  if( sizeof($img) >0){
    $res = share($img,"https://graph.facebook.com/me/feed?".testUTOKEN,$img[0]['caption'],"https://wassim-benzarti.rhcloud.com".$img[0]['url'],$old);
    echo $res['success'];
    die();
  }
  ini_restore("memory_limit");
  ?>
