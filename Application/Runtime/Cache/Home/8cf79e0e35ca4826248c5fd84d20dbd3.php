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
		<!--jq ui-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
  		<!--jqui 结束-->
  		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
	<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/time_axis.css" />
	<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">	
  		<style>
  			body,ul,li,tr{margin:0;padding:0;font-size:14px;}
  		
  			
  			
  			.clear{clear:both; height: 0; line-height: 0; font-size: 0}
  			.bianji_nb{margin:left:30%; border:1px solid:red; }
			.ziliao{height:40px;width:100%; line-height:40px;  background-color:#eee;}
			.xiaoshou{position: relative; left :20px;width:107%;}
			.genjinjilu{float:right;}
			.genjinjilu{position: relative; right:8px;top :4px;color:white;}

			.fuzeren{ position: relative; left: 15px;font-size:14px;}
			.tbl{margin-left:20px;}
			.name{font-size:20px; color:#50BBB1;}
			.header1{margin-left:10px;margin-top:16px;}
			.fuzeren{ position: relative; left: 15px;font-size:14px;}
			.fuzename{color:#50BBB1;}
			.ziliao_kh{width:35%;}
			tr{line-height:30px;}
			#th_onlykh{margin-left:20px;}
			.ways{line-height:35px;}
			tr{height:40px;}
			.shiji{float:right;position: relative; right:18px;}
			.gj td{padding-left:25px;}
			.gj tr{height:70px;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;} 
			a{color:#07d; text-decoration:none !important;}
  		</style>
		<script>
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
			 $(function() {
   				$( "#tabs" ).tabs();
 			 });
		</script>
	</head>
	<body>
	<div class="bianji"  style="display: none;border:1px;" >
		    		<div class="bianji_nb" style="width:330px;margin:0 auto">
		    			<form id="myform" class="uk-form" >
		    			<?php echo ($show2); ?>
		    			</form>
		    		</div>
			   	</div>
		<div class='header1' >
			<span  class='name'><b><?php echo ($sql_rh["zdy0"]); ?></b></span><span class="fuzeren">负责人：<span class="fuzename"><?php echo ($fuzeren); ?></span></span>
		</div>
		<div style="margin-top:15px;margin-left:8px; height:30px" >
	   		<button onclick="history.go(-1)"  class="layui-btn layui-btn-primary layui-btn-small">
 				<i class="layui-icon">&#xe603;</i>返回</button>	
		   	<button onclick="bianji()"  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe642;</i>编辑</button>
		   	<button onclick="del_check(this)"  name='<?php echo ($kh_id); ?>'  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe640;</i>删除</button>
		</div>	
		<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
		  <ul class="layui-tab-title">
		    <li class="layui-this">基本信息</li>
		    <li>联系人</li>
		    <li>产品</li>
		    <li>附件</li>
		    <li>操作日志</li>
		  </ul>
		  </ul>
		  <div class="layui-tab-content">
		  	    <div class="layui-tab-item layui-show">
		  	    <table style="margin-top:10px; border:1px solid #EEE; width:100%;">
		  	    	<tr>
		  	    		<td style="border:1px solid #EEE; width:49%;"  align="left" valign="top">
		  	    			 <div class='ziliao_kh'  style="width:100%" >
								
				  					<div   style=" height:30px;width:85%;line-height:30px;background-color:#50BBB1;color:white"><span style="margin-left:10px">基本信息</span></div>
								  	<table id="th_onlykh">
								  		<?php echo ($show); ?>	
									</table>
								</div>			
								<div class='ziliao_kh'  style="width:100%">
					  					<div  style="height:30px;line-height:30px; width:85%; background-color:#50BBB1;color:white"><span style="margin-left:10px">系统信息</span></div>
									  	<table id="th_onlykh" >
									  		<?php echo ($show1); ?>
										</table>
							
					  					
								</div>
		  	    		</td>
		  	    		<td style="border:1px solid #EEE; width:49%;"  align="left" valign="top">

									<div class="ziliao">
					  					<span class="xiaoshou">销售动态</span>
					  					<span id="dialog-form" onclick="xiegenjin()" class=" layui-btn layui-btn-small  genjinjilu" class="genjinjilu">+写跟进</span>
					  				</div>
					  				<div  class="genjin_back">
						  				<div id="uploadfrm" style="width:660px; height:500px;display: none;border:1px; ">
										  				<form id="uploadform2" class="uk-form">
										  					<select name="type" class="typegj sele" style="width:250px;height:40px;margin-top:10px;margin-left:23px";>
										  						<option value="电话">电话</option>
										  						<option value="QQ">QQ</option>
										  						<option value="拜访">微信</option>
										  						<option value="拜访">拜访</option>
										  						<option value="邮件">邮件</option>
										  						<option value="短信">短信</option>
										  						<option value="其他">其他</option>
										  					</select>
										  					<input type="text" name="add_time"  class="text ui-widget-content ui-corner-all shiji add_timegj" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'})" 
										  					placeholder="实际跟进时间（必填）"  style="width:250px;height:40px;margin-top:10px;">
										  					<input type="hidden" name="sj_id" class="bingou" value="<?php echo ($sj_id); ?>">
										  					
										  					<textarea name="content" class='contentgj' placeholder=' 勤跟进，多签单........'  style="width:620px;height:260px;margin-top:10px;margin-left:23px";></textarea>
										  					<table style="margin-top:20px"  class='gj' >
										  						<tr>
										  							<td>客户</td>
										  							<td><input type="text"  name="shiji_date" value="<?php echo ($sql_rh["zdy0"]); ?>" style="width:190px;height:40px" readonly="true"></td>
										  							<td>跟进状态</td>
										  							<td><?php echo ($gj_xgj); ?>
										  							</td>
										  						</tr>
										  				
										  					
																<tr >
																	<td >联系人</td>
											
									  									
										  							<td>
										  								<select name='lianxiren' class='lxr_id' style='width:190px;height:40px'>";
									  										<option value='<?php echo ($sql_lianxi["lx_id"]); ?>'><?php echo ($lx_json["zdy0"]); ?></option>;
									  									</select>
										  							</td>
										  							<td>下次跟进时间</td>
										  							<td>
										  								<input type="text" name='date'  class="text ui-widget-content ui-corner-all dategj" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'})"  style="width:190px;height:40px;">
										  							</td>
										  						</tr>
										  					</table>
								  						</form>
								  		</div>
					  				<?php echo ($xgj_show); ?>
					  				</div>
						 		
		  	    		 </td>
		  	    	</tr>
		  	    </table>
			  	   

		  	    </div>
		  	     <div class="layui-tab-item">
			  	     <table class="layui-table"  >
					  	<thead>
					  		<th >姓名</th>
			  				<th >职务</th>
			  				<th >电话</th>
			  				<th >手机</td>
			  				<th >邮箱</th>
			  				<th >备注</th>

						</thead>
						<tbody class="fujian_del">
							<tr>
							
					  				<td ><a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/<?php echo ($sql_lianxi["lx_id"]); ?>"><span style="color:#079"><?php echo ($lx_json["zdy0"]); ?></span></a></td>
					  				<td ><?php echo ($lx_json["zdy4"]); ?></td>
					  				<td ><?php echo ($lx_json["zdy5"]); ?></td>
					  				<td ><?php echo ($lx_json["zdy6"]); ?></td>
					  				<td ><?php echo ($lx_json["zdy10"]); ?></td>
					  				<td ><?php echo ($lx_json["zdy16"]); ?></td>
					  			
					  		
						
							</tr> 	
						</tbody>
					 </table>
		  	     </div>
		  	     <div class="layui-tab-item">
		  	       	<table class="layui-table"  >
					  	<thead>
					  		<th >产品名称</th>
			  				<th >产品编号</th>
			  				<th >标准单价</th>
			  				<th >建议价格</td>
			  				<th >数量</th>
			  				<th >折扣</th>
			  				<th >总价</th>
			  				<th >销售单位</th>
			  				<th >产品分类</th>
			  				<th >备注</th>
			  				<th >操作</th>


						</thead>
					<tbody class="fujian_del">
						<?php echo ($cp_show); ?>
					</tbody>
					 </table>
		  	     </div>
		  	      <div class="layui-tab-item">
				  	      <div >
					  		<input type="button" id="dialog-form" onclick="fj_cp()" class="layui-btn layui-btn-small" value="+文件上传">
					  		<table class="layui-table"  >
								  	<thead>
								  		
								  				<th >上传时间</th>
								  				<th >附件名称</th>
								  				<th >大小</td>
								  				<th >备注</th>
								  				<th  colspan='2'>操作</th>
								  			
									</thead>
									<tbody class="fujian_del">
											<?php echo ($file_sj_show); ?>
									</tbody>
					  		</table>  
					  		<div id="fj_cp"  style="display: none;border:1px;">     
						  			<form id="uploadform" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Shangjimingcheng/sj_upload/id/<?php echo ($sj_id); ?>" enctype="multipart/form-data" method="post" style="margin:20px;">
					  					<input type="file" name="wenjian"  >
					  					<div id="shangc_top">备&nbsp;&nbsp;&nbsp;&nbsp;注：<!-- 第一个是普通textarea -->
									<textarea name="wenbenyu" class="comments" rows="5" cols="30"> </textarea>  </div>
					  					<div id="shangc_top" ><input type="submit" value="上传附件"  class="layui-btn layui-btn-small"></div>
					  				</form>
							</div>	
						</div>
		  	      </div>
		  	      <div class="layui-tab-item">
		  	       		<table class="layui-table"  > 
								  	<thead>
								  				
								  				<th >操作时间</th>
								  				<th >操作人员</th>
								  				<th >操作模块</th>
								  			
								  				<th >备注</th>
								  				<th >类型</th>

								  				
								  			
									</thead>
									<tbody class="rz_sxp">
								
								  		<?php echo ($rz_jl); ?>

									</tbody>
					  			</table>  
		  	      </div>
		  </div>
		</div>     

	</body>
	<script>
	$(".woca").hide();
	layui.use('upload', function(){
 		 layui.upload(options);
	});
		function bianji(){
			layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
								title: '编辑商机',
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
									//alert (ajaxstr);
									$.get(rooturl+'/index.php/Home/Shangjimingcheng/save',{"id":ajaxstr},
							        		 function(html){
									        		// alert(html)
									        		if(html=="no"){
									        			alert("没有修改信息")
									        			layer.close(win)
									        		}else{
									        			location=rooturl+"/index.php/Home/Shangjimingcheng/shangjimingcheng?id="+$(".bingou").val();
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
	<script>
		function cp_sj_del(e){
				var id=$(e).prop('name');
				$.get(rooturl+'/index.php/Home/Shangjimingcheng/cp_sj_del',{"id":id},
					 function(html){
		        			$("."+id).hide();
                   });
		}	
		  function fj_cp()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'300px',
					offset: 't',
					title: '文件上传',
					content:$('#fj_cp')
				}); 
			});              
		  }
		  function fujian_del(ws){

		  	var id=$(ws).prop('name');
		  	$.get(rooturl+'/index.php/Home/Shangjimingcheng/fujian_del',{"id":id},
					 function(html){
		        			$("."+id).hide();
                   });
		  
		  }
		   layui.use('element', function(){
			  var element = layui.element();
			  
			  //…
			});
		   function xiegenjin(){

		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'680px',
							
								title: '写跟进',
								content:$('#uploadfrm'),
								btn:['确认'],
						
								btn1:function(){
									var shiji=$(".add_timegj").val();
									if(shiji=='' || shiji==null)
									{
										tishi("跟进时间必填");return
									}
										var content_gj='';
										content_gj="kh_id!"+$(".bingou").val()+","+"type!"+$('.typegj').val()+","+"content!"+$('.contentgj').val()+","+"xgj_czr!"+$(".lxr_id").val()+","+"add_time!"+$(".add_timegj").val()+","+"date!"+$(".dategj").val();
										var xgj=$(".gjzt12").val();
									//	alert(content_gj)
									$.get(rooturl+'/index.php/Home/Shangjimingcheng/xgj',{"id":content_gj,'xgj':xgj},
						        		 				function(html){
														
			        		 								 		location=rooturl+"/index.php/Home/Shangjimingcheng/shangjimingcheng?id="+$(".bingou").val();
														});

								}
							}); 
						});  
	}
	function del_gj(ss){
		 	var gj_id=$(ss).prop('id');

				$.get(rooturl+'/index.php/Home/Shangjimingcheng/del_gja',{"id":gj_id},
							        		 function(html){
									        		location=rooturl+"/index.php/Home/Shangjimingcheng/shangjimingcheng?id="+$(".bingou").val();//$(".rz_sxp").html(html);
							                   });
		 }
		 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}
	</script>
</html>