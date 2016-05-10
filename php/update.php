<?php
/*token = CAAXnZBDdib2sBAI7NuQogPZCJUstQgTRQiVjoBSzZBZCwoBkY4kH7SdvlYRmxICWZCyO47SBAc5ZAU3xhpsjIO0oeWzP8ofledmrESFlWIrGcvDLWjcxjN2ZAEr93JAtJuEuuRseU2NQ7L7myspWLhrQuutBZBXR4oUY5l38tnXsschWHvgNY9B4Wwm80qnQzDIZD

file_get_contents('https://graph.facebook.com/355698711291842/photos/uploaded?limit=9&fields=images,link,name,width,height,created_time,comments.limit(10)&access_token=CAAXnZBDdib2sBAI7NuQogPZCJUstQgTRQiVjoBSzZBZCwoBkY4kH7SdvlYRmxICWZCyO47SBAc5ZAU3xhpsjIO0oeWzP8ofledmrESFlWIrGcvDLWjcxjN2ZAEr93JAtJuEuuRseU2NQ7L7myspWLhrQuutBZBXR4oUY5l38tnXsschWHvgNY9B4Wwm80qnQzDIZD');
*/
?>
<a href="?updatenow">UPDATE</a>
<a href="?reset">RESET</a>
<?php
if(!isset($_GET['updatenow']) && !isset($_GET['reset'])){
  die();
}
require 'connect.php';
ini_set("memory_limit",-1);
function colorPalette($imageFile, $numColors, $granularity = 5)
{
   $granularity = max(1, abs((int)$granularity));
   $colors = array();
   $size = @getimagesize($imageFile);
   if($size === false)
   {
      user_error("Unable to get image size data");
      return false;
   }
   //$img = @imagecreatefromjpeg($imageFile);
   // Andres mentioned in the comments the above line only loads jpegs,
   // and suggests that to load any file type you can use this:
   $img = @imagecreatefromstring(file_get_contents($imageFile));

   if(!$img)
   {
      user_error("Unable to open image file");
      return false;
   }
   for($x = 0; $x < $size[0]; $x += $granularity)
   {
      for($y = 0; $y < $size[1]; $y += $granularity)
      {
         $thisColor = imagecolorat($img, $x, $y);
         $rgb = imagecolorsforindex($img, $thisColor);
         $red = round(round(($rgb['red'] / 0x33)) * 0x33);
         $green = round(round(($rgb['green'] / 0x33)) * 0x33);
         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue);
         if(array_key_exists($thisRGB, $colors))
         {
            $colors[$thisRGB]++;
         }
         else
         {
            $colors[$thisRGB] = 1;
         }
      }
   }
   arsort($colors);
   return array_slice(array_keys($colors), 0, $numColors);
}
function color_avg($color1,$color2,$factor=.5) {

        // extract RGB values for color1.
        list($r1,$g1,$b1) = str_split($color1,2);
        // extract RGB values for color2.
        list($r2,$g2,$b2) = str_split($color2,2);

        // get the average RGB values.
        $r_avg = (hexdec($r1)*(1-$factor)+hexdec($r2)*$factor);
        $g_avg = (hexdec($g1)*(1-$factor)+hexdec($g2)*$factor);
        $b_avg = (hexdec($b1)*(1-$factor)+hexdec($b2)*$factor);

        // construct the result color.
        $color_avg = sprintf("%02s",dechex($r_avg)).
                        sprintf("%02s",dechex($g_avg)).
                        sprintf("%02s",dechex($b_avg));


        // return it.
        return $color_avg;
}
function colorAvg($array){
  $sum=$array[0];
  for($k=1;$k<count($array);$k++){
    $sum = color_avg($sum,$array[$k]);
  }
  return $sum;
}
if(isset($_GET['reset'])){
  $reset = $db->prepare("DELETE FROM artphotos");
  $reset->execute();
  //var_dump( array_map('unlink', glob("../inc/files/blurry/*")));
  die("Reseted");
}
//retrive old data
$old = $db->prepare("SELECT fbid,autoupdate FROM artphotos WHERE autoupdate=1");
$old->execute();
$ids = $old->fetchAll(PDO::FETCH_COLUMN,0);
if(!isset($_GET['offset'])){$_GET['offset']=0;}
$data = file_get_contents('https://graph.facebook.com/355698711291842/photos/uploaded?limit=5&offset='.$_GET['offset'].'&fields=images,link,name,width,height,created_time,likes.limit(0).summary(true),comments.limit(0).summary(true)&order=reverse_chronological&access_token='.FBTOKEN);

$data = json_decode($data);
$res = $db->prepare("INSERT INTO artphotos VALUES(:id,NULL,:name,:width,:height,:images,:color,:link,:created_time,1,0,:blurry,:likes,:comments)");
try{


for($i=sizeof($data->data)-1;$i>=0;$i--){
  if(in_array($data->data[$i]->id,$ids)){
    echo "MATCH FOUND!";
    break;
  }else{
    $d = (array)$data->data[$i];
    $filename = str_replace('https://','http://',end($d["images"])->source);
    /*
    $palette = Palette::fromFilename($filename);
    $color = $palette->getMostUsedColors(1);
    $color = Color::fromIntToHex(key($color));
    */
    $time= mktime();
    $color = colorPalette($filename, 5, 10);
    echo (mktime()-$time)."s";
    $color= "#".colorAvg($color);

    switch ( strtolower(explode("?",end(explode(".",$filename)))[0]) ) {
        case 'jpeg':
            $image = imagecreatefromjpeg($filename);
        case 'jpg':
            $image = imagecreatefromjpeg($filename);
        break;
        case 'png':
            $image = imagecreatefrompng($filename);
        break;
        case 'gif':
          $image = imagecreatefromgif($filename);
        break;
    }
    $d['blurry']='/src/files/blurry/'.$d['id'].'.jpg';
    //imagefilter($image, IMG_FILTER_GRAYSCALE);
    //imagefilter($image, IMG_FILTER_CONTRAST,-40);
    //imagefilter($image, IMG_FILTER_BRIGHTNESS,30);

    for($j=0;$j<30;$j++){imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);}
    echo SERVERROOTPATH.$d['blurry'];
    if (!imagejpeg($image,SERVERROOTPATH.$d['blurry'],75)){echo("error occurred on saving");};
    imagedestroy($image);
    $d["color"]=$color;
    $d["images"]=json_encode($d['images']);
    $d["name"] = (empty($d["name"]))?'NULL':$d["name"];
    $d["created_time"]=new DateTime($d["created_time"]);
    $d["created_time"]->modify('+1 hour');
    $d["created_time"]=$d["created_time"]->format("Y-m-d H:i:s");
    $d["likes"]=$d["likes"]->summary->total_count;
    $d["comments"]=$d["comments"]->summary->total_count;
    echo "<br>//////////////////<br>Done Uploading image n°".$i." <br>/////////////////";
    echo "<pre>";
    var_dump($d);
    echo "</pre>";
    $res->execute($d);
  }
}


}catch(Exception $e){
  echo $e->getMessage();
  exit();
}
echo "<a href='?updatenow&offset=".(sizeof($data->data)-1)."'>UPDATE NEXT".(sizeof($data->data)-1)."</a>";
ini_restore("memory_limit");
?>
