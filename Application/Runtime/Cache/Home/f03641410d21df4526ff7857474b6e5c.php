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
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css"><!--图标-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>

		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>



	    <link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>

		<link href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" rel="stylesheet"  type="text/css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}

			.big{width:99%;height:100%;margin: 0px auto;}
			.xinzeng{float:right; margin-right:2%} /* 新增 导入*/
			.sxzddiv,span{overflow:hidden;}

		

    		#table_local_length{width:100px;}
    		.label-success{ height:28px;line-height:16px;width:60px; text-align: center;font-size:14px; }
			#table_local_filter label{width:300px;}
		
			#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
			.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
			.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
			.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}
			.xinzeng2{float:right;}
			.fa-pencil{float:right;}
			.sx_tj_margain{margin-left:12px;}
			
		.anniu{line-height:70px;height:70px;border:1px solid #ccc;margin-top:20px;} 
			.head_title{font-size:20px;}
			.addshangji_weizhi{margin:0px auto;margin-top:20px;}

			.addtr{line-height:25px;}
			.addtr td{padding-top:20px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;}
		
			span a{margin-left:20px;}
			.pl_bj{margin:0px auto;}
			#nchangyong{margin-top:10px;margin-left:19%;}
			#nnchangyong{margin-top:10px;margin-left:19%;}
			.onError{color:red;}
			.onSuccess{color:green;}
			.kongzhiyeshu{margin-top:19px;height:40px;font-size:16px;margin-left:20px;}
			.searchable-select-dropdown{z-index:99999990;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;} 
			.panel-title{color: #1AA094;font-weight: bold;font-size: 22px;}
			.panel-heading{
					height: 60px;line-height: 60px;border-bottom-style:solid;border-width: 1px;border-color: #E0E0E0;margin-left: 5px;
				}
			a{color:#07d; text-decoration:none !important;}
			.searchable-select-input{width:280px !important ;}
			.searchable-select {min-width:300px;}
			td
        {
            white-space: nowrap;
        }
        th
        {
            white-space: nowrap;
        }
		</style>   
		 
  <style>
  label {
    display: inline-block;
    width: 5em;
  }

  </style>  
<script>

	$(function(){
		$('.xlss').searchableSelect();
 });

</script>
	</head>

	<body style="position:relative">
	
<input type="hidden" id="ys" value="<?php echo ($ys); ?>">
	<input type="hidden" id="fenye" value="<?php echo ($list_num); ?>">
	 <input type="hidden" id="wocao" value="<?php echo ($dijiye); ?>">
	<div class="beijing">
		<div class="big">
			<div >
				  <ul>
				    <li class="panel-heading">
				    	<span class="panel-title"><b>商机</b></span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addshangji()" class="layui-btn" style="height: 30px;line-height: 30px;" ><i class="fa fa-plus" style="margin-right: 5px;"></i>新增商机</button><button onclick="daoru()"  style='border:1px solid #999; background-color:white;color:#222;margin-left:20px;height: 30px;line-height: 30px' class="layui-btn">导入商机</button></span>
				    </li>
				  </ul>
			</div>
			       
			<div class="sxdiv" >
					

			     	<div id='sxhidestr' style=';display: none;border:1px '>
       		<div class='sx_tj_margain'><span class='one sx_yes' style="margin-left:20px">全部商机</span><span class='two sx_yes'  style="margin-left:20px">全部</span><span class='three sx_yes'  style="margin-left:20px">全部</span><span class='four sx_yes'  style="margin-left:20px">全部</span></div>
      		 </div>


				         <div id="sxzddiv"  > 
			              		<?php echo ($new_html); ?>
		   				 </div>

		   </div>
		   <div id="sxshowbtn" onselectstart='return false'><i class='fa fa-chevron-up' aria-hidden='true'></i></div>
		   	<div class="anniu">		
					<span style="margin-top:-8px;margin-left:1%"  class="anniudw">

					   		
					   	<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 			<i class="layui-icon">&#xe642;</i>批量转移</button>	
					   	<button onclick="bianji_kehu1()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 			<i class="layui-icon">&#xe642;</i>批量编辑</button>
					   	<button onclick="del_check()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 			<i class="layui-icon">&#xe642;</i>删除所选</button>
   			 			<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 			<i class="layui-icon">&#xe642;</i>转移至客户公海</button>	
					</span>
					
					<div id="bj_kehu" style="margin-top:10px;padding-top:20px;display: none;border:1px" >
					<form name="pl_bjform" method="post" >
						<table class="pl_bj">
							<tr  style='line-height:70px'>
								<td >选择字段:</td>
								<td>
									<select  style="width:260px;height:26px;" id="show_yc">
											<option>请选择编辑字段</option>
										<?php if(is_array($biaoti1)): foreach($biaoti1 as $key=>$pl_bj): ?><option  value="<?php echo ($pl_bj["id"]); ?>"><?php echo ($pl_bj["name"]); ?></option><?php endforeach; endif; ?>
								 	</select>
								</td>
							</tr>
										<?php echo ($bj_tab); ?>
						</table>
					</form>
					</div>
				
   				</div>

						



			<div class="kehu2" >   
		   		<div class="kehu">   
				   		<div class='kongzhiyeshu uk-form '><span class="ycyo">每页显示<select  onchange="kongzhiyeshu(this)">

				   					<?php if($list_num == '5'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="5">5</option><?php endif; ?>
				   						<?php if($list_num == '10'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="10">10</option><?php endif; ?>
				   						<?php if($list_num == '15'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="15">15</option><?php endif; ?>
				   						<?php if($list_num == '20'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="20">20</option><?php endif; ?>
				   						<?php if($list_num == '25'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="25">25</option><?php endif; ?>
				   						<?php if($list_num == '30'): ?><option value="<?php echo ($list_num); ?>" selected="selected"><?php echo ($list_num); ?></option>
				   						<?php else: ?>
				   							<option value="30">30</option><?php endif; ?>
				   					</select>条
				   					</span>
				   					 		<span style="float:right; margin-right:2%" ><input type="text" height=26px; id="sousuo" value="">
				   					 <span onclick="sousuo1()" style="margin-left:-25px">	<i class="layui-icon" >&#x1006;</i></span>
				   					 		<span  style="width:60px; margin-left:15px" class=" layui-btn layui-btn-small "  onclick="sousuo()">搜索</span>
				   				</span>
				   		</div>
			  		
			   			<div style="overflow:auto">
								
										<table class="layui-table" style="width:auto"  >
										<div  style="width :100%;" >
									  	<thead>
									  			<tr>	
								                		<th><input type="checkbox" onclick="swapCheck()" /></th>
									                 <?php if(is_array($biaoti)): foreach($biaoti as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?> 
								                </tr>
										</thead>
										<tbody id="jb_bianji">
															<?php echo ($show); ?>   <!--客户显示信息-->
							             </tbody>	
							             </div>
									</table>  
									
								
						</div>
				</div>
					<div id="demo7" class="ycyo" style="float:right"></div>
			</div>
		</div>
	</div>



	<div id="lxr" style="display: none;border:1px"> <!--新增客户-->
								<form  name= 'form_kh' method="post" id="myform2" >
									<table class=" th_lxr addshangji_weizhi uk-form" style="width:430px">
										
										
									</table>
								</form>
								
				</div>
		<div id="add_kh" style="display: none;border:1px"> <!--新增客户-->
								<form  name= 'form_kh' method="post" id="kh" >
									<table class=" th_kh addshangji_weizhi uk-form" >
										
										
									</table>
								</form>
								
				</div>

<div id="results"></div>
	<div id="add_shangji" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form name="" id="myform" method="post" class="uk-form"  >
						<table class="addshangji_weizhi" >
							<?php echo ($add); ?>
							<?php echo ($add1); ?>
							<?php echo ($add2); ?>
						<tr  class="addtr">
								<td><span style="color:red">*</span>负责人：</td>
								 <td>
								 	<select name="fuzeren" id='ss3'  class ="clk_fzr required xlss" style='width:300px;height:30px;'>
								 		<option value="">请选择</option>
								 		<?php if(is_array($fuzeren)): foreach($fuzeren as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></option><?php endforeach; endif; ?> 
								 	</select>
								 </td>			
							</tr>
							<tr class="addtr">
								<td>部门：</td>
								<td class='bm_th'>
									<input type="text"  style='width:300px;height:30px;'>
								
								</td>			
							</tr>
						</table>
					</form>
					<div id="nchangyong" onselectstart='return false'><span style="color:#07d;cursor:pointer;">展开更多信息>></span></div>
	</div>
	<div id="daoru" style="display: none;border:1px;margin-top:40px"><!--导入-->
  						<div class="dr_q" style="width:80%;margin:0px auto";>
  							<li style="height:30px;position: relative; left:-8px;">一、下载导入数据模板 ,将导入的数据填充到导入模板文件中。</li>
  							<li  style="height:40px">注意事项：</li>
  							<li  style="height:40px">1）模板中的表头不可更改，表头行不可删除；</li>
  							<li  style="height:40px">2）除必填的列以外不需要的列可以删除；</li>
  							<li  style="height:40px">3）单次导入的数据不超过4000条</li>
  							<li  style="height:40px;position: relative; left:-8px;">二、选择要导入的数据文件</li>
  							<li  style="height:40px"><input type="file" lay-type="file" class="layui-upload-file" name="csv_up"></li>
  							<li   id="yc_xs" ><span id="name_sc" style="margin-left:10px;margin-top:19px;" >名字</span><span   style="margin-left:60px" id="size_sc">大小</span><span   style="margin-left:60px"> 完成</span > <span style="margin-left:60px" onclick="yc_file(this)"  id="fileclose">删除</span></li>
  							
  						</div>
  					</div>
<!--33333333333-->
  	<div id="addcp" style="display: none;border:1px">
  		<form id="cp_form" method="post" class="uk-form" >
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
						</table>
					</form>
  	</div>
  	<div id="piliangzy"   style="display: none;border:1px;margin-top:10px;padding-top:20px;">
					<form name="pl_bjform" method="post" >
						<table class="pl_bj">
							<tr  style='line-height:70px'>
								<td >新负责人:</td><td><select  style="width:260px;height:26px;" id="zhuanyifzr">
												<option>请选择新负责人</option>
												 <?php if(is_array($fuzeren)): foreach($fuzeren as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></option><?php endforeach; endif; ?>   
												
											  </select>
											 
												</td>
							</tr>
							 <tr style='line-height:70px'><td><input type="checkbox" name="zy_kh" value="ok">同时转移商机对应的客户</td></tr>
											  <tr style='line-height:70px'><td><input type="checkbox" name="zy_ht" value="ok">同时转移商机对应的合同</td></tr>

						</table>
					</form>

					</div>
				</body>
	<script>
		
	
window.ajaxstr_kh="";
window.name_kh="";
window.ajaxstr_lxr="";
window.name_lxr="";
		window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		$('#piliangzy').hide();
		$(".yincang").hide()
		$(".ncy").hide()
		$(".nncy").hide()
		$("#addcp").hide();
		$(".hide_dpt").hide();
	$("#add_shangji").hide();
	$("#daoru").hide();
	layui.use('upload', function(){
		
  		layui.upload(options);
		});


		
	$("#sxshowbtn").click(function(){         //控制 、筛选的隐藏与显示
	    if($(this).prop("name")=='0'||$(this).prop("name")==undefined)
	    {
	    	
	        $("#sxhidestr").show("fast");
	        $("#sxzddiv").hide("fast");
	        $(this).html("<i class='fa fa-chevron-down' aria-hidden='true'></i>");
	        $(this).prop("name",'1');
	    }
	    else
	    {
	        $("#sxzddiv").show("fast");
	        $("#sxhidestr").hide("fast");
	        $(this).html("<i class='fa fa-chevron-up' aria-hidden='true'></i>");
	        $(this).prop("name",'0');
	    }
	});
	window.id='';
	$(".sxzddiv").children("span").click(function(){    
	var tex =$(this).text();      //点击筛选的 选中
	    var title=$(this).parent().prop('id');
    $(this).parent().children("span").prop("class","sx_no");
    $(this).prop("class","sx_yes");
    var s=$(this).index();

	id+=title+","+s+"|";
	//tishi(id);
  //tishi(id);
  if(title=="zdy9")
	{
		$(".four").text(tex);
	}
	if(title=="zdy7")
	{
		$(".three").text(tex);
	}
	if(title=="zdy5")
	{
		$(".two").text(tex);
	}
	if(title=="kehujibie")
	{
		$(".one").text(tex);
	}
	$(".ycyo").hide();
	$.get(rooturl+'/index.php/Home/Shangji/shaixuan',{"id":id},
							        		 function(html){
							        			$("#jb_bianji").html(html);
							        			$('.bianji_hide').hide();
							      
							                   });
 
});
	function addshangji(){
	
    	
		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '新增商机',
							
								content:$('#add_shangji'),
								btn:['确认添加','取消'],
								btn1:function(){

									 $("#add_shangji :input.required").trigger('blur');
             							 var numError = $('#myform .onError').length;
		              				  if(numError){
		              				  	 tishi('必填项不能为空')
		                   				 return false;
              		 				 } 
              		 				var lxr = $(".lxr_ad").val();
              		 				if(lxr=='ok'){

 											tishi('请先添加联系人~亲')
		                   				 return false;
              		 				}
              		 			
									var formdom=$("#myform").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
									}

									if(ajaxstr_kh=='')
									{
									$.get(rooturl+'/index.php/Home/Shangji/add',{"id":ajaxstr},
																        		 function(html){
																		         	window.location.href="shangji";
																                   });
									}else{
								
										$.get(rooturl+'/index.php/Home/Shangji/add_end',{"id":ajaxstr_kh,"lxr":ajaxstr_lxr,"lxr_id":name_lxr,'shangji':ajaxstr},
																        		 function(html){
																        		// 	alert(html)
																		         	window.location.href="shangji";
																                   });
									}
									
								},
								btn2:function(){
									$.get(rooturl+'/index.php/Home/Shangji/del_all',{},
							        		 function(html){
									        	  // 	$(".layui-table").hide();
									        		
									        		layer.close(win)
							                   });
									layer.close(win)
									//addshangji()
								},
								cancel:function(index,layero){
									
										$.get(rooturl+'/index.php/Home/Shangji/del_all',{},
							        		 function(html){
									        	  // 	$(".layui-table").hide();
									        		
									        		layer.close(win)
							                   });
										layer.close(index)
								

								}
							}); 
						});  

	}
	var is_upload='';
	function daoru()
		{
			
			layui.upload({
					        url: rooturl+"/index.php/Home/kehu/wjsc_dr",
					        title:"选择文件",
					        success: function(res){
					            if(res['res']=='1')
					            {
					            	
					            	  $("#name_sc").text(res['oldname']);
						              $("#size_sc").text(res['newsize']);
						              $("#yc_xs").show();
						              $("#fileclose").prop("name",res['newname']);
						              if(is_upload!='')
						               {
						                    $.get(rooturl+"/index.php/Home/Kehu/del_old_file",{"oldname":"linshi/"+is_upload});
						               }
               						 is_upload=res['newname'];
               					
						  
					            }
					            else if(res['res']=='2')
					            {
					                tishi("上传文件格式仅支持csv");
					            }
					            else
					            {
					           		 tishi("文件上传失败");
					            }

					        },
					    });
					
					layui.use('layer', function(){
					//	tishi(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
									fixed: false,
								title: '客户导入',
								content:$('#daoru'),
								btn:['下载模板','下载客户参数','开始导入','取消'],
								btn1:function(){
									
				

										window.location=rooturl+'/index.php/Home/Kehu/xiazaimuban';
		        		 				
								},
								btn2:function(){
									window.location=rooturl+'/index.php/Home/Kehu/xiazaimubancanshu';
								},
								btn3:function(){

									 if(is_upload=='')
					                {
					                    tishi("请先选择需要导入的文件");
					                    return false;
					                }
					                $.get(rooturl+"/index.php/Home/Kehu/daoru_chanpin",{"csvfilename":is_upload},function(res){
					                	//tishi(res)
					                    if(res=='1')
					                    {	
					                    	tishi("导入成功")
					                       location.reload();
					                    }
					                    else if(res=='8')
					                    {
					                    	tishi("亲~请下载最新模板")
					                    	 return false;
					                    }else
					                    {
					                        tishi("导入失败，请刷新后重试");
					                        return false;
					                    }
					                });
					                layer.close(index);
					               
								},
								btn4:function(){
									layer.close(win)
								}
							}); 
						});   
}
</script>

       
    	<script>
    		function add_cp(){
    			
					layui.use('layer', function(){
					//	tishi(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
									fixed: false,
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
									$.get(rooturl+'/index.php/Home/Shangji/add_cp',{"id":vstr},
							        		 function(html){
									       		 $(".tihuan").html(html);
									        	$(".layui-table").show();
									        		layer.close(win)
							                   });
									layer.close(win)
								}
							}); 
						});   
    				

    		}
    		function del_check()
			{
				var checked_str='';
				var as_key=0;
				$(".chbox_duoxuan").each(function(){
					if($(this).prop("checked")==true)
					{
						checked_str+=$(this).prop("id")+',';
						as_key++;
						
					}
				});
				//tishi(checked_str)
			if(checked_str=="")
			 	{
			 		tishi("没有选择商机");
						return false;
			 	}
				checked_str=checked_str.substr(0,checked_str.length-1);

				$.get(rooturl+'/index.php/Home/Shangji/del_shangji',{"id":checked_str},
										        		 function(html){
										        				$("#jb_bianji").html(html);
										                   });
			}


			function bianji_kehu1()
			{
				
				var bianji_str='';
				var bianji=new Array();
				var as_key=0;
				$(".chbox_duoxuan").each(function(){
					if($(this).prop("checked")==true)
					{
						bianji_str+=$(this).prop("id")+',';
					
						as_key++;
						$("#num").text(as_key);
							
					}
				});

				if(bianji_str=="")
					{
						tishi("没有选择商机");
						return false
					}
				
					layui.use('layer', function(){
										var layer = layui.layer;
										var win=layer.open({

											type:1,
											offset: 't',
											area:'630px',
												fixed: false,
											title: '批量编辑客户',
											content:$('#bj_kehu'),
											btn:['确认修改','取消'],
											btn1:function(){
												var xgzd=$("#show_yc").val();
												var content=$("#"+xgzd+"wys").val();
											
												var xgzd2=$("#show_yc").children("option[value='"+xgzd+"']").text();//客户名称汉字
												var content2=$("#"+xgzd+"wys").children("option[value='"+content+"']").text();//参数汉字

												$.get(rooturl+'/index.php/Home/Shangji/pl_bianji',{"id":bianji_str,"ziduan":xgzd,"content":content,"xgzd2":xgzd2,"content2":content2},
					        		 				function(html){
					        		 					tishi("批量修改成功")
															$("#jb_bianji").html(html);
															layer.close(win)
													});


											},
											btn2:function(){
												layer.close(win)
											}
										}); 
									});   
			}
			$("#show_yc").change(function(){
				
				var show_va=$(this).val();
				$(".yincang").hide()
				$("#wc"+show_va).show();
			})

		function piliangzhuanyi()
		{
	 	
	 	var piliang_str='';
	 	$(".chbox_duoxuan").each(function(){
	 		if($(this).prop("checked")==true)
	 		{
	 			piliang_str+=$(this).prop("id")+',';
	 		}
	 		
	 	})
	 	if(piliang_str=="")
	 	{
	 		tishi("没有选择客户");
				return false;
	 	}

	 	layui.use('layer', function(){
								var layer = layui.layer;
								var win=layer.open({

									type:1,
									offset: 't',
									area:'630px',
										fixed: false,
									title: '批量转移客户',
									content:$('#piliangzy'),
									btn:['确认转移','取消'],
									btn1:function(){
										var fuzeren=$("#zhuanyifzr").val();
										
														if(fuzeren=='请选择新负责人')
														{
															tishi("请选择负责人");return
														}
										var fuzeren1=$("#zhuanyifzr").children("option[value='"+fuzeren+"']").text();//客户名称汉字
										var shangji_hetong='';//不确定
										//tishi(fuzeren)
										var kh=$('input[name="zy_kh"]:checked').val();
										var ht=$('input[name="zy_ht"]:checked').val();
										$.get(rooturl+'/index.php/Home/Shangji/pl_zhuanyi',{"id":fuzeren,"ziduan":fuzeren1,"sj_id":piliang_str,"kh":kh,"ht":ht},
			        		 				function(html){

			        		 					tishi("批量转移成功")
												 	window.location.href="shangji"			
											});
									},
									btn2:function(){
										layer.close(win)
									}
								}); 
							});   
	 	
	 }
    	</script>
    	<script>
    	var is_one =0;
    	var is_one1 =0;
    	function change_fun(v2)
		 {
		 	if(is_one<3 )
		 	{
		 		is_one++;
		 		return;
		 	}
	
		 		if(v2.prop("id")=="ss1"){
	    			var kh_id= v2.val();
	    			if(kh_id!="tiaozhuan"){
	    			$.get(rooturl+'/index.php/Home/Shangji/lxr_get',{"id":kh_id},
		 				function(html){
										$(".lx_th").html(html);
										layer.close(win)
						});
		    		}else{

		    			
		    				$.get(rooturl+'/index.php/Home/Shangji/kehu_add',{},

			        		 				function(html){
											$(".th_kh").html(html);
												if(is_one1<1){
													is_one1++;
		        		 								$('.xlss2').searchableSelect();
		        		 								
		        		 								return;
		        		 						}
		        		 						
										
											});
    							
					layui.use('layer', function(){

										var layer = layui.layer;
										var win=layer.open({
											type:1,
											offset: 't',
											area:'630px',
											fixed: false,
											title: '新增客户',
											content:$('#add_kh'),
											btn:['确认添加','取消'],
											btn1:function(){
												 $("#kh :input.required1").trigger('blur');
						             				  var numError = $('#kh .onError').length;
						             				
						              				  if(numError){
						              				  	tishi('必填项不能为空')
								                   			 return false;
								              		 	 } 
												var formdom=$("#kh").children("table").find("tr");
												var fornum=formdom.length;
												var ajaxstr='';
												for(a=0;a<fornum;a++)
												{
													var thisdom=formdom.eq(a).find("td").eq(1).children();
													
														
														ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
											
													
												}
												window.ajaxstr_kh=ajaxstr;
												window.name_kh =$("#kh").find("#wyszdy0").val();
												if(name_lxr==''){
													window.name_lxr=$("#kh").find("#ss2").val();
												}
											
											//	alert(name_lxr)
											
										
											
											$.get(rooturl+'/index.php/Home/Shangji/lxr_if',{"id":name_lxr},
			        		 				function(html){
												 $("#sj_zdy1").html("<input type='text' name='zdy1' value='"+name_kh+"' readonly='true'>");
												 if(html=="ok"){
		        		 							 $("#sj_zdy2").html("<select  name='zdy2'><option value='lssj' >"+name_lxr+"</option></select>");
												 }else{
												 	 $("#sj_zdy2").html("<select  name='zdy2'><option value='"+name_lxr+"' >"+html+"</option></select>");
												
												 }
		        		 						});
										
									
											layer.close(win)
										  

											},
											btn2:function(){
												layer.close(win)
												//addshangji()
											}
										}); 
									});  





					    		}
					   
					 		}
					 			if(v2.prop("id")=="ss2")
					 		{
					 	
											$('#kh table :input').blur(function(){
									    	
													var $parent =$(this).parent();
													$parent.find(".formtips").remove();
													if( $(this).is('.required1') ){
														if(this.value=="" || this.value=="add_lxr"){
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
												        });//end blur


					    		
					    			if(v2.val()=="add_lxr"){
					    				$.get(rooturl+'/index.php/Home/Shangji/lianxiren',{},
			        		 				function(html){
			        		 							$(".th_lxr").html(html);
			        		 					$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js");
		
									
											$('#lxr table :input').blur(function(){
									    	
													var $parent =$(this).parent();
													$parent.find(".formtips").remove();
													if( $(this).is('.required1') ){
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
												        });//end blur
												layer.close(win)
											});
					layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
										fixed: false,
								title: '新增联系人',
								content:$('#lxr'),
								btn:['确认添加','取消'],
								btn1:function(){
									 $("#lxr :input.required1").trigger('blur');
			             				  var numErrorxplxr= $('#myform2 .onError').length;
											
										
			              				  if(numErrorxplxr>0){
			              				  	tishi('必填项不能为空')
					                   			 return false;
					              		 	 } 
									var formdom=$("#myform2").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										if(thisdom.prop("name")=='zdy12[]')
										{	//tishi(thisdom.prop("name"))
											ajaxstr+=thisdom.prop("name")+":"+thisdom.eq(0).val()+"-"+thisdom.eq(1).val()+"-"+thisdom.eq(2).val()+",";
										}else{
											if(thisdom.prop("name")=='zdy2')
											{
												ajaxstr+=thisdom.prop("name")+":"+$('input[name="zdy2"]:checked').val()+",";
												
											}else{

												ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
											}
										}
										
									}
								
										window.ajaxstr_lxr=ajaxstr;//alert(ajaxstr)
									window.name_lxr =$("#lxr").find("#lxrzdy0").val();
										//alert(name_lxr)
									$("#zdy15th").html("<input type='text' name='zdy15' value='"+name_lxr+"' readonly='true'>");
											layer.close(win)

								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

					    		
									}					    
											
					 		}
					 		if(v2.prop("id")=="ss3"){

			    			var user_id=v2.val();
			    			//tishi(us
			    			$.get(rooturl+'/index.php/Home/Shangji/get_bm',{"id":user_id},
						        		 				function(html){
			        		 								//tishi(html)
														$(".bm_th").html(html);
															layer.close(win)
														});
			  
					 		}
					 		if(v2.prop("id")=="cp_caozuo"){
					 			
					 				
									var cp_id=v2.val();
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
					    										//	tishi(html)
					    													$(".cp_yj").val(html)
					    													$(".cp_jy").val(html)
					    												$(".cp_zk").val("100.0%")	
					    												$(".cp_num1").val(1)	
					    												$(".cp_zj").val(html)	
					    												

					    													layer.close(win)
					    										}
					    				)
					 		}

		 } 
    		
    		function kh_bmo(bm){
    			var user_id=$(bm).val();
    	//	alert(user_id)
    			$.get(rooturl+'/index.php/Home/Hetong/get_bm',{"id":user_id},
			        		 				function(html){
        		 								//tishi(html)
											$(".khbm_th").html(html);
												layer.close(win)
											});
    		}
    		
    		function cp_aj(a){
    			
    				
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
    			//tishi(yj);
    		}
    		function cp_num(w){
    			var num2 = $(w).val();	
    			var jy = $(".cp_jy").val();	
    			var num1=(num2 * jy);
    			
    			$(".cp_zj").val(num1)		
    		}
    		function kh_name_if(e){
			var a =$(e).val();
			$.get(rooturl+'/index.php/Home/Kehu/kh_name_if',{"id":a},
			        		 				function(html){

        		 							if(html){
												tishi("此客户由"+html+"负责")
												$('#wyszdy0').val('')


        		 							}
											
											});
		}
    		function cp_del(f){
    			var id = $(f).prop('name');
    				$.get(rooturl+'/index.php/Home/Shangji/cp_del',{"id":id},
    										function(html)
    										{
    											if(html==1){
    												$("."+id).hide();
    												layer.close(win)
    											}
    													
    										}
    				)
    		}
    		$("#nchangyong").click(function(){         //控制 、筛选的隐藏与显示
			    if($(this).prop("name")=='0'||$(this).prop("name")==undefined)
			    {
			        $(".ncy").show();
			        $(this).html("<span style='color:#07d;cursor:pointer;'>收起>></span>");
			        $(this).prop("name",'1');
			    }
			    else
			    {
			    	 $(".ncy").hide();
			        $(this).html("<span style='color:#07d;cursor:pointer;'>展开更多信息>></span>");
			        $(this).prop("name",'0');
			    }
			   })
    	
    		$('#add_shangji table :input').blur(function(){
    		
				var $parent =$(this).parent();
				$parent.find(".formtips").remove();
				if( $(this).is('.required') ){
					if(this.value=="" || this.value=="tiaozhuan"){
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
	        });//end blur
				
				
				
			
    		 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 2000, 
			    });
			}
			function add_lx(){     //新增联系人暂时无用

			}
			


	
        function kongzhiyeshu(ss){

		var yeshu=$(ss).val();
		window.yeshu=yeshu;
		window.location.href="shangji?fenye="+yeshu;
	
	}
  $(function() {
    $( document ).tooltip();
  });
   layui.use(['laypage', 'layer'], function(){
		  var laypage = layui.laypage
		  ,layer = layui.layer;
		  
		 var ys=$("#ys").val();
		 var wocao=$("#wocao").val();
		  laypage({
		    cont: 'demo7'
		    ,pages: ys
		    ,curr:wocao
		    ,skip: true,

		    jump: function(obj, first){
		      if(!first){
		      	var fenye=$("#fenye").val();
		      
		      	window.location.href="shangji?dijiye="+obj.curr+"&fenye="+fenye;
		       tishi('第 '+ obj.curr +' 页');

		      }
		  	}
		  });
		});
   		function sousuo(){

			$(".ycyo").hide();
					var name= $("#sousuo").val();
				
					 $.get(rooturl+'/index.php/Home/Shangji/sousuo',{"id":name},
										        		 function(lxrid){

										        		$("#jb_bianji").html(lxrid);
										                  });
				}
					function sousuo1(){
					$(".ycyo").hide();
					var name= "";
					 $("#sousuo").val("");
					 $.get(rooturl+'/index.php/Home/Shangji/sousuo',{"id":name},
										        		 function(lxrid){

										        		$("#jb_bianji").html(lxrid);
												        	
										                  });
				}
				  var isCheckAll = false;  
		        function swapCheck() {  
		            if (isCheckAll) {  
		                $("input[type='checkbox']").each(function() {  
		                    this.checked = false;  
		                });  
		                isCheckAll = false;  
		            } else {  
		                $("input[type='checkbox']").each(function() {  
		                    this.checked = true;  
		                });  
		                isCheckAll = true;  
		            }  
		        } 

    	</script>
</html>