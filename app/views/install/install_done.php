<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->load->view ( 'common/header-meta' ); ?>
    <title>安装向导 | Powered By FOXCMSBT</title>
<style>
body{font-family: "Microsoft YaHei","黑体","Arial",sans-serif;}
.allboxp p{padding:0 30px;line-height:30px;}
</style>
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top:50px;">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">安装向导 >> 安装完成</div>
                    <div class="panel-body">
                        <center>
                            <br><br>
                            <h3>安装完成！</h3>
                            <br><br>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-3">
                                    <a class="btn btn-primary btn-block" href="<?php echo site_url();?>" role="button">点击访问前台</a>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary btn-block" href="<?php echo site_url('admin/login');?>" role="button">点击进入后台</a>
                                </div>
                            </div>
                            <br>
                        </center>
                    </div>
                    <center class="panel-footer">
                        Copyright © 2015 技术支持：<a href="http://www.kuaiwww.com">快网</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</body>
</html>