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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/webset/pay');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="city_pays"> 交易送货配置 </label>
										<div class="col-sm-9">
											<div class="checkbox">
											<?php foreach(explode("|",$this->config->item('citypays')) as $k => $v){?>
												<label>
													<input name="city_pays[]" type="checkbox" class="ace" value="<?php echo $k;?>" <?php if(strstr(''.$this->config->item('city_pays').'',''.$k.'')){echo 'checked';}?> >
													<span class="lbl"> <?php echo $v;?></span>
												</label>
											<?php }?>
											<span class="help-block col-sm-reset inline hidden-480"></span>
											</div>
										</div>
									</div>	
									<div class="hr hr-16 hr-dotted"></div>
									<div class="col-xs-12">
										<h4 class="widget-title blue smaller">
											<i class="ace-icon fa fa-rss orange"></i>
											支付宝
										</h4>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ali_payemail"> 支付宝收款帐号 </label>

										<div class="col-sm-9">
											<input type="text" id="ali_payemail" name="ali_payemail" placeholder="支付宝收款帐号" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('ali_payemail');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">支付宝收款合作帐号</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ali_payid"> 支付宝合作 ID </label>

										<div class="col-sm-9">
											<input type="text" id="ali_payid" name="ali_payid" placeholder="支付宝合作 ID" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('ali_payid');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">支付宝合作 ID</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ali_paykey"> 支付宝合作 KEY </label>

										<div class="col-sm-9">
											<input type="text" id="ali_paykey" name="ali_paykey" placeholder="支付宝合作 KEY" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('ali_paykey');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											支付宝合作 KEY
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ali_paytype"> 支付宝合作方式 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label>
													<input name="ali_paytype" type="radio" class="ace" value="1" <?php if($this->config->item('ali_paytype')=='1'){echo 'checked';}?> >
													<span class="lbl"> 即时到帐</span>
												</label>
												<label>
													<input name="ali_paytype" type="radio" class="ace" value="2" <?php if($this->config->item('ali_paytype')=='2'){echo 'checked';}?> >
													<span class="lbl"> 担保交易</span>
												</label>
												<label>
													<input name="ali_paytype" type="radio" class="ace" value="3" <?php if($this->config->item('ali_paytype')=='3'){echo 'checked';}?> >
													<span class="lbl"> 双接口</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480"></span>
											</div>
										</div>
									</div>
																	
									<div class="hr hr-16 hr-dotted"></div>
									<div class="col-xs-12">
										<h4 class="widget-title blue smaller">
											<i class="ace-icon fa fa-rss orange"></i>
											微信支付
										</h4>
									</div>
									<div class="space-4"></div>
				
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="wx_appid"> 微信公众号 APPID </label>

										<div class="col-sm-9">
											<input type="text" id="wx_appid" name="wx_appid" placeholder="微信公众号 APPID" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('wx_appid');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">微信公众号 APPID</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="wx_mchid"> 微信公众号 MCHID </label>

										<div class="col-sm-9">
											<input type="text" id="wx_mchid" name="wx_mchid" placeholder="微信公众号 MCHID" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('wx_mchid');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">微信公众号 MCHID</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="wx_key"> 微信公众号 KEY </label>

										<div class="col-sm-9">
											<input type="text" id="wx_key" name="wx_key" placeholder="微信公众号 KEY" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('wx_key');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											微信公众号 KEY
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="wx_appsecret"> 微信公众号 Appsecret </label>

										<div class="col-sm-9">
											<input type="text" id="wx_appsecret" name="wx_appsecret" placeholder="微信公众号 Appsecret" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('wx_appsecret');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											微信公众号 Appsecret
											</span>
										</div>
									</div>

																	
									<div class="hr hr-16 hr-dotted"></div>

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
</body>
</html>
