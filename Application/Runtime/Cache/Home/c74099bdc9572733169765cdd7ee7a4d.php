<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>业绩目标设置</title>
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
    <style>
        *{margin:0;padding:0}
        a{text-decoration:none;cursor:pointer;color:#1AA094;margin-right:10px;}
        a:hover{color:#2F6F69;text-decoration:none;}
        #box{margin-left: 10px;margin-right: 10px;overflow:hidden;}
        /*头部页面名称*/
        #mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
        /*中部可关闭的提示框*/
        #mod1{background-color:#DFF0D8;height:50px;color:#255B56;padding-left:15px;padding-bottom:0px;border-radius:0px;font-size:12px;line-height:50px;}
        #hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
        /*按钮*/
        #mod-button{margin-top:10px;margin-bottom:10px;}
        #mod-button i{margin-right:10px;}
        /*下部表格*/
        #xinzeng select{height:30px;width:400px;}
        #xinzeng td{height:50px;}
        #xinzeng{margin-top:20px;margin-bottom:20px;}
        .redstar{color:#f00;font-size:22px;margin-right:5px;}
    </style>
</head>
<body>
<div id="box">
    <!--头部文字-->
    <div id="mod-head">
    业绩目标
    </div>
    <!--头部结束-->
    <!--中部提示-->
    <div id="mod1">
        <div>
            提示:
            1、产品数量和产品金额是根据合同的关联产品来统计的。如果开启了合同和回款审批，则只统计通过了审批的合同和。产品金额是指建议价格*数量。
            <span id="hidden-div"><a onclick="hidden_div()">×</a></span>
        </div>
    </div>
    <!--中部结束-->
    <!--按钮模块-->
    <div id="mod-button">
        <button class="layui-btn" onclick="add()"><i class="layui-icon">&#xe608;</i>新增业绩目标</button>
    </div>
    <!--下部表格-->
    <div id="mod-table">
        <table  class="layui-table" lay-skin="line">
            <thead>
                <th>年度</th>
                <th>业绩类型</th>
                <th>业绩目标</th>
                <th>操作</th>
            </thead>
            <tbody>
                <?php echo ($yjtable); ?>
            </tbody>
        </table>
    </div>
</div>
</body>
<table id="xinzeng" width="600px" >
    <tr>
        <td width="150px" height="40px" align="center">
            <i class="redstar">*</i>对应年度
        </td>
        <td>
            <select id="niandu">
                <option value=''>请选择对应年度</option>
                <option value="2005">2005</option>
                <option value="2006">2006</option>
                <option value="2007">2007</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="150px" height="40px" align="center">
            <i class="redstar">*</i>业绩类型
        </td>
        <td>
            <select id="yeji_type">
                <option value="">请选择业绩类型</option>
                <option value="1">赢单商机金额</option>
                <option value="2">赢单商机数</option>
                <option value="3">合同回款金额</option>
                <option value="4">合同金额</option>
                <option value="5">合同数</option>
                <option value="6">产品销量</option>
                <option value="7">产品销售额</option>
                <option value="8">产品分类销量</option>
                <option value="9">产品分类销售额</option>
            </select>
        </td>
    </tr>
    <tr id="chanpintr">
        <td width="150px" height="40px" align="center"  >
            <i class="redstar">*</i>产品
        </td>
        <td>
            <select id="chanpinsel">
            </select>
        </td>
    </tr>
    <tr id="chanpinfenleitr">
        <td width="150px" height="40px" align="center"  >
            <i class="redstar">*</i>产品分类
        </td>
        <td>
            <select id="chanpinfenleisel">
            </select>
        </td>
    </tr>
</table>
<script>
    $("#xinzeng").hide();
    $("#chanpintr").hide();
    $("#chanpinfenleitr").hide();
    window.root_dir="<?php echo ($_GET['root_dir']); ?>";
    window.chanpinload='0';
    window.chanpintypeload='0';
    window.selchanpin='0';
    //上方绿色提示框的关闭效果
    function hidden_div(){
        $("#mod1").hide();
    }
    //初始化
    layui.use('layer', function(){
        window.layer = layui.layer;
    });
      //  alert($.inArray('1',abc));
    //黑色半透明提示
    function tishi(neirong)
    {
        layer.msg(neirong, {
            time: 1000, 
        });
    }     
    //新增业绩目标
    function add(){
        //将业绩类型改变为可选
        $("#yeji_type").prop("disabled",false);
        //打开弹出层
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type:1,
                area:"600px",
                title:"新增业绩目标",
                content: $("#xinzeng"),
                btn: '确认',
                btn1: function(index, layero){
                        var addniandu=$("#niandu").val();
                        var addyejitype=$("#yeji_type").val();
                        var addchanpin=$("#chanpinsel").val();
                        var addchanpinfenlei=$("#chanpinfenleisel").val();
                        if(addniandu==''){tishi("请选择对应年度");return false;}
                        if(addyejitype==''){tishi("请选择业绩类型");return false;}
                        if(selchanpin!='0')
                        {
                            if(selchanpin=='1')
                            {
                                if(addchanpin==''){tishi("请选择产品");return false;}
                                else{var yjmbtypemore=addchanpin;}
                            }
                            else
                            {
                                if(addchanpinfenlei==''){tishi("请选择产品分类");return false;}
                                else{var yjmbtypemore=addchanpinfenlei;}
                            }
                        }
                         $.get(root_dir+"/index.php/Home/YejimubiaoDo/yjmbadd",{"addniandu":addniandu,"addyejitype":addyejitype,"yjmbtypemore":yjmbtypemore},function(res){
                            if(res=='1')
                            {
                                location.reload();
                            }
                            else if(res=='2')
                            {
                                tishi("添加失败");
                            }
                            else if(res=='3')
                            {
                                tishi("该目标已存在，请勿重复添加");
                            }
                            else
                            {
                                tishi("添加失败，请刷新后重试");
                            }
                         });
                    }
            });
        });
    }

    //加载产品分类
    $("#yeji_type").change(function(){
        var needshow=['6','7','8','9'];
        var thisval=$(this).val();
        var thiscp=$.inArray(thisval,needshow);
        if(thiscp>=0)
        {
            if(thiscp=='0'||thiscp=='1')//加载产品
            {
                selchanpin='1';
                $.get(root_dir+"/index.php/Home/YejimubiaoDo/chanpinload",{"cploadtype":'1'},function(res){
                    $("#chanpinsel").html(res);
                });
                chanpinload='1';
                $("#chanpintr").show();
                $("#chanpinfenleitr").hide();
            }
            else//加载产品类别
            {
                selchanpin='2';
                $.get(root_dir+"/index.php/Home/YejimubiaoDo/chanpinload",{"cploadtype":'2'},function(res){
                    $("#chanpinfenleisel").html(res);
                });
                chanpinfenleiload='1';
                $("#chanpinfenleitr").show();
                $("#chanpintr").hide();
            }
            
        }
        else
        {
            selchanpin='0';
            $("#chanpintr").hide();
            $("#chanpinfenleitr").hide();
        }
    });
    //复制业绩目标
    function yjcopy(yjnd,yjid,yjtype,yjmore)
    {
        $("#yeji_type").val(yjtype);
        $("#niandu").val(yjnd);
        $.ajaxSetup({
            async : false
        });
        if(yjtype=='6'||yjtype=='7')
        {
            selchanpin='1';
            $.get(root_dir+"/index.php/Home/YejimubiaoDo/chanpinload",{"cploadtype":'1'},function(res){
                $("#chanpinsel").html(res);
            });
            $("#chanpinsel").val(yjmore);
            $("#chanpintr").show();
            $("#chanpinfenleitr").hide();
        }
        else if(yjtype=='8'||yjtype=='9')
        {
            selchanpin='2';
            $.get(root_dir+"/index.php/Home/YejimubiaoDo/chanpinload",{"cploadtype":'2'},function(res){
                $("#chanpinfenleisel").html(res);
            });
            $("#chanpinfenleisel").val(yjmore);
            $("#chanpinfenleitr").show();
            $("#chanpintr").hide();
        }
        else
        {
            $("#chanpinfenleitr").hide();
            $("#chanpintr").hide();
        }
        //将业绩类型改变为不可选
        $("#yeji_type").prop("disabled",true);
        //打开弹出层
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.open({
                type:1,
                area:"600px",
                title:"复制业绩目标",
                content: $("#xinzeng"),
                btn: '确认复制',
                btn1: function(index, layero){
                        var addniandu=$("#niandu").val();
                        var addyejitype=$("#yeji_type").val();
                        var addchanpin=$("#chanpinsel").val();
                        var addchanpinfenlei=$("#chanpinfenleisel").val();
                        if(addniandu==''){tishi("请选择对应年度");return false;}
                        if(addyejitype==''){tishi("请选择业绩类型");return false;}
                        if(selchanpin!='0')
                        {
                            if(selchanpin=='1')
                            {
                                if(addchanpin==''){tishi("请选择产品");return false;}
                                else{var yjmbtypemore=addchanpin;}
                            }
                            else
                            {
                                if(addchanpinfenlei==''){tishi("请选择产品分类");return false;}
                                else{var yjmbtypemore=addchanpinfenlei;}
                            }
                        }
                         $.get(root_dir+"/index.php/Home/YejimubiaoDo/yjmbcopy",{"yjid":yjid,"addniandu":addniandu,"addyejitype":addyejitype,"yjmbtypemore":yjmbtypemore},function(res){
                            if(res=='1')
                            {
                                location.reload();
                            }
                            else if(res=='2')
                            {
                                tishi("复制失败");
                            }
                            else if(res=='3')
                            {
                                tishi("该目标已存在，请勿重复复制");
                            }
                            else
                            {
                                tishi("复制失败，请刷新后重试");
                            }
                         });
                    }
            });
        });
    }
    //删除业绩目标
    function yjdel(thisid)
    {
        layer.msg("是否确认删除该条业绩目标？", {
            time: 2000000, //20s后自动关闭
            btn: ['确认删除', '取消'],
            btn1: function(index, layero){
                $.get(root_dir+"/index.php/Home/YejimubiaoDo/yjmbdel",{"yjid":thisid},function(res){
                    if(res=='1')
                    {
                        location.reload(true);
                    }
                });
            },
            btn2: function(index, layero){
                layer.close(index);
            }
        })
    }
</script>
</html>