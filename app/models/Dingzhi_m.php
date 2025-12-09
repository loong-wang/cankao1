<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Dingzhi_m
#	scope:		PUBLIC

class Dingzhi_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	public function count_dingzhi($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('dingzhi');
		if($ucity>0){
			$this->db->where('dz_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_dingzhi_by_id($id)
	{
		$query = $this->db->get_where('dingzhi',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_dingzhi_list($page, $limit,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('dingzhi');
		if($ucity>0){
			$this->db->where('dz_city',$ucity);
		}
		$this->db->order_by('dz_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function add_dingzhi($data)
    {
    	$this->db->insert('dingzhi',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_dingzhi($id, $data){
		$this->db->where('id',$id)->update('dingzhi', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_dingzhi($id)
	{
		$this->db->where('id', $id)->delete('dingzhi');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_all($city=0)
	{
		$s=time()-60*60*24*30;
		if($city=0){
			$this->db->where('dz_time <',$s)->delete('dingzhi');
		}else{
			$this->db->where('dz_time <',$s)->where('dz_city',$city)->delete('dingzhi');
		}
		
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
}