$(function(){	
	var editor = $('#post_content').FoxEditor({
		pasteUrl: baseurl+"index.php/upload/upload_filest/",
		htmlsUrl: baseurl+"index.php/upload/upload_filess/",
		uploadUrl: baseurl+"index.php/upload/upload_filesd/",
		'menuConfig': [
			//['viewSourceCode'],
			['bold', 'foreColor', 'createLink', 'unLink']
		],
		//配置多组表情
		'expressions': [{
			'title': '默认',
			'items': [
				baseurl+'uploads/em/default/1.gif',
				baseurl+'uploads/em/default/2.gif',
				baseurl+'uploads/em/default/3.gif',
				baseurl+'uploads/em/default/4.gif',
				baseurl+'uploads/em/default/5.gif',
				baseurl+'uploads/em/default/6.gif',
				baseurl+'uploads/em/default/7.gif',
				baseurl+'uploads/em/default/8.gif',
				baseurl+'uploads/em/default/9.gif',
				baseurl+'uploads/em/default/10.gif',
				baseurl+'uploads/em/default/11.gif',
				baseurl+'uploads/em/default/12.gif',
				baseurl+'uploads/em/default/13.gif',
				baseurl+'uploads/em/default/14.gif',
				baseurl+'uploads/em/default/15.gif',
				baseurl+'uploads/em/default/16.gif',
				baseurl+'uploads/em/default/17.gif',
				baseurl+'uploads/em/default/18.gif',
				baseurl+'uploads/em/default/19.gif',
				baseurl+'uploads/em/default/20.gif'
			]
		},{
			'title': '金星',
			'items': [
				baseurl+'uploads/em/jinxing/1.gif',
				baseurl+'uploads/em/jinxing/2.gif',
				baseurl+'uploads/em/jinxing/3.gif',
				baseurl+'uploads/em/jinxing/4.gif',
				baseurl+'uploads/em/jinxing/5.gif',
				baseurl+'uploads/em/jinxing/6.gif'
			]
		},{
			'title': '卖萌海狮',
			'items': [
				baseurl+'uploads/em/sealion/1.gif',
				baseurl+'uploads/em/sealion/2.gif',
				baseurl+'uploads/em/sealion/3.gif',
				baseurl+'uploads/em/sealion/4.gif',
				baseurl+'uploads/em/sealion/5.gif',
				baseurl+'uploads/em/sealion/6.gif'
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
