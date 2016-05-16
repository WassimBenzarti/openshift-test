

var title;
$(window).one('doLoadingComplete',function(){
  titleAnim();

})
$(function(){
  $('#counters').data('scroll',$(window).outerHeight()/2);
  title = $('#HEAD').children('.titleAnim').css('background-position-y','0%');
  realTimeWorker();
  PHPImageLoader($('#firewall'));
});
var ipos=0;
function titleAnim(){
  title.css('background-position-y',ipos+'%');
  ipos += (100/36);
  if(ipos < 100) {setTimeout(requestAnimFrame,50,titleAnim);} else {title.css('background-position-y','100%');}
}
function timeLineAnim(h){
  var elm = $('#counters').children('div.timeLine');
  if(elm.height() < h){
    elm.height(h-elm.offset().top);
  }
}

function PHPImageLoader(elm){
  var extra='';
  if(elm.data('pg')==0){extra='&count&like&comment'}
  $.get('/php/loadImages.php?nb='+elm.data('nb')+'&pg='+elm.data('pg')+extra,function(data){
    if(extra.length){
      var counters = $('#counters');
      counters.data('images',data.count).data('likes',data.like).data('comments',data.comment);
      function increase(i,n,elm){if(i<=n){
        elm.html((i++) +elm.html().substr(elm.html().indexOf('<')));setTimeout(increase,(300/n)+10,i,n,elm)}}
      if(counters.hasClass('onScroll')){
        increase(0,counters.data('images'),counters.removeClass('onScroll').find('.images'));
        increase(0,counters.data('likes'),counters.find('.likes'));
        increase(0,counters.data('comments'),counters.find('.comments'));
      }
      data = data.result;
    }
    for(var i = 0;i<data.length;i++) {
      var d = data[i];
      d.created_time=timeAgo(d.created_time);
      d.images = $.parseJSON(d.images);
      d.title=(d.title && d.title.length>0)?d.title:(d.status.substr(0,d.status.indexOf(' '))+'...');
    }
    ImageLoader(data,elm);
    //elm.data('pg',elm.data('pg')+data.length);
    if(data.length == elm.data('nb')){elm.addClass('onScroll');}
    elm.on('visibleEvent',function(){
      if(!$(this).hasClass('load')){
        $(this).addClass('load');//.removeClass('onScroll');

        PHPImageLoader(elm);
      }
    });
  },'json');
}
function ImageLoader(data,container){
  for(var i=0;i<data.length;i++){
    var d=data[i];
    vWidth=container.width();
    vHeight=$(window).outerHeight()/1.3;
    var wrapper=$('<div class="item onScroll load">');
    wrapper.data('scroll',200);
    var ratio = d.width/d.height;
    wrapper.width('100%').height('auto');
    var date=$('<span class="date">').html(d.created_time).appendTo(wrapper);
    var info,title,status;
    //////// INFO BOX ////////
    if(d.status && d.status.length>0){
      info=$('<div class="info">');
      title=$('<h1 class="title">').html(d.title).appendTo(info);
      status=$('<p class="status">').html(d.status).mouseleave(function(){$(this).animate({scrollTop:0});}).appendTo(info);
      if(d.status.length>150){status.addClass('more')}
      info.appendTo(wrapper);
    }else if(d.title && d.title.length>0){
      info=$('<div class="info">');
      title = $('<span class="title">').html(d.title).appendTo(info);
      info.appendTo(wrapper);
    }
    /////// IMG /////////
    var img=$('<a class="img">').attr('href','#'+d.id).append($('<span class="colorful">').css('background',d.color));
    var x = new Image();
    $(x).data('wrapper',wrapper);
    x.src=d.images[0].source;
    x.onload = function(){$(this).data('wrapper').addClass('loaded')}
    img.css('background-image','url('+d.images[0].source+')');

    if(ratio > 1.2){
      img.width(vWidth).height(vWidth/ratio);
    }else if(ratio<0.8){
      img.width(vHeight*ratio).height(vHeight);
    }else{
      img.width(Math.min(vWidth*75/100,vHeight)).height(Math.min(vWidth*75/100,vHeight));
    }

    var likeBtn = $('<span class="likeBtn" title="like">').append(svgLike).attr('data-likes',d.likes).data('id',d.id).addClass(cookieLiked(d.id)).appendTo(img);
    var commentBtn = $('<span class="commentBtn" title="comment">').append(svgComment).attr('data-comments',d.comments).click(function(){
        $(this).parents('.img').trigger('click');var t = $('#THEATER');t.animate({scrollTop:t.find('form').offset().top+t.find('form').height()-$(window).outerHeight()});
      }).appendTo(img);
    likeBtn.click(likeImage);
    img.appendTo(wrapper);
    img.click(function(e){
      if($(e.target).hasClass('img')){
        Theater.open('itc',$(this).parents('.item').data('data'),$(e.target));
      }
    });

    wrapper.on('visibleEvent',function(){console.log(this)
      timeLineAnim($(this).find('.img').offset().top);
    });

    container.append(wrapper.data('data',d)).data('scroll',container.height());
  }
}
