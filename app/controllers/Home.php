<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model ('ads_m');
		$this->load->model ('haoma_m');
		$this->load->model ('zifei_m');
		$this->load->library('myclass');
	}
	
	public function index()
	{
	    
	    $data['act']='shouye';
		//城市session
		$cityid=(int)$this->session->userdata('cityid');
		$citys=$this->city_m->get_city_moren(1);
		//广告
		$ads = $this->ads_m->get_city_ads_list($cityid,5);		
		$adscount=count($ads);
		if($adscount==0){
			$data['city_adss'] = $this->ads_m->get_city_ads_list($citys['cid'],5);
		}else{
			$data['city_adsm'] = array();
			$limitads=5-$adscount;
			if($limitads>0){
				$data['city_adsm'] = $this->ads_m->get_city_ads_list($citys['cid'],$limitads);
			}
			if($citys['cid']<>$cityid){
				$data['city_adss'] = array_merge_recursive($ads, $data['city_adsm']); 	
			}else{
				$data['city_adss'] = $ads; 
			}
		}		

		//公告
		$ggnum=8;
		$gg=$this->page_m->get_type_page_list($cityid,0,$ggnum);
		$ggcount=count($gg);
		if($ggcount==0){
			$data['city_ggs'] = $this->page_m->get_type_page_list($citys['cid'],0,$ggnum);
		}else{
			$data['city_ggm'] = array();
			$limitgg=$ggnum-$ggcount;
			if($limitgg>0){
				$data['city_ggm'] = $this->page_m->get_type_page_list($citys['cid'],0,$limitgg);
			}		
			$data['city_ggs'] = array_merge_recursive($gg, $data['city_ggm']); 			
		}
		//导购
		$city=$this->city_m->get_city_by_cid_web($cityid);
		$data['pingpai_gou']=$this->city_m->get_citygou_list($cityid,$city['sid'],8);	
		
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcitycid=$pingcity['pingcid'];
		}else{
			$pingcitycid=$cityid;
		}		
		
		//号码
		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;		
		$data['haoma_yd_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,0,0,0,24);
		if($data['haoma_yd_new']){
			foreach($data['haoma_yd_new'] as $k => $v){
				$data['haoma_yd_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_yd_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_yd_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_yd_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_yd_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,0,0,1,24);
		if($data['haoma_yd_dig']){
			foreach($data['haoma_yd_dig'] as $k => $v){
				$data['haoma_yd_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_yd_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_yd_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_yd_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_lt_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,1,0,0,24);
		if($data['haoma_lt_new']){
			foreach($data['haoma_lt_new'] as $k => $v){
				$data['haoma_lt_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_lt_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_lt_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_lt_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_lt_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,1,0,1,24);
		if($data['haoma_lt_dig']){
			foreach($data['haoma_lt_dig'] as $k => $v){
				$data['haoma_lt_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_lt_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_lt_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_lt_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_dx_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,2,0,0,24);
		if($data['haoma_dx_new']){
			foreach($data['haoma_dx_new'] as $k => $v){
				$data['haoma_dx_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_dx_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_dx_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_dx_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_dx_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,2,0,1,24);
		if($data['haoma_dx_dig']){
			foreach($data['haoma_dx_dig'] as $k => $v){
				$data['haoma_dx_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_dx_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_dx_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_dx_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		
		$data['yd_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,0,$cityid);
		$data['lt_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,1,$cityid);
		$data['dx_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,2,$cityid);
		
		//$this->output->cache(30);
		
		$this->load->view('home',$data);
	}
	public function city($cityid)
	{
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['act']='shouye';
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
		
		$citys=$this->city_m->get_city_moren(1);
		//广告
		$ads = $this->ads_m->get_city_ads_list($cityid,5);
		$adscount=count($ads);
		if($adscount==0){
			$data['city_adss'] = $this->ads_m->get_city_ads_list($citys['cid'],5);
		}else{
			$data['city_adsm'] = array();
			$limitads=5-$adscount;
			if($limitads>0){
				$data['city_adsm'] = $this->ads_m->get_city_ads_list($citys['cid'],$limitads);
			}		
			$data['city_adss'] = array_merge_recursive($ads, $data['city_adsm']); 		
		}
		//公告
		$ggnum=8;
		$gg=$this->page_m->get_type_page_list($cityid,0,$ggnum);
		$ggcount=count($gg);
		if($ggcount==0){
			$data['city_ggs'] = $this->page_m->get_type_page_list($citys['cid'],0,$ggnum);
		}else{
			$data['city_ggm'] = array();
			$limitgg=$ggnum-$ggcount;
			if($limitgg>0){
				$data['city_ggm'] = $this->page_m->get_type_page_list($citys['cid'],0,$limitgg);
			}		
			$data['city_ggs'] = array_merge_recursive($gg, $data['city_ggm']); 			
		}
		//导购
		$city=$this->city_m->get_city_by_cid_web($cityid);
		$data['pingpai_gou']=$this->city_m->get_citygou_list($cityid,$city['sid'],8);

		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcitycid=$pingcity['pingcid'];
		}else{
			$pingcitycid=$cityid;
		}		
		
		//号码
		$tv1=0;
		$tv2=3;
		$tv3=4;
		$tv4=4;		
		$data['haoma_yd_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,0,0,0,24);
		if($data['haoma_yd_new']){
			foreach($data['haoma_yd_new'] as $k => $v){
				$data['haoma_yd_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_yd_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_yd_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_yd_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_yd_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,0,0,1,24);
		if($data['haoma_yd_dig']){
			foreach($data['haoma_yd_dig'] as $k => $v){
				$data['haoma_yd_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_yd_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_yd_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_yd_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_lt_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,1,0,0,24);
		if($data['haoma_lt_new']){
			foreach($data['haoma_lt_new'] as $k => $v){
				$data['haoma_lt_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_lt_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_lt_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_lt_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_lt_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,1,0,1,24);
		if($data['haoma_lt_dig']){
			foreach($data['haoma_lt_dig'] as $k => $v){
				$data['haoma_lt_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_lt_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_lt_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_lt_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_dx_new']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,2,0,0,24);
		if($data['haoma_dx_new']){
			foreach($data['haoma_dx_new'] as $k => $v){
				$data['haoma_dx_new'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_dx_new'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_dx_new'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_dx_new'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}
		$data['haoma_dx_dig']=$this->haoma_m->get_haoma_city_type_num($pingcitycid,2,0,1,24);
		if($data['haoma_dx_dig']){
			foreach($data['haoma_dx_dig'] as $k => $v){
				$data['haoma_dx_dig'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				if($v['hao_jiage']==0 && $v['hao_huafei']==0){
					$data['haoma_dx_dig'][$k]['hao_shoujia']='议价';
				}elseif($v['hao_jiage']==0 && $v['hao_huafei']>0){
					$data['haoma_dx_dig'][$k]['hao_shoujia']=$v['hao_huafei'];
				}else{
					$data['haoma_dx_dig'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
				}
			}
		}		
		$data['yd_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,0,$cityid);
		$data['lt_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,1,$cityid);
		$data['dx_zifei']=$this->zifei_m->get_all_zifei_list(0, 6,2,$cityid);

		$this->load->view('home',$data);
	}	
	
}
