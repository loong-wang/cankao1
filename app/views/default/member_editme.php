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
							<li class="active"><a href="#tab-a">完善资料</a> </li>
							<li><a href="<?php echo site_url('member/editpass/'.$citys['cid']);?>">修改密码</a> </li>
							<li><a href="<?php echo site_url('member/editavatar/'.$citys['cid']);?>">头像设置</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" action="<?php echo site_url('member/editme/'.$citys['cid']);?>" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="form-group">
										<div class="label">
											<label for="uname">
												昵称</label>
										</div>
										<div class="field">
											<input type="text" class="input input-auto" id="uname" name="uname" size="20" data-validate="required:必填" placeholder="用户昵称" value="<?php echo $user['uname'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="uzname">
												姓名</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="uzname" name="uzname" size="10" placeholder="真实姓名" data-validate="chinese:必须为汉字" value="<?php echo $user['uzname'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="utel">
												电话</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="utel" name="utel" size="30" placeholder="联系电话" data-validate="tel:验证没通过" value="<?php echo $user['utel'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="uqq">
												Q Q</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="uqq" name="uqq" size="30" placeholder="QQ联系" data-validate="qq:验证没通过" value="<?php echo $user['uqq'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="uemail">
												邮箱</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="uemail" name="uemail" size="30" placeholder="个人邮箱" data-validate="email:验证没通过" value="<?php echo $user['uemail'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="udress">
												地址</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="udress" name="udress" size="50" placeholder="通讯地址" value="<?php echo $user['udress'];?>">
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