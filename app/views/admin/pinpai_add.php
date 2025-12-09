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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/pinpai/add');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_title"> 品牌名称 </label>

										<div class="col-sm-9">
											<input type="text" id="pin_title" name="pin_title" placeholder="品牌名称" class="col-xs-10 col-sm-5 col-md-2" value="<?php echo set_value('pin_title');?>">
											<?php if(form_error('pin_title')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('pin_title');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">品牌名称</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_num"> 品牌数字 </label>
										<div class="col-sm-9">
											<input type="text" id="pin_num" name="pin_num" placeholder="品牌数字" class="col-xs-10 col-sm-5 col-md-2 input-mini spinbox-input" value="<?php echo set_value('pin_num');?>">
											<?php if(form_error('pin_num')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('pin_num');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">品牌数字</span><?php }?>
										</div>
									</div>
									
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_city"> 所属 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
											<option value=""></option>
											<?php if($citys){
												foreach($citys as $v){?>
												<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
											<?php }}?>
											</select><input type="hidden" id="pin_city" name="pin_city" value="">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('pin_city');?></span>
											</span>
										</div>
									</div>
									<?php }else{?>
									<input type="hidden" id="pin_city" name="pin_city" value="<?php echo $this->session->userdata('ucity');?>">
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_type"> 类型 </label>
										<div class="col-sm-9">
											<div class="radio">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
											<label>
												<input name="pin_type" type="radio" class="ace" value="<?php echo $k;?>" <?php if(set_checkbox('pin_type',$k)){echo 'checked';}?> >
												<span class="lbl"> <?php echo $v;?></span>
											</label>
											<?php }}?>
											<?php if(form_error('pin_type')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('pin_type');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">类型</span><?php }?>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_shuxing"> 品牌属性 </label>
										<div class="col-sm-9">
											<div class="radio">
											<?php if($this->config->item('pinpaishuxings')){
											foreach(explode("|",$this->config->item('pinpaishuxings')) as $k => $v){
											?>
											<label>
												<input name="pin_shuxing" type="radio" class="ace" value="<?php echo $k;?>" >
												<span class="lbl"> <?php echo $v;?></span>
											</label>
											<?php }}?>
											<?php if(form_error('pin_shuxing')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('pin_shuxing');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">品牌属性</span><?php }?>
											</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pin_tezheng"> 品牌特征 </label>
										<div class="col-sm-9">
											<div class="checkbox">
											<?php foreach(explode("|",$this->config->item('pinpais')) as $k => $v){?>
												<label>
													<input name="pin_tezheng[]" type="checkbox" class="ace" value="<?php echo $k;?>" <?php if(set_checkbox('pin_tezheng[]',$k)){echo 'checked';}?> >
													<span class="lbl"> <?php echo $v;?></span>
												</label>
											<?php }?>
											<?php if(form_error('pin_tezheng[]')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('pin_tezheng[]');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">特征</span><?php }?>
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
<?php echo js_url('fuelux/fuelux.spinner');?>

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
	<?php if($this->session->userdata('ucity')==0){?>
	$('#pin_num').ace_spinner({value:10,min:10,max:100000,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	<?php }else{?>
	$('#pin_num').ace_spinner({value:<?php echo $this->session->userdata('ucity').'00';?>,min:<?php echo $this->session->userdata('ucity').'00';?>,max:<?php echo $this->session->userdata('ucity').'99';?>,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	<?php }?>
	.closest('.ace-spinner')
	.on('changed.fu.spinbox', function(){
		//alert($('#spinner1').val())
	}); 
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
    $("input[name='pin_city']").attr("value",c);
}
</script>
</body>
</html>
