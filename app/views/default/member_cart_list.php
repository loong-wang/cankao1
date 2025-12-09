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
							<p class="bg padding-left border"><a href="<?php echo site_url('member/gouwudd/'.$citys['cid']);?>" class="pull-right margin-right fadein-right"><span class="icon-reorder text-red"></span> 查看所有订单</a><span class="icon-pencil-square-o"></span> <strong>确认商品信息</strong></p>
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
												<span class="pull-right text-right">删除</span>
											</td>
										</tr>
										<?php 
										$zj=0;										
										$hf=0;										
										$jf=0;										
										$haoid='';										
										if(isset($cart_list)){
										foreach($cart_list as $v){
										?>
										<tr>
											<td>
												<span class="text-default text-sub"><?php echo $v['hao_title'];?></span>
												<?php if($v['hao_jiage']==0 && $v['hao_huafei']==0){?>
												<span class="badge bg-dot">议价</span>
												<?php }?>
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
											<td class="text-right">
												<a href="<?php echo site_url('member/gouwuchedel/'.$citys['cid'].'/'.$v['che_id']);?>"><span class="icon-trash-o text-red"></span> 删除</a>
											</td>
										</tr>
										<?php 
										$zj +=$v['hao_shoujia'];
										$hf +=$v['hao_huafei'];
										$jf +=$v['hao_shoujia']+$v['hao_huafei'];
										$haoid .=$v['che_haoid'].'|';
										}}?>
									</tbody>
									</table>
									<div class="bg padding text-small height-large">数量：<span class="text-red"><?php echo $cart_count;?></span> 金额合计：<span class="text-red"><?php echo $zj;?></span>*<span class="text-red"><?php echo $zhekou;?></span>折+话费<span class="text-red"><?php echo $hf;?></span> = <span class="text-red"><?php echo ($zj*$zhekou/10)+$hf;?></span> 积分合计：<span class="text-green"><?php echo $jf;?></span>分
									<a href="<?php if($cart_count>0){echo site_url('member/gouwuchedelall/'.$citys['cid']);}?>" class="button bg-yellow pull-right">清空购物车</a><a href="<?php echo $shouye_url;?>" class="button bg-blue pull-right margin-right">继续购物</a>
									</div>
									<?php if(isset($pagination)){?>
									<ul class="pagination pagination-group pull-right">
									<?php echo $pagination?>									
									</ul>
									<?php }?>
									<?php if($cart_count>0){?>
									<form accept-charset="UTF-8" method="post" action="<?php echo site_url('member/gouwudingdan/'.$citys['cid']);?>" class="form-x">
										<?php echo csrf_hidden();?>
										<input type="hidden" name="dan_haoid" value="<?php echo $haoid;?>" >
										<br />
										<p class="bg padding-left border"><span class="icon-pencil-square-o"></span> <strong>请认真填写您的联系信息，以便我们查询到号码第一时间联系您</strong></p>
										<br />
										<div class="form-group">
											<div class="label">
												<label for="dan_name">
													收货人姓名 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_name" name="dan_name" size="30" placeholder="收货人姓名" value="<?php echo $user['uzname'];?>" data-validate="required:必填,chinese:必须为中文姓名">
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_dress">
													详细地址 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_dress" name="dan_dress" size="60" placeholder="收货人的详细地址" data-validate="required:必填" value="<?php echo $user['udress'];?>">
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_tel">
													联系电话 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_tel" name="dan_tel" size="30" placeholder="收货联系电话" data-validate="required:必填,tel:必须为手机号或者电话" value="<?php echo $user['utel'];?>">
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_tels">
													备用电话</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_tels" name="dan_tels" size="30" placeholder="收货联系备用电话" data-validate="tel:必须为手机号或者电话">
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_content">
													留言备注</label>
											</div>
											<div class="field">
												<textarea class="input" id="dan_content" name="dan_content" placeholder="收货补充说明"></textarea>
												<div class="input-note text-sub"></div>
											</div>
										</div>
										<br />
										<p class="bg padding-left border"><span class="icon-pencil-square-o"></span> <strong>选择付款方式</strong></p>
											<div class="form-group">
												<div class="label">
													<label for="dz_title">
														付款方式 *</label>
												</div>
												<div class="field">
													<?php if($this->config->item('citypays')){
													foreach(explode("|",$this->config->item('citypays')) as $k => $v){
													if(strstr(''.$this->config->item('city_pays').'',''.$k.'')){
													?>
														<label class="button">
														<input name="dan_paytype" type="radio" value="<?php echo $k;?>" data-validate="radio:请选择付款方式" >
														<?php echo $v;?></label>
													<?php }}}?>
													<div class="input-note"></div>
												</div>
											</div>											
										<br />										
											<div class="form-button">
												<button class="button bg-sub" type="submit">
													提交我的订单</button>
											</div>
										</form>
									<br />
									<?php if(strstr(''.$this->config->item('city_pays').'','2')){?>
									<p class="bg padding border"><?php echo $citys['cname'];?>免费送货上门，货到付款（特价号码除外）</p>
									<?php }?>
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