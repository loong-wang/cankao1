<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	News
#	scope:		PUBLIC

class News extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('news_m');
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/yidong';
		$data['sdao_url'] = 'news/yidong';
		$data['hao_url'] = 'yidong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/liantong';
		$data['sdao_url'] = 'news/liantong';
		$data['hao_url'] = 'liantong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/dianxin';
		$data['sdao_url'] = 'news/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
	}
	
	public function hangye($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=5;
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/dianxin';
		$data['sdao_url'] = 'news/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
	}
	
	public function youhui($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=6;
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/dianxin';
		$data['sdao_url'] = 'news/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
	}
	
	public function duanxin($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=7;
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/dianxin';
		$data['sdao_url'] = 'news/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
	}
	
	public function xiuxian($cityid,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$hao_type=8;
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
		foreach(explode("|",$this->config->item('news_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['title'] = $hao_types.'';
		$data['stitle'] = $hao_types.'中心';
		$data['act'] = 'news/dianxin';
		$data['sdao_url'] = 'news/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('news/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->news_m->count_newss($hao_type,$cityid);
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

		$data['news_list'] = $this->news_m->get_all_news_lists($start, $limit,$hao_type,$cityid);
		if($data['news_list']){
			foreach($data['news_list'] as $k => $v){
				$data['news_list'][$k]['news_city']=$this->city_m->get_cname_by_ucity($v['news_city']);					
			}
		}
		$this->load->view('news_list', $data);
			
	}
	
	public function show($id)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->news_m->get_news_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['news']=$this->news_m->get_news_by_id($id);
			$data['title']=$data['news']['news_title'];
			$data['content']=html_entity_decode(br2nl($data['news']['news_content']));
			$data['description']=fox_substr(cleanhtml($data['news']['news_content']),180);
			$data['dates']=date('Y-m-d',$data['news']['news_time']);
			$data['llcs']=$data['news']['news_llcs'];
			//更新浏览数
			$this->db->where('id',$id)->update('news',array('news_llcs'=>$data['news']['news_llcs']+1));
			$data['citys']='';
			
			if($data['news']['news_city']>0){
				$cityid=(int)$data['news']['news_city'];	
				$pingcity=$this->city_m->get_city_by_cid_web($cityid);
				if($pingcity['pingcid']>0){
					$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
				}
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
			}else{
				$data['citys']=$this->city_m->get_city_moren(1);
				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				if ( ! $data['cityt'] = $this->cache->get('cityt'))
				{
					$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
					$this->cache->save('cityt', $data['cityt'], 3600);
				}
				$data['shouye_url']=site_url();
			}
			foreach(explode("|",$this->config->item('news_types')) as $k => $s){
				if($data['news']['news_type']==$k){
					$hao_types=$s;
				}
			}
			if($data['news']['news_type']==0){
				$data['act']='news/yidong';				
				$data['sdao_url']='news/yidong/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==1){
				$data['act']='news/liantong';				
				$data['sdao_url']='news/liantong/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==2){
				$data['act']='news/dianxin';				
				$data['sdao_url']='news/dianxin/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==5){
				$data['act']='news/hangye';				
				$data['sdao_url']='news/hangye/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==6){
				$data['act']='news/youhui';				
				$data['sdao_url']='news/youhui/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==7){
				$data['act']='news/duanxin';				
				$data['sdao_url']='news/duanxin/'.$data['citys']['cid'];				
			}elseif($data['news']['news_type']==8){
				$data['act']='news/xiuxian';				
				$data['sdao_url']='news/xiuxian/'.$data['citys']['cid'];				
			}
			$data['stitle']=$hao_types.'';				
			//城市session
			$this->session->set_userdata('cityid', $data['citys']['cid']);
			
			$this->load->view('news_show',$data);
		}
	}
	
}