<?php
class Ads extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('ads_m');
		$this->load->model ('city_m');
		$this->load->library('form_validation');
	}
	
	
	public function index($city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '广告列表';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/ads';
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
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/ads/index/'.$data['city'].'/');
			$config['total_rows'] = $this->ads_m->count_ads($data['city']);
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

			$data['ads_list'] = $this->ads_m->get_all_ads_list($start, $limit,$data['city']);
			if($data['ads_list']){
				foreach($data['ads_list'] as $k => $v){
					$data['ads_list'][$k]['ads_city']=$this->city_m->get_cname_by_ucity($v['ads_city']);					
				}
			}

			$this->load->view('ads_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addads_form(){
		$this->form_validation->set_rules('ads_title', '广告标题' , 'trim|required|min_length[2]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('ads_pic', '广告图片' , 'trim|required|xss_clean');
		$this->form_validation->set_rules('ads_city', '城市选择' , 'trim|required|integer');
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
			$data['title'] = '增加广告';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/ads';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			
			if($_POST && $this->validate_addads_form()){
				$str = array(
					'ads_title' => strip_tags($this->input->post('ads_title')),
					'ads_url' => $this->input->post('ads_url',true),
					'ads_pic' => $this->input->post('ads_pic',true),
					'ads_city' => $this->input->post('ads_city',true),
					'ads_time' => time(),
				);
				if($this->ads_m->add_ads($str)){
					show_message($data['title'].'成功！',site_url('admin/ads/index'),1);
				}
			}
			$this->load->view('ads_add', $data);
			
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
			if(!$this->ads_m->get_ads_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改广告';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/ads';

			$data['citys'] = $this->city_m->get_city_all_list_ping();
			$data['adsinfo'] = $this->ads_m->get_ads_by_id($id);
			
			if($_POST && $this->validate_addads_form()){
				if($this->session->userdata('ucity')>0 && $data['adsinfo']['ads_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站广告','');
				}
				$str = array(
					'ads_title' => strip_tags($this->input->post('ads_title')),
					'ads_url' => $this->input->post('ads_url',true),
					'ads_pic' => $this->input->post('ads_pic',true),
					'ads_city' => $this->input->post('ads_city',true),
					'ads_time' => time(),
				);
				if($this->ads_m->update_ads($id,$str)){
					if($this->input->post('ads_pic')!=$this->input->post('ads_pico')){
						unlink(FCPATH.$this->input->post('ads_pico'));
					}
					show_message($data['title'].'成功！',site_url('admin/ads/index'),1);
				}
			}
			$this->load->view('ads_edit', $data);
			
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
			$data['title'] = '删除广告';
			$data['submenu'] = 'admin/ads';
			if($this->ads_m->get_ads_by_id($id)){
				$data['adsinfo'] = $this->ads_m->get_ads_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['adsinfo']['ads_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站品牌','');
				}
				//删除
				if($this->ads_m->del_ads($id)){
					unlink(FCPATH.$data['adsinfo']['ads_pic']);
					show_message($data['title'].'成功！',site_url('admin/ads/index'),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}

}