<?php if (!defined('BASEPATH')) exit('No direct access allowed.');


class MY_Loader extends CI_Loader
{
	public function __construct()
	{
		parent::__construct();
	}
	public function set_front_theme($theme='default')
	{
		$this->_ci_view_paths = array(APPPATH.'views/'.$theme.'/'	=> TRUE);
	}
	public function plugin($name)
	{
		$this->add_package_path(APPPATH.'plugin/'.$name.'/');
		$this->library($name);
		//$ci= &get_instance();
		//$ci->config->load($config);
	}

}