<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $description;?>" />
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
			<div class="xs8">  
				<div class="view-body alldbg">
					<br />
					<h2><?php echo $title;?></h2>
					<br />
					<div class="view-body">
						<dl class="dl-inline clearfix">
							<dt style="text-align:left;"><button class="button <?php if($type==0){echo 'bg-blue';}else{echo 'bg-yellow';}?>"><?php foreach(explode("|",$this->config->item('xinxi_types')) as $k => $s){
									if($type==$k){
										echo $s;
									}
								}?></button></dt>
							<dd><span class="float-right tag"><?php echo $llcs;?>浏览</span><span class="text-large text-sub"><?php echo $title;?></span></dd>
						</dl>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tbody>
							<tr style="min-height:35px">
								<td style="border:0;text-align:right;">
									<span class="text-gray">价&nbsp;&nbsp;&nbsp;格</span></td>
								<td style="border:0;">
									<span class="text-yellow text-big"><?php if($jiage==0){echo '面议';}else{echo $jiage;}?></span>
								</td>
								<td style="border:0;text-align:right;">
									<span class="text-gray">联系人</span>
								</td>
								<td style="border:0;">
									<span class="text-sub"><?php echo $name;?></span>
								</td>
							</tr>
							<tr style="min-height:35px">
								<td style="border:0;text-align:right;">
									<span class="text-gray">Q&nbsp;&nbsp;&nbsp;&nbsp;Q</span></td>
								<td style="border:0;">
									<span class=""><?php echo $qq;?></span>
								</td>
								<td style="border:0;text-align:right;">
									<span class="text-gray">电&nbsp;&nbsp;&nbsp;话</span>
								</td>
								<td style="border:0;">
									<span class=""><?php echo $tel;?></span>
								</td>
							</tr>
							<tr style="min-height:35px">
								<td style="border:0;text-align:right;">
									<span class="text-gray">更新时间</span></td>
								<td style="border:0;">
									<span class="text-small"><?php echo $dates;?></span>
								</td>
								<td style="border:0;text-align:right;">
									<span class="text-gray">Email</span>
								</td>
								<td style="border:0;">
									<span class="text-small"><?php echo $email;?></span>
								</td>
							</tr>
						</tbody></table>
					</div>
					<br />
					<div class="view-body">
						<dl class="dl-inline clearfix">
							<dt style="text-align:left;"></dt>
							<dd><span class="text-sub">详细信息</span></dd>
						</dl>
					</div>
					<div class="xinxibox">
						<span class="arrow"></span>
						<?php echo $content?>
					</div>
				</div>
			</div>
			<div class="xs4 hidden-l"> 
				<div class="alldbgy alldbgy-border">
					<div class="view-body">
						<h3 class="padding-top padding-bottom text-gray"><a href="<?php echo site_url('xinxi/flist/'.$citys['cid']);?>" class="pull-right text-little">更多</a><span class="icon-fire"></span> 热门信息</h3>
						<ul class="list-text text-little">
						<?php if(isset($xinxi_list)){
						foreach($xinxi_list as $v){?>
							<li><span class="date"><?php echo date('m/d',$v['x_time']);?></span><a href="<?php echo site_url('xinxi/show/'.$v['id']);?>"><?php echo $v['x_title'];?></a> </li>							
						<?php }}?>
						</ul>
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