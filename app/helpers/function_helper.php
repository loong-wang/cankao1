<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function get_fox_scheid($domain){
	if($_COOKIE['fox_session']){
		return $_COOKIE['fox_session'];
	}elseif($_COOKIE['scheid']){
		return $_COOKIE['scheid'];
	}elseif($_COOKIE['scid']){
		return $_COOKIE['scid'];
	}else{
		$sessions = md5(uniqid(rand()));  
		setcookie('scheid', $sessions, time() + 315360000,'/',$domain);
		setcookie('scid', $sessions, time() + 315360000,'/',$domain);
		return $_COOKIE['scheid'];
	}
}
 

function fox_ch_num($money = 0, $is_round = true, $int_unit = '元', $zheng ='') {
    $chs     = array (0, '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
    $uni     = array ('', '拾', '佰', '仟' );
    $dec_uni = array ('角', '分' );
    $exp     = array ('','万','亿');
    $res     = '';
    // 以 元为单位分割
    $parts   = explode ( '.', $money, 2 );
    $int     = isset ( $parts [0] ) ? strval ( $parts [0] ) : 0;
    $dec     = isset ( $parts [1] ) ? strval ( $parts [1] ) : '';
    // 处理小数点
    $dec_len = strlen ( $dec );
    if (isset ( $parts [1] ) && $dec_len > 2) {
        $dec = $is_round ? substr ( strrchr ( strval ( round ( floatval ( "0." . $dec ), 2 ) ), '.' ), 1 ) : substr ( $parts [1], 0, 2 );
    }
    // number= 0.00时，直接返回 0
    if (empty ( $int ) && empty ( $dec )) {
        return '零';
    }
    
    // 整数部分 从右向左
    for($i = strlen ( $int ) - 1, $t = 0; $i >= 0; $t++) {
        $str = '';
        // 每4字为一段进行转化
        for($j = 0; $j < 4 && $i >= 0; $j ++, $i --) {
            $u   = $int{$i} > 0 ? $uni [$j] : '';
            $str = $chs [$int {$i}] . $u . $str;
        }
        $str = rtrim ( $str, '0' );
        $str = preg_replace ( "/0+/", "零", $str );
        $u2  = $str != '' ? $exp [$t] : '';
        $res = $str . $u2 . $res;
    }
    $dec = rtrim ( $dec, '0' );
    // 小数部分 从左向右
    if (!empty ( $dec )) {
        $res .= $int_unit;
        $cnt =  strlen ( $dec );
        for($i = 0; $i < $cnt; $i ++) {
            $u = $dec {$i} > 0 ? $dec_uni [$i] : ''; // 非0的数字后面添加单位
            $res .= $chs [$dec {$i}] . $u;
        }
        if ($cnt == 1) $res .= $zheng;
        $res = rtrim ( $res, '0' ); // 去掉末尾的0
        $res = preg_replace ( "/0+/", "零", $res ); // 替换多个连续的0
    } else {
        $res .= $int_unit . $zheng;
    }
    return $res;
}
function daxie_month($number){
 $number=substr($number,0,2);
 $arr=array("零","一","二","三","四","五","六","七","八","九");
 if(strlen($number)==1){
  $result=$arr[$number];
  }else{
   if($number==10){
    $result="十";
   }else{
    if($number<20){
    $result="十";
    }else{
    $result=$arr[substr($number,0,1)]."十";
    }
    if(substr($number,1,1)!="0"){
    $result.=$arr[substr($number,1,1)]; 
    }
   }
 }
 return $result."月";
}

function fox_num_three($a,$b,$c){
	return $a>$b?($a>$c?$a:$c):($b>$c?$b:$c);
}

function fox_num_two($a,$b){
	return $a>$b?$a:$b;
}

//链接加
function fox_links($str='') {
    if($str=='' or !preg_match('/(http|www\.|@)/i', $str)) { return $str; }
    $lines = explode("\n", $str); $new_text = '';
    while (list($k,$l) = each($lines)) { 
        // replace links:
        $l = preg_replace("/([ \t]|^)www\./i", "\\1http://www.", $l);
        $l = preg_replace("/([ \t]|^)ftp\./i", "\\1ftp://ftp.", $l);
        $l = preg_replace("/(http:\/\/[^ )\r\n!]+)/i", "<a target=\"\\_blank\" href=\"\\1\">\\1</a>", $l);
        $l = preg_replace("/(https:\/\/[^ )\r\n!]+)/i", "<a target=\"\\_blank\" href=\"\\1\">\\1</a>", $l);
        $l = preg_replace("/(ftp:\/\/[^ )\r\n!]+)/i", "<a target=\"\\_blank\" href=\"\\1\">\\1</a>", $l);
        $l = preg_replace("/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i", "<a target=\"\\_blank\" href=\"mailto:\\1\">\\1</a>", $l);
        $new_text .= $l."\n";
    }
    return $new_text;
}

	function getExcel($fileName,$headArr,$data,$ex,$dates,$savePath){
		if(empty($data) || !is_array($data)){
		die("无数据可导出，请检查是否正确！");
		}
		if(empty($fileName)){
		exit;
		}
		$date = $dates;
		if($ex=='2003'){
			$fileName .= "_{$date}.xls";
		}elseif($ex=='2007'){
			$fileName .= "_{$date}.xlsx";
		}
		require_once(APPPATH.'third_party/PHPExcel.php');
		require_once(APPPATH.'third_party/phpExcel/Writer/Excel2007.php');  
		require_once(APPPATH.'third_party/phpExcel/Writer/Excel5.php'); 
		require_once(APPPATH.'third_party/PHPExcel/IOFactory.php');
		
		//创建新的PHPExcel对象
		$objPHPExcel = new PHPExcel();
		$objProps = $objPHPExcel->getProperties();

		//设置表头
		$key = ord("A");
		foreach($headArr as $v){
		$colum = chr($key);
		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
		$key += 1;
		}

		$column = 2;
		$objActSheet = $objPHPExcel->getActiveSheet();
		foreach($data as $key => $rows){ //行写入
		$span = ord("A");
		foreach($rows as $keyName=>$value){// 列写入
			$j = chr($span);
			$objActSheet->setCellValue($j.$column, $value);
			$span++;
		}
		$column++;
		}
		$objActSheet->getColumnDimension('b')->setWidth(15);//改变此处设置的长度数值 
		$objActSheet->getColumnDimension('e')->setWidth(25);//改变此处设置的长度数值 
		$objActSheet->getColumnDimension('f')->setWidth(20);//改变此处设置的长度数值 

		$fileName = iconv("utf-8", "gb2312", $fileName);
		//重命名表
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		//设置活动单指数到第一个表,所以Excel打开这是第一个表
		$objPHPExcel->setActiveSheetIndex(0);
		//将输出重定向到一个客户端web浏览器(Excel2007)
		if($ex=='2003'){
			  //header('Content-Type: application/vnd.ms-excel; charset=UTF-8');  
			  //header("Content-Disposition: attachment; filename=\"$fileName\"");
			  //header('Cache-Control: max-age=0');  
			  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
		  }elseif($ex=='2007'){
			  //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
			  //header("Content-Disposition: attachment; filename=\"$fileName\"");
			  //header('Cache-Control: max-age=0');
			  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		  }
		$savename=$savePath.$fileName;
		//if(!empty($_GET['excel'])){
		//	$objWriter->save('php://output'); //文件通过浏览器下载
		//}else{
			 $objWriter->save($savename); //脚本方式运行，保存在当前目录
		//}
		return $savename;
		exit;
	}


/**
 * 截取中英混排字符串
 * @param (string) $string
 * @param (int) $length
 * @param (string) $dot
 * @param (string) $charset
 */
function fox_substr( $string, $length, $dot = '..', $charset='utf-8' ) {
	$slen = strlen($string);
    if( $slen <= $length ) {
        return $string;
    }
	if( function_exists( 'mb_substr' ) ) {
		return mb_substr( $string, 0, $length, $charset ) . $dot;
	}
    $strcut = '';
    if(strtolower($charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while($n < $slen) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 1;
            } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 1;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 1;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 1;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 1;
            } else {
                $n++;
            }
            if($noc >= $length) {
                break;
            }
        }
        if($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    
    return $strcut.$dot;
}

/**
 * 清除HTML标记
 *
 * @param	string	$str
 * @return  string
 */
function cleanhtml($str)
{
	$str = strip_tags($str);
	$str = htmlspecialchars($str);
	$str=preg_replace("/\s+/"," ", $str); //过滤多余回车
	 $str = preg_replace("/ /","",$str);
	 $str = preg_replace("/&nbsp;/","",$str);
	 $str = preg_replace("/　/","",$str);
	 $str = preg_replace("/\r\n/","",$str);
	 $str = str_replace(chr(13),"",$str);
	 $str = str_replace(chr(10),"",$str);
	 $str = str_replace(chr(9),"",$str);
	return $str;
}

function check_auth()
{
	$url = 'http://www.kuaiwww.com/authorize/check_auth/'.get_domain();
	if(function_exists('file_get_contents')) {
		$data=file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 5; 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
	}
	$data = json_decode($data);
	return $data->product;
}

//手机号码验证
function checkMobile($mobilephone){
        if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/",$mobilephone)){ 
               return true;
        }else{
                return false;
        } 
}
//邮箱验证类
function validateEmail($email){
$pattern="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";  //[ch]定义验证email正则表达式
       if(preg_match($pattern,$email,$counts)){
               return true;
       }else{
                return false;
       }
 }

 //sms接口相关
 function ihuyi_Post($curlPost,$url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
}

function xml_to_array($xml){
	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
	if(preg_match_all($reg, $xml, $matches)){
		$count = count($matches[0]);
		for($i = 0; $i < $count; $i++){
		$subxml= $matches[2][$i];
		$key = $matches[1][$i];
			if(preg_match( $reg, $subxml )){
				$arr[$key] = xml_to_array( $subxml );
			}else{
				$arr[$key] = $subxml;
			}
		}
	}
	return @$arr;
}
//sms接口相关结束，发送短信
function SendShouji($a,$b,$c,$d,$e){	
	$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";	
	//替换成自己的测试账号,参数顺序和wenservice对应
	$post_data = "account=".$a."&password=".$b."&mobile=".$c."&content=".urlencode($d);
	$gets = '<?xml version="1.0" encoding="utf-8"?><SubmitResult xmlns="http://106.ihuyi.cn/"><code>2</code><msg>提交成功</msg><smsid>67472311</smsid></SubmitResult>';
	$gets = ihuyi_Post($post_data,$target);
	$gets_arr = xml_to_array($gets);
	if ($gets_arr['SubmitResult']['code'] == 2){
		return true;
	}else{
		return false;
	}
}

function get_domain($url=''){
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

	//无编辑器的过滤
	/*function filter_check ($data)
	{
		$pattern="/<pre>(.*?)<\/pre>/si";
		preg_match_all ($pattern, $data, $matches);
		foreach( $matches[1] as $val ){
			@$replace[] = htmlspecialchars($val);
		}
		$data = str_replace($matches[1], @$replace, $data);
		if(!$matches[1]){
			$data = nl2br($data);
		}
		$data = str_replace('</p><br />','</p>',$data);
		return $data = strip_tags($data,"<p> <font> <img> <b> <strong> <br> <pre> <br /> <span>");
	}*/
//无编辑器的过滤
function filter_check ($str)
{
	
	$pattern="/<pre[^>]*>(.*?)<\/pre>/si";
	preg_match_all($pattern, $str, $matches);
	$str=htmlspecialchars_decode($str);
	$str=stripslashes($str);
	if($matches[1]){
		foreach($matches[1] as $v){
			$replace[]= addslashes(htmlspecialchars(trim($v)));
		}
		$str = str_replace($matches[1], $replace, $str);
	} else{
		$str=strip_tags($str,"<img> <pre> <a> <font> <span> <em>");
	}
	$str = nl2br($str);
	
	return $str;
}

//过滤
function filter_code($str)
{
	$str=htmlspecialchars_decode($str);
	$pattern="/<pre[^>]*>(.*?)<\/pre>/si";
	preg_match_all($pattern, $str, $matches);
	if($matches[1]){
		foreach($matches[1] as $v){
			$replace= trim(htmlentities($v));
			$str = str_replace($v, $replace, $str);
		}
		$str =strip_tags($str,"<img> <pre> <a> <font> <span> <em> <p> <b>");
	}else{
		$str =strip_tags($str,"<img> <pre> <a> <font> <span> <em> <p> <b>");
		$str = trim(nl2br($str));
	}
	return $str;
}
	
//$str=stripslashes($str);
/*发送邮件*/
function send_mail($to,$subject,$message)
{
	$ci	= &get_instance();
	$config['protocol']=$ci->config->item('protocol');
	$config['smtp_host']=$ci->config->item('smtp_host');
	$config['smtp_user']=$ci->config->item('smtp_user');
	$config['smtp_pass']=$ci->config->item('smtp_pass');
	$config['smtp_port']=$ci->config->item('smtp_port');
	$config['charset'] = 'utf-8';
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	
	$ci->load->library('email',$config);
	$ci->email->from($config['smtp_user'],'');
	$ci->email->to($to);
	$ci->email->subject($subject.'-'.$ci->config->item('site_name'));
	$ci->email->message($message);
	if($ci->email->send()){
		return true;
	} else
	{
		return false;
	}
}


	function auto_link_pic($str, $type = 'both', $popup = FALSE)
	{
		if ($type != 'email')
		{
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
			{
				$pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i]))
					{
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}
					$img_ext = array('jpg','png','gif','jpeg');
					$file_ext=strtolower(end(explode(".",$matches['0'][$i])));
					if(in_array($file_ext,$img_ext)){
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<img src="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'" alt="">'.
											$period, $str);
					} else {
						$str = str_replace($matches['0'][$i],
											$matches['1'][$i].'<a href="http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'"'.$pop.'>http'.
											$matches['4'][$i].'://'.
											$matches['5'][$i].
											$matches['6'][$i].'</a>'.
											$period, $str);
					}
				}
			}
		}

		if ($type != 'url')
		{
			if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['3'][$i]))
					{
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}


function br2nl($text)
{
	return preg_replace('/<br\\s*?\/??>/i', '', $text);
}
function xss_clean($input_str) {
    $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}

function xss_clean3($str)
{

if (isset($str)){
	$str = trim($str);  //清理空格
	$str = strip_tags($str);   //过滤html标签
	$str = htmlspecialchars($str);   //将字符内容转化为html实体
	$str = addslashes($str);
	return $str;
}


}

//订单号
function build_order_no() {
	mt_srand((double) microtime() * 1000000); 
    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

function get_user_usertx($fen,$num='c') {
require(APPPATH.'config/usertx.php');
 if($fen>=0){
     foreach($userarr as $row){
         if($fen>=$row[0] && $fen<=$row[1]){
			 if ($num=='a'){
				 return $row[0];
			 }elseif ($num=='b'){
				 return $row[1];
			 }else{
				 return $row[2];
			 }
		 } 
	 }
  }
}
/*
 * XSS filter 
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 */

function xss_clean1($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
}

	function randkey($length)
	{
		 $pattern='1234567890abcdefghijklmnopqrstuvwxyz$#&^@!';
		 $key='';
		 for($i=0;$i<$length;$i++)
		 {
		   $key.= $pattern{mt_rand(0,35)};    //生成php随机数
		 }
		 return $key;
	}
	function csrf_hidden(){
		$ci = &get_instance();
		$name = $ci->security->get_csrf_token_name();
		$val = $ci->security->get_csrf_hash();
		echo "<input type=\"hidden\" id=\"$name\" name=\"$name\" value=\"$val\" />";
	}

function get_url_content($url)
{
	if(function_exists('file_get_contents')){
		return file_get_contents($url);
	} elseif(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($ch);
	}
}

/*生成盐salt*/

function get_salt($length=-6){
	return substr(uniqid(rand()), $length);
}

/*生成密码*/

function password_dohash($password,$salt)
{
	$salt=$salt?$salt:get_salt();
	return md5(md5($password).$salt);
}
/*返回信息*/
function show_message($message='', $url='', $status = 2, $heading='提示信息', $time = 1800)
{
    include APPPATH.'views/errors/html/show_message.php';
    exit;
}
function is_mobile(){
    $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
    $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
    $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
    $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
    $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
    $regex_match.=")/i";
    $state=preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
 
    //pc返回0,手机返回1
    return $state;
}
function file_merger($arrFile,$out,$a=1) {
	//$a ：正常1更新2合并
    $static = base_url('app/views/public/');
    $return = base_url('app/views/public/temp/');
    $outs = "app/views/public/temp/";
    $outss = "app/views/public/";
    $time = $_SERVER['REQUEST_TIME'];
     
    if(substr($arrFile[0],-2) == 'js' ) {
         $type = 'js';
    } elseif( substr($arrFile[0],-3) == 'css' ) {
        $type = 'css';
    }    

	if( $a==1 ) {
		$out = '';
		foreach($arrFile as $key => $file) {
			if( $type == 'js' ) {
				$out .= "<script type=\"text/javascript\" src=\"{$static}/js/{$file}\"></script>\n";
			} elseif( $type == 'css' ) {
				$out .= "<link href=\"{$static}/css/{$file}\" rel=\"stylesheet\" type=\"text/css\">\n";
			}
		}
		return $out;
	}if( $a==2 ) {
		$out = '';
		foreach($arrFile as $key => $file) {
			if( $type == 'js' ) {
				$out .= "<script type=\"text/javascript\" src=\"{$static}/js/{$file}?{$time}\"></script>\n";
			} elseif( $type == 'css' ) {
				$out .= "<link href=\"{$static}/css/{$file}?{$time}\" rel=\"stylesheet\" type=\"text/css\">\n";
			}
		}
		return $out;
	} elseif( $a==3 ) {
		if( $type == 'js' ) {
			$out = "<script type=\"text/javascript\" src=\"{$return}/{$out}\"></script>\n";
		} elseif( $type == 'css' ) {
			$out = "<link href=\"{$return}/{$out}\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		return $out;
	} elseif( $a==4 ) {
		ob_start();
		foreach($arrFile as $key => $file) {
			include $outss.$type."/".$file."";
		}
		$str =  ob_get_clean();
		//php程序精简文件
		$str = preg_replace( '#/\*.+?\*/#s','', $str );//过滤注释 /* */
		$str = preg_replace( '#(?<!http:)(?<!\\\\)(?<!\')(?<!")//(?<!\')(?<!").*\n#','', $str );//过滤注释 //
		$str = preg_replace( '#[\n\r\t]+#',' ', $str );//回车 tab替换成空格
		$str = preg_replace( '#\s{2,}#',' ', $str );//两个以上空格合并为一个
		write_file($outs.$out, $str);
		if( $type == 'js' ) {
			$out = "<script type=\"text/javascript\" src=\"{$return}/{$out}?{$time}\"></script>\n";
		} elseif( $type == 'css' ) {
			$out = "<link href=\"{$return}/{$out}?{$time}\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		return $out;
	}
}

////获得本地真实IP
function get_onlineip() {
    $ip='bad ip';
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		return is_ip($_SERVER['HTTP_CLIENT_IP'])?$_SERVER['HTTP_CLIENT_IP']:$ip;
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		return is_ip($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$ip;
	}else{
		return is_ip($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$ip;
	}
}
function is_ip($str){
	$ip=explode('.',$str);
	for($i=0;$i<count($ip);$i++){  
		if($ip[$i]>255){  
			return false;  
		}  
	}  
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',$str);  
     
}
/*补全代码*/
function closetags($html) { 
	// 不需要补全的标签 
	$arr_single_tags = array('meta', 'img', 'br', 'link', 'area'); 
	// 匹配开始标签 
	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result); 
	$openedtags = $result[1]; 
	// 匹配关闭标签 
	preg_match_all('#</([a-z]+)>#iU', $html, $result); 
	$closedtags = $result[1]; 
	// 计算关闭开启标签数量，如果相同就返回html数据 
	$len_opened = count($openedtags); 
	if (count($closedtags) == $len_opened) { 
		return $html; 
	} 
	// 把排序数组，将最后一个开启的标签放在最前面 
	$openedtags = array_reverse($openedtags); 
	// 遍历开启标签数组 
	for ($i = 0; $i < $len_opened; $i++) { 
		// 如果需要补全的标签 
		if (!in_array($openedtags[$i], $arr_single_tags)) { 
		// 如果这个标签不在关闭的标签中 
			if (!in_array($openedtags[$i], $closedtags)) { 
			// 直接补全闭合标签 
				$html .= '</' . $openedtags[$i] . '>'; 
			} else { 
				unset($closedtags[array_search($openedtags[$i], $closedtags)]); 
			} 
		} 
	} 
	return $html; 
}

function strip_url_tags($str)
{
	$str=preg_replace("/<a[^>]*href=[^>]*>|<\/[^a]*a[^>]*>/i","\\2",$str);
	return $str;
}
function decode_format($content)
{
	$STB= &get_instance();
	$STB->load->helper('security');
	$content=strip_url_tags(strip_image_tags($content));
	return $content;
}
function get_tree_array(&$data, $parentId=0)
{
    $category = array();
    foreach ($data as $key=>$value)
    {
        if ($value['pid'] == $parentId)
        {
            unset($data[$key]);
            $value['child'] = category($data, $value['id']);
            $category[] = $value;
        }
    }
    return $category;
}
function get_tree(&$data, $parentId=0)
{
	global $str;
    $str .= '<ul>';
    foreach ($data as $key=>$value)
    {
        if ($value['pid'] == $parentId)
        {
            unset($data[$key]);
            $str.="<li>|--<a href='/'>".$value['name'].'</a></li>';
            get_tree($data, $value['id']);
        }
    }
    $str .= '</ul>';
    return $str;
}

function url($type='',$num='',$any='')
{
	$FOX = &get_instance();
	return $FOX->router->url($type,$num,$any);
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

	function str_len($str)
	{
	    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
	 
	    if ($length)
	    {
	        return strlen($str) - $length + intval($length / 3) * 2;
	    }
	    else
	    {
	        return strlen($str);
	    }
	}

if(!function_exists('array_column')){
    function array_column($input, $columnKey, $indexKey=null){ 
        $columnKeyIsNumber      = (is_numeric($columnKey)) ? true : false; 
        $indexKeyIsNull         = (is_null($indexKey)) ? true : false; 
        $indexKeyIsNumber       = (is_numeric($indexKey)) ? true : false; 
        $result                 = array(); 
        foreach((array)$input as $key=>$row){ 
            if($columnKeyIsNumber){ 
                $tmp            = array_slice($row, $columnKey, 1); 
                $tmp            = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null; 
            }else{ 
                $tmp            = isset($row[$columnKey]) ? $row[$columnKey] : null; 
            } 
            if(!$indexKeyIsNull){ 
                if($indexKeyIsNumber){ 
                    $key        = array_slice($row, $indexKey, 1); 
                    $key        = (is_array($key) && !empty($key)) ? current($key) : null; 
                    $key        = is_null($key) ? 0 : $key; 
                }else{ 
                    $key        = isset($row[$indexKey]) ? $row[$indexKey] : 0; 
                } 
            } 
            $result[$key]       = $tmp; 
        } 
        return $result; 
    } 
}

function is_today($time)
{
	$date = date('Y-m-d',$time);
	$today = date('Y-m-d');
	if($date==$today){
		return TRUE;
	}else{
		return FALSE;
	}

}

//php获取中文字符拼音首字母
function getFirstCharter($str){
    if(empty($str)){return '';}
    $fchar=ord($str{0});
    if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
    $s1=iconv('UTF-8','gb2312',$str);
    $s2=iconv('gb2312','UTF-8',$s1);
    $s=$s2==$str?$s1:$str;
    $asc=ord($s{0})*256+ord($s{1})-65536;
    if($asc>=-20319&&$asc<=-20284) return 'A';
    if($asc>=-20283&&$asc<=-19776) return 'B';
    if($asc>=-19775&&$asc<=-19219) return 'C';
    if($asc>=-19218&&$asc<=-18711) return 'D';
    if($asc>=-18710&&$asc<=-18527) return 'E';
    if($asc>=-18526&&$asc<=-18240) return 'F';
    if($asc>=-18239&&$asc<=-17923) return 'G';
    if($asc>=-17922&&$asc<=-17418) return 'H';
    if($asc>=-17417&&$asc<=-16475) return 'J';
    if($asc>=-16474&&$asc<=-16213) return 'K';
    if($asc>=-16212&&$asc<=-15641) return 'L';
    if($asc>=-15640&&$asc<=-15166) return 'M';
    if($asc>=-15165&&$asc<=-14923) return 'N';
    if($asc>=-14922&&$asc<=-14915) return 'O';
    if($asc>=-14914&&$asc<=-14631) return 'P';
    if($asc>=-14630&&$asc<=-14150) return 'Q';
    if($asc>=-14149&&$asc<=-14091) return 'R';
    if($asc>=-14090&&$asc<=-13319) return 'S';
    if($asc>=-13318&&$asc<=-12839) return 'T';
    if($asc>=-12838&&$asc<=-12557) return 'W';
    if($asc>=-12556&&$asc<=-11848) return 'X';
    if($asc>=-11847&&$asc<=-11056) return 'Y';
    if($asc>=-11055&&$asc<=-10247) return 'Z';
    return null;
}


function Pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
                        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
                        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
                        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
                        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
                        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
                        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
                        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
                        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
                        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
                        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
                        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
                        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
                        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
                        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
                        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
                        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
                        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
                        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
                        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
                        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
                        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
                        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
                        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
                        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
                        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
                        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
                        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
                        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
                        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
                        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
                        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
                        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
                        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
                        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
                        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
                        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
                        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
                        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
                        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
                        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
                        "|-10270|-10262|-10260|-10256|-10254";
        $_TDataKey   = explode('|', $_DataKey);
        $_TDataValue = explode('|', $_DataValue);
        $_Data = array_combine($_TDataKey, $_TDataValue);
        arsort($_Data);
        reset($_Data);
        if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String);
        $_Res = '';
        for($i=0; $i<strlen($_String); $i++) {
                $_P = ord(substr($_String, $i, 1));
                if($_P>160) {
                        $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
                }
                $_Res .= _Pinyin($_P, $_Data);
        }
        return preg_replace("/[^a-z0-9]*/", '', $_Res);
}
function _Pinyin($_Num, $_Data){
        if($_Num>0 && $_Num<160 ){
                return chr($_Num);
        }elseif($_Num<-20319 || $_Num>-10247){
                return '';
        }else{
                foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
                return $k;
        }
}
function _U2_Utf8_Gb($_C){
        $_String = '';
        if($_C < 0x80){
                $_String .= $_C;
        }elseif($_C < 0x800) {
                $_String .= chr(0xC0 | $_C>>6);
                $_String .= chr(0x80 | $_C & 0x3F);
        }elseif($_C < 0x10000){
                $_String .= chr(0xE0 | $_C>>12);
                $_String .= chr(0x80 | $_C>>6 & 0x3F);
                $_String .= chr(0x80 | $_C & 0x3F);
        }elseif($_C < 0x200000) {
                $_String .= chr(0xF0 | $_C>>18);
                $_String .= chr(0x80 | $_C>>12 & 0x3F);
                $_String .= chr(0x80 | $_C>>6 & 0x3F);
                $_String .= chr(0x80 | $_C & 0x3F);
        }
        return iconv('UTF-8', 'GB2312', $_String);
}

 function array_unique_fb($array2D){
	 foreach ($array2D as $v){
		 $v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
		 $temp[] = $v;
	 }
	 $temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
	foreach ($temp as $k => $v){
		$temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
	}
	return $temp;
}

function assoc_unique($arr, $key)
 {
   $tmp_arr = array();
   foreach($arr as $k => $v)
  {
	 if(in_array($v[$key], $tmp_arr))//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
	{
	   unset($arr[$k]);
	}
  else {
	  $tmp_arr[] = $v[$key];
	}
  }
sort($arr); //sort函数对数组进行排序
return $arr;
}

function unique_arr($array2D,$stkeep=false,$ndformat=true)
{
    // 判断是否保留一级数组键 (一级数组键可以为非数字)
    if($stkeep) $stArr = array_keys($array2D);
    // 判断是否保留二级数组键 (所有二级数组键必须相同)
    if($ndformat) $ndArr = array_keys(end($array2D));
    //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
    foreach ($array2D as $v){
        $v = join(",",$v); 
        $temp[] = $v;
    }
    //去掉重复的字符串,也就是重复的一维数组
    $temp = array_unique($temp); 
    //再将拆开的数组重新组装
    foreach ($temp as $k => $v)
    {
        if($stkeep) $k = $stArr[$k];
        if($ndformat)
        {
            $tempArr = explode(",",$v); 
            foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
        }
        else $output[$k] = explode(",",$v); 
    }
    return $output;
}

function copy_dir($src,$dst) {
  $dir = opendir($src);
  @mkdir($dst);
  while(false !== ( $file = readdir($dir)) ) {
    if (( $file != '.' ) && ( $file != '..' )) {
      if ( is_dir($src . '/' . $file) ) {
        copy_dir($src . '/' . $file,$dst . '/' . $file);
        continue;
      }
      else {
        copy($src . '/' . $file,$dst . '/' . $file);
      }
    }
  }
  closedir($dir);
}

function deldir($dir) {
  //先删除目录下的文件：
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
  
  closedir($dh);
  //删除当前文件夹：
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}

function getAllDirAndFile($path) 
{ 
if(is_file($path)) 
{ 
if(isImage($path)) 
{ 
$str=""; 
$str.='<table style="border:solid 10px #ddd;" width="830">'; 
$str.="<tr>"; 
$path=base_url($path); 
$str.="<td style='background:#f3f3f3;' width=830><img src=".$path."></td>"; 
$str.="</tr>"; 
$str.="</table>"; 
echo $str; 
} 
} 
else 
{ 
$resource=opendir($path); 
while ($file=readdir($resource)) 
{ 
if($file!="." && $file!="..") 
{ 
getAllDirAndFile($path."/".$file); 
} 
} 
} 
} 

function isImage($filePath) 
{ 
$fileTypeArray=array("jpg","png","bmp","jpeg","gif","ico"); 
$filePath=strtolower($filePath); 
$lastPosition=strrpos($filePath,"."); 
$isImage=false; 
if($lastPosition>=0) 
{ 
$fileType=substr($filePath,$lastPosition+1,strlen($filePath)-$lastPosition); 
if(in_array($fileType,$fileTypeArray)) 
{ 
$isImage=true; 
} 
} 
return $isImage; 
}

/* End of file function_helper.php */
/* Location: ./system/helpers/function_helper.php */