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
			<div class="tabst bg-foxc alldbg navbar padding">
				<div class="tab-head border-bottom">
				 <button class="button icon-navicon" data-target="#navbarlist"></button>
				 <a href="<?php echo site_url('member/xinxiadd/'.$citys['cid']);?>" class="pull-right button button-small bg-yellow">免费发布二手信息</a>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($xinxi==10000){echo 'class="active"';}?>><a href="<?php echo site_url('xinxi/flist/'.$citys['cid'].'/10000');?>">全部信息</a> </li>
						<li <?php if($xinxi==0){echo 'class="active"';}?>><a href="<?php echo site_url('xinxi/flist/'.$citys['cid'].'/0');?>">供应</a> </li>
						<li <?php if($xinxi==1){echo 'class="active"';}?>><a href="<?php echo site_url('xinxi/flist/'.$citys['cid'].'/1');?>">求购</a> </li>
					</ul>
				</div>
				<div class="bg-white">
					<div class="view-body padding-top">
						<div class="table-responsive">
						<br />
							<table class="table table-hover">
								<tbody><tr>
									<th>标题</th>
									<th>价格</th>
									<th>浏览</th>
									<th>发布时间</th>
									<th>查看</th>
								</tr>
								<?php if(isset($xinxi_list)){
								foreach($xinxi_list as $v){?>
								<tr>
									<td class="line40"><span class="<?php if($v['x_type']==0){echo 'text-blue';}else{echo 'text-yellow';}?>">[<?php foreach(explode("|",$this->config->item('xinxi_types')) as $k => $s){
										if($v['x_type']==$k){
											echo $s;
										}
									}?>]</span>
									<a target="_blank" href="<?php echo site_url('xinxi/show/'.$v['id']);?>"><?php echo $v['x_title'];?></a></td>
									<td class="line40"><span class="text-yellow"><?php if($v['x_jiage']==0){echo '面议';}else{echo $v['x_jiage'];}?></span></td>
									<td class="line40"><?php echo $v['x_llcs'];?></td>
									<td class="line40"><?php echo date('Y-m-d',$v['x_time']);?></td>
									<td class="line40"><a target="_blank" href="<?php echo site_url('xinxi/show/'.$v['id']);?>">详情</a></td>
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