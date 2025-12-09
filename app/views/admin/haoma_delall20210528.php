<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
<?php echo css_url('chosen');?>
<?php $this->load->view('common/header-meta');?>
<?php echo css_url('bootstrap-duallistbox');?>
</head>
<body class="no-skin">
<?php $this->load->view('common/header');?>
		<div class="main-container" id="main-container">
			<!-- #section:basics/sidebar -->
			<?php $this->load->view('common/sidebar');?>
			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo site_url('admin/login');?>">后台首页</a>
							</li>
							<li class="active"><?php echo $title;?></li>
						</ul><!-- /.breadcrumb -->
						<?php $this->load->view('common/topbar');?>	
						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<?php $this->load->view('common/setpager');?>
						<div class="page-header">
							<h1>
								<?php echo $title;?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo  strtoupper(Pinyin($title));?>
								</small>
							</h1>
						</div><!-- /.page-header -->
						<div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb hidden-480">
								<a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/haoma/delall');?>">按条件批量删除</a>
								<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/haoma/delalls');?>">按号码批量删除</a>
							</ul><!-- /.breadcrumb -->
						</div>

						<div class="row">
							<div class="col-xs-12">
								<form accept-charset="UTF-8" id="new_add" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="word_com">  </label>

										<div class="col-sm-9">
											<span class="pink" id="open-event" href="#" title="move down on show">
												<i class="ace-icon fa fa-bell-o"></i>
												在删除前请先统计符合条件的号码
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_city"> 按城市 </label>
										<div class="col-sm-9">
											<div class='col-xs-10 col-sm-5 col-md-3'>
												<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
												<option value=""></option>
												<option value="0">全站</option>
												<?php if($citys){
													foreach($citys as $v){?>
													<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
												<?php }}?>
												</select><input type="hidden" id="hao_citys" name="hao_citys" value=""><input type="hidden" id="hao_city" name="hao_city" value="">
												<span class="help-inline col-xs-12 col-sm-7">
													<span class="middle red"><?php echo form_error('hao_city');?></span>
												</span>
											</div>
										</div>
									</div>
									<?php }else{?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_city"> 按城市 </label>
										<div class="col-sm-9">
											<div class='col-xs-10 col-sm-5 col-md-3'><span class="middle red"><?php echo $city;?></span>
											<input type="hidden" id="hao_citys" name="hao_citys" value="<?php echo $city;?>">
											<input type="hidden" id="hao_city" name="hao_city" value="<?php echo $this->session->userdata('ucity');?>">
											</div>
										</div>
									</div>									
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_user"> 按用户 </label>
										<div class="col-sm-9">
											<div class='col-xs-10 col-sm-5 col-md-3'>
											<input id="hao_user" name="hao_user" type="text" value="" />
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_type"> 按类型 </label>
										<div class="col-sm-9">
											<div class="radio">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
											<label>
												<input name="hao_type" type="radio" class="ace" value="<?php echo $k;?>" <?php if(set_checkbox('hao_type',$k)){echo 'checked';}?> >
												<span class="lbl"> <?php echo $v;?></span>
											</label>
											<?php }}?>
											<?php if(form_error('hao_type')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_type');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">类型</span><?php }?>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_time"> 按日期 </label>
										<div class="col-sm-9">
											<div class='col-xs-10 col-sm-5 col-md-2'>
												<div class='input-group'>
												<input id="hao_time" name="hao_time" type="number" value="" />
												<span class='input-group-addon'>天前</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"> <input id="del_num" name="del_num" type="hidden" value="0" /></label>
										<div class="col-sm-9">
											<div class='col-xs-10 col-sm-5'>
												<span id="haobox" class="middle blue"></span><span id="haoboxs" class="middle red"></span>
											</div>
										</div>
									</div>
									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button id="hao_users" class="btn btn-info" type="button">
												<i class="ace-icon fa fa-refresh bigger-110"></i>
												统计号码
											</button>
											<button id="del_users" class="btn btn-success" type="button">
												<i class="ace-icon fa fa-check bigger-110"></i>
												确认删除号码
											</button>
										</div>
									</div>
								</form>
						</div>
					</div><!-- /.row -->

			<?php $this->load->view('common/footer');?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
<!--[if !IE]> -->
<script type="text/javascript">
	window.jQuery || document.write("<?php echo jjs_url('jquery');?>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<?php echo jjs_url('jquery1x');?>");
</script>
<![endif]-->

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<?php echo jjs_url('jquery.mobile.custom');?>");
</script>
<?php echo js_url('bootstrap');?>
<!-- page specific plugin scripts -->
<?php echo js_url('jquery.bootstrap-duallistbox');?>
<?php echo js_url('bootstrap-multiselect');?>

<!--[if lte IE 8]>
	<?php echo js_url('excanvas');?>
<![endif]-->
<script type="text/javascript">
jQuery(function($){
	if(!ace.vars['touch']) {
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize

		$(window)
		.off('resize.chosen')
		.on('resize.chosen', function() {
			$('.chosen-select').each(function() {
				 var $this = $(this);
				 $this.next().css({'width': '150px'});				
			})
		}).trigger('resize.chosen');
		//resize chosen on sidebar collapse/expand
		$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
			if(event_name != 'sidebar_collapsed') return;
			$('.chosen-select').each(function() {
				 var $this = $(this);
				 $this.next().css({'width': '150px'});
			})
		});

	}	
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
});
function getvalues(obj)
{
	var c=obj.options[obj.selectedIndex].value;
	var d=obj.options[obj.selectedIndex].text; 
    $("input[name='hao_city']").attr("value",c);
    $("input[name='hao_citys']").attr("value",d);
}
</script>
<?php echo js_url('jquery-ui.custom');?>
<?php echo js_url('jquery.ui.touch-punch');?>
<?php echo js_url('chosen.jquery');?>

<!-- ace scripts -->
<?php echo js_url('ace/elements.scroller');?>
<?php echo js_url('ace/elements.colorpicker');?>
<?php echo js_url('ace/ace');?>
<?php echo js_url('ace/ace.ajax-content');?>
<?php echo js_url('ace/ace.touch-drag');?>
<?php echo js_url('ace/ace.sidebar');?>
<?php echo js_url('ace/ace.sidebar-scroll-1');?>
<?php echo js_url('ace/ace.submenu-hover');?>
<?php echo js_url('ace/ace.widget-box');?>
<?php echo js_url('ace/ace.settings');?>
<?php echo js_url('ace/ace.settings-rtl');?>
<?php echo js_url('ace/ace.settings-skin');?>
<?php echo js_url('ace/ace.widget-on-reload');?>
<?php echo js_url('ace/ace.searchbox-autocomplete');?>
<?php echo js_url('jquery.upload');?>
<script type="text/javascript">
$(document).ready(function(){
	$("#hao_users").click(function(){ 
		var hao_user=$("#hao_user").val();
		var hao_users='';
		var hao_city=$("#hao_city").val();
		var hao_citys=$("#hao_citys").val();
		var hao_time=$("#hao_time").val();
		var hao_times='';
		var hao_type=$('input[name="hao_type"]:checked').val();
		var hao_types=$('input[name="hao_type"]:checked').next("span").text();
		if(!hao_user && !hao_time && !hao_city && !hao_type){
			$("#haoboxs").html('');
			$("#haobox").html('相关参数必须选择一项');
		}else{
			if(hao_user){
				hao_users=hao_user+' ';
			}
			if(hao_time){
				hao_times=hao_time+'天前';
			}
			if(hao_city){
				hao_citys=hao_citys+' ';
			}
			if(hao_type){
				hao_types=hao_types+' ';
			}
			var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
			$.ajax({
				//提交数据的类型 POST GET
				type:"POST",
				url:baseurl+"index.php/admin/haoma/get_hao_by_del",
				data:{hao_user:hao_user,hao_time:hao_time,hao_city:hao_city,hao_type:hao_type,<?php echo $this->config->item('csrf_token_name');?>:token},
				//返回数据的格式
				datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
				//在请求之前调用的函数
				beforeSend:function(){$('#haobox').html('正在统计 '+hao_citys+hao_users+hao_times+hao_types+' 号码……');$('#haoboxs').html('');},
				//成功返回之后调用的函数             
				success:function(data){
					$('#haobox').html('');
					if(data>0){
						$('#haoboxs').html(hao_citys+hao_users+hao_times+hao_types+' 号码：'+data+ '个');
						$('#del_num').val(data);
					}else{
						$('#haoboxs').html('没有找到 '+hao_citys+hao_users+hao_times+hao_types+' 号码！');
					}
				}       
			});
		}
	});
	$("#del_users").click(function(){ 
		var del_num=$("#del_num").val();
		if(del_num==0){
			$("#haobox").html('');
			$("#haoboxs").html('参数有误，请先统计号码数');
		}else{
			var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
			var hao_user=$("#hao_user").val();
			var hao_time=$("#hao_time").val();
			var hao_city=$("#hao_city").val();
			var hao_type=$('input[name="hao_type"]:checked').val();
			$.ajax({
				//提交数据的类型 POST GET
				type:"POST",
				url:baseurl+"index.php/admin/haoma/del_hao_by_del",
				data:{hao_user:hao_user,hao_time:hao_time,hao_city:hao_city,hao_type:hao_type,<?php echo $this->config->item('csrf_token_name');?>:token},
				//返回数据的格式
				datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
				//在请求之前调用的函数
				beforeSend:function(){$('#haobox').val('正在删除……');},
				//成功返回之后调用的函数             
				success:function(data){
					if(data==1){
						$('#haoboxs').html('删除号码成功！');
					}else{
						$('#haoboxs').html('删除号码失败！');
					}
				}       
			});
		}
	});
	
});
</script>
</body>
</html>
