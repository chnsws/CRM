<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>公告管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--加载jQuery-->
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
    <!--datatable引用文件-->
    <link href="<?php echo ($_GET['public_dir']); ?>/datatable/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo ($_GET['public_dir']); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?php echo ($_GET['public_dir']); ?>/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/js/bootstrap.js" ></script>
    <script src="<?php echo ($_GET['public_dir']); ?>/datatable/js/dataTables.bootstrap.js"></script>
    <!--layUI 插件  弹窗设计 form表单样式 -->
    <script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
    <!--图标样式-->
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
    <style>
    *{margin:0;padding:0}
    a{text-decoration:none;cursor:pointer;color:#1AA094;margin-right:10px;}
    a:hover{color:#2F6F69;text-decoration:none;}
    #box{margin-left: 10px;margin-right: 10px;overflow:hidden;}
    /*头部页面名称*/
    #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
    /*按钮样式*/ 
    .add-gonggao{height:30px;width:90px;background-color:#1AA094;border:1px solid #1AA094;color:#fff;border-radius:3px;margin-right:10px;margin-bottom:10px;}
    #del-gonggao{height:30px;width:90px;background-color:#fff;border:1px solid #ccc;color:#666;border-radius:3px;margin-right:10px;margin-bottom:10px;}
    i{margin-right:5px;}
    /*表格样式*/
    .checkbox_row{width:10px;}
    /*新增公告时的表单*/
    #box-form{border:1px solid #ccc;height:600px;border-radius:5px;}
    #bfhead{background-color:#F5F5F5;height:40px;border-radius:5px;line-height:40px;padding-left:10px;}
    #formtable{width:1200px;height:400px;margin-top:20px;}
    #ggname{height:40px;width:100px;}
    #fabu_button{height:40px;}
    #fabu_button button{margin-top:10px;}
    .redstar{color:#f00;}
    .ggkejian{padding-top:10px;padding-bottom:10px;}
    
    </style>
<body>
    <div id="box">
        <!--页面名称-->
        <div id="mod-head">公告管理</div>
        <!--按钮-->
        <div id="box-button">
            <button class="add-gonggao" onclick="to_xinzeng()"><i class="fa fa-edit" aria-hidden="true" ></i>新增公告</button><button id="del-gonggao" onclick="delcheck()"><i class="fa fa-trash-o" aria-hidden="true" ></i>删除所选</button>
        </div>
        <!--表格-->
        <div id="box-table">
            <table id="table_local" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="checkbox_row"><input type="checkbox" title="全选" id="checkall" ></th>
                        <th>标题</th>
                        <th>阅读次数</th>
                        <th>发布人</th>
                        <th>发布时间</th>
                        <th>操作</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php echo ($gglist); ?>
                </tbody>
            </table>
        </div>
        <div id="box-form">
            <div id="bfhead">公告信息</div>
            <div id="bfbody">
                <center>
                <table id="formtable" >
                    <tr>
                        <td id="ggname" >公告名称<span class="redstar">*</span></td>
                        <td><input type='text' placeholder='公告名称' id='ggmc' autocomplete='off' class='layui-input'  /></td>
                    </tr>
                    <tr>
                        <td class="ggkejian" valign="top">可见范围<span class="redstar">*</span></td>
                        <td class="ggkejian">
                            <input type="radio" name="kjfw" value="1" title="" checked>全公司（系统中所有人可见）<br /><br />
                            <input type="radio" name="kjfw" value="2" title="" onclick="zhiding(1)">指定部门（指定哪几个部门可见）<br /><br />
                            <input type="radio" name="kjfw" value="3" title="" onclick="zhiding(2)">指定角色（指定角色可见）
                        </td>
                    </tr>
                    <tr>
                        <td id="ggcontent" valign="top">公告内容<span class="redstar">*</span></td>
                        <td><textarea id="demo" style="display: none;"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="fabu_button" align="center">
                            <button class="add-gonggao" id='fabubtn' onclick="fabu_end('1')">发布</button>
                            <button id="del-gonggao" onclick="fabu_end('0')">取消</button>
                        </td>
                    </tr>
                </table>
                </center>
            </div>
        </div>
    </div>
</body>
<div id="jusexuanze" class="layui-form" style="margin-left:20px;">

</div>
<div id="bumenxuanze" class="layui-form" style="margin-left:20px;">

</div>
<script>
    $("#jusexuanze").hide();
    $("#bumenxuanze").hide();
    window.root_dir="<?php echo ($_GET['root_dir']); ?>";
    $("#box-form").hide();
    $(function() {
    $("#table_local").dataTable({
        //lengthMenu: [5, 10, 20, 30],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。

        ordering: true,//是否启用排序
        searching: true,//搜索
        language: {
            lengthMenu: '<span id="pagefont">每页显示：</span><select class="form-control input-xsmall" id="pagenum">' + '<option value="5">5</option>' + '<option value="10">10</option>' + '<option value="20">20</option>' + '<option value="30">30</option>' + '<option value="40">40</option>' + '<option value="50">50</option>' + '</select>',//左上角的分页大小显示。
            search: '',//右上角的搜索文本，可以写html标签

            paginate: {
                previous: "首页",
                next: "下一页",
                first: "第一页",
                last: "末页"
            },

            zeroRecords: "没有内容",//table tbody内容为空时，tbody的内容。
            //下面三者构成了总体的左下角的内容。
            info: "",//左下角的信息显示，大写的词为关键字。
            infoEmpty: "",//筛选为空时左下角的显示。
            infoFiltered: "搜索到 _TOTAL_条记录"//筛选之后的左下角筛选提示，
        },
        paging: false,
        pagingType: "first_last_numbers",//分页样式的类型

        });
        $("#table_local_filter input[type=search]").css({ width: "auto" });//右上角的默认搜索文本框，不写这个就超出去了。
    });

    //加载layui表单样式
    layui.use('form', function(){
        window.form = layui.form();
    });
  
    //全选
    $("#checkall").click(function(){
        var nowstatus=$("input[type=checkbox]").prop("checked");

        if(nowstatus)
        {
            $("input[type=checkbox]").prop("checked",true);
            $(this).val("1");
        }
        else
        {
            $("input[type=checkbox]").prop("checked",false);
            $(this).val("0");
        }
    });
    //黑色半透明提示
    function tishi(neirong)
    {
        layer.msg(neirong, {
            time: 1000, 
        });
    }
    //layUI富文本编辑器初始化
    layui.use('layedit', function(){
        layedit = layui.layedit;
        window.areacontent=layedit.build('demo',{
             tool: ["strong","italic","underline","del","|","left","center","right","|","link","unlink","face"]
        }); //建立编辑器
    });
    //跳转到发布页面
    function to_xinzeng()
    {
        //初始化表单
        $("input[type='text']").val('');
        $("input[value='1']").prop('checked',true);
        $('#LAY_layedit_1').contents().find('body').html('');
        $("#fabubtn").attr("onclick","fabu_end('1')");
        $("#box-table").hide();
        $("#box-form").show();
    }
    //发布结束
    function fabu_end(isval)
    {
        if(isval>0)
        {
            var ggname=$("#ggmc").val();
            var ggfanwei=$("input[name='kjfw']:checked").val();
            var ggneirong=layedit.getContent(areacontent);
            if(ggname=='')
            {
                tishi("公告标题不能为空");
                return false;
            }
            if(ggname.length>20)
            {
                tishi("公告标题不能超过20个字");
            }
            if(ggfanwei==2)
            {
                var selid='bumenxuanze';
            }
            if(ggfanwei==3)
            {
                var selid='jusexuanze';
            }
            //指定部门或者指定角色的复选框中的值
            var spCodesTemp = "";
            if(ggfanwei!='1')
            {
                $('#'+selid).children("input:checked").each(function(i){
                    if(0==i){
                        spCodesTemp = $(this).val();
                    }
                    else
                    {
                        spCodesTemp += (","+$(this).val());
                    }
                });
            }
            $.post(root_dir+"/index.php/Home/GonggaoDo/gonggaoadd",{"ggname":ggname,"ggfanwei":ggfanwei,"ggneirong":ggneirong,"fanweicheck":spCodesTemp},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else if(res=='2')
                {
                    tishi("发布失败");
                }
                else
                {
                    tishi("发布失败，请刷新后重试");
                }
            });
        }
        $("#box-table").show();
        $("#box-form").hide();
    }
    window.bmone='0';
    window.jsone='0';
    //指定角色
    function zhiding(zd,c='1')
    {
        if(zd=='1')
        {
            if(bmone=='0')//部门列表每次刷新页面只获取一次，减少数据库访问
            {
                bmone='1';
                $.get(root_dir+"/index.php/Home/GonggaoDo/getbumen",{},function(res){
                    $("#bumenxuanze").html(res);
                    form.render('checkbox');
                });
            }
            xzname='选择部门';
            xzid="bumenxuanze";
        }
        if(zd=='2')
        {
            if(jsone=='0')//角色列表每次刷新页面只获取一次，减少数据库访问
            {
                jsone='1';
                $.get(root_dir+"/index.php/Home/GonggaoDo/getjuese",{},function(res){
                    $("#jusexuanze").html(res);
                    form.render('checkbox');
                });
            }
            xzname='选择角色';
            xzid="jusexuanze";
        }
        if(c=='1')
        {
            layui.use('layer', function(){
                var layer = layui.layer;
                window.tanchu=layer.open({
                    type:1,
                    offset: 't',
                    area:'300px',
                    title: xzname,
                    content:$('#'+xzid),
                    btn:"确定",
                    btn1:function(){
                        layer.close(tanchu);
                    }
                }); 
            });  
        }
    }
    //公告编辑
    function ggbianji(thisggid)
    {
        $("#box-table").hide();
        $("#box-form").show();
        //设置ajax同步执行
        $.ajaxSetup({
            async : false
        });
        $.get(root_dir+"/index.php/Home/GonggaoDo/getgginfo",{"ggid":thisggid},function(res){
            var resarr=res.split(',@,');
            window.editid=resarr[0];
            $("input[type='text']").val(resarr[1]);
            $("input[value='"+resarr[2]+"']").prop("checked",true);
            $('#LAY_layedit_1').contents().find('body').html(resarr[4]);
            $("#fabubtn").attr("onclick","editgg('"+resarr[0]+"','"+resarr[1]+"','"+resarr[2]+"','"+resarr[3]+"','"+resarr[4]+"')");
            
            window.bmjsarr=resarr[3].split(',');
            window.fw=resarr[2];
            if(resarr[2]=='2')
            {
                window.nameqz='bm';
                zhiding(1,0);
                window.tcid='bumenxuanze';
            }
            if(resarr[2]=='3')
            {
                window.nameqz='js';
                zhiding(2,0);
                window.tcid='jusexuanze';
            }
        });
        if(fw!=1)//如果范围不是全公司，就显示那些已选择的部门或角色
        {
            for(var a=0;a<bmjsarr.length;a++)
            {
                $("#"+tcid).children("input[name='"+nameqz+bmjsarr[a]+"']").prop("checked",true);
            }
            form.render("checkbox");
        }
    }
    //修改公告处理
    function editgg(thisggid,thisggname,thisggfw,thisggfwstr,thisggcontent)
    {
        var ggname=$("#ggmc").val();
        var ggfanwei=$("input[name='kjfw']:checked").val();
        var ggneirong=layedit.getContent(areacontent);
        if(ggname=='')
        {
            tishi("公告内容不能为空");
            return false;
        }
        if(ggname.length>20)
        {
            tishi("公告内容不能超过20个字");
        }
        if(ggfanwei==2)
        {
            var selid='bumenxuanze';
        }
        if(ggfanwei==3)
        {
            var selid='jusexuanze';
        }
        //指定部门或者指定角色的复选框中的值
        var spCodesTemp = "";
        if(ggfanwei!='1')
        {
            $('#'+selid).children("input:checked").each(function(i){
                if(0==i){
                    spCodesTemp = $(this).val();
                }
                else
                {
                    spCodesTemp += (","+$(this).val());
                }
            });
        }
        //如果没有进行任何修改，就直接跳回到主页面
        if(ggname==thisggname&&ggfanwei==thisggfw&&ggneirong==thisggcontent&&spCodesTemp==thisggfwstr)
        {
            location.reload();
            return false;
        }
        var ggneededitstr='';
        if(ggname!=thisggname)
        {
            ggneededitstr+='ggsz_name::'+ggname+',@,';
        }
        if(ggfanwei!=thisggfw)
        {
            ggneededitstr+='ggsz_kjfw::'+ggfanwei+',@,';
        }
        if(ggfanwei=='1')
        {
            ggneededitstr+="ggsz_kjid::,@,";
        }
        else
        { 
            if(spCodesTemp!=thisggfwstr)
            {
                ggneededitstr+='ggsz_kjid::'+spCodesTemp+',@,';
            }
        }
        if(ggneirong!=thisggcontent)
        {
            ggneededitstr+='ggsz_ggnr::'+ggneirong+',@,';
        }
        $.get(root_dir+"/index.php/Home/GonggaoDo/ggedit",{"ggeditid":thisggid,"ggeditstr":ggneededitstr},function(res){
            if(res=='1')
            {
                location.reload();
            }
            else if(res=='2')
            {
                tishi("发布失败");
            }
            else
            {
                tishi("发布失败，请刷新后重试");
            }
        });
    }
    //单条删除
    function ggshanchu(delggid,delggname)
    {
        layer.msg('是否确认删除本公告？', {
				time: 2000000, //20000s后自动关闭
				btn: ['确认删除', '取消'],
				btn1: function(index, layero){
                    $.get(root_dir+"/index.php/Home/GonggaoDo/ggdel",{"delstr":delggid,"deltype":'1',"delggname":delggname},function(res){
                        if(res=='1')
                        {
                            location.reload();
                        }
                        else if(res=='2')
                        {
                            tishi("删除失败");
                        }
                        else
                        {
                            tishi("删除失败，请刷新后重试");
                        }
                    });
                },
                btn2:function(index, layero){
                    layer.close(index);
                }
            }); 
    }
    //多条删除
    function delcheck()
    {
        var spCodesTemp='';
        $("#table_local td").children("input:checked").each(function(i){
            if(0==i){
                spCodesTemp = $(this).val();
            }
            else
            {
                spCodesTemp += (","+$(this).val());
            }
        });
        if(spCodesTemp=='')
        {
            return false;
        }
        var delnum=spCodesTemp.split(',').length;
        layer.msg('是否确认删除已选择的'+delnum+'条公告？', {
            time: 2000000, //20000s后自动关闭
            btn: ['确认删除', '取消'],
            btn1: function(index, layero){
                $.get(root_dir+"/index.php/Home/GonggaoDo/ggdel",{"delstr":spCodesTemp,"deltype":'2',"delggname":'0'},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("删除失败");
                    }
                    else
                    {
                        tishi("删除失败，请刷新后重试");
                    }
                });
            },
            btn2:function(index, layero){
                layer.close(index);
            }
        }); 
    }
    //公告置顶操作
    function ggzhiding(zdid,zdval)
    {
        $.get(root_dir+"/index.php/Home/GonggaoDo/ggzd",{"zdid":zdid,"zdval":zdval},function(res){
            if(res=='1')
            {
                location.reload();
            }
            else if(res=='2')
            {
                tishi("置顶失败");
            }
            else
            {
                tishi("置顶失败，请刷新后重试");
            }
        });
    }
</script>
</html>