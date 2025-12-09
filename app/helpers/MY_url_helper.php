<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('css_url'))
{
	function css_url($uri = '',$class='',$id='')
	{
	$CI =& get_instance();
	if(isset($class)){$class=' class="'.$class.'"';}
	if(isset($id)){$id=' id="'.$id.'"';}
	$css_string= "<link rel='stylesheet' type='text/css' href='".$CI->config->base_url("app/views/public/css/".$uri.'.css')."' ".$class." ".$id." media='all'>";
	return $css_string;
	}
}
if ( ! function_exists('ccss_url'))
{
	function ccss_url($uri = '')
	{
	$CI =& get_instance();
	$css_string='';
	if(isset($uri)){
		$arr_f = array_unique(explode(',',preg_replace("/\.+\//",'',$uri)));
		foreach($arr_f as $v)
		{
			$css_string .= "<link rel='stylesheet' type='text/css' href='".$CI->config->base_url("app/views/public/css/".$v.'.css')."' media='all'>";
		}
	}
	return $css_string;
	}
}
//---------------------------------
if ( ! function_exists('js_url'))
{
	function js_url($uri = '')
	{
	$CI =& get_instance();
	$javascript_string='';
	if(isset($uri)){
		$arr_f = array_unique(explode(',',preg_replace("/\.+\//",'',$uri)));
		foreach($arr_f as $v)
		{
		$javascript_string .= "<script type='text/javascript' src='".base_url("app/views/public/js/".$v.'.js')."'></script>";
		}
	}
	return $javascript_string;
	}
}

if ( ! function_exists('jjs_url'))
{
	function jjs_url($uri = '')
	{
	$CI =& get_instance();
	$javascript_string= "<script type='text/javascript' src='".base_url("app/views/public/js/".$uri.'.js')."'>'+'<'+'/script>";
	return $javascript_string;
	}
}

if ( ! function_exists('plugin_url'))
{
	function plugin_url($uri = '')
	{
	$CI =& get_instance();
	$string= base_url("app/views/public/".$uri);
	return $string;
	}
}