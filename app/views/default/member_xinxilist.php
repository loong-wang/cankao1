<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
</head>
<body>
<?php $this->load->view('header');?>
    <div class="container">
		<div class="line-big padding-top">
			<div class="xm2">
				<?php $this->load->view('member_leftbar');?>
			</div>
			<div class="xm10">
			<?php $this->load->view('member_top');?>
				<div class="tabst">
					<div class="tab-head">
						<ul class="tab-nav">
							<li class="active"><a href="#tab-a"><?php echo $title;?></a> </li>
							<a href="<?php echo site_url('member/xinxiadd/'.$citys['cid']);?>" class="button bg-sub pull-right"><span class="icon-edit"></span> 继续发布</a>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<div class="table-responsive">
									<table class="table table-hover">
										<tbody><tr>
											<th>
												信息标题
											</th>
											<th>
												类型
											</th>
											<th>
												提交时间
											</th>
											<th>
												<span class="pull-right text-right">操作</span>
											</th>
										</tr>
										<?php if(isset($xinxi_list)){
										foreach($xinxi_list as $v){?>
										<tr>
											<td>
												<a target="_blank" href="<?php echo site_url('xinxi/show/'.$v['id']);?>"><?php echo $v['x_title'];?></a>
											</td>
											<td>
												<?php foreach(explode("|",$this->config->item('xinxi_types')) as $k => $s){if($v['x_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td>
												<?php echo date('Y-m-d H:i:s',$v['x_time']);?>
											</td>
											<td class="text-right">
												<a href="<?php echo site_url('member/xinxiedit/'.$citys['cid'].'/'.$v['id']);?>"><span class="icon-edit text-blue"></span> 修改</a>&nbsp;&nbsp;<a href="<?php echo site_url('member/xinxidel/'.$citys['cid'].'/'.$v['id']);?>"><span class="icon-trash-o text-red"></span> 删除</a>
											</td>
										</tr>
										<?php }}?>
									</tbody>
									</table>
									<?php if(isset($pagination)){?>
									<ul class="pagination pagination-group pull-right">
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