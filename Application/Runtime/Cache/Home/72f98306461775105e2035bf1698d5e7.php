<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>销售回款排名报表</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/echarts/echarts.min.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" media="all">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/main.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/time_axis.css">
<!--layUI-->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">

<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/datepicker.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/datepicker.js"></script>
<style>
    #table{margin-top:20px;}
    .sx_title{width:45px!important;margin-right:0px!important;padding-left:0px!important;}

    
</style>
</head>
<body>
<div id="box">
    <div id="head">
        <sapn class="head_title">销售回款排名报表</sapn>
    </div>
    <div id="shaixuan">
        <!--
        <div>
            <span class="sx_title">视角：</span>
            <span class="sx_xx">个人</span>
            <span class="sx_xx">部门</span>
        </div>
        -->
        <div>
            <span class="sx_title">时间：</span>
            <span id="time_select_group" class="uk-form" style="margin-left:0px;">
                <input type="text" class="start_time" data-uk-datepicker="{format:'YYYY-MM-DD'}" placeholder="开始日期" value="<?php echo ($sts); ?>" >
                <span class="mid_span">-</span>
                <input type="text" class="end_time" data-uk-datepicker="{format:'YYYY-MM-DD'}" placeholder="结束日期" value="<?php echo ($ste); ?>" >
                <button class="layui-btn cx_btn">查询</button>
            </span>
        </div>
    </div>
    <div id="table">
        <div class="table_head">
            <!--
            <select>
                <option value="0">请选择部门</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            
            <span id="daochu_group">
                <button class="layui-btn layui-btn-primary">导出</button>
            </span>
            -->
            <!--
            <span id="px_group" style="margin-bottom:10px;">
                <select name="" id="">
                    <option value="0">按回款金额排名</option>
                    <option value="0">按回款次数排名</option>
                </select>
            </span>
            -->
        </div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>排名</th>
                <th>姓名</th>
                <th>所在部门</th>
                <th>回款次数</th>
                <th>回款金额</th>
            </thead>
            <tbody>
               <?php echo ($dataTable); ?>
            </tbody>
        </table>
        <div id="zong">回款总金额：￥<?php echo ($zong); ?></div>
    </div>
</div>
</body>

<script>
//获取URL的绝对路径
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
var aaa=$("#right_window").html();
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 1000, 
        color:"#fff"
    });
}
$(function(){
    $('select').searchableSelect();
    /*
    var sx1="<?php echo ($_GET['sx_1']); ?>";
    
    if(sx1=='')
    {
        $(".sx_xx").eq(0).addClass("sx_this");
    }
    else
    {
        sx1=parseInt(sx1)-1;
        $(".sx_xx").eq(sx1).addClass("sx_this");
    }
    $("#shaixuan").find(".sx_xx").on("click",function(){
        $(this).parent().children(".sx_this").removeClass("sx_this");
        $(this).addClass("sx_this");
        var thisindex=$(this).index();
        var now_sx=get_url_val(1);
        window.location=root_dir+"/index.php/Home/Report/xiaoshouhuikuanpaiming?sx_1="+thisindex+now_sx;
    });
    */
    $(".cx_btn").on("click",function(){
        window.jiazai=layer.load(2);
        var s=$(this).parent().children(".start_time").val();
        var e=$(this).parent().children(".end_time").val();
        var s2=s.replace('-','').replace('-','');
        var e2=e.replace('-','').replace('-','');

        if(s==''||e=='')
        {
            tishi("开始时间和结束时间不能为空");
            layer.close(jiazai);
            return;
        }
        if(s2>e2)
        {
            tishi("开始时间不能大于结束时间");
            layer.close(jiazai);
            return;
        }
        var dateStr=s+','+e;
        window.location=root_dir+"/index.php/Home/Report/xiaoshouhuikuanpaiming?sx_1="+dateStr;
    });
});
</script>
</html>