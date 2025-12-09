<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Tongji_m
#	scope:		PUBLIC

class Tongji_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	public function count_user_shu($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('users');
		$this->db->where('ugroup >',10);
		if($ucity>0){
			$this->db->where('ucity',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_dingdan_shu($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('dingdan_list');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$this->db->where('dan_hao_lock_wancheng',1);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_all_users_list($page, $limit,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('ugroup >',10);
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
	public function get_all_dingdan_list($page, $limit,$ucity=0)
	{
		$this->db->select('a.*,b.*');
		$this->db->from('dingdan_list a');
		$this->db->join('haoma b','b.id = a.dan_haoid','left');
		if($ucity>0){
			$this->db->where('a.dan_city',$ucity);
		}
		$this->db->where('a.dan_hao_lock_wancheng',1);
		$this->db->order_by('a.dan_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function count_work_type($type,$lei,$userid)
	{
		$this->db->select("id");
		$this->db->from('do_work');
		$this->db->where('do_userid',$userid);
		$this->db->where('do_type',$type);
		$this->db->where('do_lei',$lei);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
}