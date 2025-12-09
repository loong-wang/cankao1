<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array('');
$autoload['libraries'] = array('session','auth');
$autoload['drivers'] = array('');
$autoload['helper'] = array('url','file','function','form','cookie');
$autoload['config'] = array('webset','domainset','cityset');
$autoload['language'] = array('db_lang');
$autoload['model'] = array('memu_m','group_m','page_m','city_m','page_m');
