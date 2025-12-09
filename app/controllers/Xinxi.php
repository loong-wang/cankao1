<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Xinxi
#	scope:		PUBLIC

class Xinxi extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('xinxi_m');
		$this->load->model ('city_m');
		$this->load->config('haoset');
		$this->load->model('haoma_m');
		$this->config->load('cityset');
		$this->load->library('form_validation');
	}
	public function ttest(){
	    $data['hao_excel'] = str_replace('fox','/','uploads/excel/20210714132612_29014.csv');
		$handle = fopen(FCPATH.$data['hao_excel'], 'r'); 
		$result = $this->haoma_m->input_csv($handle); //解析csv
		
		foreach($result as $k => $v){
		    if($v[4]){
		        $encode = mb_detect_encoding($v[4], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5','EUC-CN'));
		        if($encode != 'UTF-8'){
		            var_dump(iconv($encode,'UTF-8',$v[4]));
		        }
		        die;
		    }
		}
	}
	public function flist($cityid,$xinxi=10000,$page=1)
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

		//分页
		$limit = 20;
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('xinxi/flist/'.$cityid.'/'.$xinxi);
		$config['total_rows'] = $this->xinxi_m->count_xinxis($xinxi);
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

		$data['xinxi_list'] = $this->xinxi_m->get_all_xinxi_lists($start, $limit,$xinxi);
		if($data['xinxi_list']){
			foreach($data['xinxi_list'] as $k => $v){
				$data['xinxi_list'][$k]['xinxi_city']=$this->city_m->get_cname_by_ucity($v['x_city']);					
			}
		}
		$data['title'] = '供求交易';
		$data['stitle'] = '供求交易信息';
		$data['act'] = 'xinxi/flist';
		$data['sdao_url'] = 'xinxi/flist/'.$data['citys']['cid'];
		$data['hao_url'] = 'xinxi/flist';
		$data['xinxi'] = $xinxi;		
		$this->load->view('xinxi_list', $data);
			
	}
	
	
	
	public function show($id)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		$this->load->config('haoset');
		if(!$this->xinxi_m->get_xinxi_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['xinxi']=$this->xinxi_m->get_xinxi_by_id($id);
			$data['title']=$data['xinxi']['x_title'];
			$data['content']=html_entity_decode(br2nl($data['xinxi']['x_content']));
			$data['description']=fox_substr(cleanhtml($data['xinxi']['x_content']),180);
			$data['dates']=date('Y-m-d',$data['xinxi']['x_time']);
			$data['type']=$data['xinxi']['x_type'];
			$data['llcs']=$data['xinxi']['x_llcs'];
			$data['jiage']=$data['xinxi']['x_jiage'];
			$data['name']=$data['xinxi']['x_name'];
			$data['tel']=$data['xinxi']['x_tel'];
			$data['qq']=$data['xinxi']['x_qq'];
			$data['email']=$data['xinxi']['x_email'];
			//更新浏览数
			$this->db->where('id',$id)->update('xinxi',array('x_llcs'=>$data['xinxi']['x_llcs']+1));
			$data['xinxi_list'] = $this->xinxi_m->get_remen_xinxi_lists(15,$data['type']);
			
			$cityid=(int)$data['xinxi']['x_city'];
			$pingcity=$this->city_m->get_city_by_cid_web($cityid);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			foreach(explode("|",$this->config->item('xinxi_types')) as $k => $s){
				if($data['xinxi']['x_type']==$k){
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
			$data['stitle']='供求交易信息';		
			$data['stitle'] = '供求交易';
			$data['act'] = 'xinxi/flist';
			$data['sdao_url'] = 'xinxi/flist/'.$data['citys']['cid'];
			$data['hao_url'] = 'xinxi/flist';
			
			$this->load->view('xinxi_show',$data);
		}
	}
	
}