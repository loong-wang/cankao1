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
							<?php if($this->session->userdata('ucity')==0){?>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-xs btn-danger dropdown-toggle" aria-expanded="true">
									<?php echo $cityname;?>
									<i class="ace-icon fa fa-angle-down icon-on-right"></i>
								</button>

								<ul class="dropdown-menu dropdown-danger">
									<div class="citybox">
									<a class="badge btn-minier <?php if($city==0){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/order/dingzhi/0');?>">全部</a>
									<?php if($citys){
									foreach($citys as $v){?>
										<a class="badge btn-minier <?php if($city==$v['cid']){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/order/dingzhi/'.$v['cid']);?>"><?php echo $v['cname'];?></a>
									<?php }}?>
									</div>
								</ul>
							</div>
							<?php }?>
						</div>
						<div class="space-4"></div>
						<div class="row">
							<div class="col-xs-12">
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>标题</th>
											<th>城市</th>
											<th class="hidden-480">状态</th>
											<th class="hidden-480">联系人</th>
											<th class="hidden-480">联系电话</th>
											<th class="hidden-480">时间</th>
											<th class="text-right">
											<a href="<?php echo site_url('admin/order/dingzhidel_all');?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="删除1月前" data-original-title="删除1月前">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>												
											</a>
											</th>
										</tr>
									</thead>

									<tbody>
									<?php if(isset($dingzhi_list)){
									foreach($dingzhi_list as $v){?>										
										<tr>
											<td><?php echo $v['dz_title'];?>
											<?php if($this->session->userdata('ucity')==$v['dz_city']){?> <i class="fa fa-flag green bigger-130 hidden-480"></i><?php }?></td>
											<td><?php echo $v['dingzhi_city'];?></td>
											<td class="hidden-480"><?php if($v['dz_lock']==0){echo '<a href="#" class="zhuangtai" data-tit="'.$v['dz_title'].'" data-id="'.$v['id'].'"><i class="fa fa-close red"></i> 未处理</a>';}else{echo '<i class="fa fa-check-circle green"></i> 已处理';}?></td>
											<td class="hidden-480"><?php echo $v['dz_name'];?></td>
											<td class="hidden-480"><?php echo $v['dz_tel'];?></td>
											<td class="hidden-480"><?php echo date('Y-m-d H:i:s',$v['dz_time']);?></td>
											<td class="text-right">
												<a class="dingzhibox btn btn-xs btn-success tooltip-success" data-tit="<?php echo $v['dz_title'];?>" data-id="<?php echo $v['id'];?>" data-rel="tooltip" title="详情查看" data-original-title="详情查看" href="#">
													<i class="ace-icon fa fa-search-plus bigger-120"></i>
												</a>
												<a href="<?php echo site_url('admin/order/dingzhidel/'.$v['id']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="删除" data-original-title="删除">
													<i class="ace-icon fa fa-trash-o bigger-120"></i>
												</a>
											</td>
										</tr><div id="dialog<?php echo $v['id'];?>" class="hide">
											<div style="padding:10px;">
												<p>城市：<?php echo $v['dingzhi_city'];?></p>
												<p>补充：<?php echo $v['dz_content'];?></p>
												<hr />
												<p>联系人：<?php echo $v['dz_name'];?></p>
												<p>电话：<?php echo $v['dz_tel'];?></p>
												<p>QQ：<?php echo $v['dz_qq'];?></p>
												<p>Email：<?php echo $v['dz_email'];?></p>
											</div>
										</div>										
									<?php }}?>
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
	$(".dingzhibox").each(function(index){
		$(this).click(function(){
			var id=$(this).attr("data-id");
			var tit=$(this).attr("data-tit");
			layer.open({
				type: 1,
				skin: 'layui-layer-rim', //加上边框
				shift: 2,
				shadeClose: true, //开启遮罩关闭
				title: tit, 
				content: $('#dialog'+id).html(), //捕获的元素
			});
		});						 
	});
	$(".zhuangtai").each(function(index){
		$(this).click(function(){
			var id=$(this).attr("data-id");
			var tit=$(this).attr("data-tit");
			layer.confirm('您要处理此订制么？', {
				btn: ['是的，确定处理','详情','关闭'] //按钮
			}, function(){
				//layer.msg(id);
				var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
				$.ajax({
					type:"POST",
					url:baseurl+"index.php/admin/order/dingzhilock",
					data:{id:id,<?php echo $this->config->item('csrf_token_name');?>:token},
					datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
					success:function(data){
						if(data==1){
							layer.msg(tit+' 处理成功');
							window.location.reload();
						}           
					},
				 });
			}, function(){
				layer.open({
					type: 1,
					skin: 'layui-layer-rim', //加上边框
					shift: 2,
					shadeClose: true, //开启遮罩关闭
					title: tit, 
					content: $('#dialog'+id).html(), //捕获的元素
				});
			});
		});						 
	});
});
</script>				
<?php echo js_url('jquery-ui.custom');?>
<?php echo js_url('jquery.ui.touch-punch');?>
<?php echo js_url('layer');?>


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
