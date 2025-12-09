<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?3594232d7fa199b6f21f1b348596708a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>


</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
	<div class="line-middle">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="padding-big-bottom hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
		<div class="padding-big-bottom hidden-l"></div>
			<div class="line hidden-l">
				<div class="xl12 xs12 xm8 xb8">
					<div class="banner" data-style="border-red">
						<div class="carousel adsbox">
							<?php if(isset($city_adss)){
							foreach($city_adss as $k => $v){?>
							<div class="item"><a href="<?php echo $v['ads_url'];?>" title="<?php echo $v['ads_title'];?>"><img class="img-responsive" src="<?php echo base_url($v['ads_pic']);?>"></a></div>
							<?php }}?>
						</div>
					</div>
					<div class="hidden-l hidden-s">
					<?php $this->load->view('inc_ssearchbox');?>
					</div>
				</div>
				<div class="xm4 xb4 hidden-l hidden-s">
					<div class="list-links">
						<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted">
						<span class="icon-volume-up"></span> 站内公告</h3>
						<?php if(isset($city_ggs)){
						foreach($city_ggs as $k => $v){?>
						<a href="<?php echo site_url('page/show/'.$v['id']);?>" class="text-small"><span class="icon-clock-o float-right text-fox"><?php echo date('m/d',$v['pages_time']);?></span>
						<span class="tag <?php if($k<3){echo 'bg-yellow';}else{echo 'bg-foxc';}?>"><?php echo $k+1;?></span> <?php echo $v['pages_title'];?> </a>
						<?php }}?>
					</div>
					<div class="padding-bottom padding-top">
					<a href="<?php echo site_url('member/xinxiadd/'.$citys['cid']);?>" class="button bg-yellow">我要转让号码</a>
					<a href="<?php echo site_url('dingzhi/haoma/'.$citys['cid']);?>" class="button bg-main float-right">我要订制号码</a>
					</div>
				</div>
			</div>
			<div class="line hidden-b hidden-m hidden-s show-l">
				<div class="layout padding-big-bottom border-top border-bottom bg hidden-l hidden-b hidden-m hidden-s">
					<?php if(isset($memu_list)){
					foreach($memu_list as $k => $v){
					if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){
					if (strstr($v['url'], 'yidong') !== false) {
						$img='yd.gif';
					}elseif (strstr($v['url'], 'liantong') !== false) {
						$img='lt.gif';
					}elseif (strstr($v['url'], 'dianxin') !== false) {
						$img='dx.gif';
					}else{
						$img='hh.gif';
					}?>
					<ul class="xl3 xs3 padding-top text-center">
						<a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>">
						<img src="<?php echo $viewmulu.'/public/images/'.$img;?>" width="50" class="img-border radius-circle padding">
						</a>
						<br /><a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>"><span class="text text-main"><?php echo $v['title'];?></span></a>
					</ul>
					<?php }}}?>							
				</div>
				<div class="show-l">
					<?php $this->load->view('inc_sjsearchbox');?>
				</div>
			</div>
			<div class="view-body">
				<div class="fox-zifeibox hidden-l hidden-s">
					<div class="tabs">
						<div class="tab-head">
							<strong class="text-big foxweight400"><?php if($citys['stitle']!='直辖市'){echo str_replace('省','',$citys['stitle']);}?>手机资费导购</strong> <span class="tab-more"></span>
							<ul class="tab-nav">
								<li class="active"><a href="#tab-start"><?php echo $citys['cname'];?></a> </li>
								<?php if(isset($pingpai_gou)){
								foreach($pingpai_gou as $v){?>
								<li><a href="<?php echo site_url('tourl/gourl/'.$v['cid']);?>"><?php echo $v['cname'];?></a></li>
								<?php }}?>
							</ul>
						</div>
						<div class="tab-body">
							<div class="tab-panel active" id="tab-start">
								<?php foreach(explode("|",$this->config->item('pinpais')) as $k => $v){?>
								<label><input type="checkbox" name="tcok" value="<?php echo $k;?>"> <?php echo $v;?></label>
								<?php }?>
								<button class="button bg-dot button-little"  onclick="goZifei();">套餐匹配</button>
							</div>
							<SCRIPT type=text/javascript>
								function goZifei(){
									var tc='tc';
									$("input[name='tcok']:checked").each(function () {
										tc += '_' + this.value;
									});
									location.href="<?php echo site_url("zifei/yidong/");?>/"+sitecityid+"/"+tc;
								} 
							</script>
						</div>
					</div>
				</div>
				<div class="padding-top"></div>
				<div class="tab border-fox">
					<div class="tab-head">
						<strong class="text-big foxweight600"><span class="icon-sort"></span> 移动选号</strong> <span class="tab-more"><a href="<?php echo site_url('haoma/yidong/'.$citys['cid']);?>">更多</a></span>
						<ul class="tab-nav">
							<li class="active"><a href="#yd-start">最新号码</a> </li>
							<li class="hidden-l"><a href="#yd-tuijian">推荐号码</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="yd-start">
							<div class="line">
							<?php if(isset($haoma_yd_new)){
							foreach($haoma_yd_new as $v){?>
								<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
							</div>
						</div>
						<div class="tab-panel" id="yd-tuijian">
							<div class="line">
							<?php if(isset($haoma_yd_dig)){
							foreach($haoma_yd_dig as $v){?>
								<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
							</div>
						</div>
					</div>
				</div>
				<div class="padding-top"></div>
				<div class="tab border-fox">
					<div class="tab-head">
						<strong class="text-big foxweight600"><span class="icon-sort"></span> 联通选号</strong> <span class="tab-more"><a href="<?php echo site_url('haoma/liantong/'.$citys['cid']);?>">更多</a></span>
						<ul class="tab-nav">
							<li class="active"><a href="#lt-start">最新号码</a> </li>
							<li class="hidden-l"><a href="#lt-tuijian">推荐号码</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="lt-start">
							<div class="line">
							<?php if(isset($haoma_lt_new)){
							foreach($haoma_lt_new as $v){?>
								<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
							</div>
						</div>
						<div class="tab-panel" id="lt-tuijian">
							<div class="line">
							<?php if(isset($haoma_lt_dig)){
							foreach($haoma_lt_dig as $v){?>
								<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
							</div>
						</div>
					</div>
				</div>
				<div class="padding-top"></div>
				<div class="tab border-fox">
					<div class="tab-head">
						<strong class="text-big foxweight600"><span class="icon-sort"></span> 电信选号</strong> <span class="tab-more"><a href="<?php echo site_url('haoma/dianxin/'.$citys['cid']);?>">更多</a></span>
						<ul class="tab-nav">
							<li class="active"><a href="#dx-start">最新号码</a> </li>
							<li class="hidden-l"><a href="#dx-tuijian">推荐号码</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="dx-start">
							<div class="line">
							<?php if(isset($haoma_dx_new)){
							foreach($haoma_dx_new as $v){?>
								<div class="haomaxxbox xl12 xl6 xs4 xm3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
							</div>
						</div>
						<div class="tab-panel" id="dx-tuijian">
							<div class="line">
							<?php if(isset($haoma_dx_dig)){
							foreach($haoma_dx_dig as $v){?>
								<div class="haomaxxbox xl12 xs6 xm4 xb3"><a target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_titles'];?></a><a class="button bg-red button-littlests pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>"><span class="fa fa-shopping-cart"></span> 订购</a></div>
							<?php }}?>
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