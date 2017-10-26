<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>自定义业务参数</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
    <!--jqueryUI插件 折叠面板-->
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/option-quanxian-css/jquery-ui.css">
    <script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.min.js"></script>
    <!--layUI 插件 弹窗设计 form表单样式 -->
    <script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
    <style>
        *{margin:0;padding:0;}
        #box div{overflow:hidden;}
        a{text-decoration:none;cursor:pointer;}
        ul{list-style:none;}
        #box{margin-left:10px;margin-right:10px;}
        
        #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
        #mod1{background-color:#DFF0D8;height:56px;color:#255B56;padding-left:15px;padding-top:10px;padding-bottom:0px;border-radius:0px;}
        #mod1 div{height:22px;font-size:12px;}
        #hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
        .left-mar{padding-left:37px;}
     
        /*折叠标签css*/
		.accordion h3{border-radius:0px;height:30px;color:#636363;margin-top:10px;line-height:30px;background-color:#F2F2F2;}
		.accordion div{border-radius:0px;}
        /*折叠标签中的表格宽度*/
        .tuozhuaiwidth{width:100px;}
        .qiyongwidth{width:100px;}
        .canshuwidth{width:200px;}
        /*折叠标签高度*/
        .layui-table tr{height:50px;}
        /*修改铅笔样式*/
        .fa{margin-left:10px;}
    </style>
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
            提示：1、所有数据系统都设置了默认值，如需修改相关默认值，建议在使用系统前修改
            <span id="hidden-div"><a onclick="hidden_div()">×</a></span>
        </div>
        <div class="left-mar">
            2、所有数据是无法删除的，如需调整，可以通过字段左侧的勾选框来设定是否启用。
        </div>
    </div>
    <!--中部结束-->
    <!--下部数据展示模块-->
    <div id="mod2">
        <div class="layui-tab layui-tab-card"><!--选项卡开始-->
            <ul class="layui-tab-title">
                <li class="layui-this">线索</li>
                <li>客户</li>
                <li>联系人</li>
                <li>商机</li>
                <li>合同</li>
                <li>其他</li>
            </ul>
            <div class="layui-tab-content" ><!--选项卡内容-->
                <?php echo ($xshtmlstr); ?>
            </div><!--选项卡内容结束-->
        </div><!--选项卡结束-->
    </div>
</div>
</body>

<script src="<?php echo ($_GET['public_dir']); ?>/paixu/build-zdycs.js"></script>
<script>
    window.root_dir="<?php echo ($_GET['root_dir']); ?>";
    window.public_dir="<?php echo ($_GET['public_dir']); ?>";
    window.onlyone1='1';
    window.onlyone2='1';
    window.shangji2_input1='';
    window.shangji2_input2='';
    //修改小铅笔的隐藏显示效果
    $(".canshuwidth").children("a").children(".fa").hide();
    $(".canshuwidth").mouseover(function(){
        $(this).children("a").children(".fa").show();
    })
    $(".canshuwidth").mouseout(function(){
        $(this).children("a").children(".fa").hide();
    });
    //初始化
    layui.use('layer', function(){
        window.layer = layui.layer;
    });
    //ajax同步
    $.ajaxSetup({
        async : false
    });
    //小铅笔点击效果
    function clickpencil()
    {
        $(".xiugai").click(function(){
        
        var thistext=$(this).parent().text();
        var isqd=$(this).parent().index();
        var inputid='changeinput';
        var blurfun='inputblur';
        var qdstr='';
        var baifen='';
        if(isqd=='3')
        {
            thistext=thistext.substr(6,thistext.length-1);
            thistext=thistext.substr(0,thistext.length-1);
            inputid='changeinput2';
            blurfun='inputblur2';
            var qdstr='签单可能性：';
            var baifen='%';
        }
        $(this).parent().html(qdstr+"<input type='text' id='"+inputid+"' onblur='"+blurfun+"()' value='"+thistext+"' style='height:25px;'>"+baifen);
        $("#changeinput").focus();
        $("#changeinput").select();
        if(isqd=='3')
        {
            $("#changeinput2").focus();
            $("#changeinput2").select();
        }
        });
    }
    clickpencil();
    //小铅笔出现的文本框失去焦点后的事件
    function inputblur()
    {
        var newval=$("#changeinput").val();
        var trid=$("#changeinput").parent().parent().attr("id");
        var nowpageid=$("#changeinput").parent().parent().parent().parent().attr("id");
        //alert(nowpageid);return false;
        var eqval=nowpageid.substr(-1)-1;
        var thistagname=$("#changeinput").parent().parent().parent().parent().parent().parent().children("h3").eq(eqval).text();
        if(newval=='')
        {
            tishi("参数不能为空");
            return false;
        }
        if(newval.length>10)
        {
            tishi("字段名不能超过10个字符");
            return false;
        }
        //alert(nowpageid);return false;
        if(onlyone1=='0')
        {
            if(nowpageid=='paixu_shangji2')
            {
                window.shangji2_input1=newval;
                shangji2add();   
            }
            else
            {
                newcanshuadd(newval);
            }
        }
        else
        {
            window.jiazai= layer.load(2);
            $.get(root_dir+"/index.php/Home/YewucanshuDo/editcsval",{"nowpageid":nowpageid,"newval":newval,"trid":trid,"thistagname":thistagname,"isknx":'0'},function(res){
                if(res=='1')
                {
                    tishi("修改成功");
                }
                else if(res=='2')
                {
                    tishi("修改失败");
                    return false;
                }
                else
                {
                    tishi("修改失败,请刷新后重试");
                    return false;
                }
            });
            layer.close(jiazai);
        }
        $("#changeinput").parent().html(newval+"<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></i></a>");
        $(".canshuwidth").children("a").children(".fa").hide();
        //重新监听class='xiugai'的点击事件
        clickpencil();
    }
    //签单可能性的失去焦点事件
    function inputblur2()
    {
        var nowpageid=$("#changeinput2").parent().parent().parent().parent().attr("id");
        if(nowpageid=='paixu_shangji2')
        {
            var trid=$("#changeinput2").parent().parent().attr("id");
            var eqval=nowpageid.substr(-1)-1;
            var thistagname=$("#changeinput2").parent().parent().parent().parent().parent().parent().children("h3").eq(eqval).text();
            var newval=$("#changeinput2").val();
            if(newval=='')
            {
                tishi("参数不能为空");
                return false;
            }
            var zzobj=/^\d+(\.\d+)?$/;
            if(!zzobj.exec(newval))
            {
                tishi("输入的数字格式错误");
                return false;
            }
            var zzobj=/^([1-9]\d*|0)(\.\d{1,2})?$/;
            if(!zzobj.exec(newval))
            {
                tishi("最高只支持两位小数");
                return false;
            }
            if(newval>100)
            {
                tishi("可能性最高只能为100%");
                return false;
            }
            if(onlyone2=='0')
            {
                if(nowpageid=='paixu_shangji2')
                {
                    window.shangji2_input2=newval;
                    shangji2add();   
                }
            }
            else
            {
                window.jiazai= layer.load(2);
                $.get(root_dir+"/index.php/Home/YewucanshuDo/editcsval",{"nowpageid":nowpageid,"newval":newval,"trid":trid,"thistagname":thistagname,"isknx":'1'},function(res){
                    if(res=='1')
                    {
                        tishi("修改成功");
                    }
                    else if(res=='2')
                    {
                        tishi("修改失败");
                        return false;
                    }
                    else
                    {
                        tishi("修改失败,请刷新后重试");
                        return false;
                    }
                });
                layer.close(jiazai);
            }

            $("#changeinput2").parent().html("签单可能性："+newval+"%<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></a>");
        
            $(".canshuwidth").children("a").children(".fa").hide();
            $(".fa-pencil").hide();
            //重新监听class='xiugai'的点击事件
            clickpencil();
        }
    }
    //上方绿色提示框的关闭效果
    function hidden_div(){
        $("#mod1").hide();
    }
    //初始化
    layui.use('layer', function(){
        window.layer = layui.layer;
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
    //jqueryUI初始化折叠面板
    $(function() {
        $( ".accordion" ).accordion({
            heightStyle: "content"
        });
    });
    //添加新参数
    $(".layui-btn").click(function(){
        var nowpageid=$(this).parent().children("table").prop("id")
        var knxhtml='';
        if(onlyone1=='0'||onlyone2=='0')
        {
            tishi("请填写当前的参数信息再进行添加操作");
            return false;
        }
        onlyone1='0';
        if(nowpageid=='paixu_shangji2')
        {
            knxhtml="<td class='canshuwidth'>签单可能性：<input type='text' id='changeinput2' onblur='inputblur2()' style='height:25px;'>%</td>";
            onlyone2='0';
        }
        var oldtable=$(this).parent().children("table").children("tbody").html();
        var newtable=oldtable+"<tr id='newcsstr'><td class='tuozhuaiclass tuozhuaiwidth' ><i class='fa fa-reorder' aria-hidden='true'></i></td><td class='qiyongwidth'>&nbsp;&nbsp;<input type='checkbox' checked><span class='teshu'>启用</span></td><td class='canshuwidth'><input type='text' id='changeinput' onblur='inputblur()' style='height:25px;'></td>"+knxhtml+"</tr>";
        $(this).parent().children("table").children("tbody").html(newtable);
        $("#changeinput").focus();
        $("#changeinput").select();
        //重新加载小铅笔的js效果
        $(".canshuwidth").children("a").children(".fa").hide();
        $(".canshuwidth").mouseover(function(){
            $(this).children("a").children(".fa").show();
        })
        $(".canshuwidth").mouseout(function(){
            $(this).children("a").children(".fa").hide();
        })
        jQuery.getScript("<?php echo ($_GET['public_dir']); ?>/paixu/build-zdycs.js");
    })
    //拖拽监听事件
    function tuozhuai()
    {
        var mouseval='0';
        $(".tuozhuaiclass").on({
            //当鼠标按下时，将鼠标值改为1（标记鼠标已经按下）
            mousedown:function(){
                window.ccc=$(this).parent().parent();
                mouseval='1';
                $(".tuozhuaiclass").on({
                    mousemove:function(){
                        //当鼠标为按下状态时（鼠标值为1时），然后再拖动时，将鼠标值改为2（标记鼠标按下并拖动）
                        if(mouseval=='1')
                        {
                            mouseval='2';
                            $("body").on({
                                mouseup:function(){
                                    if(mouseval=='2')
                                    {
                                        setTimeout("getshunxu()",100);
                                        mouseval='0';//还原鼠标值，用来进行下一次拖动判断
                                    }
                                }
                            })
                        }
                    }
                });
            }
        });
    }
    tuozhuai();
    //销售阶段paixu_shangji2 如果是新增两个参数就走这一步
    function shangji2add()
    {
        //ajax同步
        $.ajaxSetup({
            async : false
        });
        if(shangji2_input1==''||shangji2_input2=='')
        {
            return false;
        }
        window.jiazai= layer.load(2);
        var nowpageid=$("#newcsstr").parent().parent().prop("id");
        var eqval=nowpageid.substr(-1)-1;
        var thistagname=$("#newcsstr").parent().parent().parent().parent().children("h3").eq(eqval).text();
        $.get(root_dir+"/index.php/Home/YewucanshuDo/addnewval",{"nowpageid":nowpageid,"thistagname":thistagname,"newval1":shangji2_input1,"newval2":shangji2_input2,"valnum":'2'},function(res){
            var resarr=res.split(',');
            if(resarr[1]=='1')
            {
                tishi("保存成功");
                $("#newcsstr").prop("id",resarr[0]);
                shangji2_input1='';
                shangji2_input2='';
                onlyone1='';
                onlyone2='';
                tuozhuai();
                changecheckbox();
            }
            else if(resarr[1]=='2')
            {
                tishi("保存失败");
            }
            else
            {
                tishi("保存失败，请刷新后重试");
            }
        });
        layer.close(jiazai);
    }
    //如果只新增一个参数就走这一步
    function newcanshuadd(thisval)
    {
        window.jiazai= layer.load(2);
        var nowpageid=$("#newcsstr").parent().parent().prop("id");
        var eqval=nowpageid.substr(-1)-1;
        var thistagname=$("#newcsstr").parent().parent().parent().parent().children("h3").eq(eqval).text();
        $.get(root_dir+"/index.php/Home/YewucanshuDo/addnewval",{"nowpageid":nowpageid,"thistagname":thistagname,"newval1":thisval,"newval2":'0',"valnum":'1'},function(res){
            var resarr=res.split(',');
            if(resarr[1]=='1')
            {
                $("#newcsstr").prop("id",resarr[0]);
                shangji2_input1='';
                shangji2_input2='';
                onlyone1='1';
                onlyone2='1';
                tuozhuai();
                changecheckbox();
                tishi("保存成功");
            }
            else if(resarr[1]=='2')
            {
                tishi("保存失败");
            }
            else
            {
                tishi("保存失败，请刷新后重试");
            }
        });
        layer.close(jiazai);
    }
    //获得新排序
    function getshunxu()
    {
        window.jiazai= layer.load(2);
        var shunxu='';
        ccc.find("tr").each(function(){
            shunxu+=$(this).attr("id")+',';
        });
        var thistableid=ccc.parent().prop("id");
        $.post(root_dir+"/index.php/Home/YewucanshuDo/editpaixu",{"thistableid":thistableid,"shunxu":shunxu},function(res){
            layer.close(jiazai);
        });
    }
    //监听checkbox
    function changecheckbox()
    {
        $("input[type='checkbox']").click(function(){
            window.jiazai= layer.load(2);
            var thistrid=$(this).parent().parent().prop("id");
            var thischboxval=$(this).prop("checked");
            var nowpageid=$(this).parent().parent().parent().parent().prop("id");
            eqval=nowpageid.substr(-1)-1;
            var thistagname=$(this).parent().parent().parent().parent().parent().parent().find("h3").eq(eqval).text();
            //nowpageid
            $.get(root_dir+"/index.php/Home/YewucanshuDo/editcsval",{"nowpageid":nowpageid,"newval":thischboxval,"trid":thistrid,"thistagname":thistagname,"isknx":'3'},function(res){
                if(res=='1')
                {
                    
                }
                else if(res=='2')
                {
                    tishi("修改失败");
                    return false;
                }
                else
                {
                    tishi("修改失败,请刷新后重试");
                    return false;
                }
            });
            layer.close(jiazai);
        });
    }
    changecheckbox();
</script>
</html>