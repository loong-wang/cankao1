<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>注册新会员 - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">	
		<div class="line padding-big-top">
			<div class="xs7 xs1-move border-right">
				<div class="form-register">
					<div class="view-body">
						<form accept-charset="UTF-8" class="form-x" id="registerform" name="registerform" action="<?php echo site_url('user/register/'.$citys['cid']);?>" method="post" novalidate="novalidate">
						<?php echo csrf_hidden();?>
							<div class="form-group">
								<div class="label">
									<label for="username">
										会员账号</label>
								</div>
								<div class="field field-icon-right">
									<div class="xs6">
										<span class="icon icon-user"></span>
										<input type="text" class="input" id="username" name="username" size="30" placeholder="会员帐号" data-validate="required:帐号不能为空,username:帐号为英文字母开头的字母、下划线、数字,length#<16:长度小于15,length#>5:长度大于5,ajax#/index.php/user/check_register_username/:该用户名已经存在了">
									</div>
									<div class="xs6">
										<span class="padding-left height-big text-foxa">设置会员帐号</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="password">
										登陆密码</label>
								</div>
								<div class="field field-icon-right">
									<div class="xs6">
										<span class="icon icon-key"></span>
										<input type="password" class="input" id="password" name="password" size="30" placeholder="请输入密码" data-validate="required:必须输入密码,length#<16:长度小于15,length#>5:长度大于5">
									</div>
									<div class="xs6">
										<span class="padding-left height-big text-foxa">密码口令</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="password">
										确认密码</label>
								</div>
								<div class="field field-icon-right">
									<div class="xs6">
										<span class="icon icon-level-up"></span>
										<input type="password" class="input" id="password_confirm" name="password_confirm" size="30" placeholder="请输入确认密码" data-validate="required:必须输入确认密码,repeat#password:两次输入的密码不一致">
									</div>
									<div class="xs6">
										<span class="padding-left height-big text-foxa">密码确认</span>
									</div>
								</div>
							</div>
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
							<div class="form-group">
								<div class="label">
								</div>
								<div class="field label-block">
									<label>
										<input name="agreen" type="checkbox" data-validate="required:到阅读会员条款,length#>=1:请同意会员条款"> 我已阅读并同意用户注册协议
									</label>
								</div>
							</div>
							<div class="alert alert-red text-center" style="<?php if(!form_error('username') && !form_error('captcha_code') && !form_error('password')){echo 'display:none';}?>">
								<?php echo form_error('username',' ',' ');?><?php echo form_error('captcha_code',' ',' ');?><?php echo form_error('password',' ',' ');?>
							</div>
							<div class="margin-top"></div>
							<div class="form-button">
								<div class="xs6" id="registerdiv">
									<button class="button bg-gray button-block text-big" id="registersubmit" type="submit">会员注册</button>
								</div>
							</div>
						</form>
						<script type="text/javascript">
							$(document).ready(function() {
								var submit = $('#registersubmit');
								submit.attr('disabled',true);
								$('#password_confirm').click(function(){
									submit.attr('disabled',false);
								})
							});
						</script>
					</div>
				</div>
			</div>
			<div class="xs4">
				<div class="form-login">
					<div class="view-body padding-bottom">
					已有帐号，<a href="<?php echo site_url('user/login/'.$citys['cid']);?>" class="button bg-foxa radius-none text-black">立即登陆</a>
					</div>
					<div class="margin-big-top border-bottom border-dotted"></div>
					<div class="view-body">
					其他方式登陆
					</div>
				</div>
			</div>
		</div>
    </div><!-- /.container -->
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>