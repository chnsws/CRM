<?php
namespace Home\Controller;
use Think\Controller;


class ShangjiController extends Controller {

	public function shangji(){
		$data['zd_yh']=cookie('user_id');//本人ID                     
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		//var_dump($new_array);exit;
		$kh_base=M('kh');
		$data_kh['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->where($data_kh)->select();
		$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);                          //获取商机配置表参数
		$sj_base=M('shangji');
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz IN ($xiaji)");// 查询商机信息

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
		}
		
//echo "<pre>";
//var_dump($new_ywcs);exit;
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			//$kh_json1=json_encode($kh_json,true);
			//echo "<pre>";
		//	var_dump($kh_json1);exit;
			foreach($new_array as $kxj=>$vxj)
			{
				if($kh_json['fuzeren']==$vxj){
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh_name[$vkh['kh_id']]=$kh;
				}
			}
		}
		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
	//echo "<pre>";
		//var_dump($dpt_arr);exit;
		$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
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
	
		foreach($userarr as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk!='sj_data')
					if($kk=="sj_fz")
					{
						$ronghe[$k][$kk]=$fzr_only[$vv]["user_name"];
					}elseif($kk=="sj_bm")
					{
						$ronghe[$k][$kk]=$dpt_arr[$vv]["bm_name"];
					}else{
						$ronghe[$k][$kk]=$vv;
					}
					
				else
				{
					$rowjson=json_decode($vv,true);
					foreach($rowjson as $kkk=>$vvv)
					{	

						if($new_ywcs[$kkk]!="")
						{
							$ronghe[$k][$kkk]=$new_ywcs[$kkk][$rowjson[$kkk]];   //下拉框 关联表的匹配
	
						}else{
							if($kkk=="zdy1")
							{
								$ronghe[$k][$kkk]=$kh_name[$vvv]['name'];         //匹配客户名字
							}else{
								$ronghe[$k][$kkk]=$vvv;
							}
						}
						

						

					}
				}
			}
		}
		foreach($ywzd_sql_json as $k=>$v)
		{
			if($v['qy']==1)
			{
				if($v['id']=='zdy5' || $v['id']=='zdy7' || $v['id']=='zdy9')
				{
					$bir[]=$v;           //批量编辑用
				}
			}
		}
	//echo "<pre>";
//	var_dump($bir);exit;
	
		
		$array_jiansuo=array('sj_qiandan'=>"签单可能性",'sj_new_gj'=>"最新跟进记录",'sj_sj_date'=>"实际跟进时间",'sj_fz'=>"负责人",'sj_bm'=>"部门",'sj_cj'=>"创建人",'sj_cj_date'=>"创建时间","sj_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($ywzd_sql_json,$new_arrayoo);//客户标题名字

		foreach($kh_biaoti1 as $k=>$v)
		{
			$biaoti[$v['id']]=$v;             //给标题数组赋值键
		}
	//	echo "<pre>";
		//var_dump($kh_biaoti1);exit;
//echo "<pre>";
//var_dump($ronghe);exit;
		foreach ($ronghe as $k =>$v)    
		{
			$id=$v['sj_id'];
			$show.="<tr>";
			$show.="
				<td >
				<input type='checkbox' class='chbox_duoxuan' id='".$v['sj_id']."'>".$v['sj_id']."
				</td>";
			foreach($biaoti as $k1=>$k2)
			{
				if($v[$k1]!="")
				{
					if($k1=="zdy0")    //商机标题  跳转到商机页面
					{ 
						$show.="<td> <a href='shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='Kehu/kehumingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}else{
						$show.="<td> ".$v[$k1]." </td>"	;
					}
				}else{
					$show.="<td> ---- </td>"	;
				}
			}
			$show.="</tr>";                                          //显示商机信息模板
		}
		//echo $show;
		foreach($ywzd_sql_json as $kzd=>$vzd)                                      //后台判断生成模板
		{
			if($vzd['qy']=="1")
			{
				if($vzd['bt']=="1")
				{
					$table.="<tr class='addtr'>";
						$table.="<td><span style='color:red'>*</span>".$vzd['name'].":</td>";
						if($vzd['type']=="0") 
							$table.="<td><input type='text' name='".$vzd['id']."' value='' ></td>";   //  0文本框
						elseif($vzd['type']=="2")
							$table.="<td><input type='text' name='".$vzd['id']."'   class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table.="<option value='请选择'>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
								$table.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table.="<option value='请选择'>此模板还未做</option>";
								
										$table.="<option value='1'>小王</option>";
										$table.="<option value='2'>小李</option>";
									
								$table.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}else{
						
							$table1.="<td>";

								$table1.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品' >";
								
								$table1.="</td>";
								
				
							}
						}	
																//  3下拉选择
					$table.="</tr>";																						
				}else{
					$table1.="<tr class='addtr'>";
						$table1.="<td>".$vzd['name'].":</td>";
						if($vzd['type']=="0") 
							$table1.="<td><input type='text' name='".$vzd['id']."'  ></td>";   //  0文本框
						elseif($vzd['type']=="2")
							$table1.="<td><input type='text' name='".$vzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value='请选择'>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table1.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
								$table1.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value='请选择'>此模板还未做</option>";
								
										$table1.="<option value='1'>小王</option>";
										$table1.="<option value='2'>小李</option>";
									
								$table1.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value='请选择'>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							
							}else{
					
								
							$table1.="<td>";

								$table1.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品' >";
								
								$table1.="</td>";
				
							}
						}	
																//  3下拉选择
					$table1.="</tr>";	

				}
				
			}
		}
		//echo "<pre>";
	//var_dump($bir);exit;
		foreach($bir as $k=>$v)
		{
			$bj_tab.="<tr class='yincang top_pl_bj' style='line-height:70px' id='wc".$v['id']."'><td>".$v['name'].":</td>";
			if($v['type']=="3")                     //下拉框样式
			{
				$bj_tab.="<td>";
				$bj_tab.="<select id='".$v['id'].'wys'."'  style='width:260px;height:26px;'>";
				foreach($new_ywcs[$v['id']] as $k=>$vv)
				{
					//var_dump($ywcs_sql_json[$v['id']]);exit;
					if($k!='id'&&$k!='qy')
						$bj_tab.="<option value='$k'>".$vv."</option>";
				}
				$bj_tab.="</select>";
				$bj_tab.="</td>";
			}
			$bj_tab.="</tr>";    //
		}

		$new_html.="<div class='sxzddiv' id='kehujibie'>";
						$new_html.=" <div class='sx_title' >商机范围：</div>";
								$new_html.=" <span class='sx_yes'>全部商机</span>";
								$new_html.="<span class='sx_no'>我的商机</span>";
								$new_html.="<span class='sx_no'>我下属的商机</span>";					
					$new_html.="</div>";
			foreach($bir as $v)
			{
					$new_html.="<div class='sxzddiv' id='".$v['id']."'>";
						$new_html.=" <div class='sx_title' >".$v['name']."：</div>";
							$new_html.=" <span class='sx_yes'>全部</span>";
						foreach($new_ywcs[$v['id']] as $k=>$vv)
						{
						
								$new_html.="<span class='sx_no'>".$vv."</span>";
						}
					$new_html.="</div>";

			}
			$this->assign('new_html',$new_html); 	
		$this->assign('bj_tab',$bj_tab); 	
		//echo "<pre>";
	///	var_dump($ywcs_sql_json);exit;				
		$add=$table;  //必填
		$add1=$table1;//非必填
		$this->assign('show',$show);
		$this->assign('add1',$add1);		
		$this->assign('add',$add);	
		$this->assign('fuzeren',$fzr_only);	
		$this->assign('biaoti',$biaoti);	
		$this->assign('biaoti1',$bir);	
		$this->display();
	}
	public function gongyou(){
						$data['zd_yh']=cookie('user_id');//本人ID                     
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		//var_dump($new_array);exit;
		$kh_base=M('kh');
		$data_kh['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->where($data_kh)->select();
		$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);                          //获取商机配置表参数
		$sj_base=M('shangji');
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz IN ($xiaji)");// 查询商机信息
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
		}
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			//$kh_json1=json_encode($kh_json,true);
			//echo "<pre>";
		//	var_dump($kh_json1);exit;
			foreach($new_array as $kxj=>$vxj)
			{
				if($kh_json['fuzeren']==$vxj){
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh_name[$vkh['kh_id']]=$kh;
				}
			}
		}
		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
	//echo "<pre>";
		//var_dump($dpt_arr);exit;
		$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
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
	
		foreach($userarr as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk!='sj_data')
					if($kk=="sj_fz")
					{
						$ronghe[$k][$kk]=$fzr_only[$vv]["user_name"];
					}elseif($kk=="sj_bm")
					{
						$ronghe[$k][$kk]=$dpt_arr[$vv]["bm_name"];
					}else{
						$ronghe[$k][$kk]=$vv;
					}
					
				else
				{
					$rowjson=json_decode($vv,true);
					foreach($rowjson as $kkk=>$vvv)
					{	

						if($new_ywcs[$kkk]!="")
						{
							$ronghe[$k][$kkk]=$new_ywcs[$kkk][$rowjson[$kkk]];   //下拉框 关联表的匹配
	
						}else{
							if($kkk=="zdy1")
							{
								$ronghe[$k][$kkk]=$kh_name[$vvv]['name'];         //匹配客户名字
							}else{
								$ronghe[$k][$kkk]=$vvv;
							}
						}
						

						

					}
				}
			}
		}

	
		
		$array_jiansuo=array('sj_qiandan'=>"签单可能性",'sj_new_gj'=>"最新跟进记录",'sj_sj_date'=>"实际跟进时间",'sj_fz'=>"负责人",'sj_bm'=>"部门",'sj_cj'=>"创建人",'sj_cj_date'=>"创建时间","sj_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($ywzd_sql_json,$new_arrayoo);//客户标题名字
		foreach($kh_biaoti1 as $k=>$v)
		{
			$biaoti[$v['id']]=$v;             //给标题数组赋值键
		}

//echo "<pre>";
//var_dump($ronghe);exit;
		foreach ($ronghe as $k =>$v)    
		{
			$id=$v['sj_id'];
			$show.="<tr>";
			$show.="
				<td >
				<input type='checkbox' class='chbox_duoxuan' id='".$v['sj_id']."'>".$v['sj_id']."
				</td>";
			foreach($biaoti as $k1=>$k2)
			{
				if($v[$k1]!="")
				{
					if($k1=="zdy0")    //商机标题  跳转到商机页面
					{ 
						$show.="<td> <a href='shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='Kehu/kehumingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}else{
						$show.="<td> ".$v[$k1]." </td>"	;
					}
				}else{
					$show.="<td> ---- </td>"	;
				}
			}
			$show.="</tr>";                                          //显示商机信息模板
		}
					
					return $show;;
	}
	public function add(){
		$a=$_GET['id'];
		
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":",$v);
			if($ex['0']=="fuzeren")
			{
				$data['sj_fz']=$ex['1'];
			}elseif($ex['0']=="department")
			{
				$data['sj_bm']=$ex['1'];
			}
			elseif($ex['0']!="xiaodan")
			{
				$ex1[$ex['0']]=$ex['1'];
			}
			

		}
		
		$data["sj_data"]=json_encode($ex1,true);
		$data["sj_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$sj_base=M('shangji');
		$add_sj=$sj_base->add($data);
		if($add_sj){
			$xiaji= $this->gongyou();
			echo $xiaji;
		}else{
			$xiaji= $this->gongyou();
			//echo $xiaji;
			echo "no";
		}
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
	public function del_shangji(){
			$mapid=$_GET['id'];
			$shangjidel_base=M('shangji');
			$sql_del=$shangjidel_base->query("delete from `crm_shangji` where `sj_id` in ($mapid)");
			$xiaji= $this->gongyou();
			echo $xiaji;
			
	}
	public function pl_bianji(){
			$id=$_GET['id'];
			$id=substr($id,0,strlen($id)-1); //id
			//$id="5,6";
			$ziduan=$_GET['ziduan'];//zdy123445
		
			$content=$_GET['content'];//修改内容
		//	echo $id;
			$kehu_base=M('shangji');
			$sql=$kehu_base->query("select * from `crm_shangji` where `sj_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['sj_data'],true);
			
				foreach($json as $k1=>$v2)
				{
					if($ziduan == $k1 )
					{
						$json[$k1]=$content;
						$da=$json;//data替换完成
						$map['sj_id']=$v['sj_id'];//条件
						$data['sj_data']=json_encode($da,true);//修改内容
						$save=$kehu_base->where($map)->save($data);
						if($save){
							
						}
					}
				}
			
				
			}
			$xiaji= $this->gongyou();
							echo $xiaji;

	}
	public function pl_zhuanyi(){
		//$fuzeren=$_GET['id'];      //负责人ID
		
		$data['sj_fz']='9';
		
			//$rz_fuzeren=$_GET['ziduan'];        //名字 日志用
			//$sj_id=$_GET['sj_id']; //商机ID
			//$id=substr($sj_id,0,strlen($sj_id)-1); //id
		$id="5";
			//echo $id;
			//$idww=explode(",",$id);
			$shangji_base=M('shangji');

	///	foreach($idww as $k=>$v)
			//{	
				$map['sj_id']=$id;
				//var_dump($map);exit;
				$save_fzr=$shangji_base->where($map)->sava($data);
				//unset($map);
			//}
		if($save){
			echo "1";
		}else{
			echo "2";
		}
			//$xiaji= $this->gongyou();
			//echo $xiaji;

	}
}