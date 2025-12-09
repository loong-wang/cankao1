<?php
/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();	
	}
}
class FOX_Controller extends Base_Controller
{
	function __construct(){
		parent::__construct();	
		$data='';
		//判断安装
		$file=FCPATH.'install.lock';
		if (!is_file($file)){
			redirect(site_url('install'));
		}
		$this->load->database();
		if(!$this->city_m->get_city_moren(1)){
			echo '默认城市未设置，网站暂时无法访问';
			exit;
		}
		$this->fox_scheid=get_fox_scheid($this->config->item('dsfox_domain'));
		
		$comurl=$_SERVER['HTTP_HOST'];
		if(trim($comurl)!=trim($this->config->item('site_domain')) && in_array($comurl, explode("|",$this->config->item('site_domains')))){
			$data['citys']=$this->city_m->get_city_by_cdomain_web($comurl);
			$pingcity=$this->city_m->get_city_by_cid_web($data['citys']['cid']);
			if($pingcity['pingcid']>0){
				$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
			}
			if(!$data['citys']){
				echo '网站配置有误请检查';
				exit;
			}
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			if ( ! $data['cityt'] = $this->cache->get('cityt'.$data['citys']['cid']))
			{
				$data['cityt'] = $this->city_m->get_city_no_cid($data['citys']['cid']);
				$this->cache->save('cityt'.$data['citys']['cid'], $data['cityt'], 3600);
			}
			$data['shouye_url']=site_url();
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
		if($this->session->userdata('userid')){
			//取一个用户信息
			$this->load->model('user_m');
			$data['user']=$this->user_m->get_user_by_uid($this->session->userdata('userid'));
			$data['user']['nake']=(isset($data['user']['name']))?$data['user']['name']:$data['user']['username'];;
			//获取头像
			$this->load->model('upload_m');
			$data['user']['big_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'big');
			$data['user']['big_avatar']=(file_exists($data['user']['big_avatar']))?$data['user']['big_avatar']:'uploads/avatar/default/avatar_large.jpg';
			$data['user']['middle_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'middle');
			$data['user']['middle_avatar']=(file_exists($data['user']['middle_avatar']))?$data['user']['middle_avatar']:'uploads/avatar/default/avatar_middle.jpg';
			$data['user']['small_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'small');
			$data['user']['small_avatar']=(file_exists($data['user']['small_avatar']))?$data['user']['small_avatar']:'uploads/avatar/default/avatar_small.jpg';
		}
		//前台导航
		$data['memu_list'] = $this->memu_m->memu_list_by_pid(10,72);
		$data['viewmulu'] = base_url('app/views/'.$data['citys']['cthemes']);
		//取会员导航
		$limitsidebar=$this->memu_m->count_memu_dao(0,1);
		$data['siderbar_list'] = $this->memu_m->get_all_memus_dao(0, $limitsidebar, 1);
		if($data['siderbar_list']){
			foreach($data['siderbar_list'] as $k => $v){
				$data['siderbar_list'][$k]['count']=$this->memu_m->count_memu_dao($v['id'],1);
				$data['siderbar_list'][$k]['group_types'] = $v['group_type'];
				$data['siderbar_list'][$k]['siderbar_list_s'] = $this->memu_m->get_all_memus_by_pid_dao($v['id'], $data['siderbar_list'][$k]['count'], 1);				
				if($data['siderbar_list'][$k]['siderbar_list_s']){
					foreach($data['siderbar_list'][$k]['siderbar_list_s'] as $ks => $s){
						$data['siderbar_list'][$k]['siderbar_list_s'][$ks]['group_type_ss'] = $s['group_type'];
					}
				}
			}
		}
		$this->session->set_userdata('cityid', $data['citys']['cid']);
		$data['page_bangzhu']=$this->page_m->get_page_list_by_city($this->session->userdata('cityid'),4,3);
		$data['page_wenti']=$this->page_m->get_page_list_by_city($this->session->userdata('cityid'),5,3);
		$data['page_songhuo']=$this->page_m->get_page_list_by_city($this->session->userdata('cityid'),6,3);
		$data['question_list_show']=$this->page_m->get_show_question_list($this->session->userdata('cityid'),15);
		$data['gouwuche_num']=$this->page_m->count_gouwuche_num($this->fox_scheid,$this->session->userdata('cityid'));
		$this->load->set_front_theme($data['citys']['cthemes']);
		$this->load->vars($data);
	}	
}
class Admin_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		$data['siderbar']='';
		$data['submenu']='.';
		//载入后台模板
		$this->load->set_front_theme($this->config->item('adminthemes'));
		//判断安装
		$file=FCPATH.'install.lock';
		if (!is_file($file)){
			redirect(site_url('install'));
		}
		$this->load->database();
		if($this->session->userdata('userid')){
			//取一个用户信息
			$this->load->model('user_m');
			$data['user']=$this->user_m->get_user_by_uid($this->session->userdata('userid'));
			$data['user']['nake']=(isset($data['user']['name']))?$data['user']['name']:$data['user']['username'];;
			//获取头像
			$this->load->model('upload_m');
			$data['user']['big_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'big');
			$data['user']['big_avatar']=(file_exists($data['user']['big_avatar']))?$data['user']['big_avatar']:'uploads/avatar/default/avatar_large.jpg';
			$data['user']['middle_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'middle');
			$data['user']['middle_avatar']=(file_exists($data['user']['middle_avatar']))?$data['user']['middle_avatar']:'uploads/avatar/default/avatar_middle.jpg';
			$data['user']['small_avatar']=$this->upload_m->get_avatar_url($this->session->userdata('userid'), 'small');
			$data['user']['small_avatar']=(file_exists($data['user']['small_avatar']))?$data['user']['small_avatar']:'uploads/avatar/default/avatar_small.jpg';
			//获取订单
			$data['count_dingdan'] = $this->user_m->count_dingdan($this->session->userdata('ucity'));
			$data['count_dingdan_today'] = $this->user_m->count_dingdan_today($this->session->userdata('ucity'));
			//统计号码
			$data['count_haoma'] = $this->user_m->count_haoma($this->session->userdata('ucity'));
			$data['count_haoma_lock'] = $this->user_m->count_haoma_lock($this->session->userdata('ucity'));
			//统计会员
			$data['count_user'] = $this->user_m->count_user_shu($this->session->userdata('ucity'));
			$data['count_user_today'] = $this->user_m->count_user_shu_today($this->session->userdata('ucity'));
		}
		//取导航
		$limitsidebar=$this->memu_m->count_memu_dao(0,11);
		$data['siderbar_list'] = $this->memu_m->get_all_memus_dao(0, $limitsidebar, 11);
		if($data['siderbar_list']){
			foreach($data['siderbar_list'] as $k => $v){
				$data['siderbar_list'][$k]['count']=$this->memu_m->count_memu_dao($v['id'],11);
				$data['siderbar_list'][$k]['group_types'] = $v['group_type'];
				$data['siderbar_list'][$k]['siderbar_list_s'] = $this->memu_m->get_all_memus_by_pid_dao($v['id'], $data['siderbar_list'][$k]['count'], 11);				
				if($data['siderbar_list'][$k]['siderbar_list_s']){
					foreach($data['siderbar_list'][$k]['siderbar_list_s'] as $ks => $s){
						$data['siderbar_list'][$k]['siderbar_list_s'][$ks]['group_type_ss'] = $s['group_type'];
					}
				}
			}
		}
		
		//前台导航
		$data['memu_list'] = $this->memu_m->memu_list_by_pid(10,72);
	 	
		$this->load->vars($data);
	}
}
class Install_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		//载入前台模板
		$this->load->set_front_theme('install');
	}
}
class Other_Controller extends Base_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		//载入前台模板
		$this->load->set_front_theme('default');
	}
}