<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="pull-right hidden-480">
	<a href="<?php echo site_url('admin/users/listu');?>" class="btn btn-xs <?php if(strstr('admin/users/listu',$siderbar)){echo 'btn-danger';}else{echo 'btn-info';}?>" title="" />会员管理</a>
	<a href="<?php echo site_url('admin/haoma/haolist');?>" class="btn btn-xs <?php if(strstr('admin/haoma/haolist',$siderbar)){echo 'btn-danger';}else{echo 'btn-info';}?>" title="" />号码列表</a>
	<a href="<?php echo site_url('admin/daohao/daoru');?>" class="btn btn-xs <?php if(strstr('admin/daohao/daoru',$siderbar)){echo 'btn-danger';}else{echo 'btn-info';}?>" title="" />号码导入</a>
	<a href="<?php echo site_url('admin/order/flist');?>" class="btn btn-xs <?php if(strstr('admin/order/flist',$siderbar)){echo 'btn-danger';}else{echo 'btn-info';}?>" title="" />订单管理</a>
	<a href="<?php echo site_url('admin/question/flist');?>" class="btn btn-xs <?php if(strstr('admin/question/flist',$siderbar)){echo 'btn-danger';}else{echo 'btn-info';}?>" title="" />客服问答</a>
</div>