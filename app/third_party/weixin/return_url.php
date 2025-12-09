<?php
require_once("WxPayPubHelper.php");
require_once(dirname(__FILE__) . "/../core/init.php");


$dbm = new db_mysql(); //数据库类实例
$c = new common($dbm);
if($_SESSION["usertype"]==1){
	$hyzhekou=HYJB1_ZHEKOU;
}elseif($_SESSION["usertype"]==2){
	$hyzhekou=HYJB2_ZHEKOU;
}elseif($_SESSION["usertype"]==3){
	$hyzhekou=HYJB3_ZHEKOU;
}else{
    $hyzhekou=10;
} 


define ( 'ROOT_PATH', str_replace ( 'return_url.php', '', str_replace ( '\\', '/', __FILE__ ) ) );

function  log_d($word) 
{
	$log_name=ROOT_PATH."logd.txt";
	$fp = fopen($log_name,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,strftime("%Y-%m-%d-%H:%M:%S",time())."  ".$word."\n\r");
	flock($fp, LOCK_UN);
	fclose($fp);
}

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//log_d($postStr);

$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
$out_trade_no = trim($postObj->out_trade_no);
if (empty($out_trade_no)){
	 echo "fail";
}


$orderQuery = new OrderQuery_pub();
$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
$orderQueryResult = $orderQuery->getResult();


if ($orderQueryResult["return_code"] == "FAIL") {
	echo "通信出错：".$orderQueryResult['return_msg']."<br>";
}
elseif($orderQueryResult["result_code"] == "FAIL"){
	echo "错误代码：".$orderQueryResult['err_code']."<br>";
	echo "错误代码描述：".$orderQueryResult['err_code_des']."<br>";
	//echo "fail";exit;
}
else{
	$total_fee_t = $orderQueryResult['total_fee']/100;					
	$out_trade_no=$orderQueryResult['out_trade_no']; 		
	
	
	
	global $dbm, $page; 


	$where = " do_lei=2 and do_id=0 and do_danhao='".$out_trade_no."'";
	$res = $dbm -> single_query(array('where' => $where, 'table_name' => TB_PREFIX . "do_list"));
	if (count($res['list']) > 0){
			$urmb=$res['list'][0]['do_rmb'];
			$user=$res['list'][0]['uid'];
			$sql="update " . TB_PREFIX . "user_list set ujinbi=ujinbi+".$urmb*HY_DH_RMB." WHERE uid='" . $user . "'"; //更新数据
			mysql_query($sql);
			$sql="update " . TB_PREFIX . "do_list set do_id=1 WHERE do_lei=2 and uid=".$user." and do_danhao='".$out_trade_no."'"; //更新数据
			mysql_query($sql);
			userdo_update($user,0,0,"会员充值".$urmb."元换".$urmb*HY_DH_RMB." 金币",0);
	}

	$wheres=" che_hao='".$out_trade_no."' and che_lock=1";
	$b = $c->get_list_che(array('count'=>1, 'order' => ' order by che_update_time desc ','pagesize'=>50,'where'=>$wheres));//print_r($b);
	if (count($b['list']) > 0) {
		$hjia=0;
		$hjias=0;
		foreach ($b['list'] as $v) {
		$hjia+= floor($v['haoma_jiage']*HAO_XISHU);
		$hjias+= $v['haoma_huafei'];
	 }
	 $rmb=floor(($hjia*$hyzhekou)/10)+$hjias;
	}
	$params['table_name'] = TB_PREFIX . "hao_dingdan";
	$params['where'] = " dan_hao='" . $out_trade_no . "' and dan_locks<1 limit 1";
	$admin = $dbm -> single_query($params);
	$adm = $admin['list'];
	//print_r($adm);die();
	if($adm[0]['dan_lock']==0){
		$user=$adm[0]['dan_name'];
		$users=$adm[0]['dan_cook'];
		$sql="update " . TB_PREFIX . "hao_dingdan set dan_locks=1,dan_lock=1 WHERE dan_lock=0 and (dan_name='".$user."' or dan_cook='".$users."') and dan_hao='".$out_trade_no."'"; //更新数据
		mysql_query($sql);
		$sql="update " . TB_PREFIX . "hao_che set dan_qr=1,dan_zf=1 WHERE (che_name='".$user."' or che_cook='".$users."') and che_hao='".$out_trade_no."'"; //更新数据
		mysql_query($sql);
		userdo_update(get_user_id($user),1,1,$rmb,"在线付款，订单号".$out_trade_no."",$out_trade_no,3,helper::getip(),$user);
		 //log_d($postStr);
		 echo "success";exit;
	 }

	
	
	
	
}
echo "fail";exit;
?>