<?php
class Haoma extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('zifei_m');
		$this->load->model ('city_m');
		$this->load->model ('haoma_m');
		$this->load->model ('pinpai_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
	}
	public function index()
	{
		redirect(site_url('admin/haoma/haolist'));
	}
	
	public function renz($danhao)
	{
		if($danhao){
			$path='uploads/renz/'.$danhao;
			getAllDirAndFile($path);
		}
	}
	
	public function haolist($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '号码列表';
			$data['siderbar'] = 'admin/haoma';
			$data['submenu'] = 'admin/haoma/haolist';
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
			
			$data['pinpai_list'] = $this->pinpai_m->get_all_pinpai_list(0, 1000,$ug,$data['city']);

			//分页
			$limit = 20;
			$config['uri_segment'] = 6;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/haoma/haolist/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->haoma_m->count_haoma($ug,$data['city']);
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

			$data['haoma_list'] = $this->haoma_m->get_all_haoma_list($start, $limit,$ug,$data['city']);
			if($data['haoma_list']){
				foreach($data['haoma_list'] as $k => $v){
					$data['haoma_list'][$k]['city']=$v['hao_city'];					
					$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
					$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
					$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
					$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
					$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
					$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
				}
			}

			$this->load->view('haoma_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	public function listd($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '已订号码';
			$data['siderbar'] = 'admin/haoma';
			$data['submenu'] = 'admin/haoma/listd';
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
			$data['pinpai_list'] = $this->pinpai_m->get_all_pinpai_list(0, 1000,$ug,$data['city']);

			//分页
			$limit = 20;
			$config['uri_segment'] = 6;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/haoma/listd/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->haoma_m->count_haoma_lock_yd($ug,$data['city'],1);
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

			$data['haoma_list'] = $this->haoma_m->get_all_haoma_list_lock($start, $limit,$ug,$data['city'],1);
			if($data['haoma_list']){
				foreach($data['haoma_list'] as $k => $v){
					$data['haoma_list'][$k]['city']=$v['hao_city'];	
					$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
					$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
					$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
					$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
					$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
					$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
				}
			}

			$this->load->view('haoma_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function lists($ug=10000,$city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '已订号码';
			$data['siderbar'] = 'admin/haoma';
			$data['submenu'] = 'admin/haoma/lists';
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

			$data['pinpai_list'] = $this->pinpai_m->get_all_pinpai_list(0, 1000,$ug,$data['city']);
			//分页
			$limit = 20;
			$config['uri_segment'] = 6;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/haoma/lists/'.$ug.'/'.$data['city'].'/');
			$config['total_rows'] = $this->haoma_m->count_haoma_lock_yd($ug,$data['city'],2);
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

			$data['haoma_list'] = $this->haoma_m->get_all_haoma_list_lock($start, $limit,$ug,$data['city'],2);
			if($data['haoma_list']){
				foreach($data['haoma_list'] as $k => $v){
					$data['haoma_list'][$k]['city']=$v['hao_city'];	
					$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
					$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
					$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
					$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
					$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
					$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
				}
			}

			$this->load->view('haoma_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function dig_edit()
	{
		$id=$this->input->post('pk');
		$hao_dig=$this->input->post('value');
		$masterurl='admin/haoma/edit';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$str=array(
				'hao_dig'=>$hao_dig,
			);
			$this->haoma_m->update_haoma($id,$str);
		}
	}
	public function lock_edit()
	{
		$id=$this->input->post('pk');
		$hao_lock=$this->input->post('value');
		$masterurl='admin/haoma/edit';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$str=array(
				'hao_lock'=>$hao_lock,
			);
			$this->haoma_m->update_haoma($id,$str);
		}
	}
	
	public function getpinpai()
	{
		$city=$this->input->post('city');
		$type=$this->input->post('hao_type');
		if($city){
			$pinpai=$this->zifei_m->get_all_pinpai_by_city_type($city,$type);
			if($pinpai){
				foreach($pinpai as $k => $v){
					echo '<label><input name="hao_pinpai" type="radio" class="ace" value="'.$v['pin_num'].'">';
					echo '<span class="lbl"> '.$v['pin_title'].'</span></label>';
				}
			}else{
				echo '<font color="red">未找到，加载失败</font>';
			}
			
		}else{
			echo '<font color="red">品牌加载失败</font>';
		}		
	}
	
	private function validate_addhaoma_form(){
		$this->form_validation->set_rules('hao_title', '号码' , 'trim|required|min_length[8]|max_length[15]|xss_clean');
		$this->form_validation->set_rules('hao_type', '类型' , 'trim|required|integer');
		$this->form_validation->set_rules('hao_pinpai', '品牌' , 'trim|required|integer');
		$this->form_validation->set_rules('hao_city', '城市' , 'trim|required|integer');
		$this->form_validation->set_rules('hao_jiage', '最低价格' , 'trim|required|integer');
		$this->form_validation->set_rules('hao_huafei', '话费' , 'trim|required|integer');
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
			$data['title'] = '增加号码';
			$data['siderbar'] = 'admin/haoma';
			$data['submenu'] = 'admin/haoma/haolist';

			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}
			
			if($_POST && $this->validate_addhaoma_form()){
				$str = array(
					'hao_title' => strip_tags($this->input->post('hao_title')),
					'hao_type' => $this->input->post('hao_type',true),
					'hao_pinpai' => $this->input->post('hao_pinpai',true),
					'hao_city' => $this->input->post('hao_city',true),
					'hao_jiage' => $this->input->post('hao_jiage',true),
					'hao_huafei' => $this->input->post('hao_huafei',true),
					'hao_heyue' => $this->input->post('hao_heyue',true),
					'hao_user' => $this->input->post('hao_user',true),
					'hao_time' => time(),
				);
				if($this->haoma_m->check_haoma_by_title($this->input->post('hao_title'))){
					$hs=$this->haoma_m->check_haoma_by_title($this->input->post('hao_title'));
					if($this->haoma_m->update_haoma($hs['id'],$str)){
						show_message($this->input->post('hao_title').'更新成功！',site_url($data['submenu']),1);
					}
				}else{
					if($this->haoma_m->add_haoma($str)){
						show_message($data['title'].'成功！',site_url($data['submenu']),1);
					}
				}				
			}
			$this->load->view('haoma_add', $data);
			
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
			if(!$this->haoma_m->get_haoma_by_id($id)){
				show_message('参数不正确','');
			}
			$data['title'] = '修改号码';
			$data['siderbar'] = 'haoma';
			$data['submenu'] = 'admin/haoma/haolist';

			$data['citys'] = $this->city_m->get_city_all_list();
			$data['haomainfo'] = $this->haoma_m->get_haoma_by_id($id);
			$data['haomapinpai']=$this->haoma_m->get_pname_by_pin_num($data['haomainfo']['hao_pinpai']);
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}
			if($_POST && $this->validate_addhaoma_form()){
				if($this->session->userdata('ucity')>0 && $data['haomainfo']['hao_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站资费','');
				}
				$str = array(
					'hao_title' => strip_tags($this->input->post('hao_title')),
					'hao_type' => $this->input->post('hao_type',true),
					'hao_pinpai' => $this->input->post('hao_pinpai',true),
					'hao_city' => $this->input->post('hao_city',true),
					'hao_jiage' => $this->input->post('hao_jiage',true),
					'hao_huafei' => $this->input->post('hao_huafei',true),
					'hao_heyue' => $this->input->post('hao_heyue',true),
					'hao_user' => $this->input->post('hao_user',true),
					'hao_dig' => $this->input->post('hao_dig',true),
					'hao_lock' => $this->input->post('hao_lock',true),
					'hao_time' => time(),
				);
				if($this->haoma_m->update_haoma($id,$str)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('haoma_edit', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function get_hao_by_del()
	{
		$hao_user=$this->input->post('hao_user');
		$hao_time=$this->input->post('hao_time');
		$hao_city=$this->input->post('hao_city');
		$hao_type=$this->input->post('hao_type');
		$count = $this->haoma_m->get_count_by_user($hao_user,$hao_time,$hao_city,$hao_type);
		echo $count;
	}
	
	public function batch_process()
	{
		$masterurl='admin/haoma/delall';
		/** 检查登陆 */
		if(!$this->auth->is_admin() && !$this->auth->is_master($masterurl))
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$ids = array_slice($this->input->post(), 0, -1);
		if($this->input->post('batch_del')){
			if($this->db->where_in('id',$ids)->where('hao_lock',0)->delete('haoma')){
				show_message('批量删除号码成功！',site_url('admin/haoma/haolist'),1);
			}
		}
	}
	
	public function get_hao_by_tz()
	{
		$hao_user=$this->input->post('hao_user');
		$hao_city=$this->input->post('hao_city');
		$hao_timea=$this->input->post('hao_timea');
		$hao_timeb=$this->input->post('hao_timeb');
		$hao_jiagea=$this->input->post('hao_jiagea');
		$hao_jiageb=$this->input->post('hao_jiageb');
		$count = $this->haoma_m->get_count_by_tz($hao_user,$hao_city,$hao_timea,$hao_timeb,$hao_jiagea,$hao_jiageb);
		echo $count;
	}
	
	public function del_hao_by_del()
	{
		$masterurl='admin/haoma/delall';
		/** 检查登陆 */
		if(!$this->auth->is_admin() && !$this->auth->is_master($masterurl))
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$hao_user=$this->input->post('hao_user');
		$hao_time=$this->input->post('hao_time');
		$hao_city=$this->input->post('hao_city');
		$hao_type=$this->input->post('hao_type');
		if($this->haoma_m->del_haoma_by_user($hao_user,$hao_time,$hao_city,$hao_type)){
			echo '1';
		}else{
			echo '0';
		}		
	}
	
	public function tz_hao_by_tz()
	{
		$hao_user=$this->input->post('hao_user');
		$hao_city=$this->input->post('hao_city');
		$hao_timea=$this->input->post('hao_timea');
		$hao_timeb=$this->input->post('hao_timeb');
		$hao_jiagea=$this->input->post('hao_jiagea');
		$hao_jiageb=$this->input->post('hao_jiageb');
		$hao_nums=$this->input->post('hao_nums');
		if($this->haoma_m->tz_haoma_by_tz($hao_user,$hao_city,$hao_timea,$hao_timeb,$hao_jiagea,$hao_jiageb,$hao_nums)){
			echo '1';
		}else{
			echo '0';
		}		
	}
	
	public function delall()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'haoma';
			$data['title'] = '号码批量删除';
			$data['submenu'] = 'admin/haoma/delall';
			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->city_m->get_cname_by_ucity_luo($this->session->userdata('ucity'));
			}else{
				$data['city']='';
			}
			$this->load->view('haoma_delall', $data);
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function delalls()
	{
		$masterurl='admin/haoma/delall';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'haoma';
			$data['title'] = '号码批量删除';
			$data['submenu'] = 'admin/haoma/delalls';
			if($_POST){
				$hao_title=$this->input->post('hao_title',true);
				if($hao_title){
					$hao_title=str_replace("，",",",$hao_title);
					foreach(explode(',',$hao_title) as $val){
						$this->haoma_m->del_haoma_title_lock($val);
					}
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}
			}
			$this->load->view('haoma_delalls', $data);
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function tiaozheng()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'haoma';
			$data['title'] = '号码批量调整';
			$data['submenu'] = 'admin/haoma/tiaozheng';
			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->city_m->get_cname_by_ucity_luo($this->session->userdata('ucity'));
			}else{
				$data['city']='';
			}
			$this->load->view('haoma_tiaozheng', $data);
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
			$data['siderbar'] = 'haoma';
			$data['title'] = '删除号码';
			$data['submenu'] = 'admin/haoma/haolist';
			if($this->haoma_m->get_haoma_by_id($id)){
				$data['haomainfo'] = $this->haoma_m->get_haoma_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['haomainfo']['hao_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站号码','');
				}
				//删除
				if($this->haoma_m->del_haoma($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	
	public function search($ug=10000, $city=0, $q='', $sotype=0, $hao_pinpai=0, $page=1)
	{
		//查找用户
		$data['siderbar'] = 'haoma';
		$data['title'] = '搜索';
		$data['submenu'] = 'admin/haoma/haolist';
		$data['ug'] = ($this->input->post('ug'))?$this->input->post('ug'):$ug;
		$data['citys'] = $this->city_m->get_city_all_list();
		if($this->session->userdata('ucity')>0){
			$data['city']=$this->session->userdata('ucity');
		}else{
			$data['city']=($this->input->post('city'))?$this->input->post('city'):$city;
		}
		if($data['city']>0){
			$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
		}else{
			$data['cityname']='城市';
		}
		$data['pinpai_list'] = $this->pinpai_m->get_all_pinpai_list(0, 1000,0,$data['city']);
		
		$q=($this->input->post('q',true))?$this->input->post('q',true):$q;
		if(empty($q)){
			$q='foxno';
		}
		
		$sotype=($this->input->post('sotype'))?$this->input->post('sotype'):$sotype;
		$hao_pinpai=($this->input->post('hao_pinpai'))?$this->input->post('hao_pinpai'):$hao_pinpai;
		$b=(int)$this->input->post('hao_b');
		$data['hao_b']=$b;
		
		$data['hao_pinpai']=$hao_pinpai;
		$data['sotype']=$sotype;
		if($q=='foxno'){
			$data['q']='';
		}else{
			$data['q']=$q;
		}
		
		
		
		//分页
		$limit = 20;
		$config['uri_segment'] = 9;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('admin/haoma/search/'.$data['ug'].'/'.$data['city'].'/'.$q.'/'.$sotype.'/'.$hao_pinpai.'/'.$b);
		$config['total_rows'] = $this->haoma_m->count_haoma_searchm($q, $sotype, $hao_pinpai, $data['city'], $data['ug'],$b);
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
		
		$data['haoma_list']=$this->haoma_m->search_haomam($start, $limit, $q, $sotype, $hao_pinpai, $data['city'], $data['ug'],$b);	
	
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['city']=$v['hao_city'];	
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$this->load->view('haoma_list', $data);
	}
	
	

}