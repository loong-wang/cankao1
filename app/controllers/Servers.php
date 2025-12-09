<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Servers
#	scope:		PUBLIC

class Servers extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('haoma_m');
		$this->load->library('form_validation');
		$this->load->helper('haoma');
	}
	public function jixiong ($cityid=0)
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
		if ( ! $data['jixiong'] = $this->cache->get('jixiong'))
		{
			$data['jixiong'] = $this->haoma_m->get_haoma_jixion();
			$this->cache->save('jixiong', $data['jixiong'], 86400*365);
		}
		//act
		$data['act']='servers/jixiong';
		$data['siderbar']='servers/jixiong';
		$data['submenu']='servers/jixiong';
		$data['title']='号码吉凶测试';
		$data['stitle']='号码吉凶测试';
		if($_POST){
			$haoma=strip_tags($this->input->post('haoma',true));
			if(isset($haoma)){
				$data['haoma']=$haoma;
				$a=get_haoma_yuyi($haoma);
				foreach($data['jixiong'] as $v){
					if($v['jx_id']==$a){
						$data['jixiong_list']=$v;
					}
				}
			}
		}
		$this->load->view('servers_jixiong',$data);
	}
	
	public function jxlist ($cityid=0)
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
		if ( ! $data['jixiong'] = $this->cache->get('jixiong'))
		{
			$data['jixiong'] = $this->haoma_m->get_haoma_jixion();
			$this->cache->save('jixiong', $data['jixiong'], 86400*365);
		}
		//act
		$data['act']='servers/jxlist';
		$data['siderbar']='servers/jxlist';
		$data['submenu']='servers/jxlist';
		$data['title']='号码吉凶列表';
		$data['stitle']='号码吉凶列表';
		$this->load->view('servers_jxlist',$data);
	}
	
	public function haocity ($cityid=0)
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
		//act
		$data['act']='servers/haocity';
		$data['siderbar']='servers/haocity';
		$data['submenu']='servers/haocity';
		$data['title']='号码归属地查询';
		$data['stitle']='号码归属地查询';
		if($_POST){
			$haos=strip_tags($this->input->post('haoma',true));
			if(isset($haos)){
				$type=2;
				$data['hao_list']='';
				if($type==1){
					$url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$haos."&t=".time(); 
					$content = file_get_contents($url);
					if($content){
						$p = substr($content, 56, 4); 
						$mo = substr($content, 81, 4);
						$data['hao_list'].= "<li>您查询的号码为：<span class='text-large text-dot'>".$haos."</span></li>";
						$data['hao_list'].= "<li>查询结果如下：</li>";
						$data['hao_list'].= "<li>号码所属地：<span class='text-dot'>".mb_convert_encoding($p,'UTF-8','ASCII,GB2312,GB18030,GBK,UTF-8')."</span></li>";
						$data['hao_list'].= "<li>号码类型：<span class='text-dot'>".mb_convert_encoding($mo,'UTF-8','ASCII,GB2312,GB18030,GBK,UTF-8')."</span></li>";
					}else{
						$data['hao_list'].= "<li>您查询的号码为：<span>".$haos."</span></li>";
						$data['hao_list'].= "<li>查询结果如下：</li>";
						$data['hao_list'].= "<li>对不起：<span class='text-dot'>查询接口异常，请等待我们解决后再来查询</span></li>";
					}
				}elseif($type==2){
					$key="b4b88a8ffc09e2fd3f24251ee19fa168";
					$url = "http://apis.juhe.cn/mobile/get?phone=".$haos."&key=$key"; 
					$content = file_get_contents($url); 
					$result =json_decode($content,true);
					if($result['error_code']==0){		
						$datas = $result['result'];
						$data['hao_list'].= "<li>您查询的号码为：<span class='text-large text-dot'>".$haos."</span></li>";
						$data['hao_list'].= "<li>查询结果如下：</li>";
						$data['hao_list'].= "<li>号码所属地：<span class='text-dot'>".$datas['province']."/".$datas['city']."</span></li>";
						$data['hao_list'].= "<li>卡类型：<span class='text-dot'>".$datas['card']."</span></li>";
						$data['hao_list'].= "<li>运营商：<span class='text-dot'>".$datas['company']."</span></li>";
					}else{
						$data['hao_list'].= "<li>您查询的号码为：<span>".$haos."</span></li>";
						$data['hao_list'].= "<li>查询结果如下：</li>";
						$data['hao_list'].= "<li>对不起：<span class='text-dot'>查询接口异常，请等待我们解决后再来查询</span></li>";
					}
				}
			}
		}
		$this->load->view('servers_haocity',$data);
	}
	
	public function haogujia ($cityid=0)
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
		//act
		$data['act']='servers/haogujia';
		$data['siderbar']='servers/haogujia';
		$data['submenu']='servers/haogujia';
		$data['title']='号码估价';
		$data['stitle']='号码估价';
		if($_POST){
			$haos=trim(strip_tags($this->input->post('haoma',true)));
			if(isset($haos)){
				$data['hao_list']='';
				if($this->haoma_m->check_haoma_by_title($haos)){
					$datas=$this->haoma_m->check_haoma_by_title($haos);
					$hao_shoujia=ceil(fox_num_two($this->haoma_m->get_cnums_city($datas['hao_city']),$this->haoma_m->get_unums_user($datas['hao_user']))*$datas['hao_jiage']);
					if($datas['hao_lock']==0){
						$data['hao_list'] .= "<li>恭喜您：<span class='text-large text-dot'>".$haos."</span>正在本站出售中</li>";
						$data['hao_list'] .= "<li>此号码在本站仅售：<span class='text-large text-dot'>".$hao_shoujia."</span></li>";
						$data['hao_list'] .= "<li>号码规律：<span class='text-dot'>".get_haoma_guilv($haos)."</span></li>";
						$data['hao_list'] .= "<li>您可直接在线购买：<a class='text-dot' href='".site_url('haoma/show')."/".$datas['id']."/".$haos."'>在线抢购</a></li>";
					}else{
						$data['hao_list'] .= "<li>您查询的号码：<span class='text-large text-dot'>".$haos."</span>已在本站出售</li>";
						$data['hao_list'] .= "<li>此号码售出价：<span class='text-large text-dot'>".$hao_shoujia."</span></li>";
						$data['hao_list'] .= "<li>号码规律：<span class='text-dot'>".get_haoma_guilv($haos)."</span></li>";
					}
				}else{
					if(strstr($haos, '4')){
						$dijia=500;
					}else{
						$dijia=1000;
					}
					
					if(substr(substr($haos,-6),0,1)==substr(substr($haos,-5),0,1) && substr(substr($haos,-5),0,1)==substr(substr($haos,-4),0,1) && substr(substr($haos,-3),0,1)==substr(substr($haos,-2),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-4),0,1)!=substr(substr($haos,-3),0,1)){
						$guilv="AAABBB";
						$guijia=8000;
					}elseif(substr(substr($haos,-4),0,1)==substr(substr($haos,-3),0,1) && substr(substr($haos,-3),0,1)==substr(substr($haos,-2),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-5),0,1)!=substr(substr($haos,-4),0,1)){
						$guilv="AAAA";
						$guijia=7000;
					}elseif(substr(substr($haos,-3),0,1)==substr(substr($haos,-2),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-3),0,1)!=substr(substr($haos,-4),0,1)){
						$guilv="AAA";
						$guijia=2000;
					}elseif(substr($haos,-4)==1234 || substr($haos,-4)==2345 || substr($haos,-4)==3456 || substr($haos,-4)==4567 || substr($haos,-4)==5678 || substr($haos,-4)==6789 || substr($haos,-4)==4321 || substr($haos,-4)==5432 || substr($haos,-4)==6543 || substr($haos,-4)==7654 || substr($haos,-4)==8765 || substr($haos,-4)==9876){
						$guilv="升降序ABCD";
						$guijia=6000;
					}elseif(substr($haos,-3)==123 || substr($haos,-3)==234 || substr($haos,-3)==345 || substr($haos,-3)==456 || substr($haos,-3)==567 || substr($haos,-3)==678 || substr($haos,-3)==789 || substr($haos,-3)==321 || substr($haos,-3)==432 || substr($haos,-3)==543 || substr($haos,-3)==654 || substr($haos,-3)==765 || substr($haos,-3)==876 || substr($haos,-3)==987){
						$guilv="升降序ABC";
						$guijia=2000;
					}elseif(substr(substr($haos,-6),0,1)==substr(substr($haos,-5),0,1) && substr(substr($haos,-4),0,1)==substr(substr($haos,-3),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-5),0,1)!=substr(substr($haos,-4),0,1) && substr(substr($haos,-3),0,1)!=substr(substr($haos,-2),0,1)){
						$guilv="AABBCC";
						$guijia=3000;
					}elseif(substr(substr($haos,-6),0,1)==substr(substr($haos,-5),0,1) && substr(substr($haos,-5),0,1)==substr(substr($haos,-4),0,1) && substr(substr($haos,-3),0,1)==substr(substr($haos,-2),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-4),0,1)!=substr(substr($haos,-3),0,1)){
						$guilv="AAABBB";
						$guijia=8000;
					}elseif(substr(substr($haos,-4),0,2)==substr($haos,-2) && substr(substr($haos,-2),0,1)!=substr($haos,-1)){
						$guilv="ABAB";
						$guijia=4000;
					}elseif(substr(substr($haos,-4),0,1)==substr(substr($haos,-3),0,1) && substr(substr($haos,-2),0,1)==substr($haos,-1) && substr(substr($haos,-3),0,1)!=substr(substr($haos,-2),0,1)){
						$guilv="AABB";
						$guijia=2000;
					}elseif(substr(substr($haos,-3),0,1)==substr(substr($haos,-2),0,1) && substr(substr($haos,-4),0,1)==substr($haos,-1) && substr(substr($haos,-2),0,1)!=substr($haos,-1)){
						$guilv="ABBA";
						$guijia=1000;
					}else{
						$guilv="";
						$guijia=100;
					}
					if(strstr('136,137,138,139,188,189,130,133,186,185,180', mb_substr($haos,0,3))){
						$laojia=1000;
					}else{
						$laojia=200;
					}
					if(strstr($haos, '00000')){
						$laojias=5000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '11111')){
						$laojias=3000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '22222')){
						$laojias=3000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '33333')){
						$laojias=3000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '44444')){
						$laojias=2000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '55555')){
						$laojias=3000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '66666')){
						$laojias=6000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '77777')){
						$laojias=6000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '88888')){
						$laojias=9000;
						$guilv="AAAAA";
					}elseif(strstr($haos, '99999')){
						$laojias=10000;
						$guilv="AAAAA";
					}else{
						$laojias=0;
					}
					if(strstr($haos, '000000')){
						$laojiast=10000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '111111')){
						$laojiast=10000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '222222')){
						$laojiast=10000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '333333')){
						$laojiast=10000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '444444')){
						$laojiast=8000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '555555')){
						$laojiast=10000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '666666')){
						$laojiast=15000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '777777')){
						$laojiast=15000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '888888')){
						$laojiast=30000;
						$guilv="AAAAAA";
					}elseif(strstr($haos, '999999')){
						$laojiast=30000;
						$guilv="AAAAAA";
					}else{
						$laojiast=0;
					}
					if(strstr($haos, '0000000')){
						$laojiastt=100000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '1111111')){
						$laojiastt=100000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '2222222')){
						$laojiastt=100000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '3333333')){
						$laojiastt=100000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '4444444')){
						$laojiastt=80000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '5555555')){
						$laojiastt=100000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '6666666')){
						$laojiastt=150000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '7777777')){
						$laojiastt=150000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '8888888')){
						$laojiastt=300000;
						$guilv="AAAAAAA";
					}elseif(strstr($haos, '9999999')){
						$laojiastt=300000;
						$guilv="AAAAAAA";
					}else{
						$laojiastt=0;
					}
					$zuihaojia=intval($dijia)+intval($guijia)+intval($laojia)+intval($laojias)+intval($laojiast)+intval($laojiastt);
					$data['hao_list'] .= "<li>您要估价的号码为：<span class='text-large text-dot'>".$haos."</span></li>";
					$data['hao_list'] .= "<li>号码评估价：<span class='text-large text-dot'>".$zuihaojia."</span></li>";
					$data['hao_list'] .= "<li>号码规律：<span class='text-dot'>".$guilv."</span></li>";
				}
			}
		}
		$this->load->view('servers_haogujia',$data);
	}
	
	
}