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
<script src="<?php echo $viewmulu.'/public/js/jquery.form.js';?>" type="text/javascript"></script>
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
								<form accept-charset="UTF-8" method="post" action="" class="form-x form-auto">
									<div class="form-group">
										<div class="label">
											<label for="x_title">
												类型</label>
										</div>
										<div class="field">
											<?php if($this->config->item('hao_types')){
											foreach(explode("|",$this->config->item('hao_types')) as $k => $v){
											?>
												<label class="button">
												<input name="hao_type" type="radio" value="<?php echo $k;?>" data-validate="radio:请选择" onchange="getvalues(this.value)" >
												<?php echo $v;?></label>
											<?php }}?>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_city">
												城市</label>
										</div>
										<div class="field"><input type="hidden" id="hao_city" name="hao_city" value="<?php echo $this->session->userdata('ucity');?>">
										<label class="button">
										<?php echo $ucity;?></label>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_pinpai">
												品牌</label>
										</div>
										<div class="field">
											<div id="pinpai_list"></div>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group">
										<div class="label">
											<label for="hao_jiage">
												文件</label>
										</div>
										<div class="field button-group">
											<input class="button input" type="text" id="hao_excel" name="hao_excel" size="30" placeholder="EXCEL文件" value="">
											<div class="demo">
												<?php echo csrf_hidden();?>
													<div class="btn">
														<span>添加文件</span>
														<input id="fileupload" type="file" name="file">
													</div>
											   </div>
											<div class="input-note"></div>
										</div>
									</div>
									<div class="form-group" id="progress">
										<div class="label"><label for="hao_excels"> &nbsp; </label></div>

										<div class="field">
											<div class='input-group'>
												<div class="progress">
													<span class="bar"></span><span class="percent">0%</span >
												</div>
											</div>
										</div>
									</div>
									<hr class="space" />
									<div class="form-button">
										<button class="button bg-sub" id="daoru" type="button"><i class="ace-icon fa fa-check bigger-110"></i>
										OK，导入号码</button>
										<a id="godaoru" class="btn btn-info" style="display:none;" href="<?php echo site_url('member/dailiruhao/'.$citys['cid']);?>">继续导入</a>
									</div>
									<hr class="space" />
									<hr class="space" />
									<div class="form-group">
										<div class="label">
											<label for="">
												</label>
										</div>
										<div class="field"><span id="daobox" class="middle text-red"></span>
											<iframe id="downiframe" src="about:blank"  width="99%" height="50" scrolling=""  frameborder="0" style="overflow-x: hidden; overflow-y: auto; "></iframe>
										</div>
									</div>
									
									<hr />
									<div class="form-group"><img class="img-border radius-small" src="<?php echo base_url('public/img/mexcel.jpg');?>"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
function getvalues(obj)
{
	var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
	$.ajax({
		//提交数据的类型 POST GET
		type:"POST",
		url:baseurl+"index.php/member/getpinpai",
		data:{hao_type:obj,<?php echo $this->config->item('csrf_token_name');?>:token},
		//返回数据的格式
		datatype: "html",//"xml", "html", "script", "json", "jsonp", "text".
		//在请求之前调用的函数
		beforeSend:function(){$('#pinpai_list').html('品牌加载中……');},
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
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#daoru").click(function(){ 
		var hao_city=$("#hao_city").val();
		var hao_excel=$("#hao_excel").val();
		var hao_type=$("input[name='hao_type']:checked").val();
		var hao_pinpai=$(":radio[name='hao_pinpai']:checked").val();
		var hao_pinpait=$(":radio[name='hao_pinpai']:checked").next("span").text();
		var hao_pinpais="";
		if(hao_pinpai){
			hao_pinpais="选择品牌为："+hao_pinpait+" ";
		}
		if(!hao_pinpai){
			hao_pinpai='nopinpai';
		}
		if(!hao_type){
			$("#daobox").html(hao_pinpais+'号码类型必须选择');
		}else if(!hao_city){
			$("#daobox").html(hao_pinpais+'城市必须选择');
		}else if(!hao_excel){
			$("#daobox").html(hao_pinpais+'必须上传正确的EXCEL文件');
		}else{
			$("#daobox").html('');
			var reg=new RegExp(/\//g); 
			hao_excel=hao_excel.replace(reg,"fox");
			url=baseurl+'index.php/member/daorucome/'+hao_pinpai+'/'+hao_type+'/'+hao_excel;
			$("#downiframe").attr({"src":url});
		}
	});
});
function hao_upokin (a) {
	$("#daobox").html(a);
	$("#progress").hide();
	$(".demo .btn").css({'display':'none'});
	var z= $('#hao_excel').val();
	if(z.indexOf('.csv') >0 ){
		$('#daobox').html('格式转换成功，可以导入'); 		
	}
}
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var progress = $(".progress");
	var progresst = $("#progress");
	var files = $("#daobox");
	var btn = $(".btn span");
	$(".demo").wrap("<form id='myupload' action='"+baseurl+"index.php/upload/upload_excel' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmitx({
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
<?php $this->load->view('footer-meta');?>
<?php $this->load->view('footer');?>
</body>
</html>