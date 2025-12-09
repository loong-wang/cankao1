<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function renz($fox_scheid)
	{
		//print_r($this->fox_scheid);
		if($fox_scheid){
			$data['title']='手机上传实名资料';
			$data['fox_scheid']=$fox_scheid;
			$data['csrf_name'] = $this->security->get_csrf_token_name();
			$data['csrf_token'] = $this->security->get_csrf_hash();
			$this->load->view('mobile_renz',$data);
		}
	}
	public function getrenzs($fox_scheid)
	{
		if($fox_scheid){
			$dir='uploads/renz/'.$fox_scheid;
			if(!is_dir($dir)){
				echo '0';
			}else{
				$arr = scandir($dir); 
				$all = count($arr)-2;	
				if($all>=3){
					echo '1';
				}else{
					echo '0';
				}		
			}
		}else{
			echo '0';
		}		
	}
	public function getrenz($fox_scheid)
	{
		echo '1';
	}
}
