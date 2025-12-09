<?php
class Pinpai extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('pinpai_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
	}
	public function index()
	{
		redirect(site_url('admin/pinpai/listpp'));
	}
	
	public function listpp($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '品牌列表';
			$data['siderbar'] = 'admin/pinpai';
			$data['submenu'] = 'admin/pinpai/listpp';
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
			$config['base_url'] = site_url('admin/pinpai/listpp/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->pinpai_m->count_pinpai($ug,$data['city']);
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

			$data['pinpai_list'] = $this->pinpai_m->get_all_pinpai_list($start, $limit,$ug,$data['city']);
			if($data['pinpai_list']){
				foreach($data['pinpai_list'] as $k => $v){
					$data['pinpai_list'][$k]['pin_city']=$this->city_m->get_cname_by_ucity($v['pin_city']);					
				}
			}

			$this->load->view('pinpai_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_addpinpai_form(){
		$this->form_validation->set_rules('pin_title', '品牌名称' , 'trim|required|min_length[2]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('pin_num', '品牌数字' , 'trim|required|integer|min_length[1]|max_length[20]|is_unique[pinpai.pin_num]|xss_clean');
		$this->form_validation->set_rules('pin_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_shuxing', '属性' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_city', '城市选择' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_tezheng[]', '特征' , 'trim|required');
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
			$data['title'] = '增加品牌';
			$data['siderbar'] = 'pinpai';
			$data['submenu'] = 'admin/pinpai/listpp';

			$data['citys'] = $this->city_m->get_city_all_list();
			
			if($_POST && $this->validate_addpinpai_form()){
				if(is_array($this->input->post('pin_tezheng'))){
					$pin_tezheng=implode(',',$this->input->post('pin_tezheng'));
				}else{
					$pin_tezheng=$this->input->post('pin_tezheng');
				}
				$str = array(
					'pin_title' => strip_tags($this->input->post('pin_title')),
					'pin_num' => $this->input->post('pin_num',true),
					'pin_type' => $this->input->post('pin_type',true),
					'pin_shuxing' => $this->input->post('pin_shuxing',true),
					'pin_city' => $this->input->post('pin_city',true),
					'pin_tezheng' => $pin_tezheng,
					'pin_time' => time(),
				);
				if($this->pinpai_m->add_pinpai($str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('pinpai_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	private function validate_editpinpai_form(){
		$this->form_validation->set_rules('pin_title', '品牌名称' , 'trim|required|min_length[2]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('pin_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_shuxing', '属性' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_city', '城市选择' , 'trim|required|integer');
		$this->form_validation->set_rules('pin_tezheng[]', '特征' , 'trim|required');
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
			if(!$this->pinpai_m->get_pinpai_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改品牌';
			$data['siderbar'] = 'pinpai';
			$data['submenu'] = 'admin/pinpai/listpp';

			$data['citys'] = $this->city_m->get_city_all_list();
			$data['pinpaiinfo'] = $this->pinpai_m->get_pinpai_by_id($id);
			
			if($_POST && $this->validate_editpinpai_form()){
				if($this->session->userdata('ucity')>0 && $data['pinpaiinfo']['pin_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站品牌','');
				}
				if( is_array($this->input->post('pin_tezheng'))){
					$pin_tezheng=implode(',',$this->input->post('pin_tezheng'));
				}else{
					$pin_tezheng=$this->input->post('pin_tezheng');
				}
				$str = array(
					'pin_title' => strip_tags($this->input->post('pin_title')),
					'pin_type' => $this->input->post('pin_type',true),
					'pin_shuxing' => $this->input->post('pin_shuxing',true),
					'pin_city' => $this->input->post('pin_city',true),
					'pin_tezheng' => $pin_tezheng,
					'pin_time' => time(),
				);
				if($this->pinpai_m->update_pinpai($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('pinpai_edit', $data);
			
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
			$data['siderbar'] = 'pinpai';
			$data['title'] = '删除品牌';
			$data['submenu'] = 'admin/pinpai/listpp';
			if($this->pinpai_m->get_pinpai_by_id($id)){
				$data['pinpaiinfo'] = $this->pinpai_m->get_pinpai_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['pinpaiinfo']['pin_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站品牌','');
				}
				//删除
				if($this->pinpai_m->del_pinpai($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}

}