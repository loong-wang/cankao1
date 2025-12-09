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
                    <div class="panel-heading">安装向导 >> 创建管理员</div>
                    <div class="panel-body">
                        <?php echo form_open('install/setadmin', array('class' => 'form-horizontal', 'role' => 'form', 'onsubmit' => 'return validate_form(this)'));?>
                            <div class="form-group">
                                <label class="col-md-offset-1 control-label"><h3><b>创始人信息：</b></h3></label>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-md-2 col-md-offset-1 control-label">管理员</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $item['username'];?>" placeholder="username">
                                    <span class="help-block red"><?php echo form_error('username');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-2 col-md-offset-1 control-label">密码</label>
                                <div class="col-md-7">
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password')?>" placeholder="Password">
                                    <span class="help-block red"><?php echo form_error('password');?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-2 col-md-offset-1 control-label">邮箱</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="email" name="email" value="lyoy2008@163.com" placeholder="lyoy2008@163.com">
                                </div>
                            </div>
                            <div style="text-align: center">
                                <br>
                                <button type="submit" id="check" class="btn btn-primary btn-block">创建管理员</button>
                            </div>

                        </form>
                    </div>
                    <div class="panel-footer" style="text-align: center">
                        Copyright © 2015 技术支持：<a href="http://www.kuaiwww.com">快网</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
                            <script type="text/javascript" src=""<?php echo base_url('static/common/js/install.js')?> defer="defer"></script>
</body>
</html>