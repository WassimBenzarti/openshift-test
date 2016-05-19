
$(function(){
  realTimeWorker();
  PHPprojectLoader.load(0,10,projectLoader,true);
  setTimeout(function(){$('#liveBackground').on('visibleEvent',function(){$(this).hide()}).on('hideEvent',function(){$(this).fadeIn(5000)}).fadeIn(5000).get(0).play()},5000);
});

function animCounter(c){
  var elm=$('#HEAD>.counter>span');
  $({percent:0}).stop(true).animate({percent:c},{
    duration:2000,
    easing:"swing",
    step:function(){
      elm.html(Math.round(this.percent));
    }
  })
}

function projectLoader(data){
  $(window).one('doLoadingComplete',function(){animCounter(data.count)});
  var article = projectsUI(data.result);
  $('#PROJECTS').append(article);
}
