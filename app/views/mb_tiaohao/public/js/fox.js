function toNext(){
    var txts=$("#jqss_in input:text");
    txts.bind("keyup",function(){
        txts.eq(txts.index($(this))+1).focus()
    }).bind("click",function(){$(this).select()});
}
function gopage(url){
    if($("#p").val()==""||isNaN($("#p").val())){
		layer.msg('请填写页数!并且只能是数字', {icon: 6,shade: [0.8, '#393D49'],time: 5000,shift:1}); 
        $("#p").focus();
        return;
    }
    location.href=url+$("#p").val();
}
$(function () {
	 $("body div").click(function () {
        $(this).closest('form').find(".input-help").remove();
        $(this).closest('form').find('.form-group').removeClass("check-error");
        $(this).closest('form').find('.form-group').removeClass("check-success");
    });
	$("#loginsubmit").click(function() {
		$("#loginform").ajaxSubmit(function() {
			$("#logindiv").html('<button class="button button-block bg-gray text-big" id="loginsubmin" type="submit"><span class="icon-spinner rotate"></span> 努力登陆中</button>');
			$('#loginform').submit();
		});
	});
	$("#registersubmit").click(function() {
		$("#registerform").ajaxSubmit(function() {
			$("#registerdiv").html('<button class="button button-block bg-gray text-big" id="registersubmin" type="submit"><span class="icon-spinner rotate"></span> 正在注册中</button>');
			$('#registerform').submit();
		});
	});

});
function PreviewImage(obj, imgPreviewId, divPreviewId) {
	var allowExtention = ".jpg,.bmp,.gif,.png"; //,允许上传文件的后缀名
	var extention = obj.value.substring(obj.value.lastIndexOf(".") + 1).toLowerCase();
	var browserVersion = window.navigator.userAgent.toUpperCase();
	$("#imgdiv").removeClass("hidden");
	if (allowExtention.indexOf(extention) > -1) {
		if (browserVersion.indexOf("MSIE") > -1) {
			if (browserVersion.indexOf("MSIE 6.0") > -1) {//ie6
				document.getElementById(imgPreviewId).setAttribute("src", obj.value);
			} else {//ie[7-8]、ie9
				obj.select();
				var newPreview = document.getElementById(divPreviewId + "New");
				if (newPreview == null) {
					newPreview = document.createElement("div");
					newPreview.setAttribute("id", divPreviewId + "New");
					newPreview.style.width = 160;
					newPreview.style.height = 170;
					newPreview.style.border = "solid 1px #d2e2e2";
				}
				newPreview.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale',src='" + document.selection.createRange().text + "')";
				var tempDivPreview = document.getElementById(divPreviewId);
				tempDivPreview.parentNode.insertBefore(newPreview, tempDivPreview);
				tempDivPreview.style.display = "none";
			}
		} else if (browserVersion.indexOf("FIREFOX") > -1) {//firefox
			var firefoxVersion = parseFloat(browserVersion.toLowerCase().match(/firefox\/([\d.]+)/)[1]);
			if (firefoxVersion < 7) {//firefox7以下版本
				document.getElementById(imgPreviewId).setAttribute("src", obj.files[0].getAsDataURL());
			} else {//firefox7.0+                    
				document.getElementById(imgPreviewId).setAttribute("src", window.URL.createObjectURL(obj.files[0]));
			}
		} else if (obj.files) {
			//兼容chrome、火狐等，HTML5获取路径                   
			if (typeof FileReader !== "undefined") {
				var reader = new FileReader();
				reader.onload = function (e) {
					document.getElementById(imgPreviewId).setAttribute("src", e.target.result);
				}
				reader.readAsDataURL(obj.files[0]);
			} else if (browserVersion.indexOf("SAFARI") > -1) {
				alert("暂时不支持Safari浏览器!");
			}
		} else {
			document.getElementById(divPreviewId).setAttribute("src", obj.value);
		}
	} else {
		alert("仅支持" + allowSuffix + "为后缀名的文件!");
		obj.value = ""; //清空选中文件
		if (browserVersion.indexOf("MSIE") > -1) {
			obj.select();
			document.selection.clear();
		}
		obj.outerHTML = obj.outerHTML;
	}
}
//COOKIE操作
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
$(function () {
	var x = $(".haoma-shaixuan");	
	x.find("dd").click(function() {
		//$(this).toggleClass("on").parents('.haoma-shaixuan').siblings('.haoma-shaixuan').find('dd').removeClass('on');
		$(this).toggleClass("on");
	}), x.find(".on").each(function() {
		//var b = $(this),
		//	c = b.text();
	});
});
//样式
function lie_type(a,b){
	var c = readCookie('style');
	if (c) switchStylestyle(a);
	window.location.reload();
}
function switchStylestyle(styleName)
{
	createCookie('numlist', styleName, 365);
}
function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name)
{
	createCookie(name,"",-1);
}
function intlie(){
	var c = readCookie('numlist');
	if(c){
		if (c) switchStylestyle(c);
		$('.num-list').addClass(c);
	}else{
		$('.num-list').addClass('num-list');
	}
	if(c=='num-list'){
		$('#type-a span').addClass('text-red');
	}else{
		$('#type-b span').addClass('text-red');
	}
}
(function($)
{
	$(document).ready(function() {
		intlie();
	});
})(jQuery);
// /cookie functions