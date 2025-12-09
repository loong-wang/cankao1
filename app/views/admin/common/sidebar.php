<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="sidebar" class="sidebar responsive">
<?php if($this->auth->is_admin()){?>
<div class="sidebar-shortcuts" id="sidebar-shortcuts">
	<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
		<a href="<?php echo site_url('admin/memuset');?>" class="btn btn-success tooltip-success" data-rel="tooltip" data-placement="right" title="权限管理">
			<i class="ace-icon fa fa-road"></i>
		</a>
		<a href="<?php echo site_url('admin/logs');?>" class="btn btn-info tooltip-info" data-rel="tooltip" data-placement="right" title="登陆日志">
			<i class="ace-icon fa fa-certificate"></i>
		</a>
		<a href="<?php echo site_url('admin/haoset');?>" class="btn btn-warning tooltip-warning" data-rel="tooltip" data-placement="left" title="号码规则">
			<i class="ace-icon fa fa-cog"></i>
		</a>
		<a href="<?php echo site_url('admin/model');?>" class="btn btn-danger tooltip-error" data-rel="tooltip" data-placement="left" title="模型管理">
			<i class="ace-icon fa fa-cogs"></i>
		</a>
	</div>

	<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
		<span class="btn btn-success"></span>

		<span class="btn btn-info"></span>

		<span class="btn btn-warning"></span>

		<span class="btn btn-danger"></span>
	</div>
</div><?php }?>

<ul class="nav nav-list">
	<li <?php if($siderbar=='home'){echo 'class="active"';}?>>
		<a href="<?php echo site_url('admin/login');?>">
			<i class="menu-icon fa fa-home home-icon"></i>
			<span class="menu-text"> 默认首页 </span>
		</a>

		<b class="arrow"></b>
	</li>
	<?php if(isset($siderbar_list)){
	$foxug=$this->session->userdata('ugroup');
	foreach($siderbar_list as $v){
	if(in_array($foxug,explode(",",$v['group_types']))){?>
	<li <?php if(strstr($v['url'],$siderbar)){echo 'class="active"';}?>>
		<a href="<?php echo site_url($v['url']);?>" <?php if($v['count']>0){echo ' class="dropdown-toggle"';}?>>
			<i class="menu-icon fa <?php echo $v['ico'];?>"></i>
			<span class="menu-text"> <?php echo $v['title'];?> </span>
			<?php if($v['count']>0){echo '<b class="arrow fa fa-angle-down"></b>';}?>
		</a>
		<b class="arrow"></b>
		<?php if($v['siderbar_list_s']){?>
		<ul class="submenu">
		<?php foreach($v['siderbar_list_s'] as $s){
		if(in_array($foxug,explode(",",$s['group_type_ss']))){
		?>
			<li <?php if(strstr($s['url'],$submenu)){echo 'class="active"';}?>>
				<a href="<?php echo site_url($s['url']);?>">
					<i class="menu-icon fa fa-caret-right"></i>
					<?php echo $s['title'];?>
				</a>

				<b class="arrow"></b>
			</li>
		<?php }}?>
		</ul>
		<?php }?>
	</li>
	<?php }}}?>		
</ul><!-- /.nav-list -->

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
	<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

</div>