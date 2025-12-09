/* nav.js zhaokun 20150709 主要应用于首页右侧导航栏 */
$(document).ready(function(){
	$('.tbar-cart-item').hover(function (){ $(this).find('.p-del').show(); },function(){ $(this).find('.p-del').hide(); });
	$('.jth-item').hover(function (){ $(this).find('.add-cart-button').show(); },function(){ $(this).find('.add-cart-button').hide(); });
	$('.toolbar-tab').hover(function (){ $(this).find('.tab-text').addClass("tbar-tab-hover"); $(this).find('.footer-tab-text').addClass("tbar-tab-footer-hover"); $(this).addClass("tbar-tab-selected");},function(){ $(this).find('.tab-text').removeClass("tbar-tab-hover"); $(this).find('.footer-tab-text').removeClass("tbar-tab-footer-hover"); $(this).removeClass("tbar-tab-selected"); });
	$('.tbar-tab-cart').click(function (){ 
		$('.toolbar-wrap').removeClass('toolbar-open');
		$('.toolbar-tab').removeClass('tbar-tab-click-selected');
		$('.tbar-panel-history').css({'visibility':"hidden","z-index":"-1"});
		location.href=gouwucheurl;
	});
	$('.tbar-tab-follow').click(function (){ 
		$('.toolbar-wrap').removeClass('toolbar-open');
		$('.toolbar-tab').removeClass('tbar-tab-click-selected');
		$('.tbar-panel-history').css({'visibility':"hidden","z-index":"-1"});
		location.href=shoucangurl;
	});
	$('.tbar-tab-dingdan').click(function (){ 
		$('.toolbar-wrap').removeClass('toolbar-open');
		$('.toolbar-tab').removeClass('tbar-tab-click-selected');
		$('.tbar-panel-history').css({'visibility':"hidden","z-index":"-1"});
		location.href=dingdanurl;
	});
	$('.tbar-tab-history').click(function (){ 
		if($('.toolbar-wrap').hasClass('toolbar-open')){
			if($(this).find('.tab-text').length > 0){
				if(! $('.tbar-tab-follow').find('.tab-text').length > 0){
					var info = "<em class='tab-text '>我的收藏</em>";
					$('.tbar-tab-follow').append(info);
					$('.tbar-tab-follow').removeClass('tbar-tab-click-selected'); 
					$('.tbar-panel-follow').css({'visibility':"hidden","z-index":"-1"});
				}
				if(! $('.tbar-tab-cart').find('.tab-text').length > 0){
					var info = "<em class='tab-text '>购物车</em>";
					$('.tbar-tab-cart').append(info);
					$('.tbar-tab-cart').removeClass('tbar-tab-click-selected'); 
					$('.tbar-panel-cart').css({'visibility':"hidden","z-index":"-1"});
				}
				$(this).addClass('tbar-tab-click-selected'); 
				$(this).find('.tab-text').remove();
				$('.tbar-panel-history').css({'visibility':"visible","z-index":"1"});
				
			}else{
				var info = "<em class='tab-text '>浏览记录</em>";
				$('.toolbar-wrap').removeClass('toolbar-open');
				$(this).append(info);
				$(this).removeClass('tbar-tab-click-selected');
				$('.tbar-panel-history').css({'visibility':"hidden","z-index":"-1"});
			}
			
		}else{ 
			$(this).addClass('tbar-tab-click-selected'); 
			$(this).find('.tab-text').remove();
			$('.tbar-panel-cart').css('visibility','hidden');
			$('.tbar-panel-follow').css('visibility','hidden');
			$('.tbar-panel-history').css({'visibility':"visible","z-index":"1"});
			$('.toolbar-wrap').addClass('toolbar-open'); 
		}
	});
	$('.J-close').click(function (){
		$('.toolbar-wrap').removeClass('toolbar-open');
		$('.toolbar-tab').removeClass('tbar-tab-click-selected');
		$('.tbar-panel-history').css({'visibility':"hidden","z-index":"-1"});
	});
	
	if($.cookie("haoCook")){
	var json = eval($.cookie("haoCook"));    
		var list = "";    
		for(var i=0; i<json.length-1;i++){    
			list = list + "<li><a href='"+baseurl+"index.php/haoma/show/"+json[i].cityid+"/"+json[i].id+"/"+json[i].title+"' target='_blank'><strong><span class='text-dot'>"+json[i].title.substring(0,3)+"</span><span class='text-sub'>"+json[i].title.substring(3,7)+"</span><span class='text-yellow'>"+json[i].title.substring(json[i].title.length-4)+"</span></a></strong><span class='text-red pull-right'><i class='icon-rmb'></i>"+json[i].jiage+"</span></li>";    
		}    
		$("#chalist").html(list); //需要显示地方DIV的id，需要修改   
	}
	
});