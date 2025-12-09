<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?></title>
<style>body{font-size:14px;line-height:200%;margin:0;padding:0;font-family:Arial;color:#666;}</style>
</head>
<body class="no-skin">
<?php 
if($page>0){	
	echo '正在导入序列：<font color=red>'.$page.'</font>，总计 <font color=blue>'.$pages.'</font>，请耐心等待完成';
	echo ('<script type="text/javascript" language="javascript"> setTimeout(function(){window.location.href="' . $location . '";},6000);</script>');
}else{
	echo '恭喜，导入完成';
	echo ('<script type="text/javascript" language="javascript">parent.document.getElementById("daoru").style="display:none;";parent.document.getElementById("godaoru").style="display:;";</script>');
	$hao_excel=str_replace('fox','/',$hao_excel);
	if(file_exists(FCPATH.$hao_excel)){
		unlink(FCPATH.$hao_excel);
	}
}
?>
</body>
</html>
