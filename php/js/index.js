$(function(){
  artImages = new PHPImageLoader('#firewallContainer');
  artImages.loadImages(0,9);
  artImages.loadImages(0,9);
  artImages.loadImages(0,9);
  artImages.loadImages(0,9);
  realTimeWorker();
  PHPprojectLoader.load(0,1,projectLoader);
  setTimeout(function(){$('#liveBackground').on('visibleEvent',function(){$(this).hide()}).on('hideEvent',function(){$(this).fadeIn()}).fadeIn(2000).get(0).play()},5000);
});
function ImageLoader(data,wrapper){
  for(i=0;i<data.length;i++){
    var d = data[i];
    var a= $('<a class="img">');
    $('<span>').append($('<span>').css("background",get_bw_color(d.color,true))).appendTo(a);
    a.attr('href',"#"+d['id']);
    a.click(function(e){
      e.preventDefault();
      $(this).css({'background-image':'url('+$(this).data('original')+')'});
      Theater.open('itc',$(this).parents('.item').data('data'),$(this));
    });
    d.status = ((d.status == 'NULL')||(typeof d.status == 'undefined'))?'':d.status;
    d.status = (d.status.length > 120 )?d.status.substr(0,120)+'...':d.status;

    a.children('span').css('background-image','url('+d.blurry+')');
    a.attr('data-bg',d.images[d.images.length-1].source);
    a.css('background-image','url('+a.attr('data-bg')+')');
    a.data('original',d.images[0].source);
    (function foo(elm,v){
      if(document.readyState === "complete" && v.readyState === 4){console.log('done');

      var p = new Image();
      p.src = elm.data('original');
      $(p).data('elm',elm)
      p.onload = function(){
        $(this).data('elm').css('background-image','url('+elm.data('original')+')');
        console.log('done loaded');
      }
    }
      else{setTimeout(foo,10000,elm,v)}
    })(a,$('#liveBackground').get(0));
    var solidColor = $('<span class="color">').css('background-color',d.color);
    var div = $('<div class="item onScroll load">').append(solidColor).append(a).data('data',d);
    div.attr('data-status',d.status);
    div.attr('data-date',d.created_time);
    div.width(Math.round(d.images[Math.round(d.images.length/2)].width));
    div.height(Math.round(d.images[Math.round(d.images.length/2)].height));
    div.css("color",get_bw_color(d.color));
    wrapper.append(div);
  }
}

function projectLoader(data){
  var article = projectsUI(data);
  $('#projectList').append(article);
}
