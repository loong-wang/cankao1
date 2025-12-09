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
	
	public function likea_back($cityid=0,$searchnum='',$haotype=10000,$page=1)
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
		$this->load->view('search_lista',$data);
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
	
	public function liket($cityid=0,$a='all',$searchnum='',$b,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		
		if($searchnum!='iiiii'){
			if(!is_numeric($searchnum)){
				
				//show_message('参数错误','');
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
			}
		}
		//var_dump($page);
		//配置
		
		//$hao_type=0;
		$hao_lock=0;
		
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
		
		
		foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
			if($haotype==$k){
				$hao_types=$s;
			}
		}
		// var_dump($hao_types);
		// die;
		$data['hao_url']='search/liket';
		$data['hao_type']=$haotype;
		$data['hao_types']=$hao_types;
		$data['hao_lock']=$hao_lock;
		$data['hao_pinpai']=$hao_pinpai;
		$data['title_hao_types']=$title_hao_types;
		$data['hao_jiage']=$set_hao_jiage;
		$data['hao_shuweis']=$hao_shuweis;
		$data['hao_redian']=$hao_redian;
		$data['hao_ends']=$hao_ends;
		$data['hao_tedians']=$hao_tedians;
		$data['hao_heyus']=$hao_heyus;
		$data['hao_jixiong']=$hao_jixiong;
		
		
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcitycid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcitycid=$cityid;
		}
		
		
		
		
		$data['hao_citys']=$data['citys']['cname'];
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$haotype))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$haotype):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_'.$haotype));
		$data['set_hao_jiages']=explode("|",$this->config->item('hao_jiages'));
		$data['set_hao_shuweis']=explode("|",$this->config->item('hao_shuweis'));
		$data['set_hao_redians']=explode("|",$this->config->item('hao_redians'));
		$data['set_hao_ends']=explode("|",$this->config->item('hao_ends'));
		$data['set_hao_tedians']=explode("|",$this->config->item('hao_tedians'));
		$data['set_hao_heyus']=explode("|",$this->config->item('hao_heyus'));
		
		$data['list']=$list;
		$data['list_a']=$list_a;
		$data['list_b']=$list_b;
		$data['list_c']=$list_c;
		$data['list_x']=0;
		$data['list_y']=0;
		if($list==0){
			$data['list_x']=1;
		}
		if($list==1){
			$data['list_y']=1;
		}
		if($list_a==3){
			$data['list_ax']=3;
		}elseif($list_a==2){
			$data['list_ax']=1;
		}else{
			$data['list_ax']=2;
		}		
		if($list_b==1){
			$data['list_bx']=2;
		}else{
			$data['list_bx']=1;
		}
		if($list_c==1){
			$data['list_cx']=2;
		}else{
			$data['list_cx']=1;
		}
		//选择
		$data['yixuan']='';		
		//判断
		$jiage='';
		$xishu=fox_num_two($this->haoma_m->get_cnums_city($data['citys']['cid']),0);
		if($set_hao_jiage==0){
			$jiagea=ceil(100/$xishu);
			$jiage='hao_jiage<'.$jiagea.'';
		}elseif($set_hao_jiage==1){
			$jiagea=ceil(100/$xishu);
			$jiageb=ceil(500/$xishu);
			$jiage='(hao_jiage>='.$jiagea.' and hao_jiage<='.$jiageb.')';
		}elseif($set_hao_jiage==2){
			$jiagea=ceil(500/$xishu);
			$jiageb=ceil(1000/$xishu);
			$jiage='(hao_jiage>='.$jiagea.' and hao_jiage<='.$jiageb.')';
		}elseif($set_hao_jiage==3){
			$jiagea=ceil(1000/$xishu);
			$jiageb=ceil(2000/$xishu);
			$jiage='(hao_jiage>='.$jiagea.' and hao_jiage<='.$jiageb.')';
		}elseif($set_hao_jiage==4){
			$jiagea=ceil(2000/$xishu);
			$jiageb=ceil(5000/$xishu);
			$jiage='(hao_jiage>='.$jiagea.' and hao_jiage<='.$jiageb.')';
		}elseif($set_hao_jiage==5){
			$jiagea=ceil(5000/$xishu);
			$jiageb=ceil(1000/$xishu);
			$jiage='(hao_jiage>='.$jiagea.' and hao_jiage<='.$jiageb.')';
		}elseif($set_hao_jiage==6){
			$jiages=ceil(10000/$xishu);
			$jiage='hao_jiage>'.$jiages.'';
		}
		
		$shuwei='';
		if($hao_shuweis<>100){
			$shuwei="((length(hao_title)-length(replace(hao_title,'".$hao_shuweis."','')))>4)";
		}
		$hao_endst='';
		if($hao_ends==0){
			$hao_endst=$this->config->item('hao_ends_0');
		}elseif($hao_ends==1){
			$hao_endst=$this->config->item('hao_ends_1');
		}elseif($hao_ends==2){
			$hao_endst=$this->config->item('hao_ends_2');
		}elseif($hao_ends==3){
			$hao_endst=$this->config->item('hao_ends_3');
		}elseif($hao_ends==4){
			$hao_endst=$this->config->item('hao_ends_4');
		}elseif($hao_ends==5){
			$hao_endst=$this->config->item('hao_ends_5');
		}elseif($hao_ends==6){
			$hao_endst=$this->config->item('hao_ends_6');
		}elseif($hao_ends==7){
			$hao_endst=$this->config->item('hao_ends_7');
		}elseif($hao_ends==8){
			$hao_endst=$this->config->item('hao_ends_8');
		}elseif($hao_ends==9){
			$hao_endst=$this->config->item('hao_ends_9');
		}
		$tedians='';
		if($hao_tedians==0){
			$tedians=$this->config->item('hao_tedians_0');
			$tedians=str_replace('$$','"%',$tedians);
			$tedians=str_replace('$','%"',$tedians);
		}elseif($hao_tedians==1){
			$tedians=$this->config->item('hao_tedians_1');
			$tedians=str_replace('$$','"%',$tedians);
			$tedians=str_replace('$','%"',$tedians);
		}elseif($hao_tedians==2){
			$tedians=$this->config->item('hao_tedians_2');
			$tedians=str_replace('$$','"%',$tedians);
			$tedians=str_replace('$','%"',$tedians);
		}
		$hao_heyust='';
		if($hao_heyus==0){
			$hao_heyust=$this->config->item('hao_heyus_0');
		}elseif($hao_heyus==1){
			$hao_heyust=$this->config->item('hao_heyus_1');
		}
		$hao_jixiongs='';
		if($hao_jixiong<100){
			$hao_jixiongs='';
		}
		if ( ! $data['jixiong'] = $this->cache->get('jixiong'))
		{
			$data['jixiong'] = $this->haoma_m->get_haoma_jixion();
			$this->cache->save('jixiong', $data['jixiong'], 86400*365);
		}
		$hao_jixiongs='';
		if($hao_jixiong<100){
			$hao_jixiongs='(MOD(RIGHT(hao_title, 4)+1-1,81)='.$hao_jixiong.')';
		}
		$data['yixuan'] .='<a class="over">'.$hao_types.'</a>';
		if($hao_pinpai>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		
		
		
		
		
		
		$data['act']='search/haoma';
		$data['searchnum']=$searchnum;
		$data['title']=$data['citys']['cname'].'号码搜索';
		$data['stitle']=$data['citys']['cname'].'号码搜索'.$searchnum;
		//分页
		if(empty($searchnum)){
			show_message('参数错误','');
		}
		
		
		
		//$data['haoma_list_x']=$this->haoma_m->count_list_haoma_liket($pingcitycid,$haotype,$searchnum,$b,$lock);
		$start = ($page-1)*$limit;
		if($start == 0)$start=1;
		$config['base_url'] = site_url('search/liket/'.$cityid.'/all/'.$searchnum.'/0/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
		$search_type=0;
		if($where){
			$searchnum=$where;
			$search_type=1;
		}
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma_likets($start, $limit,$pingcitycid,$hao_lock,$haotype,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c,$searchnum,$b,$lock,$search_type);
		
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		
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
		// var_dump(111);
		// die;
		
		
		$data['pagination'] = $this->pagination->create_links();
		
		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;
		
		$data['haoma_list'] = $this->haoma_m->get_haoma_lists($start, $limit,$pingcitycid,$hao_lock,$haotype,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c,$searchnum,$b,$lock,$search_type);
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