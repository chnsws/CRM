<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>登录</title>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/login.css" />
	</head>

	<body class="beg-login-bg">
		<div class="beg-login-box">
			<header>
				<h1>中软远景CRM登录</h1>
			</header>
			<div class="beg-login-main">
				<form action="/manage/login" class="layui-form" method="post"><input name="__RequestVerificationToken" type="hidden" value="fkfh8D89BFqTdrE2iiSdG_L781RSRtdWOH411poVUWhxzA5MzI8es07g6KPYQh9Log-xf84pIR2RIAEkOokZL3Ee3UKmX0Jc8bW8jOdhqo81" />
					<div class="layui-form-item">
						<label class="beg-login-icon">
                        <i class="layui-icon">&#xe612;</i>
                    </label>
						<input type="text" name="userName" lay-verify="userName" autocomplete="off" placeholder="这里输入登录名" class="layui-input">
					</div>
					<div class="layui-form-item">
						<label class="beg-login-icon">
                        <i class="layui-icon">&#xe642;</i>
                    </label>
						<input type="password" name="password" lay-verify="password" autocomplete="off" placeholder="这里输入密码" class="layui-input">
					</div>
					<div class="layui-form-item">
						<div class="beg-pull-left beg-login-remember">
							<label>记住帐号？</label>
							<input type="checkbox" name="rememberMe" value="true" lay-skin="switch" lay-filter='switchTest' checked title="记住帐号">
						</div>
						<div class="beg-pull-right">
							<button class="layui-btn layui-btn-primary" id="loginbtn" lay-submit lay-filter="login">
                            	<i class="layui-icon">&#xe650;</i> 登录
                        	</button>
						</div>
						<div class="beg-clear"></div>
					</div>
				</form>
			</div>
			<footer>
				<p>2017 © 中软远景 版权所有</p>
			</footer>
		</div>
		<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"></script>
		<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/jquery-md5/jquery.md5.js"></script>
		<script>
		if(!navigator.cookieEnabled)//判断是否开启COOKIE
		{
			alert("您尚未开启浏览器的COOKIE，这将导致您不能正常使用系统。")
		}
		//判断是否记住用户名
		var jizhuname="<?php echo ($_COOKIE['jizhu']); ?>";
		if(jizhuname!='')
			$("input[name='userName']").val(jizhuname);
		//黑色半透明提示
		function tishi(neirong)
		{
			layer.msg(neirong, {
				time: 2000, 
			});
		}
		root_dir="<?php echo ($_GET['root_dir']); ?>";
		window.swithstaus='1';
		layui.use(['layer', 'form'], function() {
			var layer = layui.layer,
				$ = layui.jquery,
				form = layui.form();
				//监听指定开关
				form.on('switch(switchTest)', function(data){
					if(data.elem.checked)
					{
						layer.tips('系统将在一个月内记住您的用户名', data.othis);
						window.swithstaus='1';
					}
					else
					{
						window.swithstaus='0';
					}
				});
		});


		$("#loginbtn").click(function(){
			var username=$("input[name='userName']").val();
			var userpwd	=$.md5($("input[name='password']").val());
			if(username==''){tishi("用户名不能为空");return false;}
			if($("input[name='password']").val()==''){tishi("密码不能为空");return false;}
			$.post(root_dir+'/index.php/Home/Login/yanzheng',{name:username,pwd:userpwd,jizhu:swithstaus},function(is_success){
				if(is_success=='1')
				{
					location.href="<?php echo ($_GET['root_dir']); ?>/index.php";
				}
				else if(is_success=='3')
				{
					tishi("您的账户已过期，请联系网站管理员进行续费。");
				}
				else if(is_success=='4')
				{
					tishi("您的账户已被冻结，请联系公司管理员进行解冻。");
				}
				else
				{
					tishi("用户名或密码错误，请查证后重试。");
				}
			});
			return false;
		});
		</script>
	</body>

</html>