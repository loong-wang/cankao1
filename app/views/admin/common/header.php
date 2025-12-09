<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>

	<div class="navbar-container" id="navbar-container">
		<!-- #section:basics/sidebar.mobile.toggle -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<!-- /section:basics/sidebar.mobile.toggle -->
		<div class="navbar-header pull-left">
			<!-- #section:basics/navbar.layout.brand -->
			<a href="#" class="navbar-brand">
				<small>
					<i class="fa fa-desktop"></i>
					<strong> 后台管理 </strong> <span class="hidden-480" style="font-size:14px;padding-top:10px;">提示：360浏览极速模式下效果最佳</div>
				</small>
			</a>

			<!-- /section:basics/navbar.layout.brand -->

			<!-- #section:basics/navbar.toggle -->

			<!-- /section:basics/navbar.toggle -->
		</div>

		<!-- #section:basics/navbar.dropdown -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="purple">
					<a class="" target="_blank" href="<?php echo site_url();?>">
						<i class="ace-icon fa fa-home home-icon"></i>
						前台
					</a>
				</li>
				<li class="green">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-shopping-cart icon-animated-vertical"></i>
						<span class="badge badge-success"><?php echo $count_dingdan_today;?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-shopping-cart"></i>
							今日订单 <?php echo $count_dingdan_today;?> 个，请及时处理
						</li>

						
					</ul>
				</li>

				<!-- #section:basics/navbar.user_menu -->
				<li class="light-blue">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo base_url($user['middle_avatar'])?>" alt="<?php echo $user['nake'];?>" />
						<span class="user-info">欢迎您
							<small><?php echo $user['nake'];?></small>
						</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo site_url('admin/users/edita/'.$this->session->userdata('userid'));?>">
								<i class="ace-icon fa fa-cog"></i>
								资料设置
							</a>
						</li>

						<li>
							<a href="<?php echo site_url('admin/users/profile/'.$this->session->userdata('userid'));?>">
								<i class="ace-icon fa fa-user"></i>
								头像设置
							</a>
						</li>
						<?php if($this->auth->is_admin()){?>
						<li>
							<a href="<?php echo site_url('admin/webset/delcaches');?>">
								<i class="ace-icon fa fa-user"></i>
								缓存清理
							</a>
						</li>
						<?php }?>

						<li class="divider"></li>

						<li>
							<a href="<?php echo site_url('admin/login/logout');?>">
								<i class="ace-icon fa fa-power-off"></i>
								安全退出
							</a>
						</li>
					</ul>
				</li>

				<!-- /section:basics/navbar.user_menu -->
			</ul>
		</div>

		<!-- /section:basics/navbar.dropdown -->
	</div><!-- /.navbar-container -->
</div>
