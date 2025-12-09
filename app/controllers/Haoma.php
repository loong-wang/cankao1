<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Haoma extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model ('haoma_m');
		$this->load->model ('zifei_m');
		$this->load->model ('cart_m');
		$this->config->load('haoset');
		$this->load->library('myclass');
		$this->load->helper('haoma');
	}
	
	public function othera($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=4;
		$hao_lock=0;
		$limit = 60;
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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/othera';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_4'));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/othera';				
		$data['sdao_url']='haoma/othera/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/othera/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_lista',$data);
	}
	
	public function yihaotong($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=5;
		$hao_lock=0;
		$limit = 60;

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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/yihaotong';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_5'));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/yihaotong';				
		$data['sdao_url']='haoma/yihaotong/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/yihaotong/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_lists',$data);
	}
	
	public function xunihao($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=6;
		$hao_lock=0;
		$limit = 60;

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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/xunihao';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_6'));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/xunihao';				
		$data['sdao_url']='haoma/xunihao/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/xunihao/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_lists',$data);
	}
	
	public function yidong($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{

	    if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=0;
		$hao_lock=0;
		$limit = 60;

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
		// var_dump($this->config->item('hao_types'));
		// die;
		foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/yidong';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_0'));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/yidong';				
		$data['sdao_url']='haoma/yidong/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/yidong/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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

		$this->output->cache(30);
		$this->load->view('haoma_list',$data);
	}
	
	public function liantong($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=1;
		$hao_lock=0;
		$limit = 60;

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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/liantong';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_1'));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/liantong';				
		$data['sdao_url']='haoma/liantong/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/liantong/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_list',$data);
	}
	
	public function dianxin($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=2;
		$hao_lock=0;
		$limit = 60;

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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/dianxin';
		$data['hao_type']=$hao_type;
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
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_'.$hao_type.''));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/dianxin';				
		$data['sdao_url']='haoma/dianxin/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/dianxin/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_list',$data);
	}
	
	public function guhua($cityid=0,$list=0,$list_a=0,$list_b=0,$list_c=0,$hao_pinpai=0,$title_hao_types=0,$set_hao_jiage=100,$hao_shuweis=100,$hao_redian=0,$hao_ends=100,$hao_tedians=10,$hao_heyus=10,$hao_jixiong=100,$page=1)
	{
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		//配置
		$hao_type=3;
		$hao_lock=0;
		$limit = 60;

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
			if($hao_type==$k){
				$hao_types=$s;
			}
		}
		$data['hao_url']='haoma/guhua';
		$data['hao_type']=$hao_type;
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
		//$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcity,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcity,$hao_type):'';
		$data['hao_pinpais']=($this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type))?$this->zifei_m->get_all_pinpai_by_city_type($pingcitycid,$hao_type):'';
		$data['set_hao_types']=explode("|",$this->config->item('hao_types_'.$hao_type.''));
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
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/0/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$pname=$this->haoma_m->get_pinname_by_pin_num($hao_pinpai);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$pname.'</a>';
		}
		if($title_hao_types>0){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/0/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$title_hao_types.'</a>';
		}
		if($set_hao_jiage<>100){
			$yi=explode("|",$this->config->item('hao_jiages'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/100/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$set_hao_jiage].'元</a>';
		}
		if($hao_shuweis<>100){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/100/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$hao_shuweis.'较多</a>';
		}
		if($hao_redian>10){
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/0/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.($hao_redian-1000).'</a>';
		}
		if($hao_ends<>100){
			$yi=explode("|",$this->config->item('hao_ends'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/100/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_ends].'</a>';
		}
		if($hao_tedians<>10){
			$yi=explode("|",$this->config->item('hao_tedians'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/10/'.$hao_heyus.'/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_tedians].'</a>';
		}
		if($hao_heyus<>10){
			$yi=explode("|",$this->config->item('hao_heyus'));
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.'/10/'.$hao_jixiong);
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$yi[$hao_heyus].'</a>';
		}
		if($hao_jixiong<>100){
			foreach($data['jixiong'] as $a){
				if($a['jx_id']==$hao_jixiong){
					$arr=explode('，',$a['jx_memo']);
					$jx=$arr[0];
				}
			}
			$yixuanurl=site_url($data['hao_url'].'/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_tedians.'/'.$hao_ends.'/'.$hao_tedians.''.$hao_heyus.'/100/');
			$data['yixuan'] .='<a href="'.$yixuanurl.'" class="active">'.$jx.'</a>';
		}
		//act
		$data['act']='haoma/guhua';				
		$data['sdao_url']='haoma/guhua/'.$cityid;
		$data['title']=$data['citys']['cname'].$hao_types;
		$data['stitle']='选号大厅';
		//$data['haoma_list_a']=$this->haoma_m->count_haoma_lock($hao_type,$pingcitycid,$hao_lock);
		//$data['haoma_list_b']=$this->haoma_m->count_haoma_lock_dig($hao_type,$pingcitycid,$hao_lock,1);
		//$data['haoma_list_c']=$this->haoma_m->count_haoma_yijia($hao_type,$pingcitycid);
		//分页
		$data['haoma_list_x']=$this->haoma_m->count_list_haoma($pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a);
		$config['uri_segment'] = 17;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('haoma/guhua/'.$cityid.'/'.$list.'/'.$list_a.'/'.$list_b.'/'.$list_c.'/'.$hao_pinpai.'/'.$title_hao_types.'/'.$set_hao_jiage.'/'.$hao_shuweis.'/'.$hao_redian.'/'.$hao_ends.'/'.$hao_tedians.'/'.$hao_heyus.'/'.$hao_jixiong);
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
		$data['haoma_list'] = $this->haoma_m->get_haoma_list($start, $limit,$pingcitycid,$hao_lock,$hao_type,$hao_pinpai,$title_hao_types,$jiage,$shuwei,$hao_redian,$hao_endst,$tedians,$hao_heyust,$hao_jixiongs,$list,$list_a,$list_b,$list_c);
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
		$this->output->cache(30);
		$this->load->view('haoma_lists',$data);
	}
	
	public function show($cityid,$id,$title)
	{
		if(!is_numeric($id)){
			show_message('参数错误','');
		}
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		$cityid=(int)$cityid;
		
		$this->load->config('haoset');
		
		if(!$this->haoma_m->get_haoma_by_id($id)){
			show_message('此号码不存在或者已经被订购啦','');
		}else{
			$data['title']=$title;
			$data['haoma']=$this->haoma_m->get_haoma_by_ids($id);				
			if($this->cart_m->get_che_by_haoid_scheid($id,$this->fox_scheid)){
				$data['gouwuche']=1;
			}else{
				$data['gouwuche']=0;
			}
			if($this->cart_m->get_shoucang_by_haoid($id)){
				$data['shoucang']=1;
			}else{
				$data['shoucang']=0;
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
			$pingcity=$this->city_m->get_city_by_cid_web($cityid);
			if($pingcity['pingcid']>0){
				$pingcitycid=$pingcity['pingcid'];
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}else{
				$pingcitycid=$cityid;
			}
			
			//更新浏览数
			$this->db->where('id',$id)->update('haoma',array('hao_llcs'=>$data['haoma']['hao_llcs']+1));
			$data['haoma']['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($data['haoma']['hao_user']))*$data['haoma']['hao_jiage']);	
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$data['haoma_zifei']=$this->haoma_m->get_zifei_by_city_pinpai_type($data['haoma']['hao_city'],$data['haoma']['hao_pinpai'],$data['haoma']['hao_type'],1);
			if($data['haoma_zifei']){
				foreach($data['haoma_zifei'] as $k => $v){
					$data['haoma_zifei'][$k]['zf_content']=html_entity_decode(br2nl($v['zf_content']));
				}
			}
			$tv1=0;
			$tv2=3;
			$tv3=4;
			$tv4=4;	
			//$data['haoma_loves']=$this->haoma_m->get_haoma_loves($data['haoma']['hao_title'],substr($data['haoma']['hao_title'],-3),$data['haoma']['hao_city'],0,$data['haoma']['hao_type'],60);
			if($data['haoma_loves']){
				foreach($data['haoma_loves'] as $k => $v){
					$data['haoma_loves'][$k]['hao_titles']='<span class="text-dot">'.substr($v['hao_title'],$tv1,$tv2).'</span><span class="text-sub">'.substr($v['hao_title'],$tv1+$tv2,$tv3).'</span><span class="text-yellow">'.substr($v['hao_title'],$tv1+$tv2+$tv3,$tv4).'</span>';
				}
			}
			$data['haoma_peisong']=$this->haoma_m->get_peisong_by_city($pingcitycid,2,1);
			if($data['haoma_peisong']){
				foreach($data['haoma_peisong'] as $k => $v){
					$data['haoma_peisong'][$k]['pages_content']=html_entity_decode(br2nl($v['pages_content']));
				}
			}
			if ( ! $data['jixiong'] = $this->cache->get('jixiong'))
			{
				$data['jixiong'] = $this->haoma_m->get_haoma_jixion();
				$this->cache->save('jixiong', $data['jixiong'], 86400*365);
			}
			
			foreach(explode("|",$this->config->item('hao_types')) as $k => $s){
				if($data['haoma']['hao_type']==$k){
					$hao_types=$s;
				}
			}
			
			if($data['haoma']['hao_type']==0){
				$data['act']='haoma/yidong';				
				$data['sdao_url']='haoma/yidong/'.$cityid;				
				$data['stitle']=$hao_types.'选号';				
			}elseif($data['haoma']['hao_type']==1){
				$data['act']='haoma/liantong';				
				$data['sdao_url']='haoma/liantong/'.$cityid;				
				$data['stitle']=$hao_types.'选号';				
			}elseif($data['haoma']['hao_type']==2){
				$data['act']='haoma/dianxin';				
				$data['sdao_url']='haoma/dianxin/'.$cityid;				
				$data['stitle']=$hao_types.'选号';				
			}elseif($data['haoma']['hao_type']==3){
				$data['act']='haoma/guhua';				
				$data['sdao_url']='haoma/guhua/'.$cityid;				
				$data['stitle']=$hao_types.'选号';				
			}
			
			
			
			if($data['haoma']['hao_lock']!=0){
				show_message('您晚了一步，此号码已经被订售啦',$data['shouye_url']);
			}
			
			$this->load->view('haoma_show',$data);
		}
	}
}
?>