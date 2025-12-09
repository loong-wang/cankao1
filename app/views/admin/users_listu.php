<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
<?php $this->load->view('common/header-meta');?>
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
						<div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb hidden-480">
								<?php if($groups){
								foreach($groups as $v){
								?>
									<a class="btn btn-xs <?php if($ug==$v['group_type']){?>btn-danger<?php }else{?>btn-info<?php }?>" href="<?php echo site_url('admin/users/listu/'.$v['group_type']);?>"><?php echo $v['group_name'];?></a>
								<?php }}?>
							</ul><!-- /.breadcrumb -->

							<!-- #section:basics/content.searchbox -->
							<div class="nav-search" id="nav-search">
								<form accept-charset="UTF-8" class="form-search" action="<?php echo site_url('admin/users/searchu');?>" role="form" method="post" novalidate="novalidate" >
								<?php echo csrf_hidden();?>
									<span class="input-icon">
										<input type="text" placeholder="输入关键词回车" class="nav-search-input" id="username" name="username" autocomplete="off" />
										<i class="ace-icon fa fa-search nav-search-icon"></i>
									</span>
								</form>
							</div><!-- /.nav-search -->

							<!-- /section:basics/content.searchbox -->
						</div>
						<div class="space-4"></div>
						<div class="row">
							<div class="col-xs-12">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>帐户</th>
											<th class="hidden-480">昵称</th>
											<th><i class="ace-icon fa fa-flag bigger-110 hidden-480"></i>角色</th>
											<th class="hidden-480">源自</th>
											<th class="hidden-480">注册时间</th>
											<th class="hidden-480">最后登陆</th>
											<th class="hidden-480">积分</th>
											<th class="hidden-480">状态</th>
											<th class="text-right">
											<a href="<?php echo site_url('admin/users/addu');?>" class="btn btn-xs btn-info tooltip-info" data-rel="tooltip" title="增加" data-original-title="增加">
												<i class="ace-icon fa fa-plus bigger-120"></i>												
											</a>
											</th>
										</tr>
									</thead>

									<tbody>
									<?php if(isset($users_list)){
									foreach($users_list as $v){
									if($v['username']){?>										
										<tr>
											<td><?php echo $v['username'];?><?php if($v['utel']){?><span class="label label-sm label-danger arrowed-in"><?php echo $v['utel'];?></span><?php }?>
											<?php if($this->session->userdata('userid')==$v['userid']){?> <i class="fa fa-flag green bigger-130 hidden-480"></i><?php }?></td>
											<td class="hidden-480"><?php echo $v['uname'];?></td>
											<td><?php echo $v['ugroups'];?>
											<?php if($v['ugroup']==5){?>
											<a class="tooltip-error" tooltip-info" data-rel="tooltip" title="代理系数" data-original-title="代理系数"><span class="label label-sm label-danger"><?php echo $v['unums'];?></span></a>
											<a class="tooltip-info" tooltip-info" data-rel="tooltip" title="城市系数" data-original-title="城市系数"><span class="label label-sm label-inverse"><?php echo $v['cnums'];?></span></a>
											<?php if($v['haoma_shu']>0){?><a href="<?php echo site_url('admin/haoma/search/10000/0/'.$v['username'].'/0/0');?>" class="tooltip-error" tooltip-info" data-rel="tooltip" title="号码总数" data-original-title="号码总数"><span class="label label-sm label-danger arrowed-in"><?php echo $v['haoma_shu'];?></span></a><?php }?>
											<?php }?>
											</td>
											<td class="hidden-480"><?php echo $v['ucity'];?></td>
											<td class="hidden-480"><?php echo date('Y-m-d',$v['uregtime']);?></td>
											<td class="hidden-480"><?php echo date('Y-m-d H:i:s',$v['ulogtime']);?></td>
											<td class="hidden-480"><?php echo $v['ucredit'];?></td>
											<td class="hidden-480"><?php echo $v['ulock'];?></td>
											<td class="text-right">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="<?php echo site_url('admin/users/editu/'.$v['userid']);?>" class="btn btn-xs btn-success tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/users/delu/'.$v['userid']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
														<i class="ace-icon fa fa-trash-o bigger-120"></i>
													</a>

												</div>

												<div class="hidden-md hidden-lg">
													<div class="inline position-relative">
														<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
															<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
														</button>
														<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
															<li>
																<a href="<?php echo site_url('admin/users/editu/'.$v['userid']);?>" class="tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/users/delu/'.$v['userid']);?>" class="tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
																	<span class="red">
																		<i class="ace-icon fa fa-trash-o bigger-120"></i>
																	</span>
																</a>
															</li>
														</ul>
													</div>
												</div>
											</td>
										</tr>										
									<?php }}}?>
									</tbody>
								</table>
								<?php if(isset($pagination)){?>
								<ul class="pagination pull-right">
								<?php echo $pagination?>									
								</ul>
								<?php }?>
							</div><!-- /.span -->
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
</body>
</html>
