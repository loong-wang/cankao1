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
			<div class="padding-big-bottom hidden-l"></div>
			<?php $this->load->view('leftbox');?>
			</div>
			<div class="xl12 xs8 xm9 xb9">
			<div class="padding-big-bottom hidden-l"></div>
				<div class="tabst alldbgy padding-top">
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
										</tr>
										<tr>
											<td>
												<span class="text-default text-sub"><?php echo $haoma['hao_title'];?></span>
												<?php if($haoma['hao_jiage']==0 && $haoma['hao_huafei']==0){?>
												<span class="badge bg-dot">议价</span>
												<?php }?>
												<span class="text-gray"><?php echo $haoma['hao_lock'];?></span>
											</td>
											<td><?php echo $haoma['hao_pinpai'];?></td>
											<td>
												<?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($haoma['hao_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td><span class="icon-cny"></span><?php echo $haoma['hao_shoujia'];?></td>
											<td><span class="icon-cny"></span><?php echo $haoma['hao_huafei'];?></td>
											<td><span class="text-dot"><span class="icon-cny"></span><?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?></span></td>
											<td>
												<?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?>
											</td>
										</tr>
		
									</tbody>
									</table>
									<div class="bg padding text-small height-large">数量：<span class="text-red">1</span> 金额合计：<span class="text-red"><?php echo $haoma['hao_shoujia'];?></span>*<span class="text-red"><?php echo $zhekou;?></span>折+话费<span class="text-red"><?php echo $haoma['hao_huafei'];?></span> = <span class="text-red"><?php echo ($haoma['hao_shoujia']*$zhekou/10)+$haoma['hao_huafei'];?></span> 积分合计：<span class="text-green"><?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?></span>分
									<a href="<?php echo $shouye_url;?>" class="button bg-blue pull-right margin-right">继续购物</a>
									</div>
									
									<form accept-charset="UTF-8" method="post" action="<?php echo site_url('cart/gou/'.$citys['cid'].'/'.$haoma['id']);?>" class="form-x">
										<?php echo csrf_hidden();?>
										<br />
										<p class="bg padding-left border"><span class="icon-pencil-square-o"></span> <strong>请认真填写您的联系信息，以便我们查询到号码第一时间联系您</strong></p>
										<br />
										<div class="form-group">
											<div class="label">
												<label for="dan_name">
													收货人姓名 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_name" name="dan_name" size="30" placeholder="收货人姓名" data-validate="required:必填,chinese:必须为中文姓名" value="<?php if($this->session->userdata('userid')){echo $user['uzname'];}?>" >
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_dress">
													详细地址 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_dress" name="dan_dress" size="60" placeholder="收货人的详细地址" data-validate="required:必填" value="<?php if($this->session->userdata('userid')){echo $user['udress'];}?>" >
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_tel">
													联系电话 *</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_tel" name="dan_tel" size="30" placeholder="收货联系电话" data-validate="required:必填,mobile:必须为手机号或者电话" value="<?php if($this->session->userdata('userid')){echo $user['utel'];}?>" >
												<div class="input-note"></div>
											</div>
										</div>
										<div class="form-group">
											<div class="label">
												<label for="dan_tels">
													备用电话</label>
											</div>
											<div class="field">
												<input type="text" class="input input-auto" id="dan_tels" name="dan_tels" size="30" placeholder="收货联系备用电话" data-validate="mobile:必须为手机号或者电话">
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
														<input name="dan_paytype" type="radio" value="<?php echo $k;?>" <?php if(trim($v)=='货到付款'){echo 'checked="checked"';}?> data-validate="radio:请选择付款方式" >
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