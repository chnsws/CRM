<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>自定义业务字段</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--jquery-->
    <script src="/Public/jquery/jquery.js"></script>
    <!--public.js-->
    <script src="/Public/public.js"></script>
    <!--layui-->
    <script src="/Public/layui2.0/layui.js"></script>
    <link rel="stylesheet" href="/Public/layui2.0/css/layui.css">
    
    <!--uikit-->
    <link rel="stylesheet" href="/Public/uikit/css/uikit.almost-flat.min.css" />
    <script src="/Public/uikit/js/uikit.min.js"></script>
    
    <link rel="stylesheet" href="/Public/uikit/css/components/sortable.css" />
    <script src="/Public/uikit/js/components/sortable.js"></script>
    <!--yewuziduan.css-->
    <link rel="stylesheet" href="/Public/option/yewuziduan.css">
</head>
<body>
    <div id="box">
        <!--头部文字-->
        <div id="mod-head">
            自定义业务字段
        </div>
        <!--头部结束-->
        <!--中部提示-->
        <div id="mod1">
            <div>
                提示：1.字段设置为启用，在系统中显示此字段和字段对应的数据；如果未启用则不显示。
                <span id="hidden-div">
                    <a onclick="hidden_div()">×</a>
                </span>
            </div>
            <div class="left-mar">
                2.字段设置为必填，在系统中新增编辑时显示*，必须填写或选择后才能保存。
            </div>
            <div class="left-mar">
                3.字段设置为常用，在系统中新增编辑时默认直接显示；如果没有勾选则需展开后才能显示。
            </div>
            <div class="left-mar">
                4.每个功能模块中，最多可添加15个自定义字段和最多支持8个区块。
            </div>
        </div>
        <!--中部结束-->
        <div id="mod2">
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                <ul class="layui-tab-title">
                    <li class="layui-this">线索</li>
                    <li>客户</li>
                    <li>联系人</li>
                    <li>商机</li>
                    <li>合同</li>
                    <li>产品</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <button class="layui-btn add_zd">新增字段</button>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                            
                            
                        </ul>
                    </div>
                    <div class="layui-tab-item">
                        <button class="layui-btn add_zd">新增字段</button>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                        </ul>
                    </div>
                    <div class="layui-tab-item">
                        <button class="layui-btn add_zd">新增字段</button>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                                    
                            
                        </ul>
                    </div>
                    <div class="layui-tab-item">
                        <button class="layui-btn add_zd">新增字段</button>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                                    
                            
                        </ul>
                    </div>
                    <div class="layui-tab-item">
                        <button class="layui-btn add_zd">新增字段</button>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                            
                        </ul>
                    </div>
                    <div class="layui-tab-item">
                        <button class="layui-btn add_zd">新增字段</button>
                        <select id="cpfl_select"></select>
                        <div style="height:20px;"></div>
                        <ul class="uk-sortable" data-uk-sortable="{handleClass:'uk-icon-bars'}" >
                            
                        </ul>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</body>
<div id="addzddiv">
    <div>
        <span>字段名称:</span>
        <span><input type="text" placeholder="字段名称（不超过10个字符）" id="zdnameinput" /></span>
    </div>
</div>
<script>
window.loadArr=new Array();
loadArr[1]=0;
loadArr[2]=0;
loadArr[4]=0;
loadArr[5]=0;
loadArr[6]=0;
loadArr[7]=0;
window.cpfl=0;
$(function(){
    //初始化layui
    layui.use('layer', function(){
        window.layer = layui.layer;
        window.jiazai=loading();
    });
    layui.use('element', function(){
        var element = layui.element;
    });
    //加载层
    $("#box").fadeIn("fast");
    getData(1);
    $(".layui-tab-title").children("li").on("click",function(){
        var thisindex=$(this).index("li");
        var thismod=thisindex<2?thisindex+1:thisindex+2;
        if(thismod!='7')
        {
            if(loadArr[thismod]=='1')
            {
                return;
            }
            else
            {
                window.jiazai=loading();
                getData(thismod);
            }
        }
        else
        {
            if(cpfl=='0')
            {
                window.jiazai=loading();
                //获得产品分类下拉框
                $.get("/index.php/Home/Yewuziduan/get_cpfl_option",function(res){
                    var resarr=JSON.parse(res);
                    var cpfl_option='';
                    for(flk in resarr)
                    {
                        cpfl_option+='<option value="'+resarr[flk]['key']+'">'+resarr[flk]['name']+'</option>';
                    }
                    $("#cpfl_select").html(cpfl_option);
                    $("#cpfl_select").show();
                    $("#cpfl_select").on("change",function(){
                        window.jiazai=loading();
                        var flid=$(this).val();
                        getData('7,'+flid);
                    });
                    cpfl=1;
                    var first_fl=$("#cpfl_select").val();
                    getData('7,'+first_fl);
                });
            }
        }
    });
    $(".add_zd").on("click",function(){
        $("#zdnameinput").val('');
        layer.open({
            type:1,
            area:"500px",
            title: '新增字段',
            content:$("#addzddiv"),
            btn:["保存","取消"],
            btn1:function(index){
                var newname=$("#zdnameinput").val();
                var thisindex=$(".layui-show").index();
                var thismod=thisindex<2?thisindex+1:thisindex+2;
                if(thismod=='7')
                {
                    thismod=thismod+","+$("#cpfl_select").val();
                }
                if(newname=='')
                {
                    tishi("字段名不能为空");
                    return;
                }
                if(newname.length>10)
                {
                    tishi("字段名过长");
                    return;
                }
                window.jiazai=loading();
                $.get("/index.php/Home/Yewuziduan/addzd",{"thismod":thismod,"newname":newname},function(res){
                    layer.close(jiazai);
                    if(res=='1')
                    {
                        tishi("保存成功");
                        getData(thismod);
                    }
                    else if(res=='2')
                    {
                        tishi("保存失败，该字段已存在");
                    }
                    else
                    {
                        tishi("保存失败，请稍后重试");
                    }
                    layer.close(index);
                });
            },
            btn2:function(index){
                layer.close(index);
            }
        }); 
    });
});
function getData(type)
{
    //获取数据
    $.get("/index.php/Home/Yewuziduan/get_zd_list",{"zdtype":type},function(res){
        layer.close(jiazai);
        var zdarr=JSON.parse(res);
        var zdstr='';
        for(zdk in zdarr)
        {
            var qy=zdarr[zdk]['qy']=='1'?'checked':'';
            var bt=zdarr[zdk]['bt']=='1'?'checked':'';
            var cy=zdarr[zdk]['cy']=='1'?'checked':'';
            var bj=zdarr[zdk]['bj']=='1'?'<a class="bj">编辑</a>&nbsp;&nbsp;<a class="sc">删除</a>':'不可修改';
            var disabled=zdarr[zdk]['bj']=='1'?'':'disabled';

            zdstr+='<li clss="uk-sortable-item" id="'+zdk+'"><div><span><i class="uk-icon-bars"></i></span><span>'+zdarr[zdk]['name']+'</span><span><input name="qy" type="checkbox" '+qy+' '+disabled+' />启用</span><span><input name="bt" type="checkbox" '+bt+' '+disabled+' />必填</span><span><input name="cy" type="checkbox" '+cy+' '+disabled+' />常用</span><span>'+bj+'</span></div></li>';
        }
        $(".layui-show").find("ul").html(zdstr);
        loadArr[type]=1;

        moveListen();//拖拽监听
        checkboxListen();//复选框监听
        scListen();//删除按钮监听
        bjListen();//编辑按钮监听
    });
}
//拖拽监听
function moveListen()
{
    $(".uk-sortable").unbind("stop.uk.sortable");
    $(".uk-sortable").bind("stop.uk.sortable",function(){
        window.jiazai=loading();
        var thisindex=$(this).parent().index();
        var thismod=thisindex<2?thisindex+1:thisindex+2;
        var pxstr='';
        $(".layui-show").find("li").each(function(){
            pxstr+=$(this).prop("id")+',';
        });
        pxstr=pxstr.substr(0,pxstr.length-1);
        //判断是否是产品，如果是产品就进行特殊处理
        if(thismod=='7')
        {
            var flid=$("#cpfl_select").val();
            thismod=thismod+','+flid;
        }
        $.post("/index.php/Home/Yewuziduan/changepx",{"pxstr":pxstr,"thismod":thismod},function(res){
            layer.close(jiazai);
            if(res=='1')
            {
                tishi("保存成功");
            }
            else
            {
                tishi("保存失败，请稍后重试");
            }
        })
        //alert(pxstr+'===='+thismod);
    });
}
//复选框监听
function checkboxListen()
{
    $("input[type='checkbox']").unbind("click");
    $("input[type='checkbox']").bind("click",function(){
        window.jiazai=loading();
        var thisindex=$(".layui-show").index();
        var thismod=thisindex<2?thisindex+1:thisindex+2;
        if(thismod=='7')
        {
            var flid=$("#cpfl_select").val();
            thismod=thismod+','+flid;
        }
        var thisval=$(this).prop("checked")==true?'1':'0';
        var thisid=$(this).parent().parent().parent().prop("id");
        var thisname=$(this).attr("name");
        $.get("/index.php/Home/Yewuziduan/changecheckbox",{"thismod":thismod,"thisval":thisval,"thisid":thisid,"thisname":thisname},function(res){
            layer.close(jiazai);
            if(res=='1')
            {
                tishi("保存成功");
            }
            else
            {
                tishi("保存失败，请稍后重试");
            }
            
        });
    });
}
function scListen()
{
    //新增字段按钮监听
    $(".sc").unbind("click");
    $(".sc").bind("click",function(){
        var thisid=$(this).parent().parent().parent().prop("id");
        var thisindex=$(".layui-show").index();
        var thismod=thisindex<2?thisindex+1:thisindex+2;
        if(thismod=='7')
        {
            var flid=$("#cpfl_select").val();
            thismod=thismod+','+flid;
        }
        layer.msg('确认删除这个字段吗？', {
            time: 20000000, //20s后自动关闭
            btn: ['确认', '取消'],
            btn1:function(){
                window.jiazai=loading();
                $.get("/index.php/Home/Yewuziduan/zd_del",{"thisid":thisid,"thismod":thismod},function(res){
                    layer.close(jiazai);
                    if(res=='1')
                    {
                        $(".layui-show").find("#"+thisid).remove();
                        tishi("删除成功");
                    }
                    else
                    {
                        tishi("删除失败，请稍后重试");
                    }
                });
            },
            btn2:function(index){
                layer.close(index);
            }
        });
    });
}
//编辑监听
function bjListen()
{
    $(".bj").unbind("click");
    $(".bj").bind("click",function(){
        var oldname=$(this).parent().parent().children("span").eq(1).text();
        $("#zdnameinput").val(oldname);
        var thisid=$(this).parent().parent().parent().prop("id");
        
        layer.open({
            type:1,
            area:"500px",
            title: '编辑字段',
            content:$("#addzddiv"),
            btn:["保存","取消"],
            btn1:function(index){
                var newname=$("#zdnameinput").val();
                if(oldname==newname)
                {
                    tishi("保存成功");
                    layer.close(index);
                    return;
                }
                var thisindex=$(".layui-show").index();
                var thismod=thisindex<2?thisindex+1:thisindex+2;
                if(thismod=='7')
                {
                    thismod=thismod+","+$("#cpfl_select").val();
                }
                if(newname=='')
                {
                    tishi("字段名不能为空");
                    return;
                }
                if(newname.length>10)
                {
                    tishi("字段名过长");
                    return;
                }
                window.jiazai=loading();
                $.get("/index.php/Home/Yewuziduan/editzd",{"thismod":thismod,"newname":newname,"thisid":thisid},function(res){
                    layer.close(jiazai);
                    if(res=='1')
                    {
                        tishi("保存成功");
                        getData(thismod);
                    }
                    else if(res=='2')
                    {
                        tishi("保存失败，该字段已存在");
                    }
                    else
                    {
                        tishi("保存失败，请稍后重试");
                    }
                    layer.close(index);
                });
            },
            btn2:function(index){
                layer.close(index);
            }
        }); 
    });
}
function hidden_div()
{
    $("#mod1").hide();
}
</script>
</html>