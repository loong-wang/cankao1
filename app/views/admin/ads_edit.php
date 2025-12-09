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

						<div class="row">
							<div class="col-xs-12">
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/ads/edit/'.$adsinfo['id']);?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ads_title"> 广告标题 </label>

										<div class="col-sm-9">
											<input type="text" id="ads_title" name="ads_title" placeholder="广告标题" class="col-xs-10 col-sm-5 col-md-2" value="<?php echo set_value('ads_title',$adsinfo['ads_title']);?>">
											<?php if(form_error('ads_title')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('ads_title');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">广告标题</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ads_url"> 广告链接 </label>
										<div class="col-sm-9">
											<input type="text" id="ads_url" name="ads_url" placeholder="广告链接" class="col-xs-10 col-sm-5" value="<?php echo set_value('ads_url',$adsinfo['ads_url']);?>">
											<?php if(form_error('ads_url')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('ads_url');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">广告链接</span><?php }?>
										</div>
									</div>
									
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ads_city"> 广告所属 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
											<option value=""></option>
											<?php if($citys){
												foreach($citys as $v){?>
												<option value="<?php echo $v['cid'];?>" <?php if($v['cid']==$adsinfo['ads_city']){echo 'selected';}?>><?php echo $v['cname'];?></option>
											<?php }}?>
											</select><input type="hidden" id="ads_city" name="ads_city" value="<?php echo $adsinfo['ads_city'];?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ads_city');?></span>
											</span>
										</div>
									</div>
									<?php }else{?>
									<input type="hidden" id="ads_city" name="ads_city" value="<?php echo $this->session->userdata('ucity');?>">
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ads_pic"> 广告图片 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="ads_pic" name="ads_pic" type="text" value="<?php echo set_value('ads_pic',$adsinfo['ads_pic']);?>" />
											<input class="form-control" id="ads_pico" name="ads_pico" type="hidden" value="<?php echo $adsinfo['ads_pic'];?>" />
											<span class='input-group-addon'><input id="upload_ads_pic" type="button" value="选择"></span>
											</div>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ads_pic');?></span><span>250*600</span>
											</span>
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
<?php echo js_url('ace/elements.spinner');?>
<?php echo js_url('ace/ace.settings');?>
<?php echo js_url('ace/ace.settings-rtl');?>
<?php echo js_url('ace/ace.settings-skin');?>
<?php echo js_url('ace/ace.widget-on-reload');?>
<?php echo js_url('ace/ace.searchbox-autocomplete');?>
<?php echo js_url('jquery.upload');?>
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
	var c=obj.options[obj.selectedIndex].value
    $("input[name='ads_city']").attr("value",c);
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#upload_ads_pic").click(function(){ 
		doUpload('ads_pic'); 
	});
});
function doUpload(name) {
	// 上传方法
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.upload({
		// 上传地址
		url:baseurl+"index.php/upload/upload_ads", 
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
</body>
</html>
