<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>客户</title>
		

		<!--jq ui-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
  		<!--jqui 结束-->
  		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script><!- 时间插件-->
  		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/report/time_axis.css" />
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
  		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/css/global.css" media="all">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">

		<script>window.jQuery || document.write('<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/jquery-1.11.0.min.js"><\/script>')</script>
		<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>
<script>
	window.rooturl="<?php echo ($_GET['root_dir']); ?>";
</script>
   		<style>
		body,ul,li,table,tr{margin:0;padding:0;font-family:宋体; color:#333;}
		a{color:#07d;}
		.top{ width:100%;} 
		.top1{  position: relative; left: 10px; top :16px;}
		.name{font-size:20px; color:#50BBB1;}
		.fuzeren{ position: relative; left: 15px;font-size:14px;}
		.fuzename{color:#50BBB1;}
		.anniu{ position: relative; top :30px;}
		.quanjing_left{ height:100%;border: 1px solid #eee;}
		.quanjing_right{ border: 1px solid #eee;height:100%;overflow:hidden;}
		.ziliao{height:40px;width:100%; }
		#tabs-1{position: relative; right :18px;}
.jiben{position: relative; left :15px;top:10px; font-size:15px;}

.ck_lx{margin-left:83%; font-size:10px;color:#50BBB1; }


.left_color tbody tr{line-height:20px;}


.bottom_jj{padding-bottom:30px;}
.qc{clear:both;}
.xiaoshou{position: relative; left :20px;top:10px;width:107%;font-size:18px;}


td{padding-top: 13px;}

.add_null{position: relative; left :17px;line-height:30px;}
.shangji{width:200px; height:30px;}
.shangji1{color:#07d;position: relative;}
.genjinjilu{float:right; margin-top:3px;margin-right:11px;}

.only1{float:right; margin-top:6px;margin-right:34px;}

.genjin_back{margin-top:12px;}
.sele{position: relative; left:18px;top:5px;}
.shiji{float:right;position: relative; right:18px;top:5px;}
.wenbenyu{position: relative; left:15px;top:10px;}





.next_time{float:right;position: relative; right:86px;top:5px;}
.tijiao{float:right;position: relative; left:200px;top:90px;}
.baocun{float:right;position: relative; right:30px;}
.hetong_name{position: relative; left:20px; height:30px;top:15px;}
.ht_name_width{width:160px;}
.ht_name_float{position: relative; left:190px;top:-15px;}
.kehuziliao_show{height:50px;}
.ziliao_right{position: relative; left:50px;border:none;width:200px}
.ways{line-height:30px;}
.ziliao_right1{position: relative; left:38px;border:none;width:185px}



.tixingkuang{width:55%;height:130px;border-left: 1px solid #555;}


.tixingkuang{position: relative; left:74px;}
.write{color:white;}

.xiala_tx{width:130px;float:right;}


.tx_nei{background-color:#eee;height:70px; width:85%; margin-left:8%;margin-top:15px;}
.baocun4{margin-bottom:30px;}
.bianjiyo{width:300px;}
.rz_show{background-color:#F7FBFE;width:90%;position: relative; top:10px;margin:50px auto;}
.rz_sx{width:230px;height:40px;}
.rz_sx1{margin-left:20px;}
.woca{display:none;}
.gj td{padding-left:25px;}
.gj2{margin-left:3px;}
.dan1{height:170px;}
.dan1 tr{height:40px;}
.sj_bj{margin-left:16%;}
.sj_bj1{margin-left:20px;}
.sj_bj2{margin-left:20px;}
.layui-show{margin-top:25px;}
.ccc{width:94%;height:180px;line-height:180px;}
.c1{width:94%;height:180px;line-height:180px;}
.sjsss{height:180px;line-height:180px;width:94%;}
.htsss{height:180px;line-height:180px;width:94%;}
th{background-color:#50BBB1;height:30px;color:white;border:0px !important;} 
.ziliao_kh{margin-left:10px;width:35%;}
#th_onlykh{margin-left:20px;}
a{color:#07d; text-decoration:none !important;}


		</style>

	</head>
	<body >
		<div class="top">
			<div class="top1">
				
				<span class="name" ><b><?php echo ($kh_name); ?></b></span> <span class="fuzeren">负责人:<span class="fuzename"><?php echo ($kh_fz); ?></span></span>
				
			</div>
   		
		</div>		
		<div style="margin-top:30px;margin-left:8px; height:30px" >
	   		<button onclick="history.go(-1)"  class="layui-btn layui-btn-primary layui-btn-small">
 				<i class="layui-icon">&#xe603;</i>返回</button>	
		   	<button onclick="bianji()"  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe642;</i>编辑</button>
		   	<button onclick="del_check(this)"  name='<?php echo ($kh_id); ?>'  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe640;</i>删除</button>
		</div>	
	
		  <div class="bianji"  style="display: none;border:1px;">
		    		<div class="bianji_nb" style="width:412px;margin:0 auto">
		    			<form id="myform">
			    			<table class="uk-form">
			    				<?php echo ($tab3); ?>
			    			</table>
			    		</form>
		    		</div>
			   	</div> 
			   
				<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
				  <ul class="layui-tab-title" >
				   <li class="layui-this">客户全景</li>
					    <li>客户资料</li>
					    <li class='lxrone' >联系人</li>
					    <li class='sjrone' >商机</li>
					    <li  class='htrone'>合同</li>
					    <li>附件</li>
					    <li>操作日志</li>
				  </ul>
				  <div class="layui-tab-content" >
				    <div class="layui-tab-item layui-show">
									    	<div class="quanjing_left" style="width:50%; float:left">
						  					<div class="dan1">
								  				<div class="ziliao">
								  						<span class="jiben"><b>基本资料</b></span>
								  				</div>
							  					<div class='c1'>

							  						<table class="layui-table"  >
														  	<thead>
														  				<th >客户类型</th>
														  				<th >电话</th>
														  				<th >邮箱</th>
														  				<th >跟进状态</td>
														  				
															</thead>
															<tbody class="fujian_del">
															
														  			<?php echo ($jbxx_show); ?>
															
															</tbody>
													</table>  
							  					
							  						</table>
							  					
							  					</div>
						  					</div>
						  					<div class="dan2">
									  				<div class="ziliao">
									  					<span class="jiben"><b>联系人</b></span><span class='ck_lx' id='lxrone' onclick="ck_lx(this)"><span style='margin-top:5px;cursor:pointer;' title='查看更多'>更多>></span></span>
									  				</div>
						  						<div class="ccc">
								  					
								  							<?php echo ($lx_show); ?>
								  					
						  					
						  						</div>	
						  						<div class="qc"></div>
						  					</div>
						  			
						  				<div class="dan_sj">
							  				<div class="ziliao">
							  					<span class="jiben"><b>商机</b></span><span class='ck_lx' id='lxrone' onclick="ck_sj(this)"><span style='margin-top:5px;cursor:pointer;' title='查看更多'>更多>></span></span>
							  				</div>
						  					<div class='sjsss'>
						  					<table class='layui-table'  >
											  	<thead>
											  				<th >商机标题</th>
											  				<th >预计销售金额</th>
											  				<th >预计签单日期</th>
											  				<th >销售阶段</th>
											  			
											  				
												</thead>
												<tbody class='fujian_del'>
													<?php echo ($sj_show); ?>
												</tbody>
											 </table> 
							  					
						  					</div>
						  				</div>
						  				<div class="dan">
							  				<div class="ziliao">
							  					<span class="jiben"><b>合同</b></span><span class='ck_lx' id='htrone' onclick="ck_ht(this)"><span style='margin-top:5px;cursor:pointer;' title='查看更多'>更多>></span></span>
							  				</div>
						  		
						  					<div class='htsss'>
						  						<?php echo ($ht_show); ?>
						  					</div>
						  					
						  				</div>
						  		
						  				<div class="dan">
							  				<div class="ziliao">
							  					<span class="jiben"><b>交易数据</b></span>
							  				</div>
							  				<div >
							  					<table class='sj_bj' >
								  				<tr>
								  					<td class='shangji'>已成交：￥100000</td>
								  					<td  class='shangji'>已回款：￥100000</td>
								  					<td  class='shangji'>潜在交易：￥100000</td>
								  				</tr>
								  				
								  				</table>
							  				</div>
						  				</div>
						  		</div>
						  		

						  		<div class="quanjing_right" >
										<div class="dan">
								  				<div class="ziliao">
								  					<span class="xiaoshou"><b>销售动态</b></span><span id="dialog-form" onclick="xiegenjin()" class=" layui-btn layui-btn-small  genjinjilu">+写跟进</span><span class="only1"></span>
								  				</div>



						  				<div id="uploadfrm" style="width:660px; height:500px">
								  				<form id="uploadform2" class="uk-form">
								  					<select name="type" class="typegj sele" style="width:250px;height:40px;margin-top:10px;margin-left:5px";>
								  						<option value="电话">电话</option>
								  						<option value="QQ">QQ</option>
								  						<option value="拜访">微信</option>
								  						<option value="拜访">拜访</option>
								  						<option value="邮件">邮件</option>
								  						<option value="短信">短信</option>
								  						<option value="其他">其他</option>
								  					</select>
								  					<input type="text" name="add_time"  class="text ui-widget-content ui-corner-all shiji add_timegj" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'})" placeholder="实际跟进时间(必填)" style="width:250px;height:40px;margin-top:10px">
								  					<input type="hidden" name="kh_id" class="bingou" value="<?php echo ($kh_id); ?>">
								  					
								  					<textarea name="content" class='contentgj' placeholder=' 勤跟进，多签单........'  style="width:620px;height:260px;margin-top:10px;margin-left:23px";></textarea>
								  					<table style="margin-top:20px"  class='gj' >
								  						<tr>
								  							<td>客户</td>
								  							<td><input type="text"   name="shiji_date" value="<?php echo ($kh_name); ?>" style="width:190px;height:40px" readonly="true"></td>
								  							<td>跟进状态</td>
								  							<td><?php echo ($gj_xgj); ?>
								  							</td>
								  						</tr>
								  				
								  					
														<tr>
															<td>联系人</td>
									
								  							<td>
								  								<?php echo ($gj_lxr); ?>
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
						  	</div>
				    </div>
				    <div class="layui-tab-item">
				    	<div class='ziliao_kh'  style="border:1px solid #fff" >
					
				  					<div   style=" height:30px;line-height:30px;background-color:#50BBB1;color:white"><span style="margin-left:10px">基本信息</span></div>
								  	<table id="th_onlykh">
								  		<?php echo ($tabl); ?>	
									</table>
						</div>			
  						<div class='ziliao_kh' >
				  					<div  style="height:30px;line-height:30px;background-color:#50BBB1;color:white"><span style="margin-left:10px">系统信息</span></div>
								  	<table id="th_onlykh" >
								  		<?php echo ($tab2); ?>	
									</table>
						
				  					
							</div>
				
					</div>
				    <div class="layui-tab-item">
				    	<table class="layui-table"  >
							  	<thead>
							  				<th >姓名</th>
							  				<th >部门</th>
							  				<th >职务</th>
							  				<th >电话</td>
							  				<th >手机</th>
							  				<th >邮箱</th>
							  				<th >备注</th>
								</thead>
								<tbody class="fujian_del">
								
							  			<?php echo ($lxr_show); ?>
								
								</tbody>
						</table>  
				    </div>
				    <div class="layui-tab-item">
				    	<table class="layui-table"  >
						  	<thead>
						  				<th >商机标题</th>
						  				<th >预计销售金额</th>
						  				<th >预计签单日期</th>
						  				<th >销售阶段</td>
						  				<th >签单可能性</th>
						  				<th >备注</th>
						  				
						  			
							</thead>
							<tbody class="fujian_del">
							
						  		<?php echo ($sj_show_much); ?>
						
							</tbody>
						 </table>  
				    </div>
				    <div class="layui-tab-item">
				    	<table class="layui-table"  >
						  	<thead>
						  				<th >合同标题</th>
						  				<th >合同总金额</th>
						  				<th >合同开始时间</th>
						  				<th >合同到期时间</th>
						  				<th >合同状态</td>
						  				<th >备注</th>
						  				
						  			
							</thead>
							<tbody class="fujian_del">
									<?php echo ($ht_show_much); ?>
							</tbody>
						  </table>  
				    </div>
				    <div class="layui-tab-item">
				 		   <div >
				  				<input type="button" id="dialog-form" onclick="openwindow()" class="layui-btn layui-btn-small" value="+文件上传">
							  		<table class="layui-table"  >
							  	<thead>
							  				<th >ID</th>
							  				<th >上传时间</th>
							  				<th >附件名称</th>
							  				<th >大小</td>
							  				<th >备注</th>
							  				<th  colspan='2'>操作</th>
							  			
								</thead>
								<tbody class="fujian_del">
								<?php echo ($table_fj); ?>
								</tbody>
							  		</table>       
								  			<form id="uploadform" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Kehu/upload/id/<?php echo ($kh_id); ?>/pageid/<?php echo ($_GET['id']); ?>/fuzeren/<?php echo ($_GET['fuzeren']); ?>/id1/<?php echo ($_GET['id1']); ?>/kh_id/<?php echo ($_GET['kh_id']); ?>" enctype="multipart/form-data" method="post" style="margin:20px;">
							  					<input type="file" name="wenjian"  >
							  					<div id="shangc_top" style="margin-top:30px">备&nbsp;&nbsp;&nbsp;&nbsp;注：<!-- 第一个是普通textarea -->
											<textarea name="wenbenyu" class="comments" rows="5" cols="30"> </textarea>  </div>
							  					<div id="shangc_top" style="margin-top:30px"><input type="submit" value="上传附件"  class="layui-btn layui-btn-small"></div>
							  				</form>
						
	  							</div>	
				    </div>
				     <div class="layui-tab-item">
				     		<div class="uk-form">
					  				<span ><select  name= "rz_mk" class="rz_sx rzone" >
					  					<option value="0">所有系统模块</option>
					  					<option value="2">客户</option>
					  					<option value="3">客户公海</option>
					  					<option value="4">联系人</option>
					  					<option value="5">商机</option>
					  					<option value="6">合同</option>
					  				</select></span>

					  				<span class="rz_sx1"><select name= "rz_user"  class="rz_sx rztwo" >
					  					<option value="0">所有操作人员</option>
					  					<?php if(is_array($user)): foreach($user as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></option><?php endforeach; endif; ?>
					  				
					  				</select></span>
					  				<span class="rz_sx1">
						  				<select name= "rz_type" class="rz_sx rzthree">
						  					<option value="0">所有操作类别</option>
						  					<option value="2">编辑</option>
						  					<option value="1">添加</option>
						  					<option value="3">删除</option>
						  				</select>
					  				</span>
					  				<span class="rz_sx1"><input type="text" name= "start" value="开始日" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})" class="rz_sx rzfour"><span style="margin-left:10px;margin-right:10px">-</span><input type="text" name= "end" class="rz_sx rzfive" value="截止日" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})"></span>
					  				<button onclick="rz_sx(this)" class="rz_sx1 layui-btn layui-btn-small">查询</button>
					  			</div>
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

  		</div>
	</body>
	<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css"><!--图标-->
 		<script>0
 		$("#uploadform").hide();
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
		layui.use('layer', function(){
						var layer = layui.layer;
						
					});

		  function openwindow()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					offset: 't',
					area:'300px',
					title: '文件上传',
					content:$('#uploadform')
				}); 
			});              
		  }


	
  		</script>
  		<script>
 		$("#uploadform").hide();

 		$('#uploadfrm').hide();
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
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
									var sjgenjindate=$('.add_timegj').val();
									if(sjgenjindate=='' || sjgenjindate==null)
									{
										tishi("实际跟进时间必填");return
									}
										var content_gj='';
										content_gj="kh_id!"+$(".bingou").val()+","+"type!"+$('.typegj').val()+","+"content!"+$('.contentgj').val()+","+"xgj_czr!"+$(".lxr_id").val()+","+"add_time!"+$(".add_timegj").val()+","+"date!"+$(".dategj").val();
										var xgj=$(".gjzt12").val();
										//alert(xgj);return;
									$.get(rooturl+'/index.php/Home/Kehu/xgj',{"id":content_gj,'xgj':xgj},
						        		 				function(html){
														
			        		 								 		location=rooturl+"/index.php/Home/Kehu/kehumingcheng?kh_id="+$(".bingou").val();
														});

								}
							}); 
						});  
	}
	
  		</script>

  		
</html>
	<script>
    		function blurfun(){
    			$(".del").click(function(){

					
					//alert($(this).attr("id"))
    				$.get(rooturl+'/index.php/Home/Kehu/delete_fj',{"id":$(this).attr("id")},
							        		 				function(html){
							        		 				//	alert(html)
															$(".fujian_del").html(html);
															blurfun();

															});

    			});

    		};
    		function diquth(){
    			$('.dqth').html("<span data-toggle='distpicker' style='overflow:hidden'><select style='width:100px'  name='zdy6[]' class='form-control diquone' ></select><select  style='width:100px' name='zdy6[]' class='form-control diqutwo'   ></select><select  style='width:100px' name='zdy6[]' class='form-control diquthr'   ></select></span>");
    		

				

    			$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/jquery-1.11.0.min.js",function(){
						
					});
    			$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js",function(){
						
					});
    			$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js",function(){
						
					});
    			$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js",function(){
						
					});


    		}
    	</script>

    	<script><!--编辑-->
    		function bianji_ziliao(){

    			$(".ziliao_right").blur(function(){
    				
    				if($(this).val()==$(this).attr("value")){
    				alert("没有修改信息");
    				}else{
						
    					$.get(rooturl+'/index.php/Home/Kehu/bianji_ziliao',{"aid":$(this).attr("id"),"name":$(this).attr("name"),"val":$(this).val()},
							        		 function(html){
													if(html=='ok'){
															alert(修改成功);
							        		 		}else{
							        		 			alert(修改失败);
							        		 		}
							                   });

    					
    				}
							        		
    			})
    		}
    			bianji_ziliao();
				$(document).ready(blurfun());
    	</script>
    	<script>
    	function ck_lx(de){
    		$('.lxrone').click();
    		
    	}
    	function ck_sj(de){
    		$('.sjrone').click();
    		
    	}
    	function ck_ht(de){
    		$('.htrone').click();
    		
    	}
    	function bianji(){

			layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
										area: ['630px','520px'],
								title: '编辑客户',
								content:$('.bianji'),
								btn:['确认编辑','取消'],
								btn1:function(){
									var formdom=$("#myform").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										if(thisdom.prop("name")=="zdy6[]")
										{
											ajaxstr+="zdy6"+"::"+$('.diquone').val()+"-"+$('.diqutwo').val()+"-"+$('.diquthr').val()+',';
										}else{
											ajaxstr+=thisdom.prop("name")+"::"+thisdom.val()+",";
										}
									}
								//	alert (ajaxstr);
									$.get(rooturl+'/index.php/Home/Kehu/save',{"id":ajaxstr},
							        		 function(html){
									        		// alert(html)
									        		if(html=="no"){
									        			tishi("没有修改信息")
									        			layer.close(win)
									        		}else{
									        			
									        			$("#th_onlykh").html(html);
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

		function del_check(e){
			var a = $(e).prop('name');
			$.get(rooturl+'/index.php/Home/Kehu/delete',{"id":a},
						        		 function(sss){
								     // alert(sss)
								        		if(sss=="no"){
								        			tishi("删除失败")
								        		}else{
								        	
								        			location=rooturl+'/index.php/Home/Kehu/kehu'
								        		}
						                   });
		}
		function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}
			
		function rz_sx(){
			
			var b=$(".rzone").val();
			if(b!=0){
				 a=$(".rzone").prop('name')+":"+ b +",";
			}else{
				 a="";
			}
			var two=$(".rztwo").val();
			if(two !=0){
				 a +=$(".rztwo").prop('name')+":"+ two +",";
			}
			var three=$(".rzthree").val();
			if(three !=0){
				 a +=$(".rzthree").prop('name')+":"+ three +",";
			}
			var four=$(".rzfour").val();
			if(four !="开始日"){
				 a +=$(".rzfour").prop('name')+":"+ four +",";
			}
			var five=$(".rzfive").val();
			if(five !="截止日"){
				 a +=$(".rzfive").prop('name')+":"+ five +",";
			}
			var kh_id = $('.bingou').val();
			//alert(kh_id)
			var dudu=a.substr(0,a.length-1);
			
				$.get(rooturl+'/index.php/Home/Kehu/rz_sx',{"id":dudu,"kh_id":kh_id},
							        		 function(html){
									        		
									        		$(".rz_sxp").html(html);
							                   });
			
		}
		 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}
		 layui.use('element', function(){
			  var element = layui.element();
			  
			  //…
			});
		 function del_gj(ss){
		 	var gj_id=$(ss).prop('id');

				$.get(rooturl+'/index.php/Home/Kehu/del_gja',{"id":gj_id},
							        		 function(html){
									        		
									        		location=rooturl+"/index.php/Home/Kehu/kehumingcheng?kh_id="+$(".bingou").val();//$(".rz_sxp").html(html);
							                   });
		 }

	</script>