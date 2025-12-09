<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->auth->is_login ()){?>
<div class="panel">
	<div class="panel-head"><strong>会员面板</strong><button class="button icon-navicon button button-little pull-right" data-target="#nav-member">
	</button></div>
	<ul class="nav nav-tabs nav-navicon padding memberleftbar" id="nav-member">
		<?php if(isset($siderbar_list)){
		$foxug=$this->session->userdata('ugroup');
		foreach($siderbar_list as $v){
		if(in_array($foxug,explode(",",$v['group_types']))){?>
		<li>
			<?php if($v['count']>0){?>
				<div style="margin:5px 0px;" class="radius bg"><span class="fa <?php echo $v['ico'];?>"></span> <?php echo $v['title'];?></div>
			<?php }else{?>
			<a href="<?php echo site_url($v['url'].'/'.$citys['cid']);?>">
				<span class="fa <?php echo $v['ico'];?>"></span> <?php echo $v['title'];?> 
			</a>
			<?php }?>
			<?php if($v['siderbar_list_s']){?>
			<ul class="submenu" >
			<?php foreach($v['siderbar_list_s'] as $s){
			if(in_array($foxug,explode(",",$s['group_type_ss']))){
			?>
				<li <?php if(strstr($s['url'],$submenu)){echo 'class="active"';}?>>
					<a href="<?php echo site_url($s['url'].'/'.$citys['cid']);?>">
						<span class="icon-angle-right"></span> <?php echo $s['title'];?> 
					</a>
				</li>
			<?php }}?>
			</ul>
			<?php }?>
		</li>
		<?php }}}?>	
	</ul>
</div>
<br>
<?php }?>