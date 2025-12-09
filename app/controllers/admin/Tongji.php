<?php
class Tongji extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('tongji_m');
		$this->load->config('cityset');
	}
	public function index()
	{
		redirect(site_url('admin/tongji/dingdan'));
	}
	
	public function dingdan($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单操作记录';
			$data['siderbar'] = 'admin/tongji';
			$data['submenu'] = 'admin/tongji/dingdan';

			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/tongji/dingdan');
			$config['total_rows'] = $this->tongji_m->count_user_shu($this->session->userdata('ucity'));
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

			$data['user_list'] = $this->tongji_m->get_all_users_list($start, $limit,$this->session->userdata('ucity'));
			if($data['user_list']){
				foreach($data['user_list'] as $k => $v){
					$data['user_list'][$k]['queren']=$this->tongji_m->count_work_type(1,1,$v['userid']);
					$data['user_list'][$k]['zhifu']=$this->tongji_m->count_work_type(1,2,$v['userid']);
					$data['user_list'][$k]['fahuo']=$this->tongji_m->count_work_type(1,3,$v['userid']);
					$data['user_list'][$k]['wuxiao']=$this->tongji_m->count_work_type(1,4,$v['userid']);
					$data['user_list'][$k]['wancheng']=$this->tongji_m->count_work_type(1,5,$v['userid']);
					$data['user_list'][$k]['zuofei']=$this->tongji_m->count_work_type(1,6,$v['userid']);
					$data['user_list'][$k]['guozhang']=$this->tongji_m->count_work_type(1,7,$v['userid']);
				}
			}

			$this->load->view('tongji_dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	
	public function xiaoshou($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '销售利润表';
			$data['siderbar'] = 'admin/tongji';
			$data['submenu'] = 'admin/tongji/xiaoshou';

			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/tongji/xiaoshou');
			$config['total_rows'] = $this->tongji_m->count_dingdan_shu($this->session->userdata('ucity'));
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

			$data['dan_list'] = $this->tongji_m->get_all_dingdan_list($start, $limit,$this->session->userdata('ucity'));

			$this->load->view('tongji_dan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
}