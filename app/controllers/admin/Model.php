<?php
class Model extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->config('modelset');
		$this->load->model('model_m');
		$this->load->library('form_validation');
	}

	public function index($page=1)
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '模型表设置';
		$data['siderbar'] = 'admin/model';
		$data['submenu'] = 'admin/model/index';
		//分页
		$limit = 15;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/model/index');
		$config['total_rows'] = $this->db->count_all('model');
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

		$data['model_list'] = $this->model_m->get_all_model_list($start, $limit);
		if($data['model_list']){
			foreach($data['model_list'] as $k => $v){
				$data['model_list'][$k]['field_list'] = $this->model_m->get_all_field_list($v['id']);
			}
		}
		$this->load->view('model', $data);
	}
	
	private function validate_addmodel_form(){
		$this->form_validation->set_rules('title', '模型名称' , 'trim|required|min_length[2]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('table_name', '表名称' , 'trim|required|min_length[2]|max_length[50]|callback_oks_check|callback_url_check|xss_clean');
		$this->form_validation->set_rules('remark', '描述' , 'trim|min_length[2]|max_length[100]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	private function validate_editmodel_form(){
		$this->form_validation->set_rules('title', '模型名称' , 'trim|required|min_length[2]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('table_name', '表名称' , 'trim|required|min_length[2]|max_length[50]|callback_oks_check|xss_clean');
		$this->form_validation->set_rules('remark', '描述' , 'trim|min_length[2]|max_length[100]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function oks_check($str)
	{  
		if(!preg_match('/^(?!_)(?!.*?_$)[A-Za-z0-9_\-\/]+$/u', $str)){
			$this->form_validation->set_message('oks_check', '%s 必须为数字或者字母及下划线');
  			return false;
		} else{
			return true;
		}
	}
	public function url_check($str)
	{  
		if($this->model_m->model_check_by_url($str)){
			$this->form_validation->set_message('url_check', '%s 已经存在，不能重复');
  			return false;
		} else{
			return true;
		}
	}
	
	public function add()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '增加模型表';
		$data['siderbar'] = 'admin/model';
		$data['submenu'] = 'admin/model/index';
		if($_POST && $this->validate_addmodel_form()){
			$str=array(
				'name'=>Pinyin($this->input->post('title')),
				'title'=>$this->input->post('title'),
				'table_name'=>$this->input->post('table_name'),
				'create_time'=>time(),
				'update_time'=>time(),
			);
			if($this->model_m->add_model($str)){				
				show_message($data['title'].'操作成功！',site_url($data['submenu']),1);
			}
		}
		$this->load->view('model_add', $data);
	}
	
	public function edit($id)
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '修改模型表';
		$data['siderbar'] = 'admin/model';
		$data['submenu'] = 'admin/model/index';
		if(!$this->model_m->get_model_info_by_id($id)){
			show_message('参数错误');
		}else{
			$data['modelinfo'] = $this->model_m->get_model_info_by_id($id);
		}
		
		if($_POST && $this->validate_editmodel_form()){
			$str=array(
				'name'=>Pinyin($this->input->post('title')),
				'title'=>$this->input->post('title'),
				'table_name'=>$this->input->post('table_name'),
				'update_time'=>time(),
			);
			if($this->model_m->update_model($id, $str)){
				show_message($data['title'].'操作成功！',site_url($data['submenu']),1);
			}
		}
		$this->load->view('model_edit', $data);
	}
	
	private function validate_addfield_form(){
		$this->form_validation->set_rules('name', '字段标识' , 'trim|required|min_length[2]|max_length[50]|callback_oksf_check|xss_clean');
		$this->form_validation->set_rules('types', '数据类型' , 'trim|required|min_length[2]|max_length[100]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function oksf_check($str)
	{  
		if(!preg_match('/^(?!_)(?!.*?_$)[A-Za-z0-9_\-\/]+$/u', $str)){
			$this->form_validation->set_message('oksf_check', '%s 必须为数字或者字母及下划线');
  			return false;
		} else{
			return true;
		}
	}
	
	public function add_field($id)
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '增加字段';
		$data['siderbar'] = 'admin/model';
		$data['submenu'] = 'admin/model/index';
		if(!$this->model_m->get_model_info_by_id($id)){
			show_message('参数错误');
		}else{
			$data['modelinfo'] = $this->model_m->get_model_info_by_id($id);
		}
		
		if($_POST && $this->validate_addfield_form()){
			if($this->model_m->check_by_field_name($this->input->post('name'),$id)){
				show_message($this->input->post('name').'已经存在',site_url('admin/model/index'));
			}
			$stra=array();
			$strb=array();
			$stra=array(
				'model_id'=>$id,
				'model'=>$data['modelinfo']['table_name'],
				'name'=>$this->input->post('name'),
				'keys'=>$this->input->post('keys'),
				'remark'=>$this->input->post('remark'),
				'ords'=>$this->input->post('ords'),
				'create_time'=>time(),
			);
			foreach($this->config->item('FIELD_LIST') as $k => $v){
				if($v['types']==$this->input->post('types')){
					$strb=$v;
				}
			}
			$str = array_merge_recursive($stra, $strb);

			if($this->model_m->add_field($str)){
				show_message($data['title'].'操作成功！',site_url($data['submenu']),1);
			}
		}
		$this->load->view('model_addfield', $data);
	}
	
	public function edit_field($id)
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '修改字段';
		$data['siderbar'] = 'admin/model';
		$data['submenu'] = 'admin/model/index';
		if(!$this->model_m->get_field_info_by_id($id)){
			show_message('参数错误');
		}else{
			$data['fieldinfo'] = $this->model_m->get_field_info_by_id($id);
		}
		
		if($_POST && $this->validate_addfield_form()){
			$stra=array();
			$strb=array();
			$strc=array();
			if($this->model_m->check_by_field_name($this->input->post('name'),$data['fieldinfo']['model_id'])){
				$strc=array();
			}else{
				$strc=array('name'=>$this->input->post('name'));
			}
			$stra=array(				
				'keys'=>$this->input->post('keys'),
				'model'=>$this->input->post('model'),
				'remark'=>$this->input->post('remark'),
				'ords'=>$this->input->post('ords'),
				'create_time'=>time(),
			);
			foreach($this->config->item('FIELD_LIST') as $k => $v){
				if($v['types']==$this->input->post('types')){
					$strb=$v;
				}
			}
			$str = array_merge_recursive($stra, $strb, $strc);

			if($this->model_m->update_field($id,$str)){
				show_message($data['title'].'操作成功！',site_url($data['submenu']),1);
			}
		}
		$this->load->view('model_editfield', $data);
	}
	
	public function del($id)
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{
			$data['siderbar'] = 'admin/model';
			$data['title'] = '删除模型表';
			$data['submenu'] = 'admin/model/index';
			if($this->model_m->get_all_field_list($id)){
				show_message('请先删除其下面的字段');
			}
			//删除
			if($this->model_m->del_model($id)){
				show_message($data['title'].'成功！',site_url($data['submenu']),1);
			}				

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function del_field($id)
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{
			$data['siderbar'] = 'admin/model';
			$data['title'] = '删除字段';
			$data['submenu'] = 'admin/model/index';
			//删除
			if($this->model_m->del_field($id)){
				show_message($data['title'].'成功！',site_url($data['submenu']),1);
			}				

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	
}