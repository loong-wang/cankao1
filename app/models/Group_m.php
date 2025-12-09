<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX-HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Group_m
#	scope:		PUBLIC

class Group_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}

	public function group_list($page, $limit)
	{
		$query = $this->db->order_by('gid')->limit($limit,$page)->get('user_groups');
		return $query->result_array();
	}
	public function group_list_by_sets($sets)
	{
		if($sets<10){
			$query = $this->db->where('group_type <',10)->order_by('gid')->get('user_groups');
		}elseif($sets>10){
			$query = $this->db->where('group_type >',10)->order_by('gid')->get('user_groups');
		}else{
			$query = $this->db->order_by('gid')->get('user_groups');
		}
		
		if($query->num_rows>0){
			return $query->result_array();
		} else	{
			return false;
		}
	}
	
	public function get_all_group_name_by_mgroup($group_type)
	{
		if(strstr($group_type,",")){
			$t='';
			foreach(explode(',',$group_type) as $s){
				$query = $this->db->select('group_name')->where('group_type',$s)->get('user_groups')->row_array();
				$t .='<span class="label label-sm label-inverse arrowed-in">'.$query['group_name'].'</span>';
			}
			return $t;
		}else{
			$query = $this->db->select('group_name')->where('group_type',$group_type)->get('user_groups')->row_array();
			return '<span class="label label-sm label-inverse arrowed-in">'.$query['group_name'].'</span>';
		}
	}
	
	public function get_groupname_by_user_group_type($group_type)
	{
		$this->db->select('group_name');
		$query = $this->db->where('group_type',$group_type)->get('user_groups');
		return $query->row_array();
	}
	public function get_zhekou_by_user_group_type($group_type)
	{
		$this->db->select('zhekou');
		$query = $this->db->where('group_type',$group_type)->get('user_groups');
		return $query->row_array();
	}
	public function get_group_info($gid)
	{
		$query = $this->db->get_where('user_groups',array('gid'=>$gid));
		if($query->num_rows>0){
			return $query->row_array();
		} else
		{
			return false;
		}
	}

	public function check_group($group_name)
	{
		$query = $this->db->get_where('user_groups',array('group_name'=>$group_name));
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

}
