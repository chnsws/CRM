<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>客户</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

		<link rel="stylesheet" href="css/global.css" media="all">      
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css"><!--图标-->
<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"></script>

		<link href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" rel="stylesheet"  type="text/css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>
		
<!--下面   地区插件-->
	
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">

		<script>window.jQuery || document.write('<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/jquery-1.11.0.min.js"><\/script>')</script>
		<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>

<!--end!!-->
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">

		 <script>
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";

  		</script>

  		
  			<!--UIkit-->
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
		<style>
		body,ul,li,table,tr{margin:0;padding:0;}

		.anniu{line-height:70px;height:70px;border:1px solid #ccc;margin-left:13px;margin-top:20px;} 
		.kehu{width:auto;height:auto;border:1px solid #ccc;margin-left:13px;} 
		tr{line-height:28px}


		</style>
			  <style>
    			
    			 li{overflow:hidden;}

   				#dialog-form label{ float:left; }
   			/** #dialog-form input { float:left; }**/

   				#dialog-form label{ margin-bottom:12px; width:35%;text-align:left;margin-left:18px;padding:.8em;}
   				#sel{width:120px;}
   				 #dialog-form input.text { margin-bottom:12px;  padding: .8em 0em; }
    			
    	
    			#table_local_length{width:100px;}
    			.label-success{ height:28px;line-height:16px;width:60px; text-align: center;font-size:14px; }
    			.shaixuan{margin-left:30px;}
    			.pl_bj{margin:0px auto;}
    			.xzwj_bl{background-color:#1AA094;}
    			#yc_xs{background-color:#FFF;padding-top:10px;padding-bottom:10px;}
    		
			.sxzddiv,span{overflow:hidden;}

			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;margin-left: 10px;}
			.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
			.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
			.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}
			.xinzeng2{float:right;margin-right:2%;}
			.fa-pencil{float:right;}
			.sx_tj_margain{width:auto;margin:5px 5px 5px 15px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;background-color:#1AA094;border-radius:3px;color:#fff;}
			.layui-btn-primary{width:200px;height:30px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;height:30px;}
	
			.addtr td{padding-top:20px;}
			.addshangji_weizhi{margin:0 auto;margin-top:20px;margin-left:20%;}	

			#nchangyong{margin-top:10px;margin-left:15%;}
			.onError{color:red;}
			.onSuccess{color:green;}
			.kongzhiyeshu{margin-top:19px;height:40px;font-size:16px;margin-left:20px;}
			.panel-title{color: #1AA094;font-weight: bold;font-size: 22px;}
			.panel-heading{
				height: 60px;line-height: 60px;border-bottom-style:solid;border-width: 1px;border-color: #E0E0E0;margin-left: 15px;
			}
			.searchable-select-dropdown{z-index:99999990;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;}
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
  			

		<script type="text/javascript">
			$(function(){
				$('.xlss').searchableSelect();
 			});
		window.ajaxstr_lxr='';
		window.lxr_id='';

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
		      
		      	window.location.href="kehu?dijiye="+obj.curr+"&fenye="+fenye;
		       tishi('第 '+ obj.curr +' 页');

		      }
		  	}
		  });
		});


    	</script>
    	

	</head>

	<body style="position:relative">
	
		 <input type="hidden" id="ys" value="<?php echo ($ys); ?>">
		 <input type="hidden" id="fenye" value="<?php echo ($list_num); ?>">
		  <input type="hidden" id="wocao" value="<?php echo ($dijiye); ?>">
		<div id="tabs">
		<div>
			  <ul>
			    <li class="panel-heading" ><span class="panel-title"><b>客户</b></span><span class="xinzeng2"><button  onclick="add_yh()" class=" layui-btn " style="height: 30px;line-height: 30px;"><i class="fa fa-plus" style="margin-right: 5px;"></i>新增用户</button><span><button onclick="daoru()"  class="layui-btn" style="border:1px solid #999; background-color:white;color:#222;margin-left:20px;height: 30px;line-height: 30px;">导入客户</button></span></li>
			    
			  </ul>
		</div>
		
  			<div id="tabs-1">
  			
  					<div id="kh_daoru" style="margin-top:40px;display: none;border:1px">
  						<div class="dr_q" style="width:80%;margin:0px auto";>
  							<li style="height:30px;position: relative; left:-8px;">一、下载导入数据模板 ,将导入的数据填充到导入模板文件中。</li>
  							<li  style="height:40px">注意事项：</li>
  							<li  style="height:40px">1）模板中的表头不可更改，表头行不可删除；</li>
  							<li  style="height:40px">2）除必填的列以外不需要的列可以删除；</li>
  							<li  style="height:40px">3）单次导入的数据不超过4000条</li>
  							<li  style="height:40px;position: relative; left:-8px;">二、选择要导入的数据文件</li>
  							<li  style="height:40px"><input type="file" lay-type="file" class="layui-upload-file" name="csv_up"></li>
  							<li   id="yc_xs" style="display: none;border:1px" ><span id="name_sc" style="margin-left:10px;margin-top:19px;" >名字</span><span   style="margin-left:60px" id="size_sc">大小</span><span style="margin-left:60px"> 完成</span > <span style="margin-left:60px" onclick="yc_file(this)"  id="fileclose">删除</span></li>
  							
  						</div>
  					</div>


		 <div id="sxdiv" >
	            <div id="sxhidestr"  style='display: none;border:1px'>
	          
	            <span class="sx_tj_margain one">全部客户</span>
	            <span class="sx_tj_margain two">全部</span>
	            <span class="sx_tj_margain three" >全部</span>
	            <span class="sx_tj_margain four">全部</span>
	            <span class="sx_tj_margain five">全部</span>
	            <span class="sx_tj_margain six">全部</span>

	        	</div>

	            <div id="sxzddiv"  >
	                <?php echo ($new_html); ?>				
	            </div>

        </div>
        <div id="sxshowbtn" onselectstart='return false'><i class='fa fa-chevron-up' aria-hidden='true'></i></div>
   				<div class="anniu">		
					<span style="margin-left:1%"  class="anniudw">
					   		<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small">
   			 				<i class="layui-icon">&#xe642;</i>批量转移</button>	
						   	<button onclick="bianji_kehu1()"  class="layui-btn layui-btn-primary layui-btn-small">
	   			 			<i class="layui-icon">&#xe642;</i>批量编辑</button>
						   	<button onclick="del_check()"  class="layui-btn layui-btn-primary layui-btn-small">
	   			 			<i class="layui-icon">&#xe640;</i>删除所选</button>
				 			<button onclick="piliangzhuanyi()"  class="layui-btn layui-btn-primary layui-btn-small">
				 			<i class="layui-icon">&#xe642;</i>转移至客户公海</button>	
					</span>
					
						<div id="bj_kehu" style="margin-top:10px;padding-top:20px;display: none;border:1px">
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
						<div id="piliangzy" style="margin-top:10px;padding-top:20px;display: none;border:1px" >
							<form name="pl_bjform" method="post" >
								<table class="pl_bj">
									<tr  style='line-height:70px'>
										<td >新负责人:</td><td><select  style="width:260px;height:26px;" id="zhuanyifzr">
														<option>请选择新负责人</option>
														 <?php if(is_array($fuzeren)): foreach($fuzeren as $key=>$vo): ?><option value="<?php echo ($vo["user_id"]); ?>"><?php echo ($vo["user_name"]); ?></option><?php endforeach; endif; ?>   
														
													  </select>
													 
														</td>
									</tr>
									 <tr style='line-height:70px'><td><input type="checkbox" name="zy_sj" value="ok">同时转移客户下的商机</td></tr>
									 <tr style='line-height:70px'><td><input type="checkbox" name="zy_ht" value="ok">同时转移客户下的合同</td></tr>

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
								
										<table class="layui-table"  width='auto' >
										<div  style="width :100%;" >
									  	<thead>
									  			<tr>	
								                		<th><input type="checkbox" onclick="swapCheck()" /></th>
									                <?php if(is_array($kehu1)): foreach($kehu1 as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?>
								                </tr>
										</thead>
										<tbody id="jb_bianji">
														<?php echo ($table); ?>    <!--客户显示信息-->
							             </tbody>	
							             </div>
									</table>  
									
								
						</div>
				</div>
					<div id="demo7" class="ycyo" style="float:right"></div> 
			</div>
					<div id="dialog-form" style="display: none;border:1px;"> <!--新增弹出框-->
						<form id="ht_form" style="border:1px; method="post" class="uk-form " >
							<table class="addshangji_weizhi " style="border:1px;">
								<?php echo ($show_bt); ?>
								<?php echo ($show_bt1); ?>
								<?php echo ($show_bt2); ?>
								<?php echo ($jw); ?>
							</table>
						</form>
						<div id="nchangyong"  onselectstart='return false'><span style="color:#07d;cursor:pointer;">展开更多信息>></span></div>
					</div>
					<div id="add_lxr" style="display: none;border:1px"> <!--新增lxr 弹出框-->
									<form  name= 'form_lxr' method="post" id="lxr" >
										<table class=" th_lxr addshangji_weizhi uk-form">
											<?php echo ($add_yw); ?>
											
										</table>
									</form>
									
					</div>
							
				
  		</div>

 
	</body>

</html>
<script>

$('#bj_kehu').hide();
$('#yincang_bj').hide();
$('.bianji_hide').hide();
$('.yincang').hide();

layui.use('upload', function(){
  layui.upload(options);
});
    		function blurfun(){
    		
    			$(".bianji").blur(function(){
    				if($(this).val()==$(this).attr("value")){
    				tishi("没有修改信息");
    				$(this).parent().children("input").hide();
					$(this).parent().children("span,i").show();
					return false
    				}else{
    					$.get(rooturl+'/index.php/Home/Kehu/index',{"bianji_id":$(this).attr("id"),"bianji_name":$(this).attr("name"),"bianji_val":$(this).val()},
							        		 function(html){
							        		//tishi(html)
													if(html=='ok'){

														location.reload();
							        		 		}
							                   });

    					
    				}
							        		
    			})
    		}
$(document).ready(blurfun());
	

function del_check()
{
	var checked_str='';
	var asasd=new Array();
	var as_key=0;
	$(".chbox_duoxuan").each(function(){
		if($(this).prop("checked")==true)
		{
			checked_str+=$(this).prop("id")+',';
			asasd[as_key]=$(this).prop("id");
			as_key++;
		}
	});
if(checked_str=="")
 	{
 		tishi("没有选择客户");
			return false;
 	}
	checked_str=checked_str.substr(0,checked_str.length-1);

	$.get(rooturl+'/index.php/Home/Kehu/del_kehu',{"id":checked_str},
							        		 function(html){
							        			tishi('删除成功')
							        			for(a=0;a<asasd.length;a++)
							        			{
												
												$("#tr"+asasd[a]).hide();	
							                   	}
							                   });
}

</script>
<script>
function kongzhiyeshu(ss){

		var yeshu=$(ss).val();
		window.yeshu=yeshu;
		window.location.href="kehu?fenye="+yeshu;
	
	}
  								
function yc_file(thisdom){
	clickdelnowfile='1';
    var thisdelname=$(thisdom).prop("name");
   
    $.get(rooturl+"/index.php/Home/Kehu/del_old_file",{"oldname":"linshi/"+thisdelname});
    $(thisdom).parent().hide();
}
  	
  function kehujibie(thisa){
  	var kehu=$(thisa).prop('id');
  		$.get(rooturl+'/index.php/Home/Kehu/shaixuan',{"kehu":"mykehu"},
							        		 function(html){
							        		 		tishi(html)
							        			$("#jb_bianji").html(html);
							        			$('.bianji_hide').hide();

							        			blurfun();
							        			
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

				
		}
	});

	if(bianji_str=="")
		{
			tishi('没有选择客户')
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
									//tishi(xgzd)
									//tishi(content)
									//tishi(xgzd2)
									//tishi(content2)
									$.get(rooturl+'/index.php/Home/Kehu/pl_bianji',{"id":bianji_str,"ziduan":xgzd,"content":content,"xgzd2":xgzd2,"content2":content2},
		        		 				function(html){
		        		 					tishi("批量修改成功")
												location.reload();
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

</script>
<script>
$('#piliangzy').hide();
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
									//var content=$("#"+xgzd).val();
									
									if(fuzeren=='请选择新负责人')
									{
										tishi("请选择负责人");return
									}
									var fuzeren1=$("#zhuanyifzr").children("option[value='"+fuzeren+"']").text();//客户名称汉字
									//tishi(fuzeren)
									//tishi(fuzeren1)

									var shangji_hetong='';//不确定
 									var sj=$('input[name="zy_sj"]:checked').val();
									var ht=$('input[name="zy_ht"]:checked').val();
								
									//var content2=$("#"+xgzd).children("option[value='"+content+"']").text();//参数汉字

									$.get(rooturl+'/index.php/Home/Kehu/pl_zhuanyi',{"id":fuzeren,"ziduan":fuzeren1,"kh_id":piliang_str,'sj':sj,'ht':ht},
		        		 				function(html){
		        		 				
		        		 					tishi("批量转移成功")
												location.reload();
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
$('#kh_daoru').hide();
$('#yc_xs').hide();
var is_upload='';
	function daoru()
		{
					layui.upload({
					        url: rooturl+"/index.php/Home/kehu/wjsc_dr",
					        title:"选择文件",
					        success: function(res){
					            if(res['res']=='1')
					            {
					            	// tishi( eval (res['newname']));
					            	  $("#name_sc").text(res['oldname']);
						              $("#size_sc").text(res['newsize']);
						              $("#yc_xs").show();
						              $("#fileclose").prop("name",res['newname']);
						              if(is_upload!='')
						               {
						                    $.get(rooturl+"/index.php/Home/Kehu/del_old_file",{"oldname":"linshi/"+is_upload});
						               }
               						 is_upload=res['newname'];
               						// tishi(is_upload)
						  
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
							var layer = layui.layer;
							var win=layer.open({

								type:1,
								offset: 't',
								area:'630px',
								title: '客户导入',
								content:$('#kh_daoru'),
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
		$("#sxshowbtn").click(function(){
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

//筛选的选项
window.id='';
$(".sxzddiv").children("span").click(function(){
		var tex =$(this).text();
	    var title=$(this).parent().prop('id');
    $(this).parent().children("span").prop("class","sx_no");
    $(this).prop("class","sx_yes");
    var s=$(this).index();

	id+=title+","+s+"|";

		if(title=="zdy1")
		{
			$(".two").text(tex);
		}
		if(title=="zdy9")
		{
			$(".three").text(tex);
		}
		if(title=="zdy10")
		{
			$(".four").text(tex);
		}
		if(title=="kehujibie")
		{
			$(".one").text(tex);
		}
		if(title=="zdy11")
		{
			$(".five").text(tex);
		}
		if(title=="zdy12")
		{
			$(".six").text(tex); //23
		}
		$(".ycyo").hide();
	$.get(rooturl+'/index.php/Home/Kehu/shaixuan',{"id":id},
							        		 function(html){
							        		 	//tishi(html)
							        			$("#jb_bianji").html(html);
							        			$('.bianji_hide').hide();
							      
							        			blurfun();
							                   });
 
});
function add_yh()
	{
		layui.use('layer', function(){
				var layer = layui.layer;
				var win=layer.open({
								type:1,
								offset: 't',
								area: ['670px', '560px'],
								fixed: false,
					title: '新增客户',
					content:$('#dialog-form'),
					btn:['确认添加','取消'],
					btn1:function(){
						 $("form :input.required").trigger('blur');
             				  var numError = $('form .onError').length;
              				  if(numError){
              				  	tishi('必填项不能为空')
                   			 return false;
              		 	 } 
									var formdom=$("#ht_form").children("table").find("tr"); 
									var fornum=formdom.length;
									var ajaxstr='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();

										if(thisdom.prop("name")=='zdy6[]')
										{	//tishi(thisdom.prop("name"))
											ajaxstr+=thisdom.prop("name")+":"+thisdom.eq(0).val()+"-"+thisdom.eq(2).val()+","; 
										}else{
											if(thisdom.prop("name")=='zdy2')
											{ 
												
												ajaxstr+=thisdom.prop("name")+":"+thisdom.eq(0).val()+"-"+thisdom.eq(1).val()+"-"+thisdom.eq(2).val()+","; 
												
											}else{
												ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
											}
										}
										
									}
									
									if(ajaxstr_lxr!=''){
										$.get(rooturl+'/index.php/Home/Kehu/lxr_add',{"id":ajaxstr_lxr},
							        		 function(lxrid){
							        		 	window.lxr_id=lxrid;
							        	
										        $.get(rooturl+'/index.php/Home/Kehu/add',{"id":ajaxstr,"id2":lxr_id},
								        		 function(lxrid){
								        		
										        	location.reload();
										        		layer.close(win)
								                  });
							                  });
									
											
									}else{
										$.get(rooturl+'/index.php/Home/Kehu/adda',{"id":ajaxstr},
							        		 function(html){
									        		location.reload();
									        		layer.close(win)
							                   });
									}

									//alert(ajaxstr_lxr);
									
									
								},
					btn2:function(){

						 $(".formtips").remove(); 
						layer.close(win)
					}
				}); 
			});   
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
		        $(this).html("<span style='color:#07d; cursor:pointer;'>展开更多信息>></span>");
		        $(this).prop("name",'0');
		    }
		});
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
   layui.use(['form'], function(){
 
		});
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
         function tishi(neirong)
			{
			    layer.msg(neirong, {
			        time: 1000, 
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
         $(".sx_xl").on("click",function(){
            
           
           var th=$(this).text();
           var th3=$(this).val();
          
           $("#sss").val(th);
            var main_height=$("option").length*0;
          $("#student").css("height",main_height+"px");
            $("#student").attr("size","0");
        
        })
         function add_lxr(ss){
         	var vall=$(ss).val();
         //	alert(vall)
         	
		
		}
		function sousuo(){
			var name= $("#sousuo").val();
		$(".ycyo").hide();
			 $.get(rooturl+'/index.php/Home/Kehu/sousuo',{"id":name},
								        		 function(lxrid){

								        		$("#jb_bianji").html(lxrid);
										        	
								                  });
		}
			function sousuo1(){
				$(".ycyo").hide();
			var name= "";
			 $("#sousuo").val("");
			 $.get(rooturl+'/index.php/Home/Kehu/sousuo',{"id":name},
								        		 function(lxrid){

								        		$("#jb_bianji").html(lxrid);
										        	
								                  });
		}var is_one =0;
		function change_fun(v2){
			
			if(is_one<1 )
		 	{
		 		is_one++;
		 		return;
		 	}
		 	if(v2.val()=="add_lxr")
		 	{
		 						$.get(rooturl+'/index.php/Home/Kehu/lianxiren',{},
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
								content:$('#add_lxr'),
								btn:['确认添加','取消'],
								btn1:function(){
									 $("#lxr :input.required1").trigger('blur');
			             				  var numError = $('#lxr .onError').length;
			             				 // alert(numError)
			              				  if(numError){
			              				  	tishi('必填项不能为空')
					                   			 return false;
					              		 	 } 
									var formdom=$("#lxr").children("table").find("tr");
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
									var name =$("#lxr").find("#zdy0").val();
									$("#zdy15th").html("<select name='zdy15'><option value='linshi'>"+name+"</option></select> ")
								//	$.get(rooturl+'/index.php/Home/Lianxiren/add',{"id":ajaxstr},
							        		// function(html){
									        		// tishi("添加成功")
									        	//	$("#jb_bianji").html(html);
									        		layer.close(win)
							                 //  });

								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 
						});  

		 	}
		
		 		//if(v2.prop("id")=="ss1"){
	    		//	var kh_id= v2.val();
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
		   function checkp(x,y) {  
		    	
		      if (y.length == x.maxLength) {  
		      
		      $(".jiaodian")[0].focus()
		       }
   		 }  
	</script>