<?php
class Xinxi extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('xinxi_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	public function index()
	{
		redirect(site_url('admin/xinxi/flist'));
	}
	
	public function flist($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '交易列表';
			$data['siderbar'] = 'admin/xinxi';
			$data['submenu'] = 'admin/xinxi/flist';
			$data['ug'] = $ug;
			$data['citys'] = $this->city_m->get_city_all_list_ping();
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
			$config['base_url'] = site_url('admin/xinxi/flist/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->xinxi_m->count_xinxi($ug,$data['city']);
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

			$data['xinxi_list'] = $this->xinxi_m->get_all_xinxi_list($start, $limit,$ug,$data['city']);
			if($data['xinxi_list']){
				foreach($data['xinxi_list'] as $k => $v){
					$data['xinxi_list'][$k]['xinxi_city']=$this->city_m->get_cname_by_ucity($v['x_city']);					
				}
			}

			$this->load->view('xinxi_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addxinxi_form(){
		$this->form_validation->set_rules('xinxi_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('xinxi_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('xinxi_city', '城市' , 'trim|required|integer');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('xinxi_name', '联系人' , 'trim|required|min_length[2]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('xinxi_tel', '联系电话' , 'trim|required|min_length[2]|max_length[18]|xss_clean');
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
			$data['title'] = '增加交易';
			$data['siderbar'] = 'xinxi';
			$data['submenu'] = 'admin/xinxi/flist';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			
			if($_POST && $this->validate_addxinxi_form()){
				$str = array(
					'x_title' => strip_tags($this->input->post('xinxi_title')),
					'x_type' => $this->input->post('xinxi_type',true),
					'x_city' => $this->input->post('xinxi_city',true),
					'x_content' => html_purify($this->input->post('content',true),'comment'),
					'x_userid' => $this->input->post('xinxi_userid',true),
					'x_name' => $this->input->post('xinxi_name',true),
					'x_tel' => $this->input->post('xinxi_tel',true),
					'x_qq' => $this->input->post('xinxi_qq',true),
					'x_email' => $this->input->post('xinxi_email',true),
					'x_time' => time(),
				);
				if($this->xinxi_m->add_xinxi($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('xinxi_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function edit($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!$this->xinxi_m->get_xinxi_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改交易';
			$data['siderbar'] = 'xinxi';
			$data['submenu'] = 'admin/xinxi/flist';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$data['xinxiinfo'] = $this->xinxi_m->get_xinxi_by_id($id);
			if($_POST && $this->validate_addxinxi_form()){
				if($this->session->userdata('ucity')>0 && $data['xinxiinfo']['x_userid']!=$this->session->userdata('userid')){
					show_message('操作无权限：非您的交易信息','');
				}
				$str = array(
					'x_title' => strip_tags($this->input->post('xinxi_title')),
					'x_type' => $this->input->post('xinxi_type',true),
					'x_city' => $this->input->post('xinxi_city',true),
					'x_content' => html_purify($this->input->post('content',true),'comment'),
					'x_name' => $this->input->post('xinxi_name',true),
					'x_tel' => $this->input->post('xinxi_tel',true),
				);
				if($this->xinxi_m->update_xinxi($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('xinxi_edit', $data);
			
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
			$data['siderbar'] = 'xinxi';
			$data['title'] = '删除交易';
			$data['submenu'] = 'admin/xinxi/flist';
			if($this->xinxi_m->get_xinxi_by_id($id)){
				$data['xinxiinfo'] = $this->xinxi_m->get_xinxi_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['xinxiinfo']['x_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站问题','');
				}
				//删除
				if($this->xinxi_m->del_xinxi($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	public function del_all()
	{
		$masterurl='admin/xinxi/del';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'admin/xinxi';
			$data['title'] = '删除1月前交易';
			$data['submenu'] = 'admin/xinxi/flist';
			//删除
			$this->xinxi_m->del_all($this->session->userdata('ucity'));
			show_message($data['title'].'成功！',site_url($data['submenu']),1);

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function search()
	{
		//查找用户
		$data['siderbar'] = 'admin/xinxi';
		$data['title'] = '搜索交易';
		$data['submenu'] = 'admin/xinxi/flist';
		$data['ug'] = 10000;
		$data['citys'] = $this->city_m->get_city_all_list_ping();
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
			$data['xinxi_list']=$this->xinxi_m->search_xinxi($q);
			if($data['xinxi_list']){
				foreach($data['xinxi_list'] as $k => $v){
					$data['xinxi_list'][$k]['xinxi_city']=$this->city_m->get_cname_by_ucity($v['x_city']);					
				}
			}
		}
		$this->load->view('xinxi_list', $data);
	}
}