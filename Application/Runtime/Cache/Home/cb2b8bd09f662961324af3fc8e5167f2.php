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
		<style>
		.zuotiao{margin-left:-30px;margin-top:-10px;}
		.name{font-size:20px; color:#50BBB1;}
		.head1{margin-left:10px;margin-top:10px;}
		.fuzeren{ position: relative; left: 6px;font-size:14px;color:#50BBB1;}
		.ziliao_kh{margin-left:30px;}
		.th_onlykh{margin-left:20px;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;}
			a{color:#07d; text-decoration:none !important;}
		</style>
	</head>
	<body style="position:relative">
	<div class='head1'><span class='name'><b><?php echo ($lx_json["zdy0"]); ?></b></span><span style="margin-left:30px">客户：</span><span class='fuzeren'><?php echo ($kehu_nm); ?></span>
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

		 <div class="layui-tab layui-tab-brief zuotiao" lay-filter="docDemoTabBrief">
							  <ul class="layui-tab-title ">
							    <li class="layui-this">基本信息</li>
							    <li>相关联系人</li>
							    <li>商机</li>
					 			
					
							  </ul>
						 		<div class="layui-tab-content">
							 		 <div class="layui-tab-item layui-show" >
							 			 <div class='ziliao_kh'  style="width:100%" >
										
						  					<div   style=" height:30px;width:42%;line-height:30px;background-color:#50BBB1;color:white"><span style="margin-left:10px">基本信息</span></div>
										  	<table class="th_onlykh">
										  		<?php echo ($show); ?>	
											</table>
										</div>			
										<div class='ziliao_kh'  style="width:100%">
							  					<div  style="height:30px;line-height:30px; width:45%; background-color:#50BBB1;color:white"><span style="margin-left:10px">系统信息</span></div>
											  	<table class="th_onlykh" >
											  		<?php echo ($show1); ?>
												</table>
									
							  					
										</div>
							 		 </div>
							 		 <div class="layui-tab-item">
							 			
							 			<table class="layui-table ziliao_kh"   >
										  	<thead>
										  		<th >姓名</th>
								  				<th >电话</th>
								  				<th >手机</td>
								  				<th >邮箱</th>
								  				<th >地址</th>

											</thead>
											<tbody class="fujian_del">
												<?php if(is_array($kh)): foreach($kh as $key=>$vo): ?><tr>
										  				<td ><a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/<?php echo ($vo["lx_id"]); ?>"><span><?php echo ($vo["zdy0"]); ?></span></a></td>
										  				<td ><?php echo ($vo["zdy5"]); ?></td>
										  				<td ><?php echo ($vo["zdy6"]); ?></td>
										  				<td ><?php echo ($vo["zdy10"]); ?></td>
										  				<td ><?php echo ($vo["zdy13"]); ?></td>
												</tr><?php endforeach; endif; ?>	
											</tbody>
									 </table>
							 			
							 	    </div>
							 		 <div class="layui-tab-item">
							 			 
							 			<table class="layui-table ziliao_kh"   >
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

										if(thisdom.prop("name")=='zdy2')
										{
											ajaxstr+=thisdom.prop("name")+":"+$('input[name="zdy2"]:checked').val()+",";
										}else{
											ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
									}
						
									$.get(rooturl+'/index.php/Home/Lianxirenmingcheng/save',{"id":ajaxstr},
							        		 function(html){
									        
									        		if(html=="no"){
									        			alert("没有修改信息")
									        			layer.close(win)
									        		}else{
									        			var lxid=$(".lx_id97").val();
									        		//alert(lxid)
									        		//location.href="Lianxirenmingcheng?id"+lxid;
									        		window.location.href="Lianxirenmingcheng?id="+lxid;
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
		layui.use('element', function(){
  var element = layui.element();
  
  //…
});
	</script>