<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>赢单商机汇总报表</title>
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
<style>
</style>
</head>
<body>
<div id="box">
    <div id="head">
        <sapn class="head_title">赢单商机汇总报表</sapn>
    </div>
    <div id="shaixuan">
        <div>
            <span class="sx_title">时间：</span>
            <span class="sx_xx">
                <select>
                    <?php echo ($year_option); ?>
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
        <div class="table_head">赢单金额：¥ 3,512,632.000000, 赢单数：18</div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>时间</th>
                <th>赢单数</th>
                <th>赢单数环比增长</th>
                <th>赢单金额</th>
                <th>赢单金额环比增长</th>
                <th>平均客单价</th>
            </thead>
            <tbody>
                <?php echo ($data_table); ?>
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
    $('select').searchableSelect();
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('chart'));

    // 指定图表的配置项和数据
    var option = {
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:['赢单数','金额']
        },
        color:["#F7A35C","#48C9B3"],
        grid: {
            left: '10px',
            right: '10px',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
            }
        ],
        yAxis : [
            {
                type : 'value',
                name:"赢单数"
            },
            {
                type: 'value',
                name: '金额',
                axisLabel: {
                    formatter: '￥ {value}'
                }
            }
        ],
        series : [
            {
                name:'赢单数',
                type:'line',
                data:<?php echo ($sj_num_chart); ?>
            },
            {
                name:'金额',
                type:'bar',
                yAxisIndex:1,
                data:<?php echo ($sj_sum_chart); ?>
            }
        ]
    };

// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);
    //myChart.showLoading();     //加载动画
});
var sel_num=3;
function change_fun(dom)
{
    if(sel_num!=0)
    {
        sel_num--;
        return;
    }
    var sx_num=dom.index("select")+1;
    var this_val=dom.val();
    var now_sx=get_url_val(sx_num);
    window.location="./yingdanshangjihuizong?sx_"+sx_num+"="+this_val+now_sx;
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