<link rel="stylesheet" href="<?php echo $viewmulu.'/public/css/nav.css';?>" type="text/css">
<script type="text/javascript">
<?php if($this->session->userdata('userid')){?>
var gouwucheurl="<?php echo site_url('member/gouwuche/'.$citys['cid']);?>";
<?php }else{?>
var gouwucheurl="<?php echo site_url('cart/flist/'.$citys['cid']);?>";
<?php }?>
<?php if($this->session->userdata('userid')){?>
var dingdanurl="<?php echo site_url('member/gouwudd/'.$citys['cid']);?>";
<?php }else{?>
var dingdanurl="<?php echo site_url('cart/alldingdan/'.$citys['cid']);?>";
<?php }?>
var shoucangurl="<?php echo site_url('member/gouwusc/'.$citys['cid']);?>";
</script>
<div id="J-global-toolbar">
  <div class="toolbar-wrap J-wrap">
    <div class="toolbar">
      <div class="toolbar-panels J-panel hidden-l">
        <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-cart toolbar-animate-out">
          <h3 class="tbar-panel-header J-panel-header"> <a href="" target="_blank" class="title"> <i></i> <em class="title">购物车</em> </a> <span class="close-panel J-close"></span> </h3>
          <div class="tbar-panel-main">            
          </div>
        </div>
        <!-- hidden -->
        <div style="visibility: hidden;" data-name="follow"	class="J-content toolbar-panel tbar-panel-follow">
          <h3 class="tbar-panel-header J-panel-header"> <a href="#" target="_blank" class="title"> <i></i> <em class="title">我的收藏</em> </a> <span class="close-panel J-close"></span> </h3>
          <div class="tbar-panel-main">
            <div class="tbar-panel-content J-panel-content">
              <div class="tbar-tipbox2">
                <div class="tip-inner"> <i class="i-loading"></i> </div>
              </div>
            </div>
          </div>
          <div class="tbar-panel-footer J-panel-footer"></div>
        </div>
        <div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-history toolbar-animate-in">
          <h3 class="tbar-panel-header J-panel-header"> <a href="#" target="_blank" class="title"> <i></i> <em class="title">浏览记录</em> </a> <span class="close-panel J-close"></span> </h3>
          <div class="tbar-panel-main">
			<div class="padding">
			<ul class="list-unstyle height-big text-big" id="chalist" style="width:200px;padding:0 10px;">		
			</ul>
			</div>
          </div>
          <div class="tbar-panel-footer J-panel-footer"></div>
        </div>
      </div>
      <div class="toolbar-header hidden-l"></div>
      <div class="toolbar-tabs J-tab hidden-l">
        <div class="toolbar-tab tbar-tab-cart"> <i class="tab-ico"></i> <em class="tab-text ">购物车</em> <span class="tab-sub J-count "><?php echo $gouwuche_num;?></span> </div>
        <div class=" toolbar-tab tbar-tab-dingdan "> <i class="tab-ico"></i> <em class="tab-text">我的订单</em> <span class="tab-sub J-count hide">0</span> </div>
        <div class=" toolbar-tab tbar-tab-follow"> <i class="tab-ico"></i> <em class="tab-text">我的收藏</em> <span class="tab-sub J-count hide">0</span> </div>
        <div class=" toolbar-tab tbar-tab-history "> <i class="tab-ico"></i> <em class="tab-text">浏览记录</em> <span class="tab-sub J-count hide">0</span> </div>
      </div>
      <div class="toolbar-footer">
        <div class="toolbar-tab tbar-tab-top"> <a href="#"> <i class="tab-ico  "></i> <em class="footer-tab-text">顶部</em> </a> </div>
        <div class=" toolbar-tab tbar-tab-feedback"> <a href="<?php echo site_url('kefu/yidong/'.$citys['cid']);?>" target="_blank"> <i class="tab-ico"></i> <em class="footer-tab-text ">咨询</em> </a> </div>
      </div>
      <div class="toolbar-mini"></div>
    </div>
    <div id="J-toolbar-load-hook"></div>
  </div>
</div>
<script type="text/javascript" src ="<?php echo $viewmulu.'/public/js/nav.js';?>"></script>
<script type='text/javascript' src="<?php echo $viewmulu.'/public/js/layer.js';?>"></script>