$(function(){
  getContact($('#CONTACT').children('#contactInfo'));
  pageDotInit();
});
function pageDotInit(){
  var e = $('#CONTACT>form').children('#question');
  var pages= $('#pageDot');
  e.each(function(i,l){
    $('<span>').appendTo(pages).click(function(){console.log('hello');
      e.eq(i).find('input,textarea').focus();
    })
  });
}
function focusTextBox(elm,foc){
  if(foc){
    $(elm).parents('form').children().removeClass('now prev next');
    $(elm).parents('.textbox').addClass('focused');
    var q = $(elm).parents('#question');
    q.addClass('now').prev().addClass('prev');
    q.nextAll('#question,#button').first().addClass('next');
    $('#pageDot').children().removeClass('selected').eq(q.data('nb')).addClass("selected");
  }else if(!foc && elm.value.length==0){
    $(elm).parents('.textbox').removeClass('focused');
  }
}
function focusTextBoxKey(elm,e){
  if(e.keyCode == 13 || e.keyCode == 40){
    $(elm).parents('form').find('.next').find('input,textarea').focus();
  }else if(e.keyCode == 38){
    $(elm).parents('form').find('.prev').find('input,textarea').focus();
  }
}

function validate(f){
  function errorMsg($elm,ch){
    if(!$elm.prev().hasClass('error')){
      $elm.before($('<div id="phrase" class="error">').append($('<h2>').html(ch)));
      setTimeout(function(elm){elm.prev('.error').fadeOut(500,function(){$(this).prevAll('#question').first().addClass('prev').next().remove()})},2000,$elm)
    }else{
        $elm.prev('.error').show();
    }

  }
  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
  var ch=f.name;
  if(!/^[a-zA-Z ]{2,30}$/.test(ch.value)){
    errorMsg($(ch).parents('#question'),'Please write a valid Name');
    ch.focus();
    return false;
  }
  ch = f.msg;
  if(f.msg.value.length<10 || f.msg.value.length >1000){
    errorMsg($(ch).parents('#question'),'Please fill out this field');
    ch.focus();
    return false;
  }
  ch = f.email;
  if(!validateEmail(ch.value)){
    errorMsg($(ch).parents('#question'),'Please write a valid Email');
    ch.focus();
    return false;
  }
  setTimeout(function(){
    $.post('/php/contact.php',$(f).serialize(),function(data){
          if(data.error == -1){
            if (typeof data.msg !== "undefined") alert(data.msg);
            $('#button').removeClass('loading success').addClass('fail');
            return false;
          }else if(data.error == 0){
            $('#button').removeClass('loading fail').addClass('success');

          }else{
            errorMsg($(f).children("#question").eq(data.error-1));
          }
    },'json').fail(function(){$('#button').removeClass('loading success').addClass('fail');});
  },1000)
  $('#button').toggleClass('loading');
  return false;
}
