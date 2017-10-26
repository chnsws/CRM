<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>商机</title>
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
		.box{height:800;width:100%;}
		.xq_s{margin-top:5%;padding-left:30%;}
		.xq_s .righ{float:right;}
		.xq_s .righ1{margin-left:20px;}
		.xq_s tr{height:40px;}
		.bhyuany1{margin-top:4%;margin-left:35%;}
		 td{padding-top:20px;}
		body,ul,li,table,tr{margin:0;padding:0;}
		th{background-color:#50BBB1;height:30px;color:white;border:0px !important;}
		textarea{margin-left:25%;margin-top:35px;}
		.fujian1{margin :0 auto;}
		.gundong{overflow :auto}
		</style>

	</head>
	<body style="position:relative">
		<div style='display:none' id='bohuio'>
			<div style="width:100%;height:100">
			<textarea rows="8" id='bhyy' cols="40"></textarea>
			</div>
		</div>
		<div style='display:none' id='htbohuio'>
			<div style="width:100%;height:100">
			<textarea rows="8" id='htbhyy' cols="40"></textarea>
			</div>
		</div>
		<div style='display:none;width:800px' id='xiangqing'>
			<div class = 'xq_s'>
				
			</div>
		</div>
		 <div class="bhyuany"  style="display: none;border:1px;">
		    		<div class="bhyuany1" >
		    			
		    		</div>
			 	</div> 
		<div style='display:none' id='ht_tongguo'>
			<div style="margin-left:30%;margin-top:30px;color:green">
				提示：合同审批通过后将不可编辑、删除！
			</div>
		</div>
		<div class="box"  >
			<div class="layui-tab layui-tab-card">
				  <ul class="layui-tab-title">
				    <li class="layui-this">合同审批</li>
				    <li class="huikuan">回款审批</li>
				    <li clss='kp_kp' onclick="kp_dian()">开票审批</li>
				  
				  </ul>
				  <div class="layui-tab-content" >
				    <div class="layui-tab-item layui-show" >
				    
				    	 <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
							  <ul class="layui-tab-title">
							    <li class="layui-this">待审批</li>
							    <li>已通过</li>
							    <li>已驳回</li>
					 		
					
							  </ul>
						 		<div class="layui-tab-content">
							 		 <div class="layui-tab-item layui-show" style='overflow:auto' >
							 			 <div style='width:2600px'>	<?php echo ($ht_show); ?></div>
							 		 </div>
							 		 <div class="layui-tab-item" style='overflow:auto'>
							 			
							 		 <div style='width:2600px'>		<?php echo ($ht_show1); ?></div>
							 			
							 	    </div>
							 		 <div class="layui-tab-item">
							 			 
							 		 <div style='width:2600px'>	<?php echo ($ht_show2); ?></div>
							 			
							 		</div>
							 		
								 </div>
				    
				 		   </div>



				   	</div>
				
				    <div class="layui-tab-item">
				    	 <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
							  <ul class="layui-tab-title">
							    <li class="layui-this">待审批</li>
							    <li>已通过</li>
							    <li>已驳回</li>
					 			<li>他人审批</li>
					
							  </ul>
						 		<div class="layui-tab-content">
							 		 <div class="layui-tab-item layui-show" >
							 			 	<?php echo ($hk_show); ?>
							 		 </div>
							 		 <div class="layui-tab-item">
							 			
							 			 	<?php echo ($hk_show1); ?>
							 			
							 	    </div>
							 		 <div class="layui-tab-item">
							 			 
							 				<?php echo ($hk_show2); ?>
							 			
							 		</div>
							 		 <div class="layui-tab-item">
							 			
							 			 	<?php echo ($hk_show3); ?>
							 			 
							 		</div>
								 </div>
				    
				 		   </div>

				  </div>
				 
				    <div class="layui-tab-item">

					 <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
							  <ul class="layui-tab-title">
							    <li class="layui-this">待审批</li>
							    <li>已通过</li>
							    <li>已驳回</li>
					 			<li>他人审批</li>
					
							  </ul>
						 		<div class="layui-tab-content">
							 		 <div class="layui-tab-item layui-show" >
							 			 	<?php echo ($kp_show); ?>
							 		 </div>
							 		 <div class="layui-tab-item">
							 			
							 			 	<?php echo ($kp_show1); ?>
							 			
							 	    </div>
							 		 <div class="layui-tab-item">
							 			 
							 				<?php echo ($kp_show2); ?>
							 			
							 		</div>
							 		 <div class="layui-tab-item">
							 			
							 			 	<?php echo ($kp_show3); ?>
							 			 
							 		</div>
								 </div>
				    
				    </div>
				   </div>
				    <div class="layui-tab-item">亲~还没有数据哟</div>
				    <div class="layui-tab-item">亲~还没有数据哟</div>
				  
				  </div>
			</div>
		</div>
		<div class='fujian' style="display:none">
				<table class='fujian1'>

				</table>
		</div>
	</body>
	<script>
	 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}
	layui.use('upload', function(){
		
  		layui.upload(options);
		});
//注意：选项卡 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element();
  
  //…
});
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
layui.use('upload', function(){
  layui.upload(options);
});

</script>

<script>
	function tongguo(ss){
		$a=$(ss).prop("class");
		$.get(rooturl+'/index.php/Home/Shenpi/tongguo',{"id":$a},
						        		 				function(html){
						        		 					alert(html)
						        		 					tishi("审批成功")
			        		 								 window.location.href="Shenpi";
														});


	}
	function bohui(ss){
			$a=$(ss).prop("class");
		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '驳回原因',
								content:$('#bohuio'),
								btn:['确认驳回'],
						
								btn1:function(){
									
									var bh_yuanyin=$("#bhyy").val();
								
									$.get(rooturl+'/index.php/Home/Shenpi/bohui',{"id":$a,'yuanyin':bh_yuanyin},
						        		 				function(html){
															alert(html)
			        		 								 window.location.href="Shenpi";
														});

								}
							}); 
						});  
		
											
	}
	
	function kp_tongguo(sss){
		var ty_id=$(sss).prop("class");
		var tb=$(sss).prop("id");
		var kp_id=$(sss).attr("name");
		var dq=$(sss).parent().parent().children().eq(10).children().text();
		var zgjj=$(sss).parent().parent().children().eq(11).children().text();
		//alert(dq);
	//	alert(zgjj)
		$.get(rooturl+'/index.php/Home/Shenpi/kp_tongguo',{"id":ty_id,'tb':tb,'tjr':dq,'zgjj':zgjj,'kp_id':kp_id},
						        		 				function(html){
															alert(html)
			        		 								 window.location.href="Shenpi";
														});
		//alert(ty_id);

			
	}
	function kp_bohui(sss){
		var bh_id=$(sss).prop("class");
		var tb=$(sss).prop("id");
		var kp_id=$(sss).attr("name");
	
		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '驳回原因',
								content:$('#bohuio'),
								btn:['确认驳回'],
						
								btn1:function(){
									
									var bh_yuanyin=$("#bhyy").val();
									$.get(rooturl+'/index.php/Home/Shenpi/kp_bohui',{"id":bh_id,'yuanyin':bh_yuanyin,'tb':tb,'kp_id':kp_id},
						        		 				function(html){
														
			        		 								 window.location.href="Shenpi";
														});

								}
							}); 
						});  
	}
	function ht_bohui(sss){
		var bh_id=$(sss).prop("class");
		var tb=$(sss).prop("id");
		var ht_id=$(sss).attr("name");

		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '驳回原因',
								content:$('#htbohuio'),
								btn:['确认驳回'],
						
								btn1:function(){
									
									var bh_yuanyin=$("#htbhyy").val();
									$.get(rooturl+'/index.php/Home/Shenpi/ht_bohui',{"id":bh_id,'yuanyin':bh_yuanyin,'tb':tb,'ht_id':ht_id},
						        		 				function(html){
															
			        		 								 window.location.href="Shenpi";
														});

								}
							}); 
						});  
	}
	
	function ht_tongguo(sss){
		var id=$(sss).prop("class");
		var tb=$(sss).prop("id");

		var ht_id=$(sss).attr("name");
		var dq=$(sss).parent().parent().children().eq(11).children().text();
		var zgjj=$(sss).parent().parent().children().eq(12).children().text();
	//	alert(dq+zgjj);return
		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '确认通过',
								content:$('#ht_tongguo'),
								btn:['确认通过'],
						
								btn1:function(){
									
								
									$.get(rooturl+'/index.php/Home/Shenpi/ht_tongguo',{'id':id,'tb':tb,'ht_id':ht_id,'tjr':dq,'zgjj':zgjj},
						        		 				function(html){
														alert(html)
			        		 								 window.location.href="Shenpi";
														});

								}
							}); 
						});  
	}
	function fapiaoxinxi(ss)
	{
		var a=$(ss).prop('class');
		$.get(rooturl+'/index.php/Home/Shenpi/xiangqing',{"id":a},
						        		 				function(html){
														
			        		 								 $('.xq_s').html(html)
														});

		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'805px',
								fixed: false,
								title: '发票详情',
								content:$('#xiangqing'),
								btn:['返回'],
						
								btn1:function(){
									layer.close(win)
								}
							}); 
						});  
	}
	function because(ss){
		var a=$(ss).prop('class');

		$.get(rooturl+'/index.php/Home/Hetongmingcheng/bh_yy',{"id":a},
												function(html){
												
													$(".bhyuany1").html(html);

											})
		layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '驳回原因',
								content:$('.bhyuany'),
								btn:['确定'],

								btn1:function(){
										
									  layer.close(win)    
							            
								}
							
							}); 
						});             
	}
function hk_because(ss){
		var a=$(ss).prop('class');
		//alert(a);
		$.get(rooturl+'/index.php/Home/Hetongmingcheng/bh_yy1',{"id":a},
												function(html){
												
													$(".bhyuany1").html(html);

											})
		layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '驳回原因',
								content:$('.bhyuany'),
								btn:['确定'],

								btn1:function(){
										
									  layer.close(win)    
							            
								}
							
							}); 
						});             
	}
	function fujian(ss)
	{
		var sjid=$(ss).prop('class');
			//alert(a);
		$.get(rooturl+'/index.php/Home/Shenpi/fujian',{"id":sjid},
												function(html){
												
													$(".fujian1").html(html);

											})
			layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '附件详情',
								content:$('.fujian'),
								btn:['返回'],

								btn1:function(){
										
									  layer.close(win)    
							            
								}
							
							}); 
						});      

	}
	function fj_xz(ss)
				{
					var s=$(ss).prop('class');
				
					window.location=rooturl+'/index.php/Home/Hetongmingcheng/download1?id='+s;
						
				}   
	  function bhyy(ss){
		        	var bh_id=$(ss).prop("class");
		        	

        				$.get(rooturl+'/index.php/Home/Hetong/bh_yy',{"id":bh_id},
												function(html){
												
													$(".bhyuany1").html(html);

											})
			        		layui.use('layer', function(){

										var layer = layui.layer;
										var win=layer.open({

											type:1,
											offset: 't',
											area:'750px',
											title: '驳回原因',
											content:$('.bhyuany'),
											btn:['确定'],

											btn1:function(){
													
												  layer.close(win)    
										            
											}
										
										}); 
									});             
					        }
</script>

	</html>