<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $title;?>,<?php echo $citys['cdescription'];?>" />
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
	<ul class="bread breads">
		<li><span class="icon-home"></span> <span class="hidden-l">您的当前位置：</span><a href="<?php echo $shouye_url;?>"><?php echo $citys['cname'];?>首页</a> </li>
		<li class="hidden-l"><?php echo $title;?> </li>
		<li><?php echo $stitle;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">			
			<div class="hidden-l hidden-s sebox">
				<?php if($haotype==3){
					$this->load->view('inc_ssearchboxss');
				}else{
					$this->load->view('inc_searchbox');
				}
				?>
			</div>
			<div class="tabst bg-foxc alldbg">
				<div class="tab-head padding-top">
					<h5 class="margin-top margin-bottom text-red text-big"><a href="<?php echo site_url('dingzhi/haoma/'.$citys['cid']);?>" class="pull-right button button-small bg-main">订制号码</a>搜索：<?php echo str_replace('X','x',$searchnum);?> 结果</h5>
				</div>
				<div class="responsive bg-white">
					<div class="line clearfix">
						<div class="xm6" style="padding:0;">
						<table class="table">
						<tbody>
						<tr>
							<th class="xs4" style="font-weight:normal">号码</th>
							<th class="xs2" style="font-weight:normal">卡费</th>
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
							<th class="xs4" style="font-weight:normal">号码</th>
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
							<td class="xs2 text-dot text-default" style="padding:8px 0;"><span class="icon-cny"></span><?php if($v['hao_shoujia']==0 && $v['hao_huafei']==0){echo '议价';}else{echo $v['hao_shoujia'];}?></td>
							<td class="xs2 text-gray text-small" style="padding:8px 0;"><?php echo $v['hao_huafei'];?></td>
							<td class="xs2 text-sub text-small hidden-m hidden-l" style="padding:8px 0;"><span class="height-little"><?php echo fox_substr(cleanhtml($v['hao_heyue']),10);?></span></td>
							<td class="xs2"><a class="button bg-red button-littlest pull-right" target="_blank" href="<?php echo site_url('haoma/show/'.$citys['cid'].'/'.$v['id'].'/'.$v['hao_title']);?>">订购</a></td>
						</tr></tbody></table>
						</div>
						<?php }}else{echo '没有找到相关号码';}?>					
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