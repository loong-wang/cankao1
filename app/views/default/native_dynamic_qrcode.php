<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>微信扫码支付</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('uploads/weixin/Comm_weixin.css');?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('uploads/weixin/WeixinPay.css');?>" />
    <script type="text/javascript" src="<?php echo base_url('uploads/weixin/JQuery132.js');?>"></script>
    <script type="text/javascript">
$(function() {
	var e = $("#qr_box");
	var c = $("#guide");
	c.css({
		left: "50%",
		opacity: 0
	});
	e.hover(function() {
		c.css("display", "block").stop().animate({
			marginLeft: "+156px",
			opacity: 1
		},
		900, "swing",
		function() {
			c.animate({
				marginLeft: "+143px"
			},
			300)
		})
	},
	function() {
		c.stop().animate({
			marginLeft: "-101px",
			opacity: 0
		},
		"400", "swing",
		function() {
			c.hide()
		})
	});
	var d = $("#hidShopID").val();
	var b = 0;
});
    </script>	
</head>
<body>
    <input name="hidShopID" type="hidden" id="hidShopID" value="<?=$out_trade_no?>" />
    <div class="wx_header">
        <div class="wx_logo"><img src="<?php echo base_url('uploads/weixin/wxlogo_pay.png');?>" /></div>
    </div>
    <div class="weixin">
        <div class="weixin2">
            <b class="wx_box_corner left pngFix"></b><b class="wx_box_corner right pngFix"></b>
            <div class="wx_box pngFix">
                <div class="wx_box_area">
				<?php echo csrf_hidden();?>
                    <div class="pay_box qr_default">
                        <div class="area_bd"><span class="wx_img_wrapper"  id="qr_box">
                           <div align="center" id="qrcode" class="ewm_wrapper"></div>
						   <div id="resmsgdiv"></div>
                            <img style="left: 50%; opacity: 0; display: none; margin-left: -101px;" class="guide pngFix" src="<?php echo base_url('uploads/weixin/wxwebpay_guide.png');?>" alt="" id="guide" />
                        </span>
                            <div class="msg_default_box"><i class="icon_wx pngFix"></i>
                                <p>
                                    请使用微信扫描<br/>
                                    二维码以完成支付
                                </p>
                            </div>
                            <div class="msg_box"><i class="icon_wx pngFix"></i>
                                <p><strong>扫描成功</strong>请在手机确认支付</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wx_hd">
                    <div class="wx_hd_img icon_wx"></div>
                </div>
                <div class="wx_money"><span>￥</span><?php echo $total_fee/100;?></div>
                <!--支付订单号-->
                <div class="wx_pay">
                    <p><span  class="wx_left">支付订单号</span>
					<span id="dingdan"  ddcode="<?php echo $out_trade_no;?>"  class="wx_right" ><?php echo $out_trade_no;?></span></p>
					 <p><span  class="wx_left">订单时间</span>
					<span  class="wx_right" ><?php echo date("Y-m-d H:i:s",time());?></span></p>
                    <p><span class="wx_left">订单名称</span><span class="wx_right"><?=$subject?></span></p>
                    <p><a href="<?php echo site_url('cart/alldingdan/'.$citys['cid']);?>"><font color="red">返回用户订单区</font></a></p>
                </div>
               
            </div>
        </div>
    </div> 

	<script src="<?php echo base_url('uploads/weixin/qrcode.js');?>"></script>
	<script>
			var baseurl='<?php echo base_url()?>';
			var siteurl='<?php echo site_url()?>';
			var sitedomain='<?php echo get_domain()?>';
			var sitecityid='<?php echo $citys['cid'];?>';
		<?php if(isset($code_url) && !empty($code_url)){?>
			var url = "<?php echo $code_url;?>";
			//参数1表示图像大小，取值范围1-10；参数2表示质量，取值范围'L','M','Q','H'
			var qr = qrcode(10, 'M');
			qr.addData(url);
			qr.make();
			var wording=document.createElement('p');
			wording.innerHTML = "支付完成前，请勿关闭此页面！";
			var code=document.createElement('DIV');
			code.innerHTML = qr.createImgTag();
			var element=document.getElementById("qrcode");
			element.appendChild(wording);
			element.appendChild(code);
		<?php }?>
	</script>
    <script>
		var d=$("#dingdan").attr("ddcode");
		var cid = "<?php echo $citys['cid'];?>";
		var token=$('#<?php echo $this->config->item('csrf_token_name');?>').val();
			setInterval(function(){
			  $.ajax({
			    url:baseurl+'index.php/wxpay/do_lock',
				type: "post", 		 
				dataType: "json",  
				data: {out_trade_no:d,<?php echo $this->config->item('csrf_token_name');?>:token},  				
				async : true,
				success: function(res){
				    if(res.code!='' && res.code!='999'){
						if(res.code=='4'){
							alert(res.msg);
							window.location.href=baseurl+"index.php/cart/dingdans/"+cid+"/"+d;
						}else{
							alert(res.msg);
							window.location.href=baseurl+"index.php/cart/dingdans/"+cid+"/"+d;
						}
					}
					
				}			  
			  });			
			},5000);
		</script>	

</body>
</html>
