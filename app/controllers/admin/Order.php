<?php
class Order extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('dingzhi_m');
		$this->load->model ('city_m');
		$this->load->model ('cart_m');
		$this->load->model ('work_m');
		$this->load->model ('haoma_m');
		$this->load->model ('zifei_m');
		$this->load->library('myclass');
		$this->config->load('haoset');
		$this->config->load('payset');
		$this->load->library('form_validation');
		$this->load->helper('htmlpurifier');
	}
	public function index()
	{
		redirect(site_url('admin/order/flist'));
	}
	
	public function dingzhi($city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '号码订制';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/dingzhi';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			//分页
			$limit = 20;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/order/dingzhi/'.$data['city'].'/');
			$config['total_rows'] = $this->dingzhi_m->count_dingzhi($data['city']);
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['dingzhi_list'] = $this->dingzhi_m->get_all_dingzhi_list($start, $limit,$data['city']);
			if($data['dingzhi_list']){
				foreach($data['dingzhi_list'] as $k => $v){
					$data['dingzhi_list'][$k]['dingzhi_city']=$this->city_m->get_cname_by_ucity_luo($v['dz_city']);					
				}
			}

			$this->load->view('dingzhi_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function dingzhilock(){
		$masterurl='admin/order/dingzhi';
		/** 检查登陆 */
		if($this->auth->is_admin() && $this->auth->is_master($masterurl))
		{
			$id=strip_tags($this->input->post('id',true));
			if(isset($id)){
				$this->db->where('id',$id)->update('dingzhi',array('dz_lock'=>1));
				echo '1';
			}			
		}		
	}
	
	
	public function dingzhidel($id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '删除号码订制';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/dingzhi';
			if($this->dingzhi_m->get_dingzhi_by_id($id)){
				$data['dingzhiinfo'] = $this->dingzhi_m->get_dingzhi_by_id($id);
				if($this->session->userdata('ucity')>0 && $data['dingzhiinfo']['dz_city']!=$this->session->userdata('ucity')){
					show_message('操作无权限：非您站号码订制','');
				}
				//删除
				if($this->dingzhi_m->del_dingzhi($id)){
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}				
			}else{
				show_message('参数不正确','');
			}

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}

	}
	public function dingzhidel_all()
	{
		$masterurl='admin/dingzhidel';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '删除1月前号码订制';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/dingzhi';
			//删除
			$this->dingzhi_m->del_all($this->session->userdata('ucity'));
			show_message($data['title'].'成功！',site_url($data['submenu']),1);

		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function flist($city=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}
			
			//分页
			$limit = 20;
			$config['uri_segment'] = 5;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/order/flist/'.$data['city'].'/');
			$config['total_rows'] = $this->cart_m->count_dingdans($data['city']);
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();
			$data['page'] = $page;

			$data['dingdan_list'] = $this->cart_m->get_all_dingdan_lists($start, $limit,$data['city']);
			if(isset($data['dingdan_list'])){
				foreach($data['dingdan_list'] as $k => $v){
					$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
					$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
					if($data['dingdan_list'][$k]['dd_list']){
						foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
							$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
							$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							if(!$m['hao_title']){
								//$this->cart_m->dels_dingdan_list_by_danhao($m['dan_hao']);
							}
						}
					}else{
						$this->cart_m->dels_dingdan_list_by_danhao($v['dan_hao']);
					}
				}
			}
			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function editddjiage(){
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() && $this->auth->is_master($masterurl))
		{
			$id=strip_tags($this->input->post('dan_hao_id',true));
			$dan_hao_chengben=($this->input->post('dan_hao_chengben'))?strip_tags($this->input->post('dan_hao_chengben',true)):'0';
			$dan_hao_shoujia=($this->input->post('dan_hao_shoujia'))?strip_tags($this->input->post('dan_hao_shoujia',true)):'0';
			if(isset($id) && $id>0){
				$this->db->where('id',$id)->update('dingdan_list',array('dan_hao_chengben'=>$dan_hao_chengben,'dan_hao_shoujia'=>$dan_hao_shoujia,'dan_hao_shoujias'=>$dan_hao_shoujia));
				$arr['success']=1;
				$arr['msg']='恭喜您，修改成功';
			}else{
				$arr['success']=0;
				$arr['msg']='修改失败，请检查操作';
			}			
		}
		echo json_encode($arr);
	}
	
	public function dan_hao_lock_queren($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单确认状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('已完成订单不能修改状态了','');
			}
			if($dd['dan_hao_lock_queren']==0){
				$str=array('dan_hao_lock_queren'=>1);
				$tits='已确认';
			}elseif($dd['dan_hao_lock_queren']==1){
				$str=array('dan_hao_lock_queren'=>0);
				$tits='未确认';
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>1,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function dan_hao_lock_zhifu($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单支付状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('已完成订单不能修改状态了','');
			}
			if($dd['dan_hao_lock_zhifu']==0){
				$str=array('dan_hao_lock_zhifu'=>1);
				$tits='已支付';
			}elseif($dd['dan_hao_lock_zhifu']==1){
				$str=array('dan_hao_lock_zhifu'=>0);
				$tits='未支付';
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>2,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function dan_hao_lock_fahuo($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单发货状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('已完成订单不能修改状态了','');
			}
			if($dd['dan_hao_lock_fahuo']==0){
				$str=array('dan_hao_lock_fahuo'=>1);
				$tits='已发货';
			}elseif($dd['dan_hao_lock_fahuo']==1){
				$str=array('dan_hao_lock_fahuo'=>0);
				$tits='未发货';
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>3,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function dan_hao_lock_wuxiao($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单无效状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('已完成订单不能修改状态了','');
			}
			if($dd['dan_hao_lock_wuxiao']==0){
				$str=array('dan_hao_lock_wuxiao'=>1);
				$tits='设为无效';
				$this->db->where('id',$dd['dan_haoid'])->update('haoma', array('hao_lock'=>0));
			}elseif($dd['dan_hao_lock_wuxiao']==1){
				$str=array('dan_hao_lock_wuxiao'=>0);
				$tits='设为有效';
				$this->db->where('id',$dd['dan_haoid'])->update('haoma', array('hao_lock'=>1));
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>4,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function dan_hao_lock_wancheng($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单完成状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_wuxiao']==1){
				show_message('无效订单，不能设置为已完成','');
			}
			if($dd['dan_hao_lock_zuofei']==1){
				show_message('作废订单，不能设置为已完成','');
			}
			if($dd['dan_hao_lock_wancheng']==0){				
				$str=array('dan_hao_lock_wancheng'=>1,'dan_hao_lock_zhifu'=>1,'dan_hao_lock_fahuo'=>1);
				$tits='已完成';
			}elseif($dd['dan_hao_lock_wancheng']==1){
				$str=array('dan_hao_lock_wancheng'=>0);
				$tits='未完成';
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>5,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function dan_hao_lock_zuofei($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单作废状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
//			if($dd['dan_hao_lock_queren']==0){
//				show_message('此项操作前，需要先确认订单','');
//			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('已完成订单，不能作废','');
			}
			if($dd['dan_hao_lock_zuofei']==0){
				if($dd['dan_hao_lock_wuxiao']==1){
					show_message('无效订单，不能设置为已完成','');
				}
				$str=array('dan_hao_lock_zuofei'=>1,'dan_hao_lock_queren'=>0,'dan_hao_lock_wuxiao'=>1);
				$tits='已作废';
				$this->db->where('id',$dd['dan_haoid'])->update('haoma', array('hao_lock'=>2));
			}elseif($dd['dan_hao_lock_zuofei']==1){
				$str=array('dan_hao_lock_zuofei'=>0);
				$tits='非作废';
				$this->db->where('id',$dd['dan_haoid'])->update('haoma', array('hao_lock'=>1));
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>6,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}

	public function dan_hao_lock_guozhang($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单过帐状态：';
		$url='admin/order/flist/'.$city.'/'.$page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_zuofei']==1){
				show_message('已作废订单不能过帐','');
			}
			if($dd['dan_hao_lock_wancheng']==0){
				show_message('未完成订单不能过帐','');
			}
			if($dd['dan_hao_lock_guozhang']==0){
				if($dd['dan_hao_lock_wuxiao']==1){
					show_message('无效订单，不能设置为已完成','');
				}
				$str=array('dan_hao_lock_guozhang'=>1);
				$tits='已过帐';
			}elseif($dd['dan_hao_lock_guozhang']==1){
				$str=array('dan_hao_lock_guozhang'=>0);
				$tits='未过帐';
			}
			if($this->cart_m->update_dingdan_list($id, $str)){
				$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>1,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>$tit.$tits,'do_date'=>time()));
				show_message($tit.$tits.'，修改成功',site_url($url),1);
			}
		}
	}
	
	public function fahuo($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='订单发货：';
		$url='admin/order/flist/'.$city.'/'.$page;
		$data['title'] = '订单发货';
		$data['siderbar'] = 'admin/order';
		$data['submenu'] = 'admin/order/flist';
		$data['toid'] = $id;
		$data['tocity'] = $city;
		$data['topage'] = $page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('此订单已经完成，无需操作','');
			}
			if($_POST){
				$str=array(
					'dan_hao_fahuo_type' => strip_tags($this->input->post('fahuo_type',true)),
					'dan_hao_shoukuan_type' => strip_tags($this->input->post('shoukuan_type',true)),
					'dan_hao_kuaidi_type' => strip_tags($this->input->post('kuaidi_type',true)),
					'dan_hao_fahuo_danhao' => strip_tags($this->input->post('fahuo_danhao',true)),
					'dan_hao_fahuo_kuan' => strip_tags($this->input->post('fahuo_kuan',true)),
					'dan_hao_fahuo_beizhu' => strip_tags($this->input->post('fahuo_beizhu',true)),
					'dan_hao_lock_fahuo' => 1,
				);
				if($this->cart_m->update_dingdan_list($id, $str)){
					$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>3,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>'订单设为发货：成功','do_date'=>time()));
					show_message('订单发货提交成功',site_url($url),1);
				}				
			}
			$data['haoma']=$this->haoma_m->get_haoma_by_ids($dd['dan_haoid']);
			$data['haoma']['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($dd['dan_city']),$this->haoma_m->get_unums_user($data['haoma']['hao_user']))*$data['haoma']['hao_jiage']);	
			$data['dingdan']=$dd;
			$data['dingdan']['dan_username']=$this->cart_m->get_dingdan_list_by_userid($dd['dan_userid']);
			$data['dingdan']['zhekou']=$this->cart_m->get_zhekou_by_userid($dd['dan_userid']);
			$data['dan']=$this->cart_m->get_dingdan_by_danhao($dd['dan_hao']);
			$data['work']=$this->work_m->get_work_dan_list_by_id($id,1);
			if($data['work']){
				foreach($data['work'] as $k => $v){
					$data['work'][$k]['username']=$this->work_m->get_work_username_by_userid($v['do_userid']);
				}
			}
		}
		$this->load->view('dingdan_fahuo', $data);
	}
	
	public function haoma($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='号码详情：';
		$url='admin/order/flist/'.$city.'/'.$page;
		$data['title'] = '号码详情';
		$data['siderbar'] = 'admin/order';
		$data['submenu'] = 'admin/order/flist';
		$data['toid'] = $id;
		$data['tocity'] = $city;
		$data['topage'] = $page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			$data['haoma']=$this->haoma_m->get_haoma_by_ids($dd['dan_haoid']);
			$data['haoma']['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($dd['dan_city']),$this->haoma_m->get_unums_user($data['haoma']['hao_user']))*$data['haoma']['hao_jiage']);	
			$data['dingdan']=$dd;
			$data['dingdan']['dan_username']=$this->cart_m->get_dingdan_list_by_userid($dd['dan_userid']);
			$data['dingdan']['zhekou']=$this->cart_m->get_zhekou_by_userid($dd['dan_userid']);
			$data['dan']=$this->cart_m->get_dingdan_by_danhao($dd['dan_hao']);
			$data['work']=$this->work_m->get_work_dan_list_by_id($id,1);
			if($data['work']){
				foreach($data['work'] as $k => $v){
					$data['work'][$k]['username']=$this->work_m->get_work_username_by_userid($v['do_userid']);
				}
			}			
		}
		$this->load->view('dingdan_haoma', $data);
	}
	
	public function wancheng($id,$city,$page)
	{
		$masterurl='admin/order/flist';
		$tit='完成订单：';
		$url='admin/order/flist/'.$city.'/'.$page;
		$data['title'] = '完成订单';
		$data['siderbar'] = 'admin/order';
		$data['submenu'] = 'admin/order/flist';
		$data['toid'] = $id;
		$data['tocity'] = $city;
		$data['topage'] = $page;
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!$this->cart_m->get_dingdan_list_by_id($id)){
			show_message('没有这个订单哦','');
		}else{
			$dd = $this->cart_m->get_dingdan_list_by_id($id);
			if($this->session->userdata('ucity')>0 && $dd['dan_city']!=$this->session->userdata('ucity')){
				show_message('操作无权限：非您站号码','');
			}
			if($dd['dan_hao_lock_queren']==0){
				show_message('此项操作前，需要先确认订单','');
			}
			if($dd['dan_hao_lock_wancheng']==1){
				show_message('此订单已经完成，无需操作','');
			}
			$data['haoma']=$this->haoma_m->get_haoma_by_ids($dd['dan_haoid']);
			$data['haoma']['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($dd['dan_city']),$this->haoma_m->get_unums_user($data['haoma']['hao_user']))*$data['haoma']['hao_jiage']);	
			$data['dingdan']=$dd;
			$data['dingdan']['dan_username']=$this->cart_m->get_dingdan_list_by_userid($dd['dan_userid']);
			$data['dingdan']['zhekou']=$this->cart_m->get_zhekou_by_userid($dd['dan_userid']);
			$data['dan']=$this->cart_m->get_dingdan_by_danhao($dd['dan_hao']);
			$data['work']=$this->work_m->get_work_dan_list_by_id($id,1);
			if($data['work']){
				foreach($data['work'] as $k => $v){
					$data['work'][$k]['username']=$this->work_m->get_work_username_by_userid($v['do_userid']);
				}
			}
			if($_POST){
				$dan_hao_maichujias=strip_tags($this->input->post('dan_hao_maichujias',true));
				if(empty($dan_hao_maichujias)){
					show_message('必须填写实际售出价','');
				}
				$str=array(
					'dan_hao_maichujias' => $dan_hao_maichujias,
					'dan_hao_lock_wancheng' => 1,
				);
				if($this->cart_m->update_dingdan_list($id, $str)){
					$this->db->set('ucredit','ucredit+'.$data['haoma']['hao_shoujia'],false)->where('userid',$dd['dan_userid'])->update('users');
					$this->work_m->add_work($s=array('do_id'=>$data['haoma']['hao_shoujia'],'do_type'=>2,'do_lei'=>0,'do_userid'=>$dd['dan_userid'],'do_memo'=>'购买号码：'.$data['haoma']['hao_title'].' 获取积分：'.$data['haoma']['hao_shoujia'],'do_date'=>time()));
					$this->work_m->add_work($s=array('do_id'=>$id,'do_type'=>1,'do_lei'=>5,'do_userid'=>$this->session->userdata('userid'),'do_memo'=>'订单设为完成状态：成功','do_date'=>time()));
					show_message('订单设为完成状态成功',site_url($url),1);
				}else{
					show_message('订单未做任何改变',site_url($url));
				}				
			}
		}
		$this->load->view('dingdan_wancheng', $data);
	}
	
	public function searcha($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$danhao=$this->input->post('danhao');

				$data['dingdan_list'] = $this->cart_m->searcha($danhao,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}			

			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function searchb($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$ren=$this->input->post('ren');

				$data['dingdan_list'] = $this->cart_m->searchb($ren,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}			

			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	public function searchc($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$tel=$this->input->post('tel');

				$data['dingdan_list'] = $this->cart_m->searchc($tel,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}			

			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function searchd($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$haoma=$this->input->post('haoma');

				$data['dingdan_list'] = $this->cart_m->searchd($haoma,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}


			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	public function searche($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$user=$this->input->post('user');

				$data['dingdan_list'] = $this->cart_m->searche($user,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}


			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function searchf($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$mai=$this->input->post('mai');

				$data['dingdan_list'] = $this->cart_m->searchf($mai,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}


			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function searchg($city=0)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			$data['citys'] = $this->city_m->get_city_all_list_ping();
			if($this->session->userdata('ucity')>0){
				$data['city']=$this->session->userdata('ucity');
			}else{
				$data['city']=$city;
			}
			if($data['city']>0){
				$data['cityname']=$this->city_m->get_cname_by_ucity_luo($data['city']);	
			}else{
				$data['cityname']='城市';
			}

			$data['page'] = 1;
			
			if($_POST){
				$wuliu=$this->input->post('wuliu');

				$data['dingdan_list'] = $this->cart_m->searchg($wuliu,$this->session->userdata('ucity'));
				if(isset($data['dingdan_list'])){
					foreach($data['dingdan_list'] as $k => $v){
						$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity_luo($v['dan_city']);	
						$data['dingdan_list'][$k]['dd_list']=$this->cart_m->get_dingdan_list_by_danhao($v['dan_hao']);
						if($data['dingdan_list'][$k]['dd_list']){
							foreach($data['dingdan_list'][$k]['dd_list'] as $s => $m){
								$data['dingdan_list'][$k]['dd_list'][$s]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($v['dan_city']),$this->haoma_m->get_unums_user($m['hao_user']))*$m['hao_jiage']);
								$data['dingdan_list'][$k]['dd_list'][$s]['dan_username']=$this->cart_m->get_dingdan_list_by_userid($m['dan_userid']);
							}
						}
					}
				}				
			}


			$this->load->view('dingdan_list', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function dingdanshow($dan_hao)
	{
		$masterurl='admin/order/flist';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '订单列表';
			$data['siderbar'] = 'admin/order';
			$data['submenu'] = 'admin/order/flist';
			/** 检查登陆 */
			
			if(!is_numeric($dan_hao)){
				show_message('参数错误','');
			}
			$data['dingdan']=$this->cart_m->get_dingdan_by_danhao($dan_hao);
			$data['dingdan']['dan_username']=$this->cart_m->get_dingdan_list_by_userid($data['dingdan']['dan_userid']);
			$data['dingdan']['zhekou']=$this->cart_m->get_zhekou_by_userid($data['dingdan']['dan_userid']);
			$data['dingdan_list']=$this->cart_m->get_dingdan_list_by_danhao($dan_hao);
			if($data['dingdan_list']){
				foreach($data['dingdan_list'] as $k => $v){
					$data['dingdan_list'][$k]['work']=$this->work_m->get_work_dan_list_by_id($v['dingdan_list_id'],1);
					$data['dingdan_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
					$data['dingdan_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
					$data['dingdan_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);	
					$data['dingdan_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($data['dingdan']['dan_city']),$this->haoma_m->get_unums_user($v['hao_user']));					
					$data['dingdan_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($data['dingdan']['dan_city']),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
					if($data['dingdan_list'][$k]['work']){
						foreach($data['dingdan_list'][$k]['work'] as $t => $m){
							$data['dingdan_list'][$k]['work'][$t]['username']=$this->work_m->get_work_username_by_userid($m['do_userid']);
						}
					}
				}
			}
			$this->load->view('dingdan_show',$data);
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
}