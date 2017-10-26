<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>角色和权限设置</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
		<!--jqueryUI插件 折叠面板-->
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/option-quanxian-css/jquery-ui.css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.min.js"></script>
		<!--layUI 插件 --弹窗设计 form表单样式 -->
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
	<style>
		*{padding:0;margin:0;}
		div{border:0px solid #f00;}
		#box{margin-left:10px;margin-right:10px;}
		a{text-decoration:none;cursor:pointer;}
		/*头部页面名称*/
		#mod-head{height:100px;font-size:22px;line-height:100px;color:#1AA094;font-weight:bold;}
		/*中部可关闭的提示框*/
		#mod1{background-color:#DFF0D8;height:78px;color:#255B56;padding-left:15px;padding-top:10px;padding-bottom:0px;border-radius:0px;}
		#mod1 div{height:22px;font-size:12px;}
		#hidden-div{float:right;font-weight:bold;margin-right:15px;font-size:20px;color:#656565;}
		
		/*下部数据表部分*/
		#mod2{margin-top:10px;}
		#mod2-left,#mod2-right{float:left;}
		#mod2-left{width:30%;}
		#mod2-right{width:70%}
		/*下部-左边和右边-头部文字和按钮*/
		#mod2-left-head{height:40px;line-height:40px;font-weight:bold;color:#676767;}
		#mod2-right-head{height:40px;line-height:40px;font-weight:bold;color:#676767;}
		/*左边角色列表*/
		#mod2-left-body{padding-bottom:1px;}
		.left-juese{height:40px;line-height:40px;padding-left:10px;border:1px solid #ccc;background-color:#F2F2F2;color:#636363;border-left:4px solid #ccc;cursor:pointer;margin-bottom:-1px;}
		.left-juese span{float:right;margin-right:30px;color:#949494}
		.left-juese i{float:right;margin-right:10px;margin-top:14px;}
		/*右边头部按钮*/
		.right-top-button{float:right;margin-left:10px;}
		#mod2-right-head{height:40px;line-height:40px;font-weight:bold;color:#676767;}
		/*右边主体*/
		.layui-tab-title{color:#525252;}
		#mod2-right-body{border:1px solid #ccc;}
		#right-body-head{height:40px;line-height:40px;color:#525252;padding-left:20px;}
		/*折叠标签css*/
		#accordion h3{border-radius:0px;height:30px;color:#636363;margin-top:10px;line-height:30px;background-color:#F2F2F2;}
		#accordion div{border-radius:0px;}
		/*添加角色弹出框表格*/
		#addtable{width:500px;}
		#addtable tr{height:60px;}
		#addtable tr td{text-align:center;font-weight:bold;}
		/*复制角色弹出框表格*/
		#copytable{width:500px;}
		#copytable tr{height:60px;}
		#copyselect{width:100%;height:40px;border:1px solid #D2D2D2;}
		#copytable tr td{text-align:center;font-weight:bold;}
		/*数据权限*/
		.dataqx{margin-top:10px;margin-right:10px;}
	</style>
	</head>
	<script>

</script>
	<body>
	<div id="box">
		<!--页面名称-->
		<div id="mod-head">角色和权限设置</div>
		<!--中部可关闭提示-->
		<div id="mod1">
			<div>提示:<span id="hidden-div"><a onclick="hidden_div()">×</a></span></div>
			<div>
				1、角色代表操作权限和数据权限，操作权限是指具有该角色的用户是否能查看、新增、编辑、删除某些数据，数据权限是指具有该角色的用户能操作的数据的范围；
			</div>
			<div>
				2、超级管理员的权限是系统默认的最大权限的角色，不能修改。
			</div>
		</div>
		<!--下部数据-->
		<div id="mod2">
			<div id="mod2-left">
				<div id="mod2-left-head">公司角色</div>
				<div id="mod2-left-body">
					<?php echo ($jueselist); ?>
				</div>
			</div>
			<div id="mod2-right">
				<div id="mod2-right-head">
					<button class="right-top-button layui-btn" onclick="copyjuese()"><i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;复制角色</button>
					<button class="right-top-button layui-btn" onclick="addjuese()"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;新增角色</button>
				</div>
				<div id="mod2-right-body">
					<div id="right-body-head">
						超级管理员设置
					</div>
					<div class="layui-tab layui-tab-brief" style="margin-left:10px;margin-right:10px;">
						<ul class="layui-tab-title">
							<li class="layui-this">操作权限</li>
							<li>数据权限</li>
						</ul>
						<div class="layui-tab-content">
							<div class="layui-tab-item layui-show layui-form">
								<div id="accordion">
									
									<h3>线索-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_dc" title="导出">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xs_zy" title="转移线索给他人">
									</div>
									<h3>客户-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_dc" title="导出">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_zy_tr" title="转移客户给他人">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_zy_gh" title="转移至客户公海">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_dr_gh" title="导入至客户公海">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_kh_ck_gh" title="查看客户公海">
									</div>
									<h3>联系人-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_lx_dc" title="导出">
									</div>
									<h3>商机-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_dc" title="导出">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_sj_zy" title="转移商机给他人">
									</div>
									<h3>合同-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_dc" title="导出">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_ht_zy" title="转移合同给他人">
									</div>
									<h3>产品-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_dc" title="导出">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_cp_fl" title="产品分类设置">
									</div>
									<h3>跟进记录-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_gj_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_gj_dr" title="导入">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_gj_dc" title="导出">
									</div>
									<h3>知识库-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_ck" title="查看">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_xz" title="新增">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_bj" title="编辑">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_sc" title="删除">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_zd" title="置顶文档">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_zs_sz" title="版块设置">
									</div>
									<h3>报表-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_bb_dc" title="导出数据">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_bb_ck" title="查看报表">
									</div>
									<h3>系统-权限</h3>
									<div>
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ckbmyh" title="查看部门和用户">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_szbmyh" title="管理部门和用户"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ckjsqx" title="查看角色和权限">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_szjsqx" title="角色和权限设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ckgsxx" title="查看公司信息">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_bjgsxx" title="编辑公司信息"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ggsz" title="公告设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_szyjmb" title="设置业绩目标">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ckyjmb" title="查看业绩目标"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ccsz" title="客户查重设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_ghsz" title="客户公海设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_bgsz" title="工作报告设置">
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_gzbgdc" title="工作报告导出"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_sbsz" title="数据上报设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_hjzx" title="呼叫中心设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_zdyzd" title="自定义业务字段管理"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_zdycs" title="自定义业务参数管理"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_zdysp" title="自定义审批设置"><br />
										<input type="checkbox" lay-filter="qxcheckbox" id="qx_xt_cxrz" title="查询日志"><br />
									</div>
									
								</div><!--折叠结束-->
							</div><!--内容1结束-->
							<div class="layui-tab-item">
								<table id="dataqxtable">
									<tr>
										<td><input type="radio" name="dataqx" class="dataqx" id="dataqx1" value='1'>个人</td>
										<td style="padding-left:30px;color:#949494;">只能操作自己和下属的数据</td>
									</tr>
									<tr>
										<td><input type="radio" name="dataqx" class="dataqx" id="dataqx2" value='2'>所属部门</td>
										<td style="padding-left:30px;color:#949494;">能操作自己、下属、和自己所属部门的数据</td>
									</tr>
									<tr>
										<td><input type="radio" name="dataqx" class="dataqx" id="dataqx3" value='3'>所属部门及下属部门</td>
										<td style="padding-left:30px;color:#949494;">能操作自己、下属和自己所属部门及其子部门的数据</td>
									</tr>
									<tr>
										<td><input type="radio" name="dataqx" class="dataqx" id="dataqx4" value='4'>全公司</td>
										<td style="padding-left:30px;color:#949494;">能操作全公司的数据</td>
									</tr>
								
								
								
								
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
	<!--添加角色表单-->
	<div  id="addjuese">
		<center>
			<div id="addform" style="padding:10px;" class="layui-form">
				<table id="addtable">
					<tr>
						<td>角色名称</td>
						<td><input type="text" id='jsnameinput' name="jsname" required lay-verify="required" placeholder="角色名最长10个中文字符" autocomplete="off" class="layui-input" /></td>
					</tr>
					<tr>
						<td colspan="2"><center><button class="layui-btn" onclick="jsbc()">保存</button></center></td>
					</tr>
				</table>
			</div>
		</center>
	</div>
	<!--复制角色表单-->
	<div  id="copyjuese">
		<center>
			<form id="copyform" style="padding:10px;">
				<table id="copytable">
					<tr>
						<td>选择角色</td>
						<td>
							<select id="copyselect">
								
							</select>   
						</td>
					</tr>
					<tr>
						<td>新角色名称</td>
						<td><input type="text" id="copyjsnameinput"  required lay-verify="required" placeholder="角色名最长10个中文字符"  class="layui-input" /></td>
					</tr>
					
					<tr>
						<td colspan="2"><center><button class="layui-btn" onclick="copyjs()">保存</button></center></td>
					</tr>
				</table>
			</form>
		</center>
	</div>
	<script>
		window.nowClcikJueseId='0';
		window.root_dir="<?php echo ($_GET['root_dir']); ?>";
		//上方绿色提示框的关闭效果
		function hidden_div(){
			$("#mod1").hide();
		}
		//黑色半透明提示
		function tishi(neirong)
		{
			layer.msg(neirong, {
				time: 1000, 
			});
		}
		//layui初始化卡片折叠面板
		layui.use('element', function(){
			var element = layui.element();
			element.on('tab(demo)', function(data){
				console.log(data);
			});
		});
		//jqueryUI初始化折叠面板
		$(function() {
			$( "#accordion" ).accordion({
			  heightStyle: "content"
			});
		});
		//初始化
		$(".is-selected").val("1");
		$(".is-selected").css('background-color','#fff');
		$(".is-selected").css('border-left','4px solid #1AA094');
		$(".is-selected").css('border-right','0px solid #1AA094');
		$(".is-selected").css('color','#1AA094');
		$(".left-juese").children(".fa").hide();
		//鼠标移入
		$(".left-juese").mouseover(function(){
			$(this).css('color','#1AA094');
			$(this).css('border-left','4px solid #1AA094');
			$(this).children(".fa").show();
		});
		//鼠标移出
		$(".left-juese").mouseout(function(){
			if($(this).val()!="1")
			{
				$(this).css('color','#636363');
				$(this).css('border-left','4px solid #ccc');
				
			}
			$(this).children(".fa").hide();
			
		});
		$("input[type='checkbox']").prop("checked",false);
		$("input[type='checkbox']").prop("disabled",true);
		$("#dataqx4").prop("checked",true);
		$("input[type='radio']").prop("disabled",true);
		//点击左边角色列表事件
		$(".left-juese").click(function(){
			nowClcikJueseId=$(this).attr("id").substr(2);
			var juesename=$(this).text();
			if(juesename.substr(-4)=='系统默认')
			{
				juesename="超级管理员";
			}
			$("#right-body-head").html(juesename+'设置');
			//==========================左边角色列表效果开始==========================================
			//初始化表格样式
			$(this).parent().children(".left-juese").val("0");
			$(this).parent().children(".left-juese").css('color','#636363');
			$(this).parent().children(".left-juese").css('border-left','4px solid #ccc');
			$(this).parent().children(".left-juese").css('background-color','#F2F2F2');
			$(this).parent().children(".left-juese").css('border-right','1px solid #ccc');
			//添加表格样式
			$(this).val("1");
			$(this).css('background-color','#fff');
			$(this).css('border-left','4px solid #1AA094');
			$(this).css('border-right','1px solid #fff');
			$(this).css('color','#1AA094');
			//==========================左边角色列表效果结束============================================
		});
		//加载layui表单样式
		layui.use('form', function(){
			window.form = layui.form();
			//复选框的点击事件（值更改事件）
			form.on('checkbox(qxcheckbox)', function(data){
				var changefiled=data.elem.id;
				var changejuese=nowClcikJueseId;
				var changefiledvalue=data.elem.checked;
				var changefiledname=$("#qx"+changejuese).text();
				window.jiazai= layer.load(2);
				//改变数据库的该权限的值
				$.get(root_dir+"/index.php/Home/QuanxianDo/changeqxval",{"changefiled":changefiled,"changejuese":changejuese,"changefiledvalue":changefiledvalue,"changefiledname":changefiledname},function(cqvres){
					if(cqvres=='1')
					{
						layer.close(jiazai);
						tishi("修改成功");
					}
					else if(cqvres=='2')
					{
						layer.close(jiazai);
						tishi("修改失败");
					}
					else
					{
						layer.close(jiazai);
						tishi("修改失败，请刷新后重试");
					}
				});
			});    
		});
		//添加角色
		$("#addjuese").hide();
		function addjuese()
		{
			$("#jsnameinput").val('');
			window.isedit='0';
			layui.use('layer', function(){
				var layer = layui.layer;
				window.xinzeng=layer.open({
					type:1,
					area:'600px',
					title: '新增角色',
					content:$('#addjuese')
				}); 
			});  
		}
		//复制角色
		$("#copyjuese").hide();
		function copyjuese()
		{
			//获取最新的角色列表
			$.get(root_dir+"/index.php/Home/QuanxianDo/newjslist",{},function(jsselectstr){
				$("#copyselect").html(jsselectstr);
			});
			layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					scrollbar:false,
					area:'600px',
					title: '复制角色',
					content:$('#copyjuese')
				}); 
			}); 
		}
		//初始化超级管理员的权限
		function morenJsClick()
		{
			$("input[type='checkbox']").prop("checked",false);
			$("input[type='checkbox']").prop("disabled",true);
			$("#dataqx4").prop("checked",true);
			$("input[type='radio']").prop("disabled",true);
			form.render();
		}
		//动态改变右边的权限列表
		function jsClick(nowclickid)
		{
			//初始化效果
			$("input[type='checkbox']").prop("disabled",false);
			$("input[type='checkbox']").prop("checked",false);
			$("input[type='radio']").prop("disabled",false);
			//设置ajax同步执行
			$.ajaxSetup({
				async : false
			});
			$.get(root_dir+"/index.php/Home/QuanxianDo/oneqx",{"nowclickid":nowclickid},function(oneqxres){
				oneqxresarr=oneqxres.split('@@');
				window.resarr=oneqxresarr[0].split(',');
				window.resarrlength=resarr.length;
			});
			for(var aa=0;aa<resarrlength;aa++)
			{
				$("#"+resarr[aa]).prop("checked",true);
			}
			$("#dataqx"+oneqxresarr[1]).prop("checked",true);
			form.render();
		}
		//角色名称修改
		function jsedit(jsid)
		{
			window.isedit='1';
			var thisjsName=$("#qx"+jsid).text();
			$("#jsnameinput").val(thisjsName);
			$("#jsnameinput").attr("name",'xg'+jsid)
			layui.use('layer', function(){
				var layer = layui.layer;
				window.xiugai=layer.open({
					type:1,
					area:'600px',
					title: '修改角色名称',
					content:$('#addjuese')
				}); 
			});  
		}
		//角色删除
		function jsdel(jsid)
		{
			var jsname=$("#qx"+jsid).text();
			layer.msg("是否删除角色："+jsname+"？", {
				time: 2000000, //20s后自动关闭
				btn: ['确认删除', '取消'],
				btn1: function(index, layero){
					//设置ajax同步执行
					$.ajaxSetup({
						async : false
					});
					$.get(root_dir+"/index.php/Home/QuanxianDo/jsdel",{"jsid":jsid,"jsname":jsname},function(jsdelres){
						
					});
					location.reload(true);
					layer.close(index);
				},
				btn2: function(index, layero){
					layer.close(index);
				}
			});
		}
		//添加或修改角色的保存按钮
		function jsbc()
		{
			var editjsid=$("#jsnameinput").attr("name").substr(2);
			var editnewname=$("#jsnameinput").val();
			var thisjsName=$("#qx"+editjsid).text();
			if(!editnewname)
			{
				tishi("角色名不能为空");
				return false;
			}
			if(editnewname.length>16)
			{
				tishi("角色名不能超过16个字符");
				return false;
			}
			if(!editnewname.match(/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/))
			{
				tishi("角色名只能由中文、字母、数字和下划线组成");
				return false;
			}
			//修改
			if(isedit=='1')
			{
				if(editnewname==thisjsName)
				{
					tishi("修改成功");
					layer.close(xiugai);
					return false;
				}
				if(editnewname=='超级管理员')
				{
					tishi("修改失败，该角色已存在，请重新输入");
					return false;
				}
				$.get(root_dir+"/index.php/Home/QuanxianDo/jsedit",{"editjsid":editjsid,"editnewname":editnewname},function(oneqxres){
					if(oneqxres=='1')
					{
						tishi("修改成功");
						layer.close(xiugai);
						if($("#right-body-head").text()==$("#qx"+editjsid).text()+'设置')
						{
							$("#right-body-head").text(editnewname);
						}
						$("#qx"+editjsid).html(editnewname+"<i class='fa fa-trash-o' aria-hidden='true' onclick='jsdel("+editjsid+")' ></i><i class='fa fa-pencil' aria-hidden='true' onclick='jsedit("+editjsid+")'></i>");
						$(".left-juese").children(".fa").hide();
					}
					else if(oneqxres=='3')
					{
						tishi("修改失败，该角色已存在");
					}
					else if(oneqxres=='2')
					{
						tishi("修改失败");
					}
					else
					{
						tishi("修改失败，请刷新后重试");
					}
				});
			}
			else
			{
				if(editnewname=='超级管理员')
				{
					tishi("添加失败，该角色已存在，请重新输入");
					return false;
				}
				$.get(root_dir+"/index.php/Home/QuanxianDo/jsadd",{"addnewname":editnewname},function(oneqxres){
					if(oneqxres=='1')
					{
						location.reload(true);
					}
					else if(oneqxres=='2')
					{
						tishi("添加失败");
					}
					else
					{
						tishi("添加失败，请刷新后重试");
					}
				});
			}
		}
		//角色复制处理
		function copyjs()
		{
			var copyfromid=$("#copyselect").val();
			var copyjsnameinput=$("#copyjsnameinput").val();
			if(copyjsnameinput=='超级管理员')
			{
				tishi("复制失败，该角色已存在，请重新输入");
				return false;
			}
			$.get(root_dir+"/index.php/Home/QuanxianDo/jscopy",{"copyfromid":copyfromid,"copyjsnameinput":copyjsnameinput},function(oneqxres){
				if(oneqxres=='1')
				{
					location.reload(true);
				}
				else if(oneqxres=='2')
				{
					tishi("复制失败");
				}
				else if(oneqxres=='3')
				{
					tishi("复制失败，该角色已存在，请重新输入");
				}
				else
				{
					tishi("复制失败，请刷新后重试");
				}
			});
		}
		//数据权限改变
		$("input[type='radio']").change(function(){

			window.jiazai= layer.load(2);

			var changeid=nowClcikJueseId;
			var changeradioval=$(this).val();
			var thisjsName=$("#qx"+changeid).text();
			$.get(root_dir+"/index.php/Home/QuanxianDo/dataqxedit",{"changeid":changeid,"changeradioval":changeradioval,"thisjsName":thisjsName},function(dataqxres){
				if(dataqxres=='1')
				{
					layer.close(jiazai);
					tishi("修改成功");
				}
				else if(dataqxres=='2')
				{
					tishi("修改失败");
				}
				else
				{
					tishi("修改失败，请刷新后重试");
				}
			});
		});
	</script>
</html>