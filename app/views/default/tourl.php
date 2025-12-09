<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php if($title) echo $title;?></title>
<?php echo ccss_url('bootstrap,font-awesome,ace','ace-fonts');?>
<script type='text/javascript' src="<?php echo base_url('app/views/default/public/js/jquery.js');?>"></script>
<style type="text/css">
.fa-2 {
    font-size: 2em;
}
.f-text {padding-left:10px;
    font-size: 16px;font-family: '微软雅黑', 'Microsoft YaHei', "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;font-weight:normal;
}
.textbox{min-height:40px;line-height:40px}
#login-box{margin-top:30px;}
.login-containers {
	max-width:600px;
    margin: 0 auto;
}
</style>
</head>
<body class="login-layout light-login">
<div class="main-container">
	<div class="main-content">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="login-containers ptop100">
					<div class="space-6"></div>

					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">							
								<div class="widget-main">
									<h2 class="grey lighter smaller">
										<span class="blue bigger-125">
											<i class="ace-icon fa fa-sitemap"></i>
										</span>
										正在转向中
									</h2>
									<div class="alert alert-success textbox" role="alert">
									 <i class="fa fa-smile-o fa-2">
									<span class="f-text">正在转向<?php echo $tocity['cname'];?>站，靓号即将呈现……</span></i>
									</div>
									<p>
									<?php if($this->config->item('index_page')){
										$url='/'.$this->config->item('index_page').'/';
									}else{
										$url='/';
									}
									if($tocity['cdomain']!=trim($this->config->item('site_domain')) && in_array($tocity['cdomain'], explode("|",$this->config->item('site_domains')))){
										$tourl='http://'.$tocity['cdomain'];
									}else{
										$tourl='http://'.$tocity['cdomain'].$url.'home/city/'.$tocity['cid'];
									}
									?>
									<a href="<?php echo $tourl;?>" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a>
									</p>
									<div class="space-6"></div>	
									<?php echo csrf_hidden();?>
								</div><!-- /.widget-main -->
								<script language="javascript">setTimeout("window.location='<?php echo $tourl;?>';", 5);</script>   
							</div><!-- /.widget-body -->
						</div><!-- /.login-box -->
					</div><!-- /.position-relative -->
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.main-content -->
</div>
</body>
</html>