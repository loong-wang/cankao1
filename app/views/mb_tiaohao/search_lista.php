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
			<div class="hidden-l hidden-s sebox bg">
				<?php if($haotype==3){
					$this->load->view('inc_ssearchboxss');
				}else{
					$this->load->view('inc_searchbox');
				}
				?>
			</div>
			
			<div class="responsive bg-white xh-num-list padding-top">
					<div class="num-list" class="line">
						<?php if($haoma_list){
						foreach($haoma_list as $v){?>
						<li class="<?php if($v['hao_lock']>0){echo 'dg';}?>">
							<div class="p-num"><span class="s0"><?php echo substr($v['hao_title'],0,3);?></span><span class="s1"><?php echo substr($v['hao_title'],3,4);?></span><span class="s2"><?php echo substr($v['hao_title'],7,4);?></span></div>
								<div class="lanmu"><?php echo $hao_citys;?><?php $hty=explode("|",$this->config->item('hao_types'));echo $hty[$v['hao_type']];?></div>
							<div class="p-infor"><span><em class="val"><?php echo $v['hao_shoujia'];?></em> (话费:<?php echo $v['hao_huafei'];?>元)</span></div>
							<div class="p-operate">
								<a href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>" class="btn-buy">预约</a>	
								<a href="<?php echo site_url('member/gouwusc/'.$citys['cid'].'/'.$v['id']);?>" class="btn-collect">收藏</a>
							</div>
							<div class="p-mask"></div>
						</li>
						<?php }}?>					
					</div>
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
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>