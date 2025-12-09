<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wxpay extends FOX_controller
{

	function __construct ()
	{
		parent::__construct();
		$this->config->load('payset');
        $this->load->helper('url');	
		$this->load->library('wxpayset');		
	}
	public function getwxh5t($cityid,$cnum,$chao){
	    //cnum为金额,$chao为订单号,
		header("Content-type:text/html;charset=utf-8");
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		require_once(APPPATH.'third_party/weixin/WxPayPubHelpers.php');
		if(isset($cnum)&&isset($chao)){
			//商户订单号
			$out_trade_no = $chao;
			//商户网站订单系统中唯一订单号，必填
			//订单名称
			$subject = $data['citys']['cname'].$chao.'在线付款';
			//必填
			//付款金额
			$total_fee = $cnum*100;
			//必填
			//订单描述

			$body = $data['citys']['cname'].$chao.'下单付款';
			
			$unifiedOrder = new UnifiedOrder_pub();
			$unifiedOrder->setParameter("body",$subject);//商品描述
		
			$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
			$unifiedOrder->setParameter("total_fee",$total_fee);//总金额
			$unifiedOrder->setParameter("notify_url",$this->wxpayset->wx_config['NOTIFY_URL']);//通知地址 
			$unifiedOrder->setParameter("trade_type","MWEB");//交易类型
			
			$unifiedOrderResult = $unifiedOrder->getResult();
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
			}elseif($unifiedOrderResult["mweb_url"] != NULL){
			    echo '
        			<script language="javascript" type="text/javascript">
                        window.location.href="'.$unifiedOrderResult['mweb_url'].'&redirect_url=http%3A%2F%2Fwww.xuanhao.net'.'";
                    </script>
    			';
			}
			exit();
		}
			

	}
	public function pay($cityid,$cnum,$chao)
	{
		//cnum为金额,$chao为订单号,
		header("Content-type:text/html;charset=utf-8");
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		require_once(APPPATH.'third_party/weixin/WxPayPubHelpers.php');
		if(isset($cnum)&&isset($chao)){
			//商户订单号
			$out_trade_no = $chao;
			//商户网站订单系统中唯一订单号，必填
			//订单名称
			$subject = $data['citys']['cname'].$chao.'在线付款';
			//必填
			//付款金额
			$total_fee = $cnum;
			//必填
			//订单描述

			$body = $data['citys']['cname'].$chao.'下单付款';
			
			$unifiedOrder = new UnifiedOrder_pub();
			$unifiedOrder->setParameter("body",$subject);//商品描述
			$total_fee=$total_fee*100;
			//$total_fee=1;
			$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
			$unifiedOrder->setParameter("total_fee",$total_fee);//总金额
			$unifiedOrder->setParameter("notify_url",$this->wxpayset->wx_config['NOTIFY_URL']);//通知地址 
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
				$data['out_trade_no']=$out_trade_no;
				$data['subject']=$subject;
				$data['total_fee']=$total_fee;
				$data['body']=$body;
				$data['url']=$url;
				$data['code_url']=$url;
				$this->load->view('native_dynamic_qrcode', $data);
				//require_once(APPPATH.'third_party/weixin/native_dynamic_qrcode.php');
			}
		}
    }	
	
	function return_danhao($out_trade_no){
        header("Content-type:text/html;charset=utf-8");
		require_once(APPPATH.'third_party/weixin/WxPayPubHelpers.php');
		if (empty($out_trade_no)){
			 echo "fail";
		}


		$orderQuery = new OrderQuery_pub();
		$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$orderQueryResult = $orderQuery->getResult();


		if ($orderQueryResult["return_code"] == "FAIL") {
			echo "通信出错：".$orderQueryResult['return_msg']."<br>";
		}elseif($orderQueryResult["result_code"] == "FAIL"){
			echo "错误代码：".$orderQueryResult['err_code']."<br>";
			echo "错误代码描述：".$orderQueryResult['err_code_des']."<br>";
			//echo "fail";exit;
		}else{
			$out_trade_no= $orderQueryResult['out_trade_no']; 
			$result_code= $orderQueryResult['result_code']; 
            if($result_code=='SUCCESS'){
				//$this->db->set('dan_hao_lock_queren',1)->set('dan_hao_lock_zhifu',1)->where('dan_hao',$out_trade_no)->update('dingdan_list');
			}
        }
		echo 'fail';exit; 
    }
	
    function return_url(){
        header("Content-type:text/html;charset=utf-8");
		require_once(APPPATH.'third_party/weixin/WxPayPubHelpers.php');
	
		
        //$userdingdan=$this->db->select('*')->get_where('dingdan_list',array('dan_hao'=>$out_trade_no))->row_array();
        
        //$userdingdan=$this->db->where('dan_hao',$out_trade_no)->get('dingdan_list')->row_array();
        
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postcont= file_get_contents('php://input');
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$out_trade_no = trim($postObj->out_trade_no);
		$_error =& load_class('Exceptions', 'core');
		$_error->log_exception('error', '11111','test',1);
		//$_error->log_exception('error', $postObj,'wxpay',1);
		//$_error->log_exception('error', $postcont,'wxpay',1);
		if (empty($out_trade_no)){
			 echo "fail";
		}
        
		$orderQuery = new OrderQuery_pub();
		$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		$orderQueryResult = $orderQuery->getResult();
        //$_error->log_exception('error', json_encode($orderQueryResult),'wxpay',1);
        //$_error->log_exception('error', json_encode($orderQueryResult),'wxpay2',1);
		if ($orderQueryResult["return_code"] == "FAIL") {
		    $_error->log_exception('error', "通信出错：".$orderQueryResult['return_msg']."<br>",'test',1);
			//echo "通信出错：".$orderQueryResult['return_msg']."<br>";
			
		}
		elseif($orderQueryResult["result_code"] == "FAIL"){
			//echo "错误代码：".$orderQueryResult['err_code']."<br>";
			//echo "错误代码描述：".$orderQueryResult['err_code_des']."<br>";
			$_error->log_exception('error', "错误代码描述：".$orderQueryResult['err_code_des']."<br>",'test',1);
			//echo "fail";exit;
		}else{
		    $this->db->select('dan_hao_shoujia');
    		$this->db->from('dingdan_list');
    		$this->db->where('dan_hao',$out_trade_no);
    		$query=$this->db->get();
    		$userdingdan=$query->result_array();
    		$shoujia=0;
    		foreach($userdingdan as $k=>$v){
    		    $shoujia+=$v['dan_hao_shoujia'];
    		}
    		if($shoujia*100 != $orderQueryResult["total_fee"]){
    		    $_error->log_exception('error', "支付金额不一致：".$shoujia.'-'.$orderQueryResult["total_fee"]/100,'dan_shoujia',1);
    		    echo "fail";
    		    exit;
    		}
			//$total_fee_t = $orderQueryResult['total_fee']/100;					
			$out_trade_no= $orderQueryResult['out_trade_no']; 
            //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //如果有做过处理，不执行商户的业务程序
			//$userdingdan=$this->db->select('*')->get_where('dingdan',array('dan_chao'=>$out_trade_no))->row_array();			
			$this->db->set('dan_hao_lock_queren',1)->set('dan_hao_lock_zhifu',1)->where('dan_hao',$out_trade_no)->update('dingdan_list');
            echo "success";exit;
        }
		echo "fail";exit; 
    }
	
	function do_lock()
	{
		header("Content-type:text/html;charset=utf-8");
		require_once(APPPATH.'third_party/weixin/WxPayPubHelpers.php');		
		$dan_hao=$this->input->post('out_trade_no',true);
		if(!empty($dan_hao)){			
			$this->db->select_max('dan_hao_lock_zhifu');
			$this->db->where('dan_hao',$dan_hao);
			$query = $this->db->get('dingdan_list')->row_array();
			if($query['dan_hao_lock_zhifu']>0){
				$arr['code']=1;
				$arr['msg'] = '已经支付成功啦';
			}else{
				$orderQuery = new OrderQuery_pub();
				$orderQuery->setParameter("out_trade_no","$dan_hao");//商户订单号 
				$orderQueryResult = $orderQuery->getResult();		
				$out_trade_no= $orderQueryResult['out_trade_no']; 
				$result_code= $orderQueryResult['result_code']; 
				$trade_type= ($orderQueryResult['trade_type'])?$orderQueryResult['trade_type']:''; 
				if($trade_type){
					$arr['code']=1;
					$arr['msg'] = '已经支付成功啦';
					$this->db->set('dan_hao_lock_queren',1)->set('dan_hao_lock_zhifu',1)->where('dan_hao',$out_trade_no)->update('dingdan_list');
					echo json_encode($arr);exit;
				}else{
					$arr['code']=0;
					$arr['msg'] = '返回订单查看';					
				}
			}		
		}else{
			$arr['code']=999;
			$arr['msg'] = '获取失败';
		}
		echo json_encode($arr);exit;
	}
	

	
}