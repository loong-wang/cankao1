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
			<div class="hidden-l hidden-s sebox">
			<?php $this->load->view('inc_ssearchboxs');?>
			</div>
			<div class="line hidden-b hidden-m hidden-s show-l">
				<div class="show-l">
					<?php $this->load->view('inc_sjsearchbox');?>
				</div>
			</div>
			<div class="panel margin-top padding border border-mix clearfix radius-none">
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
					<dt>号段：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>" class="<?php if($title_hao_types==0){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($set_hao_types)){
					foreach($set_hao_types as $k => $v){?>
						<a class="<?php if($title_hao_types==$v){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$v.'/'.$hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
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
					<dt>合约：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);?>" class="<?php if($hao_heyus==10){echo 'active';}?>">不限</a>
					</dt>
					<dd><?php if(isset($set_hao_heyus)){
					foreach($set_hao_heyus as $k => $v){?>
						<a class="<?php if($hao_heyus==$k){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/'.$k.'/'.$hao_jixiong);?>"><?php echo $v;?></a>
					<?php }}?>
					</dd>
			   </dl>
			   <dl class="dl-inline haoma-shaixuan hidden-l hidden-s">
					<dt>寓意：
					<a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/100');?>" class="<?php if($hao_jixiong==100){echo 'active';}?>">不限</a>
					</dt>
					<dd class="auto"><?php if(isset($jixiong)){
					$k=0;
					foreach($jixiong as $a){
					$arr=explode('，',$a['jx_memo']);
					if(strstr($a['jx_name'], "吉")){
					$k=$k+1;
					if($k<17){
					//if($k==10){echo '<br />';}?>
						<a class="<?php if($hao_jixiong==$a['jx_id']){echo 'active';}?>" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$hao_jiage.'/100/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$a['jx_id']);?>"><?php echo $arr[0];?></a>
					<?php }}}}?><span class="pull-right text-gray text-little">仅供娱乐 (<a href="<?php echo site_url('servers/jxlist/'.$citys['cid']);?>">吉凶列表</a>)</span>
					</dd>
			   </dl>
			</div>
			<div class="haoma-yixuan margin-top margin-bottom-top padding border text-small hidden-l hidden-s">
			您选择了:<?php echo $yixuan;?>
			<span class="pull-right"><a href="<?php echo site_url($hao_url.'/'.$citys['cid']);?>">删除所有条件</a></span>
			</div>
			<div class="margin-top tabst bg-foxc alldbg">
				<div class="tab-head padding-top">
					<a href="<?php echo site_url('dingzhi/haoma/'.$citys['cid']);?>" class="pull-right button button-small bg-main hidden-l hidden-s">订制号码</a>
					<ul class="tab-nav">
						<li<?php if($list_x==1 && $list_ax<>3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/0');?>">所有号码 <span class="badge bg-main hidden-l hidden-s"><?php echo $haoma_list_a;?></span></a> </li>
						<li<?php if($list_ax==3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/0/3');?>">议价号码 <span class="badge bg-dot hidden-l hidden-s"><?php echo $haoma_list_c;?></span></a> </li>
						<li<?php if($list_y==1 && $list_ax<>3){echo ' class="margin-right active"';}?>><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/1');?>">推荐号码 <span class="badge bg-dot hidden-l hidden-s"><?php echo $haoma_list_b;?></span></a> </li>
					</ul>
				</div>

				<div class="responsive bg-white">
					<div class="line clearfix">
						<div class="bread hidden-l hidden-m" style="padding:5px 0 5px 0;border-bottom:1px dotted #ccc;margin-bottom:5px;">
							<li>排序方式</li>
							<?php if($list_ax<>3){?>
							<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_ax.'/0/0');?>">价格</a> <span class="<?php if($list_ax==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
							<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/0/'.$list_bx.'/0');?>">号码</a> <span class="<?php if($list_bx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
							<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/0/0/'.$list_cx);?>">时间</a> <span class="<?php if($list_cx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
							<?php }else{?>
							<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/3/'.$list_bx.'/0');?>">号码</a> <span class="<?php if($list_bx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
							<li><a href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/3/0/'.$list_cx);?>">时间</a> <span class="<?php if($list_cx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></span></li>
							<?php }?>
							<li style="width:0;"></li>
						</div>
						<div class="xm6" style="padding:0;">
						<hr class="bg-back hidden-s hidden-m hidden-b show-l" />
						<table class="table">
						<tbody>
						<tr>
							<th class="xs4" style="font-weight:normal"><?php echo $hao_types;?>号码
							<a class="pull-right hidden-s hidden-m hidden-b show-l" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/0/'.$list_bx.'/0');?>"><i class="text-yellow <?php if($list_bx==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></i></a>
							</th>
							<th class="xs2" style="font-weight:normal">卡费
							<?php if($list_ax<>3){?>
							<a class="pull-right hidden-s hidden-m hidden-b show-l" href="<?php echo site_url($hao_url.'/'.$citys['cid'].'/'.$list.'/'.$list_ax.'/0/0');?>"><i class="text-yellow <?php if($list_ax==2){echo 'icon-long-arrow-down';}else{echo 'icon-long-arrow-up';}?>"></i></a>
							<?php }?>
							</th>
							<th class="xs2" style="font-weight:normal">话费</th>
							<th class="xs2 hidden-l hidden-m" style="font-weight:normal">方案</th>
							<th class="xs2" style="font-weight:normal">操作</th>
						</tr>
						</tbody></table>
						</div>
						<div class="xm6 hidden-l" style="padding:0;">
						<table class="table">
						<tbody>
						<tr>
							<th class="xs4" style="font-weight:normal"><?php echo $hao_types;?>号码</th>
							<th class="xs2" style="font-weight:normal">卡费</th>
							<th class="xs2" style="font-weight:normal">话费</th>
							<th class="xs2 hidden-l hidden-m" style="font-weight:normal">方案</th>
							<th class="xs2" style="font-weight:normal">操作</th>
						</tr>
						</tbody></table>
						</div>
					</div>
					<div class="line">
						<?php if($haoma_list){
						foreach($haoma_list as $v){?>
						<div class="xm6" style="padding:0;">
						<table class="table haomaxxboxs">
						<tbody>
						<tr>
							<td class="xs4" style="padding:8px 0;"><strong><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a></strong></td>
							<td class="xs2 text-dot text-default" style="padding:8px 0;"><span class="icon-cny"></span><?php echo $v['hao_shoujia'];?></td>
							<td class="xs2 text-gray text-small" style="padding:8px 0;"><?php echo $v['hao_huafei'];?></td>
							<td class="xs2 text-sub text-small hidden-m hidden-l" style="padding:8px 0;"><span class="height-little"><?php echo fox_substr(cleanhtml($v['hao_heyue']),10);?></span></td>
							<td class="xs2"><a class="button bg-red button-littlest pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>">订购</a></td>
						</tr></tbody></table>
						</div>
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