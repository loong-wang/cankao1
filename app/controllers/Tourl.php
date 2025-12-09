<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourl extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
	}
	
	public function gourl($ctid)
	{		
		if(is_numeric($ctid)){
			if($this->city_m->get_city_by_cid_web($ctid)){
				$city=$this->city_m->get_city_by_cid_web($ctid);			
				$data['title']='转向中……';
				$data['tocity']=$city;
				$this->load->view('tourl',$data);				
			}else{
				show_message('没有找到这个城市','');
			}
		}else{
			show_message('参数有误','');
		}
	}
}
