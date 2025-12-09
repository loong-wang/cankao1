<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Work_m
#	scope:		PUBLIC

class Work_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_work_fen($userid)
	{
		$this->db->select("id");
		$this->db->from('do_work');
		$this->db->where('do_userid',$userid);
		$this->db->where('do_type',2);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_work_dan_list_by_id($id,$type)
	{
		$query = $this->db->get_where('do_work',array('do_id'=>$id,'do_type'=>$type));
		if($query->num_rows>0){
			return $query->result_array();
		} else{
			return false;
		}
	}
	
	public function get_work_username_by_userid($userid)
	{
		$query = $this->db->get_where('users',array('userid'=>$userid));
		if($query->num_rows>0){
			$u=$query->row_array();
			return $u['username'];
		} else{
			return '-----';
		}
	}
	
	public function get_all_work_fen_list($page, $limit,$userid)
	{
		$this->db->select('*');
		$this->db->from('do_work');
		$this->db->where('do_userid',$userid);
		$this->db->where('do_type',2);
		$this->db->order_by('do_date','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function add_work($data)
    {
    	$this->db->insert('do_work',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_work($id, $data){
		$this->db->where('id',$id)->update('do_work', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_work($id)
	{
		$this->db->where('id', $id)->delete('do_work');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
