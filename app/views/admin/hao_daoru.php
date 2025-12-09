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
<style type="text/css">
.demo{margin:0px auto}
.demo p{line-height:32px}
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.btn input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
.progress { position:relative; width:200px;padding: 1px; border-radius:3px; display:none}
.bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
.files{height:22px; line-height:22px; margin:10px 0}
.delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
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
								<form accept-charset="UTF-8" id="new_add" action="" class="form-horizontal" role="form" method="post" novalidate="novalidate">
								
									<div class="form-group hidden-480">
										<div class="col-xs-12">
											<h4 class="widget-title blue smaller">
												<i class="ace-icon fa fa-rss orange"></i>
												请严格按照图片格式制作EXCEL文件，并强烈建议转换为<font color="red">CSV格式</font>，注意不要有乱码
											</h4>
										</div>
									</div>
									<div class="form-group hidden-480">
										<div class="space-4"></div>
										<div class="col-sm-9 text-center">
											<img class="center-block" src="<?php echo base_url('public/img/excel.jpg');?>">
										</div>
									</div>
									<div class="hr hr-16 hr-dotted hidden-480"></div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_type"> 类型 </label>
										<div class="col-sm-9">
											<div class="radio">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
											<label>
												<input name="hao_type" type="radio" class="ace" value="<?php echo $k;?>" <?php if(set_checkbox('hao_type',$k)){echo 'checked';}?> >
												<span class="lbl"> <?php echo $v;?></span>
											</label>
											<?php }}?>
											<?php if(form_error('hao_type')){?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 red"><?php echo form_error('hao_type');?></span><?php }else{?><span class="help-block col-sm-reset inline col-xs-12 col-sm-7 hidden-480">类型</span><?php }?>
											</div>
										</div>
									</div>
									<?php if($this->session->userdata('ucity')==0){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_city"> 城市 </label>
										<div class="col-sm-9">
											<select class="chosen-select form-control" id="city" data-placeholder="选择城市" onchange="getvalues(this)">
											<option value=""></option>
											<?php if($citys){
												foreach($citys as $v){?>
												<option value="<?php echo $v['cid'];?>"><?php echo $v['cname'];?></option>
											<?php }}?>
											</select><input type="hidden" id="hao_city" name="hao_city" value="">
											<span class="help-inline col-xs-12 col-sm-7">
												<span class="middle red"><?php echo form_error('hao_city');?></span>
											</span>
										</div>
									</div>
									<?php }else{?>
									<input type="hidden" id="hao_city" name="hao_city" value="<?php echo $this->session->userdata('ucity');?>">
									<?php }?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_excel"> 文件 </label>

										<div class="col-sm-9">
											<div class='daoboxss input-group col-xs-10 col-sm-5'>
												<input class="form-control" type="text" id="hao_excel" name="hao_excel" placeholder="EXCEL文件" value="<?php echo set_value('hao_excel');?>">
												<div class="demo">
												<?php echo csrf_hidden();?>
													<div class="btn">
														<span>添加文件</span>
														<input id="fileupload" type="file" name="file">
													</div>
											   </div>
										   </div>
										</div>
									</div>
									<div class="form-group" id="progress">
										<label class="col-sm-3 control-label no-padding-right" for="haoexcel">  </label>

										<div class="col-sm-9">
											<div class='input-group col-xs-10 col-sm-5'>
													<div class="progress">
														<span class="bar"></span><span class="percent">0%</span >
													</div>
										   </div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="hao_exceldao"> </label>
										<div class="col-sm-9"><span id="daobox" class="middle red"></span>
											<iframe id="downiframe" src="about:blank"  width="99%" height="50" scrolling=""  frameborder="0" style="overflow-x: hidden; overflow-y: auto; "></iframe>
										</div>
									</div>


									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" id="daoru" type="button">
												<i class="ace-icon fa fa-check bigger-110"></i>
												OK，导入号码
											</button>
											<a id="godaoru" class="btn btn-info" style="display:none;" href="<?php echo site_url('admin/daohao/daoru');?>">继续导入</a>
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
<?php echo js_url('fuelux/fuelux.spinner');?>

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
<?php echo js_url('ace/elements.spinner');?>
<?php echo js_url('ace/ace.settings');?>
<?php echo js_url('ace/ace.settings-rtl');?>
<?php echo js_url('ace/ace.settings-skin');?>
<?php echo js_url('ace/ace.widget-on-reload');?>
<?php echo js_url('ace/ace.searchbox-autocomplete');?>
<?php echo js_url('jquery.form');?>

<script type="text/javascript">
jQuery(function($){
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
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
});
function getvalues(obj)
{
	var c=obj.options[obj.selectedIndex].value
    $("input[name='hao_city']").attr("value",c);
	if(c){
		$("#pinpaibox").css({'display':'block'});
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
		$.ajax({
			//提交数据的类型 POST GET
			type:"POST",
			url:baseurl+"index.php/admin/haoma/getpinpai",
			data:{city:c,<?php echo $this->config->item('csrf_token_name');?>:token},
			//返回数据的格式
			datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
			//在请求之前调用的函数
			beforeSend:function(){$('#pinpai_list').html('城市品牌加载中……');},
			//成功返回之后调用的函数             
			success:function(data){
				$('#pinpai_list').html(decodeURI(data));
			}   ,
			//调用执行后调用的函数
			complete: function(XMLHttpRequest, textStatus){
			   //alert(XMLHttpRequest.responseText);
			   //alert(textStatus);
				//HideLoading();
			},
			//调用出错执行的函数
			error: function(){
				//请求出错处理
			}         
		 });
	}else{
		$("#pinpaibox").css({'display':'none'});
	}
}
</script>
<script type="text/javascript">
function hao_upokin (a) {
	$("#daobox").html(a);
	$("#progress").hide();
	$(".demo .btn").css({'display':'none'});
	var z= $('#hao_excel').val();
	if(z.indexOf('.csv') >0 ){
		$('#daobox').html('格式转换成功，可以导入'); 		
	}
}

$(document).ready(function(){
	$("#daoru").click(function(){ 
		var hao_city=$("#hao_city").val();
		var hao_excel=$("#hao_excel").val();
		var hao_type=$("input[name='hao_type']:checked").val();
		if(!hao_type){
			$("#daobox").html('号码类型必须选择');
		}else if(!hao_city){
			$("#daobox").html('城市必须选择');
		}else if(!hao_excel){
			$("#daobox").html('必须上传正确的EXCEL文件');
		}else{
			$("#daobox").html('');
			var reg=new RegExp(/\//g); 
			hao_excel=hao_excel.replace(reg,"fox");
			url=baseurl+'index.php/admin/daohao/daorucome/'+hao_city+'/'+hao_type+'/'+hao_excel;
			$("#downiframe").attr({"src":url});
		}
	});
});
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var progress = $(".progress");
	var progresst = $("#progress");
	var files = $("#daobox");
	var btn = $(".btn span");
	$(".demo").wrap("<form id='myupload' action='"+baseurl+"index.php/upload/upload_excel' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				btn.html("等待，上传中...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal)
        		percent.html(percentVal);
    		},
			complete: function(json) {
				$("#daobox").html(json.msg);
			},
			success: function(json) {	
				var a=json.msg;
				$("#daobox").html(a);
				$("#hao_excel").css({'display':''});
				$("#hao_excel").val(json.url);
				hao_upokin(a);				
			},
			error:function(xhr){
				btn.html("上传失败");
				bar.width('0');
				files.html(xhr.responseText);
			},
			clearForm: true   
		});
	});

});
</script>
</body>
</html>
