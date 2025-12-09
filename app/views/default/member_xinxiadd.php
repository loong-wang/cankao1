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
<link href="<?php echo $viewmulu.'/public/editor/E.css';?>" media="screen" rel="stylesheet" type="text/css" />
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
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" action="<?php echo site_url('member/xinxiadd/'.$citys['cid']);?>" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												信息类型</label>
										</div>
										<div class="field">
											<div class="button-group border-mix radio">
											<?php if($this->config->item('xinxi_types')){
											foreach(explode("|",$this->config->item('xinxi_types')) as $k => $v){
											?>
												<label class="button">
												<input name="x_type" type="radio" value="<?php echo $k;?>" data-validate="radio:请选择" >
												<?php echo $v;?></label>
											<?php }}?>
											</div>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												信息标题</label>
										</div>
										<div class="field">
											<input type="text" class="input input-auto" id="x_title" name="x_title" size="50" data-validate="required:必填" placeholder="信息标题" value="">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_jiage">
												价格</label>
										</div>
										<div class="field">
											<input type="text" class="input input-auto" id="x_jiage" name="x_jiage" size="30" data-validate="required:必填,number:格式不正确" placeholder="价格，0为面议" value="">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												信息描述</label>
										</div>
										<div class="field">
											<textarea id="post_content" name="content" rows="10" data-validate="required:必填"><?php echo html_entity_decode(set_value('content'));?></textarea>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_name">
												姓名</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="x_name" name="x_name" size="20" placeholder="真实姓名" data-validate="required:必填,chinese:必须为汉字" value="<?php echo $user['uzname'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_tel">
												联系电话</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="x_tel" name="x_tel" size="40" placeholder="联系电话" data-validate="required:必填,tel:验证没通过" value="<?php echo $user['utel'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_qq">
												Q Q</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="x_qq" name="x_qq" size="40" placeholder="联系QQ" data-validate="qq:验证没通过" value="<?php echo $user['uqq'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="x_email">
												联系邮箱</label>
										</div>
										<div class="field">
											<input type="text" class="input" id="x_email" name="x_email" size="40" placeholder="联系邮箱" data-validate="email:验证没通过" value="<?php echo $user['uemail'];?>">
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-button">
										<button class="button bg-sub" type="submit">确认提交</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="<?php echo $viewmulu.'/public/editor/E.js';?>" type="text/javascript"></script>
<script src="<?php echo $viewmulu.'/public/editor/P.js';?>" type="text/javascript"></script>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>