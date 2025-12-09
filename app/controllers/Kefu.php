<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Kefu
#	scope:		PUBLIC

class Kefu extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('question_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	
	public function ask($cityid)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if($this->config->item('is_guest')=='off'){
			show_message('您没有登陆无法提问',site_url('user/login/'.$cityid));
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
		
      
		if($_POST){

 		if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm')!=strtolower($_POST['captcha_code'])){
  			show_message('提交失败！验证码错误',$url,1);
		}          
       $this->session->unset_userdata('yzm');
          
			$str = array(
				'q_title' => strip_tags($this->input->post('q_title',true)),
				'q_content' => html_purify($this->input->post('content',true),'comment'),
				'q_name' => strip_tags($this->input->post('q_name',true)),
				'q_type' => strip_tags($this->input->post('q_type',true)),
				'q_tel' => strip_tags($this->input->post('q_tel',true)),
				'q_userid' => ($this->session->userdata('userid'))?$this->session->userdata('userid'):'0',
				'q_city' => $cityid,
				'q_time' => time(),
			);
			
			if($this->question_m->add_question($str)){
				$new_id = $this->db->insert_id();
				if($this->input->post('q_type',true)>2){
					$url=$data['shouye_url'];
				}else{
					$url=site_url('kefu/show/'.$new_id);
				}
				show_message('客服咨询提交成功！请耐心等待我们回复',$url,1);
			}
		}
        else{
          show_message('提交失败！请返回重试',$url,1);
        }
			
	}
	
	public function yidong($cityid,$page=1)
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
		
		//配置
		$q_type=0;
		$q_url='kefu/yidong';
		$data['q_count']=$this->question_m->count_question(10001,$cityid);
		$data['q_count_a']=$this->question_m->count_question_city($cityid,0,0);
		$data['q_count_ax']=$this->question_m->count_question_city($cityid,0,1);
		$data['q_count_b']=$this->question_m->count_question_city($cityid,1,0);
		$data['q_count_bx']=$this->question_m->count_question_city($cityid,1,1);
		$data['q_count_c']=$this->question_m->count_question_city($cityid,2,0);
		$data['q_count_cx']=$this->question_m->count_question_city($cityid,2,1);

		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('kefu/yidong/'.$cityid);
		$config['total_rows'] = $data['q_count_a'];
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

		$data['question_list'] = $this->question_m->get_all_question_list($start, $limit, $q_type, $cityid);
		if($data['question_list']){
			foreach($data['question_list'] as $k => $v){
				$data['question_list'][$k]['question_city']=$this->city_m->get_cname_by_ucity($v['q_city']);					
			}
		}
		
		foreach(explode("|",$this->config->item('question_types')) as $k => $s){
			if($q_type==$k){
				$data['page_title']=$s;
			}
		}
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'].'中心';
		$data['act'] = $q_url;
		$data['sdao_url'] = $q_url.'/'.$data['citys']['cid'];
		$data['q_type'] = $q_type;		
		$this->load->view('question_list', $data);
			
	}
	
	public function liantong($cityid,$page=1)
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
		
		//配置
		$q_type=1;
		$q_url='kefu/liantong';
		$data['q_count']=$this->question_m->count_question(10001,$cityid);
		$data['q_count_a']=$this->question_m->count_question_city($cityid,0,0);
		$data['q_count_ax']=$this->question_m->count_question_city($cityid,0,1);
		$data['q_count_b']=$this->question_m->count_question_city($cityid,1,0);
		$data['q_count_bx']=$this->question_m->count_question_city($cityid,1,1);
		$data['q_count_c']=$this->question_m->count_question_city($cityid,2,0);
		$data['q_count_cx']=$this->question_m->count_question_city($cityid,2,1);

		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('kefu/liantong/'.$cityid);
		$config['total_rows'] = $data['q_count_a'];
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

		$data['question_list'] = $this->question_m->get_all_question_list($start, $limit, $q_type, $cityid);
		if($data['question_list']){
			foreach($data['question_list'] as $k => $v){
				$data['question_list'][$k]['question_city']=$this->city_m->get_cname_by_ucity($v['q_city']);					
			}
		}
		
		foreach(explode("|",$this->config->item('question_types')) as $k => $s){
			if($q_type==$k){
				$data['page_title']=$s;
			}
		}
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'].'中心';
		$data['act'] = $q_url;
		$data['sdao_url'] = $q_url.'/'.$data['citys']['cid'];
		$data['q_type'] = $q_type;		
		$this->load->view('question_list', $data);
			
	}
	
	public function dianxin($cityid,$page=1)
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
		
		//配置
		$q_type=2;
		$q_url='kefu/dianxin';
		$data['q_count']=$this->question_m->count_question(10001,$cityid);
		$data['q_count_a']=$this->question_m->count_question_city($cityid,0,0);
		$data['q_count_ax']=$this->question_m->count_question_city($cityid,0,1);
		$data['q_count_b']=$this->question_m->count_question_city($cityid,1,0);
		$data['q_count_bx']=$this->question_m->count_question_city($cityid,1,1);
		$data['q_count_c']=$this->question_m->count_question_city($cityid,2,0);
		$data['q_count_cx']=$this->question_m->count_question_city($cityid,2,1);

		//分页
		$limit = 10;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('kefu/dianxin/'.$cityid);
		$config['total_rows'] = $data['q_count_a'];
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

		$data['question_list'] = $this->question_m->get_all_question_list($start, $limit, $q_type, $cityid);
		if($data['question_list']){
			foreach($data['question_list'] as $k => $v){
				$data['question_list'][$k]['question_city']=$this->city_m->get_cname_by_ucity($v['q_city']);					
			}
		}
		
		foreach(explode("|",$this->config->item('question_types')) as $k => $s){
			if($q_type==$k){
				$data['page_title']=$s;
			}
		}
		$data['title'] = $data['page_title'];
		$data['stitle'] = $data['page_title'].'中心';
		$data['act'] = $q_url;
		$data['sdao_url'] = $q_url.'/'.$data['citys']['cid'];
		$data['q_type'] = $q_type;		
		$this->load->view('question_list', $data);
			
	}
	
	
	
	public function show($id)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->question_m->get_question_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['question']=$this->question_m->get_question_by_id($id);
			$data['title']=$data['question']['q_title'];
			$data['content']=html_entity_decode(br2nl($data['question']['q_content']));
			$data['description']=fox_substr(cleanhtml($data['question']['q_content']),180);
			$data['dates']=date('Y-m-d',$data['question']['q_time']);
			$data['type']=$data['question']['q_type'];
			$data['llcs']=$data['question']['q_llcs'];
			$data['name']=$data['question']['q_name'];
			$data['tel']=$data['question']['q_tel'];
			$data['reuserid']=$data['question']['q_reuserid'];
			$data['rename']=$data['question']['q_rename'];
			$data['recontent']=html_entity_decode(br2nl($data['question']['q_recontent']));
			//更新浏览数
			$this->db->where('id',$id)->update('question',array('q_llcs'=>$data['question']['q_llcs']+1));
			
			$cityid=(int)$data['question']['q_city'];
			$data['q_count']=$this->question_m->count_question(10001,$cityid);
			$data['q_count_a']=$this->question_m->count_question_city($cityid,0,0);
			$data['q_count_ax']=$this->question_m->count_question_city($cityid,0,1);
			$data['q_count_b']=$this->question_m->count_question_city($cityid,1,0);
			$data['q_count_bx']=$this->question_m->count_question_city($cityid,1,1);
			$data['q_count_c']=$this->question_m->count_question_city($cityid,2,0);
			$data['q_count_cx']=$this->question_m->count_question_city($cityid,2,1);
			$data['q_type']=$data['question']['q_type'];
			
			foreach(explode("|",$this->config->item('question_types')) as $k => $s){
				if($data['question']['q_type']==$k){
					$data['question']['q_typs']=$s;
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
			$pingcity=$this->city_m->get_city_by_cid_web($data['citys']['cid']);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			$data['stitle']=$data['question']['q_typs'];
			if($data['question']['q_type']==0){
				$data['act'] = 'kefu/yidong';
				$data['sdao_url'] = 'kefu/yidong/'.$data['citys']['cid'];				
			}elseif($data['question']['q_type']==1){
				$data['act'] = 'kefu/liantong';
				$data['sdao_url'] = 'kefu/liantong/'.$data['citys']['cid'];				
			}elseif($data['question']['q_type']==2){
				$data['act'] = 'kefu/dianxin';
				$data['sdao_url'] = 'kefu/dianxin/'.$data['citys']['cid'];				
			}
			
			$this->load->view('question_show',$data);
		}
	}
	
}