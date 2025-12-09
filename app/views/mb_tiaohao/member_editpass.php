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
							<li><a href="<?php echo site_url('member/editme/'.$citys['cid']);?>">完善资料</a></li>
							<li class="active"><a href="#tab-a">修改密码</a> </li>
							<li><a href="<?php echo site_url('member/editavatar/'.$citys['cid']);?>">头像设置</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" action="<?php echo site_url('member/editpass/'.$citys['cid']);?>" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="form-group">
										<div class="label">
											<label for="upassword">
												原密码</label>
										</div>
										<div class="field field-icon">
											<span class="icon icon-key"></span>
											<input type="password" class="input" id="upassword" name="upassword" size="30" placeholder="原密码" data-validate="required:必填,ajax#/index.php/member/edit_check_password/:原密码错误">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="npassword">
												新密码</label>
										</div>
										<div class="field field-icon">
											<span class="icon icon-key"></span>
											<input type="password" class="input" id="npassword" name="npassword" size="30" placeholder="新密码" data-validate="required:必填,length#<16:长度小于15,length#>5:长度大于5">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="qpassword">
												确认密码</label>
										</div>
										<div class="field field-icon">
											<span class="icon icon-key"></span>
											<input type="password" class="input" id="qpassword" name="qpassword" size="30" placeholder="确认密码" data-validate="required:必填,repeat#npassword:两次输入的密码不一致">
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
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>