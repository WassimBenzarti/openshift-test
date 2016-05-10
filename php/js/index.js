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
      Theater.open('itc',$(this).parents('.item').data('data'),$(e.target));
    });
    d.status = ((d.status == 'NULL')||(typeof d.status == 'undefined'))?'':d.status;
    d.status = (d.status.length > 120 )?d.status.substr(0,120)+'...':d.status;

    a.children('span').css('background-image','url('+d.blurry+')');
    a.attr('data-bg',d.images[Math.round(d['images'].length-1)].source);
    a.css('background-image','url('+a.attr('data-bg')+')');
    a.data('original','url('+d.images[0].source+')');
    (function foo(elm){
      if(document.readyState === "complete"){elm.css('background-image',elm.data('original'))}
      else{setTimeout(foo,2000,elm)}
    })(a);
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
