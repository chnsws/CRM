<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>报表中心</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<style>
*{margin:0;padding:0;}
html,body{height:100%;width:100%;background:#f7f7f7;}
#navv{width:200px;height:100%;position:fixed!important;}
#box{height:100%;width:100%;margin-left:200px;}
::-webkit-scrollbar{width:0px}
/*导航栏css*/
ul{background-color: #fff!important;width:200px;height:100%;position:fixed!important;}
li,dl,dd,a{width:200px!important;}
li{margin-bottom:0px;}
.layui-nav-item>a{background-color: #F1F9FE!important;color:#1AA094!important;font-weight: bold;text-decoration:none!important;}
dd a{background-color: #fff;color:#575757!important;text-decoration:none!important;}
dd a:hover{background-color: #f3f3f3!important;color:#1AA094!important;}
.layui-this>a{background:#E4EFEE!important;color:#1AA094!important;font-weight: bold;}
.layui-nav-bar{display: none!important;}
/*右边的窗口*/
#data_div{margin-left:210px;height:100%;}
#data_iframe{height:100%;width:100%;z-index:1001;border:none;}
</style>
</head>
<body>
<div id="navv" ></div>
<div id="data_div">
    <iframe id="data_iframe" src="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Report/genjinjilu"></iframe>
</div>
</body>
<script>
//获取URL的绝对路径
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
$(function(){
    $("#navv").load("<?php echo ($_GET['root_dir']); ?>/index.php/Home/Report/nav",function(){
        layui.use('element', function(){
            var element = layui.element();
        });
    });
    
    //$("#box").css("width",(parseInt($("body").css("width"))-210)+'px')
    
});
function r_to_page(file_name)
{
    document.getElementById("data_iframe").src=root_dir+"/index.php/Home/Report/"+file_name+".html";
}


</script>
</html>