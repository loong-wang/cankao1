<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
<?php echo css_url('chosen');?>
<?php $this->load->view('common/header-meta');?>
<?php echo css_url('bootstrap-duallistbox');?>
</head>
<body class="no-skin">
<?php $this->load->view('common/header');?>
		<div class="main-container" id="main-container">
			<!-- #section:basics/sidebar -->
			<?php $this->load->view('common/sidebar');?>
			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo site_url('admin/login');?>">后台首页</a>
							</li>
							<li class="active"><?php echo $title;?></li>
						</ul><!-- /.breadcrumb -->
						<?php $this->load->view('common/topbar');?>	
						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<?php $this->load->view('common/setpager');?>
						<div class="page-header">
							<h1>
								<?php echo $title;?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo  strtoupper(Pinyin($title));?>
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<form accept-charset="UTF-8" id="new_add" action="<?php echo site_url('admin/webset/zhanb_edit/'.$city['cid']);?>" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								<?php echo csrf_hidden();?>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="stitle"> 所属省区 </label>

										<div class="col-sm-9">
											<select class="chosen-select form-control" id="sj" data-placeholder="选择省区" onchange="getvalue(this)">
												<option value="">请选择</option>
												<?php foreach(explode("|",$shengji) as $k => $v){?>
												<option value="<?php echo $k;?>" <?php if(set_value('sid',$city['sid'])==$k || $city['sid']==$k){echo 'selected';}?>><?php echo $v;?></option>
												<?php }?>
											</select><input type="hidden" id="sid" name="sid" value="<?php echo $city['sid'];?>">
											<span class="middle red"><?php echo form_error('sid');?></span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ctitle"> 城市名称 </label>

										<div class="col-sm-9">
											<input type="text" id="cname" name="cname" placeholder="城市名称" class="col-xs-10 col-sm-5" value="<?php echo set_value('cname',$city['cname']);?>">
											<?php if(form_error('cname')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('cname');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">如：北京，天津，青岛</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group hidden-480">
										<label class="col-sm-3 control-label no-padding-right" for="stitle"></label>

										<div class="col-sm-9">
											<i class="ace-icon fa fa-bell-o bigger-110 purple"></i> 提醒：分站修改时省区和城市名称保持不变，以下内容可以修改
										</div>
									</div>

									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ctitle"> 网站名称 </label>

										<div class="col-sm-9">
											<input type="text" id="ctitle" name="ctitle" placeholder="网站名称" class="col-xs-10 col-sm-5" value="<?php echo $city['ctitle'];?>">
											<?php if(form_error('ctitle')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('ctitle');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">网站名称</span><?php }?>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ckeywords"> 网站关键词 </label>

										<div class="col-sm-9">
											<input type="text" id="ckeywords" name="ckeywords" placeholder="网站关键词" class="col-xs-10 col-sm-5" value="<?php echo $city['ckeywords'];?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">
											用,分开，80字内
											</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cdescription"> 网站描述 </label>

										<div class="col-sm-9">
											<input type="text" id="cdescription" name="cdescription" placeholder="网站描述" class="col-md-8 col-xs-10 col-sm-5" value="<?php echo $city['cdescription'];?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">200字内</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cthemes"> 默认模板 </label>

										<div class="col-sm-9">
											<select class="chosen-select form-control" id="cthemes" data-placeholder="选择模板" onchange="getvalues(this)">
											<option value=""></option>
											<?php if($this->config->item('moban_list')){
												foreach(explode("|",$this->config->item('moban_list')) as $v){?>
												<option value="<?php echo $v;?>" <?php if($v==$city['cthemes']){echo 'selected';}?>><?php echo $v;?></option>
											<?php }}?>
											</select>
											<input type="hidden" id="cthemes" name="cthemes" placeholder="默认模板" class="col-xs-10 col-sm-5" value="<?php echo $city['cthemes'];?>">
											<?php if(form_error('cthemes')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('cthemes');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认模板，一般无需要修改</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cowner"> 网站所有 </label>

										<div class="col-sm-9">
											<input type="text" id="cowner" name="cowner" placeholder="网站所有" class="col-xs-10 col-sm-5" value="<?php echo $city['cowner'];?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">公司或者个人，不填写不显示</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="webtel"> 联系电话 </label>

										<div class="col-sm-9">
											<input type="text" id="ctel" name="ctel" placeholder="联系电话" class="col-xs-10 col-sm-5" value="<?php echo $city['ctel'];?>">
											<?php if(form_error('ctel')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('ctel');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认电话</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cqq"> 客服QQ </label>

										<div class="col-sm-9">
											<input type="text" id="cqq" name="cqq" placeholder="客服QQ" class="col-xs-10 col-sm-5" value="<?php echo $city['cqq'];?>">
											<?php if(form_error('cqq')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('cqq');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认客服QQ，多个用|分开</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cdress"> 所在地址 </label>

										<div class="col-sm-9">
											<input type="text" id="cdress" name="cdress" placeholder="所在地址" class="col-xs-10 col-sm-5" value="<?php echo $city['cdress'];?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">默认地址</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="clogo"> 网站logo </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="clogo_<?php echo $foxtime;?>" name="clogo_<?php echo $foxtime;?>" type="text" value="<?php echo $city['clogo'];?>" />
											<span class='input-group-addon'><input id="upload_logo" type="button" value="选择"></span>
											</div>
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">最佳170*65</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="ctelpic"> 电话图片 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="ctelpic_<?php echo $foxtime;?>" name="ctelpic_<?php echo $foxtime;?>" type="text" value="<?php echo $city['ctelpic'];?>" />
											<span class='input-group-addon'><input id="upload_ctelpic" type="button" value="选择"></span>
											</div>
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">最佳210*40</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cwxpic"> 微信公众号 </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
											<input class="form-control" id="cwxpic_<?php echo $foxtime;?>" name="cwxpic_<?php echo $foxtime;?>" type="text" value="<?php echo $city['cwxpic'];?>" />
											<span class='input-group-addon'><input id="upload_cwxpic" type="button" value="选择"></span>
											</div>
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">微信公众号图片</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cdomain"> 网站域名 </label>

										<div class="col-sm-9">
											<input type="text" id="cdomain" name="cdomain" placeholder="网站域名" class="col-xs-10 col-sm-5" value="<?php echo set_value('cdomain',$city['cdomain']);?>">
											<?php if(form_error('cdomain')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('cdomain');?></span><?php }else{?><span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">支持二级域名，不含 http://</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cstats"> 统计代码 </label>

										<div class="col-sm-9">
											<textarea class="col-xs-10 col-sm-5" id="cstats" name="cstats" rows="5"><?php echo $city['cstats'];?></textarea>
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">支持HTML</span>
										</div>
									</div>
									
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cnums"> 网站系数 </label>

										<div class="col-sm-9">
											<input type="text" id="cnums" name="cnums" placeholder="网站系数" class="col-xs-10 col-sm-5" value="<?php echo $city['cnums'];?>">
											<?php if(form_error('cnums')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('cnums');?></span><?php }else{?><span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">默认系数，如1.2</span><?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cbeian"> 备案号 </label>

										<div class="col-sm-9">
											<input type="text" id="cbeian" name="cbeian" placeholder="备案号" class="col-xs-10 col-sm-5" value="<?php echo $city['cbeian'];?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">一级域名用</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_email"> 站长邮箱 </label>

										<div class="col-sm-9">
											<input type="text" id="cz_email" name="cz_email" placeholder="站长邮箱" class="col-xs-10 col-sm-5" value="<?php echo $city['cz_email'];?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">站长邮箱</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_tel"> 客服热线 </label>

										<div class="col-sm-9">
											<input type="text" id="cz_tel" name="cz_tel" placeholder="客服热线" class="col-xs-10 col-sm-5" value="<?php echo $city['cz_tel'];?>">
											<span class="help-block col-sm-reset inline col-md-3 col-xs-12 col-sm-7">客服热线</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_email_me"> 通知邮箱 </label>

										<div class="col-sm-9">
											<input type="text" id="cz_email_me" name="cz_email_me" placeholder="通知邮箱" class="col-xs-10 col-sm-5" value="<?php echo $city['cz_email_me'];?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">下单通知邮箱</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_shouji_me"> 通知手机 </label>

										<div class="col-sm-9">
											<input type="text" id="cz_shouji_me" name="cz_shouji_me" placeholder="通知手机" class="col-xs-10 col-sm-5" value="<?php echo $city['cz_shouji_me'];?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">下单通知手机</span>
										</div>
									</div>
									<div class="hr hr-16 hr-dotted"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_search"> 站内搜索词 </label>
										<div class="col-sm-9">
											<input type="text" id="cz_search" name="cz_search" placeholder="站内搜索词" class="col-xs-10 col-sm-5" value="<?php echo $city['cz_search'];?>">
											<span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">站内搜索词</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="cz_memu"> 导航菜单 </label>
										<div class="col-sm-9">
											<div class="checkbox">
											<?php if(isset($memu_list)){												
											foreach($memu_list as $k => $v){?>
												<label>
													<input name="cz_memu[]" type="checkbox" class="ace" value="<?php echo $v['url'];?>" <?php if(strstr(''.$city['cz_memu'].'',''.$v['url'].'')){echo 'checked';}?> >
													<span class="lbl"> <?php echo $v['title'];?></span>
												</label>
											<?php }} ?>
											</div>
										</div>
									</div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												确认提交
											</button>
										</div>
									</div>
								</form>
						</div>
					</div><!-- /.row -->

			<?php $this->load->view('common/footer');?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
<!--[if !IE]> -->
<script type="text/javascript">
	window.jQuery || document.write("<?php echo jjs_url('jquery');?>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<?php echo jjs_url('jquery1x');?>");
</script>
<![endif]-->

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<?php echo jjs_url('jquery.mobile.custom');?>");
</script>
<?php echo js_url('bootstrap');?>
<!-- page specific plugin scripts -->
<?php echo js_url('jquery.bootstrap-duallistbox');?>
<?php echo js_url('bootstrap-multiselect');?>

<!--[if lte IE 8]>
	<?php echo js_url('excanvas');?>
<![endif]-->

<?php echo js_url('jquery-ui.custom');?>
<?php echo js_url('jquery.ui.touch-punch');?>
<?php echo js_url('chosen.jquery');?>

<!-- ace scripts -->
<?php echo js_url('ace/elements.scroller');?>
<?php echo js_url('ace/elements.colorpicker');?>
<?php echo js_url('ace/ace');?>
<?php echo js_url('ace/ace.ajax-content');?>
<?php echo js_url('ace/ace.touch-drag');?>
<?php echo js_url('ace/ace.sidebar');?>
<?php echo js_url('ace/ace.sidebar-scroll-1');?>
<?php echo js_url('ace/ace.submenu-hover');?>
<?php echo js_url('ace/ace.widget-box');?>
<?php echo js_url('ace/ace.settings');?>
<?php echo js_url('ace/ace.settings-rtl');?>
<?php echo js_url('ace/ace.settings-skin');?>
<?php echo js_url('ace/ace.widget-on-reload');?>
<?php echo js_url('ace/ace.searchbox-autocomplete');?>
<?php echo js_url('jquery.upload');?>
<script type="text/javascript">
jQuery(function($){
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#upload_logo").click(function(){ 
	doUpload('clogo_<?php echo $foxtime;?>'); 
	});
	$("#upload_ctelpic").click(function(){ 
	doUpload('ctelpic_<?php echo $foxtime;?>'); 
	});
	$("#upload_cwxpic").click(function(){ 
	doUpload('cwxpic_<?php echo $foxtime;?>'); 
	});
	if(!ace.vars['touch']) {
		$('.chosen-select').chosen({allow_single_deselect:true}); 
		//resize the chosen on window resize

		$(window)
		.off('resize.chosen')
		.on('resize.chosen', function() {
			$('.chosen-select').each(function() {
				 var $this = $(this);
				 $this.next().css({'width': '150px'});				
			})
		}).trigger('resize.chosen');
		//resize chosen on sidebar collapse/expand
		$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
			if(event_name != 'sidebar_collapsed') return;
			$('.chosen-select').each(function() {
				 var $this = $(this);
				 $this.next().css({'width': '150px'});
			})
		});

	}
});
function getvalue(obj)
{
	var m=obj.options[obj.selectedIndex].value
    $("input[name='sid']").attr("value",m);
}
function getvalues(obj)
{
	var c=obj.options[obj.selectedIndex].value
    $("input[name='cthemes']").attr("value",c);
}
function doUpload(name) {
        // 上传方法
        var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
        $.upload({
			// 上传地址
			url:baseurl+"index.php/upload/upload_daimages/"+name, 
			// 文件域名字
			fileName: 'img', 
			// 其他表单数据
			params:{<?php echo $this->config->item('csrf_token_name');?>:token},
			// 上传完成后, 返回json, text
			dataType: 'json',
			// 上传之前回调,return true表示可继续上传
			onSend: function() {
				return true;
			},
			// 上传之后回调
			onComplate: function(data) {
				if(data.file_url){
					$('#'+name).val(data.file_url);
					//alert(data.msg);
				} else {
					alert(data.error);
				}
			}
        });
}
</script>
</script>
</body>
</html>
