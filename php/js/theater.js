 THEATER = function(){
  var self = this;
  this.tag = '';
  this.enabled = false;
  this.overlay = '';
  this.init=function(){
    self.tag=$('<div id="THEATER" class="move">').css('top',window.pageYOffset).click(self.close);
    $(document.body).width($(document.body).outerWidth()).css('top',-window.pageYOffset).addClass('noScroll');
    self.tag.width($(window).outerWidth());
    self.overlay = $('<div id="TOVERLAY">');
    self.enabled = true;
  }
  this.open=function(type,d,elm){console.log(d);
    if(self.enabled){return;}
    
    self.elm = elm.clone(true,true);
    self.original = elm.css({opacity:0});
    elm = self.elm;
    self.init();
    var vWidth=$(window).outerWidth()*0.8;
    var vHeight=$(window).outerHeight()*0.8;
    var container=$('<div id="container">').appendTo(self.tag);
    if(type.indexOf('i')>-1 && typeof elm != 'undefined'){
      elm.addClass('img').appendTo(container);
      var ratio = parseFloat(d.width)/parseFloat(d.height);
      var height;

      elm.addClass('gradient').find(".likeBtn,.commentBtn").css('bottom',0);
      console.log(ratio);
      if(ratio > 1.2){
        height=(vHeight>vWidth)?vWidth/ratio:vHeight;
        elm.width((vHeight>vWidth)?vWidth:vHeight*ratio).height(height).css('margin',(($(window).outerHeight()-height)/2)+'px auto');
      }else if(ratio<0.8){
        height=vHeight;
        elm.width(vHeight*ratio).height(height).css('margin',(($(window).outerHeight()-height)/2)+'px auto');
      }else{
        height=Math.min(vWidth*75/100,vHeight);
        elm.width(height).height(height).css('margin',(($(window).outerHeight()-height)/2)+'px auto');
      }
      if(typeof self.original !== 'undefined'){
        function cPt(elm){
          return [elm.offset().left+(elm.width()/2),elm.offset().top+(elm.height()/2)];
        }
        var elmRatio = parseFloat(self.original.width())/parseFloat(self.original.height());
        var offScale = 0;

        if(ratio > elmRatio){
          offScale = self.original.height()/self.elm.height();
        }else{
          offScale = self.original.width()/self.elm.width();
        }
            //offX= cPt(self.original)[0] - ($(window).outerWidth()/2) ,
            //offY = cPt(self.original)[1] - ($(window).outerHeight()/2);
            //offScale = self.original.width()/self.elm.width(),
        var offX = cPt(self.original)[0] - (self.elm.width()*offScale/2) - (($(document.body).outerWidth()-self.elm.width())/2),
            offY = cPt(self.original)[1] - (self.elm.height()*offScale/2) - (($(window).outerHeight()-self.elm.height())/2);
        setVendor(self.elm.get(0),'Transform','translate3d('+offX+'px,'+offY+'px,0px) scale('+offScale+')');
        elm.data('data-transform',[offX,offY,offScale]);
        setTimeout(function(){setVendor(elm.get(0),'Transform','');self.overlay.addClass('shown');},100);
        setTimeout(function(){self.tag.removeClass('move')},1000);
      }
      self.tag.append(elm);
    }
    if(type.indexOf('v')>-1){

    }
    if(type.indexOf('t')>-1){
      var title=$('<h1 class="title">').html(d.title).css({'background-color':d.color,color:get_bw_color(d.color)}).appendTo(container);
      var status=$('<p class="status">').html(d.status);
      container.append(title,status);
    }
    if(type.indexOf('c')>-1){
      var comments=$('<div class="comments">');
      var form = $('<form onsubmit="return commentImage(this);">').data('id',d.id).append('<input name=set autocomplete="off" type="text" onFocus=$(this).parent().addClass("active") onBlur=$(this).parent().removeClass("active") placeHolder="Tell me what you think...">');
      var p = new PHPCommentsLoader(comments);
      p.loadById(d.id);

      container.append(comments,form);
      comments.hover(function(){
        $(this).scroll(function(){
          $(this).parents('#THEATER').css({
              'overflow': 'hidden',
              'height': '100%'
          });
        });
      },function(){
        $(this).unbind('scroll').parents('#THEATER').css({
            'overflow': '',
            'height': ''
        });
      });
    }
    container.appendTo(self.tag);
    $('body').append(self.overlay,self.tag);
    //History.pushState({"html":$(document.body).find('#mainContainer').html(),"pageTitle":document.title}, document.title, window.location.pathname);
  }
  this.close=function(e){
    if(!self.enabled || (typeof e != "undefined" && $(e.target).attr('id')!='THEATER')) return;
    var off = self.elm.data('data-transform');
    setVendor(self.elm.get(0),'Transform','translate3d('+off[0]+'px,'+(off[1]+self.tag.scrollTop())+'px,0px) scale('+off[2]+')');
    self.tag.css("pointer-events","none");
    self.overlay.removeClass('shown');

    self.original.css({'opacity':1});
    $(document.body).focus().removeClass('noScroll').scrollTop(-parseInt($(document.body).css('top'))).css({top:'',width:''});
    self.tag.addClass('move').delay(500).fadeOut(500,function(){
      $(this).remove();
      self.overlay.remove();
      self.enabled=false;

      $(window).off('statechange');
      History.Adapter.bind(window,'statechange',History.buildHandler);
      if(History.getState().title=="Theater") History.back();
    });

  }
}
Theater = new THEATER();



function PHPCommentsLoader(container){
  var self = this;
  this.container = container;
  this.loadById=function(id){
    $.get("/php/comments.php?fbid="+id,function(data){
      if(data.error){
        if(self.container.children('.brick').length==0){self.container.append('<p>No comments</p>');}
        self.container.find('.nextBtn').slideUp();
      }
      else{
        var initialHeight=0;
        for(var i=0;i<data.data.length;i++){
          var d=data.data[i];
          var brick = initComment(d);
          brick.prependTo(self.container);
          initialHeight += brick.outerHeight();
          brick.hide().slideDown();
        }
        if(typeof data.next != 'undefined'){
          var next=self.container.find('.nextBtn');
          if(next.length==0){
            next = $('<span class="nextBtn">Load more</span>');
          }
          next.data('src',data.next).prependTo(self.container);
          next.children().removeClass('show');
          initialHeight += next.outerHeight();
          next.click(function(e){
            addRippleEffect(e);
            self.loadById($(this).data('src'));
            $(this).unbind();
          });
        }
        self.container.animate({scrollTop:initialHeight-2});
      }
    },'json');
  }

}
function initComment(d){
  var brick = $('<div class="brick">');
  var img=$('<span class=pic>').css('background-color',get_random_color());
  var name=$('<h2 class=name>').html("Anonymous");
  if(typeof d.from != 'undefined'){
    img.css('background-image','url(https://graph.facebook.com/'+d.from.id+'/picture?type=square)');
    name=$('<h2 class=name>').html(d.from.name);
  }
  var message=$('<p class=message>').html(d.message);
  var date = $('<span class=date>').html('∙ '+timeAgo(d.created_time));
  return brick.append(img,name,date,message);

}
function commentImage(elm){
  ///test comment more than 1 char && POSSSSSTTT
  if(elm.set.value.length <1 || elm.set.value.length >1000){return false;}
  $.post('/php/comments.php?fbid='+$(elm).data('id'),$(elm).serialize());
  var brick = initComment({'created_time':Date(),'message':elm.set.value});
  var wrapper = $(elm).parent().find('.comments');
  if(wrapper.children('p').length >0){wrapper.children('p').remove()}
  wrapper.append(brick.hide().fadeIn()).animate({scrollTop:wrapper.get(0).scrollHeight},1000);
  elm.reset();
  return false;
}
