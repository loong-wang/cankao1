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
							<li><a href="<?php echo site_url('member/editme/'.$citys['cid']);?>">完善资料</a></li>
							<li><a href="<?php echo site_url('member/editpass/'.$citys['cid']);?>">修改密码</a> </li>
							<li class="active"><a href="#tab-a">头像设置</a> </li>
						</ul>
					</div>
					<div class="tab-body">
						<div class="tab-panel active" id="tab-a">
							<div class="view-body margin-top">
								<form accept-charset="UTF-8" method="post" enctype="multipart/form-data" action="<?php echo site_url('member/avatar_upload/'.$citys['cid'])?>" class="form-x form-auto">
								<?php echo csrf_hidden();?>
									<div class="form-group">
										<div class="label">
											<label for="av">
												当前头像</label>
										</div>
										<div class="field">
											<img src="<?php echo base_url($user['big_avatar']);?>" width="100" class="img-border radius-circle">
											<img src="<?php echo base_url($user['middle_avatar']);?>" width="48" class="img-border radius-circle">
											<img src="<?php echo base_url($user['small_avatar']);?>" width="24" class="img-border radius-circle">
											<div class="input-note"><strong>注意</strong> 支持 512k 以内的 PNG / GIF / JPG 图片文件作为头像，推荐使用正方形的图片以获得最佳效果。</div>
										</div>
									</div>
									
									<div class="form-group">
										<div class="label">
											<label for="av">
												选择图片</label>
										</div>
										<div class="field">
											<a class="button input-file" href="javascript:void(0);">+ 浏览文件<input type="file" id="avatar_file" name="avatar_file" onchange="PreviewImage(this,'imgView','divNewPreview')" /></a>
										</div>
									</div>
									<div class="form-group hidden" id="imgdiv">
										<div class="label">
											<label for="av">
												图片预览</label>
										</div>
										<div class="field">
											<img id="imgView" width="100" height="100" class="img-border radius-circle" />
										</div>
									</div>
									<div class="form-button margin-top">
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
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>