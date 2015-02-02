// JavaScript Document
;(function($){
	$(window).scroll(function(){
		setTimeout(function(){
			if($('body').scrollTop()>500){
				$("#back-to-top").show();
			}else{
				$("#back-to-top").hide();
			}	
		},500);
	});
	
	$("#back-to-top").click(function(){
		$('body').animate({scrollTop:0},400);
	});
})(jQuery);

