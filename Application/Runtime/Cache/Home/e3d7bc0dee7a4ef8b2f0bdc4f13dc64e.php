<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>自定义审批</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
    <!--layUI 插件 --弹窗设计 form表单样式 -->
    <script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
    <style>
        *{margin:0;padding:0;}
        #box div{overflow:hidden;}
        a{text-decoration:none;cursor:pointer;}
        ul{list-style:none;}
        #box{margin-left:10px;margin-right:10px;}
        
        #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
        #mod1{background-color:#DFF0D8;height:42px;color:#255B56;padding-left:15px;padding-top:20px;padding-bottom:0px;border-radius:0px;}
        #mod1 div{height:22px;font-size:12px;}
        #hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
        /*mod2下方选项卡*/
        .fa-reorder{margin-left:10px;}
        /*选项卡内容*/
        .tab-top{height:60px;line-height:60px;padding-left:10px;background-color:#F5F5F5;color:#656565;}
        .tab-top button{margin-right:10px;}
        .tab-top2{height:60px;line-height:60px;padding-left:10px;background-color:#F5F5F5;color:#656565;}
        .tab-top2 button{margin-right:10px;}
        .tab-top3{height:60px;line-height:60px;padding-left:10px;background-color:#F5F5F5;color:#656565;}
        .tab-top3 button{margin-right:10px;}

        
        /*审批表格样式*/
        #shenpi-body table{margin-top:10px;width:100%}
        #huikuan-body table{margin-top:10px;width:100%}
        #kaipiao-body table{margin-top:10px;width:100%}
        #shenpi-body table tr{height:50px;}
        #kaipiao-body table tr{height:50px;}
        .thead{background-color:#F5F5F5;height:40px;padding-left:10px;color:#656565;}
        .selectbox{height:30px;color:#656565;}
        .layui-form{width:120px;}
        .sel-td{width:130px;padding-top:5px;}
        /*表格下方说明*/
        .shuoming{display:block;height:30px;color:#656565;}
        .redcolor{color:#f00;}

        .fdiv{display:none;}
    </style>
</head>

<body>
<div id="box">
    <!--头部文字-->
    <div id="mod-head">
    自定义审批
    </div>
    <!--头部结束-->
    <!--中部提示-->
    <div id="mod1">
        <div>提示：企业可以根据自己业务的实际情况，对审批流程进行个性化调整。<span id="hidden-div"><a onclick="hidden_div()">×</a></span></div>
    </div>
    <!--中部结束-->
    <!--下部数据展示模块-->
    <div id="mod2">
        <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
                <li class="layui-this">合同审批</li>
                <li>合同回款审批</li>
                <li>开票审批</li>
            </ul>
            <div class="layui-tab-content" >
                <!--审批-->
                <div class="layui-tab-item layui-show">
                    <div class="tab-top">
                    </div>
                    <div id="shenpi-body">
                        <table>
                            <tr>
                                <td colspan="3" class="thead">审批设置</td>
                            </tr>
                            
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr[1]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox" id="sel1">
                                        <?php echo ($spsel[1]); ?>
                                    </select>
                                </td>
                                <td id="lv1" style="padding-top:5px;"><?php echo ($btnstr[1]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr[2]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox" id="sel2">
                                        <?php echo ($spsel[2]); ?>
                                    </select>
                                </td>
                                <td id="lv2" style="padding-top:5px;"><?php echo ($btnstr[2]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr[3]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox" id="sel3">
                                        <?php echo ($spsel[3]); ?>
                                    </select>
                                </td>
                                <td id="lv3" style="padding-top:5px;"><?php echo ($btnstr[3]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($tbbtn[1]); ?></td>
                                <td style="color:#656565" colspan="2"><span class="redcolor">*</span>如果开启审批同步，只有当前等级审批人全部通过后才进行下一级的审批。</td>
                            </tr>
                        </table>
                        <span class="shuoming"><span class="redcolor">*</span>超级管理员自动可以审批所有合同。</span>
                        <span class="shuoming"><span class="redcolor">*</span>审批人可以审批合同，也可将审批通过的合同驳回。</span>
                        <span class="shuoming"><span class="redcolor">*</span>提交人上级是指提交人的主管，以及提交人主管的主管，以此类推。</span>
                        <span class="shuoming"><span class="redcolor">*</span>固定审批人，最多可选择7人。</span>
                        <span class="shuoming"><span class="redcolor">*</span>如合同提交后，没有对应的审批人时，会自动通过合同审批</span>
                        <span class="shuoming redcolor">（例如，审批人仅设置了“提交人上级”，而提交人没有上级，则提交合同审批后，此合同自动通过审批。）</span>
                        <button class="layui-btn" onclick="shenpibc()" style="height:30px;line-height:30px">保存</button>
                    </div>
                </div>
                <!--回款审批-->
                <div class="layui-tab-item">
                    <div class="tab-top2">
                    </div>
                    <div id="huikuan-body">
                        <table>
                            <tr>
                                <td colspan="3" class="thead">合同回款审批设置</td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($hkboxarr[1]); ?></td>
                                <td class="sel-td">
                                </td>
                                <td id="lv1" style="padding-top:11px;"></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($hkboxarr[2]); ?></td>
                                <td class="sel-td">
                                </td>
                                <td id="lv2" style="padding-top:11px;"></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($hkboxarr[3]); ?></td>
                                <td class="sel-td">
                                    <button class="layui-btn" style="height:30px;line-height:30px;" onclick="hkxuanze()">选择审批人</button>
                                </td>
                                <td id="huikuanmainshow" style="padding-top:11px;"><?php echo ($hkspanstr); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($tbbtn[2]); ?></td>
                                <td style="color:#656565" colspan="2"><span class="redcolor">*</span>如果开启审批同步，只有当前等级审批人全部通过后才进行下一级的审批。</td>
                            </tr>
                        </table>
                        <span class="shuoming"><span class="redcolor">*</span>勾选后，上述人既可以审批合同回款，还可以将已审批的合同回款驳回。</span>
                        <span class="shuoming"><span class="redcolor">*</span>最多选择7个固定审批人。</span>
                        <span class="shuoming"><span class="redcolor">*</span>如果固定审批人对回款的合同没有查看权限，提交该合同审批时，系统将不会通知其审批。</span>
                        <button class="layui-btn" onclick="baocun2()">保存</button>
                    </div>
                </div>
                 <!--开票审批-->
                 <div class="layui-tab-item">
                    <div class="tab-top3">
                    </div>
                    <div id="kaipiao-body">
                        <table>
                            <tr>
                                <td colspan="3" class="thead">开票审批设置</td>
                            </tr>
                            
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr2[1]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox kpsel" id="sel21">
                                        <?php echo ($spsel2[1]); ?>
                                    </select>
                                </td>
                                <td id="kplv1" style="padding-top:5px;"><?php echo ($btnstr2[1]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr2[2]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox kpsel" id="sel22">
                                        <?php echo ($spsel2[2]); ?>
                                    </select>
                                </td>
                                <td id="kplv2" style="padding-top:5px;"><?php echo ($btnstr2[2]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($checkboxarr2[3]); ?></td>
                                <td class="sel-td">
                                    <select class="selectbox kpsel" id="sel23">
                                        <?php echo ($spsel2[3]); ?>
                                    </select>
                                </td>
                                <td id="kplv3" style="padding-top:5px;"><?php echo ($btnstr2[3]); ?></td>
                            </tr>
                            <tr>
                                <td class="layui-form"><?php echo ($tbbtn[3]); ?></td>
                                <td style="color:#656565" colspan="2"><span class="redcolor">*</span>如果开启审批同步，只有当前等级审批人全部通过后才进行下一级的审批。</td>
                            </tr>
                        </table>
                        <span class="shuoming"><span class="redcolor">*</span>超级管理员自动可以审批所有开票。</span>
                        <span class="shuoming"><span class="redcolor">*</span>审批人可以审批开票，也可将审批通过的开票驳回。</span>
                        <span class="shuoming"><span class="redcolor">*</span>开票提交人上级是指提交人的主管，以及提交人主管的主管，以此类推。</span>
                        <span class="shuoming"><span class="redcolor">*</span>固定审批人，最多可选择7人。</span>
                        <span class="shuoming"><span class="redcolor">*</span>如开票提交后，没有对应的审批人时，会自动通过开票审批</span>
                        <span class="shuoming redcolor">（例如，审批人仅设置了“提交人上级”，而提交人没有上级，则提交合同审批后，此合同自动通过审批。）</span>
                        <button class="layui-btn" onclick="shenpibc3()" style="height:30px;line-height:30px">保存</button>
                    </div>
                </div><!--开票审批结束-->
            </div>
        </div>
    </div>
</div>
</body>
<!--1级审批人选择框-->
<div class="fdiv" id="shenpiren1" style="padding:10px;">
    <select id="tanchuangsel1" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="showshenpidiv1" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--2级审批人选择框-->
<div class="fdiv" id="shenpiren2" style="padding:10px;">
    <select id="tanchuangsel2" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="showshenpidiv2" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--3级审批人选择框-->
<div class="fdiv" id="shenpiren3" style="padding:10px;">
    <select id="tanchuangsel3" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="showshenpidiv3" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--回款审批人选择框-->
<div class="fdiv" id="huikuandiv" style="padding:10px;">
    <select id="huikuansel" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="huikuanshow" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--开票-1级审批人选择框-->
<div class="fdiv" id="kaipiaoshenpiren1" style="padding:10px;">
    <select id="kaipiaotanchuangsel1" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="kaipiaoshowshenpidiv1" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--开票-2级审批人选择框-->
<div class="fdiv" id="kaipiaoshenpiren2" style="padding:10px;">
    <select id="kaipiaotanchuangsel2" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="kaipiaoshowshenpidiv2" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<!--开票-3级审批人选择框-->
<div class="fdiv" id="kaipiaoshenpiren3" style="padding:10px;">
    <select id="kaipiaotanchuangsel3" style="height:30px;float:left;">
        <option value='0'>请选择审批人</option>
        <?php echo ($useroption); ?>
    </select>  
    <div id="kaipiaoshowshenpidiv3" style="margin-bottom:10px;float:left;margin-left:10px;width:400px;">
    </div>
</div>
<script>
    window.root_dir="<?php echo ($_GET['root_dir']); ?>";
    window.windowlvid='';
    window.xzbtn="<button class='layui-btn' style='height:30px;line-height:30px;margin-right:30px;' onclick='spxuanze(this)'>选择审批人</button>";
    window.xzbtn2="<button class='layui-btn' style='height:30px;line-height:30px;margin-right:30px;' onclick='spxuanze2(this)'>选择审批人</button>";
    window.spqy1='2';
    window.kpspqy1='2';
    window.spqy2='2';
    window.kpspqy2='2';
    window.spqy3='2';
    window.kpspqy3='2';
    window.hkspqy1='2';
    window.hkspqy2='2';
    window.hkspqy3='2';
    window.sptb='2';
    window.hksptb='2';
    window.kpsptb='2';
    //上方绿色提示框的关闭效果
    function hidden_div(){
        $("#mod1").hide();
    }
    //ajax同步
    $.ajaxSetup({
        async : false
    });
    //加载layui表单样式
    layui.use('form', function(){
        var form = layui.form();
        form.on('checkbox(sp_qy_1)', function(data){
            window.spqy1=data.elem.checked;
        });
        form.on('checkbox(sp_qy_2)', function(data){
            window.spqy2=data.elem.checked;
        });
        form.on('checkbox(sp_qy_3)', function(data){
            window.spqy3=data.elem.checked;
        });


        form.on('checkbox(hksp_qy_1)', function(data){
            window.hkspqy1=data.elem.checked;
        });
        form.on('checkbox(hksp_qy_2)', function(data){
            window.hkspqy2=data.elem.checked;
        });
        form.on('checkbox(hksp_qy_3)', function(data){
            window.hkspqy3=data.elem.checked;
        });

        form.on('checkbox(kpsp_qy_1)', function(data){
            window.kpspqy1=data.elem.checked;
        });
        form.on('checkbox(kpsp_qy_2)', function(data){
            window.kpspqy2=data.elem.checked;
        });
        form.on('checkbox(kpsp_qy_3)', function(data){
            window.kpspqy3=data.elem.checked;
        });

        form.on('checkbox(sp_tb1)', function(data){
            window.sptb=data.elem.checked;
        });
        form.on('checkbox(sp_tb2)', function(data){
            window.hksptb=data.elem.checked;
        });
        form.on('checkbox(sp_tb3)', function(data){
            window.kpsptb=data.elem.checked;
        });
    });
    //初始化layui的基础组件
    layui.use('element', function(){
         var element = layui.element();
    });
    //黑色半透明提示
    function tishi(neirong)
    {
        layer.msg(neirong, {
            time: 1500, 
        });
    }
    //下拉框监听事件
    $(".selectbox").change(function(){
        if($(this).hasClass("kpsel"))
        {
            return;
        }
        var thisid=$(this).attr("id").substr(3,1);//获得id的值，判断改变了哪个下拉框
        window.windowlvid=thisid;
        var selval=$(this).val();//选择的下拉框的值
        var thisshowtd='lv'+thisid;//当前审批人的级别--显示表格
        if(selval=="2")//如果选择了固定审批人
        {
            $("#lv"+windowlvid).show();
            $("#lv"+thisid).html(xzbtn);
        }
        else
        {
            $("#lv"+windowlvid).hide();
        }
    });
    $(".kpsel").on("change",function(){
        var thisid=$(this).attr("id").substr(4,1);//获得id的值，判断改变了哪个下拉框
        window.windowkplvid=thisid;
        var selval=$(this).val();//选择的下拉框的值
        var thisshowtd='lv'+thisid;//当前审批人的级别--显示表格
        if(selval=="2")//如果选择了固定审批人
        {
            $("#kplv"+windowkplvid).show();
            $("#kplv"+thisid).html(xzbtn2);
        }
        else
        {
            $("#kplv"+windowkplvid).hide();
        }
    });
    function spxuanze(thisid)
    {
        window.windowlvid=$(thisid).parent().parent().find("td").eq(1).children("select").prop("id").substr(3,1);
        layui.use('layer', function(){
            var layer = layui.layer;
            window.tanchu=layer.open({
                type:1,
                area:'600px',
                title: '选择审批人',
                content:$('#shenpiren'+windowlvid),
                btn: '保存',
                btn1: function(index, layero){
                    
                        var newtd=$("#showshenpidiv"+windowlvid).html();
                        $("#lv"+windowlvid).html(xzbtn+newtd);
                    layer.close(index);   
                }
            }); 
        });  
    }
    function spxuanze2(thisid)
    {
        window.windowlvid=$(thisid).parent().parent().find("td").eq(1).children("select").prop("id").substr(4,1);
        layui.use('layer', function(){
            var layer = layui.layer;
            window.tanchu=layer.open({
                type:1,
                area:'600px',
                title: '选择审批人',
                content:$('#kaipiaoshenpiren'+windowlvid),
                btn: '保存',
                btn1: function(index, layero){
                        var newtd=$("#kaipiaoshowshenpidiv"+windowlvid).html();
                        $("#kplv"+windowlvid).html(xzbtn2+newtd);
                    layer.close(index);   
                }
            }); 
        });  
    }
    //弹窗下拉框
    $("#tanchuangsel1").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#tanchuangsel1").children(".class"+thisid+"").hide();
            var oldhtml=$("#showshenpidiv1").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#showshenpidiv1").html(newhtml);
            $(this).val(0);
        }
    });
    $("#tanchuangsel2").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#tanchuangsel2").children(".class"+thisid+"").hide();
            var oldhtml=$("#showshenpidiv2").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#showshenpidiv2").html(newhtml);
            $(this).val(0);
        }
    });
    $("#tanchuangsel3").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#tanchuangsel3").children(".class"+thisid+"").hide();
            var oldhtml=$("#showshenpidiv3").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#showshenpidiv3").html(newhtml);
            $(this).val(0);
        }
    });
    //开票
    $("#kaipiaotanchuangsel1").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#kaipiaotanchuangsel1").children(".class"+thisid+"").hide();
            var oldhtml=$("#kaipiaoshowshenpidiv1").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi2(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#kaipiaoshowshenpidiv1").html(newhtml);
            $(this).val(0);
        }
    });
    $("#kaipiaotanchuangsel2").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#kaipiaotanchuangsel2").children(".class"+thisid+"").hide();
            var oldhtml=$("#kaipiaoshowshenpidiv2").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi2(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#kaipiaoshowshenpidiv2").html(newhtml);
            $(this).val(0);
        }
    });
    $("#kaipiaotanchuangsel3").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#kaipiaotanchuangsel3").children(".class"+thisid+"").hide();
            var oldhtml=$("#kaipiaoshowshenpidiv3").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=guanbi2(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#kaipiaoshowshenpidiv3").html(newhtml);
            $(this).val(0);
        }
    });
    //关闭审批人小蓝框
    function guanbi(athis){
        //获取到当前操作的是几级审批人
        var guanbilv=$(athis).parent().parent().attr("id").substr(-1,1);
        //获取id头部
        var idhead=$(athis).parent().parent().attr("id").substr(0,2);
        //获得当前的class中的id
        var nowclass=$(athis).parent().attr("class").substr(4);
        if(idhead=='lv')//如果点击的是主页面上的叉号，必须删除主页面和弹窗隐藏后的页面的篮框
        {
            $("#lv"+guanbilv).children(".span"+nowclass).remove();
        }
        $("#showshenpidiv"+guanbilv).children(".span"+nowclass).remove();
        $("#tanchuangsel"+guanbilv).children(".class"+nowclass).show();
    }
    //关闭审批人小蓝框--开票
    function guanbi2(athis){
        //获取到当前操作的是几级审批人
        var guanbilv=$(athis).parent().parent().attr("id").substr(-1,1);
        //获取id头部
        var idhead=$(athis).parent().parent().attr("id").substr(0,4);
        //获得当前的class中的id
        var nowclass=$(athis).parent().attr("class").substr(4);
        if(idhead=='kplv')//如果点击的是主页面上的叉号，必须删除主页面和弹窗隐藏后的页面的篮框
        {
            $("#kplv"+guanbilv).children(".span"+nowclass).remove();
        }
        $("#kaipiaoshowshenpidiv"+guanbilv).children(".span"+nowclass).remove();
        $("#kaipiaotanchuangsel"+guanbilv).children(".class"+nowclass).show();
    }
    //开启或关闭合同审批
    var shenpistatus="<?php echo ($sparr['sp_kq']); ?>";//开启状态，需要在数据库中查询
    if(shenpistatus=='1')
    {
        $("#shenpi-body").show();
        $('.tab-top').html("<button class='layui-btn' onclick='kaiqiguanbi(0)'>关闭合同审批</button>合同审批功能已经开启,如需要关闭，请先审批完成待审批合同。");
    }
    else
    {
        $("#shenpi-body").hide();
        $('.tab-top').html("<button class='layui-btn' onclick='kaiqiguanbi(1)'>开启合同审批</button>尚未开启合同审批功能。");
    }
    function kaiqiguanbi(val)
    {
        window.jiazai= layer.load(2);
        if(val=='0')
        {
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'0',"kqtype":'1'},function(res){
                layer.close(jiazai);
                tishi("合同审批已关闭");
            });
            $("#shenpi-body").hide();
            $('.tab-top').html("<button class='layui-btn' onclick='kaiqiguanbi(1)'>开启合同审批</button>尚未开启合同审批功能。");
        }
        else
        {
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'1',"kqtype":'1'},function(res){
                layer.close(jiazai);
                tishi("合同审批已开启");
            });
            $("#shenpi-body").show();
            $('.tab-top').html("<button class='layui-btn' onclick='kaiqiguanbi(0)'>关闭合同审批</button>合同审批功能已经开启,如需要关闭，请先审批完成待审批合同。");
        }
    }
    //合同回款审批
    var huikuanstatus="<?php echo ($hksparr['sp_kq']); ?>";
    if(huikuanstatus=='1')
    {
        $("#huikuan-body").show();
        $('.tab-top2').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(0)'>关闭合同回款审批</button>");
    }
    else
    {
        $("#huikuan-body").hide();
        $('.tab-top2').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(1)'>开启合同回款审批</button>尚未开启合同回款审批功能。");
    }
    function huikuankaiqiguanbi(hkval)
    {
        window.jiazai= layer.load(2);
        if(hkval=='0')
        {
            $("#huikuan-body").hide();
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'0',"kqtype":'2'},function(res){
                layer.close(jiazai);
                tishi("合同回款审批已关闭");
            });
            $('.tab-top2').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(1)'>开启合同回款审批</button>尚未开启合同回款审批功能。");
            huikuanstatus='0';
        }
        else
        {
            $("#huikuan-body").show();
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'1',"kqtype":'2'},function(res){
                layer.close(jiazai);
                tishi("合同回款审批已开启");
            });
            $('.tab-top2').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(0)'>关闭合同回款审批</button>");
            huikuanstatus='1';
        }
    }
    //开票审批
    var kaipiaostatus="<?php echo ($kpsparr['sp_kq']); ?>";
    if(kaipiaostatus=='1')
    {
        $("#kaipiao-body").show();
        $('.tab-top3').html("<button class='layui-btn' onclick='kaipiaokaiqiguanbi(0)'>关闭开票审批</button>");
    }
    else
    {
        $("#kaipiao-body").hide();
        $('.tab-top3').html("<button class='layui-btn' onclick='kaipiaokaiqiguanbi(1)'>开启开票审批</button>尚未开启开票审批功能。");
    }
    function kaipiaokaiqiguanbi(kpval)
    {
        window.jiazai= layer.load(2);
        if(kpval=='0')
        {
            $("#kaipiao-body").hide();
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'0',"kqtype":'3'},function(res){
                layer.close(jiazai);
                tishi("开票审批已关闭");
            });
            $('.tab-top3').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(1)'>开启开票审批</button>尚未开启开票审批功能。");
            kaipiaostatus='0';
        }
        else
        {
            $("#kaipiao-body").show();
            $.get(root_dir+"/index.php/Home/ShenpiDo/change_on_off",{"kqval":'1',"kqtype":'3'},function(res){
                layer.close(jiazai);
                tishi("开票审批已开启");
            });
            $('.tab-top3').html("<button class='layui-btn' onclick='huikuankaiqiguanbi(0)'>关闭开票审批</button>");
            kaipiaostatus='1';
        }
    }
    //回款审批人选择
    function hkxuanze()
    {
        layui.use('layer', function(){
            var layer = layui.layer;
            window.tanchu=layer.open({
                type:1,
                area:'600px',
                title: '选择审批人',
                content:$('#huikuandiv'),
                btn: '保存',
                btn1: function(index, layero){
                        var newtd=$("#huikuanshow").html();
                        $("#huikuanmainshow").html(newtd);
                    layer.close(index);   
                }
            }); 
        });  
    }
    //回款弹窗下拉框
    $("#huikuansel").change(function(){
        var thisid=$(this).val();
        var thistext=$(this).children("option[value='"+thisid+"']").text();
        if(thisid!='0')
        {
            $("#huikuansel").children(".class"+thisid+"").hide();
            var oldhtml=$("#huikuanshow").html();
            var newhtml=oldhtml+"<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span"+thisid+"'>"+thistext+"<a onclick=huikuanguanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
            $("#huikuanshow").html(newhtml);
            $(this).val(0);
        }
    });
    //回款关闭小蓝框
    function huikuanguanbi(athis)
    {
        //获取到当前操作的是几级审批人
        var guanbilv=$(athis).parent().parent().attr("id").substr(-1,1);
        //获取id头部
        var idhead=$(athis).parent().parent().attr("id");
        //获得当前的class中的id
        var nowclass=$(athis).parent().attr("class").substr(4);
        if(idhead=='huikuanmainshow')//如果点击的是主页面上的叉号，必须删除主页面和弹窗隐藏后的页面的篮框
        {
            $("#huikuanmainshow").children(".span"+nowclass).remove();
        }
        $("#huikuanshow").children(".span"+nowclass).remove();
        $("#huikuansel").children(".class"+nowclass).show();
    }
    //保存合同审批
    function shenpibc()
    {
        window.jiazai= layer.load(2);
        var sel1=$("#sel1").val();
        var sel2=$("#sel2").val();
        var sel3=$("#sel3").val();
        var ajaxstr="sp_tb:"+sptb+",sp_qy_1:"+spqy1+",sp_qy_2:"+spqy2+",sp_qy_3:"+spqy3+",sp_type_1:"+sel1+',sp_type_2:'+sel2+',sp_type_3:'+sel3;
        if(sel1=='2')
        {
            var spanid='';
            var havespan='0';
            
            $("#sel1").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_1:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择1级审批人");
                return false;
            }
        }
        if(sel2=='2')
        {
            var spanid='';
            var havespan='0';
            $("#sel2").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_2:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择2级审批人");
                return false;
            }
        }
        if(sel3=='2')
        {
            var spanid='';
            var havespan='0';
            $("#sel3").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_3:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择3级审批人");
                return false;
            }
        }
        $.post(root_dir+"/index.php/Home/ShenpiDo/baocun",{"ajaxstr":ajaxstr,"sptype":'1'},function(res){
            if(res=='1')
            {
                tishi("保存成功");
            }
            else if(res=='2')
            {
                tishi("保存失败");
            }
            else
            {
                tishi("保存失败，请刷新后重试");
            }
            layer.close(jiazai);
        });
    }
    //保存开票审批
    function shenpibc3()
    {
        window.jiazai= layer.load(2);
        var sel1=$("#sel21").val();
        var sel2=$("#sel22").val();
        var sel3=$("#sel23").val();//下拉框的值
        var ajaxstr="sp_tb:"+kpsptb+",sp_qy_1:"+kpspqy1+",sp_qy_2:"+kpspqy2+",sp_qy_3:"+kpspqy3+",sp_type_1:"+sel1+',sp_type_2:'+sel2+',sp_type_3:'+sel3;
        if(sel1=='2')
        {
            var spanid='';
            var havespan='0';
            
            $("#sel21").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_1:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择1级审批人");
                return false;
            }
        }
        if(sel2=='2')
        {
            var spanid='';
            var havespan='0';
            $("#sel22").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_2:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择2级审批人");
                return false;
            }
        }
        if(sel3=='2')
        {
            var spanid='';
            var havespan='0';
            $("#sel23").parent().parent().find("td").eq(2).find("span").each(function(){
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            });
            if(havespan=='1')
            {
                ajaxstr=ajaxstr+',sp_value_3:'+spanid;
                ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
            }
            else
            {
                layer.close(jiazai);
                tishi("请选择3级审批人");
                return false;
            }
        }
        $.post(root_dir+"/index.php/Home/ShenpiDo/baocun",{"ajaxstr":ajaxstr,"sptype":'3'},function(res){
            if(res=='1')
            {
                tishi("保存成功");
            }
            else if(res=='2')
            {
                tishi("保存失败");
            }
            else
            {
                tishi("保存失败，请刷新后重试");
            }
            layer.close(jiazai);
        });
    }
    //保存合同回款审批设置
    function baocun2()
    {
        window.jiazai= layer.load(2);
        var ajaxstr='';
        if(hkspqy1!='2')
        {
            ajaxstr+='sp_qy_1:'+hkspqy1+',';
        }
        if(hkspqy2!='2')
        {
            ajaxstr+='sp_qy_2:'+hkspqy2+',';
        }
        var spanid='';
        var havespan='0';
        $("#hksp_qy_3").parent().parent().children("td").find("span").each(function(){
            if($(this).attr("class")!=undefined)
            {
                spanid+=$(this).attr("class").substr(4)+'.';
                havespan='1';
            }
        });
        
        if(hkspqy3!='2')
        {
            ajaxstr+='sp_qy_3:'+hkspqy3+',';
        }
        if(havespan=='1')
        {
            spanid=spanid.substr(0,spanid.length-1);
                ajaxstr+='sp_value_3:'+spanid+',';
        }
        else
        {
            var hkgdsp=$("#hksp_qy_3").prop("checked");
            if(hkgdsp==true)
            {
                layer.close(jiazai);
                tishi("请选择审批人");
                return false;
            }
            else
            {
                ajaxstr+='sp_value_3:,';
            }
        }
        
        if(hksptb!='2')
        {
            ajaxstr+='sp_tb:'+hksptb+',';
        }
        ajaxstr=ajaxstr.substr(0,ajaxstr.length-1);
        $.post(root_dir+"/index.php/Home/ShenpiDo/baocun",{"ajaxstr":ajaxstr,"sptype":'2'},function(res){
            if(res=='1')
            {
                tishi("保存成功");
            }
            else if(res=='2')
            {
                tishi("保存失败");
            }
            else
            {
                tishi("保存失败，请刷新后重试");
            }
            layer.close(jiazai);
        });
    }
</script>
</html>