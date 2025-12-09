<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $title;?>,<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
<script type='text/javascript' src="<?php echo $viewmulu.'/public/js/laypage.js';?>"></script>
</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
	<ul class="bread breads">
		<li><span class="icon-home"></span> <span class="hidden-l">您的当前位置：</span><a href="<?php echo $shouye_url;?>"><?php echo $citys['cname'];?>首页</a> </li>
		<li><?php echo $stitle;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst bg-foxc alldbg">
				<div class="tab-head padding-top">
					<button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li class="active"><a href="<?php echo site_url('servers/jxlist/'.$citys['cid']);?>">吉凶列表</a> </li>
						<li><a id="jixiong" href="<?php echo site_url('servers/jixiong/'.$citys['cid']);?>">号码吉凶测试</a> </li>
						<li><a href="<?php echo site_url('servers/haogujia/'.$citys['cid']);?>">号码估价</a> </li>
						<li><a id="jixiong" href="<?php echo site_url('servers/haocity/'.$citys['cid']);?>">号码归属地</a> </li>
					</ul>
				</div>
				<div class="bg-white">
				<br />
					<?php if(isset($jixiong)){?>
					<div class="view-body margin-top">
						<table class="table table-striped">
							<tbody><tr>
								<th>解读释义</th>
								<th>吉凶</th>
								<th>选号</th>
								<th>选号</th>
								<th>选号</th>
							</tr>
							</tbody>
							<tbody id="jxlist"></tbody>
						</tbody></table>
						<div class="margin-top" id="jxlistpage"></div>
						<script>
						//测试数据
						var data = [
						   <?php foreach($jixiong as $v){?>
							   {'memo':'<?php echo $v['jx_memo'];?>','name':'<?php echo $v['jx_name'];?>','id':'<?php echo $v['jx_id'];?>'},
							<?php }?>
						];

						var nums = 22; //每页出现的数量
						var pages = Math.ceil(data.length/nums); //得到总页数

						var thisDate = function(curr){
							//此处只是演示，实际场景通常是返回已经当前页已经分组好的数据
							var str = '', last = curr*nums - 1;
							last = last >= data.length ? (data.length-1) : last;
							for(var i = (curr*nums - nums); i <= last; i++){
								str += '<tr>';
								str += '<td>'+ data[i]['memo'] +'</td>';
								str += '<td class="text-dot text-center">'+ data[i]['name'] +'</td>';
								str += '<td><a href="<?php echo site_url('haoma/yidong/'.$citys['cid'].'/0/0/0/0/0/0/100/100/0/100/10/10');?>/'+ data[i]['id'] +'">移动选号</a></td>';
								str += '<td><a href="<?php echo site_url('haoma/liantong/'.$citys['cid'].'/0/0/0/0/0/0/100/100/0/100/10/10');?>/'+ data[i]['id'] +'">联通选号</a></td>';
								str += '<td><a href="<?php echo site_url('haoma/dianxin/'.$citys['cid'].'/0/0/0/0/0/0/100/100/0/100/10/10');?>/'+ data[i]['id'] +'">电信选号</a></td>';
								str += '</tr>';
							}
							return str;
						};

						//调用分页
						laypage({
							cont: 'jxlistpage',
							pages: pages,
							jump: function(obj){
								document.getElementById('jxlist').innerHTML = thisDate(obj.curr);
								
							}
						})
						</script>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>