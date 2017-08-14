$(function(){
    'use strict';
// header height
    $('.header').height($(window).height());
    $(window).resize(function(){
      $('.header').height($(window).height());  
    });
    $('.links li').click(function(){
       $(this).addClass('active').siblings().removeClass('active'); 
    });
   //make item center
    $('.bxslider').each(function(){
      $(this).css('paddingTop',(677-$('.bxslider li').height())/2);  
    });
  $('.bxslider').bxSlider({
      pager:false
  });  
    $('.links li a').click(function(){
       $('html,body').animate({
         scrollTop:$('#' + $(this).data('value')).offset().top 
       },1000);
    });
    
    (function auto(){
       $('.slider .active').each(function(){
          if(!$(this).is(':last-child')){
              $(this).delay(3000).fadeOut(1000,function(){
              $(this).removeClass('active').next().addClass('active').fadeIn(1000);    
              auto();
              });
          } 
           else{
               $(this).delay(3000).fadeOut(1000,function(){
               $(this).removeClass('active');
               $('.slider div').eq(0).addClass('active').fadeIn();
                   auto();
           });
           }
       });
    }());
    
});