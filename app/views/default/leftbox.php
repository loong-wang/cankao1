<div class="bg-foxb border border-fox radius">
	<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted">
		<span class="icon-globe"></span> 本站导航</h3>
	<div class="leftbox">
		<div class="title"><img class="ring-hover" src="<?php echo base_url('app/views/default/public/images/yd.gif');?>"><?php echo $citys['cname'];?>移动</div>
		<div class="leftboxin border-bottom list-inline">
			<li><a href="<?php echo site_url('zifei/yidong/'.$citys['cid']);?>">移动资费</a></li>
			<li><a href="<?php echo site_url('haoma/yidong/'.$citys['cid']);?>">移动选号</a></li>
			<li><a href="<?php echo site_url('kefu/yidong/'.$citys['cid']);?>">移动客服中心</a></li>
			<li><a href="<?php echo site_url('news/yidong/'.$citys['cid']);?>">移动资讯</a></li>
		</div>
		<div class="title"><img class="ring-hover" src="<?php echo base_url('app/views/default/public/images/lt.gif');?>"><?php echo $citys['cname'];?>联通</div>
		<div class="leftboxin border-bottom list-inline">
			<li><a href="<?php echo site_url('zifei/liantong/'.$citys['cid']);?>">联通资费</a></li>
			<li><a href="<?php echo site_url('haoma/liantong/'.$citys['cid']);?>">联通选号</a></li>
			<li><a href="<?php echo site_url('kefu/liantong/'.$citys['cid']);?>">联通客服中心</a></li>
			<li><a href="<?php echo site_url('news/liantong/'.$citys['cid']);?>">联通资讯</a></li>
		</div>
		<div class="title"><img class="ring-hover" src="<?php echo base_url('app/views/default/public/images/dx.gif');?>"><?php echo $citys['cname'];?>电信</div>
		<div class="leftboxin border-bottom list-inline">
			<li><a href="<?php echo site_url('zifei/dianxin/'.$citys['cid']);?>">电信资费</a></li>
			<li><a href="<?php echo site_url('haoma/dianxin/'.$citys['cid']);?>">电信选号</a></li>
			<li><a href="<?php echo site_url('kefu/dianxin/'.$citys['cid']);?>">电信客服中心</a></li>
			<li><a href="<?php echo site_url('news/dianxin/'.$citys['cid']);?>">电信资讯</a></li>
		</div>
		<div class="title"><img class="ring-hover" src="<?php echo base_url('app/views/default/public/images/hh.gif');?>">网站服务</div>
		<div class="leftboxin list-inline">
			<li><a href="<?php echo site_url('servers/jixiong/'.$citys['cid']);?>">号码吉凶测试</a></li>
			<li><a href="<?php echo site_url('servers/haocity/'.$citys['cid']);?>">号码归属地</a></li>
			<li><a href="<?php echo site_url('servers/haogujia/'.$citys['cid']);?>">号码估价</a></li>
			<li><a href="<?php echo site_url('xinxi/flist/'.$citys['cid']);?>">二手号交易</a></li>
			<li><a href="<?php echo site_url('news/hangye/'.$citys['cid']);?>">行业新闻</a></li>
			<li><a href="<?php echo site_url('news/youhui/'.$citys['cid']);?>">优惠政策</a></li>
		</div>
	</div>
</div>

<?php if($question_list_show){?>
<div class="margin-top bg-foxb border border-fox radius padding-bottom" id="saybox">
		<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted">
		<span class="icon-question-circle"></span> 客服咨询</h3>
	<div class="padding-top" style="height:250px;overflow:hidden" id="quotation">
		<ul>
		<?php foreach($question_list_show as $v){?>
		<dl class="clearfix">
			<dt><a class="" target="_blank" href="<?php echo site_url('kefu/show/'.$v['id']);?>"><?php echo $v['q_title'];?></a></dt>
			<dd><div class="qbox margin-top text-little height-little">
				<span class="arrow"></span><?php echo cleanhtml(html_entity_decode(br2nl($v['q_content'])));?>
				</div>
			</dd>
		</dl>
		<?php }?>
		</ul>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var scrtime;
	$("#quotation").hover(function(){
		clearInterval(scrtime);
	
	},function(){
	
	scrtime = setInterval(function(){
		var obj = $('#quotation ul dl').last();
		obj.hide();
		$('#quotation ul').prepend(obj);
		$('#quotation ul dl').first().slideDown(500);
	},5000);
	
	}).trigger("mouseleave");
	
var fixfox="fixedffs";
var rollSet = $('#saybox');// 检查对象，#sidebar-tab是要随滚动条固定的ID，可根据需要更改
var offset = rollSet.offset();
$(window).scroll(function () {
// 检查对象的顶部是否在游览器可见的范围内
var scrollTop = $(window).scrollTop();
if(offset.top < scrollTop && $(document).scrollTop() + $(window).height() < $(document).height()){
rollSet.addClass(fixfox);
}else{
rollSet.removeClass(fixfox);
}
});
});
</script>
<?php }?>
