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
	<ul class="bread breads">
		<li><span class="icon-home"></span> 您的当前位置：<a href="<?php echo $shouye_url;?>"><?php echo $citys['cname'];?>首页</a> </li>
		<li><?php echo $title;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst alldbgy">
				<div class="tab-head padding-top">
					<ul class="tab-nav">
						<li class="active"><a><?php echo $title;?></a> </li>
					</ul>
				</div>
				<br />
				<div class="view-body">
					<div class="doc-bg-color">
						<p class="bg-back padding border border-sub text-small">亲爱的用户，如果您在 选号大厅 查询不到您需要的号码，您可以填写下面的表单与我们联系，我们会在第一时间为您找到需要的号码或者类似的号码，更好的满足您的要求。</p>
						<br />
						<p class="bg padding-left border"><span class="icon-pencil-square-o"></span> <strong>请输入您需要预定的号码信息</strong></p>
						<form accept-charset="UTF-8" method="post" action="<?php echo site_url('dingzhi/haoma/'.$citys['cid']);?>" class="form-x">
						<?php echo csrf_hidden();?>
						<br />
							<div class="form-group">
								<div class="label">
									<label for="dz_title">
										号码归属地</label>
								</div>
								<div class="field">
									<select class="input input-auto" name="dz_city" data-validate="required:请选择归属地">
										<option value="<?php echo $citys['cid'];?>" selected><?php echo $citys['cname'];?></option>
										<?php if(isset($citylist)){print_r($citylist);
										foreach($citylist as $v){?>
										<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
										<?php }}?>
									</select>
									<span class="text-sub" >系统默认 <span class="text-red"><?php echo $citys['cname'];?></span></span>
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dz_title">
										具体号码</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dz_title" name="dz_title" size="30" placeholder="订制的号码" data-validate="required:必填">
									<span class="text-sub text-little" >*请输入您要的号码的关键数字，无特殊要求请用*代替，例如：需要预定开头为139，尾数为6666的手机号，则需要填写139****6666</span>
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dz_content">
										其他要求</label>
								</div>
								<div class="field">
									<textarea class="input" id="dz_content" name="dz_content" placeholder="其他补充要求"></textarea>
									<div class="input-note text-sub"></div>
								</div>
							</div>
						<br />
						<p class="bg padding-left border"><span class="icon-pencil-square-o"></span> <strong>请认真填写您的联系信息，以便我们查询到号码第一时间联系您</strong></p>
						<br />
							<div class="form-group">
								<div class="label">
									<label for="dz_name">
										您的姓名</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dz_name" name="dz_name" size="30" placeholder="您的姓名" data-validate="required:必填,chinese:必须为中文姓名">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dz_tel">
										联系电话</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dz_tel" name="dz_tel" size="30" placeholder="您的电话" data-validate="required:必填,tel:必须为手机号或者电话">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dz_qq">
										联系QQ</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dz_qq" name="dz_qq" size="30" placeholder="您的QQ" data-validate="qq:格式不正确">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="dz_email">
										Email</label>
								</div>
								<div class="field">
									<input type="text" class="input input-auto" id="dz_email" name="dz_email" size="30" placeholder="您的邮箱" data-validate="email:格式不正确">
									<div class="input-note"></div>
								</div>
							</div>
							<div class="form-button">
								<button class="button bg-sub" type="submit">
									提交我的订制</button>
							</div>
						</form>
						<br />
						<p class="bg padding border">
						1、您的定制的号码信息我们会发送给当地的运营商和号码经销商，如果经销商有您需要的号码，我们会第一时间联系您，请耐心等待。
						<br />2、如果您已经购买到号码，请在管理后台删除您的预订信息，或者联系我们的站点客服。</p>
					</div>
				</div>
				<br />

			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>

</body>
</html>