<div class="bg-foxb border border-fox radius">
	<div class="leftbox">
		<div class="lie">
			<div class="title"><?php echo $citys['cname'];?>移动</div>
			<div class="leftboxin list-inline">
				<li><a href="<?php echo site_url('zifei/yidong/'.$citys['cid']);?>">移动资费</a></li>
				<li><a href="<?php echo site_url('haoma/yidong/'.$citys['cid']);?>">移动选号</a></li>
				<li><a href="<?php echo site_url('kefu/yidong/'.$citys['cid']);?>">移动客服中心</a></li>
				<li><a href="<?php echo site_url('news/yidong/'.$citys['cid']);?>">移动资讯</a></li>
			</div>
		</div>
		<div class="lie">
			<div class="title"><?php echo $citys['cname'];?>联通</div>
			<div class="leftboxin list-inline">
				<li><a href="<?php echo site_url('zifei/liantong/'.$citys['cid']);?>">联通资费</a></li>
				<li><a href="<?php echo site_url('haoma/liantong/'.$citys['cid']);?>">联通选号</a></li>
				<li><a href="<?php echo site_url('kefu/liantong/'.$citys['cid']);?>">联通客服中心</a></li>
				<li><a href="<?php echo site_url('news/liantong/'.$citys['cid']);?>">联通资讯</a></li>
			</div>
		</div>
		<div class="lie">
			<div class="title"><?php echo $citys['cname'];?>电信</div>
			<div class="leftboxin list-inline">
				<li><a href="<?php echo site_url('zifei/dianxin/'.$citys['cid']);?>">电信资费</a></li>
				<li><a href="<?php echo site_url('haoma/dianxin/'.$citys['cid']);?>">电信选号</a></li>
				<li><a href="<?php echo site_url('kefu/dianxin/'.$citys['cid']);?>">电信客服中心</a></li>
				<li><a href="<?php echo site_url('news/dianxin/'.$citys['cid']);?>">电信资讯</a></li>
			</div>
		</div>
		<div class="lie">
			<div class="title">网站服务</div>
			<div class="leftboxin list-inline">
				<!--<li><a href="<?php echo site_url('servers/jixiong/'.$citys['cid']);?>">号码吉凶测试</a></li> -->
				<li><a href="<?php echo site_url('servers/haocity/'.$citys['cid']);?>">号码归属地</a></li>
				<li><a href="<?php echo site_url('servers/haogujia/'.$citys['cid']);?>">号码估价</a></li>
				<li><a href="<?php echo site_url('xinxi/flist/'.$citys['cid']);?>">二手号交易</a></li>
				<li><a href="<?php echo site_url('news/hangye/'.$citys['cid']);?>">行业新闻</a></li>
				<li><a href="<?php echo site_url('news/youhui/'.$citys['cid']);?>">优惠政策</a></li>
			</div>
		</div>
	</div>
</div>


<style>.listContainer_left{ float:left;width:240px; margin-right:10px;margin-top: 10px;}

.listContainer_tjhm{width:243px;border:#ddd solid 1px; margin-bottom:10px;min-height:200px;}
.listContainer_tjhm h2{height:35px; line-height:35px; font-size:12px; background-color:#ededed; padding-left:40px;background-image:url(../images/index_60.png);background-repeat:no-repeat; background-position:15px 8px;}
.listContainer_tjhm h2 span{color:#ff2a06; }
.listContainer_tjhm ul{width:198px; padding-left:5px; padding-right:5px;}
.listContainer_tjhm ul li{width:188px;border-bottom:#ccc dashed 1px; display:inline-block;height:20px; line-height:20px;color:#087dc8; font-size:14px; padding:5px;  }
.listContainer_tjhm ul li:last-child{width:188px;border-bottom:#ccc dashed 0px; display:inline-block;height:20px; line-height:20px; padding:5px; }
.listContainer_tjhm ul li:hover{width:188px;display:inline-block;height:20px; line-height:20px;padding:5px;}
.listContainer_tjhm ul li img{width:20px;height:20px; vertical-align:middle; margin-right:5px;}
.listContainer_tjhm ul li a{width:135px;height:20px; display:inline-block;margin-right:5px; float:left;color:#087dc8; font-size:14px; }
.listContainer_tjhm ul li a:hover{width:135px;height:20px; display:inline-block;margin-right:5px; float:left;color:#f76100; font-size:14px; }
.listContainer_tjhm ul li a:last-child{width:40px;height:20px; display:inline-block;margin-right:5px; float:right;color:#087dc8; font-size:14px;  text-align:center;}
.listContainer_tjhm ul li a:last-child:hover{width:40px;height:20px; display:inline-block;margin-right:5px; float:right;color:#f76100; font-size:14px; text-align:center; }</style>
<script type="text/javascript">
//我的收藏的操作
function setcardsc(_this,id, num, type) {
    //$.cookie('cardsc', null); 
    var varlist = [];
    var keyjson = { "id": id, "num": num, "type": type };
    varlist = $.cookie('cardsc');
    if (varlist != null) {
        varlist = jQuery.parseJSON(varlist);
    } else {
        varlist = [];
    }
    if (varlist.length >= 6) {
        if(confirm("当前收藏超过6个，你确定要替换以前的数据吗？")){
            varlist.splice(0, 1);
            if (iscardsc(varlist, id)) {
                varlist.push(keyjson);
                $.cookie('cardsc', JSON.stringify(varlist), { expires: 0 });
                getcardsc();
                $(_this).html("");
                $(_this).html("<img src=\"images/colIcon/329.png\">已收藏");
                $(_this).css("background-color", "#bbb");
            }
        }
     }else{
        if (iscardsc(varlist, id)) {
            varlist.push(keyjson);
            $.cookie('cardsc', JSON.stringify(varlist), { expires: 0 });
            getcardsc();
            $(_this).html("");
            $(_this).html("<img src=\"images/colIcon/329.png\">已收藏");
            $(_this).css("background-color", "#bbb");
        }
    }
}
function getcardsc() {
    var scul = "";
    var keyjson = $.cookie('cardsc');
    var varlist = jQuery.parseJSON(keyjson);
    if (varlist != null) {
        if (varlist.length > 0) {
            for (var i = 0; i < varlist.length; i++) {
                var imgurl = "images/shang_12.png";
                var types = varlist[i].type;
                var id = varlist[i].id;
                var num = varlist[i].num;
                if (types == 2) { imgurl = "images/shang_07.png"; } else if (types == 3) { imgurl = "images/shang_10.png"; } else { imgurl = "images/shang_12.png"; }
                //scul += '<li><a href="/aspx/zhw/cardinfo.aspx?cnum=' + num + '"><img src="' + imgurl + '" />' + num + '</a><a href=\"javascript:delcardsc(' + i + ')\"">删除</a></li>'
                scul += '<li><a href="/aspx/zhw/cardinfo.aspx?cnum=' + num + '">' + num + '</a><a href=\"javascript:delcardsc(' + i + ')\"">删除</a></li>'
            }
        }
    }
    $(".setcardsc").find("h2 span").html("");
    $(".setcardsc").find("h2 span").html("(" + ((varlist != null) ? varlist.length : 0) + ")");
    $(".setcardsc").find("ul").html("");
    $(".setcardsc").find("ul").html(scul);
}
function delcardsc(index) {
    var keyjson = $.cookie('cardsc');
    var varlist = jQuery.parseJSON(keyjson);
    if (varlist != null) {
        if (varlist.length > 0) {
            for (var i = 0; i < varlist.length; i++) {
                var types = varlist[i].type;
                var id = varlist[i].id;
                var num = varlist[i].num;
                $(".listProul_sc" + id).html("");
                $(".listProul_sc" + id).html("<img onload=\"ResultIscardsc(this," + id + ")\" src=\"images/colIcon/329.png\">收藏");
                $(".listProul_sc" + id).css("background-color", "#ef4520");
            }
            varlist.splice(index, 1);
            $.cookie('cardsc', JSON.stringify(varlist), { expires: 0 });
            getcardsc();
//            alert("删除成功！");
        }
    }
}
function iscardsc(varlist,id) {
    for (var i = 0; i < varlist.length; i++) {
        if (id == varlist[i].id) {
            return false;
        }
    }
    return true;
}
//我的浏览的操作
function setcardLL(id, num, type) {
    //$.cookie('cardsc', null); 
    var varlist = [];
    var keyjson = { "id": id, "num": num, "type": type };
    varlist = $.cookie('cardLL');
    if (varlist != null) {
        varlist = jQuery.parseJSON(varlist);
        if (varlist.length >= 6) {
            varlist.splice(0, 1);
        }
    } else {
        varlist = [];
    }
    
    if (iscardLL(varlist, id)) {
        varlist.push(keyjson);
        $.cookie('cardLL', JSON.stringify(varlist), { expires: 0 });
        getcardLL();
    } else {
    }
}
function getcardLL() {
    var scul = "";
    var keyjson = $.cookie('cardLL');
    var varlist = jQuery.parseJSON(keyjson);
    if (varlist != null) {
        if (varlist.length > 0) {
            for (var i = 0; i < varlist.length; i++) {
                var imgurl = "images/shang_12.png";
                var types = varlist[i].type;
                var id = varlist[i].id;
                var num = varlist[i].num;
                if (types == 2) { imgurl = "images/shang_07.png"; } else if (types == 3) { imgurl = "images/shang_10.png"; } else { imgurl = "images/shang_12.png"; }
                scul += '<li><a href="/aspx/zhw/cardinfo.aspx?cnum=' + num + '"><img src="' + imgurl + '" />' + num + '</a><a href=\"javascript:delcardLL(' + i + ')\"">删除</a></li>'
            }
        }
    }
    $(".setcardll").find("h2 span").html("");
    $(".setcardll").find("h2 span").html("(" + ((varlist != null)?varlist.length:0) + ")");
    $(".setcardll").find("ul").html("");
    $(".setcardll").find("ul").html(scul);
}
function delcardLL(index) {
    var keyjson = $.cookie('cardLL');
    var varlist = jQuery.parseJSON(keyjson);
    if (varlist != null) {
        if (varlist.length > 0) {
            varlist.splice(index, 1);
            $.cookie('cardLL', JSON.stringify(varlist), { expires: 0 });
            getcardLL();
//            alert("删除成功！");
        }
    }
}
function iscardLL(varlist, id) {
    for (var i = 0; i < varlist.length; i++) {
        if (id == varlist[i].id) {
            return false;
        }
    }
    return true;
}


function getcardsc2() {
    var scul = "";
    var keyjson = $.cookie('scang');
    var varlist = jQuery.parseJSON(keyjson);
    if (varlist != null) {
        if (varlist.length > 0) {
            for (var i = 0; i < varlist.length; i++) {
                //var imgurl = "images/shang_12.png";
                //var types = varlist[i].type;
                //var id = varlist[i].id;
                //var num = varlist[i].num;
                //if (types == 2) { imgurl = "images/shang_07.png"; } else if (types == 3) { imgurl = "images/shang_10.png"; } else { imgurl = "images/shang_12.png"; }
                //scul += '<li><a href="/aspx/zhw/cardinfo.aspx?cnum=' + num + '"><img src="' + imgurl + '" />' + num + '</a><a href=\"javascript:delcardsc(' + i + ')\"">删除</a></li>'
                scul += '<li><a href="/member/gouwuscdel/' + varlist[i].hao_llcs + '/'+ varlist[i].sc_id +'">'+varlist[i].hao_pinpai+'' + varlist[i].hao_title + '</a><a href=\"javascript:delcardsc(' + i + ')\"">删除</a></li>'
            }
        }
    }
    $(".setcardsc").find("h2 span").html("");
    $(".setcardsc").find("h2 span").html("(" + ((varlist != null) ? varlist.length : 0) + ")");
    $(".setcardsc").find("ul").html("");
    $(".setcardsc").find("ul").html(scul);
}
getcardsc2();
</script>
<div class="listContainer_left">
<div class="listContainer_tjhm setcardsc">
    <h2>我收藏过的号码<span>(0)</span></h2>
    <ul></ul>
</div>
<div class="listContainer_tjhm setcardll">
    <h2>我浏览过的号码<span>(0)</span></h2>
    <ul></ul>
</div>
        </div>
		

<?php if($question_list_show){?>
<div class="margin-top border radius padding-bottom" id="saybox" style="margin-top:10px;">
		<h3 class="border-bottom padding-top padding-left padding-bottom text-main border-dotted bg">
		<span class="icon-question-circle"></span> 客服咨询
		<a href="http://www.xuanhao.net/kefu/yidong/1" class="blue float-right" style="font-size:14px;margin-right:15px;">我要咨询</a>
		</h3>
	<div class="padding-top" style="height:450px;overflow:hidden" id="quotation">
		<ul>
		<?php foreach($question_list_show as $v){?>
		<dl class="clearfix">
			<dt><span class="haokefulie haokefuim_<?php echo $v['q_type'];?>"></span><a class="" target="_blank" href="<?php echo site_url('kefu/show/'.$v['id']);?>"><?php echo $v['q_title'];?></a></dt>
			<dd><div class="qbox margin-top text-little height-little">
				<span class="arrow"></span><?php echo cleanhtml(html_entity_decode(br2nl($v['q_content'])));?>
				<p class="text-right text-gray"><?php echo date('Y-m-d H:i:s',$v['q_time']);?></p>
				</div>
			</dd>			
		</dl>
		<?php }?>
		</ul>
	</div>
</div>


<script type="text/javascript">
$(function(){
	var scrtime;
	$("#quotation").hover(function(){
		clearInterval(scrtime);
	
	},function(){
	
	scrtime = setInterval(function(){
		var obj = $('#quotation ul dl').last();
		obj.hide();
		$('#quotation ul').prepend(obj);
		$('#quotation ul dl').first().slideDown(500);
	},5000);
	
	}).trigger("mouseleave");
	
var fixfox="fixedffs";
var rollSet = $('#saybox');// 检查对象，#sidebar-tab是要随滚动条固定的ID，可根据需要更改
var offset = rollSet.offset();
$(window).scroll(function () {
// 检查对象的顶部是否在游览器可见的范围内
var scrollTop = $(window).scrollTop();
if(offset.top < scrollTop && $(document).scrollTop() + $(window).height() < $(document).height()){
rollSet.addClass(fixfox);
}else{
rollSet.removeClass(fixfox);
}
});
});
</script>
<?php }?>
