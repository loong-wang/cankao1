<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX-HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Group_m
#	scope:		PUBLIC

class Memu_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_memu($pid,$mtype=0)
	{
		$this->db->select("id");
		$this->db->from('sys_menus');
		$this->db->where('pid',$pid);
		if($mtype<>0){
			if($mtype<10){
				$this->db->where('mtype <',10);
			}elseif($mtype>10){
				$this->db->where('mtype >',10);
			}elseif($mtype==10){
				$this->db->where('mtype',$mtype);
			}			
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_memu_dao($pid,$mtype=0)
	{
		$this->db->select("id");
		$this->db->from('sys_menus');
		$this->db->where('pid',$pid);
		$this->db->where('mtype',$mtype);
		$total=$this->db->count_all_results();
		return $total;	
	}

	public function memu_check_by_url($url)
	{
		$query = $this->db->where('url',$url)->order_by('id')->get('sys_menus');
		if($query->num_rows>0){
			return true;
		} else	{
			return false;
		}
	}	
	
	public function get_memu_info_by_id($id)
	{
		$query = $this->db->get_where('sys_menus',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function memu_list_by_pid($mtype,$pid)
	{
		if($mtype<>0){
			if($mtype<10){
				$query = $this->db->where('pid',$pid)->where('mtype <',10)->order_by('sort')->get('sys_menus');
			}elseif($mtype>10){
				$query = $this->db->where('pid',$pid)->where('mtype >',10)->order_by('sort')->get('sys_menus');
			}elseif($mtype==10){
				$query = $this->db->where('pid',$pid)->where('mtype',$mtype)->order_by('sort')->get('sys_menus');
			}			
		}else{
			$query = $this->db->where('pid',$pid)->order_by('sort')->get('sys_menus');
		}
		
		if($query->num_rows>0){
			return $query->result_array();
		} else	{
			return false;
		}
	}
	
	public function get_all_memus($page,$limit,$mtype)
	{
		$this->db->select('*');
		if($mtype<>0){
			if($mtype<10){
				$this->db->where('mtype <',10);
			}elseif($mtype>10){
				$this->db->where('mtype >',10);
			}elseif($mtype==10){
				$this->db->where('mtype',$mtype);
			}
		}		
		$this->db->where('pid', 0);
		$this->db->order_by('ctime', 'desc');
		$this->db->order_by('sort', 'asc');
		$this->db->limit($limit,$page);
		$query = $this->db->get('sys_menus');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_memus_dao($page,$limit,$mtype)
	{
		$this->db->select('*');
		$this->db->where('mtype',$mtype);
		$this->db->where('pid', 0);
		$this->db->order_by('sort', 'asc');
		$this->db->limit($limit,$page);
		$query = $this->db->get('sys_menus');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_memus_by_pid($pid,$limit,$mtype=0)
	{
		$this->db->select('*');
		if($mtype<>0){
			if($mtype<10){
				$this->db->where('mtype <',10);
			}elseif($mtype>10){
				$this->db->where('mtype >',10);
			}elseif($mtype==10){
				$this->db->where('mtype',$mtype);
			}		
		}
		$this->db->where('pid', $pid);
		$this->db->order_by('sort', 'asc');
		$this->db->limit($limit);
		$query = $this->db->get('sys_menus');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_memus_by_pid_dao($pid,$limit,$mtype)
	{
		$this->db->select('*');
		$this->db->where('mtype',$mtype);
		$this->db->where('pid', $pid);
		$this->db->order_by('sort', 'asc');
		$this->db->limit($limit);
		$query = $this->db->get('sys_menus');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function add_memu($data)
    {
    	$this->db->insert('sys_menus',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_memu($id, $data){
		$this->db->where('id',$id);
  		$this->db->update('sys_menus', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_memu($id)
	{
		$this->db->where('id', $id)->delete('sys_menus');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
