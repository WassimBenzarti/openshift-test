function ProgressBar(id,value){
  var self=this;
  this.elm = id;
  this.val = (typeof value ==='undefined')?0:value;
  function init(){
    var inside=self.elm.children(".progress");
    if(inside.length == 0) $("<span class='progress'>").prependTo(self.elm);
  }
  this.load=function(val){
    if(typeof val === "undefined") val=this.val;

    var inside = $(self.elm);
    self.elm.children(".progress").attr('data-value',val).width(0).width(this.elm.width()*val/100);
  }
  init();
}
