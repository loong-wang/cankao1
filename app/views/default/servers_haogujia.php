<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $title;?>,<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
	<ul class="bread breads">
		<li><span class="icon-home"></span> <span class="hidden-l">您的当前位置：</span><a href="<?php echo $shouye_url;?>"><?php echo $citys['cname'];?>首页</a> </li>
		<li><?php echo $stitle;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst bg-foxc alldbg">
				<div class="tab-head padding-top">
					<button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li><a href="<?php echo site_url('servers/jxlist/'.$citys['cid']);?>">吉凶列表</a> </li>
						<li><a href="<?php echo site_url('servers/jixiong/'.$citys['cid']);?>">号码吉凶测试</a> </li>
						<li class="active"><a id="jixiong" href="<?php echo site_url('servers/haogujia/'.$citys['cid']);?>">号码估价</a> </li>
						<li><a href="<?php echo site_url('servers/haocity/'.$citys['cid']);?>">号码归属地</a> </li>
					</ul>
				</div>
				<div class="bg-white">
					<script language="javascript">$(document).ready(function(){layer.tips('号码估价仅供参考，以实际售价为准！', '#jixiong', {tips: [3,'#999'],area: ['250px', '30px'],time: 0});})</script> 
					<br />
					<br />
					<br />
					<div class="bg padding-big">
						<form accept-charset="UTF-8" class="form-tips" id="foxform" name="foxform" action="<?php echo site_url('servers/haogujia/'.$citys['cid']);?>" method="post" novalidate="novalidate">
						<?php echo csrf_hidden();?>
						<div class="form-group">
							<div class="field input-inline clearfix">
								<input type="text" class="input" id="haoma" name="haoma" size="40" data-validate="required:必填,mobile:手机号格式不正确" placeholder="输入要查询的手机号" />
								<input class="button bg-dot" type="submit" value="评估号码价格" />
							</div>
							<div class="field clearfix"><div class="input-help"></div></div>
						</div>
						</form>
					</div>
					<?php if(isset($hao_list)){?>
					<div class="view-body margin-top">
						<ul class="list-text list-underline list-striped">
							<?php echo $hao_list;?>
						</ul>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>