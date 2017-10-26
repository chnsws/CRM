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
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
		<!--UIkit-->
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
		<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"></script>

		<link href="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.css" rel="stylesheet"  type="text/css">
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/searchable/jquery.searchableSelect.js"></script>
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
		<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">
		<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	    <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>
		<style>

			body,ul,li,table,tr{margin:0;padding:0;}
			.sx_tj_margain{margin-left:12px;}
			#table_local_filter{width:300px; float:right;}
    		#table_local_length{width:100px;}
			.big{width:99%;height:100%;margin: 0px auto;}
			.xinzeng{float:right;margin-right:20px} /* 新增 导入*/
			.sxzddiv,span{overflow:hidden;}
			#sxdiv{background-color:#fff;margin:10px 10px 0px 10px;padding:10px 5px 10px 5px;}
			#sxshowbtn{background-color:#fff;width:40px;text-align:center;margin:0 auto;cursor:pointer;}
			.sxzddiv{width:100%;height:auto;word-break: break-all;word-wrap: break-word;}
			.sx_title{float:left;width:80px;height:25px;margin:5px 5px 5px 5px;line-height:25px;}
			.sx_yes,.sx_no{width:auto;margin:5px 5px 5px 5px;cursor:pointer;padding:0 5px 0 5px;float:left;height:25px;line-height:25px;}
			.sx_yes{background-color:#1AA094;border-radius:3px;color:#fff;}
			.fa-pencil{float:right;}
			.sx_tj_margain{margin-left:12px;}
			.sxzddiv,span{overflow:hidden;}
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
			
		.anniu{line-height:70px;height:70px;border:1px solid #ccc;margin-top:20px;} 
			.head_title{font-size:20px;}
			.addshangji_weizhi{margin:0px auto;margin-top:20px;margin-left:80px;}
			.addtr{line-height:25px;}
			.addtr td{padding-top:20px;}
			.addtr td input{width:300px;}
			.addtr td select{width:300px;}
	
			.pl_bj{margin:0px auto;}
			.onError{color:red;}
			.onSuccess{color:green;}
			.kongzhiyeshu{margin-top:19px;height:40px;font-size:16px;margin-left:20px;}
			th{background-color:#50BBB1;height:30px;color:white;border:0px !important;} 
			.panel-title{color: #1AA094;font-weight: bold;font-size: 22px;}
			.panel-heading{
				height: 60px;line-height: 60px;border-bottom-style:solid;border-width: 1px;border-color: #E0E0E0;margin-left: 5px;
			}
			.searchable-select-input{width:280px !important ;}
			.searchable-select {min-width:300px;}
			.bhyuany1{margin-top:4%;margin-left:35%;}
			a{ text-decoration:none !important; }
			.fujian1{margin :0 auto;margin-top:15px;}
			.chanpin1{width:90%;margin :0 auto;margin-top:15px;}
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
			
		window.ajaxstr_lxr='';
		window.lxr_id='';
		window.ajaxstr_kh='';
		window.ajaxstr_sj='';
		window.name_lxr='';
	      layui.use(['laypage', 'layer'], function(){
		  var laypage = layui.laypage
		  ,layer = layui.layer;
		  
		 var ys=$("#ys").val();
	

		 var wocao=$("#wocao").val();
		 
		  laypage({
		    cont: 'demo7'
		    ,pages:ys
		    ,curr:wocao
		    ,skip: true,

		    jump: function(obj, first){
		      if(!first){
		      	var fenye=$("#fenye").val();
		      
		      	window.location.href="hetong?dijiye="+obj.curr+"&fenye="+fenye;
		       tishi('第 '+ obj.curr +' 页');

		      }
		  	}
		  });
		});
$(function(){

		$('#xl1').searchableSelect();
 $('#xl2').searchableSelect();

 });


    	</script>    
	</head>
	<body style="position:relative">
	
	<div class="beijing">
	<input type="hidden" id="zhuangtai" value="<?php echo ($zhuangtai); ?>">
	<input type="hidden" id="ys" value="<?php echo ($ys); ?>">
	<input type="hidden" id="fenye" value="<?php echo ($list_num); ?>">
	 <input type="hidden" id="wocao" value="<?php echo ($dijiye); ?>">
		<div class="big">
			<div >
				  <ul>
				    <li class="panel-heading">
				    	<span class="panel-title"><b>合同</b></span>
				    	<span class="xinzeng"><button  id="create-sahngji" onclick="addhetong()" class="layui-btn" style="height: 30px;line-height: 30px;"><i class="fa fa-plus" style="margin-right: 5px;"></i>新增合同</button><button onclick="daoru()" style="border:1px solid #999; background-color:white;color:#222;margin-left:20px;height: 30px;line-height: 30px;" class="layui-btn">导入合同</button></span>
				    </li>
				  </ul>
			</div>
			       
			<div class="sxdiv">
			<div id='sxhidestr' style=';display: none;border:1px '>
       		<div class='sx_tj_margain'><span class='one sx_yes' style="margin-left:20px">全部合同</span><span class='two sx_yes'  style="margin-left:20px">全部</span><span class='three sx_yes'  style="margin-left:20px">全部</span><span class='four sx_yes'  style="margin-left:20px">全部</span></div>
      		 </div>
		         <div id="sxzddiv"  >
	              		<?php echo ($peizhi); ?>
	              		<div class='sxzddiv zhuangtai' id='ht_sp'>
						<div class='sx_title zhuangtai ' >审批状态：</div>
							<span class='sx_yes'  id='sp_qb'>全部</span>
							<span class='sx_no'  id='sp_wfq'>未发起</span>
							<span class='sx_no'  id='sp_spz'>审批中</span>
							<span class='sx_no'  id='sp_sptg'>审批通过</span>
							<span class='sx_no' id='sp_spbh'>审批驳回</span>
						</div>
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
							 <tr style='line-height:70px'><td><input type="checkbox" name="zy_sj" value="ok">同时转移合关联的商机</td></tr>
						     <tr style='line-height:70px'><td><input type="checkbox" name="zy_kh" value="ok">同时转移合同关联的客户</td></tr>
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
								                		<th>审批状态</th>
									               <?php if(is_array($ywzd)): foreach($ywzd as $key=>$vo): ?><th><?php echo ($vo["name"]); ?></th> <!--客户标题--><?php endforeach; endif; ?>
								                </tr>
										</thead>
										 <tbody id="jb_bianji">
														<?php echo ($a); ?>
								                </tbody>
								                </div>
									</table>  
									
								
						</div>
				</div>
					<div id="demo7" class="ycyo" style="float:right"></div>
			</div>		
		</div>
	</div>
	<div id="add_kh" style="display: none;border:1px"> <!--新增客户-->
								<form  name= 'form_kh' method="post" id="kh" >
									<table class=" th_kh addshangji_weizhi uk-form" >
										
										
									</table>
								</form>
								
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
					<div id="nchangyong" onselectstart='return false'><span style="color:#07d;cursor:pointer;">展开更多信息>></span></div>
	</div>
	
	<div id="add_shangji1" style="display: none;border:1px"> <!--新增商机 弹出框-->
					<form name="sj_name"  id="sj_name" method="post" class="uk-form"  >
						<table class="addshangji_weizhi sj_tihuan" >
							
						
						</table>
					</form>
	</div>
<div class='fujian' style="display:none">
				<table class='fujian1'>

				</table>
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
	<div id="lxr" style="display: none;border:1px"> <!--新增客户-->
								<form  name= 'form_kh' method="post" id="myform2" >
									<table class=" th_lxr addshangji_weizhi uk-form" >
										
										
									</table>
								</form>
								
				</div>
	<div class="bhyuany"  style="display: none;border:1px;">
					    		<div class="bhyuany1" >
					    			
					    		</div>
						 	</div>
  <div id="bj_kehu" style="margin-top:10px;padding-top:20px;display: none;border:1px">
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
  	<div class='faqi' style='height:80px;display:none'>
  		<span style='color:green;margin-left:35%;line-height:70px;height:70px'>发起审批后将不可编辑、删除！</span>
  	</div>
  	<div class='ck_spjd' style='height:80px;display:none'>
  		<div class='ck_spjd1' style='margin-left:20%;'></div>
  	</div>
	</body>
	<script>

layui.use('upload', function(){
  layui.upload(options);
});
var zhuangtai=$("#zhuangtai").val();
var lszt='';
if(zhuangtai=='' || zhuangtai==null ||zhuangtai=="全部")
{	
	lszt='sp_qb'
	
}else{

	if(zhuangtai=="未发起")
	{
		lszt='sp_wfq'
	}
	if(zhuangtai=="审批中")
	{
		lszt='sp_spz'
	}	
	if(zhuangtai=="审批通过")
	{
		lszt='sp_sptg'
	}
	if(zhuangtai=="审批驳回")
	{
		lszt='sp_spbh'
	}
	 $(".zhuangtai").children("span").prop("class","sx_no");
     $("#"+lszt).prop("class","sx_yes");
}
    
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
	window.id='';
	$(".sxzddiv").children("span").click(function(){          //点击筛选的 选中
		var tex =$(this).text();
	    var title=$(this).parent().prop('id');
	if(title=='ht_sp')
    {
    	   	window.location.href="hetong?ht_sp926="+tex;return;
    }
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
   $(".ycyo").hide();

	$.get(rooturl+'/index.php/Home/Hetong/shaixuan',{"id":id},
							        		 function(html){
							        		 	
							        			$("#jb_bianji").html(html);
							        	
							        			blurfun();
							                   });
 
});

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
	var fujian_name='';
	function addhetong(){
		
					layui.upload({
					        url: rooturl+"/index.php/Home/Hetong/wjsc_dr",
					      
					        title:"选择文件",
					        success: function(res){
					        
					            if(res['res']=='1')
					            {
					            	var a=res['oldname'];
					
					            	$.get(rooturl+'/index.php/Home/Hetong/sql_fj',{},
							        		 function(html){
							        		 	$(".fj_th").html(html);
							        		 		$(".yc_xs").show();
									        		
							                 });
					            	
						  
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
								area: ['720px', '560px'],
								title: '新增合同',
								content:$('#add_shangji'),
								btn:['确认添加','取消'],
								btn1:function(){
									
								 $("#ht_form :input.required").trigger('blur');
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
										ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
									}

									var vstr=ajaxstr.substr(0,ajaxstr.length-1);
									
									
									if(ajaxstr_kh=="" && ajaxstr_sj == "")
									{ 
										
										$.get(rooturl+'/index.php/Home/Hetong/add_ht',{"id":vstr},
								        		 function(html){
								        		 		tishi("添加成功")

		     											   	window.location.href="hetong";
										        	
								                 });
									}else{

											var kh_lxr_name=$("#kh_lxr_name").val();
					
											if(kh_lxr_name==undefined || kh_lxr_name==null)
											{
												kh_lxr_name =name_lxr;
											}
											
										$.get(rooturl+'/index.php/Home/Hetong/add_ht1',{"kh":ajaxstr_kh,"lxr_id":kh_lxr_name,"kh_id":kh_id12,"lxr":ajaxstr_lxr,"sj":ajaxstr_sj,"ht":vstr},
									        		 function(html){
									        	

									        		 		tishi("添加成功")

			     											   	window.location.href="hetong";
											        		
									                 });
									}
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
	        $(this).html("<span style='color:#07d;cursor:pointer;'>收起>></span>");
	        $(this).prop("name",'1');
	    }
	    else
	    {
	    	 $(".ncy").hide();
	        $(this).html("<span style='color:#07d;cursor:pointer;'>展开更多信息>></span>");
	        $(this).prop("name",'0');
	    }
	});
</script>

    	<script>
    		function get_sj(sj){
    			
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
		        				 	window.location.href="hetong"
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
										//	alert(bianji_str+xgzd+content+xgzd2+content2);return
												$.get(rooturl+'/index.php/Home/Hetong/pl_bianji',{"id":bianji_str,"ziduan":xgzd,"content":content,"xgzd2":xgzd2,"content2":content2},
					        		 				function(html){
					        		 				tishi("批量修改成功")
															  	window.location.href="hetong"
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
														
														if(fuzeren=='请选择新负责人')
														{
															tishi("请选择负责人");return
														}
														var fuzeren1=$("#zhuanyifzr").children("option[value='"+fuzeren+"']").text();//客户名称汉字
														var shangji_hetong='';//不确定
														//tishi(fuzeren)
														var sj=$('input[name="zy_sj"]:checked').val();
														var kh=$('input[name="zy_kh"]:checked').val();
														
														$.get(rooturl+'/index.php/Home/Hetong/pl_zhuanyi',{"id":fuzeren,"ziduan":fuzeren1,"ht_id":piliang_str,'sj':sj,'kh':kh},
							        		 				function(html){

							        		 					tishi("批量转移成功")
							        		 					   	window.location.href="hetong"
																		
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
    	var xlcp1=0;
    		function cp_add(){
    				if(xlcp1<1)
				 			{
				 				$('.xlcp').searchableSelect();

				 				xlcp1++;
					 			
				 			}

					

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
									        		$(".cp_yj").val("")
								    				$(".cp_jy").val("")
								    				$(".cp_zk").val("-")	
								    				$(".cp_num1").val("")	
								    				$(".cp_zj").val("")	
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
									        	
													$(".cp_yj").val("")
								    				$(".cp_jy").val("")
								    				$(".cp_zk").val("-")	
								    				$(".cp_num1").val("")	
								    				$(".cp_zj").val("")	
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
	function kongzhiyeshu(ss){

		var yeshu=$(ss).val();
		window.yeshu=yeshu;
		window.location.href="hetong?fenye="+yeshu;
	
	}
	function sousuo(){
			$(".ycyo").hide();
					var name= $("#sousuo").val();

					 $.get(rooturl+'/index.php/Home/hetong/sousuo',{"id":name},
										        		 function(ht_id){
										        		
										        		$("#jb_bianji").html(ht_id);
												        	
										                  });
				}
					function sousuo1(){
					$(".ycyo").hide();
					var name= "";
					 $("#sousuo").val("");
					 $.get(rooturl+'/index.php/Home/hetong/sousuo',{"id":name},
										        		 function(lxrid){

										        		$("#jb_bianji").html(lxrid);
												        	
										                  });
				}
				var is_one="0";
				var is_one1="0";
				 function change_fun(v2)
				 {
				 		if(is_one<2 )
					 	{
					 		is_one++;
					 		return;
					 	}
					 	
					 	if(v2.prop('id')=="xlcp") //下拉产品
				 		{
				 			window.w= v2.val();

				    			if(w == 's'){
				    				$(".cp_yj").val("")
				    				$(".cp_jy").val("")
				    				$(".cp_zk").val("-")	
				    				$(".cp_num1").val("")	
				    				$(".cp_zj").val("")	
				    				
				    			}

				    			
				    			$.get(rooturl+'/index.php/Home/Shangji/cp_ajax',{"id":w},
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
				 	if(v2.prop('id')=="xl1"){
				 			window.kh_id12= v2.val();
				 		if(kh_id12!="xz_kh")
				 			{
    						$.get(rooturl+'/index.php/Home/Hetong/get_sj',{"id":kh_id12},
			        		 				function(html){
        		 								//tishi(html)
												$(".th_sj").html(html);
												layer.close(win)
											});
	    					}else{


		    				$.get(rooturl+'/index.php/Home/Shangji/kehu_add',{},
			        		 				function(html){
											$(".th_kh").html(html);
											
		        		 								$('.xlss2').searchableSelect();
		        		 								
		        		 								return;
		        		 			
		        		 						
												
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
												 $("#kh_name").html("<input type='text' name='zdy1' value='"+name_kh+"' readonly='true'>");
												
											
										

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
											
											ajaxstr+=thisdom.prop("name")+":"+thisdom.val()+",";
										}
										
									}
								
										window.ajaxstr_lxr=ajaxstr;//alert(ajaxstr)
								

									window.name_lxr =$("#lxr").find("#lxrzdy0").val();
										
									$("#zdy15th").html("<select name='zdy15' id='kh_lxr_name'><option value='lslxr'>"+name_lxr+"</option></select>");
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
				 	if(v2.prop('id')=="xl2"){
				 			var user_id=v2.val();
			    			$.get(rooturl+'/index.php/Home/Hetong/get_bm',{"id":user_id},
						        		 				function(html){
			        		 								//tishi(html)
														$(".bm_th").html(html);
															layer.close(win)
														});
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
    		
    	</script>
    	<script>
    		function sjtzz(s){
    			
    			var sj_va=$(s).val();
    		
    	
    			if(sj_va == "xzsj")
    			{		//alert(name_lxr)
    					$.get(rooturl+'/index.php/Home/Hetong/add_shangji',{"id":kh_id12,'lx_id':name_lxr},
		        		 function(html){
		     
		        				$(".sj_tihuan").html(html);
		        				$('#sj_name table :input').blur(function(){
									    	
													var $parent =$(this).parent();
													$parent.find(".formtips").remove();
													if( $(this).is('.required') ){
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

		                   });

    				layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '新增商机',

								content:$('#add_shangji1'),
								btn:['确认添加','取消'],
								btn1:function(){
									 $("#sj_name :input.required").trigger('blur');
			             				  var numErrorxplxr= $('#sj_name .onError').length;
											
										
			              				  if(numErrorxplxr>0){
			              				  	tishi('必填项不能为空')
					                   			 return false;
					              		 	 } 
									var formdom=$("#sj_name").children("table").find("tr");
									var fornum=formdom.length;
									var ajaxstr_sj1='';
									for(a=0;a<fornum;a++)
									{
										var thisdom=formdom.eq(a).find("td").eq(1).children();
											ajaxstr_sj1+=thisdom.prop("name")+":"+thisdom.val()+",";	
									}
								
										window.ajaxstr_sj=ajaxstr_sj1;//
							

									window.name_sj =$("#sj_name").find("#wyzdy0").val();
									//	alert(name_sj)
									$(".sjgl").html("<option  value='"+name_sj+"'>"+name_sj+"</option>");
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
		        function bhyy(ss){
		        	var bh_id=$(ss).prop("class");
		        	

        				$.get(rooturl+'/index.php/Home/Hetong/bh_yy',{"id":bh_id},
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
			function faqi(ss){
				var id=$(ss).prop('class');
				
					layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:'630px',
								fixed: false,
								title: '发起审批',

								content:$('.faqi'),
								btn:['确认发起','取消'],
								btn1:function(){

										$.get(rooturl+'/index.php/Home/Hetong/faqi',{"id":id},
												function(html){
										
													window.location.href="hetong";

											})
										


								},
								btn2:function(){
									layer.close(win)
									//addshangji()
								}
							}); 

						});      		
			}
			function ck_spjd(ss){
				var id=$(ss).prop("class");
			
				$.get(rooturl+'/index.php/Home/Hetong/jindu',{"id":id},
												function(html){
										
											 $(".ck_spjd1").html(html)		

											})
				
				layui.use('layer', function(){
							var layer = layui.layer;
							var win=layer.open({
								type:1,
								offset: 't',
								area:['630px','400px'],
								fixed: false,
								title: '查看审批进度',

								content:$('.ck_spjd'),
								btn:['返回'],
								btn1:function(){

											layer.close(win)
									//addshangji()


								},
								
							}); 

						});      	
			}
    	</script>
    	
</html>