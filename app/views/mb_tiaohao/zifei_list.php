<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $title;?>,<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
	<div class="line-middle">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst bg-foxc alldbg">
				<div class="tab-head padding-top">
				<button class="button icon-navicon" data-target="#navbarlist"></button>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($hao_type==0){echo 'class="active"';}?>><a href="<?php echo site_url('zifei/yidong/'.$citys['cid']);?>">移动资费</a> </li>
						<li <?php if($hao_type==1){echo 'class="active"';}?>><a href="<?php echo site_url('zifei/liantong/'.$citys['cid']);?>">联通资费</a> </li>
						<li <?php if($hao_type==2){echo 'class="active"';}?>><a href="<?php echo site_url('zifei/dianxin/'.$citys['cid']);?>">电信资费</a> </li>
						<li><a href="<?php echo site_url('taocan/yidong/'.$citys['cid']);?>">套餐中心</a> </li>
					</ul>
				</div>
				<div class="border bg-white">
					<div class="padding">
					<?php foreach(explode("|",$this->config->item('pinpais')) as $k => $v){?>
					<label class="padding-right"><input type="checkbox" name="tcok" value="<?php echo $k;?>"> <?php echo $v;?></label>
					<?php }?>
					<button class="button bg-dot button-little"  onclick="goZifei();">套餐匹配</button>
					</div>
					<div class="padding">
					<?php if(isset($pinpai_list)&&!empty($pinpai_list)){
					foreach($pinpai_list as $v){?>
					<a class="padding-right" href="<?php echo site_url($pinurl.'/'.$citys['cid'].'/0/0/0/0/'.$v['pin_num']);?>"><?php echo $v['pin_title'];?></a>
					<?php }}?>
					</div>
				</div>
				<SCRIPT type=text/javascript>
				<?php if(isset($tcs)){?>
				$(document).ready(function(){
					var str = "<?php echo $tcs;?>";
					$(str.split("_")).each(function (i,dom){
						$(":checkbox[value='"+dom+"']").prop("checked",true);
						$(":checkbox[id='"+dom+"']").prop("checked",true);
					});
				}); 
				<?php }?>
					function goZifei(){
						var tc='tc';
						$("input[name='tcok']:checked").each(function () {
							tc += '_' + this.value;
						});
						location.href="<?php echo site_url($sdao_url);?>/"+sitecityid+"/"+tc;
					} 
				</script>
				<div class="bg-white">
					<div class="view-body padding-top">
						<div class="table-responsive">
						<br />
							<table class="table table-hover">
								<tbody><tr>
									<th>标题</th>
									<th>运营商</th>
									<th>品牌</th>
									<th>浏览次数</th>
									<th>更新日期</th>
									<th>立即办理</th>
								</tr>
								<?php if(isset($zifei_list)){
								foreach($zifei_list as $v){?>
								<tr>
									<td class="line40"><a target="_blank" href="<?php echo site_url('zifei/show/'.$v['id']);?>"><?php echo $v['zf_title'];?></a></td>
									<td class="line40"><?php echo $hao_types;?></td>
									<td class="line40"><?php echo $v['zf_pinpais'];?></td>
									<td class="line40"><?php echo $v['zf_llcs'];?></td>
									<td class="line40"><?php echo date('Y-m-d',$v['zf_time']);?></td>
									<td class="line40"><a href="<?php echo site_url('haoma/'.$hao_url.'/'.$citys['cid'].'/0/0/0/0/'.$v['zf_pinpai']);?>">立即办理</a></td>
								</tr>
								<?php }}?>
							</tbody></table>
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
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>