<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Zifei_m
#	scope:		PUBLIC

class Zifei_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_zifei($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('zifei');
		if($ug<10000){
			$this->db->where('zf_type',$ug);
		}
		if($ucity>0){
			$this->db->where('zf_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
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
	
	public function get_zifei_by_id($id)
	{
		$query = $this->db->get_where('zifei',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
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
	
	public function get_all_pinpai_by_city($city)
	{
		$query = $this->db->get_where('pinpai',array('pin_city'=>$city));
		if($query->num_rows>0){
			return $query->result_array();
		} else{
			return false;
		}
	}
	
	public function get_all_pinpai_by_city_type($city,$type)
	{	
		
		$query = $this->db->get_where('pinpai',array('pin_city'=>$city,'pin_type'=>$type));
		if($query->num_rows>0){
			return $query->result_array();
		} else{
			return false;
		}
	}
	
	public function get_pname_by_pid($id)
	{
		$query = $this->db->select("pin_title")->where('pin_num',$id)->get('pinpai');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return '<span class="badge badge-yellow">'.$cname['pin_title'].'</span>';
		} else	{
			return '---';
		}
	}
	
	public function get_all_zifei_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('zifei');
		if($ug<10000){
			$this->db->where('zf_type',$ug);
		}
		if($ucity>0){
			$this->db->where('zf_city',$ucity);
		}
		$this->db->order_by('zf_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
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
	
	public function search_zifei($q)
	{
		$query = $this->db->like('zf_title',$q)->get('zifei');
		return $query->result_array();
	}
	
	public function search_taocan($q)
	{
		$query = $this->db->like('tc_title',$q)->get('taocan');
		return $query->result_array();
	}

	public function add_zifei($data)
    {
    	$this->db->insert('zifei',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function add_taocan($data)
    {
    	$this->db->insert('taocan',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_zifei($id, $data){
		$this->db->where('id',$id)->update('zifei', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_taocan($id, $data){
		$this->db->where('id',$id)->update('taocan', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_zifei($id)
	{
		$this->db->where('id', $id)->delete('zifei');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_taocan($id)
	{
		$this->db->where('id', $id)->delete('taocan');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
