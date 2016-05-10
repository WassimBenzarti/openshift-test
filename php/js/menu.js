$(function(){
  var $menu = $('#menu');
  $menu.find("span.icon").click(function(e){
    $(this).toggleClass('is-active');
    addRippleEffect(e);
    $menu.trigger("menuToggle");
  });
  $menu.find('nav li').children("span").each(function(index){$(this).css('background-color',get_random_color(index))});
  $menu.on('menuToggle',function(){
    $(this).toggleClass('open');
  });

});
