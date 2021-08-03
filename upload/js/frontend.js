$(function() {

$('.login-page h1 span').click(function(){
	$(this).addClass('selected').siblings().removeClass('selected');
	$('.login-page form').hide();
	$('.' + $(this).data('class')).fadeIn(500);
});

$('.live').keyup(function (){
		$($(this).data('class')).text($(this).val());
});
 
});