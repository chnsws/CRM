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
			<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
  		
<script>
	window.rooturl="<?php echo ($_GET['root_dir']); ?>";
</script>
   		<style>
		body,ul,li,table,tr{margin:0;padding:0;font-family:宋体; color:#333;}
		.top{ width:100%;} 
		.top1{  position: relative; left: 10px; top :16px;}
		.name{font-size:24px; color:black;}
		.fuzeren{ position: relative; left: 15px;font-size:14px;}
		.fuzename{color:blue;}
		.anniu{ position: relative; top :30px;}
		.quanjing_left{ height:100%;border: 1px solid #eee;}
		.quanjing_right{ border: 1px solid #eee;}
		.ziliao{height:40px;width:100%; background-color:#eee;}
		#tabs-1{position: relative; right :18px;}
.jiben{position: relative; left :20px;top:10px;}
.ck_lx{float:right;margin-top:10px;position: relative; right :20px;}
.phone{position: relative; left :20px;top:20px;}



.left_color tbody tr{line-height:20px;}
.left_color:nth(1)-child{float:left;width:35%;background-color:#F7FBFE;}
.sj_bj{background-color:#F7FBFE;margin-top:20px;margin-bottom:20px;width:81%;}
.left_color:nth(2)-child{float:right;width:35%;background-color:#F7FBFE;position: relative; right :200px;}
.bottom_jj{padding-bottom:30px;}
.qc{clear:both;}
.xiaoshou{position: relative; left :20px;top:10px;width:107%;}
.phone1{line-height:80px;position: relative; left :20px;}
td{padding-top: 13px;position: relative; left :20px;}
#ccc table{ position: relative; top :3px;background-color:#F8F8FF; width:300px;}
.add_null{position: relative; left :17px;line-height:30px;}
.shangji{width:200px; height:30px;}
.shangji1{color:blue;position: relative;}
.genjinjilu{background-color:#1AA094;width:70px;height:24px;float:right;}
.genjinjilu{position: relative; right:8px;top:6px;color:white;}
.only1{position: relative; left:475px;top:6px;}
.genjin_back{}
.sele{position: relative; left:18px;top:5px;}
.shiji{float:right;position: relative; right:18px;top:5px;}
.wenbenyu{position: relative; left:15px;top:10px;}
.kehu_genjin{position: relative; left:18px;top:20px;}
.genjinzhuangtai{float:right;position: relative; right:86px;top:-5px;}
.legt_genjin{position: relative; left:50px;}
.left_genjin1{position: relative; left:50px;}
.lianxiren_genjin{position: relative; left:18px;top:30px;}
.left_lianxiren{position: relative; left:33px;}
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
.fa-pencil{position: relative; left:50px;}
.xinzengtixing{background-color:#1AA094;margin-bottom:30px;}
.tixingkuang{width:55%;height:130px;border-left: 1px solid #555;}


.tixingkuang{position: relative; left:74px;}
.write{color:white;}
.time_tx{margin-left:10px;color:#1AA094;}
.xiala_tx{width:130px;float:right;}
.yiwancheng{border-radius: 1em; background-color:#1AA094;float:right;position: relative; left:112px;}
.tx_nei{background-color:#eee;height:70px; width:85%; margin-left:8%;margin-top:15px;}
.baocun4{margin-bottom:30px;}
.bianjiyo{width:300px;}
.rz_show{background-color:#F7FBFE;width:90%;position: relative; top:10px;margin:50px auto;}
.rz_sx{width:230px;height:40px;}
.rz_sx1{margin-left:20px;}
		</style>

	</head>
	<body >
		<div class="top">
			<div class="top1">
				
				<span class="name" ><?php echo ($kh_name); ?></span> <span class="fuzeren">负责人:<span class="fuzename"><?php echo ($kh_fz); ?></span></span>
				
			</div>
   		
		</div>		
		<div style="margin-top:50px;margin-left:8px; height:50px" >
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
		<div id="tabs">
			  <ul>
			    <li><a href="#tabs-1">客户全景</a></li>
			    <li><a href="#tabs-2">客户资料</a></li>
			
			    <li><a href="#tabs-4" class='lxrone' >联系人</a></li>
			    <li><a href="#tabs-5">商机</a></li>
			    <li><a href="#tabs-6">合同</a></li>
			    <li><a href="#tabs-7">提醒</a></li>
			    <li><a href="#tabs-8">附件</a></li>
			    <li><a href="#tabs-9">操作日志</a></li>
			  </ul>
	  		<div id="tabs-1" style="overflow:hidden;width:100%">
	  			<div class="quanjing_left" style="width:50%; float:left">
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">基本资料</span>
	  				</div>
	  				<div >
	  					<span class="phone">客户类型：<?php echo ($kh_type2); ?></span><br />
	  					<span class="phone1">电话：<?php echo ($kh_phone); ?></span>
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">联系人</span><span class='ck_lx' id='lxrone' onclick="ck_lx(this)">查看更多>></span>
	  				</div>
	  				<div class="ccc">
	  					
	  				<?php echo ($lx_show); ?>
	  				</div>	
	  				<div class="qc"></div>
	  				</div>
	  			
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">商机</span>
	  				</div>
	  				<div >
	  					
	  					<table class='sj_bj'>
	  						<?php echo ($sj_show); ?>
	  					</table>
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">合同</span>
	  				</div>
	  				<div >
	  				<table class='sj_bj'>
	  						<?php echo ($ht_show); ?>
	  					</table>
	  					
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">交易数据</span>
	  				</div>
	  				<div >
	  					<table class='sj_bj'>
		  				<tr>
		  					<td class='shangji'>已成交：￥100000</td>
		  					<td  class='shangji'>已回款：￥100000</td>
		  					<td  class='shangji'>潜在交易：￥100000</td>
		  				</tr>
		  				</table>
	  				</div>
	  				</div>
	  			</div>
	  			<div class="quanjing_right" style="width:45%;float:left;position: relative; left :50px;">
					<div class="dan">
	  				<div class="ziliao">
	  					<span class="xiaoshou">销售动态</span><span class="only1">只看跟进</span><span id="dialog-form" onclick="xiegenjin()" class="genjinjilu">+写跟进</span>
	  				</div>
	  				<div id="uploadfrm" style="height:400px;width:590px;padding:0;margin:0;">
	  				<form id="uploadform2" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Kehu/genjin_bianji/id/<?php echo ($kh_id); ?>/pageid/<?php echo ($_GET['id']); ?>/fuzeren/<?php echo ($_GET['fuzeren']); ?>/id1/<?php echo ($_GET['id1']); ?>/kh_id/<?php echo ($_GET['kh_id']); ?>
	  				" method="post">
	  					<select name="fangshi" class="sele" style="width:150px;height:30px">
	  						<option value="电话">电话</option>
	  						<option value="QQ">QQ</option>
	  						<option value="拜访">微信</option>
	  						<option value="拜访">拜访</option>
	  						<option value="邮件">邮件</option>
	  						<option value="短信">短信</option>
	  						<option value="其他">其他</option>
	  					</select>
	  					<input type="text" name="shiji"  class="text ui-widget-content ui-corner-all shiji" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})" value="<?php echo ($valav['kh_sj_gj_date']); ?>" style="width:150px;height:30px">
	  					<input type="hidden" name="kh_id" class="bingou" value="<?php echo ($kh_id); ?>">
	  					
	  					<textarea name="wenbenyu" rows="10" cols="77" class="wenbenyu"> 
	  						勤跟进，多签单........
	  					</textarea>
	  				<div class="kehu_genjin">客户<span class="legt_genjin"><input type="text" name="shiji_date" value="<?php echo ($a_id); ?>" style="width:150px;height:20px" readonly="true"></span></div>  

	  				<div class="genjinzhuangtai"> 
	  					跟进状态 <span class="left_
	  					genjin1">
	  								<select name="genjinzhuantai"  style="width:150px;height:25px">
		  							
			  							<?php if(is_array($dan_ywcs)): foreach($dan_ywcs as $sq=>$ywcs): if($ywcs == $valav['zdy9']){ ?>
			  												<option selected="slected" value="<?php echo ($sq); ?>"> <?php echo ($ywcs); ?></option>

			  										<?php	}else{ ?>
			  												<option value=" <?php echo ($sq); ?>"><?php echo ($ywcs); ?></option>
			  										<?php	} endforeach; endif; ?>
	  							</select></span>
	  							</div>
 
	  				<div class="lianxiren_genjin">联系人
	  				<span class="left_lianxiren">
	  								<select name="lianxiren"  style="width:150px;height:25px">
		  							<option value="王玉帅">王玉帅</option>
			  						<option value="小明">小明</option>
			  						<option value="小刚">小刚</option>
			  						<option value="皮皮虾">皮皮虾</option>
			  						<option value="biubiubiu">biubiubiu</option>
	  							</select>
	  					</span>
	  				</div>  
					<div class="next_time">下次跟进时间<span ><input type="text" name="next_date" value="" style="width:150px;height:20px" class="text ui-widget-content ui-corner-all left_genjin1" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})"></span></div> 

					<div class="tijiao"><input type="submit" value="保存"  style="width:80px">
					<input type="button" value="取消"  style="width:80px"></div>
	  				</form>
	  				</div>
				<!--	<div  class="genjin_back">

		  				<table>
			  				<tr>
			  					<td><span class="fuzename"><?php echo ($vo["user_id"]); ?>：<?php echo ($vo["type"]); ?></span></td>
			  				</tr>
			  				<tr>
			  					<td><?php echo ($vo["content"]); ?></td>
			  				</tr>
			  				<tr>
			  					<td>来自客户<span class="fuzename">  <?php echo ($a_id); ?></span></td>
			  				</tr>
			  				<tr>
			  					<td><span class="dataa">时间:<?php echo ($vo["rz_time"]); ?></span></td>
			  				</tr>
		  				</table>
	  				</div>
			-->
	  				<div  class="genjin_back" >
		  				<?php echo ($rz_show); ?>
	  				</div>

	  				</div>
	  				
	  			</div>
	  		</div>
	  		<div id="tabs-2">
	  			<div >
	  				<span style="color:blue;margin-bottom:20px">基本信息</span>
				  	<table id="th_onlykh">
				  		<?php echo ($tabl); ?>	
					</table>
				</div>
					<div >
	  					<span style="color:blue;">	系统信息</span>
					  	<table>
					  		<?php echo ($tab2); ?>	
						</table>
					</div>
	  		</div>
	  		
	  		<div id="tabs-4">
	  		
	  			<table class="layui-table" lay-skin="line">
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
	  		<div id="tabs-5">
	  			<table class="layui-table" lay-skin="line">
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
	  		<div id="tabs-6">
	  			<table class="layui-table" lay-skin="line">
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
	  		<div id="tabs-7">
	  				
	  				<div class="xinzengtixing" style="width:72px;height:25px"><span class="write" id="dialog-form" onclick="xinzeng()" class="genjinjilu">+新增提醒</span></div>
	  				<?php if(is_array($tixing_tx)): foreach($tixing_tx as $key=>$vo): ?><div class="tx_date"><span style="color:#1AA094;" ><?php echo ($vo["tx_date"]); ?></span>
		  					<div class="tixingkuang" >
		  						<div>
									<i class="fa fa-clock-o" aria-hidden="true"></i><span class="time_tx"><?php echo ($vo["tx_time"]); ?></span>

									<select  class="xiala_tx" style="border:0px">
										<option selected="selected"></option>
										<option >编辑</option>
										<option >删除</option>
									</select>

									<span class="yiwancheng" style="color:white">设为已完成</span>
								</div>
								<div class="tx_nei">
									<?php echo ($vo["tx_nr"]); ?>
								</div>
		  					</div>
		  				</div><?php endforeach; endif; ?>
		  				
		  				
	  				<form  method="post" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Kehu/tixing_add/id/<?php echo ($kh_id); ?>/pageid/<?php echo ($_GET['id']); ?>/fuzeren/<?php echo ($_GET['fuzeren']); ?>/id1/<?php echo ($_GET['id1']); ?>/kh_id/<?php echo ($_GET['kh_id']); ?>
	  				" id="xinzengtixing1">
	  					<table>
	  						
	  					<tr><td><input type="hidden" name="tx_mk" value="<?php echo ($_GET['id1']); ?>" ></td></tr>
	  					<tr><td>提醒内容：<input type="text" name="tx_nr"></td></tr> 
	  					<tr><td><input type="hidden" name="tx_people" value="<?php echo ($_GET['fuzeren']); ?>"></td></tr>
	  					<tr><td>提醒时间：<input type="text" name="tx_bijiao" class="text ui-widget-content ui-corner-all " onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})" name=""></td></tr>
	  						<tr><td><input type="submit" value="保存" class="baocun4" style="width:90px"></td></tr> 
	  					</table>
	  				</form>
	  				
	  		
	  		</div>
	  		<div id="tabs-8">
	  		

	  		<div >
	  		<input type="button" id="dialog-form" onclick="openwindow()" class="layui-btn layui-btn-small" value="+文件上传">
	  		<table class="layui-table" lay-skin="line">
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
	  		<div id="tabs-9">
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
	  				<button onclick="rz_sx(this)" class="rz_sx1 layui-btn layui-btn-small">查询</button></div>
	  			<table class="layui-table" lay-skin="line"> 
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


		  function xiegenjin()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'610px',
					title: '写跟进',
					content:$('#uploadfrm')
				}); 
			});              
		  }


	
  		</script>

  		<script>
			$("#xinzengtixing1").hide();
			 $(function() {
			   				 $( "#tabs" ).tabs();
			 		 });
					  function xinzeng()
					  {
					  	layui.use('layer', function(){
							var layer = layui.layer;
							layer.open({
								type:1,
								area:'330px',
								title: '新增提醒',
								content:$('#xinzengtixing1')
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
							        		 					alert(html)
															$(".fujian_del").html(html);
															blurfun();

															});

    			});

    		};
    		
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
    	function bianji(){
			layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
										area: '630px',
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
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
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
	</script>