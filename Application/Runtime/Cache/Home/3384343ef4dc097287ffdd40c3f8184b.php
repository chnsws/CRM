<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>合同</title>
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
		<link href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" rel="stylesheet"  type="text/css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>
  		<style>
  			table body,ul,li,tr td{margin:0;padding:0;font-size:14px;}
  		
i.layui-anim{display:inline-block}
  			.bjwh{width:300px;height:30px}
  			.jibenxinxi{width:50% ;float:left;}
  			.xiegenjin{width:48% ;float:right;}
  		
  			.clear{clear:both; height: 0; line-height: 0; font-size: 0}
  			.bianji_nb{margin:left:30%; border:1px solid:red; }
			.ziliao{height:40px;width:100%; background-color:#eee;}
			.xiaoshou{position: relative; left :20px;width:107%;}
			
			.only1{position: relative; left:75%;top:6px;}
	
			.fuzeren{ position: relative; left: 15px;font-size:14px;}
			.tbl{margin-left:20px;}
			.addshangji_weizhi{margin:0px auto;margin-top:20px;}
			.addtr{line-height:25px;}
			.addtr td{padding-top:20px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;}
			.cd input{width:500px;}
			.cd td{padding-top:20px;}
			.jc{font-weight:bold }
			.top_bz{position: relative; top: -65px;}
			.hkshow{margin-left:30px; }
			.hk_wh{height:40px;}
			.hkauto{margin-top: 20px; }
			.pz_wz{float:right;}
			.backg{height:40px;border:1px solid #DDD;background-color:#DDDDDD;}
		.kongzhi1{margin-top:13px;}
		.add_wz{float:right;margin-top:-9px;padding-top:-20px;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;}
			tr{line-height:45px;}
			.th_hei th{height:40px;}
			.hk_add tr{height:60px;}
			.shuai{padding-top:60px;}
		form input{width:300px;}
		form select{width:300px;}
			 td{padding-top:20px;}
			 	.onError{color:red;}
			.onSuccess{color:green;}
			.bhyuany1{margin-top:4%;margin-left:35%;}
			.bhyuany12{margin-top:4%;margin-left:35%;}  
			.name{font-size:20px; color:#50BBB1;}
			.fuzename{color:#50BBB1;}
			#th_onlykh {margin-left:20px;}
				.genjinjilu{float:right;}
			.genjinjilu{position: relative; right:8px;top :4px;color:white;}
				.gj td{padding-left:25px;}
			.gj tr{height:70px;}
			.woca{display:none;}
			.ace{width:80px;}
			.fujian1{margin :0 auto;margin-top:15px;}
				.searchable-select-input{width:280px !important ;}
			.searchable-select {min-width:300px;}
			.cd tr{line-height:27px;height:40px}
			 th{
        text-align:center;/** 设置水平方向居中 */
        vertical-align:middle/** 设置垂直方向居中 */
    }
     .th_peizhi td{
        text-align:center;/** 设置水平方向居中 */
       
    }
    .jzhj td{
    	 text-align:center;
    }
    .shet{margin-left:40px;}
    .xiaoshou{cursor:pointer}

    .sc_hkjl{ margin-left:30%;margin-top:30px;}
     .sc_hkjla{ margin-left:38%;margin-top:30px;}
  	</style>
		<script>
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
			 $(function() {
   				$( "#tabs" ).tabs();
 			 });
		</script>
	</head>
	<body>
		<div style="margin-left:10px"><span  class='name' ><b><?php echo ($name); ?></b></span><span style="margin-left:10px">负责人：<span class="fuzename">	<?php echo ($fuzeren); ?></span></span>
		</div>
		<input type='hidden' value='<?php echo ($kh_id); ?>' class='kh_id'>
		<input type='hidden' value='<?php echo ($pz_num); ?>' class='pz_num'>
		<input type='hidden' value='<?php echo ($uiid); ?>' class='uiid'>
		<input type='hidden' value='<?php echo ($ht_sp918); ?>' class='ht_sp'>
		<div style="margin-top:20px;margin-left:8px; height:35px" >
	   		<button onclick="history.go(-1)"  class="layui-btn layui-btn-primary layui-btn-small">
 				<i class="layui-icon">&#xe603;</i>返回</button>	
		   	<button onclick="bianji()"  class="layui-btn layui-btn-primary layui-btn-small bjscyc">
	 			<i class="layui-icon">&#xe642;</i>编辑</button>
		   	<button onclick="del_check(this)"  id='<?php echo ($ht_id); ?>'  class="layui-btn layui-btn-primary layui-btn-small bjscyc">
	 			<i class="layui-icon">&#xe640;</i>删除</button>
		</div>	
		<div class='fujian' style="display:none">
				<table class='fujian1'>

				</table>
		</div>
			<div class='del_huikuan' style="display:none;height:60px">
				<div class='sc_hkjl'>
					<span >确定删除此条回款计划以及相关回款记录吗？</span>
				</div>
		</div>
		<div class='del_hkjilu' style="display:none;height:60px">
				<div class='sc_hkjla'>
					<span >确定删除此条回款记录吗？</span>
				</div>
		</div>
		<div class='save_huikuan' style="display:none;height:60px">
				123
		</div>
<div class='chanpina' style="display:none">
				<table class='chanpin1 layui-table' >
							<thead>
								  	<tr><th >产品名称</th>
					  				<th >产品编号</th>
					  				<th >公开价格</th>
					  				<th >合同价格</th>
					  				<th >数量</th>
					  			
					  				<th >总价</th>
					  				</tr>

									</thead>
									<tbody class="cp_showoo">
										
									</tbody>
				</table>
		</div>
			<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
			<div class="bianji"  style="display: none;border:1px;">
		    		<div class="bianji_nb" style="width:430px;margin:0 auto">
		    			<form id="myform">
		    			<?php echo ($show3); ?>
		    			</form>
		    		</div>
			   	</div>
		  <ul class="layui-tab-title">
		    <li id='onesh'>基本信息</li>
		    <li  id='er'>回款</li>
		    <li>开票</li>
		    <li>产品</li>
		  	<li  id='twosh'>附件</li>
		    <li>操作日志</li>
		  </ul>
		  
			  <div class="layui-tab-content">
					<div class="layui-tab-item" id='onesh1'>
				  	    <table style=" width:100%;">
				  	    	<tr class='jb_xt'>
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
														  						<option value="微信">微信</option>
														  						<option value="拜访">拜访</option>
														  						<option value="邮件">邮件</option>
														  						<option value="短信">短信</option>
														  						<option value="其他">其他</option>
														  					</select>
														  					<input type="text" name="add_time"  class="text ui-widget-content ui-corner-all shiji add_timegj" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'})" placeholder="实际跟进时间（必填）" style="width:250px;height:40px;margin-top:10px;margin-left:17.5%">
														  					<input type="hidden" name="sj_id" class="bingou" value="<?php echo ($sj_id); ?>">
														  					
														  					<textarea name="content" class='contentgj' placeholder=' 勤跟进，多签单........'  style="width:620px;height:260px;margin-top:10px;margin-left:23px";></textarea>
														  					<table style="margin-top:20px"  class='gj' >
														  						<tr>
														  							<td>合同</td>
														  							<td><input type="text"  name="shiji_date" value="<?php echo ($name); ?>" style="width:190px;height:40px" readonly="true"></td>
														  							<td>跟进状态</td>
														  							<td><?php echo ($gj_xgj); ?>
														  							</td>
														  						</tr>
														  				
														  					
																				<tr >
																					
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
			  	    
				    <div class='layui-tab-item' id='er1'>
					  	<div class="bhyuanyyy"  style="display: none;border:1px;">
				    		<div class="bhyuany12" >
				    			
				    		</div>
						</div>
					  			<div class="add_hk"  style="display: none;border:1px;">
						    		<div class="bianji_nb" style="width:430px;margin:0 auto">
						    			<form id="hk_add">
						    				<?php echo ($xz_jh); ?>
						    			</form>
						    		</div>
								</div> 
								<div class="save_hk"  style="display: none;border:1px;">
						    		<div class="bianji_nb" style="width:430px;margin:0 auto">
						    			<form id="hk_adda">
						    				
						    			</form>
						    		</div>
								</div> 
					    		<div id="hkpz"  style="display: none;border:1px;">
					    		<div class="bianji_nb" style="width:620px;margin:0 auto">
					    			<form id="myform">
					    			<table class='uk-form cd'>

					    			
					    					<tr><td><span style="color:red;">*</span><span class="jc">对应客户：</span></td><td><input type="text" name='' value="<?php echo ($ht_kh); ?>" readonly="true"></td></tr>
					    					<tr><td><span style="color:red;">*</span><span class="jc">合同标题：</span></td><td><input type="text" name='' value="<?php echo ($ht_name); ?>" readonly="true"></td></tr>
					    					<tr><td><span style="color:red">*</span><span class="jc">合同总金额：</span></td><td><input type="text" class="zje" name='' value="<?php echo ($ht_money); ?>"  readonly="true"></td></tr>
					    					<tr><td><span style="color:red">*</span><span class="jc">签约日期：</span></td><td><input type="text" name='' value="<?php echo ($ht_data); ?>" readonly="true"></td></tr>
					    				    <tr><td> </td><td> </td></tr>
								    		<tr style="margin-top:130px">
								    			<td colspan='2'>
										    		<table class='uk-form cd' style="width:105%;">
										    			<thead class="th_hei">
													  		<th >期次</th>
											  				<th >操作</th>
											  				<th >回款日期1</th>
											  				<th >回款占比(%)</td>
											  				<th >回款金额</th>
											  				<th >备注</th>
														</thead>
														<tbody class="fujian_del th_peizhi">
															<tr class="qingxuanze">
																<td colspan="6" ><span>亲~还没有回款计划哦~<span onclick="hkzb()"
																style="color:blue;font-weight:bold">新增回款计划>></span></span></td>
															</tr>
															<tr class="add_pz" style="display:none">
																<td ><span class='fiseta'>1</span></td>
																<td ><span onclick="jia(this)"><i class="layui-icon"  style="color:black">&#xe61f;</i></span><span class="1" onclick="hkzb1(this)"><i class="layui-icon"   style="font-size:20px">&#xe640;</i></span></td>
																<td ><input type="text" style="width:110px"  name =""  onfocus="WdatePicker({dateFmt:'yyyy-M-d'})"></td>
																<td ><input type="text" style="width:100px" class= "zbi" onchange="zolop(this)"></td>
																<td ><input type="text" style="width:100px" class= "money" value="" onchange="fan(this)" name =""></td>
																<td ><input type="text" style="width:110px" name =""></td>
															</tr> 	
				 	
														</tbody>
													</table>
												</td>
											</tr> 

										<tr style="padding-top:40px" class='jzhj'><td class="shuai" colspan="2"><span style="margin-left:0px;">合计</span><span style="margin-left:80px" class="zhanbi"><?php echo ($zb); ?></span><span style="margin-left:70px" class="zongjine"><?php echo ($zonghkjh); ?></span></td></tr>
					    			</table>
					    			</form>
					    		</div>
								</div>
					    		<div class="hk_wh">
						  			<div class="hkauto">
								  		<span class="hkshow">计划回款总金额：¥ <b><?php echo ($hkzje); ?></b></span><span class="hkshow"> 已回款总金额：¥<b> <?php echo ($zonghk); ?></b></span> <span class="hkshow">未回款总金额：¥ <b><?php echo ($weihka); ?></b>(逾期未回款金额： <span style="color:red">¥ 0.000000</span>)</span> <span  class="pz_wz"><button onclick="hkpeizhi()"  class="layui-btn layui-btn-primary layui-btn-small ">
						 				<i class="layui-icon">&#xe614;</i>配置回款计划</button>	</span>
						 		 	</div >
					   			</div>
				 	 			<div>
				 	 				<?php echo ($hk_jihua); ?>
								</div>
					</div>






				    <div class='layui-tab-item'>
					  		<div class="kpjl"  style="display: none;border:1px;">
					    		<div class="bianji_nb" style="width:480px;margin:0 auto">
					    			<form id="kaipiaoadd">
					    				<?php echo ($kaipiao); ?>
					    			</form>
					    		</div>
					 		</div> 
							<div class="bhyuany"  style="display: none;border:1px;">
					    		<div class="bhyuany1" >
					    			
					    		</div>
						 	</div>
							<div class="hk_wh">
										<div class="hkauto" >
									  		合同总金额：¥ <b><?php echo ($hkzje); ?></b><span class="hkshow"> 已开票总金额：¥<b> <?php echo ($zonghk); ?></b></span> <span class="hkshow">未开票总金额：¥ <b><?php echo ($weihka); ?></b></span> <span  class="pz_wz"><button  id='create-sahngji' onclick='xzkp()' class='layui-btn layui-btn-small add_wz' >新增开票记录</button></span>
									  	</div >
							</div>
						<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
									  <ul class="layui-tab-title">
									    <li class="layui-this">增值税普通发票</li>
									    <li>增值税专用发票</li>
									    <li>国税通用机打发票</li>
									    <li>地税通用机打发票</li>
									  </ul>
								 		<div class="layui-tab-content">
								 			 <div class="layui-tab-item layui-show">
								 			 		<div>
														  <table class='layui-table' lay-skin='line' style="margin-top:20px" >
																  	<thead >
																  					<th >操作</th>
																  					<th >状态</th>
																	  				<th >开票日期</th>
																	  				<th >票据内容</th>
																	  				<th >开票金额</td>
																	  				<th >票据类型</th>
																	  				<th >发票开头</th>
																	  				<th >纳税人识别码</th>
																	  				<th >发票号码</th>
																	  				<th >经手人</th>
																	  				<th >备注</th>
																	  				<th >创建人</th>
																	  				<th >创建时间</th>
																	</thead>
															<tbody class='fujian_del'>
																				<?php echo ($kp_show); ?>
															</tbody>	
													      </table>
													</div>
								 			 </div>
								 			  <div class="layui-tab-item" >
									    	 <div class="layui-tab-item layui-show"  >
							 			 		<div style='overflow :auto;width:99%'>
													  <table class='layui-table' lay-skin='line' style="margin-top:20px;width:3000px" >
															  	<thead >
															  					<th >操作</th>
															  					<th >状态</th>
																  				<th >开票日期</th>
																  				<th >票据内容</th>
																  				<th >开票金额</td>
																  				<th >票据类型</th>
																  				<th >单位名称</th>
																  				<th >纳税人识别码</th>
																  				<th >注册地址</th>
																  				<th >注册电话</th>
																  				<th >开户银行</th>
																  				<th >银行账户</th>
																  				<th >收票人姓名</th>
																  				<th >收票人手机</th>
																  			
																  				<th >收票人省份</th>
																  				<th >详细信息</th>
																  				<th >发票号码</th>
																  				<th >经手人</th>
																  				<th >备注</th>
																  				<th >创建人</th>
																  				<th >创建时间</th>
																</thead>
														<tbody class='fujian_del'>
																			<?php echo ($kp_show1); ?>
														</tbody>	
													</table>
												</div>
						 					 </div>
									    </div>
									    <div class="layui-tab-item">
									    	<div class="layui-tab-item layui-show">
							 			 		<div>
													  <table class='layui-table' lay-skin='line' style="margin-top:20px" >
															  	<thead >
															  					<th >操作</th>
														  					<th >状态</th>
															  				<th >开票日期</th>
															  				<th >票据内容</th>
															  				<th >开票金额</td>
															  				<th >票据类型</th>
															  				
															  				<th >发票号码</th>
															  				<th >经手人</th>
															  				<th >备注</th>
															  				<th >创建人</th>
															  				<th >创建时间</th>
																</thead>
														<tbody class='fujian_del'>
																			<?php echo ($kp_show2); ?>
														</tbody>	
													</table>
												</div>
						 					 </div>
									    </div>
									    <div class="layui-tab-item">
									    	<div class="layui-tab-item layui-show">
							 			 		<div>
													  <table class='layui-table' lay-skin='line' style="margin-top:20px" >
															  	<thead >
															  					<th >操作</th>
														  					<th >状态</th>
															  				<th >开票日期</th>
															  				<th >票据内容</th>
															  				<th >开票金额</td>
															  				<th >票据类型</th>
															  				
															  				<th >发票号码</th>
															  				<th >经手人</th>
															  				<th >备注</th>
															  				<th >创建人</th>
															  				<th >创建时间</th>
																</thead>
														<tbody class='fujian_del'>
																			<?php echo ($kp_show3); ?>
														</tbody>	
													</table>
												</div>
						 					 </div>

									    </div>

								 		</div>
						</div>

				</div>		






				    <div class='layui-tab-item'>
			  			  <input type="button"  onclick="add_cpp()" class=" layui-btn layui-btn-small bjscyc" value="+添加产品">
			  			  <span style='margin-left:60%'><b>合同总金额</b>：￥<span style='color:green'><?php echo ($ht_zje); ?></span><b style='margin-left:15px'>产品总金额</b>：￥<?php echo ($zje9133); ?></span>
							<table class="layui-table"  >
								  	<thead>
								  	<th >产品名称</th>
					  				<th >产品编号</th>
					  				<th >公开价格</th>
					  				<th >合同价格</td>
					  				<th >数量</th>
					  				<th >折扣</th>
					  				<th >总价</th>
					  				
					  				<th >备注</th>
					  				<th >操作</th>
									</thead>
									<tbody class="cp_showoo">
										<?php echo ($show2); ?>	
									</tbody>
							 </table>
			 		 </div>
			 		  <div class='layui-tab-item' id='twosh1' >
			  			<input type="button" id="dialog-form" onclick="fj_cp()"  class=" layui-btn layui-btn-small bjscyc" value="+文件上传">
					   <table class="layui-table"  >
							  	<thead>
							  		<th >上传时间</th>
					  				<th >附件名称</th>
					  				<th >大小</td>
					  				<th >备注</th>
					  				<th >操作</th>

								</thead>
								<tbody class="fujian_del">
								
									<?php echo ($file_show); ?>

								</tbody>
						 </table>
				 	<div id="fj_cp"  style="display: none;border:1px;">     
				  			<form id="uploadform" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Hetongmingcheng/fj_shangchuan/id/<?php echo ($ht_id); ?>" enctype="multipart/form-data" method="post" style="margin:20px;">
			  					<input type="file" name="wenjian"  >
			  					
			  					<div class='jiu' id="shangc_top" style="margin-top:20px"><span class="top_bz">备&nbsp;&nbsp;&nbsp;&nbsp;注：</span><!-- 第一个是普通textarea -->

							<textarea name="wenbenyu" class="comments" rows="5" cols="30"> </textarea>  </div>
								
					
			  					<div id="shangc_top" class='xuanzhuan'><input type="submit" onclick='xuanzhuan()' value="上传附件"  class="layui-btn layui-btn-small ace"></div>
			  					<div class='xuanzhuan1' style='display:none'></div>
			  				</form>
					</div>	
			 		 </div>
			 		  <div class='layui-tab-item'>
			  		
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
			 		  <div class='layui-tab-item'>
			  			<b>4</b>
			 		 </div>
			 </div>
		</div>
		 
		  



		 <div id="addcp" style="display: none;border:1px">
		  		<form id="cp_form" method="post" >
								<table class="addshangji_weizhi">
								<?php echo ($chanpin1); ?>
								<tr class="addtr">
									<td>公开价格：</td>
										<td>
											<input type="text" class="cp_yj" name="cp_yj" disabled name="cp_yj" style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td><span style="color:red">*</span>合同价格：</td>
										<td>
											<input type="number" class="cp_jy"  name="cp_jy" onkeyup='cp_jy_aj(this)'  style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td><span style="color:red">*</span>数量：</td>
										<td>
										<input type="number" class="cp_num1" name="cp_num1" onkeyup='cp_num(this)'  style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td>折扣：</td>
										<td>
											<input type="text" class="cp_zk"  name="cp_zk" value="-"  disabled style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td>总价：</td>
										<td>
											<input type="text" class="cp_zj" name="cp_zj" disabled style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td>备注：</td>
										<td>
											<textarea name="cp_beizhu" rows="4" cols="40">
											</textarea>		
										</td>			
								</tr>
								<tr class="addtr">
									<td></td>
										<td>
											<input type="hidden" name="sj_id" disabled class="ht_id" value="<?php echo ($ht_id); ?>";'>	
										</td>			
								</tr>
								</table>
							</form>
		  	</div>










	</body>
	<script>
	var ht_sp918=$(".ht_sp").val();
	if(ht_sp918==1)
	{
		$('.bjscyc').hide();
	}
	var uiid=$('.uiid').val();
	if(uiid==5)
	{
		
		$("#twosh").attr('class','layui-this');
		$("#twosh1").attr('class','layui-tab-item layui-show');
	}
	if(uiid==2)
	{
		
		$("#er").attr('class','layui-this');
		$("#er1").attr('class','layui-tab-item layui-show');
	}
	if(uiid==1)
	{
	
		$("#onesh").attr('class','layui-this');
		$("#onesh1").attr('class','layui-tab-item layui-show');
	}
	
	function xuanzhuan(){
		$('.xuanzhuan').hide();
		$('.xuanzhuan1').html('<i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop" style="font-size: 40px;color:green ">&#xe63e;</i>');
			$('.xuanzhuan1').show();
	}
	layui.use('upload', function(){
 		 layui.upload(options);
	});
	window.htid=$(".ht_id").val();
		function bianji(){
			layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								title: '编辑合同',
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
									
									var ht_id=$(".ht_id1").val();
									
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/save',{"id":ajaxstr,'ht_id':ht_id},
							        		 function(html){
									        	//	alert(html)
									        		if(html=="no"){
									        			tishi("没有修改信息")
									        			window.location.href="hetongmingcheng?id="+ht_id;
									        		}else{
									        			
									        			
									        			window.location.href="hetongmingcheng?id="+ht_id;
									        		}
							                   });
								},
								btn2:function(){
									var ht_id=$(".ht_id1").val();
									window.location.href="hetongmingcheng?id="+ht_id;
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
					area:'400px',
					offset: 't',
					title: '文件上传',
					content:$('#fj_cp')
				}); 
			});              
		  }
		  function get_sj(sj){
    				var kh_id= $(sj).val();
    			$.get(rooturl+'/index.php/Home/Hetong/get_sj',{"id":kh_id},
			        		 				function(html){
        		 								//tishi(html)
												$(".th_sj").html(html);
												layer.close(win)
											});
    		}
    		var ace=0;
		  function add_cpp(){
		  	if(ace<1)
		  	{
		  	$('#xlcp').searchableSelect();
		  	ace++;
		  	}
    				layui.use('layer', function(){
					//	alert(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '添加产品',
								content:$('#addcp'),
								btn:['保存'],

								btn1:function(){
									
									var formdom=$("#cp_form").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
									}
									var vstr=ajaxstr.substr(0,ajaxstr.length-1);
									var kh_id=$(".kh_id").val();
								
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/add_cp',{"id":vstr,'kh_id':kh_id},
							        		 function(html){
									       		 $(".cp_showoo").html(html);
									        		layer.close(win)
							                   });
									layer.close(win)
								}
							}); 
						});   
    			} 
	</script>
	<script>
		function cp_aj(a){
    			var cp_id=$(a).val();
    			if(cp_id == 's'){
    				$(".cp_yj").val("")
    				$(".cp_jy").val("")
    				$(".cp_zk").val("-")	
    				$(".cp_num1").val("")	
    				$(".cp_zj").val("")	
    				layer.close(win)
    			}
    			$.get(rooturl+'/index.php/Home/Shangji/cp_ajax',{"id":cp_id},
    										function(html)
    										{
										//	alert(html)
													$(".cp_yj").val(html)
													$(".cp_jy").val(html)
    												$(".cp_zk").val("100.0%")	
    												$(".cp_num1").val(1)	
    												$(".cp_zj").val(html)	
    													layer.close(win)
    										}
    				)
    				
    		}
    		function cp_jy_aj(b){
    			var jy = $(b).val();	
    			var yj = $(".cp_yj").val();	
    			/**用  100 除  原价  得出的值 乘 建议 价格**/
    		
    			var baifenbi=(100 /  yj *  jy );
    			var jiequ =	baifenbi.toFixed(2);
    		
    			var end = jiequ +"%";
    			var num=$('.cp_num1').val();
    			var num1=(num * jy);
    			$(".cp_zk").val(end);
    			$(".cp_zj").val(num1)		
    			//alert(yj);
    		}
    		function cp_num(w){
    			var num2 = $(w).val();	
    			var jy = $(".cp_jy").val();	
    			var num1=(num2 * jy);
    			
    			$(".cp_zj").val(num1)		
    		}
    		function cp_del(f){
    			var id = $(f).prop('name');
    			//alert(id)
    				$.get(rooturl+'/index.php/Home/Hetong/cp_del',{"id":id},
    										function(html)
    										{
    											if(html==1){
    												$("."+id).hide();
    												layer.close(win)
    											}
    													
    										}
    				)
    		}
    		function fujian_del(ws){

		  		var id=$(ws).prop('name');
		  		$.get(rooturl+'/index.php/Home/Hetongmingcheng/fujian_del',{"id":id},
					 function(html){
		        			$("."+id).hide();
                   });
		  
		  }
		  	 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 2000, 
			    });
			}
			 function hkpeizhi(){

				var htid=$(".ht_id").val();	 	
				var numa=$('.pz_num').val();
			 	$.get(rooturl+'/index.php/Home/Hetongmingcheng/hkpz_content',{"id":htid,'dijiqi':numa},
					 function(html){
					 //	alert(html)
		        		$(".th_peizhi").html(html)
                   });
			
    				layui.use('layer', function(){
					//	alert(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '新增回款计划',
								content:$('#hkpz'),
								btn:['保存'],

								btn1:function(){
								
									window.jiazai=layer.load(2);
		
									var a="";
									$(".add_pz").each(function(){
										 a +="hk_qici:"+$(this).children().eq(0).text()+","+"hk_data:"+$(this).children().eq(2).find("input").val()+","+"hk_zb:"+$(this).children().eq(3).find("input").val()+","+"hk_je:"+$(this).children().eq(4).find("input").val()+","+"hk_bz:"+$(this).children().eq(5).find("input").val()+"!";
									});
							
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/peizhi_hk',{"id":htid,"content":a},
												 function(html){

									        			 	window.location.href="Hetongmingcheng?id="+htid;
							                   });

								}
							}); 
						});                  
    			}
    			function hkzb(){
    				
    				
    		
					$(".add_pz").show();
					$(".qingxuanze").hide();
    			}
    			function hkzb1(ss){
					var trdom=$(ss).parent().parent();
    				
    				trdom.remove();
    				
					var numa=$('.pz_num').val();
					$(".th_peizhi").children('tr').each(function(){

			
						$(this).children('td').eq(0).text(numa);
						numa++;

					})
				



    			}
    			
    		
    			function jia(thisdom){
    				
    				
					var next_tr=$(thisdom).parent().parent();
					var as=next_tr.html();
					$(thisdom).parent().parent().parent().append('<tr class="add_pz" >'+as+'</tr>');
					var numa=$('.pz_num').val();
					$(thisdom).parent().parent().parent().children('tr').each(function(){
						$(this).children('td').eq(0).text(numa);
						numa++;

					})

    			}
    		
    			function zolop(sa){
    		
    				var zba = $(sa).val();

    				var zje = $(".zje").val();
    			
    				$.get(rooturl+'/index.php/Home/Hetongmingcheng/jisuan',{"zba":zba,"zje":zje},
							        		 function(html){
									       	
									        		$(sa).parent().parent().find(".money").val(html)
									        			var jinez=0;

									    				for(dood=0;dood < jh_num-1;dood++)
									    				{
									    					var mon=$(".money").eq(dood).val();
									    				
									    					jinez=mon*1+jinez;
									    				}
									    				$(".zongjine").html(jinez);
							                   });

    				var boo =0;//获取占比
    				for(doom=0;doom < jh_num-1;doom++)
    				{
    					var a=$(".zbi").eq(doom).val();
    					boo=a*1+boo;
    				}
    				$(".zhanbi").html(boo+"%");
    						//获取金额
    			
    			}
    			function fan(saa){
    		
    				var money= $(saa).val();
    				var zje = $(".zje").val();
    					var jinez=0;
	    				for(dood=0;dood < jh_num-1;dood++)
	    				{
	    					var mon=$(".money").eq(dood).val();
	    				
	    					jinez=mon*1+jinez;
	    				}
	    				$(".zongjine").html(jinez);
    				$.get(rooturl+'/index.php/Home/Hetongmingcheng/jisuan1',{"money":money,"zje":zje},
							        		 function(html){
									       		
									        		$(saa).parent().parent().find(".zbi").val(html)
									        			var boo =0;//获取占比
									    				for(doom=0;doom < jh_num-1;doom++)
									    				{
									    					var a=$(".zbi").eq(doom).val();
									    					boo=a*1+boo;
									    				}
									    				$(".zhanbi").html(boo+"%");
							                   });

    			
    			}
    			function xzjh(thisdom){
    				var qi='';
    			
    				
    				if($(thisdom).prop("tagName")=='BUTTON')
    				{
    						var hk_id=$(thisdom).prop('name');
    					qi=$(thisdom).parent().find("b").eq(0).text();
    				}
    				else
    				{
    						var hk_id=$(thisdom).prop('id');
    					qi=$(thisdom).parent().parent().parent().parent().parent().prev().find("b").eq(0).text();
    				}

    				$(".qicia").html("<select name='hk_qici'><option value='"+qi+"'>第"+qi+"期  </option></select>")
    					layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '新增回款',
								content:$('.add_hk'),
								btn:['保存'],

								btn1:function(){
										
										var htid=$(".ht_id").val();	 	
										var formdom1=$("#hk_add").children("table").find("tr");
										var fornum1=formdom1.length;
										var end_hk='';
									//	alert(fornum1)
										for(a=0;a<fornum1;a++)
										{
											var thisdom=formdom1.eq(a).find("td").eq(1).children();
												end_hk+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
											$.get(rooturl+'/index.php/Home/Hetongmingcheng/add_huikuan',{"id":end_hk,"hk_id":hk_id},
												 function(html){

									        			window.location.href="Hetongmingcheng?id="+htid;
							                   });

								}
							
							}); 
						});                  
    			}
function bjjh(thisdom){
    				
    				var hk_id=$(thisdom).prop('id');
					qi=$(thisdom).parent().parent().parent().parent().prev().find("b").eq(0).text();
    				$.get(rooturl+'/index.php/Home/Hetongmingcheng/save_hksql',{"hk_id":hk_id,'qi':qi},
												 function(html){

									        		$('#hk_adda').html(html)		
							                   });
    				
    						
    						
    					

    				
    					layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '编辑回款',
								content:$('.save_hk'),
				
								btn:['保存且发起审批','取消'],
								btn1:function(){
										
										var htid=$(".ht_id").val();	 	
										var formdom1=$("#hk_add").children("table").find("tr");
										var fornum1=formdom1.length;
										var end_hk='';
									//	alert(fornum1)
										for(a=0;a<fornum1;a++)
										{
											var thisdom=formdom1.eq(a).find("td").eq(1).children();
												end_hk+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
											$.get(rooturl+'/index.php/Home/Hetongmingcheng/add_huikuan',{"id":end_hk,"hk_id":hk_id},
												 function(html){

									        			window.location.href="Hetongmingcheng?id="+htid;
							                   });

								}
							
							}); 
						});                  
    			}
    	function xzkp(){
    		$('#kaipiaoadd table :input').blur(function(){
			var $parent =$(this).parent();
			$parent.find(".formtips").remove();
			if( $(this).is('.required') ){
				if(this.value==""){
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#x1007;</i> ";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#xe616;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
		
		}).keyup(function(){
           $(this).triggerHandler("blur");
        }).focus(function(){
             $(this).triggerHandler("blur");
        });
    				layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '新增开票记录',
								content:$('.kpjl'),
								btn:['保存'],

								btn1:function(){

								 $("#kaipiaoadd :input.required").trigger('blur');
             							 var numError = $('form .onError').length;
		              				  if(numError){
		              				  	 tishi('必填项不能为空')
		                   				 return false;
              		 				 }  /**nnn**/
              		 				 window.jiazai=layer.load(2);
									var htid=$(".ht_id").val();
									var kp_end='';
									//	var formdom1=$("#hk_add").children("table").find("tr");
										var kp_num=$("#kaipiaoadd").children("table").find("tr");
										var kp_num1=kp_num.length;
										for(var a = 0; a<kp_num1; a++)
										{
											var thisdom=kp_num.eq(a).find("td").eq(1).children();
											kp_end+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
								//	alert(kp_end)
										$.get(rooturl+'/index.php/Home/Hetongmingcheng/kaipiaoadd',{"id":kp_end},
												function(html){
												
													window.location.href="Hetongmingcheng?id="+htid;
												})

								}
							}); 
						});          
    	}

    	
        function bh_yy(tjl){
        		var bh_id=$(tjl).prop("class");
        		$.get(rooturl+'/index.php/Home/Hetongmingcheng/bh_yy',{"id":bh_id},
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
         function bh_yy1(tjl){
        		var bh_id=$(tjl).prop("class");
        		$.get(rooturl+'/index.php/Home/Hetongmingcheng/bh_yy1',{"id":bh_id},
											function(html){
												//alert(html)
													$(".bhyuany12").html(html);

											})
        		layui.use('layer', function(){

							var layer = layui.layer;

							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '驳回原因',
								content:$('.bhyuanyyy'),
								btn:['确定'],

								btn1:function(){
										
									  layer.close(win)    
							            
								}
							
							}); 
						}); 

        }	
       function sc_kp(ss){
			var kp_id=$(ss).prop("class");
			$.get(rooturl+'/index.php/Home/Hetongmingcheng/sc_kpee',{"id":kp_id},
												function(html){
													if(html=="ok")
													{
														tishi("删除成功");
														window.location.href="Hetongmingcheng?id="+htid;
													}else{
														tishi("删除失败");
													}
												

											})
       }
       function fapiao(ss){
       	var a=$(ss).val();
       	var hqtr = $(ss).parent().parent();
       //	alert(hqtr)
	       if(a == 0)
	       {
	       	$(".zzsfp").remove();
	    	hqtr.after("<tr class='ptfp' ><td><span style='color:red'>＊</span>发票抬头:</td><td><input type='text' name='kp_fp_tt' class='required'></td></tr><tr class='ptfp' ><td>纳税人识别号:</td><td><input type='text' name='kp_fp_sbm' ></td></tr>");
	    	$('#kaipiaoadd table :input').blur(function(){
			var $parent =$(this).parent();
			$parent.find(".formtips").remove();
			if( $(this).is('.required') ){
				if(this.value==""){
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#x1007;</i> ";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#xe616;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
		
		}).keyup(function(){
           $(this).triggerHandler("blur");
        }).focus(function(){
             $(this).triggerHandler("blur");
        });

	       }else if(a==1){
	    	$(".ptfp").remove();
	    	hqtr.after("<tr class='zzsfp'><td><span style='color:red'>＊</span>单位名称:</td><td><input type='text' name='kp_fp_dw' class='required'></td></tr><tr class='zzsfp'><td><span style='color:red'>＊</span>纳税人识别码:</td><td><input type='text' name='kp_fp_sbm1' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>注册地址:</td><td><input type='text' name='kp_fp_zcdz' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>注册电话:</td><td><input type='text' name='kp_fp_zcdh' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>开户银行:</td><td><input type='text' name='kp_fp_khyh' class='required'></td></tr><tr class='zzsfp'><td><span style='color:red'>＊</span>银行账户:</td><td><input type='text' name='kp_fp_yhzh' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>收票人姓名:</td><td><input type='text' name='kp_fp_spr' class='required'></td></tr><tr class='zzsfp'><td><span style='color:red'>＊</span>收票人手机:</td><td><input type='text' name='kp_fp_sprphone' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>收票人省份:</td><td><input type='text' name='kp_fp_sheng' class='required'></td></tr><tr class='zzsfp' ><td><span style='color:red'>＊</span>详细信息:</td><td><input type='text' name='kp_fp_xiangxi' class='required'></td></tr>");
	    	$('#kaipiaoadd table :input').blur(function(){
			var $parent =$(this).parent();
			$parent.find(".formtips").remove();
			if( $(this).is('.required') ){
				if(this.value==""){
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#x1007;</i> ";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px;margin-left:3px'>&#xe616;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
		
		}).keyup(function(){
           $(this).triggerHandler("blur");
        }).focus(function(){
             $(this).triggerHandler("blur");
        });
	       }
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
										content_gj="kh_id!"+$(".ht_id").val()+","+"type!"+$('.typegj').val()+","+"content!"+$('.contentgj').val()+","+"add_time!"+$(".add_timegj").val()+","+"date!"+$(".dategj").val();
										var xgj=$(".gjzt12").val();
									//	alert(content_gj)
									//	alert(xgj);return;
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/xgj',{"id":content_gj,'xgj':xgj},
						        		 				function(html){
												
			        		 								location=rooturl+"/index.php/Home/Hetongmingcheng/hetongmingcheng?id="+$(".ht_id").val();
			        		 								
														});

								}
							}); 
						});  
	}
	function del_check(ss){
    			var checked_str=$(ss).prop('id');
    			
    			$.get(rooturl+'/index.php/Home/Hetong/del',{"id":checked_str},
		        		 function(html){
		        		 		tishi("删除成功")
		        				 				location=rooturl+"/index.php/Home/Hetong/hetong";
		                   });

    		}
    		var is_one=0;
     function change_fun(v2)
				 {
				 		if(is_one<1)
					 	{
					 		is_one++;
					 		return;
					 	}

					
				 		
				 			window.cp_id= v2.val();
			    			if(cp_id == 's'){
			    				$(".cp_yj").val("")
			    				$(".cp_jy").val("")
			    				$(".cp_zk").val("-")	
			    				$(".cp_num1").val("")	
			    				$(".cp_zj").val("")	
			    				layer.close(win)
			    			}
			    			$.get(rooturl+'/index.php/Home/Shangji/cp_ajax',{"id":cp_id},
			    										function(html)
			    										{
													//	alert(html)
																$(".cp_yj").val(html)
																$(".cp_jy").val(html)
			    												$(".cp_zk").val("100.0%")	
			    												$(".cp_num1").val(1)	
			    												$(".cp_zj").val(html)	
			    													layer.close(win)
			    										}
			    				)

				}
				function fj_xz(ss)
				{
					var s=$(ss).prop('class');
					window.location=rooturl+'/index.php/Home/Hetongmingcheng/download1?id='+s;
						
				}
					function fj_xz(ss)
				{
					var s=$(ss).prop('class');
				
					window.location=rooturl+'/index.php/Home/Hetongmingcheng/download1?id='+s;
						
				}   
	function ht_fj(ss){
		var ht_id=$(ss).prop('class');
		
		$.get(rooturl+'/index.php/Home/Shenpi/fujian',{"id": ht_id},
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
	function ht_cp(ss){
		var ht_id=$(ss).prop('class');
		$.get(rooturl+'/index.php/Home/Hetong/cp_ck',{"id": ht_id},
												function(html){
												
													$(".cp_showoo").html(html);

											})
		
			layui.use('layer', function(){
			
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:['1000px','400px'],
								title: '产品详情',
								content:$('.chanpina'),
								btn:['返回'],

								btn1:function(){
										
									  layer.close(win)    
							            
								}
							
							}); 
						});      

	}
	function shanchu_pz(ss){
		var id=$(ss).prop('id');

		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								title: '删除回款记录',
								content:$('.del_huikuan'),
								btn:['确认删除','取消'],
								btn1:function(){
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/del_hkjh',{"id":id},
												function(html){
													tishi("删除成功");
													location=rooturl+"/index.php/Home/Hetongmingcheng/hetongmingcheng?id="+$(".ht_id").val()+"&uiid=2";
											})
								},
								btn2:function(){
									  layer.close(win)    
								}
							}); 
						});  

	}
	function xiugai_pz(ss){
			var id=$(ss).prop('id');

			var qici=$(ss).parent().parent().children().children().eq(0).text();
			
			$.get(rooturl+'/index.php/Home/Hetongmingcheng/save_hkjh',{"id":id,'qici':qici},
													function(html){
													$('.save_huikuan').html(html);
												})
			layui.use('layer', function(){
								var layer = layui.layer;
								var win=layer.open({
									type:1,
									offset: 't',
									area:['630px','400px'],
									title: '编辑回款计划',
									content:$('.save_huikuan'),
									btn:['确认编辑','取消'],
									btn1:function(){
											content_hk="hk_data!@"+$("#hk_data").val()+"!,"+"hk_zb!@"+$('#hk_zb').val()+"!,"+"hk_je!@"+$('#hk_je').val()+"!,"+"hk_bz!@"+$("#hk_bz").val();
									
										$.get(rooturl+'/index.php/Home/Hetongmingcheng/save_hkjhend',{"content":content_hk,'id':id},
													function(html){
														tishi(html)
														
														location=rooturl+"/index.php/Home/Hetongmingcheng/hetongmingcheng?id="+$(".ht_id").val()+"&uiid=2";
												})
									},
									btn2:function(){
										  layer.close(win)    
									}
								}); 
							});  

	}
	function del_hkadd(ss)
	{
		var id=$(ss).prop('id');

		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								title: '删除回款记录',
								content:$('.del_hkjilu'),
								btn:['确认删除','取消'],
								btn1:function(){
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/del_hkjl',{"id":id},
												function(html){
													tishi("删除成功");
													location=rooturl+"/index.php/Home/Hetongmingcheng/hetongmingcheng?id="+$(".ht_id").val()+"&uiid=2";
											})
								},
								btn2:function(){
									  layer.close(win)    
								}
							}); 
						});  
	}
	function del_gj(ss){
		 	var gj_id=$(ss).prop('id');
				$.get(rooturl+'/index.php/Home/Hetongmingcheng/del_gja',{"id":gj_id},
							        		 function(html){
									        		location=rooturl+"/index.php/Home/Hetongmingcheng/hetongmingcheng?id="+$(".ht_id").val();//$(".rz_sxp").html(html);
							                   });
		 }
	</script>
</html>