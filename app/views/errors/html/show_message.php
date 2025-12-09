<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset='UTF-8'>
<meta content='True' name='HandheldFriendly'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>
<title><?php if($heading) echo $heading;else {?>Error<?php }?></title>
<?php echo ccss_url('bootstrap,font-awesome,ace','ace-fonts');?>
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
										<?php echo $heading; ?>
									</h2>
									<div class="alert<?php if ($status==1){ ?> alert-success<?php }else{?> alert-danger<?php } ?> textbox" role="alert">
									<?php if ($status==1){ ?> <i class="fa fa-smile-o fa-2"> <?php }else{?> <i class="fa fa-meh-o fa-2"> <?php } ?> 
									<span class="f-text"><?php echo $message;?></span></i>
									</div>
									<p>
									<?php if(!$url){ ?>
									<a href="javascript:history.back();" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a>
									<script language="javascript">setTimeout(function(){history.back();}, <?php echo $time; ?>);</script>
									<?php } else{?>
									<a href="<?php echo $url?>" class="alert-link">如果您的浏览器没有自动跳转，请点击这里</a>
									<script language="javascript">setTimeout("location.href='<?php echo $url; ?>';", <?php echo $time; ?>);</script>   
									<?php } ?>
									</p>

									<div class="space-6"></div>								

								</div><!-- /.widget-main -->
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