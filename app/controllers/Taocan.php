<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Taocan
#	scope:		PUBLIC

class Taocan extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('taocan_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
	}
	
	public function yidong($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=0;
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
		foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'套餐';
		$data['stitle'] = $hao_types.'套餐中心';
		$data['act'] = 'taocan/yidong';
		$data['sdao_url'] = 'taocan/yidong';
		$data['hao_url'] = 'yidong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('taocan/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->taocan_m->count_taocan($hao_type,$cityid);
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['taocan_list'] = $this->taocan_m->get_all_taocan_list($start, $limit,$hao_type,$cityid);
		if($data['taocan_list']){
			foreach($data['taocan_list'] as $k => $v){
				$data['taocan_list'][$k]['tc_city']=$this->city_m->get_cname_by_ucity($v['tc_city']);					
			}
		}
		$this->load->view('taocan_list', $data);
			
	}
	
	public function liantong($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=1;
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
		foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'套餐';
		$data['stitle'] = $hao_types.'套餐中心';
		$data['act'] = 'taocan/liantong';
		$data['sdao_url'] = 'taocan/liantong';
		$data['hao_url'] = 'liantong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('taocan/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->taocan_m->count_taocan($hao_type,$cityid);
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['taocan_list'] = $this->taocan_m->get_all_taocan_list($start, $limit,$hao_type,$cityid);
		if($data['taocan_list']){
			foreach($data['taocan_list'] as $k => $v){
				$data['taocan_list'][$k]['tc_city']=$this->city_m->get_cname_by_ucity($v['tc_city']);					
			}
		}
		$this->load->view('taocan_list', $data);
			
	}
	
	public function dianxin($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=2;
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
		foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'套餐';
		$data['stitle'] = $hao_types.'套餐中心';
		$data['act'] = 'taocan/dianxin';
		$data['sdao_url'] = 'taocan/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('taocan/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->taocan_m->count_taocan($hao_type,$cityid);
		$config['per_page'] = $limit;
		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['num_links'] = 5;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$start = ($page-1)*$limit;
		$data['pagination'] = $this->pagination->create_links();

		$data['taocan_list'] = $this->taocan_m->get_all_taocan_list($start, $limit,$hao_type,$cityid);
		if($data['taocan_list']){
			foreach($data['taocan_list'] as $k => $v){
				$data['taocan_list'][$k]['tc_city']=$this->city_m->get_cname_by_ucity($v['tc_city']);					
			}
		}
		$this->load->view('taocan_list', $data);
			
	}
	
	public function show($id)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->taocan_m->get_taocan_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['taocan']=$this->taocan_m->get_taocan_by_id($id);
			$data['title']=$data['taocan']['tc_title'];
			$data['content']=html_entity_decode(br2nl($data['taocan']['tc_content']));
			$data['description']=fox_substr(cleanhtml($data['taocan']['tc_content']),180);
			$data['dates']=date('Y-m-d',$data['taocan']['tc_time']);
			$data['llcs']=$data['taocan']['tc_llcs'];
			//更新浏览数
			$this->db->where('id',$id)->update('taocan',array('tc_llcs'=>$data['taocan']['tc_llcs']+1));
			
			$cityid=(int)$data['taocan']['tc_city'];
				$pingcity=$this->city_m->get_city_by_cid_web($cityid);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
				if($data['taocan']['tc_type']==$k){
					$hao_types=$s;
				}
			}
			$data['citys']='';
			if($data['taocan']['tc_type']==0){
				$data['act']='taocan/yidong';				
				$data['sdao_url']='taocan/yidong';				
			}
			$data['stitle']=$hao_types.'套餐';				
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
			
			$this->load->view('taocan_show',$data);
		}
	}
	
}