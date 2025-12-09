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
							<div class="pull-right">
							<a href="<?php echo site_url('member/dailiaddhao/'.$citys['cid']);?>" class="button bg-sub button-little"><span class="icon-edit"></span> 号码发布</a>
							<a href="<?php echo site_url('member/dailiruhao/'.$citys['cid']);?>" class="button bg-sub button-little"><span class="icon-mail-forward"></span> 批量导入</a>
							</div>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<div class="table-responsive">
									<table class="table table-hover">
										<tbody><tr>
											<th>
												号码
											</th>
											<th>
												默认品牌
											</th>
											<th>
												类型
											</th>
											<th>
												底价
											</th>
											<th>
												出售价
											</th>
											<th>
												话费
											</th>
											<th>状态</th>
											<th>
												更新时间
											</th>
											<th>
												<span class="pull-right text-right">操作</span>
											</th>
										</tr>
										<?php if(isset($haoma_list)){
										foreach($haoma_list as $v){?>
										<tr>
											<td>
												<a target="_blank" href="<?php echo site_url('haoma/show/'.$v['id'].'/'.$v['hao_title']);?>"><?php echo $v['hao_title'];?></a>
											</td>
											<td><?php echo $v['hao_pinpai'];?></td>
											<td>
												<?php foreach(explode("|",$this->config->item('hao_types')) as $k => $s){if($v['hao_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td><?php echo $v['hao_jiage'];?></td>
											<td><?php echo $v['hao_shoujia'];?></td>
											<td><?php echo $v['hao_huafei'];?></td>
											<td><?php echo $v['hao_lock'];?></td>
											<td>
												<?php echo date('Y-m-d',$v['hao_time']);?>
											</td>
											<td class="text-right">
												<a href="<?php echo site_url('member/dailiedithao/'.$citys['cid'].'/'.$v['id']);?>"><span class="icon-edit text-blue"></span> 修改</a>&nbsp;&nbsp;<a href="<?php echo site_url('member/dailidelhao/'.$citys['cid'].'/'.$v['id']);?>"><span class="icon-trash-o text-red"></span> 删除</a>
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