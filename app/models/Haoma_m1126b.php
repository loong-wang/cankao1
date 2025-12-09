<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
#	FOX_HMCMS
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Haoma_m
#	scope:		PUBLIC

class Haoma_m extends FOX_Model
{

	function __construct ()
	{
		parent::__construct();
		$this->config->load('webset');
	}
	
	public function count_user_haoma($user,$lock=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_user',$user);
		$this->db->where('hao_lock >=',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	//搜索
	public function count_list_haoma_likea($city,$where='',$haotype,$lock=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<10000){
			$this->db->where('hao_type',$haotype);
		}
		$this->db->where('( '.$where.' )');
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function get_haoma_list_likea($page, $limit,$city,$where,$haotype,$lock=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<10000){
			$this->db->where('hao_type',$haotype);
		}
		$this->db->where('( '.$where.' )');
		$this->db->where('hao_lock <=',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function count_list_haoma_likeb($city,$searchnum,$b=0,$haotype=10000,$lock=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<10000){
			$this->db->where('hao_type',$haotype);
		}
		if($b==1){
			$this->db->like('hao_title',$searchnum,'before');
		}else{
			$this->db->like('hao_title',$searchnum);
		}		
		$this->db->where('hao_lock <=',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_haoma_list_likeb($page, $limit,$city,$searchnum,$b=0,$haotype=10000,$lock=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<10000){
			$this->db->where('hao_type',$haotype);
		}
		if($b==1){
			$this->db->like('hao_title',$searchnum,'before');
		}else{
			$this->db->like('hao_title',$searchnum);
		}	
		$this->db->where('hao_lock <=',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}

	public function count_list_haoma_liked($city,$searchnum,$lock=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		$this->db->like('hao_title',$searchnum);
		$this->db->where('hao_lock <=',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function get_haoma_list_liked($page, $limit,$city,$searchnum,$lock=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		$this->db->like('hao_title',$searchnum);
		$this->db->where('hao_lock <=',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function count_list_haoma_liket($city,$haotype,$searchnum,$b,$lock)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<>10000){
			$this->db->where('hao_type',$haotype);
		}
		if($searchnum!='iiiii'){
			if($b<=1){
				$this->db->like('hao_title',$searchnum);
			}elseif($b==2){
				$this->db->like('hao_title',$searchnum,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$searchnum,'before');
			}
		}
		$this->db->where('hao_lock <=',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function get_haoma_list_liket($page, $limit,$city,$haotype,$searchnum,$b,$lock=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_city',$city);
		if($haotype<>10000){
			$this->db->where('hao_type',$haotype);
		}	
		if($searchnum!='iiiii'){
			if($b<=1){
				$this->db->like('hao_title',$searchnum);
			}elseif($b==2){
				$this->db->like('hao_title',$searchnum,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$searchnum,'before');
			}
		}
		$this->db->where('hao_lock >=',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	//大厅
	public function count_list_haoma($cityid,$lock=0,$hao_type,$hao_pinpai=0,$title_hao_types=0,$jiage='',$shuwei='',$hao_redian=0,$hao_endst='',$tedians='',$hao_heyust='',$hao_jixiongs='',$list=0,$list_a=0)
	{
		$pinshuxing=$this->get_pinshuxing_by_pin_num($hao_pinpai);
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_city',$cityid);
		$this->db->where('hao_lock <=',$lock);
		$this->db->where('hao_type',$hao_type);
		if($hao_pinpai>0){	
			if($hao_type<3 && $pinshuxing==1){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}elseif($hao_type>=3){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}			
		}
		if($title_hao_types>0){
			$this->db->like('hao_title',$title_hao_types, 'after');
		}
		if(isset($jiage)&&!empty($jiage)){
			$this->db->where(''.$jiage.'');
		}
		if(isset($shuwei)&&!empty($shuwei)){
			$this->db->where(''.$shuwei.'');
		}
		if($hao_redian>0){
			$this->db->like('hao_title',$hao_redian-1000, 'before');
		}
		if(isset($hao_endst)&&!empty($hao_endst)){
			$this->db->where(''.$hao_endst.'');
		}
		if(isset($tedians)&&!empty($tedians)){
			$this->db->where(''.$tedians.'');
		}
		if(isset($hao_heyust)&&!empty($hao_heyust)){
			$this->db->where(''.$hao_heyust.'');
		}
		if(isset($hao_jixiongs)&&!empty($hao_jixiongs)){
			$this->db->where(''.$hao_jixiongs.'');
		}
		if($list>0){
			$this->db->where('hao_dig',$list);
		}
		if($list_a==3){
			$this->db->where('hao_jiage',0);
			$this->db->where('hao_huafei',0);
		}elseif($list_a==1 || $list_a==2){
			$this->db->where('hao_jiage >',0);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_haoma_list($page, $limit,$cityid,$lock=0,$hao_type,$hao_pinpai=0,$title_hao_types=0,$jiage='',$shuwei='',$hao_redian=0,$hao_endst='',$tedians='',$hao_heyust='',$hao_jixiongs='',$list=0,$list_a=0,$list_b=0,$list_c=0)
	{
		$pinshuxing = $this->get_pinshuxing_by_pin_num($hao_pinpai);
		$this->db->select("*");
		$this->db->from('haoma');
		$this->db->where('hao_city',$cityid);
		$this->db->where('hao_lock <=',$lock);
		$this->db->where('hao_type',$hao_type);
		if($hao_pinpai>0){	
			if($hao_type<3 && $pinshuxing==1){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}elseif($hao_type>=3){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}			
		}
		if($title_hao_types>0){
			$this->db->like('hao_title',$title_hao_types, 'after');
		}
		if(isset($jiage)&&!empty($jiage)){
			$this->db->where(''.$jiage.'');
		}
		if(isset($shuwei)&&!empty($shuwei)){
			$this->db->where(''.$shuwei.'');
		}
		if($hao_redian>0){
			$this->db->like('hao_title',$hao_redian-1000, 'before');
		}
		if(isset($hao_endst)&&!empty($hao_endst)){
			$this->db->where(''.$hao_endst.'');
		}
		if(isset($tedians)&&!empty($tedians)){
			$this->db->where(''.$tedians.'');
		}
		if(isset($hao_heyust)&&!empty($hao_heyust)){
			$this->db->where(''.$hao_heyust.'');
		}
		if(isset($hao_jixiongs)&&!empty($hao_jixiongs)){
			$this->db->where(''.$hao_jixiongs.'');
		}
		if($list>0){
			$this->db->where('hao_dig',$list);
		}
		if($list_a==1){
			$this->db->where('hao_jiage >',0);
			$this->db->order_by('hao_jiage','desc');
			$this->db->order_by('hao_huafei','desc');
		}elseif($list_a==2){
			$this->db->where('hao_jiage >',0);
			$this->db->order_by('hao_jiage','asc');
			$this->db->order_by('hao_huafei','desc');
		}elseif($list_a==3){
			$this->db->where('hao_jiage',0);
			$this->db->where('hao_huafei',0);
		}
		if($list_b==1){
			$this->db->order_by('hao_title','desc');
		}elseif($list_b==2){
			$this->db->order_by('hao_title','asc');
		}
		if($list_c==1){
			$this->db->order_by('hao_time','desc');
		}elseif($list_c==2){
			$this->db->order_by('hao_time','asc');
		}
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	
	public function get_haoma_lists($page, $limit,$cityid,$lock=0,$hao_type,$hao_pinpai=0,$title_hao_types=0,$jiage='',$shuwei='',$hao_redian=0,$hao_endst='',$tedians='',$hao_heyust='',$hao_jixiongs='',$list=0,$list_a=0,$list_b=0,$list_c=0,$searchnum,$b,$lock=0)
	{
		
		$pinshuxing = $this->get_pinshuxing_by_pin_num($hao_pinpai);
		$this->db->select("*");
		$this->db->from('haoma');
		$this->db->where('hao_city',$cityid);
		//$this->db->where('hao_lock <=',$lock);
		$this->db->where('hao_type',$hao_type);
		
		if($searchnum!='iiiii'){
			if($b<=1){
				$this->db->like('hao_title',$searchnum);
			}elseif($b==2){
				$this->db->like('hao_title',$searchnum,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$searchnum,'before');
			}
		}
		$this->db->where('hao_lock >=',$lock);
		
		
		if($hao_pinpai>0){	
			if($hao_type<3 && $pinshuxing==1){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}elseif($hao_type>=3){
				$this->db->where('hao_pinpai',$hao_pinpai);
			}			
		}
		if($title_hao_types>0){
			$this->db->like('hao_title',$title_hao_types, 'after');
		}
		if(isset($jiage)&&!empty($jiage)){
			$this->db->where(''.$jiage.'');
		}
		if(isset($shuwei)&&!empty($shuwei)){
			$this->db->where(''.$shuwei.'');
		}
		if($hao_redian>0){
			$this->db->like('hao_title',$hao_redian-1000, 'before');
		}
		if(isset($hao_endst)&&!empty($hao_endst)){
			$this->db->where(''.$hao_endst.'');
		}
		if(isset($tedians)&&!empty($tedians)){
			$this->db->where(''.$tedians.'');
		}
		if(isset($hao_heyust)&&!empty($hao_heyust)){
			$this->db->where(''.$hao_heyust.'');
		}
		if(isset($hao_jixiongs)&&!empty($hao_jixiongs)){
			$this->db->where(''.$hao_jixiongs.'');
		}
		if($list>0){
			$this->db->where('hao_dig',$list);
		}
		if($list_a==1){
			$this->db->where('hao_jiage >',0);
			$this->db->order_by('hao_jiage','desc');
			$this->db->order_by('hao_huafei','desc');
		}elseif($list_a==2){
			$this->db->where('hao_jiage >',0);
			$this->db->order_by('hao_jiage','asc');
			$this->db->order_by('hao_huafei','desc');
		}elseif($list_a==3){
			$this->db->where('hao_jiage',0);
			$this->db->where('hao_huafei',0);
		}
		if($list_b==1){
			$this->db->order_by('hao_title','desc');
		}elseif($list_b==2){
			$this->db->order_by('hao_title','asc');
		}
		if($list_c==1){
			$this->db->order_by('hao_time','desc');
		}elseif($list_c==2){
			$this->db->order_by('hao_time','asc');
		}
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	
	
	
	
	public function check_haoma_by_title($title)
	{
		$query = $this->db->select('*')->where('hao_title', $title)->order_by('id', 'asc')->get('haoma');
		if($query->num_rows>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function check_haoma_by_title_user($title,$user)
	{
		$query = $this->db->select('*')->where('hao_title', $title)->where('hao_user', $user)->order_by('id', 'asc')->get('haoma');
		if($query->num_rows>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function get_cnums_city($city)
	{
		$query = $this->db->select('cnums')->where('cid', $city)->order_by('cid', 'asc')->get('citys')->row_array();
		if($query){
			return $query['cnums'];
		}else{
			return $this->config->item('webnums');
		}
	}
	public function get_unums_user($user='')
	{
		if(isset($user)){
			$query = $this->db->select('unums')->where('username', $user)->order_by('userid', 'asc')->get('users')->row_array();
			if($query){
				return $query['unums'];
			}else{
				return $this->config->item('webnums');
			}
		}else{
			return $this->config->item('webnums');
		}
	}
	
	public function get_user_haoma_list($page, $limit,$user,$lock=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_user',$user);
		$this->db->where('hao_lock >=',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_count_by_user($hao_user='',$hao_time=0,$hao_city=0, $hao_type='')
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if($hao_time>0){
			$numday=$hao_time*60*60*24;
			$s=time()-$numday;
			$this->db->where('hao_time <',$s);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		if($hao_type){
			$this->db->where('hao_type',$hao_type);
		}
		$this->db->where('hao_lock',0);
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function get_count_by_user_member($hao_user,$hao_time='notime',$hao_city,$hao_type='notype',$hao_pinpai='nopinpai')
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if($hao_time>=0 && $hao_time<>'notime'){
			$numday=$hao_time*60*60*24;
			$s=time()-$numday;
			$this->db->where('hao_time <',$s);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		if($hao_type<>'notype'){
			$this->db->where('hao_type',$hao_type);
		}
		if($hao_pinpai<>'nopinpai'){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		$this->db->where('hao_lock',0);
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function get_count_by_tz($hao_user='',$hao_city=0,$hao_timea='',$hao_timeb='',$hao_jiagea=0,$hao_jiageb=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if(!empty($hao_timea) && !empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time between '.$a.' and '.$b.'');
		}elseif(!empty($hao_timea) && empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$this->db->where('hao_time >',$a);
		}elseif(empty($hao_timea) && !empty($hao_timeb)){
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time <',$b);
		}
		if($hao_jiagea>0 && $hao_jiageb>0){
			$this->db->where('hao_jiage between '.$hao_jiagea.' and '.$hao_jiageb.'');
		}elseif($hao_jiagea>0 && $hao_jiageb==0){
			$this->db->where('hao_jiage >=',$hao_jiagea);
		}elseif($hao_jiagea==0 && $hao_jiageb>0){
			$this->db->where('hao_jiage <=',$hao_jiageb);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function get_list_by_dc($hao_user='',$hao_city=0,$hao_timea='',$hao_timeb='',$hao_type='')
	{
		$this->db->select("hao_pinpai,hao_title,hao_jiage,hao_huafei,hao_heyue,hao_beizhu,hao_user");
		$this->db->from('haoma');
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if(!empty($hao_timea) && !empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time between '.$a.' and '.$b.'');
		}elseif(!empty($hao_timea) && empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$this->db->where('hao_time >',$a);
		}elseif(empty($hao_timea) && !empty($hao_timeb)){
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time <',$b);
		}
		if(!empty($hao_type)){
			$this->db->where('hao_type',$hao_type);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		$query = $this->db->get();
		if($query->num_rows>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	public function get_count_by_dc($hao_user='',$hao_city=0,$hao_timea='',$hao_timeb='',$hao_type='')
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if(!empty($hao_timea) && !empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time between '.$a.' and '.$b.'');
		}elseif(!empty($hao_timea) && empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$this->db->where('hao_time >',$a);
		}elseif(empty($hao_timea) && !empty($hao_timeb)){
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time <',$b);
		}
		if(!empty($hao_type)){
			$this->db->where('hao_type',$hao_type);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function tz_haoma_by_tz($hao_user='',$hao_city=0,$hao_timea='',$hao_timeb='',$hao_jiagea=0,$hao_jiageb=0,$hao_nums=0)
	{
		$this->db->set('hao_jiage','hao_jiage+'.$hao_nums,false);
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if(!empty($hao_timea) && !empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time between '.$a.' and '.$b.'');
		}elseif(!empty($hao_timea) && empty($hao_timeb)){
			$a=strtotime($hao_timea." 00:00:00");
			$this->db->where('hao_time >',$a);
		}elseif(empty($hao_timea) && !empty($hao_timeb)){
			$b=strtotime($hao_timeb." 23:59:59");
			$this->db->where('hao_time <',$b);
		}
		if($hao_jiagea>0 && $hao_jiageb>0){
			$this->db->where('hao_jiage between '.$hao_jiagea.' and '.$hao_jiageb.'');
		}elseif($hao_jiagea>0 && $hao_jiageb==0){
			$this->db->where('hao_jiage >=',$hao_jiagea);
		}elseif($hao_jiagea==0 && $hao_jiageb>0){
			$this->db->where('hao_jiage <=',$hao_jiageb);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		$this->db->update('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function count_haoma($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function count_haoma_lock($ug=10000,$ucity=0,$lock)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_lock <=',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_haoma_lock_yd($ug=10000,$ucity=0,$lock)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_lock',$lock);
		$total=$this->db->count_all_results();
		return $total;	
	}
	public function count_haoma_yijia($ug=10000,$ucity=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_jiage',0);
		$this->db->where('hao_huafei',0);
		$total=$this->db->count_all_results();
		return $total;	
	}	
	public function count_haoma_lock_dig($ug=10000,$ucity=0,$lock,$dig)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_lock<=',$lock);
		$this->db->where('hao_dig=',$dig);
		$total=$this->db->count_all_results();
		return $total;	
	}
	
	public function get_haoma_by_id($id)
	{
		$query = $this->db->get_where('haoma',array('id'=>$id));
		if($query->num_rows>0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	public function get_haoma_by_ids($id)
	{
		$this->db->select('a.*,b.pin_title,b.pin_shuxing,c.cname');
		$this->db->from('haoma a');
		$this->db->join('pinpai b','b.pin_num = a.hao_pinpai','left');
		$this->db->join('citys c','c.cid = a.hao_city','left');
		$this->db->where('a.id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_haoma_jixion()
	{
		$query = $this->db->get_where('jixiong');
		if($query->num_rows>0){
			return $query->result_array();
		} else{
			return false;
		}
	}
	
	public function get_zifei_by_city_pinpai_type($city,$pinpai,$type,$limit)
	{
		$this->db->select('*');
		$this->db->from('zifei');
		$this->db->where('zf_city',$city);
		$this->db->where('zf_pinpai',$pinpai);
		$this->db->where('zf_type',$type);
		$this->db->order_by('zf_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function get_peisong_by_city($city,$type,$limit)
	{
		$this->db->select('*');
		$this->db->from('pages');
		$this->db->where('pages_city',$city);
		$this->db->where('pages_type',$type);
		$this->db->order_by('pages_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	public function get_haoma_loves($titles,$title,$city,$pinpai=0,$type,$limit)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->like('hao_title',$title, 'before');
		$this->db->where('hao_title !=',$titles);
		$this->db->where('hao_city',$city);
		if($pinpai>0){
			$this->db->where('hao_pinpai',$pinpai);
		}		
		$this->db->where('hao_type',$type);
		$this->db->where('hao_lock',0);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
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
	
	public function get_pname_by_pid($id)
	{
		$query = $this->db->select("pin_title")->where('id',$id)->get('pinpai');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return '<span class="badge badge-yellow">'.$cname['pin_title'].'</span>';
		} else	{
			return '<span class="badge badge-success">全站</span>';
		}
	}
	public function get_pname_by_pin_num($num)
	{
		$query = $this->db->select("pin_title")->where('pin_num',$num)->get('pinpai');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return '<span class="badge badge-yellow">'.$cname['pin_title'].'</span>';
		} else	{
			return '<span class="badge badge-success">--</span>';
		}
	}
	
	public function get_pinname_by_pin_num($num)
	{
		$query = $this->db->select("pin_title")->where('pin_num',$num)->get('pinpai');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return $cname['pin_title'];
		} 
	}
	
	public function get_pinshuxing_by_pin_num($num)
	{
		$query = $this->db->select("pin_shuxing")->where('pin_num',$num)->get('pinpai');
		if($query->num_rows>0){
			$cname = $query->row_array();
			return $cname['pin_shuxing'];
		}else{
			return '8';
		} 
	}
	
	public function get_all_haoma_list($page, $limit,$ug=0,$ucity=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_haoma_city_type_num($cityid,$hao_type,$hao_lock,$hao_dig=0,$limit)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		$this->db->where('hao_city',$cityid);
		$this->db->where('hao_type',$hao_type);
		$this->db->where('hao_lock <=',$hao_lock);
		if($hao_dig>0){
			$this->db->where('hao_dig',$hao_dig);
		}
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_all_haoma_list_lock($page, $limit,$ug=0,$ucity=0,$lock)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->where('hao_lock',$lock);
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function get_hao_dig($dig,$id)
	{
		foreach(explode("|",$this->config->item('haojis')) as $k => $s){
			if($dig==$k){
				if($dig==0){
					$t='badge-grey';
				}elseif($dig==1){
					$t='badge-success';
				}elseif($dig==2){
					$t='badge-pink';
				}
				return '<a href="#" class="digbox badge '.$t.'" data-type="select" data-pk="'.$id.'" data-value="'.$dig.'" data-title="'.$s.'">'.$s.'</a>';
			}
		}
	}
	
	public function get_hao_lock($lock,$id)
	{
		foreach(explode("|",$this->config->item('haolocks')) as $k => $s){
			if($lock==$k){
				if($lock==0){
					$t='badge-success';
				}elseif($lock==1){
					$t='badge-grey';
				}elseif($lock==2){
					$t='badge-pink';
				}
				return '<a href="#" class="lockbox badge '.$t.'" data-type="select" data-pk="'.$id.'" data-value="'.$lock.'" data-title="'.$s.'">'.$s.'</a>';
			}
		}
	}
	
	public function get_hao_lock_cart($lock,$id)
	{
		foreach(explode("|",$this->config->item('haolocks')) as $k => $s){
			if($lock==$k){
				return $s;
			}
		}
	}
	
	public function check_username($username,$hao_city)
	{
		$query = $this->db->select('userid')->where('username', $username)->order_by('userid', 'asc')->get('users');
		if($query->num_rows==0){
			$c = $this->db->select('cnums')->where('cid', $hao_city)->order_by('cid', 'asc')->get('citys')->row_array();
			$this->db->insert('users',array('username'=>$username,'upassword'=>'123456','uemail'=>'xxx@xxx.com','uregip'=>get_onlineip(),'unums'=>$c['cnums'],'utype'=>5,'ugroup'=>5,'ucity'=>$hao_city,'uregtime'=>time(),'ulogtime' => time()));
		}
	}
	
	public function get_haoma_count_by_user($user,$lock=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		$this->db->where('hao_user',$user);
		if($lock>0){
			$this->db->where('hao_lock',$lock);
		}
		$total=$this->db->count_all_results();
		return $total;
	}
	
	public function count_haoma_search($q='foxno',$sotype=0,$hao_pinpai='',$ucity=0, $ug=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($q) && $q!='foxno'){
			if($sotype==0){
				$this->db->like('hao_title',$q);
				$this->db->or_like('hao_user',$q);
			}elseif($sotype==1){
				$this->db->like('hao_user',$q);
			}elseif($sotype==2){
				$this->db->like('hao_title',$q);
			}			
		}

		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($hao_pinpai){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
		
	public function search_haoma($page, $limit, $q='foxno',$sotype=0,$hao_pinpai='',$ucity=0, $ug=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		if(!empty($q) && $q!='foxno'){
			if($sotype==0){
				$this->db->like('hao_title',$q);
				$this->db->or_like('hao_user',$q);
			}elseif($sotype==1){
				$this->db->like('hao_user',$q);
			}elseif($sotype==2){
				$this->db->like('hao_title',$q);
			}			
		}
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}

		if($hao_pinpai){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}
	
	public function count_haoma_searchm($q='foxno',$sotype=0,$hao_pinpai='',$ucity=0, $ug=0,$b=0)
	{
		$this->db->select("id");
		$this->db->from('haoma');
		if(!empty($q) && $q!='foxno'){
			if($sotype==0){
				//$this->db->like('hao_title',$q);
				//$this->db->or_like('hao_user',$q);
				
			if($b<=1){
				$this->db->like('hao_title',$q);
				$this->db->or_like('hao_user',$q);
			}elseif($b==2){
				$this->db->like('hao_title',$q,'after');
				$this->db->or_like('hao_user',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$q,'before');
				$this->db->or_like('hao_user',$q,'before');
			}
			
			}elseif($sotype==1){
				//$this->db->like('hao_user',$q);
				
			if($b<=1){
				$this->db->like('hao_user',$q);
			}elseif($b==2){
				$this->db->like('hao_user',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_user',$q,'before');
			}
			
			}elseif($sotype==2){
				//$this->db->like('hao_title',$q);
				
			if($b<=1){
				$this->db->like('hao_title',$q);
			}elseif($b==2){
				$this->db->like('hao_title',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$q,'before');
			}
			
			}			
		}

		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}
		if($hao_pinpai){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$total=$this->db->count_all_results();
		return $total;	
	}
		
	public function search_haomam($page, $limit, $q='foxno',$sotype=0,$hao_pinpai='',$ucity=0, $ug=0,$b=0)
	{
		$this->db->select('*');
		$this->db->from('haoma');
		if(!empty($q) && $q!='foxno'){
			if($sotype==0){
				//$this->db->like('hao_title',$q);
				//$this->db->or_like('hao_user',$q);

			if($b<=1){
				$this->db->like('hao_title',$q);
				$this->db->or_like('hao_user',$q);
			}elseif($b==2){
				$this->db->like('hao_title',$q,'after');
				$this->db->or_like('hao_user',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$q,'before');
				$this->db->or_like('hao_user',$q,'before');
			}				
				
			}elseif($sotype==1){
				//$this->db->like('hao_user',$q);
			if($b<=1){
				$this->db->like('hao_user',$q);
			}elseif($b==2){
				$this->db->like('hao_user',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_user',$q,'before');
			}				
				
			}elseif($sotype==2){
				//$this->db->like('hao_title',$q);
				
			if($b<=1){
				$this->db->like('hao_title',$q);
			}elseif($b==2){
				$this->db->like('hao_title',$q,'after');
			}elseif($b==3){
				$this->db->like('hao_title',$q,'before');
			}
			
			}			
		}
		if($ug<10000){
			$this->db->where('hao_type',$ug);
		}

		if($hao_pinpai){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		if($ucity>0){
			$this->db->where('hao_city',$ucity);
		}
		$this->db->order_by('hao_time','desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result_array();
		}
	}	
	
	
	public function add_haoma($data)
    {
    	$this->db->insert('haoma',$data);
    	return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	function update_haoma($id, $data){
		$this->db->where('id',$id)->update('haoma', $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_haoma_by_user($del_user='',$hao_time=0,$hao_city=0, $hao_type='')
	{
		if(!empty($del_user)){
			$this->db->where('hao_user',$del_user);
		}		
		if($hao_time>0){
			$numday=$hao_time*60*60*24;
			$s=time()-$numday;
			$this->db->where('hao_time <',$s);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		if($hao_type>0){
			$this->db->where('hao_type',$hao_type);
		}
		$this->db->where('hao_lock',0);
		$this->db->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_haoma_by_user_member($hao_user,$hao_time='notime',$hao_city,$hao_type='notype',$hao_pinpai='nopinpai'){
		if(!empty($hao_user)){
			$this->db->where('hao_user',$hao_user);
		}		
		if($hao_time>=0 && $hao_time<>'notime'){
			$numday=$hao_time*60*60*24;
			$s=time()-$numday;
			$this->db->where('hao_time <',$s);
		}
		if($hao_city>0){
			$this->db->where('hao_city',$hao_city);
		}
		if($hao_type<>'notype'){
			$this->db->where('hao_type',$hao_type);
		}
		if($hao_pinpai<>'nopinpai'){
			$this->db->where('hao_pinpai',$hao_pinpai);
		}
		$this->db->where('hao_lock',0);
		$this->db->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	function del_haoma($id)
	{
		$this->db->where('id', $id)->where('hao_lock',0)->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function input_csv($handle) { 
		$out = array (); 
		$n = 0; 
		while ($data = fgetcsv($handle, 10000)) { 
			$num = count($data); 
			for ($i = 0; $i < $num; $i++) { 
				$out[$n][$i] = $data[$i]; 
			} 
			$n++; 
		} 
		return $out; 
	} 
	
	function del_haoma_title($title)
	{
		$this->db->like('hao_title', $title)->where('hao_lock',0)->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_haoma_title_lock(){
		$this->db->like('hao_title', $title)->where('hao_lock',0)->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	function del_haoma_title_user($title,$user)
	{
		$this->db->like('hao_title', $title)->where('hao_user', $user)->delete('haoma');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}



}