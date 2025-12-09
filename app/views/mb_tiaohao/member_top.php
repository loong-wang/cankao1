<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->auth->is_login ()){?>
<div class="bread bg margin-bottom">
    <li><a href="<?php echo site_url('member/index/').'/'.$citys['cid'];?>" class="icon-home"> 会员中心</a> </li>
    <li><?php echo $title;?></li>
</div>
<?php }?>