<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>问题反馈</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--jquery-->
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
    <!--layUI 插件  form表单样式 table样式 -->
    <script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
    <!--UIkit-->
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
    <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
    <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/lightbox.js"></script>
    <style>
        html,body{margin:0;padding:0;}
        #box{margin:10px;}
        #top{border-bottom:3px solid #1AA094;height:50px;line-height: 50px;font-size: 24px;color:#1AA094;font-weight: bold;margin-bottom:20px;}
       
    </style>
</head>
<body>
<div id="box">
    <div id="top">
        问题反馈列表
    </div>
    <div id="body">
        <table class="layui-table" lay-skin="line">
            <thead>
                <th>标题</th>
                <th>模块</th>
                <th>图片</th>
                <th>内容</th>
                <th>类型</th>
                <th>反馈人</th>
                <th>反馈时间</th>
                <th>浏览器</th>
                <th>操作</th>
            </thead>
            <tbody>
                <?php echo ($tablestr); ?>
            </tbody>
        </table>
    </div>
</div>
</body>
<script>
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
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
$(function(){
    $(".layui-btn").on("click",function(){
        if($(this).prop("id").substr(0,2)=='wa')
        {
            if(!confirm("确认已完成这条反馈？")) return;
            var thisid=$(this).prop("id").substr(8);
            $.get(rooturl+"/index.php/Home/Fankui/change_act",{"fk_id":thisid,"act":"2"},function(res){
                window.location.reload();
            });
        }
        if($(this).prop("id").substr(0,2)=='hu')
        {
            if(!confirm("确认忽略这条反馈？")) return;
            var thisid=$(this).prop("id").substr(5);
            $.get(rooturl+"/index.php/Home/Fankui/change_act",{"fk_id":thisid,"act":"3"},function(res){
                window.location.reload();
            });
        }
    });
});

</script>
</html>