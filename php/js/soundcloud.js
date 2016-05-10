var audioPlayer=new Audio();
function ProgressBarUpdater(span){
  var self=this;
  var div = $('<div class="insideBar">');
  span.click(function(e){
    audioPlayer.currentTime = (e.offsetX/parseInt(span.css('width')))*audioPlayer.duration
  });
  div.appendTo(span);
  this.update=function(){
    if(audioPlayer.ended){return self.next()}
    if(!span.parent().hasClass('playing')){return self.destroy()}
    div.css('width', (audioPlayer.currentTime/audioPlayer.duration)*parseInt(span.css('width')));
    setTimeout(self.update,500);
  }
  this.next=function(){
    span.parent().next().children('img').trigger('click');
    span.parent().removeClass('playing');
    span.css({'height':'0'},500,function(){$(this).remove();});
  }
  this.destroy=function(){
    span.css({'height':'0'},500,function(){$(this).remove();});
  }
}
function playMusic(e){
  elm=$(this).parent();
  if(elm.hasClass('playing')){
    $('#musicList .playing').removeClass('playing');
    audioPlayer.pause();
  }else{
    $('#musicList .playing').removeClass('playing');
    src = elm.attr('data-music');
    if(audioPlayer.src != elm.attr('data-music')) audioPlayer.src = elm.attr('data-music');
    elm.addClass('playing');
    audioPlayer.play();
    var span=$('<span id="progressBar">');
    var p=new ProgressBarUpdater(span);
    span.css('height',0).appendTo(elm).animate({'height':'30px'},500,function(){$(this).delay(2000).removeAttr('style')});
    p.update()
  }
}

//$res = file_get_contents("http://api.soundcloud.com/e1/users/50277268/likes.json?client_id=8486830f17cbccc8b96e236dbf59df03&limit=6");
function SCloud(id,number,page,onCompleteEvent,onHoverEvent){
  self=this;
  this.id=id;
  this.number = number || 7;
  this.page = page || 0;
  this.onCompleteEvent=onCompleteEvent;
  this.onHoverEvent=onHoverEvent;
  this.wall=new freewall(id);
  this.wall.reset({
    gutterX:50,
    gutterY:50,
    cellW:300,
    cellH:300,
    onResize:function(){this.fitWidth()}
  });
  this.getTracks = function(animation){
    clientId = 'client_id=8486830f17cbccc8b96e236dbf59df03';
    $.get("http://api.soundcloud.com/e1/users/50277268/likes.json?"+clientId+"&limit="+this.number+"&offset="+this.page,function(data){
      for(var i=0;i<data.length;i++){
        self.page++;
        var div=$('<div>');
        div.addClass('item').addClass('onScroll load fadeScroll').attr('data-music',data[i].track.stream_url+'?'+clientId);
        div.attr('title',data[i].track.title);
        var img=$('<img>');
        data[i].track.artwork_url=data[i].track.artwork_url || data[i].track.user.avatar_url;
        var url = data[i].track.artwork_url.replace('-large.','-t300x300.');
        img.click(playMusic);
        img.attr('src',url).appendTo(div);
        div.appendTo(self.id);
      }
      SC.fitWidth(animation);
    });
  }
  this.fitWidth = function(animation){
    elm = $(self.id);
    var h = elm.parent().height();
    SC.wall.fitWidth();
    if(animation){
      elm.find('.item').removeClass('load');
      var toh=elm.parent().height();
      elm.parent().height(h).animate({height:toh},500,function(){
        $(this).css('height','auto');

      });
    }
  }
}
$(function(){
  SC=new SCloud('#musicList');
  SC.getTracks();
});
