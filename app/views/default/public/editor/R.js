var initTop = 0;
$(document).ready(function(){ 
	$(window).scroll(function (){ 
		var ph = $("#FoxEditor-textarea").height();
		var scrollTop = $(document).scrollTop();
		 if(scrollTop > initTop){
				$(".FoxEditor-btn-container").addClass('FoxEditor-fix');
				$(".FoxEditor-btn-container").css("top", scrollTop-50);
				if(scrollTop<150){
					$(".FoxEditor-btn-container").removeClass('FoxEditor-fix');
				}
		 } else {
			  $(".FoxEditor-btn-container").addClass('FoxEditor-fix');
			  $(".FoxEditor-btn-container").css("top", initTop)
			  if(initTop<150){
				  $(".FoxEditor-btn-container").removeClass('FoxEditor-fix');
			  }
		 }
		
		if(ph<150){
			$(".FoxEditor-btn-container").removeClass('FoxEditor-fix');
		}
		initTop = scrollTop;
	}); 
}); 