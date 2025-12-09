<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $description;?>" />
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
			<div class="detail alldbg padding">
				<br />
				<h1><?php echo $title;?></h1>
				<p class="text-right">时间：<?php echo $dates;?> 浏览：<?php echo $llcs;?></p>
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