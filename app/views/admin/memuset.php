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
						<div class="row">
							<div class="col-xs-12">
								<span class="bigger-110 hidden-480"><i class="ace-icon fa fa-flag"></i> <?php echo $title;?>配置项</span>
								<div class="pull-right">
									<a href="<?php echo site_url('admin/memuset/pubsite');?>" class="btn btn-xs btn-info <?php if($memuset==10){echo 'btn-danger';}?>">
										<i class="ace-icon fa fa-bars bigger-120"></i> 公共												
									</a>
									<a href="<?php echo site_url('admin/memuset/front');?>" class="btn btn-xs btn-info <?php if($memuset==1){echo 'btn-danger';}?>">
										<i class="ace-icon fa fa-bars bigger-120"></i> 前台												
									</a>
									<a href="<?php echo site_url('admin/memuset/back');?>" class="btn btn-xs btn-info <?php if($memuset==11){echo 'btn-danger';}?>">
										<i class="ace-icon fa fa-bars bigger-120"></i> 后台												
									</a>
									<a href="<?php echo site_url('admin/memuset');?>" class="btn btn-xs btn-info <?php if($memuset==0){echo 'btn-danger';}?>">
										<i class="ace-icon fa fa-bars bigger-120"></i> 所有												
									</a>
									</div>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="row">
							<div class="col-xs-12">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>菜单标题</th>
											<th>操作地址</th>
											<th class="hidden-480"><i class="ace-icon fa fa-flag bigger-110 hidden-480"></i>权限</th>
											<th class="hidden-480">排序</th>
											<th class="text-right">
											<a href="<?php echo site_url('admin/memuset/add/'.$memuset);?>" class="btn btn-xs btn-info tooltip-info" data-rel="tooltip" title="增加" data-original-title="增加">
												<i class="ace-icon fa fa-plus bigger-120"></i>												
											</a>
											</th>
										</tr>
									</thead>

									<tbody>
									<?php if($memu_list){
									foreach($memu_list as $v){?>										
										<tr>
											<td><i class="menu-icon fa <?php echo $v['ico'];?>"></i>
												<a href="<?php if($v['count']==0){echo site_url($v['url']);} ?>"><?php echo $v['title'];?></a>
											</td>
											<td><?php echo $v['url'];?></td>
											<td class="hidden-480"><?php echo $v['group_type'];?></td>
											<td class="hidden-480"><?php echo $v['sort'];?></td>
											<td class="text-right">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="<?php echo site_url('admin/memuset/add/'.$v['mtype'].'/'.$v['id']);?>" class="btn btn-xs btn-info tooltip-info" data-rel="tooltip" title="增加" data-original-title="增加">
														<i class="ace-icon fa fa-plus bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/memuset/edit/'.$v['id'].'/'.$v['mtype'].'/'.$v['pid']);?>" class="btn btn-xs btn-success tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/memuset/del/'.$v['id'].'/'.$v['pid']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
																<a href="<?php echo site_url('admin/memuset/add/'.$v['mtype'].'/'.$v['id']);?>" class="tooltip-info" data-rel="tooltip" title="增加" data-original-title="增加">
																	<span class="blue">
																		<i class="ace-icon fa fa-plus bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/memuset/edit/'.$v['id'].'/'.$v['mtype'].'/'.$v['pid']);?>" class="tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/memuset/del/'.$v['id'].'/'.$v['pid']);?>" class="tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
										<?php if($v['memu_list_s']){
										foreach($v['memu_list_s'] as $s){?>
										<tr>
											<td>&nbsp;&nbsp;┣
												<a href="<?php echo site_url($s['url']); ?>"><?php echo $s['title'];?></a>
											</td>
											<td><?php echo $s['url'];?></td>
											<td class="hidden-480"><?php echo $s['group_type_s'];?></td>
											<td class="hidden-480"><?php echo $s['sort'];?></td>
											<td class="text-right">
												<div class="hidden-sm hidden-xs btn-group">
												
													<a href="<?php echo site_url('admin/memuset/add_act/'.$s['mtype'].'/'.$s['id']);?>" class="btn btn-xs btn-warning tooltip-warning" data-rel="tooltip" title="操作" data-original-title="操作">
														<i class="ace-icon fa fa-plus bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/memuset/edit/'.$s['id'].'/'.$s['mtype'].'/'.$s['pid']);?>" class="btn btn-xs btn-success tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/memuset/del/'.$s['id'].'/'.$s['pid']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
																<a href="<?php echo site_url('admin/memuset/add_act/'.$s['mtype'].'/'.$s['id']);?>" class="tooltip-warning" data-rel="tooltip" title="操作" data-original-title="操作">
																	<span class="orange">
																		<i class="ace-icon fa fa-plus bigger-120"></i>
																	</span>
																</a>
															</li>
															<li>
																<a href="<?php echo site_url('admin/memuset/edit/'.$s['id'].'/'.$s['mtype'].'/'.$s['pid']);?>" class="tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/memuset/del/'.$s['id'].'/'.$s['pid']);?>" class="tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
										<?php if($s['memu_list_t']){
										foreach($s['memu_list_t'] as $t){?>
										<tr>
											<td>&nbsp;&nbsp;├
												<?php echo $t['title'];?>
											</td>
											<td><?php echo $t['url'];?></td>
											<td class="hidden-480"><?php echo $t['group_type_t'];?></td>
											<td class="hidden-480"><?php echo $t['sort'];?></td>
											<td class="text-right">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="<?php echo site_url('admin/memuset/edit_act/'.$t['id'].'/'.$t['mtype'].'/'.$t['pid']);?>" class="btn btn-xs btn-success tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/memuset/del_act/'.$t['id'].'/'.$t['pid']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
																<a href="<?php echo site_url('admin/memuset/edit_act/'.$t['id'].'/'.$t['mtype'].'/'.$t['pid']);?>" class="tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/memuset/del_act/'.$t['id'].'/'.$t['pid']);?>" class="tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
										<?php }}?>
										<?php }}?>
									<?php }}?>
									</tbody>
								</table>
								<?php if($pagination){?>
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
