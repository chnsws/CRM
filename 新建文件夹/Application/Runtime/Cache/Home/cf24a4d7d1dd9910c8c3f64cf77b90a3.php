<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>合同信息</title>
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
		<!--UIkit-->
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}
			.sx_tj_margain{margin-left:12px;}
			#table_local_filter{width:300px; float:right;}
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
			#nchangyong{margin-top:10px;margin-left:19%;}
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
			.top_del{margin-top:10px;}
			.pl_bj{margin:0px auto;}
			.onError{color:red;}
			.onSuccess{color:green;}
		</style>      
	</head>
	<body style="position:relative">
	<div class="beijing">
		<div class="big">
			<div >
				  <ul>
				    <li class="panel-heading">
				    	<span class="head_title">客户信息</span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addhetong()" class="layui-btn layui-btn-small" >新增合同</button><button onclick="daoru()" style="margin-left:20px" class="layui-btn layui-btn-small">导入商机</button></span>
				    </li>
				  </ul>
			</div>
			       
			<div class="sxdiv">
			<div id='sxhidestr' style=';display: none;border:1px '>
       		<div class='sx_tj_margain'><span class='one sx_yes' style="margin-left:20px">全部合同</span><span class='two sx_yes'  style="margin-left:20px">全部</span><span class='three sx_yes'  style="margin-left:20px">全部</span><span class='four sx_yes'  style="margin-left:20px">全部</span></div>
      		 </div>
		         <div id="sxzddiv"  >
	              		<?php echo ($peizhi); ?>
   				 </div>

		   </div>
		   <div id="sxshowbtn" onselectstart='return false'><i class='fa fa-chevron-up' aria-hidden='true'></i></div>
		   	<div class="anniu">		
					<span style="margin-left:1%;"  class="anniudw">
					   	<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small top_del">
   			 			<i class="layui-icon">&#xe642;</i>批量转移</button>	
					   	<button onclick="bianji_ht()"  class="layui-btn layui-btn-primary layui-btn-small top_del">
   			 			<i class="layui-icon">&#xe642;</i>批量编辑</button>
					   	<button onclick="del_check()"  class="layui-btn layui-btn-primary layui-btn-small top_del">
   			 			<i class="layui-icon">&#xe642;</i>删除所选</button>
   			 			<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small top_del">
   			 			<i class="layui-icon">&#xe642;</i>转移至客户公海</button>	
					</span>
					
				
					<div id="piliangzy" style="margin-top:10px;padding-top:20px;display: none;border:1px ">
					<form name="pl_bjform" method="post" >
						<table class="pl_bj">
							<tr  style='line-height:70px'>
								<td >新负责人:</td><td><select  style="width:260px;height:26px;" id="zhuanyifzr">
												<option>请选择新负责人</option>
												 <?php if(is_array($fuzeren)): foreach($fuzeren as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></option><?php endforeach; endif; ?>   
											  </select>
												</td>
							</tr>
							

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
								                	<?php if(is_array($ywzd)): foreach($ywzd as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?>
									        
								                </tr>
								            </thead>
								                <tbody id="jb_bianji" style="display:none;">
														<?php echo ($a); ?>
								                </tbody>			       
								  			</table>
								</div>
							</div>
						</div>
		</div>
	</div>

	<div id="add_shangji" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form id="ht_form" method="post" class="uk-form" >
						<table class="addshangji_weizhi ">
						
								<?php echo ($show_bt); ?>

								<?php echo ($show_bt1); ?>
								<?php echo ($show_ncy); ?>
								<?php echo ($jw); ?>
							
												
						</table>
					</form>
					<div id="nchangyong" onselectstart='return false'><span style="color:blue">展开更多信息>></span></div>
	</div>
  <div id="bj_kehu" style="margin-top:10px;padding-top:20px;display: none;border:1px"">
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
						</table>
					</form>
  	</div>
  	<div id="hkjh" style="display: none;border:1px">
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
						</table>
					</form>
  	</div>
	</body>
	<script>

layui.use('upload', function(){
  layui.upload(options);
});
    
		window.rooturl="<?php echo ($_GET['root_dir']); ?>";
	$("#add_shangji").hide();
	$(".yc_xs").hide();
	
$(".yincang").hide()
	$("#daoru").hide();
	
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
	        $("#sxhidestr").hide("fast");
	        $("#sxzddiv").show("fast");
	        $(this).html("<i class='fa fa-chevron-up aria-hidden='true'></i>");
	        $(this).prop("name",'0');
	    }
	});

	window.id='';
	$(".sxzddiv").children("span").click(function(){          //点击筛选的 选中
		var tex =$(this).text();
	    var title=$(this).parent().prop('id');
    $(this).parent().children("span").prop("class","sx_no");
    $(this).prop("class","sx_yes");
    var s=$(this).index();

	id+=title+","+s+"|";
//	tishi(id);
	if(title=="zdy7")
	{
		$(".two").text(tex);
	}
	if(title=="zdy10")
	{
		$(".three").text(tex);
	}
	if(title=="zdy11")
	{
		$(".four").text(tex);
	}
	if(title=="kehujibie")
	{
		$(".one").text(tex);
	}

	$.get(rooturl+'/index.php/Home/Hetong/shaixuan',{"id":id},
							        		 function(html){
							        		 	
							        			$("#jb_bianji").html(html);
							        	
							        			blurfun();
							                   });
 
});

	function addhetong(){
		
					layui.upload({
					        url: rooturl+"/index.php/Home/Hetong/wjsc_dr",
					        title:"选择文件",
					        success: function(res){
					            if(res['res']=='1')
					            {
					            	$.get(rooturl+'/index.php/Home/Hetong/sql_fj',{},
							        		 function(html){
							        		 	$(".fj_th").html(html);
							        		 		$(".yc_xs").show();
									        		
							                 });
					            	
						  
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
    	$(".ncy").hide();
		layui.use('layer', function(){
							
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
							//	area:'630px',
								area: ['630px', '700px'],
								title: '新增合同',
								content:$('#add_shangji'),
								btn:['确认添加','取消'],
								btn1:function(){
								 $("form :input.required").trigger('blur');
             							 var numError = $('form .onError').length;
		              				  if(numError){
		              				  	 tishi('必填项不能为空')
		                   				 return false;
              		 				 }  /**nnn**/
									var formdom=$("#ht_form").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
									}
									var vstr=ajaxstr.substr(0,ajaxstr.length-1);
									
									$.get(rooturl+'/index.php/Home/Hetong/add_ht',{"id":vstr},
							        		 function(html){
							        		 		tishi("添加成功")
							        		 	$("#jb_bianji").html(html);
							        		 		 	$(".cp").hide();
									        		$(".yc_xs").hide();
									        		  $("#nchangyong").html("<span style='color:blue'>展开更多信息>></span>");
	     											   $("#nchangyong").prop("name",'0');
									        		layer.close(win)
							                 });
								},
								btn2:function(){
									$.get(rooturl+'/index.php/Home/Hetong/del_all',{},
							        		 function(html){
									        	   	$(".cp").hide();
									        		$(".yc_xs").hide();
									        		layer.close(win)
							                   });
									layer.close(win)
									//addshangji()
								},
								cancel:function(index,layero){
									
										$.get(rooturl+'/index.php/Home/Hetong/del_all',{},
							        		 function(html){
									        	     	$(".cp").hide();
									        	     	$(".yc_xs").hide();
									        		
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
					
					layui.use('layer', function(){
					
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
$("#nchangyong").click(function(){      
		
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
	});
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
            $("#jb_bianji").show();
        });

    	</script>
    	<script>
    		function get_sj(sj){
    				var kh_id= $(sj).val();
    			$.get(rooturl+'/index.php/Home/Hetong/get_sj',{"id":kh_id},
			        		 				function(html){
        		 								//tishi(html)
												$(".th_sj").html(html);
												layer.close(win)
											});
    		}
    		function get_bm(bm){
    			var user_id=$(bm).val();
    			$.get(rooturl+'/index.php/Home/Hetong/get_bm',{"id":user_id},
			        		 				function(html){
        		 								//tishi(html)
											$(".bm_th").html(html);
												layer.close(win)
											});
    		}
    	</script>
    		<script>
    		function del_check(){
    			var checked_str='';
    			var as_key=0;

    			$(".chbox_duoxuan").each(function(){
    				if($(this).prop("checked")==true)
    				{
    					checked_str+=$(this).prop("id")+',';
    					as_key++;
    				}
    			})
    			//tishi(checked_str)
    			if(checked_str=="")
    			{
    				tishi("没有选择合同");
    				return flase;
    			}
    			checked_str=checked_str.substr(0,checked_str.length-1);
    			$.get(rooturl+'/index.php/Home/Hetong/del',{"id":checked_str},
		        		 function(html){
		        		 		tishi("删除成功")
		        				$("#jb_bianji").html(html);
		                   });

    		}
    		function bianji_ht()
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
				//tishi(bianji_str)
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
											title: '批量编辑客户',
											content:$('#bj_kehu'),
											btn:['确认修改','取消'],
											btn1:function(){
												var xgzd=$("#show_yc").val();
												var content=$("#"+xgzd+"wys").val();
											
												var xgzd2=$("#show_yc").children("option[value='"+xgzd+"']").text();//客户名称汉字
												var content2=$("#"+xgzd+"wys").children("option[value='"+content+"']").text();//参数汉字

												//tishi(xgzd);
											//	tishi(content);
												$.get(rooturl+'/index.php/Home/Hetong/pl_bianji',{"id":bianji_str,"ziduan":xgzd,"content":content,"xgzd2":xgzd2,"content2":content2},
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
													title: '批量转移客户',
													content:$('#piliangzy'),
													btn:['确认转移','取消'],
													btn1:function(){
														var fuzeren=$("#zhuanyifzr").val();
														var fuzeren1=$("#zhuanyifzr").children("option[value='"+fuzeren+"']").text();//客户名称汉字
														var shangji_hetong='';//不确定
														//tishi(fuzeren)

														$.get(rooturl+'/index.php/Home/Hetong/pl_zhuanyi',{"id":fuzeren,"ziduan":fuzeren1,"ht_id":piliang_str},
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
    		function cp_add(){
    				layui.use('layer', function(){
					//	tishi(123)
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
									$.get(rooturl+'/index.php/Home/Hetong/add_cp',{"id":vstr},
							        		 function(html){
									       		 $(".tihuan").html(html);
									        	$(".cp").show();
									        		layer.close(win)
							                   });
									layer.close(win)
								}
							}); 
						});   
    				
    		}
    			function hkjh(){
    				layui.use('layer', function(){
					//	tishi(123)
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'750px',
								title: '添加产品',
								content:$('#hkjh'),
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
									$.get(rooturl+'/index.php/Home/Hetong/add_cp',{"id":vstr},
							        		 function(html){
									       		 $(".tihuan").html(html);
									        	$(".cp").show();
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
    		function fj_del(a){
    		var id = $(a).prop('name');

    				$.get(rooturl+'/index.php/Home/Hetong/fujiandel',{"id":id},
    										function(html)
    										{
    											if(html==1){
    												$("."+id).hide();
    												layer.close(win)
    											}
    													
    										}
    				)
    			}
    	</script>
    	<script>

		$('form table :input').blur(function(){
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

			
		
         function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}

    	</script>
</html>