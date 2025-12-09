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
			<div class="tabst bg-foxc alldbg padding">
				<div class="tab-head border-bottom">
				<button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($hao_type==0){echo 'class="active"';}?>><a href="<?php echo site_url('taocan/yidong/'.$citys['cid']);?>">移动套餐</a> </li>
						<li <?php if($hao_type==1){echo 'class="active"';}?>><a href="<?php echo site_url('taocan/liantong/'.$citys['cid']);?>">联通套餐</a> </li>
						<li <?php if($hao_type==2){echo 'class="active"';}?>><a href="<?php echo site_url('taocan/dianxin/'.$citys['cid']);?>">电信套餐</a> </li>
						<li><a href="<?php echo site_url('zifei/yidong/'.$citys['cid']);?>">资费中心</a> </li>
					</ul>
				</div>
				<div class="bg-white">
					<div class="view-body padding-top">
						<div class="table-responsive">
						<br />
							<table class="table table-hover">
								<tbody><tr>
									<th>标题</th>
									<th>运营商</th>
									<th>浏览次数</th>
									<th>更新日期</th>
								</tr>
								<?php if(isset($taocan_list)){
								foreach($taocan_list as $v){?>
								<tr>
									<td class="line40"><a target="_blank" href="<?php echo site_url('taocan/show/'.$v['id']);?>"><?php echo $v['tc_title'];?></a></td>
									<td class="line40"><?php echo $hao_types;?></td>
									<td class="line40"><?php echo $v['tc_llcs'];?></td>
									<td class="line40"><?php echo date('Y-m-d',$v['tc_time']);?></td>
								</tr>
								<?php }}?>
							</tbody></table>
							<div class="margin-top text-center">
							<?php if(isset($pagination)){?>
							<ul class="pagination pagination-group">
							<?php echo $pagination?>									
							</ul>
							<?php }?>
							</div>
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