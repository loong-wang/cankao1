<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
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

						<div class="row">
							<div class="col-xs-12">
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/webset/sms');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_type"> 发送方式 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label>
													<input name="sms_type" type="radio" class="ace" value="off" <?php if($this->config->item('sms_type')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>												
												<label>
													<input name="sms_type" type="radio" class="ace" value="on" <?php if($this->config->item('sms_type')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>

											<span class="help-block col-sm-reset inline hidden-480"></span>
											</div>
										</div>
									</div>	
									<div class="hr hr-16 hr-dotted"></div>
									<div class="widget-title blue smaller col-xs-12">
										<h4 class="col-xs-6">
											<i class="ace-icon fa fa-rss orange"></i>
											SMS通道
										</h4>
										<span class="pull-right inline text-right col-xs-6 hidden-480">
											<a href="http://sms.ihuyi.com/login.html" target="_blank" data-action="reload">
												<i class="ace-icon fa fa-hand-o-right"></i>
											</a>
										</span>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_user"> 通道帐号 </label>

										<div class="col-sm-9">
											<input type="text" id="sms_user" name="sms_user" placeholder="通道帐号" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('sms_user');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">通道帐号</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_key"> 通道key </label>

										<div class="col-sm-9">
											<input type="password" id="sms_key" name="sms_key" placeholder="通道key" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('sms_key');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">通道key</span>
										</div>
									</div>	
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_moban_jihuo"> 激活码模板 </label>

										<div class="col-sm-9">
											<input type="text" id="sms_moban_jihuo" name="sms_moban_jihuo" placeholder="激活码模板" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('sms_moban_jihuo');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">激活码模板</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_moban_order"> 订单模板 </label>

										<div class="col-sm-9">
											<input type="text" id="sms_moban_order" name="sms_moban_order" placeholder="订单模板" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('sms_moban_order');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">用户订单通知模板</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sms_moban_order_me"> 客服模板 </label>

										<div class="col-sm-9">
											<input type="text" id="sms_moban_order_me" name="sms_moban_order_me" placeholder="客服模板" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('sms_moban_order_me');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">用户下单通知客服模板</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="test_shouji"> 测试发送 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="test_shouji" name="test_shouji" type="text" value="" />
											<span class='input-group-addon'><input id="send_test_shouji" type="button" value="发送"></span>
											</div>
											<span class="help-block col-sm-reset inline red" id="send_txt"></span>
										</div>
									</div>
																		
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="shouji_order"> 发送下单短信 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="shouji_order" type="radio" class="ace" value="on" <?php if($this->config->item('shouji_order')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="shouji_order" type="radio" class="ace" value="off" <?php if($this->config->item('shouji_order')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">下单时给会员发送短信</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="shouji_order_me"> 通知下单短信 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="shouji_order_me" type="radio" class="ace" value="on" <?php if($this->config->item('shouji_order_me')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="shouji_order_me" type="radio" class="ace" value="off" <?php if($this->config->item('shouji_order_me')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">下单时给客服发送短信</span>
											</div>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												确认提交
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
jQuery(function($){
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#send_test_shouji").click(function(){ 
		var shouji=$('#test_shouji').val();
		var reg = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/; 
        if(!reg.test(shouji)){
			$('#send_txt').html('请填写正确的手机号码');
		}else{
			test_shouji(shouji);
		}	 
	});
});
function test_shouji(shouji) {	
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.ajax({
		//提交数据的类型 POST GET
		type:"POST",
		url:baseurl+"index.php/admin/webset/sendsms",
		data:{shouji:shouji,<?php echo $this->config->item('csrf_token_name');?>:token},
		//返回数据的格式
		datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
		//在请求之前调用的函数
		beforeSend:function(){$('#send_txt').html('测试短信发送中……');},
		//成功返回之后调用的函数             
		success:function(data){
			$('#send_txt').html(decodeURI(data));
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
</body>
</html>
