<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Question_m
#	scope:		PUBLIC

class Question_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_question($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('question');
		if($ug<10000){
			$this->db->where('q_type',$ug);
		}
		if($ucity>0){
			$this->db->where('q_city',$ucity);
		}
		$this->db->where('q_recontent is not null');
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_question_city($ucity,$q_type,$num=0)
	{
		$this->db->select("id");
		$this->db->from('question');
		if($q_type<10000){
			$this->db->where('q_type',$q_type);
		}
		if($ucity>0){
			$this->db->where('q_city',$ucity);
		}
		if($num>0){
			$this->db->where('q_reuserid >',0);
		}
		$this->db->where('q_recontent is not null');
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function count_user_question($uid)
	{
		$this->db->select("id");
		$this->db->from('question');
		$this->db->where('q_userid',$uid);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_question_by_id($id)
	{
		//$query = $this->db->get_where('question',array('id'=>$id));
		//$query = $this->db->get_where('question',array('id'=>$id));
		$this->db->select("*");
		$this->db->from('question');
		$this->db->where('id',$id);
		$this->db->where('q_recontent is not null');
		$query=$this->db->get();
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_question_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('question');
		if($ug<10000){
			$this->db->where('q_type',$ug);
		}
		if($ucity>0){
			$this->db->where('q_city',$ucity);
		}
		$this->db->where('q_recontent is not null');
		$this->db->order_by('q_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_question_lists($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('question');
		if($ug<10000){
			$this->db->where('q_type',$ug);
		}
		if($ucity==0){
			$this->db->where('q_city',$ucity);
		}
		$this->db->order_by('q_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function get_user_question_list($page, $limit,$uid)
	{
		$this->db->select('*');
		$this->db->from('question');
		$this->db->where('q_userid',$uid);
		$this->db->order_by('q_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function search_question($q)
	{
		$query = $this->db->like('q_title',$q)->get('question');
		return $query->result_array();
	}
	

	public function add_question($data)
    {
    	$this->db->insert('question',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_question($id, $data){
		$this->db->where('id',$id)->update('question', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_question($id)
	{
		$this->db->where('id', $id)->delete('question');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
