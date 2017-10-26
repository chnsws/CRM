<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
<title>部门和用户设置</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<!--layUI 插件 弹窗设计 form表单样式 -->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>

<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/sortable.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/sortable.js"></script>
<style>
div ul{margin:0;padding:0;}
th i{color:#ccc;}
a{text-decoration:none;cursor:pointer;}
a:link {color: #1AA094}		
a:visited {color: #1AA094}
ul{list-style:none;}
body{height:auto;margin:0;background-color:#F7F7F7;}
/*div{border:1px solid #f00;}*/
#box{height:auto;}
#left-div{float:left;width:20%;height:auto;background-color:#fff;}
#left-top{height:40px;line-height:40px;color:#1AA094;padding-left:10px;font-weight:bold;background-color:#f2f2f2}

#left-body div{border:1px solid #B6B6B6;height:28px;line-height:28px;color:#6B6B6B;border-left:4px solid #828282;margin-top:5px;margin-bottom:5px;padding-left:5px;}
#fllist li{border:1px solid #B6B6B6;height:28px;line-height:28px;color:#6B6B6B;border-left:4px solid #828282;margin-bottom:5px;padding-left:5px;background-color:#fff;}
.lv1{margin-left:15px;}
.lv2{margin-left:30px;}
.lv3{margin-left:45px;}
.lv4{margin-left:60px;}
.lv5{margin-left:75px;}
.left-li{margin-left:5px;}
.right-span i{color:#1AA094}
.right-span{float:right;margin-right:5px;}

#right-div{float:left;width:100%;}
#right-top{margin-left:10px;height:60px;line-height:60px;border-bottom:1px solid #ccc;}
#right-body{margin:10px 10px 0 10px;}

#right-top span{color:#1AA094;font-weight:bold;font-size:22px;}
#right-top button{height:30px;line-height:30px;float:right;margin-right:10px;margin-top:20px;}
#rb-left{display: inline}
#rb-left button i{margin-right:5px;}
#rb-right{float:right;margin-top:10px;}
#rb-right button{height:30px;line-height: 30px;}

.cp_name_td{cursor:pointer;color:#1AA094;}

.link_span{cursor:pointer;color:#1AA094;margin-left:3px;margin-right:3px;}

#daorudiv{width:600px;margin-bottom:25px;}
.daoruhead{color:#60ADA5;background-color:#F7F7F7;padding:10px 0 10px 20px;}

#fenleisel{height:40px;width:500px;margin:10px 0 10px 0;}

#tabletishi{color:#828282;}
#addcpdiv{width:400px;padding:20px 50px 20px 50px;font-weight:bold;font-size:14px;}
#addcpdiv tr{height:50px;line-height:50px;}
#add_yc_div{color:#1AA094;}
#cpimg{width:120px;height:120px;}

#addcpdiv table{width:100%;}
#addcpdiv input{width:100%;}
#cp_jieshao{width:100%;height:90px;resize:none;line-height:20px;}
#addflsel{width:100%;}
.redstart{color:#f00;}
.add_left{width:100px;}

#cpfladddiv{width:100%;margin-top:20px;}
#cpfladddiv input{width:60%;}
#cpfltitle{font-weight:bold;margin-right:10px;}

.left_t{position:absolute;background-color:#fff;margin-left:40px;width:160px;}
.left_t_th{position:absolute;background-color:#F2F2F2;margin-left:40px;width:160px;}
#checkboxcss1{position:absolute;background-color:#F2F2F2;}
#checkboxcss2{position:absolute;background-color:#fff;}

.pxthcss{float:left;width:150px;text-align:center;background-color:#1AA094;cursor:pointer;margin:5px 5px 5px 5px;height:30px;line-height:30px;color:#fff;font-weight:bold;}
.pxdiv{margin:10px 50px 10px 50px;width:500px;}
.showoptiondiv{padding-left:58px;}

/*筛选*/
div,span{overflow:hidden;}
#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}

.sxdbtn{height:26px;line-height:26px;padding-left:10px;padding-right:10px;margin-left:10px;}
.sxzddiv_d .sxdbtn{margin-top:4px;}
.sxsea{height:26px;margin-top:5px;border-radius:3px;border:1px solid #ccc;}
.sxzddiv_w .sxdbtn{margin-bottom:2px;}
.sxzddiv_q .sxsea{width:60px;}
.sxzddiv_q .sxdbtn{height:28px;margin-bottom:2px;}


</style>
</head>
<body>
<div id="box">

    <!-- 抽屉式边栏 -->
    <div id="my-id" class="uk-offcanvas">
        <div class="uk-offcanvas-bar" style="background-color:#fff;">
            <div>
                <div id="left-top">产品分类</div>
                <div id="left-body">
                    <div id="user_company_name" class="lv-on" value="" onselectstart="return false">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                        <span class="left-li">产品分类</span>
                        <span class="right-span">
                            <a onclick='cpfladd(0)'><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a style='margin-right:5px;' onclick='cpflshowlist(0)'><i class='fa fa-reorder' aria-hidden='true'></i></a>
                        </span>
                    </div>
                    <ul id="fllist">
                        <?php echo ($bmlist); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!--产品列表-->
    <div id="right-div">
        <div id="right-top">
            <span>产品列表</span>
            <button class="layui-btn layui-btn-primary" onclick="daochu()">导出</button>
            <button class="layui-btn layui-btn-primary" onclick="daoru()">导入</button>
            <button class="layui-btn" onclick="cp_add()"><i class='fa fa-plus' aria-hidden='true'></i>新增产品</button>
        </div>
        <!--筛选区域-->
        <div id="sxdiv" >
            <div id="sxhidestr">筛选条件：全部</div>
            <!--<div id="sxzddiv" style="display: none">-->
            <div id="sxzddiv" style="display: none">
                <?php echo ($sxhtml); ?>
            <a style='margin-left:5px;color:#6B6B6B' onclick="sxqk()">清除筛选条件</a>
            </div>
        </div>
        <div id="sxshowbtn" onselectstart='return false' ><i class='fa fa-chevron-down' aria-hidden='true'></i></div>
        <!--筛选结束-->
        <div id="right-body">
            <div id="right-body-top" class="uk-form">
                <div id="rb-left">
                    <div data-uk-offcanvas="{target:'#my-id'}" style="position:fixed;top:100px;left:0px;z-index:999;background:#000;color:#fff;width:20px;opacity:0.40;text-align:center;padding:8px 0px;cursor:pointer;border-radius:0px 5px 5px 0px;font-size:10px;">产品分类</div>
                    <button class="layui-btn layui-btn-primary" onclick="pl_zhuanyi()"><i class='fa fa-edit' aria-hidden='true'></i>批量转移</button>
                    <button class="layui-btn layui-btn-primary" onclick="pl_qiyong()"><i class='fa fa-unlock' aria-hidden='true'></i>批量启用</button>
                    <button class="layui-btn layui-btn-primary" onclick="pl_jinyong()"><i class='fa fa-lock' aria-hidden='true'></i>批量禁用</button>
                    <button class="layui-btn layui-btn-primary" onclick="sel_del()"><i class='fa fa-trash' aria-hidden='true'></i>删除所选</button>
                    <button class="layui-btn layui-btn-primary" onclick="show_option()"><i class='fa fa-list-ul' aria-hidden='true'></i>视图设置</button>
                </div>
                
                <div id="rb-right" >
                    <select id="search_sel">
                        <?php echo ($searchoption); ?>
                    </select>
                    <input type="search" id="search_ipt" placeholder="请输入搜索内容">
                    <button class="layui-btn" onclick="searchfun()">搜索</button>
                </div>
            </div>
            <span id="tabletishi">提示：可以按住键盘Shift键并滑动鼠标滑轮来横向滑动列表</span>
            <div id="right-body-body" style="overflow-X:auto;height:77;width:100%;" >
                <table class="layui-table" id="main_table" style="display:none;" >
                    <thead>
                        <?php echo ($thstr); ?>
                    </thead>
                    <tbody>
                        <?php echo ($cplist); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
<!--导入弹出层-->
<div id="daorudiv" style="display: none">
    <div class="daoruhead">
        1.下载数据模板后，将要导入的数据填充到数据导入模板文件中，再进行上传导入。<br>
        2.模板中的表头不可更改，表头行不可删除。<br>
        3.单次导入的数据不超过4000条。
    </div>
    <div id="daorubody" class='layui-form' style="margin-left:10px;margin-top:10px;">
        <center><input type="file" name="csv_up" lay-type="file" class="layui-upload-file" id="imm"  /></center>
    </div>
    <div id="filebody" class="uk-alert" style="margin:10px;height:40px;line-height:40px;">
        <span id="filename" >12333333.txt</span>
        <span id="fileclose" style="cursor:pointer;float:right;" onclick="delnowfile(this)"><i class="layui-icon" style="font-size: 20px; color: #1E9FFF;">&#x1006;</i></span>
        <span id="filesize" style="float:right;margin-right:40px;">223.0K</span>
    </div>
    <span style="color:#828282;cursor:pointer;position:absolute;bottom:0px;right:15px;" onclick="open_dr_history()">查看导入记录</span>
</div>
<!--导入历史弹出层-->
<div id="daoru_history" style="width:580px;margin:0 10px 0 10px;padding:0;display:none">
    <table  class="layui-table" style="margin:0;padding:0;">
        <thead>
            <th>导入时间</th>
            <th>导入结果</th>
        </thead>
        <tbody>
    
        </tbody>
    </table>
</div>
<!--转移弹出层-->
<div id="zhuanyidiv" class="uk-form" style="display: none"> 
    <center>
    <select id="fenleisel">
        <?php echo ($cpfloption); ?>
    </select>
    </center>
</div>
<!--新增产品-->
<div id="addcpdiv" class="uk-form" style="display: none">
    <?php echo ($addlist); ?>
</div>
<!--添加产品分类弹出层-->
<div id="cpfladddiv" class="uk-form" style="display: none">
    <center>
        <span id="cpfltitle">分类名称：</span><input type="text" id="newflname">
    </center>
</div>
<div id="flidlist" style="margin-left:10px;margin-right:10px;display:none;">
    <table class='layui-table' id="fllisttable">
        <thead>
            <th>分类名称</th>
            <th>ID</th>
        </thead>
        <tbody>
            <?php echo ($flidlist); ?>
        </tbody>
    </table>
</div>
<!--显示设置-->
<div id="show_option_div" style="width:600px;display:none;" class='layui-form'>
    <div class='daoruhead showoptiondiv'>
        可以在这里设置列表中需要显示或隐藏的字段
    </div>
    <div class="pxdiv">
        <?php echo ($pxdiv); ?>
    </div>
</div>
<script>
$(".right-span").hide();
$("#daorudiv").hide();
$("#daoru_history").hide();
$("#zhuanyidiv").hide();
$("#add_yc_body").hide();
$("#cpimg").hide();
$("#addcpdiv").hide();
$("#cpfladddiv").hide();
$("#flidlist").hide();
$("#filebody").hide();
$("#show_option_div").hide();
$("#sxzddiv").hide();
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
window.nowpagepz=<?php echo ($pzjson); ?>;
window.nowpagepx=<?php echo ($pxzdjson); ?>;

var maintablewidth=$("#main_table").find("thead").find("th").length;
maintablewidth=parseInt(maintablewidth)*150;
$("#main_table").css("width",maintablewidth+'px');
$("#main_table").show();

$("li").attr("onselectstart","return false");//屏蔽双击选中
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//上传控件初始化
layui.use('upload', function(){
  layui.upload(options);
});
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 2000, 
    });
}
//筛选模块-------------------
$("#sxdiv").attr("onselectstart",'return false');
//是否开启
var kqsx="<?php echo ($kqsx); ?>";
if(kqsx=='1')
{
    $("#sxdiv").show();
    $("#sxshowbtn").show();
}
else
{
    $("#sxdiv").css("display","none");
    $("#sxshowbtn").css("display","none");
}
//筛选
$("#sxshowbtn").click(function(){
    if($(this).prop("name")=='0'||$(this).prop("name")==undefined)
    {
        $("#sxhidestr").hide("fast");
        $("#sxzddiv").show("fast");
        $(this).html("<i class='fa fa-chevron-up' aria-hidden='true'></i>");
        $(this).prop("name",'1');
    }
    else//隐藏筛选区域时更新筛选信息到筛选提示中
    {
        var sxdom=$("#sxzddiv").children("div");
        var fornum=sxdom.length;
        var tishi='';
        for(a=0;a<fornum;a++)
        {
            var thiseachclass=sxdom.eq(a).prop("class");
            var fdomindex=sxdom.eq(a).index();
            if(thiseachclass=='sxzddiv')
            {
                var thistitle1=sxdom.eq(a).find("div").eq(0).text();
                var thistext1=sxdom.eq(a).find("span[class='sx_yes']").text();
                tishi+=thistitle1+thistext1+'、'
            }
            
            if(thiseachclass=='sxzddiv_d')
            {
                var spandom2=sxdom.eq(a).find("span");
                var fornum2=spandom2.length;
                var indexstr2='';
                for(a2=0;a2<fornum2;a2++)
                {
                    if(spandom2.eq(a2).prop("class")=='sx_yes'&&spandom2.eq(a2).index()!='1')
                    {
                        indexstr2+=spandom2.eq(a2).text()+',';
                    }
                }
                indexstr2=indexstr2.substr(0,indexstr2.length-1);
                indexstr2=indexstr2==''?'全部':indexstr2;
                var thistitle2=sxdom.eq(a).find("div").eq(0).text();
                tishi+=thistitle2+indexstr2+'、'
            }
            if(thiseachclass=='sxzddiv_w')
            {
                var thistitle3=sxdom.eq(a).find("div").eq(0).text();
                var text3=sxdom.eq(a).find("input[type='search']").val();
                text3=text3==''?'全部':text3;
                tishi+=thistitle3+text3+'、'
            }
            if(thiseachclass=='sxzddiv_q')
            {
                var text1=sxdom.eq(a).find("input[type='number']").eq(0).val();
                var text2=sxdom.eq(a).find("input[type='number']").eq(1).val();
                if(text1==''||text2=='')
                {
                    sxdom.eq(a).find("span").eq(0).prop("class",'sx_yes');
                }
                var thistitle4=sxdom.eq(a).find("div").eq(0).text();
                var indexstr4=sxdom.eq(a).find("span").eq(0).prop("class")=='sx_yes'?sxdom.eq(a).find("span").eq(0).text():text1+"-"+text2;
                tishi+=thistitle4+indexstr4+'、'
            }
            
        }
        $("#sxhidestr").text("筛选条件："+tishi);
        $("#sxzddiv").hide("fast");
        $("#sxhidestr").show("fast");
        $(this).html("<i class='fa fa-chevron-down' aria-hidden='true'></i>");
        $(this).prop("name",'0');
    }
});
//筛选的选项（单选）
$(".sxzddiv").children("span").click(function(){
    $(this).parent().children("span").prop("class","sx_no");
    $(this).prop("class","sx_yes");
});

//筛选的选项（多选）
$(".sxzddiv_d").children("span").click(function(){
    if($(this).index()!=1)
    {
        $(this).parent().children("span").eq(0).prop("class","sx_no");
    }
    var thisclass=$(this).prop("class");
    //$(this).parent().children("span").prop("class","sx_no");
    if(thisclass=='sx_yes')
    {
        $(this).prop("class","sx_no");
    
    }
    else
    {
        $(this).prop("class","sx_yes");
    }
    var thisspandom=$(this).parent().find("span");
    var ssa=0;
    for(a=0;a<thisspandom.length;a++)
    {
        if(thisspandom.eq(a).index()!=1&&thisspandom.eq(a).prop("class")=='sx_yes')
        {
            ssa=1;
        }
    }
    if(ssa!=1)
    {
        $(this).parent().find("span").eq(0).prop("class",'sx_yes');
    }
});
$(".sxsea").change(function(){
    if($(this).val()!='')
    {
        $(this).parent().children("span").prop("class","sx_no");
    }
    else
    {
        $(this).parent().children("span").prop("class","sx_yes");
    }
});
$("#sxzddiv").find("span").click(function(){
    if($(this).parent().prop("class")!='sxzddiv') return false;
    sxfun();
});
$(".sxdbtn").click(function(){
    sxfun();
});
//获取筛选的所有元素
function sxfun()
{
    window.jiazai= layer.load(2);
    var sxdom=$("#sxzddiv").children("div");
    var fornum=sxdom.length;
    var ajaxstr='';
    for(a=0;a<fornum;a++)
    {
        var thiseachclass=sxdom.eq(a).prop("class");
        var fdomindex=sxdom.eq(a).index();
        
        if(thiseachclass=='sxzddiv')
        {
            var thisindex1=sxdom.eq(a).find("span[class='sx_yes']").index();
            var indexstr=thisindex1=='1'?'[1]':thisindex1;
            ajaxstr+="["+fdomindex+"]:["+indexstr+"],";
        }
        
        if(thiseachclass=='sxzddiv_d')
        {
            var spandom2=sxdom.eq(a).find("span");
            var fornum2=spandom2.length;
            var indexstr2='';
            for(a2=0;a2<fornum2;a2++)
            {
                if(spandom2.eq(a2).prop("class")=='sx_yes'&&spandom2.eq(a2).index()!='1')
                {
                    indexstr2+=spandom2.eq(a2).index()+',';
                }
            }
            indexstr2=indexstr2.substr(0,indexstr2.length-1);
            indexstr2=indexstr2==''?'[1]':indexstr2;
            ajaxstr+="["+fdomindex+"]:["+indexstr2+"],";
        }
        if(thiseachclass=='sxzddiv_w')
        {
            var text3=sxdom.eq(a).find("input[type='search']").val();
            var indexstr3=sxdom.eq(a).find("span").eq(0).prop("class")=='sx_yes'?'[1]':text3;
            ajaxstr+="["+fdomindex+"]:["+indexstr3+"],";
        }
        if(thiseachclass=='sxzddiv_q')
        {
            var text1=sxdom.eq(a).find("input[type='number']").eq(0).val();
            var text2=sxdom.eq(a).find("input[type='number']").eq(1).val();
            if(text1==''||text2=='')
            {
                sxdom.eq(a).find("span").eq(0).prop("class",'sx_yes');
            }
            var indexstr3=sxdom.eq(a).find("span").eq(0).prop("class")=='sx_yes'?'[1]':"["+text1+"]["+text2+"]";
            ajaxstr+="["+fdomindex+"]:["+indexstr3+"],";
        }
        
    }
    ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
    
    //alert(ajaxstr);return false;
    var px=JSON.stringify(nowpagepx);
    var pz=JSON.stringify(nowpagepz);
    $.post(root_dir+"/index.php/Home/Chanpin/shaixuan",{"ajaxstr":ajaxstr,"px":px,"pz":pz},function(res){
        //alert(res);
        $("#right-body-body").children("table").find("tbody").html(res);
        layer.close(jiazai);
    });
}
//清除筛选条件
function sxqk()
{
    window.location.reload();
}
//筛选模块结束------------
//部门列表上方公司名称点击事件
$(".lv-on").on("click",function(){
    var clicktext=$(this).text();
    if($(this).is("div"))//如果点击了DIV
    {
        if(!$(this).val())
        {
            $(this).children("i").removeClass("fa-folder-open");
            $(this).children("i").addClass("fa-folder");
            $(this).val('1');
            $(this).parent().children("ul").hide("fast");
        }
        else
        {
            $(this).children("i").removeClass("fa-folder");
            $(this).children("i").addClass("fa-folder-open");
            $(this).val('');
            $(this).parent().children("ul").show("fast");
        }
    }
});
//部门列表点击事件
function onshijian()
{
    $(".lv-on").on("click",function(){
        var clicktext=$(this).text();
        if(!$(this).is("div"))
        {
            var thisid=$(this).attr("id").substr(2);
            var hideFid='fid'+thisid;
            if($(this).val()=='1')
            {
                $(this).children("i").removeClass("fa-folder-open");
                $(this).children("i").addClass("fa-folder");
                $(this).css('border-left','4px solid #B7B7B7');
                $(this).val('0');
                var thislv=$(this).attr("name");
                $(".lv"+thislv+thisid).hide("fast");
                $(".lv"+thislv+thisid).val('0');
                $(".lv"+thislv+thisid).children("i").removeClass("fa-folder-open");
                $(".lv"+thislv+thisid).children("i").addClass("fa-folder");
                $(".lv"+thislv+thisid).css('border-left','4px solid #B7B7B7');	
            }
            else
            {
                $(this).children("i").removeClass("fa-folder");
                $(this).children("i").addClass("fa-folder-open");
                $(this).css('border-left','4px solid #828282');
                $(this).val('1');
                var thislv=$(this).attr("name");
                $(".lv"+thislv+thisid).show("fast");
                $(".lv"+thislv+thisid).val('1');
                $(".lv"+thislv+thisid).children("i").removeClass("fa-folder");
                $(".lv"+thislv+thisid).children("i").addClass("fa-folder-open");
                $(".lv"+thislv+thisid).css('border-left','4px solid #828282');
            }
        }
    });
    return '22';
}
onshijian();
//部门标签右边小图标的显示和隐藏
$(".lv-on").mouseover(function(){
    $(this).children(".right-span").show();
});
$(".lv-on").mouseout(function(){
    $(this).children(".right-span").hide();
});

//显示该分类的产品
function cpflshowlist(flid)
{
    var px=JSON.stringify(nowpagepx);
    var pz=JSON.stringify(nowpagepz);
    $.post(root_dir+"/index.php/Home/Chanpin/get_fl_cplist",{"clickflid":flid,"px":px,"pz":pz},function(res){
       $("#right-body-body").children("table").find("tbody").html(res);
    });
}

//全选/反选
$("#checkall").click(function(e){
    e.stopPropagation();
    if($(this).prop("checked")==true)
    {
        $(".tbbox").prop("checked",true);
    }
    else
    {
        $(".tbbox").prop("checked",false);
    }
});
//导出
function daochu()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:0,
            title: '全部导出',
            content:"是否导出全部产品数据？",
            yes:function(index,layero){
                window.location=root_dir+"/index.php/Home/Chanpin/daochu_data";
                layer.close(index);
            }
        }); 
    });  
}

//导入
function daoru()
{
    $("#filebody").hide();    
    var is_upload='';
    window.clickdelnowfile='0';
    get_dr_history();
    //显示文件上传按钮
    layui.upload({
        url: root_dir+"/index.php/Home/Chanpin/chanpin_csv_upload",
        title:"选择文件",
        before: function(input){
            //返回的参数item，即为当前的input DOM对象
            window.jiazai= layer.load(2);
            //tishi('文件上传中');
        },
        success: function(res){
            if(res['res']=='1')
            {
                $("#filename").text(res['oldname']);
                $("#filesize").text(res['newsize']);
                $("#filebody").show();
                $("#fileclose").prop("name",res['newname']);
                if(is_upload!='')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":"linshi/"+is_upload});
                }
                is_upload=res['newname'];
                layer.close(jiazai);
            }
            else if(res['res']=='2')
            {
                layer.close(jiazai);
                tishi("只支持CSV文件导入");
                return false;
            }
            else
            {
                layer.close(jiazai);
                tishi("文件上传失败，请刷新后重试");
            }
        },
    });

    layui.use('layer', function(){
        var layer = layui.layer;
        var daoruopen=layer.open({
            type:1,
            area:"600px",
            title: '产品导入',
            content:$("#daorudiv"),
            btn:["下载模板","产品分类id表","开始导入","取消"],
            btn1:function(index,layero){
                window.location=root_dir+"/index.php/Home/Chanpin/get_muban";
            },
            btn2:function(index,layero){
                var fenlei=layer.open({
                    type:1,
                    area:"300px",
                    title: '产品分类id表',
                    content:$("#flidlist"),
                    btn:"关闭",
                    btn1:function(){
                        layer.close(fenlei);
                    }
                }); 
            },
            btn3:function(index,layero){
                if(is_upload=='')
                {
                    tishi("请先选择需要导入的文件");
                    return false;
                }
                $.get(root_dir+"/index.php/Home/Chanpin/daoru_chanpin",{"csvfilename":is_upload},function(res){
                    if(res=='1')
                    {
                        $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":"linshi/"+is_upload});
                        location.reload();
                    }
                    else if(res=='4')
                    {
                        tishi("当前模板已失效，请下载最新模板再进行导入。");
                        return false;
                    }
                    else
                    {
                        tishi("导入失败，请刷新后重试");
                        return false;
                    }
                });
                layer.close(index);
            },
            btn4:function(index,layero){
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":"linshi/"+is_upload});
                }
                layer.close(index);
            },
             cancel: function(index, layero){ 
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":"linshi/"+is_upload});
                }
                layer.close(index);                
            }
        }); 
    });  
}

//取消当前选择的文件
function delnowfile(thisdom)
{
    clickdelnowfile='1';
    var thisdelname=$(thisdom).prop("name");
    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":"linshi/"+thisdelname});
    $(thisdom).parent().hide();
}

//导入历史
function open_dr_history()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            area:"600px",
            title: '导入记录',
            content:$("#daoru_history"),
            btn:"关闭",
            btn1:function(){
                layer.close(hisopen);
            }
        }); 
    });  
}

//删除所选
function sel_del()
{
    var sel_del_num=0;
    var sel_id='';
    $(".tbbox").each(function(){
        if($(this).prop("checked"))
        {
            sel_id+=$(this).prop("id")+',';
            sel_del_num++;
        }
    });
    if(sel_id=='')  return false;
    sel_id=sel_id.substr(0,sel_id.length-1);
    //var sel_del_num='20';
    layer.msg("是否删除所选的"+sel_del_num+"条记录<br>该操作成功后，将无法恢复", {
        time: 9999999,
        btn: ['确认删除', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/del_more",{"sel_id":sel_id},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else if(res=='2')
                {
                    tishi("删除失败");
                    return false;
                }
                else
                {
                    tishi("删除失败,请稍后重试");
                    return false;
                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}

//批量禁用
function pl_jinyong()
{
    var sel_del_num=0;
    var sel_id='';
    $(".tbbox").each(function(){
        if($(this).prop("checked"))
        {
            sel_id+=$(this).prop("id")+',';
            sel_del_num++;
        }
    });
    if(sel_id=='')  return false;
    sel_id=sel_id.substr(0,sel_id.length-1);
    //var sel_del_num='20';
    layer.msg("是否禁用所选的"+sel_del_num+"条记录？", {
        time: 9999999,
        btn: ['禁用', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/qy_jy",{"qyjy":0,"sel_id":sel_id},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else if(res=='2')
                {
                    tishi("修改失败");
                    return false;
                }
                else
                {
                    tishi("修改失败,请稍后重试");
                    return false;
                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//批量启用
function pl_qiyong()
{
    var sel_del_num=0;
    var sel_id='';
    $(".tbbox").each(function(){
        if($(this).prop("checked"))
        {
            sel_id+=$(this).prop("id")+',';
            sel_del_num++;
        }
    });
    if(sel_id=='')  return false;
    sel_id=sel_id.substr(0,sel_id.length-1);
    //var sel_del_num='20';
    layer.msg("是否启用所选的"+sel_del_num+"条记录？", {
        time: 9999999,
        btn: ['启用', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/qy_jy",{"qyjy":1,"sel_id":sel_id},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else if(res=='2')
                {
                    tishi("修改失败");
                    return false;
                }
                else
                {
                    tishi("修改失败,请稍后重试");
                    return false;
                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//批量转移
function pl_zhuanyi()
{
    var sel_del_num=0;
    var sel_id='';
    $(".tbbox").each(function(){
        if($(this).prop("checked"))
        {
            sel_id+=$(this).prop("id")+',';
            sel_del_num++;
        }
    });
    if(sel_id=='')  return false;
    sel_id=sel_id.substr(0,sel_id.length-1);
    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            area:"600px",
            title: '批量转移',
            content:$("#zhuanyidiv"),
            btn:["确认转移","取消"],
            btn1:function(){
                var newflid=$("#fenleisel").val();
                $.get(root_dir+"/index.php/Home/Chanpin/zhuanyi",{"newflid":newflid,"sel_id":sel_id},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return false;
                    }
                    else
                    {
                        tishi("修改失败,请稍后重试");
                        return false;
                    }
                });
                layer.close(hisopen);
            },
            btn2:function(){
                layer.close(hisopen);
            }
        }); 
    });  
}

//添加产品
function cp_add()
{
    var has_old_img='';
    $("#add_yc_div").show();
    $("#add_yc_body").hide();
    $("#addcpdiv").find("input").val('');
    $("#addcpdiv").find("textarea").val('');
    $("#addcpdiv").find("select").val('0');
    $("#cpimg").hide();
     //显示文件上传按钮
    layui.upload({
        url: root_dir+"/index.php/Home/Chanpin/cp_img_add",
        title:"选择图片",
        before: function(input){
            //返回的参数item，即为当前的input DOM对象
            window.jiazai= layer.load(2);
            //tishi('文件上传中');
        },
        success: function(res){
            if(res['res']=='1')
            {
                //tishi('更换成功');
                $("#cpimg").attr("src",root_dir+'/Public/chanpinfile/cpimg/'+res['newname']);
                $("#cpimg").show();
                if(has_old_img!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":has_old_img});
                }
                has_old_img=res['newname'];
                layer.close(jiazai);
            }
            else
            {
                layer.close(jiazai);
                tishi("图片上传失败");
            }
        },
    });


    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            offset: 't',
            area:"500px",
            title: '新增产品',
            fixed: false,
            content:$("#addcpdiv"),
            btn:["保存","取消"],
            btn1:function(){
                var addstr='';
                var trdom=$("#addcpdiv").find("tr");
                fornum=trdom.length;

                for(a=0;a<fornum;a++)
                {
                    var thisdom=$("#addcpdiv").find("tr").eq(a);
                    var thistagname=thisdom.find("td").eq(1).children().prop("tagName");//标签名
                    var thiszdyname=thisdom.find("td").eq(1).children().prop("name");//控件name
                    var thiszdyvalue=thisdom.find("td").eq(1).children().val();//控件值

                    //必填项
                    if(thisdom.find("td").eq(0).children("span").attr("class")=="redstart")
                    {
                        if(thistagname=="DIV")//图片上传
                        {
                            if(has_old_img=='')
                            {
                                tishi("必须上传一个产品图片");
                                return false;
                            }
                        }
                        else//text select textarea
                        {
                            if(thiszdyvalue=='')
                            {
                                tishi("必填项不能为空");
                                return false;
                            }
                        }
                    }//必填验证结束
                    if(thistagname=="DIV")//图片上传
                    {
                        addstr+="[zdy7]:["+has_old_img+"],";
                    }
                    else if(thistagname=='IMG')
                    {
                        continue;
                    }
                    else//text select textarea
                    {
                        addstr+="["+thiszdyname+"]:["+thiszdyvalue+"],"
                    }
                }
                addstr=addstr.substr(0,addstr.length-1);
                $.post(root_dir+"/index.php/Home/Chanpin/cp_add",{"addstr":addstr},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("添加失败");
                        return false;
                    }
                    else
                    {
                        tishi("添加失败，请刷新后重试");
                        return false;
                    }
                });
            },
            btn2:function(){
                if(has_old_img!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":has_old_img});
                }
                layer.close(hisopen);
            },
            cancel: function(index, layero){ 
                if(has_old_img!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":has_old_img});
                }
            }
        }); 
    }); 
}
//搜索
function searchfun()
{
    var sea_type=$("#search_sel").val();
    var sea_text=$("#search_ipt").val();
    var px=JSON.stringify(nowpagepx);
    var pz=JSON.stringify(nowpagepz);
    //alert(sea_text+sea_type);return false;
    $.post(root_dir+"/index.php/Home/Chanpin/searchfun",{"sea_type":sea_type,"sea_text":sea_text,"px":px,"pz":pz},function(res){
        $("#right-body-body").children("table").find("tbody").html(res);
    });
}

$("a").click(function(e){
    e.stopPropagation();
});
//点击展开更多时
function more_info()
{
    $("#add_yc_div").hide();
    $("#add_yc_body").show();
}
//点击产品名称时
function link_info(thisid)
{
    window.location=root_dir+"/index.php/Home/Chanpin/chanpininfo?cpid="+thisid;
}
//添加产品分类
function cpfladd(addfid)
{
    $("#newflname").val('');
    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            area:"500px",
            title: '添加产品分类',
            content:$("#cpfladddiv"),
            btn:["保存","取消"],
            btn1:function(){
                var newname=$("#newflname").val();
                if(newname=='')
                {
                    tishi("名称不能为空");
                    return false;
                }
                $.get(root_dir+"/index.php/Home/Chanpin/addfl",{"addfid":addfid,"newname":newname},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("添加失败");
                        return false;
                    }
                    else if(res=='3')
                    {
                        tishi("该分类已存在，请重新输入");
                        return false;
                    }
                    else
                    {
                        tishi("添加失败，请刷新后重试");
                        return false;
                    }
                });
            },
            btn2:function(){
                layer.close(hisopen);
            }
        }); 
    });  
}
//修改产品分类
function cpfledit(thisid)
{
    var thistext=$("#id"+thisid).text();
    $("#newflname").val(thistext);
    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            area:"500px",
            title: '修改产品分类',
            content:$("#cpfladddiv"),
            btn:["保存","取消"],
            btn1:function(){
                var newname=$("#newflname").val();
                if(newname==thistext)
                {
                    layer.close(hisopen);
                    return false;
                }
                if(newname=='')
                {
                    tishi("名称不能为空");
                    return false;
                }
                $.get(root_dir+"/index.php/Home/Chanpin/editfl",{"editid":thisid,"newname":newname},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return false;
                    }
                    else if(res=='3')
                    {
                        tishi("该分类已存在，请重新输入");
                        return false;
                    }
                    else
                    {
                        tishi("修改失败，请刷新后重试");
                        return false;
                    }
                });
            },
            btn2:function(){
                layer.close(hisopen);
            }
        }); 
    });  
}
//产品分类删除
function cpfldel(thisid)
{
    var thistext=$("#id"+thisid).text();
    layer.msg("删除该分类将同时删除该分类的下级分类，是否继续删除", {
        time: 9999999,
        btn: ['删除', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/delfl",{"delid":thisid,"delname":thistext},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else if(res=='2')
                {
                    tishi("删除失败");
                    return false;
                }
                else
                {
                    tishi("删除失败,请稍后重试");
                    return false;
                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//获得导入记录
function get_dr_history()
{
    $.get(root_dir+"/index.php/Home/Chanpin/get_dr_history",function(res){
        $("#daoru_history").children("table").find("tbody").html(res);
    });
}
$(".pxthcss").click(function(){
    var isclick=$(this).prop("lang");
    if(isclick=='1'||isclick==undefined)
    {
        $(this).prop("style","background-color:#ccc;");
        $(this).prop("lang",'0');
    }
    else
    {
        $(this).prop("style","background-color:#1AA094;");
        $(this).prop("lang",'1');
    }
});
//显示设置
function show_option()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        var hisopen=layer.open({
            type:1,
            area:"600px",
            title: '修改字段显示',
            content:$("#show_option_div"),
            btn:["保存","取消"],
            btn1:function(){
                var checkid='';
                $(".pxthcss").each(function(){
                    if($(this).prop("lang")=='1'||$(this).prop("lang")==undefined)
                        checkid+=$(this).prop("id")+',';
                });
                if(checkid=='')
                {
                    tishi("尚未选择需要显示的字段，请至少选择一个字段显示。");
                    return false;
                }
                $.post(root_dir+"/index.php/Home/Chanpin/show_option",{"checkid":checkid},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("保存失败");
                        return false;
                    }
                    else
                    {
                        tishi("保存失败，请刷新后重试");
                        return false;
                    }
                });
            },
            btn2:function(index){
                layer.close(index);
            }
        }); 
    });  
}
//表格排序
function table_px()
{
    $("th").css("cursor","pointer");//添加小手指针
    $("th").attr("onselectstart","return false");//屏蔽双击选中
    window.tdeq='';
    window.sorj='';
    $("th").click(function(){
        var thnum=$(this).index();
        if($(this).parent().parent().parent().parent().attr("id")!='daoru_history')
        {
            if(thnum=='0') return false;
            $("#checkall").prop("checked",false);
        }
        if($(this).parent().parent().parent().attr("id")=='fllisttable')
        {
            return false;
        }
        if(tdeq==''&&tdeq!=0)
        {
            tdeq=thnum;
            sorj='s';
        }
        else
        {
            if(tdeq==thnum)
            {
                if(sorj=='s')
                    sorj='j';
                else
                    sorj='s';
            }
            else
            {
                tdeq=thnum;
                sorj='s';
            }
        }
        $(this).parent().parent().parent().find("i").css("color","#ccc");
        $(this).children("i").css("color","#000");
        //修改表头箭头图标
        if(sorj=='s')
        {
            $(this).children("i").removeClass("fa-sort-down");
            $(this).children("i").addClass("fa-sort-up");
        }
        else
        {
            $(this).children("i").removeClass("fa-sort-up");
            $(this).children("i").addClass("fa-sort-down");
        }
        var tdarr=new Array();
        var trarr=new Array();
        var sxarr=new Array();
        var sxlen=0;
        var trdom=$(this).parent().parent().parent().children("tbody").find("tr");
        var trdomlen=trdom.length;
        //alert(trdomlen);
        for(aa=0;aa<trdomlen;aa++)
        {
            var thiscolstdtext=trdom.eq(aa).find("td").eq(thnum).html();

            if(trarr[thiscolstdtext]!=undefined)
            {
                trarr[thiscolstdtext]+='<tr>'+trdom.eq(aa).html()+'</tr>';
            }
            else
            {
                trarr[thiscolstdtext]='<tr>'+trdom.eq(aa).html()+'</tr>';
                sxlen=sxarr.length;
                sxarr[sxlen]=thiscolstdtext;
            }
        }
        /*
        $(this).parent().parent().parent().children("tbody").find("tr").each(function(){
            var thiscolstdtext=$(this).find("td").eq(thnum).html();
            if(trarr[thiscolstdtext]!=undefined)
            {
                trarr[thiscolstdtext]+='<tr>'+$(this).html()+'</tr>';
            }
            else
            {
                trarr[thiscolstdtext]='<tr>'+$(this).html()+'</tr>';
                arrnum++;
                tdarr[a]=thiscolstdtext;
                a++;
            }
        });
         sxarr.sort();
        */

        var lsv='';
        var ccc='';
        var isnum=0;
        var bb1='';
        var bb2='';
        sxlen=sxarr.length;
        for(d=1;d<sxlen;d++)
        {
            for(e=0;e<sxlen-d;e++)
            {
                ccc=parseInt(e)+1;
                bb1=isNaN(parseInt(sxarr[e]))?sxarr[e]:parseInt(sxarr[e]);
                bb2=isNaN(parseInt(sxarr[ccc]))?sxarr[ccc]:parseInt(sxarr[ccc]);
                
                bb1d=isNaN(bb1)?"0":sxarr[e].split('.').length;
                bb2d=isNaN(bb2)?"0":sxarr[ccc].split('.').length;

                bb1=bb1d=='2'?parseFloat(sxarr[e]):bb1;
                bb2=bb2d=='2'?parseFloat(sxarr[ccc]):bb2;

                if(isNaN(bb1)&&isNaN(bb2))
                {
                    bb1=sxarr[e].charCodeAt();
                    bb2=sxarr[ccc].charCodeAt();
                }
                var tm1=sxarr[e];
                var tm2=sxarr[ccc];
                var tmn1=tm1.split('-');
                var tmn2=tm2.split('-');
                if(tm1.split('-').length==3&&tmn1[0].length==4&&tmn1[1].length==2)
                {
                    bb1=tm1;
                }
                if(tm2.split('-').length==3&&tmn2[0].length==4&&tmn2[1].length==2)
                {
                    bb2=tm2;
                }

                //alert(bb1=='NaN')
                //alert(bb1+'>'+bb2);
                //alert(bb1>bb2);
                if(bb1>bb2)
                {
                    isnum=1;
                    lsv=sxarr[parseInt(e)+1];
                    sxarr[parseInt(e)+1]=sxarr[e];
                    sxarr[e]=lsv;
                }
            }
        }
        if(sorj=='j')
        {
           sxarr.reverse();
        }
        var newtable='';
        arrnum=sxarr.length;
        for(aa=0;aa<arrnum;aa++)
        {
            newtable+=trarr[sxarr[aa]];
        }
        $(this).parent().parent().parent().children("tbody").html(newtable);
    });
}
table_px();
</script>
</html>