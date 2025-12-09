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
		<li><a href="<?php echo site_url($sdao_url);?>"><?php echo $stitle;?></a> </li>
		<li><?php echo $title;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="line-big">
				<div class="xb5">
					<div class="haomaout text-center border radius">
						<li class="haomashow"><span class="text-gray"><?php echo substr($title,0,7);?></span><span class="text-yellow"><?php echo substr($title,7,4);?></span></li>
					</div>
					<br />
					<div class="text-default height">号码状态</div>
					<br />
					<div class="step step-small text-small">
						<div class="step-bar step-small-bar bg-dot" style="width: 20%;">
							<span class="step-point step-big-point-red">待售</span>
						</div>
						<div class="step-bar step-small-bar" style="width: 20%;">
							<span class="step-point step-small-point"></span>
						</div>
						<div class="step-bar step-small-bar" style="width: 20%;">
							<span class="step-point step-small-point"></span>
						</div>
						<div class="step-bar step-small-bar" style="width: 20%;">
							<span class="step-point step-small-point"></span>
						</div>
						<div class="step-bar step-small-bar" style="width: 20%;">
							<span class="step-point step-small-point">5</span>
						</div>
					</div>
					<div class="text-gray height text-little">号码还未售出，抓紧时间下单吧，不要被别人抢先哦</div>
					<div class="padding-top text-default height">便民小贴士</div>
					<div class="text-gray height-little text-little">由于靓号的特殊性，不保证号码都在，请联系客服确认号码是否存在，或者多选购几个备用号码</div>
				</div>
				<div class="xb7 text-small">
					<dl class="dl-inline dl-inlines clearfix">
						<dt>运营商：</dt>
						<dd><?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($haoma['hao_type']==$k){echo '<span class="text-sub">'.$s.'</span>';}}?> &nbsp;</dd>
					</dl>
					<dl class="dl-inline dl-inlines clearfix">
						<dt>目前品牌：</dt>
						<dd><span class="text-sub"><?php echo $haoma['pin_title'];?></span> <?php if($haoma['pin_shuxing']==0){echo '<span class="text-gray text-little">可转品牌</span>';}?> &nbsp;</dd>
					</dl>
					<?php if(get_haoma_guilv($haoma['hao_title'])){?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt>号码规律：</dt>
						<dd><span class="text-sub"><?php echo get_haoma_guilv($haoma['hao_title']);?> &nbsp;</span></dd>
					</dl>
					<?php }?>
					<?php if($haoma['hao_heyue']){?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt>每月最低消费：</dt>
						<dd><span class="text-sub"><?php echo $haoma['hao_heyue'];?> &nbsp;</span></dd>
					</dl>
					<?php }?>
					<?php if($haoma['hao_beizhu']){?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt>号码备注：</dt>
						<dd><span class="text-sub"><?php echo $haoma['hao_beizhu'];?> &nbsp;</span></dd>
					</dl>
					<?php }?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt>号码寓意：</dt>
						<dd>
						<?php if(get_haoma_yuyi($haoma['hao_title'])>0){
							foreach($jixiong as $a){
								if($a['jx_id']==get_haoma_yuyi($haoma['hao_title'])){
								if(!strstr($a['jx_name'], "凶")){
									echo '<span class="text-sub">'.$a['jx_memo'].'</span>';
									echo '(<span class="text-red">'.$a['jx_name'].'</span>)';
									echo '<span class="text-gray text-little">仅供娱乐</span>';
								}
						}}} ?>
						</dd>
					</dl>
					<hr />
					<?php if($haoma['hao_jiage']==0 && $haoma['hao_huafei']==0){?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>号码价格</strong>：</dt>
						<dd><span class="text-sub"><strong>￥ 议价</strong></span></dd>
					</dl>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>合计</strong>：</dt>
						<dd><span class="text-red"><strong>￥ 议价</strong></span></dd>
					</dl>
					<?php }elseif($haoma['hao_jiage']==0 && $haoma['hao_huafei']>0){?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>号码价格</strong>：</dt>
						<dd><span class="text-sub"><strong>￥<?php echo $haoma['hao_shoujia'];?></strong></span> &nbsp; &nbsp;<strong>话费</strong>：<span class="text-green"><strong>￥<?php echo $haoma['hao_huafei'];?></strong></span></dd>
					</dl>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>合计</strong>：</dt>
						<dd><span class="text-red"><strong>￥<?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?></strong></span></dd>
					</dl>
					<?php }else{?>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>号码价格</strong>：</dt>
						<dd><span class="text-sub"><strong>￥<?php echo $haoma['hao_shoujia'];?></strong></span> &nbsp; &nbsp;<strong>话费</strong>：<span class="text-green"><strong>￥<?php echo $haoma['hao_huafei'];?></strong></span></dd>
					</dl>
					<dl class="dl-inline dl-inlines clearfix">
						<dt><strong>合计</strong>：</dt>
						<dd><span class="text-red"><strong>￥<?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?></strong></span></dd>
					</dl>
					<?php }?>
					<div class="margin-top">
						<a href="<?php echo site_url('cart/gou/'.$citys['cid'].'/'.$haoma['id']);?>" class="button button-big bg-red"><span class="icon-shopping-cart"></span> 立即订购</a>
						<?php if($gouwuche>0){?>
							<a href="<?php if($this->session->userdata('userid')){?><?php echo site_url('member/gouwuche/'.$citys['cid']);?><?php }else{?><?php echo site_url('cart/flist/'.$citys['cid']);?><?php }?>" class="button button-big bg-gray"><span class="icon-check-square-o"></span> 已在购物车</a>
						<?php }else{?>
							<a href="<?php if($this->session->userdata('userid')){echo site_url('member/gouwuche/'.$citys['cid'].'/'.$haoma['id']);}else{echo site_url('cart/flist/'.$citys['cid'].'/'.$haoma['id']);}?>" class="button button-big bg-yellow"><span class="icon-check-square-o"></span> 加入购物车</a>
						<?php }?>
						<?php if($shoucang==0){?>
							<a href="<?php echo site_url('member/gouwusc/'.$citys['cid'].'/'.$haoma['id']);?>" class="hidden-l button button-big bg-blue"><span class="icon-star-o"></span> 收藏</a>
						<?php }else{?>
							<a href="<?php echo site_url('member/gouwusc/'.$citys['cid']);?>" class="hidden-l button button-big bg-gray"><span class="icon-star-o"></span> 已收藏</a>
						<?php }?>
					</div>
				</div>
			</div>
			<script type="text/javascript">
			var hao_title = <?php echo $haoma['hao_title'];?>;   
			var hao_city = <?php echo $haoma['hao_city'];?>;   
			var hao_jiage = <?php echo $haoma['hao_shoujia']+$haoma['hao_huafei'];?>;
			var hao_id = <?php echo $haoma['id'];?>; 
			if(hao_title!='' && hao_jiage!='' && hao_id!=''){
				var canAdd = true; //初始可以插入cookie信息
			}
			var haoCook = $.cookie("haoCook");  
			var len = 0;    
			if(haoCook){    
				haoCook = eval("("+haoCook+")");    
				len = haoCook.length;    
			}   
			$(haoCook).each(function(){    
				if(this.title == hao_title){    
					canAdd = false;    
					return false;    
				}    
			});  
			
			if(canAdd==true){    
				var json = "[";    
				var start = 0;    
				if(len>18){start = 6;} 
				json = json + "{\"title\":\""+hao_title+"\",\"jiage\":\""+hao_jiage+"\",\"id\":\""+hao_id+"\",\"cityid\":\""+hao_city+"\"}";
				for(var i=start;i<len;i++){    
					json = json + ",{\"title\":\""+haoCook[i].title+"\",\"jiage\":\""+haoCook[i].jiage+"\",\"id\":\""+haoCook[i].id+"\",\"cityid\":\""+haoCook[i].hao_city+"\"}";    
				}    
				json = json + "]";    
				$.cookie("haoCook",json,{path: '/', expires: 365});    
			}     
		</script>
			<br />
			<div class="margin-top tab bg-foxc alldbg">
				<div class="tab-head padding-top">
					<ul class="tab-nav">
						<li class="active"><a href="#tab-start">资费介绍</a> </li>
						<li><a href="#tab-css">相似号码</a> </li>
						<li class="hidden-l"><a href="#tab-units">配送事宜</a> </li>
					</ul>
				</div>
				<div class="tab-body bg-white">
					<div class="tab-panel active" id="tab-start">
						<?php if(isset($haoma_zifei)){
						foreach($haoma_zifei as $v){?>
						<div class="detail">
						<h4><?php echo $v['zf_title'];?></h4>
						<?php echo $v['zf_content'];?>
						</div>						
						<?php }}?>
					</div>
					<div class="tab-panel" id="tab-css">
						<div class="detail line">
						<?php if(isset($haoma_loves)){
						foreach($haoma_loves as $v){?>
							<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
						<?php }}?>
						</div>						
					</div>
					<div class="tab-panel" id="tab-units">
						<?php if(isset($haoma_peisong)){
						foreach($haoma_peisong as $v){?>
						<div class="detail">
						<h4><?php echo $v['pages_title'];?></h4>
						<?php echo $v['pages_content'];?>
						</div>						
						<?php }}?>
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