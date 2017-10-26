<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>联系人</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
	  		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
			<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
		<script>
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
			 $(function() {
   				$( "#tabs" ).tabs();
 			 });
		</script>
	</head>
	<body style="position:relative">
	<div style="margin:20px"><span style="font-size:22px;margin-right:10px"><?php echo ($lx_json["zdy0"]); ?></span>客户：<span><?php echo ($kehu_nm); ?></span>
	</div>
	<div class="bianji"  style="display: none;border:1px;">
		    		<div class="bianji_nb" style="width:330px;margin:0 auto">
		    			<form id="myform" >
			    			<table class="uk-form"> 
			    				<?php echo ($show3); ?>
			    			</table>
		    			</form>
		    		</div>
			   	</div>
		<div style="margin-top:20px;margin-left:8px; height:50px" >
	   		<button onclick="history.go(-1)"  class="layui-btn layui-btn-primary layui-btn-small">
 				<i class="layui-icon">&#xe603;</i>返回</button>	
		   	<button onclick="bianji()"  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe642;</i>编辑</button>
		  
		</div>	
		<div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">基本信息</a></li>
		    <li><a href="#tabs-2">相关联系人</a></li>
		    <li><a href="#tabs-3">商机</a></li>
		    <li><a href="#tabs-4">操作日志</a></li>
		   
		  </ul>
		  <div id="tabs-1">
				<div class="">
					<span style="color:blue">基本信息</span> 
  					<table class="save_jb">
  						<?php echo ($show); ?>
  					</table>
				</div>
				<div class="" style="margin-top:20px">
					<span style="color:blue">系统信息</span>
					<table>
  					<?php echo ($show1); ?>
  					</table>
				</div>
				
		</div>	  		
		  <div id="tabs-2">
					<table class="layui-table" lay-skin="line">
				  	<thead>
				  		<th >姓名</th>
		  				<th >电话</th>
		  				<th >手机</td>
		  				<th >邮箱</th>
		  				<th >地址</th>

					</thead>
					<tbody class="fujian_del">
					<?php if(is_array($kh)): foreach($kh as $key=>$vo): ?><tr>
				  				<td ><a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/<?php echo ($vo["lx_id"]); ?>"><span style="color:blue"><?php echo ($vo["zdy0"]); ?></span></a></td>
				  				<td ><?php echo ($vo["zdy5"]); ?></td>
				  				<td ><?php echo ($vo["zdy6"]); ?></td>
				  				<td ><?php echo ($vo["zdy10"]); ?></td>
				  				<td ><?php echo ($vo["zdy13"]); ?></td>
						</tr><?php endforeach; endif; ?>	
					</tbody>
			 </table>
		  </div>
		  <div id="tabs-3">
				<table class="layui-table" lay-skin="line">
				  	<thead>
				  		<th >商机标题</th>
		  				<th >预售销售金额</th>
		  				<th >预计签单日期</td>
		  				<th >销售阶段</th>
		  				
						<th >备注</th>
						<th >签单可能性</th>
					</thead>
					<tbody class="fujian_del">
				
						<?php echo ($shangji1); ?>
					
					</tbody>
			 </table>
		  </div>
		  <div id="tabs-4">
		   操作日志
		  </div>
		</div>
 
	</body>
</html>
	<script>
		function bianji(){
			layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
								title: '编辑联系人',
								content:$('.bianji'),
								btn:['确认编辑','取消'],
								btn1:function(){
									var formdom=$("#myform").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
									}
									
									$.get(rooturl+'/index.php/Home/Lianxirenmingcheng/save',{"id":ajaxstr},
							        		 function(html){
									        
									        		if(html=="no"){
									        			alert("没有修改信息")
									        			layer.close(win)
									        		}else{
									        			
									        			$(".save_jb").html(html);
									        			layer.close(win)
									        		}
							                   });
								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

		}
	</script>