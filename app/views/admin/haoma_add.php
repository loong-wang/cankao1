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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/haoma/add');?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_title"> 号码 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_title" name="hao_title" placeholder="号码" class="col-xs-10 col-sm-5" value="<?php echo set_value('hao_title');?>">
											<?php if(form_error('hao_title')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_title');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">号码</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_type"> 类型 </label>
										<div class="col-sm-9">
											<div class="radio">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
											<label>
												<input name="hao_type" type="radio" class="ace" value="<?php echo $k;?>" <?php if(set_checkbox('hao_type',$k)){echo 'checked';}?> onchange="getvaluest(this.value)" >
												<span class="lbl"> <?php echo $v;?></span>
											</label>
											<?php }}?>
											<?php if(form_error('hao_type')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_type');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">类型</span><?php }?>
											</div>
										</div>
									</div>
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_city"> 城市 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
											<option value=""></option>
											<?php if($citys){
												foreach($citys as $v){?>
												<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
											<?php }}?>
											</select><input type="hidden" id="hao_city" name="hao_city" value="">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('hao_city');?></span>
											</span>
										</div>
									</div>
									<div class="form-group" id="pinpaibox">
										<label class="col-sm-3 control-label no-padding-right" for="hao_pinpai"> 品牌 </label>
										<div class="col-sm-9">
											<div class="radio" id="pinpai_list">
											<?php if(form_error('hao_pinpai')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_pinpai');?></span><?php }?>
											</div>
										</div>
									</div>
									<?php }else{?>
									<input type="hidden" id="hao_city" name="hao_city" value="<?php echo $this->session->userdata('ucity');?>">
									<div class="form-group" id="pinpaibox">
										<label class="col-sm-3 control-label no-padding-right" for="hao_pinpai"> 品牌 </label>
										<div class="col-sm-9">
											<div class="radio" id="pinpai_list">
											<?if(isset($pinpai_list)){
											foreach($pinpai_list as $k => $v){?>
												<label>
													<input name="hao_pinpai" type="radio" class="ace" value="<?php echo $v['pin_num'];?>" <?php if(set_select('hao_pinpai',$v['pin_num'])){echo 'checked';}?> >
													<span class="lbl"> <?php echo $v['pin_title'];?></span>
												</label>
											<?php }}?>
											<?php if(form_error('hao_pinpai')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_pinpai');?></span><?php }?>
											</div>
										</div>
									</div>
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_jiage"> 底价 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_jiage" name="hao_jiage" placeholder="底价" class="col-xs-10 col-sm-5" value="<?php echo set_value('hao_jiage');?>">
											<?php if(form_error('hao_jiage')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_jiage');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">底价</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_huafei"> 话费 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_huafei" name="hao_huafei" placeholder="含话费" class="col-xs-10 col-sm-5" value="<?php echo set_value('hao_huafei','0');?>">
											<?php if(form_error('hao_huafei')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_huafei');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">含话费</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_heyue"> 合约 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_heyue" name="hao_heyue" placeholder="合约" class="col-xs-10 col-sm-5" value="<?php echo set_value('hao_heyue');?>">
											<?php if(form_error('hao_heyue')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_heyue');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">留空为无合约</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_user"> 所属 </label>

										<div class="col-sm-9">
											<input type="text" id="hao_user" name="hao_user" placeholder="所属" class="col-xs-10 col-sm-5" value="<?php echo set_value('hao_user');?>">
											<?php if(form_error('hao_user')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_user');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">会员帐号</span><?php }?>
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
    $("input[name='hao_city']").attr("value",c);
	var hao_type=$(':radio[name=hao_type]:checked').val();
	if(!$(':radio[name=hao_type]:checked').length) {
		alert('请先选择号码类型');
		return false;
	}
	if(c){
		$("#pinpaibox").css({'display':'block'});
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
		$.ajax({
			//提交数据的类型 POST GET
			type:"POST",
			url:baseurl+"index.php/admin/haoma/getpinpai",
			data:{city:c,hao_type:hao_type,<?php echo $this->config->item('csrf_token_name');?>:token},
			//返回数据的格式
			datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
			//在请求之前调用的函数
			beforeSend:function(){$('#pinpai_list').html('城市品牌加载中……');},
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
	}else{
		$("#pinpaibox").css({'display':'none'});
	}
}
function getvaluest(obj)
{
	var c=$('#hao_city').val();
	if(c){
		$("#pinpaibox").css({'display':'block'});
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
		$.ajax({
			//提交数据的类型 POST GET
			type:"POST",
			url:baseurl+"index.php/admin/haoma/getpinpai",
			data:{city:c,hao_type:obj,<?php echo $this->config->item('csrf_token_name');?>:token},
			//返回数据的格式
			datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
			//在请求之前调用的函数
			beforeSend:function(){$('#pinpai_list').html('城市品牌加载中……');},
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
	}else{
		$("#pinpaibox").css({'display':'none'});
	}
}
</script>
</body>
</html>
