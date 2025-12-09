<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Auth
{
	/**
     * 用户
     *
     * @access private
     * @var array
     */
    private $_user = array();
    
    /**
     * 是否已经登录
     * 
     * @access private
     * @var boolean
     */
    private $_hasLogin = NULL;
    
	/**
    * CI句柄
    * 
    * @access private
    * @var object
    */
	private $_CI;

	 /**
     * 构造函数
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        /** 获取CI句柄 */
		$this->_CI = & get_instance();
		$this->_CI->load->model('user_m');		
		$this->_CI->load->helper('cookie');
		$this->_user = unserialize($this->_CI->session->userdata('user'));		
		log_message('debug', "FOX: Authentication library Class Initialized");
    }
	
	public function user_logout($cityid){
		delete_cookie('userid');
		delete_cookie('username');
		delete_cookie('ugroup');
		delete_cookie('openid');
		delete_cookie('loveme');
		$this->_CI->session->unset_userdata('userid');
		$this->_CI->session->unset_userdata('username');
		$this->_CI->session->sess_destroy();
		redirect('user/login/'.$cityid);
	}
	
    /**
     * 判断用户是否已经登录
     *
     * @access public
     * @return void
     */

	public function is_login(){
		$uid=$this->_CI->session->userdata('userid');
		$encryption_key=$this->_CI->config->item('encryption_key');
		$loveme=get_cookie('loveme',TRUE);
		if(isset($loveme)){
			$this->_CI->user_m->checklogin($uid,$loveme);
		}
		$ukey=$this->_CI->session->userdata('ukey');
		if(!$uid || $ukey!=$encryption_key){
			return false;
		}else{
			return true;
		}
	}
	
	 /**
     * 判断是否管理员
     *
     * @access 	public
     * @param 	string 	$group 	用户组
     * @param 	boolean $return 是否为返回模式
     * @return 	boolean
     */
	public function is_admin()
	{
		$ugroup=$this->_CI->session->userdata('ugroup');
		/** 权限验证通过 */
        return ($this->is_login() && $ugroup!='' && $ugroup==19)? TRUE : FALSE;
	}
	
	public function is_admins()
	{
		$ugroup=$this->_CI->session->userdata('ugroup');
		/** 权限验证通过 */
        return ($this->is_login() && $ugroup!='' && $ugroup>10)? TRUE : FALSE;
	}

	public function is_master($url)
	{
		$query = $this->_CI->db->select('group_type')->get_where('sys_menus', array('url'=>$url))->row_array();
		$data = explode(',',@$query['group_type']);
		//return var_dump($data);
		$group_type=$this->_CI->session->userdata('ugroup');
		/** 权限验证通过 */
        return ($this->is_login() && in_array($group_type, $data))? TRUE : FALSE;
	}

	public function is_user($uid)
	{
		$suid=$this->_CI->session->userdata('uid');
		if($suid!='' && $uid==$suid){
			return TRUE;
		} else {
			return FALSE;
		}
		//return ($this->is_login() && $uid==$this->_CI->session->userdata('uid')) ? TRUE : FALSE;
	}
	public function permit_edit()
	{
		
	}
	//浏览权限
	public function user_permit($node_id)
	{
		$query = $this->_CI->db->select('permit')->get_where('nodes', array('node_id'=>$node_id))->row_array();
		if(@$query['permit']){
			$data = explode(',',$query['permit']);
			$gid=$this->_CI->session->userdata('gid');
			/** 权限验证通过 */
	        return ($this->is_login() && in_array($gid, $data))? TRUE : FALSE;	
		} else{
			return TRUE;
		}

	}
	
	//发布权限
	public function user_addpermit($node_id)
	{
		$query = $this->_CI->db->select('addpermit')->get_where('nodes', array('node_id'=>$node_id))->row_array();
		if(@$query['addpermit']){
			$data = explode(',',$query['addpermit']);
			$gid=$this->_CI->session->userdata('gid');
			/** 权限验证通过 */
	        return ($this->is_login() && in_array($gid, $data))? TRUE : FALSE;	
		} else{
			return TRUE;
		}

	}
	
	 /**
     * 处理用户登出
     * 
     * @access public
     * @return void
     */
	public function process_logout()
	{
		$this->_CI->session->sess_destroy();
		
		redirect('admin/login');
	}
	
	/**
     * 处理用户登录
     *
     * @access public
     * @param  array $user 用户信息
     * @return boolean
     */
	public function process_login($user)
	{
		/** 获取用户信息 */
		$this->_user = $user;
		
		/** 每次登陆时需要更新的数据 */
		$this->_user['logged'] = now();
		$this->_user['lastlogin'] = $user['logged'];
		/** 每登陆一次更新一次token */
		$this->_user['token'] = sha1(now().rand());
		
		if($this->_CI->user_m->update_user($this->_user['uid'],$this->_user))
		{
			/** 设置session */
			$this->_set_session();
			$this->_hasLogin = TRUE;
			
			return TRUE;
		}
		
		return FALSE;
	}

	/**
     * 设置session
     *
     * @access private
     * @return void
     */
	private function _set_session() 
	{
		$session_data = array('user' => serialize($this->_user));
		
		$this->_CI->session->set_userdata($session_data);
	}

}

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */
