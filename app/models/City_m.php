<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX-HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	City_m
#	scope:		PUBLIC

class City_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	
	public function count_city_moren($moren)
	{
		$this->db->select("cid");
		$this->db->from('citys');
		$this->db->where('cmoren',$moren);
		$this->db->where('pingcid',0);
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function count_city_moren_ping($moren,$ping=0)
	{
		$this->db->select("cid");
		$this->db->from('citys');
		$this->db->where('cmoren',$moren);
		if($ping==0){
			$this->db->where('pingcid',0);
		}else{
			$this->db->where('pingcid >',0);
		}		
		$total=$this->db->count_all_results();
		return $total;
	}

	public function get_city_moren($cmoren)
	{
		$query = $this->db->where('pingcid',0)->where('cmoren',$cmoren)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->row_array();
		} else	{
			return false;
		}
	}
	
	public function get_city_no_cid($cid)
	{
		$query = $this->db->where('cid !=',$cid)->where('pingcid',0)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			$list = $query->result_array();
			if($list){
				$a=array();
				$b=array();
				$c=array();
				$d=array();
				$this->load->config('cityset');
				foreach(explode("|",$this->config->item('shengji')) as $v){
					foreach($list as $k => $s){
						if(in_array($v, $s)){
							$a['citys'][$k]['sheng']= $v;
							$a['citys'][$k]['shi']= $s['cname'];
							$a['citys'][$k]['cid']= $s['cid'];
						}
					}
				}
				foreach($a['citys'] as $k=>$v) {
					$b[$v["sheng"]][] = $v;
				}
				return $b;
			}
		}
	}
	
	public function get_city_all_list()
	{
		$query = $this->db->where('pingcid',0)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->result_array();
		} else	{
			return false;
		}
	}
	
	public function get_city_all_list_ping()
	{
		$query = $this->db->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->result_array();
		} else	{
			return false;
		}
	}
	
	public function get_cnums_by_ucity($cid)
	{
		$query = $this->db->select('cnums')->where('cid', $cid)->order_by('cid', 'asc')->get('citys')->row_array();
		if($query){
			return $query['cnums'];
		}else{
			return $this->config->item('webnums');
		}
	}
	
	public function get_cname_by_ucity($cid)
	{
		$query = $this->db->select("cname,pingcid")->where('cid',$cid)->get('citys');
		if($query->num_rows>0){
			$cname = $query->row_array();
			if($cname['pingcid']==0){
				$cityname=$cname['cname'];
				return '<span class="badge badge-purple">'.$cityname.'</span>';
			}else{				 
				$cityname=$this->get_cname_by_ucity($cname['pingcid']);
				return $cityname;
			}			
		} else	{
			return '<span class="badge badge-success">全站</span>';
		}
	}
	
	public function get_cname_by_ucity_ping_cname($cid)
	{
		$query = $this->db->select("pingcid")->where('cid',$cid)->get('citys');
		if($query->num_rows>0){
			$c = $query->row_array();
			$querys = $this->db->select("cname")->where('cid',$c['pingcid'])->get('citys');
			$cname = $querys->row_array();
			return $cname['cname'];
		}
	}
	
	public function get_cname_by_dan_city_cname($cid)
	{
		$querys = $this->db->select("cname")->where('cid',$cid)->get('citys');
		$cname = $querys->row_array();
		return $cname['cname'];
	}
	
	public function get_cname_by_ucity_ping($cid)
	{
		$query = $this->db->select("cname")->where('cid',$cid)->get('citys');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return '<span class="badge badge-purple">'.$cname['cname'].'</span>';
		} else	{
			return '<span class="badge badge-success">独立</span>';
		}
	}
	
	public function get_cname_by_ucity_luo($cid)
	{
		$query = $this->db->select("cname")->where('cid',$cid)->get('citys');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return ''.$cname['cname'].'';
		} else	{
			return '全站';
		}
	}
	
	public function get_city_by_cdomain_web($cdomain)
	{
		$query = $this->db->where('cdomain',$cdomain)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->row_array();
		} else	{
			return false;
		}
	}
	
	public function get_city_by_cid_web($cid)
	{
		$query = $this->db->where('cid',$cid)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->row_array();
		} else	{
			return false;
		}
	}
	
	public function get_citygou_list($cid,$sid,$limit)
	{
		$this->db->select('cid,cname');			
		$this->db->where('cid !=', $cid);
		$this->db->where('sid', $sid);
		$this->db->where('pingcid', 0);
		$this->db->order_by('cord', 'asc');
		$this->db->limit($limit);
		$query = $this->db->get('citys');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_city_by_cid($cid)
	{
		$query = $this->db->where('cid',$cid)->where('cmoren',0)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->row_array();
		} else	{
			return false;
		}
	}
	
	public function get_all_city_moren($page,$limit,$moren)
	{
		$this->db->select('*');			
		$this->db->where('cmoren', $moren);
		$this->db->order_by('cord', 'asc');
		$this->db->order_by('sid', 'asc');
		$this->db->order_by('cid', 'asc');
		$this->db->limit($limit,$page);
		$query = $this->db->get('citys');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_city_moren_ping($page,$limit,$moren,$ping=0)
	{
		$this->db->select('*');			
		$this->db->where('cmoren', $moren);
		if($ping==0){
			$this->db->where('pingcid',0);
		}else{
			$this->db->where('pingcid >',0);
		}
		$this->db->order_by('cord', 'asc');
		$this->db->order_by('sid', 'asc');
		$this->db->order_by('cid', 'asc');
		$this->db->limit($limit,$page);
		$query = $this->db->get('citys');
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function city_name_check($str)
	{
		$query = $this->db->where('cname',$str)->order_by('cid')->get('citys');
		if($query->num_rows>0){
			return $query->row_array();
		} else	{
			return false;
		}
	}
	
	public function add_city($data)
    {
    	$this->db->insert('citys',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_city($cid, $data){
		$this->db->where('cid',$cid);
  		$this->db->update('citys', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function update_city_moren($moren, $data){
		$this->db->where('cmoren',$moren);
  		$this->db->update('citys', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_city($cid)
	{
		$this->db->where('cid', $cid)->where('cmoren',0)->delete('citys');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

}
