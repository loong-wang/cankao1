<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*模型字段类型*/
$config = array (
	'FIELD_LIST' => array (
		'num5'=>array('types'=>'num5','title'=>'短数字','field'=>'TINYINT|3|TRUE|0'),
		'num11'=>array('types'=>'num11','title'=>'长数字','field'=>'INT|11|TRUE|0'),
		'string50'=>array('types'=>'string50','title'=>'短文本','field'=>'VARCHAR|50|TRUE|NULL'),
		'string100'=>array('types'=>'string100','title'=>'中文本','field'=>'VARCHAR|100|TRUE|NULL'),
		'string255'=>array('types'=>'string255','title'=>'长文本','field'=>'VARCHAR|255|TRUE|NULL'),
		'text'=>array('types'=>'text','title'=>'文本区','field'=>'TEXT'),
	),
);