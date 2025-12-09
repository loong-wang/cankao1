<!--[if lt IE 8]> 
<div class="alert alert-red padding-top padding-bottom text-center">
		<span class="close rotate-hover"></span><strong>注意：</strong>您的浏览器版本太低，请升级浏览器以达到更好的浏览效果。</div>
 <![endif]-->
 <div class="layout bg topbox">
	<div class="container toper">
		<div class="line-middle">
			<div class="xs6 xm6">				
				<?php if($this->session->userdata('userid')){ ?>
				<span class="text-gray"><?php echo $citys['ctitle'];?>，欢迎您：<?php echo ($this->session->userdata('uname'))?$this->session->userdata('uname'):$this->session->userdata('username'); ?></span>！<a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="blue">管理中心</a> &nbsp;|&nbsp; <a href="<?php echo site_url('user/logout/'.$citys['cid']);?>" class="red">退出</a>
				<?php if($this->session->userdata('ugroup')>10){?>&nbsp;|&nbsp; <a href="<?php echo site_url('admin/login');?>" class="red">后台</a><?php }?>
				<?php }else{?>
				你好，欢迎来到<?php echo $citys['ctitle'];?>！
				&nbsp;&nbsp; <a href="<?php echo site_url('user/login/'.$citys['cid']);?>" class="red">请登录</a> &nbsp;&nbsp; <a href="<?php echo site_url('user/register/'.$citys['cid']);?>" class="blue">免费注册</a>
				<?php }?>
			</div>
			<div class="xs6 xm6 text-right hidden-l">
				<img class="ring-hover" src="<?php echo $viewmulu.'/public/images/gouwuche.gif';?>"> <a href="<?php if($this->session->userdata('userid')){?><?php echo site_url('member/gouwuche/'.$citys['cid']);?><?php }else{?><?php echo site_url('cart/flist/'.$citys['cid']);?><?php }?>" class="red">购物车</a> &nbsp;|&nbsp; <a href="<?php echo site_url('page/bangzhu/'.$citys['cid']);?>" class="blue">购号帮助</a> &nbsp;|&nbsp; <a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="blue">会员中心</a>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="padding-big-bottom hidden-l"></div>
		<div class="line-middle">
			<div class="xl12 xs5 xm4 xb3">
				<a href="<?php echo site_url('tourl/gourl/'.$citys['cid']);?>"><img class="logobox float-left" src="<?php echo base_url($citys['clogo']);?>"></a>
				<button class="button icon-navicon float-right mgtop20 mgright20" data-target="#header">
				</button>
				<span class="hidden-s hidden-m hidden-b show-l text-red text-small padding-top"><?php echo $citys['cname'];?>站</span>
				<div class="button-group float-left mgtop20 padding-left button-group-little hidden-l">
					<button type="button" class="button bg-red dropdown-toggle">
						<?php echo $citys['cname'];?> <span class="downward"></span>
					</button>
					<ul class="drop-menu citybox border-yellow fadein">
						<?php if($cityt){
						foreach($cityt as $k => $v){?>
						<dl class="dl-inline clearfix">
							<dt><?php echo $k;?>:</dt>
							<dd>
							<?php foreach($v as $s => $t){?>
								<a href="<?php echo site_url('tourl/gourl/'.$t['cid']);?>"><?php echo $t['shi'];?></a>
							<?php }?>
							</dd>
						</dl>
						<?php }}?>
					</ul>
				</div>
				
			</div>
			<div class="xs7 xm8 xb6 hidden-l">
				<div class="head-seach">
					   <DIV class=searchBar>
						<DIV class=select>
						<SELECT id="hao_sa" class="selectbox" name="hao_sa">
							<OPTION value="all" selected>全部号段</OPTION>
							<?php if(isset($memu_list)){
							foreach($memu_list as $k => $v){
							if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
							<OPTION value="<?php echo str_replace('haoma/','',$v['url']);?>"><?php echo $v['title'];?></OPTION>
							<?php }}}?>
						</SELECT> </DIV>
						<DIV class=text><INPUT onKeyDown="search_skip(this); if(event.keyCode==13) do_search();" onBlur="if(this.value==''){this.value='请在这里输入您的目标数字';this.style.color='#aaa'}" onFocus="if(this.value=='请在这里输入您的目标数字'){this.value='';this.style.color='#666'}" value="<?php echo "请在这里输入您的目标数字";?>" name="seach-txt" id="seach-txt">
						 </DIV>
						 <DIV class=selects>
						 <SELECT id="hao_sb" class="selectboxs" name="hao_sb">
							<OPTION value=0 selected>关键字位置</OPTION>
							<OPTION value=1 >┗任意位置</OPTION>
							<OPTION value=2 >┗开头位置</OPTION>
							<OPTION value=3 >┗结尾位置</OPTION>
						</SELECT> </DIV>
						<div class="btns"><a href="#" onclick="topSearch();"><img src="<?php echo $viewmulu.'/public/images/sotu.png';?>" /></a></div>
					</DIV>
						<div class="keyword">热门搜索：
						<?php if(isset($citys['cz_search'])){
						foreach(explode('|',$citys['cz_search']) as $v){?>
						<a href="<?php echo site_url("search/liked/".$citys['cid']."/".$v);?>"><?php echo $v;?></a>
						<?php }}?>
						</div>
				</div>
				<SCRIPT type=text/javascript>
					function topSearch(){
						if($("#seach-txt").val()==""||isNaN($("#seach-txt").val())){
							layer.msg('请填写号码!并且只能是数字', {offset: '100px',icon: 0,shade: [0.8, '#393D49'],time: 3000,shift:1}); 
							$("#seach-txt").focus();
							return;
						}
						var hao_sa=$('#hao_sa option:selected').val();;
						var hao_sb=$('#hao_sb option:selected').val();;
						location.href="<?php echo site_url("search/liket/".$citys['cid']);?>/"+hao_sa+"/"+$("#seach-txt").val()+"/"+hao_sb;
					}
					</SCRIPT> 
			</div>
			<div class="xb3 hidden-s hidden-m hidden-l">
				<img class="telbox fadein-right" src="<?php echo base_url($citys['ctelpic']);?>">
			</div>
		</div>
	<div class="padding-big-bottom hidden-l"></div>
</div>
<div class="bg-inverse noradius nav-navicon navbarbox " id="header">
	<div class="container clearfix">
		<ul class="nav nav-inline nav-menu nav-pills nav-big">
			<li class="nav-more flash hidden-s hidden-m hidden-b"><a href="#"><?php echo $citys['cname'];?>站<span class="arrow"></span></a>
				<ul class="drop-menu citybox border-white radius-none">
					<?php if($cityt){
					foreach($cityt as $k => $v){?>
					<li><strong class="text-red"><?php echo $k;?>:</strong>
					<?php foreach($v as $s => $t){?>
						<a href="<?php echo site_url('tourl/gourl/'.$t['cid']);?>"><?php echo $t['shi'];?>站</a>
					<?php }?>
					</li>
					<?php }}?>
				</ul>
			</li>
			<li <?php if($act=='shouye'){echo 'class="active"';}?>><a href="<?php echo $shouye_url;?>">网站首页</a> </li>
			<?php if(isset($memu_list)){
			foreach($memu_list as $k => $v){
			if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
			<li <?php if($act==$v['url']){echo 'class="active"';}?>><a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>"><?php echo $v['title'];?></a> </li>
			<?php }}}?>
		</ul>
		<div class="navbar-text navbar-right hidden-s">
            <a href="<?php echo site_url('page/hezuo/'.$citys['cid']);?>" class="text-white button border-yellow bg-yellow ring-hover"><span class="icon-foursquare text-large text-white"></span> 业务合作</a>
        </div>
	</div>
</div>
<div class="top-category hidden-s hidden-m hidden-b show-l" id="mobile_nav">
	<ul>
		<li <?php if($act=='shouye'){echo 'class="active"';}?>><a href="<?php echo $shouye_url;?>">网站首页</a> </li>
		<?php if(isset($memu_list)){
		foreach($memu_list as $k => $v){
		if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
		<li <?php if($act==$v['url']){echo 'class="active"';}?>><a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>"><?php echo $v['title'];?></a></li>
		<?php }}}?>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		if ($('.top-category').length)
		{
			var length = 0;

			$.each($('.top-category li'), function (i, e)
			{
				length += $(this).innerWidth();
			});
			$('.top-category ul').css('width', length + 10);
			var myScroll = new IScroll('.top-category', {snap: 'li', eventPassthrough: true, scrollX: true, scrollY: false, preventDefaultException: { tagName: /^(INPUT|TEXTAREA|BUTTON|SELECT)$/, className: /(^|\s)btn(\s|$)/ } });
			//myScroll.scrollToElement("li:nth-child(4)", "5s");
			
			myScroll.destroy(); myScroll = null;
		}
	});
</script>
