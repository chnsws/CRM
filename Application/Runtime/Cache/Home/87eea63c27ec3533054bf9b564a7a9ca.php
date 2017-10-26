<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
<title>部门和用户设置</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<!--layUI 插件 弹窗设计 form表单样式 -->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/components/lightbox.min.js"></script>
<style>
div,ul,li{border:0;padding:0;}
#box{height:100%;width:100%;}
#cp_btn i{margin-right:5px;}
#cp_btn button{height:30px;line-height:30px;}

#head_cp_name,#cp_btn,#cp_page{margin-left:20px;}
#head_cp_name{height:60px;line-height:60px;font-size:20px;color:#1AA094;font-weight:bold;}
#jibenpage table tr{height:50px;}

#fujian_table tbody tr{height:50px;line-height:50px;}

.info_title{font-weight:bold;}
.info_content{padding-left:20px;word-break: break-all;word-wrap: break-word;}

.link_span{cursor:pointer;color:#1AA094;margin-right:10px;}

#fujian_div{width:600px;margin-top:30px;margin-bottom:30px;}
#fujian_div table tr:nth-child(1){height:50px;}
#fujian_div table textarea{width:100%;height:80px;}

#fenleisel{height:40px;width:500px;margin:10px 0 10px 0;}
#addcpdiv{width:400px;padding:20px 50px 20px 50px;font-weight:bold;font-size:14px;}
#addcpdiv input{line-height: 30px;}
#addcpdiv tr{height:50px;line-height:50px;}
#add_yc_div{color:#1AA094;}
#cpimg{width:120px;height:120px;}
#addcpdiv table{width:100%;}
#addcpdiv input{width:100%;}
textarea{resize:none;}
#cp_jieshao{width:100%;height:90px;resize:none;line-height:20px;}
#addflsel{width:100%;}
.redstart{color:#f00;}
.add_left{width:100px;}

#jibenpage tr td:first-child{width:100px;}
#jibenpage table{width:600px;}
</style>
</head>
<body>
<div id="box">
    <div id="head_cp_name">
        <?php echo ($cpinfoarr['cp_name']); ?>
    </div>
    <div id="cp_btn">
        <button class="layui-btn layui-btn-primary" onclick="fanhui()"><i class="fa fa-arrow-left" aria-hidden="true"></i>返回</button>
        <button class="layui-btn" onclick="bj_chanpin()"><i class="fa fa-edit" aria-hidden="true"></i>编辑</button>
        <button class="layui-btn" onclick="del_chanpin()"><i class="fa fa-trash" aria-hidden="true"></i>删除</button>
        <?php echo ($jy_btn); ?>
    </div>
    <div id="cp_page">
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <li class="layui-this">产品信息</li>
                <li>附件</li>
            </ul>
            <div class="layui-tab-content">
                <div id="jibenpage" class="layui-tab-item layui-show">
                    <span>产品信息</span>
                    <table>
                        <?php echo ($infostr); ?>
                    </table>
                    <hr />
                    <span>系统信息</span>
                    <table>
                        <tr>
                            <td class="info_title">创建时间：</td>
                            <td class="info_content"><?php echo ($xitonginfo['add']); ?></td>
                        </tr>
                        <tr>
                            <td class="info_title">更新于：</td>
                            <td class="info_content"><?php echo ($xitonginfo['edit']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="layui-tab-item">
                    <button class="layui-btn" style="height:30px;line-height:30px;" onclick="add_fujian()"><i class="fa fa-plus" aria-hidden="true"></i>上传附件</button>
                    <table class="layui-table" lay-skin="line" id="fujian_table">
                        <thead>
                            <th>上传时间<i class='fa fa-sort-down' aria-hidden='true'></i></th>
                            <th>附件名称<i class='fa fa-sort-down' aria-hidden='true'></i></th>
                            <th>大小<i class='fa fa-sort-down' aria-hidden='true'></i></th>
                            <th>备注<i class='fa fa-sort-down' aria-hidden='true'></i></th>
                            <th>操作<i class='fa fa-sort-down' aria-hidden='true'></i></th>
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
</body>
<!--编辑产品-->
<div id="addcpdiv" class="uk-form">
    <div id="add_cy_div">
        <table>
            <?php echo ($cydiv); ?>
        </table>
    </div>
    <div id="add_yc_div"><span onclick="more_info()" style="cursor:pointer;">展开更多信息<i class='fa fa-chevron-down' aria-hidden='true'></i></span></div>
    <div id="add_yc_body">
        <table>
            <?php echo ($ncydiv); ?>   
        </table>    
    </div>
</div>
<!--添加附件-->
<div class="uk-form" id="fujian_div">
    <center>
    <table style="width:450px;">
        <tr>
            <td>附件</td>
            <td class="info_content">
                <input type="file" name="cp_file" lay-type="file" class="layui-upload-file" id="imm"  />
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
            <td>备注</td>
            <td class="info_content"><textarea></textarea></td>
        </tr>
    </table>
    </center>
</div>
<script>
$("#addcpdiv").hide();
$("#add_yc_body").hide();
$("#fujian_div").hide();
$("#filebody").hide();
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
window.nowpageid="<?php echo ($_GET['cpid']); ?>";
window.nowpagename="<?php echo ($cpinfoarr['cp_name']); ?>";
//加载选项卡
layui.use('element', function(){
  var element = layui.element();
});
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//上传控件初始化
layui.use('upload', function(){
  layui.upload(options);
});

//$.post("/index.php/Home/Chanpin/demo",{"yzm":abc},function(data){alert(data)})
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 1000, 
    });
}

//上传附件
function add_fujian()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有修改产品的权限");
        return;
    }
    window.clickdelnowfile='0';
    var is_upload='';
    //显示文件上传按钮
    layui.upload({
        url: "/index.php/Home/Chanpin/cp_file",
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
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":is_upload});
                }
                is_upload=res['newname'];
                layer.close(jiazai);
            }
            else
            {
                layer.close(jiazai);
                tishi("更换失败，请刷新后重试");
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
                var fj_bz=$("#fujian_div").find("textarea").val();
                var fj_size=$("#filesize").text();
                var thiscpid="<?php echo ($_GET['cpid']); ?>";
                var rzname=$("#filename").text();
                if(is_upload=='')
                {
                    tishi("请先上传附件");
                    return false;
                }
                $.get(root_dir+"/index.php/Home/Chanpin/bt_cpfj",{"fjbz":fj_bz,"fjmc":is_upload,"fjdx":fj_size,"fjcpid":thiscpid,"upoldname":rzname},function(res){
                    if(res=='1')
                    {
                        tishi("上传成功");
                        reload_file_list();
                        layer.close(index);

                    }
                    else if(res=='2')
                    {
                        tishi("上传失败");
                        $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":is_upload});
                        return false;
                    }
                    else
                    {
                        tishi("上传失败，请刷新后重试");
                        $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":is_upload});
                        return false;
                    }
                });
            },
            btn2:function(index,layero){
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":is_upload});
                }
                layer.close(index);
            },
            cancel: function(index, layero){ 
                if(is_upload!=''&&clickdelnowfile=='0')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":is_upload});
                }
                layer.close(index);                
            }
        }); 
    });  
}
//点击删除当前已上传的文件
function delnowfile(thisdom)
{
    clickdelnowfile='1';
    var nowupfilename=$(thisdom).prop("name");
    if(nowupfilename!='')
    {
        $.get(root_dir+"/index.php/Home/Chanpin/del_old_file",{"oldname":nowupfilename});
    }
    $("#filebody").hide();
}
//重新加载附件列表
function reload_file_list()
{
    var thiscpid="<?php echo ($_GET['cpid']); ?>";
    $.get(root_dir+"/index.php/Home/Chanpin/reload_file_list",{"reloadcpid":thiscpid},function(res){
        $("#fujian_table").find("tbody").html(res);
    });
}
//下载附件
function down_fujian(fjid)
{
    window.location=root_dir+"/index.php/Home/Chanpin/fujian_download?fjid="+fjid;
}
//删除附件
function del_fujian(thisfjid)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有修改产品的权限");
        return;
    }
    var fileyname=$("#fujian_table").find("tbody").find("span[onclick='del_fujian("+thisfjid+")']").parent().parent().find("td").eq("1").text();
    layer.msg("确认删除该附件？该操作成功后，将无法恢复", {
        time: 9999999,
        btn: ['确认删除', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/del_fj",{"delfjid":thisfjid,"fileyname":fileyname},function(res){
                if(res=='1')
                {
                    tishi("删除成功");
                    reload_file_list();
                }
                else if(res=='2')
                {
                    tishi("删除失败");

                }
                else
                {
                    tishi("删除失败，请刷新后重试");

                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//删除产品
function del_chanpin()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_del']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有删除产品的权限");
        return;
    }
    layer.msg("确认删除产品:"+nowpagename+"？操作成功后，将无法恢复", {
        time: 9999999,
        btn: ['确认删除', '取消'],
        btn1: function(index, layero){
            $.get(root_dir+"/index.php/Home/Chanpin/del_more",{"sel_id":nowpageid,"delname":nowpagename},function(res){
                if(res=='1')
                {
                    window.location=root_dir+"/index.php/Home/Chanpin/";
                }
                else if(res=='2')
                {
                    tishi("删除失败");
                    return false;
                }
                else
                {
                    tishi("删除失败，请刷新后重试");
                    return false;
                }
            });
            layer.close(index);
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
}
//编辑产品
window.img_up_one='';
function bj_chanpin()
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有修改产品的权限");
        return;
    }
    var img_is_up='';
    if(img_up_one=='1')
    {
        $("#cpimg").hide();
    }
    //显示文件上传按钮
    layui.upload({
        url: root_dir+"/index.php/Home/Chanpin/cp_img_add",
        title:"选择图片",
        before: function(input){
            //返回的参数item，即为当前的input DOM对象
            window.jiazai= layer.load(2);
            //tishi('文件上传中');
        },
        success: function(res){
            if(res['res']=='1')
            {
                //tishi('更换成功');
                $("#cpimg").attr("src",root_dir+'/Public/chanpinfile/cpimg/'+res['newname']);
                $("#cpimg").show();
                img_up_one='1';
                if(img_is_up!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":img_is_up});
                }
                img_is_up=res['newname'];
                //$("#headimg").attr("src",root_dir+'/Public/head-img/'+res['newpath']);
            }
            else
            {
                tishi("更换失败，请刷新后重试");
            }
            layer.close(jiazai);
        },
    });

    layui.use('layer', function(){
        var layer = layui.layer;
        layer.open({
            type:1,
            offset:'t',
            area:"500px",
            title: '产品编辑',
            fixed: false,
            content:$("#addcpdiv"),
            btn:["保存","取消"],
            btn1:function(index,layero){
                var oldimgname="<?php echo ($oldimgname); ?>";
                img_is_up=img_is_up==''?oldimgname:img_is_up;
                var addstr='';
                var trdom=$("#addcpdiv").find("tr");
                fornum=trdom.length;

                for(a=0;a<fornum;a++)
                {
                    var thisdom=$("#addcpdiv").find("tr").eq(a);
                    var thistagname=thisdom.find("td").eq(1).children().prop("tagName");//标签名
                    var thiszdyname=thisdom.find("td").eq(1).children().prop("name");//控件name
                    var thiszdyvalue=thisdom.find("td").eq(1).children().val();//控件值
                    
                    //必填项
                    if(thisdom.find("td").eq(0).children("span").attr("class")=="redstart")
                    {
                        if(thistagname=="DIV")//图片上传
                        {
                            if(img_is_up=='')
                            {
                                tishi("必须上传一个产品图片");
                                return false;
                            }
                        }
                        else//text select textarea
                        {
                            if(thiszdyvalue=='')
                            {
                                tishi("必填项不能为空");
                                return false;
                            }
                        }
                    }//必填验证结束
                    if(thistagname=="DIV")//图片上传
                    {
                        addstr+="[zdy7]:["+img_is_up+"],";
                    }
                    else if(thistagname=='IMG')
                    {
                        continue;
                    }
                    else//text select textarea
                    {
                        addstr+="["+thiszdyname+"]:["+thiszdyvalue+"],"
                    }
                }
                addstr=addstr.substr(0,addstr.length-1);
                //修改，获取本页面的id和名称
                var nowpageid="<?php echo ($_GET['cpid']); ?>";
                var nowpagename="<?php echo ($cpinfoarr['cp_name']); ?>";
                $.post(root_dir+"/index.php/Home/Chanpin/editcp",{"editstr":addstr,"nowpageid":nowpageid,"nowpagename":nowpagename},function(res){
                    if(res=='1')
                    {
                        location.reload();
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return false;
                    }
                    else
                    {
                        tishi("修改失败，请刷新后重试");
                        return false;
                    }
                });

            },
            btn2:function(index,layero){
                if(img_is_up!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":img_is_up});
                }
            },
            cancel: function(index, layero){ 
                if(img_is_up!='')
                {
                    //删除上次上传的图片
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":img_is_up});
                }
            }
        }); 
    });  
}

//点击展开更多时
function more_info()
{
    $("#add_yc_div").hide();
    $("#add_yc_body").show();
}

//下载图片
function xiazai(thisdom)
{
    var thishref=$("#spanaaa").attr("href");
    var hrefarr=thishref.split('/');
    var newkey=hrefarr.length-1;
    window.location=root_dir+"/index.php/Home/Chanpin/img_download?file="+hrefarr[newkey];
}
//删除图片
function shanchu(thisdom)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有修改产品的权限");
        return;
    }
    layer.msg("是否删除产品图片？该操作成功后，将无法恢复", {
        time: 9999999,
        btn: ['删除', '取消'],
        btn1: function(index, layero){
            var thishref=$("#spanaaa").attr("href");
            var hrefarr=thishref.split('/');
            var newkey=hrefarr.length-1;
            var thiscpid="<?php echo ($_GET['cpid']); ?>";
            var cpname="<?php echo ($cpinfoarr['cp_name']); ?>";
            $.get(root_dir+"/index.php/Home/Chanpin/img_del",{"delcpid":thiscpid,"cpname":cpname},function(res){
                if(res=='1')
                {
                    $.get(root_dir+"/index.php/Home/Chanpin/del_old_img",{"oldname":hrefarr[newkey]});
                    location.reload();
                }
                else
                {
                    tishi("删除失败，请刷新后重试");
                    return false;
                }
            });
        },
        btn2: function(index, layero){
            layer.close(index);
        }
    });
    
}

$("#spanaaa").hide();
function sc()
{
    $("#spanaaa").click();
}

//启用/禁用产品
function jy_qy_chanpin(qyjyid)
{
    var cookie_qx="<?php echo ($_COOKIE['qx_cp_edit']); ?>";
    if(cookie_qx!='1')
    {
        tishi("您没有修改产品的权限");
        return;
    }
    $.get(root_dir+"/index.php/Home/Chanpin/qy_jy",{"sel_id":nowpageid,"qyjy":qyjyid,"pagename":nowpagename},function(res){
        if(res=='1')
        {
            if(qyjyid=='1')
            {
                var qyjybtntext="<i class='fa fa-lock' aria-hidden='true'></i>禁用";
                var qyjybtnon="jy_qy_chanpin(0)";
                tishi("已启用");
            }
            else
            {
                var qyjybtntext="<i class='fa fa-unlock' aria-hidden='true'></i>启用";
                var qyjybtnon="jy_qy_chanpin(1)";
                tishi("已禁用");
            }
            $("#qyjybtn").html(qyjybtntext);
            $("#qyjybtn").attr("onclick",qyjybtnon);
            //location.reload();
        }
        else if(res=='2')
        {
            tishi("修改失败");
            return false;
        }
        else
        {
            tishi("修改失败，请刷新后重试");
            return false;
        }
    });
}
function fanhui()
{
    layer.load(2);
    var fromPage="<?php echo ($_GET['from']); ?>";
    if(fromPage=='flpage')
    {
        window.location='<?php echo ($_GET[root_dir]); ?>/index.php/Home/Cpfl/cpfl_index';
    }
    else
    {
        window.location='<?php echo ($_GET[root_dir]); ?>/index.php/Home/Chanpin/index/?flid=<?php echo ($_GET['flid']); ?>';
    }
    
}
function table_px()
{
    $("th").css("cursor","pointer");//添加小手指针
    $("th").attr("onselectstart","return false");//屏蔽双击选中
    window.tdeq='';
    window.sorj='';
    $("th").click(function(){
        var thnum=$(this).index();
        if($(this).parent().parent().parent().attr("id")!='fujian_table')
        {
            return false;
        }
        if(tdeq==''&&tdeq!=0)
        {
            tdeq=thnum;
            sorj='s';
        }
        else
        {
            if(tdeq==thnum)
            {
                if(sorj=='s')
                    sorj='j';
                else
                    sorj='s';
            }
            else
            {
                tdeq=thnum;
                sorj='s';
            }
        }
        $(this).parent().parent().parent().find("i").css("color","#ccc");
        $(this).children("i").css("color","#000");
        //修改表头箭头图标
        if(sorj=='s')
        {
            $(this).children("i").removeClass("fa-sort-down");
            $(this).children("i").addClass("fa-sort-up");
        }
        else
        {
            $(this).children("i").removeClass("fa-sort-up");
            $(this).children("i").addClass("fa-sort-down");
        }
        var tdarr=new Array();
        var trarr=new Array();
        var a=0;
        var arrnum=0;
        $(this).parent().parent().parent().children("tbody").find("tr").each(function(){
            var thiscolstdtext=$(this).find("td").eq(thnum).html();
            if(trarr[thiscolstdtext]!=undefined)
            {
                trarr[thiscolstdtext]+='<tr>'+$(this).html()+'</tr>';
            }
            else
            {
                trarr[thiscolstdtext]='<tr>'+$(this).html()+'</tr>';
                arrnum++;
                tdarr[a]=thiscolstdtext;
                a++;
            }
        });
        tdarr.sort();
        if(sorj=='j')
        {
            tdarr.reverse();
        }
        var newtable='';
        for(aa=0;aa<arrnum;aa++)
        {
            newtable+=trarr[tdarr[aa]];
        }
        $(this).parent().parent().parent().children("tbody").html(newtable);
    });
}
table_px();



</script>
</html>