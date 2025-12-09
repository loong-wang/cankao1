<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Page
#	scope:		PUBLIC

class Page extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	
	public function hezuo($cityid)
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

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,1,5);

		$data['title'] = '业务合作';
		$data['stitle'] = '业务合作';
		$data['act'] = 'page/hezuo';
		$data['sdao_url'] = 'page/hezuo/'.$data['citys']['cid'];
		$data['hao_url'] = 'page/hezuo';
		$this->load->view('page_hezuo', $data);
			
	}
	
	public function bangzhu($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$page_type=4;
		$limit=10;
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
		
		foreach(explode("|",$this->config->item('page_types')) as $k => $s){
			if($page_type==$k){
				$data['page_title']=$s;
			}
		}

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,$page_type,$limit);

		$data['page_type'] = $page_type;
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'];
		$data['act'] = 'page/show';
		$this->load->view('page_show', $data);
			
	}
	
	public function wenti($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$page_type=5;
		$limit=10;
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
		
		foreach(explode("|",$this->config->item('page_types')) as $k => $s){
			if($page_type==$k){
				$data['page_title']=$s;
			}
		}

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,$page_type,$limit);

		$data['page_type'] = $page_type;
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'];
		$data['act'] = 'page/show';
		$this->load->view('page_show', $data);
			
	}
	
	public function songhuo($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$page_type=6;
		$limit=10;
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
		
		foreach(explode("|",$this->config->item('page_types')) as $k => $s){
			if($page_type==$k){
				$data['page_title']=$s;
			}
		}

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,$page_type,$limit);

		$data['page_type'] = $page_type;
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'];
		$data['act'] = 'page/show';
		$this->load->view('page_show', $data);
			
	}
	
	public function pays($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$page_type=7;
		$limit=10;
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
		
		foreach(explode("|",$this->config->item('page_types')) as $k => $s){
			if($page_type==$k){
				$data['page_title']=$s;
			}
		}

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,$page_type,$limit);

		$data['page_type'] = $page_type;
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'];
		$data['act'] = 'page/show';
		$this->load->view('page_show', $data);
			
	}
	
	public function wes($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$page_type=8;
		$limit=10;
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
		
		foreach(explode("|",$this->config->item('page_types')) as $k => $s){
			if($page_type==$k){
				$data['page_title']=$s;
			}
		}

		$data['page_hezuo']=$this->page_m->get_page_list_by_city($cityid,$page_type,$limit);

		$data['page_type'] = $page_type;
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'];
		$data['act'] = 'page/show';
		$this->load->view('page_show', $data);
			
	}	
	
	public function show($id,$page=1)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->page_m->get_page_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['page']=$this->page_m->get_page_by_id($id);
			$data['title']=$data['page']['pages_title'];
			$data['content']=html_entity_decode(br2nl($data['page']['pages_content']));
			$data['description']=fox_substr(cleanhtml($data['page']['pages_content']),180);
			$data['dates']=date('Y-m-d',$data['page']['pages_time']);
			$data['type']=$data['page']['pages_type'];
			$data['llcs']=$data['page']['pages_llcs'];
			//更新浏览数
			$this->db->where('id',$id)->update('pages',array('pages_llcs'=>$data['page']['pages_llcs']+1));
			
			$cityid=(int)$data['page']['pages_city'];
			$pingcity=$this->city_m->get_city_by_cid_web($cityid);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			foreach(explode("|",$this->config->item('page_types')) as $k => $s){
				if($data['page']['pages_type']==$k){
					$hao_types=$s;
				}
			}
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
			//分页
			$limit = 15;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('page/show/'.$id);
			$config['total_rows'] = $this->page_m->count_page($data['type'],$data['citys']['cid']);
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
			$config['num_links'] = 3;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();
			
			$data['page_list']=$this->page_m->get_all_page_list($start, $limit,$data['type'],$data['citys']['cid']);
			
			$data['stitle']=$hao_types;		
			$data['act'] = 'page/show';
			
			$this->load->view('page_shows',$data);
		}
	}
	
}