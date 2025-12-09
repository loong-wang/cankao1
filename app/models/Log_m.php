<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Log_m
#	scope:		PUBLIC

class Log_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function log_list($page, $limit)
	{
		$this->db->select('*');
		$this->db->from('login_log');
		$this->db->order_by('lotime','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	function del_log($loid)
	{
		$this->db->where('loid',$loid)->delete('login_log');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_all()
	{
		$s=time()-60*60*24;
		$this->db->where('lotime <',$s)->delete('login_log');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
