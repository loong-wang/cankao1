<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model ('cart_m');
		$this->load->model ('haoma_m');
		$this->load->model ('zifei_m');
		$this->load->model ('city_m');
		$this->load->library('myclass');
		$this->config->load('haoset');
		$this->config->load('payset');
		$this->load->library('form_validation');	
		$this->load->helper('htmlpurifier');
	}
	
	public function flist($cityid=0,$haoid=0,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($haoid)){
			show_message('参数错误','');
		}
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['fox_scheid']=$this->fox_scheid;
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
			$pingcitycid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcitycid=$cityid;
		}
		$data['citylist'] = $this->city_m->get_city_all_list();
		if($haoid>0 && !$this->cart_m->get_che_by_haoid_scheid($haoid,$this->fox_scheid)){
			$str = array(
				'che_hao' => $this->fox_scheid,
				'che_userid' => ($this->session->userdata('userid'))?$this->session->userdata('userid'):'0',
				'che_city' => $cityid,
				'che_haoid' => $haoid,
				'che_time' => time(),
			);
		
			$this->cart_m->add_che($str);
		}

		$data['zhekou']=$this->cart_m->get_zhekou_by_ugroup($this->session->userdata('ugroup'));
		//分页
		$limit = 20;
		$data['cart_count']=$this->cart_m->count_che($cityid);
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('cart/flist/'.$cityid.'/'.$haoid);
		$config['total_rows'] = $data['cart_count'];
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

		$data['cart_list'] = $this->cart_m->get_all_che_list($start, $limit,$cityid);
		//if(count($data['cart_list'])==0){
		//	show_message('您的购物车为空，正转向订单区……',site_url('cart/alldingdan/'.$data['citys']['cid']));
		//}
		if($data['cart_list']){
			foreach($data['cart_list'] as $k => $v){
				$data['cart_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['cart_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['cart_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['cart_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock_cart($v['hao_lock'],$v['id']);					
				$data['cart_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['cart_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		//act
		$data['act']='cart/flist';
		$data['title']='我的购物车';
		$this->load->view('cart_list',$data);
	}
	
	public function del($cityid=0,$id)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($id)){
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
		//act
		$data['act']='cart/flist';
		$data['title']='删除购物车';
		if(!$this->cart_m->get_che_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['che']=$this->cart_m->get_che_by_id($id);
			if($data['che']['che_hao']!=$this->fox_scheid){
				show_message('这不是您的购物车哦','');
			}
			//删除
			$url='cart/flist/'.$cityid;
			if($this->cart_m->del_che($id)){
				redirect(site_url($url));
			}
		}
	}
	public function delall($cityid=0)
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
		//act
		$data['act']='cart/flist';
		$data['title']='删除购物车';
		//删除
		$url='cart/flist/'.$cityid;
		$this->cart_m->del_all_scheid($this->fox_scheid);
		redirect(site_url($url));
	}
	public function dingdan($cityid=0)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if($this->config->item('is_guest')=='off'){
			show_message('您没有登陆',site_url('user/login/'.$cityid));
		}
		$cityid=(int)$cityid;
		$data['citys']='';
		$data['fox_scheid']=$this->fox_scheid;
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
		
		if($_POST){
			if(!$this->_check_captcha($this->input->post('captcha_code',true))){
				show_message('参数错误','');
			}
			$danhao=$this->cart_m->get_order_maxonum();
			$danhao = number_format($danhao,0,'','');
			$haoids=strip_tags($this->input->post('dan_haoid',true));
			$userid=($this->session->userdata('userid'))?$this->session->userdata('userid'):'0';
			$str = array(
				'dan_hao' => $danhao,
				'che_hao' => $this->fox_scheid,
				'dan_name' => strip_tags($this->input->post('dan_name',true)),
				'dan_dress' => strip_tags($this->input->post('dan_dress',true)),
				'dan_tel' => strip_tags($this->input->post('dan_tel',true)),
				'dan_tels' => strip_tags($this->input->post('dan_tels',true)),
				'dan_content' => html_purify($this->input->post('dan_content',true),'comment'),
				'dan_userid' => $userid,
				'dan_city' => $cityid,
				'dan_paytype' => strip_tags($this->input->post('dan_paytype',true)),
				'dan_haoid' => $haoids,
				'dan_time' => time(),
			);		
			if($this->cart_m->add_dingdan($str)){
				foreach(explode('|',$haoids) as $v){
					$this->cart_m->del_che_haoid($v);
					$this->cart_m->lock_haoma_haoid($v,$danhao,$haoids,$userid,$cityid,$this->fox_scheid);
				}
				//copy_dir('uploads/renz/'.$this->fox_scheid,'uploads/renz/'.$danhao);
				//deldir('uploads/renz/'.$this->fox_scheid);
				$url=site_url('cart/dingdans/'.$cityid.'/'.$danhao);
				//echo $url;echo number_format($danhao,0,'','');exit();
				show_message('恭喜您，订单提交成功',$url,1);
			}
		}
	}
	public function dingdans($cityid=0,$dan_hao)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($dan_hao)){
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
			$pingcitycid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcitycid=$cityid;
		}
		if(!$this->cart_m->get_dingdan_by_danhao($dan_hao)){
			show_message('没有找到这个订单号','');
		}else{
			$data['zhekou']=$this->cart_m->get_zhekou_by_ugroup($this->session->userdata('ugroup'));
			$data['dingdan']=$this->cart_m->get_dingdan_by_danhao($dan_hao);
			$data['dingdan_list']=$this->cart_m->get_dingdan_list_by_danhao($dan_hao);
			if($data['dingdan_list']){
				foreach($data['dingdan_list'] as $k => $v){
					$data['dingdan_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
					$data['dingdan_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
					$data['dingdan_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
					$data['dingdan_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));	
					if($v['hao_jiage']>0){
						$data['dingdan_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
					}else{
						$data['dingdan_list'][$k]['hao_shoujia']=$v['dan_hao_shoujia'];
					}
				}
			}
		}
		//act
		$data['act']='cart/dingdans';
		$data['title']='订单详情';
		$checkm=is_mobile();
		
		if($checkm){
		    $data['payaction']='getwxh5t';
		}else{
		    $data['payaction']='pay';
		}
		
		$this->load->view('dingdan_show',$data);
	}
	
	public function alldingdan($cityid=0,$page=1)
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
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		$data['citylist'] = $this->city_m->get_city_all_list();

		//分页
		$limit = 20;
		$data['cart_count']=$this->cart_m->count_dingdan($cityid);
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('cart/alldingdan/'.$cityid);
		$config['total_rows'] = $data['cart_count'];
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

		$data['dingdan_list'] = $this->cart_m->get_all_dingdan_list($start, $limit,$cityid);
		if($data['dingdan_list']){
			foreach($data['dingdan_list'] as $k => $v){
				$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_dan_city_cname($v['dan_city']);	
				$data['dingdan_list'][$k]['dan_lock_wancheng']=$this->cart_m->get_dingdan_list_lock_wancheng($v['dan_haoid']);
			}
		}
		//act
		$data['act']='cart/alldingdan';
		$data['title']='我的订单';
		$this->load->view('dingdan_list',$data);
	}
	
	public function goust($cityid=0,$id=0,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($id)){
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
			$pingcitycid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcitycid=$cityid;
		}
		$data['citylist'] = $this->city_m->get_city_all_list();

		$data['zhekou']=$this->cart_m->get_zhekou_by_ugroup($this->session->userdata('ugroup'));
		$data['haoma']=$this->haoma_m->get_haoma_by_ids($id);
		$data['haoma']['hao_lock']=$this->haoma_m->get_hao_lock_cart($data['haoma']['hao_lock'],$data['haoma']['id']);
		$data['haoma']['hao_pinpai']=$this->zifei_m->get_pname_by_pid($data['haoma']['hao_pinpai']);	
		//更新浏览数
		$this->db->where('id',$id)->update('haoma',array('hao_llcs'=>$data['haoma']['hao_llcs']+1));
		$data['haoma']['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($data['haoma']['hao_user']))*$data['haoma']['hao_jiage']);	
		if($_POST){
			$danhao=$this->cart_m->get_order_maxonum();
			$userid=($this->session->userdata('userid'))?$this->session->userdata('userid'):'0';
			$str = array(
				'dan_hao' => $danhao,
				'che_hao' => $this->fox_scheid,
				'dan_name' => strip_tags($this->input->post('dan_name',true)),
				'dan_dress' => strip_tags($this->input->post('dan_dress',true)),
				'dan_tel' => strip_tags($this->input->post('dan_tel',true)),
				'dan_tels' => strip_tags($this->input->post('dan_tels',true)),
				'dan_content' => html_purify($this->input->post('dan_content',true),'comment'),
				'dan_userid' => $userid,
				'dan_city' => $cityid,
				'dan_paytype' => strip_tags($this->input->post('dan_paytype',true)),
				'dan_haoid' => $id.'|',
				'dan_time' => time(),
			);	
			$this->load->config('smsset');
			$shouji=$this->input->post('dan_tel',true);
			if(isset($shouji) && checkMobile($shouji) && $this->config->item('sms_type')=='on'){  
				if($this->config->item('shouji_order')=='on'){
					$shoujbody = str_replace('【变量】','【'.$data['haoma']['hao_title'].'】',$this->config->item('sms_moban_order'));
					SendShouji($this->config->item('sms_user'),$this->config->item('sms_key'),$shouji,$shoujbody,date('Y-m-d H:i:s',time()));		
				}
			}
			$shoujis=$data['citys']['cz_shouji_me'];
			if(isset($shoujis) && checkMobile($shoujis) && $this->config->item('sms_type')=='on'){  
				if($this->config->item('shouji_order_me')=='on'){
					$shoujbody = str_replace('【变量】','【'.$data['haoma']['hao_title'].'】',$this->config->item('sms_moban_order_me'));
					SendShouji($this->config->item('sms_user'),$this->config->item('sms_key'),$shoujis,$shoujbody,date('Y-m-d H:i:s',time()));		
				}
			}
			if($this->cart_m->add_dingdan($str)){
				$this->db->where('id',$id)->update('haoma', array('hao_lock'=>1));
				$this->cart_m->del_che_haoid($this->input->post('dan_haoid',true));
				$this->cart_m->add_dingdan_list_haoid($danhao,$id,$userid,$cityid,$this->fox_scheid);
				$url=site_url('cart/dingdans/'.$cityid.'/'.$danhao);				
				show_message('恭喜您，订单提交成功',$url,1);
			}
		}

		//act
		$data['act']='cart/flist';
		$data['title']='立即订购';
		$this->load->view('cart_gou',$data);
	}
	
	public function gou($cityid=0,$haoid=0,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($haoid)){
			show_message('参数错误','');
		}
		if($this->config->item('is_guest')=='off'){
			show_message('您没有登陆，请登陆会员购买',site_url('user/login/'.$cityid));
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
			$pingcitycid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcitycid=$cityid;
		}
		$data['citylist'] = $this->city_m->get_city_all_list();
		if($haoid>0 && !$this->cart_m->get_che_by_haoid_scheid($haoid,$this->fox_scheid)){
			$str = array(
				'che_hao' => $this->fox_scheid,
				'che_userid' => ($this->session->userdata('userid'))?$this->session->userdata('userid'):'0',
				'che_city' => $cityid,
				'che_haoid' => $haoid,
				'che_time' => time(),
			);
		
			$this->cart_m->add_che($str);
		}
		$data['zhekou']=$this->cart_m->get_zhekou_by_ugroup($this->session->userdata('ugroup'));
		//分页
		$limit = 20;
		$data['cart_count']=$this->cart_m->count_che($cityid);
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('cart/flist/'.$cityid.'/'.$haoid);
		$config['total_rows'] = $data['cart_count'];
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

		$data['cart_list'] = $this->cart_m->get_all_che_list($start, $limit,$cityid);
		//if(count($data['cart_list'])==0){
		//	show_message('您的购物车为空，正转向订单区……',site_url('cart/alldingdan/'.$data['citys']['cid']));
		//}
		if($data['cart_list']){
			foreach($data['cart_list'] as $k => $v){
				$data['cart_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['cart_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['cart_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['cart_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock_cart($v['hao_lock'],$v['id']);					
				$data['cart_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($v['hao_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['cart_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		//act
		$data['act']='cart/flist';
		$data['title']='我的购物车';
		$this->load->view('cart_list',$data);
	}
	public function _check_captcha($captcha)
	{
		if($this->config->item('show_captcha')=='on' && $this->session->userdata('yzm')!=strtolower($captcha)){
  			return false;
		} else{
			return true;
		}
	}
}
