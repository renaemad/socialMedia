$(document).ready(function(){
  
  $(".login-div").animate({
    left:'95px'
  },1000);
  $(".login-div").css({
    backgroundColor:'rgba(0,0,0,0.5)'
  });
  
  $(".fa-chevron-up").click(function(){
     $(".chat-panel-body").toggle(400);
  });
});

