<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$comurl_fox=parse_url($_SERVER['HTTP_HOST']);
//$comurl_s=$comurl_fox['host']?$comurl_fox['host']:$comurl_fox['path'];
$comurl_s=$_SERVER['HTTP_HOST'];
preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU', $comurl_s, $domain);
//var_dump($comurl_fox);
$C_domain = rtrim($domain[0], '/');
$config['base_url'] = '';
$config['index_page'] = '';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= 'cn';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'fox_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = APPPATH . 'cache/session';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= 'fox_';
$config['cookie_domain']	= ''.$C_domain.'';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = false;
$config['csrf_token_name'] = 'fox_csrf_token';
$config['csrf_cookie_name'] = 'fox_csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = array('admin/haoma/del_hao_by_del',
'upload/upload_mbrenzbs',
'admin/haoma/get_hao_by_del',
'member/get_hao_by_del',
'member/del_hao_by_del',
'admin/haoma/get_hao_by_tz',
'admin/daohao/get_hao_by_dc',
'admin/daohao/dc_hao_by_dc',
'admin/haoma/tz_hao_by_tz');
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
