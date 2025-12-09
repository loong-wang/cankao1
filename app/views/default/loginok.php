<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
<link rel="stylesheet" href="<?php echo $viewmulu.'/public/css/TimeCircles.css';?>" />
<script type='text/javascript' src="<?php echo $viewmulu.'/public/js/TimeCircles.js';?>"></script>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">
		<div class="padding-big-top padding-big-bottom hidden-l"></div>
		<div class="line">
			<div class="xs8 xs3-move">
				<div id="someTimer2" class="someTimer pull-right" data-timer="30" data-utimer="30" style="width: 150px; margin: 0 auto;"></div>
				<div class="login-body text-gray">
					<li><span class="icon-check-circle" style="font-size: 36px;color:green;"></span>
					<span class="text-yellow" id="member"><?php echo ($this->session->userdata('uname'))?$this->session->userdata('uname'):$this->session->userdata('username');?></span>  ，<span style="font-size: 16px;">恭喜亲成功登陆！</span>
					<a href="<?php echo $shouye_url;?>" class="blue">继续逛</a> &nbsp;&nbsp;<a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="blue">会员中心</a>
					<?php if($this->session->userdata('ugroup')>10){?>&nbsp;&nbsp; <a href="<?php echo site_url('admin/login');?>" class="red">后台管理</a><?php }?>
					</li>
					<div class="padding-big-top padding-big-bottom"></div>
					<script language="javascript">$(document).ready(function(){layer.tips('<?php echo $ucity;?>，级别：<?php echo $this->session->userdata('group_name');?>', '#member', {tips: [3,'#999'],area: ['250px', '30px'],time: 0});})</script>   
					<li></li>
					<div class="alert alert-yellow">
					<?php if(!$this->session->userdata('uname')){?>
						<strong>注意：</strong>您的帐号：<?php echo $this->session->userdata('username');?> 会展示在页面、资讯、评论等地方，如不希望暴露，建议您  <a href="<?php echo site_url('member/editme/'.$citys['cid']);?>">修改昵称</a> 。
					<?php }else{?>
						<strong>提醒：</strong>每天登录送<?php echo $this->config->item('credit_login');?>分，记的常来哦 ，您目前积分：<?php echo $this->session->userdata('ucredit');?> 。
					<?php }?>
					</div>
				</div>						
			</div>
		</div>
		<div class="padding-big-top padding-big-bottom hidden-l"></div>
	</div>
<script>
$(function(){
	$('#someTimer2').TimeCircles({
		time : {
			Days: {
				boxs: false,
				show: false,
				text: "天",
				color: "#FC6"
			},
			Hours: {
				boxs: false,
				show: false,
				text: "时",
				color: "#9CF"
			},
			Minutes: {
				boxs: false,
				show: false,
				text: "分",
				color: "#fff"
			},
			Seconds: {
				boxs: true,
				show: false,
				text: "",
				color: "#F99"
			}
		},
		refresh_interval: 0.1,
		count_past_zero: false,
		circle_bg_color: "#fff",
		fg_width: 0.1,
		bg_width: 1.2
	});
	var times=$("#someTimer2").data('utimer')-1;
	setTimeout("window.location='<?php echo site_url('member/index/'.$citys['cid']);?>';", times*1000);
});
</script>

<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>