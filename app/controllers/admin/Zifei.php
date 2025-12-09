<?php
class Zifei extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('zifei_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	public function index()
	{
		redirect(site_url('admin/zifei/listzf'));
	}
	
	public function listzf($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '资费中心';
			$data['siderbar'] = 'admin/zifei';
			$data['submenu'] = 'admin/zifei/listzf';
			$data['ug'] = $ug;
			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			//分页
			$limit = 20;
			$config['uri_segment'] = 6;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/zifei/listzf/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->zifei_m->count_zifei($ug,$data['city']);
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

			$data['zifei_list'] = $this->zifei_m->get_all_zifei_list($start, $limit,$ug,$data['city']);
			if($data['zifei_list']){
				foreach($data['zifei_list'] as $k => $v){
					$data['zifei_list'][$k]['zf_city']=$this->city_m->get_cname_by_ucity($v['zf_city']);					
					$data['zifei_list'][$k]['zf_pinpai']=$this->zifei_m->get_pname_by_pid($v['zf_pinpai']);					
				}
			}

			$this->load->view('zifei_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function taocan($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '套餐中心';
			$data['siderbar'] = 'admin/zifei';
			$data['submenu'] = 'admin/zifei/taocan';
			$data['ug'] = $ug;
			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			//分页
			$limit = 20;
			$config['uri_segment'] = 6;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/zifei/taocan/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->zifei_m->count_taocan($ug,$data['city']);
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

			$data['taocan_list'] = $this->zifei_m->get_all_taocan_list($start, $limit,$ug,$data['city']);
			if($data['taocan_list']){
				foreach($data['taocan_list'] as $k => $v){
					$data['taocan_list'][$k]['tc_city']=$this->city_m->get_cname_by_ucity($v['tc_city']);					
				}
			}

			$this->load->view('taocan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function getpinpai()
	{
		$city=$this->input->post('city');
		if($city){
			$pinpai=$this->zifei_m->get_all_pinpai_by_city($city);
			if($pinpai){
				foreach($pinpai as $k => $v){
					echo '<label><input name="zf_pinpai" type="radio" class="ace" value="'.$v['pin_num'].'">';
					echo '<span class="lbl"> '.$v['pin_title'].'</span></label>';
				}
			}else{
				echo '<font color="red">未找到，加载失败</font>';
			}
			
		}else{
			echo '<font color="red">品牌加载失败</font>';
		}		
	}
	
	private function validate_addzifei_form(){
		$this->form_validation->set_rules('zf_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('zf_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('zf_pinpai', '品牌' , 'trim|required|integer');
		$this->form_validation->set_rules('zf_city', '城市' , 'trim|required|integer');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function add()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '增加资费';
			$data['siderbar'] = 'zifei';
			$data['submenu'] = 'admin/zifei/listzf';

			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}
			
			if($_POST && $this->validate_addzifei_form()){
				$str = array(
					'zf_title' => strip_tags($this->input->post('zf_title')),
					'zf_type' => $this->input->post('zf_type',true),
					'zf_pinpai' => $this->input->post('zf_pinpai',true),
					'zf_city' => $this->input->post('zf_city',true),
					'zf_content' => html_purify($this->input->post('content',true),'comment'),
					'zf_time' => time(),
				);
				if($this->zifei_m->add_zifei($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('zifei_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addtaocan_form(){
		$this->form_validation->set_rules('tc_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('tc_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('tc_city', '城市' , 'trim|required|integer');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function taocan_add()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '增加套餐';
			$data['siderbar'] = 'zifei';
			$data['submenu'] = 'admin/zifei/taocan';

			$data['citys'] = $this->city_m->get_city_all_list();
			
			if($_POST && $this->validate_addtaocan_form()){
				$str = array(
					'tc_title' => strip_tags($this->input->post('tc_title')),
					'tc_type' => $this->input->post('tc_type',true),
					'tc_city' => $this->input->post('tc_city',true),
					'tc_content' => html_purify($this->input->post('content',true),'comment'),
					'tc_time' => time(),
				);
				if($this->zifei_m->add_taocan($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('taocan_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_editzifei_form(){
		$this->form_validation->set_rules('zf_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('zf_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('zf_pinpai', '品牌' , 'trim|required|integer');
		$this->form_validation->set_rules('zf_city', '城市' , 'trim|required|integer');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edit($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->zifei_m->get_zifei_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改品牌';
			$data['siderbar'] = 'zifei';
			$data['submenu'] = 'admin/zifei/listzf';

			$data['citys'] = $this->city_m->get_city_all_list();
			$data['zifeiinfo'] = $this->zifei_m->get_zifei_by_id($id);
			$data['zifeipinpai']=$this->zifei_m->get_pname_by_pid($data['zifeiinfo']['zf_pinpai']);
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}
			if($_POST && $this->validate_editzifei_form()){
				if($this->session->userdata('ucity')>0 && $data['zifeiinfo']['zf_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站资费','');
				}
				$str = array(
					'zf_title' => strip_tags($this->input->post('zf_title')),
					'zf_type' => $this->input->post('zf_type',true),
					'zf_pinpai' => $this->input->post('zf_pinpai',true),
					'zf_city' => $this->input->post('zf_city',true),
					'zf_content' => html_purify($this->input->post('content',true),'comment'),
					'zf_time' => time(),
				);
				if($this->zifei_m->update_zifei($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('zifei_edit', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function taocan_edit($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->zifei_m->get_taocan_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改套餐';
			$data['siderbar'] = 'zifei';
			$data['submenu'] = 'admin/zifei/taocan';

			$data['citys'] = $this->city_m->get_city_all_list();
			$data['taocaninfo'] = $this->zifei_m->get_taocan_by_id($id);
			if($_POST && $this->validate_addtaocan_form()){
				if($this->session->userdata('ucity')>0 && $data['taocaninfo']['tc_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站资费','');
				}
				$str = array(
					'tc_title' => strip_tags($this->input->post('tc_title')),
					'tc_type' => $this->input->post('tc_type',true),
					'tc_city' => $this->input->post('tc_city',true),
					'tc_content' => html_purify($this->input->post('content',true),'comment'),
					'tc_time' => time(),
				);
				if($this->zifei_m->update_taocan($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('taocan_edit', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function del($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'zifei';
			$data['title'] = '删除品牌';
			$data['submenu'] = 'admin/zifei/listzf';
			if($this->zifei_m->get_zifei_by_id($id)){
				$data['zifeiinfo'] = $this->zifei_m->get_zifei_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['zifeiinfo']['zf_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站品牌','');
				}
				//删除
				if($this->zifei_m->del_zifei($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function taocan_del($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'zifei';
			$data['title'] = '删除套餐';
			$data['submenu'] = 'admin/zifei/taocan';
			if($this->zifei_m->get_taocan_by_id($id)){
				$data['taocaninfo'] = $this->zifei_m->get_taocan_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['taocaninfo']['tc_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站品牌','');
				}
				//删除
				if($this->zifei_m->del_taocan($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	public function searchz()
	{
		//查找用户
		$data['siderbar'] = 'zifei';
		$data['title'] = '搜索资费';
		$data['submenu'] = 'admin/zifei/listzf';
		$data['ug'] = 0;
		$data['citys'] = $this->city_m->get_city_all_list();
		if($this->session->userdata('ucity')>0){
			$data['city']=$this->session->userdata('ucity');
		}else{
			$data['city']=0;
		}
		if($data['city']>0){
			$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
		}else{
			$data['cityname']='城市';
		}
		if($_POST){
			$q=$this->input->post('q');
			$data['zifei_list']=$this->zifei_m->search_zifei($q);
			if($data['zifei_list']){
				foreach($data['zifei_list'] as $k => $v){
					$data['zifei_list'][$k]['zf_city']=$this->city_m->get_cname_by_ucity($v['zf_city']);					
					$data['zifei_list'][$k]['zf_pinpai']=$this->zifei_m->get_pname_by_pid($v['zf_pinpai']);					
				}
			}
		}
		$this->load->view('zifei_list', $data);
	}
	public function searcht()
	{
		//查找用户
		$data['siderbar'] = 'zifei';
		$data['title'] = '搜索套餐';
		$data['submenu'] = 'admin/zifei/taocan';
		$data['ug'] = 0;
		$data['citys'] = $this->city_m->get_city_all_list();
		if($this->session->userdata('ucity')>0){
			$data['city']=$this->session->userdata('ucity');
		}else{
			$data['city']=0;
		}
		if($data['city']>0){
			$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
		}else{
			$data['cityname']='城市';
		}
		if($_POST){
			$q=$this->input->post('q');
			$data['taocan_list']=$this->zifei_m->search_taocan($q);
			if($data['taocan_list']){
				foreach($data['taocan_list'] as $k => $v){
					$data['taocan_list'][$k]['tc_city']=$this->city_m->get_cname_by_ucity($v['tc_city']);					
				}
			}
		}
		$this->load->view('taocan_list', $data);
	}
}