<?php
header("Content-type:text/html;charset=utf-8");
require_once(dirname(__FILE__) . "/../core/init.php");
$time_start = helper :: getmicrotime(); //开始时间

require_once("WxPayPubHelper.php");

if (isset($_POST['WIDout_trade_no'])){
        //商户订单号
        $out_trade_no = $_POST['WIDout_trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = $_POST['WIDsubject'];
        //必填
        //付款金额
        $total_fee = $_POST['WIDtotal_fee'];
        //必填
        //订单描述

        $body = $_POST['WIDbody'];
//print_r($_POST);

$unifiedOrder = new UnifiedOrder_pub();
$unifiedOrder->setParameter("body",$subject);//商品描述
$total_fee=$total_fee*100;
//$total_fee=1;
$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
$unifiedOrder->setParameter("total_fee",$total_fee);//总金额
$unifiedOrder->setParameter("notify_url",WxPayConf_pub::$NOTIFY_URL);//通知地址 
$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
//非必填参数，商户可根据实际情况选填
//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
//$unifiedOrder->setParameter("device_info","XXXX");//设备号 
//$unifiedOrder->setParameter("attach","XXXX");//附加数据 
//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
//$unifiedOrder->setParameter("openid","XXXX");//用户标识
//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

//获取统一支付接口结果
$unifiedOrderResult = $unifiedOrder->getResult();
//print_r($unifiedOrderResult);
//exit;
//商户根据实际情况设置相应的处理流程
if ($unifiedOrderResult["return_code"] == "FAIL") 
{
	//商户自行增加处理流程
	echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
}
elseif($unifiedOrderResult["result_code"] == "FAIL")
{
	//商户自行增加处理流程
	echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
	echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
}
elseif($unifiedOrderResult["code_url"] != NULL)
{

	//从统一支付接口获取到code_url
	 $code_url = $unifiedOrderResult["code_url"];
	 $url=$code_url;
	//echo 'xx';
	 //header("location:".$code_url);
	// print_r($config);
	require_once("native_dynamic_qrcode1.php");
}

}else{
echo "非法访问";
}






?>
