<?php
require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
if (isset($_FILES['upload_file'])) {
  $res= [];
  $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
  $db->query("INSERT INTO facebookpics SET date='0000-00-00 00:00:00',url='',caption='error',done=0,posted=0");
  $nb=$db->lastInsertId();
  if(move_uploaded_file($_FILES['upload_file']['tmp_name'],getenv("OPENSHIFT_DATA_DIR")."/files/photoshare/".$nb.".".$ext)){
      $db->query("UPDATE facebookpics SET url='/src/photoshare/".$nb.".".$ext."' , caption='' WHERE id=".$nb);
      $res['success'] = 1;
  } else {
      $res['success'] = 0;
  }
  $res['id'] = $nb;
  $res['url']=getenv("OPENSHIFT_DATA_DIR")."photoshare/".$nb.".".$ext;
  die(json_encode($res));
}

?>

<form action="upload.php" method="post">
  <input type="file" name="fileInput" />
  <input type="button" value="Upload" onclick="upload(this.form)" />
</form>

<script>
function upload(f){
  var file = f.fileInput.files[0];
  uploadFile(file);
}
function uploadFile(file){
    var url = 'upload.php';
    var xhr = new XMLHttpRequest();
    var fd = new FormData();
    xhr.open("POST", url, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Every thing ok, file uploaded
            alert(xhr.responseText); // handle response.
            result = JSON.parse(req.responseText);
		console.log(result);
        }
    };
    fd.append("upload_file", file);
    xhr.send(fd);
}

</script>
