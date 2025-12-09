<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>会员登陆 - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">
		<div class="line">
			<div class="xs6 xm4 xs3-move xm4-move">
				<br>
				<form accept-charset="UTF-8" action="<?php echo site_url('user/login/'.$citys['cid']);?>" id="loginform" name="loginform" method="post" novalidate="novalidate">
				<?php echo csrf_hidden();?>
				<input type="hidden" name="comurl" value="<?php echo $shouye_url;?>">
					<div class="panel border-white form-login">
						<div class="alert alert-red text-center" style="<?php if(!form_error('username') && !form_error('captcha_code') && !form_error('password')){echo 'display:none';}?>">
							<?php echo form_error('username',' ',' ');?><?php echo form_error('captcha_code',' ',' ');?><?php echo form_error('password',' ',' ');?>
						</div>
						<div class="panel-body" style="padding:30px;">
							<div class="form-group">
								<div class="field field-icon-right">
									<span class="icon icon-user"></span>
									<input type="text" class="input" name="username" placeholder="登录账号" value="<?php echo set_value('username'); ?>" data-validate="required:请填写账号,length#>=3:账号长度不符合要求">
								</div>
							</div>
							<div class="form-group">
								<div class="field field-icon-right">
									<span class="icon icon-key"></span>
									<input type="password" class="input" name="password" placeholder="登录密码" value="<?php echo set_value('password'); ?>" data-validate="required:请填写密码,length#>5:密码长度不符合要求">
								</div>
							</div>
							<?php if($this->config->item('show_captcha')=='on'){?>
							<div class="form-group">
								<div class="field">
									<input type="text" class="input" name="captcha_code" placeholder="填写右侧的验证码" value="<?php echo set_value('captcha_code'); ?>" data-validate="required:请填写右侧的验证码,ajax#/index.php/user/check_captcha_code/:验证码不正确">
									<img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" onclick="javascript:reloadcode();" border="0"  width="65" height="32" class="passcode" />
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
						</div>
						
						<div class="panel-foots text-center border-white" id="logindiv">
							<button class="button button-block bg-gray text-big" id="loginsubmit" type="submit">登 陆</button>
						</div>
					<div class="margin-big-top"></div>
					</div>
				</form>
				<br>
			</div>
		</div>
	</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>