var PHPprojectLoader = new function(){
  var self = this;
  this.count=0;
  this.load=function(page,number,onComplete,count){
    page = page || self.count;
    number = number || -1;
    count = (count)? '&count' : '' ;
    $.get('/php/loadProjects.php?pg='+page+'&nb='+number+count,function(data){
      onComplete(data);
    },'json');
  }
}
function callPlayer(iframe, func, args) {
    if (iframe) {
        iframe.contentWindow.postMessage(JSON.stringify({
            "event": "command",
            "func": func,
            "args": args || []
        }), "*");
    }
}

function projectsUI(data){
  for(var i=0;i<data.length;i++){
    var d=data[i];console.log(d);
    d.color="#333";
    var vHeight=$(window).outerHeight()*70/100;
    var article=$('<article class="item fullscreen">').data('data',d);
    if(d.bg !== undefined){
      d.bg=$.parseJSON(d.bg);
      var bg=$('<div class="bg">').height(vHeight);
      if(d.bg.type == "Image"){
        bg.css('background-image','url('+d.bg.src+')').appendTo(article);
      }else if(d.bg.type == "Video"){
        loadBGVideo(d.bg,bg);
      }
      bg.appendTo(article);
    }
    var text=$('<div class="text">');
    if(d.title !== undefined){
      $('<h1 class="title">').html(d.title).appendTo(text);
    }
    if(d.subtitle !== undefined){
      $('<h2 class="sub">').html(d.subtitle).appendTo(text);
    }
    if(d.link !== undefined){
      d.link=$.parseJSON(d.link);
      $('<a href="'+d.link.src+'" >').html(d.link.text).appendTo(text);
    }
    $('<a class="learnMore" href="#theater" >').html("Take a quick look").click(function(e){e.preventDefault();var p =$(e.currentTarget).parents('article.item');Theater.open('vtp',p.data('data'),p.find('.content'));/*openProjectTheater(e.currentTarget)*/}).appendTo(text);
    if(text.children().length>0){text.appendTo(article);}
    var content=$('<div class="content">');
    if(d.description !== undefined){
      $('<h1 class="title">').html(d.title).appendTo(content);
      $('<p class="desc">').html(d.description).appendTo(content);
    }
    if(d.cover !== undefined){
      d.cover=$.parseJSON(d.cover);
      for(var j=0;j<d.cover.length;j++){
        if(d.cover[j].type=="Image"){
          $('<div class="img">').css('background-image','url('+d.cover[j].src+')').appendTo(content);
        }else{
          loadBGVideo(d.cover[j],content,true);
        }
      }
    }
    article.append(content);
  }
  return article;
}
