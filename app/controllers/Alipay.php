<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alipay extends FOX_controller
{

	function __construct ()
	{
		parent::__construct();
		$this->config->load('payset');
        $this->load->helper('url');	
		$this->load->model ('city_m');

		$this->alipay_config['seller_emaill']=$this->config->item('ali_payemail');
		$this->alipay_config['partner'] = $this->config->item('ali_payid'); 
		$this->alipay_config['key'] = $this->config->item('ali_paykey'); 
		$this->alipay_config['sign_type'] = strtoupper('MD5'); 
		$this->alipay_config['input_charset'] = strtolower('utf-8'); 
		$this->alipay_config['cacert'] = APPPATH.'third_party/alipay/cacert.pem'; 
		$this->alipay_config['transport'] = 'http';
	}
	
	public function jishi_alipay($cityid,$cnum,$chao)
	{
		//cnum为金额,$chao为订单号,
		header("Content-type:text/html;charset=utf-8");
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');
		if(isset($cnum)&&isset($chao)){
			$parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($this->alipay_config['partner']),
            "payment_type"    => '1',
            "notify_url"    => site_url('alipay/do_notify'),
            "return_url"    => site_url('alipay/do_return'),
            "seller_email"    => trim($this->alipay_config['seller_emaill']),//支付宝帐户,
            "out_trade_no"    => trim($chao),//商户订单号
            "subject"    => '在线付款',//订单名称
            "total_fee"    => $cnum,//必填,付款金额
            "body"    => '在线付款',//必填,订单描述
            "show_url"    => site_url(),//商品展示地址
            "anti_phishing_key"    => '',//防钓鱼时间戳
            "exter_invoke_ip"    => '',//客户端的IP地址
            "_input_charset"    => trim(strtolower($this->alipay_config['input_charset']))
			);		

		//print_r($parameter);die();
		
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
		}
    }
	
	public function shuang_alipay($cityid,$cnum,$chao)
	{
		//cnum为金额,$chao为订单号,
		header("Content-type:text/html;charset=utf-8");
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');
		if(isset($cnum)&&isset($chao)){
			$parameter = array(
				"service" => "trade_create_by_buyer", //交易类型，必填实物交易＝trade_create_by_buyer（需要填写物流）
				"partner" => $this->alipay_config['partner'],                                               //合作商户号
				"return_url" =>site_url('alipay/do_notify'),  //同步返回
				"notify_url" =>site_url('alipay/do_return'),  //异步返回
				"_input_charset" => $this->alipay_config['input_charset'],                                //字符集，默认为GBK
				"subject" => "在线付款",                                                //商品名称，必填
				"body" => "在线付款",                                           //商品描述，必填
				"out_trade_no" => $chao,                      //商品外部交易号，必填,每次测试都须修改
				"logistics_fee"=>'0.00',                       //物流配送费用
				"logistics_payment"=>'BUYER_PAY',               // 物流配送费用付款方式：SELLER_PAY(卖家支付)、BUYER_PAY(买家支付)、BUYER_PAY_AFTER_RECEIVE(货到付款)
				"logistics_type"=>'EXPRESS',                    // 物流配送方式：POST(平邮)、EMS(EMS)、EXPRESS(其他快递)
				"price" => $cnum,                                 //商品单价，必填
				"payment_type"=>"1",                               // 默认为1,不需要修改
				"quantity" => "1",                                 //商品数量，必填
				"show_url" => site_url(),            //商品相关网站
				"seller_email" => $this->alipay_config['seller_emaill']                //卖家邮箱，必填
			);		

		//print_r($parameter);die();
		
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
		}
    }
	
	
	
	function do_notify(){
        header("Content-type:text/html;charset=utf-8");
		require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
 
    }
 
    function do_return(){
        header("Content-type:text/html;charset=utf-8");
		require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        
        //商户订单号
        $out_trade_no = $_GET['out_trade_no']; 
        //支付宝交易号
        $trade_no = $_GET['trade_no']; 
        //交易状态
        $trade_status = $_GET['trade_status'];
		
        if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
			$userdingdan=$this->db->select('*')->get_where('dingdan',array('dan_chao'=>$out_trade_no))->row_array();			
			$this->db->set('dan_hao_lock_queren',1)->set('dan_hao_lock_zhifu',1)->where('dan_hao',$userdingdan['dan_hao'])->update('dingdan_list');
            show_message('付款成功',site_url('cart/alldingdan/'.$userdingdan['dan_city']),1);
        }else {
            echo "trade_status=".$_GET['trade_status'];
        }
		show_message('验证成功',site_url('/'),1);
        //echo "验证成功<br />";
 
    }
	

	
}