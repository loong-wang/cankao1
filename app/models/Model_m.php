<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX-HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Model_m
#	scope:		PUBLIC

class Model_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function get_all_model_list($page,$limit)
	{
		$this->db->select('*');			
		$this->db->order_by('update_time', 'desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get('model');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function get_model_info_by_id($id)
	{
		$query = $this->db->get_where('model',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_field_info_by_id($id)
	{
		$query = $this->db->get_where('model_field',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_all_field_list($model_id){
		$query = $this->db->order_by('ords')->get_where('model_field',array('model_id'=>$model_id));
		if($query->num_rows>0){
			return $query->result_array();
		} else{
			return false;
		}
	}
	public function model_check_by_url($table_name)
	{
		$query = $this->db->where('table_name',$table_name)->order_by('id')->get('model');
		if($query->num_rows>0){
			return true;
		} else	{
			return false;
		}
	}
	public function check_by_field_name($name,$id)
	{
		$query = $this->db->where('name',$name)->where('model_id',$id)->order_by('id')->get('model_field');
		if($query->num_rows>0){
			return true;
		} else	{
			return false;
		}
	}
	public function add_model($data)
    {
		$this->load->dbforge();
		$this->dbforge->add_field('id');
		$this->dbforge->create_table($data['table_name']);
    	$this->db->insert('model',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function add_field($data)
    {
		$this->load->dbforge();
		if(in_array('INT',explode("|",$data['field'])) || in_array('TINYINT',explode("|",$data['field'])) || in_array('VARCHAR',explode("|",$data['field']))){
			$t=explode("|",$data['field']);
			$fields = array(''.$data['name'].'' =>  array('type' => $t[0], 'constraint' => $t[1], 'unsigned' => $t[2], 'default' => $t[3]));
		}else{
			$t=explode("|",$data['field']);
			$fields = array(''.$data['name'].'' =>  array('type' => $t[0]));
		}
		if($data['keys']=='1'){
			$this->dbforge->add_column($data['model'], $fields);
			$this->dbforge->add_key(''.$data['name'].'', TRUE);
		}else{
			$this->dbforge->add_column($data['model'], $fields);
		}
    	$this->db->insert('model_field',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_model($id, $data){
		$tx = $this->db->get_where('model',array('id'=>$id))->row_array();
		if($tx['table_name']!=$data['table_name']){
			$this->db->set('model',$data['table_name'])->where('model_id',$id)->update('model_field'); 
			$this->load->dbforge();
			$this->dbforge->rename_table($tx['table_name'], $data['table_name']);			
		}
		$this->db->where('id',$id)->update('model', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_field($id, $data){		
		$this->load->dbforge();	
		$tx = $this->db->get_where('model_field',array('id'=>$id))->row_array();
		if(isset($data['name'])&&!empty($data['name'])){
			$data_name=$data['name'];
			$data_names=$tx['name'];
		}else{
			$data_name=$tx['name'];
			$data_names=$tx['name'];
		}		
		if(in_array('INT',explode("|",$data['field'])) || in_array('TINYINT',explode("|",$data['field'])) || in_array('VARCHAR',explode("|",$data['field']))){
			$t=explode("|",$data['field']);
			if(isset($data['name'])&&!empty($data['name'])){
				$fields = array(''.$data_names.'' =>  array( 'name'=>''.$data['name'].'', 'type' => $t[0], 'constraint' => $t[1], 'unsigned' => $t[2], 'default' => $t[3]));
			}else{
				$fields = array(''.$data_name.'' =>  array('type' => $t[0], 'constraint' => $t[1], 'unsigned' => $t[2], 'default' => $t[3]));
			}			
		}else{
			$t=explode("|",$data['field']);
			if(isset($data['name'])&&!empty($data['name'])){
				$fields = array(''.$data_names.'' =>  array( 'name'=>''.$data['name'].'', 'type' => $t[0]));
			}else{
				$fields = array(''.$data_name.'' =>  array('type' => $t[0]));
			}			
		}
		//print_r($fields);exit;
		$this->dbforge->modify_column($data['model'], $fields);
		
		$this->db->where('id',$id);
  		$this->db->update('model_field', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_model($id)
	{
		$model = $this->db->select('table_name')->where('id',$id)->get('model')->row_array();
		$this->load->dbforge();
		$this->dbforge->drop_table($model['table_name']);
		$this->db->where('id', $id)->delete('model');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_field($id)
	{
		$tx = $this->db->get_where('model_field',array('id'=>$id))->row_array();
		$this->load->dbforge();
		$this->dbforge->drop_column($tx['model'], $tx['name']);
		$this->db->where('id', $id)->delete('model_field');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
