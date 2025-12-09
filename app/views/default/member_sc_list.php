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
		<div class="line-big padding-top">
			<div class="xm2">
				<?php $this->load->view('member_leftbar');?>
			</div>
			<div class="xm10">
			<?php $this->load->view('member_top');?>
				<div class="tabst">
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
								<div class="table-responsive">
									<table class="table table-hover text-little">
										<tbody><tr>
											<td>
												号码
											</td>
											<td>
												默认品牌
											</td>
											<td>
												类型
											</td>
											<td>
												售价
											</td>
											<td>
												话费
											</td>
											<td>
												总价
											</td>
											<td>
												赠送积分
											</td>			
											<td>
												购买
											</td>
											<td>
												<span class="pull-right text-right">删除</span>
											</td>
										</tr>
										<?php 							
										if(isset($sc_list)){
										foreach($sc_list as $v){
										?>
										<tr>
											<td>
												<a href="<?php echo site_url('haoma/show/'.$v['id'].'/'.$v['hao_title']);?>"><span class="text-default text-sub"><?php echo $v['hao_title'];?></span></a>
												<span class="text-gray"><?php echo $v['hao_lock'];?></span>
											</td>
											<td><?php echo $v['hao_pinpai'];?></td>
											<td>
												<?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($v['hao_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td><span class="icon-cny"></span><?php echo $v['hao_shoujia'];?></td>
											<td><span class="icon-cny"></span><?php echo $v['hao_huafei'];?></td>
											<td><span class="text-dot"><span class="icon-cny"></span><?php echo $v['hao_shoujia']+$v['hao_huafei'];?></span></td>
											<td>
												<?php echo $v['hao_shoujia']+$v['hao_huafei'];?>
											</td>
											<td>
											<a class="text-green" href="<?php echo site_url('cart/gou/'.$citys['cid'].'/'.$v['id']);?>"><span class="icon-plus"></span> 下单</a>
											</td>
											<td class="text-right">
												<a href="<?php echo site_url('member/gouwuscdel/'.$citys['cid'].'/'.$v['sc_id']);?>"><span class="icon-trash-o text-red"></span> 删除</a>
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