$(function(){

	'use strict';

	$('.login-page h1 span').click(function(){

		$(this).addClass('selected').siblings().removeClass('selected');
		$('.login-page form').hide();
		$('.'+ $(this).data('class')).fadeIn(200);
	});

 // confirmation messege in button 

 $('.confirm').click(function(){

 	return confirm('Are You Sure ?');
 });

 	$('.live-name').keyup(function() {
 		$('.live-preview .caption h3').text( $(this).val() );
 	});

 	$('.live-desc').keyup(function() {
 		$('.live-preview .caption p').text( $(this).val() );
 	});

 	$('.live-price').keyup(function() {
 		$('.live-preview .price').text('$' + $(this).val() );
 	});

});
