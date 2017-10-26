<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>合同</title>
		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
        <script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script>
		<!--jq ui-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
  		<!--jqui 结束-->
   		<style>
		body,ul,li,table,tr{margin:0;padding:0;font-family:宋体; color:#333;}
		.top{ width:100%;height:50px ;} 
		.top1{  position: relative; left: 10px; top :16px;}
		.name{font-size:24px; color:black;}
		.fuzeren{ position: relative; left: 15px;font-size:14px;}
		.fuzename{color:blue;}
		.anniu{ position: relative; top :30px;}
		.quanjing_left{ height:100%;border: 1px solid #eee;}
		.quanjing_right{ height:600px;border: 1px solid #eee;}
		.ziliao{height:40px;width:100%; background-color:#eee;}
		#tabs-1{position: relative; right :18px;}
        .jiben{position: relative; left :20px;top:10px;}
        .phone{line-height:40px;position: relative; left :20px;}
        .xiaoshou{position: relative; left :20px;top:10px;width:107%;}

        .only1{position: relative; left:475px;top:6px;}
        .genjin_back{background-color:#F7FBFE;width:90%;position: relative; top:10px;margin:20px auto;}
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

        .phone1{line-height:40px;position: relative; left :20px;}
        .phone2{line-height:40px;position: relative; left :20px;}
        .phone3{line-height:40px;position: relative; left :20px;}
        .phone4{line-height:40px;position: relative; left :20px;}
        .phone5{line-height:40px;position: relative; left :20px;}
        .phone6{line-height:40px;position: relative; left :20px;}
        .phone7{line-height:40px;position: relative; left :20px;}
        .phone8{line-height:40px;position: relative; left :20px;}
        .phone9{line-height:40px;position: relative; left :20px;}
        .phone10{line-height:40px;position: relative; left :20px;}
        .ht_rz{line-height:24px; background-color:#F7FBFE; position: relative; left :20px;top:10px;width:90%;margin-bottom:20px;
			}
			body .lt2{ float: left;margin-top:20px;  }
			body .tr1{ float: left;margin-right:25px;  }
        .genjinjilu{background-color:#1AA094;width:70px;height:24px;float:right;}
        .genjinjilu{position: relative; right:8px;top:6px;color:white;}
        #shangc_top{padding-top:30px}
        #formtable{width:500px;}
        #huikuanjihua{width:500px;}
         #huikuanjilu{width:500px;}
          #kaipiaojihua{width:500px;}
           #guanlianchanpin{width:500px;}
		#formtable tr{height:50px;line-height:50px;margin-bottom:20px;}
		.redstar{text-align:center;color:#f00;}
		</style>

	</head>

	<body >
		<div class="top">
			<div class="top1" >
				
				<span class="name" ><?php echo ($a_id); ?></span> <span class="fuzeren">负责人:<span class="fuzename"><?php echo ($fuzeren["user_name"]); ?></span></span>
				
			</div>
			<div class="top1 anniu">		
					
							<select >
								<option>意向</option>
								<option>出访</option>
								<option>跟进</option>
								<option>不错</option>
							</select>
							<select >
								<option>添加</option>
								<option>联系人</option>
								<option>商机</option>
								<option>合同</option>
							</select>
							<input type="button" name="" value="转移给他人">
							 <input type="button" name="" value="转移至公海"> 
					   		
					   		 <input type="button" name="" value="编辑"> 
					   		 <input type="button" name="" value="删除"> 
					
   			</div>
   		
		</div>		 
		<div id="tabs">
			  <ul>
			    <li><a href="#tabs-1">基本信息</a></li>
			    <li><a href="#tabs-2">回    款</a></li>
			    <li><a href="#tabs-3">产    品</a></li>
			    <li><a href="#tabs-5">合同附件</a></li>
			    <li><a href="#tabs-6">操作日志</a></li>

			  </ul>
	  		<div id="tabs-1" style="overflow:hidden;width:100%">
	  			<div class="quanjing_left" style="width:50%; float:left">
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">基本信息</span>
	  				</div>
	  				<div >
	  					<span class="phone">合同标题:<?php echo ($d_id["zdy0"]); ?></span><br />
	  					<span class="phone1">对应客户:<?php echo ($d_id["zdy1"]); ?></span><br />
	  					<span class="phone2">对应商机:<?php echo ($d_id["zdy2"]); ?></span><br />
	  					<span class="phone3">合同总金额:<?php echo ($d_id["zdy3"]); ?></span><br />
	  					<span class="phone4">合同开始时间:<?php echo ($d_id["zdy5"]); ?></span><br />
	  					<span class="phone5">合同结束时间:<?php echo ($d_id["zdy6"]); ?></span><br />
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">回款信息</span>
	  				</div>
	  				<div >
	  					<span class="phone1">已开票金额:<?php echo ($c_id["ht_yihui"]); ?></span><br />
	  					<span class="phone2">已回款金额:<?php echo ($c_id["ht_weihui"]); ?></span><br />
	  					<span class="phone3">未回款金额:<?php echo ($c_id["ht_yikai"]); ?></span><br />
	  					<span class="phone4">未开票金额:<?php echo ($c_id["ht_weikai"]); ?></span><br />
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">其他信息</span>
	  				</div>
	  				<div >
	  					<span class="phone1">合同状态:<?php echo ($zdy7); ?></span><br />
	  					<span class="phone2">合同编号:<?php echo ($d_id["zdy8"]); ?></span><br />
	  					<span class="phone3">合同类型:<?php echo ($zdy10); ?></span><br />
	  					<span class="phone4">付款方式:<?php echo ($zdy11); ?></span><br />
	  					<span class="phone5">客户方签约人:<?php echo ($d_id["zdy12"]); ?></span><br />
	  					<span class="phone6">我方签约人:<?php echo ($d_id["zdy13"]); ?></span><br />	
	  					<span class="phone7">签约日期:<?php echo ($d_id["zdy4"]); ?></span><br />	
	  					<span class="phone8">合同附件:</span><br />
	  					<span class="phone9">下次跟进时间:<?php echo ($d_id["zdy15"]); ?></span><br />
	  					<span class="phone10">备注:<?php echo ($d_id["zdy17"]); ?></span><br />
	  				</div>
	  				</div>
	  				<div class="dan">
	  				<div class="ziliao">
	  					<span class="jiben">系统信息</span>
	  				</div>
	  				<div >
	  					<span class="phone1">负责人:<?php echo ($fuzeren["user_name"]); ?></span><br />
	  					<span class="phone2">创建人:<?php echo ($c_id["ht_cj"]); ?></span><br />
	  					<span class="phone3">前负责人:<?php echo ($c_id["ht_old_fz"]); ?></span><br />
	  					<span class="phone4">部门:<?php echo ($d_id["department"]); ?></span><br />
	  					<span class="phone5">前所属部门:<?php echo ($c_id["ht_old_bm"]); ?></span><br />
	  					<span class="phone6">创建时间:<?php echo ($c_id["ht_cj_date"]); ?></span><br />
	  					<span class="phone7">更新于:<?php echo ($c_id["ht_gx_date"]); ?></span><br />
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
	  					<input type="hidden" name="kh_id" value="<?php echo ($kh_id); ?>">
	  					
	  					<textarea name="wenbenyu" rows="10" cols="77" class="wenbenyu"> 
	  						勤跟进，多签单........
	  					</textarea>
	  				<div class="kehu_genjin">合同<span class="legt_genjin"><input type="text" name="shiji_date" value="<?php echo ($a_id); ?>" style="width:150px;height:20px" readonly="true"></span></div>  

	  				<div class="genjinzhuangtai"> 
	  					跟进状态 <span class="left_genjin1">
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

	  				<?php if(is_array($genjin)): foreach($genjin as $key=>$vo): if($vo["rz_bz"] == ''): ?><div  class="ht_rz">
	  				<table>
		  				<tr>
		  					<td><span class="fuzename"><?php echo ($vo["user_id"]); ?>：<?php echo ($vo["type"]); ?></span></td>
		  				</tr>
		  				<tr>
		  					<td><?php echo ($vo["content"]); ?></td>
		  				</tr>
		  				<tr>
		  					<td>来自合同<span class="fuzename">  <?php echo ($a_id); ?></span></td>
		  				</tr>
		  				<tr>
		  					<td><span class="dataa">时间:<?php echo ($vo["rz_time"]); ?></span></td>
		  				</tr>
	  				</table>
	  				</div>
			<?php else: ?>
	  				<div  class="ht_rz">
	  				<table>
		  				<tr>
		  					<td>操作人：<span class="fuzename"><?php echo ($vo["rz_user"]); ?></span></td>
		  				</tr>
		  				<tr>
		  					<td><?php echo ($vo["rz_bz"]); ?></td>
		  				</tr>
		  				<tr>
		  					<td>来自合同:<span class="fuzename">  <?php echo ($a_id); ?></span></td>
		  				</tr>
		  				<tr>
		  					<td><span class="data">时间:<?php echo ($vo["rz_time"]); ?></span></td>
		  				</tr>
	  				</table>
	  				</div><?php endif; endforeach; endif; ?>	
	  				</div>
	  				
	  			</div>
	  		</div>

	  				
	  	
	  		<div id="tabs-2">
	  			<div class = "name1">
	  			<p  class = "tr1">
	  			计划回款总金额:<?php echo ($jihua_zjine); ?>
	  			</p>
	  			<p  class = "tr1">
	  			已回款总金额:<?php echo ($c_id["ht_yihui"]); ?>
	  			</p>
	  			<p  class = "tr1">
	  			未回款总金额:<?php echo ($c_id["ht_weihui"]); ?>
	  			</p>
	  			<p class = "tr1">
	  			已开票总金额:<?php echo ($c_id["ht_yikai"]); ?>
	  			</p>
	  			<p  class = "tr1">
	  			未开票总金额:<?php echo ($c_id["ht_weikai"]); ?>
	  			</p>
	  			</div>
	  		   
              
	  			<table class="layui-table lt2" lay-skin="line">
              
	  	        <thead>
	  	        <thead style="width: 100%">
		  	        <th>回款计划</th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  			<th><input type="button" id="dialog-form" onclick="huikuanjihua()" value="新增回款计划"></th>

	  			</thead>
	  			    <th >计划回款名称</th>
	  				<th >计划回款日期</th>
	  				<th >计划回款金额</th>
	  				<th >回款类型</th>
	  				<th >备注</td>
	  				<th  colspan='2'>操作</th>
	  				</thead>
		       <tbody class="fujian_del">
		       <?php if(is_array($arr)): foreach($arr as $key=>$vo): if($vo["jihua_date"] != ''): ?><tr>
	  			   
	  			    <td ><?php echo ($vo["hui_name"]); ?></td>
	  				<td ><?php echo ($vo["jihua_date"]); ?></td>
	  				<td ><?php echo ($vo["jihua_jine"]); ?></td>
	  				<td ><?php echo ($vo["jihua_type"]); ?></td>
	  				<td ><?php echo ($vo["jihua_beizhu"]); ?></td>
	  				<td  > <input type="button" onclick="bianjihuikuan1(this)"  id="<?php echo ($vo["hui_id"]); ?>" value="编辑">  <a href="/index.php/Home/Hetong/delete_hui?hui_id=<?php echo ($vo["hui_id"]); ?>"><input type="button" value="删除"></a></td>
	  			</tr><?php endif; endforeach; endif; ?>
		        </tbody>
	  		    </table>  

	  		    <table class="layui-table 1t3" lay-skin="line">
	  	        
	  			    <thead>
	  			    <thead style="width: 100%" >
		  	        <th>回款记录</th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>

		  			<th><input type="button" id="dialog-form" onclick="huikuanjilu()" value="新增回款记录"></th>
	  			</thead>
	  			    <th >回款记录名称</th>
	  				<th >回款日期</th>
	  				<th >回款金额</th>
	  				<th >付款方式</th>
	  				<th >回款类型</td>
	  				<th >收款人</th>
	  				<th >备注</th>
	  			    <th  colspan='2'>操作</th>
		        </thead>
		        <tbody class="fujian_del">
		        <?php if(is_array($arrp)): foreach($arrp as $key=>$va): if($va["jilu_date"] != ''): ?><tr>
	  			   
	  			    <td ><?php echo ($va["hui_name"]); ?></td>
	  				<td ><?php echo ($va["jilu_date"]); ?></td>
	  				<td ><?php echo ($va["jilu_jine"]); ?></td>
	  				<td ><?php echo ($va["jilu_fukuan"]); ?></td>
	  				<td ><?php echo ($va["jilu_type"]); ?></td>
	  				<td ><?php echo ($va["jilu_shoukuanren"]); ?></td>
	  				<td ><?php echo ($va["jilu_beizhu"]); ?></td>
	  				<td  ><input type="button" onclick="bianjihuikuan2(this)" id="<?php echo ($va["hui_id"]); ?>" value="编辑">  <a href="/index.php/Home/Hetong/delete_hui?hui_id=<?php echo ($vo["hui_id"]); ?>"><input type="button" value="删除"></a></td>
	  			</tr><?php endif; endforeach; endif; ?>
		        </tbody>
	  		    </table>

	  		    <table class="layui-table" lay-skin="line">
	  	        <thead>
	  	         <thead style="width: 100%" >
		  	        <th>开票记录</th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	         <th ></th>
		  			<th><input type="button" id="dialog-form" onclick="kaipiaojilu()" value="新增开票记录"></th>
		  			</thead>
		  			<th >开票记录名称</th>
	  				<th >开票日期</th>
	  				<th >票据内容</th>
	  				<th >开票金额</th>
	  				<th >票据类型</td>
	  				<th >发票号码</th>
	  				<th >经手人</th>
	  			    <th >备注</th>
	  			    <th  colspan='2'>操作</th>
		        </thead>
		        <tbody class="fujian_del">
		        <?php if(is_array($arrq)): foreach($arrq as $key=>$vp): if($vp["kaipiao_date"] != ''): ?><tr>
	  			   
	  			    <td ><?php echo ($vp["hui_name"]); ?></td>
	  		        <td ><?php echo ($vp["kaipiao_date"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_neirong"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_jine"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_type"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_haoma"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_jingshouren"]); ?></td>
	  				<td ><?php echo ($vp["kaipiao_beizhu"]); ?></td>
	  				<td  ><input type="button" onclick="bianjihuikuan3(this)" id="<?php echo ($vp["hui_id"]); ?>" value="编辑"> <a href="/index.php/Home/Hetong/delete_hui?hui_id=<?php echo ($vo["hui_id"]); ?>"><input type="button" value="删除"></a></td>
	  			</tr><?php endif; endforeach; endif; ?>
		        </tbody>
	  		    </table>    
	  			
	  		</div>
	  		<div id="tabs-3">
	  		
	  			<table class="layui-table lt5" lay-skin="line">
              
	  	        <thead>
	  	        <thead style="width: 100%">
		  	        <th>关联产品</th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  	        <th ></th>
		  			<th><input type="button" id="dialog-form" onclick="guanlianchanpin()" value="关联产品"></th>

	  			</thead>
	  			    <th >产品名称价格</th>
	  			    <th >建议价格</td>
	  				<th >数量</th>
	  				<th >总价</th>
	  				<th >备注</th>
	  				<th  colspan='2'>操作</th>
	  			</thead>
		       <tbody class="fujian_del">
		       <?php if(is_array($gc_chan)): foreach($gc_chan as $key=>$va): ?><tr>
	  		        <td ><?php echo ($va["gp_name"]); ?></td>
	  				<td ><?php echo ($va["gp_jianyi"]); ?></td>
	  				<td ><?php echo ($va["gp_shuliang"]); ?></td>
	  				<td ><?php echo ($va["gp_zongjia"]); ?></td>
	  				<td ><?php echo ($va["gp_beizhu"]); ?></td>
	  				<td  > <input type="button" onclick="guanlianchanpin1(this)"  id="<?php echo ($va["gp_id"]); ?>" value="编辑">  <a href="/index.php/Home/Hetong/delete_chan?gp_id=<?php echo ($va["gp_id"]); ?>"><input type="button" value="删除"></a></td>
	  			</tr><?php endforeach; endif; ?>
		        </tbody>
	  		    </table>  
	  		</div>
	  		<div id="tabs-5">
	  		
	  		<input type="button" id="dialog-form" onclick="openwindow()" value="+文件上传">
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
		<?php if(is_array($sql)): foreach($sql as $key=>$vo): ?><tr>
	  		        <td ><?php echo ($vo["id"]); ?></td>
	  				<td ><?php echo ($vo["sc_data"]); ?></td>
	  				<td ><?php echo ($vo["fujian_name"]); ?></td>
	  				<td ><?php echo ($vo["big"]); ?></td>
	  				<td ><?php echo ($vo["beizhu"]); ?></td>
	  				<td  ><a href="http://127.0.0.1/<?php echo ($vo["lujing"]); ?>">预览</a>|<a href="<?php echo ($_GET['root_dir']); ?>/<?php echo ($vo["lujing"]); ?>">下载</a>|<span class="del" id="<?php echo ($vo["id"]); ?>">删除</span></td>
	  			</tr><?php endforeach; endif; ?>
		</tbody>
	  		</table>  


				
		  			<form id="uploadform" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/upload/id/<?php echo ($kh_id); ?>/pageid/<?php echo ($_GET['id']); ?>/fuzeren/<?php echo ($_GET['fuzeren']); ?>/id1/<?php echo ($_GET['id1']); ?>/ht_id/<?php echo ($_GET['ht_id']); ?>" enctype="multipart/form-data" method="post" style="margin:20px;">
	  					<input type="file" name="wenjian"  >
	  					<div id="shangc_top">备&nbsp;&nbsp;&nbsp;&nbsp;注：<!-- 第一个是普通textarea -->
					<textarea name="wenbenyu" class="comments" rows="5" cols="30"> </textarea>  </div>
	  					<div id="shangc_top" ><input type="submit" value="上传附件"  class="layui-btn layui-btn-small"></div>
	  				</form>


	  		</div>
	  		

	  	<div id="tabs-6">
	  	<table class="layui-table" lay-skin="line">
	  	<thead>
	  				<th >ID</th>
	  				<th >操作时间</th>
	  				<th >操作人员</th>
	  				<th >操作模块</th>
	  				<th >操作对象</th>
	  				<th >备注</th>
	  	</thead>
		<tbody class="fujian_del">
		<?php if(is_array($rz_caozuo)): foreach($rz_caozuo as $key=>$vo): ?><tr>
	  				<td ><?php echo ($vo["rz_id"]); ?></td>
	  				<td ><?php echo ($vo["rz_time"]); ?></td>
	  				<td ><?php echo ($vo["rz_user"]); ?></td>
	  				<td >合同模块</td>
	  				<td ><?php echo ($a_id); ?></td>
	  				<td ><?php echo ($vo["rz_bz"]); ?></td>
	  				
	  			</tr><?php endforeach; endif; ?>
		</tbody>
	  		</table>  
	  		</div>


  		</div>
	</body>

	<div  id="guanlianchanpin" >
	 	<div id="addform" style="margin:10px;" >
	 	 <form id="guanlianchanpin" name="lilong" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/guanlianchanpin" enctype="multipart/form-data" method="post">
			<table id="formtable">
			    <tr>
					<td class="redstar">*</td>
					<td>产品名称价格</td>

					<td>
					<select name = gp_name>
					<?php if(is_array($a_arp)): foreach($a_arp as $key=>$vo): ?><option value="<?php echo ($vo["zdy0"]); ?>      <?php echo ($vo["zdy2"]); ?>"><?php echo ($vo["zdy0"]); ?>      <?php echo ($vo["zdy2"]); ?></option><?php endforeach; endif; ?>
					</select>
					</td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>建议价格</td>
					<td><input type="text" name="gp_jianyi" placeholder="建议价格" class="layui-input" />
					<input type="hidden" name="ht_id" value="<?php echo ($_GET['ht_id']); ?>" placeholder="建议价格" class="layui-input" />
					</td>
				</tr>
				 <tr>
					<td class="redstar">*</td>
					<td>产品数量</td>
					<td><input type="text" name="gp_shuliang" placeholder="产品数量" class="layui-input" />
					</td>
				</tr>
				 <tr>
					<td class="redstar">*</td>
					<td>备注</td>
					<td><input type="text" name="gp_beizhu" placeholder="备注" class="layui-input" />
					</td>
				</tr>
				<tr>
			    <td align="right" colspan="3">
                <input type="submit" class="layui-btn" value="确定">
                </td>
			    </tr>
			</table>
			   
               
                </form>
		</div>
	</div>
 
		      
		
	<div  id="guanlianchanpin1" >
	 	<div id="addform" style="margin:10px;" >
	 	 <form id="guanlianchanpin1" name="lilong" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/guanlianchanpin1" enctype="multipart/form-data" method="post">

	  <?php echo ($table); ?>
	      
         </form>

		</div>
	</div>

	<div  id="huikuanjihua" >
	 	<div id="addform" style="margin:10px;" >
	 	 <form id="huikuanjihua" name="lilong" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c" enctype="multipart/form-data" method="post">
			<table id="formtable">
			    <tr>
					<td class="redstar">*</td>
					<td>计划回款名称</td>
					<td><input type="text" name="hui_name" required lay-verify="required" placeholder="请输入计划回款名称" class="layui-input"/></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>计划回款日期</td>
					<td><input type="text" name="jihua_date"  placeholder="请输入日期" class="text ui-widget-content ui-corner-all layui-input" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})"  /></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>计划回款金额</td>
					<td><input type="text" name="jihua_jine" placeholder="请输入金额" class="layui-input" />
					<input type="hidden" name="ht_id" value="<?php echo ($_GET['ht_id']); ?>" placeholder="请输入金额" class="layui-input" />
					</td>
				</tr>
				 
				<tr>
					<td class="redstar">*</td>
					<td>回款类型</td>
				
					<td>
				     	<select name="jihua_type"  style="width:150px;height:25px">
		  							
			  							<?php if(is_array($dan_ywcs)): foreach($dan_ywcs as $sq=>$ywcs): if($ywcs == $valav['hktype']){ ?>
			  												<option selected="slected" value="<?php echo ($sq); ?>"> <?php echo ($ywcs); ?></option>

			  										<?php	}else{ ?>
			  												<option value=" <?php echo ($sq); ?>"><?php echo ($ywcs); ?></option>
			  										<?php	} endforeach; endif; ?>
	  				</select>
                    </td>
                  
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>备注</td>
					<td><input type="textarea" name="jihua_beizhu" placeholder="请输入备注" class="layui-input" /></td>
				</tr>
				<tr>
			    <td align="right" colspan="3">
                <input type="submit" class="layui-btn" value="确定">
                </td>
			    </tr>
			</table>
			   
               
                </form>
		</div>
	</div>
 
		      
		
	<div  id="bianjihuikuan1" >
	 	<div id="addform" style="margin:10px;" >
	 	 <form id="bianjihuikuan1" name="lilong" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/bianjihuikuan1" enctype="multipart/form-data" method="post">

	  <?php echo ($table); ?>
	      
         </form>

		</div>
	</div>

	<div  id="huikuanjilu" >
	 	<div id="addform" style="margin:10px;">
	 	 <form id="huikuanjilu" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c" enctype="multipart/form-data" method="post" onsubmit = "return checkUser();">
			<table id="formtable">

			    <tr>
					<td class="redstar">*</td>
					<td>回款记录名称</td>
					<td><input type="text" name="hui_name" required lay-verify="required" placeholder="请输入回款记录名称" class="layui-input"/></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>回款日期</td>
					<td><input type="text" name="jilu_date" required lay-verify="required" placeholder="请输入日期" class="text ui-widget-content ui-corner-all layui-input" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})"/></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>回款金额</td>
					<td><input type="text" name="jilu_jine" required lay-verify="required" placeholder="请输入金额"  class="layui-input" /><input type="hidden" name="ht_id" value="<?php echo ($_GET['ht_id']); ?>" placeholder="请输入金额" class="layui-input" />
					</td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>付款方式</td>
					<td>
					<select name="jilu_fukuan"  style="width:150px;height:25px">
		  							
			  							<?php if(is_array($fukuan)): foreach($fukuan as $aq=>$ywcs): if($ywcs == $valav['zdy11']){ ?>
			  												<option selected="slected" value="<?php echo ($aq); ?>"> <?php echo ($ywcs); ?></option>

			  										<?php	}else{ ?>
			  												<option value=" <?php echo ($aq); ?>"><?php echo ($ywcs); ?></option>
			  										<?php	} endforeach; endif; ?>
	  				</select>
	  				<td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>回款类型</td>
					<td>
					<select name="jilu_type"  style="width:150px;height:25px">
		  							
			  							<?php if(is_array($dan_ywcs)): foreach($dan_ywcs as $sq=>$ywcs): if($ywcs == $valav['hktype']){ ?>
			  												<option selected="slected" value="<?php echo ($sq); ?>"> <?php echo ($ywcs); ?></option>

			  										<?php	}else{ ?>
			  												<option value=" <?php echo ($sq); ?>"><?php echo ($ywcs); ?></option>
			  										<?php	} endforeach; endif; ?>
	  				</select>
	  				<td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>收款人</td>
					<td><input type="text" name="jilu_shoukuanren" required lay-verify="required" placeholder="请输入收款人
					" autocomplete="off" class="layui-input" /></td>
				</tr>
					<td class="redstar">*</td>
					<td>备注</td>
					<td><input type="textarea" name="jilu_beizhu" required lay-verify="required" placeholder="请输入备注" autocomplete="off" class="layui-input" /></td>
				</tr>
				<tr>
			    <td align="right" colspan="3">
                <input type="submit" class="layui-btn" value="确定">
                </td>
			    </tr>
			</table>
			</form>
		</div>
	</div>

<div  id="bianjihuikuan2" >
	 	<div id="addform" style="margin:10px;" >
	 	 <form id="bianjihuikuan2" name="lilong" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/bianjihuikuan2" enctype="multipart/form-data" method="post">
	 	 <?php echo ($table); ?>
         </form>

		</div>
	</div>

	<div  id="kaipiaojilu" > 
	 	<div id="addform" style="margin:10px;">
	 	 <form id="kaipiaojilu" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c" enctype="multipart/form-data" method="post">
			<table id="formtable">
			    <tr>
					<td class="redstar">*</td>
					<td>开票记录名称</td>
					<td><input type="text" name="hui_name" required lay-verify="required" placeholder="请输入开票记录名称" class="layui-input"/></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>开票日期</td>
					<td><input type="text" name="kaipiao_date" required lay-verify="required" placeholder="请输入开票日期
					" class="layui-input" class="text ui-widget-content ui-corner-all layui-input" onfocus="WdatePicker({dateFmt:'yyyy-M-d H:mm:ss'})"/></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>开票内容</td>
					<td><input type="text"  name="kaipiao_neirong" required lay-verify="required" placeholder="请输入开票内容" class="layui-input" /></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>开票金额</td>
					<td><input type="text"  name="kaipiao_jine" required lay-verify="required" placeholder="请输入金额" class="layui-input" /><input type="hidden" name="ht_id" value="<?php echo ($_GET['ht_id']); ?>" placeholder="请输入金额" class="layui-input" /></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>票据类型</td>
					<td>
					<select name="kaipiao_type"  style="width:150px;height:25px">
		  							
			  							<?php if(is_array($piaoju)): foreach($piaoju as $sq=>$ywcs): if($ywcs == $valav['pjtype']){ ?>
			  												<option selected="slected" value="<?php echo ($sq); ?>"> <?php echo ($ywcs); ?></option>

			  										<?php	}else{ ?>
			  												<option value=" <?php echo ($sq); ?>"><?php echo ($ywcs); ?></option>
			  										<?php	} endforeach; endif; ?>
	  				</select>
	  				<td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>发票号码</td>
					<td><input type="text" name="kaipiao_haoma" required lay-verify="required" placeholder="请输入发票号码"  class="layui-input" /></td>
				</tr>				<tr>
					<td class="redstar">*</td>
					<td>经手人</td>
					<td><input type="text" name="kaipiao_jingshouren" required lay-verify="required" placeholder="请输入经手人"  class="layui-input" /></td>
				</tr>
				<tr>
					<td class="redstar">*</td>
					<td>备注</td>
					<td><input type="text" name="kaipiao_beizhu" required lay-verify="required" placeholder="请输入备注"  class="layui-input" /></td>
				</tr>
				<tr>
			    <td align="right" colspan="3">
                <input type="submit" class="layui-btn" value="确定">
                </td>
			    </tr>

			</table>
			</form>
		</div>
	</div>

	<div  id="bianjihuikuan3" > 
	 	<div id="addform" style="margin:10px;">
	 	 <form id="bianjihuikuan3" action="<?php echo ($_GET['root_dir']); ?>/index.php/Home/hetong/bianjihuikuan3" enctype="multipart/form-data" method="post">
			
			<?php echo ($table); ?>
		
			</form>
		</div>
	</div>
 		<script>
 		
 		
 		
 		$("#uploadform").hide();
			window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });


		  function openwindow()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'300px',
					title: '文件上传',
					content:$('#uploadform')
				}); 
			});              
		  }
</script>
<script>
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#guanlianchanpin").hide();

function guanlianchanpin()
{
	alert(1);

	layui.use('layer', function(){
	var layer = layui.layer;
	layer.open({
			type:1,
			area:'600px',
			title: '关联产品',
			content:$('#guanlianchanpin')
		}); 
	});              
}
</script>
<script>

window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#guanlianchanpin1").hide();
		   function guanlianchanpin1(e)
		  {
		  	var ass =$(e).attr("id");
		  $.get(rooturl+'/index.php/Home/hetong/guanlian',{"id":ass},
				function(html){
					$('#guanlianchanpin1').html(html);
					  	layui.use('layer', function(){
							var layer = layui.layer;
							layer.open({
								type:1,
								area:'600px',
								title: '编辑',
								content:$('#guanlianchanpin1')
							}); 
						});  


				});

		  }

		  function test_value5()
		  {
				var rrr=$('#gp_id').val();
		  		var aaa=$('#gp_name').val();
			  	var bbb=$('#gp_jianyi').val();
			  	var ccc=$('#gp_shuliang').val();
			    var ddd=$('#ht_id').val();
			  	var eee=$('#gp_beizhu').val();
	
       
			  	$.post(rooturl+'/index.php/Home/hetong/guanlianchanpin1',{"gp_name":aaa,"gp_jianyi":bbb,"gp_shuliang":ccc,"ht_id":ddd,"gp_beizhu":eee,"gp_id":rrr},function(data){
			  		alert(data)
			  		window.location.href=rooturl+'/index.php/Home/hetong/hetongmingcheng';
				});


		  		
		  }

</script>
<script>
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#huikuanjihua").hide();

function huikuanjihua()
{
	layui.use('layer', function(){
	var layer = layui.layer;
	layer.open({
			type:1,
			area:'600px',
			title: '新增回款计划',
			content:$('#huikuanjihua')
		}); 
	});              
}
</script>
<script>
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#huikuanjilu").hide();
		   function huikuanjilu()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'600px',
					title: '新增回款记录',
					content:$('#huikuanjilu')
				}); 
			});              
		  }
</script>

<script>

window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#bianjihuikuan1").hide();
		   function bianjihuikuan1(e)
		  {
		  	var ass =$(e).attr("id");
		  $.get(rooturl+'/index.php/Home/hetong/dantiaobj',{"id":ass},
				function(html){
					$('#bianjihuikuan1').html(html);
					  	layui.use('layer', function(){
							var layer = layui.layer;
							layer.open({
								type:1,
								area:'600px',
								title: '编辑',
								content:$('#bianjihuikuan1')
							}); 
						});  


				});

		  }

		  function test_value()
		  {
				var rrr=$('#hui_id').val();
		  		var aaa=$('#hui_name').val();
			  	var bbb=$('#jihua_date').val();
			  	var ccc=$('#jihua_jine').val();
			    var ddd=$('#ht_id').val();
			  	var eee=$('#jihua_type').val();
			  	var fff=$('#jihua_beizhu').val();
			    var ggg=$('#hui_id').val();

			  	$.post(rooturl+'/index.php/Home/hetong/bianjihuikuan1',{"hui_name":aaa,"jihua_date":bbb,"jihua_jine":ccc,"ht_id":ddd,"jihua_type":eee,"jihua_beizhu":fff,"hui_id":rrr},function(data){
			  		alert(data)
			  		window.location.href=rooturl+'/index.php/Home/hetong/hetongmingcheng';
				});


		  		
		  }

</script>
<script>
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#bianjihuikuan2").hide();
		   function bianjihuikuan2(e)
		  {
		  	var ass =$(e).attr("id");
		  $.get(rooturl+'/index.php/Home/hetong/bianji2',{"id":ass},
				function(html){
					$('#bianjihuikuan2').html(html);
					  	layui.use('layer', function(){
							var layer = layui.layer;
							layer.open({
								type:1,
								area:'600px',
								title: '编辑',
								content:$('#bianjihuikuan2')
							}); 
						});  


				});

		  }
		    function test_value2()
		  {
				var rrr=$('#hui_id').val();
		  		var aaa=$('#hui_name').val();
		  	    var ggg=$('#jilu_fukuan').val();
			  	var bbb=$('#jilu_date').val();
			  	var ccc=$('#jilu_jine').val();
			    var ddd=$('#ht_id').val();
			  	var eee=$('#jilu_type').val();
			  	var fff=$('#jilu_beizhu').val();
			    var hhh=$('#jilu_shoukuanren').val();

			  	$.post(rooturl+'/index.php/Home/hetong/bianjihuikuan2',{"hui_name":aaa,"jilu_date":bbb,"jilu_jine":ccc,"ht_id":ddd,"jilu_type":eee,"jilu_beizhu":fff,"hui_id":rrr,"jilu_fukuan":ggg,"jilu_shoukuanren":hhh},function(data){
			  		alert(data)
			  		window.location.href=rooturl+'/index.php/Home/hetong/hetongmingcheng';
				});


		  		
		  }
</script>
<script>
window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#bianjihuikuan3").hide();
		   function bianjihuikuan3(e)
		  {
		  	var ass =$(e).attr("id");
		  $.get(rooturl+'/index.php/Home/hetong/bianji3',{"id":ass},
				function(html){
					$('#bianjihuikuan3').html(html);
					  	layui.use('layer', function(){
							var layer = layui.layer;
							layer.open({
								type:1,
								area:'600px',
								title: '编辑',
								content:$('#bianjihuikuan3')
							}); 
						});  


				});

		  }
		  function test_value3()
		  {
				var rrr=$('#hui_id').val();
		  		var aaa=$('#hui_name').val();
		  	   
			  	var bbb=$('#kaipiao_date').val();
			  	var iii=$('#kaipiao_neirong').val();
			    var jjj=$('#kaipiao_haoma').val();
			  	var ccc=$('#kaipiao_jine').val();
			    var ddd=$('#ht_id').val();
			  	var eee=$('#kaipiao_type').val();
			  	var fff=$('#kaipiao_beizhu').val();
			    var hhh=$('#kaipiao_jingshouren').val();

			  	$.post(rooturl+'/index.php/Home/hetong/bianjihuikuan2',{"hui_name":aaa,"kaipiao_date":bbb,"kaipiao_jine":ccc,"ht_id":ddd,"kaipiao_type":eee,"kaipiao_beizhu":fff,"hui_id":rrr,"kaipiao_jingshouren":hhh,"kaipiao_neirong":iii,"kaipiao_haoma":jjj},function(data){
			  		alert(data)
			  		window.location.href=rooturl+'/index.php/Home/hetong/hetongmingcheng';
				});


		  		
		  }
</script>
<script>

window.rooturl="<?php echo ($_GET['root_dir']); ?>";
		  $(function() {
   				 $( "#tabs" ).tabs();
 		 });
$("#kaipiaojilu").hide();
		   function kaipiaojilu()
		  {
		  	layui.use('layer', function(){
				var layer = layui.layer;
				layer.open({
					type:1,
					area:'600px',
					title: '新增开票记录',
					content:$('#kaipiaojilu')
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
  		
</html>
	<script>
    		function blurfun(){
    			$(".del").click(function(){

					
					alert($(this).attr("id"))
    				$.get(rooturl+'/index.php/Home/hetong/delete',{"id":$(this).attr("id")},
							        		 				function(html){
							        		 					alert(html)
															$(".fujian_del").html(html);
															blurfun();

															});

    			});
    		};
    		blurfun();
    	</script>