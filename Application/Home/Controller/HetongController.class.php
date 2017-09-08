<?php
namespace Home\Controller;
use Think\Controller;


class HetongController extends Controller {

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

		public function user(){                 //负责人和部门
		$xiaji= $this->get_xiashu_id();;//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
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
	
	 	$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id IN ($xiaji)");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
					}
						
				}
			} 
	
			
return $fzr_only;
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
public function kehu(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map' and kh_fz IN ($xiaji)");
		
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
	public function shangji()
	{
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		
		$sj_base=M('shangji');
		$data_sj=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$data_sj' and sj_fz IN ($xiaji)");// 查询商机信息
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
	public function department(){                                   //部门表查询
		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
		return $dpt_arr;
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
	public function hetong(){
		$ywzd=$this->ywzd();
		$kehu=$this->kehu();
		$ywcs=$this->ywcs();
		$shangji=$this->shangji();
		$userqb=$this->userqb();
	//	echo "<pre>";
	//	var_dump($shangji);exit;
		//批量编辑
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$ht_base=M('hetong');
		$data_ht=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$fenye=$_GET['fenye'];
		if($fenye==null || $fenye=='')
		{
			$list_num=10;
		}else{
			$list_num=$fenye;
		}
		$dijiye=$_GET['dijiye'];
		if($dijiye==null || $dijiye=="")
		{
			$new=0;
			$dijiye=1;
		}else{
			$new=($dijiye-1)*$list_num;
		}
		
		$userarr=$ht_base->query("select * from crm_hetong where ht_yh='$data_ht' and ht_fz IN ($xiaji) order by ht_id desc limit ".$new.",".$list_num." ");// 查询商机信息
		$userarr_count=$ht_base->query("select count(ht_id) from crm_hetong where ht_yh='$data_ht' and ht_fz IN ($xiaji)");
		
		$ys= ceil($userarr_count['0']['count(ht_id)']/$list_num);//多少页


		foreach($userarr as $v)
		{
			foreach($v as $k1 =>$v1)
			{
				if($k1!='ht_data')
				{
					$ht_sql[$k1]=$v1;
				}else{
					$ht_json=json_decode($v[$k1],true);
					foreach($ht_json as $k2=>$v2)
					{
						$ht_sql[$k2]=$v2;
					}
				}
				$ht_sql2[$v['ht_id']]=$ht_sql;
			}
			
		}
	$hetong=$ht_sql2;
	
		foreach($ywzd as $k=>$v)
		{
			if($v['qy']==1)
			{
				if($v['id']=='zdy7' || $v['id']=='zdy10' || $v['id']=='zdy11')
				{
					$bir[]=$v;           //批量编辑用
				}
			}
		}
		//echo "<pre>";
		//var_dump($ywcs);exit;
		foreach($bir as $k=>$v)
		{
			$bj_tab.="<tr class=' yincang top_pl_bj' style='line-height:70px' id='wc".$v['id']."'><td>".$v['name'].":</td>";
		
				$bj_tab.="<td>";
				$bj_tab.="<select id='".$v['id'].'wys'."'  style='width:300px;height:30px;'>";
				foreach($ywcs[$v['id']] as $k=>$vv)
				{
						$bj_tab.="<option value='$k'>".$vv."</option>";
				}
				$bj_tab.="</select>";
				$bj_tab.="</td>";
			$bj_tab.="</tr>";    
		}
		//新增
	//	echo "<pre>";
		//var_dump($ywzd)e
		foreach($ywzd as $k=>$v)
		{
			if($v['bt']=="1")
			{	
				if($v['type']=="2") //时间
				{
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
					$show_bt.="<td><input type='text' name='".$v['id']."' value='' class='required text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."> </td></tr>	";		
				}elseif($v['type']=="3")
				{	
					if($v['id']=='zdy1')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td id='kh_name'><select name='".$v['id']."' class='required ht_ss'  id='xl1'>";

								$show_bt.="	<option value=''> --选择客户--</option>";
								$show_bt.="	<option value='xz_kh'> --新增客户--</option>";
							foreach($kehu as $kkh =>$vkh)
							{
								$show_bt.="	<option value='".$vkh['id']."'> ".$vkh['name']."</option>";
							}
						$show_bt.=  " </select></td></tr>	";		
					}
					elseif($v['id']=='zdy2')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td ><select name='".$v['id']."' class='th_sj required sjgl' id='sjtz' onchange='sjtzz(this)'>";
							
								$show_bt.="	<option value=''> 请先选择对应客户</option>";
								$show_bt.="	<option value='xzsj'>新增商机(此商机对应商机)</option>";
						
						$show_bt.=  " </select></td></tr>";		
					}elseif($v['id']=='zdy7'){

						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><select name='".$v['id']."' class='required'>";

								$show_bt.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt.=  " </select></td></tr>	";		
					}elseif($v['id']=='zdy10'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><select name='".$v['id']."' class='required' >";
 
								$show_bt.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt.=  " </select></td></tr>	";	
					}elseif($v['id']=='zdy11'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><select name='".$v['id']."' class='required' >";

								$show_bt.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt.=  " </select></td></tr>	";	
					}
					
				}else{
					if($v['id']=='zdy9')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><input type='button'  value='".$v['id']."' > </td></tr>	";

					}elseif($v['id']=='zdy14')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><input type='button' value='".$v['id']."' > </td></tr>	";

					}elseif($v['id']=='zdy16')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><input type='button' value='".$v['id']."' > </td></tr>	";


					}elseif($v['id']=='zdy13')
					{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td>
										<select  name='".$v['id']."'>";
											foreach($userqb as $k=>$v )
											{
												$show_bt.="<option  value='".$v['user_id']."'>".$v['user_name']."</option>";
											}
										$show_bt.="	</select>
									 </td></tr>	";		
			
					}else{
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name'].":</td>";
						$show_bt.="<td><input type='text' class='required' name='".$v['id']."' value='' > </td></tr>	";		
					}
		
				}
					
				

			}elseif($v['cy']=="1")
			{
				if($v['type']=="2") //时间
				{
					$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
					$show_bt1.="<td><input type='text' name='".$v['id']."' value='' class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."> </td></tr>	";		
				}elseif($v['type']=="3")
				{	
					if($v['id']=='zdy1')
					{
						$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
						$show_bt1.="<td><select name='".$v['id']."' onchange='get_sj(this)'>";

								$show_bt1.="	<option value=''> --选择客户--</option>";
							foreach($kehu as $kkh =>$vkh)
							{
								$show_bt1.="	<option value='".$vkh['id']."'> ".$vkh['name']."</option>";
							}
						$show_bt1.=  " </select></td></tr>	";		
					}
					elseif($v['id']=='zdy2')
					{
						$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
						$show_bt1.="<td ><select name='".$v['id']."' class='th_sj'>";
							
								$show_bt1.="	<option value='pipixia'> 请先选择对应客户</option>";
						
						$show_bt1.=  " </select></td></tr>	";		
					}elseif($v['id']=='zdy7'){

						$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
						$show_bt1.="<td><select name='".$v['id']."' >";

								$show_bt1.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt1.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt1.=  " </select></td></tr>	";		
					}elseif($v['id']=='zdy10'){
						$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
						$show_bt1.="<td><select name='".$v['id']."' >";

								$show_bt1.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt1.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt1.=  " </select></td></tr>	";	
					}elseif($v['id']=='zdy11'){
						$show_bt1.="<tr class='addtr'><td>".$v['name'].":</td>";
						$show_bt1.="<td><select name='".$v['id']."'>";

								$show_bt1.="	<option value=''> --请选择--</option>";
							foreach($ywcs[$v['id']] as $k =>$v)
							{
								$show_bt1.="	<option value='".$k."'> ".$v."</option>";
							}
						$show_bt1.=  " </select></td></tr>	";	
					}
					
				}else{
					if($v['id']=='zdy9')
					{
						$show_bt1.="<tr class='addtr '><td>".$v['name'].":</td>";
						$show_bt1.="<td><input type='button' class='uk-button' onclick='cp_add()' name='cpgd'value='添加产品' > </td></tr>	";
					
						$show_bt1.="<tr><td colspan='2'>";
							$show_bt1.="<table class='layui-table cp' lay-skin='line' style='display: none;border:1px'>";
								 	 $show_bt1.="<thead>
								  				<th >产品名称</th>
						  						<th >产品原价</th>
						  						<th >建议价格</td>
						  						<th >数量</th>
						  						<th >折扣</th>
						  						<th >总价</th>
						  						<th >操作</th>
											</thead>";
									 $show_bt1.="<tbody class='tihuan'>";
								
									  $show_bt1.="</tbody>
										 </table>";
						$show_bt1.="</td></tr>";

					}elseif($v['id']=='zdy14')
					{
						$show_bt1.="<tr class='addtr ncy'><td>".$v['name'].":</td>";
						$show_bt1.="<li><td><input type='file' lay-type='file' class='layui-upload-file' name='csv_up'> </td></tr>	";
							
  							$show_bt1.="<tr ><td colspan='2'>";
							$show_bt1.="<table class='layui-table yc_xs' lay-skin='line'>";
								 	$show_bt1.="<thead>
								  				<th >附件名字</th>
						  						<th >大小</th>
						  						<th >进度</td>
						  						<th >操作</th>
											</thead>";
									$show_bt1.="<tbody class='fj_th'>";
							
									$show_bt1.="</tbody>
										 </table>";
						 $show_bt1.="</td></tr>"; 

					}elseif($v['id']=='zdy16')
					{
					
						
					}else{
						$show_bt1.="<tr class='addtr '><td>".$v['name'].":</td>";
						$show_bt1.="<td><input type='text' name='".$v['id']."' value='' > </td></tr>	";		
					}
				}
					
				

			}else{ //不常用
				if($v['id']=='zdy9')
					{
						$show_ncy.="<tr class='addtr ncy'><td>".$v['name'].":</td>";
						$show_ncy.="<td><input type='button' class='uk-button'  onclick='cp_add()' name='cpgd'value='添加产品' > </td></tr>	";

						$show_ncy.="<tr><td colspan='2'>";
							$show_ncy.="<table class='layui-table cp' lay-skin='line' style='display: none;border:1px'>";
								 	 $show_ncy.="<thead>
								  				<th >产品名称</th>
						  						<th >产品原价</th>
						  						<th >建议价格</td>
						  						<th >数量</th>
						  						<th >折扣</th>
						  						<th >总价</th>
						  						<th >操作</th>
											</thead>";
									$show_ncy.="<tbody class='tihuan'>";
								
									 $show_ncy.="</tbody>
										 </table>";
						$show_bt.="</td></tr>"; 

					}elseif($v['id']=='zdy14')
					{
						$show_ncy.="<tr class='addtr ncy'><td>".$v['name'].":</td>";
						$show_ncy.="<li><td><input type='file' lay-type='file' class='layui-upload-file' name='csv_up'> </td></tr>	";
							
  							$show_ncy.="<tr ><td colspan='2'>";
							$show_ncy.="<table class='layui-table yc_xs' lay-skin='line'>";
								 	 $show_ncy.="<thead>
								  				<th >附件名字</th>
						  						<th >大小</th>
						  						<th >进度</td>
						  						<th >操作</th>
											</thead>";
									$show_ncy.="<tbody class='fj_th'>";
							
									 $show_ncy.="</tbody>
										 </table>";
						 $show_ncy.="</td></tr>"; 



					}elseif($v['id']=='zdy16')
					{
						
						
					}else{
						$show_ncy.="<tr class='addtr ncy'><td>".$v['name'].":</td>";
						$show_ncy.="<td><input type='text'  name='".$v['id']."' value='' > </td></tr>	";		
					}
			}
		}
		$user=$this->user();

			$jw.="<tr class='addtr'><td><span style='color:red'>*</span>负责人:</td>";
			$jw.="<td><select name='ht_fz' class='required' id='xl2' onchange='get_bm(this)'>";
			$jw.="<option  value='".$v['user_id']."'>请选择负责人</option>";	
				foreach($user as $k=>$v)
				{
					$jw.="<option  value='".$v['user_id']."'>".$v['user_name']."</option>";
				}
			$jw.=" </select></td></tr>	";
			$jw.="<tr class='addtr '><td>部门:</td>";
			$jw.="<td class='bm_th' ><input type='text' name='ht_department' disabled value='' > </td>";
	

		$array_jiansuo=array('ht_fz'=>"负责人",'ht_bm'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"最新跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"原负责人",'ht_old_bm'=>"原负责人部门",'ht_cj_date'=>"创建时间","ht_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[$k]=$new_str1;
					}

		$ht_biaoti1=array_merge_recursive($ywzd,$new_arrayoo);//客户标题名字


		
		
		foreach($hetong as $k=>$v)
		{
				$content.="<tr id='".$v['ht_id']."'><td><input type='checkbox' class='chbox_duoxuan' id='".$v['ht_id']."'></td>";
			foreach($ht_biaoti1 as $kbt => $vbt)
			{
				if($v[$kbt]!="")
				{
					if($kbt=='zdy0')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Hetongmingcheng/hetongmingcheng/id/".$v['ht_id']."'><span style='color:blue' >".$v[$kbt]."</span></a></td>";
					elseif($kbt=='zdy1'){
						$kh_mc=$kehu[$v[$kbt]]['name'];
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Kehu/Kehumingcheng/id/$kh_mc/kh_id/$v[$kbt]'><span style='color:blue' >".$kehu[$v[$kbt]]['name']."</span></a></td>";
						}
					elseif($kbt=='zdy2')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/Shangjimingcheng/id/".$v[$kbt]."'><span style='color:blue' >".$shangji[$v[$kbt]]['zdy0']."</span></a></td>";
					elseif($kbt=="zdy7"||$kbt=="zdy10"||$kbt=="zdy11")
							$content.="<td>".$ywcs[$kbt][$v[$kbt]]."</td>";
					elseif($kbt=='ht_fz' || $kbt=='ht_cj' ||$kbt=='ht_old_fz' ||$kbt=='zdy13')
						$content.="<td>".$user[$v[$kbt]]['user_name']."</td>";
					else
						$content.="<td>".$v[$kbt]."</td>";
				}else{
					$content.="<td>---</td>";
				}
				
			}
			$content."</tr>";
		}
						$peizhi.="<div class='sxzddiv' id='kehujibie'>";
						$peizhi.="<div class='sx_title' >合同范围：</div>";
						$peizhi.="<span class='sx_yes'>全部合同</span>";
						$peizhi.="<span class='sx_no'>我的合同</span>";
						$peizhi.="<span class='sx_no'>我下属的客户</span>";	
						$peizhi.="</div>";
						foreach($bir as $v)
						{
							$peizhi.="<div class='sxzddiv' id='".$v['id']."'>";
								$peizhi.=" <div class='sx_title' >".$v['name']."：</div>";
									$peizhi.=" <span class='sx_yes'>全部</span>";
								foreach($ywcs[$v['id']] as $k=>$vv)
								{
										$peizhi.="<span class='sx_no'>".$vv."</span>";
								}
							$peizhi.="</div>";

						}
		
        $chanpin=$this->chanpin();
			$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id' onchange='cp_aj(this)' class ='clk_fzr xlcp' id=' xlcp' style='width:300px;height:30px;'>";
							$chanpin1.="<option value='s'>请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0'].$v['zdy1']." </option>";
					}
					$chanpin1.="</select> </td></tr>";
		$this->assign('ys',$ys);//页数
		$this->assign('dijiye',$dijiye);
		$this->assign('list_num',$list_num);
		$this->assign('chanpin1',$chanpin1); 
		$this->assign('new_html',$new_html); 	
        $this->assign('peizhi',$peizhi);
		$this->assign('a',$content);
		$this->assign('show_bt',$show_bt);
		$this->assign('show_bt1',$show_bt1);
		$this->assign('show_ncy',$show_ncy);
		$this->assign('jw',$jw);
		$this->assign('ywzd',$ht_biaoti1);
		$this->assign('biaoti1',$bir);
		$this->assign('bj_tab',$bj_tab); 
		$this->assign('fuzeren',$user); 
		
		$this->display();
	}
	public function get_sj(){
		$id=$_GET['id'];
		$shangji=$this->shangji();
		//echo "<pre>";
	//	var_dump($shangji);exit;
		$num=1;
		$sj_th.="<select class='bjwh'>";
		$sj_th.="<option value=''>--请选择--</option>";
		$sj_th.="<option value='xzsj'>新增商机(此商机对应商机)</option>";
		foreach($shangji as $k => $v)
		{	
			if($v['zdy1']==$id)
			{	$num=$num+1;
				$sj_th.="<option value='".$v['sj_id']."'> ".$v['zdy0']."</option>";
			}

		}
		$sj_th.="</select>";
	
		$sj_th3.="<select class='bjwh'>";
			$sj_th3.="<option value=''>请添加对应商机 </option>";
			$sj_th3.="<option value='xzsj'>新增商机(此商机对应商机)</option>";
		$sj_th3.="</select>";
		if($num>1){
			echo $sj_th;
		}else{
			echo $sj_th3;
		}
		
	}
	public function get_bm(){
		$id=$_GET['id'];
		$user=$this->user();
		//echo "<pre>";
		//var_dump($user);exit;
			$jw.="<input type='text' name='ht_department' disabled value='".$user[$id]['department']."' > ";
			

		echo $jw;
	}
	public function add_ht(){
		$id=$_GET['id'];
	//	$id="zdy0:驱蚊器群,zdy1:277,zdy2:155,zdy3:444444,zdy4:2017-6-2 15:59:38,yyyy:2017-6-2 15:59:44,zdy6:2017-6-2 15:59:47,zdy7:canshu1,zdy15:2017-6-2 15:59:50,zdy8:00041,cpgd:添加产品,undefined:undefined,undefined:undefined,zdy10:,zdy11:,zdy12:,zdy13:,undefined:,undefined:undefined,undefined:undefined,zdy17:,zdy18:,ht_fz:1,ht_department:项目部-上海";
		$new_arr=explode(',',$id);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":",$v);
			if($ex['0']=="ht_fz")
			{
				$data['ht_fz']=$ex['1'];
			}elseif($ex['0']=="ht_department")
			{
				$data['ht_bm']=$ex['1'];
			}elseif($ex['0']=="cpgd" || $ex['0']=="fjgd" || $ex['0']=="jkgd" )
			{
				
			}else{
				$ex1[$ex['0']]=$ex['1'];
			}
			
		}
		$data["ht_data"]=json_encode($ex1,true);
		$data["ht_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["ht_cj"]=cookie('user_id');//本人ID  
		$data["ht_cj_date"]=time();
		$ht_base=M('hetong');
		$sql=$ht_base->add($data);
	//	echo "<pre>";
		//var_dump($ex1);exit;
		if($sql){
					
					$sql_sel=$ht_base->where($data)->field('ht_id')->find();
					$sql12['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql12['sj_id']=0; 
					$sql12['cp_mk']=6; 
					$sql12['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$dat['sj_id']= $sql_sel['ht_id'];
					$dat1['name_id']= $sql_sel['ht_id'];
					$sql_add=$cp_sj_base->where($sql12)->save($dat);

					$fj_map['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件   
					$fj_map['mk']=6;
					$fj_map['name_id']=0; 
					$fj_base=M('file');
					$sql_fj=$fj_base->where($fj_map)->save($dat1);
					$rz_bz="新增了合同：".$ex1['zdy0']."";
					$this->rizhi($ex1['zdy1'],$rz_bz,"1",$sql_sel['ht_id']);//1客户id   2备注    3 操作类型   4合同id  



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
															$fg=explode(",",$dingji[1]); //获取到最顶级一层的审批人

															$sp_kp_base=M('sp');
															$map_sp_kp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
															$map_sp_kp['sp_sj']=date("Y-m-d h:i:s");
															$map_sp_kp['sp_sjid']=$sql;//合同ID
															$map_sp_kp['sp_jg']=0;//未审批\

															$map_sp_kp['sp_yy']=1;//所属应用 3代表开票
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



		}else{
			echo 2;
		}
	
	}
	public function htselect(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$ht_base=M('hetong');
		$data_ht=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userarr=$ht_base->query("select * from crm_hetong where ht_yh='$data_ht' and ht_fz IN ($xiaji) order by ht_id desc");// 查询商机信息
		foreach($userarr as $v)
		{
			foreach($v as $k1 =>$v1)
			{
				if($k1!='ht_data')
				{
					$ht_sql[$k1]=$v1;
				}else{
					$ht_json=json_decode($v[$k1],true);
					foreach($ht_json as $k2=>$v2)
					{
						$ht_sql[$k2]=$v2;
					}
				}
				$ht_sql2[$v['ht_id']]=$ht_sql;
			}
			
		}
		return $ht_sql2;
	}
	public function del(){
		$id=$_GET['id'];
		$idex=explode(",", $id);
		foreach($idex as $k=>$v)
		{
				$map['ht_id']=$v;
				$ht_base=M('hetong');
				$sql_sql=$ht_base->where($map)->find();
				$sql_del=$ht_base->where($map)->delete();
				$sql_json=json_decode($sql_sql['ht_data'],true);
				$rz_bz="删除了合同".$sql_json['zdy0'];
				$this->rizhi($sql_json['zdy1'],$rz_bz,"2",$v);//1客户id   2备注    3 操作类型   4合同id  
		}
			

				
	}
	public function ajax_jb(){
			$ywzd=$this->ywzd();
		$kehu=$this->kehu();
		$ywcs=$this->ywcs();
		$shangji=$this->shangji();
		$user=$this->user();
		$array_jiansuo=array('ht_fz'=>"负责人",'ht_bm'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"最新跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"原负责人",'ht_old_bm'=>"原负责人部门",'ht_cj_date'=>"创建时间","ht_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[$k]=$new_str1;
					}

		$ht_biaoti1=array_merge_recursive($ywzd,$new_arrayoo);//客户标题名字
	
		$hetong=$this->htselect();
		foreach($hetong as $k=>$v)
		{
				$content.="<tr id='".$v['ht_id']."'><td><input type='checkbox' class='chbox_duoxuan' id='".$v['ht_id']."'></td>";
			foreach($ht_biaoti1 as $kbt => $vbt)
			{
				if($v[$kbt]!="")
				{
					if($kbt=='zdy0')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Hetongmingcheng/hetongmingcheng/id/".$v['ht_id']."'><span style='color:blue' >".$v[$kbt]."</span></a></td>";
					elseif($kbt=='zdy1'){
						$kh_mc=$kehu[$v[$kbt]]['name'];
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Kehu/Kehumingcheng/id/$kh_mc/kh_id/$v[$kbt]'><span style='color:blue' >".$kehu[$v[$kbt]]['name']."</span></a></td>";
						}
					elseif($kbt=='zdy2')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/Shangjimingcheng/id/$v[$kbt]'><span style='color:blue' >".$v[$kbt]."".$shangji[$v[$kbt]]['zdy0']."</span></a></td>";
					elseif($kbt=="zdy7"||$kbt=="zdy10"||$kbt=="zdy11")
							$content.="<td>".$ywcs[$kbt][$v[$kbt]]."</td>";
					elseif($kbt=='ht_fz' || $kbt=='ht_cj' ||$kbt=='ht_old_fz' ||$kbt=='zdy13')
						$content.="<td>".$userqb[$v[$kbt]]['user_name']."</td>";
					else
						$content.="<td>".$v[$kbt]."</td>";
				}else{
					$content.="<td>---</td>";
				}
				
			}
			$content."</tr>";
		}
	return $content;
	}
	public function pl_bianji(){
			$id=$_GET['id'];
			$id=substr($id,0,strlen($id)-1); //id
			//$id="152,153";
			$ziduan=$_GET['ziduan'];//zdy123445
		
			$content=$_GET['content'];//修改内容
		//	echo $id;
			$kehu_base=M('hetong');
			$sql=$kehu_base->query("select * from `crm_hetong` where `ht_id` in ($id)");
			//echo "<pre>";
		//	var_dump($sql);exit;
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['ht_data'],true);
			
				foreach($json as $k1=>$v2)
				{
					if($ziduan == $k1 )
					{
						$json[$k1]=$content;
						$da=$json;//data替换完成
						$map['ht_id']=$v['ht_id'];//条件
						$data['ht_data']=json_encode($da,true);//修改内容
						$save=$kehu_base->where($map)->save($data);
						$rz_bz="把合同的".$_GET['xgzd2']."改为了：".$_GET['content2']."";
						$this->rizhi($json['zdy1'],$rz_bz,"2",$v['ht_id']);//1客户id   2备注    3 操作类型   4合同id  	
					}
				}
			
				
			}
			$a = $this->ajax_jb();
					echo $a;
	}
	public function pl_zhuanyi(){
		$fuzeren=$_GET['id']; 
		$rz_fuzeren=$_GET['ziduan']; 
		$ht_id=$_GET['ht_id']; //商机ID          //负责人ID
		$id=substr($ht_id,0,strlen($ht_id)-1); //id
		$map['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$data['ht_fz']=$fuzeren;
		$idex=explode(",",$id);
		$sj_base=M('hetong');
		$user=$this->user();
		//echo "<pre>";
	//	var_dump($user);exit;
		$user=$this->user();
		foreach($idex as $k=>$v){

			$map['ht_id']=$v;
			$sql_sel=$sj_base->where($map)->field('ht_fz,ht_data')->find();
		
			$data['ht_old_fz']=$sql_sel['ht_fz'];
			$data['ht_old_bm']=$user[$sql_sel['ht_fz']]['department'];
			$data['ht_bm']=$user[$fuzeren]['department'];
			$sql_save=$sj_base->where($map)->save($data);
					$sql_khid=json_decode($sql_sel['ht_data'],true);
					$rz_bz="把合同由".$user[$sql_sel['ht_fz']]['user_name']."转移给了：".$rz_fuzeren."";
					$this->rizhi($sql_khid['zdy1'],$rz_bz,"2",$v);//1客户id   2备注    3 操作类型   4合同id  	
		}

		//$a = $this->ajax_jb();
					//echo $a;1
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
	public function cp_ajax(){
		$chanpin =$this->chanpin();
		$id=$_GET['id'];
		foreach($chanpin as $k=>$v)
		{
			if($v['cp_id']==$id){
				$yj=$v['zdy2'];
			}
		}
		echo $yj;
	}
		public function add_cp(){
		$id=$_GET['id'];
		//$id= "cp_id:58,cp_yj:6666,cp_jy:6666,cp_num1:1,cp_zk:100.0%,cp_zj:6666,cp_beizhu:		7";
		$ex=explode(',',$id);
		foreach($ex as $v)
		{
			$a=explode(":",$v);
			$sql[$a['0']]=$a['1'];
		}
		$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
		$sql['sj_id']='0'; 
		$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
		$sql['cp_mk']=6;
		$cp_sj_base=M('cp_sj');
		$sql_add=$cp_sj_base->add($sql);
		if($sql_add){
			$map['cp_sj_cj']=$sql['cp_sj_cj'];
			$map['cp_yh']=$sql['cp_yh'];
			$map['sj_id']=$sql['sj_id'];
			$map['cp_mk']=6;
			$sql_cp_cha=$cp_sj_base->where($map)->select();
			$chanpin=$this->chanpin();
		//	echo "<pre>";
			//var_dump($sql_cp_cha);exit;
			foreach($sql_cp_cha as $v)
			{
					 $table1.="<tr  class='".$v['cp_id1']."'>
		  				<td >".$chanpin[$v['cp_id']]['zdy0']."</td>
		  				<td >".$v['cp_yj']."</td>
		  				<td >".$v['cp_jy']."</td>
		  				<td >".$v['cp_num1']."</td>
		  				<td >".$v['cp_zk']."</td>
		  				<td >".$v['cp_zj']."</td>
		  				<td ><input type='button' value='删除' onclick='cp_del(this)' name='".$v['cp_id1']."' ></td>
					</tr> ";
			}
			echo $table1;
			 						
		} else{
			echo "2";
		}
	
		}	

			public function cp_del(){
				$id['cp_id1']=$_GET['id'];
				$id['cp_mk']=6;
				$cp_sj_base=M('cp_sj');
				$sql_del=$cp_sj_base->where($id)->delete();
				if($sql_del){
					echo "1";
				}else{
					echo "2";
				}
			}
			public function fujiandel(){
				$cnm['id']=$_GET['id'];
				$cnm['mk']='6';
				$cp_sj_base=M('file');
				$sql_del=$cp_sj_base->where($cnm)->delete();
				if($sql_del){
					echo "1";
				}else{
					echo "2";
				}
			}
			public function del_all(){
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_mk']=6; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$sql_add=$cp_sj_base->where($sql)->delete();

					$sql1['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql1['name_id']='0'; 
					$sql1['mk']=6; 
					$cp_sj_base1=M('file');
					$sql_add1=$cp_sj_base1->where($sql1)->delete();
			}
		
			public function wjsc_dr()
			{
				//文件保存
		        if(count($_FILES['csv_up'])<1)
		        {
		            echo '{"res":0}';
		            die();
		        }
				$getFileArr=$_FILES['csv_up'];
		        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
				
		        $newname=time().$getFileArr['name'];
		        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpfile/linshi/'.$newname);
		        if(!file_exists('./Public/chanpinfile/cpfile/linshi/'.$newname))//验证上传是否成功
		        {
		            echo '{"res":3}';
		            die();
		        }
		        
				$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
		       
		       
		        $map['name_id']=0;
		       	$map['sc_data']=time();
		       	$map['fujian_name']=$getFileArr['name'];
		       	$map['big']=$sizestr;
		       	$map['lujing']=$newname;
		       	$map['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件;
		       	$map['mk']=6;
		       	$file_base=M('file');
		       	$sql=$file_base->add($map);
		       	echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$getFileArr['name'].'"}';
			}	
			public function sql_fj(){
					$mapa['mk']=6;
		       		$mapa['name_id']=0;
		       		$mapa['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件;
		       		     	$file_base=M('file');
		       		$sql_select=$file_base->where($mapa)->select();
		       		foreach($sql_select as $v)
					{
						 $sql_fujian.="<tr class='".$v['id']."'>
			  				<td >".$v['fujian_name']."</td>
			  				<td >".$v['big']."</td>
			  				<td >完成</td>
			  				<td ><input type='button' value='删除' onclick='fj_del(this)' name='".$v['id']."' ></td>
						</tr> ";
					}
					echo $sql_fujian;
			}

	public function shaixuan(){

		$id=$_GET['id'];
		$new_id=substr($id,0,strlen($id)-1); 
	//	$new_id="zdy7,2|kehujibie,1|zdy10,3|";
		$new_arr=explode("|",$new_id);
		foreach($new_arr as $k=>$v)
		{
			$new_arr2=explode(",",$v);
			$new_arr3[]=$new_arr2;
		}

		//$new_arr_daoxu=array_reverse($new_arr3);
		foreach($new_arr3 as $kget=>$vget)
		{
			$get[$vget[0]]=$vget;         //  zdy0   dom 下标4   求完每个标题的唯一了
		}
		
		foreach($get as $kqb=>$vqb)
		{
			if($kqb!='kehujibie')
			{
				if($kqb!=''){
					if($vqb['1']!='1')
					{
						$get1[$vqb['0']]=$vqb;
					}
				}
			}
		}

		$get2=$get1;
		$av=1;
		foreach ($get2 as $k=>$v)
		{
			
			$get3[$v['0']]="canshu".($v['1']-$av);       //把 2替换成canshu1

		}
		foreach($get as $kkh =>$vkh)
		{
			if($kkh=="kehujibie")
			{
				$kehu_jibie=$vkh['1'];                  //判断商机 是全部商机  我的商机还是 我下属的商机       //zh这里通用
			}
		}
	
		
		$sj_base=M('hetong');
		$xiaji= $this->get_xiashu_id();// 全部商机
		$myid=cookie('user_id');//本人ID  
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$new_number=substr($xiaji,0,-(strlen($myid)+1));

		if($kehu_jibie=="3"){ 
			$userarr=$sj_base->query("select * from crm_hetong where ht_yh='$map' and ht_fz IN ($new_number)");                  //全部客户
			
		}elseif($kehu_jibie=="2"){               //我的客户
			$userarr=$sj_base->query("select * from crm_hetong where ht_yh='$map' and ht_fz ='$myid' ");

		}else{                                   //我下属的客户
			$userarr=$sj_base->query("select * from  crm_hetong where ht_yh='$map' and ht_fz IN ($xiaji)");
		}
		foreach($userarr as $v)
		{
			foreach($v as $k1 =>$v1)
			{
				if($k1!='ht_data')
				{
					$ht_sql[$k1]=$v1;
				}else{
					$ht_json=json_decode($v[$k1],true);
					foreach($ht_json as $k2=>$v2)
					{
						$ht_sql[$k2]=$v2;
					}
				}
				$ht_sql2[$v['ht_id']]=$ht_sql;
			}
			
		}
		foreach($ht_sql2 as $k=>$v)
		{
				if($v['zdy7']==$get3['zdy7'] || $get3['zdy7']=='' )
				{
					if($v['zdy10']==$get3['zdy10'] || $get3['zdy10']=='' )
					{
						if($v['zdy11']==$get3['zdy11'] || $get3['zdy11']=='' )
						{
							$ronghhh[]=$v;
						}
					}
				}
			
		}
		//echo "<pre>";
		//var_dump($get3);exit;
		$ywzd=$this->ywzd();
		$kehu=$this->kehu();
		$ywcs=$this->ywcs();
		$shangji=$this->shangji();
		$user=$this->user();
		$array_jiansuo=array('ht_fz'=>"负责人",'ht_bm'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"最新跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"原负责人",'ht_old_bm'=>"原负责人部门",'ht_cj_date'=>"创建时间","ht_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[$k]=$new_str1;
					}

		$ht_biaoti1=array_merge_recursive($ywzd,$new_arrayoo);//客户标题名字
		$jw.="</tr>";
		$hetong=$ronghhh; //替换合同
		foreach($hetong as $k=>$v)
		{
				$content.="<tr id='".$v['ht_id']."'><td><input type='checkbox' class='chbox_duoxuan' id='".$v['ht_id']."'></td>";
			foreach($ht_biaoti1 as $kbt => $vbt)
			{
				if($v[$kbt]!="")
				{
					if($kbt=='zdy0')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Hetongmingcheng/hetongmingcheng/id/$id'><span style='color:blue' >".$v[$kbt]."</span></a></td>";
					elseif($kbt=='zdy1'){
						$kh_mc=$kehu[$v[$kbt]]['name'];
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Kehu/Kehumingcheng/id/$kh_mc/kh_id/$v[$kbt]'><span style='color:blue' >".$kehu[$v[$kbt]]['name']."</span></a></td>";
						}
					elseif($kbt=='zdy2')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/Shangjimingcheng/id/$v[$kbt]'><span style='color:blue' >".$v[$kbt]."".$shangji[$v[$kbt]]['zdy0']."</span></a></td>";
					elseif($kbt=="zdy7"||$kbt=="zdy10"||$kbt=="zdy11")
							$content.="<td>".$ywcs[$kbt][$v[$kbt]]."</td>";
					elseif($kbt=='ht_fz' || $kbt=='ht_cj' ||$kbt=='ht_old_fz'||$kbt=='zdy13')
						$content.="<td>".$user[$v[$kbt]]['user_name']."</td>";
					else
						$content.="<td>".$v[$kbt]."</td>";
				}else{
					$content.="<td>---</td>";
				}
				
			}
			$content."</tr>";
		}
		echo $content;
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
	public function sousuo(){
		/**$user=$this->user();
		$ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
		foreach($ywcs_sql_json as $kywcs=>$vywcs)
		{
			$ywcs_new[$vywcs['id']]=$vywcs;
		}
		//var_dump($user);exit;**/
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$kehu= $this->kehu();//  查询下
		$shangji= $this->shangji();//  查询下
		$user= $this->user();//  查询下
		$ywcs= $this->ywcs();//  查询下
		$name=$_GET['id'];
		//$name="二级";
		$json_name=json_encode($name,true);
		$newstr = substr($json_name,0,strlen($json_name)-1); 
		$first =substr($newstr,1);  
		$tihuan= str_replace("\\", "\\\\\\\\", $first);
		$ht_base=M('hetong');
		$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$hetong=$ht_base->query("select * from crm_hetong where ht_yh = '$yh' and ht_fz IN ($xiaji) and  ht_data like '%".$tihuan."%'");
		
			foreach($hetong as $k=>$v)
				{
					foreach($v as $kk=>$vv)
					{
						if($kk!='ht_data')
							$ronghe[$k][$kk]=$vv;
						else
						{
							$rowjson=json_decode($vv,true);
							foreach($rowjson as $kkk=>$vvv)
							{	
								$ronghe[$k][$kkk]=$vvv;

							}
						}
					}
				}


	$ywzd=$this->ywzd();
		$array_jiansuo=array('ht_fz'=>"负责人",'ht_bm'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"最新跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"原负责人",'ht_old_bm'=>"原负责人部门",'ht_cj_date'=>"创建时间","ht_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[$k]=$new_str1;
					}

		$ht_biaoti1=array_merge_recursive($ywzd,$new_arrayoo);//客户标题名
	
		foreach($ronghe as $k=>$v)
		{
				$content.="<tr id='".$v['ht_id']."'><td><input type='checkbox' class='chbox_duoxuan' id='".$v['ht_id']."'></td>";
			foreach($ht_biaoti1 as $kbt => $vbt)
			{
				if($v[$kbt]!="")
				{
					if($kbt=='zdy0')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Hetongmingcheng/hetongmingcheng/id/".$v['ht_id']."'><span style='color:blue' >".$v[$kbt]."</span></a></td>";
					elseif($kbt=='zdy1'){
						$kh_mc=$kehu[$v[$kbt]]['name'];
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Kehu/Kehumingcheng/id/$kh_mc/kh_id/$v[$kbt]'><span style='color:blue' >".$kehu[$v[$kbt]]['name']."</span></a></td>";
						}
					elseif($kbt=='zdy2')
						$content.="<td><a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/Shangjimingcheng/id/".$v[$kbt]."'><span style='color:blue' >".$shangji[$v[$kbt]]['zdy0']."</span></a></td>";
					elseif($kbt=="zdy7"||$kbt=="zdy10"||$kbt=="zdy11")
							$content.="<td>".$ywcs[$kbt][$v[$kbt]]."</td>";
					elseif($kbt=='ht_fz' || $kbt=='ht_cj' ||$kbt=='ht_old_fz'||$kbt=='zdy13')
						$content.="<td>".$user[$v[$kbt]]['user_name']."</td>";
					else
						$content.="<td>".$v[$kbt]."</td>";
				}else{
					$content.="<td>---</td>";
				}
				
			}
			$content."</tr>";
		}
		echo $content;
	}
	public function add_shangji(){
		$kh_id_sj=$_GET['id'];
		//$kh_id_sj= "xz_kh";
			if($kh_id_sj!="xz_kh")
			{
			$lxr_base=M('lx');
	 		$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	 		$tiaojian='"zdy1":"'.$kh_id_sj.'"';
			$sql_lxr=$lxr_base->query("select * from crm_lx where lx_yh = '$yh' and lx_data like '%$tiaojian%'");
				foreach($sql_lxr as $k=>$v)
				{
					foreach($v as $k1=>$v1)
					{
						if($k1=="lx_data")
						{
							$lxr_json=json_decode($v[$k1],true);
								
								$lxr_new['lx_id']=$v['lx_id'];
								$lxr_new['lx_name']=$lxr_json['zdy0'];
								$lxr_end[]=$lxr_new;
						
						}
					}
				}
			}
		//echo "<pre>";
		//var_dump($lxr_end);exit;
		$user=$this->user();
		$data['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件               
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		//var_dump($new_array);exit;
		
		$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);                   //获取商机配置表参数
	
     
		foreach($ywcs_json as $kcs => $vcs)
		{
			foreach($vcs['qy'] as $kqy=>$vqy)
			{

				if($vqy=='1')
				{
					$cs_new[$kqy]=$vcs[$kqy];

				}
			}
			$new_ywcs[$vcs['id']]=$cs_new;            //获取到启用了的参数
			unset($cs_new);
			
		}
	//	echo "<pre>";
//ar_dump($ywcs_json );exit;
//echo "<pre>";
//var_dump($new_ywcs);exit;
		
		
		foreach($ywzd_sql_json as $kzd=>$vzd)                                      //后台判断生成模板
		{
			if($vzd['qy']=="1")
			{
				if($vzd['bt']=="1")
				{
					$table.="<tr class='addtr '>";
						if($vzd['id']!="zdy1")
						{
						$table.="<td><span style='color:red'>*</span>".$vzd['name'].":</td>";
						if($vzd['type']=="0") 
							$table.="<td><input type='text' class='required' id='wy".$vzd['id']."' name='".$vzd['id']."'  ></td>";   //  0文本框
						elseif($vzd['type']=="2")
							$table.="<td><input type='text' class='required' name='".$vzd['id']."'   class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
						if($vzd['id']=="zdy9")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."'  class='required ' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
							
							}elseif($vzd['id']=="zdy2"){
								if($kh_id_sj!="xz_kh")
								{
									$table.="<td>";
									$table.="<select name='".$vzd['id']."'  class='required ' style='width:300px;height:30px;'>";
											foreach($lxr_end as $k=>$v)
											{
												$table.="<option value='".$v['lx_id']."'>".$v['lx_name']."</option>";
											}
										
									$table.="</td>";
								}else{
									$lx_id74=$_GET['lx_id'];
								//	$lx_id74="206";
									$lxr_base=M('lx');
	 								$lxr_maplx['lx_id']=$lx_id74;//获取所属用户（所属公司）
	 								$lxr_maplx['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
	 								$lx_lxsql=$lxr_base->where($lxr_maplx)->find();
	 								
	 								if($lx_lxsql=='' || $lx_lxsql==null)//客户那里新增新的
	 								{
	 									$table.="<td>";
											$table.="<input name='".$vzd['id']."'  class='required ' value='".$lx_id74."' readonly='value'>";
										
											$table.="</td>";
	 								}else{                            //客户那里选的

	 									$san_json=json_decode($lx_lxsql['lx_data'],true);
	 								//	echo "<pre>";
	 								//var_dump($san_json);exit;
	 									$table.="<td>";
											$table.="<input name='".$vzd['id']."'  class='required ' value='".$san_json['zdy0']."' readonly='value'>";
											
											$table.="</td>";
	 								}
								}
							}elseif($vzd['id']=="zdy5")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' class='required ' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' id='".$vzd['id']."' class='required' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}
						}											//  3下拉选择
					$table.="</tr>";																						
	
				}
			}
			}
		}
	$table.="<tr class='addtr'><td><span style='color:red'>*</span>负责人:</td>";
			$table.="<td><select name='sj_fz' class='required' id='xl2' onchange='get_bm(this)'>";
			$table.="<option  value='".$v['user_id']."'>请选择负责人</option>";	
				foreach($user as $k=>$v)
				{
					$table.="<option  value='".$v['user_id']."'>".$v['user_name']."</option>";
				}
			$table.=" </select></td></tr>	";
			$table.="<tr class='addtr '><td>部门:</td>";
			$table.="<td class='bm_th' ><input type='text' name='sj_department' disabled value='' > </td>";

		echo $table;
	}
	public function add_ht1(){
		$xiaji= $this->get_xiashu_id();//  查询下级I
		$kehu=$_GET['kh']; 
		//$kehu="zdy0:2323,zdy1:canshu2,zdy2:23,zdy3:233223,zdy4:23,zdy5:23,zdy15:215,kh_fz:45,ht_department:销售部-国贸1,";
		if($kehu=="" || $kehu == null)       //z只需要处理 合同和商机。客户和联系人都有了
		{
			$shangji= $_GET['sj'];
			//$shangji="zdy0:标题拍合同,zdy1:104114,zdy2:晓明商机,zdy3:896000,zdy4:2017-7-13 18:11:34,zdy5:2017-7-4 18:11:37,zdy6:2017-7-4 18:11:40,zdy7:canshu1,zdy15:2017-7-4 18:11:42,zdy8:,cpgd:添加产品,undefined:undefined,undefined:undefined,zdy10:,zdy11:,zdy12:,zdy13:,undefined:,undefined:undefined,undefined:undefined,zdy17:,ht_fz:46,ht_department:技术部
		//	";
			$kh_id=$_GET['kh_id']; //选的客户
			$kh_id=104104;
		//	$shangji="zdy0:小母牛1,undefined:undefined,zdy2:142,zdy3:60000,zdy4:2017-7-4 18:25:41,sj_fz:46,ht_department:技术部,";
			$shangji_number=substr($shangji,0,strlen($shangji)-1); 
			$shangji_arr=explode(',',$shangji_number);
			
			foreach($shangji_arr as $k=>$v)
			{
				$sj_ex=explode(":",$v);
				if($sj_ex['0']=="sj_fz")
				{
					$sj_data["sj_fz"]=	$sj_ex['1'];//本人ID  ;
				}elseif($sj_ex['0']=="ht_department")
				{
					$sj_data["sj_bm"]=	$sj_ex['1'];//本人ID  ;
				
				}elseif($sj_ex['0']=="undefined"){

				}else{
					$sj_ex_json[$sj_ex['0']]=$sj_ex['1'];
				}		
			}
			$sj_ex_json['zdy1']=$kh_id;
			$sj_data['sj_data']=json_encode($sj_ex_json,true);
			$sj_data["sj_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$sj_data["sj_cj"]=cookie('user_id');//本人ID  
			$sj_data["sj_cj_date"]=time();
			$shangji_base=M('shangji');
			$shangji_add=$shangji_base->add($sj_data);
			if($shangji_add)//商机添加完了 添加合同开始
			{
				$hetong=$_GET['ht'];
			//	$hetong="zdy0:标题拍合同1,zdy1:104114,zdy2:晓明商机,zdy3:896000,zdy4:2017-7-13 18:11:34,zdy5:2017-7-4 18:11:37,zdy6:2017-7-4 18:11:40,zdy7:canshu1,zdy15:2017-7-4 18:11:42,zdy8:,cpgd:添加产品,undefined:undefined,undefined:undefined,zdy10:,zdy11:,zdy12:,zdy13:,undefined:,undefined:undefined,undefined:undefined,zdy17:,ht_fz:46,ht_department:技术部";
					$ht_new_arr=explode(',',$hetong);
					foreach($ht_new_arr as $k=>$v)
					{
						$ht_ex=explode(":",$v);
						if($ht_ex['0']=="ht_fz")
						{
							$ht_data['ht_fz']=$ht_ex['1'];
						}elseif($ht_ex['0']=="ht_department")
						{
							$ht_data['ht_bm']=$ht_ex['1'];
						}elseif($ht_ex['0']=="cpgd" || $ht_ex['0']=="fjgd" || $ht_ex['0']=="jkgd" )
						{
							
						}else{
							if($ht_ex['0']=="zdy2"){
								$ht_ex1['zdy2']=$shangji_add;
							}else{
							$ht_ex1[$ht_ex['0']]=$ht_ex['1'];
							}
						}
						
					}
					$ht_data["ht_data"]=json_encode($ht_ex1,true);
					$ht_data["ht_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$ht_data["ht_cj"]=cookie('user_id');//本人ID  
					$ht_data["ht_cj_date"]=time();
					$ht_baseq=M('hetong');
					$ht_sql=$ht_baseq->add($ht_data);
					if($ht_sql)
					{	
						$sql_sel=$ht_sql;
						$sql12['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
						$sql12['sj_id']=0; 
						$sql12['cp_mk']=6; 
						$sql12['cp_sj_cj']=cookie('user_id'); //通用条件   
						$cp_sj_base=M('cp_sj');
						$dat['sj_id']= $sql_sel;
					//	$dat1['name_id']= $sql_sel;
						$sql_add=$cp_sj_base->where($sql12)->save($dat); //应该缺少修改附件

						
					}else{
						echo "2";
					}
			}
		}else{

			$lxr_id_sel=$_GET['lxr_id'];
			//$lxr_id_sel="lslxr";
				$lx_base=M('lx');
				if($lxr_id_sel=="lslxr"){     //先添加联系人 这里是  新增的 else 是选择的
					$lxr75=$_GET['lxr'];
					//$lxr75="zdy0:我收,zdy2:lxrzdy2,zdy4:lxrzdy4,zdy6:lxrzdy6,zdy10:lxrzdy10,zdy12[]:北京市-北京市市辖区-东城区,";
					$lxr_number=substr($lxr75,0,strlen($lxr75)-1); 

					$lxr_ex=explode(',',$lxr_number);
					foreach($lxr_ex as $k=>$v)
					{
						$exv=explode(":",$v);
						if($exv['0']=="zdy12[]")
						{
						$exv1['zdy12']=$exv['1'];
						}else{
						$exv1[$exv['0']]=$exv['1'];
						}
					}
				
					$lxr_map1['lx_data']=json_encode($exv1,true);
					$lxr_map1['lx_cj_date']=time();
					$lxr_map1['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$lxr_map1['lx_cj']=cookie('user_id');
			//	echo "<pre>";var_dump($lxr_map1);exit;
					$lxr_add=$lx_base->add($lxr_map1); //联系人添加完了 添加客户
				}else{
					$lxr_id=$lxr_id_sel;
					$new_xiaji=$xiaji;          
					$new_array=explode(',',$new_xiaji);
					$lx_yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$lx_sql=$lx_base->query("select * from  crm_lx where lx_yh='$lx_yh' and lx_id='$lxr_id' and lx_cj IN ($xiaji)");
					$lxr_json=json_decode($lx_sql['0']['lx_data'],true);
					$lxr_json['zdy1']="lssj";
					$lxr_map['lx_data']=json_encode($lxr_json,true);
					$lxr_map['lx_cj_date']=time();
					$lxr_map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
					$lxr_map['lx_cj']=cookie('user_id');
					$lxr_add=$lx_base->add($lxr_map);

				}
					if($lxr_add){
				
						$kehu75=$_GET['kh'];
						//$kehu75="zdy0:新的客户1,zdy1:canshu1,zdy2:4545,zdy3:45,zdy4:4545,zdy5:45,zdy15:lslxr,kh_fz:47,ht_department:技术部,";
						$kh_number=substr($kehu75,0,strlen($kehu75)-1); 
						$kh_ex=explode(',',$kh_number);
						foreach($kh_ex as $k=>$v)
						{
							$kh_ex=explode(":",$v);
							if($kh_ex['0']=="kh_fz")
							{
								$data_kh75["kh_fz"]=$kh_ex['1'];//本人ID  ;
							}elseif($kh_ex['0']=="ht_department")
							{
								$data_kh75["kh_bm"]=$kh_ex['1'];//本人ID  ;
							}else{
								if($kh_ex['0']=='zdy15')
								{
									$kh_ex1['zdy15']=$lxr_add;
								}else{
								$kh_ex1[$kh_ex['0']]=$kh_ex['1'];
								}
							}		
						}
						//echo "<pre>";
						//var_dump($kh_ex1);exit;
						$data_kh75["kh_data"]=json_encode($kh_ex1,true);
						$data_kh75["kh_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
						$data_kh75["kh_cj"]=cookie('user_id');//本人ID  ;
						$data_kh75["kh_cj_date"]=time();//本人ID  ;
						
						//var_dump($data["kh_data"]);
						//echo "<pre>";
						//var_dump($data_kh75);exit;
						$kh_base=M('kh');
						$add_kh=$kh_base->add($data_kh75);
						if($add_kh)
						{
							$shangji=$_GET['sj'];
							//$shangji="zdy0:安慰法1,undefined:undefined,zdy2:281,zdy3:2333333,zdy4:2017-7-5 17:37:46,sj_fz:46,ht_department:技术部,";
							$sj_number=substr($shangji,0,strlen($shangji)-1); 
							$sj_ex=explode(",",$sj_number);
							foreach($sj_ex as $k=>$v){
								$sj_ex=explode(":",$v);
								if($sj_ex["0"]=="sj_fz")
								{
									$sj_data['sj_fz']=$sj_ex["1"];
								}elseif($sj_ex["0"]=="ht_department"){
									$sj_data['sj_bm']=$sj_ex["1"];
								}else{
									if($sj_ex["0"]=="zdy2")
									{
										$sj_ex1["zdy2"]=$lxr_add;
									}elseif($sj_ex["0"]==undefined){

									}else{
										$sj_ex1[$sj_ex['0']]=$sj_ex['1'];
									}
								}

							}
							$sj_ex1["zdy1"]=$add_kh;
							$sj_data["sj_data"]=json_encode($sj_ex1,true);
							$sj_data["sj_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
							$sj_data["sj_cj"]=cookie('user_id');//本人ID  
							$sj_data["sj_cj_date"]=time();
							$shangji_base=M('shangji');
							$sj_add=$shangji_base->add($sj_data);
							if($sj_add){
								$hetong=$_GET['ht'];
								//$hetong="zdy0:真的合同,zdy1:合同公司,zdy2:即可看看,zdy3:45656,zdy4:2017-12-5 18:02:07,zdy5:2017-7-14 18:02:10,zdy6:2017-7-20 18:02:16,zdy7:canshu4,zdy15:2017-7-24 18:02:20,zdy8:,cpgd:添加产品,undefined:undefined,undefined:undefined,zdy10:,zdy11:,zdy12:,zdy13:,undefined:,undefined:undefined,undefined:undefined,zdy17:,ht_fz:46,ht_department:技术部";
							$ht_ex=explode(",",$hetong);
								foreach($ht_ex as $k=>$v)
								{
									$ht_ex=explode(":",$v);
									if($ht_ex["0"]=="ht_fz")
									{
										$ht_data['ht_fz']=$ht_ex["1"];
									}elseif($ht_ex["0"]=="ht_department"){
										$ht_data['ht_bm']=$ht_ex["1"];
									}elseif($ht_ex["0"]==undefined){
									}else{
										if($ht_ex["0"]=="zdy1")
										{
											$ht_ex1["zdy1"]=$add_kh;
										}elseif($ht_ex["0"]=="zdy2"){
											$ht_ex1["zdy2"]=$sj_add;
										}else{
											$ht_ex1[$ht_ex['0']]=$ht_ex['1'];
										}
									}
								}
								
								$ht_data["ht_data"]=json_encode($ht_ex1,true);
								$ht_data["ht_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
								$ht_data["ht_cj"]=cookie('user_id');//本人ID  
								$ht_data["ht_cj_date"]=time();
								$ht_base=M('hetong');
								$sql_ht=$ht_base->add($ht_data);
								if($sql_ht)       //合同完成 修改最初的联系人少的客户ID
								{
									$lx_map['lx_id']=$lxr_add;
									$lx_map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
									$lx_base=M('lx');
									$sql_lx=$lx_base->where($lx_map)->find();
									$lx_json=json_decode($sql_lx['lx_data'],true);
									
									$lx_json['zdy1']=$add_kh;

									$lx_data_save['lx_data']=json_encode($lx_json,true);
									
									
									$lx_save=$lx_base->where($lx_map)->save($lx_data_save);
									if($lx_save){
										$sql_sel=$sql_ht;
										$sql12['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
										$sql12['sj_id']=0; 
										$sql12['cp_mk']=6; 
										$sql12['cp_sj_cj']=cookie('user_id'); //通用条件   
										$cp_sj_base=M('cp_sj');
										$dat['sj_id']= $sql_sel;
									//	$dat1['name_id']= $sql_sel;
										$sql_add=$cp_sj_base->where($sql12)->save($dat); //应该缺少修改附件
									}
								}
							}
							
						}
					}

		


			
		
		}				
					
	}
		public function shenpi_kp(){  //审批开票封装
		
			$shenpi_base=M('shenpi');
			$shenpi_map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
			$shenpi_map['sp_type']=1;
			$sql_shenpi=$shenpi_base->where($shenpi_map)->find();
			
			if($sql_shenpi['sp_kq']==1)
			{
				
					$a=$sql_shenpi['sp_tb']."|";
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
	Public function ceshia(){
													$spr=$this->shenpi_kp();
														if($spr!="zidongtongguo")
														{
															echo "1";exit;
															$dingji=explode("|",$spr);
															foreach($dingji as $k=>$v)
															{
																if($k!=0)
																{

																	$arr_new[]=$v;
															
																}
															}
															$gongjj=count($dingji)-1;
															$fg=explode(",",$dingji[1]); //获取到最顶级一层的审批人

															$sp_kp_base=M('sp');
															$map_sp_kp['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
															$map_sp_kp['sp_sj']=date("Y-m-d h:i:s");
															$map_sp_kp['sp_sjid']=$sql;//合同ID
															$map_sp_kp['sp_jg']=0;//未审批\

															$map_sp_kp['sp_yy']=1;//所属应用 3代表开票
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
															echo "222";exit;
															$kp_base=M('kp');     //自动通过
															$map_kp['wocao']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;;
															$map_kp['kp_id']=$kp_add;
															$data_kp['kp_sp']=1;
															$save_kp=$kp_base->where($map_kp)->save($data_kp);

														}

	}
}






















