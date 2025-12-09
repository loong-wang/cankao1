<?php
class Memuset extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	
	private function validate_memuset_form(){
		$this->form_validation->set_rules('title', '标题' , 'trim|required|min_length[2]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('url', '地址' , 'trim|required|min_length[2]|max_length[50]|callback_oks_check|callback_url_check|xss_clean');
		$this->form_validation->set_rules('ico', '图标' , 'trim|required|callback_oks_check|min_length[2]|max_length[40]');
		$this->form_validation->set_rules('sort', '排序' , 'trim|required|integer');
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
	
	private function validate_ememuset_form(){
		$this->form_validation->set_rules('title', '标题' , 'trim|required|min_length[2]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('url', '地址' , 'trim|required|min_length[2]|max_length[50]|callback_oks_check|xss_clean');
		$this->form_validation->set_rules('ico', '图标' , 'trim|required|callback_oks_check|min_length[2]|max_length[40]');
		$this->form_validation->set_rules('sort', '排序' , 'trim|required|integer');
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
			$this->form_validation->set_message('oks_check', '%s 格式不正确');
  			return false;
		} else{
			return true;
		}
	}
	
	public function url_check($str)
	{  
		if($this->memu_m->memu_check_by_url($str)){
			$this->form_validation->set_message('url_check', '%s 地址已经存在，不能重复');
  			return false;
		} else{
			return true;
		}
	}
	
	private function data_post($arr)
	{
		if( is_array($this->input->post('group_type'))){
			$group_type=implode(',',$this->input->post('group_type'));
		}else{
			$group_type=($this->input->post('group_type'))?$this->input->post('group_type'):'0';
		}
		if($this->input->post('mtype')==10){
			$group_types=$group_type.',0';
		}else{
			$group_types=$group_type;
		}
		$str = array(
			'title'=>$this->input->post('title'),
			'url'=>$this->input->post('url'),
			'ico'=>$this->input->post('ico'),
			'remark'=>$this->input->post('remark'),
			'sort'=>$this->input->post('sort'),
			'pid'=>$this->input->post('pid'),
			'group_type'=>$group_types,
			'mtype'=>$this->input->post('mtype'),
			'mlock'=>$this->input->post('mlock'),
			'ctime'=>time(),
		);		
		return $str;
	}
	
	public function index($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '所有菜单';
			$data['memuset'] = 0;
			$data['siderbar'] = 'memuset';
			$data['submenu'] = 'memuset/back';

			//分页
			$limit = 6;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/memuset/index/');
			$config['total_rows'] = $this->memu_m->count_memu(0,0);
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

			$data['memu_list'] = $this->memu_m->get_all_memus($start, $limit, 0);
			if($data['memu_list']){
				foreach($data['memu_list'] as $k => $v){
					$data['memu_list'][$k]['count']=$this->memu_m->count_memu($v['id'],0);
					$data['memu_list'][$k]['group_type'] = $this->group_m->get_all_group_name_by_mgroup($v['group_type']);
					$data['memu_list'][$k]['memu_list_s'] = $this->memu_m->get_all_memus_by_pid($v['id'], $data['memu_list'][$k]['count'], 0);				
					if($data['memu_list'][$k]['memu_list_s']){
						foreach($data['memu_list'][$k]['memu_list_s'] as $ks => $s){
							$data['memu_list'][$k]['memu_list_s'][$ks]['count_s']=$this->memu_m->count_memu($s['id'],0);
							$data['memu_list'][$k]['memu_list_s'][$ks]['group_type_s'] = $this->group_m->get_all_group_name_by_mgroup($s['group_type']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] = $this->memu_m->get_all_memus_by_pid($s['id'], $data['memu_list'][$k]['memu_list_s'][$ks]['count_s'], $data['memuset']);
							if($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t']){
								foreach($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] as $kt => $t){
									$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'][$kt]['group_type_t']=$this->group_m->get_all_group_name_by_mgroup($t['group_type']);
								}
							}
						}
					}
				}
			}

			$this->load->view('memuset', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function pubsite($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '公共菜单';
			$data['memuset'] = 10;
			$data['siderbar'] = 'memuset';
			$data['submenu'] = 'memuset/pubsite';
			
			//分页
			$limit = 6;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/memuset/pubsite/');
			$config['total_rows'] = $this->memu_m->count_memu(0,$data['memuset']);
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

			$data['memu_list'] = $this->memu_m->get_all_memus($start, $limit, $data['memuset']);
			if($data['memu_list']){
				foreach($data['memu_list'] as $k => $v){
					$data['memu_list'][$k]['count']=$this->memu_m->count_memu($v['id'],$data['memuset']);
					$data['memu_list'][$k]['group_type'] = $this->group_m->get_all_group_name_by_mgroup($v['group_type']);
					$data['memu_list'][$k]['memu_list_s'] = $this->memu_m->get_all_memus_by_pid($v['id'], $data['memu_list'][$k]['count'], $data['memuset']);				
					if($data['memu_list'][$k]['memu_list_s']){
						foreach($data['memu_list'][$k]['memu_list_s'] as $ks => $s){
							$data['memu_list'][$k]['memu_list_s'][$ks]['count_s']=$this->memu_m->count_memu($s['id'],$data['memuset']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['group_type_s'] = $this->group_m->get_all_group_name_by_mgroup($s['group_type']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] = $this->memu_m->get_all_memus_by_pid($s['id'], $data['memu_list'][$k]['memu_list_s'][$ks]['count_s'], $data['memuset']);
							if($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t']){
								foreach($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] as $kt => $t){
									$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'][$kt]['group_type_t']=$this->group_m->get_all_group_name_by_mgroup($t['group_type']);
								}
							}
						}
					}
				}
			}

			$this->load->view('memuset', $data);			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}

	public function front($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '前台菜单';
			$data['memuset'] = 1;
			$data['siderbar'] = 'memuset';
			$data['submenu'] = 'memuset/front';
			
			//分页
			$limit = 6;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/memuset/front/');
			$config['total_rows'] = $this->memu_m->count_memu(0,$data['memuset']);
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

			$data['memu_list'] = $this->memu_m->get_all_memus($start, $limit, $data['memuset']);
			if($data['memu_list']){
				foreach($data['memu_list'] as $k => $v){
					$data['memu_list'][$k]['count']=$this->memu_m->count_memu($v['id'],$data['memuset']);
					$data['memu_list'][$k]['group_type'] = $this->group_m->get_all_group_name_by_mgroup($v['group_type']);
					$data['memu_list'][$k]['memu_list_s'] = $this->memu_m->get_all_memus_by_pid($v['id'], $data['memu_list'][$k]['count'], $data['memuset']);				
					if($data['memu_list'][$k]['memu_list_s']){
						foreach($data['memu_list'][$k]['memu_list_s'] as $ks => $s){
							$data['memu_list'][$k]['memu_list_s'][$ks]['count_s']=$this->memu_m->count_memu($s['id'],$data['memuset']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['group_type_s'] = $this->group_m->get_all_group_name_by_mgroup($s['group_type']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] = $this->memu_m->get_all_memus_by_pid($s['id'], $data['memu_list'][$k]['memu_list_s'][$ks]['count_s'], $data['memuset']);
							if($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t']){
								foreach($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] as $kt => $t){
									$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'][$kt]['group_type_t']=$this->group_m->get_all_group_name_by_mgroup($t['group_type']);
								}
							}
						}
					}
				}
			}

			$this->load->view('memuset', $data);			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}

	public function back($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '后台菜单';
			$data['memuset'] = 11;
			$data['siderbar'] = 'memuset';
			$data['submenu'] = 'memuset/back';

			//分页
			$limit = 6;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/memuset/back/');
			$config['total_rows'] = $this->memu_m->count_memu(0,$data['memuset']);
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

			$data['memu_list'] = $this->memu_m->get_all_memus($start, $limit, $data['memuset']);
			if($data['memu_list']){
				foreach($data['memu_list'] as $k => $v){
					$data['memu_list'][$k]['count']=$this->memu_m->count_memu($v['id'],$data['memuset']);
					$data['memu_list'][$k]['group_type'] = $this->group_m->get_all_group_name_by_mgroup($v['group_type']);
					$data['memu_list'][$k]['memu_list_s'] = $this->memu_m->get_all_memus_by_pid($v['id'], $data['memu_list'][$k]['count'], $data['memuset']);				
					if($data['memu_list'][$k]['memu_list_s']){
						foreach($data['memu_list'][$k]['memu_list_s'] as $ks => $s){
							$data['memu_list'][$k]['memu_list_s'][$ks]['count_s']=$this->memu_m->count_memu($s['id'],$data['memuset']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['group_type_s'] = $this->group_m->get_all_group_name_by_mgroup($s['group_type']);
							$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] = $this->memu_m->get_all_memus_by_pid($s['id'], $data['memu_list'][$k]['memu_list_s'][$ks]['count_s'], $data['memuset']);
							if($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t']){
								foreach($data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'] as $kt => $t){
									$data['memu_list'][$k]['memu_list_s'][$ks]['memu_list_t'][$kt]['group_type_t']=$this->group_m->get_all_group_name_by_mgroup($t['group_type']);
								}
							}
						}
					}
				}
			}

			$this->load->view('memuset', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function add($sets,$pid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if($sets>10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'120px'});";
			}elseif($sets<10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'150px'});";
			}else{
				$data['setsh'] = '';
			}
			$this->load->helper('form');
			$data['groups'] = $this->group_m->group_list_by_sets($sets);		
			$data['memus'] = $this->memu_m->memu_list_by_pid($sets,0);	
			if($pid>0){
				$data['memust'] = $this->memu_m->get_memu_info_by_id($pid);
			}else{
				$data['memust'] = '';
			}
			$data['siderbar'] = 'memuset';
			$data['title'] = '添加权限菜单';
			$data['memuset'] = $sets;
			$data['submenu'] = 'admin/memuset';

			if($_POST && $this->validate_memuset_form()){
				$str=$this->data_post($_POST);//引用
				if($this->input->post('mtype')<10){
					$url='admin/memuset/front';
				}elseif($this->input->post('mtype')>10){
					$url='admin/memuset/back';
				}elseif($this->input->post('mtype')==10){
					$url='admin/memuset/pubsite';
				}else{
					$url='admin/memuset';
				}
				if($this->memu_m->add_memu($str)){
					show_message('增加权限菜单成功！',site_url($url),1);
				}
			}
			$this->load->view('memuset_add', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function add_act($sets,$pid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if($sets>10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'120px'});";
			}elseif($sets<10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'150px'});";
			}else{
				$data['setsh'] = '';
			}
			$this->load->helper('form');
			$data['groups'] = $this->group_m->group_list_by_sets($sets);		
			$data['memus'] = $this->memu_m->memu_list_by_pid($sets,0);	
			if($pid>0){
				$data['memust'] = $this->memu_m->get_memu_info_by_id($pid);
			}else{
				$data['memust'] = '';
			}
			$data['siderbar'] = 'memuset';
			$data['title'] = '添加权限动作';
			$data['memuset'] = $sets;
			$data['submenu'] = 'admin/memuset';

			if($_POST && $this->validate_memuset_form()){
				$str=$this->data_post($_POST);//引用
				if($this->input->post('mtype')<10){
					$url='admin/memuset/front';
				}elseif($this->input->post('mtype')>10){
					$url='admin/memuset/back';
				}elseif($this->input->post('mtype')==10){
					$url='admin/memuset/pubsite';
				}else{
					$url='admin/memuset';
				}
				if($this->memu_m->add_memu($str)){
					show_message('增加权限动作成功！',site_url($url),1);
				}
			}
			$this->load->view('memuset_add_act', $data);			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function edit($id,$sets,$pid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if($sets>10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'120px'});";
			}elseif($sets<10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'150px'});";
			}else{
				$data['setsh'] = '';
			}
			if($this->memu_m->get_memu_info_by_id($id)){
				$this->load->helper('form');
				$data['memuinfo'] = $this->memu_m->get_memu_info_by_id($id);
				$data['groups'] = $this->group_m->group_list_by_sets($sets);		
				$data['memus'] = $this->memu_m->memu_list_by_pid($sets,0);
				if($pid>0){
					$data['memust'] = $this->memu_m->get_memu_info_by_id($pid);
				}else{
					$data['memust'] = '';
				}
				$data['siderbar'] = 'memuset';
				$data['title'] = '修改权限菜单';
				$data['memuset'] = $sets;
				$data['submenu'] = 'admin/memuset';
				if($_POST && $this->validate_ememuset_form()){
					$str=$this->data_post($_POST);//引用
					if($this->input->post('mtype')<10){
						$url='admin/memuset/front';
					}elseif($this->input->post('mtype')>10){
						$url='admin/memuset/back';
					}elseif($this->input->post('mtype')==10){
						$url='admin/memuset/pubsite';
					}else{
						$url='admin/memuset';
					}
					if($this->memu_m->update_memu($id,$str)){
						show_message($data['title'].'成功',site_url($url),1);
					}
				}
				$this->load->view('memuset_edit', $data);
			}else{
				show_message('参数错误！','');
			}				
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function edit_act($id,$sets,$pid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if($sets>10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'120px'});";
			}elseif($sets<10){
				$data['setsh'] = "container1.find('select.form-control[multiple]').css({'height':'150px'});";
			}else{
				$data['setsh'] = '';
			}
			if($this->memu_m->get_memu_info_by_id($id)){
				$this->load->helper('form');
				$data['memuinfo'] = $this->memu_m->get_memu_info_by_id($id);
				$data['groups'] = $this->group_m->group_list_by_sets($sets);		
				$data['memus'] = $this->memu_m->memu_list_by_pid($sets,0);
				if($pid>0){
					$data['memust'] = $this->memu_m->get_memu_info_by_id($pid);
				}else{
					$data['memust'] = '';
				}
				$data['siderbar'] = 'memuset';
				$data['title'] = '修改权限操作';
				$data['memuset'] = $sets;
				$data['submenu'] = 'admin/memuset';
				if($_POST && $this->validate_ememuset_form()){
					$str=$this->data_post($_POST);//引用
					if($this->input->post('mtype')<10){
						$url='admin/memuset/front';
					}elseif($this->input->post('mtype')>10){
						$url='admin/memuset/back';
					}elseif($this->input->post('mtype')==10){
						$url='admin/memuset/pubsite';
					}else{
						$url='admin/memuset';
					}
					if($this->memu_m->update_memu($id,$str)){
						show_message($data['title'].'成功',site_url($url),1);
					}
				}
				$this->load->view('memuset_edit_act', $data);
			}else{
				show_message('参数错误！','');
			}			
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
			$data['siderbar'] = 'memuset';
			$data['title'] = '删除权限菜单';
			$data['submenu'] = 'admin/memuset';

			//删除链接
			if($this->memu_m->del_memu($id)){
				show_message('权限菜单删除成功！',site_url($data['submenu']),1);
			}			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}


	}
	
	public function del_act($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'memuset';
			$data['title'] = '删除权限动作';
			$data['submenu'] = 'admin/memuset';

			//删除链接
			if($this->memu_m->del_memu($id)){
				show_message('权限动作删除成功！',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
}