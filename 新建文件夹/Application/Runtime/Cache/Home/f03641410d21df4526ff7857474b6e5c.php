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

		<link href="<?php echo ($_GET['public_dir']); ?>/dataTable/css/dataTables.bootstrap.css" rel="stylesheet">
  		<link href="<?php echo ($_GET['public_dir']); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/jquery.dataTables.min.js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/js/bootstrap.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/dataTables.bootstrap.js" ></script>

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
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}

			.big{width:99%;height:100%;margin: 0px auto;}
			.xinzeng{float:right;} /* 新增 导入*/
			div,span{overflow:hidden;}
			#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
			.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
			.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
			.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}

			.fa-pencil{float:right;}
			.sx_tj_margain{margin-left:12px;}
	

    			#table_local_length{width:100px;}
    			.label-success{ height:28px;line-height:16px;width:60px; text-align: center;font-size:14px; }
#table_local_filter label{width:300px;}
			div,span{overflow:hidden;}
			#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
			.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
			.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
			.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}
			.xinzeng2{float:right;}
			.fa-pencil{float:right;}
			.sx_tj_margain{margin-left:12px;}
			.anniu{width:auto;height:50px;border:1px solid #ccc;margin-left:-17px;} 
			.head_title{margin-left:-16px;font-size:20px;}
			.addshangji_weizhi{margin:0px auto;margin-top:20px;}
			.addtr{line-height:25px;}
			.addtr td{padding-top:20px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;}
			.anniudw{  position: relative;top: 14px;}
			span a{margin-left:20px;}
			.pl_bj{margin:0px auto;}
			#nchangyong{margin-top:10px;margin-left:19%;}
			#nnchangyong{margin-top:10px;margin-left:19%;}
			.onError{color:red;}
			.onSuccess{color:green;}

		</style>   
		  <script>
  $(function() {
    $( document ).tooltip();
  });
  </script>
  <style>
  label {
    display: inline-block;
    width: 5em;
  }
  </style>   
	</head>
	<body style="position:relative">
	<div class="beijing">
		<div class="big">
			<div >
				  <ul>
				    <li class="panel-heading">
				    	<span class="head_title">商机信息</span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addshangji()" class="layui-btn layui-btn-small" >新增商机</button><button onclick="daoru()" style="margin-left:20px" class="layui-btn layui-btn-small">导入商机</button></span>
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

						<div class="kehu">   	
				   			<div class="panel panel-default">
					   			 
								<div class="panel-body" >
										 <table id="table_local" class="table table-bordered table-striped table-hover">
								            <thead>
								                <tr>	
								                		<th>ID</th>
								                <?php if(is_array($biaoti)): foreach($biaoti as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?> 
									        
								                </tr>
								            </thead>
								                <tbody id="jb_bianji">
														<?php echo ($show); ?>
								                </tbody>			       
								  			</table>
								</div>
							</div>
						</div>
		</div>
	</div>
	<div id="lxr" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form name="" method="post" id="myform2" >
						<table class="th_lxr addshangji_weizhi uk-form">
							<?php echo ($add_yw); ?>
							<?php echo ($add_yw1); ?>
							<?php echo ($add_yw2); ?>
						</table>
					</form>
					<div id="nnchangyong"  onselectstart='return false'><span style="color:blue">展开更多信息>></span></div>
	</div>
<div id="results"></div>
	<div id="add_shangji" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form name="" id="myform" method="post" class="uk-form"  >
						<table class="addshangji_weizhi">
							<?php echo ($add); ?>
							<?php echo ($add1); ?>
							<?php echo ($add2); ?>
						<tr  class="addtr">
								<td><span style="color:red">*</span>负责人：</td>
								 <td>
								 	<select name="fuzeren" onchange='get_bm(this)' class ="clk_fzr required" style='width:300px;height:30px;'>
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
					<div id="nchangyong" onselectstart='return false'><span style="color:blue">展开更多信息>></span></div>
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
							 <tr style='line-height:70px'><td><input type="checkbox" name="ched" value="1">同时转移客户下的商机</td></tr>
											  <tr style='line-height:70px'><td><input type="checkbox" name="ched" value="2">同时转移客户下的合同</td></tr>

						</table>
					</form>

					</div>
<div id="add_kh" style="display: none;border:1px"> <!--新增客户-->
								<form  name= 'form_kh' method="post" id="kh" >
									<table class=" th_kh addshangji_weizhi uk-form">
										
										
									</table>
								</form>
								
				</div>
	</body>
	<script>
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
             							 var numError = $('form .onError').length;
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
									//tishi(ajaxstr)
									$.get(rooturl+'/index.php/Home/Shangji/add',{"id":ajaxstr},
							        		 function(html){
									        	//tishi(html)dd
									        		$("#jb_bianji").html(html);
									        			$(".layui-table").hide();
									        		layer.close(win)
							                   });
								},
								btn2:function(){
									$.get(rooturl+'/index.php/Home/Shangji/del_all',{},
							        		 function(html){
									        	   	$(".layui-table").hide();
									        		
									        		layer.close(win)
							                   });
									layer.close(win)
									//addshangji()
								},
								cancel:function(index,layero){
									
										$.get(rooturl+'/index.php/Home/Shangji/del_all',{},
							        		 function(html){
									        	   	$(".layui-table").hide();
									        		
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
<script type="text/javascript">
        $(function () {
            $("#table_local").dataTable({
                //lengthMenu: [5, 10, 20, 30],//这里也可以设置分页，但是不能设置具体内容，只能是一维或二维数组的方式，所以推荐下面language里面的写法。
                //"
                "sScrollX": "100%",
				"sScrollXInner": "250%",
				"bScrollCollapse": true,
                paging: true,//分页
                ordering: true,//是否启用排序
                searching: true,//搜索
                language: {
                    lengthMenu: '<select class="form-control input-xsmall">' + '<option value="1">1</option>' + '<option value="10">10</option>' + '<option value="20">20</option>' + '<option value="30">30</option>' + '<option value="40">40</option>' + '<option value="50">50</option>' +'<option value="5">5</option>' + '</select>条记录',//左上角的分页大小显示。
                    search: '<span class="label label-success">搜索：</span>',//右上角的搜索文本，可以写html标签

                    paginate: {
                        previous: "上一页",
                        next: "下一页",
                        first: "第一页",
                        last: "最后"
                    },

                    zeroRecords: "没有内容",//table tbody内容为空时，tbody的内容。
                    //下面三者构成了总体的左下角的内容。
                    info: "总共_PAGES_ 页，显示第_START_ 到第 _END_ ，筛选之后得到 _TOTAL_ 条，初始_MAX_ 条 ",//左下角的信息显示，大写的词为关键字。
                    infoEmpty: "0条记录",//筛选为空时左下角的显示。
                    infoFiltered: ""//筛选之后的左下角筛选提示，
                },
                paging: true,
                pagingType: "full_numbers",//分页样式的类型

            });
            $("#table_local_filter input[type=search]").css({ width: "auto" });//右上角的默认搜索文本框，不写这个就超出去了。
        });

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
										var fuzeren1=$("#zhuanyifzr").children("option[value='"+fuzeren+"']").text();//客户名称汉字
										var shangji_hetong='';//不确定
										//tishi(fuzeren)

										$.get(rooturl+'/index.php/Home/Shangji/pl_zhuanyi',{"id":fuzeren,"ziduan":fuzeren1,"sj_id":piliang_str},
			        		 				function(html){
			        		 					tishi("批量转移成功")
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
    	</script>
    	<script>
    		function get_lx(e){
    			var kh_id= $(e).val();
    			$.get(rooturl+'/index.php/Home/Shangji/lxr_get',{"id":kh_id},
			        		 				function(html){
			        		 	
															$(".lx_th").html(html);
															layer.close(win)
											});
    		}
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
			        $(this).html("<span style='color:blue'>收起>></span>");
			        $(this).prop("name",'1');
			    }
			    else
			    {
			    	 $(".ncy").hide();
			        $(this).html("<span style='color:blue'>展开更多信息>></span>");
			        $(this).prop("name",'0');
			    }
			   })
    		$("#nnchangyong").click(function(){         //控制 、筛选的隐藏与显示
			    if($(this).prop("name")=='0'||$(this).prop("name")==undefined)
			    {
			        $(".nncy").show();
			        $(this).html("<span style='color:blue'>收起>></span>");
			        $(this).prop("name",'1');
			    }
			    else
			    {
			    	 $(".nncy").hide();
			        $(this).html("<span style='color:blue'>展开更多信息>></span>");
			        $(this).prop("name",'0');
			    }
			   })
    		$('#add_shangji table :input').blur(function(){
    		
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
	        });//end blur
				
				
				
			function get_bm(bm){
    			var user_id=$(bm).val();
    			//tishi(us
    			$.get(rooturl+'/index.php/Home/Shangji/get_bm',{"id":user_id},
			        		 				function(html){
        		 								//tishi(html)
											$(".bm_th").html(html);
												layer.close(win)
											});
    		}
    		 function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 2000, 
			    });
			}
			function add_lx(){
				$.get(rooturl+'/index.php/Home/Shangji/lianxiren',{},
			        		 				function(html){
			        		 					$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js");
		
											$(".th_lxr").html(html);
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
			             				  var numErrorxp= $('form .onError').length;
											
										
			              				  if(numErrorxp>0){
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
											
											ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
									}
									//tishi(ajaxstr)
									$.get(rooturl+'/index.php/Home/Lianxiren/add',{"id":ajaxstr},
							        		 function(html){
							        		 	var kh_id= $(".lxr_ajax").val();

									    			$.get(rooturl+'/index.php/Home/Shangji/lxr_get',{"id":kh_id},
												        		 				function(html){
																						$(".lx_th").html(html);
																						 tishi("添加成功")
																						layer.close(win)
																				});
									        		
									        	
							                   });

								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

			}
					    function kh_add(){
	$.get(rooturl+'/index.php/Home/Shangji/kehu_add',{},
			        		 				function(html){
			        		 					$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js");
		        		 						$.getScript("<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js");
											$(".th_kh").html(html);
											$('#kh table :input').blur(function(){
									    	
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
										if(thisdom.prop("name")=='zdy12[]')
										{	//tishi(thisdom.prop("name"))
											ajaxstr+=thisdom.prop("name")+":"+thisdom.eq(0).val()+"-"+thisdom.eq(1).val()+"-"+thisdom.eq(2).val()+",";
										}else{
											
											ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
									}
									window.ajaxstr_kh=ajaxstr;
									var name =$("#kh").find("#wyszdy0").val();
								
									 $(".kh_ls").html("<option value='001' selected='selected'>"+name+"</option>");
								
									        		layer.close(win)
							  

								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

	}
	 $("#sss").on("click",function(){
            var main_height=$("option").length*1;
            $("#student").css("height",main_height+"px");
            $("#student").attr("size","20");
        })

        $("#sss").on("keyup",function(){
            //$("option")rrrr
            var in_text=$("#sss").val();
            if(in_text=='')
            {
                $("option").show();
                return;
            }
            var main_height=$("option").length*1;
            $("#student").css("height",main_height+"px");
            $("#student").attr("size","20");
            
            $("option").each(function(){
            	 $("#tshi").show();
                if($(this).text().search(in_text)>=0)
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
                
            });

        });
    	</script>
</html>