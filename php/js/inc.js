window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          function( callback ){
            window.setTimeout(callback, 1000 / 60);
          };
})();
/////////////////////// HISTORY API ///////////////////
function loadContent(href,data,onComplete) {
  onComplete=onComplete||function(){};
  Theater.close();
  var $result = $('<div/>').html(data);
  document.title = $result.find("title").html();
  var html=$result.find('#mainContainer').html();
  History.pushState({"html":html,"pageTitle":document.title}, document.title, href);
  //$("#mainContainer").html(html);
  setTimeout(function(){$('#menu').removeClass("open");window.scroll(0 ,0);},1000);

  nav.find("a").removeClass("current");
  nav.find("a[href='" + href + "']").addClass("current");
  onComplete();
}

$(function(){
  var $mainContainer = $('#mainContainer');
  History.buildHandler=function(){
    console.log('buildHandler');

    var State = History.getState();
    History.log('statechange:', State.data, State.title, State.url);
    if(State.title=="Theater") return;
    $mainContainer.html(State.data.html);
    document.title = State.data.pageTitle;
    //$(window).trigger('doLoadingComplete');

  }
  //History.buildHandler();
  History.replaceState({"html":$mainContainer.html(),"pageTitle":document.title}, document.title, window.location.pathname);

  History.Adapter.bind(window,'statechange',function(){
    console.log('stateChange');
    History.buildHandler();
    /*var State = History.getState();
    History.log('statechange:', State.data, State.title, State.url);
    if(State.title=="Theater") return;
    $mainContainer.html(State.data.html);
    document.title = State.data.pageTitle;
    //$(window).trigger('doLoadingComplete');*/
  });


  nav = $('#menu nav');
  doLoading(true,null,function(){$(window).trigger('doLoadingComplete');});
  nav.find("a[href$='" + window.location.pathname.replace(/\/index.php/,'/') + "']").first().addClass("current");
  nav.delegate("li", "click", function(e) {
      e.preventDefault();
      addRippleEffect(e);
      $(window).off("load");
      if($(this).find('a').hasClass('current')) return false;
      $(this).find('a').addClass("current");
      var _href = $(this).find('a').attr("href");
      doLoading(true,function(){
        $.get(_href, function(result){
          loadContent(_href,result);
        });
      },function(){
        $(window).trigger('doLoadingComplete');
      });
      return false;
  });
});
////////////////////// VISIBLE EVENT TO SHOW ELEMENTS //////////////////////
function showOnScroll(){
  var top = $(window).scrollTop();
  var bottom = $(window).scrollTop() + $(window).outerHeight();
  var data=document.getElementsByClassName('onScroll');
  var j=0;
  for(var i=0;i<data.length;i++){
    var elm=$(data[i]);
    var marge=-50;
    if(elm.data('scroll')){marge=elm.data('scroll')}
    if(bottom>elm.offset().top+marge){
      if(elm.hasClass('load')){
        setTimeout(function(temp){
            temp.removeClass('load');
        },100*j++,elm);
      }
      elm.trigger("visibleEvent");
    }
    if(elm.offset().top>bottom || elm.offset().top+elm.outerHeight()<top){
      elm.trigger("hideEvent");
    }
  }
}
////////////////////// REALTIME WORKER //////////////////////
var lastPosition = -1;
var timer;
function realTimeWorker(){
    // Avoid calculations if not needed
    if (lastPosition == window.pageYOffset) {
        timer = setTimeout(requestAnimFrame,500, realTimeWorker );
        return false;
    } else if(lastPosition!=-1){
      if($(document.body).hasClass('loading')){window.scrollTo(0,lastPosition);}
      lastPosition = window.pageYOffset;
    }else{
      lastPosition = window.pageYOffset;
    }
    clearTimeout(timer);
    //... calculations
    showOnScroll();
    timer = setTimeout(requestAnimFrame,30,realTimeWorker);
}
var colors=['#4285F4','#EA4335','#FBBC05','#34A853','#FF6780','#67CBFF','#E868A1','#F18C32','#156096'];
function get_random_color(index) {
  function shuffle(o){
    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
  }
  if(typeof index == 'undefined') {shuffle(colors);return colors[parseInt(Math.random()*colors.length)]}
  if(index==0) shuffle(colors);
  return colors[index];
}
function setVendor(element, property, value) {
  element.style["webkit" + property] = value;
  element.style["moz" + property] = value;
  element.style["ms" + property] = value;
  element.style["o" + property] = value;
}
function get_bw_color(color,invert){
  var red = parseInt(color.substr(1,2),16);
  var green = parseInt(color.substr(3,2),16);
  var blue = parseInt(color.substr(5,2),16);
  var sum = red+green+blue;
  if(sum > 450){
  	return (!invert)?"#000":"#FFF";
  }else{
  	return (!invert)?"#FFF":"#000";
  }
}
var addRippleEffect = function (e) {
  var target = e.currentTarget;
  var rect = target.getBoundingClientRect();
  var ripple = target.querySelector('.ripple');
  if (!ripple) {
      ripple = document.createElement('span');
      ripple.className = 'ripple';
      ripple.style.height = ripple.style.width = Math.max(rect.width, rect.height) + 'px';
      ripple.style.position = 'absolute';
      ripple.style.borderRadius = '100%';
      ripple.style.pointerEvents='none';
      ripple.style.oTransform = 'scale(0,0)';
      ripple.style.mozTransform = 'scale(0,0)';
      ripple.style.msTransform = 'scale(0,0)';
      ripple.style.webkitTransform = 'scale(0,0)';
      ripple.style.transform = 'scale(0,0)';
      target.appendChild(ripple);
  }
  ripple.classList.remove('show');
  var top = e.pageY - rect.top - ripple.offsetHeight / 2 - document.body.scrollTop;
  var left = e.pageX - rect.left - ripple.offsetWidth / 2 - document.body.scrollLeft;
  ripple.style.top = top + 'px';
  ripple.style.left = left + 'px';

  ripple.classList.add('show');
  return false;
}
Date.locale = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
function timeAgo(time){
  time = new Date(time.replace('-','/')).getTime();
  var time_formats = [
    [60, 'seconds', 1], // 60
    [120, '1 minute ago', '1 minute from now'], // 60*2
    [3600, 'minutes', 60], // 60*60, 60
    [7200, '1 hour ago', '1 hour from now'], // 60*60*2
    [86400, 'hours', 3600], // 60*60*24, 60*60
    [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
    [604800, 'days', 86400], // 60*60*24*7, 60*60*24
    [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
    [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
    [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
    [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
    [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
    //[2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
    [348364800, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
  ];
  var seconds = (+new Date() - time) / 1000,
      token = 'ago', list_choice = 1;
  if (seconds < 60) {
    return 'Just now'
  }
  if (seconds < 0) {
    seconds = Math.abs(seconds);
    token = 'from now';
    list_choice = 2;
  }
  var i = 0, format;
  while (format = time_formats[i++]){
    if (seconds < format[0]){
        if (typeof format[2] == 'string')
            return format[list_choice];
        else
            return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
    }
  }
  format = time_formats[time_formats.length - 1];
  return (Math.floor(seconds / format[2])-1) + ' ' + format[1] + ' ' + token;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
function cookieLiked(id){
  var liked = getCookie('liked');
  if (liked == '') return '';
  var arr = $.parseJSON(decodeURIComponent(getCookie('liked')));
  if($.inArray(id,arr) > -1) {return 'liked'} else  {return ''};
}
function openTheater(e){
  e.preventDefault();
  var mainItem = $(e.currentTarget).parents('.item');
  var d=mainItem.data('data');
  var vWidth=$(window).outerWidth()*80/100;
  var vHeight=$(window).outerHeight()/1.1;
  var theater=$('<div class="theater">').click(closeTheater);
  var container=$('<div id="container">').width(vWidth);
  var title=$('<h1 class="title">').html(d.title).css({'background-color':d.color,color:get_bw_color(d.color)}).appendTo(container);
  var img=$('<a class="img">').css('background-image','url('+d.images[2].source+')').append($('<div class="preload">')).append(mainItem.find('.likeBtn').clone().click(function(e){likeImage(e);mainItem.find('.likeBtn').trigger('click');}));
  var ratio = d.width/d.height;
  var height;
  if(ratio > 1.2){
    height=vWidth/ratio;
    img.width(vWidth).height(height).css('margin-top',($(window).outerHeight()-height)/2).css('margin-bottom',(($(window).outerHeight()-height)/2)-30);
  }else if(ratio<0.8){
    img.addClass('gradient').find(".likeBtn").css('bottom',0);
    height=vHeight;
    img.width(vHeight*ratio).height(height).css('margin-bottom',(($(window).outerHeight()-height)/2)-10);
  }else{
    img.addClass('gradient').find(".likeBtn").css('bottom',0);
    height=Math.min(vWidth*75/100,vHeight);
    img.width(height).height(height).css('margin-bottom',(($(window).outerHeight()-height)/2)-10);
  }
  var status=$('<p class="status">').html(d.status);
  var comments=$('<div class="comments">');
  var form = $('<form onsubmit="return commentImage(this);">').data('id',d.id).append('<input name=set autocomplete="off" type="text" onFocus=$(this).parent().addClass("active") onBlur=$(this).parent().removeClass("active") placeHolder="Tell me what you think...">');

  container.append(title,status,comments,form);
  theater.append(img,container).hide().appendTo(document.body).fadeIn('200',function(){
    //img.children('.preload').css('background-image','url('+d.images[0].source+')');
    var com = new PHPCommentsLoader(comments);
    com.loadById(d.id);
    comments.hover(function(){
      $(this).scroll(function(){
        $(this).parents('.theater').css({
            'overflow': 'hidden',
            'height': '100%'
        });
      });
    },function(){
      $(this).unbind('scroll').parents('.theater').css({
          'overflow': '',
          'height': ''
      });
    });
  });
  $(document.body).width($(document.body).outerWidth()).css('top',-window.pageYOffset).addClass('noScroll');
}
function closeTheater(e){
  if(e){
    if($(e.target).parents('.theater').length){
      return false;
    }
  }
  $('.theater').fadeOut(400,function(){$(this).remove();
    $(document.body).removeClass('noScroll').scrollTop(-parseInt($(document.body).css('top'))).css({top:'',width:''});
    $(window).off('statechange');
    History.Adapter.bind(window,'statechange',History.buildHandler);
    if(History.getState().title=="Theater") History.back();
  });
}
function likeImage(e){
  e.preventDefault();
  var elm = $(e.target);
  var id=elm.data('id');

  $('.img[href=#'+id+']').each(function(elm){
    elm = $(this).children('.likeBtn');
    if(elm.toggleClass('liked').hasClass('liked')){
      elm.attr('data-likes',parseInt(elm.attr('data-likes'))+1);
    }else{
      elm.attr('data-likes',parseInt(elm.attr('data-likes'))-1);
    }

  });
}
function openProjectTheater(elm){
  var mainItem = $(elm).parents('.item');
  var theater=$('<div class="theater">').click(closeTheater);
  var container = mainItem.find('.content').clone();
  theater.append(container).appendTo(mainItem);
  $(window).off('statechange');
  History.pushState({"pageTitle":document.title},"Theater","?theater");
  theater.hide().fadeIn();
  History.Adapter.bind(window, 'statechange', closeTheater);
  $(document.body).width($(document.body).outerWidth()).css('top',-window.pageYOffset).addClass('noScroll');
}
function loadBGVideo(file,wrapper,paused){
  var videoWrapper = $('<div class="video-wrapper onScroll" >').css({'padding-bottom':file.padding||0,height:(file.padding)?0:$(window).outerHeight()}).appendTo(wrapper);
  $('<span>').css('background-image','url(http://img.youtube.com/vi/'+file.src+'/hqdefault.jpg)').appendTo(videoWrapper);
  videoWrapper.on((paused)?'click':'visibleEvent',function(){

    if($(this).find('iframe').length==0){
      var iframe = $('<iframe frameborder="0" allowfullscreen="allowfullscreen" title="YouTube video player" type="text/html" src="http://www.youtube.com/embed/'+file.src+'?enablejsapi=1&autohide=2&version=3'+((paused)?'':'&controls=0')+'&showinfo=0&loop=1&iv_load_policy=3'+((file.extra!==undefined && !paused)?file.extra:'')+((file.list)?'&listType=playlist&list='+file.list:'&playlist='+file.src)+'">').appendTo($(this));
      var f=iframe[0];
      //$(this).parent().height(Math.ceil(iframe.outerHeight(true)/2));
      f.onload=function(){
        if(!paused){callPlayer(f,"mute");}
        callPlayer(f,"playVideo");
        $(this).parent().addClass('playing').find('span').delay(1000).fadeOut(1000);
      }
    }else if(!$(this).hasClass('playing')){
      var f=$(this).find('iframe')[0];
      callPlayer(f,"playVideo");callPlayer(f,"mute");
      $(this).addClass('playing');
    }
  }).on('hideEvent',function(){
      if($(this).hasClass('playing')){
        $(this).removeClass('playing');
        if($(this).find('iframe').length>0){
          callPlayer($(this).find('iframe')[0],"pauseVideo");
        }
      }
  });
}


var contactInfo;
function getContact(elm){
  if(typeof contactInfo == 'undefined'){
    $.get('/php/about.php?contact',function(data){
      console.log(data);
      for(var i=0;i<data.length;i++){
        var d= data[i];
        switch(data[i].type){
          case 'text':
            elm.append('<br>');
            $('<b>').html(d.info).appendTo(elm);
            $('<p>').html(d.val).appendTo(elm);
            break;
          case 'html':
            elm.append(d.val);
            break;
          case 'link':
            elm.append('<br>');
            $('<a>').attr('href',d.val).html(d.info).appendTo(elm);
            break;
        }

      }
      contactInfo = elm.html();
    },'json');
  }else{
    elm.html(contactInfo);alert('hello');
  }
}
