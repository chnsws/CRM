<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>客户数量排名报表</title>
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
        <sapn class="head_title">客户数量排名报表</sapn>
    </div>
    <div id="shaixuan">
        <div>
            <span class="sx_title">视角：</span>
            <span class="sx_xx sx_this">个人</span>
            <span class="sx_xx">部门</span>
        </div>
    </div>
    <div id="table">
        <div class="table_head">
            <select>
                <option value="0">请选择部门</option>
                <?php echo ($bm_option); ?>
            </select>
            <span id="time_select_group" class="uk-form">
                <input type="text" class="start_time" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo ($st); ?>">
                <span class="mid_span">-</span>
                <input type="text" class="end_time" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo ($et); ?>">
                <button class="layui-btn cx_btn">查询</button>
            </span>
            <!--
            <span id="daochu_group">
                <button class="layui-btn layui-btn-primary">导出</button>
            </span>
            -->
            <span id="px_group">
                <select name="" id="">
                    <option value="0">客户数降序</option>
                    <option value="1" <?php echo ($dx); ?> >客户数升序</option>
                </select>
            </span>
            
        </div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>排名</th>
                <th>姓名</th>
                <th>所在部门</th>
                <th>客户数</th>
            </thead>
            <tbody>
               <?php echo ($data_table); ?>

                <tr>
                    <td colspan="4" style="text-align:center;">共<?php echo ($data_table_num); ?>条</td>
                </tr>
            </tbody>
        </table>
        <div id="zong">客户总数：<?php echo ($zong); ?></div>
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
    $(".cx_btn").on("click",function(){
        var stime=$(this).parent().children(".start_time").val();
        var etime=$(this).parent().children(".end_time").val();
        
        if(stime==''||etime=='')
        {
            tishi("开始时间和结束时间不能为空");
            return;
        }
        if(stime>etime)
        {
            tishi("开始时间不能大于结束时间");
            return;
        }
        layer.load(2);
        var time_str=stime+','+etime;
        var now_sx=get_url_val(3);
        window.location="./kehushuliangpaiming?sx_3="+time_str+now_sx;
    });
    $("#shaixuan").children("div").children(".sx_xx").on("click",function(){
        $(".sx_this").removeClass("sx_this");
        $(this).addClass("sx_this");
        if($(this).index(".sx_xx")==1)
        {
            var now_sx=get_url_val(4);
            now_sx=now_sx.substr(1);
            layer.load(2);
            window.location="./kehushuliangpaiming2?"+now_sx;
        }
        else
        {
            var now_sx=get_url_val(4);
            now_sx=now_sx.substr(1);
            layer.load(2);
            window.location="./kehushuliangpaiming?"+now_sx;
        }
    });
});
var sel_num=2;
function change_fun(dom)
{
    if(sel_num!=0)
    {
        sel_num--;
        return;
    }
    layer.load(2);
    var sel_index=dom.index("select")+1;
    var now_sx=get_url_val(sel_index)
    window.location="./kehushuliangpaiming?sx_"+sel_index+"="+dom.val()+now_sx;
}
//获取URL中剩余的值，可以删除一个值
function get_url_val(without)
{
    var now_sx='';
    if("<?php echo ($_GET['sx_1']); ?>"!=''&&"sx_"+without!='sx_1')
    {
        now_sx+="&sx_1="+"<?php echo ($_GET['sx_1']); ?>";
    }
    if("<?php echo ($_GET['sx_2']); ?>"!=''&&"sx_"+without!='sx_2')
    {
        now_sx+="&sx_2="+"<?php echo ($_GET['sx_2']); ?>";
    }
    if("<?php echo ($_GET['sx_3']); ?>"!=''&&"sx_"+without!='sx_3')
    {
        now_sx+="&sx_3="+"<?php echo ($_GET['sx_3']); ?>";
    }
    return now_sx;
}
</script>
</html>