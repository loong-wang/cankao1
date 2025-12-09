<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Xinxi_m
#	scope:		PUBLIC

class Xinxi_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_xinxi($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('xinxi');
		if($ug<10000){
			$this->db->where('x_type',$ug);
		}
		if($ucity>0){
			$this->db->where('x_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_xinxis($ug=10000)
	{
		$this->db->select("id");
		$this->db->from('xinxi');
		if($ug<10000){
			$this->db->where('x_type',$ug);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_user_xinxi($uid)
	{
		$this->db->select("id");
		$this->db->from('xinxi');
		$this->db->where('x_userid',$uid);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_xinxi_by_id($id)
	{
		$query = $this->db->get_where('xinxi',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_xinxi_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('xinxi');
		if($ug<10000){
			$this->db->where('x_type',$ug);
		}
		if($ucity>0){
			$this->db->where('x_city',$ucity);
		}
		$this->db->order_by('x_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_xinxi_lists($page, $limit,$ug=0)
	{
		$this->db->select('*');
		$this->db->from('xinxi');
		if($ug<10000){
			$this->db->where('x_type',$ug);
		}
		$this->db->order_by('x_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_remen_xinxi_lists($limit,$ug=0)
	{
		$this->db->select('*');
		$this->db->from('xinxi');
		if($ug<10000){
			$this->db->where('x_type',$ug);
		}
		//$this->db->order_by('x_time','desc');
		//$this->db->order_by('x_title','RANDOM');
		$this->db->order_by($limit, 'RANDOM');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_user_xinxi_list($page, $limit,$uid)
	{
		$this->db->select('*');
		$this->db->from('xinxi');
		$this->db->where('x_userid',$uid);
		$this->db->order_by('x_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function search_xinxi($q)
	{
		$query = $this->db->like('x_title',$q)->get('xinxi');
		return $query->result_array();
	}
	

	public function add_xinxi($data)
    {
    	$this->db->insert('xinxi',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_xinxi($id, $data){
		$this->db->where('id',$id)->update('xinxi', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_xinxi($id)
	{
		$this->db->where('id', $id)->delete('xinxi');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_all($city=0)
	{
		$s=time()-60*60*24*30;
		if($city=0){
			$this->db->where('x_time <',$s)->delete('xinxi');
		}else{
			$this->db->where('x_time <',$s)->where('x_city',$city)->delete('xinxi');
		}
		
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
