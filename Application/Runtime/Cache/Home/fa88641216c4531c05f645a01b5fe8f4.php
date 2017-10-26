<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>业务新增汇总报表</title>
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
        <sapn class="head_title">业务新增汇总报表</sapn>
        <sapn class="head_tab">
            <span>按创建时间汇总</span>
            <span class="head_tab_show"  onclick="location='./yewuxinzenghuizong2'">按创建人汇总</span>
            <!--<span class="head_tab_show">按负责人汇总</span>-->
        </sapn>
    </div>
    <div id="shaixuan">
        <div class="textalign">
            <span class="sx_title">时间纬度：</span>
            <span class="sx_xx">本周</span>
            <span class="sx_xx">本月</span>
            <span class="sx_xx">今年</span>
            <span class="sx_time"></span>
        </div>
        <div>
            <span class="sx_title">创建人：</span>
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
        <div class="table_head">线索数：<?php echo ($topInfo[1]); ?>，客户数：<?php echo ($topInfo[2]); ?>，商机数：<?php echo ($topInfo[3]); ?>，合同数：<?php echo ($topInfo[4]); ?></div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>时间</th>
                <th>线索数</th>
                <th>客户数</th>
                <th>商机数</th>
                <th>合同数</th>
            </thead>
            <tbody>
              <?php echo ($tableHtml); ?>
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
                type : 'line'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data:['线索数','客户数','商机数','合同数']
        },
        grid: {
            left: '10px',
            right: '10px',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : [<?php echo ($chartXName); ?>]
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        dataZoom: [
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 0,      // 左边在 10% 的位置。
                end: 100         // 右边在 60% 的位置。
            },
            {   // 这个dataZoom组件，默认控制x轴。
                type: 'inside', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                start: 0,      // 左边在 10% 的位置。
                end: 100         // 右边在 60% 的位置。
            }
        ],
        series : [
            {
                name:'线索数',
                type:'line',
                data:[<?php echo ($chartValue1); ?>]
            },
            {
                name:'客户数',
                type:'line',
                data:[<?php echo ($chartValue2); ?>]
            },
            {
                name:'商机数',
                type:'line',
                data:[<?php echo ($chartValue3); ?>]
            },
            {
                name:'合同数',
                type:'line',
                data:[<?php echo ($chartValue4); ?>]
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    //myChart.showLoading();     //加载动画
    //显示选中的日期
    var selTime="<?php echo ($_GET['sx_1']); ?>";
    if(selTime!='')
    {
        var selIndex=parseInt(selTime)-1;
        $(".textalign").children(".sx_xx").eq(selIndex).addClass("sx_this");
    }
    else
    {
        $(".textalign").children(".sx_xx").eq(1).addClass("sx_this");
    }
    //监听筛选
    $(".textalign").children(".sx_xx").on("click",function(){
        layer.load(2);
        var thisindex=$(this).index();
        var now_sx=get_url_val(1);
        window.location=root_dir+"/index.php/Home/Report/yewuxinzenghuizong?sx_1="+thisindex+now_sx;
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
    var thisindex=dom.index("select")+2;
    var now_sx=get_url_val(thisindex);
    window.location=root_dir+"/index.php/Home/Report/yewuxinzenghuizong?sx_"+thisindex+"="+dom.val()+now_sx;
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