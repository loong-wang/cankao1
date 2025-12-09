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
		<li><?php echo $title;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
			<div class="list-links">
				<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted">
				<span class="icon-volume-up"></span> 站内公告</h3>
				<?php if(isset($page_list)){
				foreach($page_list as $v){?>
				<a href="<?php echo site_url('page/show/'.$v['id']);?>" class="text-small"><span class="icon-clock-o text-fox"><?php echo date('m/d',$v['pages_time']);?></span>
				<?php echo $v['pages_title'];?></a>
				<?php }}?>
				<?php if(isset($pagination) && !empty($pagination)){?>
				<div class="margin-top margin-bottom text-center">
				<ul class="pagination pagination-group">
				<?php echo $pagination?>									
				</ul>
				</div>
				<?php }?>
			</div>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="detail alldbg">
				<br />
				<h1><?php echo $title;?></h1>
				<p class="text-right">发布时间：<?php echo $dates;?> 浏览：<?php echo $llcs;?></p>
				<hr class="margin-big-top margin-big-bottom">
				<p><?php echo $content?></p>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>