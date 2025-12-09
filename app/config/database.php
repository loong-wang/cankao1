<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
'dsn'	=> '',
'hostname' => '127.0.0.1',
'port' => '3306',
'username' => 'xuanhao_net',
'password' => 'xhw123456',
'database' => 'xuanhao_net',
'dbdriver' => 'mysql',
'dbprefix' => 'fox_',
'pconnect' => FALSE,
'db_debug' => (ENVIRONMENT !== 'production'),
'cache_on' => FALSE,
'cachedir' => '',
'char_set' => 'utf8',
'dbcollat' => 'utf8_general_ci',
'swap_pre' => '',
'encrypt' => FALSE,
'compress' => FALSE,
'stricton' => FALSE,
'failover' => array(),
'save_queries' => TRUE
);