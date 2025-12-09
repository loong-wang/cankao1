<?php
class News extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('news_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	public function index()
	{
		redirect(site_url('admin/news/flist'));
	}
	
	public function flist($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '资讯列表';
			$data['siderbar'] = 'admin/news';
			$data['submenu'] = 'admin/news/flist';
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
			$config['base_url'] = site_url('admin/news/flist/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->news_m->count_news($ug,$data['city']);
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

			$data['news_list'] = $this->news_m->get_all_news_list($start, $limit,$ug,$data['city']);
			if($data['news_list']){
				foreach($data['news_list'] as $k => $v){
					$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
				}
			}

			$this->load->view('news_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addnews_form(){
		$this->form_validation->set_rules('news_title', '标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('news_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('news_city', '城市' , 'trim|required|integer');
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
			$data['title'] = '增加资讯';
			$data['siderbar'] = 'news';
			$data['submenu'] = 'admin/news/flist';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			
			if($_POST && $this->validate_addnews_form()){
				$str = array(
					'news_title' => strip_tags($this->input->post('news_title')),
					'news_type' => $this->input->post('news_type',true),
					'news_city' => $this->input->post('news_city',true),
					'news_content' => html_purify($this->input->post('content',true),'comment'),
					'news_from' => $this->input->post('news_from',true),
					'news_time' => time(),
				);
				if($this->news_m->add_news($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('news_add', $data);
			
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
			if(!$this->news_m->get_news_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改资讯';
			$data['siderbar'] = 'news';
			$data['submenu'] = 'admin/news/flist';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$data['newsinfo'] = $this->news_m->get_news_by_id($id);
			if($_POST && $this->validate_addnews_form()){
				if($this->session->userdata('ucity')>0 && $data['newsinfo']['news_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站资讯','');
				}
				$str = array(
					'news_title' => strip_tags($this->input->post('news_title')),
					'news_type' => $this->input->post('news_type',true),
					'news_city' => $this->input->post('news_city',true),
					'news_content' => html_purify($this->input->post('content',true),'comment'),
					'news_from' => $this->input->post('news_from',true),
					'news_time' => time(),
				);
				if($this->news_m->update_news($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('news_edit', $data);
			
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
			$data['siderbar'] = 'news';
			$data['title'] = '删除资讯';
			$data['submenu'] = 'admin/news/flist';
			if($this->news_m->get_news_by_id($id)){
				$data['newsinfo'] = $this->news_m->get_news_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['newsinfo']['news_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站资讯','');
				}
				//删除
				if($this->news_m->del_news($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function search()
	{
		//查找用户
		$data['siderbar'] = 'admin/news';
		$data['title'] = '搜索资讯';
		$data['submenu'] = 'admin/news/flist';
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
			$data['news_list']=$this->news_m->search_news($q);
			if($data['news_list']){
				foreach($data['news_list'] as $k => $v){
					$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
				}
			}
		}
		$this->load->view('news_list', $data);
	}
}