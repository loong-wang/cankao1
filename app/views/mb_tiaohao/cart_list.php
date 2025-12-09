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
<?php echo js_url('jquery.upload');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container" data-role="page">
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
							<span class="text-red text-little padding-top"><a href="<?php echo site_url('cart/alldingdan/'.$citys['cid']);?>" class="pull-right margin-right fadein-right"><span class="icon-reorder text-red"></span> 查看所有订单</a></span>
							</div>
						</ul>
					</div>
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
								<td><?php echo $v['hao_pinpai'];?><?php if($v['pin_shuxing']==0){echo '<span class="text-gray text-little">可转品牌</span>';}?></td>
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
									<a href="<?php echo site_url('cart/del/'.$citys['cid'].'/'.$v['che_id']);?>"><span class="icon-trash-o text-red"></span> 删除</a>
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
						<div class="bg padding height-large">数量：<span class="text-red"><?php echo $cart_count;?></span> 金额合计：<span class="text-red"><?php echo $zj;?></span>*<span class="text-red"><?php echo $zhekou;?></span>折+话费<span class="text-red"><?php echo $hf;?></span> = <span class="text-red"><?php echo ($zj*$zhekou/10)+$hf;?></span> 积分合计：<span class="text-green"><?php echo $jf;?></span>分
						<a href="<?php if($cart_count>0){echo site_url('cart/delall/'.$citys['cid']);}?>" class="button bg-yellow pull-right">清空购物车</a><a href="<?php echo $shouye_url;?>" class="button bg-blue pull-right margin-right">继续购物</a>
						</div>
						<?php if(isset($pagination)){?>
						<ul class="pagination pagination-group pull-right">
						<?php echo $pagination?>									
						</ul>
						<?php }?>
						<?php if($cart_count>0){?>
						<form accept-charset="UTF-8" method="post" action="<?php echo site_url('cart/dingdan/'.$citys['cid']);?>" class="form-x" id="ajaxForm">
							<?php echo csrf_hidden();?>
							<input type="hidden" name="dan_haoid" value="<?php echo $haoid;?>" >
							<br />
							<p class="bg padding border"><span class="icon-pencil-square-o"></span> <strong>请认真填写您的联系信息，以便我们查询到号码第一时间联系您</strong></p>
							<br />
							<div class="form-group">
								<div class="label">
									<label for="dan_name">
										收货人姓名 *</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dan_name" name="dan_name" size="30" placeholder="收货人姓名" data-validate="required:必填,chinese:必须为中文姓名">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dan_dress">
										详细地址 *</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dan_dress" name="dan_dress" size="60" placeholder="收货人的详细地址" data-validate="required:必填">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dan_tel">
										联系电话 *</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dan_tel" name="dan_tel" size="30" placeholder="收货联系电话" data-validate="required:必填,mobile:必须为手机号或者电话">
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
							<p class="bg padding border"><span class="icon-pencil-square-o"></span> <strong>选择付款方式</strong></p>
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
							<div class="border-top">
								<p class="alert alert-yellow">
									<strong>注意：</strong>根据国家工信部相关规定，所有手机号码销售都需要提供身份证实名验证,到店自取。需要您上传身份证照片及在收货时查看身份证原件及收取复印件。国家工信部《电话用户真实身份信息登记规定》（工业和信息化部令第25号）、电话“黑卡”治理专项行动工作方案。
								</p>								
							</div>		
							<div class="tab" style="display:none;">
								<div class="tab-head">
									<strong><span class="icon-pencil-square-o"></span> 实名验证</strong>
									<ul class="tab-nav">
										<li class="active"><a href="#tab-rza">二维码拍摄上传</a> </li>
										<li><a href="#tab-rzb">电脑文件上传</a> </li>
									</ul>
								</div>
								<div class="tab-body">
									<div class="tab-panel active" id="tab-rza">
										<p class="alert alert-blue">
											<strong>提示：</strong>您提供的身份信息我们承诺将予以加密保护，此证件照片仅用于办理本次入网业务。
										</p>
										<div class="table-responsive">
											<table class="table rcode-box">
												<tr>
													<td class="text-center">
														<img src="<?php echo site_url('php_qrcode');?>" style="margin:5px;border:2px solid #ddd;">
														<p>微信扫描上传</p>
													</td>
													<td class="text-center">
													<div class="margin-large-top">
														<h2>二维码扫描</h2>
														<h1>更简单更快捷</h1>
													</div>
													</td>
													<td class="text-center">
														<img src="<?php echo base_url('public/img/phone.jpg');?>">
													</td>
												</tr>
											</table>
										</div>										
									</div>
									<div class="tab-panel" id="tab-rzb">
										<p class="alert alert-blue">
											<strong>提示：</strong>您提供的身份信息我们承诺将予以加密保护，此证件照片仅用于办理本次入网业务。
										</p>
										<div class="table-responsive">
											<table class="table rcode-box">												
												<tr>
													<td>
													<div class="upload-c ld1" >
														<a id="up_1" href="javascript:;" class="upload_btn up1">
															<input id="file_1" capture="camera" accept="image/*" name="file_1" type="file" class="intfile">
														</a>
														<span id="img_1" class="upload-pic" style="display:none"><img name="pic1" src=""/><div style="width: 198px; height: 125px;" class="watermark"></div></span>
														<a id="mobidfy_1" style="display:none" href="javascript:;" class="upload_edit btn">修改</a>
													</div>

													</td>
													<td>
													<div class="upload-c ld2">
														<div class="uploadling"><div></div></div>
														<a id="up_2" href="javascript:;" class="upload_btn up2">
															<input id="file_2" capture="camera" accept="image/*" name="file_2" type="file" class="intfile">
														</a>
														<span id="img_2" class="upload-pic" style="display:none"><img name="pic2" src=""><div style="width: 198px; height: 125px;" class="watermark"></div></span>
														<a id="mobidfy_2" style="display:none" href="javascript:;" class="upload_edit btn">修改</a>
													</div>
													</td>
													<td>
													<div class="upload-c ld3">
														<div class="uploadling"><div></div></div>
														<a id="up_3" href="javascript:;" class="upload_btn up3">
															<input id="file_3" capture="camera" accept="image/*" name="file_3" type="file" class="intfile">
														</a>
														<span id="img_3" class="upload-pic" style="display:none"><img name="pic3" src=""><div style="width: 198px; height: 125px;" class="watermark"></div></span>
														<a id="mobidfy_3" style="display:none" href="javascript:;" class="upload_edit btn">修改</a>
													</div>
													</td>
												</tr>
												<tr>
													<td>
														<p>示例</p>
														<img src="<?php echo base_url('public/img/example01.jpg');?>">
													</td>
													<td>
														<p>示例</p>
														<img src="<?php echo base_url('public/img/example02.jpg');?>">
													</td>
													<td>
														<p>示例</p>
														<img src="<?php echo base_url('public/img/example03.jpg');?>">
													</td>
												</tr>
											</table>
											<p class="text-gray">请使用实拍照片，扫描、PS等不能通过审核。图片尺寸最大不超过5M，照片支持jpg/jpeg/bmp格式。</p>
										</div>	
									</div>
								</div>
							</div>	
							<div id="upsok"></div>
							<br>
							<?php if($this->config->item('show_captcha')=='on'){?>
							<div class="form-group">
								<div class="label">
									<label for="yzm">
										验证码</label>
								</div>
								<div class="field field-icon-right">
									<div class="xs6">
										<input type="text" class="input" name="captcha_code" placeholder="填写验证码答案" data-validate="required:请填写验证码答案,ajax#/index.php/user/check_captcha_code/:验证码不正确">
										<img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" onclick="javascript:reloadcode();" border="0"  width="65" height="32" class="passcode" />
									</div>
									<div class="xs6">
										<span class="padding-left height-big text-foxa">验证码</span>
									</div>
								</div>
							</div>
							<script language="javascript">
							//刷新图片
							function reloadcode() {//刷新验证码函数
							 var verify = document.getElementById('checkCodeImg');
							 verify.setAttribute('src', '<?php echo site_url('captcha_code?');?>' + Math.random());
							}
							</script>
							<?php }?>
							<br />										
								<div class="form-button">
									<button class="button bg-sub" type="submit" id="btnAjaxSubmit">
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
<script type="text/javascript">
$(document).ready(function(){
	$(".upload_btn").on("click",function(e){
		var fileId = this.id;
		var index = getIndex(fileId);
		if(index){
			doUpload(index);
			$(".ld" + index + " .uploadling").show();
		}
	});
	$(".upload_edit").on("click",function(e){
		var fileId = this.id;
		var index = getIndex(fileId);
		if(index){
			$("#img_" + index).hide();
			$("img[name='pic"+index+"']").attr("src",'');
			$("#up_" + index).fadeIn();			
		}
	});
});
function getIndex(domId){
	return domId.substring(domId.length - 1);
}
function doUpload(index) {
	// 上传方法
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$(".ld" + index + " .uploadling").show();
	$.upload({
		// 上传地址
		url:baseurl+"index.php/upload/upload_renz/"+index, 
		// 文件域名字
		fileName: 'img', 
		// 其他表单数据
		params:{<?php echo $this->config->item('csrf_token_name');?>:token},
		// 上传完成后, 返回json, text
		dataType: 'json',
		// 上传之前回调,return true表示可继续上传
		onSend: function() {
			return true;
		},
		// 上传之后回调
		onComplate: function(data) {
			if(data.file_url){
				//$('#'+index).val(data.file_url);
				$(".ld" + index + " .uploadling").hide();
				$('#up_'+index).css({'display':'none'});
				$("img[name='pic"+index+"']").attr("src",baseurl + data.file_url + '?rnd=' + Math.random());
				$('#mobidfy_'+index).show();
				$('#img_'+index).fadeIn();
			} else {
				alert(data.error);
			}
		}
	});
}

$(function() {
	$("#btnAjaxSubmit").click(function() {
		$("#ajaxForm").ajaxSubmit();
	});
});

</script>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>oter');?>
</body>
</html>