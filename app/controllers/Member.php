<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Member
#	scope:		PUBLIC

class Member extends FOX_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->load->model ('user_m');
		$this->load->model ('cart_m');
		$this->load->model ('zifei_m');
		$this->load->model ('question_m');
		$this->load->model ('xinxi_m');
		$this->load->model ('haoma_m');
		$this->load->model ('work_m');
		$this->load->library('form_validation');	
		$this->load->model('upload_m');
		$this->config->load('haoset');
		$this->config->load('payset');
		$this->load->library('myclass');
		$this->load->helper('htmlpurifier');
		if(!$this->auth->is_login ()){
			show_message('您没有登陆，会员请登陆',site_url('user/login/'.$this->session->userdata('cityid')));
		}

	}
	public function index ($cityid=0)
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
		if($this->session->userdata('ugroup')>10){
			redirect('admin/login');
		}
		//act
		$data['act']='member/index';
		$data['siderbar']='member/index';
		$data['submenu']='member/index';
		$data['title']='会员首页';
		$this->load->view('member_index',$data);
	}
	
	public function editme($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/editme';
		$data['siderbar']='member/editme';
		$data['submenu']='member/editme';
		$data['title']='完善资料';
		if($_POST){
			if($this->user_m->check_uid_utel($this->session->userdata('userid'), strip_tags($this->input->post('utel',true)))){
				show_message($data['title'].'：此电话已经存在',site_url($url));
			}
			$str = array(
				'uname' => strip_tags($this->input->post('uname',true)),
				'uzname' => strip_tags($this->input->post('uzname',true)),
				'utel' => strip_tags($this->input->post('utel',true)),
				'uqq' => strip_tags($this->input->post('uqq',true)),
				'uemail' => strip_tags($this->input->post('uemail',true)),
				'udress' => strip_tags($this->input->post('udress',true)),
			);
			$url='member/editme/'.$cityid;
			if($this->user_m->update_user($this->session->userdata('userid'), $str)){
				show_message($data['title'].'：提交成功！',site_url($url),1);
			}else{
				show_message($data['title'].'：未做任何修改',site_url($url));
			}
		}
		$this->load->view('member_editme',$data);
	}
	
	public function editpass($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/editpass';
		$data['siderbar']='member/editpass';
		$data['submenu']='member/editpass';
		$data['title']='修改密码';
		if($_POST){
			$url='member/editpass/'.$cityid;
			$psw = $this->input->post('npassword',true);
			$npsw = $this->input->post('qpassword',true);
			if($psw!=$npsw){
				show_message('两次输入密码不一致',site_url($url));
			}else{
				$salt =get_salt();
				$password= password_dohash($npsw,$salt);
				$str = array ('salt' => $salt, 'upassword' =>$password);
			}
			if($this->user_m->update_user($this->session->userdata('userid'), $str)){
				show_message($data['title'].'：提交成功！',site_url('user/logout/'.$cityid),1);
			}else{
				show_message($data['title'].'：未做任何修改',site_url($url));
			}
		}
		$this->load->view('member_editpass',$data);
	}
	
	public function editavatar($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/editavatar';
		$data['siderbar']='member/editavatar';
		$data['submenu']='member/editavatar';
		$data['title']='头像设置';
		if($_POST){
			$str = array(
				'uname' => strip_tags($this->input->post('uname',true)),
				'uzname' => strip_tags($this->input->post('uzname',true)),
				'utel' => strip_tags($this->input->post('utel',true)),
				'uqq' => strip_tags($this->input->post('uqq',true)),
				'uemail' => strip_tags($this->input->post('uemail',true)),
				'udress' => strip_tags($this->input->post('udress',true)),
			);
			$url='member/editavatar/'.$cityid;
			if($this->user_m->update_user($this->session->userdata('userid'), $str)){
				show_message($data['title'].'：提交成功！',site_url($url),1);
			}else{
				show_message($data['title'].'：未做任何修改',site_url($url));
			}
		}
		$this->load->view('member_editavatar',$data);
	}
	
    public function avatar_upload($cityid)
    {
        $config['upload_path'] = './uploads/avatar';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '512';
        $url='member/editavatar/'.$cityid;
		if($_FILES['avatar_file']['name']==''){
			show_message('您没有选择图片',site_url($url));
		}	
		
		$uptype=array('jpg','jpeg','png','bmp','png');
		$torrent = explode(".", $_FILES['avatar_file']['name']);
		$fileend = strtolower(end($torrent));
		if(!in_array($fileend, $uptype))
		{
			show_message('不允许的上传图片',site_url($url));
		}

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('avatar_file'))
        {
            $this->avatar($this->upload->display_errors());
        }
        else
        {
            //upload sucess
            $img_array = $this->upload->data();
            $this->load->library('AvatarResize');

            if ($this->avatarresize->resize($img_array['full_path'], 100 ,100 ,'avatar_big') && $this->avatarresize->resize($img_array['full_path'], 48 ,48 ,'avatar_middle') && $this->avatarresize->resize($img_array['full_path'], 24 ,24 ,'avatar_small')) {

                $data = array(
                    'avatar' => $this->avatarresize->get_dir()
                    );
                $this->user_m->update_user($this->session->userdata('userid'), $data);
                //删除tmp下的原图
                unlink($img_array['full_path']);
                $this->session->set_userdata('avatar',$data['avatar']);
				show_message('您的头像设置成功！',site_url($url),1);
            } else {
                //设置三个头像没有成功
                show_message('头像设置失败，请重新设置',site_url($url));
            }
        }
    }	
	
	function edit_check_password($password){
		$data = array(
			'username' => $this->session->userdata('username'),
			'upassword' => $password,
			);
		if (!$this->user_m->login($data)){
			$arr['getdata']='flase';
			echo json_encode($arr);
		} else {
			$arr['getdata']='true';
			echo json_encode($arr);
		}
	}
	
	public function kefuadd($cityid=0,$q_type=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/kefuadd';
		$data['siderbar']='member/kefuadd';
		$data['submenu']='member/kefuadd';
		$data['title']='在线咨询';
		if($_POST){
			$str = array(
				'q_title' => strip_tags($this->input->post('q_title',true)),
				'q_content' => html_purify($this->input->post('content',true),'comment'),
				'q_type' => strip_tags($this->input->post('q_type',true)),
				'q_name' => strip_tags($this->input->post('q_name',true)),
				'q_tel' => strip_tags($this->input->post('q_tel',true)),
				'q_userid' => $this->session->userdata('userid'),
				'q_city' => $cityid,
				'q_time' => time(),
			);
			$url='member/kefulist/'.$cityid;
			if($this->question_m->add_question($str)){
				show_message($data['title'].'：提交成功！',site_url($url),1);
			}else{
				show_message($data['title'].'：未做任何修改',site_url($url));
			}
		}
		$this->load->view('member_kefuadd',$data);
	}
	
	public function kefulist($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/kefulist';
		$data['siderbar']='member/kefulist';
		$data['submenu']='member/kefulist';
		$data['title']='我的咨询';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/kefulist/'.$cityid.'/');
		$config['total_rows'] = $this->question_m->count_user_question($this->session->userdata('userid'));
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

		$data['question_list'] = $this->question_m->get_user_question_list($start, $limit,$this->session->userdata('userid'));
		$this->load->view('member_kefulist',$data);
	}
	
	public function xinxiadd($cityid=0,$q_type=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/xinxiadd';
		$data['siderbar']='member/xinxiadd';
		$data['submenu']='member/xinxiadd';
		$data['title']='发布信息';
		if($_POST){
			$str = array(
				'x_title' => strip_tags($this->input->post('x_title',true)),
				'x_jiage' => strip_tags($this->input->post('x_jiage',true)),
				'x_content' => html_purify($this->input->post('content',true),'comment'),
				'x_name' => strip_tags($this->input->post('x_name',true)),
				'x_tel' => strip_tags($this->input->post('x_tel',true)),
				'x_qq' => strip_tags($this->input->post('x_qq',true)),
				'x_email' => strip_tags($this->input->post('x_email',true)),
				'x_userid' => $this->session->userdata('userid'),
				'x_city' => $cityid,
				'x_time' => time(),
			);
			$url='member/xinxilist/'.$cityid;
			if($this->xinxi_m->add_xinxi($str)){
				show_message($data['title'].'：提交成功！',site_url($url),1);
			}else{
				show_message($data['title'].'：未做任何修改',site_url($url));
			}
		}
		$this->load->view('member_xinxiadd',$data);
	}
	
	public function xinxilist($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/xinxilist';
		$data['siderbar']='member/xinxilist';
		$data['submenu']='member/xinxilist';
		$data['title']='我的信息';
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/xinxilist/'.$cityid.'/');
		$config['total_rows'] = $this->xinxi_m->count_user_xinxi($this->session->userdata('userid'));
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

		$data['xinxi_list'] = $this->xinxi_m->get_user_xinxi_list($start, $limit,$this->session->userdata('userid'));
		$this->load->view('member_xinxilist',$data);
	}
	
	public function xinxiedit($cityid=0,$id)
	{
		$masterurl='member/xinxiadd';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/xinxiadd';
		$data['siderbar']='member/xinxiadd';
		$data['submenu']='member/xinxiadd';
		$data['title']='修改信息';
		if(!$this->xinxi_m->get_xinxi_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['xinxi']=$this->xinxi_m->get_xinxi_by_id($id);
			if($data['xinxi']['x_userid']!=$this->session->userdata('userid')){
				show_message('这不是您的信息哦','');
			}
			if($_POST){
				$str = array(
					'x_title' => strip_tags($this->input->post('x_title',true)),
					'x_jiage' => strip_tags($this->input->post('x_jiage',true)),
					'x_content' => html_purify($this->input->post('content',true),'comment'),
					'x_name' => strip_tags($this->input->post('x_name',true)),
					'x_tel' => strip_tags($this->input->post('x_tel',true)),
					'x_qq' => strip_tags($this->input->post('x_qq',true)),
					'x_email' => strip_tags($this->input->post('x_email',true)),
					'x_userid' => $this->session->userdata('userid'),
					'x_city' => $cityid,
					'x_time' => time(),
				);
				$url='member/xinxilist/'.$cityid;
				if($this->xinxi_m->update_xinxi($id,$str)){
					show_message($data['title'].'：提交成功！',site_url($url),1);
				}else{
					show_message($data['title'].'：未做任何修改',site_url($url));
				}
			}
			$this->load->view('member_xinxiedit',$data);			
		}
	}
	
	public function xinxidel($cityid=0,$id)
	{
		$masterurl='member/xinxiadd';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/xinxiadd';
		$data['siderbar']='member/xinxiadd';
		$data['submenu']='member/xinxiadd';
		$data['title']='删除信息';
		if(!$this->xinxi_m->get_xinxi_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['xinxi']=$this->xinxi_m->get_xinxi_by_id($id);
			if($data['xinxi']['x_userid']!=$this->session->userdata('userid')){
				show_message('这不是您的信息哦','');
			}
			if((time()-$data['xinxi']['x_time'])<60*60){
				show_message('信息发布1小时内不能删除','');
			}
			//删除
			$url='member/xinxilist/'.$cityid;
			if($this->xinxi_m->del_xinxi($id)){
				show_message($data['title'].'成功！',site_url($url),1);
			}
		}
	}
	
	public function dailihao($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/dailihao';
		$data['siderbar']='member/dailihao';
		$data['submenu']='member/dailihao';
		$data['title']='我的号码';
		$this->config->load('haoset');
		$this->load->model ('zifei_m');
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/dailihao/'.$cityid.'/');
		$config['total_rows'] = $this->haoma_m->count_user_haoma($this->session->userdata('username'),0);
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

		$data['haoma_list'] = $this->haoma_m->get_user_haoma_list($start, $limit,$this->session->userdata('username'),0);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$this->load->view('member_dailihao',$data);
	}
	
	public function dailishouhao($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/dailishouhao';
		$data['siderbar']='member/dailishouhao';
		$data['submenu']='member/dailishouhao';
		$data['title']='已售号码';
		$this->config->load('haoset');
		$this->load->model ('zifei_m');
		//分页
		$limit = 20;
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/dailishouhao/'.$cityid.'/');
		$config['total_rows'] = $this->haoma_m->count_user_haoma($this->session->userdata('username'),1);
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

		$data['haoma_list'] = $this->haoma_m->get_user_haoma_list($start, $limit,$this->session->userdata('username'),1);
		if($data['haoma_list']){
			foreach($data['haoma_list'] as $k => $v){
				$data['haoma_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['haoma_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['haoma_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['haoma_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock($v['hao_lock'],$v['id']);					
				$data['haoma_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['haoma_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		$this->load->view('member_dailihao',$data);
	}
	
	public function dailiaddhao($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/dailihao';
		$data['siderbar']='member/dailihao';
		$data['submenu']='member/dailihao';
		$data['title']='号码发布';
		$this->config->load('haoset');
		$this->load->model ('zifei_m');
		$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));
		if($_POST){
			$str = array(
				'hao_title' => strip_tags($this->input->post('hao_title',true)),
				'hao_type' => strip_tags($this->input->post('hao_type',true)),
				'hao_pinpai' => ($this->input->post('hao_pinpai',true))?strip_tags($this->input->post('hao_pinpai',true)):'0',
				'hao_jiage' => strip_tags($this->input->post('hao_jiage',true)),
				'hao_huafei' => ($this->input->post('hao_huafei',true))?strip_tags($this->input->post('hao_huafei',true)):'0',
				'hao_heyue' => strip_tags($this->input->post('hao_heyue',true)),
				'hao_user' => $this->session->userdata('username'),
				'hao_city' => $this->session->userdata('ucity'),
				'hao_time' => time(),
			);
			$url='member/dailihao/'.$cityid;
			if($this->haoma_m->check_haoma_by_title_user($this->input->post('hao_title'),$this->session->userdata('username'))){
				$hs=$this->haoma_m->check_haoma_by_title($this->input->post('hao_title'),$this->session->userdata('username'));
				if($this->haoma_m->update_haoma($hs['id'],$str)){
					show_message($this->input->post('hao_title').'更新成功！',site_url($url),1);
				}
			}else{
				if($this->haoma_m->add_haoma($str)){
					show_message($data['title'].'成功！',site_url($url),1);
				}
			}
		}
		$this->load->view('member_dailiaddhao',$data);
	}
	
	public function dailiedithao($cityid=0,$id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/dailihao';
		$data['siderbar']='member/dailihao';
		$data['submenu']='member/dailihao';
		$data['title']='修改号码';
		$this->config->load('haoset');
		$this->load->model ('zifei_m');
		
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));
		if(!$this->haoma_m->get_haoma_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['haoma']=$this->haoma_m->get_haoma_by_id($id);
			$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city_type($this->session->userdata('ucity'),$data['haoma']['hao_type']);
			if($data['haoma']['hao_user']!=$this->session->userdata('username')){
				show_message('这不是您的号码哦','');
			}
			if($data['haoma']['hao_lock']>0){
				show_message('号码已经订售中，无法修改','');
			}
			if($_POST){
				$str = array(
					'hao_title' => strip_tags($this->input->post('hao_title',true)),
					'hao_type' => strip_tags($this->input->post('hao_type',true)),
					'hao_pinpai' => ($this->input->post('hao_pinpai',true))?strip_tags($this->input->post('hao_pinpai',true)):'0',
					'hao_jiage' => strip_tags($this->input->post('hao_jiage',true)),
					'hao_huafei' => ($this->input->post('hao_huafei',true))?strip_tags($this->input->post('hao_huafei',true)):'0',
					'hao_heyue' => strip_tags($this->input->post('hao_heyue',true)),
					'hao_user' => $this->session->userdata('username'),
					'hao_city' => $this->session->userdata('ucity'),
					'hao_time' => time(),
				);
				$url='member/dailihao/'.$cityid;
				if($this->haoma_m->update_haoma($id,$str)){
					show_message($data['title'].'：提交成功！',site_url($url),1);
				}else{
					show_message($data['title'].'：未做任何修改',site_url($url));
				}
			}
			$this->load->view('member_dailiedithao',$data);			
		}
	}
	public function dailidelhao($cityid=0,$id)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/dailihao';
		$data['siderbar']='member/dailihao';
		$data['submenu']='member/dailihao';
		$data['title']='删除号码';
		if(!$this->haoma_m->get_haoma_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['haoma']=$this->haoma_m->get_haoma_by_id($id);
			if($data['haoma']['hao_user']!=$this->session->userdata('username')){
				show_message('这不是您的号码哦','');
			}
			if($data['haoma']['hao_lock']>0){
				show_message('号码已经订售中，无法修改','');
			}
			//删除
			$url='member/dailihao/'.$cityid;
			if($this->haoma_m->del_haoma($id)){
				show_message($data['title'].'成功！',site_url($url),1);
			}
		}
	}
	
	public function dailiruhao ($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		//act
		$data['act']='member/dailiruhao';
		$data['siderbar']='member/dailiruhao';
		$data['submenu']='member/dailiruhao';
		$data['title']='导入号码';
		$this->config->load('haoset');
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));
		$this->load->view('member_dailiruhao',$data);
	}
	
	public function getpinpai()
	{
		$city=$this->session->userdata('ucity');
		$hao_type = $this->input->post('hao_type',true);
		$this->load->model ('zifei_m');
		if($city){
			$pinpai=$this->zifei_m->get_all_pinpai_by_city_type($city,$hao_type);
			if($pinpai){
				foreach($pinpai as $k => $v){
					echo '<label class="button button-little"><input name="hao_pinpai" type="radio" value="'.$v['pin_num'].'" data-validate="radio:请选择">';
					echo '<span>'.$v['pin_title'].'</span></label> ';
				}
			}else{
				echo '<font color="red">未找到，加载失败</font>';
			}
			
		}else{
			echo '<font color="red">品牌加载失败</font>';
		}		
	}
	
	public function daorucome($hao_pinpai='',$hao_type='',$hao_excel='',$page=1)
	{
		$masterurl='member/dailiruhao';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		$data['title'] = '批量导入号码';	
		$hao_city = $this->session->userdata('ucity');	
		$data['hao_pinpai'] = $hao_pinpai;	
		$data['hao_type'] = $hao_type;	
		$data['hao_excel'] = str_replace('fox','/',$hao_excel);
		$handle = fopen(FCPATH.$data['hao_excel'], 'r'); 
		$result = $this->haoma_m->input_csv($handle); //解析csv 
		$len_result = count($result); 
		/** 循环读取每个单元格的数据 */
		$limit=5000;
		$start = ($page-1)*$limit;
		if($page==1){
			$nums=$start+2;
		}else{
			$nums=$start+1;
		}
		$starts = $limit*$page;
		if($starts>$len_result){
			$starts = $len_result;
		}
		for ($i = $start; $i < $starts; $i++) { //循环获取各字段值 
			if($hao_pinpai=='nopinpai' && empty($result[$i][5])){
				echo '您没有选择品牌，无法导入';exit;
			}
			if(!empty($result[$i][0])&&isset($result[$i][0])){
				$hao_title = ($result[$i][0])?$result[$i][0]:''; 
				$hao_jiage = intval(($result[$i][1]))?intval($result[$i][1]):0; 
				$hao_huafei = intval(($result[$i][2]))?intval($result[$i][2]):0; 
				$hao_heyue = ($result[$i][3])?$result[$i][3]:''; //中文转码 
				$hao_beizhu = ($result[$i][4])?$result[$i][4]:''; //中文转码 
				if($hao_pinpai<>'nopinpai'){
					$hao_pinpai =(int)$hao_pinpai;
				}else{
					$hao_pinpai = (int)$result[$i][5];
				}	
				$hao_user = $this->session->userdata('username'); 
				$hao_time = time();
				$data_values .= "($hao_city,$hao_type,$hao_pinpai,'$hao_title',$hao_jiage,$hao_huafei,'$hao_heyue','$hao_beizhu','$hao_user',$hao_time),"; 
			}
		} 
		if($start<$len_result){
			$data_values = substr($data_values,0,-1); //去掉最后一个逗号 
			if ($this->db->query("insert into `{$this->db->dbprefix}haoma` (hao_city,hao_type,hao_pinpai,hao_title,hao_jiage,hao_huafei,hao_heyue,hao_beizhu,hao_user,hao_time) values $data_values"))
			{			
				$this->db->query("delete from `{$this->db->dbprefix}haoma` where id in (select * from (select min(id) from `{$this->db->dbprefix}haoma` group by hao_title having count(hao_title) > 1) as b)");
				$data['page']=$page;
				$data['pages']=ceil($len_result/$limit); 
				$data['hao_excels']=str_replace('/','fox',$data['hao_excel']);
				$data['location'] = site_url('member/daorucome/'.$data['hao_pinpai'].'/'.$data['hao_type'].'/'.$data['hao_excels'].'/'.($data['page']+1));
			}
			else
			{
				echo "导入异常停止!";
			}
			fclose($handle); //关闭指针 
		}else{
			$data['page']=0;
		}
		
		$this->load->view('member_daorucom', $data);
	}
	
	public function dailidelallhao ($cityid=0)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		//act
		$data['act']='member/dailidelallhao';
		$data['siderbar']='member/dailidelallhao';
		$data['submenu']='member/dailidelallhao';
		$data['title']='批量删除';
		$this->config->load('haoset');
		$data['ucity'] = $this->city_m->get_cname_by_ucity($this->session->userdata('ucity'));
		$this->load->view('member_dailidelallhao',$data);
	}
	public function get_hao_by_del()
	{
		$hao_user=$this->session->userdata('username');
		$hao_time=($this->input->post('hao_time'))?$this->input->post('hao_time'):'notime';
		$hao_type=($this->input->post('hao_type'))?$this->input->post('hao_type'):'notype';
		$hao_pinpai=($this->input->post('hao_pinpai'))?$this->input->post('hao_pinpai'):'nopinpai';
		$hao_city=$this->session->userdata('ucity');
		$count = $this->haoma_m->get_count_by_user_member($hao_user,$hao_time,$hao_city,$hao_type,$hao_pinpai);
		echo $count;
	}
	public function del_hao_by_del()
	{
		$masterurl='member/dailidelallhao';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		$hao_user=$this->session->userdata('username');
		$hao_time=($this->input->post('hao_time'))?$this->input->post('hao_time'):'notime';
		$hao_type=($this->input->post('hao_type'))?$this->input->post('hao_type'):'notype';
		$hao_pinpai=($this->input->post('hao_pinpai'))?$this->input->post('hao_pinpai'):'nopinpai';
		$hao_city=$this->session->userdata('ucity');
		if($this->haoma_m->del_haoma_by_user_member($hao_user,$hao_time,$hao_city,$hao_type,$hao_pinpai)){
			echo '1';
		}else{
			echo '0';
		}		
	}
	
	public function gouwuche($cityid=0,$haoid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($haoid)){
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
		$this->cart_m->update_gouwuche_foxid_userid($this->fox_scheid,$this->session->userdata('userid'));
		if($haoid>0 && !$this->cart_m->get_che_by_haoid($haoid)){
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
		$config['base_url'] = site_url('member/gouwuche/'.$cityid.'/'.$haoid);
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
		if($data['cart_list']){
			foreach($data['cart_list'] as $k => $v){
				$data['cart_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['cart_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['cart_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['cart_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock_cart($v['hao_lock'],$v['id']);					
				$data['cart_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['cart_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);					
			}
		}
		//act
		$data['act']='member/gouwuche';
		$data['siderbar']='member/gouwuche';
		$data['submenu']='member/gouwuche';
		$data['title']='我的购物车';
		$this->load->view('member_cart_list',$data);
	}
	
	public function gouwuchedel($cityid=0,$id)
	{
		$masterurl='member/gouwuche';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/gouwuche';
		$data['siderbar']='member/gouwuche';
		$data['submenu']='member/gouwuche';
		$data['title']='删除购物车';
		if(!$this->cart_m->get_che_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['che']=$this->cart_m->get_che_by_id($id);
			if($data['che']['che_hao']!=$this->fox_scheid){
				show_message('这不是您的购物车哦','');
			}
			//删除
			$url='member/gouwuche/'.$cityid;
			if($this->cart_m->del_che($id)){
				redirect(site_url($url));
			}
		}
	}
	public function gouwuchedelall($cityid=0)
	{
		$masterurl='member/gouwuche';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/gouwuche';
		$data['siderbar']='member/gouwuche';
		$data['submenu']='member/gouwuche';
		$data['title']='删除购物车';
		//删除
		$url='member/gouwuche/'.$cityid;
		if($this->cart_m->del_all()){
			redirect(site_url($url));
		}
	}
	public function gouwudingdan($cityid=0)
	{
		$masterurl='member/gouwuche';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		if($_POST){
			$danhao=$this->cart_m->get_order_maxonum();
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
				$url=site_url('member/gouwudds/'.$cityid.'/'.$danhao);
				show_message('恭喜您，订单提交成功',$url,1);
			}
		}
	}
	
	public function gouwudds($cityid=0,$dan_hao)
	{
		$masterurl='member/gouwuche';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
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
		$data['act']='member/gouwudd';
		$data['siderbar']='member/gouwudd';
		$data['submenu']='member/gouwudd';
		$data['title']='订单详情';
		$this->load->view('member_dingdan_show',$data);
	}
	
	public function gouwudd($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		
		$this->cart_m->update_gouwuche_foxid_userid($this->fox_scheid,$this->session->userdata('userid'));

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
				$data['dingdan_list'][$k]['dan_city']=$this->city_m->get_cname_by_ucity($v['dan_city']);	
				$data['dingdan_list'][$k]['dan_lock_wancheng']=$this->cart_m->get_dingdan_list_lock_wancheng($v['dan_haoid']);
			}
		}
		//act
		$data['act']='member/gouwudd';
		$data['siderbar']='member/gouwudd';
		$data['submenu']='member/gouwudd';
		$data['title']='我的订单';
		$this->load->view('member_dingdan_list',$data);
	}
	public function gouwusc($cityid=0,$haoid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
		if(!is_numeric($cityid)){
			show_message('参数错误','');
		}
		if(!is_numeric($haoid)){
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

		if($haoid>0 && !$this->cart_m->get_shoucang_by_haoid($haoid)){
			$str = array(
				'userid' => $this->session->userdata('userid'),
				'shoucangid' => $haoid,
			);
		
			$this->cart_m->add_shoucang($str);
		}
		//分页
		$limit = 20;
		$data['cart_count']=$this->cart_m->count_shoucang($this->session->userdata('userid'));
		$config['uri_segment'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/gouwusc/'.$cityid.'/'.$haoid);
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

		$data['sc_list'] = $this->cart_m->get_all_shoucang_list($start, $limit,$this->session->userdata('userid'));
		if($data['sc_list']){
			$haos = array();
			foreach($data['sc_list'] as $k => $v){
				$data['sc_list'][$k]['hao_city']=$this->city_m->get_cname_by_ucity($v['hao_city']);					
				$data['sc_list'][$k]['hao_pinpai']=$this->zifei_m->get_pname_by_pid($v['hao_pinpai']);					
				$data['sc_list'][$k]['hao_dig']=$this->haoma_m->get_hao_dig($v['hao_dig'],$v['id']);					
				$data['sc_list'][$k]['hao_lock']=$this->haoma_m->get_hao_lock_cart($v['hao_lock'],$v['id']);					
				$data['sc_list'][$k]['hao_nums']=fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']));					
				$data['sc_list'][$k]['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($cityid),$this->haoma_m->get_unums_user($v['hao_user']))*$v['hao_jiage']);
                if($k<6){
					$haos[$k]=$data['sc_list'][$k];
				}				
			}
			setcookie("scang", json_encode($haos), time()+360000);	
		}
		//act
		$data['act']='member/gouwusc';
		$data['siderbar']='member/gouwusc';
		$data['submenu']='member/gouwusc';
		$data['title']='我的收藏';
		$this->load->view('member_sc_list',$data);
	}
	
	public function gouwuscdel($cityid=0,$id)
	{
		$masterurl='member/gouwusc';
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$pingcity=$this->city_m->get_city_by_cid_web($cityid);
		if($pingcity['pingcid']>0){
			$pingcityid=$pingcity['pingcid'];
			$data['citys']['cname']=$this->city_m->get_cname_by_ucity_luo($pingcity['pingcid']);
		}else{
			$pingcityid=$cityid;
		}
		//act
		$data['act']='member/gouwusc';
		$data['siderbar']='member/gouwusc';
		$data['submenu']='member/gouwusc';
		$data['title']='删除收藏';
		if(!$this->cart_m->get_shoucang_by_id($id)){
			show_message('参数错误','');
		}else{
			$data['sc']=$this->cart_m->get_shoucang_by_id($id);
			if($data['sc']['userid']!=$this->session->userdata('userid')){
				show_message('这不是您的收藏哦','');
			}
			//删除
			$url='member/gouwusc/'.$cityid;
			if($this->cart_m->del_shoucang($id)){
				show_message('删除收藏成功',site_url($url),1);
			}
		}
	}
	
	public function gouwufen($cityid=0,$page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2);
		/** 检查登陆 */
		if(!$this->auth->is_master($masterurl))
		{
			show_message('您没有此操作权限','');
		}
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
		$data['cart_count']=$this->work_m->count_work_fen($this->session->userdata('userid'));
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['base_url'] = site_url('member/gouwufen/'.$cityid);
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

		$data['fen_list'] = $this->work_m->get_all_work_fen_list($start, $limit,$this->session->userdata('userid'));

		//act
		$data['act']='member/gouwufen';
		$data['siderbar']='member/gouwufen';
		$data['submenu']='member/gouwufen';
		$data['title']='我的积分';
		$this->load->view('member_fen_list',$data);
	}
	
}