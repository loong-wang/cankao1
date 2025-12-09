<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Zifei
#	scope:		PUBLIC

class Zifei extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('zifei_m');
		$this->load->model ('pinpai_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
	}
	
	public function yidong($cityid,$tc='',$page=1)
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
		$data['title'] = $hao_types.'资费';
		$data['stitle'] = $hao_types.'资费中心';
		$data['act'] = 'zifei/yidong';
		$data['sdao_url'] = 'zifei/yidong';
		$data['hao_url'] = 'yidong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;
		$data['pinurl'] = 'haoma/yidong';
		$data['tc'] = $tc;
		$data['tcs'] = str_replace('tc_','',$tc);
		$data['pinpai_list'] = $this->pinpai_m->get_pinpai_list($cityid,$hao_type,$data['tcs']);

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('zifei/yidong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->zifei_m->count_zifei($hao_type,$cityid);
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

		$data['zifei_list'] = $this->zifei_m->get_all_zifei_list($start, $limit,$hao_type,$cityid);
		if($data['zifei_list']){
			foreach($data['zifei_list'] as $k => $v){
				$data['zifei_list'][$k]['zf_city']=$this->city_m->get_cname_by_ucity($v['zf_city']);					
				$data['zifei_list'][$k]['zf_pinpais']=$this->zifei_m->get_pname_by_pid($v['zf_pinpai']);					
			}
		}
		$this->load->view('zifei_list', $data);
			
	}
	
	public function liantong($cityid,$tc='',$page=1)
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
		$data['title'] = $hao_types.'资费';
		$data['stitle'] = $hao_types.'资费中心';
		$data['act'] = 'zifei/liantong';
		$data['sdao_url'] = 'zifei/liantong';
		$data['hao_url'] = 'liantong';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;
		$data['pinurl'] = 'haoma/liantong';
		$data['tc'] = $tc;
		$data['tcs'] = str_replace('tc_','',$tc);
		$data['pinpai_list'] = $this->pinpai_m->get_pinpai_list($cityid,$hao_type,$data['tcs']);

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('zifei/liantong/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->zifei_m->count_zifei($hao_type,$cityid);
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

		$data['zifei_list'] = $this->zifei_m->get_all_zifei_list($start, $limit,$hao_type,$cityid);
		if($data['zifei_list']){
			foreach($data['zifei_list'] as $k => $v){
				$data['zifei_list'][$k]['zf_city']=$this->city_m->get_cname_by_ucity($v['zf_city']);					
				$data['zifei_list'][$k]['zf_pinpais']=$this->zifei_m->get_pname_by_pid($v['zf_pinpai']);					
			}
		}
		$this->load->view('zifei_list', $data);
			
	}
	
	public function dianxin($cityid,$tc='',$page=1)
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
		$data['title'] = $hao_types.'资费';
		$data['stitle'] = $hao_types.'资费中心';
		$data['act'] = 'zifei/dianxin';
		$data['sdao_url'] = 'zifei/dianxin';
		$data['hao_url'] = 'dianxin';
		$data['hao_type'] = $hao_type;
		$data['hao_types'] = $hao_types;
		$data['pinurl'] = 'haoma/dianxin';
		$data['tc'] = $tc;
		$data['tcs'] = str_replace('tc_','',$tc);
		$data['pinpai_list'] = $this->pinpai_m->get_pinpai_list($cityid,$hao_type,$data['tcs']);

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('zifei/dianxin/'.$hao_type.'/'.$cityid.'/');
		$config['total_rows'] = $this->zifei_m->count_zifei($hao_type,$cityid);
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

		$data['zifei_list'] = $this->zifei_m->get_all_zifei_list($start, $limit,$hao_type,$cityid);
		if($data['zifei_list']){
			foreach($data['zifei_list'] as $k => $v){
				$data['zifei_list'][$k]['zf_city']=$this->city_m->get_cname_by_ucity($v['zf_city']);					
				$data['zifei_list'][$k]['zf_pinpais']=$this->zifei_m->get_pname_by_pid($v['zf_pinpai']);					
			}
		}
		$this->load->view('zifei_list', $data);
			
	}
	
	public function show($id)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->zifei_m->get_zifei_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['zifei']=$this->zifei_m->get_zifei_by_id($id);
			$data['title']=$data['zifei']['zf_title'];
			$data['content']=html_entity_decode(br2nl($data['zifei']['zf_content']));
			$data['description']=fox_substr(cleanhtml($data['zifei']['zf_content']),180);
			$data['dates']=date('Y-m-d',$data['zifei']['zf_time']);
			$data['llcs']=$data['zifei']['zf_llcs'];
			//更新浏览数
			$this->db->where('id',$id)->update('zifei',array('zf_llcs'=>$data['zifei']['zf_llcs']+1));
			
			$cityid=(int)$data['zifei']['zf_city'];
			$pingcity=$this->city_m->get_city_by_cid_web($cityid);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
				if($data['zifei']['zf_type']==$k){
					$hao_types=$s;
				}
			}
			$data['citys']='';
			if($data['zifei']['zf_type']==0){
				$data['act']='zifei/yidong';				
				$data['sdao_url']='zifei/yidong';				
			}
			$data['stitle']=$hao_types.'资费';				
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
			
			$this->load->view('zifei_show',$data);
		}
	}
	
}