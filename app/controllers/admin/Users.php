<?php
class Users extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('user_m');
		$this->load->model ('group_m');
		$this->load->model ('city_m');
		$this->load->model ('haoma_m');
		$this->load->model('upload_m');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		redirect(site_url('admin/users/listu'));
	}
	
	public function groups($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '角色分组';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'users/groups';

			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/users/groups/');
			$config['total_rows'] = $this->db->count_all('user_groups');
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['groups_list'] = $this->group_m->group_list($start, $limit);
			if($data['groups_list']){
				foreach($data['groups_list'] as $k => $v){
					$data['groups_list'][$k]['group_count']=$this->user_m->count_users_group($v['group_type']);
				}
			}
			$this->load->view('users_groups', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function groupedit($gid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->group_m->get_group_info($gid)){
				show_message('参数不正确','');
			}

			$data['title'] = '修改分组';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'admin/users/groups';

			$data['ginfo'] = $this->group_m->get_group_info($gid);

			if($_POST){
				$str = array(
					'group_name' => $this->input->post('group_name',true),
					'zhekou' => $this->input->post('zhekou',true),
					'credit' => $this->input->post('credit',true),
				);
				if($this->db->where('gid',$gid)->update('user_groups', $str)){
					show_message('修改分组成功',site_url('admin/users/groups'),1);
				}else{
					show_message('未做任何修改',site_url($data['submenu']));
				}
			}
			$this->load->view('users_groupedit', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function lista($ug=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '管理列表';
			$data['memuset'] = 11;
			$data['siderbar'] = 'users';
			$data['submenu'] = 'users/lista';
			$data['groups'] = $this->group_m->group_list_by_sets(11);
			$data['ug'] = $ug;

			//分页
			$limit = 20;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/users/lista/'.$ug.'/');
			$config['total_rows'] = $this->user_m->count_users(11,$ug,$this->session->userdata('ucity'));
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['users_list'] = $this->user_m->get_all_users_list($start, $limit,11,$ug,$this->session->userdata('ucity'));
			if($data['users_list']){
				foreach($data['users_list'] as $k => $v){
					$data['users_list'][$k]['ugroup']=$this->group_m->get_all_group_name_by_mgroup($v['ugroup']);					
					$data['users_list'][$k]['ucity']=$this->city_m->get_cname_by_ucity($v['ucity']);					
					$data['users_list'][$k]['ulock']=$this->user_m->get_user_by_ulock($v['ulock']);					
				}
			}

			$this->load->view('users_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	
	public function listu($ug=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '会员列表';
			$data['memuset'] = 11;
			$data['siderbar'] = 'users';
			$data['submenu'] = 'users/listu';
			$data['groups'] = $this->group_m->group_list_by_sets(1);
			$data['ug'] = $ug;

			//分页
			$limit = 20;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/users/listu/'.$ug.'/');
			$config['total_rows'] = $this->user_m->count_users(1,$ug,$this->session->userdata('ucity'));
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['users_list'] = $this->user_m->get_all_users_list($start, $limit,1,$ug,$this->session->userdata('ucity'));
			if($data['users_list']){
				foreach($data['users_list'] as $k => $v){
					$data['users_list'][$k]['ugroups']=$this->group_m->get_all_group_name_by_mgroup($v['ugroup']);					
					$data['users_list'][$k]['ucity']=$this->city_m->get_cname_by_ucity($v['ucity']);					
					$data['users_list'][$k]['cnums']=$this->city_m->get_cnums_by_ucity($v['ucity']);					
					$data['users_list'][$k]['ulock']=$this->user_m->get_user_by_ulock($v['ulock']);					
					$data['users_list'][$k]['haoma_shu']=$this->haoma_m->get_haoma_count_by_user($v['username'],0);					
				}
			}

			$this->load->view('users_listu', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function _check_username($username)
	{  
		if(!preg_match('/^(?!_)(?!.*?_$)[A-Za-z0-9_]+$/u', $username)){
  			return false;
		} else{
			$user=$this->user_m->get_user_by_username($username);
			if(isset($user)){
				return false;
			}else{
				return true;
			}			
		}
	}
	
	public function _disabled_username($username)
	{
		$this->config->load('userset');
		$user_arr=explode(',',$this->config->item('disabled_username'));
		if(in_array($username,$user_arr,true)){
			return false;
		}else{
			return true;
		}
	}
	
	private function validate_adduser_form(){
		$this->form_validation->set_rules('username', '帐号' , 'trim|required|min_length[3]|max_length[15]|is_unique[users.username]|callback__check_username|callback__disabled_username|xss_clean');
		$this->form_validation->set_rules('upassword', '密码' , 'trim|required|min_length[6]|max_length[18]');
		$this->form_validation->set_rules('upassword_com', '重复密码' , 'trim|required|matches[upassword]');
		$this->form_validation->set_rules('uemail', '邮箱' , 'trim|required|min_length[3]|max_length[50]|valid_email|is_unique[users.uemail]|xss_clean');
		$this->form_validation->set_rules('ugroup', '角色' , 'trim|required|integer');
		$this->form_validation->set_rules('ucity', '城市选择' , 'trim|required|integer');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function adda()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '增加管理';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'admin/users/lista';

			$data['groups'] = $this->group_m->group_list_by_sets(11);
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$this->config->load('userset');//用户积分
			
			if($_POST && $this->validate_adduser_form()){
				$password = $this->input->post('upassword',true);
				$salt =get_salt();
				$str = array(
					'username' => strip_tags($this->input->post('username')),
					'upassword' => password_dohash($password,$salt),
					'salt' => $salt,
					'uname' => $this->input->post('uname',true),
					'uzname' => $this->input->post('uzname',true),
					'uemail' => $this->input->post('uemail',true),
					'ucredit' => $this->input->post('ucredit',true),
					'uregip' => get_onlineip(),
					'ugroup' => $this->input->post('ugroup',true),
					'ucity' => $this->input->post('ucity',true),
					'uregtime' => time(),
					'ulogtime' => time(),
					'ulock' => 0
				);
				if($this->user_m->register($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('users_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_uadduser_form(){
		$this->form_validation->set_rules('username', '帐号' , 'trim|required|min_length[3]|max_length[15]|is_unique[users.username]|callback__check_username|callback__disabled_username|xss_clean');
		$this->form_validation->set_rules('upassword', '密码' , 'trim|required|min_length[6]|max_length[18]');
		$this->form_validation->set_rules('upassword_com', '重复密码' , 'trim|required|matches[upassword]');
		$this->form_validation->set_rules('uemail', '邮箱' , 'trim|required|min_length[3]|max_length[50]|valid_email|is_unique[users.uemail]|xss_clean');
		$this->form_validation->set_rules('ugroup', '级别' , 'trim|required|integer');
		$this->form_validation->set_rules('ucity', '源自选择' , 'trim|required|integer');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function addu()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '增加会员';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'admin/users/listu';

			$data['groups'] = $this->group_m->group_list_by_sets(1);
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$this->config->load('userset');//用户积分
			
			if($_POST && $this->validate_uadduser_form()){
				if($this->input->post('utel',true) && $this->user_m->check_utel($this->input->post('utel',true))){
					show_message($data['title'].'：此电话已经存在',site_url('admin/users/addu'));
				}
				$password = $this->input->post('upassword',true);
				$salt =get_salt();
				$str = array(
					'username' => strip_tags($this->input->post('username')),
					'upassword' => password_dohash($password,$salt),
					'salt' => $salt,
					'uemail' => $this->input->post('uemail',true),
					'uname' => $this->input->post('uname',true),
					'uzname' => $this->input->post('uzname',true),
					'ucredit' => $this->input->post('ucredit',true),
					'uregip' => get_onlineip(),
					'ugroup' => $this->input->post('ugroup',true),
					'ucity' => $this->input->post('ucity',true),
					'unums' => $this->input->post('unums',true),
					'utel' => $this->input->post('utel',true),
					'uregtime' => time(),
					'ulogtime' => time(),
					'ulock' => 0
				);
				if($this->user_m->register($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('users_addu', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_edituser_form(){
		$this->form_validation->set_rules('ugroup', '角色' , 'trim|required|integer');
		$this->form_validation->set_rules('ucity', '城市选择' , 'trim|required|integer');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edita($userid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->user_m->get_user_by_uid($userid)){
				show_message('参数不正确','');
			}
			$data['userinfo']=$this->user_m->get_user_by_uid($userid);
			if($data['userinfo']['ugroup']>$this->session->userdata('ugroup')){
				show_message('操作无权限：大于您的级别','');
			}
			$data['title'] = '修改管理';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'admin/users/lista';

			$data['groups'] = $this->group_m->group_list_by_sets(11);
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($_POST && $this->validate_edituser_form()){
				if($this->user_m->check_uid_utel($userid, $this->input->post('utel',true))){
					show_message($data['title'].'：此电话已经存在',site_url('admin/users/edita/'.$userid));
				}
				$psw = $this->input->post('upassword',true);
				$npsw = $this->input->post('upassword_com',true);
				$str1=array();
				$str2=array();
				$str1 = array(
					'uemail' => $this->input->post('uemail',true),
					'uname' => $this->input->post('uname',true),
					'uzname' => $this->input->post('uzname',true),
					'ucredit' => $this->input->post('ucredit',true),
					'utel' => $this->input->post('utel',true),
					'uqq' => $this->input->post('uqq',true),
					'ugroup' => $this->input->post('ugroup',true),
					'ucity' => $this->input->post('ucity',true),
					'ulock' => $this->input->post('ulock',true),
				);
				if(!empty($psw)){
					if($psw!=$npsw){
						show_message('密码不一致',site_url('admin/users/edita/'.$userid));
					}else{
						$salt =get_salt();
						$password= password_dohash($npsw,$salt);
						$str2 = array ('salt' => $salt, 'upassword' =>$password);					
					}				
				}
				$str = array_merge_recursive($str1, $str2);
				if($this->user_m->update_user($userid, $str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}else{
					show_message('未做任何修改',site_url($data['submenu']));
				}
			}
			$this->load->view('users_edit', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_uedituser_form(){
		$this->form_validation->set_rules('ugroup', '级别' , 'trim|required|integer');
		$this->form_validation->set_rules('ucity', '源自选择' , 'trim|required|integer');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function editu($userid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->user_m->get_user_by_uid($userid)){
				show_message('参数不正确','');
			}
			$data['userinfo']=$this->user_m->get_user_by_uid($userid);
			if($data['userinfo']['ugroup']>$this->session->userdata('ugroup')){
				show_message('操作无权限：大于您的级别','');
			}
			$data['title'] = '修改会员';
			$data['siderbar'] = 'users';
			$data['submenu'] = 'admin/users/listu';

			$data['groups'] = $this->group_m->group_list_by_sets(1);
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($_POST && $this->validate_uedituser_form()){
				if($this->user_m->check_uid_utel($userid, $this->input->post('utel',true))){
					show_message($data['title'].'：此电话已经存在',site_url('admin/users/editu/'.$userid));
				}
				$psw = $this->input->post('upassword',true);
				$npsw = $this->input->post('upassword_com',true);
				$str1=array();
				$str2=array();
				$str1 = array(
					'uname' => $this->input->post('uname',true),
					'uzname' => $this->input->post('uzname',true),
					'uemail' => $this->input->post('uemail',true),
					'utel' => $this->input->post('utel',true),
					'uqq' => $this->input->post('uqq',true),
					'ucredit' => $this->input->post('ucredit',true),
					'ugroup' => $this->input->post('ugroup',true),
					'ucity' => $this->input->post('ucity',true),
					'ulock' => $this->input->post('ulock',true),
					'unums' => $this->input->post('unums',true),
				);
				if(!empty($psw)){
					if($psw!=$npsw){
						show_message('密码不一致',site_url('admin/users/edita/'.$userid));
					}else{
						$salt =get_salt();
						$password= password_dohash($npsw,$salt);
						$str2 = array ('salt' => $salt, 'upassword' =>$password);					
					}				
				}
				$str = array_merge_recursive($str1, $str2);
				if($this->user_m->update_user($userid, $str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}else{
					show_message('未做任何修改',site_url($data['submenu']));
				}
			}
			$this->load->view('users_editu', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	public function profile($userid)
	{
		$masterurl='admin/users/edita';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->user_m->get_user_by_uid($userid)){
				show_message('参数不正确','');
			}
			$data['userinfo']=$this->user_m->get_user_by_uid($userid);
			$data['title'] = '修改头像';
			$data['siderbar'] = 'sets';
			$data['submenu'] = 'admin/sets/profile';

			$this->load->view('users_profile', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function dela($userid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'users';
			$data['title'] = '删除管理会员';
			$data['submenu'] = 'admin/users/lista';
			if($userid==$this->session->userdata('userid')){
				show_message('您不能够删除自己哦','');
			}
			if($this->user_m->get_user_by_uid($userid)){
				$user=$this->user_m->get_user_by_uid($userid);
				if($user['ugroup']>=$this->session->userdata('ugroup')){
					show_message('操作无权限：同级或者大于您的级别','');
				}
				if($this->session->userdata('ucity')>0 && $user['ucity']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站管理人员','');
				}
				//删除
				if($this->user_m->del_user($userid)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function delu($userid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'users';
			$data['title'] = '删除管理会员';
			$data['submenu'] = 'admin/users/listu';
			if($userid==$this->session->userdata('userid')){
				show_message('您不能够删除自己哦','');
			}
			if($this->user_m->get_user_by_uid($userid)){
				$user=$this->user_m->get_user_by_uid($userid);
				if($user['ugroup']>=$this->session->userdata('ugroup')){
					show_message('操作无权限：同级或者大于您的级别','');
				}
				if($this->session->userdata('ucity')>0 && $user['ucity']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站管理人员','');
				}
				//删除
				if($this->user_m->del_user($userid)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function avatar_upload()
    {
        $config['upload_path'] = './uploads/avatar';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '512';
        $url='admin/users/profile/'.$this->session->userdata('userid');
		if($_FILES['avatar_file']['name']==''){
			show_message('您没有选择图片',site_url($url));
		}	
		
		$uptype=array('jpg','jpeg','png','bmp','png');
		$torrent = explode(".", $_FILES['avatar_file']['name']);
		$fileend = strtolower(end($torrent));
		if(!in_array($fileend, $uptype))
		{
			show_message('不允许的上传图片',site_url($url));
		}

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('avatar_file'))
        {
            $this->avatar($this->upload->display_errors());
        }
        else
        {
            //upload sucess
            $img_array = $this->upload->data();
            $this->load->library('AvatarResize');

            if ($this->avatarresize->resize($img_array['full_path'], 100 ,100 ,'avatar_big') && $this->avatarresize->resize($img_array['full_path'], 48 ,48 ,'avatar_middle') && $this->avatarresize->resize($img_array['full_path'], 24 ,24 ,'avatar_small')) {

                $data = array(
                    'avatar' => $this->avatarresize->get_dir()
                    );
                $this->user_m->update_user($this->session->userdata('userid'), $data);
                //删除tmp下的原图
                unlink($img_array['full_path']);
                $this->session->set_userdata('avatar',$data['avatar']);
				show_message('您的头像设置成功！',site_url($url),1);
            } else {
                //设置三个头像没有成功
                show_message('头像设置失败，请重新设置',site_url($url));
            }
        }
    }	
	public function searcha()
	{
		//查找用户
		$data['siderbar'] = 'users';
		$data['title'] = '搜索管理人员';
		$data['submenu'] = 'admin/users/lista';
		$data['groups'] = $this->group_m->group_list_by_sets(11);
		$data['ug'] = 0;
		if($_POST){
			$q=$this->input->post('username');
			$data['users_list']=$this->user_m->search_user_by_username($q);
			if($data['users_list']){
				foreach($data['users_list'] as $k => $v){
					$data['users_list'][$k]['ugroup']=$this->group_m->get_all_group_name_by_mgroup($v['ugroup']);					
					$data['users_list'][$k]['ucity']=$this->city_m->get_cname_by_ucity($v['ucity']);					
					$data['users_list'][$k]['ulock']=$this->user_m->get_user_by_ulock($v['ulock']);					
				}
			}
		}
		$this->load->view('users_list', $data);
	}
	
	
	public function searchu()
	{
		//查找用户
		$data['siderbar'] = 'users';
		$data['title'] = '搜索普通会员';
		$data['submenu'] = 'admin/users/listu';
		$data['groups'] = $this->group_m->group_list_by_sets(1);
		$data['ug'] = 0;
		if($_POST){
			$q=$this->input->post('username');
			$data['users_list']=$this->user_m->search_user_by_username($q);
			if($data['users_list']){
				foreach($data['users_list'] as $k => $v){
					$data['users_list'][$k]['ugroups']=$this->group_m->get_all_group_name_by_mgroup($v['ugroup']);					
					$data['users_list'][$k]['ucity']=$this->city_m->get_cname_by_ucity($v['ucity']);					
					$data['users_list'][$k]['ulock']=$this->user_m->get_user_by_ulock($v['ulock']);					
				}
			}
		}
		$this->load->view('users_listu', $data);
	}
}