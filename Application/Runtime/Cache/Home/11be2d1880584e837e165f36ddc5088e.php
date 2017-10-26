<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
<title>自定义筛选</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<!--layUI 插件 --弹窗设计 form表单样式 -->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--uikit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<style>
    *{margin:0;padding:0;}
    #box div{overflow:hidden;}
    a{text-decoration:none;cursor:pointer;}
    ul{list-style:none;}
    #box{padding-left:10px;padding-right:10px;}
    ul{margin:0;padding:0;}
    /*绿色提示窗和标题*/
    #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
    #mod1{background-color:#DFF0D8;height:100px;color:#255B56;padding-left:15px;padding-top:10px;padding-bottom:0px;border-radius:0px;}
    #mod1 div{height:22px;font-size:12px;}
    #hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
    .left-mar{padding-left:37px;}
    /*绿色提示窗结束*/
    /*数据模块*/
    #shengchengbtn{float:right;}
</style>
</head>

<body>
<div id="box">
    <!--头部文字-->
    <div id="mod-head">
    自定义筛选
    </div>
    <!--头部结束-->
    <!--中部提示-->
    <div id="mod1">
        <div>提示：1.字段筛选设置为启用，在系统其他模块筛选中会显示，未开启则不显示。<span id="hidden-div"><a onclick="hidden_div()">×</a></span></div>
        <div class="left-mar">2.修改完筛选设置后需要点击生成筛选模块按钮才能更新最新的筛选设置。</div>
        <div class="left-mar">3.如果修改了自定义业务字段或新增了产品信息，需要重新生成筛选。</div>
        <div class="left-mar">4.多条件筛选最多只能选择五个条件，自动区间最多只能生成10个区间。</div>
    </div>
    <!--中部结束-->
    <!--数据模块-->
    <div id="sx_list">
        <div class="layui-tab layui-tab-card" >
            <ul class="layui-tab-title">
                <li class="layui-this">产品</li>
                <li>其他</li>
            </ul>
            <div class="layui-tab-content" >
                <div class="layui-tab-item layui-show">
                    <div><button class="layui-btn" name="qybtn7" onclick="kqgb(this)">关闭筛选</button></div>
                    <div id="body7" style="display:none;">
                        <table class="layui-table uk-form" lay-skin="line">
                            <thead>
                                <th width="200px">字段名称</th>
                                <th width="200px">启用</th>
                                <th>筛选选项</th>
                            </thead>
                            <tbody>
                                <?php echo ($sxtable[7]); ?>
                            </tbody>
                        </table>
                        <span id='sj7'>上次生成时间：<?php echo ($sctime[7]); ?></span>
                        <span id="shengchengbtn"><button class="layui-btn layui-btn-radius layui-btn-normal" onclick="createmb(this)" >生成筛选模块</button><button class="layui-btn layui-btn-radius" onclick="bcbtn(this)">保存设置</button></span>
                    </div>
                </div>
                <div class="layui-tab-item">
                    敬请期待
                </div>
            </div>
        </div>
    </div>
    <!--数据模块结束-->
</div>
</body>
<script>
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
//上方绿色提示框的关闭效果
function hidden_div(){
    $("#mod1").hide();
}
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//ajax同步
$.ajaxSetup({
    async : false
});
//初始化layui的基础组件
layui.use('element', function(){
        var element = layui.element();
});
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 1000, 
    });
}
//显示
var qy=<?php echo ($qy); ?>;
for(a=1;a<8;a++)
{
    var bodynum=qy[a];
    if(bodynum=='1')
    {
        $("#body"+a).show();
    }
    else
    {
        $("button[name='qybtn"+a+"']").text("开启筛选");
    }
}
//区间数量显示隐藏
$("select").change(function(){
    if($(this).val()=='5')
    {
        $(this).parent().children(".qjspan").show();
    }
    else
    {
        $(this).parent().children(".qjspan").hide();
    }
});

//启用/不启用
function kqgb(thisdom)
{
    window.jiazai= layer.load(2);
    var thisname=$(thisdom).prop("name");
    var thisyewu=thisname.substr(5);
    var thistext=$(thisdom).text();
    if(thistext=='开启筛选')//当前是关闭状态需要开启
    {
        $.get(root_dir+"/index.php/Home/ShaixuanDo/sxqy",{"cval":'1',"thisyewu":thisyewu},function(res){
            layer.close(jiazai);
            if(res!='1')
            {
                tishi("开启失败，请稍后重试");
                return false;
            }
        });
        $(thisdom).text("关闭筛选");
        $("#body"+thisyewu).show();
    }
    else
    {
        $.get(root_dir+"/index.php/Home/ShaixuanDo/sxqy",{"cval":'0',"thisyewu":thisyewu},function(res){
            layer.close(jiazai);
            if(res!='1')
            {
                tishi("关闭失败，请稍后重试");
                return false;
            }
        });
        $(thisdom).text("开启筛选");   
        $("#body"+thisyewu).hide();
    }
}
//保存按钮
function bcbtn(thisdom)
{
    window.jiazai= layer.load(2);
    var thisid=$(thisdom).parent().parent().attr("id");
    var thisyewu=thisid.substr(4);
    var thisboxdom=$("#"+thisid).children("table").children("tbody").find("input[type='checkbox']");
    var qyid='';
    var thisboxname='';
    var selectval='';
    var qjnum='';
    var thisqjnum='';
    var thisselval='';
    var domlen=thisboxdom.length;
    for(a=0;a<domlen;a++)
    {
        if(thisboxdom.eq(a).prop("checked")==true)
        {
            thisboxname=thisboxdom.eq(a).prop("name")
            qyid+=thisboxname+',';
            thisselval=$(".ys"+thisyewu+"[name='"+thisboxname+"']").val();
            selectval+=thisselval+',';
            thisqjnum=$(".qj"+thisyewu+"[name='qjnum"+thisboxname+"']").val();
            if((thisqjnum<5||thisqjnum>50)&&thisselval=='5')
            {
                layer.close(jiazai);
                tishi("保存失败，区间数量必须在5到50之间");
                return false;
            }
            qjnum+=thisqjnum+',';
        }
    }
    qyid=qyid.substr(0,qyid.length-1);//zdy1
    selectval=selectval.substr(0,selectval.length-1);//123
    qjnum=qjnum.substr(0,qjnum.length-1);//123
    $.get(root_dir+"/index.php/Home/ShaixuanDo/bcsz",{"qyid":qyid,"selectval":selectval,"yewu":thisyewu,"qjnum":qjnum},function(res){
        layer.close(jiazai);
        if(res!="1")
        {
            tishi("保存失败");
        }
        tishi("保存成功");
    });
}
//生成筛选模板
function createmb(thisdom)
{
    window.jiazai= layer.load(2);
    var thisid=$(thisdom).parent().parent().attr("id");//内容ID
    var thisyewu=thisid.substr(4);//业务号

    $.get(root_dir+"/index.php/Home/ShaixuanDo/createmb",{"thisyewu":thisyewu},function(res){
        layer.close(jiazai);
        resarr=res.split("#");
        if(resarr[0]!='1')
        {
            tishi("生成失败，请稍后再试");
            return false;
        }
        tishi("操作成功");
        $("#sj"+thisyewu).text("上次生成时间："+resarr[1]);
    });
}
</script>
</html>