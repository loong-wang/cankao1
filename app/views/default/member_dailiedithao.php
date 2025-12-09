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
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" action="<?php echo site_url('member/dailiedithao/'.$citys['cid'].'/'.$haoma['id']);?>" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												类型</label>
										</div>
										<div class="field">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
												<label class="button">
												<input name="hao_type" type="radio" value="<?php echo $k;?>" <?php if($haoma['hao_type']==$k){echo 'checked';}?> data-validate="radio:请选择" onchange="getvalues(this.value)" >
												<?php echo $v;?></label>
											<?php }}?>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_title">
												号码</label>
										</div>
										<div class="field">
											<input type="text" class="input input-auto" id="hao_title" name="hao_title" size="30" data-validate="required:必填" placeholder="号码" value="<?php echo $haoma['hao_title'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_city">
												城市</label>
										</div>
										<div class="field">
										<label class="button">
										<?php echo $ucity;?></label>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_pinpai">
												品牌</label>
										</div>
										<div class="field">
											<div id="pinpai_list"></div>
											<div id="pinpai_lists">
											<?php if($pinpai_list){
											foreach($pinpai_list as $k => $v){
											?>
												<label class="button button-little">
												<input name="hao_pinpai" type="radio" value="<?php echo $v['pin_num'];?>" <?php if($haoma['hao_pinpai']==$v['pin_num']){echo 'checked';}?> data-validate="radio:请选择" >
												<?php echo $v['pin_title'];?></label>
											<?php }}?></div>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_jiage">
												底价</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="hao_jiage" name="hao_jiage" size="30" placeholder="最底价格" data-validate="required:必填,plusinteger:验证没通过" value="<?php echo $haoma['hao_jiage'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_huafei">
												话费</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="hao_huafei" name="hao_huafei" size="30" placeholder="含话费" data-validate="plusinteger:验证没通过" value="<?php echo $haoma['hao_huafei'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_heyue">
												合约</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="hao_heyue" name="hao_heyue" size="40" placeholder="合约" data-validate="" value="<?php echo $haoma['hao_heyue'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-button">
										<button class="button bg-sub" type="submit">确认提交</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
function getvalues(obj)
{
	$("#pinpai_lists").css({'display':'none'});
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.ajax({
		//提交数据的类型 POST GET
		type:"POST",
		url:baseurl+"index.php/member/getpinpai",
		data:{hao_type:obj,<?php echo $this->config->item('csrf_token_name');?>:token},
		//返回数据的格式
		datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
		//在请求之前调用的函数
		beforeSend:function(){$('#pinpai_list').html('品牌加载中……');},
		//成功返回之后调用的函数             
		success:function(data){
			$('#pinpai_list').html(decodeURI(data));
		}   ,
		//调用执行后调用的函数
		complete: function(XMLHttpRequest, textStatus){
		   //alert(XMLHttpRequest.responseText);
		   //alert(textStatus);
			//HideLoading();
		},
		//调用出错执行的函数
		error: function(){
			//请求出错处理
		}         
	 });
}
</script>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>