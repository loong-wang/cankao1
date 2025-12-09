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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/haoset/index');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_types"> 号码类型 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_types" name="hao_types" placeholder="号码类型" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_types');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码类型，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_types')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_types"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_types_<?php echo $k;?>" name="hao_types_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_types_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <b>号码尾数</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_ends" name="hao_ends" placeholder="号码尾数" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_ends');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码尾数，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_ends')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_ends_<?php echo $k;?>" name="hao_ends_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_ends_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_jiages"> <b>号码价格</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_jiages" name="hao_jiages" placeholder="号码价格" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_jiages');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码价格，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_jiages')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_jiages_<?php echo $k;?>" name="hao_jiages_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_jiages_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_shuweis"> <b>号码数位</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_shuweis" name="hao_shuweis" placeholder="号码数位" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_shuweis');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码数位，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_shuweis')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?>较多 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_shuweis_<?php echo $k;?>" name="hao_shuweis_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_shuweis_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_redians"> <b>号码热点</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_redians" name="hao_redians" placeholder="号码热点" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_redians');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码热点，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_redians')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_redians_<?php echo $k;?>" name="hao_redians_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_redians_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_tedians"> <b>号码特点</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_tedians" name="hao_tedians" placeholder="号码特点" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_tedians');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码特点，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_tedians')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_tedians_<?php echo $k;?>" name="hao_tedians_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_tedians_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_yues"> <b>生日选号</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_yues" name="hao_yues" placeholder="生日选号" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_yues');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">生日选号，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_yues')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_yues_<?php echo $k;?>" name="hao_yues_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_yues_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_heyus"> <b>合约</b> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_heyus" name="hao_heyus" placeholder="合约" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_heyus');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">合约，用|分隔</span>
										</div>
									</div>
									<?php foreach(explode("|",$this->config->item('hao_heyus')) as $k => $v){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_ends"> <?php echo $v;?> </label>

										<div class="col-sm-9">
											<input type="text" id="hao_heyus_<?php echo $k;?>" name="hao_heyus_<?php echo $k;?>" placeholder="规则" class="col-xs-10 col-sm-5 col-md-9" value="<?php echo $this->config->item('hao_heyus_'.$k.'');?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">规则，用|分隔</span>
										</div>
									</div>
									<?php }?>

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
