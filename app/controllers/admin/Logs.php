<?php
class Logs extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('log_m');
		$this->load->config('cityset');
	}
	
	public function index($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '登录日志';
			$data['siderbar'] = 'admin/logs';
			$data['submenu'] = 'admin/logs/index';

			//分页
			$limit = 10;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/logs/index');
			$config['total_rows'] = $this->db->count_all('login_log');
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

			$data['logs_list'] = $this->log_m->log_list($start, $limit);

			$this->load->view('logs_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function del($loid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'admin/logs';
			$data['title'] = '删除日志';
			$data['submenu'] = 'admin/logs/index';
			//删除
			if($this->log_m->del_log($loid)){
				show_message($data['title'].'成功！',site_url($data['submenu']),1);
			}				

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function del_all()
	{
		$masterurl='admin/logs/del';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['siderbar'] = 'admin/logs';
			$data['title'] = '删除日志';
			$data['submenu'] = 'admin/logs/index';
			//删除
			$this->log_m->del_all();
			show_message($data['title'].'成功！',site_url($data['submenu']),1);

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	
}