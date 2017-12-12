<?php
namespace Home\Controller;
use Think\Controller;


class HetongmingchengController extends Controller {

		public function ywzd(){                               //业务字段表--联系人
		$ywzd_base=M('yewuziduan');
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$map['zd_yewu']=6;
		$sql_ywzd=$ywzd_base->where($map)->find();
		$sql_json=json_decode($sql_ywzd['zd_data'],true);
		foreach($sql_json as $k=>$v)
		{
			if($v['qy']=="1")
			{
				$sql[$v['id']]=$v;
			}
		}
			return $sql;
		}
		public function ywcs(){
			$data['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$data['ywcs_yw']='6';
			$ywcs_base=M('ywcs');
			$sql=$ywcs_base->where(array($data))->field('ywcs_data')->find();


			$sql_json=json_decode($sql['ywcs_data'],true);
		
			foreach($sql_json as $k=>$v)
			{
				$sql_json2='';
					foreach($v['qy'] as $kqy =>$vqy)
					{
						if($vqy==1)
						{
							$sql_json2[$kqy]=$v[$kqy];
						}	
					}
					
				
				$sql_json3[$v['id']]=$sql_json2;
			}
			return $sql_json3;
		}
		public function user(){                 //负责人和dddd
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		
	 	$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门ddddd
		}

		$fuzeren=M('user');

		
			$m=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
	
	 	$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_fid=$m or user_id =$m");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
					
			}  


return $fzr_only;



	}
		public function kehu(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map' ");
		
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh_name[$vkh['kh_id']]=$kh;
		}
		//echo "<pre>";
		//var_dump($kh_name);exit;
		return $kh_name;
	}
		public function shangji()
		{
			$xiaji= $this->get_xiashu_id();//  查询下级ID
			
			$sj_base=M('shangji');
			$data_sj=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$data_sj'");// 查询商机信息
			foreach($userarr as $k => $v)
			{
				foreach($v as $k1 => $v1)
				{
					if($k1!='sj_data')
					{
						$sql_sj[$k1]=$v1;	
					}else{
						$sj_json=json_decode($v[$k1],true);
						foreach($sj_json as $k2=>$v2)
						{
							$sql_sj[$k2]=$v2;
						}	
					}	
					$sql_sj1[$v['sj_id']]=$sql_sj;
				}
				
			}
		
			return $sql_sj1;
		}
		public function hetongmingcheng(){
			$yzdl=A('DB');
			$yzdl->is_login2(2);
			$yzdl->have_qx2("qx_ht_open");//跳转权限验证
			
			$uiid=$_GET['uiid'];
			if($uiid=='' || $uiid==null)
			{
				$uiid=1;
			}else{
				$uiid=$uiid;
				
			}
			$this->assign('uiid',$uiid);
				$userqb=$this->userqb();

			$ywzd=$this->ywzd();
			$user=$this->user();
		//	echo"<pre>";
		//	var_dump($user);exit;
			$kehu=$this->kehu();
			$ywcs=$this->ywcs();
		

			$shangji=$this->shangji();
			$chanpin=$this->chanpin();
			
			$ht_id=$_GET['id'];
			$map['ht_id']=$ht_id;//联系人条件
			$map['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件          
			$lx_base=M("hetong");
			$sql_lianxi=$lx_base->where($map)->find();
			$xiaji1= $this->get_xiashu_id();//  查询用户
			$new_xiaji1=$xiaji1; 
			$new_array1=explode(',',$new_xiaji1);
			$qxa=0;
			foreach($new_array1 as $k=>$v)
			{
				if(	$sql_lianxi['ht_fz']==$v)
				{

					$qxa++;
				}
			}
			
		
			if($qxa<1)
			{
				echo "<script> alert('您没有查看此客户权限~');history.go(-1); 
				 
				</script>";die;
			}
			$ht_sp918=$sql_lianxi['ht_sp'];
			$this->assign('ht_sp918',$ht_sp918);
			$ht_json=json_decode($sql_lianxi['ht_data'],true);
			$ht_zje=$ht_json['zdy3'];
			$this->assign('ht_zjea',$ht_zje);
		
	
			foreach ($ywzd as $k => $v){
				$show.="<tr style='line-height:40px'><td style='width :150px'>".$v['name']."：</td>";
				if($ht_json[$k]!=""){
					if($k == 'zdy1')
					{
						$show.="<td title='".$kehu[$ht_json[$k]]['name']."' style='cursor:pointer'>".$kehu[$ht_json[$k]]['name']."</td>";	
					}elseif($k=='zdy2'){
						$show.="<td title='".$shangji[$ht_json[$k]]['zdy0']."' style='cursor:pointer'>".$shangji[$ht_json[$k]]['zdy0']."</td>";	
					}elseif($k=='zdy7' || $k=='zdy10' || $k=='zdy11'){
						$show.="<td >".$ywcs[$k][$ht_json[$k]]."</td>";
					}elseif($k=='zdy13'){

												


					$show.="<td >".$userqb[$ht_json[$k]]['user_name']."</td>";	
			
					}elseif($k=="zdy17"){
							$aaa=strlen($ht_json[$k]);
							if($aaa>40)
							{
								$bzhu=mb_substr($ht_json[$k],0,40,'utf-8')."···";	
							}else{
								$bzhu=$ht_json[$k];
							}
							$show.="<td> <span title='".$ht_json[$k]."' style='cursor:pointer'>".$bzhu." </span></td>";
					}else{
							$show.="<td title='".$ht_json[$k]."' style='cursor:pointer'>".$ht_json[$k]."</td>";	
						}	
				}else{
					if($k == 'zdy9')
					{
						
						$show.="<td onclick='ht_cp(this)' class='".$ht_id."' title='点击查看附件' style='color:#1AA094;cursor:pointer'>产品</td>";	

					}elseif($k=="zdy14")
					{
						$show.="<td  onclick='ht_fj(this)' class='".$ht_id."' title='点击查看产品' style='color:#1AA094;cursor:pointer'>附件</td>";	
					}elseif($k=="zdy17"){
							$aaa=strlen($ht_json[$k]);
							if($aaa>40)
							{
								$bzhu=mb_substr($ht_json[$k],0,40,'utf-8')."···";	
							}else{
								$bzhu=$ht_json[$k];
							}
							$show.="<td> <span title='".$ht_json[$k]."' style='cursor:pointer'>".$bzhu." </span></td>";
					}else{
						$show.="<td >未填写</td>";	
					}
					
				}
				$show.="</tr>";
			}
			$array_jiansuo=array('ht_fz'=>"负责人",'ht_bm'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"最新跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"原负责人",'ht_old_bm'=>"原负责人部门",'ht_cj_date'=>"创建时间","ht_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
					$new_str1['id']=$k;
					$new_str1['name']=$v;
					$new_str1['qy']=1;
					$new_str1['type']=0;
					$new_arrayoo[$k]=$new_str1;
				}
			foreach($new_arrayoo as $k=>$v)
			{
				$show1.="<tr style='line-height:40px'><td style='width :150px'>".$v['name']."：</td>";
				if($sql_lianxi[$k]!=""){
						if($k=='ht_fz' || $k=='ht_old_fz' ||$k=='ht_cj')
						{
							$show1.="<td >".$user[$sql_lianxi[$k]]['user_name']."</td>";
						}elseif($k=='ht_spzt'){
								
						}elseif($k=='ht_new_gj'){
								$show1.="<td >".$sql_lianxi[$k]."</td>";
						}elseif($k=='ht_bm'){
								$show1.="<td >".$sql_lianxi[$k]."</td>";
						}elseif($k=='ht_gx_date'){
								$show1.="<td >".$sql_lianxi[$k]."</td>";
						}
						else{
							$show1.="<td >".date("Y-m-d H:i:s", $sql_lianxi[$k])."</td>";
						}
							    
				}else{
					$show1.="<td >未填写</td>";
				}
				$show1.="</tr>";
			} 
		
			$show3.="<table class='uk-form'>";
		$show3.="<tr><td></td><td><input type='hidden' class='ht_id1' value='".$ht_id."'></td></tr>";
			foreach ($ywzd as $k => $v){
				if($k=="zdy9" || $k=='zdy14'){
					continue;
				}
			
			
				$show3.="<tr style='line-height:30px;height:40px'><td style='width :150px'>".$v['name']."：</td>";
	
					if($k == 'zdy1')
					{
						$show3.="<td ><select name='$k' onchange='get_sj(this)' class='bjwh'>";

						
						foreach($kehu as $k2=>$v2)
						{
							if($k2==$ht_json[$k])
							$show3.="<option value='".$v2['id']."' selected='selected'>".$v2['name']."</option>";
							
						}
						$show3.="</select></td>";	
					}elseif($k=='zdy2'){

						$show3.="<td class='th_sj'><select name='".$k."' class='bjwh'>";
						
							
							
									$show3.="<option value='".$ht_json['zdy2']."' selected='selected'>".$shangji[$ht_json['zdy2']]['zdy0']."</option>";		
					
									
							
								
							
						
						$show3.="</select></td>";	
					}elseif($k=='zdy7' || $k=='zdy10' || $k=='zdy11'){
						$show3.="<td ><select  class='bjwh' name='$k'>";
							if($ht_json[$k]==''){
								$show3.="<option value='' selected='selected'>--请选择--</option>";
							}
							foreach($ywcs[$k] as $k4 =>$v4)
							{	
								
									if($k4==$ht_json[$k])
									$show3.="<option value='".$k4."' selected='selected'>".$v4."</option>";
									else{
									$show3.="<option value='".$k4."'>".$v4."</option>";
									}
							
								
							}

						$show3.="</select></td>";
					
					}elseif($k=='zdy4' || $k=='zdy5'  ||$k=='zdy6' || $k=='zdy15'){
						$show3.="<td ><input type='text' class='bjwh' name='$k' value='".$ht_json[$k]."' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td>";	
					}elseif($k=='zdy13'){

												


						$show3.="<td ><select  class='bjwh' name='$k'>";
						
						
						
							foreach($userqb as $k11=>$v11)
							{
								if($v11['user_id']==$ht_json[$k])
								{
								$show3.="<option value='".$v11['user_id']."' selected='selected'>".$v11['user_name']."</option>";
								}else{
								$show3.="<option value='".$v11['user_id']."' >".$v11['user_name']."</option>";
								}

							}
						$show3.="</select></td>";	
					}elseif($k=='zdy17'){
								$show3.="<td><textarea name='".$k."'  maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400' >".$ht_json[$k]."</textarea></td>";
							}else{
						$show3.="<td ><input type='text' class='bjwh' name='$k' value='".$ht_json[$k]."' maxlength='40'></td>";	
					}	
				
				$show3.="</tr>";;

			}
			$show3.="</table>";
			//合同附件查询
			$file['mk']=6;
			$file['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$file['name_id']=$ht_id;
			$file_base=M('file');
			$sql_file=$file_base->where($file)->select();
			if($sql_file==''||$sql_file==null){
				$file_show.="<tr><td colspan='30' align='center'><span>亲~没有数据哟！请上传附件</td></tr>";
			}else{
				foreach($sql_file as $k=>$v)
				{
					$file_show.="<tr class='".$v['id']."'>
					  				<td >". $v['sc_data']."</td>
					  				<td class='bzsl' title='".$v['fujian_name']."' style='cursor:pointer'><span onclick='fj_xz(this)' class='".$v['lujing']."' style='color:green;cursor:pointer' title='点击下载' >".$v['fujian_name']."</span></td>
					  				<td >".$v['big']."</td>
					  				<td class='bzsl' title='".$v['beizhu']."' style='cursor:pointer'>".$v['beizhu']."</td>
					  				<td ><input type='button' value='删除' onclick='fujian_del(this)' name='".$v['id']."'></td>
								</tr> ";
				}
			}
			//产品查询
			$cp['cp_mk']=6;
			$cp['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$cp['sj_id']=$ht_id;
			$cp_ht=M('cp_sj');
			$sql_cp_sql=$cp_ht->where($cp)->select();

			foreach($sql_cp_sql as $k=>$v)
			{
				$v['zdy0']=$chanpin[$v['cp_id']]['zdy0'];
				$v['zdy1']=$chanpin[$v['cp_id']]['zdy1'];
				$v['zdy3']=$chanpin[$v['cp_id']]['zdy3'];
				$v['zdy6']=$chanpin[$v['cp_id']]['zdy6'];
				$cp_new[$v['cp_id1']]=$v;
			}
			$zje913=0;
			if($cp_new==''||$cp_new==null){
				$show2.="<tr><td colspan='9' align='center'><span>亲~没有数据哟！请添加相关产品</td></tr>";
			}else{
				foreach ($cp_new as $k=>$v)
				{
					$show2.="<tr class='".$v['cp_id1']."'>
					<td class='bzsl' title='".$v['zdy0']."' style='cursor:pointer'>".$v['zdy0']."</td>
					<td class='bzsl' title='".$v['zdy1']."' style='cursor:pointer'>".$v['zdy1']."</td>
					<td>".$v['cp_yj']."</td>
					<td>".$v['cp_jy']."</td>
					<td>".$v['cp_num1']."</td>
					<td>".$v['cp_zk']."</td>
					<td>".$v['cp_zj']."</td>
			
					<td class='bzsl' title='".$v['cp_beizhu']."' style='cursor:pointer'>".$v['cp_beizhu']."</td>
					<td><input type='button' name='".$v['cp_id1']."' onclick='cp_del(this)' value='删除'></td>
					</tr>";
					$zje913=$zje913+$v['cp_zj'];
				}
			}
			if($zje913==$ht_zje)
			{
				$zje9133="<span style='color:green'>".$zje913."</span>";
			}else{
				$zje9133="<span style='color:red'>".$zje913."</span>";
			}
			$this->assign('zje9133',$zje9133);
				$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id' onchange='cp_aj(this)' class ='clk_fzr' id='xlcp' style='width:300px;height:26px;'>";
							$chanpin1.="<option value='s'>请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0'].$v['zdy1']." </option>";
					}
					$chanpin1.="</select> </td></tr>";
			//回款计划开始咯
			$hk_base=M('hk');
			$hk_map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$hk_map['hk_htid']=$ht_id;
			$sql_hk=$hk_base->where($hk_map)->select();
			$sql_hk_count=$hk_base->where($hk_map)->count();
			$zonghkjh=0;
					$zb=0;
			foreach($sql_hk as $k=>$v)
			{
				$zonghkjh=$v['hk_je']+$zonghkjh;
				$zb=$v['hk_zb']+$zb;
			}
			$this->assign('zonghkjh',$zonghkjh);
			$this->assign('zb',$zb);
			$hkzje=0;

			foreach($sql_hk as $k=>$v)
			{	

				$hkzje=$hkzje+$v['hk_je'];  //计划回款总金额

			}
			$shenpi_arr=array("0"=>"待审批","1"=>"审批通过","2"=>"审批驳回");
			//查询已添加的回款
			$add_hk_base=M("hkadd");
			$hk_addmap['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$hk_addmap['hk_ht']=$ht_id;
			$sql_hk_add=$add_hk_base->where($hk_addmap)->select();
			
			foreach($sql_hk_add as $k=>$v)
			{
				$count[$v['hk_qici']][]=$v;
			}
			$yihuikuan[$v1['hk_qici']]=0;
			$zonghk=0;
			
			foreach($count as $k=>$v)
			{
				foreach($v as $k1=>$v1)
				{	if($v1['hk_sp']==1)
					{
					$yihuikuan[$v1['hk_qici']]=$v1['hk_je']+$yihuikuan[$v1['hk_qici']];
				}
				}
				$zonghk=$zonghk+$yihuikuan[$v1['hk_qici']];//全部回款$zonghk；
			}

			
			$dinum=1;
			

				
				foreach($sql_hk as $k=>$v)
				{
					$yhk[$v['hk_id']]=0;
					foreach($sql_hk_add as $k7=>$v7)
					{
						if($v7['hk_sp']==1 && $v['hk_id']==$v7['hk_qici'])
						{
							$yhk[$v['hk_id']]=$v7['hk_je']+$yhk[$v['hk_id']];
						}
						
					}

					$weihuikuan=$v['hk_je']-$yhk[$v['hk_id']];
					$hk_jihua.="<div class='long'>";  
						$hk_jihua.="<div class='backg'>";
							$hk_jihua.="<div class='kongzhi1'><span class='hkshow'>第<b>".$sql_hk_count."-".$dinum."</b>期回款计划：".$v['hk_data']."</span><span class='hkshow'>计划回款总金额：¥<b> ".$v['hk_je']."</b></span><span class='hkshow'>占比：¥<b> ".$v['hk_zb']."%</b></span><span class='hkshow'> 已回款总金额：¥ <b>".$yhk[$v['hk_id']]."</b></span> <span class='hkshow'>未回款总金额：¥<b>".$weihuikuan."</b></span><span  class='hkshow'>未完成</span> <span class='shet'> <i class='layui-icon xiaoshou' id='".$v['hk_id']."' style='font-size: 17px; ' onclick='shanchu_pz(this)' >&#xe640;</i> <i class='layui-icon xiaoshou' id='".$v['hk_id']."' onclick='xiugai_pz(this)' style='font-size: 17px; '>&#xe642;</i> </span> <button  id='create-sahngji' onclick='xzjh(this)' name='".$v['hk_id']."' class='layui-btn layui-btn-small add_wz' >新增回款记录</button>
						  	</div>
						  </div>";
					  	$hk_jihua.="<table class='layui-table' lay-skin='line' style='width:100%; table-layout:fixed'>
							  	<thead >
							  		<th >操作</th>
					  				<th >审批状态</th>
					  				<th >回款日期</th>
					  				<th >回款金额</td>
					  				<th >付款方式</th>
					  				<th >回款类型</th>
					  				<th >收款人</th>
					  				<th >备注</th>
								</thead>";
								$abc=0;
							
								foreach($sql_hk_add as $k3=>$v3)
								{
									
									
										if($v['hk_id']==$v3['hk_qici']){
											$abc++;
											$hk_jihua.="<tbody class='fujian_del'>
												<tr>
												";
												if($v3['hk_sp']==0)
												{
														$hk_jihua.="<td >不可操作</td><td ><span  >".$shenpi_arr[$v3['hk_sp']]."</span></td>";
												}elseif($v3['hk_sp']==1)
												{	
													$hk_jihua.="<td >不可操作</td><td ><span style='color:green' >".$shenpi_arr[$v3['hk_sp']]."</span></td>";
												}elseif($v3['hk_sp']==2)
												{
													$hk_jihua.="<td > <i class='layui-icon' id='".$v3['hk_id']."' style='font-size: 17px;cursor:pointer ' onclick='del_hkadd(this)' >&#xe640;</i> <i class='layui-icon' id='".$v3['hk_id']."' onclick='bjjh(this)' style='font-size: 17px;cursor:pointer '>&#xe642;</i></td><td ><span style='color:red;cursor:pointer' onclick='bh_yy1(this)' class='".$v3['hk_id']."'>".$shenpi_arr[$v3['hk_sp']]."</span></td>";
												}
												
												$hk_jihua.="<td >".$v3['hk_data']."</td>
												<td >".$v3['hk_je']."</td>
												<td >".$ywcs['zdy11'][$v3['zdy11']]."</td>
												<td >".$ywcs['hktype'][$v3['hk_type']]."</td>
												<td >".$user[$v3['hk_skr']]['user_name']."</td>
												<td class='bzsl' title='".$v3['hk_bz']."' style='cursor:pointer'>".$v3['hk_bz']."</td>
												</tr>  
												</tbody>";
										}
									
								}
								if($abc==0){
											$hk_jihua.="	<tbody class='fujian_del'>
											<tr><td colspan='8'  height='120px' >
												<i class='layui-icon xiaolian' style='font-size:80px;float:left;position:relative;left:50%;margin-left:-200px;'><b>&#xe60c;</b></i>

												<span style='margin-left:45%'>亲~ 还没有数据哦～ <span style='color:#07d;cursor:pointer;cursor:pointer;' id='".$v['hk_id']."' onclick='xzjh(this)'>新增回款记录 >></span></span>
											</td></tr>  
											</tbody>";
								}
			 					$hk_jihua.="</table>
				 	</div>";
				 	$dinum++;
				}
				if($dinum==1)
				{
					$mengen=0;
				}else{
					$mengen=$dinum-1;
				}
				$this->assign('pz_num',$mengen);    
			//这里往下是新增计划、1234567485674896789798789789789 
			
			$xz_jh.="<table class='uk-form ' >";
		    			$xz_jh.="<tr>
		    						<td><span style='color:red' >*</span>回款日期：</td><td><input type='text' name='hk_data'  onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red' >*</span>回款金额：</td><td><input type='number' name='hk_je' value=''></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red' >*</span>对应客户：</td><td><select name='hk_kh'><option value='".$ht_json['zdy1']."'>".$kehu[$ht_json['zdy1']]['name']."</option></select></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red' >*</span>合同标题：</td><td><select name='hk_ht'><option value='".$ht_id."'>".$ht_json['zdy0']."</option></select></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red' >*</span>合同期次：</td><td class='qicia'><select name='ht_qici'><option value=''>第".$v."期</option></select></td>
		    					</tr>
		    					<tr>
		    						<td>付款方式：</td><td><select name='zdy11'>";
		    						foreach($ywcs['zdy11'] as $k=>$v)
		    						{
		    							$xz_jh.="<option value='".$k."'>".$v."</option>";
		    						}
		    					$xz_jh.="	</select>
		    					</td>
		    					</tr>
		    					<tr>
		    						<td>回款类型：</td><td><select name='hk_type'>";
									foreach($ywcs['hktype'] as $k=>$v)
		    						{
		    							$xz_jh.="<option value='".$k."'>".$v."</option>";
		    						}
		    						
		    					$xz_jh.="</select></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red' >*</span>收款人：</td><td><select name='hk_skr'>";
		    							foreach($user as $k=>$v)
				    						{
				    							$xz_jh.="<option value='".$k."'>".$v['user_name']."</option>";
				    						}
		    						$xz_jh.="</select></td>
		    					</tr>
		    					<tr>
		    						<td>备注：</td><td><input type='text' name='hk_bz' value=''></td>
		    					</tr>";

		    			$xz_jh.="</table>";
		    
		    $weihka=$hkzje-$zonghk;
		    $kp_type_arr=array('0' => "增值税普通发票", '1' => "增值税专用发票",'2' => "国税通用机打发票",'3' => "地税通用机打发票",);
		    $kaipiao.="<table class='uk-form ' >";
		    			 $kaipiao.="<tr>

		    						<td><span style='color:red'>＊</span>开票日期:</td><td><input type='text' class='required' name='kp_date' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>票据内容:</td><td><input type='text' name='kp_data' class='required'></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>开票金额:</td><td><input type='text' name='kp_je' class='required'></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>票据类型:</td><td><select name='kp_type' onchange='fapiao(this)' class='required'>
		    							<option value=''>--请选择发票--</option>
		    							<option value='0'>增值税普通发票</option>
		    							<option value='1'>增值税专用发票</option>
		    							<option value='2'>国税通用机打发票</option>
		    							<option value='3'>地税通用机打发票</option>
		    						</select></select></td>
		    					</tr>

		    					

		    					
		    					
		    					<tr>

		    						<td><span style='color:red'>＊</span>合同标题:</td><td><select name='kp_ht' class='required'><option value='".$ht_id."'>".$ht_json['zdy0']."</option></select></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>对应客户:</td><td><select name='kp_kh' class='required'><option value='".$ht_json['zdy1']."'>".$kehu[$ht_json['zdy1']]['name']."</option></select></td>
		    					</tr>
		    					<tr>
		    						<td>发票号码:</td><td><input type='text' name='kp_number'></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>经手人:</td><td><select name='kp_user' class='required'>";
		    							foreach($user as $k=>$v)
				    						{
				    							 $kaipiao.="<option value='".$k."'>".$v['user_name']."</option>";
				    						}
		    						 $kaipiao.="</select></td>
		    					</tr>
		    					<tr>
		    						<td><span style='color:red'>＊</span>备注:</td><td><input type='text' name='kp_bz' class='required'></td>
		    					</tr>
		    			</table>";
		    $kp_base=M('kp');
		    $kp_map['kp_ht']=$ht_id;

		    $kp_map['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		    $sql_kp= $kp_base->where($kp_map)->select();
			
			$sq_kp=0;
		
		   	foreach ($sql_kp as $k=>$v)
		   	{	if($v['kp_sp']==1){
		   		$sq_kp=$sq_kp+$v['kp_je'];
		   	}

		   		if($v['kp_type']==0)
		   		{
		   			$sql_kp1[]=$v;
		   		}elseif($v['kp_type']==1)
		   		{
					$sql_kp2[]=$v;
		   		}elseif($v['kp_type']==2)
		   		{
		   			$sql_kp3[]=$v;
		   		}elseif($v['kp_type']==3){
		   			$sql_kp4[]=$v;
		   		}
		   	} 
		   	if($sql_kp1!="")
		   	{
		   		$this->assign('yi','yi');
		   	}elseif($sql_kp2!=""){
		   		$this->assign('yi','er');
		   	}elseif($sql_kp3!=""){
		   		$this->assign('yi','san');
		   	}elseif($sql_kp4!=""){
		   		$this->assign('yi','si');
		   	}else{
		   		$this->assign('yi','yi');
		   	}
		   	$wkp=$ht_zje-$sq_kp;
		   	$this->assign('wkp',$wkp);	
		   	$this->assign('sq_kp',$sq_kp);
		    if($sql_kp1=="" ||  $sql_kp1==null)
		    {
					$kp_show.="	<tr class='qingxuanze'>
						<td colspan='8'><span>亲~ 还没有数据哦～<span onclick='xzkp()'
						style='color:#07d;cursor:pointer;font-weight:bold' class='wtgbky'>新增开票记录>></span></span></td>
					</tr>";
					

		    }else{
		    	foreach($sql_kp1 as $k=>$v)
			    	{
	
							$kp_show.="<tr>	";
								if($v['kp_sp']==0)
								{
										$kp_show.="<td>不允许操作</td><td ><span >".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==1)
								{
										$kp_show.="<td>不允许操作</td><td ><span style='color:green'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==2)
								{
										$kp_show.="<td ><span style='margin-left:10px'  class='".$v['kp_id']."' onclick='sc_kp(this)'><i class='layui-icon'  style='font-size:20px;cursor:pointer'>&#xe640;</i></span></td><td ><span style='color:red;cursor:pointer ' onclick='bh_yy(this)' class='".$v['kp_id']."'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}
						
								$kp_show.="<td title='".$v['kp_date']."' style='cursor:pointer'>".$v['kp_date']."</td>
											<td title='".$v['kp_data']."' style='cursor:pointer'>".$v['kp_data']."</td>
											<td title='".$v['kp_je']."' style='cursor:pointer'>".$v['kp_je']."</td>
											<td title='".$kp_type_arr[$v['kp_type']]."' style='cursor:pointer'>". $kp_type_arr[$v['kp_type']]."</td>
											<td title='".$v['kp_fp_tt']."' style='cursor:pointer'>".$v['kp_fp_tt']."</td>
											<td title='".$v['kp_fp_sbm']."' style='cursor:pointer'>".$v['kp_fp_sbm']."</td>
											<td title='".$v['kp_number']."' style='cursor:pointer'>".$v['kp_number']."</td>
											<td title='".$user[$v['kp_user']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_user']]['user_name']."</td>
											<td title='".$v['kp_bz']."' style='cursor:pointer'>".$v['kp_bz']."</td>
											<td title='".$user[$v['kp_cj']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_cj']]['user_name']."</td>
											<td title='".$v['kp_cj_date']."' style='cursor:pointer'>".$v['kp_cj_date']."</td>
										</tr>"; 
			    	}
		    	}
		   if($sql_kp2=="" ||  $sql_kp2==null)
		    {
					$kp_show1.="<tr class='qingxuanze'>
						<td colspan='8'><span>亲~ 还没有数据哦～<span onclick='xzkp()'
						style='color:#07d;cursor:pointer;font-weight:bold' class='wtgbky'>新增开票记录>></span></span></td>
					</tr>";
					

		    }else{
		    	foreach($sql_kp2 as $k=>$v)
			    	{
	
							$kp_show1.="<tr>	";
								if($v['kp_sp']==0)
								{
										$kp_show1.="<td>不允许操作</td><td ><span >".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==1)
								{
										$kp_show1.="<td>不允许操作</td><td ><span style='color:green'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==2)
								{
										$kp_show1.="<td ><span style='margin-left:10px'  class='".$v['kp_id']."' onclick='sc_kp(this)'><i class='layui-icon'  style='font-size:20px;cursor:pointer'>&#xe640;</i></span></td><td ><span style='color:red;cursor:pointer' onclick='bh_yy(this)' class='".$v['kp_id']."'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}
						
								$kp_show1.="<td title='".$v['kp_date']."' style='cursor:pointer'>".$v['kp_date']."</td>
											<td title='".$v['kp_data']."' style='cursor:pointer'>".$v['kp_data']."</td>
											<td title='".$v['kp_je']."' style='cursor:pointer'>".$v['kp_je']."</td>
											<td title='".$kp_type_arr[$v['kp_type']]."' style='cursor:pointer'>". $kp_type_arr[$v['kp_type']]."</td>
											<td title='".$v['kp_fp_dw']."' style='cursor:pointer'>".$v['kp_fp_dw']."</td>
											<td title='".$v['kp_fp_sbm1']."' style='cursor:pointer'>".$v['kp_fp_sbm1']."</td>
											<td title='".$v['kp_fp_zcdz']."' style='cursor:pointer'>".$v['kp_fp_zcdz']."</td>
											<td title='".$v['kp_fp_zcdh']."' style='cursor:pointer'>".$v['kp_fp_zcdh']."</td>
											<td title='".$v['kp_fp_khyh']."' style='cursor:pointer'>".$v['kp_fp_khyh']."</td>
											<td title='".$v['kp_fp_yhzh']."' style='cursor:pointer'>".$v['kp_fp_yhzh']."</td>
											<td title='".$v['kp_fp_spr']."' style='cursor:pointer'>".$v['kp_fp_spr']."</td>
											<td title='".$v['kp_fp_sprphone']."' style='cursor:pointer'>".$v['kp_fp_sprphone']."</td>
											<td title='".$v['kp_fp_sheng']."' style='cursor:pointer'>".$v['kp_fp_sheng']."</td>
											<td title='".$v['kp_fp_xiangxi']."' style='cursor:pointer'>".$v['kp_fp_xiangxi']."</td>
											<td title='".$v['kp_number']."' style='cursor:pointer'>".$v['kp_number']."</td>
											<td title='".$user[$v['kp_user']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_user']]['user_name']."</td>
											<td title='".$v['kp_bz']."' style='cursor:pointer'>".$v['kp_bz']."</td>
											<td title='".$user[$v['kp_cj']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_cj']]['user_name']."</td>
											<td title='".$v['kp_cj_date']."' style='cursor:pointer'>".$v['kp_cj_date']."</td>
										</tr>"; 
			    	}
		    	}
		    	
		   if($sql_kp3=="" ||  $sql_kp3==null)
		    {
					$kp_show2.="	<tr class='qingxuanze'>
						<td colspan='8'><span>亲~ 还没有数据哦～<span onclick='xzkp()'
						style='color:#07d;cursor:pointer;font-weight:bold' class='wtgbky'>新增开票记录>></span></span></td>
					</tr>";
					

		    }else{
		    	foreach($sql_kp3 as $k=>$v)
			    	{
	
							$kp_show2.="<tr>	";
								if($v['kp_sp']==0)
								{
										$kp_show2.="<td>不允许操作</td><td ><span >".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==1)
								{
										$kp_show2.="<td>不允许操作</td><td ><span style='color:green'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==2)
								{
										$kp_show2.="<td ><span style='margin-left:10px'  class='".$v['kp_id']."' onclick='sc_kp(this)'><i class='layui-icon'  style='font-size:20px;cursor:pointer'>&#xe640;</i></span></td><td ><span style='color:red;cursor:pointer' onclick='bh_yy(this)' class='".$v['kp_id']."'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}
						
								$kp_show2.="<td title='".$v['kp_date']."' style='cursor:pointer'>".$v['kp_date']."</td>
											<td title='".$v['kp_data']."' style='cursor:pointer'>".$v['kp_data']."</td>
											<td title='".$v['kp_je']."' style='cursor:pointer'>".$v['kp_je']."</td>
											<td title='".$kp_type_arr[$v['kp_type']]."' style='cursor:pointer'>". $kp_type_arr[$v['kp_type']]."</td>
											
											<td title='".$v['kp_number']."' style='cursor:pointer'>".$v['kp_number']."</td>
											<td title='".$user[$v['kp_user']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_user']]['user_name']."</td>
											<td title='".$v['kp_bz']."' style='cursor:pointer'>".$v['kp_bz']."</td>
											<td title='".$user[$v['kp_cj']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_cj']]['user_name']."</td>
											<td title='".$v['kp_cj_date']."' style='cursor:pointer'>".$v['kp_cj_date']."</td>
										</tr>"; 
			    	}
		    	}

		    if($sql_kp4=="" ||  $sql_kp4==null)
		    {
					$kp_show3.="	<tr class='qingxuanze'>
						<td colspan='8'><span>亲~ 还没有数据哦～<span onclick='xzkp()'
						style='color:#07d;cursor:pointer;font-weight:bold' class='wtgbky'>新增开票记录>></span></span></td>
					</tr>";
					

		    }else{
		    	foreach($sql_kp4 as $k=>$v)
			    	{
	
							$kp_show3.="<tr>	";
								if($v['kp_sp']==0)
								{
										$kp_show3.="<td>不允许操作</td><td ><span >".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==1)
								{
										$kp_show3.="<td>不允许操作</td><td ><span style='color:green'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}elseif($v['kp_sp']==2)
								{
										$kp_show3.="<td ><span style='margin-left:10px'  class='".$v['kp_id']."' onclick='sc_kp(this)'><i class='layui-icon'  style='font-size:20px;cursor:pointer'>&#xe640;</i></span></td><td ><span style='color:red;cursor:pointer' onclick='bh_yy(this)' class='".$v['kp_id']."'>".$shenpi_arr[$v['kp_sp']]."</span></td>";
								}
						
								$kp_show3.="<td title='".$v['kp_date']."' style='cursor:pointer'>".$v['kp_date']."</td>
											<td title='".$v['kp_data']."' style='cursor:pointer'>".$v['kp_data']."</td>
											<td title='".$v['kp_je']."' style='cursor:pointer'>".$v['kp_je']."</td>
											<td title='".$kp_type_arr[$v['kp_type']]."' style='cursor:pointer'>". $kp_type_arr[$v['kp_type']]."</td>
											
											<td title='".$v['kp_number']."' style='cursor:pointer'>".$v['kp_number']."</td>
											<td title='".$user[$v['kp_user']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_user']]['user_name']."</td>
											<td title='".$v['kp_bz']."' style='cursor:pointer'>".$v['kp_bz']."</td>
											<td title='".$user[$v['kp_cj']]['user_name']."' style='cursor:pointer'>".$user[$v['kp_cj']]['user_name']."</td>
											<td title='".$v['kp_cj_date']."' style='cursor:pointer'>".$v['kp_cj_date']."</td>
										</tr>"; 
			    	}
		    	}
		    
								$gj_xgj.="<select name='genjinzhuantai' class='gjzt12' style='width:190px;height:40px'>";
									if($ht_json['zdy7']=='' || $ht_json['zdy0']==null)
									{
										$gj_xgj.="<option  selected='selected'>--请选择--</option>";
									}
			  						foreach($ywcs['zdy7'] as $k=>$v)
									{
										if($ht_json['zdy7']==$k)
										{
											$gj_xgj.="<option value='".$k."' selected='selected'>".$v."</option>";
										}else{
											$gj_xgj.="<option value='".$k."'>".$v."</option>";
										}
										
										
									}
	  							$gj_xgj.="</select>"; //这里是写跟进的 跟进状态\
	  		$xiegenjin_base=M('xiegenjin');
	  			$map_xiegenjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$map_xiegenjin['mode_id']=6;
				$map_xiegenjin['kh_id']=$ht_id;
				$sql_xiegenjin=$xiegenjin_base->where($map_xiegenjin)->order("add_time desc")->select();
				if($sql_xiegenjin=="" || $sql_xiegenjin==null)
				{
					$xgj_show.="<table  style='margin-left:40%;margin-top:20%'><tr><td><i class='layui-icon' style='font-size: 140px; color: #999;'>&#xe64d;</i></td></tr>
						 <tr><td ><span style='margin-left:25px;color:#999'>暂无跟进记录</span></tr> </table>";
				}
				foreach($sql_xiegenjin as $k=>$v)
				{
					$xgj_show.="<div class='gj_mod'>";
						$da[$k] =substr($v['add_time'],0,10);
							$daa[$k] =substr($v['add_time'],11,5);
						if($da[$k]==$da[$k-1]){
						}else{
						$xgj_show.="<div class='gj_head'><div class='gj_head_point'></div><div class='gj_head_date'>".$da[$k]."</div></div>";
						}
						$xgj_show.="
						<div class='gj_body'>
							<div class='gj_body_icon'><i class='fa fa-pencil'></i></div>
							<div class='gj_body_content'>
								<div class='gj_body_content_head'>
									<img src='' class='gj_headimg woca'>
									<span class='user_name'>
									".$user[$v['user_id']]['user_name']."</span>".$daa[$k]."<span class='gj_fangshi'>".$v['type'].":<span style='color:#07d'>".$lx_json['zdy0']."</span>
									</span>
								<span style='float:right;cursor:pointer;' id='".$v['genjin_id']."' title='点击删除' onclick='del_gj(this)' ><i class='layui-icon'>&#xe640;</i>  </span>
								</div>
								<div class='gj_body_content_content'>".$v['content']."</div>
							
								<div class='gj_body_content_from'>来自合同：".$ht_json['zdy0']."</div> 
								<div class='gj_body_content_button'>
									
								</div>
							</div>
						</div>
					</div>";
				}//客户模块下
			$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 		$rz_map['rz_mode']=6;
	 		$rz_map['rz_user']=cookie('user_id');
			$rz_map['rz_zd_name']=$ht_id;//客户名称ID
			$rz_sql=$rz->where(array($rz_map))->order("rz_time desc")->select();//查询出日志记录、
			
			
			$rz_mk_a=array(
				"1"=>"线索",
				"2"=>"客户",
				"3"=>"客户公海",
				"4"=>"联系人",
				"5"=>"商机",
				"6"=>"合同",
				);
			$rz_type=array(
				"1"=>"添加",
				"2"=>"编辑",
				"3"=>"删除"  

 				);
			if($rz_sql==''||$rz_sql==null){
				$rz_jl.="<tr><td colspan='5' align='center'><span>亲~没有数据哟！</td></tr>";
			}else{
				foreach($rz_sql as $k=>$v)
				{
			  		$rz_jl.="<tr>
		  					<td >".date('Y-m-d H:i:s',$v['rz_time'])."</td>
		  					<td >".$user[$v['rz_user']]['user_name']."</td>";
		  					$rz_jl.="<td >".$rz_mk_a[$v['rz_mode']]."</td>";
		  					$rz_jl.="
		  							 <td class='bzsl' title='".$v['rz_bz']."' style='cursor:pointer'>".$v['rz_bz']."</td>";
		  				
		  					$rz_jl.="<td >".$rz_type[$v['rz_cz_type']]."</td>";
		  				
		  				
		  			$rz_jl.="</tr>";
		  		}
		  	}
	  		$this->assign("rz_jl",$rz_jl);		
			$this->assign("xgj_show",$xgj_show);		
			$this->assign("gj_xgj",$gj_xgj);		
    	    $this->assign("kp_show3",$kp_show3);		
    	    $this->assign("kp_show2",$kp_show2);		
    	    $this->assign("kp_show1",$kp_show1);										
		    $this->assign("kp_show",$kp_show);					
		    $this->assign("kaipiao",$kaipiao);					
		    $this->assign("weihka", $weihka);
		   	$this->assign("xz_jh",$xz_jh);
			$this->assign("hk_jihua",$hk_jihua);//回款计划页面信息
			$this->assign('zonghk',$zonghk);
			$this->assign('hkzje',$hkzje); 
			$this->assign('chanpin1',$chanpin1); 
			$this->assign('ht_id',$ht_id);
			$this->assign('show2',$show2); //合同残品
			$this->assign('show3',$show3); //合同编辑
			$this->assign('file_show',$file_show); //合同附件
			$this->assign('show',$show); //合同基本信息
			$this->assign('show1',$show1); //合同系统信息
			$this->assign('name',$ht_json['zdy0']); //合同名字
			$this->assign('fuzeren',$user[$sql_lianxi['ht_fz']]['user_name']);//合同负责人
			$this->assign("kh_id",$ht_json['zdy1']);
			$this->assign("ht_kh",$kehu[$ht_json['zdy1']]['name']);
			$this->assign("ht_name",$ht_json['zdy0']);
			$this->assign("ht_money",$ht_json['zdy3']);
			$this->assign("ht_data",$ht_json['zdy4']);
			$this->display();
		}
		public function del_hkjh(){
			$yzdl=A('DB');
			
			$yzdl->is_login();
			$yzdl->have_qx("qx_ht_del");//跳转权限验证
			$base=M('hk');
			$id['hk_id']=$_GET['id'];
			$del_sql=$base->where($id)->delete();
		}
		public function userqb(){                 //负责人和部门
	

	 	$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}


		$fuzeren=M('user');
		
		$map['user_id']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
	
	 	$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id = ".$map['user_id']." or user_fid = ".$map['user_id']."");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
				
			} 
	
		
return $fzr_only;
	}
		public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("quanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0' and user_act!='0'");
		foreach($userarr as $v)  
		{
			$userkeyid[$v['user_id']]=$v;
		}
		$nowloginqx=$userkeyid[$nowloginid]['user_quanxian'];
		$nowloginbid=$userkeyid[$nowloginid]['user_zhu_bid'];

		$qxarr=$qxbase->query("select qx_data_qx from crm_quanxian where qx_company='$nowloginfid' and qx_id='$nowloginqx'");
		$dataqx=$qxarr[0]['qx_data_qx'];
		$bmbasearr=$bmbase->query("select * from crm_department where bm_company='$nowloginfid'");
		for($a=0;$a<10;$a++)
		{
			foreach($bmbasearr as $v)
			{
				if($v['bm_id']==$nowloginbid||in_array($v['bm_fid'],$bmid))
					$bmid[$v['bm_id']]=$v['bm_id'];
			}
		}
		if($dataqx=='1')
		{
			return $nowloginid;
		}
		$foreachnum=0;
		foreach($userkeyid as $v)
		{
			if($v['user_zhuguan_id']=='0')
			{
				continue;
			}
			foreach($userkeyid as $kk=>$vv)
			{
				if($vv['user_zhuguan_id']==$nowloginid||in_array($vv['user_zhuguan_id'],$nowzgid))
				{
					$nowzgid[$vv['user_id']]=$vv['user_id'];
				}
			}
			if($foreachnum=='50')
			{
				break;
			}
			$foreachnum++;
		}
		$nowzgid[$nowloginid]=$nowloginid;
		foreach($nowzgid as $k=>$v)
		{
			if($dataqx=='2')
			{
				if($userkeyid[$v]['user_zhu_bid']!=$nowloginbid)
					unset($nowzgid[$k]);
			}
			if($dataqx=='3')
			{
				if(!in_array($userkeyid[$v]['user_zhu_bid'],$bmid))
					unset($nowzgid[$k]);
			}
		}
		return implode(",",$nowzgid);
	}
		public function chanpin(){
		$map['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cp_base=M('chanpin');
		$map['cp_del']=0;
		$sql=$cp_base->where($map)->select();
		foreach($sql as $k=>$v)
		{
			$cp_sql='';
			foreach($v as $k1=>$v1){
				if($k1!='cp_data'){
					$cp_sql[$k1]=$v1;
				}else{
					$json=json_decode($v[$k1],true);
					foreach($json as $k2=>$v2){
						$cp_sql[$k2]=$v2;
					}
					
				}
			}$sql_cp[$v['cp_id']]=$cp_sql;
			
		}
		
		return $sql_cp;
	}
	public function add_cp(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		//echo "<pre>";
		//var_dump($chanpin);exit;
		$id=$_GET['id'];
		//$id= "cp_id:140156,cp_yj:20800,cp_jy:20800,cp_num1:1,cp_zk:100.0%,cp_zj:20800,cp_beizhu:	1										,sj_id:335";
		$ex=explode(',',$id);
		foreach($ex as $v)
		{
			$a=explode(":",$v);
			$sql[$a['0']]=$a['1'];
		}
		$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
		$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
		$sql['cp_mk']=6;
		$cp_sj_base=M('cp_sj');

		$sql_add=$cp_sj_base->add($sql);
		if($sql_add){
			$chanpin=$this->chanpin();
			$cp['cp_mk']=6;
			$cp['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$cp['sj_id']=$sql['sj_id'];
			$cp_ht=M('cp_sj');
			$sql_cp_sql=$cp_ht->where($cp)->select();
			foreach($sql_cp_sql as $k=>$v)
			{
				$v['zdy0']=$chanpin[$v['cp_id']]['zdy0'];
				$v['zdy1']=$chanpin[$v['cp_id']]['zdy1'];
				$v['zdy3']=$chanpin[$v['cp_id']]['zdy3'];
				$v['zdy6']=$chanpin[$v['cp_id']]['zdy6'];
				$cp_new[$v['cp_id1']]=$v;
			}
			foreach ($cp_new as $k=>$v)
			{
				$show2.="<tr class='".$v['cp_id1']."'>
				<td>".$v['zdy0']."</td>
				<td>".$v['zdy1']."</td>
				<td>".$v['cp_yj']."</td>
				<td>".$v['cp_jy']."</td>
				<td>".$v['cp_num1']."</td>
				<td>".$v['cp_zk']."</td>
				<td>".$v['cp_zj']."</td>
			
				<td>".$v['cp_beizhu']."</td>
				<td><input type='button' name='".$v['cp_id1']."' onclick='cp_del(this)' value='删除'></td>
				</tr>";
			}
			$rz_bz="新增了产品：".$chanpin[$sql['cp_id']]['zdy0'].",型号：".$chanpin[$sql['cp_id']]['zdy1']."" ;	
			$this->rizhi($_GET['kh_id'],$rz_bz,"1",$sql['sj_id']);//1客户id   2备注    3 
			echo $show2;
			 						
		} else{
			echo "2";
		}
	
		}
			public function fj_shangchuan(){

				$yzdl=A('DB');
				$yzdl->is_login2(2);
				$yzdl->have_qx2("qx_ht_open");//跳转权限验证删除
				$ht_id=$_GET['id'];
			    $upload = new \Think\Upload();// 实例化上传类
    			$upload->maxSize   =     52428800 ;// 设置附件上传大小
   				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','pptx','xls','zip','pdf');// 设置附件上传类型
    			$upload->rootPath  =     './Public/chanpinfile/cpfile/linshi/'; // 设置附件上传根目录
   				$upload->autoSub = false;
   				$upload->hash = false;
    		// 上传文件 
   				 $info   =   $upload->upload();
    			if(!$info) {// 上传错误提示错误信息
        		$this->error($upload->getError());
    				}// 上传成功
    					    foreach($info as $file){
       						$save_name= $file['savename'];//获取报存路径
       						$save_oldname=$file['name'];//原始吗，
       						$save_size=$file['size'] *'0.0009766';//大小
       						$sql=ceil($save_size/1024).'M';//换算
 
    			 $data['name_id']=$ht_id;
    			 $data['sc_data']= date("Y-m-d G:i:s");
    			 	 $data['user']=cookie('user_id');
    			 $data['fujian_name']=$save_oldname;
    			 $data['lujing']=$save_name;
    			 $data['big']=$sql;
       			 $data['beizhu']=$_POST['wenbenyu'];
       			 $data['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
       			 $data['mk']="6";
       			 $sql_file=M('file');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	//$this->success("上传成功");
       			 	echo '<script>
       			 		
       			 				window.location.href="'.__ROOT__.'/index.php/Home/Hetongmingcheng/Hetongmingcheng/id/'.$ht_id.'/uiid/5"
       			 				;
       			 				</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
}
	public function fujian_del(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_del");//跳转权限验证
				$data['id']=$_GET['id'];
				 $sql_file=M('file');
				 $data['mk']="6";
				 $data['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
				 $sql_del=$sql_file->where($data)->delete();
				 
			}
	public function jisuan(){
		$zje=$_GET['zje'];
		$zba=$_GET['zba'];
		$a=($zje/100)*$zba;
		
		echo $a;
	}
	public function jisuan1(){
		$zje=$_GET['zje'];
		
		$money=$_GET['money'];
	
		$a=$money/($zje/100);   

		
		echo $a;
	}
	public function peizhi_hk(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$id=$_GET['id'];
	//	$id=5;
		$content=$_GET['content'];
	//	$content="hk_qici:1,hk_data:2017-7-11,hk_zb:12,hk_je:10161415.8,hk_bz:12!hk_qici:2,hk_data:2017-7-22,hk_zb:13,hk_je:11008200.45,hk_bz:13!";
		$hk_number=substr($content,0,strlen($content)-1); 
		$new_hk=explode("!",$hk_number);
		foreach($new_hk as $k=>$v)
		{
			$array_hk=explode(",",$v);
			foreach($array_hk as $k=>$v)
			{
				$array_end=explode(":",$v);
				$data[$array_end[0]]=$array_end[1];
			}
			$data['hk_htid']=$id;
			$data['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$data['hk_cj']=cookie("user_id");
			$hk_peizhi_base=M('hk');
			$sql_add=$hk_peizhi_base->add($data);
			
		}

		if($sql_add){
			echo "1";
		}else{
			echo "2";
		}
				
	}
	
	public function save_huikuana(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$content=$_GET['id'];//'undefined:::undefined,,,hk_data:::2017-12-04,,,hk_je:::10000,,,zdy11:::canshu1,,,hktype:::canshu1,,,user_name:::45,,,hk_bz:::1234,,,';
		$hk_number=substr($content,0,strlen($content)-3); 
		$new_hk=explode(",,,",$hk_number);
		foreach($new_hk as $k=>$v)
		{
			$baobao=explode(":::", $v);
			if($baobao[0]=="undefined" )
			{
				
			}else{
				$data[$baobao[0]]=$baobao[1];	
			}
			

		}
		$data['hk_sp']=0;
		$where['hk_id']=$_GET['hk_id'];
		$base=M('hkadd');
		$hk_sql=$base->where($where)->save($data);
		if($hk_sql){
			
						$shenpiyo=$this->shenpi_hk();
						$shenpi_user=explode(",", $shenpiyo);
			
						foreach($shenpi_user as $k=>$v)
			
						{	
							if($k!='a' && $k!='b'){
							$new_shenpi[$v]=$v;
							}else{
								$sp_tbb=$v;
							}
						}
						if($sp_tbb=="a")
						{
							$map_sp_hk['sp_tp']=1;//未审批
						}else{
							$map_sp_hk['sp_tp']=0;//未审批
						}
						$sp_hk_base=M('sp');
						$map_sp_hk['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
						$map_sp_hk['sp_yy']=2;
						$map_sp_hk['sp_sjid']=$_GET['hk_id'];//回款ID
						$hk_del=$sp_hk_base->where($map_sp_hk)->delete();
						$map_sp_hk['sp_jg']=0;//未审批
						$map_sp_hk['sp_sj']=date("Y-m-d h:i:s");
						foreach($new_shenpi as $k=>$v)
						{
							$map_sp_hk['sp_user']=$v;//回款ID
							$sh_end=$sp_hk_base->add($map_sp_hk);//
						}
						
					}
	}
	public function add_huikuan(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$content=$_GET['id'];
		$hk_ida=$_GET['hk_id'];

		//$content="hk_data:2017-7-28,hk_je:60000,hk_kh:104335,hk_ht:308,hk_qici:1,zdy11:canshu1,hk_type:canshu1,hk_skr:1,hk_bz:0000000,";
		$hk_number=substr($content,0,strlen($content)-1); 
		$new_hk=explode(",",$hk_number);
		foreach($new_hk as $k=>$v)
		{
			$baobao=explode(":", $v);
			if($baobao[0]=='hk_qici')
			{
				$data[$baobao[0]]=$hk_ida;
			}else{
				$data[$baobao[0]]=$baobao[1];	
			}
			

		}
		
		$data['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$data['hk_sp']=0;
		$data['hk_cj_date']=date("Y-m-d h:i:s");;
		$data['hk_cj']=cookie("user_id");
		$hkadd_base=M('hkadd');
		$hk_sql=$hkadd_base->add($data);
		if($hk_sql){

			$shenpiyo=$this->shenpi_hk();
			$shenpi_user=explode(",", $shenpiyo);

			foreach($shenpi_user as $k=>$v)

			{	
				if($k!='a' && $k!='b'){
				$new_shenpi[$v]=$v;
				}else{
					$sp_tbb=$v;
				}
			}
			if($sp_tbb=="a")
			{
				$map_sp_hk['sp_tp']=1;//未审批
			}else{
				$map_sp_hk['sp_tp']=0;//未审批
			}
			$sp_hk_base=M('sp');
			$map_sp_hk['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$map_sp_hk['sp_sj']=date("Y-m-d h:i:s");
			$map_sp_hk['sp_yy']=2;
			$map_sp_hk['sp_sjid']=$hk_sql;//回款ID
			$map_sp_hk['sp_jg']=0;//未审批

			foreach($new_shenpi as $k=>$v)
			{
				$map_sp_hk['sp_user']=$v;//回款ID
				$sh_end=$sp_hk_base->add($map_sp_hk);
			}
			$rz_bz="新增了第".$data['hk_qici']."期回款记录：￥：".$data['hk_je']."";	
			$this->rizhi($data['hk_kh'],$rz_bz,"1",$data['hk_ht']);//1客户id   2备注    3 
		}

	}
	public function shenpi_hk(){  //审批回款封装
		
			$shenpi_base=M('shenpi');
			$shenpi_map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$shenpi_map['sp_type']=2;
			$sql_shenpi=$shenpi_base->where($shenpi_map)->find();
			if($sql_shenpi['sp_tb']==1)
			{
				$save_tb="a";
			}else{
				$save_tb="b";
			}
			$a=$save_tb.",";
			if($sql_shenpi['sp_qy_1']==1)
			{
				$a.=cookie('user_fid')=='0'?cookie('user_id').",":cookie('user_fid').",";
			}
			if($sql_shenpi['sp_qy_2']==1)
			{
				$user_base=M('user');
				$map_user['user_id']=cookie("user_id");
				$user_sql=$user_base->where($map_user)->field('user_zhuguan_id')->find();
				if($user_sql["user_zhuguan_id"]!=0){
						$a.=$user_sql["user_zhuguan_id"].",";
					}
			}
			if($sql_shenpi['sp_qy_3']==1)
			{
				$a.=$sql_shenpi["sp_value_3"].",";
			}
			$shenpi_user=substr($a,0,strlen($a)-1); 
		
				return $shenpi_user;
		
	}
	public function hkpz_content(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
			$hk_base=M('hk');
			$hk_map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$hk_map['hk_htid']=$_GET['id'];
			
			$dijiqia=$_GET['dijiqi'];
			$dijiqi=$dijiqia+1;
		//$hk_map['hk_htid']=309;
			$sql_hk=$hk_base->where($hk_map)->select();

			//if($sql_hk==null || $sql_hk=="")
		//	{
				$peizhi712.="<tr class='qingxuanze'>
					<td colspan='6' ><span>亲~还没有回款计划哦~<span onclick='hkzb()'
					style='color:#07d;cursor:pointer;font-weight:bold'>新增回款计划>></span></span></td>
				</tr>
				<tr class='add_pz' style='display:none'>
					<td >".$dijiqi."</td>
					<td ><span onclick='jia(this)'><i class='layui-icon'  style='color:black'>&#xe61f;</i></span><span class='1' onclick='hkzb1(this)'><i class='layui-icon'   style='font-size:20px'>&#xe640;</i></span></td>
					<td ><input type='text' style='width:110px'  name ='' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd '".'})"'."></td>
					<td ><input type='text' style='width:100px' class= 'zbi' onchange='zolop(this)'></td>
					<td ><input type='text' style='width:100px' class= 'money' value='' onchange='fan(this)' name =''></td>
					<td ><input type='text' style='width:110px' name =''></td>
				</tr> ";
		//	}else{
				/**$peizhi712.="<tr class='qingxuanze' style='display:none'>
					<td colspan='6' ><span>亲~还没有回款计划哦~<span onclick='hkzb()'
					style='color:#07d;cursor:pointer;font-weight:bold'>新增回款计划>></span></span></td>
				</tr>";
				foreach($sql_hk as $k=>$v)
				{
					
				$peizhi712.="

				<tr class='add_pz'>
								<td >".$v['hk_qici']."</td>
								<td ><span onclick='jia(this)'><i class='layui-icon'  style='color:black'>&#xe61f;</i></span><span class='1' onclick='hkzb1(this)'><i class='layui-icon'   style='font-size:20px'>&#xe640;</i></span></td>
								<td ><input type='text' style='width:110px'  name =''  value='".$v['hk_data']."'  onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>
								<td ><input type='text' style='width:100px' class= 'zbi' value='".$v['hk_zb']."' onchange='zolop(this)'></td>
								<td ><input type='text' style='width:100px' class= 'money' value='".$v['hk_je']."' onchange='fan(this)' name =''></td>
								<td ><input type='text' style='width:110px' name ='' value='".$v['hk_bz']."'></td>
							</tr>"; 
				}
				
			
			}**/
			echo $peizhi712;

	}
	public function shenpi_kp(){  //审批开票封装
		
			$shenpi_base=M('shenpi');
			$shenpi_map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$shenpi_map['sp_type']=3;
			$sql_shenpi=$shenpi_base->where($shenpi_map)->find();
			if($sql_shenpi['sp_kq']==1)
			{
				
					$a=$sql_shenpi['sp_kq']."|";
					if($sql_shenpi['sp_qy_1']==1)     //一级是否开启
					{
						if($sql_shenpi['sp_type_1']==1) //直接上级
						{
							
							$user_base=M('user');
							$map_user['user_id']=cookie("user_id");
							$user_sql=$user_base->where($map_user)->field('user_zhuguan_id')->find();
								if($user_sql["user_zhuguan_id"]!=0){
									$a.=$user_sql["user_zhuguan_id"];
								}else{
									$a.=cookie('user_id');
								}

						}elseif($sql_shenpi['sp_type_1']==2){
							
									$a.=$sql_shenpi['sp_value_1'];
						}elseif($sql_shenpi['sp_type_1']==3){

							$a.=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
						}
						$a.="|";
					}
				if($sql_shenpi['sp_qy_2']==1) //二级是否开启
					{
						if($sql_shenpi['sp_type_2']==1) //直接上级
						{
							
							$user_base=M('user');
							$map_user['user_id']=cookie("user_id");
							$user_sql=$user_base->where($map_user)->field('user_zhuguan_id')->find();
								if($user_sql["user_zhuguan_id"]!=0){
									$a.=$user_sql["user_zhuguan_id"];
								}else{
									$a.=cookie('user_id');
								}

						}elseif($sql_shenpi['sp_type_2']==2){
							
									$a.=$sql_shenpi['sp_value_2'];
						}elseif($sql_shenpi['sp_type_2']==3){

							$a.=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
						}
						$a.="|";
					}
				if($sql_shenpi['sp_qy_3']==1)              //三级是否开启
					{
						if($sql_shenpi['sp_type_3']==1) //直接上级
						{
							
							$user_base=M('user');
							$map_user['user_id']=cookie("user_id");
							$user_sql=$user_base->where($map_user)->field('user_zhuguan_id')->find();
								if($user_sql["user_zhuguan_id"]!=0){
									$a.=$user_sql["user_zhuguan_id"];
								}else{
									$a.=cookie('user_id');
								}

						}elseif($sql_shenpi['sp_type_3']==2){
							
									$a.=$sql_shenpi['sp_value_3'];
						}elseif($sql_shenpi['sp_type_3']==3){

							$a.=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
						}
						$a.="|";
					}
						$spu=substr($a,0,strlen($a)-1); 
			}else{
				$spu="zidongtongguo";//审批关闭  自动通过
			}


				return $spu;
		
	}
	public function kaipiaoadd(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$id=$_GET['id'];
	//	$id="kp_date:2017-7-28 ,kp_data:x晓明内容,kp_je:+56120,kp_type:0,kp_ht:310,kp_kh:104104,kp_number:1213456,kp_user:45,kp_bz:3111,";
		$kp_number=substr($id,0,strlen($id)-1); 
		$new_kp=explode(",",$kp_number);
		
		foreach($new_kp as $k=>$v)
		{
			$baobao=explode(":", $v);
			$data[$baobao[0]]=$baobao[1];

		}
		$data['kp_cj']=cookie('user_id');
		$data['kp_cj_date']=date("Y-m-d h:i:s");
	//	$data['kp_yh2']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data['kp_sp']=0;
		$kp_base=M('kp');
		$kp_add=$kp_base->add($data);
		if($kp_add){
			$spr=$this->shenpi_kp();
			if($spr!="zidongtongguo")
			{
				$dingji=explode("|",$spr);
				foreach($dingji as $k=>$v)
				{
					if($k!=0)
					{
						
							
					
						$arr_new[]=$v;
				
					}
				}
				$gongjj=count($dingji)-1;
			//	$fg=explode(",",$dingji[1]); //获取到最顶级一层的审批人

				$sp_kp_base=M('sp');
				$map_sp_kp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
				$map_sp_kp['sp_sj']=date("Y-m-d h:i:s");
				$map_sp_kp['sp_sjid']=$kp_add;//开票ID
				$map_sp_kp['sp_jg']=0;//未审批\

				$map_sp_kp['sp_yy']=3;//所属应用 3代表开票
				$map_sp_kp['sp_tp']=$dingji['0'];//开启同步否
				
				$map_sp_kp['sp_zg_jj']=$gongjj;
			
				
			$jjjj=1;
				foreach($arr_new as $k=>$v)
				{
					$fg=explode(",",$v); //获取到最顶级一层的审批人
					foreach($fg as $k1=>$v1)
					{
						if($jjjj==1)
						{
						$map_sp_kp['sp_jg']=0;
						}else{
						$map_sp_kp['sp_jg']=128;
						}
						$map_sp_kp['sp_dq_jj']=$jjjj;
						$map_sp_kp['sp_user']=$v1;//回款ID
						$sh_end=$sp_kp_base->add($map_sp_kp);
					}
					$jjjj++;
					
				}
			}else{ 
				$kp_base=M('kp');     //自动通过
				$map_kp['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
				$map_kp['kp_id']=$kp_add;
				$data_kp['kp_sp']=1;
				$save_kp=$kp_base->where($map_kp)->save($data_kp);

			}
			$rz_bz="新增了开票：开票金额：".$data['kp_je']."";	
			$this->rizhi($data['kp_kh'],$rz_bz,"1",$data['kp_ht']);//1客户id   2备注    3 
		}
	}
	public function userws(){                 //负责人和dddd
	
		$fuzeren=M('user');

		
			$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
	
	 		$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id = $fid or user_fid=$fid ");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						
					
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
				
			}  


return $fzr_only;



	}
	public function bh_yy(){
		$user=$this->userws();
		
		$id['sp_sjid']=$_GET['id'];
		$id['sp_jg']=2;
		$id['sp_yy']=3;
		$id['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$m=M('sp');
		$sql=$m->where($id)->find();
		echo "<table class='bohuics'><tr><td>驳回人：</td><td>".$user[$sql['sp_user']]['user_name']."</td></tr><tr><td>驳回原因：</td><td title='".$sql['sp_yuanyin']."' style='cursor:pointer;'>".$sql['sp_yuanyin']."</td></tr><tr><td>驳回时间：</td><td>".$sql['sp_sj']."</td></tr></table>";

		
	}
	public function bh_yy1(){
		$user=$this->userws();
		
		$id['sp_sjid']=$_GET['id'];
		$id['sp_jg']=2;
		$id['sp_yy']=2;
		$id['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$m=M('sp');
		$sql=$m->where($id)->find();
		echo "<table class='bohuics'><tr><td>驳回人：</td><td>".$user[$sql['sp_user']]['user_name']."</td></tr><tr><td>驳回原因：</td><td title='".$sql['sp_yuanyin']."' style='cursor:pointer'>".$sql['sp_yuanyin']."</td></tr><tr><td>驳回时间：</td><td>".$sql['sp_sj']."</td></tr></table>";

		
	}
	
	public function sc_kpee(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_del");//跳转权限验证
		$id['kp_id']=$_GET['id'];
		$m=M('kp');
		$id['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$id['kp_sp']=2;
		$sql_s=$m->where($id)->delete();
		if($sql_s)
		{
			echo "ok";
		}

	} 
	public function ss(){
		echo 12;
	}
	public function xgj(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$id=$_GET['id'];
		$kh_id = $_GET['kh_id'];
	//	$id="kh_id!276,type!拜访,content!123456,add_time!2017-08-22 10:53:01,date!2017-08-23 10:53:06";
		$ex_id_arr=explode(',@!',$id);
		foreach($ex_id_arr as $k=>$v)
		{
			$ex2=explode("!@!", $v);
			$array[$ex2['0']]=$ex2['1'];

		}
	
		$array['mode_id']=6;
		$array['user_id']=cookie('user_id');
		$array['gl_khid']=$kh_id;
		$array['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
		$xgj_base=M('xiegenjin');
		$add_xgj=$xgj_base->add($array);

		$xgj=$_GET['xgj'];
		//$xgj="canshu5";
		$map_kh['ht_id']=$array['kh_id'];
		$map_kh['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
		$m_kh=M('hetong');
		$sql_sj=$m_kh->where($map_kh)->find();
		
		$a_arra=json_decode($sql_sj['ht_data'],true);
		
		$old=$a_arr['zdy7'];
		
		if($a_arr['zdy7']==$xgj){
			//相等代表没改变 啥也不用干
			//echo 1;exit;
		}else{ //改变了赋值
			//echo 2;exit;
				$a_arra['zdy7']=$xgj;
				$a_arr1x['ht_gx_date']=$array['add_time'];
				$a_arr1x['ht_data']=json_encode($a_arra,true);
				$sql_sjx=$m_kh->where($map_kh)->save($a_arr1x);//修改成功
				if($sql_sjx){
					echo "1";
				}else{
					echo "2";
				}
				/**$ywzd=$this->ywzd_sj();
				foreach($ywzd as $k=>$v)
				{
					$sjywzd[$v['id']]=$v;
				}
						$ywcs=M('ywcs');                 //获取ywcs表中的 数据
				 		$yw_cs['ywcs_yw']="5";
				 		$yw_cs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
				 		
				 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
				 		
				 		foreach($ywcs_sql_json as $k=>$v)
				 		{
				 			$ywcs_new[$v['id']]=$v;
				 		}
				 	
					$rz_bz="把".$sjywzd['zdy5']['name']."的".$ywcs_new['zdy5'][$old]."值改为".$ywcs_new['zdy5'][$xgj];
					
					$this->rizhi($array['kh_id'],$rz_bz,"2");	**/

					
				}

		
		
	}
	public function save(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_open");//跳转权限验证
		$ywzd=$this->ywzd();
		$ywcs=$this->ywcs();
		
		$a=$_GET['id'];
		
		
		$new_arr=explode(',￥￥',$a);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
			
			
				$ex1[$ex['0']]=$ex['1'];               //提交过来的数据
		
			

		}
		$data['ht_data']=json_encode($ex1,true);
		$data['ht_gx_date'] = date('Y-m-d H:i:s');
	$mapa['ht_id']=$_GET['ht_id'];
		
		$kh_base=M('hetong');
		$kh_map['ht_id']=$mapa['ht_id'];
		$sql_kh=$kh_base->where($kh_map)->find();
	
				
		$ht_json=json_decode($sql_kh['ht_data'],true);
		
		foreach($ht_json as $kjson =>$vjson)
		{
			$new_ht[$kjson]=$vjson;
		}
		$sql_save=$kh_base->where($mapa)->save($data);

		if($sql_save){
			foreach($ex1 as $knew=>$vnew)
			{
				if($ex1[$knew] != $new_ht[$knew])
				{
					if( $knew == 'zdy7' ||  $knew == 'zdy10' || $knew == 'zdy11' )
					{
						
						$rz_bz="".$ywzd[$knew]['name']."的".$ywcs[$knew][$new_ht[$knew]]."改为了".$ywcs[$knew][$ex1[$knew]]."";
						
						$this->rizhi($ex1['zdy1'],$rz_bz,"2",$mapa['ht_id']);//1客户id   2备注    3 操作类型   4合同id  	
					}else{
					
					//	$rz_bz="把xxx的xxx改为xxxx";
						$rz_bz="".$ywzd[$knew]['name']."的".$new_ht[$knew]."改为了".$ex1[$knew]."";
						
						$this->rizhi($ex1['zdy1'],$rz_bz,"2",$mapa['ht_id']);//1客户id   2备注    3 操作类型   4合同id  	
					}
				}
			}
		//	$kh_rz_new=
		
			echo "ok";
			
		}else{
			echo "no";
		}
	}
	public function rizhi($one="",$two="",$three="",$four="")
	{
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		$addressArr=getCity($nowip);//登录地点
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$rz=M('rz');
		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		$rz_map['rz_mode']=6;
		$rz_map['rz_object']=$one;//客户名称ID
		$rz_map['rz_bz']=$two;
		$rz_map['rz_user']=cookie('user_id');
		$rz_map['rz_cz_type']=$three;//2代表编辑
		$rz_map['rz_zd_name']=$four;//2代表编辑
		$rz_map['rz_time']=time();
		$rz_map['rz_ip']=$loginIp;//ip
		$rz_map['rz_place']=$loginDidianStr;//登录地点
		$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
		$rz_map['rz_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$rz_sql=$rz->add($rz_map);//查'			//删除增加日志
		
	}
	//下载文件
	public function download1(){
		$name=$_GET['id'];
	

		$filepath='./Public/chanpinfile/cpfile/linshi/'.$name;
		header("Content-type:application/octet-stream");
		header("Content-disposition:attachment;filename=".$name.";");
		ob_clean();
		@readfile($filepath);
		die;
	}
	public function save_hkjh(){ //编辑回款计划
		$id=$_GET['id'];
		$qici=$_GET['qici'];
		$base=M('hk');
		$map['hk_id']=$id;
		$map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$sql=$base->where($map)->find();
		$sql_show.="<form class='uk-form' style='margin-left:18%;margin-top:25px'>
		<table>
			<tr><td>期次：</td><td>第".$qici."期</td></tr>
			<tr><td>回款日期：</td><td style='line-height:28px'><input type='text' id='hk_data' value='".$sql['hk_data']."'></td></tr>
			<tr><td>回款占比：</td><td style='line-height:28px'><input type='text' id='hk_zb' value='".$sql['hk_zb']."'></td></tr>
			<tr><td>回款金额：</td><td style='line-height:28px'><input type='text' id='hk_je' value='".$sql['hk_je']."'></td></tr>
			<tr><td>备注：</td><td style='line-height:28px'><textarea style='width:300px;height:90px;line-height:18px' id='hk_bz' >".$sql['hk_bz']."</textarea></td></tr>
		</table>
		</form>";
		echo $sql_show;
		
	}
	public function save_hkjhend(){
		$id=$_GET['id'];
		$content=$_GET['content'];
		//$content="hk_data!@2017-10-12 !,hk_zb!@20!,hk_je!@4000!,hk_bz!@12";
		$new_a=explode("!,", $content);
		foreach($new_a as $k=>$v)
		{
			$new_b=explode("!@",$v);
			$new_array[$new_b[0]]=$new_b[1];
		}
			$map['hk_id']=$id;
			$map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
			$base=M('hk');
			
			$sql=$base->where($map)->save($new_array);
			if($sql){
				echo "修改成功";
			}else{
				echo "修改失败";
			}
	}
	public function del_hkjl(){
		$yzdl=A('DB');
		
		$yzdl->is_login();
		$yzdl->have_qx("qx_ht_del");//跳转权限验证
		$map['hk_id']=$_GET['id'];
		$map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$base=M('hkadd');
		$del_sql=$base->where($map)->delete();
		$base_sp=M('sp');
		$map_sp['sp_sjid']=$id;
		$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$del_sp=$base_sp->where($map_sp)->delete();
	}
	public function save_hksql(){
		$ywcs=$this->ywcs();
		$userqb=$this->userqb();

	$map['hk_id']=$_GET['hk_id'];
	$qici=$_GET['qi'];
		//$map['hk_id']='81';
		$base=M('hkadd');
		$map['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$sql=$base->where($map)->find();
		$show.="<table class='uk-form'>

				<tr><td>期次：</td><td>第".$qici."期</td></tr>
				<tr><td>回款日期：</td><td><input type='text' id='' name='hk_data' value='".$sql['hk_data']."'  onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td></tr>
	
				<tr><td>回款金额：</td><td><input type='text' id=''  name='hk_je' value='".$sql['hk_je']."' ></td></tr>
			<tr><td>付款方式：</td><td><select id='' name='zdy11' ' >";
			foreach($ywcs['zdy11'] as $k=>$v)
			{	if($sql['zdy11']==$k)
				{
					$show.="<option value='".$k."'>".$v."</option>";
				}else{
					$show.="<option value='".$k."'>".$v."</option>";
				}
				
			}
				$show.="	</select></td></tr>
				<tr><td>回款类型：</td><td><select  id='' name='hk_type' >";
				foreach($ywcs['hktype'] as $k=>$v)
			{	if($sql['hktype']==$k)
				{
					$show.="<option value='".$k."'>".$v."</option>";
				}else{
					$show.="<option value='".$k."'>".$v."</option>";
				}
				
			}
				$show.="</select></td></tr>
				<tr><td>收款人：</td><td><select  id='' name='hk_skr' >";
				foreach($userqb as $k=>$v)
				{
					
					$show.="<option value='".$k."'>".$v['user_name']."</option>";
				
				}
				$show.="</select></td></tr>
				<tr><td>备注：</td><td><textarea style='width:300px' name='hk_bz'>".$sql['hk_bz']."</textarea></td></tr>
				</table>";
			echo $show;
	

	}
	public function del_gja(){
		$map['genjin_id']=$_GET['id'];
		$map['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$map['mode_id']=6;
		$base=M('xiegenjin');
		$sql=$base->where($map)->delete();
	}
	public function jiancha_tg(){
		$id=$_GET['id'];
		$base=M('hk_add');
		$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$qici=$id;
		$sqla=$base->query("select * from crm_hkadd where hk_yh = '$yh' and hk_qici= $qici and (hk_sp =1 or hk_sp =0)");
		if($sqla == "" || $sqla == null)
		{
			echo "1";
		}else{
			echo "no";
		}
		
	}
}