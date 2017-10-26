<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>线索</title>
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
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/xiansuo/xsinfo.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/time_axis.css">
<!--layUI-->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<!--select2-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/select2/css/select2.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/select2/js/select2.min.js"></script>
<!--UIKIT时间-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/datepicker.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/datepicker.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/sticky.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/sticky.js"></script>
<style>
</style>
</head>
<body>
<div id="box" style="display:none;">
    <div id="head">
        <span class="head_name"><?php echo ($title_title); ?></span>
        <span class="head_fuzeren">
            <span class="head_fuzeren_title">负责人：</span>
            <span class="head_fuzeren_name"><?php echo ($title_fuzeren); ?></span>
        </span>
        <div class="xiacigenjinshijian">下次跟进时间：<?php echo ($next_genjin_time); ?></div>
    </div>
    
    <div id="btn_div" data-uk-sticky="{clsactive:'asd'}">
        <button class="layui-btn layui-btn-primary" id="back_xiansuo"><i class="fa fa-reply"></i>返回</button>
        <button class="layui-btn layui-btn-primary" onclick="zhuankehu()"><i class="fa fa-user"></i>转成客户</button>
        <button class="layui-btn layui-btn-primary" onclick="zhuanyi()"><i class="fa fa-retweet"></i>转移给他人</button>
        <button class="layui-btn layui-btn-primary" onclick="bianji()"><i class="fa fa-edit"></i>编辑</button>
        <button class="layui-btn layui-btn-primary" onclick="shanchu()"><i class="fa fa-trash"></i>删除</button>
        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="layui-btn"><?php echo ($nowdongtai); ?> <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown" id="change_zhuangtai_link">
                    <?php echo ($top_right_dongtai); ?>
                </ul>
            </div>
        </div>
    </div>
    <div id="infobody">
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">基本信息</li>
                <li>附件</li>
            </ul>
            <div class="layui-tab-content">
                <!--选项卡1-->
                <div class="layui-tab-item layui-show">
                    <table id="jibenxinxi_table">
                        <tr>
                            <td id="jibenxinxi" valign="top">
                                <div>
                                    <div class="xxtitle">基本信息</div>
                                    <table>
                                       <?php echo ($xinxi_table); ?>
                                    </table>
                                    <div class="xxtitle">系统信息</div>
                                    <table>
                                        <tr>
                                            <td>负责人：</td>
                                            <td><?php echo ($xt_fuzeren); ?></td>
                                        </tr>
                                        <tr>
                                            <td>所属部门：</td>
                                            <td><?php echo ($xt_suoshubumen); ?></td>
                                        </tr>
                                        <tr>
                                            <td>创建时间：</td>
                                            <td><?php echo ($xt_chuangjianshijian); ?></td>
                                        </tr>
                                        <tr>
                                            <td>更新于：</td>
                                            <td><?php echo ($xt_gengxinyu); ?></td>
                                        </tr>
                                        <tr>
                                            <td>创建人：</td>
                                            <td><?php echo ($xt_chuangjianren); ?></td>
                                        </tr>
                                        <tr>
                                            <td>前负责人：</td>
                                            <td><?php echo ($xt_qianfuzeren); ?></td>
                                        </tr>
                                        <tr>
                                            <td>前负责部门：</td>
                                            <td><?php echo ($xt_qianfuzebumen); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td id="xiaoshoudongtai" valign="top">
                                <div class="xxtitle">
                                    销售动态
                                    <button class="layui-btn" id="add_genjin" onclick="xiegenjin()"><i class="fa fa-pencil"></i>写跟进</button>
                                </div>
                                <?php echo ($genjin_str); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--选项卡2-->
                <div class="layui-tab-item" id="tab2">
                    <div>
                        <button class="layui-btn" onclick="add_fujian()"><i class="fa fa-plus"></i>上传附件</button>
                    </div>
                    <div>
                        <table class="layui-table">
                            <thead>
                                <tr>
                                    <th>上传时间</th>
                                    <th>附件名称</th>
                                    <th>大小</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo ($fjtable); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!--批量转移-->
<div id="piliangzhuanyidiv">
    <span>新负责人：</span>
    <span class="uk-form">
        <select name="" id="">
            <option value="0">请选择用户</option>
            <?php echo ($tingxingshuikan); ?>
        </select>
    </span>
</div>
<!--写跟进-->
<div id="xiegenjindiv">
    <table class="uk-form">
        <tr>
            <td colspan="2">
                <select id="new_genjin_fangshi">
                    <?php echo ($genjinfangshi_option); ?>
                </select>
            </td>
            <td colspan="2" align="right">
                <input class="layui-input" placeholder="实际跟进时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm'})" value="<?php echo ($xiegenjin_now_time); ?>" id="new_genjin_time" />
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <textarea id="new_genjin_content"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                提醒谁看
            </td>
            <td colspan="3">
                <select id="tixingshuikan" class="js-example-basic-multiple" multiple="multiple">
                    <?php echo ($tingxingshuikan); ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>线索</td>
            <td><input type="text" disabled value="<?php echo ($title_title); ?>"></td>
            <td>跟进状态</td>
            <td>
                <select id="new_genjin_zhuangtai">
                    <?php echo ($xiegenjin_zhuangtai); ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>下次跟进时间</td>
            <td><input class="layui-input" placeholder="请选择下次跟进时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm'})" id="new_genjin_next_genjin_time"></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<!--新增线索div-->
<div id="xinzengxiansuodiv">
    <table class="uk-form">
        <?php echo ($add_table_str); ?>
    </table>
</div>
<!--添加附件-->
<div class="uk-form" id="fujian_div">
    <center>
    <table style="width:450px;">
        <tr>
            <td>附件 &nbsp;&nbsp;</td>
            <td class="info_content">
                <input type="file" name="xs_file" lay-type="file" class="layui-upload-file" id="imm"  />
                单个文件最大支持20MB，上传请耐心等待.
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="info_content">
                <div id="filebody" class="uk-alert" style="margin:10px 0 10px 0;height:30px;line-height:30px;">
                    <span id="filename" >12333333.txt</span>
                    <span id="fileclose" style="cursor:pointer;float:right;" onclick="delnowfile(this)"><i class="fa fa-trash" aria-hidden="true"></i></span>
                    <span id="filesize" style="float:right;margin-right:40px;">223.0K</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>备注 &nbsp;&nbsp;</td>
            <td class="info_content"><textarea></textarea></td>
        </tr>
    </table>
    </center>
</div>
<!--线索转客户要求填入联系人信息-->
<div id="xs_to_kh_div" class="uk-form">
    <table>
        <tr>
            <td>客户名称：</td>
            <td><input type="text" id="khname" value="<?php echo ($kh_name); ?>" /></td>
        </tr>
        <tr>
            <td>联系人姓名：</td>
            <td><input type="text" id="lxrname" placeholder="" value="<?php echo ($title_title); ?>" /></td>
        </tr>
        <tr>
            <td>联系人电话：</td>
            <td><input type="text" id="lxrphone" placeholder="请填写该客户的联系人电话"></td>
        </tr>
    </table>
</div>
<script>
//获取URL的绝对路径
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
window.diqu_is_load=0;
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 2000, 
        color:"#fff"
    });
}
//上传控件初始化
layui.use('upload', function(){
  layui.upload(options);
});
layui.use('element', function(){
  var element = layui.element();
});
layui.use('laydate', function(){});
$(function(){
    $("#tixingshuikan").select2();
    //监听返回按钮点击
    $("#back_xiansuo").on("click",function(){
        var now_val=get_url_val("none");
        window.location=root_dir+"/index.php/Home/Xiansuo/index?"+now_val;
    });
    //隐藏编辑弹出层中需要隐藏的行
    add_hide_to_hide();
    //编辑-展开更多按钮点击事件
    $(".add_show_btn").on("click",function(){
        $("#xinzengxiansuodiv").find("tr").show("fast");
        $(this).parent().parent().hide();
    });
    //监听地区下拉三级联动
    add_diqu_listen();
    //右上角修改跟进状态的快捷方式
    $("#change_zhuangtai_link").find("li").on("click",function(){
        window.jiazai=layer.load(2);
        var this_canshu_id=$(this).prop("id").substr(23);
        var this_xs_id="<?php echo ($_GET['xs_id']); ?>";
        this_xs_id=this_xs_id.substr(6);
        $.get(root_dir+"/index.php/Home/Xiansuo/change_zhuangtai",{"this_xs_id":this_xs_id,"this_canshu_id":this_canshu_id},function(res){
            if(res=='1')
            {
                location.reload();
            }
            else
            {
                tishi("修改失败，请稍后重试");
                layer.close(jiazai);
                return false;
            }
        });
    });
    //获取当前负责人，用于编辑时比对
    window.now_fz=$("#add_fuzeren").find("select").val();
    //从客户页进来时隐藏一些按钮
    var main_type="<?php echo ($is_to_kh); ?>";
    if(main_type=='1')
    {
        $("#btn_div").children("button").eq(1).hide();
        $("#btn_div").children("button").eq(2).hide();
        $("#btn_div").children("button").eq(3).hide();
        $(".uk-button-dropdown").hide();
        $("#add_genjin").hide();
        $("#tab2").find(".layui-btn").hide();
    }
    //如果是附件页面的刷新  就跳到附件页面
    var tofj="<?php echo ($_GET['tofj']); ?>";
    if(tofj=='1')
    {
        $(".layui-show").removeClass("layui-show");
        $("#tab2").addClass("layui-show");
        $(".layui-this").removeClass("layui-this");
        $(".layui-tab-title").children("li").eq(1).addClass("layui-this");
    }
    //显示渐入页面
    setTimeout(function() {
        $("#box").fadeIn();
    }, 100);
});
//写跟进
function xiegenjin()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '写跟进',
            area:"600px",
            btn:["保存","取消"],
            content:$("#xiegenjindiv"),
            btn1:function(index,layero){
                window.jiazai=layer.load(2);

                var new_genjin_str='';
                var new_genjin_fangshi=$("#new_genjin_fangshi").val();
                var new_genjin_time=$("#new_genjin_time").val();
                var new_genjin_content=$("#new_genjin_content").val();
                var new_genjin_xiansuo="<?php echo ($_GET['xs_id']); ?>";
                new_genjin_xiansuo=new_genjin_xiansuo.substr(6);
                var new_genjin_zhuangtai=$("#new_genjin_zhuangtai").val();
                var new_genjin_next_genjin_time=$("#new_genjin_next_genjin_time").val();

                if(new_genjin_time=='')
                {
                    tishi("跟进时间不能为空");
                    layer.close(jiazai);
                    return;
                }
                if(new_genjin_content=='')
                {
                    tishi("跟进内容不能为空");
                    layer.close(jiazai);
                    return;
                }
                if(new_genjin_next_genjin_time=='')
                {
                    tishi("请选择下次跟进时间");
                    layer.close(jiazai);
                    return;
                }
                $.post(root_dir+"/index.php/Home/Xiansuo/add_new_genjin",{"new_genjin_fangshi":new_genjin_fangshi,"new_genjin_time":new_genjin_time,"new_genjin_content":new_genjin_content,"new_genjin_xiansuo":new_genjin_xiansuo,"new_genjin_zhuangtai":new_genjin_zhuangtai,"new_genjin_next_genjin_time":new_genjin_next_genjin_time},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else
                    {
                        tishi("添加失败，请稍后重试");
                        layer.close(jiazai);
                        return false;
                    }
                });
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
    
    setTimeout(function() {
        $("#xiegenjindiv").find("textarea").select();
    }, 300);
}
//隐藏添加线索弹出层中需要隐藏的行
function add_hide_to_hide(hidetime)
{
    hidetime=hidetime==''?0:hidetime;
    var can_hide=0;
    setTimeout(function() {
        $("#xinzengxiansuodiv").find("tr").each(function(){
            if(can_hide!=0)
            {
                $(this).hide();
            }
            if($(this).find(".add_show_btn").length==1)
            {
                can_hide=1;
            }
        });
        $(".add_show_btn").parent().parent().show();
    }, hidetime);
}
//编辑
function bianji()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '编辑线索',
            area:"600px",
            offset:'t',
            fixed: false,
            btn:["保存","取消"],
            content:$("#xinzengxiansuodiv"),
            btn1:function(index,layero){
                window.jiazai=layer.load(2);
                var ajax_str='';
                var have_diqu=0;
                var need_stop=0;
                $("#xinzengxiansuodiv").find("tbody").children("tr").each(function(){
                    if($(this).children("td").eq(1).html()=='')
                    {
                        return true;
                    }
                    var this_zd_id=$(this).prop("id").substr(4);
                    var this_zd_val='';
                    if(this_zd_id=='zdy11')
                    {
                        this_zd_val=$(this).children("td").eq(1).children("select").eq(0).val()+','+$(this).children("td").eq(1).children("select").eq(1).val()+','+$(this).children("td").eq(1).children("select").eq(2).val();
                        have_diqu=1;
                    }
                    else if(this_zd_id=='zdy17')
                    {
                        this_zd_val=$(this).children("td").eq(1).children("textarea").val();
                    }
                    else if(this_zd_id=='zdy14'||this_zd_id=='zdy15')
                    {
                        this_zd_val=$(this).children("td").eq(1).children("select").val();
                    }
                    else if(this_zd_id=='fuzeren')
                    {
                        this_zd_val=$(this).children("td").eq(1).children("select").val();
                    }
                    else
                    {
                        this_zd_val=$(this).children("td").eq(1).children("input").val();
                    }
                    if($(this).find(".redstar").prop("class")=='redstar')
                    {
                        if($(this).find("select").prop("tagName")=="SELECT")
                        {
                            if(this_zd_val==''||this_zd_val=='0')
                            {
                                need_stop=1;
                            }
                        }
                        if($(this).find("input").prop("tagName")=="INPUT"||$(this).find("textarea").prop("tagName")=="TEXTAREA")
                        {
                            if(this_zd_val=='')
                            {
                                need_stop=1;
                            }
                        }
                    }
                    ajax_str+='"'+this_zd_id+'":"'+this_zd_val+'",';
                });
                
                if(have_diqu==1)
                {
                    var diquname1=$("#add_zdy11").children("td").eq(1).children("select").eq(0).find("option:selected").text()=='请选择省'?'':$("#add_zdy11").children("td").eq(1).children("select").eq(0).find("option:selected").text();
                    var diquname2=$("#add_zdy11").children("td").eq(1).children("select").eq(1).find("option:selected").text()=='请选择市'?'':$("#add_zdy11").children("td").eq(1).children("select").eq(1).find("option:selected").text();
                    var diquname3=$("#add_zdy11").children("td").eq(1).children("select").eq(2).find("option:selected").text()=='请选择区'?'':$("#add_zdy11").children("td").eq(1).children("select").eq(2).find("option:selected").text();
                    if($("#add_zdy11").find(".redstar").prop("class")=='redstar')
                    {
                        if(diquname1==''||diquname2==''||diquname3=='')
                        {
                            need_stop=1;
                        }
                    }
                    var diquname=diquname1+diquname2+diquname3;
                    ajax_str+='"diquname":"'+diquname+'",';
                }
                
                if(need_stop==1)
                {
                    layer.close(jiazai);
                    tishi("必填项不能为空");
                    return false;
                }
                ajax_str='{'+ajax_str.substr(0,ajax_str.length-1)+'}';
                var this_xs_id="<?php echo ($_GET['xs_id']); ?>";
                this_xs_id=this_xs_id.substr(6);
                $.post(root_dir+"/index.php/Home/Xiansuo/edit_xs",{"ajax_str":ajax_str,"this_xs_id":this_xs_id,"now_fz":now_fz},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else
                    {
                        layer.close(jiazai);
                        tishi("添加失败，请稍后重试");
                    }
                });
                
            },
            btn2:function(index,layero){
                layer.close(index);
                add_hide_to_hide(200);
            },
            cancel: function(index, layero){ 
                add_hide_to_hide(200);
            }
        }); 
    });
}
//转移给他人
function zhuanyi()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '转移给他人',
            area:"500px",
            fixed: false,
            btn:["确定","取消"],
            content:$("#piliangzhuanyidiv"),
            btn1:function(index,layero){
                window.jiazai=layer.load(2);
               var to_user_id=$("#piliangzhuanyidiv").find("select").val();
               var need_to_user_xs="<?php echo ($_GET['xs_id']); ?>";
               need_to_user_xs=need_to_user_xs.substr(6);
               if(to_user_id==''||to_user_id=='0')
               {
                   tishi("请选择需要转移的用户");
                   return;
               }
               $.get(root_dir+"/index.php/Home/Xiansuo/change_fuzeren",{to_user_id:to_user_id,"need_to_user_xs":need_to_user_xs},function(res){
                    if(res=='1')
                    {
                        window.location.reload();
                    }
                    else
                    {
                        tishi("转移失败，请稍后重试");
                        layer.close(jiazai);
                        return;
                    }
               });
                
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
}
//监听地区三级联动
function add_diqu_listen()
{
    var sheng='0';
    if(diqu_is_load==0)
    {
        jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/index_js_css/datas/area_data.js", function(data, status, jqxhr) {
            jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/xiansuo/diqu.js", function(data, status, jqxhr) {
                $("#xinzengxiansuodiv").find(".add_diqu").eq(0).on("change",function(){
                    if($(this).val()!=0)
                    {
                        var shi=get_diqu2($(this).val());
                        $("#xinzengxiansuodiv").find(".add_diqu").eq(1).html('<option value="0">请选择市</option>'+shi);
                        $("#xinzengxiansuodiv").find(".add_diqu").eq(2).html('<option value="0">请选择区</option>');
                        sheng=$(this).val();
                    }
                });
                $("#xinzengxiansuodiv").find(".add_diqu").eq(1).on("change",function(){
                    if($(this).val()!=0)
                    {
                        var qu=get_diqu3(sheng,$(this).val());
                        $("#xinzengxiansuodiv").find(".add_diqu").eq(2).html('<option value="0">请选择区</option>'+qu);
                    }
                });
            });
        });
        diqu_is_load=1;
    }
    else
    {
        $("#xinzengxiansuodiv").find(".add_diqu").eq(0).on("change",function(){
            if($(this).val()!=0)
            {
                var shi=get_diqu2($(this).val());
                $("#xinzengxiansuodiv").find(".add_diqu").eq(1).html('<option value="0">请选择市</option>'+shi);
                $("#xinzengxiansuodiv").find(".add_diqu").eq(2).html('<option value="0">请选择区</option>');
                sheng=$(this).val();
            }
        });
        $("#xinzengxiansuodiv").find(".add_diqu").eq(1).on("change",function(){
            if($(this).val()!=0)
            {
                var qu=get_diqu3(sheng,$(this).val());
                $("#xinzengxiansuodiv").find(".add_diqu").eq(2).html('<option value="0">请选择区</option>'+qu);
            }
        });
    }
}
//转成客户
function zhuankehu()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_xs_to_kh']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有将线索转成客户的权限");
        return;
    }
    setTimeout(function() {
        //tishi("请完善客户信息");
    }, 200);
     layui.use('layer', function(){
        var layer = layui.layer;
        window.zhuankehudiv=layer.open({
            type:1,
            title: '完善客户信息',
            fixed: false,
            area:'500px',
            btn:["转成客户","取消"],
            content:$("#xs_to_kh_div"),
            btn1:function(index,layero){
                var zdy0=$("#khname").val();
                var lxrname=$("#lxrname").val();
                var lxrphone=$("#lxrphone").val();
                if(zdy0=='')
                {
                    tishi("客户名称不能为空");
                    return;
                }
                if(lxrname=='')
                {
                    tishi("联系人姓名不能为空");
                    return;
                }
                if(lxrphone=='')
                {
                    tishi("联系人电话不能为空");
                    return;
                }
                layer.open({
                    type:0,
                    title: '提示',
                    fixed: false,
                    btn:["确定","取消"],
                    content:"确定将此线索转成客户？",
                    btn1:function(index,layero){
                        window.jiazai=layer.load(2);
                        var thisxsid="<?php echo ($_GET['xs_id']); ?>";
                        thisxsid=thisxsid.substr(6);
                        $.get(root_dir+"/index.php/Home/Xiansuo/xs_to_kh",{"thisxsid":thisxsid,"zdy0":zdy0,"lxrname":lxrname,"lxrphone":lxrphone},function(res){
                            if(res=='1')
                            {
                                window.location=root_dir+"/index.php/Home/Xiansuo/index";
                            }
                            else if(res=='2')
                            {
                                layer.close(jiazai);
                                tishi("当前没有设置负责人，无法转为客户");
                                return false;
                            }
                            else
                            {
                                tishi("操作失败，请稍后重试");
                                layer.close(jiazai);
                                return false;
                            }
                        });
                    },
                    btn2:function(index,layero){
                        layer.close(index);
                    }
                }); 
            },
            btn2:function(index,layero){
                layer.close(zhuankehudiv);
            }
        }); 
    });
}
//删除
function shanchu()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_xs_del']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有删除线索的权限");
        return;
    }
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:0,
            title: '提示',
            fixed: false,
            btn:["确定","取消"],
            content:"确定删除此线索？",
            btn1:function(index,layero){
                window.jiazai=layer.load(2);
                var xsid="<?php echo ($_GET['xs_id']); ?>";
                xsid=xsid.substr(6);
                $.get(root_dir+"/index.php/Home/Xiansuo/del_more",{"sel_xs":xsid},function(res){
                    if(res=='1')
                    {
                        var now_page_url=get_url_val("none");
                        window.location=root_dir+"/index.php/Home/Xiansuo/index?"+now_page_url;
                    }
                    else
                    {
                        tishi("删除失败，请稍后重试");
                        layer.close(jiazai);
                        return false;
                    }
                });
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
}
//上传附件
function add_fujian()
{
    window.clickdelnowfile='0';
    var is_upload='';
    var oldoldname='';
    //显示文件上传按钮
    layui.upload({
        url: "/index.php/Home/Xiansuo/xs_file",
        title:"选择文件",
        before: function(input){
            //返回的参数item，即为当前的input DOM对象
            window.jiazai= layer.load(2);
            //tishi('文件上传中');
        },
        success: function(res){
            if(res['res']=='1')
            {
                $("#filename").text(res['oldname']);
                $("#filesize").text(res['newsize']);
                $("#filebody").show();
                $("#fileclose").prop("name",res['newname']);
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Xiansuo/del_old_file",{"oldname":is_upload});
                }
                is_upload=res['newname'];
                oldoldname=res['oldoldname'];
                clickdelnowfile='0';
                layer.close(jiazai);
            }
            else
            {
                layer.close(jiazai);
                tishi("上传失败，请稍后重试");
            }
        },
    });

    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            area:"600px",
            title: '上传附件',
            content:$("#fujian_div"),
            btn:["开始上传","取消"],
            btn1:function(index,layero){
                var fj_bz=$("#fujian_div").find("textarea").val();//备注
                var fj_size=$("#filesize").text();//文件大小
                var thisxsid="<?php echo ($_GET['xs_id']); ?>";//id
                thisxsid=thisxsid.substr(6);
                if(is_upload==''||clickdelnowfile!='0')
                {
                    tishi("请选择需要上传的附件");
                    return false;
                }
                $.post(root_dir+"/index.php/Home/Xiansuo/add_xsfile_info",{"fjbz":fj_bz,"fjmc":is_upload,"fjdx":fj_size,"fjxsid":thisxsid,"oldoldname":oldoldname},function(res){
                    if(res=='1')
                    {
                        tishi("上传成功");
                        reload_to_fujian()
                        layer.close(index);

                    }
                    else
                    {
                        tishi("上传失败，请稍后重试");
                        $.get(root_dir+"/index.php/Home/Xiansuo/del_old_file",{"oldname":is_upload});
                        is_upload='';
                        oldoldname='';
                        return false;
                    }
                });
            },
            btn2:function(index,layero){
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Xiansuo/del_old_file",{"oldname":is_upload});
                }
                layer.close(index);
                setTimeout(function() {
                    $("#filebody").hide();
                }, 300);
            },
            cancel: function(index, layero){ 
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Xiansuo/del_old_file",{"oldname":is_upload});
                }
                layer.close(index); 
                setTimeout(function() {
                    $("#filebody").hide();
                }, 300);               
            }
        }); 
    });  
}
//点击删除当前已上传的文件
function delnowfile(thisdom)
{
    window.jiazai=layer.load(2);
    clickdelnowfile='1';
    var nowupfilename=$(thisdom).prop("name");
    if(nowupfilename!='')
    {
        $.get(root_dir+"/index.php/Home/Xiansuo/del_old_file",{"oldname":nowupfilename},function(){
            layer.close(jiazai);
        });
        
    }
    $("#filebody").hide();
}
//附件下载
function file_xiazai(fjid)
{
    window.location=root_dir+"/index.php/Home/Xiansuo/fj_download?fjid="+fjid;
}
//附件删除
function file_shanchu(fjid)
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:0,
            title: '提示',
            fixed: false,
            btn:["确定","取消"],
            content:"确定删除此附件吗？<br>此操作成功后不可恢复",
            btn1:function(index,layero){
                window.jiazai=layer.load(2);
                $.get(root_dir+"/index.php/Home/Xiansuo/del_fujian",{"fjid":fjid},function(res){
                    if(res=='1')
                    {
                        reload_to_fujian()
                    }
                    else
                    {
                        layer.close(jiazai);
                        tishi("删除失败，请稍后重试");
                        return;
                    }
                });
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
}
function reload_to_fujian()
{
    var xsid="<?php echo ($_GET['xs_id']); ?>";
    var now_page_url=get_url_val("none");
    window.location=root_dir+"/index.php/Home/Xiansuo/xsinfo?tofj=1&xs_id="+xsid+now_page_url;
}
//获取URL中剩余的值，可以删除一个值
function get_url_val(without)
{
    var now_sx='';
    if("<?php echo ($_GET['sheng']); ?>"!=''&&without!="sheng")
    {
        now_sx+="&sheng="+"<?php echo ($_GET['sheng']); ?>";
    }
    if("<?php echo ($_GET['shi']); ?>"!=''&&without!="shi"&&without!="sheng")
    {
        now_sx+="&shi="+"<?php echo ($_GET['shi']); ?>";
    }
    if("<?php echo ($_GET['qu']); ?>"!=''&&without!="qu"&&without!="shi"&&without!="sheng")
    {
        now_sx+="&qu="+"<?php echo ($_GET['qu']); ?>";
    }
    if("<?php echo ($_GET['xiansuolaiyuan']); ?>"!=''&&without!="xiansuolaiyuan")
    {
        now_sx+="&xiansuolaiyuan="+"<?php echo ($_GET['xiansuolaiyuan']); ?>";
    }
    if("<?php echo ($_GET['genjinzhuangtai']); ?>"!=''&&without!="genjinzhuangtai")
    {
        now_sx+="&genjinzhuangtai="+"<?php echo ($_GET['genjinzhuangtai']); ?>";
    }
    if("<?php echo ($_GET['shijigenjinshijian']); ?>"!=''&&without!="shijigenjinshijian")
    {
        now_sx+="&shijigenjinshijian="+"<?php echo ($_GET['shijigenjinshijian']); ?>";
    }
    if("<?php echo ($_GET['xiacigenjinshijian']); ?>"!=''&&without!="xiacigenjinshijian")
    {
        now_sx+="&xiacigenjinshijian="+"<?php echo ($_GET['xiacigenjinshijian']); ?>";
    }
    if("<?php echo ($_GET['chuangjianshijian']); ?>"!=''&&without!="chuangjianshijian")
    {
        now_sx+="&chuangjianshijian="+"<?php echo ($_GET['chuangjianshijian']); ?>";
    }
    if("<?php echo ($_GET['gengxinyu']); ?>"!=''&&without!="gengxinyu")
    {
        now_sx+="&gengxinyu="+"<?php echo ($_GET['gengxinyu']); ?>";
    }
    if("<?php echo ($_GET['suoshubumen']); ?>"!=''&&without!="suoshubumen")
    {
        now_sx+="&suoshubumen="+"<?php echo ($_GET['suoshubumen']); ?>";
    }
    if("<?php echo ($_GET['chuangjianren']); ?>"!=''&&without!="chuangjianren")
    {
        now_sx+="&chuangjianren="+"<?php echo ($_GET['chuangjianren']); ?>";
    }
    if("<?php echo ($_GET['fuzeren']); ?>"!=''&&without!="fuzeren")
    {
        now_sx+="&fuzeren="+"<?php echo ($_GET['fuzeren']); ?>";
    }
    if("<?php echo ($_GET['qianfuzeren']); ?>"!=''&&without!="qianfuzeren")
    {
        now_sx+="&qianfuzeren="+"<?php echo ($_GET['qianfuzeren']); ?>";
    }
    if("<?php echo ($_GET['page']); ?>"!=''&&without!="page")
    {
        now_sx+="&page="+"<?php echo ($_GET['page']); ?>";
    }
    if("<?php echo ($_GET['search']); ?>"!=''&&without!="search")
    {
        now_sx+="&search="+"<?php echo ($_GET['search']); ?>";
    }
    if("<?php echo ($_GET['main_type']); ?>"!=''&&without!="main_type")
    {
        now_sx+="&main_type="+"<?php echo ($_GET['main_type']); ?>";
    }
    return now_sx;
}
</script>
</html>