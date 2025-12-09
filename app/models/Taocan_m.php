<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Taocan_m
#	scope:		PUBLIC

class Taocan_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_taocan($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('taocan');
		if($ug<10000){
			$this->db->where('tc_type',$ug);
		}
		if($ucity>0){
			$this->db->where('tc_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_taocan_by_id($id)
	{
		$query = $this->db->get_where('taocan',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_taocan_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('taocan');
		if($ug<10000){
			$this->db->where('tc_type',$ug);
		}
		if($ucity>0){
			$this->db->where('tc_city',$ucity);
		}
		$this->db->order_by('tc_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
}