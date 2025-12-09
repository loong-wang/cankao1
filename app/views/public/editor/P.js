$(function(){	
	var editor = $('#post_content').FoxEditor({
		pasteUrl: baseurl+"index.php/upload/upload_filest/",
		htmlsUrl: baseurl+"index.php/upload/upload_filess/",
		uploadUrl: baseurl+"index.php/upload/upload_filesd/",
		'menuConfig': [
			//['viewSourceCode'],
			['bold', 'foreColor', 'createLink', 'unLink', 'insertExpression','insertImage', 'insertVideo']
		],
		//配置多组表情
		'expressions': [{
			'title': '默认',
			'items': [
				baseurl+'static/common/editor/em/default/1.gif',
				baseurl+'static/common/editor/em/default/2.gif',
				baseurl+'static/common/editor/em/default/3.gif',
				baseurl+'static/common/editor/em/default/4.gif',
				baseurl+'static/common/editor/em/default/5.gif',
				baseurl+'static/common/editor/em/default/6.gif',
				baseurl+'static/common/editor/em/default/7.gif',
				baseurl+'static/common/editor/em/default/8.gif',
				baseurl+'static/common/editor/em/default/9.gif',
				baseurl+'static/common/editor/em/default/10.gif',
				baseurl+'static/common/editor/em/default/11.gif',
				baseurl+'static/common/editor/em/default/12.gif',
				baseurl+'static/common/editor/em/default/13.gif',
				baseurl+'static/common/editor/em/default/14.gif',
				baseurl+'static/common/editor/em/default/15.gif',
				baseurl+'static/common/editor/em/default/16.gif',
				baseurl+'static/common/editor/em/default/17.gif',
				baseurl+'static/common/editor/em/default/18.gif',
				baseurl+'static/common/editor/em/default/19.gif',
				baseurl+'static/common/editor/em/default/20.gif'
			]
		},{
			'title': '金星',
			'items': [
				baseurl+'static/common/editor/em/jinxing/1.gif',
				baseurl+'static/common/editor/em/jinxing/2.gif',
				baseurl+'static/common/editor/em/jinxing/3.gif',
				baseurl+'static/common/editor/em/jinxing/4.gif',
				baseurl+'static/common/editor/em/jinxing/5.gif',
				baseurl+'static/common/editor/em/jinxing/6.gif'
			]
		},{
			'title': '卖萌海狮',
			'items': [
				baseurl+'static/common/editor/em/sealion/1.gif',
				baseurl+'static/common/editor/em/sealion/2.gif',
				baseurl+'static/common/editor/em/sealion/3.gif',
				baseurl+'static/common/editor/em/sealion/4.gif',
				baseurl+'static/common/editor/em/sealion/5.gif',
				baseurl+'static/common/editor/em/sealion/6.gif'
			]
		}]

	});  // FoxEditor配置 end

	var $inputa = $('#foxinputnone');
	if($inputa.size() || $inputa.length > 0){
		editor.hide();
	}
	$inputa.focus(function(){
		$inputa.hide();
		editor.show();
		editor.focus();
	});
});
