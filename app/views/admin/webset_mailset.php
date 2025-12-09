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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/webset/email');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mail_type"> 发送方式 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_type" type="radio" class="ace" value="off" <?php if($this->config->item('mail_type')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_type" type="radio" class="ace" value="smtp" <?php if($this->config->item('mail_type')=='smtp'){echo 'checked';}?> >
													<span class="lbl"> SMTP</span>
												</label>

											<span class="help-block col-sm-reset inline hidden-480"></span>
											</div>
										</div>
									</div>	
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="smtp_host"> SMTP 服务器 </label>

										<div class="col-sm-9">
											<input type="text" id="smtp_host" name="smtp_host" placeholder="SMTP 服务器" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('smtp_host');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">如：smtp.163.com</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="smtp_port"> SMTP端口 </label>

										<div class="col-sm-9">
											<input type="text" id="smtp_port" name="smtp_port" placeholder="SMTP端口" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('smtp_port');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">SMTP端口，默认25</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="smtp_user"> 发信人邮件地址 </label>

										<div class="col-sm-9">
											<input type="text" id="smtp_user" name="smtp_user" placeholder="发信人邮件地址" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('smtp_user');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											@发信人邮件地址
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="smtp_pass"> 邮箱密码 </label>

										<div class="col-sm-9">
											<input type="password" id="smtp_pass" name="smtp_pass" placeholder="邮箱密码" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('smtp_pass');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											@发信人邮箱密码
											</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="test_mail"> 测试发送 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="test_mail" name="test_mail" type="text" value="" />
											<span class='input-group-addon'><input id="send_test_mail" type="button" value="发送"></span>
											</div>
											<span class="help-block col-sm-reset inline red" id="send_txt"></span>
										</div>
									</div>
																		
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mail_reg"> 发送注册邮件 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_reg" type="radio" class="ace" value="on" <?php if($this->config->item('mail_reg')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_reg" type="radio" class="ace" value="off" <?php if($this->config->item('mail_reg')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline hidden-480">注册时发送邮件</span>
											</div>
										</div>
									</div>	
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mail_order"> 发送下单邮件 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_order" type="radio" class="ace" value="on" <?php if($this->config->item('mail_order')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_order" type="radio" class="ace" value="off" <?php if($this->config->item('mail_order')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">下单时给会员发送邮件</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mail_order_me"> 通知下单邮件 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_order_me" type="radio" class="ace" value="on" <?php if($this->config->item('mail_order_me')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_order_me" type="radio" class="ace" value="off" <?php if($this->config->item('mail_order_me')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">下单时给客服发送邮件</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mail_question"> 发送提问邮件 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_question" type="radio" class="ace" value="on" <?php if($this->config->item('mail_question')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="mail_question" type="radio" class="ace" value="off" <?php if($this->config->item('mail_question')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">提问时给客服发送邮件</span>
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
	$("#send_test_mail").click(function(){ 
		var toemail=$('#test_mail').val();
		var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; //验证邮箱
        if(!reg.test(toemail)){
			$('#send_txt').html('请填写正确的接收邮件地址');
		}else{
			send_email(toemail);
		}	 
	});
});
function send_email(toemail) {	
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.ajax({
		//提交数据的类型 POST GET
		type:"POST",
		url:baseurl+"index.php/admin/webset/sendemail",
		data:{toemail:toemail,<?php echo $this->config->item('csrf_token_name');?>:token},
		//返回数据的格式
		datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
		//在请求之前调用的函数
		beforeSend:function(){$('#send_txt').html('测试邮件发送中……');},
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
