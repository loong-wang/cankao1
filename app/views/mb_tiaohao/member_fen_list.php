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
							<span class="text-red text-little padding-top">今天是<?php echo date('Y-m-d',time())?></span>
							</div>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<h2>您现有积分：<span class="text-red"><?php echo $user['ucredit'];?></span></h2>
								<br />
								<div class="table-responsive">
									<table class="table table-hover">
										<tbody><tr>
											<th>
												时间
											</th>
											<th>
												获得积分
											</th>
											<th>
												说明
											</th>
										</tr>
										<?php 							
										if(isset($fen_list)){
										foreach($fen_list as $v){
										?>
										<tr>
											<td><?php echo date('Y-m-d H:i',$v['do_date']);?></td>
											<td><span class="text-red"><?php echo $v['do_id'];?></span></td>
											<td>
											<span class="text-gray"><?php echo $v['do_memo'];?></span>
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