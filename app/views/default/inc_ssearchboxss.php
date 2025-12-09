<div style="background: #FFFCE9;height:90px;padding:10px 20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:宋体;font-size:12px;">
    <tr>
        <td>
            <table class="stable" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="width:150px;"></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td style="width:20px;"></td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td style="width:65px;"></td>
        <td style="width:150px;"></td>
      </tr>
      <tr id="jqss_in" height="25">
          <td>固话号码精确检索</td>
        <td><input type="text" id="n1" size="3" maxlength="1" value="1" /></td>
        <td><input type="text" id="n2" size="3" maxlength="1" /></td>
        <td><input type="text" id="n3" size="3" maxlength="1" /></td>
        <td><input type="text" id="n4" size="3" maxlength="1" /></td>
        <td></td>
        <td><input type="text" id="n5" size="3" maxlength="1" /></td>
        <td><input type="text" id="n6" size="3" maxlength="1" /></td>
        <td><input type="text" id="n7" size="3" maxlength="1" /></td>
        <td><input type="text" id="n8" size="3" maxlength="1" /></td>
        <td><a style="cursor:pointer;" onclick="goSearch();"><img src="<?php echo $viewmulu;?>/public/images/ss11.gif" width="54" height="22" /></a></td>
        <td style="width:150px;"></td>
      </tr>     
    </table>
        </td>
    </tr>
  <tr height="35">
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="stables">
      <tr>
          <td style="width:240px;">注：按固话号所在位搜索 不确定请留空</td>
        <td><input name="txt_haoma" id="txt_haoma" type="text" /></td>
        <td><input type="checkbox" name="cbox" id="cbox" /> 尾数包含</td>
        <td style="width:65px;"><a style="cursor:pointer;" onclick="goSearchLike();"><img src="<?php echo $viewmulu;?>/public/images/ss22.gif" width="54" height="22" /></a></td>
        <td style="width:150px;"></td>
        </tr>
    </table>
    </td>    
  </tr>
</table>
</div>
<SCRIPT type=text/javascript>
<?php if($hao_type){?>
var type="<?php echo $hao_type;?>";
<?php }else{?>
var type=3;
<?php }?>
toNext();$("#n2").focus();
if(''!=''){
	var jqss=''.match(/./g);
	for(var i =0; i<jqss.length;i++){
		if(!isNaN(jqss[i]))
			$("#n"+(i+1)).val(jqss[i]);
	}
}
function goSearch(){
    var n="";
    for(var i=1;i<=8;i++){
        var v=$("#n"+i).val();
        if(isNaN(v)){
            layer.msg('请填写号码数字', {icon: 0,shade: [0.8, '#393D49'],time: 3000,shift:1}); 
            return;
        }
        n+=v==""?"X":v;
    }
    location.href="<?php echo site_url("search/likea");?>/"+sitecityid+"/"+n+"/"+type;
} 
function goSearchLike(){
    if($("#txt_haoma").val()==""||isNaN($("#txt_haoma").val())){
		layer.msg('请填写号码!并且只能是数字', {icon: 0,shade: [0.8, '#393D49'],time: 3000,shift:1}); 
        $("#txt_haoma").focus();
        return;
    }
	if( $('input[name=cbox]').is(':checked')){
		var cbox=1;
	}else{
		var cbox=0;
	}
    location.href="<?php echo site_url("search/likeb");?>/"+sitecityid+"/"+$("#txt_haoma").val()+"/"+cbox+"/"+type;
}
</SCRIPT> 