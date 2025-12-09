<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head lang="zh">
<meta charset="utf-8" />
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="yes" name="apple-touch-fullscreen"/>
<meta content="telephone=no" name="format-detection"/>
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="#ffffff" name="msapplication-TileColor" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<title><?php echo $title;?></title>
<link rel="stylesheet" href="/public/css/name.css"/>
<script type="text/javascript" src="/public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/public/js/ajaxfileupload.min.js"></script>
<script type="text/javascript">
var baseurl='<?php echo base_url()?>';
var siteurl='<?php echo site_url()?>';
var sitedomain='<?php echo get_domain()?>';
var sitecityid='<?php echo $citys['cid'];?>';
</script>
<script>

var order_id = "<?php echo $fox_scheid;?>" ;
$(function(){


var isReady = 1;

// 上传表单发生变化
$("#file_1,#file_2,#file_3").change(function(e){
	var domId = this.id;
	var tail = domId.substring(domId.length - 1);
	try 
	{
		jQuery.preView(e, "preview_" + tail,function(data){
			$("#up_" + tail).hide();
			$("#preview_" +tail).hide();
			$("#watermark_" +tail).hide();
			$("#upover_" + tail).show();		
		});
				
	} catch(e){
				
		$("#up_" + tail).hide();
		$("#upover_" + tail).show();
		isReady+=tail;
	}
});

// 演示图片
$("#preview_1,#preview_2,#preview_3").bind("load", function(){
	var isNew = $(this).attr("isNew");
	if ( isNew && isNew == "1" ) {
	
		var domId = this.id;
		var tail = domId.substring(domId.length - 1);
				
		jQuery.preViewCompress(this, 512000, 800, function(){
			$("#preview_" +tail).show();
			$("#watermark_" +tail).show();
			isReady+=tail;
		});
	}
});

// 上传按钮
$(".nu-upload").click(function(){


	// 校验
	if (!file_1.value || file_1.value == "" ) {
		alert("点击添加身份证正面照片");
		return false;
	}
	if (!file_2.value || file_2.value == "" ) {
		alert("点击添加身份证反面照片");
		return false;
	}
	if (!file_3.value || file_3.value == "" ) {
		alert("点击添人证合一照片");
		return false;
	}
	//if ( isUploading == 1) {
	//	return false;
	//} else {
		isUploading = 1;

		$("div[name='infos']").hide();
		$("#uping").show();
		ajaxFileUpload("file_1");

	//}
});

// 返回信息
function succOrfail( isSucc, errorCode, errorMsg ) {

	var msg = "";
		
	if ( errorCode == 1 ) {
		msg = "图片大小不可超过5M";
	} else if ( errorCode == 2 ) {
		msg = "图片格式错误，照片支持jpg/jpeg/bmp格式";
	} else if ( errorCode == 3 || errorCode == 4 ) {
		msg = errorMsg;
	}
   		
	if ( isSucc ) {

		$("div[name='infos']").hide();
		$("#upok").show();

		setTimeout(function(){

			$("body>div").hide();
			$("#upsucc").show();
				
		}, 3000 );
			
	} else {

		$("div[name='infos']").hide();
		$("#upfailtext").html(msg);
		$("#upfail").show();

		setTimeout(function(){

			var colosTag = $("#upfail").attr("close");

			if ( colosTag && colosTag != "" ) {
				closeMe();
			} else {
				$("div[name='infos']").hide();
				isUploading = 0;
				$("#uppre").show();
			}
		 		
		}, 3000 );
	}
}

// 替换
$(".ia-tip").click(function(){
	var domId = this.id;
	var tail = domId.substring(domId.length - 1);
	$("#up_" + tail).show();
	$("#upover_" + tail).hide();

	$("#preview_" + tail).attr("src","");
		
	isReady-=tail;
	$("#file_" + tail).replaceWith($("#file_" + tail).clone(true));		
});

// 上传
function ajaxFileUpload(_fileID) {
	$.ajaxFileUpload({
        url: baseurl+"index.php/upload/upload_mbrenzbs/<?php echo $fox_scheid;?>/"+ _fileID,
		secureuri: false, //是否需要安全协议，一般设置为false
		fileElementId: _fileID, //文件上传域的ID
		data: { "<?php echo $csrf_name;?>":"<?php echo $csrf_token;?>"},
		dataType: 'json', //返回值类型 一般设置为json
		success: function (data)  //服务器成功响应处理函数
		{
			if(_fileID == "file_3")
			{
				succOrfail(true, 4, "请在电脑上点击“我已上传图片”按钮确认");
			}
			else if(_fileID == "file_2")
			{
				ajaxFileUpload("file_3");
			}
			else{
				ajaxFileUpload("file_2");
			}
			return true;
		},
		error: function (data)//服务器响应失败处理函数
		{
	        succOrfail(false);
		}
	})
}


function succOrfail( isSucc, errorCode, errorMsg ) {

	var msg = "";
   		
	if ( isSucc ) {

		$("div[name='infos']").hide();
		$("#upok").show();
		setTimeout(function(){
			$("body>div").hide();
			$("#upsucc").show();
		}, 3000 );

	} else {

		$("div[name='infos']").hide();
		$("#upfailtext").html(msg);
		$("#upfail").show();
		setTimeout(function(){
			var colosTag = $("#upfail").attr("close");
			if ( colosTag && colosTag != "" ) {
		 			//closeMe();
			} else {
				$("div[name='infos']").hide();
				isUploading = 0;
				$("#uppre").show();
			}
		 		
		}, 3000 );
	}
}

// end $
});


</script>
<div id="uppre" class="common-wrapper">
	<div class="steps nopd">
        <div class="sm-tip">
			您提供的身份信息我们将予以加密保护，保证此证件照片仅用于办理本次入网业务。若上传遇到问题，您也可登录电脑版我们上传照片，祝您购物愉快。
        </div>
    </div>
	
    <div class="m idcard">
        <div class="mc">
            <!-- 添加class，idcard-add-no ,为不可添加状态 -->
            <div id="up_1" class="idcard-add ">
                <a href="javascript:;" class="ia-add">
	            	<input id="file_1" capture="camera" accept="image/*" name="file_1" type="file" style="font-size: 118px;cursor: pointer;position: absolute;right: 0;top: 0; width: 100%; height: 100%;z-index:999;filter:alpha(opacity=0);opacity:0;">点击添加身份证正面照片
	            </a>
            </div>
            <div id="upover_1" class="idcard-add" style="display:none;">
                <a href="javascript:;" class="ia-succ">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <img id="preview_1" src="/public/img/pic1.png" class="idcard-img">
                <div id="watermark_1" class="watermark"></div>
                <i id="change_1" class="ia-tip">更换</i>
            </div>
        </div>
        <div class="mc">
            <!-- 添加class，idcard-add-no ,为不可添加状态 -->
            <div id="up_2" class="idcard-add ">
                <a href="javascript:;" class="ia-add">
                	<input id="file_2" capture="camera" accept="image/*" name="file_2" type="file" style="font-size: 118px;cursor: pointer;position: absolute;right: 0;top: 0; width: 100%; height: 100%;z-index:999;filter:alpha(opacity=0);opacity:0;">点击添加身份证反面照片
                </a>
            </div>
            <div id="upover_2" class="idcard-add" style="display:none;">
                <a href="javascript:;" class="ia-succ">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <img id="preview_2" src="/public/img/pic2.png" class="idcard-img">
                <div id="watermark_2" class="watermark"></div>
                <i id="change_2" class="ia-tip">更换</i>
            </div>
        </div>

        <div class="mc">
            <!-- 添加class，idcard-add-no ,为不可添加状态 -->
            <div id="up_3" class="idcard-add ">
                <a href="javascript:;" class="ia-add">
                	<input id="file_3" capture="camera" accept="image/*" name="file_3" type="file" style="font-size: 118px;cursor: pointer;position: absolute;right: 0;top: 0; width: 100%; height: 100%;z-index:999;filter:alpha(opacity=0);opacity:0;">点击添加人证合一照片
                </a>
            </div>
            <div id="upover_3" class="idcard-add" style="display:none;">
                <a href="javascript:;" class="ia-succ">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <img id="preview_3" src="/public/img/pic3.png" class="idcard-img">
                <div id="watermark_3" class="watermark"></div>
                <i id="change_3" class="ia-tip">更换</i>
            </div>
        </div>

    </div>
    <div class="name-upload">
        <a href="javascript:;" class="nu-upload">上传</a>
    </div>
    
</div>
<!-- 上传成功和失败的弹层 -->
<div id="upok" name="infos" class="popup-w" style="display:none;">
    <div class="upload-succ">
        <div class="upload-icon"></div>
        <p>上传成功</p>
    </div>
</div>

<div id="upfail" name="infos" class="popup-w" style="display:none;">
    <div class="upload-fail">
        <div class="upload-icon"></div>
        <p>上传失败</p>
       	<strong id="upfailtext"></strong>
    </div>
</div>

<div id="upsucc" name="infos" class="common-wrapper" style="display:none;">
    <div class="succ-show">
        <span></span>
        <strong>上传成功</strong>
        <p>请继续提交下单，祝您购物愉快~</p>
    </div>

    <section style="font-size:14px;font-family:'Microsoft YaHei';margin:20px 4% 0;white-space: normal;">
	<section style="text-align:center"><img src="/public/img/gz_01.png" alt="" style="width:12em">
        <section style="margin-top:-3.6em;background-color:#d61111;padding:40px 40px 30px;text-align:center;border-radius:5%;">
            <section style="margin:0 0 10px;padding-top:20px;"><span style="color:#fff">手机号码直销专家</span></section>
            <section style="text-align:center;margin-top:16px"><span style="color:#fff">靓号好号，推荐给您的朋友吧</span></section>
        </section>
    </section>
</section>
</div>

<div id="uping" name="infos" class="loading" style="display:none;">
    <div class="loading-in"></div>
</div>
</body>
</html>