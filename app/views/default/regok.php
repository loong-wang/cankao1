<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
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
		<div class="padding-big-top padding-big-bottom hidden-l"></div>
		<div class="line">
			<div class="xs8 xs3-move">
				<div class="login-body text-gray">
					<li><span class="icon-check-circle" style="font-size: 36px;color:green;"></span>
					<span class="text-yellow" id="member"><?php echo $this->session->userdata('username');?></span>  ，<span style="font-size: 16px;">恭喜亲注册成功！</span>
					<a href="<?php echo $shouye_url;?>" class="red">继续逛</a> &nbsp;&nbsp;<a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="red">会员中心</a>
					</li>
					<div class="padding-big-top padding-big-bottom"></div>
					<script language="javascript">$(document).ready(function(){layer.tips('新人注册送<?php echo $this->config->item('credit_start');?>积分，每天登录送<?php echo $this->config->item('credit_login');?>分啦！', '#member', {tips: [3,'#999'],area: ['250px', '30px'],time: 0});})</script>   
					<li></li>
					<div class="alert alert-yellow">
						<strong>注意：</strong>您的帐号：<?php echo $this->session->userdata('username');?> 会展示在页面、资讯、评论等地方，如不希望暴露，建议您  <a href="<?php echo site_url('member/editme/'.$citys['cid']);?>">修改昵称</a> 。</div>
				</div>						
			</div>
		</div>
		<div class="padding-big-top padding-big-bottom hidden-l"></div>
	</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>