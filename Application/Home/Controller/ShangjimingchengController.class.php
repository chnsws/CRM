<?php
namespace Home\Controller;
use Think\Controller;


class ShangjimingchengController extends Controller {


	public function ywzd(){                               //业务字段表--联系人
		$data['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件              
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
	//	echo "<pre>";
	//	var_dump($ywzd_sql_json);exit;
		foreach ($ywzd_sql_json as $k=>$v)
		{
			if($v['qy']=='1')
			{
				$sql_ywzd[$v['id']]=$v;
				//$sql[]=$sql_ywzd;
			}
		}

	

		return $sql_ywzd;
	}
	public function kehu_name(){
		$kh_base=M('kh');
		$data_kh['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->where($data_kh)->select();
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['kh_id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$sql_kh[$vkh['kh_id']]=$kh;
		}
		return $sql_kh;
	}
	
	public function ywcs()
		{
			$ywcs_base=M('ywcs');
			$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$ywcs['ywcs_yw']=5;
			$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
			$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);   

			foreach($ywcs_json as $kcs => $vcs)
			{
				foreach($vcs['qy'] as $kqy=>$vqy)
				{

					if($vqy=='1')
					{
						$cs_new[$kqy]=$vcs[$kqy];

					}
				}
				$new_ywcs[$vcs['id']]=$cs_new;            //获取到启用了yyyy
				unset($cs_new);
				
			}
			return $new_ywcs;
		}

			public function user(){                 //负责人和dddd
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
	 	$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门ddddd
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
	public function shangjimingcheng(){
	$array_jiansuo=array('sj_qiandan'=>"签单可能性",'sj_new_gj'=>"最新跟进记录",'sj_sj_date'=>"实际跟进时间",'sj_fz'=>"负责人",'sj_bm'=>"部门",'sj_cj'=>"创建人",'sj_cj_date'=>"创建时间","sj_gx_date"=>"更新时间");
		foreach($array_jiansuo as $k=>$v){
				$new_str1['id']=$k;
				$new_str1['name']=$v;
				$new_str1['qy']=1;
				$new_str1['type']=0;
				$new_arrayoo[$k]=$new_str1;
			}
		$sj_id=$_GET['id'];
		$uiid=$_GET['uiid'];
		if($uiid==""||$uiid==null){
			$uiid=1;
		}
		$this->assign('uiid',$uiid);
		$xiaji1= $this->get_xiashu_id();//  查询用户
		$new_xiaji1=$xiaji1; 
		$new_array1=explode(',',$new_xiaji1);	
		//echo $sj_id;exit;
		$sj_base=M('shangji');
		$map_sj['sj_id']=$sj_id;
		$sql_sj=$sj_base->where($map_sj)->find();
		$qxa=0;
			foreach($new_array1 as $k=>$v)
			{
				if($sql_sj['sj_fz']==$v)
				{
					$qxa++;
				}
			}
		
			if($qxa<1)
			{
				echo "<script> alert('您没有查看此商机权限~');history.go(-1); 
				 
				</script>";die;
			}
		foreach($sql_sj as $k=>$v)
		{
			if($k!='sj_data')
			{
				$sql_rh[$k]=$v;
			}else{
				
				$sj_json=json_decode($sql_sj['sj_data'],true);
				//echo "<pre>";
	///	var_dump($sj_json);exit;
				foreach ($sj_json as $k1=>$v1)
				{
					$sql_rh[$k1]=$v1;
				}
			}

		}    //商机信息查询
		$this->assign('kh_id27',$sql_rh['zdy1']);
		$biaoti=$this->ywzd(); //标题过来了
		$ywcs=$this->ywcs(); //参数过来了

		$map['lx_id']=$sj_json['zdy2'];//联系人条件
		$map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件          
		$lx_base=M("lx");
		$sql_lianxi=$lx_base->where($map)->find();
	//	echo "<pre>";
	//	var_dump($sql_lianxi);exit;
		$lx_json=json_decode($sql_lianxi['lx_data'],true);
		foreach($biaoti as $kbt=>$vbt)
		{
			
			if($kbt!='zdy2' && $kbt!='zdy6'){
				$show.="<tr class='ways'><td width='200xp'>".$vbt['name'].":</td>";
				if($sql_rh[$kbt]=="")
				{	
					$show.="<td>未填写</td>";
				}else{
					if($kbt=="zdy1")
					{
						$kh_name=$this->kehu_name();
						foreach( $kh_name as $k=>$v)
						{
							if($k==$sql_rh[$kbt])
							{
								$show.="<td>".$v['name']."</td> ";
							}
						}
						
					}elseif($kbt=="zdy2"){
					
						//2就是空
						}elseif($kbt=="zdy6"){
						//4就是空
					}elseif($kbt=="zdy5"){	
						
						foreach( $ywcs[$kbt] as $k=>$v)
						{
							if($k==$sql_rh[$kbt])
							{
								$show.="<td>".$ywcs[$kbt][$k]."</td> ";
							}
						}

					}elseif($kbt=="zdy7"){	
						
						foreach( $ywcs[$kbt] as $k=>$v)
						{
							if($k==$sql_rh[$kbt])
							{
								$show.="<td>".$ywcs[$kbt][$k]."</td> ";
							}
						}
					}elseif($kbt=="zdy9"){	

						foreach( $ywcs[$kbt] as $k=>$v)
						{
							if($k==$sql_rh[$kbt])
							{
								$show.="<td>".$ywcs[$kbt][$k]."</td> ";
							}
						}
							
					}elseif($kbt=='zdy11'){
							$aaa=strlen($sql_rh[$kbt]);
							if($aaa>40)
							{
								$bzhu=mb_substr($sql_rh[$kbt],0,40,'utf-8')."···";	
							}else{
								$bzhu=$sql_rh[$kbt];
							}
								$show.="<td> <span title=".$sql_rh[$kbt]." style='cursor:pointer;'>".$bzhu." </span></td>"	;
					}
					else{
						$show.="<td>".$sql_rh[$kbt]."</td> ";
					}
					
				}
						$show.="</tr>";
			}
					

		}

		$user_dpment=$this->user();
	
		foreach ($new_arrayoo as $k=>$v)
		{
	
			$show1.="<tr  class='ways'><td  width='200px'>".$v['name'].":</td>";
			if($sql_rh[$k]=="")
			{
				$show1.="<td>未填写</td>";
			}else{
				//echo $k;
				if($k=="sj_fz")
				{	
						$show1.="<td>".$user_dpment[$sql_rh[$k]]['user_name']."</td> ";	
				}elseif($k=="sj_bm"){
					
						
						$show1.="<td>".$sql_rh['ht_department']."</td> ";	
						
					
						
				}elseif($k=="sj_cj"){

						$show1.="<td>".$user_dpment[$sql_rh[$k]]['user_name']."</td> ";	
				}elseif($k=="sj_cj_date"){
									$show1.="<td>".date('Y-m-d H:i:s',$sql_rh[$k])."</td>";

				}
				elseif($k=="sj_gx_date"){
									$show1.="<td>".$sql_rh[$k]."</td>";
								}else{}
				
			}
			$show1.="</tr>";

		}//exit;
	//echo "<pre>";//
		//var_dump($sql_rh);exit;
	$show2.="<table >";
		
			foreach($biaoti as $kbt=>$vbt)
		{

			if($kbt!='zdy2' && $kbt!='zdy1' && $kbt!="zdy6"){
				$show2.="<tr style='line-height:30px;height:40px'><td style='width:160px'>".$vbt['name'].":</td>";
		
						if($kbt=="zdy1")
						{
							//1就是空
						}elseif($kbt=="zdy2"){
							//2就是空
						}elseif($kbt=="zdy6"){
								//6就是空
						}elseif($kbt=="zdy5"){	
							$show2.="<td><select name='".$kbt."' style='width:175px'>";
							foreach( $ywcs[$kbt] as $k=>$v)
							{
								if($k==$sql_rh[$kbt])
								{
									$show2.="<option value='".$k."' selected='selected'>".$ywcs[$kbt][$k]."</option> ";
								}elseif($k!='id' && $k!="qy" && $k!="knx")
								$show2.="<option  value='".$k."'>".$ywcs[$kbt][$k]."</option> ";
							}
							$show2.="</select></td>";
						}elseif($kbt=="zdy7"){	
							
							$show2.="<td><select name='".$kbt."' style='width:175px'>";
							foreach( $ywcs[$kbt] as $k=>$v)
							{
								if($k==$sql_rh[$kbt])
								{
									$show2.="<option  value='".$k."' selected='selected'>".$ywcs[$kbt][$k]."</option> ";
								}elseif($k!='id' && $k!="qy" && $k!="knx")
								$show2.="<option  value='".$k."'>".$ywcs[$kbt][$k]."</option> ";
							}
							$show2.="</select></td>";
						}elseif($kbt=="zdy9"){	

							$show2.="<td><select name='".$kbt."' style='width:175px'>";
							foreach( $ywcs[$kbt] as $k=>$v)
							{
								if($k==$sql_rh[$kbt])
								{
									$show2.="<option  value='".$k."' selected='selected'>".$ywcs[$kbt][$k]."</option> ";
								}elseif($k!='id' && $k!="qy" && $k!="knx")
								$show2.="<option  value='".$k."'>".$ywcs[$kbt][$k]."</option> ";
							}
							$show2.="</select></td>";
								
						}elseif($kbt=="zdy4"|| $kbt=="zdy8" ||$kbt=="zdy10"){
							$show2.="<td><input type='text' name='".$kbt."' value='".$sql_rh[$kbt]."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'." ></td> ";
						}elseif($kbt=='zdy11'){
							$show2.="<td><textarea name='".$kbt."'  maxlength='400' style='width:185px' rows='2' cols='38' placeholder='最大长度400'>".$sql_rh[$kbt]."</textarea></td>";
						}
						else{
							$show2.="<td><input type='text' name='".$kbt."' value='".$sql_rh[$kbt]."' maxlength='40'></td> ";
						}
				
			
			}
			
					$show2.="</tr>";
			
		}
			$show2.="<tr><td></td><td><input type='hidden' name='sj_id' value='".$sql_rh['sj_id']."' ></td> </tr>";
				$show2.="<tr><td></td><td><input type='hidden' name='zdy1' value='".$sql_rh['zdy1']."' ></td> </tr>";
			$show2.="<tr><td></td><td><input type='hidden' name='zdy2' value='".$sql_rh['zdy2']."' ></td> </tr>";	
		$show2.="</table>";
		$this->assign('show2',$show2);
		$user_dpment[$sql_rh['sj_fz']]['user_name'];
		$chanpin=$this->chanpin();
		$cp_sj['sj_id']=$sj_id;
		$cp_sj['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cp_sj['cp_sj_cj']=cookie('user_id'); //通用条件  
		$cp_sj_base=M('cp_sj');
		$sql_cp_sj=$cp_sj_base->where($cp_sj)->select();
		foreach($sql_cp_sj as $k=>$v)
		{
			foreach($v as $k1=>$v1)
			{
				$chanpin_rh[$k1]=$v1;
			}
			$chanpin_rh['zdy0']=$chanpin[$v['cp_id']]['zdy0'];
			$chanpin_rh['zdy1']=$chanpin[$v['cp_id']]['zdy1'];
			$chanpin_rh['zdy4']=$chanpin[$v['cp_id']]['zdy4'];
			$chanpin_rh['zdy5']=$chanpin[$v['cp_id']]['zdy5'];
			$cp_rh[]=$chanpin_rh;
		}if($cp_rh==''||$cp_rh==null){
			$cp_show.="<tr><td colspan='30' align='center'><span>亲~没有数据哟！请添加相关产品</td></tr>";
		}else{
			foreach($cp_rh as $k=>$v){
				$cp_show.="<tr class='".$v['cp_id1']."'><td >".$v['zdy0']."</td>
						  <td >".$v['zdy1']."</td>
						  <td >".$v['cp_yj']."</td>
						  <td >".$v['cp_jy']."</td>
						  <td >".$v['cp_num1']."</td>
						  <td >".$v['cp_zk']."</td>
						  <td >".$v['cp_zj']."</td>
						  <td >".$v['cp_beizhu']."</td>
						  	<td ><input type='button' name='".$v['cp_id1']."' onclick='cp_sj_del(this)' value='删除'></td>
						 </tr> ";
			}
		}
		$file_sj['name_id']=$sj_id;
		$file_sj['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$file_sj['mk']='5';
		$file_sj_base=M('file');
		$sql_file_sj=$file_sj_base->where($file_sj)->select();
		if($sql_file_sj==''||$sql_file_sj==null){
			$file_sj_show.="<tr><td colspan='30' align='center'><span>亲~没有数据哟！请添加相关附件</td></tr>";
		}else{
			foreach($sql_file_sj as $k=>$v)
			{
				$file_sj_show.="<tr class='".$v['id']."'><td>".$v['sc_data']."</td><td><span onclick='fj_xz(this)' class='".$v['lujing']."' style='color:green;cursor:pointer' title='点击下载' >".$v['fujian_name']."</span></td><td>".$v['big']."</td><td>".$v['beizhu']."</td><td><button onclick='fujian_del(this)' name='".$v['id']."' class='layui-btn layui-btn-primary layui-btn-small'>
	    			<i class='layui-icon'>&#xe642;</i>删除
	  				</button></td>";
				$file_sj_show.="</tr>";
			}
		}

								$gj_xgj.="<select name='genjinzhuantai' class='gjzt12' style='width:190px;height:40px'>";
									if($sql_rh['zdy5']=='' || $sql_rh['zdy5']==null)
									{
										$gj_xgj.="<option  selected='selected'>--请选择--</option>";
									}
			  						foreach($ywcs['zdy5'] as $k=>$v)
									{
										if($sql_rh['zdy5']==$k)
										{
											$gj_xgj.="<option value='".$k."' selected='selected'>".$v."</option>";
										}else{
											$gj_xgj.="<option value='".$k."'>".$v."</option>";
										}
										
										
									}
	  							$gj_xgj.="</select>"; //这里是写跟进的 跟进状态
	  			$xiegenjin_base=M('xiegenjin');
	  			$map_xiegenjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$map_xiegenjin['mode_id']=5;
				$map_xiegenjin['kh_id']=$sj_id;
				$sql_xiegenjin=$xiegenjin_base->where($map_xiegenjin)->order("add_time desc")->select();
				if($sql_xiegenjin=="" || $sql_xiegenjin==null)
				{
					$xgj_show.="<table  style='margin-left:40%;margin-top:20%'><tr><td><i class='layui-icon' style='font-size: 140px; color: #999;'>&#xe64d;</i></td></tr>
						 <tr><td ><span style='margin-left:25px;color:#999'>暂无跟进记录</span></tr> </table>";
				}
			//	echo "<pre>";
			//	var_dump($sql_xiegenjin);exit;
				foreach($sql_xiegenjin as $k=>$v)
				{
					$xgj_show.="<div class='gj_mod'>";
						$da[$k] =substr($v['add_time'],0,10);
							$daa[$k] =substr($v['add_time'],11,5);
						if($da[$k]==$da[$k-1]){

						}else{
						$xgj_show.="<div class='gj_head'><div class='gj_head_point'></div><div class='gj_head_date'>".$da[$k]."</div></div>";
						}
				//	$xgj_show.=	"<div class='gj_head'><div class='gj_head_point'></div><div class='gj_head_date'>".$v['add_time']."</div></div>";
					$xgj_show.=	"	<div class='gj_body'>
							<div class='gj_body_icon'><i class='fa fa-pencil'></i></div>
							<div class='gj_body_content'>
								<div class='gj_body_content_head'>
									<img src='' class='gj_headimg woca'>
									<span class='user_name'>
									".$user_dpment[$v['user_id']]['user_name']."</span>".$daa[$k]."<span class='gj_fangshi'>".$v['type'].":<span style='color:blue'>".$lx_json['zdy0']."</span>
									</span>
								<span style='float:right;cursor:pointer;' id='".$v['genjin_id']."' title='点击删除' onclick='del_gj(this)' ><i class='layui-icon'>&#xe640;</i>  </span>
								</div>
								<div class='gj_body_content_content'>".$v['content']."</div>
							
								<div class='gj_body_content_from'>来自商机：".$sj_json['zdy0']."</div> 
								<div class='gj_body_content_button'>
									
								</div>
							</div>
						</div>
					</div>";
				}//客户模块下跟进记录必须是当前客户  其他模块再继续查询

			$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 			
			$rz_map['rz_mode']=5;//客户名称ID
			$rz_map['rz_object']=$sj_id;//客户名称ID
			$rz_map['rz_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;//客户名称ID
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
			$rz_jl.="<tr><td colspan='30' align='center'><span>亲~没有数据哟！</td></tr>";
			}else{
				foreach($rz_sql as $k=>$v)
				{
			  		$rz_jl.="<tr>
		  					<td >".date('Y-m-d H:i:s',$v['rz_time'])."</td>
		  					<td >".$user_dpment[$v['rz_user']]['user_name']."</td>";
		  					$rz_jl.="<td >".$rz_mk_a[$v['rz_mode']]."</td>";
		  					$rz_jl.="
		  							 <td >".$v['rz_bz']."</td>";
		  				
		  					$rz_jl.="<td >".$rz_type[$v['rz_cz_type']]."</td>";
		  				
		  				
		  			$rz_jl.="</tr>";
		  		}
	  		}
	  		
				$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id'  id='cp_caozuo' class ='clk_fzr xlss' style='width:300px;height:30px;'>";
							$chanpin1.="<option value='s' >请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0']."(".$v['zdy1'].") </option>";
					}
					$chanpin1.="</select> </td></tr>";
	  		$this->assign('rz_jl',$rz_jl);				
	  	$this->assign('xgj_show',$xgj_show);					
	  	$this->assign('gj_xgj',$gj_xgj);
		$this->assign('file_sj_show',$file_sj_show);
	//echo "<pre>";
		//var_dump($sql_file_sj);exit;
		$this->assign('cp_show',$cp_show);
		$this->assign('fuzeren',$user_dpment[$sql_rh['sj_fz']]['user_name']);
		$this->assign('show',$show);
		$this->assign('show1',$show1);
		$this->assign('sj_id',$sj_id);
		$this->assign('chanpin1',$chanpin1); 
		$this->assign('sql_rh',$sql_rh);
		$this->assign('lx_json',$lx_json);
		$this->assign('sql_lianxi',$sql_lianxi);
	$this->display();
	}
	public function add_cpa(){
	
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
		$sql['cp_mk']=5;
		$sql['sj_id']=$_GET['sj_id'];
		$cp_sj_base=M('cp_sj');

		$sql_add=$cp_sj_base->add($sql);
		if($sql_add){
			echo "ok";
		
			 						
		} else{
			echo "2";
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
	public function save(){
		$a=$_GET['id'];
		//$a="sj_id:60,zdy1:247,zdy2:1,zdy0:中软远景,zdy3:898989,zdy4:2017-5-4 10,zdy5:canshu2,zdy7:canshu2,zdy8:2017-5-4 10,zdy9:canshu3,zdy10:2017-5-4 10,zdy11:545,zdy12:54,zdy13:5,";
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":",$v);
			if($ex['0']=="sj_id")
			{
				$map['sj_id']=$ex['1'];
			}
			else
			{
				$ex1[$ex['0']]=$ex['1'];
			}
			

		}
		$data['sj_data']=json_encode($ex1,true);
		$data['sj_gx_date'] = date('Y-m-d H:i:s');
		//echo "<pre>";
		//var_dump($data);exit;
		$sj_base=M('shangji');
		$sql_save=$sj_base->where($map)->save($data);
		if($sql_save){
				echo "ok";

		}else{
			echo "no";
		}
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
	public function cp_sj_del(){
		
			$id['cp_id1']=$_GET['id'];
				$cp_sj_base=M('cp_sj');
				$sql_del=$cp_sj_base->where($id)->delete();
				if($sql_del){
					echo "1";
				}else{
					echo "2";
				}
	}
			public function sj_upload(){//http://www.jb51.net/article/74353.htm   筛选第二天要看的


				$sj_id=$_GET['id'];
				//echo $sj_id;exit;
			    $upload = new \Think\Upload();// 实例化上传类
    			$upload->maxSize   =    52428800 ;// 设置附件上传大小
   				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','pptx','xls','pdf');// 设置附件上传类型
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
 
    			 $data['name_id']=$sj_id;
    			 $data['sc_data']= date("Y-m-d h:i:s");
    			 $data['fujian_name']=$save_oldname;
    			 $data['lujing']=$save_name;
    			 $data['big']=$sql;
       			 $data['beizhu']=$_POST['wenbenyu'];
       			 $data['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
       			 $data['mk']="5";
       			 $sql_file=M('file');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	//$this->success("上传成功");
       			 	echo '<script>
       			 				alert("上传成功");
       			 				window.location="'.$_GET['root_dir'].'/index.php/Home/Shangjimingcheng/shangjimingcheng/id/'.$sj_id.'/uiid/4";
       			 				</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	


}
			public function fujian_del(){
				$data['id']=$_GET['id'];
				 $sql_file=M('file');
				 $data['mk']="5";
				 $data['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
				 $sql_del=$sql_file->where($data)->delete();
				 
			}
	public function xgj(){
		$id=$_GET['id'];

	//	$id="kh_id!276,type!拜访,content!123456,xgj_czr!411,add_time!2017-08-22 10:53:01,date!2017-08-23 10:53:06";
		$ex_id_arr=explode(',',$id);
		foreach($ex_id_arr as $k=>$v)
		{
			$ex2=explode("!", $v);
			$array[$ex2['0']]=$ex2['1'];

		}
	
		$array['mode_id']=5;
		$array['user_id']=cookie('user_id');
		$array['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
		$array['gl_khid']=$_GET['kh_id'];
		$xgj_base=M('xiegenjin');
		$add_xgj=$xgj_base->add($array);

		$xgj=$_GET['xgj'];
		//$xgj="canshu5";
		$map_kh['sj_id']=$array['kh_id'];
		$map_kh['sj_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
		$m_kh=M('shangji');
		$sql_sj=$m_kh->where($map_kh)->find();
		
		$a_arr=json_decode($sql_sj['sj_data'],true);
		
		$old=$a_arr['zdy5'];
		
		if($a_arr['zdy5']==$xgj){
			//相等代表没改变 啥也不用干
			
		}else{ //改变了赋值
				$a_arr['zdy5']=$xgj;
				$a_arr1['sj_gx_date']=$array['add_time'];
				$a_arr1['sj_data']=json_encode($a_arr,true);
				$sql_sj=$m_kh->where($map_kh)->save($a_arr1);//修改成功

				$ywzd=$this->ywzd_sj();
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
					
					$this->rizhi($array['kh_id'],$rz_bz,"2");	

					
				}

		
		
	}
	public function ywzd_sj(){                               //业务字段表--联系人
		$ywzd_base=M('yewuziduan');
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$map['zd_yewu']=5;
		$sql_ywzd=$ywzd_base->where($map)->find();
		$sql_json=json_decode($sql_ywzd['zd_data'],true);
		
		return $sql_json;
	}
	public function rizhi($one="",$two="",$three="")
	{
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		$addressArr=getCity($nowip);//登录地点
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$rz=M('rz');
		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		$rz_map['rz_mode']=5;
		$rz_map['rz_object']=$one;//客户名称ID
		$rz_map['rz_bz']=$two;
		$rz_map['rz_user']=cookie('user_id');
		$rz_map['rz_cz_type']=$three;//2代表编辑
		$rz_map['rz_time']=time();
		$rz_map['rz_ip']=$loginIp;//ip
		$rz_map['rz_place']=$loginDidianStr;//登录地点
		$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
		$rz_map['rz_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$rz_sql=$rz->add($rz_map);//查'			//删除增加日志
		if($rz_sql){
			echo "1";
		}else{
			echo "2";
		}
	}
	public function rz_jl(){

		

	}
	public function del_gja(){
		$map['genjin_id']=$_GET['id'];
		$map['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//
		$map['mode_id']=5;
		$base=M('xiegenjin');
		$sql=$base->where($map)->delete();
	}
}