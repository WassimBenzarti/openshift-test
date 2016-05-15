function PHPImageLoader(id){
  var self=this;
  this.id = id;
  this.elm=$(self.id);
  this.wall=new freewall(self.id);
  this.wall.reset({
    gutterX:10,
    gutterY:10,
    cellH:150,
    onResize:function(elm){this.fitWidth()}
  });
  this.engine = ImageLoader;
  this.order=0;
  this.loadImages=function(page,number,onComplete,btn){
    if(page === undefined) page = self.order;
    if(number === undefined) number = 5;
    onComplete = onComplete || function(){};
    $.get('/php/loadImages.php?nb='+number+'&pg='+page,function(data){
      for(var i = 0;i<data.length;i++) {
        var d = data[i];
        d.created_time=timeAgo(d.created_time);
        d.images = $.parseJSON(d.images);
        d.title=(d.title && d.title.length>0)?d.title:(d.status.substr(0,d.status.indexOf(' '))+'...');
      }

      self.engine(data,self.elm);
      self.fitWidth();
      self.order=page+data.length;
      if(btn && data.length<number){btn.animate({'opacity':0},function(){$(this).slideUp()})};
    },'json');
  }
  this.fitWidth = function(){
    var h = self.elm.parent().height();
    self.wall.fitWidth();
    var toh=self.elm.parent().height();
    self.elm.parent().height(h).animate({height:toh},500,function(){
      $(this).css('height','auto').children('.load');
    });

  }
  this.loadMoreClick=function(elm){
    self.loadImages(self.order,9,showOnScroll,$(elm).parent());
  }
}
