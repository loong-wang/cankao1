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
				<div class="tabst padding">
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
					<h3 class="text-red"><span class="icon-sign-in"></span> 恭喜您下单成功</h3>
							<div class="view-body margin-top">
							<p class="bg padding-left border"><a href="<?php echo site_url('cart/alldingdan/'.$citys['cid']);?>" class="pull-right margin-right fadein-right"><span class="icon-reorder text-red"></span> 查看所有订单</a><span class="icon-reorder"></span> <strong>订单详情</strong></p>
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
												城市
											</td>
											<td>
												售价
											</td>
											<td>
												话费
											</td>
											<td>
												低消
											</td>
											<td>
												总价												
											</td>											
											<td>
												赠送积分
											</td>
											<td>
												订单处理状态
											</td>
										</tr>
										<?php 
										$zj=0;										
										$hf=0;										
										$jf=0;			
										$zf=0;
										if(isset($dingdan)){
										foreach($dingdan_list as $v){
										?>
										<tr>
											<td>
												<span class="text-sub text-default"><?php echo $v['hao_title'];?></span>	
												<?php if($v['hao_jiage']==0 && $v['hao_huafei']==0){?>
												<span class="badge bg-dot">议价</span>
												<?php }?>
											</td>
											<td><?php echo $v['hao_pinpai'];?></td>
											<td>
												<?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($v['hao_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td><?php echo $v['hao_city'];?></td>
											<td><span class="icon-cny"></span><?php echo $v['hao_shoujia'];?></td>
											<td><span class="icon-cny"></span><?php echo $v['hao_huafei'];?></td>
											<td><?php echo $v['hao_heyue'];?></td>
											<td><span class="text-dot"><span class="icon-cny"></span><?php echo $v['hao_shoujia']+$v['hao_huafei'];?></span></td>
											<td>
												<?php echo $v['hao_shoujia']+$v['hao_huafei'];?>
											</td>
											<td>
											<?php if($v['dan_hao_lock_queren']==0){echo '-';}else{echo '确认';}?>
											<?php if($v['dan_hao_lock_zhifu']==0){echo '未支付';}else{echo '-支付';}?>
											<?php if($v['dan_hao_lock_fahuo']==0){echo '-';}else{echo '-发货';}?>
											<?php if($v['dan_hao_lock_wuxiao']==0){echo '-';}else{echo '-无效';}?>
											<?php if($v['dan_hao_lock_wancheng']==0){echo '-';}else{echo '-完成';}?>
											<?php if($v['dan_hao_lock_zuofei']==0){echo '-';}else{echo '-作废';}?>
											</td>
										</tr>
										<?php 
										$zj +=$v['hao_shoujia'];
										$hf +=$v['hao_huafei'];
										$jf +=$v['hao_shoujia']+$v['hao_huafei'];
										$zf +=$v['dan_hao_lock_zhifu'];
										}}?>
									</tbody>
									</table>
									<p class="bg padding-left"><span class="icon-comment-o"></span> 注：如订单含议价号码，请等待客服联系或者请您主动与我们客服联系沟通确认价格</p>
									<div class="bg padding text-small height-large">您的订单号 <span class="text-red"><?php echo $dingdan['dan_hao'];?></span>，数量：<span class="text-red"><?php echo count($dingdan_list);?></span> 金额合计：<span class="text-red"><?php echo $zj;?></span>*<span class="text-red"><?php echo $zhekou;?></span>折+话费<span class="text-red"><?php echo $hf;?></span> = <span class="text-red"><?php echo ($zj*$zhekou/10)+$hf;?></span> 积分合计：<span class="text-green"><?php echo $jf;?></span>分
									
									</div>
									<div class="bg padding text-small height-large" style="    height: 66px;">
									    <?php if($dingdan['dan_paytype']==4 && $zf==0){?>
									<a href="<?php if($this->config->item('ali_paytype')==3){echo site_url('alipay/shuang_alipay/'.$citys['cid'].'/'.(($zj*$zhekou/10)+$hf).'/'.$dingdan['dan_hao']);}?>" class="button bg-red pull-right margin-right">支付宝付款</a>
									<?php }?>
									<?php if($dingdan['dan_paytype']==5 && $zf==0){?>
									<a href="<?php echo site_url('wxpay/'.$payaction.'/'.$citys['cid'].'/'.(($zj*$zhekou/10)+$hf).'/'.$dingdan['dan_hao']);?>" class="button bg-red pull-right margin-right">微信付款</a>
									<?php }?>
									<a href="<?php echo $shouye_url;?>" class="button bg-blue pull-right margin-right">继续购物</a>
									</div>
									<?php if(isset($pagination)){?>
									<ul class="pagination pagination-group pull-right">
									<?php echo $pagination?>									
									</ul>
									<?php }?>
										<br />
										<p class="bg padding-left border"><span class="icon-reorder"></span> <strong>收货人信息</strong></p>
										<div class="view-body">
											<dl class="dl-inline clearfix">
												<dt>支付方式</dt>
												<dd><?php foreach(explode("|",$this->config->item('citypays')) as $k => $s){if($dingdan['dan_paytype']==$k){echo $s;}}?></dd>
											</dl>
											<dl class="dl-inline clearfix">
												<dt>收货人</dt>
												<dd><?php echo $dingdan['dan_name'];?></dd>
											</dl>
											<dl class="dl-inline clearfix">
												<dt>送货地址</dt>
												<dd><?php echo $dingdan['dan_dress'];?></dd>
											</dl>
											<dl class="dl-inline clearfix">
												<dt>联系电话</dt>
												<dd><?php echo $dingdan['dan_tel'];?></dd>
											</dl>
											<?php if(isset($dingdan['dan_tels']) && !empty($dingdan['dan_tels'])){?>
											<dl class="dl-inline clearfix">
												<dt>备用电话</dt>
												<dd><?php echo $dingdan['dan_tels'];?></dd>
											</dl>
											<?php }?>
											<dl class="dl-inline clearfix">
												<dt>留言备注</dt>
												<dd><?php echo html_entity_decode(br2nl($dingdan['dan_content']));?></dd>
											</dl>
										</div>
									<br />
									<?php if(strstr(''.$this->config->item('city_pays').'','2')){?>
									<p class="bg padding border"><?php echo $citys['cname'];?>免费送货上门，货到付款（特价号码除外）</p>
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