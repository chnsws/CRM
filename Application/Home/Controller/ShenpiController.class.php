<?php
namespace Home\Controller;
use Think\Controller;


class ShenpiController extends Controller {

	public function shenpi(){
		$ht_name=$this->hetong();
		
		$kh_name=$this->kehu();
		$sj_name=$this->shangji();
		$user_name=$this->user();

		$ywcs=$this->ywcs();
	
		$sp_base=M('sp');
		$sp_map['sp_user']=cookie("user_id");
		$sp_map['sp_yy']=2;//三代表别人审批了
	//	$sp_map['sp_jg']=0;
		$sp_map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$sp_sql=$sp_base->where($sp_map)->select();
		$sp_sql_count=$sp_base->where($sp_map)->count();//几条
		foreach($sp_sql as $k=>$v)
		{
			$array_sp[$v['sp_sjid']]['sp_sjid']=$v['sp_id'];
			$array_sp[$v['sp_sjid']]['sp_jg']=$v['sp_jg'];
			$array_sp[$v['sp_sjid']]['sp_xgr']=$v['sp_xgr'];
		}
	
		if($sp_sql_count==0 || $sp_sql_count==null)
		{
			$hk_ts="合同回款审批";
		}else{
			$hk_ts="合同回款审批<span style='color:red'>(".$sp_sql_count.")</span>";
		}
		//echo "<pre>";
		//var_dump($sp_sql_count);exit;
		foreach($sp_sql as $k=>$v)
		{
			$a.=$v['sp_sjid'].",";   //回款ID

		}
		$b=substr($a,0,strlen($a)-1); 
		$hk_add_base=M('hkadd');
		$hkyh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$huikuan=$hk_add_base->query("select * from  crm_hkadd where hk_yh=$hkyh and  hk_id IN ($b)");


		foreach($huikuan as $k=>$v)
		{
			
			$huikuan[$k]['sp_id']=$array_sp[$v['hk_id']]['sp_sjid'];
			$huikuan[$k]['sp_jg']=$array_sp[$v['hk_id']]['sp_jg'];
			$huikuan[$k]['sp_xgr']=$array_sp[$v['hk_id']]['sp_xgr'];
		}
		
		foreach($huikuan as $k=>$v)
		{
			if($v['sp_jg']==0)
			{
				$huikuan1[]=$v;
			}elseif($v['sp_jg']==1){
				$huikuan2[]=$v;
			}elseif($v['sp_jg']==2){
				$huikuan3[]=$v;
			}elseif($v['sp_jg']==3 || $v['sp_jg']==4){
				$huikuan4[]=$v;
			}
		}
	//	echo "<pre>";
	//	var_dump($huikuan4);exit;
		if($huikuan1=="" || $huikuan1==null)
		{
			$hk_show.="<span style='margin-left:45%;height:70px'>亲~ 还没有数据哦～ </span>";
		}else{
		$hk_show.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>回款期次</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>回款日期</th>
			                		<th>回款金额</th>
			                		<th>回款方式</th>
			                		<th>回款类型</th>
			                		<th>收款人</th>
			                		<th>创建回款人</th>
			                		<th>回款创建时间</th>

			                </tr>
					</thead>
					 <tbody >";
						 foreach($huikuan1 as $k=>$v)
						 {
								$hk_show.="<tr>
										<td><span style='color:#079;cursor:pointer' class='".$v['sp_id']."' onclick='tongguo(this)'>通过</span><span style='color:#079;margin-left:20px;cursor:pointer'  class='".$v['sp_id']."' onclick='bohui(this)'>驳回</span></td>
										<td>第".$v['hk_qici']."期</td>
										<td>".$ht_name[$v['hk_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['hk_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['hk_kh']]['name']."</td>
										<td>".$v['hk_data']."</td>
										<td>".$v['hk_je']."</td>
										<td>".$ywcs['zdy11'][$v['zdy11']]."</td>
										<td>".$ywcs['hktype'][$v['hk_type']]."</td>
										<td>".$user_name[$v['hk_skr']]['user_name']."</td>
										<td>".$user_name[$v['hk_cj']]['user_name']."</td>
										<td>".date("Y-m-d H:i:s", $v['hk_cj_date'])."</td>
									</tr>";
						}
			            $hk_show.="</tbody>
				</table>  
				
			</div>
		</div>";
		}
		if($huikuan2=="" || $huikuan2==null)
		{
			$hk_show1.="<span style='margin-left:45%;height:70px'>亲~ 还没有数据哦～ </span>";
		}else{
		$hk_show1.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>回款期次</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>回款日期</th>
			                		<th>回款金额</th>
			                		<th>回款方式</th>
			                		<th>回款类型</th>
			                		<th>收款人</th>
			                		<th>创建回款人</th>
			                		<th>回款创建时间</th>

			                </tr>
					</thead>
					 <tbody >";
						 foreach($huikuan2 as $k=>$v)
						 {
								$hk_show1.="<tr>
										<td><span style='color:green'>您已通过</span></td>
										<td>第".$v['hk_qici']."期</td>
										<td>".$ht_name[$v['hk_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['hk_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['hk_kh']]['name']."</td>
										<td>".$v['hk_data']."</td>
										<td>".$v['hk_je']."</td>
										<td>".$ywcs['zdy11'][$v['zdy11']]."</td>
										<td>".$ywcs['hktype'][$v['hk_type']]."</td>
										<td>".$user_name[$v['hk_skr']]['user_name']."</td>
										<td>".$user_name[$v['hk_cj']]['user_name']."</td>
										<td>".date("Y-m-d H:i:s", $v['hk_cj_date'])."</td>
									</tr>";
						}
			            $hk_show1.="</tbody>
				</table>  
				
			</div>
		</div>";
		}
		if($huikuan3=="" || $huikuan3==null)
		{
			$hk_show2.="<span style='margin-left:45%;height:70px'>亲~ 还没有数据哦～ </span>";
		}else{
		$hk_show2.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>回款期次</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>回款日期</th>
			                		<th>回款金额</th>
			                		<th>回款方式</th>
			                		<th>回款类型</th>
			                		<th>收款人</th>
			                		<th>创建回款人</th>
			                		<th>回款创建时间</th>

			                </tr>
					</thead>
					 <tbody >";
						 foreach($huikuan3 as $k=>$v)
						 {
								$hk_show2.="<tr>
										<td>您已驳回<span style='margin-left:10px;font-size:20px;color:red' class='".$v['hk_id']."' onclick='hk_because(this)'><i class='layui-icon'>&#xe607;</i>  </span></td>
										<td>第".$v['hk_qici']."期</td>
										<td>".$ht_name[$v['hk_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['hk_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['hk_kh']]['name']."</td>
										<td>".$v['hk_data']."</td>
										<td>".$v['hk_je']."</td>
										<td>".$ywcs['zdy11'][$v['zdy11']]."</td>
										<td>".$ywcs['hktype'][$v['hk_type']]."</td>
										<td>".$user_name[$v['hk_skr']]['user_name']."</td>
										<td>".$user_name[$v['hk_cj']]['user_name']."</td>
										<td>".date("Y-m-d H:i:s", $v['hk_cj_date'])."</td>
									</tr>";
						}
			            $hk_show2.="</tbody>
				</table>  
				
			</div>
		</div>";
		}
		if($huikuan4=="" || $huikuan4==null)
		{
			$hk_show3.="<span style='margin-left:45%;height:70px'>亲~ 还没有数据哦～ </span>";
		}else{
		$hk_show3.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>回款期次</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>回款日期</th>
			                		<th>回款金额</th>
			                		<th>回款方式</th>
			                		<th>回款类型</th>
			                		<th>收款人</th>
			                		<th>创建回款人</th>
			                		<th>回款创建时间</th>

			                </tr>
					</thead>
					 <tbody >";
					
						 foreach($huikuan4 as $k=>$v)
						 {
								$hk_show3.="<tr>
										<td>";
										if($v['sp_jg']==3)
										{
											$hk_show3.="<span style='color:green'>".$user_name[$v['sp_xgr']]['user_name']."通过</span>";
										}elseif($v['sp_jg']==4){
											$hk_show3.="".$user_name[$v['sp_xgr']]['user_name']."驳回<span style='margin-left:10px;font-size:20px;color:red' class='".$v['hk_id']."' onclick='hk_because(this)'><i class='layui-icon'>&#xe607;</i>  </span>";

										}
										$hk_show3.="";
										
										$hk_show3.="</td><td>第".$v['hk_qici']."期</td>
										<td>".$ht_name[$v['hk_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['hk_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['hk_kh']]['name']."</td>
										<td>".$v['hk_data']."</td>
										<td>".$v['hk_je']."</td>
										<td>".$ywcs['zdy11'][$v['zdy11']]."</td>
										<td>".$ywcs['hktype'][$v['hk_type']]."</td>
										<td>".$user_name[$v['hk_skr']]['user_name']."</td>
										<td>".$user_name[$v['hk_cj']]['user_name']."</td>
										<td>".date("Y-m-d H:i:s", $v['hk_cj_date'])."</td>
									</tr>";
						}
			            $hk_show3.="</tbody>
				</table>  
				
			</div>
		</div>";
		}
		//往下是开票审批
	    $kp_type_arr=array('0' => "增值税普通发票", '1' => "增值税专用发票",'2' => "国税通用机打发票",'3' => "地税通用机打发票",);
	    $tongbu=array('0'=>"未开启",'1'=>'已开启');
		$sp_base=M('sp');
		$sp_map_kp['sp_user']=cookie("user_id");
		$sp_map_kp['sp_jg']= array(0,1,2,3,4,'or');
		$sp_map_kp['sp_yy']=3;
		$sp_map_kp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$sp_sql_kp=$sp_base->where($sp_map_kp)->select();
		$sp_map_kp1['sp_user']=cookie("user_id");
		$sp_map_kp1['sp_jg']= 0;
		$sp_map_kp1['sp_yy']=3;
		$sp_map_kp1['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$cp_count=$sp_base->where($sp_map_kp1)->count();
		/**foreach($sp_sql_kp as $k=>$v)
		{
			$arrkp[$v['sp_sjid']]['sp_id']=$v['sp_id'];
			$arrkp[$v['sp_sjid']]['sp_zg_jj']=$v['sp_zg_jj'];
			$arrkp[$v['sp_sjid']]['sp_dq_jj']=$v['sp_dq_jj'];
			$arrkp[$v['sp_sjid']]['sp_tp']=$v['sp_tp'];
			$arrkp[$v['sp_sjid']]['sp_jg']=$v['sp_jg'];
			$arrkp[$v['sp_sjid']]['sp_xgr']=$v['sp_xgr'];
		}
		**/

		foreach($sp_sql_kp as $k=>$v) //循环得出开票ID,用逗号隔开
		{
			$kp_id.=$v['sp_sjid'].",";   //回款ID

		}
		$kp_id1=substr($kp_id,0,strlen($kp_id)-1); 
		
		$kp_add_base=M('kp');
		$kpyh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$kaipiao=$kp_add_base->query("select * from  crm_kp where wocao=$kpyh and  kp_id IN ($kp_id1)");
		
		
		foreach($kaipiao as $k=>$v)
		{	
			$array_kkp[$v['kp_id']]=$v;
		}
		foreach($sp_sql_kp as $k=>$v)
		{
			$sp_sql_kp1[$v['sp_id']]=$v;
		}
		
		foreach($sp_sql_kp as $k=>$v)
		{	//$array_ssp[$a]['sp_id']=$v['sp_id'];
			$array_kkp[$v['sp_sjid']]['sp_id']=$v['sp_id'];
			$array_ssp[$v['sp_id']]=$array_kkp[$v['sp_sjid']];
			
		}
	
		foreach($array_ssp as $k=>$v)
		{
	
			$array_ssp[$k]['sp_zg_jj']=$sp_sql_kp1[$k]['sp_zg_jj'];
			$array_ssp[$k]['sp_dq_jj']=$sp_sql_kp1[$k]['sp_dq_jj'];
			$array_ssp[$k]['sp_tp']=$sp_sql_kp1[$k]['sp_tp'];
			$array_ssp[$k]['sp_jg']=$sp_sql_kp1[$k]['sp_jg'];
			$array_ssp[$k]['sp_xgr']=$sp_sql_kp1[$k]['sp_xgr'];
		}
	
			

		//echo "<pre>";
		//var_dump($array_ssp);exit;
		foreach($array_ssp as $k=>$v)
		{
			if($v['sp_jg']==0) //待审批
			{
				$kp_sp_show[]=$v;
			}elseif($v['sp_jg']==1){//已通过
				$kp_sp_show1[]=$v;
			}elseif($v['sp_jg']==2){//已驳回
				$kp_sp_show2[]=$v;
			}elseif($v['sp_jg']==3 || $v['sp_jg']==4 ){ //别人已审批
				$kp_sp_show3[]=$v;
			}
		}
		
		if($cp_count==0 || $cp_count==null) //替换提示有几条审批
		{
			$kp_ts="开票回款审批";
		}else{
			$kp_ts="开票回款审批<span style='color:red'>(".$cp_count.")</span>";
		}
		if($kp_sp_show == "" || $kp_sp_show==null )
		{
			$kp_show.="暂无开票审批";
		}else{
		$kp_show.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>开票日期</th>
			                		<th>票据内容</th>
			                		<th>开票金额</th>
			                		<th>票据类型</th>
			                		<th>经手人</th>
			                	
			                		<th>创建开票人</th>
			                		
			                		<th>当前审批级别</th>
			                		<th>共几级</th>
			                		<th>是否开启同步</th>

			                </tr>
					</thead>
					 <tbody >";
					//echo "<pre>";
					//var_dump($kaipiao);exit;
						foreach($kp_sp_show as $k=>$v)
						{
								$kp_show.="<tr>
										<td>";
									
									$kp_show.="<span style='color:#079;cursor:pointer' class='".$v['sp_id']."'  id = '".$v['sp_tp']."' name='".$v['kp_id']."'  onclick='kp_tongguo(this)'>通过</span><span style='color:#079;margin-left:20px;cursor:pointer'  class='".$v['sp_id']."' id = '".$v['sp_tp']."' name='".$v['kp_id']."' onclick='kp_bohui(this)'>驳回</span>";
							
									
									$kp_show.="</td>
										<td>".$ht_name[$v['kp_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['kp_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['kp_kh']]['name']."</td>
										<td>".$v['kp_date']."</td>
										<td>".$v['kp_data']."</td>
										<td>".$v['kp_je']."</td>";
										if($v['kp_type']==0 || $v['kp_type']==1)
										{
											$kp_show.="	<td><span style='color:#079;cursor:pointer' class='".$v['kp_id']."' onclick='fapiaoxinxi(this)'>".$kp_type_arr[$v['kp_type']]."</span></td>";
										}else{
											$kp_show.="	<td>".$kp_type_arr[$v['kp_type']]."</td>";
										}
									
										$kp_show.="<td>".$user_name[$v['kp_user']]['user_name']."</td>
									
										<td>".$user_name[$v['kp_cj']]['user_name']."</td>
									
										<td>第<span>".$v['sp_dq_jj']."</span>级</td>
										<td>共<span>".$v['sp_zg_jj']."</span>级</td>
										<td>".$tongbu[$v['sp_tp']]."</td>
									</tr>";
						}
			            $kp_show.="</tbody>
				</table>  
				
			</div>
		</div>";//上面是待审批
}
		//已通过
	if($kp_sp_show1 == "" || $kp_sp_show1==null )
		{
			$kp_show1.="暂无记录";
		}else{
	 	$kp_show1.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>开票日期</th>
			                		<th>票据内容</th>
			                		<th>开票金额</th>
			                		<th>票据类型</th>
			                		<th>经手人</th>
			                	
			                		<th>创建开票人</th>
			                		
			                		<th>当前审批级别</th>
			                		<th>共几级</th>
			                		<th>是否开启同步</th>

			                </tr>
					</thead>
					 <tbody >";
					//echo "<pre>";
					//var_dump($kaipiao);exit;
						foreach($kp_sp_show1 as $k=>$v)
						{
								$kp_show1.="<tr>
										<td>您已通过</td>
										<td>".$ht_name[$v['kp_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['kp_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['kp_kh']]['name']."</td>
										<td>".$v['kp_date']."</td>
										<td>".$v['kp_data']."</td>
										<td>".$v['kp_je']."</td>";
										if($v['kp_type']==0 || $v['kp_type']==1)
										{
											$kp_show1.="	<td><span style='color:blue' class='".$v['kp_id']."' onclick='fapiaoxinxi(this)'>".$kp_type_arr[$v['kp_type']]."</span></td>";
										}else{
											$kp_show1.="	<td>".$kp_type_arr[$v['kp_type']]."</td>";
										}
									
										$kp_show1.="<td>".$user_name[$v['kp_user']]['user_name']."</td>
									
										<td>".$user_name[$v['kp_cj']]['user_name']."</td>
									
										<td>第<span>".$v['sp_dq_jj']."</span>级</td>
										<td>共<span>".$v['sp_zg_jj']."</span>级</td>
										<td>".$tongbu[$v['sp_tp']]."</td>
									</tr>";
						}
			            $kp_show1.="</tbody>
				</table>  
				
			</div>
		</div>";
	}
		//已驳回
		if($kp_sp_show2 == "" || $kp_sp_show2==null )
		{
			$kp_show2.="暂无记录";
		}else{
			$kp_show2.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>开票日期</th>
			                		<th>票据内容</th>
			                		<th>开票金额</th>
			                		<th>票据类型</th>
			                		<th>经手人</th>
			                	
			                		<th>创建开票人</th>
			                		
			                		<th>当前审批级别</th>
			                		<th>共几级</th>
			                		<th>是否开启同步</th>

			                </tr>
					</thead>
					 <tbody >";
					//echo "<pre>";
					//var_dump($kaipiao);exit;
						foreach($kp_sp_show2 as $k=>$v)
						{
								$kp_show2.="<tr>
										<td>您已驳回<span style='margin-left:10px;font-size:20px;color:red' class='".$v['kp_id']."' onclick='because(this)'><i class='layui-icon'>&#xe607;</i>  </span></td>
										<td>".$ht_name[$v['kp_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['kp_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['kp_kh']]['name']."</td>
										<td>".$v['kp_date']."</td>
										<td>".$v['kp_data']."</td>
										<td>".$v['kp_je']."</td>";
										if($v['kp_type']==0 || $v['kp_type']==1)
										{
											$kp_show2.="	<td><span style='color:blue' class='".$v['kp_id']."' onclick='fapiaoxinxi(this)'>".$kp_type_arr[$v['kp_type']]."</span></td>";
										}else{
											$kp_show2.="	<td>".$kp_type_arr[$v['kp_type']]."</td>";
										}
									
										$kp_show2.="<td>".$user_name[$v['kp_user']]['user_name']."</td>
									
										<td>".$user_name[$v['kp_cj']]['user_name']."</td>
									
										<td>第<span>".$v['sp_dq_jj']."</span>级</td>
										<td>共<span>".$v['sp_zg_jj']."</span>级</td>
										<td>".$tongbu[$v['sp_tp']]."</td>
									</tr>";
						}
			            $kp_show2.="</tbody>
				</table>  
				
			</div>
		</div>";
	}
	if($kp_sp_show3 == "" || $kp_sp_show3==null )
		{
			$kp_show3.="暂无记录";
		}else{
		$kp_show3.="<div >
			<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>合同名称</th>
			                		<th>合同负责人</th>
			                		<th>对应客户</th>
			                		<th>开票日期</th>
			                		<th>票据内容</th>
			                		<th>开票金额</th>
			                		<th>票据类型</th>
			                		<th>经手人</th>
			                	
			                		<th>创建开票人</th>
			                		
			                		<th>当前审批级别</th>
			                		<th>共几级</th>
			                		<th>是否开启同步</th>

			                </tr>
					</thead>
					 <tbody >";
					//echo "<pre>";
					//var_dump($kaipiao);exit;
						foreach($kp_sp_show3 as $k=>$v)
						{
								$kp_show3.="<tr>
										<td>";
										if($v['sp_jg']==3)
										{
											$kp_show3.="".$user_name[$v['sp_xgr']]['user_name']."驳回<span style='margin-left:10px;font-size:20px;color:red' class='".$v['kp_id']."' onclick='because(this)'><i class='layui-icon'>&#xe607;</i>  </span>";
										}elseif($v['sp_jg']==4){
											$kp_show3.="<span style='color:green'><b>".$user_name[$v['sp_xgr']]['user_name']."</b></span>:通过";
										}

									$kp_show3.="</td>
										<td>".$ht_name[$v['kp_ht']]['name']."</td>
										<td>".$user_name[$ht_name[$v['kp_ht']]['fz']]['user_name']."</td>
										<td>".$kh_name[$v['kp_kh']]['name']."</td>
										<td>".$v['kp_date']."</td>
										<td>".$v['kp_data']."</td>
										<td>".$v['kp_je']."</td>";
										if($v['kp_type']==0 || $v['kp_type']==1)
										{
											$kp_show3.="	<td><span style='color:blue' class='".$v['kp_id']."' onclick='fapiaoxinxi(this)'>".$kp_type_arr[$v['kp_type']]."</span></td>";
										}else{
											$kp_show3.="	<td>".$kp_type_arr[$v['kp_type']]."</td>";
										}
									
										$kp_show3.="<td>".$user_name[$v['kp_user']]['user_name']."</td>
									
										<td>".$user_name[$v['kp_cj']]['user_name']."</td>
									
										<td>第<span>".$v['sp_dq_jj']."</span>级</td>
										<td>共<span>".$v['sp_zg_jj']."</span>级</td>
										<td>".$tongbu[$v['sp_tp']]."</td>
									</tr>";
						}
			            $kp_show3.="</tbody>
				</table>  
				
			</div>
		</div>";
		}	
	
		$spht_map['sp_user']=cookie("user_id");
		$spht_map['sp_yy']=1;//三代表别人审批了
	//	$sp_map['sp_jg']=0;
		$spht_map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
		$spht_sql=$sp_base->where($spht_map)->select();
		foreach($spht_sql as $k=>$v)
		{
			if($v['sp_jg']==0) //待审批
			{
				$ht_sp_show[]=$v;
			}elseif($v['sp_jg']==1){//已通过
				$ht_sp_show1[]=$v;
			}elseif($v['sp_jg']==2){//已驳回
				$ht_sp_show2[]=$v;
			}elseif($v['sp_jg']==3 || $v['sp_jg']==4 ){ //别人已审批
				$ht_sp_show3[]=$v;
			}
		}
		if($ht_sp_show == "" || $ht_sp_show==null )
		{
			$ht_show.="暂无记录";
		}else{
		$ht_show.="<div >
					<div >
					<table class='layui-table' >
				  	<thead>
				  			<tr>	
			                		<th>操作</th>
			                		<th>合同标题</th>
			                		<th>对应客户</th>
			                		<th>对应商机</th>
			                		<th>合同总金额</th>
			                		<th>签约日期</th>
			                		<th>合同开始日期</th>
			                		<th>合同结束日期</th>
			                		<th>合同状态</th>
			                		<th>附件</th>
			                		<th>负责人</th>
			                		<th>当前审批级别</th>
			                		<th>共几级</th>
			                		<th>是否开启同步</th>

			                </tr>
					</thead>
					 <tbody >";
					//echo "<pre>";
					//var_dump($kaipiao);exit;
						foreach($ht_sp_show  as $k=>$v)
						{
							$ht_show.="<tr>
										<td>";
											$ht_show.="<span style='color:blue' class='".$v['sp_id']."'  id = '".$v['sp_tp']."' name='".$v['sp_sjid']."'  onclick='ht_tongguo(this)'>通过</span><span style='color:blue;margin-left:20px'  class='".$v['sp_id']."'  id = '".$v['sp_tp']."' name='".$v['sp_sjid']."'  onclick='ht_bohui(this)'>驳回</span></td>";
							
								$ht_show.="	<td>".$ht_name[$v['sp_sjid']]['name']."</td>
											<td>".$kh_name[$ht_name[$v['sp_sjid']]['zdy1']]['name']."</td>
											<td>".$sj_name[$ht_name[$v['sp_sjid']]['zdy2']]['name']."</td>
											<td>".$ht_name[$v['sp_sjid']]['zdy3']."</td>
											<td>".$ht_name[$v['sp_sjid']]['zdy4']."</td>
											<td>".$ht_name[$v['sp_sjid']]['zdy5']."</td>
											<td>".$ht_name[$v['sp_sjid']]['zdy6']."</td>
											<td>".$ywcs['zdy7'][$ht_name[$v['sp_sjid']]['zdy7']]."</td>
											<td><span style='color:blue' class='".$v['sp_sjid']."' onclick='fujian(this)'>点击查看</span></td>
											<td>".$user_name[$ht_name[$v['sp_sjid']]['fz']]['user_name']."</td>
											<td>第<span>".$v['sp_dq_jj']."</span>级</td>
											<td>共<span>".$v['sp_zg_jj']."</span>级</td>
											<td>".$tongbu[$v['sp_tp']]."</td>
									</tr>";
						}
			            $ht_show.="</tbody>
				</table>  
				
			</div>
		</div>";
		}	
		$this->assign('ht_show',$ht_show);
		$this->assign('kp_show3',$kp_show3);
		$this->assign('kp_show2',$kp_show2);
		$this->assign('kp_show1',$kp_show1);
		$this->assign('kp_show',$kp_show);
		$this->assign('hk_ts',$hk_ts);
		$this->assign('kp_ts',$kp_ts);
		$this->assign('hk_show',$hk_show);
		$this->assign('hk_show1',$hk_show1);
		$this->assign('hk_show2',$hk_show2);
		$this->assign('hk_show3',$hk_show3);
		$this->display();
	}
	public function  hetong(){
	
	
		$ht=M('hetong');
		$ht_yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ht_sql=$ht->query("select * from  crm_hetong where ht_yh='$ht_yh'");
		foreach($ht_sql as $k =>$v)
		{
			$ht_json=json_decode($v['ht_data'],true);
			
					$hts['id']=$v['ht_id'];
					$hts['name']=$ht_json['zdy0'];
					$hts['fz']=$v['ht_fz'];
					$hts['zdy1']=$ht_json['zdy1'];
					$hts['zdy2']=$ht_json['zdy2'];
					$hts['zdy3']=$ht_json['zdy3'];
					$hts['zdy4']=$ht_json['zdy4'];
					$hts['zdy5']=$ht_json['zdy5'];
					$hts['zdy6']=$ht_json['zdy6'];
					$hts['zdy7']=$ht_json['zdy7'];
					$hts['zdy14']=$ht_json['zdy14'];

					$ht_name[$v['ht_id']]=$hts;
		}
		//echo "<pre>";
		//var_dump($kh_name);exit;
		return $ht_name;
		
	}

	public function kehu(){
		
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map'");
		
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
	public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("quanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0'");
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
			return "'".$nowloginid."'";
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
public function user(){                 //负责人和dddd
	
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
		public function ywcs(){
			$data['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$data['ywcs_yw']='6';
			$ywcs_base=M('ywcs');
			$sql=$ywcs_base->where(array($data))->field('ywcs_data')->find();
			$sql_json=json_decode($sql['ywcs_data'],true);
			foreach($sql_json as $k=>$v)
			{
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
		public function tongguo(){
			$id=$_GET['id'];
	//$id=237;
			//echo $id;exit;
			$sp_base=M('sp');
			$map_sp['sp_id']=$id;
			$map_sp['sp_yy']=2;

			$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$sql_sp=$sp_base->where($map_sp)->find();
			if($sql_sp['sp_tp']==1) //开启同步
			{
				
				$data['sp_jg']="1";
				$sql_save=$sp_base->where($map_sp)->save($data);
				$count_ling['sp_jg']=0;
				$count_ling['sp_yy']=2;
				$count_ling['sp_sjid']=$sql_sp['sp_sjid'];
				$count_ling['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$sql_c=$sp_base->where($count_ling)->count();
				if($sql_c==0){ //全部通过
					$hk['hk_id']=$sql_sp['sp_sjid'];;
					$hk['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$hk_base=M('hkadd');
					$hk_data['hk_sp']=1;
					$sqk_kp_save=$hk_base->where($hk)->save($hk_data);
					//echo ""
				}
				
			}elseif($sql_sp['sp_tp']==0){//不开启同步
			
				$data['sp_jg']="1";
				$sql_save=$sp_base->where($map_sp)->save($data);
				$sp_taren['sp_sjid']=$sql_sp['sp_sjid'];
				$sp_taren['sp_jg']=0;
				$sp_taren['sp_yy']=2;
				$sp_taren['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			
				$sp_sql_count['sp_jg']=4;
				$sp_sql_count['sp_xgr']=cookie('user_id');
				$sql_save_taren=$sp_base->where($sp_taren)->save($sp_sql_count);
					//echo "<pre>";
				//var_dump($sql_save_taren);exit;
				if($sql_save_taren)
				{
					$hk['hk_id']=$sql_sp['sp_sjid'];;
					$hk['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$hk_base=M('hkadd');
					$hk_data['hk_sp']=1;
					$sqk_kp_save=$hk_base->where($hk)->save($hk_data);
				}



			}

		}
		public function bohui(){
			$id=$_GET['id'];
			//echo $id;
			$sp_base=M('sp');
			$map_sp['sp_id']=$id;
			$data['sp_jg']="2";
			$data['sp_yuanyin']=$_GET['yuanyin'];
			$sql_save=$sp_base->where($map_sp)->save($data);
			$map_sp_sql['sp_id']=$id;
			$map_sp_sql['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$sql=$sp_base->where($map_sp_sql)->find();
		//	echo "<pre>";
			//var_dump($sql);exit;
			$taren_save['sp_sjid']=$sql['sp_sjid'];
			$taren_save['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$taren_save['sp_yy']=2;
			$taren_save['sp_jg']=0;
			$savekk['sp_jg']=3;
			$savekk['sp_xgr']=cookie('user_id');
			$sql_taren=$sp_base->where($taren_save)->save($savekk);
			if($sql_taren)
			{
				$hk['hk_id']=$sql['sp_sjid'];
				$hk['hk_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$hk_base=M('hkadd');
				$hk_data['hk_sp']=2;
				$sqk_kp_save=$hk_base->where($hk)->save($hk_data);
			}
			//var_dump($sql);exit;
		}
		public function kp_bohui(){
			$tb=$_GET['tb'];

			$id=$_GET['id'];
			$yuany['sp_yuanyin']=$_GET['yuanyin'];
			$yuany['sp_jg']=2;
			//echo $id.$yuany;
			$kp_base=M('sp');
			$map_sp['sp_id']=$id;
			$map_sp['sp_yy']=3;
			$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$kp_save=$kp_base->where($map_sp)->save($yuany);
			if($kp_save){
			
			
					$save_kpsp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //修改同级其他 工作人员的审批为别人已审批
					$save_kpsp['sp_sjid']=$_GET['kp_id'];
					$save_kpsp['sp_yy']=3;
					$save_kpsp['sp_jg']=0;
					$save_kpo['sp_jg']=3;//3为别人已审批
					$save_kpo['sp_xgr']=cookie('user_id');
					$sql_spkp_save=$kp_base->where($save_kpsp)->save($save_kpo);
					//审批只要遇到一个驳回  这条信息就是驳回 修改信息状态
					$kp_base=M('kp');
					$map_kp['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$map_kp['kp_id']=$_GET['kp_id'];
				//	$map_kp['kp_sp']=0;
					$data_kp['kp_sp']=2;
					$kp_sav=$kp_base->where($map_kp)->save($data_kp);


			}
			//$data['sp_jg']="2";
			//$sql_save=$sp_base->where($map_sp)->save($data);
		}
		public function kp_tongguo(){
			$sp_id=$_GET['id'];
			$tb=$_GET['tb'];
			$tongguo['sp_jg']=1;
			//echo $id.$yuany;
			$kp_base=M('sp');
			$map_sp['sp_id']=$sp_id;
			$map_sp['sp_yy']=3;
			$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$kp_save=$kp_base->where($map_sp)->save($tongguo);
			$tjr=$_GET['tjr'];
			$zgjj=$_GET['zgjj'];
			if($tb==1)
			{
			
				//这里判断第一级的x个人是否都过,过了给下一级,直到最后一级全过  才去修改开票信息 的审核状态
					
					$map['sp_dq_jj']=$tjr;
					$map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$map['sp_yy']=3;
					$map['sp_sjid']=$_GET['kp_id'];

					$base_sp=M('sp');
					$sql=$base_sp->where($map)->select();
					$num1=0;
					$num2=0;
					foreach($sql as $k=>$v)
					{
						$num1++;
						if($v['sp_jg']==1)
						{
							$num2++;
						}
					}
					if($num1==$num2) //当前级别全员通过 继续判断有无下级 有则下级继续 ，没有则修改开票状态
					{
						if($map['sp_dq_jj']==$zgjj)  //当前级别等于最高级别 就是 1 2 3级全部通过 去修改开票状态
						{
							$m_kp_base=M('kp');
							$m_ap['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$m_ap['kp_id']=$_GET['kp_id'];
							$datass['kp_sp']=1;
							$sql_savekp=$m_kp_base->where($m_ap)->save($datass);
							if($sql_savekp){
								echo "全部人员审批通过";
							}
						}else{                       //x级过了  扔给 x+1 级去审批
							$map_xiaji['sp_dq_jj']=$map['sp_dq_jj']+1;
							$map_xiaji['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$map_xiaji['sp_yy']=3;
							$map_xiaji['sp_sjid']=$_GET['kp_id'];
							$map_xiaji['sp_jg']=128;
							$data_map['sp_jg']=0;
							$sal_save=M('sp')->where($map_xiaji)->save($data_map);
							if($sal_save){
								echo "已通知下级";
							}
						}
					}else{ //测试 以下删除
						echo "您已通过  ";
					}




			
				
			}elseif($tb==0){
				//非同步状态下判断这人是通过 直接 扔给下一级，直到最后一级的第一个审批的过了  才去修改开票信息的审核状态
						if($tjr==$zgjj)  //当前级别等于最高级别 就是 1 2 3级全部通过 去修改开票状态
						{
							$m_kp_base=M('kp');
							$m_ap['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$m_ap['kp_id']=$_GET['kp_id'];
							$datass['kp_sp']=1;
							$sql_savekp=$m_kp_base->where($m_ap)->save($datass);
							if($sql_savekp){
								echo "全部人员审批通过";
							}
						}else{                       //x级过了  扔给 x+1 级去审批
							$map_xiaji['sp_dq_jj']=$tjr+1;
							$map_xiaji['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$map_xiaji['sp_yy']=3;
							$map_xiaji['sp_sjid']=$_GET['kp_id'];
							$map_xiaji['sp_jg']=128;
							$data_map['sp_jg']=0;
							$sal_save=M('sp')->where($map_xiaji)->save($data_map);
							if($sal_save){


								$save_kpsp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //修改同级其他 工作人员的审批为别人已审批
								$save_kpsp['sp_sjid']=$_GET['kp_id'];
								$save_kpsp['sp_yy']=3;
								$save_kpsp['sp_dq_jj']=$tjr;
								$save_kpsp['sp_jg']=0;
								$save_kpo['sp_jg']=4;//34为别人已审批
								$save_kpo['sp_xgr']=cookie('user_id');
								$sql_spkp_save=$kp_base->where($save_kpsp)->save($save_kpo);


								echo "已通知下级";
							}
						}
			}

		}
		public function ht_tongguo(){
			$sp_id=$_GET['id'];
			$tb=$_GET['tb'];
			$tongguo['sp_jg']=1;
			//echo $id.$yuany;
			$kp_base=M('sp');
			$map_sp['sp_id']=$sp_id;
			$map_sp['sp_yy']=1;
			$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$kp_save=$kp_base->where($map_sp)->save($tongguo);
			$tjr=$_GET['tjr'];
			$zgjj=$_GET['zgjj'];
			if($tb==1)
			{
			
				//这里判断第一级的x个人是否都过,过了给下一级,直到最后一级全过  才去修改开票信息 的审核状态
					
					$map['sp_dq_jj']=$tjr;
					$map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$map['sp_yy']=1;
					$map['sp_sjid']=$_GET['ht_id'];

					$base_sp=M('sp');
					$sql=$base_sp->where($map)->select();
					$num1=0;
					$num2=0;
					foreach($sql as $k=>$v)
					{
						$num1++;
						if($v['sp_jg']==1)
						{
							$num2++;
						}
					}
					if($num1==$num2) //当前级别全员通过 继续判断有无下级 有则下级继续 ，没有则修改开票状态
					{	
						if($map['sp_dq_jj']==$zgjj)  //当前级别等于最高级别 就是 1 2 3级全部通过 去修改开票状态
						{
						
							$m_ht_base=M('hetong');
							$m_ap['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$m_ap['ht_id']=$_GET['ht_id'];
							$datass['ht_sp']=1;
							$sql_saveht=$m_ht_base->where($m_ap)->save($datass);
							if($sql_saveht){
								echo "全部人员审批通过";
							}
							
						}else{  
						                     //x级过了  扔给 x+1 级去审批
							$map_xiaji['sp_dq_jj']=$map['sp_dq_jj']+1;
							$map_xiaji['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$map_xiaji['sp_yy']=1;
							$map_xiaji['sp_sjid']=$_GET['ht_id'];
							$map_xiaji['sp_jg']=128;
							$data_map['sp_jg']=0;
							$sal_save=M('sp')->where($map_xiaji)->save($data_map);
							if($sal_save){
								echo "已通知下级";
							}
						}
					}else{ //测试 以下删除
						echo "您已通过  ";
					}

	
			}elseif($tb==0){
							

					/**		$map_xiaji['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$map_xiaji['sp_yy']=1;
							$map_xiaji['sp_sjid']=$_GET['ht_id'];
						
							$data_map['sp_jg']=1;
							$data_map['sp_xgr']=cookie('user_fid');
							$sal_save=M('sp')->where($map_xiaji)->save($data_map);

							$m_ht_base=M('hetong');
							$m_ap['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$m_ap['ht_id']=$_GET['ht_id'];
							$datass['ht_sp']=1;
							$sql_saveht=$m_ht_base->where($m_ap)->save($datass);
							if($sql_savekp){
								echo "审批通过";//缺少把他人的给修改了
									}**/
											$save_kpsp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //修改同级其他 工作人员的审批为别人已审批
											$save_kpsp['sp_sjid']=$_GET['ht_id'];
											$save_kpsp['sp_yy']=1;
											$save_kpsp['sp_dq_jj']=$tjr;
											$save_kpsp['sp_jg']=0;
											$save_kpo['sp_jg']=4;//34为别人已审批
											$save_kpo['sp_xgr']=cookie('user_id');
											$sql_spkp_save=$kp_base->where($save_kpsp)->save($save_kpo);
								if($tjr==$zgjj)  //当前级别等于最高级别 就是 1 2 3级全部通过 去修改开票状态
									{
										$m_ht_base=M('hetong');
										$m_ap['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
										$m_ap['ht_id']=$_GET['ht_id'];
										$datass['ht_sp']=1;
										$sql_saveht=$m_ht_base->where($m_ap)->save($datass);
										if($sql_saveht){

											

											echo "全部人员审批通过";
										}

									}else{                       //x级过了  扔给 x+1 级去审批
										$map_xiaji['sp_dq_jj']=$tjr+1;
										$map_xiaji['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
										$map_xiaji['sp_yy']=1;
										$map_xiaji['sp_sjid']=$_GET['ht_id'];
										$map_xiaji['sp_jg']=128;
										$data_map['sp_jg']=0;
										$sal_save=M('sp')->where($map_xiaji)->save($data_map);
										if($sal_save){


											


											echo "已通知下级";
										}
									}
						
			}

		}
		public function xiangqing(){
			$id=$_GET['id'];
			//$id=88;
			$kp_add_base=M('kp');
			$kpyh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$kaipiao=$kp_add_base->query("select * from  crm_kp where wocao=$kpyh and  kp_id =$id");
			if($kaipiao[0]['kp_type']==0)
			{
				$xq_show.="<table class='uk-form'>";
					$xq_show.="<tr><td><span class='righ'>发票开头：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_tt']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>纳税人识别码：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_sbm']."</span></td></tr>";
				$xq_show.="<table>";
			}elseif($kaipiao[0]['kp_type']==1)
																	
			{
				$xq_show.="<table class='uk-form'>";
					$xq_show.="<tr><td><span class='righ'>单位名称：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_dw']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>纳税人识别码：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_sbm1']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>注册地址：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_zcdz']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>注册电话：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_zcdh']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>开户银行：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_khyh']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>银行账户：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_yhzh']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>收票人姓名：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_spr']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>收票人手机：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_sprphone']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>收票人省份：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_sheng']."</span></td></tr>";
					$xq_show.="<tr><td><span class='righ'>详细信息：</span></td><td ><span class='righ1'>".$kaipiao[0]['kp_fp_xiangxi']."</span></td></tr>";

				$xq_show.="<table>";
			}
			echo $xq_show;
		//	echo "<pre>";
		//	var_dump($xq_show);exit;

		}
			public function shangji(){
		
				$sj_base=M('shangji');
				$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$sj_sql=$sj_base->query("select * from  crm_shangji where sj_yh='$map'");
				
				foreach($sj_sql as $kkh =>$vkh)
				{
					$sj_json=json_decode($vkh['sj_data'],true);
					
							$sj['id']=$vkh['sj_id'];
							$sj['name']=$sj_json['zdy0'];
							$sj_name[$vkh['sj_id']]=$sj;
				}
				
				return $sj_name;
			}
			public function fujian(){
				$map['name_id']=$_GET['id'];
				$map['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
				$map['mk']=6;
				$base=M('file');

				$sql=$base->where($map)->select();
				foreach($sql as $k=>$v)
				{
					$fujian.="<tr><td><span style='cursor:pointer;color:blue' title='点击下载' onclick='fj_xz(this)' class='".$v['lujing']."'>".$v['fujian_name']."</span></td></tr>";
				}
				echo $fujian;
			}
			public function ht_bohui(){
			$tb=$_GET['tb'];

			$id=$_GET['id'];

			$yuany['sp_yuanyin']=$_GET['yuanyin'];
			$yuany['sp_jg']=2;
			//echo $id.$yuany;
			$ht_base=M('sp');
			$map_sp['sp_id']=$id;
			$map_sp['sp_yy']=1;
			$map_sp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$ht_save=$ht_base->where($map_sp)->save($yuany);
			if($ht_save){
			
				
					$save_htsp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //修改同级其他 工作人员的审批为别人已审批
					$save_htsp['sp_sjid']=$_GET['ht_id'];
					$save_htsp['sp_yy']=1;
					$save_htsp['sp_jg']=array("in","0,128");
			
					$save_kpo['sp_jg']=3;//3为别人已审批
					$save_kpo['sp_xgr']=cookie('user_id');
					$save_kpo['sp_yuanyin']=$_GET['yuanyin'];
					$sql_spht_save=$ht_base->where($save_htsp)->save($save_kpo);
					//审批只要遇到一个驳回  这条信息就是驳回 修改信息状态
					$kp_base=M('hetong');
					$map_kp['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$map_kp['ht_id']=$_GET['ht_id'];
				//	$map_kp['kp_sp']=0;
					$data_kp['ht_sp']=2;
					$kp_sav=$kp_base->where($map_kp)->save($data_kp);


			}else{
				echo "nsave";
			}
			//$data['sp_jg']="2";
			//$sql_save=$sp_base->where($map_sp)->save($data);
		}
		
}






















