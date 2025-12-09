<div class="search-result-wrap">
	<div class="result-title"><strong>抱歉，没有找到与您所搜匹配的号码<br>原因可能是：</strong></div>
	<p>1. 限制条件过多，<em class="all-clear">请重新搜索或通过栏目导航挑选</em></p>
	<p>2.号码订制请点击：<a href="<?php echo site_url('dingzhi/haoma/'.$citys['cid']);?>" class="pull-right button button-small bg-main">订制号码</a></p>
	<p>3.如需帮助，请联系我们<q><em><?php echo $citys['cz_tel'];?></em></q></p>
	<?php if($citys['cwxpic']){?>
	<p>4.也可扫描我们的微信公众号与我们联系<br /><img src="<?php echo $citys['cwxpic'];?>"></p>
	<?php }?>
</div>