<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>产品分类</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <!--jquery-->
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
    <!--layUI 插件  form表单样式 table样式 -->
    <script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
    <!--UIkit-->
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
    <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/sticky.css" />
    <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/sticky.js"></script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/notify.css" />
    <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/notify.js"></script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/sortable.css" />
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/nestable.css" />

    <style>
        *{margin:0;padding:0;}
        html,body,#box{background: #f7f7f7;overflow: auto;}
        a{text-decoration:none;cursor:pointer;color:#1AA094;margin-right:10px;}
        a:hover{color:#2F6F69;text-decoration:none;}
        #box{margin-left: 10px;margin-right: 10px;overflow:hidden;color:#3B3B3B;}
        .fa{margin-right:5px;}
        ul{padding:0px;}
        li{width:100%;}
        li a{width:80%;}
        /*头部页面名称*/
        #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
        /*工具栏*/
        #top_div{height:70px;line-height:70px;background: #f7f7f7;border-bottom:1px solid #e1e1e1;}
        #search_input,#search_button{float:right;margin-top:15px;height:40px;}
        #search_input{padding:0px 10px;height:36px;line-height:36px;}
        button i{margin-right:5px;}
        /*树形结构*/
        #fljg_list{float: left;width:29%;height:100%;margin-right:1%;padding:10px 0px;}
        .uk-nestable-panel{border:1px solid #ccc;border-left: 3px solid #1AA094;margin-right:5px;background:#fff;overflow: hidden;line-height: 19px;}
        .fljg_mod{float:right;height:19px;line-height: 19px;overflow: hidden;}
        .fljg_mod i{float:right;height:19px;line-height:19px;margin-right:10px;cursor:pointer;color:#888;}
        /*树形结构下面的按钮组*/
        #fljg_btn{width:100%;margin-top:30px;display:none;}
        #fljg_btn button{float:left;width:49%;}
        /*没有快捷方式时*/
        #kongstyle .uk-icon-smile-o,#kongstyle span{float:left;height:100px;line-height:100px;color:#999;}
        #kongstyle span{width:70%;text-align:left;}
        #kongstyle .uk-icon-smile-o{font-size:80px;width:30%;text-align:right;}
        #kongstyle span i{color:#999;}
        /*分类块*/
        #cpfl_list{overflow:hidden;float: left;width:70%;height:auto;padding-bottom:200px;}
        .fl_mod{float:left;width:25%;margin-bottom:30px;cursor: pointer;}
        .fl_in_mod{margin:10px;background: #fff;}
        .fl_mod_top{height:35px;background:#ECEFF1;border:1px solid #CFD8DC;border-top:2px solid #4DBD74;border-bottom: none;}
        .fl_name{float: left;height:35px;line-height:35px;margin-left: 10px;color:#4E585D;width:70%;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;}
        .fl_set{float: right;height:35px;line-height:35px;margin-right:5px;width:10%;}
        .fl_set i{float: right;height:35px;line-height:35px;color:#888}
        .fl_mod_info{background: #fff;border:1px solid #CFD8DC;padding:10px;}
        .fl_cpnum{height:30px;}
        .fl_father{height:60px;line-height: 30px;overflow: hidden;text-overflow:ellipsis;word-break:break-all;}
        .uk-icon-cog{height:100%;width:100%;text-align: center;}
        /*添加产品分类/修改产品分类名称*/
        #add_cpfl_div,#edit_cpfl_div{width:500px;overflow:hidden;height:80px;display: none;}
        #add_cpfl_div div,#edit_cpfl_div div{float:left;height:80px;line-height: 80px;color:#3B3B3B;font-weight: bold;}
        #add_cpfl_div div:first-child,#edit_cpfl_div div:first-child{width:100px;text-align:right;padding-right:10px;}
        #add_cpfl_div div:last-child,#edit_cpfl_div div:last-child{width:390px;}
        #add_cpfl_div div:last-child input,#edit_cpfl_div div:last-child input{width:350px;margin-left:10px;}
        #new_fl_name,#edit_fl_name{line-height:30px;}
        /*修改产品分类简介*/
        #edit_jj_div{width:500px;height:100px;padding:0px;}
        #edit_jj_div textarea{width:480px;height:80px;padding:10px;margin:10px;resize:none;}
        /*产品搜索弹出层的样式*/
        #search_cp_div{width:490px;padding:10px;padding-top:5px;padding-right:0px;display: none;}
        .searchdiv_top{border-bottom: 1px solid #ccc;padding-bottom:10px;}
        #search_cp_div input{width:370px;padding:0px;height:36px;border:1px solid #ccc;margin-top:15px;padding-left:10px;margin-bottom:10px;}
        #search_cp_div button{width:100px;margin-top:-2px;}
        .searchdiv_body_tip{height:150px;text-align: center;padding-top:130px;color:#aaa;}
        .searchdiv_body{display: none;}
        /*#search_cp_div tr>td:last-child{width:100px;}*/
        /*抖动*/
        .doudong{animation:doudong 0.22s infinite linear;}
        /*消失*/
        .xiaoshi{animation:xiaoshi 0.3s;}
        /*效果*/
        .xuanzhuan{animation:xuanzhuan 1s infinite linear;color:#1AA094;}
        .uk-notify-message{border:1px solid #F3C1B6;}
        .lefttreecolor{background:#31A99D;color:#fff;border:1px solid #31A99D;}
        .lefttreecolor i{color:#fff;}
        @keyframes doudong
        {
            0% {
                    -webkit-transform: rotate(0deg);  
                    -moz-transform: rotate(0deg);  
                    -ms-transform: rotate(0deg);  
                    transform: rotate(0deg);
                }
            25% {
                    -webkit-transform: rotate(0.5deg);  
                    -moz-transform: rotate(0.5deg);  
                    -ms-transform: rotate(0.5deg);  
                    transform: rotate(0.5deg);
                }
            50% {
                    -webkit-transform: rotate(0deg);  
                    -moz-transform: rotate(0deg);  
                    -ms-transform: rotate(0deg);  
                    transform: rotate(0deg);
                }
            75% {
                    -webkit-transform: rotate(-0.5deg);  
                    -moz-transform: rotate(-0.5deg);  
                    -ms-transform: rotate(-0.5deg);  
                    transform: rotate(-0.5deg);
                }
            100% {
                    -webkit-transform: rotate(0deg);  
                    -moz-transform: rotate(0deg);  
                    -ms-transform: rotate(0deg);  
                    transform: rotate(0deg);
                }
        }
        @keyframes xiaoshi
        {
            0% {
                    width:25%;
                }
            100% {
                    width:0;
                }
        }
        @keyframes  xuanzhuan     
        {
            0% {
                -webkit-transform: rotate(0deg);  
                -moz-transform: rotate(0deg);  
                -ms-transform: rotate(0deg);  
                transform:rotate(0deg);
                }
            100% {
                -webkit-transform: rotate(360deg);  
                -moz-transform: rotate(360deg);  
                -ms-transform: rotate(360deg);  
                transform:rotate(360deg);
                }
        }
        @media screen and (max-width:1000px)
        {
            .fl_mod{width:50%}
        }
    </style>
</head>
<body>

<div id="box">
    <!--头部文字-->
    <div id="mod-head">
    产品分类
    </div>
    <!--头部结束-->
    <div data-uk-sticky id="top_div">
        <button class="layui-btn" onclick="add_cpfl()" disabled="disabled"><i class='uk-icon-plus' aria-hidden='true'></i>添加产品分类</button>
        <button class="layui-btn" onclick="cp_search_window()" ><i class='uk-icon-search' aria-hidden='true'></i>产品搜索</button>
        <!--<button class="layui-btn layui-btn-primary" onclick="window.location=rooturl+'/index.php/Home/Chanpin'"><i class='uk-icon-cubes' aria-hidden='true'></i>查看全部产品</button>-->
        <button class="layui-btn layui-btn-primary" onclick="edit_link(this)" disabled="disabled"><i class='fa fa-th' aria-hidden='true'></i>编辑快捷方式</button>
        <!--<button class="layui-btn" id="search_button">搜索分类</button>-->
        <input type="text" id="search_input" placeholder="搜索快捷方式" disabled="disabled" />
    </div>
    <div id="fljg_list" style="height:100%;">
        <ul class="uk-nestable" id="ukpaixu" data-uk-nestable="maxDepth:5">
        </ul>
        <div id="cpfl_jiazai"><span class='fa fa-refresh xuanzhuan' style='margin-top:10%;margin-left:-12px;position:relative;left:50%;font-size:30px;'></span><div style='text-align:center;font-size:12px;color:#1AA094;margin-top:5px;'>加载中</div></div>
    </div>
    <ul id="cpfl_list" data-uk-sortable="{animation:0, threshold:1000}" >
      <div id="cpfl_jiazai2"><span class='fa fa-refresh xuanzhuan' style='margin-top:10%;margin-left:-12px;position:relative;left:50%;font-size:30px;'></span><div style='text-align:center;font-size:12px;color:#1AA094;margin-top:5px;'>加载中</div></div>
    </ul>
</div>
</body>
<div id="add_cpfl_div" class="uk-form" style="display:none;">
    <div>分类名称：</div>
    <div><input type="text" id="new_fl_name" /></div>
</div>
<div id="edit_cpfl_div" class="uk-form" style="display:none;">
    <div>分类名称：</div>
    <div><input type="text" id="edit_fl_name" /></div>
</div>
<div id="edit_jj_div" class="uk-form" style="display:none;">
    <textarea id="edit_jianjie" placeholder="在此修改产品简介"></textarea>
</div>
<!--产品搜索div-->
<div id="search_cp_div">
    <div class="searchdiv_top">
        <input type="text" id="search_cp_input" placeholder="请输入需要搜索的产品关键字" />
        <button class="layui-btn" id="search_cp_btn" onclick="search_div_btn()">搜索</button>
    </div>
    <div class="searchdiv_body_tip">
        您可以在此快速搜索到产品
    </div>
    <div class="searchdiv_body">
        
    </div>
</div>
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
window.oldjg;
$(function(){

    
    /*
    var modwidth=$(".fl_mod").css("width");
    var inmodwidth=$(".fl_in_mod").css("width");
    $(".fl_mod").css("height",modwidth);
    $(".fl_in_mod").css("height",inmodwidth);
    */

    //window.jiazai= layer.load(2);
    //获取产品分类树形结构
    //$.get(rooturl+"/index.php/Home/Cpfl/get_fl_level_html",function(tree_html){
    $.get(rooturl+"/index.php/Home/Cpfl/old_fl",function(tree_html){
        $(".uk-nestable").html(tree_html);
        edit_fl_name_fun();
        oldjg=tree_html;
        $("#cpfl_jiazai").remove();
        var can_change="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
        if(can_change=='1')
        {
            $.getScript("<?php echo ($_GET['public_dir']); ?>/uikit/js/components/nestable.js");
            tuozhuai();
        }
        add_link();
        remove_cpfl();
        create_fl_link();
        tree_to_chanpin()
        $("button,input").attr("disabled",false);
        //layer.close(jiazai);
    });
    
    //搜索快捷方式
    $("#search_input").on("keyup",function(){
        var thisval=$(this).val();
        if(thisval=='')
        {
            $(".fl_mod").show("fast");
            $(".uk-nestable-panel").removeClass("lefttreecolor");
            return;
        }
        $(".fl_mod").each(function(){
            if($(this).find(".fl_name").text().search(thisval)>=0)
            {
                $(this).show("fast");
            }
            else
            {
                $(this).hide("fast");
            }
        });
        $(".uk-nestable-panel").each(function(){
            var s1=$(this).children(".fljg_mod").children("span").eq(0).text();
            var s2=$(this).children(".fljg_mod").children("span").eq(1).text();
            $(this).children(".fljg_mod").children("span").eq(0).text('');
            $(this).children(".fljg_mod").children("span").eq(1).text('');
            if($(this).text().search(thisval)>=0)
            {
                $(this).addClass("lefttreecolor");
            }
            else
            {
                $(this).removeClass("lefttreecolor");
            }
            $(this).children(".fljg_mod").children("span").eq(0).text(s1);
            $(this).children(".fljg_mod").children("span").eq(1).text(s2);
        });
    });
});
//链接到对应的分类
function goto_fl_page()
{
    $(".fl_mod_info,.fl_name").on("click",function(){
        var link_id;
        if($(this).prop("class")=="fl_mod_info")
        {
            link_id=$(this).parent().parent().prop("id");
        }
        else if($(this).prop("class")=="fl_name")
        {
            link_id=$(this).parent().parent().parent().prop("id");
        }
        else
        {
            link_id='';
        }
        if(link_id)
        {
            window.jiazai=layer.load(2);
            //alert(link_id.substr(7));
            window.location=rooturl+"/index.php/Home/Chanpin/index?flid="+link_id.substr(7);
        }
        
    });
}
function mod_add_am()
{
    $(".fl_in_mod").on("mouseenter",function(){
        $(this).addClass("uk-animation-fade");
        var f_this=$(this);
        setTimeout(function() {
            f_this.removeClass("uk-animation-fade");
        }, 800);
    });
}
//点击快捷方式右上角的按钮事件
function right_top_set()
{
    $(".uk-icon-cog").on("click",function(e){
        　　//e.stopPropagation(); 
      
    });
}
//构造快捷方式
function create_fl_link()
{
    
    //产品分类快捷方式数据
    $.get(rooturl+"/index.php/Home/Cpfl/get_fl_link",function(link_str){
        //alert(link_str)
        if(!link_str)
        {
            var nolinkstr='<div id="kongstyle" style="height:100px;"><i class="uk-icon-smile-o"></i><span>&nbsp;&nbsp;&nbsp;&nbsp;还没有分类快捷方式，点击左边的<i class="uk-icon-arrow-right" aria-hidden="true"></i>添加一个吧！</span></div>';
            $("#cpfl_list").html(nolinkstr);
            return;
        }
        else
        {
            var arr=link_str.split(",");
            var left_fl_dom=$("#ukpaixu").find("div").prop("id");
            $("#cpfl_list").html("");
            for(a in arr)
            {
                var link_title_dom=$("#fl_id_"+arr[a]).parent();
                
                var jianjietext=link_title_dom.find("span").eq(0).text();//简介
                var shuliangtext=link_title_dom.find("span").eq(1).text();//数量
                link_title_dom.find("span").eq(0).text('');
                link_title_dom.find("span").eq(1).text('');
                var link_title=link_title_dom.text();//标题
                if(!link_title)
                {
                    continue;
                }
                link_title_dom.find("span").eq(0).text(jianjietext);
                link_title_dom.find("span").eq(1).text(shuliangtext);

                var linkmodhtml='<li class="fl_mod" style="display:none;" id="newlink'+arr[a]+'" ><div class="fl_in_mod"><div class="fl_mod_top"><div class="fl_name">'+link_title+'</div><div class="fl_set uk-button-dropdown" data-uk-dropdown="{mode:\'click\'}" ><i class="uk-icon-cog"></i><div class="uk-dropdown uk-dropdown-small"><ul class="uk-nav uk-nav-dropdown"><li><a onclick="edit_fl_name_fun_link(this)">修改名称</a></li><li><a onclick="edit_fl_jj(this)">修改简介</a></li><li><a onclick="link_del_this(this)">删除快捷方式</a><a onclick="link_del_this_fl(this)">删除产品分类</a></li></ul></div></div></div><div class="fl_mod_info"><div class="fl_cpnum">产品数量：'+shuliangtext+'</div><div class="fl_father" title="'+jianjietext+'">产品简介：'+jianjietext+'</div></div></div></li>';
                $("#cpfl_jiazai2").hide();
                //$("#kongstyle").remove();
                $("#cpfl_list").append(linkmodhtml);
                $(".fl_mod").fadeIn();
                
            }
            goto_fl_page();//监听点击快捷方式事件
            right_top_set();
            //mod_add_am();//添加动画 
        }
        
    });
}
//编辑快捷方式
function edit_link(varthis)
{
    if($(".fl_in_mod").length<1||($("#link_baocun").text()||$("#link_quxiao").text()))
    {
        return;
    }
    $(varthis).after('<button class="layui-btn" id="link_baocun" onclick="baocun_link()">保存</button><button id="link_quxiao" class="layui-btn layui-btn-primary" onclick="location.reload();">取消</button>');
    $(".fl_in_mod").addClass("doudong");//抖动
    //支持拖拽
    $("#cpfl_list").addClass("uk-sortable");
    $("#cpfl_list").attr("data-uk-sortable",false);
    //重载拖拽js
    $.getScript("<?php echo ($_GET['public_dir']); ?>/uikit/js/components/sortable.js");
    //隐藏设置按钮以及设置菜单
    $(".fl_set").removeClass("uk-button-dropdown");
    $(".uk-dropdown-small").remove();
    $(".uk-icon-cog").prop("class","fa fa-remove");
    removeThisLink()
}
//编辑时删除单个快捷方式
function removeThisLink()
{
    $(".fa-remove").on("click",function(e){
        e.stopPropagation;
        var rmdom=$(this).parent().parent().parent().parent();
        rmdom.find(".fl_name").text('');
        rmdom.find(".fl_cpnum").text('');
        rmdom.find(".fl_father").text('');
        rmdom.find(".fl_set").remove();
        rmdom.addClass("xiaoshi");
        setTimeout(function(){
            rmdom.remove();
        },300);
    });
}
//保存编辑后的快捷方式
function baocun_link(isreload)
{
    var link_id_str='';
    if($(".fl_mod").length>0)
    {
        $(".fl_mod").each(function(){
            link_id_str+=$(this).prop("id").substr(7)+',';
        });
        link_id_str=link_id_str.substr(0,link_id_str.length-1);
    }
    $.get(rooturl+"/index.php/Home/Cpfl/edit_cpfl_link",{"link_id_str":link_id_str},function(){
        if(!isreload)
        {
            location.reload();
        }
    });
}
//保存树形结构
function save_tree()
{
   
    var tree_html=$(".uk-nestable").html();
    $.post(rooturl+"/index.php/Home/Cpfl/save_tree_html",{"tree_html":tree_html});
    var db_tree_json=save_tree_db();
    $.get(rooturl+"/index.php/Home/Cpfl/edit_db_tree_old",{"json_str":db_tree_json});
    var tree_px=html_to_px($("#ukpaixu"));
    //alert(tree_px);
    $.post(rooturl+"/index.php/Home/Cpfl/edit_tree_px",{"jsonstr":tree_px});
}
function save_tree_db()
{
    window.cdd='{';
    var maindom=$("#ukpaixu");
    html_to_db_tree(maindom);
    cdd=cdd.substr(0,cdd.length-1);
    cdd=cdd+'}';
    return cdd;
}
function html_to_db_tree(main_ul_dom)
{
    /*
    将HTML的树形结构转化成数据库的储存结构
    ≡└( 'o')┘≡┌( 'o')┐≡└( 'o')┘≡┌( 'o')┐
    */
    main_ul_dom.children(".uk-nestable-item").each(function(){
        var noweachid=$(this).parent().parent().children(".uk-nestable-panel").eq(0).children(".fljg_mod").prop("id")==undefined?'0':$(this).parent().parent().children(".uk-nestable-panel").eq(0).children(".fljg_mod").prop("id").substr(6);
        cdd+='"'+noweachid+'":"'+$(this).find(".fljg_mod").prop("id").substr(6)+'",';
        if($(this).children("ul").length)
        {
            var each_dom=$(this).children("ul");
            html_to_db_tree(each_dom);
        }
    });
}

function html_to_px(m)
{
    /*
        获取树形结构的顺序
    */
    var sq=new Array();
    m.find(".fljg_mod").each(function(){
        sq.push($(this).prop("id").substr(6));
    });
    return JSON.stringify(sq);

}
//添加快捷方式
var isclick=0;
function add_link()
{
    if(isclick!=0)
    {
        return;
    }
    isclick=1;
    setTimeout(function(){
        isclick=0;
    },500);
    $(".fljg_mod").children(".uk-icon-arrow-right").on("click",function(){
        var lsdom=$(this).parent().parent();
        var ls_span_text=lsdom.find("span").eq(0).text();
        var ls_span_text2=lsdom.find("span").eq(1).text();
        lsdom.find("span").eq(0).text('');
        lsdom.find("span").eq(1).text('');
        var cpname=lsdom.text();
        lsdom.find("span").eq(0).text(ls_span_text);
        lsdom.find("span").eq(1).text(ls_span_text2);
        if($(".fl_name").text().search(cpname)>=0)
        {
            $(".fl_name").each(function(){
                if($(this).text().search(cpname)>=0)
                {
                    var eachdom=$(this).parent().parent();
                    eachdom.addClass("uk-animation-shake");
                    setTimeout(function(){
                       eachdom.removeClass("uk-animation-shake");
                    },500);
                }
            });
            return;
        }
        else
        {
            var this_fl_id=$(this).parent().prop("id").substr(6);
            var jj=$(this).parent().children().eq(0).text();
            var sl=$(this).parent().children().eq(1).text();
            var linkmodhtml='<li class="fl_mod" style="display:none;" id="newlink'+this_fl_id+'" ><div class="fl_in_mod"><div class="fl_mod_top"><div class="fl_name">'+cpname+'</div><div class="fl_set uk-button-dropdown" data-uk-dropdown="{mode:\'click\'}" ><i class="uk-icon-cog"></i><div class="uk-dropdown uk-dropdown-small"><ul class="uk-nav uk-nav-dropdown"><li><a onclick="edit_fl_name_fun_link(this)">修改名称</a></li><li><a onclick="edit_fl_jj(this)">修改简介</a></li><li><a onclick="link_del_this(this)">删除快捷方式</a><a onclick="link_del_this_fl(this)">删除产品分类</a></li></ul></div></div></div><div class="fl_mod_info"><div class="fl_cpnum">产品数量：'+sl+'</div><div class="fl_father" title="'+jj+'">产品简介：'+jj+'</div></div></div></li>';
            $("#kongstyle").remove();
            $("#cpfl_list").append(linkmodhtml);
            $('#newlink'+this_fl_id).fadeIn();
            baocun_link(1);
            goto_fl_page();//监听点击事件，链接到对应的分类页面
        }
    });
}
//从树形菜单跳转到对应的产品分类
function tree_to_chanpin()
{
    $(".uk-icon-folder-open-o").on("click",function(){
        var cpflid=$(this).parent().prop("id").substr(6);
        location=rooturl+"/index.php/Home/Chanpin/index?flid="+cpflid;
    });
}
//删除产品分类
function remove_cpfl()
{
    $(".fljg_mod").children(".uk-icon-trash-o").on("click",function(){
        var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
        if(cookie_qx!='1')
        {
            tishi("您没有产品模块的删除权限");
            return;
        }
        var thisid=$(this).parent().prop("id").substr(6);
        var lsdom=$(this).parent().parent();
        var ls_span_text=lsdom.find("span").eq(0).text();
        var ls_span_text2=lsdom.find("span").eq(1).text();
        lsdom.find("span").eq(0).text('');
        lsdom.find("span").eq(1).text('');
        var thistext=lsdom.text();
        lsdom.find("span").eq(0).text(ls_span_text);
        lsdom.find("span").eq(1).text(ls_span_text2);
        var thisdom=$(this).parent().parent().parent();
        layer.msg("是否删除该产品分类？<br>如果该分类有子分类，那么子分类也会被删除", {
            time: 9999999,
            btn: ['确认删除', '取消'],
            btn1: function(index, layero){
                window.jiazai=layer.load(2);
                $.get(rooturl+"/index.php/Home/Chanpin/delfl",{"delid":thisid,"delname":thistext},function(res){
                    if(res=='1')
                    {
                        save_tree();
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("删除失败");
                        return false;
                    }
                    else
                    {
                        tishi("删除失败,请稍后重试");
                        return false;
                    }
                });
                thisdom.remove();
                layer.close(index);
            },
            btn2: function(index, layero){
                layer.close(index);
            }
        });
    });
}
//添加产品分类
function add_cpfl()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_add']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有产品模块的添加权限");
        return;
    }
    $("#new_fl_name").val('');
    setTimeout(function() {
        $("#new_fl_name").focus();
    }, 100);
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            area:"500px",
            title: '添加产品分类',
            content:$("#add_cpfl_div"),
            btn:["添加","取消"],
            btn1:function(index){
                if($("#new_fl_name").val()=='')
                {
                    tishi("分类名称不能为空");
                    return false;
                }
                layer.close(index);
                
                $.get(rooturl+"/index.php/Home/Cpfl/add_new_fl",{"flname":$("#new_fl_name").val()},function(e){
                    var e2=e.split(',');
                    if(e2[0]=='2')
                    {
                        tishi("添加失败，请刷新页面后重试");
                    }
                    else
                    {
                        
                        $(".uk-nestable").append('<li class="uk-nestable-item"> <div class="uk-nestable-panel"> <div class="uk-nestable-toggle" data-nestable-action="toggle"></div> '+$("#new_fl_name").val()+' <div class="fljg_mod" id="fl_id_'+e2[1]+'"><span style="display:none;">无</span><span style="display:none;">0</span><i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i> <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i> <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i><i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i> </div> </div> </li>');
                        //alert(e);
                        save_tree();
                        $(".fljg_mod").children(".uk-icon-arrow-right").off("click");
                        $(".fljg_mod").children(".uk-icon-trash-o").off("click");
                        add_link();
                        remove_cpfl();
                        tuozhuai();
                        tree_to_chanpin()
                        //window.location.reload();
                    }
                });
                
            },
            btn2:function(index){

            }
        }); 
    }); 
}
//修改产品分类名称
function edit_fl_name_fun()
{
    $(".fljg_mod").children(".uk-icon-pencil").on("click",function(){
        var thisid=$(this).parent().prop("id").substr(6);
        //alert($(this).parent().parent().text());
        var this_fl_dom=$(this).parent().parent();
        
        var e_jj=this_fl_dom.find("span").eq(0).text();
        var e_sl=this_fl_dom.find("span").eq(1).text();
        
        this_fl_dom.find("span").eq(0).text('');
        this_fl_dom.find("span").eq(1).text('');

        var old_fl_name=this_fl_dom.text();
        $("#edit_fl_name").val($.trim(old_fl_name));

        this_fl_dom.find("span").eq(0).text(e_jj);
        this_fl_dom.find("span").eq(1).text(e_sl);
        edit_fl_name_fun2(thisid);
    });
}
//修改产品分类名称
function edit_fl_name_fun2(thisid)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有产品模块的修改权限");
        return;
    }
    //$("#edit_fl_name").val('');
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            area:"500px",
            title: '修改分类名称',
            content:$("#edit_cpfl_div"),
            btn:["修改","取消"],
            btn1:function(index){
                var newname=$("#edit_fl_name").val();
                if(newname=='')
                {
                    tishi("名称不能为空");
                    return;
                }
                $.get(rooturl+"/index.php/Home/Chanpin/editfl",{"editid":thisid,"newname":newname},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return false;
                    }
                    else if(res=='3')
                    {
                        tishi("该分类已存在，请重新输入");
                        return false;
                    }
                    else
                    {
                        tishi("修改失败，请刷新后重试");
                        return false;
                    }
                });
                
            },
            btn2:function(index){

            }
        }); 
    }); 
}
//快捷方式中修改产品分类名称
function edit_fl_name_fun_link(thisdom)
{
    var oldname=$(thisdom).parent().parent().parent().parent().parent().find(".fl_name").html();
    var thisid=$(thisdom).parent().parent().parent().parent().parent().parent().parent().prop("id");
    $("#edit_fl_name").val($.trim(oldname));
    edit_fl_name_fun2(thisid.substr(7));
}
//删除快捷方式，删除产品分类
function loadingggg(thisdom)
{
    tishi("该功能尚未完成，敬请期待！");
    return;
}
//修改产品分类简介
function edit_fl_jj(thisdom)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有产品模块的修改权限");
        return;
    }
    var this_id=$(thisdom).parent().parent().parent().parent().parent().parent().parent().prop("id").substr(7);
    var old_jj=$("#fl_id_"+this_id).find("span").eq(0).text();
    $("#edit_jianjie").val(old_jj);
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            area:"500px",
            title: '编辑产品简介',
            content:$("#edit_jj_div"),
            btn:["保存","取消"],
            btn1:function(index){
                var new_jj=$("#edit_jianjie").val();
                if(new_jj==old_jj)
                {
                    tishi("修改成功");
                    layer.close(index);
                    return;
                }
                if(new_jj=='')
                {
                    tishi("简介不能为空");
                    return;
                }
                window.jiazai=layer.load(2);
                $.get(rooturl+"/index.php/Home/Cpfl/edit_fl_jj",{"cpflid":this_id,"jj_content":new_jj},function(res){
                    layer.close(jiazai);
                    if(res=='1')
                    {
                        tishi("修改成功");
                        $("#fl_id_"+this_id).find("span").eq(0).text(new_jj);
                        $("#newlink"+this_id).children("div").children(".fl_mod_info").children(".fl_father").prop("title",new_jj);
                        $("#newlink"+this_id).children("div").children(".fl_mod_info").children(".fl_father").text("产品简介："+new_jj);
                        layer.close(index);
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return;
                    }
                    else
                    {
                        tishi("修改失败，请刷新后重试");
                        return;
                    }
                });
            },
            btn2:function(index){

            }
        }); 
    }); 
}
//快捷方式-菜单-删除本快捷方式的方法
function link_del_this(thisdom)
{
    $(thisdom).parent().parent().parent().parent().parent().parent().parent().hide("fast");
    setTimeout(function() {
        $(thisdom).parent().parent().parent().parent().parent().parent().parent().remove();
        baocun_link(1);
    }, 200);
    
}
//快捷方式-菜单-删除产品分类
function link_del_this_fl(thisdom)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_del']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有产品模块的删除权限");
        return;
    }
    layer.msg("是否删除该产品分类？<br>如果该分类有子分类，那么子分类也会被删除", {
            time: 9999999,
            btn: ['确认删除', '取消'],
            btn1: function(index, layero){
                //获取本模块的id
                var this_fl_id=$(thisdom).parent().parent().parent().parent().parent().parent().parent().prop("id").substr(7);
                //获取删除分类的名称
                var this_fl_name=$(thisdom).parent().parent().parent().parent().parent().children(".fl_name").text();
                this_fl_name=$.trim(this_fl_name);
                link_del_this(thisdom);//删除本快捷方式的显示，并保存
                //删除数据库中的分类
                $.get(rooturl+"/index.php/Home/Chanpin/delfl",{"delid":this_fl_id,"delname":this_fl_name},function(res){
                    if(res=='1')
                    {
                        //save_tree();
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("删除失败");
                        return false;
                    }
                    else
                    {
                        tishi("删除失败,请稍后重试");
                        return false;
                    }
                });
            },
            btn2:function(index,layero){
                layer.close(index);
            }
    });
}
//拖拽监听事件
function tuozhuai()
{
    /*
    var mouseval='0';
    $(".uk-nestable-panel").on({
        //当鼠标按下时，将鼠标值改为1（标记鼠标已经按下）
        mousedown:function(){
            oldpos=getMousePos();
            
            mouseval='1';
            $(".uk-nestable-panel").on({
                mousemove:function(){
                    //当鼠标为按下状态时（鼠标值为1时），然后再拖动时，将鼠标值改为2（标记鼠标按下并拖动）
                    if(mouseval=='1')
                    {
                        mouseval='2';
                        $("body").on({
                            mouseup:function(){
                                if(mouseval=='2')
                                {
                                    newpos=getMousePos();
                                    if(Math.abs(newpos['y']-oldpos['y'])<10&&Math.abs(newpos['x']-oldpos['x'])<10)
                                    {
                                        //$("#search_input").val(Math.abs(newpos['x']-oldpos['x'])+'/'+Math.abs(newpos['y']-oldpos['y']));
                                        return;
                                    }
                                    if($(".uk-nestable").html()==oldjg)
                                    {
                                        return ;
                                    }
                                    else
                                    {
                                        window.jiazai= layer.load(2);
                                        $("body").off("mouseup");
                                        $(".uk-nestable-panel").off("mousemove");
                                        $(".uk-nestable-panel").off("mousedown");
                                        oldjg=$(".uk-nestable").html();//记录当前结构
                                        //稍微延迟后保存树形结构
                                        setTimeout(function(){
                                            //进行ajax提交
                                            save_tree();
                                            layer.close(jiazai);
                                            tuozhuai();
                                        },200);
                                    }
                                }
                            }
                        });
                    }
                }
            });
        }
    });
    */
    $("#ukpaixu").on("change.uk.nestable",function(){
        window.jiazai= layer.load(2);
        oldjg=$(".uk-nestable").html();
        //稍微延迟后保存树形结构
        setTimeout(function(){
            //进行ajax提交
            save_tree();
            layer.close(jiazai);
        },200);
    });
}
$(document).keydown(function(event){ 
        if(event.keyCode==13){
            var nowf=document.activeElement.id;
            if(nowf=='search_cp_input')
            {
                $("#search_cp_btn").click();
            }
        } 
    });
function cp_search_window()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        var thiswindow=layer.open({
            type:1,
            area:["510px","500px"],
            title: '产品全局搜索',
            content:$("#search_cp_div"),
            btn:'',
            btn1:function(index){
               layer.close(thiswindow);
            }
        });
    });
    setTimeout(function() {
        $("#search_cp_input").focus();
    }, 300);
}
function search_div_btn()
{
    var inputText=$(".searchdiv_top").children("input").val();
    if(inputText=='')
    {
        $(".search_div_body").hide();
        $(".search_div_body_tip").show();
        return;
    }
    window.jiazai=layer.load(2);
    $.get("/index.php/Home/Cpfl/search_cp_list",{"searchstr":inputText},function(res){
        var resArr=JSON.parse(res);
        if(resArr.length>8)
        {
            $(".searchdiv_body").css("width","480px");
        }
        else
        {
            $(".searchdiv_body").css("width","490px");
        }
        var tableHead='<table class="layui-table"><thead><th>产品名称</th><th>所属分类</th></thead><tbody>';
        var tableFoot='</tbody></table>';
        var tableBody='';
        for(row in resArr)
        {
            //alert(resArr[row]['id']);
            var cp_num=resArr[row]['number']==null?'':'('+resArr[row]['number']+')';
            tableBody+='<tr><td><a href="/index.php/Home/Chanpin/chanpininfo?flid='+resArr[row]['flid']+'&cpid='+resArr[row]['id']+'&from=flpage">'+resArr[row]['name']+cp_num+'</a></td><td><a href="/index.php/Home/Chanpin/index?flid='+resArr[row]['flid']+'">'+resArr[row]['flname']+'</a></td></tr>';
        }
        if(tableBody=='')
        {
            $(".searchdiv_body_tip").text("没有搜索到对应产品");
            $(".searchdiv_body").hide();
            $(".searchdiv_body_tip").show();
        }
        else
        {
            $(".searchdiv_body_tip").text("您可以在此快速搜索到产品");
            $(".searchdiv_body_tip").hide();
            var tableString=tableHead+tableBody+tableFoot;
            $(".searchdiv_body").html(tableString);
            $(".searchdiv_body").show();
        }
        layer.close(jiazai);
    });
    //alert(inputText);
}
function search_sel_fl(flname)
{
    alert(1);
}
function getMousePos(event) {
    var e = event || window.event;
    var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
    var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
    var x = e.pageX || e.clientX + scrollX;
    var y = e.pageY || e.clientY + scrollY;
    return { 'x': x, 'y': y };
}
</script>
</html>