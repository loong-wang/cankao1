<div class="layout margin-top padding bg hidden-l">
	<div class="container padding">
		<div class="slogan">
			<ul class="wrap">
				<li class="duo-icon"><strong>百万号码 谁与争锋</strong></li>
				<li class="hao-icon"><strong>每日精选 天天特价</strong></li>
				<li class="bian-icon"><strong>实体店面 信誉保证</strong></li>
				<li class="sheng-icon"><strong>十年积淀 诚信为本</strong></li>
			</ul>
		</div>
	</div>
</div>
<div class="layout margin-top margin-bottom bg-white">
	<div class="container padding">
		<div class="line">
			<div class="hidden-l xs9 table-responsive">
				<ul class="nav nav-sitemap">
					<li><a href=""><span class="icon-asterisk"></span> 选号大厅</a>
						<ul>
							<li><a href="<?php echo site_url('haoma/yidong/'.$citys['cid']);?>">移动选号</a></li>
							<li><a href="<?php echo site_url('haoma/liantong/'.$citys['cid']);?>">联通选号</a></li>
							<li><a href="<?php echo site_url('haoma/dianxin/'.$citys['cid']);?>">电信选号</a></li>
						</ul>
					</li>
					<li class="border-left border-dotted padding-left"><a href="<?php echo site_url('page/bangzhu/'.$citys['cid']);?>"><span class="icon-key"></span> 购号帮助</a>
						<ul>
						<?php if(isset($page_bangzhu)){
						foreach($page_bangzhu as $v){?>
							<li><a href="<?php echo site_url('page/bangzhu/'.$citys['cid']);?>"><?php echo $v['pages_title'];?></a></li>
						<?php }}?>
						</ul>
					</li>
					<li class="border-left border-dotted padding-left"><a href="<?php echo site_url('page/wenti/'.$citys['cid']);?>"><span class="icon-fire"></span> 常见问题</a>
						<ul>
						<?php if(isset($page_wenti)){
						foreach($page_wenti as $v){?>
							<li><a href="<?php echo site_url('page/wenti/'.$citys['cid']);?>"><?php echo $v['pages_title'];?></a></li>
						<?php }}?>
						</ul>
					</li>
					<li class="border-left border-dotted padding-left"><a href="<?php echo site_url('page/songhuo/'.$citys['cid']);?>"><span class="icon-clock-o"></span> 发货配送</a>
						<ul>
						<?php if(isset($page_songhuo)){
						foreach($page_songhuo as $v){?>
							<li><a href="<?php echo site_url('page/songhuo/'.$citys['cid']);?>"><?php echo $v['pages_title'];?></a></li>
						<?php }}?>
						</ul>
					</li>
					<li class="padding-left">
					</li>
				</ul>
			</div>
			<div class="xl12 xs3 padding-top">
			    <div style=" float: left;text-align: center;"><img src="http://www.xuanhao.net/uploads/wechat.jpg" width="100px" height="100px" style="/* float: left; *//* margin-right: 20%; *//* margin-top: 20px; *//* text-align: center; *//* margin: auto 0; */"><div style="    /* font-size: 12px; */">微信扫一扫<br>号码帮你找</div></div>
				<div class="media media-x">
					<div class="float-left txt-border radius-circle border-yellow">
						<div class="txt radius-circle bg-yellow icon-phone text-large"></div>
					</div>
					<div class="media-body"><strong class="text-big text-main"><?php echo $citys['cz_tel'];?></strong>7*24小时客服电话</div>
				</div>
				<div class="media media-x">
					<div class="float-left txt-border radius-circle border-yellow">
						<div class="txt radius-circle bg-yellow icon-envelope-o text-large"></div>
					</div>
					<div class="media-body"><strong class="text-big text-main"><?php echo $citys['cz_email'];?></strong>客服邮箱</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-layout hidden-s hidden-l">
    <div class="padding-top">
        <div class="text-center">
            <ul class="nav nav-inline mbgcolor1 bg-inverse padding-big">
                <li <?php if($act=='shouye'){echo 'class="active"';}?>><a href="<?php echo $shouye_url;?>">网站首页</a> </li>
				<?php if(isset($memu_list)){
				foreach($memu_list as $k => $v){
				if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
				<li <?php if($act==$v['url']){echo 'class="active"';}?>><a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>"><?php echo $v['title'];?></a> </li>
				<?php }}}?>
				<li><a href="<?php echo site_url('page/hezuo/'.$citys['cid']);?>">业务合作</a></li>
				<li><a href="<?php echo site_url('page/wes/'.$citys['cid']);?>">联系我们</a></li>
				<li><a href="<?php echo site_url('page/pays/'.$citys['cid']);?>">支付方式</a></li>
            </ul>
        </div>
        <div class="text-center height-big padding mbgcolor2 bg-inverse">
			<p class="text-small"><?php echo $citys['ctitle'];?>[<?php echo $citys['cdress'];?>]&nbsp;&nbsp;7*24小时客服电话：<?php echo $citys['cz_tel'];?>&nbsp;&nbsp;<a href="https://beian.miit.gov.cn/">ICP备：<?php echo $citys['cbeian'];?></a>
			<br>版权所有 © <?php echo date('Y',time());?>-<?php echo date('Y',time())+6;?>&nbsp;&nbsp;<a href="<?php echo site_url('city/'.$citys['cid']);?>" target="_blank"><?php echo $citys['cdomain'];?></a> All Rights Reserved.
			<script charset="UTF-8" id="LA_COLLECT" src="//sdk.51.la/js-sdk-pro.min.js"></script>
<script>LA.init({id: "1wbU9xGFGtRxUUpr",ck: "1wbU9xGFGtRxUUpr"})</script>
			</p>
			<p class="padding"><img src="<?php echo base_url('public/img/anquan_01_03.gif');?>">
			<img src="<?php echo base_url('public/img/anquan_01_05.gif');?>">
			<img src="<?php echo base_url('public/img/bt110.gif');?>">
			<img src="<?php echo base_url('public/img/zhifubao.jpg');?>"></p>
		</div>
    </div>
</div>