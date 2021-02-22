$(function(){
	'use strict';
	$('.toggle-info').click(function(){
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
		if($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		} else {
			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
	}); 

var passFaild = $('.password');

$('.show-pass').hover( function () {

	passFaild.attr('type','text');

  }, function (){

  	passFaild.attr('type','password');
  });

 // confirmation messege in button 

 $('.confirm').click(function(){

 	return confirm('Are You Sure ?');
 });

 // Categories View Option

$('.cat h3').click( function () {
	$(this).next('.full-view').fadeToggle(200);
});
$('.option span').click(function(){
	$(this).addClass('active').siblings('span').removeClass();

	if ($(this).data('view') === 'full'){
		$('.cat .full-view').fadeIn(200);
	}else{
		$('.cat .full-view').fadeOut(200);
	}
});

		 $('.child-link').hover(function(){
		 	$(this).find('.show-delet').fadeIn(400);

		 }, function(){
		 	$(this).find('.show-delet').fadeOut(400);

		 });

});