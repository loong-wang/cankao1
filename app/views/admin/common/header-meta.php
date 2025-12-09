<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<link rel="shortcut icon" href="<?php echo base_url('public/img/favicon.ico')?>" type="image/x-icon" />
<?php echo css_url('bootstrap');?>
<?php echo css_url('font-awesome');?>
<?php echo css_url('ace','ace-fonts');?>
<?php echo css_url('fox');?>
<!--[if lte IE 9]>
	<?php echo css_url('ace-part2','ace-main-stylesheet','');?>
	<?php echo css_url('ace-ie');?>
<![endif]-->
<script type="text/javascript">
var baseurl='<?php echo base_url()?>';
var siteurl='<?php echo site_url()?>';
var sitedomain='<?php echo get_domain()?>';
</script>
<?php echo js_url('ace-extra');?>
<!--[if lt IE 9]>
<?php //echo js_url('html5shiv,respond');?>
<![endif]-->
