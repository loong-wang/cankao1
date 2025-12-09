<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Page_m
#	scope:		PUBLIC

class Page_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	public function count_gouwuche_num($foxid,$cityid)
	{
		$this->db->select('id');
		$this->db->from('ches');
		$this->db->where('che_hao',$foxid);
		$this->db->where('che_city',$cityid);
		$total=$this->db->count_all_results();
		return $total;
	}
	public function get_show_question_list($ucity=0,$limit)
	{
		$this->db->select('*');
		$this->db->from('question');
		if($ucity>0){
			$this->db->where('q_city',$ucity);
		}
		$this->db->where('q_recontent is not null');
		$this->db->order_by('q_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function count_page($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('pages');
		if($ug<10000){
			$this->db->where('pages_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pages_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_page_by_id($id)
	{
		$query = $this->db->get_where('pages',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_page_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('pages');
		if($ug<10000){
			$this->db->where('pages_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pages_city',$ucity);
		}
		$this->db->order_by('pages_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_type_page_list($ucity=0,$ug=0,$limit)
	{
		$this->db->select('*');
		$this->db->from('pages');
		if($ug<10000){
			$this->db->where('pages_type',$ug);
		}
		if($ucity>0){
			$this->db->where('pages_city',$ucity);
		}
		$this->db->order_by('pages_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_page_list_by_city($ucity=0,$ug=0,$limit)
	{
		$this->db->select('*');
		$this->db->from('pages');
		if($ug<10000){
			$this->db->where('pages_type',$ug);
		}
		if($ucity>0){
			$ucitys=array($ucity,'0');
			$this->db->where_in('pages_city',$ucitys);
		}
		$this->db->order_by('pages_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function add_page($data)
    {
    	$this->db->insert('pages',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_page($id, $data){
		$this->db->where('id',$id)->update('pages', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_page($id)
	{
		$this->db->where('id', $id)->delete('pages');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}


}
