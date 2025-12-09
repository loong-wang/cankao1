<?php
class Haoset extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->config('haoset');
	}

	public function index()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '号码设置';
		$data['siderbar'] = 'admin/haoset';
		$data['submenu'] = 'admin/haoset/index';
		if($_POST){
			$config['hao_types'] = $this->input->post('hao_types');
			foreach(explode("|",$this->input->post('hao_types')) as $k => $v){
				$config['hao_types_'.$k.''] = $this->input->post('hao_types_'.$k.'');
			}
			
			$config['hao_ends'] = $this->input->post('hao_ends');
			foreach(explode("|",$this->input->post('hao_ends')) as $k => $v){
				$config['hao_ends_'.$k.''] = $this->input->post('hao_ends_'.$k.'');
			}
			
			$config['hao_jiages'] = $this->input->post('hao_jiages');
			foreach(explode("|",$this->input->post('hao_jiages')) as $k => $v){
				$config['hao_jiages_'.$k.''] = $this->input->post('hao_jiages_'.$k.'');
			}
			
			$config['hao_shuweis'] = $this->input->post('hao_shuweis');
			foreach(explode("|",$this->input->post('hao_shuweis')) as $k => $v){
				$config['hao_shuweis_'.$k.''] = $this->input->post('hao_shuweis_'.$k.'');
			}
			
			$config['hao_redians'] = $this->input->post('hao_redians');
			foreach(explode("|",$this->input->post('hao_redians')) as $k => $v){
				$config['hao_redians_'.$k.''] = $this->input->post('hao_redians_'.$k.'');
			}
			
			$config['hao_tedians'] = $this->input->post('hao_tedians');
			foreach(explode("|",$this->input->post('hao_tedians')) as $k => $v){
				$config['hao_tedians_'.$k.''] = $this->input->post('hao_tedians_'.$k.'');
			}
			
			$config['hao_yues'] = $this->input->post('hao_yues');
			foreach(explode("|",$this->input->post('hao_yues')) as $k => $v){
				$config['hao_yues_'.$k.''] = $this->input->post('hao_yues_'.$k.'');
			}
			
			$config['hao_heyus'] = $this->input->post('hao_heyus');
			foreach(explode("|",$this->input->post('hao_heyus')) as $k => $v){
				$config['hao_heyus_'.$k.''] = $this->input->post('hao_heyus_'.$k.'');
			}
			
			$this->config->set_item('haoset', $config);
			$this->config->save('haoset',$config);
			show_message($data['title'].'更新成功',site_url($data['submenu']),1);
		}
		$this->load->view('hao_set', $data);
	}
	
	
}