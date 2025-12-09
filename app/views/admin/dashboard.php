<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title;?> - <?php echo $this->config->item('site_name');?></title>
<meta name="keywords" content="<?php echo $this->config->item('site_keywords');?>" />
<meta name="description" content="<?php echo $this->config->item('site_description');?>" />
<?php $this->load->view('common/header-meta');?>
</head>
<body class="no-skin">
<?php $this->load->view('common/header');?>
		<div class="main-container" id="main-container">
			<!-- #section:basics/sidebar -->
			<?php $this->load->view('common/sidebar');?>
			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="<?php echo site_url('admin/login');?>">后台首页</a>
							</li>
							<li class="active"><?php echo $title;?></li>
						</ul><!-- /.breadcrumb -->
						<?php $this->load->view('common/topbar');?>						
						<!-- /section:basics/content.searchbox -->
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<?php $this->load->view('common/setpager');?>
						<div class="page-header">
							<h1>
								<?php echo $title;?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo strtoupper(Pinyin($title));?>
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="well well-sm">
									<h4 class="lighter no-margin-bottom">
										<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
										<small><?php echo $this->session->userdata('username');?>，恭喜您成功登陆后台，
										<strong class="green">
											您的级别：<?php echo $this->session->userdata('group_name');?> <?php echo $ucity;?>
										</strong></small>
									</h4>
								</div>
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>
									今天是：<?php echo date('Y',time());?>年<?php echo date('m',time());?>月<?php echo date('d',time());?>日
								</div>
								
								<h4 class="lighter">
										<i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
										站内统计
									</h4>
									<table id="sample-table-1" class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td style="width:100px;">订单总数</td>
												<td><?php echo $count_dingdan;?></td>
												<td style="width:100px;">今日订单</td>
												<td><?php echo $count_dingdan_today;?></td>
											</tr>
											<tr>
												<td style="width:100px;">站内号码</td>
												<td><?php echo $count_haoma;?></td>
												<td style="width:100px;">成功售出</td>
												<td><?php echo $count_haoma_lock;?></td>
											</tr>
											<tr>
												<td style="width:100px;">注册会员</td>
												<td><?php echo $count_user;?></td>
												<td style="width:100px;">今日注册</td>
												<td><?php echo $count_user_today;?></td>
											</tr>
										</tbody>
									</table>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php $this->load->view('common/footer');?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
<!--[if !IE]> -->
<script type="text/javascript">
	window.jQuery || document.write("<?php echo jjs_url('jquery');?>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<?php echo jjs_url('jquery1x');?>");
</script>
<![endif]-->

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<?php echo jjs_url('jquery.mobile.custom');?>");
</script>
<?php echo js_url('bootstrap');?>
<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
	<?php echo js_url('excanvas');?>
<![endif]-->

<?php echo js_url('jquery-ui.custom');?>
<?php echo js_url('jquery.ui.touch-punch');?>
<?php echo js_url('jquery.easypiechart');?>
<?php echo js_url('jquery.sparkline');?>
<?php echo js_url('flot/jquery.flot');?>
<?php echo js_url('flot/jquery.flot.pie');?>
<?php echo js_url('flot/jquery.flot.resize');?>

<!-- ace scripts -->
<?php echo js_url('ace/elements.scroller');?>
<?php echo js_url('ace/elements.colorpicker');?>
<?php echo js_url('ace/ace');?>
<?php echo js_url('ace/ace.ajax-content');?>
<?php echo js_url('ace/ace.touch-drag');?>
<?php echo js_url('ace/ace.sidebar');?>
<?php echo js_url('ace/ace.sidebar-scroll-1');?>
<?php echo js_url('ace/ace.submenu-hover');?>
<?php echo js_url('ace/ace.widget-box');?>
<?php echo js_url('ace/ace.settings');?>
<?php echo js_url('ace/ace.settings-rtl');?>
<?php echo js_url('ace/ace.settings-skin');?>
<?php echo js_url('ace/ace.widget-on-reload');?>
<?php echo js_url('ace/ace.searchbox-autocomplete');?>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		$('.easy-pie-chart.percentage').each(function(){
			var $box = $(this).closest('.infobox');
			var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
			var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor: barColor,
				trackColor: trackColor,
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(size/10),
				animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
				size: size
			});
		})
	
		$('.sparkline').each(function(){
			var $box = $(this).closest('.infobox');
			var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
			$(this).sparkline('html',
							 {
								tagValuesAttribute:'data-values',
								type: 'bar',
								barColor: barColor ,
								chartRangeMin:$(this).data('min') || 0
							 });
		});
	
	
	  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
	  //but sometimes it brings up errors with normal resize event handlers
	  $.resize.throttleWindow = false;
	
	  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
	  var data = [
		{ label: "social networks",  data: 38.7, color: "#68BC31"},
		{ label: "search engines",  data: 24.5, color: "#2091CF"},
		{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
		{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
		{ label: "other",  data: 10, color: "#FEE074"}
	  ]
	  function drawPieChart(placeholder, data, position) {
		  $.plot(placeholder, data, {
			series: {
				pie: {
					show: true,
					tilt:0.8,
					highlight: {
						opacity: 0.25
					},
					stroke: {
						color: '#fff',
						width: 2
					},
					startAngle: 2
				}
			},
			legend: {
				show: true,
				position: position || "ne", 
				labelBoxBorderColor: null,
				margin:[-30,15]
			}
			,
			grid: {
				hoverable: true,
				clickable: true
			}
		 })
	 }
	 drawPieChart(placeholder, data);
	
	 /**
	 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
	 so that's not needed actually.
	 */
	 placeholder.data('chart', data);
	 placeholder.data('draw', drawPieChart);
	
	
	  //pie chart tooltip example
	  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
	  var previousPoint = null;
	
	  placeholder.on('plothover', function (event, pos, item) {
		if(item) {
			if (previousPoint != item.seriesIndex) {
				previousPoint = item.seriesIndex;
				var tip = item.series['label'] + " : " + item.series['percent']+'%';
				$tooltip.show().children(0).text(tip);
			}
			$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
		} else {
			$tooltip.hide();
			previousPoint = null;
		}
		
	 });
	
		
	
	$( ".tooltip-info,.tooltip-success,.tooltip-error,.tooltip-warning" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
		
	
	})
</script>
</body>
</html>
