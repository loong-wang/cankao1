<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	User_m
#	scope:		PUBLIC

class User_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
		$this->zhudomain=$this->config->item('dsfox_domain');
	}
	
	public function count_dingdan($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_dingdan_today($ucity=0)
	{
		$startx = strtotime(date('Y-m-d 00:00:00'));
		$this->db->select("id");
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$this->db->where('dan_time >=',$startx);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_haoma($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_haoma_lock($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_lock >',0);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_user_shu($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('users');
		if($ucity>0){
			$this->db->where('ucity',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_user_shu_today($ucity=0)
	{
		$startx = strtotime(date('Y-m-d 00:00:00'));
		$this->db->select("id");
		$this->db->from('users');
		if($ucity>0){
			$this->db->where('ucity',$ucity);
		}
		$this->db->where('uregtime >=',$startx);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_users($ugroup,$ug=0,$ucity=0)
	{
		$this->db->select("userid");
		$this->db->from('users');
		if($ugroup<10){
			$this->db->where('ugroup <',10);
		}elseif($ugroup>10){
			$this->db->where('ugroup >',10);
		}
		if($ug>0){
			$this->db->where('ugroup',$ug);
		}
		if($ucity>0){
			$this->db->where('ucity',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_users_group($ugroup)
	{
		$this->db->select("userid");
		$this->db->from('users');
		$this->db->where('ugroup',$ugroup);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_user_by_ulock($ulock)
	{
		if($ulock==0){
			return '<span class="badge badge-success">正常</span>';
		} else	{
			return '<span class="badge badge-danger">锁定</span>';
		}
	}

	function register($data){
		return $this->db->insert('users',$data);
	}
	/*login in*/
    function login($data,$loveme=0){
	    $user = $this->get_user_by_username($data['username']);
	    if($user){
			$this->session->set_userdata('user_ulogtime',$user['ulogtime']);
			$password = password_dohash($data['upassword'],$user['salt']);
			if($user['upassword']==$password){
				$this->session->set_userdata(array ('userid' => $user['userid'], 'username' => $user['username'], 'uname' => $user['uname'], 'avatar' => $user['avatar'], 'ugroup' => $user['ugroup'], 'utype' => $user['utype'], 'group_name' => $user['group_name'], 'ulock' => $user['ulock'], 'ucredit' => $user['ucredit'], 'umoney' => $user['umoney'], 'ucity' => $user['ucity'], 'ukey' => $this->config->item('encryption_key'), 'cookie_domain' => $this->zhudomain));
				if($loveme==1){
					set_cookie('loveme', $password, 86500);				
				}
				session_write_close();
				return TRUE;
			} else {
				return FALSE;
			}
	    } else {
			return FALSE;
		}
    }
	function checklogin($uid,$loveme){
		$user=$this->user_m->get_user_by_userid($uid);
		if($user){
			if($user['upassword']==$loveme){
				$this->session->set_userdata(array ('userid' => $user['userid'], 'username' => $user['username'], 'uname' => $user['uname'], 'avatar' => $user['avatar'], 'ugroup' => $user['ugroup'], 'utype' => $user['utype'], 'group_name' => $user['group_name'], 'ulock' => $user['ulock'], 'ucredit' => $user['ucredit'], 'umoney' => $user['umoney'], 'ucity' => $user['ucity'], 'ukey' => $this->config->item('encryption_key'), 'cookie_domain' => $this->zhudomain));
				set_cookie('loveme', $loveme, 86500);
				session_write_close();
			}
		}
	}
	function check_register($email){
		$query = $this->db->get_where('users',array('email'=>$email));
        return $query->row_array();
	}
	function check_utel($utel){
		$query = $this->db->get_where('users',array('utel'=>$utel));
        return $query->row_array();
	}
	function check_uid_utel($userid, $utel){
		$query = $this->db->get_where('users',array('utel'=>$utel,'userid !='=>$userid));
        return $query->row_array();
	}
	function check_ulock($username){
		$query = $this->db->select('ulock')->from('users')->where('username',$username)->or_where('utel',$username)->get();
        $ulock = $query->row_array();
		if($ulock['ulock']==0){
			return true;
		}else{
			return false;
		}
	}
	function add_log($data){
		return $this->db->insert('login_log',$data);
	}
	public function update_log($loid,$lotype)
	{
		$this->db->set('lotype',$lotype)->where('loid',$loid)->update('login_log');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function get_user_by_username($username){
		$query = $this->db->select('a.*,b.*')->from('users a')->join('user_groups b','b.group_type=a.ugroup','LEFT')->where('a.username',$username)->or_where('a.utel',$username)->get();
        return $query->row_array();
	}
	function get_user_by_userid($userid){
		$query = $this->db->select('a.*,b.*')->from('users a')->join('user_groups b','b.group_type=a.ugroup','LEFT')->where('a.userid',$userid)->get();
        return $query->row_array();
	}
	public function get_user_by_uid($uid)
	{
		$query = $this->db->get_where('users', array('userid'=>$uid));
		return $query->row_array();
	}

	function update_user($uid, $data){
		$this->db->where('userid',$uid);
  		$this->db->update('users', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_pwd($data){
		$query = $this->get_user_by_uid($data['userid']);
		$password = password_dohash($data['password'],@$query['salt']);
		$this->db->where('userid',$data['userid']);
		$this->db->update('users', array('upassword'=>$password));
		return $this->db->affected_rows();
	}
	function update_avatar($avatar,$uid)
	{
		$this->db->where('userid',$uid);
		$this->db->update('users', array('avatar'=>$avatar));
	}
	public function get_all_users($page, $limit)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->order_by('userid','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_users_list($page, $limit,$ugroup,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('users');
		if($ugroup<10){
			$this->db->where('ugroup <',10);
		}elseif($ugroup>10){
			$this->db->where('ugroup >',10);
		}
		if($ug>0){
			$this->db->where('ugroup',$ug);
		}
		if($ucity>0){
			$this->db->where('ucity',$ucity);
		}
		$this->db->order_by('userid','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function is_user($uid)
	{
		return ($this->auth->is_login() && $uid==$this->session->userdata('userid')) ? TRUE : FALSE;
	}
	function get_user_msg($uid,$username){
		if($uid){
		   $query = $this->db->select('username')->get_where('users',array('userid'=>$uid));
		}else{
		   $query = $this->db->select('userid')->get_where('users',array('username'=>$username));
		}
	   	   return $query->row_array();
	}

	public function getpwd_by_username($username)
	{
		print_r($username);
		$query = $this->db->select('userid,email,password,ugroup')->get_where('users', array('username'=>$username));
		return $query->row_array();
	}
	public function search_user_by_username($username)
	{
		$query = $this->db->like('username',$username)->get('users');
		return $query->result_array();
	}
	public function update_ulognum($uid,$num=1)
	{
		$this->db->set('ulognum','ulognum+'.$num,false)->where('userid',$uid)->update('users');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function update_credit($uid,$credit)
	{
		$this->db->set('ucredit','ucredit+'.$credit,false)->where('userid',$uid)->update('users');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_user($uid)
	{
		$this->db->where('userid',$uid)->delete('users');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
