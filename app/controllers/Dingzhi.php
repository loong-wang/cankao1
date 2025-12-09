<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dingzhi extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model ('dingzhi_m');
		$this->load->model ('city_m');
		$this->load->library('myclass');
		$this->load->library('form_validation');	
		$this->load->helper('htmlpurifier');
	}
	
	public function haoma($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['citys']=$this->city_m->get_city_by_cid_web($cityid);
		if($data['citys']['cdomain']!=trim($this->config->item('site_domain')) && in_array($data['citys']['cdomain'], explode("|",$this->config->item('site_domains')))){
			$data['shouye_url']=site_url();			
		}else{
			$data['shouye_url']=site_url('home/city/'.$data['citys']['cid']);
		}
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		if ( ! $data['cityt'] = $this->cache->get('cityt'.$cityid))
		{
			$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
			$this->cache->save('cityt'.$cityid, $data['cityt'], 3600);
		}
		//城市session
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}
		$data['citylist'] = $this->city_m->get_city_all_list();
		if($_POST){
			$str = array(
				'dz_city' => strip_tags($this->input->post('dz_city',true)),
				'dz_title' => strip_tags($this->input->post('dz_title',true)),
				'dz_content' => html_purify($this->input->post('dz_content',true),'comment'),
				'dz_name' => strip_tags($this->input->post('dz_name',true)),
				'dz_tel' => strip_tags($this->input->post('dz_tel',true)),
				'dz_qq' => strip_tags($this->input->post('dz_qq',true)),
				'dz_email' => strip_tags($this->input->post('dz_email',true)),
				'dz_time' => time(),
				'dz_userid' => ($this->session->userdata('userid'))?$this->session->userdata('userid'):'0',
				'dz_lock' => 0,
			);
		
			if($this->dingzhi_m->add_dingzhi($str)){
				show_message('您的订制号码提交成功！请耐心等待我们与您联系',$data['shouye_url'],1);
			}
		}
		//act
		$data['act']='dingzhi/haoma';
		$data['title']='号码订制';
		$this->load->view('dingzhi_index',$data);
	}
}
