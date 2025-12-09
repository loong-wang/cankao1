$(function(){

//获取输入信息
    function get_inputs() {
        var dbhost = $("#dbhost").val();
        var dbport = $("#port").val();
        var dbuser = $("#dbuser").val();
        var dbpwd = $("#dbpsw").val();
        var dbname = $("#dbname").val();
            
        if (! dbhost || ! dbuser || ! dbname || ! dbhost || ! port) {
            $("#testdb").html('<div style="color: brown; font-weight: bolder;">数据库信息错误</div>');
            return false;
        }

        return {dbhost:dbhost,dbport:dbport,dbuser:dbuser,dbpwd:dbpwd,dbname:dbname};
    }

    //检测数据库信息
    $("#check").click(function(){
        var obj = get_inputs();
        if (!obj) return false;
    })

    //填写数据库名及离开焦点后
    $("#dbname").blur(function(){
        var obj = get_inputs();
        if (!obj) return false;

        var url = baseurl+'index.php/install/testdb'+'/' + obj.dbhost +'/' + obj.dbuser +'/' + obj.dbpwd +'/' + obj.dbname + '/' + obj.dbport;
       $.ajax({
            url: url,
            success: function(data) {
                var obj = JSON.parse(data);
                var fcolor = 'red';
                var cr_dis = true;  //新建数据库选项
                var cr_sel = false;
                if (obj.code == '200') {
                    fcolor = "green";
                } else if (obj.code == '1049') {
                    obj.msg = "请检测数据库是否存在或者连接是否正确";
                    cr_dis = false;
                    cr_sel = true;
                }

                $("#dbcreate").attr("disabled", cr_dis);  //禁用
                $("#dbcreate").attr("checked", cr_sel);  //选中
                //if (cr_sel == true) obj.msg = "将启用新数据库安装";
                $("#testdb").html('<div style="color: ' + fcolor + '; font-weight: bolder;">' + obj.msg + '</div>');
			}
		});
    });
});