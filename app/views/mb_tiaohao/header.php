<!--[if lt IE 8]> 
<div class="alert alert-red padding-top padding-bottom text-center">
		<span class="close rotate-hover"></span><strong>注意：</strong>您的浏览器版本太低，请升级浏览器以达到更好的浏览效果。</div>
 <![endif]-->
 <div class="layout bg topbox">
	<div class="container toper">
		<div class="line-middle">
			<div class="text-right">
				<span class="hidden-l"><img class="ring-hover" src="<?php echo $viewmulu.'/public/images/gouwuche.gif';?>"> <a href="<?php if($this->session->userdata('userid')){?><?php echo site_url('member/gouwuche/'.$citys['cid']);?><?php }else{?><?php echo site_url('cart/flist/'.$citys['cid']);?><?php }?>" class="red">购物车</a> &nbsp;|&nbsp; <a href="<?php echo site_url('page/bangzhu/'.$citys['cid']);?>" class="blue">购号帮助</a> &nbsp;|&nbsp; <a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="blue">会员中心</a></span>
				<?php if($this->session->userdata('userid')){ ?>
				&nbsp;|&nbsp;<a href="<?php echo site_url('member/index/'.$citys['cid']);?>" class="blue">管理中心</a> &nbsp;|&nbsp; <a href="<?php echo site_url('user/logout/'.$citys['cid']);?>" class="red">退出</a>
				<?php if($this->session->userdata('ugroup')>10){?>&nbsp;|&nbsp; <a href="<?php echo site_url('admin/login');?>" class="red">后台</a><?php }?>
				&nbsp;|&nbsp;<?php echo ($this->session->userdata('uname'))?$this->session->userdata('uname'):$this->session->userdata('username'); ?>
				<?php }else{?>				
				&nbsp;|&nbsp; <a href="<?php echo site_url('user/login/'.$citys['cid']);?>" class="red">登录</a> &nbsp;|&nbsp; <a href="<?php echo site_url('user/register/'.$citys['cid']);?>" class="blue">注册</a>
				<?php }?>&nbsp;&nbsp;
			</div>
		</div>
	</div>
</div>
<div class="layout mb-tiaohao-container-head">
	<div class="container">
			<div class="line-middle mb-tiaohao-head">
				<div class="xb8">
					<div class="line-middle">
						<div class="xl12 xs5 xm4 xb6">
							<a href="<?php echo site_url('tourl/gourl/'.$citys['cid']);?>"><img class="logobox float-left" src="<?php echo base_url($citys['clogo']);?>"></a>
							<button class="button icon-navicon float-right mgtop20" data-target="#header">
							</button>
							<span class="hidden-s hidden-m hidden-b show-l text-red text-small padding-top"><?php echo $citys['cname'];?>站</span>
							<div class="nav nav-menu float-left mgtop20 padding-large-left button-group-little hidden-l">
								<h2><?php echo $citys['cname'];?></h2>
								<li id="citybox-button"><a class="button dropdown-toggle dropdown-hover mb-tiaohao-border mb-tiaohao-border-xuan">
									城市切换 <span class="downward"></span>
								</a>
								<ul id="citybox-box" class="drop-menu citybox">
									<div class="mb-tiaohao-city-header">
										<div class="city-breadcrumb"><span class="highlight">选城市</span> &gt; 定位置 &gt; 挑号码</div>
										<h3>请选择你所在的城市</h3>
									</div>
									<dl class="dl-inline clearfix">
										<dt>猜您在:</dt>
										<dd>
										<button type="button" class="button bg-red"><?php echo $citys['cname'];?></button>
										</dd>
									</dl>
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
								</li>
							</div>
							
						</div>
			<style>.seach-tab .searchBar .text{max-width: 180px;} .selectboxs{color:#000;}</style>
						<div class="xs7 xm8 xb6 hidden-l">
							<div class="tab seach-tab">
								<div class="tab-head">
									<ul class="tab-nav seach-tab-nav">
									    <li <?php if(!$this->uri->segment(4) || $this->uri->segment(4)=='all' || $this->uri->segment(2)=='show'){echo 'class="active"';}?> ><a href="#tab-all" onclick="sethao_sa('all');">所有号码</a></li>
										<?php if(isset($memu_list)){
										foreach($memu_list as $k => $v){
										if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
										<li <?php if($this->uri->segment(4)==str_replace('haoma/','',$v['url'])){echo 'class="active"';}?>><a href="#tab-<?php echo $k;?>" onclick="sethao_sa('<?php echo str_replace('haoma/','',$v['url']);?>');"><?php echo str_replace('选号','',$v['title']);?></a>
										<?php }}}?>
									</ul>
								</div>
								<div class="tab-body">
									
									<div class="tab-panel <?php if($this->uri->segment(2)=='likea'){if(!$this->uri->segment(5) || $this->uri->segment(5)=='all' || $this->uri->segment(5)=='10000' || $this->uri->segment(2)=='show'){echo 'active';}}elseif(!$this->uri->segment(4) || $this->uri->segment(4)=='all' || $this->uri->segment(2)=='show'){echo 'active';}?>" id="tab-all">
										<DIV class=searchBar>
										<DIV class=text><INPUT onKeyDown="if(event.keyCode==13) do_search('<?php echo $k;?>'); search_skip(this);" onBlur="if(this.value==''){this.value='靓号搜索，请输入搜索数字';this.style.color='#aaa'}" onFocus="if(this.value=='靓号搜索，请输入搜索数字'){this.value='';this.style.color='#666'}" value="<?php if(!$this->uri->segment(5)){echo '靓号搜索，请输入搜索数字';}else{ echo $this->uri->segment(5);}?>" name="seach-txt" id="seach-txt-<?php echo $k;?>">
										 </DIV>
							 <DIV class=selects>
						 <SELECT id="hao_sb" class="selectboxs" name="hao_sb">
							<OPTION value=0 <?php if(!$this->uri->segment(6)){echo 'selected';}?>>关键字位置</OPTION>
							<OPTION value=1 <?php if($this->uri->segment(6)=='1'){echo 'selected';}?>>┗任意位置</OPTION>
							<OPTION value=2 <?php if($this->uri->segment(6)=='2'){echo 'selected';}?>>┗开头位置</OPTION>
							<OPTION value=3 <?php if($this->uri->segment(6)=='3'){echo 'selected';}?>>┗结尾位置</OPTION>
						</SELECT> </DIV>
										<div class="btns pull-right"><a href="#" onclick="topSearch('<?php echo $k;?>');"><img src="<?php echo $viewmulu.'/public/images/sotu.png';?>" /></a></div>
									</DIV>
									</div>							
									<?php if(isset($memu_list)){
									foreach($memu_list as $k => $v){
									if(strstr(''.$citys['cz_memu'].'',''.$v['url'].'')){?>
									<div class="tab-panel <?php if($this->uri->segment(4)==str_replace('haoma/','',$v['url'])){echo 'active';}?>" id="tab-<?php echo $k;?>">
										<DIV class=searchBar>
										<DIV class=text><INPUT onKeyDown="if(event.keyCode==13) do_search('<?php echo $k;?>'); search_skip(this);" onBlur="if(this.value==''){this.value='靓号搜索，请输入搜索数字';this.style.color='#aaa'}" onFocus="if(this.value=='靓号搜索，请输入搜索数字'){this.value='';this.style.color='#666'}" value="<?php if(!$this->uri->segment(5)){echo '靓号搜索，请输入搜索数字';}else{ echo $this->uri->segment(5);}?>" name="seach-txt" id="seach-txt-<?php echo $k;?>">
										 </DIV>
							 <DIV class=selects>
						 <SELECT id="hao_sb" class="selectboxs" name="hao_sb">
							<OPTION value=0 <?php if(!$this->uri->segment(6)){echo 'selected';}?>>关键字位置</OPTION>
							<OPTION value=1 <?php if($this->uri->segment(6)=='1'){echo 'selected';}?>>┗任意位置</OPTION>
							<OPTION value=2 <?php if($this->uri->segment(6)=='2'){echo 'selected';}?>>┗开头位置</OPTION>
							<OPTION value=3 <?php if($this->uri->segment(6)=='3'){echo 'selected';}?>>┗结尾位置</OPTION>
						</SELECT> </DIV>										 
										<div class="btns pull-right"><a href="#" onclick="topSearch('<?php echo $k;?>');"><img src="<?php echo $viewmulu.'/public/images/sotu.png';?>" /></a></div>
									</DIV>
									</div>
									<?php }}}?>
								</div>
								<input type="hidden" id="hao_sa" name="hao_sa" value="<?php if($this->uri->segment(4)){echo $this->uri->segment(4);}else{echo 'all';}?>">
							</div>
							<SCRIPT type=text/javascript>
								function sethao_sa(str){
									if(str){
										$('#hao_sa').val(str);
									}else{
										$('#hao_sa').val('all');
									}
								}
								
								function topSearch(k){
									if($("#seach-txt-"+k).val()==""||isNaN($("#seach-txt-"+k).val())){
										var hao_hao='iiiii';
									}else{
										var hao_hao=$("#seach-txt-"+k).val();
									}									
									var hao_sa=$('#hao_sa').val();
									var hao_sb=0;
									if(hao_sa=='all'){
										hao_sb=$('#hao_sb option:selected').val();
									}
									location.href="<?php echo site_url("search/liket/".$citys['cid']);?>/"+hao_sa+"/"+hao_hao+"/"+hao_sb;
								}
								function do_search(k){
									if($("#seach-txt-"+k).val()==""||isNaN($("#seach-txt-"+k).val())){
										var hao_hao='iiiii';
									}else{
										var hao_hao=$("#seach-txt-"+k).val();
									}									
									var hao_sa=$('#hao_sa').val();
									var hao_sb=0;
									if(hao_sa=='all'){
										hao_sb=$('#hao_sb option:selected').val();
									}
									location.href="<?php echo site_url("search/liket/".$citys['cid']);?>/"+hao_sa+"/"+hao_hao+"/"+hao_sb;
								}
								</SCRIPT> 
						</div>
					</div>
					<div class="margin-top bg-inverse noradius nav-navicon " id="header">
						<div class="container clearfix">
							<div class="line-middle">
								<div class="xs4 xm3 xb3 hidden-l">
									<div class="fi"><a href="/"><font color="#fff">全部栏目导航</font></a></div>
								</div>
								<div class="xl12 xs8 xm9 xb9">
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
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="xb4 text-right hidden-s hidden-m hidden-l">
					<img class="telbox fadein-right" src="<?php echo base_url($citys['ctelpic']);?>">
				</div>
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
