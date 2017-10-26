<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>业绩目标完成度报表</title>
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
<script src="<?php echo ($_GET['public_dir']); ?>/echarts/echarts.min.js"></script>
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
        <sapn class="head_title">业绩目标完成度报表</sapn>
    </div>
    <div id="shaixuan">
        <div>
            <span class="sx_title">时间：</span>
            <span class="sx_xx">
                <select>
                    <?php echo ($dateOption); ?>
                </select>
            </span>
        </div>
        <div class="textalign moredo">
            <span class="sx_title">业绩类型：</span>
            <?php echo ($sxName); ?>
        </div>
        <div>
            <span class="sx_title">部门和用户：</span>
            <span class="sx_xx">
                <select>
                    <option value="0">请选择部门</option>
                    <?php echo ($bm_option); ?>
                </select>
            </span>
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
        <div class="table_head"><?php echo ($tableTopTip); ?></div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>时间</th>
                <th>销售金额</th>
                <th>目标</th>
                <th>完成率</th>
            </thead>
            <tbody>
                <?php echo ($dataTable); ?>
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
            data:['销售金额','目标','完成率']
        },
        grid: {
            left: '10px',
            right: '10px',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
            }
        ],
        yAxis : [
            {
                type : 'value',
                name: '金额',
            },
            {
                type: 'value',
                name: '完成率',
                min: 0,
                max: 100,
                axisLabel: {
                    formatter: '{value} %'
                }
            }
        ],
        series : [
            {
                name:'销售金额',
                type:'bar',
                data:<?php echo ($chart2); ?>
            },
            {
                name:'目标',
                type:'bar',
                data:<?php echo ($chart1); ?>
            },
            {
                name:'完成率',
                yAxisIndex:1,
                type:'line',
                data:<?php echo ($chart3); ?>,
                tooltip :{
                    trigger: 'item',
                    formatter: "完成率 : {c} %"
                }
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    //myChart.showLoading();     //加载动画

    $(".textalign").children(".sx_xx").on("click",function(){
        var thisYjId=$(this).attr("name");
        if(thisYjId=='none')
        {
            return;
        }
        layer.load(2);
        var now_sx=get_url_val(2);
        window.location=root_dir+"/index.php/Home/Report/yejimubiaowanchengdu?sx_2="+thisYjId+now_sx;
    });

});
//监听下拉框改变
var sel_num=3;
function change_fun(dom)
{
    if(sel_num!=0)
    {
        sel_num--;
        return;
    }
    
    var thisindex=dom.index("select")=='0'?dom.index("select")+1:dom.index("select")+2;
    var now_sx=get_url_val(thisindex);
    window.location=root_dir+"/index.php/Home/Report/yejimubiaowanchengdu?sx_"+thisindex+"="+dom.val()+now_sx;
}
//获取URL中剩余的值，可以删除一个值
function get_url_val(without)
{
    var now_sx='';
    if("<?php echo ($_GET['sx_1']); ?>"!=''&&"sx_"+without!='sx_1')
    {
        now_sx+="&sx_1="+"<?php echo ($_GET['sx_1']); ?>";
    }
    if(without=='1')
    {
        without='2';
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