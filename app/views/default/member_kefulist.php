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
							<a href="<?php echo site_url('member/kefuadd/'.$citys['cid']);?>" class="button bg-sub pull-right"><span class="icon-edit"></span> 继续咨询</a>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<div class="table-responsive">
									<table class="table table-hover">
										<tbody><tr>
											<th>
												咨询标题
											</th>
											<th>
												类型
											</th>
											<th>
												提交时间
											</th>
											<th>
												<span class="pull-right text-right">状态</span>
											</th>
										</tr>
										<?php if(isset($question_list)){
										foreach($question_list as $v){?>
										<tr>
											<td>
												<a target="_blank" href="<?php echo site_url('kefu/show/'.$v['id']);?>"><?php echo $v['q_title'];?></a>
											</td>
											<td>
												<?php foreach(explode("|",$this->config->item('question_types')) as $k => $s){if($v['q_type']==$k){echo '<span class="badge badge-pink">'.$s.'</span>';}}?>
											</td>
											<td>
												<?php echo date('Y-m-d H:i:s',$v['q_time']);?>
											</td>
											<td class="text-right">
												<?php if($v['q_reuserid']>0){echo '<i class="fa fa-check-circle fa-1 green"></i> 已回复';}else{echo '<i class="fa fa-close fa-1 red"></i> 未回复';}?>
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