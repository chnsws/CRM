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
    <style>
        html,body{margin:0;padding:0;}
        #box{margin:10px;}
        #top{border-bottom:3px solid #1AA094;height:50px;line-height: 50px;font-size: 24px;color:#1AA094;font-weight: bold;margin-bottom:20px;}
        /*form*/
        form{width:600px;}
        form div{height:50px;line-height:50px;}
        .left,.right{float: left;margin-top:10px;}
        .left{width:100px;font-weight: bold;}
        .left:nth-child(7){height:100px;}
        .right:nth-child(8){height:100px;}
        .right{width:500px;}
        #feedback_type,#feedback_mod,#feedback_title{height:40px;line-height: 40px;width:500px;}
        #feedback_more{height:80px;line-height:14px;font-size: 14px;width:500px;margin-top:16px;resize:none;}
        #feedback_img{height:25px;line-height: 20px;margin-top:10px;}
        #feedback_submit{height:40px;line-height: 40px;border-radius: 5px;color:#fff;font-weight: bold;margin-top:10px;width:100px;}
        .btn{float: left;width:600px;border-top:1px solid #ccc;padding-top:20px;margin-top:20px;}
    </style>
</head>
<body>
<div id="box">
    <div id="top">
        问题反馈
    </div>
    <div id="body">
        <center>
        <form class="uk-form" method="post" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Fankui/feedback_to_db" enctype="multipart/form-data" >
            <div class="left">反馈标题：</div>
            <div class="right">
                <input type="text" id="feedback_title" name="feedback_title" placeholder="输入您的反馈标题（必填）" />
            </div>
            <div class="left">反馈模块：</div>
            <div class="right">
                <select id="feedback_mod" name="feedback_mod">
                    <option value="0">--请选择模块（必填）--</option>
                    <option value="1">线索</option>
                    <option value="2">客户</option>
                    <option value="3">客户公海</option>
                    <option value="4">联系人</option>
                    <option value="5">商机</option>
                    <option value="6">合同</option>
                    <option value="7">产品</option>
                    <option value="8">报表中心</option>
                    <option value="9">工作报告</option>
                    <option value="10">跟进记录</option>
                    <option value="11">知识库</option>
                    <option value="12">设置中心</option>
                    <option value="13">部门和用户设置</option>
                    <option value="14">角色和权限设置</option>
                    <option value="15">公司信息</option>
                    <option value="16">公告管理</option>
                    <option value="17">业绩目标</option>
                    <option value="18">客户公海（后台设置）</option>
                    <option value="19">工作报告</option>
                    <option value="20">自定义业务字段</option>
                    <option value="21">自定义业务参数</option>
                    <option value="22">自定义审批</option>
                    <option value="23">自定义筛选</option>
                    <option value="24">日志查询</option>
                    <option value="25">其他</option>
                    <option value="26">审批</option>
                </select>
            </div>
            <div class="left">反馈分类：</div>
            <div class="right">
                <select id="feedback_type" name="feedback_type">
                    <option value="0">--请选择分类（必填）--</option>
                    <option value="1">优化建议</option>
                    <option value="2">BUG提交</option>
                    <option value="3">逻辑有误</option>
                    <option value="4">运行速度</option>
                    <option value="5">其他</option>
                </select>
            </div>
            <div class="left">反馈详情：</div>
            <div class="right">
                <textarea name="feedback_more" id="feedback_more" placeholder="简述您需要反馈的问题（可选）"></textarea>
            </div>
            <div class="left">反馈图片：</div>
            <div class="right">
                <input type="file" name="feedback_img" id="feedback_img" />
            </div>
            <div class="left">反馈人：</div>
            <div class="right" style="text-align:left;">
                <?php echo ($_COOKIE['user_name']); ?>
            </div>
            <div class="left">反馈账号：</div>
            <div class="right" style="text-align:left;">
                <?php echo ($_COOKIE['user_phone']); ?>
            </div>
            <div class="btn"><center><input type="button" name="feedback_submit" id="feedback_submit" onclick="yanzheng()" class="layui-btn" value="提交反馈" /><?php echo ($listbtn); ?></center></div>
        </form>
        </center>
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


function yanzheng()
{
    window.jiazai=layer.load(2);
    if($("#feedback_title").val()=='')
    {
        layer.close(jiazai);
        tishi("请填写反馈标题");
        $("#feedback_title").css("border","1px solid #f00");
        return;
    }
    else
    {
        $("#feedback_title").css("border","1px solid #ddd");
    }
    if($("#feedback_mod").val()=="0")
    {
        layer.close(jiazai);
        tishi("请选择反馈模块");
        $("#feedback_mod").css("border","1px solid #f00");
        return;
    }
    else
    {
        $("#feedback_mod").css("border","1px solid #ddd");
    }
    if($("#feedback_type").val()=="0")
    {
        layer.close(jiazai);
        tishi("请选择反馈类型");
        $("#feedback_type").css("border","1px solid #f00");
        return;
    }
    else
    {
        $("#feedback_type").css("border","1px solid #ddd");
    }
    $("form").submit();
}

</script>
</html>