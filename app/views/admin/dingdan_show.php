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
								<div class="page-header breadcrumbs widget-header">
									<a href="<?php echo site_url('admin/order/flist');?>" class="btn btn-primary">全部订单</a>
									<a href="javascript:void(0);" onclick="history.back();" class="btn btn-primary">返回上页</a>
								</div>
									<h4 class="lighter">
										<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
										订单号：<?php echo $dingdan['dan_hao'];?>
									</h4>
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>号码</th>
												<th>初始品牌</th>
												<th>归属地</th>
												<th class="hidden-480">出售价</th>
												<th class="hidden-480">话费（元）</th>
												<th class="hidden-480">低消</th>
												<th class="hidden-480">赠送积分</th>
												<th class="hidden-480">确认</th>
												<th class="hidden-480">支付</th>
												<th class="hidden-480">发货</th>
												<th class="hidden-480">无效</th>
												<th class="hidden-480">完成</th>
												<th class="hidden-480">作废</th>
											</tr>
										</thead>
										<tbody>
										<?php if($dingdan_list){
										$zj=0;										
										$hf=0;										
										$jf=0;			
										foreach($dingdan_list as $v){
										?>										
											<tr>
												<td><?php echo $v['hao_title'];?> <a class="danbox" href="#" data-id="<?php echo $v['id'];?>">记录</a></td>
												<td><?php echo $v['hao_pinpai'];?></td>
												<td><?php echo $v['hao_city'];?></td>
												<td class="hidden-480"><?php echo $v['hao_shoujia'];?></td>
												<td class="hidden-480"><?php echo $v['hao_huafei'];?></td>
												<td class="hidden-480"><?php echo $v['hao_heyue'];?></td>
												<td class="hidden-480"><?php echo $v['hao_shoujia']+$v['hao_huafei'];?></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_queren']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_zhifu']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_fahuo']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_wuxiao']==0){echo '<i class="fa fa-check-circle green"></i>';}else{echo '<i class="fa fa-close red"></i>';}?></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_wancheng']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
												<td class="hidden-480"><?php if($v['dan_hao_lock_zuofei']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
											</tr>
											<tr>
												<td colspan="13">快递方式：<?php echo $v['dan_hao_fahuo_type'];?>
												&nbsp;&nbsp;收款方式：<?php echo $v['dan_hao_shoukuan_type'];?>
												&nbsp;&nbsp;快递公司：<?php echo $v['dan_hao_kuaidi_type'];?>
												&nbsp;&nbsp;单号/备注：<?php echo $v['dan_hao_fahuo_danhao'];?>
												&nbsp;&nbsp;金额：<?php echo $v['dan_hao_fahuo_kuan'];?>
												&nbsp;&nbsp;备注：<?php echo $v['dan_hao_fahuo_beizhu'];?>
												</td>
											</tr><div id="worklist_<?php echo $v['id'];?>" style="display:none;">
													<div style="margin:5px 20px;">
													<?php if($v['work']){
													foreach($v['work'] as $s){?>
													<p><?php echo date('m-d H:i',$s['do_date']);?> <?php echo $s['username'];?> <?php echo $s['do_memo'];?></p>
													<?php }}else{?>
													<p>此订单还没有操作记录</p>
													<?php }?>
													</div>
												</div>
										<?php 
										$zj +=$v['hao_shoujia'];
										$hf +=$v['hao_huafei'];
										$jf +=$v['hao_shoujia'];
										}}?>
										</tbody>
									</table>
									<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td>订购帐号：<span class="text-danger"><?php echo $dingdan['dan_username'];?></span>  订单编号：<span class="text-danger"><?php echo $dingdan['dan_hao'];?></span>  
												享受折扣：<span class="text-danger"><?php echo $dingdan['zhekou'];?></span>  金额合计：<span class="text-danger"><?php echo ($jf*($dingdan['zhekou']/10))+$hf;?></span>元  赠送积分合计：<span class="text-danger"><?php echo ($jf*($dingdan['zhekou']/10))+$hf;?></span>分</td>
											</tr>
										</tbody>
									</table>
									<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td>交易方式：
												<?php if($this->config->item('citypays')){
												foreach(explode("|",$this->config->item('citypays')) as $t => $s){
												if($dingdan['dan_paytype']==$t){ echo $s;}}}?></td>
											</tr>											
										</tbody>
									</table>
									<h4 class="lighter">
										收货信息
									</h4>
									<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td><strong>收货人</strong>：<?php echo $dingdan['dan_name'];?> &nbsp;&nbsp;<strong>联系电话</strong>：<?php echo $dingdan['dan_tel'];?> &nbsp;&nbsp;<strong>备用电话</strong>：<?php echo $dingdan['dan_tels'];?> &nbsp;&nbsp;<strong>收货地址：</strong><?php echo $dingdan['dan_dress'];?></td>
											</tr>
											<tr>
												<td><strong>留言备注</strong>：<?php echo $dingdan['dan_content'];?></td>
											</tr>											
										</tbody>
									</table>
								
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
	$(".danbox").each(function(index){
		$(this).click(function(){
			var id=$(this).attr("data-id");
			layer.open({
				type: 1,
				title:'订单操作记录',
				skin: 'layui-layer-rim', //加上边框
				content: $('#worklist_'+id)
			});
		});						 
	});
});
function getvalues(obj)
{
	var c=obj.options[obj.selectedIndex].value
    $("input[name='tc_city']").attr("value",c);	
}
</script>
</body>
</html>
