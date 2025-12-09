<?php
class Login extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('user_m');
		$this->load->model ('city_m');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
	}

	public function index()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admins())
		{
			show_message('非管理员或未登录',site_url('admin/login/do_login'));
		}
		$data['title'] = '默认首页';
		$data['siderbar'] = 'home';
		$data['siderbar'] = 'home';
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));

		$this->load->view('dashboard', $data);
	}

	public function do_login ()
	{
		/** 检查登陆 */
		if($this->auth->is_admins())
		{
			redirect('admin/login/index');
		}
		$data['title'] = '用户登录';
		if($_POST && $this->form_validation->run() === TRUE){
			$log = array(
                'louid' => $this->input->post('username'),
                'loip' => get_onlineip(),
                'lotime' => time(),
                'lotype' => 0,
				'loagent' => substr($this->agent->agent , 0 , 250),
            );
			if($this->user_m->add_log($log)){
				$new_log_id = $this->db->insert_id();
			}
			if(!$this->user_m->check_ulock($this->input->post('username', TRUE))){
				show_message('您的帐号已被锁定');
			}
			$data = array(
                'username' => $this->input->post('username', TRUE),
                'upassword' => $this->input->post('password',TRUE)
            );			
			if($this->input->post('loveme')=='on'){
				$loveme=1;
			}else{
				$loveme=0;
			}
			if($this->user_m->login($data,$loveme)){
				$uid=$this->session->userdata('userid');
				//更新积分
				$this->config->load('userset');
				$this->user_m->update_credit($uid,$this->config->item('credit_login'));
				if($new_log_id){
					$this->user_m->update_log($new_log_id,1);
				}
				redirect('admin/login/index');
				
			} else {
				show_message('用户名或密错误!');
			}
			}else{
			$this->load->view('do_login',$data);
		}
	}
	public function logout ()
	{
		$this->session->sess_destroy();
		
		$this->load->helper('cookie');
		delete_cookie('userid');
		delete_cookie('username');
		delete_cookie('ugroup');
		delete_cookie('utype');
		delete_cookie('openid');
		redirect('admin/login/do_login');
	}

	
}