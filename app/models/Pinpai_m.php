<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Pinpai_m
#	scope:		PUBLIC

class Pinpai_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_pinpai($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('pinpai');
		if($ug<10000){
			$this->db->where('pin_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pin_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_pinpai_by_id($id)
	{
		$query = $this->db->get_where('pinpai',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_pinpai_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('pinpai');
		if($ug<10000){
			$this->db->where('pin_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pin_city',$ucity);
		}
		$this->db->order_by('pin_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_pinpai_list($ucity=0,$ug=0,$tcs='')
	{
		$this->db->select('*');
		$this->db->from('pinpai');
		if($ug<10000){
			$this->db->where('pin_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pin_city',$ucity);
		}
		if(!empty($tcs)){
			if(strpos($tcs, '_')){
				foreach(explode('_',$tcs) as $v){
					$this->db->like('pin_tezheng',$v);
				}
			}else{
				$this->db->like('pin_tezheng',$tcs);
			}
		}
		$this->db->order_by('pin_time','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function add_pinpai($data)
    {
    	$this->db->insert('pinpai',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_pinpai($id, $data){
		$this->db->where('id',$id)->update('pinpai', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_pinpai($id)
	{
		$this->db->where('id', $id)->delete('pinpai');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
