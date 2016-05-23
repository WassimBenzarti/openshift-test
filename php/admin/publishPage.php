<?php
  define('UTOKEN','access_token=EAACoSoJeH3wBAAJpxTzTyZAFpGrktOaE6C37QfpzINj0kbDZCuocLhfJdpXet0YomQ5xQqWefBgDoAK1wa4Ts4ASmxUUWbHZB8aWmZArTmGDZByHTI8WyRHeFcrUTuHmiaIWSNKdfcy9ZCmVZCJNlZA3OMlUYZBJvkvgZD');
  define('testUTOKEN','access_token=EAAG9k5MGFPYBAIRic40ZBf6tuq7XWy8gPRUqEZAxW6VBLgMJdeGcZBLZCvXviIveAZAsbfGMgLhFKeTSIhIuCPhoE48lLelTL8tYTc4pnIfWhkSR8Wp029VVq6H24rL8AZCSEC4dScZBvjdjRrk6knHpLuZB7ZBrjGqMZD');
  define('PTOKEN','access_token=EAAEPz5DjZAhUBAC8sZBYriqZBiy8dWo3TwZCiA9ApvklbXBT8ro0lZC3pvN4gNZCKOX7JZC9e58i8KLrWMpyM6OhNTrUIaZB1vqZCCijFbA2XM2hYDZB6yjzyopMqOAp6VqPEGNLZAHmJqTo6QDwbu5ejc5eGbCYSYhMFFKUAKNejmvwwZDZD');
  define('testPTOKEN','access_token=EAAXnZBDdib2sBAFcwEZAozOKZCaUEZBQoAviQIODZCfplFgB1pcjuTRSYOzbzwfnoZBYr7HZCgP3lJdzOYTXM0WEqeF5Om4hu5xstjch2wl5yez1Nko58fAsJLAl0HxeHKswut0F9dJe2oCrkUEWzaDZBO3Wv8aogV6iAjqolQe2ggZDZD');
  function share($url,$caption){
    if(!isset($caption)){$caption = ""}
    $data = array('caption' => $_POST['msg'], 'url' => $_POST['url']);
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
      return ['success'=>$succ,
                      'url' => $_POST['url'],
                      'sth' => $_POST['msg']
                    ];
    }
    return ['success'=>$succ];
  }
  if(isset($_GET['upload'])){
    $res = share("https://graph.facebook.com/me/photos?".testPTOKEN,"hello");
    echo "<pre>";
    echo json_encode($res);
    echo "</pre>";
    die();
  }
  ?>
