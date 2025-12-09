<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	News_m
#	scope:		PUBLIC

class News_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_news($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('news');
		if($ug<10000){
			$this->db->where('news_type',$ug);
		}
		if($ucity>0){
			$this->db->where('news_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_newss($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('news');
		if($ug<10000){
			$this->db->where('news_type',$ug);
		}
		if($ucity>0){
			$ucitys = array($ucity, '0');
			$this->db->where_in('news_city',$ucitys);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_news_by_id($id)
	{
		$query = $this->db->get_where('news',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_news_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('news');
		if($ug<10000){
			$this->db->where('news_type',$ug);
		}
		if($ucity>0){
			$this->db->where('news_city',$ucity);
		}
		$this->db->order_by('news_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_news_lists($page, $limit,$ug=10000,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('news');
		if($ug<10000){
			$this->db->where('news_type',$ug);
		}
		if($ucity>0){
			$ucitys = array($ucity, '0');
			$this->db->where_in('news_city',$ucitys);
		}
		$this->db->order_by('news_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function search_news($q)
	{
		$query = $this->db->like('news_title',$q)->get('news');
		return $query->result_array();
	}
	

	public function add_news($data)
    {
    	$this->db->insert('news',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_news($id, $data){
		$this->db->where('id',$id)->update('news', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_news($id)
	{
		$this->db->where('id', $id)->delete('news');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
