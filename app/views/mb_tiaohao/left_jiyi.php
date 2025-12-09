<div class="margin-top bg-foxb border border-fox radius padding-bottom" id="saybox">
	<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted">
	<span class="icon-eye"></span> 浏览记录</h3>
	<script type="text/javascript">
	//$.cookie("haoCook", '', { expires: -1 }); // 删除 cookie
	//alert($.cookie("haoCook"));
		
	$(function(){   
	if($.cookie("haoCook")){
	var json = eval($.cookie("haoCook"));    
		var list = "";    
		for(var i=0; i<json.length-1;i++){    
			list = list + "<li><a href='"+baseurl+"index.php/haoma/show/"+json[i].id+"/"+json[i].title+"' target='_blank'><strong><span class='text-dot'>"+json[i].title.substring(0,3)+"</span><span class='text-sub'>"+json[i].title.substring(3,7)+"</span><span class='text-yellow'>"+json[i].title.substring(json[i].title.length-4)+"</span></a></strong><span class='text-red pull-right'><i class='icon-rmb'></i>"+json[i].jiage+"</span></li>";    
		}    
		$("#chalist").html(list); //需要显示地方DIV的id，需要修改   
	}
	});  
	</script>
	<div class="padding">
	<ul class="list-unstyle height-big text-big" id="chalist">		
	</ul>
	</div>
</div>