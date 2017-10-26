<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>跟进记录报表</title>
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
        <sapn class="head_title">跟进记录报表</sapn>
        <!--
        <sapn class="head_tab">
            <span>跟进对象</span>
            <span class="head_tab_show" onclick="">跟进类型</span>
        </sapn>
        -->
    </div>
    <div id="shaixuan">
        <!--
        <div class="textalign">
            <span class="sx_title">写跟进时间：</span>
            <span class="sx_xx">全部</span>
            <span class="sx_xx sx_this">今日</span>
            <span class="sx_xx">本周</span>
            <span class="sx_xx">本月</span>
            <span class="sx_xx">本季度</span>
            <span class="sx_xx">本年</span>
            <span class="sx_xx">自定义时间段</span>
            <span class="sx_time"></span>
        </div>
        -->
        <div class="textalign">
            <span class="sx_title">跟进时间：</span>
            <span class="sx_xx">全部</span>
            <span class="sx_xx">今日</span>
            <span class="sx_xx">本周</span>
            <span class="sx_xx">本月</span>
            <span class="sx_xx">本季度</span>
            <span class="sx_xx">今年</span>
            <!--<span class="sx_xx">自定义时间段</span>-->
            <span class="sx_time"></span>
        </div>
        <div>
            <span class="sx_title">跟进人：</span>
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
        <div class="table_head"><?php echo ($tableTopData); ?></div>
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>姓名</th>
                <th>所在部门</th>
                <th>跟进次数</th>
                <th>跟进线索次数</th>
                <th>跟进客户次数</th>
                <th>跟进商机次数</th>
                <th>跟进合同次数</th>
            </thead>
            <tbody>
                <?php echo ($tableData); ?>
            </tbody>
        </table>
    </div>
</div>
<div id="right_window">
    <!--跟进记录模块-->
    <!--
    <div class="gj_mod">
        <div class="gj_head">
            <div class="gj_head_point"></div>
            <div class="gj_head_date">2017-07-07</div>
        </div>
        <div class="gj_body">
            <div class="gj_body_icon"><i class="fa fa-phone"></i></div>
            <div class="gj_body_content">
                <div class="gj_body_content_head">
                    <img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />
                    徐淑红<i class="fa fa-caret-right"></i>电话
                </div>
                <div class="gj_body_content_content">这个有意向我，3月5日打电话</div>
                <div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div>
                <div class="gj_body_content_from">来自线索 张二</div>
                <div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div>
            </div>
        </div>
    </div>
    -->
    <!--跟进记录模块结束-->
   
    
    
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
            data:['跟进次数','跟进线索次数','跟进客户次数','跟进商机次数','跟进合同次数','aaa']
        },
        grid: {
            left: '10px',
            right: '10px',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : [<?php echo ($chartName); ?>]
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
                name:'跟进次数',
                type:'bar',
                data:[<?php echo ($chartValue1); ?>]
            },
            {
                name:'跟进线索次数',
                type:'bar',
                data:[<?php echo ($chartValue2); ?>]
            },
            {
                name:'跟进客户次数',
                type:'bar',
                data:[<?php echo ($chartValue3); ?>]
            },
            {
                name:'跟进商机次数',
                type:'bar',
                data:[<?php echo ($chartValue4); ?>]
            },
            {
                name:'跟进合同次数',
                type:'bar',
                data:[<?php echo ($chartValue5); ?>]
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    //myChart.showLoading();     //加载动画

    /*跟进记录详情弹出层
    var ssa='<div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div><div class="gj_mod"><div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">2017-07-07</div></div><div class="gj_body"><div class="gj_body_icon"><i class="fa fa-phone"></i></div><div class="gj_body_content"><div class="gj_body_content_head"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=57183681,2474253451&fm=117&gp=0.jpg" class="gj_headimg" />徐淑红<i class="fa fa-caret-right"></i>电话</div><div class="gj_body_content_content">这个有意向我，3月5日打电话</div><div class="gj_body_content_time">写跟进时间: 2016-03-01 15:11</div><div class="gj_body_content_from">来自线索 张二</div><div class="gj_body_content_button"><button class="layui-btn layui-btn-primary">评论</button></div> </div></div></div>';
    $("tbody tr td").on("click",function(e){
        window.jiazai=layer.load(2);
        e.stopPropagation();
        //如果现在没显示，就加载动画
        if($("#right_window").css("display")=='none')
        {
            $("#right_window").show("fast");
            setTimeout(function() {
                $("#right_window").html(ssa);
            }, 200);
        }
        layer.close(jiazai);
    });
    $("#right_window").on("click",function(e){
        e.stopPropagation();
    });
    $("body").on("click",function(){
        $("#right_window").hide("fast");
    });
    */
    //时间初始化
    var sx1="<?php echo ($_GET['sx_1']); ?>";
    sx1=sx1==''?1:sx1;
    sx1=parseInt(sx1)-1;
    $(".textalign").children(".sx_xx").eq(sx1).addClass("sx_this");
    //时间筛选
    $(".textalign").children(".sx_xx").on("click",function(){
        layer.load(2);
        var thisindex=$(this).index();
        var now_sx=get_url_val(1);
        window.location=root_dir+"/index.php/Home/Report/genjinjilu?sx_1="+thisindex+now_sx;
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
    window.location=root_dir+"/index.php/Home/Report/genjinjilu?sx_"+thisindex+"="+dom.val()+now_sx;
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