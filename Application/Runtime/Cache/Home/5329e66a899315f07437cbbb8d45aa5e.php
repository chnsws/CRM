<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>设置中心</title>
</head>
		<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<style>
	#box{width:98%;margin-left:1%;margin-right:1%;overflow:hidden;padding:0;}
	div{border:0px solid #f00;border-radius:5px;}
	
	#mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}

	#left-box{float:left;width:80%;clear:both;}
	#right-box{float:left;height:450px;width:18%;border:1px solid #E5E5E5;margin-left:1%;background-color:#F8F6F6;}
	#mod1{border:1px solid #D6D6D6;height:100px;background-color:#F8F8F8;padding:10px;}
	
	#headimg{border:0px solid #f00;width:60px;height:100px;float:left;overflow:hidden;margin-left:10px;}
	#headimg i{height:100px;width:60px;line-height: 100px;text-align: center;font-size: 70px;color:#777;}
	#short_info{float:left;overflow:hidden;height:100px;color:#555;margin-left:20px;}
	.shortinfo{height:50px;line-height:50px;}
	.shortinfo:first-child{line-height:70px;}
	.shortinfo:last-child{line-height:35px;}


	#mod2{height:150px;line-height:150px;}
	#mod2 button i{font-size:30px;margin:0;}
	#mod2 button{height:130px;width:30%;background-color:#FFFCFC;border-radius:5px;border:1px solid #CECECE;color:#868686;font-size:20px;cursor:pointer;}

	#fast_button1{margin-right:2.6%;}
	#fast_button2{margin-right:2%;margin-left:2%;}
	#fast_button3{margin-left:2.5%;}
	#mod4{color:#6D6D6D;line-height:25px;}
	#headimgdiv{width:60%;}
	#mod4 img{margin-top:15px;display: none;}

	#mod3{margin-top:10px;}
	#mod3 table{width:100%;color:#A7A7A7;}
	#mod3 table a{color:#3A3838;}
	#mod3 table a:hover{color:#1AA094;}
	#mod3 table td{height:40px;border-bottom:1px solid #DEDEDE;}
	.gg_right{float:right;}
	
	#mod5{margin-top:20px;}
	#mod5 table{width:100%;}
	#mod5 tr td{height:30px;line-height:30px;color:#3A3838;}
	@media screen and (max-width:1100px)
	{
		#fast_button1{margin-right:2.3%;}
		#fast_button2{margin-right:1.7%;margin-left:1.7%;}
		#fast_button3{margin-left:2.3%;}
	}
</style>
<body>
<div id="box">
	<div id="mod-head">设置中心</div>
	<!--左边盒子-->
	<div id="left-box">
		<!--model 1 用户简略信息-->
		<div id="mod1">
			<!--<img id="headimg" src="<?php echo ($_GET['public_dir']); ?>/head-img/headimg2.jpg">-->
			<span id="headimg" ><i class="fa fa-home" aria-hidden="true"></i></span>
			<div id="short_info">
				<div class="shortinfo"><?php echo ($_COOKIE['user_name']); ?>，欢迎进入设置中心</div><div class="shortinfo">上次登录时间：<?php echo ($_COOKIE['user_lastlogintime']); ?></div>
			</div>
		</div>
		<!--model 1 结束-->

		<!--model 2 快捷按钮-->
		<div id="mod2">
			<button id="fast_button1" class="uk-animation-fade uk-animation-hover" ><i class="fa fa-user" aria-hidden="true"></i><br>部门用户设置</button>
			<button id="fast_button2" class="uk-animation-fade uk-animation-hover" ><i class="fa fa-bar-chart" aria-hidden="true"></i><br>业绩目标</button>
			<button id="fast_button3" class="uk-animation-fade uk-animation-hover" ><i class="fa fa-pencil" aria-hidden="true"></i><br>自定义业务字段</button>
		</div>
		<!--mod2结束-->
		
		<!--model 3 系统公告-->
		<div id="mod3">
			<table>
				<tr>
					<td><span style="color:#1AA094;font-weight:bold;">系统公告</span><a class='gg_right' id="gotogonggao">更多</a></td>
				</tr>
				<?php echo ($gg_str); ?>
			</table>
		</div>
		<!--mod3结束-->
		<!--mod5 系统介绍-->
		<div id="mod5">
			
			<table>
				<tr>
					<td style="border-bottom:1px solid #DEDEDE;"><span style="color:#1AA094;font-weight:bold;">系统介绍</span></td>
				</tr>
				<tr>
					<td>
						中软远景CRM app<br>
中软远景CRM是专注移动化，以销售为导向，提高销售转化的新型CRM。<br>
专注中小企业的外勤销售管理，帮助销售人员外勤时查询客户及相关数据，借助一些自动化的识别技术，如扫描名片、语音识别、LBS等，方便用户快速准确的自动录入销售数据，形成销售轨迹，便于管理和跟进客户，方便销售管理，从而提高销售业绩。
					</td>
				</tr>
			</table>
		
		</div>
	</div>
	<!--左边盒子结束-->
	
	<!--右边盒子-->
	<div id="right-box">
		<div id="mod4">
			<div style="height:40%;margin-bottom:0px;padding:0;" >
				<center><div id="headimgdiv"><?php echo ($_COOKIE['gsimg']); ?></div></center>
			</div>
			<div style="height:56%;padding:20px;">
				<p style="height:35px;line-height:35px;text-align:center;border-bottom:1px solid #DEDEDE;">使用账号数：<?php echo ($usercount); ?>/100</p>
				
				<p style="height:35px;line-height:35px;text-align:center;margin-top:20px;">开始时间：<?php echo ($stime); ?></p>
				<p style="height:35px;line-height:35px;text-align:center;">结束时间：<?php echo ($etime); ?></p>
				<p style="height:35px;line-height:35px;text-align:center;margin-top:20px;font-size:20px;font-weight:bold;">客服电话</p>
				<p style="height:35px;line-height:35px;text-align:center;font-size:20px;font-weight:bold;">400-000-0000</p>
			</div>
		</div>
	</div>
	<!--右边盒子结束-->
</div>
<!--大盒子结束-->








</body>
<script>
	
$(function(){
	//初始化
	layui.use('layer', function(){
		window.layer = layui.layer;
	});
	//黑色半透明提示
	function tishi(neirong)
	{
		layer.msg(neirong, {
			time: 1000, 
		});
	}
	//鼠标经过事件
	$("button").mouseover(function(){
		$(this).css({'color':'#1AA094',"border":"1px solid #1AA094"});
	});
	$("button").mouseout(function(){
		$(this).css({'color':'#868686',"border":"1px solid #CECECE"});
	});
	//公司图片处理

	$("#mod4").find("img").fadeIn();
	//快捷按钮1
	$("#fast_button1").on("click",function(){
		var findindex='';
		$(".layui-nav-tree",parent.document).find("dd").each(function(){
			var qx="<?php echo ($_COOKIE['qx_sys_bmyh']); ?>";
			if(qx=='0')
			{
				tishi("您没有进入此模块的权限");
				return;
			}
			var thistext=$(this).text();
			if(thistext.search('部门和用户设置')!='-1')
			{
				$(this).click();
			}
		});
	});
	//快捷按钮2
	$("#fast_button2").on("click",function(){
		var findindex='';
		$(".layui-nav-tree",parent.document).find("dd").each(function(){
			var qx="<?php echo ($_COOKIE['qx_sys_yjmb']); ?>";
			if(qx=='0')
			{
				tishi("您没有进入此模块的权限");
				return;
			}
			var thistext=$(this).text();
			if(thistext.search('业绩目标')!='-1')
			{
				$(this).click();
			}
		});
	});
	//快捷按钮3
	$("#fast_button3").on("click",function(){
		var qx="<?php echo ($_COOKIE['qx_sys_ywzd']); ?>";
			if(qx=='0')
			{
				tishi("您没有进入此模块的权限");
				return;
			}
		var findindex='';
		$(".layui-nav-tree",parent.document).find("dd").each(function(){
			var thistext=$(this).text();
			if(thistext.search('自定义业务字段')!='-1')
			{
				$(this).click();
			}
		});
	});
	$("#gotogonggao").on("click",function(){
		$(".layui-nav-tree",parent.document).find("li").eq(1).children("dl").children("dd").eq(3).click();
	});
});
</script> 
</html>