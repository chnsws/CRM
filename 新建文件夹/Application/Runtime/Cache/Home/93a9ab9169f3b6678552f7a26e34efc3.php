<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>联系人</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css"><!--图标-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>

  		<link href="<?php echo ($_GET['public_dir']); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/jquery.dataTables.min.js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/js/bootstrap.js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/dataTables.js" ></script>

		<link href="<?php echo ($_GET['public_dir']); ?>/dataTable/css/dataTables.bootstrap.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/dataTable/js/dataTables.bootstrap.js" ></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">


		<!--下面   地区插件-->
	
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">

		<script>window.jQuery || document.write('<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/jquery-1.11.0.min.js"><\/script>')</script>
		<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
<!--end!!-->
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}

			.big{width:99%;height:100%;margin: 0px auto;}
			.xinzeng{float:right;} /* 新增 导入*/
			div,span{overflow:hidden;}
			#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
			.sx_title{float:left;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
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
			.addtr td select{width:300px;}
			.addtr td input{width:300px;}	.anniudw{  position: relative;top: 14px;}	span a{margin-left:20px;}
			#nchangyong{margin-top:10px;margin-left:15%;}
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
				    	<span class="head_title">联系人信息</span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addshangji()" class=" layui-btn layui-btn-small" >新增联系人</button><button onclick="daoru()" style="margin-left:20px" class=" layui-btn layui-btn-small">导入联系人</button></span>
				    </li>
				  </ul>
			</div>
			       
			<div class="sxdiv">
					

				         <div id="sxzddiv"  >
			              		<div class='sxzddiv' id='kehujibie'>
								 	<span class='sx_yes'>全部联系人</span>
									<span class='sx_no'>我的联系人</span>
									<span class='sx_no'>我下属的联系人</span>	
								</div>	
								
		   				 </div>

		   </div>
		   <div id="sxshowbtn" onselectstart='return false'><i class='fa fa-chevron-down' aria-hidden='true'></i></div>
		   	<div class="anniu">		
					<span style="margin-top:-8px;margin-left:1%"  class="anniudw">
					   		 <button onclick="del_check()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 			<i class="layui-icon">&#xe642;</i>删除所选
  					</button>
					</span>
   				</div>

						<div class="kehu">   	
				   			<div class="panel panel-default">
					   			 
								<div class="panel-body" >
										 <table id="table_local" class="table table-bordered table-striped table-hover">
								            <thead>
								                <tr>
								              		  <th>ID</th> <!--客户标题-->
								                <?php if(is_array($lx_biaoti)): foreach($lx_biaoti as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?>
								                </tr>
								            </thead>
								                <tbody id="jb_bianji">
														<?php echo ($show_bt); ?>

								                </tbody>			       
								  			</table>
								</div>
							</div>
						</div>
		</div>
	</div>

	<div id="add_shangji" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form name="" method="post" id="myform" >
						<table class="addshangji_weizhi uk-form">
							<?php echo ($add_yw); ?>
							<?php echo ($add_yw1); ?>
							<?php echo ($add_yw2); ?>
						</table>
					</form>
					<div id="nchangyong"  onselectstart='return false'><span style="color:blue">展开更多信息>></span></div>
	</div>
	<div id="add_kh" style="display: none;border:1px"> <!--新增lxr 弹出框-->
								<form  name= 'form_kh' method="post" id="kh" >
									<table class=" th_kh addshangji_weizhi uk-form">
										
										
									</table>
								</form>
								
				</div>
	<div id="daoru" style="margin-top:40px;display: none;border:1px"><!--导入-->
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
	window.ajaxstr_kh='';
		window.rooturl="<?php echo ($_GET['root_dir']); ?>";
	$("#add_shangji").hide();
	$(".ncy").hide();
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
	//tishi(id);
   //tishi(id);
	$.get(rooturl+'/index.php/Home/Lianxiren/shaixuan',{"id":id},
							        		 function(html){
							        		 
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
								fixed: false,
								title: '新增联系人',
								content:$('#add_shangji'),
								btn:['确认添加','取消'],
								btn1:function(){
									 $("form :input.required").trigger('blur');
			             				  var numError = $('form .onError').length;
			              				  if(numError){
			              				  	tishi('必填项不能为空')
					                   			 return false;
					              		 	 } 
									var formdom=$("#myform").children("table").find("tr");
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
									if(ajaxstr_kh=='')
									{
										$.get(rooturl+'/index.php/Home/Lianxiren/add',{"id":ajaxstr},
								        		 function(html){
										        		 tishi("添加成功")
										        		$("#jb_bianji").html(html);
										        		layer.close(win)
								                   });
									}else{
										$.get(rooturl+'/index.php/Home/Lianxiren/add_kh',{"id":ajaxstr_kh},
								        		 function(khid){
								        		 	window.kh_id=khid;
								        		 	$.get(rooturl+'/index.php/Home/Lianxiren/adda',{"id":ajaxstr,"id2":kh_id},
										        		 function(html){
												        		 tishi("添加成功")
												        		$("#jb_bianji").html(html);
												        		layer.close(win)
										                   });
								                   });
									}
								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

	}
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
						//tishi(123)
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
    		//	tishi(checked_str)
    			if(checked_str=="")
    			{
    				tishi("没有选择商机");
    				return flase;
    			}
    			checked_str=checked_str.substr(0,checked_str.length-1);
    			$.get(rooturl+'/index.php/Home/Lianxiren/del',{"id":checked_str},
		        		 function(html){
		        		 	tishi("删除成功");
		        				$("#jb_bianji").html(html);
		                   });

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
		});
		  function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
			    });
			}
			    function kh_add(){
	$.get(rooturl+'/index.php/Home/lianxiren/kehu_add',{},
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
	function get_bm(bm){
    			var user_id=$(bm).val();
    		//	tishi(user_id)ddddddd
    			$.get(rooturl+'/index.php/Home/Hetong/get_bm',{"id":user_id},
			        		 				function(html){
        		 								//tishi(html)
											$(".bm_th").html(html);
												layer.close(win)
											});
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
    	</script>
</html>