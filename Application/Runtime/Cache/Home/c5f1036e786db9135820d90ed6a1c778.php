<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>销售漏斗报表</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>

<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" media="all">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/main.css">
<!--layUI-->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/datepicker.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/datepicker.js"></script>
<!--漏斗-->
<script src="<?php echo ($_GET['public_dir']); ?>/highcharts/highcharts.js"></script>
<script src="http://cdn.hcharts.cn/highcharts/modules/funnel.js"></script>
<style>
    #chart{width:60%!important;overflow:visible!important;margin-top:10px;margin-bottom:10px;}
    .highcharts-background,.highcharts-point,.highcharts-root,.highcharts-container{overflow:visible!important;}
</style>
</head>
<body>
<div id="box">
    <div id="head">
        <sapn class="head_title">销售漏斗报表</sapn>
    </div>
    <div id="shaixuan">
        <div class="textalign">
            <span class="sx_title">预计签单日期：</span>
            <span class="sx_xx">全部</span>
            <span class="sx_xx">本周</span>
            <span class="sx_xx">本月</span>
            <span class="sx_xx">本季度</span>
            <span class="sx_xx">本年</span>
            <span class="sx_xx">自定义时间段</span>
        </div>
        <div style="display:none;">
            <span class="sx_title">请选择时间段：</span>
            <span id="time_select_group" class="uk-form top_line">
                <input type="text" class="start_time" placeholder="请选择开始时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                <span class="mid_span">-</span>
                <input type="text" class="end_time"  placeholder="请选择结束时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                <button class="layui-btn cx_btn">查询</button>
            </span>
        </div>
        <div>
            <span class="sx_title">所属部门：</span>
            <span class="sx_xx">
                <select>
                    <option value="0">请选择部门</option>
                    <?php echo ($bm_option); ?>
                </select>
            </span>
        </div>
        <div>
            <span class="sx_title">负责人：</span>
            <span class="sx_xx">
                <select>
                    <option value="0">请选择部门</option>
                    <?php echo ($user_option); ?>
                </select>
            </span>
        </div>
    </div>
    <center>
    <div id="chart" ></div>
    </center>
    <div id="table">
        <div class="table_head">商机单数：<?php echo ($zong_num); ?>，预计销售金额：¥ <?php echo ($zong_sum); ?>，概率金额：¥ <?php echo ($zong_sum_g); ?></div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>销售阶段</th>
                <th>商机数</th>
                <th>预计销售金额</th>
                <th>概率金额</th>
            </thead>
            <tbody>
                <?php echo ($data_table); ?>
                <tr>
                    <td colspan="4" style="text-align:center;">共7条</td>
                </tr>
            </tbody>
        </table>
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
    $('#chart').highcharts({
        chart: {
            type: 'funnel',
            backgroundColor:"#f7f7f7"
        },
        title: {
            text: ' '
        },
        plotOptions: {
            series: {
                
                neckWidth: '25%',
                neckHeight: '25%'
            }
        },
        legend: {
            enabled: false
        },
        series: [{
            name: '预计销售金额',
            data: [<?php echo ($chart); ?>]
        }]
    });
    /*
    //alert($("#chart").find("tspan").length)
    $("#chart").find("tspan").each(function(){
        $(this).css("overflow","visible")
    });
    */
    $(".highcharts-credits").hide();
    $(".highcharts-data-label").each(function(){
        var titledom=$(this).children("text").children("title");
        if(titledom.text()!='')
        {
            titledom.prev().text(titledom.text())
        }
    })

    $('select').searchableSelect();


    //筛选1初始化
    var sx1eq="<?php echo ($_GET['sx_1']); ?>"==''?'1':"<?php echo ($_GET['sx_1']); ?>";
    $(".textalign").children("span").removeClass("sx_this");
    sx1eq=sx1eq.length=='1'?sx1eq:6;
    $(".textalign").children("span").eq(sx1eq).addClass("sx_this");
    if(sx1eq==6)
    {
        
        var times="<?php echo ($_GET['sx_1']); ?>";
        times=times.split(',');
        $("#time_select_group").find(".start_time").val(times[0]);
        $("#time_select_group").find(".end_time").val(times[1]);
        $("#time_select_group").parent().show();
        
    }

    //自定义时间段的确认按钮
    $("#time_select_group").children("button").on("click",function(){
        window.jiazai=layer.load(2);
        var time1=$("#time_select_group").find(".start_time").val();
        var time2=$("#time_select_group").find(".end_time").val();
        if(time1==''||time2=='')
        {
            tishi("时间不能为空");
            layer.close(jiazai);
            return;
        }
        if(time1>time2)
        {
            tishi("开始时间不能大于结束时间");
            layer.close(jiazai);
            return;
        }
        
        var now_sx=get_url_val(1);
        window.location="./xiaoshouloudou?sx_1="+time1+','+time2+now_sx;
    });


    //显示自定义时间选择器的交互
    $(".textalign").children("span").on("click",function(){
        if($(this).index()==0)
        {
            return;
        }
        //alert(1);
        $(this).parent().children(".sx_this").removeClass("sx_this");
        $(this).addClass("sx_this");
        if($(this).index()==1)
        {
            layer.load(2);
            var now_sx=get_url_val(1);

            window.location="./xiaoshouloudou?sx_1="+now_sx;
        }
        else if($(this).text()=='自定义时间段')
        {
            $(this).parent().next().show();
        }
        else
        {
            layer.load(2);
            var ss=get_url_val(1);
            window.location="./xiaoshouloudou?sx_1="+$(this).index()+ss;
            $(this).parent().next().hide();
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
    var sel_index=dom.index("select")+2;
    var now_sx=get_url_val(sel_index);
    window.location="./xiaoshouloudou?sx_"+sel_index+"="+dom.val()+now_sx;
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
    if("<?php echo ($_GET['sx_4']); ?>"!=''&&"sx_"+without!='sx_4')
    {
        now_sx+="&sx_4="+"<?php echo ($_GET['sx_4']); ?>";
    }
    return now_sx;
}
</script>
</html>