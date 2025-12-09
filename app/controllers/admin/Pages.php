<?php
class Pages extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('page_m');
		$this->load->model ('city_m');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	
	
	public function index($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '单页列表';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/pages';
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
			$config['base_url'] = site_url('webset/pages/index/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->page_m->count_page($ug,$data['city']);
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

			$data['page_list'] = $this->page_m->get_all_page_list($start, $limit,$ug,$data['city']);
			if($data['page_list']){
				foreach($data['page_list'] as $k => $v){
					$data['page_list'][$k]['pages_city']=$this->city_m->get_cname_by_ucity($v['pages_city']);					
				}
			}

			$this->load->view('page_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addpage_form(){
		$this->form_validation->set_rules('pages_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('content', '内容' , 'trim|required|xss_clean');
		$this->form_validation->set_rules('pages_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('pages_city', '城市' , 'trim|required|integer');
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
			$data['title'] = '增加单页';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/pages';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			
			if($_POST && $this->validate_addpage_form()){
				$str = array(
					'pages_title' => strip_tags($this->input->post('pages_title')),
					'pages_content' => html_purify($this->input->post('content',true),'comment'),
					'pages_type' => $this->input->post('pages_type',true),
					'pages_city' => $this->input->post('pages_city',true),
					'pages_time' => time(),
				);
				if($this->page_m->add_page($str)){
					show_message($data['title'].'成功！',site_url('admin/pages'),1);
				}
			}
			$this->load->view('page_add', $data);
			
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
			if(!$this->page_m->get_page_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改单页';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/pages';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$data['pageinfo'] = $this->page_m->get_page_by_id($id);
			
			if($_POST && $this->validate_addpage_form()){
				if($this->session->userdata('ucity')>0 && $data['pageinfo']['pages_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站单页','');
				}
				$str = array(
					'pages_title' => strip_tags($this->input->post('pages_title')),
					'pages_content' => html_purify($this->input->post('content',true),'comment'),
					'pages_type' => $this->input->post('pages_type',true),
					'pages_city' => $this->input->post('pages_city',true),
					'pages_time' => time(),
				);
				if($this->page_m->update_page($id,$str)){
					show_message($data['title'].'成功！',site_url('admin/pages'),1);
				}
			}
			$this->load->view('page_edit', $data);
			
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
			$data['siderbar'] = 'admin/webset';
			$data['title'] = '删除单页';
			$data['submenu'] = 'admin/pages';
			if($this->page_m->get_page_by_id($id)){
				$data['pageinfo'] = $this->page_m->get_page_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['pageinfo']['pages_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站单页','');
				}
				//删除
				if($this->page_m->del_page($id)){
					show_message($data['title'].'成功！',site_url('admin/pages'),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}

}