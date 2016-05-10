var PHPprojectLoader = new function(){
  var self = this;
  this.count=0;
  this.load=function(page,number,onComplete,count){
    page = page || self.count;
    number = number || -1;
    count = (count)? '&count' : '' ;
    $.get('/php/loadProjects.php?pg='+page+'&nb='+number+count,function(data){
      onComplete(data);
    },'json');
  }
}
function callPlayer(iframe, func, args) {
    if (iframe) {
        iframe.contentWindow.postMessage(JSON.stringify({
            "event": "command",
            "func": func,
            "args": args || []
        }), "*");
    }
}
