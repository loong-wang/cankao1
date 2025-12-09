<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Cart_m
#	scope:		PUBLIC

class Cart_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
	}
	public function count_che($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('ches');
		if($ucity>0){
			$this->db->where('che_city',$ucity);
		}
		$this->db->where('che_hao',$this->fox_scheid);
		if($this->session->userdata('userid')){
			$this->db->or_where('che_userid',$this->session->userdata('userid'));			
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_shoucang($userid)
	{
		$this->db->select("id");
		$this->db->from('shoucangs');
		$this->db->where('userid',$userid);			
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_dingdan($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$this->db->where('che_hao',$this->fox_scheid);
		if($this->session->userdata('userid')){
			$this->db->or_where('dan_userid',$this->session->userdata('userid'));			
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_dingdans($ucity=0)
	{
		$this->db->select("id");
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_dingdan_list_by_userid($userid)
	{
		$query = $this->db->get_where('users',array('userid'=>$userid));
		if($query->num_rows>0){
			$u=$query->row_array();
			return $u['username'];
		} else{
			return '游客';
		}
	}
	
	public function get_che_by_id($id)
	{
		$query = $this->db->get_where('ches',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_che_by_haoid_scheid($haoid,$fox_scheid)
	{
		$time=time()-60*60*24*7;
		$this->db->where('che_time <=', $time)->delete('ches');
		$query = $this->db->get_where('ches',array('che_haoid'=>$haoid,'che_hao'=>$fox_scheid));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_che_by_haoid($haoid)
	{
		$time=time()-60*60*24*7;
		$this->db->where('che_time <=', $time)->delete('ches');
		$query = $this->db->get_where('ches',array('che_haoid'=>$haoid));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_shoucang_by_haoid($haoid)
	{
		$query = $this->db->get_where('shoucangs',array('shoucangid'=>$haoid));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_shoucang_by_id($id)
	{
		$query = $this->db->get_where('shoucangs',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_dingdan_by_danhao($danhao)
	{
		$query = $this->db->get_where('dingdan',array('dan_hao'=>$danhao));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	public function get_dingdan_list_by_id($id)
	{
		$query = $this->db->get_where('dingdan_list',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_dingdan_list_by_danhao($danhao)
	{
		$this->db->select('a.*,b.*,c.*,a.id as dingdan_list_id');
		$this->db->from('dingdan_list a');
		$this->db->join('haoma b','b.id = a.dan_haoid','left');
		$this->db->join('users c','c.username = b.hao_user','left');
		$this->db->where('a.dan_hao',$danhao);
		$this->db->order_by('a.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_zhekou_by_ugroup($ugroup)
	{
		$query = $this->db->get_where('user_groups',array('group_type'=>$ugroup));
		if($query->num_rows>0){
			$user_groups = $query->row_array();
			return $user_groups['zhekou']/10;
		} else{
			return '10';
		}
	}
	
	public function get_zhekou_by_userid($userid)
	{
		$this->db->select('a.ugroup,b.zhekou');
		$this->db->from('users a');
		$this->db->join('user_groups b','b.group_type = a.ugroup','left');
		$this->db->where('a.userid',$userid);
		$query = $this->db->get();
		if($query->num_rows>0){
			$user_groups = $query->row_array();
			return $user_groups['zhekou']/10;
		} else{
			return '10';
		}
	}
	
	public function get_all_che_list($page, $limit,$ucity=0)
	{
		$this->db->select('a.*,b.*,a.id as che_id');
		$this->db->from('ches a');
		$this->db->join('haoma b','b.id = a.che_haoid','left');
		if($ucity>0){
			$this->db->where('a.che_city',$ucity);
		}
		$this->db->where('a.che_hao',$this->fox_scheid);
		if($this->session->userdata('userid')){
			$this->db->or_where('che_userid',$this->session->userdata('userid'));			
		}
		$this->db->order_by('a.che_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$list= $query->result_array();
			foreach($list as $k => $v){
			if(!$v['hao_title'])
				unset($list[$k]);
			}
			return $list;
		}
	}
	public function get_all_shoucang_list($page, $limit,$userid)
	{
		$this->db->select('a.*,b.*,a.id as sc_id');
		$this->db->from('shoucangs a');
		$this->db->join('haoma b','b.id = a.shoucangid','left');
		$this->db->where('a.userid',$userid);			
		$this->db->order_by('a.id','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_dingdan_list($page, $limit,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$this->db->where('che_hao',$this->fox_scheid);
		if($this->session->userdata('userid')){
			$this->db->or_where('dan_userid',$this->session->userdata('userid'));			
		}
		$this->db->order_by('dan_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_dingdan_lists($page, $limit,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('dingdan');
		if($ucity>0){
			$this->db->where('dan_city',$ucity);
		}
		$this->db->order_by('dan_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function dels_dingdan_list_by_danhao($dan_hao)
	{
		$this->db->where('dan_hao', $dan_hao)->delete('dingdan');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	//获取最大订单号
	public function get_order_maxonum()
	{
		mt_srand((double) microtime() * 1000000); 
		$query = $this->db->select_max('dan_hao')->get('dingdan');
		if($query->num_rows>0){
			$danhao = $query->row_array();
			if(isset($danhao['dan_hao'])){
				return $danhao['dan_hao']+mt_rand(10000, 99999);
			}else{
				return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			}
		}else{
			return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
		}
	}
	
	public function add_che($data)
    {
    	$this->db->insert('ches',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	public function add_shoucang($data)
    {
    	$this->db->insert('shoucangs',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	public function add_dingdan($data)
    {
    	$this->db->insert('dingdan',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function update_gouwuche_foxid_userid($foxid,$userid)
	{
		$this->db->where('che_hao', $foxid)->update('ches', array('che_userid'=>$userid));
		$this->db->where('che_hao', $foxid)->update('dingdan', array('dan_userid'=>$userid));
		$this->db->where('che_hao', $foxid)->update('dingdan_list', array('dan_userid'=>$userid));
	}
	
	public function get_dingdan_list_lock_wancheng($haoids)
	{
		$lock=0;
		foreach(explode('|',$haoids) as $k => $v){
			$d[$k] = $this->db->get_where('dingdan_list',array('dan_haoid'=>$v))->row_array();
			$lock += $d[$k]['dan_hao_lock_wancheng'];
		}
		return $lock;
	}
	
	public function get_dan_hao_lock($lock)
	{
		foreach(explode("|",$this->config->item('dingdan_lock')) as $k => $s){
			if($lock==$k){
				return $s;
			}
		}
	}
	
	public function get_city_shouji_by_cityid($cid){
		$query = $this->db->get_where('citys',array('cid'=>$cid));
		if($query->num_rows>0){
			$u=$query->row_array();
			return $u['cz_shouji_me'];
		}
	}
	
	public function get_dingdan_shouji_by_danhao($danhao)
	{
		$query = $this->db->get_where('dingdan',array('dan_hao'=>$danhao));
		if($query->num_rows>0){
			$u=$query->row_array();
			return $u['dan_tel'];
		}
	}
	
	public function lock_haoma_haoid($haoid,$danhao,$haoids,$userid,$cityid,$foxid){
		$query = $this->db->get_where('haoma',array('id'=>$haoid));
		if($query->num_rows>0){
			$haoma = $query->row_array();
			if($haoma['hao_lock']==0){
				$this->db->where('id',$haoid)->update('haoma', array('hao_lock'=>1));
				$haoma['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($haoma['hao_city']),$this->haoma_m->get_unums_user($haoma['hao_user']))*$haoma['hao_jiage']);			
				$str=array(
					'che_hao' => $foxid,
					'dan_hao' => $danhao,
					'dan_userid' => $userid,
					'dan_city' => $cityid,
					'dan_haoid' => $haoid,
					'dan_hao_chengben' => $haoma['hao_jiage'],
					'dan_hao_shoujia' => $haoma['hao_shoujia'],
					'dan_hao_shoujias' => $haoma['hao_shoujia']+$haoma['hao_huafei'],
					'dan_time' => time(),
				);				
				$this->db->insert('dingdan_list',$str);			
				$this->load->config('smsset');
				$shouji=$this->get_dingdan_shouji_by_danhao($danhao);
				if(checkMobile($shouji) && $this->config->item('sms_type')=='on'){  
					if($this->config->item('shouji_order')=='on'){
						$shoujbody = str_replace('【变量】','【'.$haoma['hao_title'].'】',$this->config->item('sms_moban_order'));
						SendShouji($this->config->item('sms_user'),$this->config->item('sms_key'),$shouji,$shoujbody,date('Y-m-d H:i:s',time()));		
					}
				}
				//echo $shouji; echo $this->config->item('sms_type');print_r($haoma);echo $shoujbody;exit();
				$shoujis=$this->get_city_shouji_by_cityid($cityid);
				if(isset($shoujis) && checkMobile($shoujis) && $this->config->item('sms_type')=='on'){  
					if($this->config->item('shouji_order_me')=='on'){
						$shoujbody = str_replace('【变量】','【'.$haoma['hao_title'].'】',$this->config->item('sms_moban_order_me'));
						SendShouji($this->config->item('sms_user'),$this->config->item('sms_key'),$shoujis,$shoujbody,date('Y-m-d H:i:s',time()));		
					}
				}
				//echo $shoujis; echo $this->config->item('sms_type');print_r($haoma);echo $shoujbody;exit();
			}else{
				$haoida=$haoid.'|';
				$haoidst=str_replace(''.$haoida.'','',$haoids);
				$this->db->where('dan_hao', $danhao)->update('dingdan', array('dan_haoid'=>$haoidst));
			}
			
		}
	}	
	function add_dingdan_list_haoid($danhao,$id,$userid,$cityid,$foxid)
	{
		$query = $this->db->get_where('haoma',array('id'=>$id));
		$haoma = $query->row_array();
		$haoma['hao_shoujia']=ceil(fox_num_two($this->haoma_m->get_cnums_city($haoma['hao_city']),$this->haoma_m->get_unums_user($haoma['hao_user']))*$haoma['hao_jiage']);			
		$this->db->where('id',$id)->update('haoma', array('hao_lock'=>1));
		$str=array(
			'che_hao' => $foxid,
			'dan_hao' => $danhao,
			'dan_userid' => $userid,
			'dan_city' => $cityid,
			'dan_haoid' => $id,
			'dan_hao_chengben' => $haoma['hao_jiage'],
			'dan_hao_shoujia' => $haoma['hao_shoujia'],
			'dan_hao_shoujias' => $haoma['hao_shoujia']+$haoma['hao_huafei'],
			'dan_time' => time(),
		);
		$this->db->insert('dingdan_list',$str);
	}
	function del_che($id)
	{
		if($this->session->userdata('userid')){
			$this->db->where('id', $id)->where('che_userid',$this->session->userdata('userid'))->delete('ches');;			
		}else{
			$this->db->where('id', $id)->where('che_hao',$this->fox_scheid)->delete('ches');		
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_che_haoid($haoid)
	{
		$this->db->where('che_haoid', $haoid)->delete('ches');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_shoucang($id)
	{
		$this->db->where('id', $id)->delete('shoucangs');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_all()
	{
		if($this->session->userdata('userid')){
			$this->db->where('che_userid',$this->session->userdata('userid'))->delete('ches');;			
		}else{
			$this->db->where('che_hao',$this->fox_scheid)->delete('ches');
		}				
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function del_all_scheid($fox_scheid)
	{
		$this->db->where('che_hao',$fox_scheid)->delete('ches');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	function update_dingdan_list($id, $data){
		$this->db->where('id',$id)->update('dingdan_list', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function searcha($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->like('a.dan_hao',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	public function searchb($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->like('b.dan_name',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	public function searchc($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->like('b.dan_tel',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	
	public function searchd($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->where('c.hao_title',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	
	public function searche($q)
	{
		$this->db->select('a.*,b.*,c.*,d.username');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->join('users d','d.userid = a.dan_userid','left');
		$this->db->where('d.username',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	public function searchf($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->where('c.hao_user',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	
	public function searchg($q)
	{
		$this->db->select('a.*,b.*,c.*');
		$this->db->from('dingdan_list a');
		$this->db->join('dingdan b','b.dan_hao = a.dan_hao','left');
		$this->db->join('haoma c','c.id = a.dan_haoid','left');
		$this->db->like('a.dan_hao_fahuo_danhao',$q);
		$query=$this->db->get();
		return assoc_unique($query->result_array(),'dan_hao');
	}
	
}