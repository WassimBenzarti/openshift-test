///////CREDITS/////////
/// WASSIM BENZARTI ///
///// JUN, 1 2015//////

function loadingCircle(canvas){
        var self=this;
        var ctx = canvas.get(0).getContext('2d');
        this.colorText = "#AAA";
        this.colorStroke = "#000";
        this.lineWidth = 5;
        this.font = "100 30px sans-serif";
        cw = ctx.canvas.width ; ch = ctx.canvas.height;
        frames = 30;rotation_speed=5;angle=10;speed=5;
        var interv;
        clearTimeout(interv);
        this.anim = function(frames,rotation_speed,speed,angle){
            frames = frames || 20;
            rotation_speed = rotation_speed || 6;
            speed = speed || 4;
            angle = angle || 8;
            ctx.fillStyle=this.colorText;
            ctx.strokeStyle = this.colorStroke;
            ctx.lineCap='round';
            ctx.lineWidth = this.lineWidth;
            ctx.font = this.font;
            ctx.textAlign = "center";
            i=0;
            x= 0,y=1; min= 0; max= Math.PI; miny= 0; maxy= Math.PI;
            var count=0;
            function progressDraw(){
                function easeInOutExpo(t, b, c, d) {
                    if (t==0) return b;
                    if (t==d) return b+c;
                    if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
                    return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
                }
                ctx.clearRect(0,0,cw,ch);
                ctx.beginPath();
                w = easeInOutExpo(x*2,min,max-min,max-min);
                z = easeInOutExpo(y*2,miny,maxy-miny,maxy-miny);
                ctx.arc(cw/2,ch/2,cw/3, w+i, z+0.4+i);
                ctx.stroke();
                x+=speed/100;
                y+=speed/100;
                i+=0.03*rotation_speed/5;
                if(w>=max-0.01){min = max;max=(max+6.2831853071*angle/10)%(Math.PI*2);if (max<min){min-=Math.PI*2};x=0}
                if(z>=maxy-0.01){miny = maxy;maxy=(maxy+6.2831853071*angle/10)%(Math.PI*2);if (maxy<miny) miny-=Math.PI*2;y=0}
                if($(document.body).hasClass('loading')){interv = setTimeout(requestAnimFrame,frames,progressDraw);}
            };
            interv=0;
            interv = setTimeout(requestAnimFrame,frames,progressDraw);
        }
        this.stop = function(domLoad,onComplete){
          onComplete = onComplete || function(){};
          function quitPhase(){
            clearTimeout(interv);
            $('html, body').css("overflow","");
            $('body').removeClass('loading');
            setTimeout(onComplete,2000);
          }
          if(domLoad){
            setTimeout(function(){
              if (document.readyState === "complete" && $('body').hasClass('loading')) {
                quitPhase()
              }else{
                self.stop(true,onComplete);
              }
            },1000);
          }else{
            quitPhase();
          }
        }
        this.update = function(){
            clearTimeout(interv);
            self.anim();
        }
}
function doLoading(domLoad,onProgress,onComplete){
  onProgress = onProgress || function(){};
  onComplete = onComplete || function(){};
  $('body').addClass('loading');
  (function loading(){
    onProgress();
    function quitPhase(){
      clearTimeout(interv);
      $('html, body').css("overflow","");
      $('body').removeClass('loading');
      setTimeout(onComplete,2000);
    }
    if(domLoad){
      setTimeout(function(){
        if (document.readyState === "complete" && $('body').hasClass('loading')) {
          quitPhase()
        }else{
          self.stop(true,onComplete);
        }
      },1000);
    }else{
      quitPhase();
    }
  },$(document.body));
  $('#loadingHeader').width($(document.body).width());
  $('html, body').css("overflow","hidden");
}
LOADER = new function(){
  var self = this;
  self.interv=null;
  self.onProgress=function(){};
  self.onComplete=function(){};
  self.doLoading = function(domLoad,onProgress,onComplete){
    if(typeof onProgress === 'function')self.onProgress=onProgress;
    if(typeof onComplete === 'function')self.onComplete=onComplete;
    var body = $('body');

    /* INIT */
    body.addClass('loading');
    $('html, body').css("overflow","hidden");
    /* FINISH */
    function quitPhase(body){
      clearTimeout(self.interv);
      $('html, body').css("overflow","");
      body.removeClass('loading');
      setTimeout(self.onComplete,2000);
    }
    function repeat(){
      self.onProgress();
      if(domLoad){
        if (document.readyState === "complete" && body.hasClass('loading')) {
          quitPhase(body);console.log('completed')
        }else{
          self.interv = setTimeout(repeat,1000,domLoad,body,quitPhase);
        }
      }else{
        quitPhase(body);
      }
    }
    setTimeout(repeat,2000,domLoad,body,quitPhase);
  }
}
