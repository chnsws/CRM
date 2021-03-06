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
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/xiansuo/main.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/cctable/cctable.css">
<!--layUI-->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<!--UIKIT时间-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/components/datepicker.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/datepicker.js"></script>
<style>
</style>
</head>
<body>
<div id="box" style="display:none;">
    <div id="head">
        <sapn class="head_title">线索</sapn>
        <sapn class="head_tab">
            <span class="head_tab_show" >全部线索</span>
            <span class="head_tab_show">我的线索</span>
            <span class="head_tab_show">我下属的线索</span>
            <span class="head_tab_show">已转客户的线索</span>
        </sapn>
        <span class="t_r_btn">
            <button class="layui-btn" id="xinzengxiansuo" onclick="xinzengxiansuo(this)"><i class="fa fa-plus"></i>新增线索</button>
            
            <button id="daorubtn" class="layui-btn layui-btn-primary" onclick="daoru()">导入线索</button>
            <!--<button class="layui-btn layui-btn-primary" onclick="daochu()">导出线索</button>-->
            
        </span>
    </div>
    <div class="sx_div">
        <div class="sx_setting"><i class="fa fa-cog" id="setting_btn" onclick="sx_setting()"></i></div>
        <div class="sx_body" id="shaixuan">
            <div class="textalign shaixuan_show" id="xiansuolaiyuan">
                <span class="sx_title">线索来源：</span>
                <span class="sx_xx">全部</span>
                <?php echo ($sx_cs[zdy15]); ?>
            </div>
            <div class="textalign shaixuan_show" id="genjinzhuangtai">
                <span class="sx_title">跟进状态：</span>
                <span class="sx_xx">全部</span>
                <?php echo ($sx_cs[zdy14]); ?>
            </div>
            <div class="textalign shaixuan_show" id="shijigenjinshijian">
                <span class="sx_title">实际跟进时间：</span>
                <span class="sx_xx">全部</span>
                <span class="sx_xx">今天</span>
                <span class="sx_xx">昨天</span>
                <span class="sx_xx">本周</span>
                <span class="sx_xx">上周</span>
                <span class="sx_xx">本月</span>
                <span class="sx_xx">上月</span>
                <span class="sx_xx zdysj">自定义时间段</span>
            </div>
            <div style="display:none;">
                <span class="sx_title">请选择时间段：</span>
                <span id="time_select_group" class="uk-form top_line">
                    <input type="text" class="start_time" placeholder="请选择开始时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <span class="mid_span">-</span>
                    <input type="text" class="end_time"  placeholder="请选择结束时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <button class="layui-btn cx_btn">查询</button>
                </span>
            </div>
            <div class="textalign shaixuan_show" id="xiacigenjinshijian">
                <span class="sx_title">下次跟进时间：</span>
                <span class="sx_xx">全部</span>
                <span class="sx_xx">今天</span>
                <span class="sx_xx">昨天</span>
                <span class="sx_xx">本周</span>
                <span class="sx_xx">上周</span>
                <span class="sx_xx">本月</span>
                <span class="sx_xx">上月</span>
                <span class="sx_xx zdysj">自定义时间段</span>
            </div>
            <div style="display:none;">
                <span class="sx_title">请选择时间段：</span>
                <span id="time_select_group" class="uk-form top_line">
                    <input type="text" class="start_time" placeholder="请选择开始时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <span class="mid_span">-</span>
                    <input type="text" class="end_time"  placeholder="请选择结束时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <button class="layui-btn cx_btn">查询</button>
                </span>
            </div>
            <div class="textalign shaixuan_show" id="chuangjianshijian">
                <span class="sx_title">创建时间：</span>
                <span class="sx_xx">全部</span>
                <span class="sx_xx">今天</span>
                <span class="sx_xx">昨天</span>
                <span class="sx_xx">本周</span>
                <span class="sx_xx">上周</span>
                <span class="sx_xx">本月</span>
                <span class="sx_xx">上月</span>
                <span class="sx_xx zdysj">自定义时间段</span>
            </div>
            <div style="display:none;">
                <span class="sx_title">请选择时间段：</span>
                <span id="time_select_group" class="uk-form top_line">
                    <input type="text" class="start_time" placeholder="请选择开始时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <span class="mid_span">-</span>
                    <input type="text" class="end_time"  placeholder="请选择结束时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <button class="layui-btn cx_btn">查询</button>
                </span>
            </div>
            <div class="textalign shaixuan_show" id="gengxinyu">
                <span class="sx_title">更新于：</span>
                <span class="sx_xx">全部</span>
                <span class="sx_xx">今天</span>
                <span class="sx_xx">昨天</span>
                <span class="sx_xx">本周</span>
                <span class="sx_xx">上周</span>
                <span class="sx_xx">本月</span>
                <span class="sx_xx">上月</span>
                <span class="sx_xx zdysj">自定义时间段</span>
            </div>
            <div style="display:none;">
                <span class="sx_title">请选择时间段：</span>
                <span id="time_select_group" class="uk-form top_line">
                    <input type="text" class="start_time" placeholder="请选择开始时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <span class="mid_span">-</span>
                    <input type="text" class="end_time"  placeholder="请选择结束时间" data-uk-datepicker="{format:'YYYY-MM-DD'}">
                    <button class="layui-btn cx_btn">查询</button>
                </span>
            </div>
            <div class="diqu shaixuan_show">
                <span class="sx_title">地区：</span>
                <span class="sx_xx">
                    <select id="sheng">
                        <option value="0">请选择省</option>
                    </select>
                </span>
                <span class="sx_xx">
                    <select id="shi">
                        <option value="0">请选择市</option>
                    </select>
                </span>
                <span class="sx_xx">
                    <select id="qu">
                        <option value="0">请选择区</option>
                    </select>
                </span>
            </div>
            <div class="shaixuan_show">
                <span class="sx_title">所属部门：</span>
                <span class="sx_xx">
                    <select id="suoshubumen">
                        <option value="0">请选择部门</option>
                        <?php echo ($bm_option); ?>
                    </select>
                </span>
            </div>
            <div class="shaixuan_show">
                <span class="sx_title">创建人：</span>
                <span class="sx_xx">
                    <select id="chuangjianren">
                        <option value="0">请选择用户</option>
                        <?php echo ($chuangjian_user_option); ?>
                    </select>
                </span>
            </div>
            <div class="shaixuan_show">
                <span class="sx_title">负责人：</span>
                <span class="sx_xx">
                    <select id="fuzeren">
                        <option value="0">请选择用户</option>
                        <?php echo ($fuzeren_option); ?>
                    </select>
                </span>
            </div>
            <div class="shaixuan_show">
                <span class="sx_title">前负责人：</span>
                <span class="sx_xx">
                    <select id="qianfuzeren">
                        <option value="0">请选择用户</option>
                        <?php echo ($qianfuzeren_option); ?>
                    </select>
                </span>
            </div>
            
        </div>
    </div>
    <div id="sx_info" style="display:none;">
        当前选中：达大厦、阿斯达所、萨达撒大所、阿斯达所大所
    </div>
    <!--控制筛选区域的显示和隐藏-->
    <center><span id="sx_show_hide" onclick="sx_show_hide(this)"><i class="fa fa-chevron-up"></i></span></center>
    <div class="body_div">
        <div class="table_top_div">
            <div class="t_t_d_l">
                <button class="layui-btn layui-btn-primary" onclick="piliangzhuanyi()"><i class="fa fa-retweet"></i>批量转移</button>
                <button class="layui-btn layui-btn-primary" onclick="del_more()"><i class="fa fa-trash"></i>批量删除</button>
            </div>
            <div class="t_t_d_r uk-form">
                <select id="table_search_type">
                    <?php echo ($search_option); ?>
                </select>
                <input type="text" id="table_top_search_input" placeholder="输入需要搜索的内容" value="<?php echo ($search_input_str); ?>" />
                <span class="input_clear" onclick="document.getElementById('table_top_search_input').value='';this.style.display='none';table_top_search()">×</span>
                <button class="layui-btn layui-btn-primary" id="table_top_search_button"  onclick="table_top_search()"><i class="fa fa-search"></i>查询</button>
            </div>
        </div>
        <div class="body_table_div">
            <div class="cctable">
                <table class="layui-table">
                    <thead>
                        <tr>
                            <?php echo ($table_head); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo ($table_body); ?>
                    </tbody>
                </table>
            </div>
            <div class="fy_div" id="fy_div"></div>
        </div>
    </div>
</body>
<div id="sx_set_div" style="display:none;">
    <div>
        最多支持5个筛选字段
    </div>
    <div>
        <table class="layui-table">
            <thead>
                <tr>
                    <th>是否启用</th>
                    <th>支持筛选的字段</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>线索来源</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>跟进状态</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>实际跟进时间</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>下次跟进时间</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>创建时间</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>更新于</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>地区</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>所属部门</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>创建人</td>
                </tr>
                
                <tr>
                    <td><input type="checkbox"></td>
                    <td>负责人</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>前负责人</td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
<!--批量转移-->
<div id="piliangzhuanyidiv">
    <span>新负责人：</span>
    <span class="uk-form">
        <select name="" id="">
            <option value="0">请选择用户</option>
            <?php echo ($chuangjian_user_option); ?>
        </select>
    </span>
</div>
<!--新增线索div-->
<div id="xinzengxiansuodiv">
    <table class="uk-form">
        <?php echo ($add_table_str); ?>
    </table>
</div>
<!--线索导入DIV-->
<div id="daorudiv">
    <div class="daoru_shuoming">
        <div>1.下载数据模板后，将要导入的数据填充到数据导入模板文件中，再进行上传导入。</div>
        <div>2.模板中的表头不可更改，表头行不可删除。</div>
        <div>3.单次导入的数据不超过4000条。</div>
        <div>4.跟进状态、线索来源字段暂不支持导入。</div>
    </div>
    <div style="margin-top:20px;margin-bottom:10px;">
        <center>
        <input type="file" id="daoru" name="daoru" lay-type="file" class="layui-upload-file">
        </center>
    </div>
    <div id="filebody" class="uk-alert" style="margin:10px;height:40px;line-height:40px;display:none;">
        <span id="filename" >12333333.txt</span>
        <span id="fileclose" style="cursor:pointer;float:right;" onclick="delnowfile(this)"><i class="layui-icon" style="font-size: 20px; color: #1E9FFF;">&#x1006;</i></span>
        <span id="filesize" style="float:right;margin-right:40px;">223.0K</span>
    </div>
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
//ajax同步
$.ajaxSetup({
    async: false
});
//上传控件初始化
layui.use('upload', function(){
  layui.upload(options);
});
//分页初始化
layui.use(['laypage', 'layer'], function(){
    var laypage = layui.laypage
    ,layer = layui.layer;
    layui.laypage({
        pages:<?php echo ($max_page); ?>,
        skip:true,
        curr:<?php echo ($page_now); ?>,
        cont:$("#fy_div"),
        jump: function(obj, first){
            $(".layui-laypage-total").css("background","#f7f7f7");
            $("a").css("text-decoration","none");
            var check_page=$(".layui-laypage-curr").text();//切换分页时所选的页
            check_page=check_page==''?"1":check_page;
            if(check_page=="<?php echo ($page_now); ?>")
            {
                //防止第一次进入本页时触发
                return;
            }
            layer.load(2);
            var now_url=get_url_val("page");

            window.location=root_dir+'/index.php/Home/Xiansuo/index?page='+check_page+now_url;
        }
    });
});
layui.use('laydate', function(){});
$(function(){
    var main_type="<?php echo ($_GET['main_type']); ?>";
    if(main_type=='to_kh')
    {
        $("#xinzengxiansuo").hide();
    }
    //parent.aaload();
    //根据筛选设置显示需要显示的筛选栏
    var sx_config="<?php echo ($conarr); ?>";
    
    var have_diqu=0;
    if(sx_config.length!='')
    {
        sx_config=sx_config.split(',');
        for(a in sx_config)
        {
            $("#sx_set_div").find("tbody").children("tr").eq(sx_config[a]).find("input").prop("checked",true);
            $("#shaixuan").find(".shaixuan_show").eq(sx_config[a]).show();
            if(sx_config[a]=='6')
            {
                have_diqu=1;
            }
        }
    }
    else
    {
        $(".sx_body").html("未设置筛选字段");
    }

    $("#shaixuan").find("select").searchableSelect();
    //处理城市，如果有地区筛选就加载地区数据
    if(have_diqu==1)
    {
        if(diqu_is_load==0)
        {
            jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/index_js_css/datas/area_data.js", function(data, status, jqxhr) {
                jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/xiansuo/diqu.js", function(data, status, jqxhr) {
                    var sheng_id="<?php echo ($_GET['sheng']); ?>"==''?0:"<?php echo ($_GET['sheng']); ?>";
                    //替换省
                    var sheng=get_diqu1();
                    diqu_sel(0,sheng,sheng_id)
                    //替换市
                    var shi=get_diqu2(sheng_id);
                    var shi_id="<?php echo ($_GET['shi']); ?>"==''?0:"<?php echo ($_GET['shi']); ?>";
                    diqu_sel(1,shi,shi_id)
                    //替换区
                    var qu=get_diqu3(sheng_id,shi_id);
                    var qu_id="<?php echo ($_GET['qu']); ?>"==''?0:"<?php echo ($_GET['qu']); ?>";
                    diqu_sel(2,qu,qu_id);
                });
            });
            diqu_is_load=1;
        }
        else
        {
            var sheng_id="<?php echo ($_GET['sheng']); ?>"==''?0:"<?php echo ($_GET['sheng']); ?>";
            //替换省
            var sheng=get_diqu1();
            diqu_sel(0,sheng,sheng_id)
            //替换市
            var shi=get_diqu2(sheng_id);
            var shi_id="<?php echo ($_GET['shi']); ?>"==''?0:"<?php echo ($_GET['shi']); ?>";
            diqu_sel(1,shi,shi_id)
            //替换区
            var qu=get_diqu3(sheng_id,shi_id);
            var qu_id="<?php echo ($_GET['qu']); ?>"==''?0:"<?php echo ($_GET['qu']); ?>";
            diqu_sel(2,qu,qu_id)
        }
    }//地区处理结束
    var main_type="<?php echo ($_GET['main_type']); ?>"
    if(main_type=='my')
    {
        $(".head_tab_show").eq(1).removeClass("head_tab_show");
    }
    else if(main_type=='my_xs')
    {
        $(".head_tab_show").eq(2).removeClass("head_tab_show");
    }
    else if(main_type=='to_kh')
    {
        $(".head_tab_show").eq(3).removeClass("head_tab_show");
    }
    else
    {
        $(".head_tab_show").eq(0).removeClass("head_tab_show");
    }
    $(".head_tab").children("span").on("click",function(){
        var to_url='';
        if($(this).index()==1)
        {
            to_url='?main_type=my';
        }
        if($(this).index()==2)
        {
            to_url='?main_type=my_xs';
        }
        if($(this).index()==3)
        {
            to_url='?main_type=to_kh';
        }
        window.location=root_dir+"/index.php/Home/Xiansuo/index"+to_url;
    });
    //处理单项筛选的选中状态
    $(".textalign").each(function(){
        var thisid=$(this).prop("id");
        var get_val='';
        switch(thisid)
        {
            case "xiansuolaiyuan":
                get_val="<?php echo ($_GET['xiansuolaiyuan']); ?>";
            break;
            case "genjinzhuangtai":
                get_val="<?php echo ($_GET['genjinzhuangtai']); ?>";
            break;
            case "shijigenjinshijian":
                get_val="<?php echo ($_GET['shijigenjinshijian']); ?>";
            break;
            case "xiacigenjinshijian":
                get_val="<?php echo ($_GET['xiacigenjinshijian']); ?>";
            break;
            case "chuangjianshijian":
                get_val="<?php echo ($_GET['chuangjianshijian']); ?>";
            break;
            case "gengxinyu":
                get_val="<?php echo ($_GET['gengxinyu']); ?>";
            break;
        }
        if(get_val=='')
        {
            $(this).find(".sx_xx").eq(0).addClass("sx_this");
        }
        else
        {
            if(thisid=='xiansuolaiyuan'||thisid=='genjinzhuangtai')
            {
                $(this).find(".sx_xx[name='"+get_val+"']").addClass("sx_this");
            }
            else
            {
                if(get_val.length==1)
                {
                    $(this).children("span").eq(get_val).addClass("sx_this");
                }
                else
                {
                    $(this).children("span").eq(8).addClass("sx_this");
                    get_val_arr=get_val.split(',');
                    $(this).next().show();
                    $(this).next().find(".start_time").val(get_val_arr[0]);
                    $(this).next().find(".end_time").val(get_val_arr[1]);
                    var ssas=$(this);
                    setTimeout(function() {
                        ssas.children("span").eq(8).click();
                    }, 500);
                    
                }
            }
        }
    });
    //单项筛选选中状态处理结束
    //隐藏添加线索弹出层中需要隐藏的行
    add_hide_to_hide();
    //添加线索-展开更多按钮点击事件
    $(".add_show_btn").on("click",function(){
        $("#xinzengxiansuodiv").find("tr").show("fast");
        $(this).parent().parent().hide();
    });
    //单项筛选点击事件
    $(".sx_xx").on("click",function(){
        if(!$(this).parent().hasClass("textalign"))
        {
            return;
        }
        $(this).parent().children(".sx_xx").removeClass("sx_this");
        $(this).addClass("sx_this");
        var this_sx_name=$(this).parent().prop("id");
        var now_sx=get_url_val(this_sx_name);
        var thisval='';
        if($(this).hasClass("zdysj"))
        {
            $(this).parent().next("div").show();
            var sxxxthis=$(this);
            $(this).parent().next("div").find("button").on("click",function(){
                var st=sxxxthis.parent().next("div").find("input").eq(0).val();
                var et=sxxxthis.parent().next("div").find("input").eq(1).val();
                if(st==''||et=='')
                {
                    tishi("开始时间或结束时间不能为空");
                    return;
                }
                if(st>et)
                {
                    tishi("开始时间不能大于结束时间");
                    return;
                }
                thisval=st+','+et;
                window.location=root_dir+"/index.php/Home/Xiansuo/index?"+this_sx_name+"="+thisval+now_sx;
            });
            
            
        }
        else
        {
            if(this_sx_name=="xiansuolaiyuan"||this_sx_name=="genjinzhuangtai")
            {
                thisval=$(this).attr("name")==undefined?'':$(this).attr("name");
            }
            else
            {
                thisval=$(this).index();
            }
            window.location=root_dir+"/index.php/Home/Xiansuo/index?"+this_sx_name+"="+thisval+now_sx;
        }
        
    });
    //点击表格跳转到详细信息页面
    $(".cctable").find("td").on("click",function(){
        if($(this).index()==0)
        {
            return;
        }
        if($(this).parent("tr").prop("class")=='noinfo')
        {
            return;
        }
        var now_sx=get_url_val(0);
        var xs_id=$(this).parent().prop("class");
        window.location=root_dir+"/index.php/Home/Xiansuo/xsinfo?xs_id="+xs_id+now_sx;
    });
    //监听表头中的全选全不选
    $(".cctable").find("th").eq(0).children("input[type='checkbox']").on("change",function(){
        if($(this).prop("checked"))
        {
            $(".cctable").find("tbody").find("tr").each(function(){
                $(this).children("td").eq(0).children("input").prop("checked",true);
            });
        }
        else
        {
            $(".cctable").find("tbody").find("tr").each(function(){
                $(this).children("td").eq(0).children("input").prop("checked",false);
            });
        }
    });
    
    $(".layui-layer-title").on("click",function(){return false;})
    //搜索框清除按钮的处理
    $("#table_top_search_input").on("keyup",function(){
        if($(this).val()!='')
        {
            $(".input_clear").show();
        }
        else
        {
            $(".input_clear").hide();
        }
    });
    $("#table_top_search_input").val()==''?$(".input_clear").hide():$(".input_clear").show();
    //搜索框绑定回车事件
    $("#table_top_search_input").keydown(function (e) {
      var curKey = e.which;
      if (curKey == 13) {
        $("#table_top_search_button").click();
        return false;
      }
    });
    var main_type="<?php echo ($_GET['main_type']); ?>";
    if(main_type=='to_kh')
    {
        $(".t_t_d_l").children("button").eq(0).hide();
        $(".t_t_d_l").children("button").eq(1).css("margin-left","0px");
    }
    //其他页面隐藏导入按钮
    if(main_type!='')
    {
        $("#daorubtn").hide();
    }
    //显示渐入页面
    setTimeout(function() {
        $("#box").fadeIn();
    }, 100);
    //
});

//searchable的改变事件
var select_num=$(".sx_div").find("select").length;
function change_fun(dom)
{
    if(select_num!=0)
    {
        select_num--;
        return;
    }
    var thisid=dom.prop("id");
    var thisval=dom.val();
    var now_sx=get_url_val(thisid);
    window.location=root_dir+"/index.php/Home/Xiansuo/index?"+thisid+"="+thisval+now_sx;
}
//字段配置弹出层
function sx_setting()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '自定义筛选字段',
            area:["500px","500px"],
            btn:["确定","取消"],
            content:$("#sx_set_div"),
            btn1:function(index,layero){
                window.jiazai=layer.load(2);
                var sel_str='';
                var sel_num=0;
                $("#sx_set_div").find("tbody").find("input[type='checkbox']").each(function(){
                    if($(this).prop("checked")==true)
                    {
                        sel_str+=$(this).parent().parent().index()+',';
                        sel_num++;
                    }
                });
                if(sel_num>5)
                {
                    tishi("最多支持五个筛选字段");
                    layer.close(jiazai);
                    return;
                }
                sel_str=sel_str.substr(0,sel_str.length-1);
                $.get(root_dir+"/index.php/Home/Xiansuo/change_sx",{"sel_str":sel_str},function(res){
                    if(res==1)
                    {
                        window.location=root_dir+"/index.php/Home/Xiansuo/index";
                    }
                    else
                    {
                        tishi("保存失败，请稍后重试");
                        layer.close(jiazai);
                    }
                });
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
}
/*
setTimeout(function() {
    $("#shaixuan").find("select").append("<option value='123'>啊啊啊</option>");
    $(".diqu").children(".sx_xx").eq(0).children("div").remove();
    $(".diqu").children(".sx_xx").eq(0).children("select").searchableSelect();
    $("#shaixuan").find("select").append("<option value='123'>鹅鹅鹅</option>");
    $(".diqu").children(".sx_xx").eq(1).children("div").remove();
    $(".diqu").children(".sx_xx").eq(1).children("select").searchableSelect();
    alert('done')
    //$("#shaixuan").find("select").searchableSelect();
}, 3000);
*/
//控制筛选区域的显示和隐藏
function sx_show_hide(thisdom)
{
    //动画效果
    $(".sx_div").toggle("fast");
    var rmc=$(thisdom).children("i").prop("class")=='fa fa-chevron-up'?"fa-chevron-up":"fa-chevron-down";
    var adc=$(thisdom).children("i").prop("class")=='fa fa-chevron-up'?"fa-chevron-down":"fa-chevron-up";
    var settingtime=$(thisdom).children("i").prop("class")=='fa fa-chevron-up'?0:200;
    setTimeout(function() {
        $("#setting_btn").toggle();
    }, settingtime);
    $(thisdom).children("i").removeClass(rmc);
    $(thisdom).children("i").addClass(adc);
    //动画效果结束
}
//地区下拉框更新
function diqu_sel(sxindex,optionstr,optionval)
{
    $(".diqu").children(".sx_xx").eq(sxindex).children("select").append(optionstr);
    $(".diqu").children(".sx_xx").eq(sxindex).children("select").children("option[value='"+optionval+"']").prop("selected",true);
    $(".diqu").children(".sx_xx").eq(sxindex).children("div").remove();
    select_num++;
    $(".diqu").children(".sx_xx").eq(sxindex).children("select").searchableSelect();
}
//批量转移
function piliangzhuanyi()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '批量转移线索',
            area:["500px","160px"],
            btn:["确定","取消"],
            content:$("#piliangzhuanyidiv"),
            btn1:function(index,layero){
                var to_user_id=$("#piliangzhuanyidiv").find("select").val();
                if(to_user_id==''||to_user_id=='0')
                {
                    tishi("请选择新负责人");
                    return false;
                }
                var need_to_user_xs=get_sel_val();
                if(need_to_user_xs=='')
                {
                    tishi("没有勾选任何线索");
                    return false;
                }
                
                window.jiazai=layer.load(2);
                $.get(root_dir+"/index.php/Home/Xiansuo/change_fuzeren",{"to_user_id":to_user_id,"need_to_user_xs":need_to_user_xs},function(res){
                    if(res=='1')
                    {
                        window.location.reload();
                    }
                    else
                    {
                        tishi("操作失败，请稍后重试");
                        layer.close(jiazai);
                        return false;
                    }
                })

            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
}
//批量删除
function del_more()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_xs_del']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有删除线索的权限");
        return;
    }
    var sel_xs=get_sel_val();
    if(sel_xs=='')
    {
        tishi("没有勾选任何线索");
        return false;
    }
    layui.layer.msg("是否删除所选的线索？<br>该操作成功后，将无法恢复", {
        time: 9999999,
        btn: ['确认删除', '取消'],
        btn1: function(index, layero){
            window.jiazai=layer.load(2);
            $.get(root_dir+"/index.php/Home/Xiansuo/del_more",{"sel_xs":sel_xs},function(res){
                if(res=='1')
                {
                    location.reload();
                }
                else
                {
                    layer.close(jiazai);
                    tishi("删除失败,请稍后重试");
                    layer.close(index);
                    return false;
                }
            });
            
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//获取到多选内容
function get_sel_val()
{
    var need_to_user_xs='';
    $(".cctable").find("tbody").children("tr").each(function(){
        if($(this).children("td").eq(0).children("input").prop("checked")==true)
        {
            need_to_user_xs+=$(this).prop("class").substr(6)+',';
        }
    });
    need_to_user_xs=need_to_user_xs==''?'':need_to_user_xs.substr(0,need_to_user_xs.length-1);
    return need_to_user_xs;
}
//新增线索
function xinzengxiansuo(thisdom)
{
    
    $(thisdom).html("加载中...");
    
    //如果有地区，就监听地区下拉联动
    
    if($("#xinzengxiansuodiv").find(".add_diqu").html())
    {
        window.jiazai=layer.load(2);
        setTimeout(function() {
            add_diqu_listen();
        }, 200);
    }
    setTimeout(function() {
        xinzengxiansuo_show();
        $(thisdom).html('<i class="fa fa-plus"></i>新增线索');
    }, 200);
}
function xinzengxiansuo_show()
{
    //初始化新增线索弹出框中的各项数据
    $("#xinzengxiansuodiv").find("input").val('');
    $("#xinzengxiansuodiv").find("textarea").val('');
    $("#xinzengxiansuodiv").find("select").children("option[value='0']").prop("selected",true);
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '新增线索',
            area:"600px",
            offset:'t',
            fixed: false,
            btn:["确定","取消"],
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
                if($("#add_fuzeren").children("td").eq(1).children("select").val()=='0'||$("#add_fuzeren").children("td").eq(1).children("select").val()=='')
                {
                    layer.close(jiazai);
                    tishi("请选择负责人");
                    return false;
                }
                ajax_str='{'+ajax_str.substr(0,ajax_str.length-1)+'}';
                $.post(root_dir+"/index.php/Home/Xiansuo/add_xs",{"ajax_str":ajax_str},function(res){
                    if(res=='1')
                    {
                        location=root_dir+"/index.php/Home/Xiansuo/index";
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
//导入线索弹出框
function daoru()
{
    var upname='';
    layui.upload({
        url: root_dir+"/index.php/Home/Xiansuo/daoru_upload",
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
                upname=res['newname'];
                layer.close(jiazai);
            }
            else if(res['res']=='2')
            {
                layer.close(jiazai);
                tishi("只支持xls或xlsx文件导入");
                return false;
            }
            else
            {
                layer.close(jiazai);
                tishi("文件上传失败，请刷新后重试");
            }
        },
    });
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            title: '导入',
            area:"600px",
            btn:["开始导入","下载模板","取消"],
            content:$("#daorudiv"),
            btn1:function(index,layero){
                $.get(root_dir+"/index.php/Home/Xiansuo/daoru_start",{"upname":upname},function(res){
                    if(res=='1')
                    {
                        window.location=root_dir+"/index.php/Home/Xiansuo/index";
                    }
                    else if(res=='2')
                    {
                        tishi("当前导入文件的字段与服务器中的字段不符，请下载最新模板后重试");
                        layer.close(jiazai);
                        return false;
                    }
                    else if(res=='3')
                    {
                        tishi("导入失败，无法获取数据");
                        return false;
                    }
                    else
                    {
                        tishi("导入失败，请稍后重试");
                        layer.close(jiazai);
                    }
                });
                layer.close(index);
            },
            btn2:function(index,layero){
                window.location=root_dir+"/index.php/Home/Xiansuo/download_mod";
            },
            btn3:function(index,layero){
                layer.close(index);
            },
        }); 
    });
}
//导出弹出框
function daochu()
{
    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:0,
            title: '导出',
            btn:["确定","取消"],
            content:"是否导出全部线索？",
            btn1:function(index,layero){
                layer.close(index);
            },
            btn2:function(index,layero){
                layer.close(index);
            }
        }); 
    });
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
//监听地区三级联动
function add_diqu_listen()
{
    var sheng='0';
    if(diqu_is_load==0)
    {
        jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/index_js_css/datas/area_data.js", function(data, status, jqxhr) {
            jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/xiansuo/diqu.js", function(data, status, jqxhr) {
                layer.close(jiazai);
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
        layer.close(jiazai);
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
//搜索
function table_top_search()
{
    layer.load(2);
    var search_type=$("#table_search_type").val();
    var search_content=$("#table_top_search_input").val();
    search_content=search_content==''?search_content:search_type+','+search_content;
    var now_url=get_url_val("search");
    window.location=root_dir+"/index.php/Home/Xiansuo/index?search="+search_content+now_url;
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