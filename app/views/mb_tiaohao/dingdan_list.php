<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">
		<div class="line-middle">
			<div class="xs4 xm3 xb3 hidden-l">  
			<?php $this->load->view('leftbox');?>
			</div>
			<div class="xl12 xs8 xm9 xb9">
				<div class="tabst alldbgy padding">
					<div class="tab-head">
						<ul class="tab-nav">
							<li class="active"><a href="#tab-a"><?php echo $title;?></a> </li>
							<div class="pull-right">
							<span class="text-red text-little padding-top">今天是<?php echo date('Y-m-d',time())?></span>
							</div>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
							<p class="bg padding-left border"><a class="pull-right margin-right fadein-right" href="<?php echo site_url('cart/flist/'.$citys['cid']);?>"><span class="icon-shopping-cart text-red"></span> 我的购物车</a><span class="icon-reorder"></span> <strong>查看已有订单</strong></p>
								<div class="table-responsive">
									<table class="table table-hover text-little">
										<tbody><tr>
											<td>
												订单编号
											</td>
											<td>
												城市
											</td>
											<td>
												下单日期
											</td>
											<td>
												号码数量
											</td>
											<td>付款方式</td>
											<td>
												订单状态
											</td>
											<td>
												<span class="pull-right text-right">详情</span>
											</td>
										</tr>
										<?php 
										if(isset($dingdan_list)){
										foreach($dingdan_list as $v){
										?>
										<tr>
											<td>
												<span class="text-default text-red"><?php echo $v['dan_hao'];?></a>
											</td>
											<td><?php echo $v['dan_city'];?></td>
											<td>
												<?php echo date('Y-m-d H:i:s', $v['dan_time']);?>
											</td>
											<td><span class="text-red text-center"><?php echo substr_count($v['dan_haoid'], '|');?></span></td>
											<td><?php if($this->config->item('citypays')){
											foreach(explode("|",$this->config->item('citypays')) as $t => $s){
											if($v['dan_paytype']==$t){ echo $s;}}}?></td>
											<td>
												<?php if(substr_count($v['dan_haoid'], '|')*$v['dan_lock_wancheng']==0){?>
												<span class="text-gray">等待处理</span>
												<?php }elseif(substr_count($v['dan_haoid'], '|')*$v['dan_lock_wancheng']<substr_count($v['dan_haoid'], '|')*5){?>
												<span class="text-sub">正在处理</span>
												<?php }elseif(substr_count($v['dan_haoid'], '|')*$v['dan_lock_wancheng']==substr_count($v['dan_haoid'], '|')*5){?>
												<span class="text-green">订单完成</span>
												<?php }elseif(substr_count($v['dan_haoid'], '|')*$v['dan_lock_wancheng']>substr_count($v['dan_haoid'], '|')*5){?>
												<span class="text-red">问题订单</span>
												<?php }?>
											</td>
											<td class="text-right">
												<a class="text-green flash-hover" href="<?php echo site_url('cart/dingdans/'.$citys['cid'].'/'.$v['dan_hao']);?>"><span class="icon-eye "></span> 详情</a>
											</td>
										</tr>
										<?php }}?>
									</tbody>
									</table>
									<?php if(isset($pagination)){?>
									<ul class="pagination pagination-group pull-right">
									<?php echo $pagination?>									
									</ul>
									<?php }?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>