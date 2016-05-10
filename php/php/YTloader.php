<?php
  die();
  if(!isset($_GET['id'])){die("{failed:true}");}
  $content = file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$_GET['id'].'&asv=3&el=detailpage&hl=en_US');
  parse_str($content);
  function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }

  $cleanedtitle = clean($title);
  $my_formats_array = explode(',', $url_encoded_fmt_stream_map);

  $avail_formats[] = '';
  $i = 0;
  $ipbits = $ip = $itag = $sig = $quality = '';
  $expire = time();
  foreach($my_formats_array as $format) {
    parse_str($format);
  	parse_str($format,$hell);
  	$avail_formats[$i]['itag'] = $itag;
  	$avail_formats[$i]['quality'] = $quality;
  	$type = explode(';',$type);
  	$avail_formats[$i]['type'] = $type[0];
  	$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $s;
  	parse_str(urldecode($url));
  	$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
  	$avail_formats[$i]['ipbits'] = $ipbits;
  	$avail_formats[$i]['ip'] = $ip;
  	$i++;
  }
  for ($i = 0; $i < count($avail_formats); $i++) {
		echo '<li>';
		echo '<span class="itag">' . $avail_formats[$i]['itag'] . '</span> ';
		$directlink = explode('.googlevideo.com/',$avail_formats[$i]['url']);
		$directlink = 'http://redirector.googlevideo.com/' . $directlink[1] . '';
		echo '<a href="' . $directlink .'&title='.$cleanedtitle.'" class="mime">' . $avail_formats[$i]['type'] . '</a> ';
    $mime = $avail_formats[$i]['type'];
    $ext  = str_replace(array('/', 'x-'), '', strstr($mime, '/'));
    $url  = $avail_formats[$i]['url'];
    $name = $title. '.' .$ext;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = curl_exec($ch);
    curl_close($ch);

    if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {

        // Contains file size in bytes
        $size = (int)$matches[1];
        $size = 15456345;
    };
    header('Content-Type: "' . $mime . '"');
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Content-Length: '.$size);
		header('Pragma: no-cache');
    readfile($url);

	}


  echo '<pre>';
  print_r($avail_formats);
  echo '</pre>';

    die();



  $results = [];
  for($i=0; $i<sizeof($streams); $i++){
   $real_stream = [];
   parse_str($streams[$i], $real_stream);
   $real_stream["url"] .= "&signature=".$real_stream['s'];
   $real_stream["url"] .= "&fallback_host=".$real_stream['fallback_host'];
   array_push($results,$real_stream);
   var_dump($real_stream);
   echo "<br>/////////////////////////////////////////////////////////////////////////////////////////////////<br>";
   echo "<a href='".$real_stream['url']."'>".$real_stream['quality']."</a>";
  }
  //var_dump($results);

?>
