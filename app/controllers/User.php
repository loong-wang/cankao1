<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	User
#	scope:		PUBLIC

class User extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('user_m');
		$this->load->library('form_validation');	
		$this->load->library('user_agent');

	}
	public function register ($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$data['shouye_url']=site_url();			
		}else{
			$data['shouye_url']=site_url('home/city/'.$data['citys']['cid']);
		}
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ( ! $data['cityt'] = $this->cache->get('cityt'.$cityid))
		{
			$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
			$this->cache->save('cityt'.$cityid, $data['cityt'], 3600);
		}
		//城市session
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		//act
		$data['act']='user/register';
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['title'] = '注册新用户';
		if ($this->auth->is_login()) {
			show_message('已登录，请退出再注册',site_url());
		}
		if($_POST && $this->form_validation->run() === TRUE){
			$password = $this->input->post('password',true);
			$unums=($data['citys']['cnums'])?$data['citys']['cnums']:$this->config->item('webnums');
			$salt =get_salt();
			$this->config->load('userset');//用户积分
			$str = array(
				'username' => strip_tags($this->input->post('username')),
				'upassword' => password_dohash($password,$salt),
				'salt' => $salt,
				'uemail' => '',
				'ucredit' => $this->config->item('credit_start'),
				'uregip' => get_onlineip(),
				'ucity' => $cityid,
				'utype' => 1,
				'ugroup' => 1,
				'ulognum' => 1,
				'uthemes' => 'default',
				'unums' => $unums,
				'uregtime' => time(),
				'ulogtime' => time()
			);
			if($this->user_m->register($str)){
				$uid = $this->db->insert_id();
				$newdata=array('username'=>$str['username'],'upassword'=>$password);
				$this->user_m->login($newdata);
				//去除验证码session
				$this->session->unset_userdata('yzm');
				redirect(site_url('user/regok/'.$cityid));
			}

		} else{
			$this->load->view('register',$data);
		}
	}
	
	public function regok ($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$this->config->load('userset');
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$data['shouye_url']=site_url();			
		}else{
			$data['shouye_url']=site_url('home/city/'.$data['citys']['cid']);
		}
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ( ! $data['cityt'] = $this->cache->get('cityt'.$cityid))
		{
			$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
			$this->cache->save('cityt'.$cityid, $data['cityt'], 3600);
		}
		//城市session
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		if (!$this->auth->is_login()) {
			show_message('您没有登陆，请先登陆',site_url('user/login/'.$data['citys']['cid']));
		}
		//act
		$data['act']='user/regok';
		$data['title'] = '恭喜您注册成功';

		$this->load->view('regok',$data);
	}
	
	public function _check_username($username)
	{  
		if(!preg_match('/^(?!_)(?!.*?_$)[A-Za-z0-9_]+$/u', $username)){
  			return false;
		} else{
			return true;
		}
	}
	
	public function login ($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}

		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		//寻找地址
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$data['shouye_url']=site_url();			
		}else{
			$data['shouye_url']=site_url('home/city/'.$data['citys']['cid']);
		}
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ( ! $data['cityt'] = $this->cache->get('cityt'.$cityid))
		{
			$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
			$this->cache->save('cityt'.$cityid, $data['cityt'], 3600);
		}
		//城市session
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		//act
		$data['act']='user/login';
		//继续寻找地址
		if($this->config->item('index_page')){
			$url='/'.$this->config->item('index_page').'/';
		}else{
			$url='/';
		}
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$tourl='http://'.$data['citys']['cdomain'];
		}else{
			$tourl='http://'.$data['citys']['cdomain'].$url.'home/city/'.$data['citys']['cid'];
		}
		//加载form类，为调用错误函数,需view前加载
		$this->load->helper('form');
		$data['title'] = '用户登陆';
		if ($this->auth->is_login()) {
			redirect($tourl);
		}
		if($_POST && $this->form_validation->run() === TRUE){
			if(!$this->user_m->check_ulock($this->input->post('username', TRUE))){
				show_message('您的帐号已被锁定');
			}
            $data = array(
                'username' => $this->input->post('username', TRUE),
                'upassword' => $this->input->post('password',TRUE)
            );

            if ($this->user_m->login($data)) {
				$this->session->unset_userdata('yzm');
	            $uid=$this->session->userdata('userid');
				//更新积分
				if(time()-@$data['myinfo']['ulogtime']>86500){
					$this->config->load('userset');
					$this->user_m->update_credit($uid,$this->config->item('credit_login'));
				}
				//更新登陆次数
				$this->user_m->update_ulognum($uid);
				//更新最后登录时间
				$this->user_m->update_user($uid,array('ulogtime'=>time()));
				redirect(site_url('user/loginok/'.$cityid));
            } else {
                show_message('用户名或密码错误！',site_url('user/login/'.$cityid));
            }
		} else{
			$this->load->view('login',$data);
		}
	}
	
	public function loginok ($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$this->config->load('userset');
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$data['shouye_url']=site_url();			
		}else{
			$data['shouye_url']=site_url('home/city/'.$data['citys']['cid']);
		}
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ( ! $data['cityt'] = $this->cache->get('cityt'.$cityid))
		{
			$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
			$this->cache->save('cityt'.$cityid, $data['cityt'], 3600);
		}
		//城市session
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		if (!$this->auth->is_login()) {
			show_message('您没有登陆，请先登陆',site_url('user/login/'.$data['citys']['cid']));
		}
		$log = array(
			'louid' => $this->session->userdata('username'),
			'loip' => get_onlineip(),
			'lotime' => time(),
			'lotype' => 0,
			'loagent' => substr($this->agent->agent , 0 , 250),
		);
		$this->user_m->add_log($log);
		//act
		$data['act']='user/loginok';
		$data['title'] = '恭喜您登陆成功';

		$this->load->view('loginok',$data);
	}
	
	public function logout ($cityid=0)
	{		
		$this->auth->user_logout($cityid);		
	}
	
	public function _check_captcha($captcha)
	{
		if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm')!=strtolower($captcha)){
  			return false;
		} else{
			return true;
		}
	}
	
	function check_register_username($username){
		if(isset($username)){
			$query = $this->db->get_where('users',array('username'=>$username));
			if($query->num_rows>0){
				$arr['getdata']='flase';
				echo json_encode($arr);
			}else{
				$arr['getdata']='true';
				echo json_encode($arr);
			}			
		}else{
			$arr['getdata']='true';
			echo json_encode($arr);
		}
	}
	public function check_captcha_code($captcha)
	{
		if($captcha){
			if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm') != strtolower($captcha)){
				$arr['getdata']='flase';
				echo json_encode($arr);
			}else{
				$arr['getdata']='true';
				echo json_encode($arr);
			}
		}else{
			$arr['getdata']='true';
			echo json_encode($arr);
		}
	}
	
}