<?php
require_once(dirname(__FILE__) . "/../core/init.php");
$out_trade_no = $_POST['out_trade_no'];
$arr=array('code'=>999,'msg'=>'支付失败');
if(empty($out_trade_no)){
	exit(json_encode($arr));
}
$dbm = new db_mysql(); //数据库类实例
$c = new common($dbm);
$res = $dbm -> query("select * from ".TB_PREFIX . "hao_che where dan_zf=1 and che_hao='".$out_trade_no."'");
//print_r($res);
if (count($res['list']) > 0) {
	$arr=array('code'=>4,'msg'=>'支付成功');
}
exit(json_encode($arr));
?>