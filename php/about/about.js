$(function(){
  loadChannel();
  realTimeWorker();

});
function loadChannel(){
  $.get("/php/fbpage.php",function(data){
    var d=data;
    $("#pagePic").attr('src','http://graph.facebook.com/'+d.id+'/picture?width=200');
    $("#HEAD").css('background-image','url('+d.cover.source.replace(/\/p[0-9]+x[0-9]+\//g,'/p720x720/')+')');
    $(function(){
      $("<div id='pageCover'>").prependTo('#HEAD').css('background-image','url('+d.cover.source.replace(/\/p[0-9]+x[0-9]+\//g,'/')+')');
    })
    $("#info").find(".speech").html(d.personal_info);
    loadSkills();
  },'json');

  /*
  //https://www.googleapis.com/youtube/v3/channels?part=brandingSettings&id=UCuuVXu3AX2GhSjHR6s56xTg&key=AIzaSyBTgptPbssftSXVZGoLt35XqZQbypmq0yw
  $.get("https://www.googleapis.com/youtube/v3/channels?part=brandingSettings,contentDetails,snippet,statistics&id=UCuuVXu3AX2GhSjHR6s56xTg&key=AIzaSyBTgptPbssftSXVZGoLt35XqZQbypmq0yw",function(data){
    var d= data.items[0];
    console.log(d);
    $.get("https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCuuVXu3AX2GhSjHR6s56xTg&type=video&order=viewCount&maxResults=5&key=AIzaSyBTgptPbssftSXVZGoLt35XqZQbypmq0yw",listVideos);
    $('#channelPic').attr('src',d.snippet.thumbnails.high.url);
    var wrap=$('#VIDEOS');
    wrap.find("#channelArt").css('background-image','url('+data.items[0].brandingSettings.image.bannerTvMediumImageUrl+')');
    wrap.find("#counters").find(".views>span").html(d.statistics.viewCount);
    wrap.find("#counters").find(".subscribers>span").html(d.statistics.subscriberCount);
    wrap.find("#channelName").html(d.snippet.title);
    wrap.find("#description").html(d.snippet.description);
    wrap.find("#videoCounter").html(d.statistics.videoCount);

  });
  */
}

function loadSkills(){
  var skills = $("#skills");
  $.get("/php/about.php?skills",function(data){
    console.log(data);
    var field='';
    var wrapper;
    var count=0;
    for(i=0;i<data.length;i++){
      if(data[i].field != field){
        count=0;
        wrapper = $('<div class="field onScroll Sfade load">').data('scroll',20);
        $('<h1>').html(data[i].field).appendTo(wrapper);
        wrapper.appendTo(skills);
        field=data[i].field;
      }

      $('<label>').css('opacity',(data[i].val<75)?0.7:1).html(data[i].name).appendTo(wrapper);
      var elm = $('<div class="progressBar onScroll">').css('opacity',(data[i].val<70)?0.7:1).appendTo(wrapper);
      var p = new ProgressBar(elm);
      p.val=data[i].val;
      if(data[i].field== "Design") elm.find('.progress').css('background',get_random_color(count));
      count++;
      elm.data('progress',p).on('visibleEvent',function(){
        $(this).data('progress').load();

        $(this).unbind();
        console.log('hello');
      });

    }
    loadTimeline();
  },'json');
}

function loadTimeline(){
  var wrapper = $("#timeline");
  $.get("/php/about.php?timeline",function(data){
    console.log(data);
    data[data.length] = {title:"There is no such thing as an ending.",story:"There's always a new beginning."}
    for(var i=0;i<data.length;i++){
      var d = data[i];
      var ev = $('<div class="moment onScroll Sfade load">');
      if (d.date) {
        var date = d.date.split('-');
        if(date[1]==0){
          date=date[0];
        }else if(date[2]==0){
          date = Date.locale[parseInt(date[1])-1]+' '+date[0];
        }else{
          date =  date[2]+' '+Date.locale[parseInt(date[1])-1]+' '+date[0];
        }
        $("<span class='date'>").html(date).appendTo(ev);
      }else if(i == data.length-1){
        ev.addClass("final");
      }

      if (d.title) var story = $("<div class='story'>");
      if (d.title.length>0) $("<h5 class='title'>").html(d.title).appendTo(story);
      if (d.story.length>0) $("<p>").html(d.story).appendTo(story);
      ev.append(story).appendTo(wrapper);
    }
    loadClients();
  },'json');

}

function listVideos(data){
  console.log(data);
  var wrap=$('#VIDEOS>#videoList');
  for(var i in data.items){
    var d = data.items[i];
    var item = $('<a class="item">').attr('href','https://youtube.com/watch?v='+d.id.videoId);
    $('<div class="thumbnail">').css('background-image','url(http://i1.ytimg.com/vi/'+d.id.videoId+'/hqdefault.jpg)').appendTo(item);
    $('<h2 class="videoTitle">').html(d.snippet.title).appendTo(item);
    item.appendTo(wrap);
  }
}

function loadClients(){
  var wrapper = $("#clients");
  $.get("/php/about.php?clients",function(data){
    console.log(data);
    for(var i=0;i<data.length;i++){
      var d = data[i];
      var ev = $('<div class="client onScroll Sfade load">');
      if (d.name) {ev.html('#'+d.name)};
      ev.appendTo(wrapper);
    }
  },'json');

}


function test(im){
  $.get(im+"&key=AIzaSyBTgptPbssftSXVZGoLt35XqZQbypmq0yw",function(data){console.log(data)});
}
