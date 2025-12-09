<br />
<div class="layout padding-big-top padding-big-bottom border-top bg">
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
<div class="layout bg-black bg-inverse hidden-s hidden-l">
	<div class="container">
		<div class="navbar">
			<div class="navbar-head">
				<a href="<?php echo site_url('city/'.$citys['cid']);?>" target="_blank"><span class="icon-bookmark"></span></a>
			</div>
			<div class="navbar-body nav-navicon" id="navbar-footer">
				<div class="navbar-text navbar-left">版权所有 &copy; <a href="<?php echo site_url('city/'.$citys['cid']);?>" target="_blank"><?php echo $citys['ctitle'];?></a> All Rights Reserved，ICP备：<?php echo $citys['cbeian'];?></div>
				<ul class="nav nav-inline navbar-right">
					<li><a href="<?php echo site_url('page/wes/'.$citys['cid']);?>">联系我们</a></li>
					<li><a href="<?php echo site_url('page/pays/'.$citys['cid']);?>">支付方式</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>