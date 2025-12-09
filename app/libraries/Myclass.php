<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myclass {

	function __construct() {
	$this->ci = & get_instance ();
	}

//生成友好时间形式
function  friendly_date( $from ){
	static $now = NULL;
	$now == NULL && $now = time();
	! is_numeric( $from ) && $from = strtotime( $from );
	$seconds = $now - $from;
	$minutes = floor( $seconds / 60 );
	$hours   = floor( $seconds / 3600 );
	$day     = round( ( strtotime( date( 'Y-m-d', $now ) ) - strtotime( date( 'Y-m-d', $from ) ) ) / 86400 );
	if( $seconds == 0 ){
		return '刚刚';
	}
	if( ( $seconds >= 0 ) && ( $seconds <= 60 ) ){
		return "{$seconds}秒前";
	}
	if( ( $minutes >= 0 ) && ( $minutes <= 60 ) ){
		return "{$minutes}分钟前";
	}
	if( ( $hours >= 0 ) && ( $hours <= 24 ) ){
		return "{$hours}小时前";
	}
	if( ( date( 'Y' ) - date( 'Y', $from ) ) > 0 ) {
		return date( 'Y-m-d', $from );
	}
	
	switch( $day ){
		case 0:
			return date( '今天H:i', $from );
		break;
		
		case 1:
			return date( '昨天H:i', $from );
		break;
		
		default:
			//$day += 1;
			return "{$day} 天前";
		break;
	}
}

	function notice($str)
	{	
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script>'.$str.'</script>';
	}
	
	function from_mobile(){
		$regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
		$regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|meizu|miui|ucweb";
		$regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";    
		$regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
		$regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
		$regex_match.=")/i";  
		
		if(isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) || preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']))){
			return true;
		}
		return false;
	}	

	/**
	 * 文件或目录权限检查函数
	 *
	 * @access          public
	 * @param           string  $file_path   文件路径
	 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
	 *
	 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
	 *                          返回值在二进制计数法中，四位由高到低分别代表
	 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
	 */
	function is_write($file_path)
	{
		/* 如果不存在，则不可读、不可写、不可改 */
		if (!file_exists($file_path))
		{
			return false;
		}
		$mark = 0;
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		{
			/* 测试文件 */
			$test_file = $file_path . '/cf_test.txt';
			/* 如果是目录 */
			if (is_dir($file_path))
			{
				/* 检查目录是否可读 */
				$dir = @opendir($file_path);
				if ($dir === false)
				{
					return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
				}
				if (@readdir($dir) !== false)
				{
					$mark ^= 1; //目录可读 001，目录不可读 000
				}
				@closedir($dir);
				/* 检查目录是否可写 */
				$fp = @fopen($test_file, 'wb');
				if ($fp === false)
				{
					return $mark; //如果目录中的文件创建失败，返回不可写。
				}
				if (@fwrite($fp, 'directory access testing.') !== false)
				{
					$mark ^= 2; //目录可写可读011，目录可写不可读 010
				}
				@fclose($fp);
				@unlink($test_file);
				/* 检查目录是否可修改 */
				$fp = @fopen($test_file, 'ab+');
				if ($fp === false)
				{
					return $mark;
				}
				if (@fwrite($fp, "modify test.\r\n") !== false)
				{
					$mark ^= 4;
				}
				@fclose($fp);
				/* 检查目录下是否有执行rename()函数的权限 */
				if (@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
				@unlink($test_file);
			}
			/* 如果是文件 */
			elseif (is_file($file_path))
			{
				/* 以读方式打开 */
				$fp = @fopen($file_path, 'rb');
				if ($fp)
				{
					$mark ^= 1; //可读 001
				}
				@fclose($fp);
				/* 试着修改文件 */
				$fp = @fopen($file_path, 'ab+');
				if ($fp && @fwrite($fp, '') !== false)
				{
					$mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
				}
				@fclose($fp);
				/* 检查目录下是否有执行rename()函数的权限 */
				if (@rename($test_file, $test_file) !== false)
				{
					$mark ^= 8;
				}
			}
		}
		else
		{
			if (@is_readable($file_path))
			{
				$mark ^= 1;
			}
			if (@is_writable($file_path))
			{
				$mark ^= 14;
			}
		}
		return $mark;
	}


	function get_ip() {
		$url = 'http://iframe.ip138.com/ic.asp';
		if(function_exists('curl_init')){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$a = curl_exec($ch);
		} else
		{
			$a = @file_get_contents($url);
		}
		preg_match('/\[(.*)\]/', $a, $ip);
		return @$ip[1];
	}
	//

function get_domain($url){ 
	$host=$url?$url:@$_SERVER[HTTP_HOST]; 
	$host=strtolower($host); 
	if(strpos($host,'/')!==false){ 
		$parse = @parse_url($host); 
		$host = $parse['host']; 
	}
	$topleveldomaindb=array('com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me','cn','tv','in','hk','de','us','tw');
	$str=''; 
	foreach($topleveldomaindb as $v){ 
		$str.=($str ? '|' : '').$v;
	} 
	$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
	if(preg_match("/".$matchstr."/ies",$host,$matchs)){ 
		$domain=$matchs['0'];
	}else{ 
		$domain=$host; 
	}
	return $domain; 
}

/*
* 功能:PHP图片水印 (水印支持图片或文字)
* 参数:
* $groundImage 背景图片,即需要加水印的图片,暂只支持GIF,JPG,PNG格式;
* $waterPos 水印位置,有10种状态,0为随机位置;
* 1为顶端居左,2为顶端居中,3为顶端居右;
* 4为中部居左,5为中部居中,6为中部居右;
* 7为底端居左,8为底端居中,9为底端居右;
* $waterImage 图片水印,即作为水印的图片,暂只支持GIF,JPG,PNG格式;
* $waterText 文字水印,即把文字作为为水印,支持ASCII码,不支持中文;
* $textFont 文字大小,值为1、2、3、4或5,默认为5;
* $textColor 文字颜色,值为十六进制颜色值,默认为#FF0000(红色);
*
* 注意:Support GD 2.0,Support FreeType、GIF Read、GIF Create、JPG 、PNG
* $waterImage 和 $waterText 最好不要同时使用,选其中之一即可,优先使用 $waterImage.
* 当$waterImage有效时,参数$waterString、$stringFont、$stringColor均不生效.
* 加水印后的图片的文件名和 $groundImage 一样.

*/

	function FoximageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000")
	{
	$isWaterImage = FALSE;
	$formatMsg = "暂不支持该文件格式,请用图片处理软件将图片转换为GIF、JPG、PNG格式.";
	//读取水印文件
	if(!empty($waterImage) && file_exists($waterImage))
	{
	$isWaterImage = TRUE;
	$water_info = getimagesize($waterImage);
	$water_w = $water_info[0];//取得水印图片的宽
	$water_h = $water_info[1];//取得水印图片的高
	switch($water_info[2])//取得水印图片的格式
	{
	case 1:$water_im = imagecreatefromgif($waterImage);break;
	case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	case 3:$water_im = imagecreatefrompng($waterImage);break;
	default:die($formatMsg);
	}
	}
	//读取背景图片
	if(!empty($groundImage) && file_exists($groundImage))
	{
	$ground_info = getimagesize($groundImage);
	$ground_w = $ground_info[0];//取得背景图片的宽
	$ground_h = $ground_info[1];//取得背景图片的高
	switch($ground_info[2])//取得背景图片的格式
	{
	case 1:$ground_im = imagecreatefromgif($groundImage);break;
	case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	case 3:$ground_im = imagecreatefrompng($groundImage);break;
	default:die($formatMsg);
	}
	}
	else
	{
	die("需要加水印的图片不存在!");
	}
	//水印位置
	if($isWaterImage)//图片水印
	{
	$w = $water_w;
	$h = $water_h;
	$label = "图片的";
	}
	else//文字水印
	{
	$temp = imagettfbbox(ceil($textFont*5.5),0,"/static/font/1.ttf",$waterText);//取得使用 TrueType 字体的文本的范围
	$w = $temp[2] - $temp[6];
	$h = $temp[3] - $temp[7];
	unset($temp);
	$label = "文字区域";
	}
	if( ($ground_w<$w) || ($ground_h<$h) )
	{
	echo "需要加水印的图片的长度或宽度比水印".$label."还小,无法生成水印!";
	return;
	}
	switch($waterPos)
	{
	case 0://随机
	$posX = rand(0,($ground_w - $w));
	$posY = rand(0,($ground_h - $h));
	break;
	case 1://1为顶端居左
	$posX = 0;
	$posY = 0;
	break;
	case 2://2为顶端居中
	$posX = ($ground_w - $w) / 2;
	$posY = 0;
	break;
	case 3://3为顶端居右
	$posX = $ground_w - $w;
	$posY = 0;
	break;
	case 4://4为中部居左
	$posX = 0;
	$posY = ($ground_h - $h) / 2;
	break;
	case 5://5为中部居中
	$posX = ($ground_w - $w) / 2;
	$posY = ($ground_h - $h) / 2;
	break;
	case 6://6为中部居右
	$posX = $ground_w - $w;
	$posY = ($ground_h - $h) / 2;
	break;
	case 7://7为底端居左
	$posX = 0;
	$posY = $ground_h - $h;
	break;
	case 8://8为底端居中
	$posX = ($ground_w - $w) / 2;
	$posY = $ground_h - $h;
	break;
	case 9://9为底端居右
	$posX = $ground_w - $w;
	$posY = $ground_h - $h;
	break;
	default://随机
	$posX = rand(0,($ground_w - $w));
	$posY = rand(0,($ground_h - $h));
	break;
	}
	//设定图像的混色模式
	imagealphablending($ground_im, true);
	if($isWaterImage)//图片水印
	{
	imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件
	}
	else//文字水印
	{
	if( !empty($textColor) && (strlen($textColor)==7) )
	{
	$R = hexdec(substr($textColor,1,2));
	$G = hexdec(substr($textColor,3,2));
	$B = hexdec(substr($textColor,5));
	}
	else
	{
	die("水印文字颜色格式不正确!");
	}
	imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));
	}
	//生成水印后的图片
	@unlink($groundImage);
	switch($ground_info[2])//取得背景图片的格式
	{
	case 1:imagegif($ground_im,$groundImage);break;
	case 2:imagejpeg($ground_im,$groundImage);break;
	case 3:imagepng($ground_im,$groundImage);break;
	default:die($errorMsg);
	}
	//释放内存
	if(isset($water_info)) unset($water_info);
	if(isset($water_im)) imagedestroy($water_im);
	unset($ground_info);
	imagedestroy($ground_im);
	}
	
	function foxgetImgs($content,$order='ALL'){
		$pattern="/src=\"\/?(.*?)\"/";
		preg_match_all($pattern,$content,$match);
		if(isset($match[1])&&!empty($match[1])){
			if(strpos($match[1][0],'.jpg')||strpos($match[1][0],'.jpeg')||strpos($match[1][0],'.gif')||strpos($match[1][0],'.png')){
				if($order==='ALL'){				
					return $match[1];
				}
				if(is_numeric($order)&&isset($match[1][$order])){
					return $match[1][$order];
				}
			}
		}
	}
	
	function FoxNewgetImgs($content,$order='ALL'){
		$pattern="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg]|\.jpeg]|\.png]))[\'|\"].*?[\/]?>/i";
		preg_match_all($pattern,$content,$match);
		if(isset($match[1])&&!empty($match[1])){
			if($order==='ALL'){
				return $match[1];
			}
			if(is_numeric($order)&&isset($match[1][$order])){
				return $match[1][$order];
			}
		}
		return '';
	}
	
	function makeThumbnail($srcImgPath,$targetImgPath,$targetW=10,$targetH=10,$bDengbi=true){
		 $imgSize = GetImageSize($srcImgPath);
		 $imgType = $imgSize[2];
		 //使函数不向页面输出错误信息
		 switch ($imgType)
		{
		  case 1:
			$srcImg = @ImageCreateFromGIF($srcImgPath);
			break;
		  case 2:
			$srcImg = @ImageCreateFromJpeg($srcImgPath);
			break;
		  case 3:
			$srcImg = @ImageCreateFromPNG($srcImgPath);
			break;
		}
		 //取源图象的宽高
		$srcW = ImageSX($srcImg);
		$srcH = ImageSY($srcImg);
		if($srcW>$targetW || $srcH>$targetH)
		{
		  if($bDengbi){//等比压缩
			if($targetW>10){//定宽
			  $targetH = $srcH*$targetW/$srcW;
			}else if($targetH>10){//定高
			  $targetW = $srcW*$targetH/$srcH;
			}else{
			return false;
			}
			if($targetH<11 ||$targetW<11) return false;
		  }//end
		  $targetX = 0;
		  $targetY = 0;
		  if ($srcW > $srcH)
		  {
			$finaW=$targetW;
			$finalH=round($srcH*$finaW/$srcW);
			$targetY=floor(($targetH-$finalH)/2);
		  }
		  else
		  {
			$finalH=$targetH;
			$finaW=round($srcW*$finalH/$srcH);
			$targetX=floor(($targetW-$finaW)/2);
		  }
		   //function_exists 检查函数是否已定义
		   //ImageCreateTrueColor 本函数需要GD2.0.1或更高版本
		  if(function_exists("ImageCreateTrueColor"))
		  {
			$targetImg=ImageCreateTrueColor($targetW,$targetH);
		  }
		  else
		   {
			$targetImg=ImageCreate($targetW,$targetH);
		  }
		  $targetX=($targetX<0)?0:$targetX;
		  $targetY=($targetX<0)?0:$targetY;
		  $targetX=($targetX>($targetW/2))?floor($targetW/2):$targetX;
		  $targetY=($targetY>($targetH/2))?floor($targetH/2):$targetY;
		  //背景颜色默认白色
		  $white = ImageColorAllocate($targetImg, 255,255,255);
		  ImageFilledRectangle($targetImg,0,0,$targetW,$targetH,$white);
		  /*
			  PHP的GD扩展提供了两个函数来缩放图象：
			  ImageCopyResized 在所有GD版本中有效，其缩放图象的算法比较粗糙，可能会导致图象边缘的锯齿。
			  ImageCopyResampled 需要GD2.0.1或更高版本，其像素插值算法得到的图象边缘比较平滑，
								   该函数的速度比ImageCopyResized慢。
		  */
		  if(function_exists("ImageCopyResampled"))
		  {
			ImageCopyResampled($targetImg,$srcImg,$targetX,$targetY,0,0,$finaW,$finalH,$srcW,$srcH);
		  }
		  else
		  {
			ImageCopyResized($targetImg,$srcImg,$targetX,$targetY,0,0,$finaW,$finalH,$srcW,$srcH);
		  }
		   switch ($imgType) {
			case 1:
			  ImageGIF($targetImg,$targetImgPath);
			  break;
			case 2:
			  ImageJpeg($targetImg,$targetImgPath);
			  break;
			case 3:
			  ImagePNG($targetImg,$targetImgPath);
			  break;
		  }
		  ImageDestroy($srcImg);
		  ImageDestroy($targetImg);
		}
		 else //不超出指定宽高则直接复制
		{
		  copy($srcImgPath,$targetImgPath);
		  ImageDestroy($srcImg);
		}
   }


}

/* End of file Myclass.php */