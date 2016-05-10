
$(function(){console.log("project.js loaded");
  realTimeWorker();
  PHPprojectLoader.load(0,10,projectLoader,true);
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
  var article = projectsUI(data.result);console.log(article);
  $('#PROJECTS').append(article);
}
