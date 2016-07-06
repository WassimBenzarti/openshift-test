

<?php
  require_once(getenv("OPENSHIFT_REPO_DIR")."php/connect.php");
  if(isset($_POST['id']) && isset($_POST['caption']) && isset($_POST['date']) && isset($_POST['done'])){
    $set = $db->prepare("UPDATE facebookpics SET caption=:cap, done=:done , date=:date WHERE id=:id");
    $res = $set->execute([':cap'=>$_POST['caption'],
                  ':done'=>$_POST['done'],
                  ':date'=>$_POST['date'],
                  ':id'=>  $_POST['id']]);
    if(!$res){
      die(json_encode(['success'=>false,'msg'=>json_encode($_POST)]));
    }
    echo json_encode(['success'=>true,'msg'=>json_encode($_POST)]);
    die();
  }
  if(!isset($_GET['pg'])){
    die();
  }
  $get = $db->prepare("SELECT * FROM facebookpics WHERE done = 0 ORDER BY id LIMIT 10 OFFSET :pg");
  $get->bindValue(':pg', intval($_GET['pg']), PDO::PARAM_INT);
  $get->execute();

  $imgs = $get->fetchAll(PDO::FETCH_ASSOC);


  for($i = 0;$i<sizeof($imgs);$i++){
    $d = $imgs[$i];
    $d['url'] = '/admin/compress.php?URL='+urlencode($d['url']);

?>

<h2><?php echo($d['id']) ?></h2>
<form action="manage.php" method="POST" data-id="<?php echo($d['id']) ?>"     style="background-image:url(<?php echo($d['url']) ?>)"><?php echo($d['url']) ?>
  <input type="text" name="caption" value="<?php echo($d['caption']) ?>">
  <input id="datetimepicker" name="userDate" type="text" value="<?php echo($d['date']) ?>" >
  <input value="default" type="reset">
  <input type="button" onclick="updatedb(this.form)" value="Update">
  <input type="checkbox" name="show" <?php echo (($d['done']===1)?'checked':'')  ?>>Done?
</form>

<?php
  }
  // echo "<pre>";
  // var_dump($imgs);
  // echo "</pre>";
?>


<div id="status">
  <h1></h1>
</div>
<link rel="stylesheet" href="styles/jquery.datetimepicker.css">
<link rel="stylesheet" href="styles/manage.css">
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jquery.datetimepicker.full.min.js"></script>
<script>
  $("form>#datetimepicker").datetimepicker({
    dateFormat:'yy-mm-dd',timeFormat:'HH:mm:ss'
  });

  function updatedb(f){

    if(confirm('Do you really want to UPDATE ?')){
      var id=$(f).data('id');
      var caption = f.caption.value;
      var checked = ((f.show.checked)?0:1);
      var date = "0000-00-00 00:00:00";
      date = f.userDate.value.split('/').join('-');
      $.post('manage.php',{id:id,date:date,caption:caption,done:checked},function(data){
        _(data);

      },'json');

    }

  }
  function _(a){
    console.log(a);
    if(a.success){
      $('#status').html(a.msg).addClass((a.success)?'success':'fail');
      setTimeout(function(){
        $('#status').removeClass('success').removeClass('fail');
      },2000)
    }
  }
</script>
