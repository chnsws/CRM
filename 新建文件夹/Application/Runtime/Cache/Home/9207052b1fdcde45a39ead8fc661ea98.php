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
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<!--UIkit-->
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.min.css" />
        <script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
		<!--datatable引用文件-->
		<link href="<?php echo ($_GET['public_dir']); ?>/datatable/css/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/datatable/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/js/bootstrap.js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/datatable/js/dataTables.bootstrap.js"></script>
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
			#mod1{background-color:#DFF0D8;height:78px;color:#255B56;padding-left:15px;padding-top:10px;padding-bottom:0px;border-radius:0px;}
			#mod1 div{height:22px;font-size:12px;}
			#hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
			#mod2-left{width:25%;font-size:14px;float:left;}
			#left-top{height:40px;line-height:40px;font-weight:bold;color:#676767;border-bottom:1px solid #ccc;margin-bottom:20px;}
			#left-bottom div{border:1px solid #B6B6B6;height:28px;line-height:28px;color:#6B6B6B;border-left:4px solid #828282;margin-top:5px;margin-bottom:5px;padding-left:5px;}
			#left-bottom li{border:1px solid #B6B6B6;height:28px;line-height:28px;color:#6B6B6B;border-left:4px solid #828282;margin-top:5px;margin-bottom:5px;padding-left:5px;}
			.lv1{margin-left:20px;}
			.lv2{margin-left:40px;}
			.lv3{margin-left:60px;}
			.lv4{margin-left:80px;}
			.lv5{margin-left:100px;}
			.left-li{margin-left:5px;}
			.right-span{float:right;margin-right:5px;}
			#mod2-right{float:right;width:73%;font-size:14px;}
			#right-head{height:40px;line-height:40px;font-weight:bold;color:#676767;border-bottom:1px solid #ccc;margin-bottom:20px;}
			#right-head button{float:right;margin-top:4px;background-color:#1AA094;border:1px solid #1AA094;height:32px;line-height:32px;color:#fff;width:100px;}
			#right-head button i{margin-right:5px;}

			
			#formtable{width:500px;}
			#formtable tr{height:50px;line-height:50px;}
			#formdiv{width:600px;}
			#formtishi{width:600px;height:80px;background-color:#DFF0D8;color:#255B56;}
			#tishi-left,#tishi-right{float:left;margin-top:20px;margin-left:10px;}
			.redstar{text-align:center;color:#f00;}

			#form-div select{width:300px;height:40px;}
			.selectcss{height:40px;width:100%;border:1px solid #E5E5E5;}
			
			#table-head{border:1px solid #E2E2E2;margin-bottom:0px;height:40px;line-height:40px;background-color:#F8F8F8;color:#656565;padding-left:5px;font-weight:bold;}

		</style>
	</head>

	<body>
	<div id="box">
		<!--头部文字-->
		<div id="mod-head">
		部门和用户设置
		</div>
		<!--头部结束-->
		<!--中部提示-->
		<div id="mod1">
			<div>提示:<span id="hidden-div"><a onclick="hidden_div()">×</a></span></div>
			<div>1、公司组织架构非常重要，部分管理功能以及数据权限是依赖于公司组织架构的，因此建议在正式使用产品前，进行相关配置</div>
			<div>2、部门组织架构支持多级、最多支持5级；</div>
		</div>
		<!--中部结束-->
		<!--下部数据-->
		<div id="mod2">
			<!--下部左边列表-->
			<div id="mod2-left">
				<div id="left-top">公司组织架构</div>
				<div id="left-bottom">
					<div id="user_company_name" class="lv-on" value="">
						<i class="fa fa-folder-open" aria-hidden="true"></i>
						<span class="left-li"><?php echo ($companyName); ?></span>
						<span class="right-span">
							<a onclick='bmadd(0)'><i class="fa fa-plus" aria-hidden="true"></i></a>
						</span>
					</div>
					<ul id="bmlistid">
						<?php echo ($bmList); ?>
					</ul>
				</div>
			</div>
			<!--左边列表结束-->
			<!--下部右边表格-->
			<div id="mod2-right">
				<div id="right-head">用户列表<button onclick="openwindow()"><i class="fa fa-plus" aria-hidden="true"></i>新增用户</button></div>
				<div id="right-list" style="padding-bottom:150px;">
							<div id="table-head">
								<?php echo ($companyName); ?>
							</div>
							<table id="table_local" class="layui-table" lay-skin="line" style="width:100%" >
								<thead>
									<tr>
										<th>姓名</th>
										<th>性别</th>
										<th>手机号</th>
										<th>角色</th>
										<th>主管</th>
										<th>主部门</th>
										<th>辅部门</th>
										<th>上次登录时间</th>
										<th width="30px">操作</th>
									</tr>
								</thead>
								<tbody>
									<?php echo ($userList); ?>
								</tbody>
							</table>
						
				</div>
			</div>
			<!--右边表格结束-->
		</div>
		<!--下部结束-->
	</div>
	</body>
	<div  id="formdiv">
		<div id="formtishi">
			<div id="tishi-left">提示：</div>
			<div id="tishi-right">
				1、新增用户保存后，系统将自动给此用户发送短信通知，告知帐户的初始密码。<br>
				2、如通知短信未收到时，建议此用户通过找回密码功能自己设置。
			</div>
		</div>
	<center>
	<div id="addform" style="padding:10px;" class="layui-form">
		<table id="formtable">
			<tr>
				<td class="redstar">*</td>
				<td>姓名</td>
				<td><input type="text" id="xingming" required lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input" /></td>
			</tr>
			<tr>
				<td class="redstar"></td>
				<td>性别</td>
				<td id="xingbie"><input type="radio" name="xingbie" title="男" id="nan" value="1" checked/><input type="radio" id="nv" name="xingbie" title="女" value="2"/></td>
			</tr>
			<tr>
				<td class="redstar">*</td>
				<td>手机号</td>
				<td><input type="text" id="shoujihao" required lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input"/></td>
			</tr>
			<tr>
				<td class="redstar">*</td>
				<td>邮箱</td>
				<td><input type="text" id="youxiang" required lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input"/></td>
			</tr>
			<tr>
				<td class="redstar">*</td>
				<td>角色</td>
				<td >
					<select id="juese" lay-verify="required" class="selectcss" lay-ignore>
						<?php echo ($jueseoption); ?>
					</select>    
				</td>
			</tr>
			<tr>
				<td class="redstar">*</td>
				<td>主管</td>
				<td>
					<select id="zhuguan" lay-verify="" class="selectcss" lay-ignore>
						<?php echo ($zhuguanoption); ?>
					</select>   
				</td>
			</tr>
			<tr>
				<td class="redstar">*</td>
				<td>主部门</td>
				<td>
					<select id="zhubumen" lay-verify="" lay-verify="required" class="selectcss" lay-ignore>
						<?php echo ($bumenoption); ?>
					</select>   
				</td>
			</tr>
			<tr>
				<td class="redstar"></td>
				<td>辅部门</td>
				<td>
					<select id="fubumen"   class="selectcss" lay-ignore>
						<?php echo ($bumenoption); ?>
					</select>   
				</td>
			</tr>
			<tr id="baocunbtn">
				<td colspan="3"><center><button class="layui-btn" id="adduserbtn" >保存</button></center></td>
			</tr>
		</table>
	</div>
	</center>
	</div>

	<div id="bumendiv" class="layui-form">
	<center>
		<table id="bumentable" width="500px" style="margin-top:20px;">
			<tr id="shangji">
				<td style="width:80px;" >上级部门</td>
				<td><input type="text"  disabled required lay-verify="required" placeholder="上级部门" autocomplete="off" class="layui-input"/></td>
			</tr>
			<tr>
				<td>部门名称</td>
				<td><input type="text" id="newBumenName" style="margin-top:10px;" required lay-verify="required" placeholder="请输入部门名称" autocomplete="off" class="layui-input"/></td>
			</tr>
		</table>
	</center>
	</div>

	<div id="mimadiv" class="layui-form" style="margin-bottom:20px;">
	<center>
		<table id="mimatable" width="500px" style="margin-top:20px;">
			<tr id="">
				<td style="width:80px;" >登录密码</td>
				<td><input type="password" id="xinmima"   required lay-verify="required" placeholder="请输入新密码" autocomplete="off" class="layui-input"/></td>
			</tr>
			<tr>
				<td>确认密码</td>
				<td><input type="password" id="querenmima" style="margin-top:10px;" required lay-verify="required" placeholder="确认新密码" autocomplete="off" class="layui-input"/></td>
			</tr>
		</table>
	</center>
	</div>

	<script>
		
		$("#formdiv").hide();
		$("#bumendiv").hide();
		$('#mimadiv').hide();
		window.root_dir="<?php echo ($_GET['root_dir']); ?>";
		window.nowclick='b';
		window.addoredit='add';
		//上方绿色提示框的关闭效果
		function hidden_div(){
			$("#mod1").hide();
		}
		$(".right-span").hide();
		//黑色半透明提示
		function tishi(neirong)
		{
			layer.msg(neirong, {
				time: 1000, 
			});
		}
		
		
		//部门列表上方公司名称点击事件
		$(".lv-on").on("click",function(){
			if(nowclick=='a')	return false;
			var clicktext=$(this).text();
			$("#table-head").text(clicktext);
			if($(this).is("div"))//如果点击了DIV
			{
				if(!$(this).val())
				{
					$(this).children("i").removeClass("fa-folder-open");
					$(this).children("i").addClass("fa-folder");
					$(this).val('1');
					$(this).parent().children("ul").hide("fast");
				}
				else
				{
					$(this).children("i").removeClass("fa-folder");
					$(this).children("i").addClass("fa-folder-open");
					$(this).val('');
					$(this).parent().children("ul").show("fast");
				}
			}
		});
		//部门列表点击事件
		function onshijian()
		{
		$(".lv-on").on("click",function(){
			if(nowclick=='a')	return false;
			var clicktext=$(this).text();
			$("#table-head").text(clicktext);
			if(!$(this).is("div"))
			{
				var thisid=$(this).attr("id").substr(2);
				var hideFid='fid'+thisid;
				if($(this).val()=='1')
				{
					$(this).children("i").removeClass("fa-folder-open");
					$(this).children("i").addClass("fa-folder");
					$(this).css('border-left','4px solid #B7B7B7');
					$(this).val('0');
					var thislv=$(this).attr("name");
					$(".lv"+thislv+thisid).hide("fast");
					$(".lv"+thislv+thisid).val('0');
					$(".lv"+thislv+thisid).children("i").removeClass("fa-folder-open");
					$(".lv"+thislv+thisid).children("i").addClass("fa-folder");
					$(".lv"+thislv+thisid).css('border-left','4px solid #B7B7B7');	
				}
				else
				{
					$(this).children("i").removeClass("fa-folder");
					$(this).children("i").addClass("fa-folder-open");
					$(this).css('border-left','4px solid #828282');
					$(this).val('1');
					var thislv=$(this).attr("name");
					$(".lv"+thislv+thisid).show("fast");
					$(".lv"+thislv+thisid).val('1');
					$(".lv"+thislv+thisid).children("i").removeClass("fa-folder");
					$(".lv"+thislv+thisid).children("i").addClass("fa-folder-open");
					$(".lv"+thislv+thisid).css('border-left','4px solid #828282');
				
				}
			}
		});
		return '22';
		}
		onshijian();
		//部门标签右边小图标的显示和隐藏
		$(".lv-on").mouseover(function(){
			$(this).children(".right-span").show();
		});
		$(".lv-on").mouseout(function(){
			$(this).children(".right-span").hide();
		});
		//初始化form表单插件
		layui.use('form', function(){
		window.form = layui.form();
		});
		//当点击添加用户按钮时触发该事件
		function openwindow(){
			$("input").val('');
			$("#zhubumen").val('');
			$("#fubumen").val('');
			$("#zhuguan").val('');
			$("#baocunbtn").show();
			layui.use('layer', function(){
				var layer = layui.layer;
				window.addyonghuopen=layer.open({
					type:1,
					area:'600px',
					title: '新增用户',
					content:$('#formdiv')
				}); 
			});  
		}
		//添加部门
		function bmadd(thisfid)
		{ 
			if(this.tagName==undefined)
			{
				nowclick='a';
			}
			if(thisfid=='0')
			{
				$("#shangji").hide();
			}
			else
			{
				$("#shangji").show();
				var shangjiname=$("#id"+thisfid).text();
				$("#shangji").children("td").children("input").val(shangjiname);
			}
			layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'600px',
					title: '添加部门',
					content:$('#bumendiv'),
					btn: '保存',
               		btn1: function(index, layero){
						var newBumenName=$("#newBumenName").val();
						if(newBumenName=='')
						{
							tishi("部门名称不能为空");
							return false;
						}
						$.get(root_dir+'/index.php/Home/OptionDo/bumenadd',{"newname":newBumenName,"fid":thisfid},function(is_ok){
							if(is_ok=='1')
							{
								$.get(root_dir+'/index.php/Home/OptionDo/bumenshuaxin',{"newname":newBumenName,"fid":thisfid},function(searcharr){
									newbumenlistarr=searcharr.split('@@');
									//更新部门列表
									$("#bmlistid").html(newbumenlistarr[0]);
									//更新添加用户中部门下拉框中的部门
									$("#zhubumen").html(newbumenlistarr[1]);
									$("#fubumen").html(newbumenlistarr[1]);
									//重新监听部门列表右边的按钮事件
									$(".right-span").hide();
									$(".lv-on").mouseover(function(){
										$(this).children(".right-span").show();
									});
									$(".lv-on").mouseout(function(){
										$(this).children(".right-span").hide();
									});
									onshijian();
								});
								tishi("添加成功");
								layer.close(index);
								nowclick='b';
							}
							else if(is_ok=='2')
							{
								tishi("该部门已存在");
							}
							else if(is_ok=='3')
							{
								tishi("输入的内容不合法");
							}
							else
							{
								tishi("添加失败，请重试");
							}
						});
                    },
					cancel: function(){ 
						nowclick='b';
					}
				}); 
			});
		}
		//选择主部门后，对应的辅部门变为不可选
		$("#zhubumen").change(function(){
			$("#fubumen").children("option").attr("disabled",false);
			var zhuid=$("#zhubumen").val();
			$("#fubumen").children("option[value='"+zhuid+"']").attr("disabled",true);
		});
		$("#fubumen").change(function(){
			$("#zhubumen").children("option").attr("disabled",false);
			var zhuid=$("#fubumen").val();
			$("#zhubumen").children("option[value='"+zhuid+"']").attr("disabled",true);
		});

		//修改部门
		function bmedit(thisid)
		{
			var thisname=$("#id"+thisid).text();
			var bmFnameArr='<?php echo ($bumenFname); ?>';
			var fname=jQuery.parseJSON(bmFnameArr);

			$("#newBumenName").val(thisname);
			
			if(this.tagName==undefined)
			{
				nowclick='a';
			}
			if(fname[thisid]<1)
			{
				$("#shangji").hide();
			}
			else
			{
				$("#shangji").show();
				$("#shangji").children("td").children("input").val(fname[thisid]);
			}


			layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'600px',
					title: '修改部门',
					content:$('#bumendiv'),
					btn: '保存',
               		btn1: function(index, layero){
						var namename=$("#newBumenName").val();
						if(thisname==namename)//如果用户没有修改任何内容，直接点保存，就直接提示修改成功
						{
							tishi("修改成功");
							layer.close(index);
							nowclick='b';
						}
						else
						{
							$.get(root_dir+'/index.php/Home/OptionDo/bumenedit',{"newname":namename,"thisid":thisid},function(is_ok){
								if(is_ok=='1')
								{
									$.get(root_dir+'/index.php/Home/OptionDo/bumenshuaxin',{},function(searcharr){
										newbumenlistarr=searcharr.split('@@');
										//更新部门列表
										$("#bmlistid").html(newbumenlistarr[0]);
										//更新添加用户中部门下拉框中的部门
										$("#zhubumen").html(newbumenlistarr[1]);
										$("#fubumen").html(newbumenlistarr[1]);
										//重新监听部门列表右边的按钮事件
										$(".right-span").hide();
										$(".lv-on").mouseover(function(){
											$(this).children(".right-span").show();
										});
										$(".lv-on").mouseout(function(){
											$(this).children(".right-span").hide();
										});
										onshijian();
									});
									$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
										var fhArr=searcharr.split("@@&&");
										//更新用户表格
										$("#table_local").children("tbody").html(fhArr[1]);
										//更新添加用户时的主管下拉框
										$("#zhuguan").html(fhArr[0]);
									});
									tishi("修改成功");
									layer.close(index);
									nowclick='b';
								}
								else if(is_ok=='2')
								{
									tishi("该部门已存在");
								}
								else if(is_ok=='3')
								{
									tishi("输入的内容不合法");
								}
								else
								{
									tishi("修改失败，请重试");
								}
							});
						}
                    },
					cancel: function(){ 
						nowclick='b';
					}
				}); 
			});
		}
		//删除部门
		function bmdel(thisid)
		{
			//当点击子元素时不触发父元素的事件
			if(this.tagName==undefined)
			{
				nowclick='a';
			}
			var thisname=$("#id"+thisid).text();
			layer.msg('是否确定删除&nbsp;<font color="#f00" style="font-weight:bold">'+thisname+'</font>&nbsp;？<br>确认后将默认删除此部门的所有下级部门<br>所有下级部门的用户将自动移动到主部门', {
				time: 2000000, //20s后自动关闭
				btn: ['确认删除', '取消'],
				btn1: function(index, layero){
					$.get(root_dir+'/index.php/Home/OptionDo/bumendel',{"thisid":thisid,"thisname":thisname},function(is_ok){
						if(is_ok=='1')
						{
							$.get(root_dir+'/index.php/Home/OptionDo/bumenshuaxin',{},function(searcharr){
								newbumenlistarr=searcharr.split('@@');
								//更新部门列表
								$("#bmlistid").html(newbumenlistarr[0]);
								//更新添加用户中部门下拉框中的部门
								$("#zhubumen").html(newbumenlistarr[1]);
								$("#fubumen").html(newbumenlistarr[1]);
								//重新监听部门列表右边的按钮事件
								$(".right-span").hide();
								$(".lv-on").mouseover(function(){
									$(this).children(".right-span").show();
								});
								$(".lv-on").mouseout(function(){
									$(this).children(".right-span").hide();
								});
								onshijian();
							});
							$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
								var fhArr=searcharr.split("@@&&");
								//更新用户表格
								$("#table_local").children("tbody").html(fhArr[1]);
								//更新添加用户时的主管下拉框
								$("#zhuguan").html(fhArr[0]);
							});
							tishi("删除成功");
						}
						else
						{
							tishi("删除失败");
						}
					});
					layer.close(index);
					nowclick='b';
				},
				btn2: function(index, layero){
					nowclick='b';
				}
			});
		}
		//添加用户(修改用户)
		$("#adduserbtn").click(function(){
			if(window.addoredit=='add')
			{
				//表单信息
				var addusername=$("#xingming").val();
				if($("input[name='xingbie']:checked").attr('id')=='nan')
				{
					var addusersex="1";
				}
				else
				{
					var addusersex="2";
				}
				var adduserphone=$("#shoujihao").val();
				var adduseremail=$("#youxiang").val();
				var adduserjuese=$("#juese").val();
				var adduserzhuguan=$("#zhuguan").val();
				var adduserzhubm=$("#zhubumen").val();
				var adduserfubm=$("#fubumen").val();
				//表单验证
				if(!addusername)
				{
					tishi("用户名不能为空");
					return false;
				}
				if(addusername.length>16)
				{
					tishi("用户名不能超过16个字符");
					return false;
				}
				if(!addusername.match(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/))
				{
					tishi("用户名只能由中文、字母、数字和下划线组成");
					return false;
				}
				if(!adduserphone)
				{
					tishi("手机号不能为空");
					return false;
				}
				if (!adduserphone.match(/^1[0-9]{10}$/)) 
				{
					tishi("手机号格式不正确");
					return false;
				}
				if(!adduseremail)
				{
					tishi("邮箱不能为空");
					return false;
				}
				if(!adduseremail.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
				{
					tishi("邮箱格式不正确");
					return false
				}
				if(!adduserjuese)
				{
					tishi("角色不能为空");
					return false;
				}
				if(!adduserzhubm)
				{
					tishi("主部门不能为空");
					return false;
				}
				$.get(root_dir+'/index.php/Home/OptionDo/useradd',{"addusername":addusername,"addusersex":addusersex,"adduserphone":adduserphone,"adduseremail":adduseremail,"adduserjuese":adduserjuese,"adduserzhuguan":adduserzhuguan,"adduserzhubm":adduserzhubm,"adduserfubm":adduserfubm},function(is_ok){
					var fanhuiArr=is_ok.split('&&');
					if(fanhuiArr[0]=='1')
					{
						$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
							var fhArr=searcharr.split("@@&&");
							//更新用户表格
							$("#table_local").children("tbody").html(fhArr[1]);
							//更新添加用户时的主管下拉框
							$("#zhuguan").html(fhArr[0]);
						});
						layer.msg(addusername+'的密码为：'+fanhuiArr[1]+'<br>建议第一次登陆后修改密码', {
							time: 2000000, 
							btn: "确认",
							btn1: function(index2, layero){
								layer.close(index2);
							}
						});
						layer.close(addyonghuopen);
					}
					else if(fanhuiArr[0]=='2')
					{
						tishi("您填写的内容不合法");
					}
					else
					{
						tishi(is_ok);
						return false;
					}
				});
			}
		});
		//冻结
		function dongjie(thisTrId,thisType)
		{
			if(thisType=='0')
			{
				var djtishi='是否确认冻结此用户？<br>冻结后此用户将无法登录';
			}
			else if(thisType=='1')
			{
				var djtishi='是否确认取消此用户的冻结状态？<br>取消冻结后此用户将可以正常登录';
			}
			else
			{
				tishi("未知错误，请刷新页面后重试");
				return false;
			}
			layer.msg(djtishi, {
				time: 2000000, //20s后自动关闭
				btn: ['确定', '取消'],
				btn1: function(index, layero){
					$.get(root_dir+'/index.php/Home/OptionDo/dongjie',{"thisTrId":thisTrId,"DJtype":thisType},function(FH){
						if(FH=='1')
						{
							$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
								var fhArr=searcharr.split("@@&&");
								//更新用户表格
								$("#table_local").children("tbody").html(fhArr[1]);
								//更新添加用户时的主管下拉框
								$("#zhuguan").html(fhArr[0]);
							});
						}
						if(FH=='0')
						{
							tishi("操作失败，请稍后再试");
						}
					});
					layer.close(index);
				},
				btn2: function(index, layero){
					layer.close(index);
				}
			});
		}
		//修改密码
		function pwdedit(thisTrId)
		{
			layui.use('layer', function(){
				var layer = layui.layer;
				window.addyonghuopen=layer.open({
					type:1,
					area:'600px',
					title: '修改密码',
					content:$('#mimadiv'),
					btn:['确认修改','取消'],
					btn1: function(index, layero){
						var newpwd=$("#xinmima").val();
						var querenpwd=$("#querenmima").val();
						if(newpwd=='')
						{
							tishi("密码不能为空");
							return false;
						}
						var zzobj=/^(\w){6,20}$/;
						if(newpwd.length>20||newpwd.length<4)
						{
							tishi("密码长度必须为4-20位");
							return false;
						}
						if(newpwd!=querenpwd)
						{
							tishi("两次输入的密码不一致");
							return false;
						}
						$.get(root_dir+'/index.php/Home/OptionDo/pwdedit',{"editid":thisTrId,"pwd":newpwd},function(XG){
							if(XG==1)
							{
								tishi("修改成功");
								layer.close(index);
							}
							else if(XG==2)
							{
								tishi("修改失败，密码不能为空");
							}
							else
							{
								tishi("修改失败，出现未知错误，请稍后重试");
								layer.close(index);
							}
						});
					},
					btn2: function(index, layero){
						layer.close(index);
					}
				}); 
			});  
		}
		//用户删除
		function userdel(thisuserid,thisusername)
		{
			var deltishi="<div style='text-align:left;'>即将删除用户：<font style='color:#f00;font-weight:bold;'>"+thisusername+"</font><br>删除后,此用户将无法登陆，并且<font style='color:#f00;font-weight:bold'>无法恢复</font>，但不会删除此账号下的任何数据。<br><font style='color:#f00;font-weight:bold;'>是否确认删除？</font></div>";
			layer.msg(deltishi, {
				time: 2000000, //20s后自动关闭
				btn: ['确认删除', '取消'],
				btn1: function(index, layero){
					$.get(root_dir+'/index.php/Home/OptionDo/userdel',{"deluserid":thisuserid,"delusername":thisusername},function(is_del){
						
						if(is_del=='1')
						{
							$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
								var fhArr=searcharr.split("@@&&");
								//更新用户表格
								$("#table_local").children("tbody").html(fhArr[1]);
								//更新添加用户时的主管下拉框
								$("#zhuguan").html(fhArr[0]);
							});
							tishi("删除成功");
						}
						else if(is_del=='2')
						{
							tishi("error:001");
						}
						else
						{
							tishi("未知错误，请刷新页面后重试");
						}
					});
					layer.close(index);
				},
				btn2: function(index, layero){
					layer.close(index);
				}
			});
		}
		//用户编辑
		function useredit(bj_id,bj_name,bj_sex,bj_phone,bj_email,bj_juese,bj_zhuguan,bj_zhubm,bj_fubm)
		{
			//===========修改时的显示操作==============
			if(bj_sex==1)
				$("#xingbie").html("<input type='radio' name='xingbie' title='男' id='nan' value='1' checked/><input type='radio' id='nv' name='xingbie' title='女' value='2'/>");
			else
				$("#xingbie").html("<input type='radio' name='xingbie' title='男' id='nan' value='1'/><input type='radio' id='nv' name='xingbie' title='女' value='2' checked/>");
			form.render('radio');
			$("#xingming").val(bj_name);
			$("#shoujihao").val(bj_phone);
			$("#youxiang").val(bj_email);
			$("#juese").val(bj_juese);
			$("#zhuguan").val(bj_zhuguan);
			$("#zhubumen").val(bj_zhubm);
			$("#fubumen").val(bj_fubm);
			$("#baocunbtn").hide();
			if(bj_zhubm=='')//如果主部门不为空，就把辅部门列表中的选中的主部门给屏蔽掉
			{	
				$("#fubumen").children("option").attr("disabled",false);
				$("#fubumen").children("option[value='"+bj_zhubm+"']").attr("disabled",true);
			}
			if(bj_fubm=='')//辅部门也是
			{
				$("#zhubumen").children("option").attr("disabled",false);
				$("#zhubumen").children("option[value='"+bj_fubm+"']").attr("disabled",true);
			}
			//===========================================
			layui.use('layer', function(){
				var layer = layui.layer;
				window.addyonghuopen=layer.open({
					type:1,
					area:'600px',
					title: '修改用户',
					content:$('#formdiv'),
					btn:["修改","取消"],
					btn1:function(index, layero){
						//重新获取表单中的值
						var addusername=$("#xingming").val();
						if($("input[name='xingbie']:checked").attr('id')=='nan')
						{
							var addusersex="1";
						}
						else
						{
							var addusersex="2";
						}
						var adduserphone=$("#shoujihao").val();
						var adduseremail=$("#youxiang").val();
						var adduserjuese=$("#juese").val();
						var adduserzhuguan=$("#zhuguan").val();
						var adduserzhubm=$("#zhubumen").val();
						var adduserfubm=$("#fubumen").val();
						var updatestr='';
						//表单验证
						if(!addusername)
						{
							tishi("用户名不能为空");
							return false;
						}
						if(addusername.length>16)
						{
							tishi("用户名不能超过16个字符");
							return false;
						}
						if(!addusername.match(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/))
						{
							tishi("用户名只能由中文、字母、数字和下划线组成");
							return false;
						}
						if(!adduserphone)
						{
							tishi("手机号不能为空");
							return false;
						}
						if (!adduserphone.match(/^1[0-9]{10}$/)) 
						{
							tishi("手机号格式不正确");
							return false;
						}
						if(!adduseremail)
						{
							tishi("邮箱不能为空");
							return false;
						}
						if(!adduseremail.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
						{
							tishi("邮箱格式不正确");
							return false
						}
						if(!adduserjuese)
						{
							tishi("角色不能为空");
							return false;
						}
						if(!adduserzhubm)
						{
							tishi("主部门不能为空");
							return false;
						}
						var editusername=bj_name;
						//判断有没有修改东西
						if(bj_name!=addusername&&!(bj_name=='0'&&addusername==null))
						{
							updatestr=updatestr+"user_name:"+addusername+',';
							editusername=addusername;
						}
						if(bj_sex!=addusersex&&!(bj_sex=='0'&&addusersex==null))
						{
							updatestr=updatestr+"user_sex:"+addusersex+',';
						}
						if(bj_phone!=adduserphone&&!(bj_phone=='0'&&adduserphone==null))
						{
							updatestr=updatestr+"user_phone:"+adduserphone+',';
						}
						if(bj_email!=adduseremail&&!(bj_email=='0'&&adduseremail==null))
						{
							updatestr=updatestr+"user_email:"+adduseremail+',';
						}
						if(bj_juese!=adduserjuese&&!(bj_juese=='0'&&adduserjuese==null))
						{
							updatestr=updatestr+"user_quanxian:"+adduserjuese+',';
						}
						if(bj_zhuguan!=adduserzhuguan&&!(bj_zhuguan=='0'&&adduserzhuguan==null))
						{
							updatestr=updatestr+"user_zhuguan_id:"+adduserzhuguan+',';
						}
						if(bj_zhubm!=adduserzhubm&&!(bj_zhubm=='0'&&adduserzhubm==null))
						{
							updatestr=updatestr+"user_zhu_bid:"+adduserzhubm+',';
						}
						if(bj_fubm!=adduserfubm&&!(bj_fubm=='0'&&adduserfubm==null))
						{
							updatestr=updatestr+"user_fu_bid:"+adduserfubm+',';
						}
						//如果有修改，就和服务器进行交互
						if(updatestr!='')
						{
							$.get(root_dir+'/index.php/Home/OptionDo/useredit',{"usereditid":bj_id,"usereditdata":updatestr,"editusername":editusername},function(usereditres){
								if(usereditres=='1')
								{
									$.get(root_dir+'/index.php/Home/OptionDo/usershuaxin',{},function(searcharr){
										var fhArr=searcharr.split("@@&&");
										//更新用户表格
										$("#table_local").children("tbody").html(fhArr[1]);
										//更新添加用户时的主管下拉框
										$("#zhuguan").html(fhArr[0]);
									});
									tishi("修改成功");
									layer.close(index);
								}
								else if(usereditres=='2')
								{
									tishi("error:001");
								}
								else
								{
									tishi("未知错误，请刷新后重试");
								}
							});
						}
						else
						{
							layer.close(index);
						}
						
					},
					btn2:function(index, layero){
						layer.close(index);
					}
				}); 
			});  
			//
		}
	</script>
</html>