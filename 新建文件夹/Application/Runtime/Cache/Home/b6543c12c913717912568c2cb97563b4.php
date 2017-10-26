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
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/js/bootstrap.js"'" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/dataTables..js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}
.sx_tj_margain{margin-left:12px;}
	#table_local_filter{width:300px;margin-top:-32px; float:right;}
    			#table_local_length{width:100px;}
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
		</style>      
	</head>
	<body style="position:relative">
	<div class="beijing">
		<div class="big">
			<div >
				  <ul>
				    <li class="panel-heading">
				    	<span class="head_title">商机信息</span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addshangji()" >新增商机</button><button onclick="daoru()" style="margin-left:20px">导入商机</button></span>
				    </li>
				  </ul>
			</div>
			       
			<div class="sxdiv">
					<div id="sxhidestr" >筛选条件：
			        	<span class="sx_tj_margain">筛选条件1</span><span  class="sx_tj_margain">筛选条件2</span><span  class="sx_tj_margain">筛选条件3</span><span  class="sx_tj_margain">筛选条件4</span>
			        </div>

				         <div id="sxzddiv" style="display: none;border:1px" >
			              		<div class='sxzddiv' id='kehujibie'>
									<div class='sx_title' >客户范围：</div>
								 	<span class='sx_yes'>全部客户</span>
									<span class='sx_no'>我的客户</span>
									<span class='sx_no'>我下属的客户</span>	
								</div>	
								<div class='sxzddiv' id='kehujibie'>
									<div class='sx_title' >客户范围：</div>
								 	<span class='sx_yes'>全部客户</span>
									<span class='sx_no'>我的客户</span>
									<span class='sx_no'>我下属的客户</span>	
								</div>	
								<div class='sxzddiv' id='kehujibie'>
									<div class='sx_title' >客户范围：</div>
								 	<span class='sx_yes'>全部客户</span>
									<span class='sx_no'>我的客户</span>
									<span class='sx_no'>我下属的客户</span>	
								</div>	
								<div class='sxzddiv' id='kehujibie'>
									<div class='sx_title' >客户范围：</div>
								 	<span class='sx_yes'>全部客户</span>
									<span class='sx_no'>我的客户</span>
									<span class='sx_no'>我下属的客户</span>	
								</div>		
		   				 </div>

		   </div>
		   <div id="sxshowbtn" onselectstart='return false'><i class='fa fa-chevron-down' aria-hidden='true'></i></div>
		   	<div class="anniu">		
					<span style="margin-top:-8px;margin-left:1%"  class="anniudw">
							已选0位客户
					   		<a href="#" onclick="piliangzhuanyi()" >批量转移</a>
					   		<a href="#"  onclick="bianji_kehu1()">批量编辑</a>
					   		<a href="#" onclick="del_check()" >删除所选</a>
					   		<a href="#">转移至客户公海</a>
					</span>
					
				<!--	<div id="bj_kehu" style="margin-top:10px;padding-top:20px;" >
					<form name="pl_bjform" method="post" >
						<table class="pl_bj">
							<tr  style='line-height:70px'>
								<td >选择字段:</td><td><select  style="width:260px;height:26px;" id="show_yc">
												<option>请选择编辑字段</option>
												<?php if(is_array($pl_bj)): foreach($pl_bj as $key=>$pl_bj): ?><option  value="<?php echo ($pl_bj["id"]); ?>"><?php echo ($pl_bj["name"]); ?></option><?php endforeach; endif; ?>
												
											  </select>
												</td>
							</tr>
										<?php echo ($bj_tab); ?>
						</table>
					</form>
					</div>
					<div id="piliangzy" style="margin-top:10px;padding-top:20px;" >
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
					</div>-->
   				</div>

						<div class="kehu">   	
				   			<div class="panel panel-default">
					   			 
								<div class="panel-body" >
										 <table id="table_local" class="table table-bordered table-striped table-hover">
								            <thead>
								                <tr>	
								                		

									                    <th>1</th> <!--客户标题-->
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    <th>1</th>
									                    
									        
								                </tr>
								            </thead>
								                <tbody id="jb_bianji">
															<tr><td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>

															</tr>
															<tr><td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>

															</tr>
															<tr><td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>

															</tr>
															<tr><td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>
															<td>2</td>

															</tr>
								                </tbody>			       
								  			</table>
								</div>
							</div>
						</div>
		</div>
	</div>

	<div id="add_shangji"> <!--新增商机 弹出框-->
					<form name="" method="post" >
						<table class="addshangji_weizhi">
							<tr class="addtr">
								<td>姓名234：</td><td><input type="text" name="" value=" " id=""> </td>			
							</tr>
							<tr class="addtr">
								<td>姓名：</td><td><input type="text" name="" value=" " id=""> </td>			
							</tr >
							<tr  class="addtr">
								<td>姓名3：</td><td><input type="text" name="" value=" " id=""> </td>			
							</tr>
							<tr class="addtr">
								<td>姓名5555566：</td><td><input type="text" name="" value=" " id=""> </td>			
							</tr>
						</table>
					</form>
	</div>
	<div id="daoru" style="margin-top:40px"><!--导入-->
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
	</body>
	<script>
		window.rooturl="<?php echo ($_GET['root_dir']); ?>";
	$("#add_shangji").hide();
	$("#daoru").hide();
	layui.use('upload', function(){
  		layui.upload(options);
		});
	$("#sxshowbtn").click(function(){         //控制 、筛选的隐藏与显示
	    if($(this).prop("name")=='0'||$(this).prop("name")==undefined)
	    {
	    	
	        $("#sxhidestr").hide("fast");
	        $("#sxzddiv").show("fast");
	        $(this).html("<i class='fa fa-chevron-up' aria-hidden='true'></i>");
	        $(this).prop("name",'1');
	    }
	    else
	    {
	        $("#sxzddiv").hide("fast");
	        $("#sxhidestr").show("fast");
	        $(this).html("<i class='fa fa-chevron-down' aria-hidden='true'></i>");
	        $(this).prop("name",'0');
	    }
	});
	window.id='';
	$(".sxzddiv").children("span").click(function(){          //点击筛选的 选中
	    var title=$(this).parent().prop('id');
    $(this).parent().children("span").prop("class","sx_no");
    $(this).prop("class","sx_yes");
    var s=$(this).index();

	id+=title+","+s+"|";
	alert(id);
   //alert(id);
	$.get(rooturl+'/index.php/Home/Kehu/shaixuan',{"id":id},
							        		 function(html){
							        		 	//alert(html)
							        			$("#jb_bianji").html(html);
							        			$('.bianji_hide').hide();
							        			pencil();
							        			blurfun();
							                   });
 
});

	function addshangji(){
	
    	
		layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
								title: '新增商机',
								content:$('#add_shangji'),
								btn:['确认修改','取消'],
								btn1:function(){
									var xgzd=$("#show_yc").val();
									var content=$("#"+xgzd+"wys").val();
								
									var xgzd2=$("#show_yc").children("option[value='"+xgzd+"']").text();//客户名称汉字
									var content2=$("#"+xgzd+"wys").children("option[value='"+content+"']").text();//参数汉字
									//alert(xgzd)
									//alert(content)
									//alert(xgzd2)
									//alert(content2)
									$.get(rooturl+'/index.php/Home/Kehu/pl_bianji',{"id":bianji_str,"ziduan":xgzd,"content":content,"xgzd2":xgzd2,"content2":content2},
		        		 				function(html){
		        		 					alert("批量修改成功")
												location.reload();
										});


								},
								btn2:function(){
									layer.close(win)
									//addshangji()
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
					                alert("上传文件格式仅支持csv");
					            }
					            else
					            {
					           		 alert("文件上传失败");
					            }

					        },
					    });
					
					layui.use('layer', function(){
						alert(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
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
					                	//alert(res)
					                    if(res=='1')
					                    {	
					                    	alert("导入成功")
					                       location.reload();
					                    }
					                    else if(res=='8')
					                    {
					                    	alert("亲~请下载最新模板")
					                    	 return false;
					                    }else
					                    {
					                        alert("导入失败，请刷新后重试");
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
</html>