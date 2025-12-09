<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
<?php $this->load->view('common/header-meta');?>
<?php echo css_url('select2');?>
<?php echo css_url('bootstrap-editable');?>
<?php echo css_url('jNotify.jquery');?>
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
								<a class="btn btn-xs <?php if($ug==10000){?>btn-danger<?php }else{?>btn-info<?php }?>" href="<?php echo site_url('admin/haoma/haolist/10000/'.$city);?>">全部</a>
								<?php if($this->config->item('hao_types')){
								foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
								?>
									<a class="btn btn-xs <?php if($ug==$k){?>btn-danger<?php }else{?>btn-info<?php }?>" href="<?php echo site_url('admin/haoma/haolist/'.$k.'/'.$city);?>"><?php echo $v;?></a>
								<?php }}?>
							</ul><!-- /.breadcrumb -->
							<?php if($this->session->userdata('ucity')==0){?>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-xs btn-danger dropdown-toggle" aria-expanded="true">
									<?php echo $cityname;?>
									<i class="ace-icon fa fa-angle-down icon-on-right"></i>
								</button>

								<ul class="dropdown-menu dropdown-danger">
									<div class="citybox">
									<a class="badge btn-minier <?php if($city==0){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/haoma/haolist/'.$ug.'/0');?>">全部</a>
									<?php if($citys){
									foreach($citys as $v){?>
										<a class="badge btn-minier <?php if($city==$v['cid']){?>badge-success<?php }else{?>badge-grey<?php }?>" href="<?php echo site_url('admin/haoma/haolist/'.$ug.'/'.$v['cid']);?>"><?php echo $v['cname'];?></a>
									<?php }}?>
									</div>
								</ul>
							</div>
							<?php }?>
							<div style="float:right;width:480px;display:inline-block;">
								<form accept-charset="UTF-8" class="form-search" action="<?php echo site_url('admin/haoma/search');?>" role="form" method="post" novalidate="novalidate" >
								<input name="ug" type="hidden" value="<?php echo $ug;?>">
								<input name="city" type="hidden" value="<?php echo $city;?>">
								<div class="btn-group" style="margin-left:0px;">
								<select class="form-controls" id="form-field-select-1" name="sotype">
									<option value="0" <?php if($sotype && $sotype==0){echo 'selected';}?>>搜索</option>
									<option value="1" <?php if($sotype && $sotype==1){echo 'selected';}?>>卖家</option>
									<option value="2" <?php if($sotype && $sotype==2){echo 'selected';}?>>号码</option>
								</select>
								</div>
								<div class="btn-group" style="margin-left:10px;">
								<select class="form-controls" id="form-field-select-1" name="hao_pinpai">
									<option value="">选择品牌</option>
									<?php if($pinpai_list){
										foreach($pinpai_list as $v){?>
									<option value="<?php echo $v['pin_num'];?>" <?php if($hao_pinpai && $hao_pinpai==$v['pin_num']){echo 'selected';}?>><?php echo $v['pin_title'];?></option>
									<?php }}?>
								</select>
								</div>
								<div class="btn-group" style="margin-left:0px;">
								<select class="form-controls" id="form-field-select-1" name="hao_b">
									<option value="0" <?php if($hao_b && $hao_b==0){echo 'selected';}?>>关键字位置</option>
									<option value="1" <?php if($hao_b && $hao_b==1){echo 'selected';}?>>任意位置</option>
									<option value="2" <?php if($hao_b && $hao_b==2){echo 'selected';}?>>开头位置</option>									
									<option value="3" <?php if($hao_b && $hao_b==3){echo 'selected';}?>>结尾位置</option>
								</select>
								</div>								
								<div class="nav-search" id="nav-search">
									<?php echo csrf_hidden();?>
										<span class="input-icon">
											<input type="text" placeholder="输入关键字回车" class="nav-search-input" id="q" name="q" autocomplete="off" <?php if($q){echo 'value='.$q.'';}?> />
											<i class="ace-icon fa fa-search nav-search-icon"></i>
										</span>
								</div>
							</form>
							</div>
						</div>
						<div class="space-4"></div>
						<div class="row">
							<div class="col-xs-12">
							<?php if($haoma_list && strstr($_SERVER[ 'REQUEST_URI' ],"haoma/haolist")){?>
							<form accept-charset="UTF-8" action="<?php echo site_url('admin/haoma/batch_process');?>" role="form" method="post" novalidate="novalidate" >
							<?php echo csrf_hidden();?>
							<?php }?>
							<table id="sample-table-1" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<?php if($haoma_list && strstr($_SERVER[ 'REQUEST_URI' ],"haoma/haolist")){?>
											<th><input id="checkall" type="checkbox" checked="1"></th>
											<?php }?>
											<th>标题</th>
											<th>品牌</th>
											<th class="hidden-480">城市</th>
											<th class="hidden-480">类型</th>
											<?php if($this->session->userdata('ugroup')>=18){?>
											<th class="hidden-480">底价</th>
											<?php }?>
											<th class="hidden-480">出售价</th>
											<th class="hidden-480">话费</th>
											<th class="hidden-480">所有人</th>
											<th class="hidden-480">级别</th>
											<th class="hidden-480">状态</th>
											<th class="hidden-480">更新时间</th>
											<th class="text-right">
											<a href="<?php echo site_url('admin/haoma/add');?>" class="btn btn-xs btn-info tooltip-info" data-rel="tooltip" title="增加" data-original-title="增加">
												<i class="ace-icon fa fa-plus bigger-120"></i>												
											</a>
											</th>
										</tr>
									</thead>

									<tbody>
									<?php if(isset($haoma_list)){
									foreach($haoma_list as $k => $v){?>										
										<tr>
											<?php if($haoma_list && strstr($_SERVER[ 'REQUEST_URI' ],"haoma/haolist")){?>
											<td>
											<input name="<?php echo $k?>" checked="1" value="<?php echo $v['id']?>" type="checkbox">
											</td>
											<?php }?>
											<td><a target="_blank" href="<?php echo site_url('haoma/show/'.$v['city'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_title'];?></a>
											<?php if($this->session->userdata('ucity')==$v['hao_city']){?> <i class="fa fa-flag green bigger-130 hidden-480"></i><?php }?></td>
											<td><?php echo $v['hao_pinpai'];?></td>
											<td class="hidden-480"><?php echo $v['hao_city'];?></td>
											<td class="hidden-480"><?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($v['hao_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?></td>
											<?php if($v['hao_jiage']==0 && $v['hao_huafei']==0){?>
											<td class="hidden-480 red">议价</td>
											<td class="hidden-480 red">议价</td>
											<?php }else{?>
											<td class="hidden-480"><?php echo $v['hao_jiage'];?></td>
											<td class="hidden-480"><?php echo $v['hao_shoujia'];?></td>
											<?php }?>
											<td class="hidden-480"><?php echo $v['hao_huafei'];?></td>
											<td class="hidden-480"><?php echo $v['hao_user'];?></td>
											<td class="hidden-480"><?php echo $v['hao_dig'];?></td>
											<td class="hidden-480"><?php echo $v['hao_lock'];?></td>
											<td class="hidden-480"><?php echo date('Y-m-d H:i:s',$v['hao_time']);?></td>
											<td class="text-right">
												<div class="hidden-sm hidden-xs btn-group">
													<a href="<?php echo site_url('admin/haoma/edit/'.$v['id']);?>" class="btn btn-xs btn-success tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</a>

													<a href="<?php echo site_url('admin/haoma/del/'.$v['id']);?>" class="btn btn-xs btn-danger tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
																<a href="<?php echo site_url('admin/haoma/edit/'.$v['id']);?>" class="tooltip-success" data-rel="tooltip" title="编辑" data-original-title="编辑">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
																	</span>
																</a>
															</li>

															<li>
																<a href="<?php echo site_url('admin/haoma/del/'.$v['id']);?>" class="tooltip-error" data-rel="tooltip" title="谨慎删除" data-original-title="谨慎删除">
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
									</tbody>
									</form>
								</table>
								<?php if(isset($pagination)){?>
								<ul class="pagination pull-right">
								<?php echo $pagination?>									
								</ul>
								<?php }?>
								<?php if($haoma_list && strstr($_SERVER[ 'REQUEST_URI' ],"haoma/haolist")){?>
								<input class="btn btn-primary btn-danger" name="batch_del" type="submit" value="批量删除" />
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
	$.fn.editable.defaults.mode = 'popup';   
	$('.digbox').editable({
		url: baseurl+"index.php/admin/haoma/dig_edit",
		name:'hao_dig',
        type: 'select2',  
        source: [
			<?php foreach(explode("|",$this->config->item('haojis')) as $k => $s){?>
              {value: <?php echo $k;?>, text: '<?php echo $s;?>'},
            <?php }?>
           ],
		select2: {'width': 80},
		success: function(response, newValue) {
			location.reload();
		}
    });
	$('.lockbox').editable({
		url: baseurl+"index.php/admin/haoma/lock_edit",
		name:'hao_lock',
        type: 'select2',  
        source: [
			<?php foreach(explode("|",$this->config->item('haolocks')) as $k => $s){?>
              {value: <?php echo $k;?>, text: '<?php echo $s;?>'},
            <?php }?>
           ],
		select2: {'width': 80},
		success: function(response, newValue) {
			location.reload();
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
<?php echo js_url('jquery-ui.custom');?>
<?php echo js_url('jquery.ui.touch-punch');?>
<?php echo js_url('x-editable/bootstrap-editable');?>
<?php echo js_url('x-editable/ace-editable');?>
<?php echo js_url('select2');?>
<?php echo js_url('jNotify.jquery');?>

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
$(document).ready(function(){
  $("#checkall").bind('click',function(){
  $("input:checkbox").prop("checked",$(this).prop("checked"));//全选
  });
});
</script>
</body>
</html>
