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
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/memuset/edit_act/'.$memuinfo['id'].'/'.$memuinfo['mtype']);?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
								<input type="hidden" id="mtype" name="mtype" value="<?php echo $memuset; ?>">
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="title"> 菜单标题 </label>

										<div class="col-sm-9">
											<input type="text" id="title" name="title" placeholder="菜单标题，四字最佳" class="col-xs-10 col-sm-5" value="<?php echo $memuinfo['title']; ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('title');?></span>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="url"> 操作地址 </label>

										<div class="col-sm-9">
											<input type="text" id="url" name="url" placeholder="操作地址，地址标识" class="col-xs-10 col-sm-5" value="<?php echo $memuinfo['url']; ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('url');?></span>
											</span>
										</div>
									</div>

									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ico"> 菜单图标 </label>

										<div class="col-sm-9">
											<input type="text" id="ico" name="ico" placeholder="菜单图标样式" class="col-xs-10 col-sm-5" value="<?php echo $memuinfo['ico']; ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('ico');?></span>
												<span class="middle"><a href="http://fontawesome.io/icons/" target="_blank">图标参考地址</a></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="remark"> 菜单描述 </label>
										<div class="col-sm-9">
											<input type="text" id="remark" name="remark" placeholder="菜单的说明，100字内" class="col-xs-10 col-sm-5" value="<?php echo $memuinfo['remark']; ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('remark');?></span>
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="sort"> 菜单排序 </label>

										<div class="col-sm-9">
											<input type="text" id="sort" name="sort" placeholder="" class="col-xs-2 col-sm-2 col-md-1" value="<?php echo $memuinfo['sort']; ?>">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('sort');?></span>
											</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-xs-3 col-sm-3 control-label no-padding-right" for="mlock"> 显示开关 </label>
										<input id="mlock" name="mlock" type="hidden" value="<?php echo $memuinfo['mlock']; ?>" >

										<div class="col-xs-3 col-sm-3 col-md-2">
												<input id="mlockok" name="mlockok" class="ace ace-switch ace-switch-7" type="checkbox" >
												<span class="lbl" data-lbl="隐&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;显"></span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="mact"> 菜单归类 </label>

										<div class="col-sm-9">
											<div class="radio">
												<label>
													<input name="mtype" type="radio" class="ace" value="2" <?php if($memuinfo['mtype']==2){echo 'checked';}?> >
													<span class="lbl"> 前台操作</span>
												</label>
											</div>
											<div class="radio">
												<label>
													<input name="mtype" type="radio" class="ace" value="12" <?php if($memuinfo['mtype']==12){echo 'checked';}?> >
													<span class="lbl"> 后台操作</span>
												</label>
											</div>
										</div>
									</div>

									<div class="hr hr-16 hr-dotted"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="pid"> 所属分类 </label>
										<div class="col-sm-9">
											<select class="help-inline col-xs-12 col-sm-7 col-md-3" id="pid" name="pid">
												<?php if(isset($memust)){?>
													<option value="<?php echo $memust['id'];?>"><?php echo $memust['title'];?></option>
												<?php }else{?>
													<option value="0">顶级分类</option>
												<?php }?>
												<?php if($memus){
												foreach($memus as $v){?>
													<option value="<?php echo $v['id'];?>"><?php echo $v['title'];?></option>
												<?php }}?>
											</select>
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('pid');?></span>
											</span>
										</div>
									</div>

									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="group_type"> 操作权限 </label>

										<div class="col-sm-9">
											<select multiple="multiple" size="10" name="group_type[]" id="group_type">
												<?php foreach($groups as $v){?>
													<option value="<?php echo $v['group_type'];?>" <?php if(strstr($memuinfo['group_type'],$v['group_type'])){echo 'selected';}?>><?php echo $v['group_name'];?></option>
												<?php }?>
											</select>
											<div class="hr hr-16 hr-dotted"></div>
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
<script type="text/javascript">
jQuery(function($){
	var demo1 = $('select[name="group_type[]"]').bootstrapDualListbox({moveOnSelect: true,showFilterInputs:false,infoText:''});
	var container1 = demo1.bootstrapDualListbox('getContainer');
	container1.find('.btn').addClass('btn-white btn-info btn-bold');
	container1.find('.box1').addClass('col-xs-6 col-sm-6');
	container1.find('.box2').addClass('col-xs-6 col-sm-6');
	<?php echo $setsh;?>
	<?php if($memuinfo['mlock']==1){?>
	$('#mlockok').prop("checked",true);
	<?php }?>
	$('#mlockok').on('change', function () {
		if(this.checked){ 
			$("input[name='mlockok']").each(function(){this.checked=true;}); 
			$("input[name='mlock']").attr("value",1);
		}else{ 
			$("input[name='mlockok']").each(function(){this.checked=false;}); 
			$("input[name='mlock']").attr("value",0);
		} 
	});
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
