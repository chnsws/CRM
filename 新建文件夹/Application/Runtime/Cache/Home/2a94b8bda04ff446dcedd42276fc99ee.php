<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>智子科技CRM系统</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all" />
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
		<style>
			dd{width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
			dd a{max-width:470px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
		</style>
	</head>

	<body>
		<div class="layui-layout layui-layout-admin">
			<div class="layui-header header header-demo">
				<div class="layui-main">
					<div class="admin-login-box">
						<a class="logo" style="left: 0;">
							<?php echo ($_COOKIE['gsimg']); ?>
							<span style="font-size: 22px;"><?php echo ($_COOKIE['gsname']); ?></span>
						</a>
						<div class="admin-side-toggle" style="position:fixed;top:100%;left:0px;margin-top:-30px;display:none;">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</div>
					</div>
					<ul class="layui-nav admin-header-item">
			
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user" style="width:100px;">
								<span style="width:100px"><center><b>消息</b></b></center></span>
							</a>
							<dl class="layui-nav-child" style="max-width:480px;">
								<dd >
									<a href="">消息1</a>
								</dd>
								<dd>
									<a href="">消息2</a>
								</dd>
								<dd>
									<a href="">消息3</a>
								</dd>
							</dl>
						</li>
				
	
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user" style="width:100px;">
								<span style="width:100px"><center><b>帮助中心</b></b></center></span>
							</a>
							<dl class="layui-nav-child">
								<!--这是一条消息-->
								<dd>
									<a href=""> 帮助中心</a>
								</dd>
								<dd>
									<a href=""> 意见反馈</a>
								</dd>
								<dd>
									<a href=""> 客服电话</a>
								</dd>
							</dl>
						</li>
						<li class="layui-nav-item">
							<a href="javascript:;" class="admin-header-user" style="width:100px;">
				
								<span style="width:100px;"><center><b id="log_user_name"></b></center></span>
							</a>
							<dl class="layui-nav-child">
								
								<dd>
									<a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Option/"><i class="fa fa-gear" aria-hidden="true"></i> 设置</a>
								</dd>
								<dd>
									<a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Index/tuichu"><i class="fa fa-sign-out" aria-hidden="true"></i> 安全退出</a>
								</dd>
							</dl>
						</li>
					</ul>
					<ul class="layui-nav admin-header-item-mobile">
						<li class="layui-nav-item">
							<a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Index/tuichu"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="layui-side layui-bg-black" id="admin-side">
				<div class="layui-side-scroll" id="admin-navbar-side" lay-filter="side"></div>
			</div>
			<div class="layui-body" style="bottom: 0;border-left: solid 2px #1AA094;" id="admin-body">
				<div class="layui-tab admin-nav-card layui-tab-brief" lay-filter="admin-tab">
					<ul class="layui-tab-title">
						<li class="layui-this">
							<i class="fa fa-dashboard" aria-hidden="true"></i>
							<cite>工作台</cite>
						</li>
						
						
					</ul>
					<div class="layui-tab-content" style="min-height: 150px; padding: 5px 0 0 0;">
						<div class="layui-tab-item layui-show">
							<iframe src="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Main"></iframe>
						</div>
					</div>
				</div>
			</div>
			<div class="layui-footer footer footer-demo" id="admin-footer">
				<div class="layui-main">
					<p>2017 &copy;
						<a >智子科技</a> 版权所有
					</p>
				</div>
			</div>
	
		
			
			
			<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
			<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"></script>
			<script type="text/javascript" src="<?php echo ($_GET['public_dir']); ?>/index_js_css/datas/nav.js"></script>
			<script>
layui.config({
	base: "<?php echo ($_GET[public_dir]); ?>/index_js_css/js/"
}).use(['element', 'layer', 'navbar', 'tab'], function() {
	var element = layui.element(),
		$ = layui.jquery,
		layer = layui.layer,
		navbar = layui.navbar(),
		tab = layui.tab({
			elem: '.admin-nav-card' //设置选项卡容器
		});
	//iframe自适应
	$(window).on('resize', function() {
		var $content = $('.admin-nav-card .layui-tab-content');
		$content.height($(this).height() - 147);
		$content.find('iframe').each(function() {
			$(this).height($content.height());
		});
	}).resize();
	//登录用户名设置
	var log_user_name="<?php echo ($_COOKIE['user_name']); ?>";
	log_user_name=log_user_name.length>6?log_user_name.substr(0,6)+'...':log_user_name;
	$("#log_user_name").text(log_user_name);
	//设置navbar
	navbar.set({
		spreadOne: true,
		elem: '#admin-navbar-side',
		cached: true,
		data: navs
			/*cached:true,
			url: 'datas/nav.json'*/
	});
	//渲染navbar
	navbar.render();
	$(".layui-nav-tree").children("li").eq(-2).css("margin-bottom","45px")
	$(".layui-nav-tree").children("li").last().css({"position":"fixed","bottom":"0px","width":"160px"});
	$(".layui-nav-tree").children("li").last().children("a").css({"background":"#1AA094","color":"#fff"});
	$(".layui-nav-tree").children("li").last().children("a").css("width","160px");
	var lastclick=0;
	var shouqidom;
	//监听点击事件
	navbar.on('click(side)', function(data) {
		
		if(data.field.title=="收起")
		{
			$(".layui-nav-tree").children("li").last().hide("fast");
			$(".layui-nav-tree").children("li").removeClass("layui-this");
			if(lastclick!=0)
			{
				$(".layui-nav-tree").children("li").eq(lastclick).addClass("layui-this");
			}
			$(".admin-side-toggle").click();
			return false;
		}
		lastclick=$(".layui-this").index();
		
		
		
		tab.tabAdd(data.field);
	});

	$('.admin-side-toggle').on('click', function() {
		var sideWidth = $('#admin-side').width();
		if(sideWidth === 200) {
			$('.admin-side-toggle').show("fast");
			setTimeout(function(){
				$(".layui-nav-tree").children("li").last().hide("fast");
			},200);
			$('#admin-body').animate({
				left: '0'
			}); //admin-footer
			$('#admin-footer').animate({
				left: '0'
			});
			$('#admin-side').animate({
				width: '0'
			});
		} else {
			$('.admin-side-toggle').hide("fast");
			setTimeout(function(){
				$(".layui-nav-tree").children("li").last().show("fast");
			},200);
			
			$('#admin-body').animate({
				left: '200px'
			});
			$('#admin-footer').animate({
				left: '200px'
			});
			$('#admin-side').animate({
				width: '200px'
			});
		}
	});




});
				
			</script>

			
		</div>
	</body>

</html>