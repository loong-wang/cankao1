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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/users/addu/');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="username"> 会员帐号 </label>

										<div class="col-sm-9">
											<input type="text" id="username" name="username" placeholder="会员帐号" class="col-xs-10 col-sm-5" value="<?php echo set_value('username'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('username');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="upassword"> 会员密码 </label>

										<div class="col-sm-9">
											<input type="password" id="upassword" name="upassword" placeholder="会员密码" class="col-xs-10 col-sm-5" value="<?php echo set_value('upassword'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('upassword');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="upassword_com"> 密码确认 </label>

										<div class="col-sm-9">
											<input type="password" id="upassword_com" name="upassword_com" placeholder="密码确认" class="col-xs-10 col-sm-5" value="<?php echo set_value('upassword_com'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('upassword_com');?></span>
											</span>
										</div>
									</div>
									

									<div class="hr hr-16 hr-dotted"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ugroup"> 级别 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="group" data-placeholder="选择级别" onchange="getvalue(this)">
											<option value=""></option>
											<?php if($groups){
												foreach($groups as $v){
												if($this->session->userdata('ugroup')>$v['group_type']){?>
												<option value="<?php echo $v['group_type'];?>"><?php echo $v['group_name'];?></option>
											<?php }}}?>
											</select><input type="hidden" id="ugroup" name="ugroup" value="">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ugroup');?></span>
											</span>
										</div>
									</div>
									<div class="form-group" id="unumsbox" style="display:none;">
										<label class="col-sm-3 control-label no-padding-right" for="unums"> 系数 </label>
										<div class="col-sm-9">
											<input type="text" id="unums" name="unums" placeholder="系数" class="col-xs-10 col-sm-5 input-mini spinbox-input" value="<?php echo set_value('unums',$this->config->item('webnums')); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('unums');?></span>
											</span>
										</div>
									</div>
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ucity"> 源自 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
											<option value=""></option>
											<option value="0">全站</option>
											<?php if($citys){
												foreach($citys as $v){?>
												<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
											<?php }}?>
											</select><input type="hidden" id="ucity" name="ucity" value="">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ucity');?></span>
											</span>
										</div>
									</div>
									<?php }else{?>
									<input type="hidden" id="ucity" name="ucity" value="<?php echo $this->session->userdata('ucity');?>">
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ucredit"> 积分 </label>
										<div class="col-sm-9">
											<input type="text" id="ucredit" name="ucredit" placeholder="会员积分" class="col-xs-10 col-sm-5 input-mini spinbox-input" value="<?php echo set_value('ucredit',$this->config->item('credit_start')); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ucredit');?></span>
											</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="uname"> 昵称 </label>
										<div class="col-sm-9">
											<input type="text" id="uname" name="uname" placeholder="会员昵称" class="col-xs-10 col-sm-5" value="<?php echo set_value('uname'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('uname');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="uzname"> 姓名 </label>
										<div class="col-sm-9">
											<input type="text" id="uzname" name="uzname" placeholder="真实姓名" class="col-xs-10 col-sm-5" value="<?php echo set_value('uzname'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('uzname');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="uemail"> 邮箱 </label>
										<div class="col-sm-9">
											<input type="text" id="uemail" name="uemail" placeholder="会员邮箱" class="col-xs-10 col-sm-5" value="<?php echo set_value('uemail'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('uemail');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="utel"> 电话 </label>
										<div class="col-sm-9">
											<input type="text" id="utel" name="utel" placeholder="会员电话" class="col-xs-10 col-sm-5" value="<?php echo set_value('utel'); ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('utel');?></span>
											</span>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												确认提交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn hidden-xs" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												重置
											</button>
										</div>
									</div>
								</form>
						</div>
			</div><!-- /.main-content -->

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
	$('#ucredit').ace_spinner({value:<?php echo $this->config->item('credit_start');?>,min:<?php echo $this->config->item('credit_start');?>,max:1000,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	.closest('.ace-spinner')
	.on('changed.fu.spinbox', function(){
		//alert($('#spinner1').val())
	}); 
	$('.ace-spinner').css({'display':'block'});

	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});

});
function getvalue(obj)
{
	var m=obj.options[obj.selectedIndex].value
    $("input[name='ugroup']").attr("value",m);
	if(m==5){
		$("#unumsbox").css({'display':'block'});
	}else{
		$("#unumsbox").css({'display':'none'});
	}
}
function getvalues(obj)
{
	var c=obj.options[obj.selectedIndex].value
    $("input[name='ucity']").attr("value",c);
}
</script>
</body>
</html>
