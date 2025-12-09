<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Wxpayset
{
	private $_CI;
	
	public function __construct()
    {
        /** 获取CI句柄 */
		$this->_CI = & get_instance();
		$this->_CI->config->load('payset');	
		$this->_init_config();
    }
	
	private function _init_config(){
		$this->wx_config['APPID']= $this->_CI->config->item('wx_appid');
		//受理商ID，身份标识
		$this->wx_config['MCHID'] = $this->_CI->config->item('wx_mchid');
		//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
		$this->wx_config['KEY'] = $this->_CI->config->item('wx_key');
		//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
		$this->wx_config['APPSECRET'] = $this->_CI->config->item('wx_appsecret');

		//=======【JSAPI路径设置】===================================
		//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
		$this->wx_config['JS_API_CALL_URL'] = '';
		//=======【证书路径设置】=====================================
		//证书路径,注意应该填写绝对路径
		$this->wx_config['SSLCERT_PATH'] = base_url('uploads/weixin/cacert/apiclient_cert.pem');
		$this->wx_config['SSLKEY_PATH'] = base_url('uploads/weixin/cacert/apiclient_key.pem');
		
		//=======【异步通知url设置】===================================
		//异步通知url，商户根据实际开发过程设定
		$this->wx_config['NOTIFY_URL'] =site_url('wxpay/return_url');

		//=======【curl超时设置】===================================
		//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
		$this->wx_config['CURL_TIMEOUT'] = 30;
	}	
}

