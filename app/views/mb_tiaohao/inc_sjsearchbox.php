<div style="background:#f9f9f9;height:100px;padding:5px 10px;border:1px solid #F2F2F2;border-radius:4px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:宋体;font-size:12px;">
    <tr>
        <td>
            <table class="stable" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td style="width:54px;"></td>
      </tr>
      <tr id="sdjqss_in">
        <td><input type="number" name="sn1" id="sn1" min="0" max="9" onkeyup="XinToNext(1)" oninput="checkTextLength(this, 1)" value="1" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn2" id="sn2" min="0" max="9" onkeyup="XinToNext(2)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn3" id="sn3" min="0" max="9" onkeyup="XinToNext(3)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn4" id="sn4" min="0" max="9" onkeyup="XinToNext(4)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn5" id="sn5" min="0" max="9" onkeyup="XinToNext(5)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn6" id="sn6" min="0" max="9" onkeyup="XinToNext(6)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn7" id="sn7" min="0" max="9" onkeyup="XinToNext(7)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn8" id="sn8" min="0" max="9" onkeyup="XinToNext(8)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn9" id="sn9" min="0" max="9" onkeyup="XinToNext(9)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn10" id="sn10" min="0" max="9" onkeyup="XinToNext(10)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td><input type="number" name="sn11" id="sn11" min="0" max="9" onkeyup="XinToNext(11)" oninput="checkTextLength(this, 1)" style="width:22px; height:22px;border:1px solid #ccc;border-radius:4px;" /></td>
        <td style="width:54px;"><a style="cursor:pointer;" onclick="goSearchsj();"><img src="<?php echo $viewmulu;?>/public/images/ss11.gif" width="54" height="28" /></a></td>
      </tr>     
    </table>
        </td>
    </tr>
  <tr height="35">
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="stables">
      <tr>
        <td><input name="stxt_haoma" style="width:100%;height:22px;border:1px solid #ccc;border-radius:4px;" id="stxt_haoma" type="number" /></td>
        <td><input type="checkbox" name="scbox" id="scbox" /> 尾数包含</td>
        <td style="width:54px;"><a style="cursor:pointer;" onclick="goSearchLikesj();"><img src="<?php echo $viewmulu;?>/public/images/ss22.gif" width="54" height="28" /></a></td>
        </tr>
    </table>
    </td>    
  </tr>
</table>
</div>
<SCRIPT type=text/javascript>
function checkTextLength(obj, length) {   
   if(obj.value.length > length)   {   
	   obj.value = obj.value.substr(0, length);   
   }   
}
function goSearchsj(){
    var sn="";
	var sn1=$("#sn1").val();
	if($("#sn1").val()==""||isNaN($("#sn1").val())){
		sn1="1";
	}
	var sn2=$("#sn2").val();
	if($("#sn2").val()==""||isNaN($("#sn2").val())){
		sn2="X";
	}
	var sn3=$("#sn3").val();
	if($("#sn3").val()==""||isNaN($("#sn3").val())){
		sn3="X";
	}
	var sn4=$("#sn4").val();
	if($("#sn4").val()==""||isNaN($("#sn4").val())){
		sn4="X";
	}
	var sn5=$("#sn5").val();
	if($("#sn5").val()==""||isNaN($("#sn5").val())){
		sn5="X";
	}
	var sn6=$("#sn6").val();
	if($("#sn6").val()==""||isNaN($("#sn6").val())){
		sn6="X";
	}
	var sn7=$("#sn7").val();
	if($("#sn7").val()==""||isNaN($("#sn7").val())){
		sn7="X";
	}
	var sn8=$("#sn8").val();
	if($("#sn8").val()==""||isNaN($("#sn8").val())){
		sn8="X";
	}
	var sn9=$("#sn9").val();
	if($("#sn9").val()==""||isNaN($("#sn9").val())){
		sn9="X";
	}
	var sn10=$("#sn10").val();
	if($("#sn10").val()==""||isNaN($("#sn10").val())){
		sn10="X";
	}
	var sn11=$("#sn11").val();
	if($("#sn11").val()==""||isNaN($("#sn11").val())){
		sn11="X";
	}
	
	sn=sn1+sn2+sn3+sn4+sn5+sn6+sn7+sn8+sn9+sn10+sn11;
    //location.href="<?php echo site_url("search/likea");?>/"+sitecityid+"/"+sn;
	location.href="<?php echo site_url("search/liket");?>/"+sitecityid+"/all/"+sn;
} 
function goSearchLikesj(){
    if($("#stxt_haoma").val()==""||isNaN($("#stxt_haoma").val())){
		layer.msg('请填写号码!并且只能是数字', {icon: 0,shade: [0.8, '#393D49'],time: 3000,shift:1}); 
        $("#stxt_haoma").focus();
        return;
    }
	if( $('input[name=scbox]').is(':checked')){
		var scbox=1;
	}else{
		var scbox=0;
	}
    location.href="<?php echo site_url("search/liket");?>/"+sitecityid+"/all/"+$("#stxt_haoma").val()+"/"+scbox;
}
 
function XinToNext(num){ 
	cur_num = "sn" + num;
	next_num = "sn" + (num + 1);
	theNum=document.getElementById(cur_num).value;
	if (theNum>="0" && theNum<="9"){
	if(document.getElementById(cur_num).value.length==1){
	document.getElementById(next_num).focus();
	document.getElementById(next_num).select();
	}
	}else
	{
	alert("对不起，请输入数字！");
	document.getElementById(cur_num).select();
	}			
}  
</SCRIPT> 