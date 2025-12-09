<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Ads_m
#	scope:		PUBLIC

class Ads_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_ads($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('ads');
		if($ucity>0){
			$this->db->where('ads_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_ads_by_id($id)
	{
		$query = $this->db->get_where('ads',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_city_ads_list($ucity=0,$limit)
	{
		$this->db->select('*');
		$this->db->from('ads');
		if($ucity>0){
			$this->db->where('ads_city',$ucity);
		}
		$this->db->order_by('ads_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_ads_list($page, $limit,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('ads');
		if($ucity>0){
			$this->db->where('ads_city',$ucity);
		}
		$this->db->order_by('ads_city','asc');
		$this->db->order_by('ads_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function add_ads($data)
    {
    	$this->db->insert('ads',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_ads($id, $data){
		$this->db->where('id',$id)->update('ads', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_ads($id)
	{
		$this->db->where('id', $id)->delete('ads');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
