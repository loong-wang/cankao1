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
	<div class="line-middle">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst detail alldbg navbar padding">
				<div class="tab-head border-bottom">
				 <button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($page_type==4){echo 'class="active"';}?>><a href="<?php echo site_url('page/bangzhu/'.$citys['cid']);?>">购号帮助</a> </li>
						<li <?php if($page_type==5){echo 'class="active"';}?>><a href="<?php echo site_url('page/wenti/'.$citys['cid']);?>">常见问题</a> </li>
						<li <?php if($page_type==6){echo 'class="active"';}?>><a href="<?php echo site_url('page/songhuo/'.$citys['cid']);?>">发货配送</a> </li>
						<li <?php if($page_type==7){echo 'class="active"';}?>><a href="<?php echo site_url('page/pays/'.$citys['cid']);?>">支付方式</a> </li>
						<li <?php if($page_type==8){echo 'class="active"';}?>><a href="<?php echo site_url('page/wes/'.$citys['cid']);?>">联系我们</a> </li>
					</ul>
				</div>
				<br />
				<h1><?php echo $title;?></h1>
				<br />
				<div class="view-body">
				<?php if(isset($page_hezuo)){
				foreach($page_hezuo as $v){?>
				<dl>
						<dt class="border-top-bottom border-dotted" style="border-top:0;"><h3 class="text-dot height-big"><?php echo $v['pages_title'];?></h3></dt>
						<dd><?php echo html_entity_decode(br2nl($v['pages_content']));?></dd>
					</dl>
				<?php }}?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>