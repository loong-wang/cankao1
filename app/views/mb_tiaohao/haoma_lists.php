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
			<?php $this->load->view('inc_ssearchboxss');?>
			</div>
			<div class="line hidden-b hidden-m hidden-s show-l">
				<div class="show-l">
					<?php $this->load->view('inc_ghsearchbox');?>
				</div>
			</div>
			<div class="panel margin-top padding border border-bg clearfix radius-none">
				<div class="padding-top hidden-l"></div>
				<dl class="dl-inline haoma-shaixuan">
					<dt>品牌：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_pinpai==0){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($hao_pinpais) && !empty($hao_pinpais)){
					foreach($hao_pinpais as $v){?>
						<a class="<?php if($hao_pinpai==$v['pin_num']){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$v['pin_num'].'/'.$title_hao_types.'/'.$hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v['pin_title'];?></a>
					<?php }}?>
					&nbsp;</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan">
					<dt>价格：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_jiage==100){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_jiages)){
					foreach($set_hao_jiages as $k => $v){?>
						<a class="<?php if($hao_jiage==$k){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$k.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
					<?php }}?>
					</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan hidden-l hidden-s">
					<dt>数位：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/100/10/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_shuweis==100){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_shuweis)){
					foreach($set_hao_shuweis as $k => $v){?>
						<a class="<?php if($hao_shuweis==(9-$k)){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/'.(9-$k).'/0/100/10/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?>较多</a>
					<?php }}?>
					</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan">
					<dt>规律：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/100/10/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_redian==0){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_redians)){
					foreach($set_hao_redians as $k => $v){?>
						<a class="<?php if($hao_redian==($v+1000)){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/'.($v+1000).'/100/10/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
					<?php }}?>
					</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan">
					<dt>尾数：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_ends==100){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_ends)){
					foreach($set_hao_ends as $k => $v){?>
						<a class="<?php if($hao_ends==$k){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$k.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
					<?php }}?>
					</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan hidden-l hidden-s">
					<dt>特点：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($hao_tedians==10){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_tedians)){
					foreach($set_hao_tedians as $k => $v){?>
						<a class="<?php if($hao_tedians==$k){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$k.'/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
					<?php }}?>
					</dd>
			   </dl>
			   <hr class="hidden-l hidden-s" />
			   <dl class="dl-inline haoma-shaixuan hidden-l hidden-s">
					<dt>寓意：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/100');?>" class="<?php if($hao_jixiong==100){echo 'active';}?>">不限</a>
					</dt><dd class="auto"><?php if(isset($jixiong)){
					$k=0;
					foreach($jixiong as $a){
					$arr=explode('，',$a['jx_memo']);
					if(strstr($a['jx_name'], "吉")){
					$k=$k+1;
					if($k<17){
					//if($k==10){echo '<br />';}?>
						<a class="<?php if($hao_jixiong==$a['jx_id']){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$a['jx_id']);?>"><?php echo $arr[0];?></a>
					<?php }}}}?><span class="pull-right text-gray text-little">仅供娱乐</span>
					</dd>
			   </dl>
			</div>
			<div class="haoma-yixuan margin-top margin-bottom-top padding border text-small hidden-l hidden-s">
			您选择了:<?php echo $yixuan;?>
			<span class="pull-right"><a href="<?php echo site_url($hao_url.'/'.$citys['cid']);?>">删除所有条件</a></span>
			</div>
			<div class="margin-top tabst bg-foxc alldbg">
				<div class="tab-head padding-top border-bottom">
					<div class="float-right bread-box text-right hidden-l hidden-m" style="">
						<?php if($list_ax<>3){?>
						<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_ax.'/0/0');?>">价格</a> <span class="<?php if($list_ax==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
						<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/0/'.$list_bx.'/0');?>">号码</a> <span class="<?php if($list_bx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
						<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/0/0/'.$list_cx);?>">时间</a> <span class="<?php if($list_cx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
						<?php }else{?>
						<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/3/'.$list_bx.'/0');?>">号码</a> <span class="<?php if($list_bx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
						<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/3/0/'.$list_cx);?>">时间</a> <span class="<?php if($list_cx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
						<?php }?>
						<li id="type-a">								
							<a href="javascript:;" onclick="lie_type('num-list','num-list-row')"><span class="icon-th-large text-big"></span></a>
						</li>
						<li id="type-b">
							<a href="javascript:;" onclick="lie_type('num-list-row','num-list')"><span class="icon-th-list text-big"></span></a>
						</li>
						<li style="width:0;"></li>
					</div>
					<ul class="tab-nav haoma-tab-nav">
						<li<?php if($list_x==1 && $list_ax<>3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/0');?>">所有号码 <span class="badge bg-main hidden-l hidden-s"><?php echo $haoma_list_a;?></span></a> </li>
						<li<?php if($list_ax==3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/0/3');?>">议价号码 <span class="badge bg-dot hidden-l hidden-s"><?php echo $haoma_list_c;?></span></a> </li>
						<li<?php if($list_y==1 && $list_ax<>3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/1');?>">推荐号码 <span class="badge bg-dot hidden-l hidden-s"><?php echo $haoma_list_b;?></span></a> </li>
					</ul>
				</div>

				<div class="responsive bg-white xh-num-list padding-top">
					<div class="num-list" class="line">
						<?php if($haoma_list){
						foreach($haoma_list as $v){?>
						<li class="<?php if($v['hao_lock']>0){echo 'dg';}?>">
							<div class="p-num"><span class="s0"><?php echo substr($v['hao_title'],0,3);?></span><span class="s1"><?php echo substr($v['hao_title'],3,4);?></span><span class="s2"><?php echo substr($v['hao_title'],7,4);?></span></div>
								<div class="lanmu"><?php echo $hao_citys;?><?php $hty=explode("|",$this->config->item('hao_types'));echo $hty[$v['hao_type']];?></div>
							<div class="p-infor"><span><em class="val"><?php echo $v['hao_shoujia'];?></em> (含话费:<?php echo $v['hao_huafei'];?>元)</span></div>
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
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>