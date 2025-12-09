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
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>订单号</th>
									<th>收货人</th>
									<th class="hidden-480">收货人电话</th>
									<th class="hidden-480">手机号码</th>
									<th class="hidden-480">订购会员</th>
									<th class="hidden-480">卖家</th>
									<th class="hidden-480">快递单号/代收人/电话</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px;" action="<?php echo site_url('admin/order/searcha');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="订单号" class="nav-search-input" style="width:150px" id="danhao" name="danhao" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td>
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searchb');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="收货人" class="nav-search-input" style="width:100px" id="ren" name="ren" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td class="hidden-480">
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searchc');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="收货人电话" class="nav-search-input" style="width:120px" id="tel" name="tel" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td class="hidden-480">
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searchd');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="手机号码" class="nav-search-input" style="width:120px" id="hao" name="haoma" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td class="hidden-480">
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searche');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="订购会员" class="nav-search-input" style="width:100px" id="user" name="user" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td class="hidden-480">
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searchf');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="卖家" class="nav-search-input" style="width:100px" id="mai" name="mai" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
									<td class="hidden-480">
									<form accept-charset="UTF-8" class="form-search" style="float:left;margin-left:10px" action="<?php echo site_url('admin/order/searchg');?>" role="form" method="post" novalidate="novalidate" >
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="快递单号/代收人/电话" class="nav-search-input" style="width:190px" id="wuliu" name="wuliu" autocomplete="off" />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
									</form>
									</td>
								</tr>											
							</tbody>
						</table>
						<div class="breadcrumbs" id="breadcrumbs">
							<?php if($this->session->userdata('ucity')==0){?>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-xs btn-danger dropdown-toggle" aria-expanded="true">
									<?php echo $cityname;?>
									<i class="ace-icon fa fa-angle-down icon-on-right"></i>
								</button>

								<ul class="dropdown-menu dropdown-danger">
									<div class="citybox">
									<a class="badge btn-minier <?php if($city==0){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/order/flist/0');?>">全部</a>
									<?php if($citys){
									foreach($citys as $v){?>
										<a class="badge btn-minier <?php if($city==$v['cid']){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/order/flist/'.$v['cid']);?>"><?php echo $v['cname'];?></a>
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
											<th style="padding:0;text-align:center">订单号</th>
											<th style="padding:0;text-align:center">时间</th>
											<th style="padding:0;text-align:center">下单站点</th>
											<th class="hidden-480" style="padding:0;text-align:center">收货人</th>
											<th class="hidden-480" style="padding:0;">
												<table class="table table-bordered table-hover" style="margin-bottom:0;border:0;">
													<thead>
														<tr>
															<th style="width:100px">号码</th>
															<th style="width:100px">出售价</th>
															<th style="width:70px">话费</th>
															<th style="width:100px">交易方式</th>
															<th style="width:100px">订购人</th>
															<th style="width:100px">卖家</th>
															<th style="width:25px">确认</th>
															<th style="width:25px">支付</th>
															<th style="width:25px">发货</th>
															<th style="width:25px">有效</th>
															<th style="width:25px;">完成</th>
															<th style="width:25px">作废</th>
															<th style="width:25px">过帐</th>
														</tr>
														
													</thead>
												</table>
											</th>
										</tr>
									</thead>

									<tbody>
									<?php if(isset($dingdan_list)){
									foreach($dingdan_list as $v){?>										
										<tr>
											<td><a href="<?php echo site_url('admin/order/dingdanshow/'.$v['dan_hao']);?>"><span class="red"><?php echo $v['dan_hao'];?></span></a>
											<?php if($this->session->userdata('ucity')==$v['dan_city']){?> <i class="fa fa-flag green bigger-130 hidden-480"></i><?php }?>
											<br />
											<?php $dir = 'uploads/renz/'.$v['dan_hao'];
											if (is_dir($dir)){?>
											<a target="_blank" href="<?php echo site_url('admin/haoma/renz/'.$v['dan_hao']);?>">实名资料</a>
											<?php }?>
											</td>
											<td><?php echo date('m-d H:i',$v['dan_time']);?></td>
											<td><?php echo $v['dan_city'];?></td>
											<td class="hidden-480"><a href="javascript:;" id="lianxibox_<?php echo $v['id'];?>" class="lianxibox" data-tel="<?php echo $v['dan_tel'];?>" data-id="<?php echo $v['id'];?>"><?php echo $v['dan_name'];?></a></td>
											<td class="hidden-480" style="padding:0;">
												<table class="table table-bordered table-hover" style="margin-bottom:0;">
													<tbody>
														<?php foreach($v['dd_list'] as $key => $m){?>
														<tr class="">
															<td style="width:100px"><a href="<?php echo site_url('admin/order/haoma/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php echo $m['hao_title'];?></a></td>
															<?php if($m['hao_jiage']==0 && $m['hao_huafei']==0){?>
															<td style="width:100px;color:red;">
															<?php if($m['dan_hao_shoujia']==0){echo '议价';}else{echo $m['dan_hao_shoujia'];}?>
															<a href="javascript:;" onclick="editddjiage(<?php echo $m['dingdan_list_id'];?>,<?php echo $m['hao_title'];?>);" class="tooltip-success" data-rel="tooltip" title="" data-original-title="编辑价格">
																<i class="ace-icon fa fa-pencil"></i>
															</a>
															</td>
															<td style="width:70px"><?php echo $m['hao_huafei'];?></td>
															<?php }else{?>
															<td style="width:100px"><?php echo $m['hao_shoujia'];?></td>
															<td style="width:70px"><?php echo $m['hao_huafei'];?></td>
															<?php }?>
															<td style="width:100px"><?php if($this->config->item('citypays')){
															foreach(explode("|",$this->config->item('citypays')) as $t => $s){
															if($v['dan_paytype']==$t){ echo $s;}}}?></td>
															<td style="width:100px"><?php echo $m['dan_username'];?></td>
															<td style="width:100px;position: relative;" id="maijia_list_<?php echo $m['hao_title'];?>"><?php if($m['hao_user']){?><a href="javascript:;" id="maijia_<?php echo $m['hao_title'];?>" class="maijiabox" data-haoma="<?php echo $m['hao_title'];?>" data-utel="<?php echo $m['utel'];?>" data-uqq="<?php echo $m['uqq'];?>" data-uname="<?php echo $m['hao_user'];?>" data-maijia="<?php echo $m['hao_title'];?>"><?php echo $m['hao_user'];?></a><?php }?></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/dan_hao_lock_queren/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_queren']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/dan_hao_lock_zhifu/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_zhifu']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/fahuo/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_fahuo']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/dan_hao_lock_wuxiao/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_wuxiao']==0){echo '<i class="fa fa-check-circle green"></i>';}else{echo '<i class="fa fa-close red"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/wancheng/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_wancheng']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/dan_hao_lock_zuofei/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_zuofei']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
															<td style="width:30px"><a href="<?php echo site_url('admin/order/dan_hao_lock_guozhang/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_guozhang']==0){echo '<i class="fa fa-close red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
														</tr>
														<tr style="background:#f9f9f9;">
														<td colspan="15">快递方式：<?php echo $m['dan_hao_fahuo_type'];?>
												&nbsp;&nbsp;收款方式：<?php echo $m['dan_hao_shoukuan_type'];?>
												&nbsp;&nbsp;快递公司：<?php echo $m['dan_hao_kuaidi_type'];?>
												&nbsp;&nbsp;单号/备注：<?php echo $m['dan_hao_fahuo_danhao'];?>
												&nbsp;&nbsp;金额：<?php echo $m['dan_hao_fahuo_kuan'];?>
												&nbsp;&nbsp;备注：<?php echo $m['dan_hao_fahuo_beizhu'];?>
												&nbsp;&nbsp;<a href="<?php echo site_url('admin/order/fahuo/'.$m['dingdan_list_id'].'/'.$city.'/'.$page);?>"><?php if($m['dan_hao_lock_fahuo']==0){echo '<i class="ace-icon fa fa-pencil red"></i>';}else{echo '<i class="fa fa-check-circle green"></i>';}?></a></td>
														</tr>
														<?php }?>
													</tbody>
												</table>
											</td>
										</tr>		
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
		<div id="editjiagebox" style="display:none;">
			<div style="margin:20px;list-style:none;">
			<li>成本价格：<input type="text" placeholder="成本价格" class="nav-search-input" style="width:150px" id="dan_hao_chengben" name="dan_hao_chengben" autocomplete="off" />
			</li>
			<li>出售价格：<input type="text" placeholder="出售价格" class="nav-search-input" style="width:150px" id="dan_hao_shoujia" name="dan_hao_shoujia" autocomplete="off" />
			</li>
			<li><input type="text" id="ddid" name="ddid" value="0"> </li>
			<div class="layui-layer-btn"><a class="layui-layer-btn0">确定</a><a class="layui-layer-btn1">取消</a></div>
			</div>
		</div>
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
function editddjiage(ddid,hao){
	layer.open({
		type: 1,
		shadeClose: true, //开启遮罩关闭
		title: "修改[ " +hao+ "] 价格", 
		content: '<div style="margin:20px;list-style:none;">'
			+'<li>成本价格：<input type="text" placeholder="成本价格" class="nav-search-input" style="width:150px" id="hao_chengben" name="hao_chengben" />'
			+'</li><li>出售价格：<input type="text" placeholder="出售价格" class="nav-search-input" style="width:150px" id="hao_shoujia" name="hao_shoujia" />'
			+'</li><li style="display:none;"><input type="text" id="dd_id" name="dd_id" value="'+ddid+'"> </li>'
			+'<div class="layui-layer-btn"><a class="layui-layer-btn0" onclick="editddjiageok();">确定</a><a class="layui-layer-btn1">取消</a></div>'
			+'</div>', 		
	});
}
function editddjiageok(){
	var dan_hao_id=$('#dd_id').val();
	var dan_hao_chengben=$('#hao_chengben').val();
	var dan_hao_shoujia=$('#hao_shoujia').val();
	layer.confirm('确定修改价格么？', {
		btn: ['是的，确定修改','关闭'] //按钮
	}, function(){
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
		$.ajax({
			type:"POST",
			url:baseurl+"index.php/admin/order/editddjiage",
			data:{dan_hao_id:dan_hao_id,dan_hao_chengben:dan_hao_chengben,dan_hao_shoujia:dan_hao_shoujia,<?php echo $this->config->item('csrf_token_name');?>:token},
			datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
			success:function(data){
				var s = eval("("+data+")"); //包数据解析为json 格
				if(s.success==1){
					layer.msg(s.msg);
					window.location.reload();
				}else{
					layer.msg(s.msg);
				}          
			},
		 });
	});
}
jQuery(function($){
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$(".lianxibox").each(function(index){
		$(this).mouseover(function(){
			var id=$(this).attr("data-id");
			var tel=$(this).attr("data-tel");
			layer.tips('联系电话:'+tel, '#lianxibox_'+id, {
				tips: [1, '#3595CC'],
				time: 4000
			});
		});						 
	});
	$(".maijiabox").each(function(index){
		$(this).click(function(){
			var id=$(this).attr("data-maijia");
			var sname=$(this).attr("data-uname");
			var haoma=$(this).attr("data-haoma");
			var qq=$(this).attr("data-uqq");
			var tel=$(this).attr("data-utel");
			if(haoma){
				var shaoma='<font color="red">订单号码：'+haoma+'</font><br />';
			}
			if(tel){
				var stel='联系电话：'+tel+'<br />';
			}
			if(qq){
				var sqq='QQ对话：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin='+qq+'&amp;site=qq&amp;menu=yes">'+qq+'</a>';
			}
			if(!qq && !tel){
				layer.open({
				  type: 4,
				  title: false,
				  shadeClose: true,
				  content: ['<p style="margin:20px;text-align:left;line-height:30px;">此卖家没有设置联系方式</p>', '#maijia_list_'+id+''],
				});	
			}else{
				layer.open({
				  type: 4,
				  title: '卖家['+sname+']',
				  shadeClose: true,
				  content:  ['<p style="margin:10px 20px;text-align:left;line-height:30px;">'+stel+sqq+'</p>', '#maijia_list_'+id+''],
				});				
			}
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
