<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">
		<div class="line-big padding-top">
			<div class="xm2">
				<?php $this->load->view('member_leftbar');?>
			</div>
			<div class="xm10">
			<?php $this->load->view('member_top');?>
				<div class="tabst">
					<div class="tab-head">
						<ul class="tab-nav">
							<li class="active"><a href="#tab-a"><?php echo $title;?></a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" action="" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="alert alert-yellow">
									<span class="close rotate-hover"></span><strong>注意：</strong>删除号码前先统计号码。</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_city">
												城市</label>
										</div>
										<div class="field"><input type="hidden" id="hao_city" name="hao_city" value="<?php echo $this->session->userdata('ucity');?>">
										<label class="button">
										<?php echo $ucity;?></label>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												按类型</label>
										</div>
										<div class="field">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
												<label class="button">
												<input name="hao_type" type="radio" value="<?php echo $k;?>" data-validate="radio:请选择" onchange="getvalues(this.value)" >
												<span><?php echo $v;?></span></label>
											<?php }}?>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_pinpai">
												按品牌</label>
										</div>
										<div class="field">
											<div id="pinpai_list"></div>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_time">
												按日期</label>
										</div>
										<div class="field button-group">
											<input class="button input input-auto" type="text" id="hao_time" name="hao_time" placeholder="数字" value="">
											<span class='button'>天前</span>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-button">
										<button id="hao_users" class="button bg-sub" type="button">
												<i class="ace-icon fa fa-refresh bigger-110"></i>
												统计号码<input id="del_num" name="del_num" type="hidden" value="0" />
											</button>
										<button class="button bg-red" id="del_users" type="button"><i class="icon-trash-o"></i>
												OK，删除号码</button>
									</div>
									<hr class="space" />
									<div class="form-group">
										<div class="label">
											<label for="">
												</label>
										</div>
										<div class="field"><span id="daobox" class="middle text-blue"></span><span id="haoboxs" class="middle text-red"></span>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
function getvalues(obj)
{
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.ajax({
		//提交数据的类型 POST GET
		type:"POST",
		url:baseurl+"index.php/member/getpinpai",
		data:{hao_type:obj,<?php echo $this->config->item('csrf_token_name');?>:token},
		//返回数据的格式
		datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
		//在请求之前调用的函数
		beforeSend:function(){$('#pinpai_list').html('品牌加载中……');},
		//成功返回之后调用的函数             
		success:function(data){
			$('#pinpai_list').html(decodeURI(data));
		}   ,
		//调用执行后调用的函数
		complete: function(XMLHttpRequest, textStatus){
		   //alert(XMLHttpRequest.responseText);
		   //alert(textStatus);
			//HideLoading();
		},
		//调用出错执行的函数
		error: function(){
			//请求出错处理
		}         
	 });
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#hao_users").click(function(){ 
		var hao_user='<?php echo $this->session->userdata('username');?>';
		var hao_users='';
		var hao_city=$("#hao_city").val();
		var hao_types='';
		var hao_type=$("input[name='hao_type']:checked").val();
		var hao_typet=$("input[name='hao_type']:checked").next("span").text();
		var hao_pinpais='';
		var hao_pinpai=$("input[name='hao_pinpai']:checked").val();
		var hao_pinpait=$(":radio[name='hao_pinpai']:checked").next("span").text();
		var hao_citys='<?php echo $ucity;?>';
		var hao_time=$("#hao_time").val();
		var hao_times='';
		var hao_timeo='notime';
		var hao_typeo='notype';
		var hao_pinpaio='nopinpai';
		if(hao_user){
			hao_users=hao_user+' ';
		}
		if(hao_type){
			hao_types=hao_typet+' ';
			hao_typeo=hao_type;
		}
		if(hao_pinpai){
			hao_pinpais=hao_pinpait+' ';
			hao_pinpaio=hao_pinpai;
		}
		if(hao_time){
			hao_times=hao_time+'天前';
			hao_timeo=hao_time;
		}
		if(hao_city){
			hao_citys=hao_citys+' ';
		}
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
		$.ajax({
			//提交数据的类型 POST GET
			type:"POST",
			url:baseurl+"index.php/member/get_hao_by_del",
			data:{hao_type:hao_typeo,hao_time:hao_timeo,hao_pinpai:hao_pinpaio,<?php echo $this->config->item('csrf_token_name');?>:token},
			//返回数据的格式
			datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
			//在请求之前调用的函数
			beforeSend:function(){$('#haobox').html('正在统计 '+hao_citys+hao_users+hao_times+hao_types+hao_pinpais+' 号码……');$('#haoboxs').html('');},
			//成功返回之后调用的函数             
			success:function(data){
				$('#haobox').html('');
				if(data>0){
					$('#haoboxs').html(hao_citys+hao_users+hao_times+hao_types+hao_pinpais+' 号码：'+data+ '个');
					$('#del_num').val(data);
				}else{
					$('#haoboxs').html('没有找到 '+hao_citys+hao_users+hao_times+hao_types+hao_pinpais+' 号码！');
				}
			}       
		});
	});
	$("#del_users").click(function(){ 
		var del_num=$("#del_num").val();
		if(del_num==0){
			$("#haobox").html('');
			$("#haoboxs").html('参数有误！无法删除，请先统计号码数');
		}else{
			var hao_user='<?php echo $this->session->userdata('username');?>';
			var hao_users='';
			var hao_city=$("#hao_city").val();
			var hao_types='';
			var hao_type=$("input[name='hao_type']:checked").val();
			var hao_typet=$("input[name='hao_type']:checked").next("span").text();
			var hao_pinpais='';
			var hao_pinpai=$("input[name='hao_pinpai']:checked").val();
			var hao_pinpait=$(":radio[name='hao_pinpai']:checked").next("span").text();
			var hao_citys='<?php echo $ucity;?>';
			var hao_time=$("#hao_time").val();
			var hao_times='';
			var hao_timeo='notime';
			var hao_typeo='notype';
			var hao_pinpaio='nopinpai';
			if(hao_user){
				hao_users=hao_user+' ';
			}
			if(hao_type){
				hao_types=hao_typet+' ';
				hao_typeo=hao_type;
			}
			if(hao_pinpai){
				hao_pinpais=hao_pinpait+' ';
				hao_pinpaio=hao_pinpai;
			}
			if(hao_time){
				hao_times=hao_time+'天前';
				hao_timeo=hao_time;
			}
			if(hao_city){
				hao_citys=hao_citys+' ';
			}
			var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
			$.ajax({
				//提交数据的类型 POST GET
				type:"POST",
				url:baseurl+"index.php/member/del_hao_by_del",
				data:{hao_type:hao_typeo,hao_time:hao_timeo,hao_pinpai:hao_pinpaio,<?php echo $this->config->item('csrf_token_name');?>:token},
				//返回数据的格式
				datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
				//在请求之前调用的函数
				beforeSend:function(){$('#haobox').val('正在删除……');},
				//成功返回之后调用的函数             
				success:function(data){
					if(data==1){
						$('#haoboxs').html(hao_citys+hao_users+hao_times+hao_types+hao_pinpais+'删除号码成功！');
					}else{
						$('#haoboxs').html(hao_citys+hao_users+hao_times+hao_types+hao_pinpais+'删除号码失败！');
					}
				}       
			});
		}
	});
	
});
</script>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>