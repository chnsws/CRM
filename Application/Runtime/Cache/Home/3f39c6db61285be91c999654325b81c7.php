<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>产品销售汇总表</title>
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
</style>
</head>
<body>
<div id="box">
    <div id="head">
        <sapn class="head_title">产品销售汇总表</sapn>
        <sapn class="head_tab">
            <span>按产品汇总</span>
            <span class="head_tab_show" onclick="window.location='./chanpinxiaoshouhuizong2';">按分类汇总</span>
            <span class="head_tab_show" onclick="window.location='./chanpinxiaoshouhuizong3';">按时间汇总</span>
        </sapn>
    </div>
    <div id="shaixuan">
        <div class="textalign">
            <span class="sx_title">合同开始日期：</span>
            <span class="sx_xx">全部</span>
            <span class="sx_xx">今日</span>
            <span class="sx_xx">本周</span>
            <span class="sx_xx">本月</span>
            <span class="sx_xx">本季度</span>
            <span class="sx_xx">本年</span>
            <span class="sx_xx zdy_time_btn">自定义时间段</span>
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
            <span class="sx_title">产品分类：</span>
            <span class="sx_xx">
                <select>
                    <option value="0">全部</option>
                    <?php echo ($cpfl_option); ?>
                </select>
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
                    <option value="0">请选择用户</option>
                    <?php echo ($user_option); ?>
                </select>
            </span>
        </div>
    </div>
    <div id="chart"></div>
    <div id="table">
        <div class="table_head">总销量：<?php echo ($sum_xiaoliang); ?> ， 销售额：¥ <?php echo ($sum_sum); ?></div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>产品名称</th>
                <th>产品编号</th>
                <th>产品分类</th>
                <th>销量</th>
                <th>销售额</th>
                <th>平均单价</th>
            </thead>
            <tbody>
                <?php echo ($data_table); ?>
                
                
                <tr>
                    <td colspan="6" style="text-align:center;">共<?php echo ($data_table_max_num); ?>条</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>

<script>
//获取URL的绝对路径
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
//当前筛选
window.now_sx='';
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
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('chart'));

    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'line'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        color:["#48C9B3"],
        legend: {
            data:['销售额']
        },
        grid: {
            left: '10px',
            right: '10px',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : <?php echo ($cp_name_chart); ?>
            }
        ],
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 0,      // 左边在 10% 的位置。
                end: 60         // 右边在 60% 的位置。
            },
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'inside', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 0,      // 左边在 10% 的位置。
                end: 60         // 右边在 60% 的位置。
            }
        ],
        yAxis : [
            {
                type : 'value',
                name:"销售额",
                axisLabel: {
                    formatter: '￥{value}'
                }
            }
        ],
        series : [
            {
                name:'销售额',
                type:'bar',
                data:<?php echo ($cp_sum_chart); ?>
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    //myChart.showLoading();     //加载动画
    
    //筛选1初始化
    var sx1eq="<?php echo ($_GET['sx_1']); ?>"==''?'1':"<?php echo ($_GET['sx_1']); ?>";
    $(".textalign").children("span").removeClass("sx_this");
    sx1eq=sx1eq.length=='1'?sx1eq:7;
    $(".textalign").children("span").eq(sx1eq).addClass("sx_this");
    if(sx1eq==7)
    {
        var times="<?php echo ($_GET['sx_1']); ?>";
        times=times.split(',');
        $("#time_select_group").find(".start_time").val(times[0]);
        $("#time_select_group").find(".end_time").val(times[1]);
        $("#time_select_group").parent().show();
        
    }
    
    //显示自定义时间选择器的交互
    $(".textalign").children("span").on("click",function(){
        //alert($(this).index());
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

            window.location="./chanpinxiaoshouhuizong?sx_1="+now_sx;
        }
        else if($(this).text()=='自定义时间段')
        {
            $(this).parent().next().show();
        }
        else
        {
            layer.load(2);
            var ss=get_url_val(1);
            window.location="./chanpinxiaoshouhuizong?sx_1="+$(this).index()+ss;
            $(this).parent().next().hide();
        }
    });
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
        window.location="./chanpinxiaoshouhuizong?sx_1="+time1+','+time2+now_sx;
    });
});

//searchable的改变事件
var select_num=3;
function change_fun(dom)
{
    if(select_num!=0)
    {
        select_num--;
        return;
    }
    layer.load(2);
    var sxnum=(parseInt(dom.index("select"))+2);
    //alert(dom.val());
    var now_sx=get_url_val(sxnum);
    window.location="./chanpinxiaoshouhuizong?sx_"+sxnum+"="+dom.val()+now_sx;
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