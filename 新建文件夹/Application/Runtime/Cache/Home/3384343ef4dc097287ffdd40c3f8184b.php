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

  		<style>
  			body,ul,li,tr{margin:0;padding:0;font-size:14px;}
  			.jibenxinxi{width:50% ;float:left;}
  			.xiegenjin{width:48% ;float:right;}
  		
  			.clear{clear:both; height: 0; line-height: 0; font-size: 0}
  			.bianji_nb{margin:left:30%; border:1px solid:red; }
			.ziliao{height:40px;width:100%; background-color:#eee;}
			.xiaoshou{position: relative; left :20px;top:10px;width:107%;}
			.genjinjilu{background-color:#1AA094;width:70px;height:24px;float:right;}
			.genjinjilu{position: relative; right:8px;top:6px;color:white;}
			.only1{position: relative; left:75%;top:6px;}
			.genjin_back{background-color:#F7FBFE;width:90%;position: relative; top:10px;margin:20px auto;}
			.fuzeren{ position: relative; left: 15px;font-size:14px;}
			.tbl{margin-left:20px;}
			.addshangji_weizhi{margin:0px auto;margin-top:20px;}
			.addtr{line-height:25px;}
			.addtr td{padding-top:20px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;}
			.top_bz{position: relative; top: -65px;;}
			tr{line-height:30px;}
  				  		</style>
		<script>
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
			 $(function() {
   				$( "#tabs" ).tabs();
 			 });
		</script>
	</head>
	<body>
		<div style="margin:20px"><span style="font-size:22px;margin-right:10px"><?php echo ($name); ?></span>负责人：<span><?php echo ($fuzeren); ?></span></div>
		<div style="margin-top:20px;margin-left:8px; height:50px" >
	   		<button onclick="history.go(-1)"  class="layui-btn layui-btn-primary layui-btn-small">
 				<i class="layui-icon">&#xe603;</i>返回</button>	
		   	<button onclick="bianji()"  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe642;</i>编辑</button>
		   	<button onclick="del_check(this)"  name='<?php echo ($kh_id); ?>'  class="layui-btn layui-btn-primary layui-btn-small">
	 			<i class="layui-icon">&#xe640;</i>删除</button>
		</div>	
		<div id="tabs">
		  <ul>
		    <li><a href="#tabs-1">基本信息</a></li>
		    <li><a href="#tabs-2">回款</a></li>
		    <li><a href="#tabs-3">产品</a></li>
		    <li><a href="#tabs-4">提醒</a></li>
		    <li><a href="#tabs-5">附件</a></li>
		    <li><a href="#tabs-6">操作日志</a></li>
		   
		  </ul>
		  <div id="tabs-1">
			  <div class="jibenxinxi">
			  		<div>
			  				<span style="color:blue">基本资料</span>
   
			  			 	<span id="save_jb"><?php echo ($show); ?></span>
			  		</div>
			  		<div>
			  				<span style="color:blue">系统资料</span>
			  				<?php echo ($show1); ?>
			  		</div>
			   </div>
			   <div class="xiegenjin">
					<div class="ziliao">
	  					<span class="xiaoshou">销售动态</span><span class="only1">只看跟进</span><span id="dialog-form" onclick="xiegenjin()" class="genjinjilu">+写跟进</span>
	  				</div>
	  				<div  class="genjin_back">
	  				<table class="tbl">
		  				<tr>
		  					<td>操作人：<span class="fuzename">王玉帅</span></td>
		  				</tr>
		  				<tr>
		  					<td>我吃饭了呼呼呼呼或或</td>
		  				</tr>
		  				<tr>
		  					<td>来自客户<span class="fuzename">  抓泥鳅</span></td>
		  				</tr>
		  				<tr>
		  					<td><span class="dataa">时间:2012-03-03</span></td>
		  				</tr>
	  				</table>
	  				</div>
			   </div>
			    <div class="clear"></div>
			   	<div class="bianji"  style="display: none;border:1px;">
		    		<div class="bianji_nb" style="width:330px;margin:0 auto">
		    			<form id="myform">
		    			<?php echo ($show2); ?>
		    			</form>
		    		</div>
			   	</div>
		   </div>
		  <div id="tabs-2">
		  	<table class="layui-table" lay-skin="line">
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
						
				  				<td ><a href="<?php echo ($_GET['root_dir']); ?>/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/<?php echo ($sql_lianxi["lx_id"]); ?>"><span style="color:blue"><?php echo ($lx_json["zdy0"]); ?></span></a></td>
				  				<td ><?php echo ($lx_json["zdy4"]); ?></td>
				  				<td ><?php echo ($lx_json["zdy5"]); ?></td>
				  				<td ><?php echo ($lx_json["zdy6"]); ?></td>
				  				<td ><?php echo ($lx_json["zdy10"]); ?></td>
				  				<td ><?php echo ($lx_json["zdy16"]); ?></td>
				  			
				  	
						</tr> 	
					</tbody>
			 </table>
		  </div>
		  <div id="tabs-3">
		  <input type="button"  onclick="add_cpp()" class=" layui-btn layui-btn-small" value="+添加产品">
				<table class="layui-table" lay-skin="line">
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
						<tbody class="cp_showoo">
							<?php echo ($show2); ?>	
						</tbody>
				 </table>
		  </div>
		  <div id="tabs-4">
		  统一做
		  </div>
		  <div id="tabs-5">

			  		<input type="button" id="dialog-form" onclick="fj_cp()"  class=" layui-btn layui-btn-small" value="+文件上传">
			   <table class="layui-table" lay-skin="line">
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
			  					<div id="shangc_top" style="margin-top:20px"><span class="top_bz">备&nbsp;&nbsp;&nbsp;&nbsp;注：</span><!-- 第一个是普通textarea -->
							<textarea name="wenbenyu" class="comments" rows="5" cols="30"> </textarea>  </div>
			  					<div id="shangc_top" ><input type="submit" value="上传附件"  class="layui-btn layui-btn-small"></div>
			  				</form>
					</div>	
		
		  </div>
		  <div id="tabs-6">
		    	
			  		
	  		</div>
	  		
		 
		</div>
		 <div id="addcp" style="display: none;border:1px">
		  		<form id="cp_form" method="post" >
								<table class="addshangji_weizhi">
								<?php echo ($chanpin1); ?>
								<tr class="addtr">
									<td>产品原价：</td>
										<td>
											<input type="text" class="cp_yj" name="cp_yj" disabled name="cp_yj" style='width:300px;height:26px;'>		
										</td>			
								</tr>
								<tr class="addtr">
									<td><span style="color:red">*</span>建议价格：</td>
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
											<input type="hidden" name="sj_id" disabled value="<?php echo ($ht_id); ?>";'>	
										</td>			
								</tr>
								</table>
							</form>
		  	</div>
	</body>
	<script>
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
									//alert (ajaxstr);
									$.get(rooturl+'/index.php/Home/Shangjimingcheng/save',{"id":ajaxstr},
							        		 function(html){
									        		// alert(html)
									        		if(html=="no"){
									        			alert("没有修改信息")
									        			layer.close(win)
									        		}else{
									        			
									        			$("#save_jb").html(html);
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
		  
		  function add_cpp(){
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
									$.get(rooturl+'/index.php/Home/Hetongmingcheng/add_cp',{"id":vstr},
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
	</script>
</html>