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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/webset/allset');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_name"> 网站名称 </label>

										<div class="col-sm-9">
											<input type="text" id="site_name" name="site_name" placeholder="网站名称" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('site_name');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">网站名称</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_domain"> 网站域名 </label>

										<div class="col-sm-9">
											<input type="text" id="site_domain" name="site_domain" placeholder="网站域名" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('site_domain');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">网站域名，不含 http://</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="dsfox_domain"> 短域名 </label>

										<div class="col-sm-9">
											<input type="text" id="dsfox_domain" name="dsfox_domain" placeholder="短域名" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('dsfox_domain');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">短域名，如 kuaiwww.com</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_keywords"> 网站关键词 </label>

										<div class="col-sm-9">
											<input type="text" id="site_keywords" name="site_keywords" placeholder="网站关键词" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('site_keywords');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											用,分开，80字内
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_description"> 网站描述 </label>

										<div class="col-sm-9">
											<input type="text" id="site_description" name="site_description" placeholder="网站描述" class="col-md-8 col-xs-10 col-sm-5" value="<?php echo $this->config->item('site_description');?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">200字内</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_search"> 默认搜索词 </label>

										<div class="col-sm-9">
											<input type="text" id="site_search" name="site_search" placeholder="默认搜索词" class="col-md-8 col-xs-10 col-sm-5" value="<?php echo $this->config->item('site_search');?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">用|分开</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sub_folder"> 网站目录 </label>

										<div class="col-sm-9">
											<input type="text" id="sub_folder" name="sub_folder" placeholder="网站目录" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('sub_folder');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											根目录请留空，子目录填写目录名
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="themes"> 前台模板 </label>

										<div class="col-sm-9">
											<input type="text" id="themes" name="themes" placeholder="前台默认模板目录" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('themes');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											前台已有模板项，填写默认的目录
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="adminthemes"> 后台模板 </label>

										<div class="col-sm-9">
											<input type="text" id="adminthemes" name="adminthemes" placeholder="后台默认模板目录" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('adminthemes');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											后台模板目录
											</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="weblogo"> 网站logo </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="weblogo" name="weblogo" type="text" value="<?php echo $this->config->item('weblogo');?>" />
											<span class='input-group-addon'><input id="upload_logo" type="button" value="选择"></span>
											</div>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="telpic"> 电话图片 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="telpic" name="telpic" type="text" value="<?php echo $this->config->item('telpic');?>" />
											<span class='input-group-addon'><input id="upload_telpic" type="button" value="选择"></span>
											</div>
										</div>
									</div>

									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="wxpic"> 微信公众号 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="wxpic" name="wxpic" type="text" value="<?php echo $this->config->item('wxpic');?>" />
											<span class='input-group-addon'><input id="upload_wxpic" type="button" value="选择"></span>
											</div>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="encryption_key"> 安全密钥 </label>

										<div class="col-sm-9">
											<input type="text" id="encryption_key" name="encryption_key" placeholder="安全密钥" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('encryption_key');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">安全密钥</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="webtel"> 联系电话 </label>

										<div class="col-sm-9">
											<input type="text" id="webtel" name="webtel" placeholder="联系电话" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('webtel');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认电话</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="webqq"> 客服QQ </label>

										<div class="col-sm-9">
											<input type="text" id="webqq" name="webqq" placeholder="客服QQ" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('webqq');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认客服QQ，多个用|分开</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="webdress"> 所在地址 </label>

										<div class="col-sm-9">
											<input type="text" id="webdress" name="webdress" placeholder="所在地址" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('webdress');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认地址</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="fahuo_type"> 快递方式 </label>

										<div class="col-sm-9">
											<input type="text" id="fahuo_type" name="fahuo_type" placeholder="快递方式" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('fahuo_type');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">多个用|分开</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="shoukuan_type"> 收款方式 </label>

										<div class="col-sm-9">
											<input type="text" id="shoukuan_type" name="shoukuan_type" placeholder="收款方式" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('shoukuan_type');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">多个用|分开</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="kuaidi_type"> 快递公司 </label>

										<div class="col-sm-9">
											<input type="text" id="kuaidi_type" name="kuaidi_type" placeholder="快递公司" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('kuaidi_type');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">多个用|分开</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="is_rewrite"> 伪静态 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_rewrite" type="radio" class="ace" value="on" <?php if($this->config->item('is_rewrite')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_rewrite" type="radio" class="ace" value="off" <?php if($this->config->item('is_rewrite')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline hidden-480">需要主机支持，否则出错</span>
											</div>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="show_captcha"> 验证码 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="show_captcha" type="radio" class="ace" value="on" <?php if($this->config->item('show_captcha')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="show_captcha" type="radio" class="ace" value="off" <?php if($this->config->item('show_captcha')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">网站表单验证码开关</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="is_guest"> 游客行为 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_guest" type="radio" class="ace" value="on" <?php if($this->config->item('is_guest')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_guest" type="radio" class="ace" value="off" <?php if($this->config->item('is_guest')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">网站游客行为开关</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="is_member"> 会员折扣 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_member" type="radio" class="ace" value="on" <?php if($this->config->item('is_member')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_member" type="radio" class="ace" value="off" <?php if($this->config->item('is_member')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">网站会员折扣开关</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="is_ip"> 智能转向 </label>
										<div class="col-sm-9">
											<div class="radio">
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_ip" type="radio" class="ace" value="on" <?php if($this->config->item('is_ip')=='on'){echo 'checked';}?> >
													<span class="lbl"> 开启</span>
												</label>
												<label class="col-md-2 col-xs-6 col-sm-4">
													<input name="is_ip" type="radio" class="ace" value="off" <?php if($this->config->item('is_ip')=='off'){echo 'checked';}?> >
													<span class="lbl"> 关闭</span>
												</label>
											<span class="help-block col-sm-reset inline inline hidden-480">IP判断访问，关闭时访问主站</span>
											</div>
										</div>
									</div>
									
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="site_stats"> 统计代码 </label>

										<div class="col-sm-9">
											<textarea class="col-xs-10 col-sm-5" id="site_stats" name="site_stats" rows="5"><?php echo $this->config->item('site_stats');?></textarea>
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">支持HTML</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="webnums"> 默认系数 </label>

										<div class="col-sm-9">
											<input type="text" id="webnums" name="webnums" placeholder="默认系数" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('webnums');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认系数，如1.2</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="beian"> 备案号 </label>

										<div class="col-sm-9">
											<input type="text" id="beian" name="beian" placeholder="备案号" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('beian');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">备案号</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="zhan_email"> 站长邮箱 </label>

										<div class="col-sm-9">
											<input type="text" id="zhan_email" name="zhan_email" placeholder="站长邮箱" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('zhan_email');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">站长邮箱</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="zhan_tel"> 客服热线 </label>

										<div class="col-sm-9">
											<input type="text" id="zhan_tel" name="zhan_tel" placeholder="客服热线" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('zhan_tel');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">客服热线</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="zhan_email_me"> 通知邮箱 </label>

										<div class="col-sm-9">
											<input type="text" id="zhan_email_me" name="zhan_email_me" placeholder="通知邮箱" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('zhan_email_me');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">下单通知邮箱</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="zhan_shouji_me"> 通知手机 </label>

										<div class="col-sm-9">
											<input type="text" id="zhan_shouji_me" name="zhan_shouji_me" placeholder="通知手机" class="col-xs-10 col-sm-5" value="<?php echo $this->config->item('zhan_shouji_me');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">下单通知手机</span>
										</div>
									</div>
									
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="moban_list">  前台多模板</label>

										<div class="col-sm-9">
											<textarea class="col-xs-10 col-sm-5" id="moban_list" name="moban_list" rows="2"><?php echo $this->config->item('moban_list');?></textarea>
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">多模板配置，多个用|分开，前后无|</span>
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
	$("#upload_logo").click(function(){ 
	doUpload('weblogo'); 
	});
	$("#upload_telpic").click(function(){ 
	doUpload('telpic'); 
	});
	$("#upload_wxpic").click(function(){ 
	doUpload('wxpic'); 
	});
});
function doUpload(name) {
        // 上传方法
        var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
        $.upload({
			// 上传地址
			url:baseurl+"index.php/upload/upload_daimages/"+name, 
			// 文件域名字
			fileName: 'img', 
			// 其他表单数据
			params:{<?php echo $this->config->item('csrf_token_name');?>:token},
			// 上传完成后, 返回json, text
			dataType: 'json',
			// 上传之前回调,return true表示可继续上传
			onSend: function() {
				return true;
			},
			// 上传之后回调
			onComplate: function(data) {
				if(data.file_url){
					$('#'+name).val(data.file_url);
					//alert(data.msg);
				} else {
					alert(data.error);
				}
			}
        });
}
</script>
</script>
</body>
</html>
