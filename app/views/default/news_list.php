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
		<li><a href="<?php echo site_url($sdao_url);?>"><?php echo $title;?></a> </li>
		<li><?php echo $stitle;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst bg-foxc alldbg navbar">
				<div class="tab-head padding-top">
				 <button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($hao_type==0){echo 'class="active"';}?>><a href="<?php echo site_url('news/yidong/'.$citys['cid']);?>">移动资讯</a> </li>
						<li <?php if($hao_type==1){echo 'class="active"';}?>><a href="<?php echo site_url('news/liantong/'.$citys['cid']);?>">联通资讯</a> </li>
						<li <?php if($hao_type==2){echo 'class="active"';}?>><a href="<?php echo site_url('news/dianxin/'.$citys['cid']);?>">电信资讯</a> </li>
						<li <?php if($hao_type==5){echo 'class="active"';}?>><a href="<?php echo site_url('news/hangye/'.$citys['cid']);?>">行业新闻</a> </li>
						<li <?php if($hao_type==6){echo 'class="active"';}?>><a href="<?php echo site_url('news/youhui/'.$citys['cid']);?>">优惠政策</a> </li>
						<li <?php if($hao_type==7){echo 'class="active"';}?>><a href="<?php echo site_url('news/duanxin/'.$citys['cid']);?>">经典短信</a> </li>
						<li <?php if($hao_type==8){echo 'class="active"';}?>><a href="<?php echo site_url('news/xiuxian/'.$citys['cid']);?>">生活休闲</a> </li>
					</ul>
				</div>
				<div class="bg-white">
					<div class="view-body padding-top">
						<div class="table-responsive">
						<br />
							<table class="table table-hover">
								<tbody><tr>
									<th>标题</th>
									<th>所属</th>
									<th>浏览次数</th>
									<th>更新日期</th>
									<th>查看</th>
								</tr>
								<?php if(isset($news_list)){
								foreach($news_list as $v){?>
								<tr>
									<td class="line40"><a target="_blank" href="<?php echo site_url('news/show/'.$v['id']);?>"><?php echo $v['news_title'];?></a></td>
									<td class="line40"><?php echo $hao_types;?></td>
									<td class="line40"><?php echo $v['news_llcs'];?></td>
									<td class="line40"><?php echo date('Y-m-d',$v['news_time']);?></td>
									<td class="line40"><a target="_blank" href="<?php echo site_url('news/show/'.$v['id']);?>">查看</a></td>
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