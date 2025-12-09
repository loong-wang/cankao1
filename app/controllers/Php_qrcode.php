<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Php_qrcode extends FOX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('phpqrcode');
	}
	
	public function index()
	{
		if($this->fox_scheid){
			$url='mobile/renz/'.$this->fox_scheid;
			//print_r($url);
			QRcode::png(site_url($url));
		}
	}
}