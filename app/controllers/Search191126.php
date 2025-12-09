<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Search
#	scope:		PUBLIC

class Search extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('haoma_m');
		$this->load->model ('zifei_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	
	public function likea($cityid=0,$searchnum='',$haotype=10000,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$limit = 60;
		$lock=0;
		if($searchnum!=''){
			$sohao=strip_tags($searchnum);
			$where='';
			$fca=substr($sohao,0,1);
			$fcb=substr($sohao,1,1);
			$fcc=substr($sohao,2,1);
			$fcd=substr($sohao,3,1);
			$fce=substr($sohao,4,1);
			$fcf=substr($sohao,5,1);
			$fcg=substr($sohao,6,1);
			$fch=substr($sohao,7,1);
			$fci=substr($sohao,8,1);
			$fcj=substr($sohao,9,1);
			$fck=substr($sohao,10,1);
			if(preg_match("/^[0-9]{1}/",$fca)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,1,1)=$fca";
				}else{
					$where.=" substr(hao_title,1,1)=$fca";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcb)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,2,1)=$fcb";
				}else{
					$where.=" substr(hao_title,2,1)=$fcb";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcc)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,3,1)=$fcc";
				}else{
					$where.=" substr(hao_title,3,1)=$fcc";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcd)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,4,1)=$fcd";
				}else{
					$where.=" substr(hao_title,4,1)=$fcd";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fce)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,5,1)=$fce";
				}else{
					$where.=" substr(hao_title,5,1)=$fce";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcf)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,6,1)=$fcf";
				}else{
					$where.=" substr(hao_title,6,1)=$fcf";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcg)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,7,1)=$fcg";
				}else{
					$where.=" substr(hao_title,7,1)=$fcg";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fch)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,8,1)=$fch";
				}else{
					$where.=" substr(hao_title,8,1)=$fch";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fci)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,9,1)=$fci";
				}else{
					$where.=" substr(hao_title,9,1)=$fci";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fcj)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,10,1)=$fcj";
				}else{
					$where.=" substr(hao_title,10,1)=$fcj";
				}
			}
			if(preg_match("/^[0-9]{1}/",$fck)){
				if (strlen($where) > 0) {
					$where.=" and substr(hao_title,11,1)=$fck";
				}else{
					$where.=" substr(hao_title,11,1)=$fck";
				}
			}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		$data['act']='search/haoma';
		$data['searchnum']=$searchnum;
		$data['title']=$data['citys']['cname'].'号码搜索';
		$data['stitle']=$data['citys']['cname'].'号码搜索如下';
		//分页
		if(empty($where)){
			show_message('参数错误','');
		}
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma_likea($pingcityid,$where,$haotype,$lock);
		$config['uri_segment'] = 6;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('search/likea/'.$cityid.'/'.$searchnum.'/'.$haotype);
		$config['total_rows'] = $data['haoma_list_x'];
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

		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;	
		$data['haoma_list'] = $this->haoma_m->get_haoma_list_likea($start, $limit,$pingcityid,$where,$haotype,$lock);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$data['haotype']=$haotype;
		$this->load->view('search_list',$data);
	}
	
	public function likeb($cityid=0,$searchnum='',$b=0,$haotype=10000,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($searchnum)){
			show_message('参数错误','');
		}
		//配置
		$limit = 60;
		$lock=0;

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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		$data['act']='search/haoma';
		$data['searchnum']=$searchnum;
		$data['title']=$data['citys']['cname'].'号码搜索';
		$data['stitle']=$data['citys']['cname'].'号码搜索'.$searchnum;
		//分页
		if(empty($searchnum)){
			show_message('参数错误','');
		}
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma_likeb($pingcityid,$searchnum,$b,$haotype,$lock);
		$config['uri_segment'] = 6;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('search/liked/'.$cityid.'/'.$searchnum.'/'.$b);
		$config['total_rows'] = $data['haoma_list_x'];
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

		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;	
		$data['haoma_list'] = $this->haoma_m->get_haoma_list_likeb($start, $limit,$pingcityid,$searchnum,$b,$haotype,$lock);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$data['haotype']=$haotype;
		$this->load->view('search_list',$data);
	}
	
	public function liked($cityid=0,$searchnum='',$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($searchnum)){
			show_message('参数错误','');
		}
		//配置
		$limit = 60;
		$lock=0;

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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		$data['act']='search/haoma';
		$data['searchnum']=$searchnum;
		$data['title']=$data['citys']['cname'].'号码搜索';
		$data['stitle']=$data['citys']['cname'].'号码搜索'.$searchnum;
		//分页
		if(empty($searchnum)){
			show_message('参数错误','');
		}
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma_liked($pingcityid,$searchnum,$lock);
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('search/liked/'.$cityid.'/'.$searchnum);
		$config['total_rows'] = $data['haoma_list_x'];
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

		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;	
		$data['haoma_list'] = $this->haoma_m->get_haoma_list_liked($start, $limit,$pingcityid,$searchnum,$lock);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($pingcityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$data['haotype']='10000';
		$this->load->view('search_list',$data);
	}
	
	public function liket($cityid=0,$a='all',$searchnum='',$b,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if($searchnum!='iiiii'){
			if(!is_numeric($searchnum)){
				show_message('参数错误','');
			}
		}		
		
		//配置
		$haotype=10000;
		$limit = 60;
		$lock=0;
		if($a=='yidong'){
			$haotype=0;
		}elseif($a=='liantong'){
			$haotype=1;
		}elseif($a=='dianxin'){
			$haotype=2;
		}elseif($a=='guhua'){
			$haotype=3;
		}
		$b=(int)$b;
		$data['haotype']=$haotype;

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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		$data['act']='search/haoma';
		$data['searchnum']=$searchnum;
		$data['title']=$data['citys']['cname'].'号码搜索';
		$data['stitle']=$data['citys']['cname'].'号码搜索'.$searchnum;
		//分页
		if(empty($searchnum)){
			show_message('参数错误','');
		}
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma_liket($pingcityid,$haotype,$searchnum,$b,$lock);
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('search/liket/'.$cityid.'/'.$a.'/'.$searchnum.'/'.$b);
		$config['total_rows'] = $data['haoma_list_x'];
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

		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;	
		$data['haoma_list'] = $this->haoma_m->get_haoma_list_liket($start, $limit,$pingcityid,$haotype,$searchnum,$b,$lock);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_list'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_list'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}					
			}
		}
		$this->load->view('search_list',$data);
	}

	
}
?>