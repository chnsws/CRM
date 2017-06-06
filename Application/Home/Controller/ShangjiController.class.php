<?php
namespace Home\Controller;
use Think\Controller;


class ShangjiController extends Controller {

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
	public function shangji(){
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
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);   
	//	echo "<pre>";
		//var_dump($ywcs_json);exit;                       //获取商机配置表参数
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
			unset($cs_new);
			
		}
	//	echo "<pre>";
//ar_dump($ywcs_json );exit;
//echo "<pre>";
//var_dump($new_ywcs);exit;
		
		$kh_name=$this->kehu();
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
								$ronghe[$k][$kkk]=$kh_name[$vvv]['name'];  //匹配客户名字
								$ronghe[$k]['kh_id']  = $vvv;     
							}else{
								$ronghe[$k][$kkk]=$vvv;
							}
						}
						

						

					}
				}
			}
		}//echo "<pre>";
	//var_dump($ronghe);exit;
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
			$kh_mc=$v['zdy1'];
			$kh_id=$v['kh_id'];
			//$fuzeren=$
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
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id'>".$v[$k1]." </a></td>"	;
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
					$table.="<tr class='addtr '>";
						$table.="<td><span style='color:red'>*</span>".$vzd['name'].":</td>";
						if($vzd['type']=="0") 
							$table.="<td><input type='text' class='required' name='".$vzd['id']."' value='' ></td>";   //  0文本框
						elseif($vzd['type']=="2")
							$table.="<td><input type='text' class='required' name='".$vzd['id']."'   class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table.="<td>";
								$table.="<select  class='required' name='".$vzd['id']."' onchange='get_lx(this)' style='width:300px;height:26px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
									$table.="</select>";	
								$table.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table.="<td class='lxr'>";
								$table.="<select name='".$vzd['id']."' class='required' style='width:300px;height:26px;'>";
										$table.="<option value=''>请先选择公司</option>";
									$table.="</select>";	
								$table.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."'  class='required' style='width:300px;height:26px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' class='required' style='width:300px;height:26px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."'  class='required' style='width:300px;height:26px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}else{
						
							$table.="<td>";

								$table.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品' >";
								
								$table.="</td>";
								
				
							}
						}	
																//  3下拉选择
					$table.="</tr>";																						
				}elseif($vzd['cy']=="1"){
					$table1.="<tr class='addtr'>";
						$table1.="<div class='".$vzd['id']."'><td >".$vzd['name'].":</td></div>";
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
								$table1.="<select name='".$vzd['id']."' onchange='get_lx(this)' style='width:300px;height:26px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table1.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
										$table1.="</select>";
								$table1.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table1.="<td class='lxr'>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value=''>请先选择公司</option>";
								$table1.="</select>";	
								$table1.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
									$table1.="</select>";	
								$table1.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							
							}else{
					
								
							$table1.="<td>";

								$table1.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品'  >";
								

								
								$table1.="</td>";

							}
						}	
																//  3下拉选择
					$table1.="</tr>";

					
				}else{
					$table2.="<tr class='addtr ncy'>";
						$table2.="<div class='".$vzd['id']."'><td >".$vzd['name'].":</td></div>";
						if($vzd['type']=="0") 
							$table2.="<td><input type='text' name='".$vzd['id']."'  ></td>";   //  0文本框
						elseif($vzd['type']=="2")
							$table2.="<td><input type='text' name='".$vzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' onchange='get_lx(this)' style='width:300px;height:26px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table2.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
										$table2.="</select>";
								$table1.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table2.="<td class='lxr'>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table2.="<option value=''>请先选择公司</option>";
								$table2.="</select>";	
								$table2.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
									$table2.="</select>";	
								$table2.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:26px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
								$table2.="</td>";
								
							
							}else{
					
								
							$table2.="<td>";

								$table2.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品'  >";
								

								
								$table2.="</td>";

							}
						}	
																//  3下拉选择
					$table2.="</tr>";

				}
				if($vzd['id']=="zdy6"){
				$table1.="<tr><td colspan='2'>";
					$table1.="<table class='layui-table' lay-skin='line' style='display: none;border:1px'>";
								 	 $table1.="<thead>
								  				<th >产品名称</th>
						  						<th >产品原价</th>
						  						<th >建议价格</td>
						  						<th >数量</th>
						  						<th >折扣</th>
						  						<th >总价</th>
						  						<th >操作</th>
											</thead>";
									  $table1.="<tbody class='tihuan'>";
								
									  $table1.="</tbody>
										 </table>";
					$table1.="</td></tr>";
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
			$chanpin=$this->chanpin();
		

			$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id' onchange='cp_aj(this)' class ='clk_fzr' style='width:300px;height:26px;'>";
							$chanpin1.="<option value='s'>请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0']." </option>";
					}
					$chanpin1.="</select> </td></tr>";
//var_dump($chanpin1);exit;
				$this->assign('chanpin1',$chanpin1); 
			$this->assign('new_html',$new_html); 	
		$this->assign('bj_tab',$bj_tab); 			
		$add=$table;  //必填
		$add1=$table1;//非必填
		$this->assign('show',$show);
		$this->assign('add1',$add1);		
		$this->assign('add',$add);	
		$this->assign('add2',$table2);
		$this->assign('fuzeren',$fzr_only);	
		$this->assign('biaoti',$biaoti);	
		$this->assign('biaoti1',$bir);	
		$this->display();
	}
	public function chanpin(){
		$map['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cp_base=M('chanpin');
		$sql=$cp_base->where($map)->select();
		foreach($sql as $k=>$v)
		{
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
		//echo "<pre>";
		//var_dump($sql_cp);exit;
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
								$ronghe[$k]['kh_id']  = $vvv;     
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
			$kh_mc=$v['zdy1'];
			$kh_id=$v['kh_id'];
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
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id'>".$v[$k1]." </a></td>"	;
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
	//	echo $ex['0'];
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
		$data["sj_cj"]=cookie('user_id');//本人ID  
		$data["sj_cj_date"]=time();
		$sj_base=M('shangji');
		$add_sj=$sj_base->add($data);
		if($add_sj){
					$xiaji= $this->gongyou();
					echo $xiaji;
					$sql_sel=$sj_base->where($data)->field('sj_id')->find();
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$dat['sj_id']= $sql_sel['sj_id'];
					$sql_add=$cp_sj_base->where($sql)->save($dat);
					//echo "<pre>";
					//var_dump($sql);exit;
			
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
		$fuzeren=$_GET['id']; 
		$rz_fuzeren=$_GET['ziduan']; 
		$sj_id=$_GET['sj_id']; //商机ID          //负责人ID
		$id=substr($sj_id,0,strlen($sj_id)-1); //id
		$map['sj_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$data['sj_fz']=$fuzeren;
		$idex=explode(",",$id);
		$sj_base=M('shangji');
		foreach($idex as $k=>$v){
			$map['sj_id']=$v;
			$sql_save=$sj_base->where($map)->save($data);

		}
		$xiaji= $this->gongyou();
		echo $xiaji;
	}
	public function shaixuan(){

		$id=$_GET['id'];
		$new_id=substr($id,0,strlen($id)-1); 
		//$new_id="zdy7,1|kehujibie,3";
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
			if($vqb['1']!='1')
			{
				$get1[$vqb['0']]=$vqb;
			}
		}

		$get=$get1;
		foreach($get as $kkh =>$vkh)
		{
			if($kkh=="kehujibie")
			{
				$kehu_jibie=$vkh['1'];                  //判断商机 是全部商机  我的商机还是 我下属的商机
			}
		}
	

		$sj_base=M('shangji');
		$xiaji= $this->get_xiashu_id();// 全部商机
		$myid=cookie('user_id');//本人ID  
		$myid2=$myid."0";
		$myidcount=strlen($myid2); //查询下级时候用
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$new_number=substr($xiaji,0,strlen($xiaji)-$myidcount);

		if($kehu_jibie=="3"){ 
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz IN ($new_number)");                  //全部客户
			
		}elseif($kehu_jibie=="2"){               //我的客户
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz ='$myid' ");

		}else{                                   //我下属的客户
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz IN ($xiaji)");
		}	
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
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);   
	            //获取商机配置表参数
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
		$cs_th=$new_ywcs;

			$number="1";
	 		foreach($ywcs_json as $k=>$v)
			{
				foreach($v as $k1=>$v2)
				{	
					if($k1=="id")
					{
						$new_ywcs[$number]=$v2;
					}else{
						$new_ywcs[$number]=$k1;
					}
					
					$number++;
				}
				$number="1";
				$new_ywcs2[]=$new_ywcs;  //实现  dom 下标 对应 canshu***
				unset($new_ywcs);
			}
			foreach($get as $knum=>$vnum)  //匹配  筛选
		{	
				foreach($new_ywcs2 as $knew_cs=>$vnew_cs)
				{	

					if($knum==$vnew_cs['1'])
					{
					
						$vnum['1']=$vnew_cs[$vnum['1']];
						//var_dump($vnum);exit;
						$end[]=$vnum;          
					}
					

				}

		}

		foreach($end as $kr=>$vr)
		{
			$save[$vr['0']]=$vr['1']; //得到结果 下步找客户数据匹配
		}
			//echo "<pre>";
			//var_dump($save);exit;
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
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

							if($kkk=="zdy1")
							{
								$ronghe[$k][$kkk]=$kh_name[$vvv]['name'];         //匹配客户名字
								$ronghe[$k]['kh_id']  = $vvv;     
							}else{
								$ronghe[$k][$kkk]=$vvv;
							}
					}
				}
			}
		}
		foreach ($ronghe as $k=>$v)
		{
			foreach($v as $k1=>$v1)
			{
				
					if($v["zdy5"]==$save["zdy5"] || $save["zdy5"]=="" )
					{	

						if($v["zdy7"]==$save["zdy7"] || $save["zdy7"]=="")
						{	
							
							if($v["zdy9"]==$save["zdy9"] ||$save["zdy9"]=="")
							{	
								$new_ronghe[]=$v;
							}continue 2;
						}continue 2;
					}continue 2;
				
			}
		}

		foreach($new_ronghe as $kcs=>$vcs)
		{
			foreach($vcs as $k=>$v)
			{
				if($cs_th[$k]!="")
				{
					$new_ronghe[$kcs][$k]=$cs_th[$k][$vcs[$k]];
				}
			}
		}
		   		foreach($userarr as $k=>$v)
					{
						foreach($v as $kk=>$vv)
						{
							
								$rowjson=json_decode($vv,true);
								foreach($rowjson as $kkk=>$vvv)
								{	

									if($new_ywcs[$kkk]!="")
									{
										$ronghe[$k][$kkk]=$new_ywcs[$kkk][$rowjson[$kkk]];   //下拉框 关联表的匹配
				
									}
								}
						}
					}
                                                                                  //
		 foreach ($new_ronghe as $k =>$v)    
		{
			$id=$v['sj_id'];
			$kh_mc=$v['zdy1'];
			$kh_id=$v['kh_id'];
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
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id'>".$v[$k1]." </a></td>"	;
					}else{
						$show.="<td> ".$v[$k1]." </td>"	;
					}
				}else{
					$show.="<td> ---- </td>"	;
				}
			}
			$show.="</tr>";                                          //显示商机信息模板
		}
		echo $show;		
	}
	public function lxr_get(){
		$a=$_GET['id'];
		
			$lxr_base=M('lx');
	 		$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	 		$tiaojian='"zdy1":"'.$a.'"';
	 		
			$new_lx=$lxr_base->query("select * from crm_lx where lx_yh = '$yh' and lx_data like '%$tiaojian%'");



		
		foreach($new_lx as $k=>$v)
		{
			if($v['zdy1']==$a)
			{	$c=$c+1;
				$lx_arr['id']=$v['lx_id'];
				$lx_arr['name']=$v['zdy0'];
				$lx_end[$v['zdy0']]=$lx_arr;
			}
		}
		$table.="<select name='zdy2' style='width:300px;height:26px;'>";
		foreach($lx_end as $k=>$v)
		{
			$table.="<option value='".$v['id']."'>".$v['name']."</option>";
		}
		$table.="</select>";	

		$table2.="<select name='zdy2' style='width:300px;height:26px;'>";
		
			$table2.="<option value=''>请添加此客户联系人</option>";
		
		$table2.="</select>";	
		if($c>1)
		{
			echo $table;
		}else{
			echo $table2;
		}
		
		
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
		$cp_sj_base=M('cp_sj');
		$sql_add=$cp_sj_base->add($sql);
		if($sql_add){
			$map['cp_sj_cj']=$sql['cp_sj_cj'];
			$map['cp_yh']=$sql['cp_yh'];
			$map['sj_id']=$sql['sj_id'];
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
				$cp_sj_base=M('cp_sj');
				$sql_del=$cp_sj_base->where($id)->delete();
				if($sql_del){
					echo "1";
				}else{
					echo "2";
				}
			}
			public function del_all(){
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$sql_add=$cp_sj_base->where($sql)->delete();
			}	

}