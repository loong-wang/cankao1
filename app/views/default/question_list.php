<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> - <?php echo $citys['ctitle'];?></title>
<meta name="keywords" content="<?php echo $title;?>,<?php echo $citys['ckeywords'];?>" />
<meta name="description" content="<?php echo $title;?>,<?php echo $citys['cdescription'];?>" />
<?php $this->load->view('header-meta');?>
<link href="<?php echo $viewmulu.'/public/editor/E.css';?>" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<?php $this->load->view('header');?>
<div class="container">
	<ul class="bread breads">
		<li><span class="icon-home"></span> <span class="hidden-l">您的当前位置：</span><a href="<?php echo $shouye_url;?>"><?php echo $citys['cname'];?>首页</a> </li>
		<li><a href="<?php echo site_url($sdao_url);?>"><?php echo $title;?></a> </li>
		<li><?php echo $stitle;?></li>
	</ul>	
	<div class="line-big">
    	<div class="xs4 xm3 xb3 hidden-l">  
		<div class="hidden-l"></div>
		<?php $this->load->view('leftbox');?>
        </div>
        <div class="xl12 xs8 xm9 xb9">
			<div class="tabst bg-foxc alldbg navbar">
				<div class="tab-head padding-top">
				 <button class="button icon-navicon" data-target="#navbarlist"></button>
					<strong>全部问题 <span class="badge bg-red"><?php echo $q_count;?></span></strong>
					<?php if($q_type==0){?>
					<span class="tab-more">已解决<span class="text-red"><?php echo $q_count_ax;?></span> 未解决<span class="text-red"><?php echo $q_count_a-$q_count_ax;?></span> </span>
					<?php }elseif($q_type==1){?>
					<span class="tab-more">已解决<span class="text-red"><?php echo $q_count_bx;?></span> 未解决<span class="text-red"><?php echo $q_count_b-$q_count_bx;?></span> </span>
					<?php }elseif($q_type==2){?>
					<span class="tab-more">已解决<span class="text-red"><?php echo $q_count_cx;?></span> 未解决<span class="text-red"><?php echo $q_count_c-$q_count_cx;?></span> </span>
					<?php }?>
					<ul class="tab-nav nav-navicon" id="navbarlist">
						<li <?php if($q_type==0){echo 'class="active"';}?>><a href="<?php echo site_url('kefu/yidong/'.$citys['cid']);?>">移动客服 <span class="badge bg-blue"><?php echo $q_count_a;?></span></a> </li>
						<li <?php if($q_type==1){echo 'class="active"';}?>><a href="<?php echo site_url('kefu/liantong/'.$citys['cid']);?>">联通客服 <span class="badge bg-blue"><?php echo $q_count_b;?></span></a> </li>
						<li <?php if($q_type==2){echo 'class="active"';}?>><a href="<?php echo site_url('kefu/dianxin/'.$citys['cid']);?>">电信客服 <span class="badge bg-blue"><?php echo $q_count_c;?></span></a> </li>
					</ul>
				</div>
				<div class="bg-white">
					<div class="view-body padding-top">
						<div class="table-responsive">
						<br />
							<div class="view-body">
							<br />
							<?php if($question_list){
							foreach($question_list as $v){?>
								<dl class="dl-inline clearfix margin-big-top margin-big-bottom height-big border-top-bottom border-dotted" style="border-top:0;">
									<dt><button class="button flash-hover <?php if($v['q_reuserid']==0){echo 'bg text-gray';}else{echo 'border-main bg-green-light';}?>"><?php if($v['q_reuserid']==0){echo '<i class="icon-times"></i> 未回答';}else{echo '<i class="icon-check-circle"></i> 已解决';}?></button></dt>
									<dd><span class="float-right bg text-small text-gray"><?php echo date('m-d',$v['q_time']);?></span>
									<a class="text-red" target="_blank" href="<?php echo site_url('kefu/show/'.$v['id']);?>"><?php echo $v['q_title'];?></a>
									<?php if($v['q_reuserid']>0){?>
									<h6 class="text-gray"><?php echo $citys['ctitle'];?> <span class="text-green"><?php echo $v['q_rename'];?></span> 回答了该问题</h6>
									<div class="xinxibox margin-top">
										<span class="arrow"></span>
										<?php echo html_entity_decode(br2nl($v['q_recontent']));?>
									</div>
									<?php }?>
									</dd>
								</dl>
							<?php }}?>
							</div>
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
				<div class="view-body margin-top">
					<form accept-charset="UTF-8" method="post" action="<?php echo site_url('kefu/ask/'.$citys['cid']);?>" class="form-x form-auto">
					<?php echo csrf_hidden();?>
						<div class="form-group">
							<div class="label">
								<label for="q_title">
									咨询类型</label>
							</div>
							<div class="field">
								<?php if($this->config->item('question_types')){
								foreach(explode("|",$this->config->item('question_types')) as $k => $v){
								if($k!=3 && $k!=4){?>
									<label class="button">
									<input name="q_type" type="radio" value="<?php echo $k;?>" data-validate="radio:请选择" <?php if($q_type==$k){ echo 'checked';}?>>
									<?php echo $v;?></label>
								<?php }}}?>
								<div class="input-note"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="label">
								<label for="q_title">
									咨询标题</label>
							</div>
							<div class="field">
								<input type="text" class="input input-auto" id="q_title" name="q_title" size="50" data-validate="required:必填" placeholder="咨询标题" value="">
								<div class="input-note"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="label">
								<label for="q_title">
									问题描述</label>
							</div>
							<div class="field">
								<textarea id="post_content" name="content" rows="10" data-validate="required:必填"><?php echo html_entity_decode(set_value('content'));?></textarea>
								<div class="input-note"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="label">
								<label for="q_name">
									姓名</label>
							</div>
							<div class="field">
								<input type="text" class="input" id="q_name" name="q_name" size="20" placeholder="真实姓名" data-validate="required:必填,chinese:必须为汉字" value="<?php if($this->session->userdata('userid')){echo $user['uzname'];}?>">
								<div class="input-note"></div>
							</div>
						</div>
						<div class="form-group">
							<div class="label">
								<label for="q_tel">
									联系电话</label>
							</div>
							<div class="field">
								<input type="text" class="input" id="q_tel" name="q_tel" size="40" placeholder="联系电话" data-validate="required:必填,tel:验证没通过" value="<?php if($this->session->userdata('userid')){echo $user['utel'];}?>">
								<div class="input-note"></div>
							</div>
						</div>
                      
                    <?php if($this->config->item('show_captcha')=='on'){?>
						<div class="form-group">
							<div class="label">
								<label for="q_tel">
									验证码</label>
							</div>
							<div class="field">
								<input type="text" class="input" name="captcha_code" placeholder="填写右侧的验证码" value="<?php echo set_value('captcha_code'); ?>" data-validate="required:请填写右侧的验证码,ajax#/index.php/user/check_captcha_code/:验证码不正确">
								<img src="<?php echo site_url('captcha_code');?>" name="checkCodeImg" id="checkCodeImg" onclick="javascript:reloadcode();" border="0"  width="65" height="32" class="passcode" />
								<div class="input-note"></div>
							</div>
						</div>                      
 
							<script language="javascript">
							//刷新图片
							function reloadcode() {//刷新验证码函数
							 var verify = document.getElementById('checkCodeImg');
							 verify.setAttribute('src', '<?php echo site_url('captcha_code?');?>' + Math.random());
							}
							</script>
	                 <?php }?>
                      
						<div class="form-button">
							<button class="button bg-sub" type="submit">我要咨询</button>
						</div>
					</form>
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