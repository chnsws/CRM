<?php
namespace Home\Controller;
use Think\Controller;


class LianxirenController extends Controller {

	public function ywzd(){                               //业务字段表--联系人
		$ywzd_base=M('yewuziduan');
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$map['zd_yewu']=4;
		$sql_ywzd=$ywzd_base->where($map)->find();
		$sql_json=json_decode($sql_ywzd['zd_data'],true);
		return $sql_json;
	}
	public function kehu(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh  where kh_yh='$map' and kh_gonghai=0 ");
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh['department']=$kh_json['department'];
					$kh_name[$vkh['kh_id']]=$kh;
		}
		return $kh_name;
	}
	public function kehu1(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh  where kh_yh='$map' and kh_gonghai=0 and kh_fz in ($xiaji)");
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh['department']=$kh_json['department'];
					$kh_name[$vkh['kh_id']]=$kh;
		}
		return $kh_name;
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
	
	public function lianxiren(){
		$userqb=$this->userqb();
		//echo "<pre>";
	//	var_dump($userqb);exit;
		$ywzd= $this->ywzd();    //业务字段信息 
		$kh_name= $this->kehu();    //业务字段信息 
		$kh_name1= $this->kehu1();    //业务字段信息 
	//	echo "<pre>";var_dump($kh_name);exit;
		$dpt_arr= $this->department();    //部门字段信息 
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;
		//$new_xiaji="1,3,4,6,7,8";       
		$new_array=explode(',',$new_xiaji);
		
		$fenye=$_GET['fenye'];
		if($fenye==null || $fenye=='')
		{
			$list_num=20;
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

		$sxaaa=$_GET['sxaaa'];
		
		$namess=$_GET['sousuo'];
		$lx_base=M('lx');
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		if($namess!="")
		{
				$json_name=json_encode($namess,true);
				$newstr = substr($json_name,0,strlen($json_name)-1); 
				$first =substr($newstr,1);  
				$tihuan= str_replace("\\", "\\\\\\\\", $first);
				$kh_base=M('lx');
				$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$lxr_sql=$kh_base->query("select * from crm_lx where lx_yh = '$yh' and lx_cj IN ($xiaji) and lx_gonghai=0 and lx_data like '%".$tihuan."%'");
				$this->assign('namess',$namess);
		}elseif($sxaaa!=""){
			$new_id=substr($sxaaa,0,strlen($sxaaa)-1); 
		

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
				$xiashu=$this->get_xiashu_id();
				
				$ex=explode(',',$xiashu);
				$my=cookie('user_id');
				foreach ($ex as $k=>$v){
					if($v!=$my){
						$xs[]=$v;
					}
				}
				$xs1=implode(',', $xs);
			//	echo "<pre>";
			//	var_dump($xs);exit;  
				if($get['kehujibie']['1']=="0"){
					echo "quanbu";die;
					
				}elseif($get['kehujibie']['1']=="1"){
					$lxr_sql=$lx_base->query("select * from `crm_lx` where `lx_yh` = $fid  and lx_gonghai=0 and  `lx_cj` = $my");        //我的

				}elseif($get['kehujibie']['1']=="2"){ 
					
					$lxr_sql=$lx_base->query("select * from `crm_lx` where `lx_yh` = $fid  and lx_gonghai=0 and  `lx_cj` in ($xs1)"); //全部我的                                        //下属的
				}
				
		}else{
			$lxr_base=M('lx');
			$map['lx_gonghai']=0;
			$map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司
			$map['lx_cj']=array('in',$new_array);//cid在这个数组中，
			$lx_count=$lxr_base->where($map)->count(); 
			$lxr_sql=$lxr_base->where($map)->limit($new,$list_num)->order("lx_cj_date desc")->select();  //查询出我的我的下级联系人
			$ys= ceil((int)$lx_count/$list_num);//多少页
		}
		foreach($lxr_sql as $k=>$v)
		{
			foreach($v as $k1 =>$v1)
			{
				if($k1!="lx_data")
				{
					$sql[$k1]=$lxr_sql[$k][$k1];
				}else{

					$sql_json=json_decode($v1,true);
					foreach($sql_json as $kjson=>$vjson)
					{
						$sql[$kjson]=$vjson;
					}
				}
			
			}$lianxiren[]=$sql;
			unset($sql );
			
		}
	 
																	//联系人标题
		foreach($ywzd as $k=>$v)
		{
			if($v['qy']==1)
			{
				$ywzd2[$v['id']]=$v;
				//$ywzd2[]=$ywzd1;
			}
		}
		$array_jiansuo=array('lx_cj'=>"创建人",'lx_cj_date'=>"创建时间",'lx_gx_date'=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array12[$new_str1['id']]=$new_str1;
					}

		$lx_biaoti1=array_merge_recursive($ywzd2,$new_array12);//联系人标题名字
		//echo "<pre>";
		//var_dump($lx_biaoti1);exit;
		//echo "<pre>";var_dump($lx_biaoti1);exit;					
				//echo "<pre>";
			//	var_dump($lianxiren);
			//	echo "<pre>";
				//var_dump($lx_biaoti1);exit;														//联系人显示内容'
				//'
		if($lianxiren == "" || $lianxiren==null)
		{
			$show_bt.="<tr width='100%'><td colspan='20' width='100%'><span style='margin-left:80px' onclick='addshangji()'> 亲~暂无数据，请<span style='color:#1AA094;cursor:pointer'>新增</span>联系人</td></tr>";
			if($sxaaa!="")
					{
						echo $show_bt;exit;
					}else{
						$this->assign('bfb',"bfb");
					}
			

		}else{	
		foreach($lianxiren as $k=>$v)
		{
			$id=$v['lx_id'];
			//echo "<pre>";
			//var_dump($lianxiren);exit;
			$show_bt.="<tr><td ><input type='checkbox' class='chbox_duoxuan' id='".$v['lx_id']."'></td>";
				foreach($lx_biaoti1 as $k1=>$v1)
				{
					if($v[$k1]!="")
					{

						if($k1=="zdy0")    //商机标题  跳转到商机页面
						{ 
							$show_bt.="<td ><a href='".$_GET['root_dir']."/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/$id' title='".$v[$k1]."'>".$v[$k1]." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>"	;
						}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面

							$kh_id=$v[$k1];
							$kh_mc=$kh_name[$v[$k1]]['name'];
							$show_bt.="<td>";
								if($kh_name[$v[$k1]]['name']==""){
									$show_bt.="<span style='color:#999'>此客户已被删除</span>";
								}else{
									$show_bt.=" <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id' title='".$kh_name[$v[$k1]]['name']."'>".$kh_name[$v[$k1]]['name']." </a>";
								}
								$show_bt.="</td>"	;
						}elseif($k1=="lx_cj")
						{
								$show_bt.="<td> ".$userqb[$v[$k1]]['user_name']." </td>"	;
						}elseif($k1=="zdy5")
						{
							$afirst=substr($v[$k1],0,1);

							if($afirst=="-")
							{
								$show_bt.="<td> ".substr($v[$k1],1)." </td>"	;
							
							}else{
								$show_bt.="<td> ".$v[$k1]." </td>"	;
							}
								
						}elseif($k1=="zdy16")
						{
							$aaa=strlen($v[$k1]);
							if($aaa>40)
							{
								$bzhu=mb_substr($v[$k1],0,40,'utf-8')."···";	
							}else{
								$bzhu=$v[$k1];
							}
								$show_bt.="<td> <span title=".$v[$k1]." style='cursor:pointer'>".$bzhu." </span></td>"	;
								
						}elseif($k1=="lx_cj_date")
						{
							$show_bt.="<td> ".date("Y-m-d H:i:s",$v[$k1])."</td>"	;

						}else{
							$show_bt.="<td> ".$v[$k1]." </td>"	;
						}

					}else{

						$show_bt.="<td> ---- </td>"	;
						
					}
				}	
			$show_bt.="</tr>";
			}
		}
		if($sxaaa!=''){
			echo $show_bt;exit;
		}
		//echo "<pre>";
		//var_dump($ywzd);exit;

		foreach($ywzd as $kywzd=>$vywzd)
		{
			if($vywzd['qy']==1)
			{
				if($vywzd['bt']==1)
				{
					if($vywzd['type']==3)
					{
						if($vywzd['id']=='zdy1')
						{
							$add_yw.="<tr class='addtr'>";
							$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td>";
									$add_yw.="<td class='ssaa'>
							 		<select  name='".$vywzd['id']."' class='required kh_ls xlss'>
							 			<option value=''>--请选择--</option>
							 			<option value='kh_add'>--点击添加--</option>";
							 		foreach ($kh_name1 as $kkh => $vkh)
							 		{
							 			 $add_yw.="<option value='".$vkh['id']."'>".$vkh['name']."</option>";
							 		} 
							 $add_yw.=	"</select>";
							$add_yw.="</tr>";
						}
					
					}elseif($vywzd['type']==2){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text'  class=' required text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."  name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['type']==1){	
						$add_yw.="<tr class='addtr' data-toggle='distpicker' style='overflow:hidden'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td><td class='form-group' style='width:80%;'>";

						$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			          	$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			         	$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
		 				$add_yw.="</td></tr>";
					}elseif($vywzd['id']=='zdy15'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'." name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['id']=='zdy10'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' class='qingyx'  onchange='yxyz(this)' name='".$vywzd['id']."'  maxlength='40'></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['id']=='zdy6'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='number' class='qingyx1'  onchange='sjyz(this)' name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					
					}
					elseif($vywzd['id']=='zdy5'){
							$add_yw.="<tr class='addtr'><td><span style='color:red'>*</span>".$vywzd['name'].":</td>";
							$add_yw.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$vywzd['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodiana' name='".$vywzd['id']."' maxlength='25'></td></tr>";	
					}elseif($vywzd['id']=='zdy2'){
							$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input class='danxuan' checked='checked'  name='".$vywzd['id']."' type='radio' value='男' />男<input name='".$vywzd['id']."' class='danxuan'  type='radio' value='女' />女</td>";
						$add_yw.="</tr>";
					}elseif($vywzd['id']=='zdy16'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><textarea name='".$vywzd['id']."' class='required' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
						$add_yw.="</tr>";
					}
					else{
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' class='required' name='".$vywzd['id']."' maxlength='50'></td>";
						$add_yw.="</tr>";
						
					}
				}elseif($vywzd['cy']==1)
				{
					if($vywzd['type']==3)
					{
						
					}elseif($vywzd['type']==2){
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['type']==1){	
						$add_yw1.="<tr class='addtr' data-toggle='distpicker' style='overflow:hidden'>";
						$add_yw1.="<td>".$vywzd['name'].":</td><td class='form-group' style='width:80%;'>";

						$add_yw1.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			          	$add_yw1.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			         	$add_yw1.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
		 				$add_yw1.="</td></tr>";
					}elseif($vywzd['id']=='zdy15'){
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='text' class=' ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'." name='".$vywzd['id']."'></td>";
						$add_yw1.="</tr>";
					}elseif($vywzd['id']=='zdy6'){
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='number' class='qingyx1'  onchange='sjyz(this)' name='".$vywzd['id']."'></td>";
						$add_yw1.="</tr>";
					}elseif($vywzd['id']=='zdy5'){
							$add_yw.="<tr class='addtr'><td>".$vywzd['name'].":</td>";
							$add_yw.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$vywzd['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodiana' name='".$vywzd['id']."' maxlength='25'></td></tr>";	
					}elseif($vywzd['id']=='zdy10'){
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='text' class='qingyx'  onchange='yxyz(this)' name='".$vywzd['id']."' maxlength='40'></td>";
						$add_yw1.="</tr>";
					}
					elseif($vywzd['id']=='zdy16'){
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><textarea name='".$vywzd['id']."' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
						$add_yw1.="</tr>";
					}else{
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."' maxlength='50'></td>";
						$add_yw1.="</tr>";
					}
				}else
				{
					if($vywzd['type']==3)
					{
						if($vywzd['id']=='zdy1')
						{
							$add_yw2.="<tr class='addtr ncy'>";
							$add_yw2.="<td>".$vywzd['name'].":</td>";
									$add_yw2.="<td>
							 		<select  name='' style='width:300px;height:30px;'>
							 			<option>--请选择--</option>";
							 		foreach ($kh_name1 as $kkh => $vkh)
							 		{
							 			 $add_yw2.="<option value='".$vkh['id']."'>".$vkh['name']."</option>";
							 		} 
							 $add_yw2.=	"</select> </td>";
							$add_yw2.="</tr>";
						}
					}elseif($vywzd['type']==2){
						$add_yw2.="<tr class='addtr ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['type']==1){	
						$add_yw2.="<tr class='addtr ncy' data-toggle='distpicker' style='overflow:hidden'>";
						$add_yw2.="<td>".$vywzd['name'].":</td><td class='form-group' style='width:80%;'>";

						$add_yw2.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			          	$add_yw2.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			         	$add_yw2.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
		 				$add_yw2.="</td></tr>";
					
		 			}elseif($vywzd['id']=='zdy6'){
						$add_yw2.="<tr class='addtr  ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='number' class='qingyx1'  onchange='sjyz(this)' name='".$vywzd['id']."'></td>";
						$add_yw2.="</tr>";
		 			}elseif($vywzd['id']=='zdy5'){
							$add_yw.="<tr class='addtr ncy'><td>".$vywzd['name'].":</td>";
							$add_yw.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$vywzd['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodiana' name='".$vywzd['id']."' maxlength='25'></td></tr>";	
					}elseif($vywzd['id']=='zdy15'){
		 				$add_yw2.="<tr class='addtr ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='text' class='ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'." name='".$vywzd['id']."'></td>";
						$add_yw2.="</tr>";
					}elseif($vywzd['id']=='zdy10'){
						$add_yw2.="<tr class='addtr  ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='text'  class='qingyx'  onchange='yxyz(this)'  name='".$vywzd['id']."' maxlength='40'></td>";
						$add_yw2.="</tr>";
					}elseif($vywzd['id']=='zdy16'){
						$add_yw2.="<tr class='addtr  ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><textarea name='".$vywzd['id']."' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
						$add_yw2.="</tr>";
					}else{
						$add_yw2.="<tr class='addtr ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."' maxlength='50'></td>";
						$add_yw2.="</tr>";
					}
				}
			}
		}
			$this->assign('dijiye',$dijiye);
		$this->assign('ys',$ys);
		$this->assign('list_num',$list_num);
		$this->assign('lx_biaoti',$lx_biaoti1);
		$this->assign('add_yw',$add_yw);
		$this->assign('add_yw1',$add_yw1);
		$this->assign('add_yw2',$add_yw2);
			$this->assign('show_bt',$show_bt);
		$this->display();
  
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
	public function add(){
		$a=$_GET['id'];
		//$a="zdy0:王玉帅,zdy1:公司二,zdy2:男,zdy3:技术部,zdy4:程序员,zdy5:15101574324,zdy6:1510157324,zdy7:guanzhuwoba666,zdy8:792732447,zdy9:没有,zdy10:792732447@qq.com,zdy11:www.nmm.com,zdy12[]:北京市-北京市市辖区-东城区,zdy13:劲松富顿中心C座1201,zdy14:548976,zdy15:2017-4-27 17:11:46,zdy16:2222,";
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
			if($ex['0']=="zdy12[]")
			{
				$substr=substr($ex['0'],0,strlen($ex['0'])-2); //id
					$ex1[$substr]=$ex['1'];
			}else{
				$ex1[$ex['0']]=$ex['1'];
			}
			
		}
		$data["lx_data"]=json_encode($ex1,true);
		$data["lx_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["lx_cj"]=	cookie('user_id');//本人ID  ;
		$data["lx_cj_date"]=time();//本人ID  ;
		$lx_base=M('lx');
		$add_lx=$lx_base->add($data);
		if($add_lx){
			
		}else{
			echo "2";
		}
	}
	public function adda(){
		$a=$_GET['id'];
		$b=$_GET['id2'];
		//$a="zdy0:王玉帅,zdy1:公司二,zdy2:男,zdy3:技术部,zdy4:程序员,zdy5:15101574324,zdy6:1510157324,zdy7:guanzhuwoba666,zdy8:792732447,zdy9:没有,zdy10:792732447@qq.com,zdy11:www.nmm.com,zdy12[]:北京市-北京市市辖区-东城区,zdy13:劲松富顿中心C座1201,zdy14:548976,zdy15:2017-4-27 17:11:46,zdy16:2222,";
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
			if($ex['0']=="zdy12[]")
			{
				$substr=substr($ex['0'],0,strlen($ex['0'])-2); //id
					$ex1[$substr]=$ex['1'];
			}elseif($ex['0']=='zdy1'){

				$ex1['zdy1']=$b;
			}else{
				$ex1[$ex['0']]=$ex['1'];
			}
			
		}  
		$data["lx_data"]=json_encode($ex1,true);
		$data["lx_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["lx_cj"]=	cookie('user_id');//本人ID  ;
		$data["lx_cj_date"]=time();//本人ID  ;
		$lx_base=M('lx');
		$add_lx=$lx_base->add($data);
		if($add_lx){
			$kh_base=M('kh');
			$map_kh['kh_id']=$b;
			$map_kh["kh_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$sql_kh=$kh_base->where($map_kh)->find();
			$kh_json=json_decode($sql_kh['kh_data'],true);
			foreach($kh_json as $k=>$v)
			{
				$sqlkh_new[$k]=$v;
			} 
			$sqlkh_new['zdy15']=(string)$add_lx;
			$sqlkh_en['kh_data']=json_encode($sqlkh_new,true);
			$sql_save=$kh_base->where($map_kh)->save($sqlkh_en);
			
		}else{
			echo "2";
		}
	}
	public function del(){
			$mapid=$_GET['id'];
		//	echo $mapid;
			$shangjidel_base=M('lx');
			$sql_del=$shangjidel_base->query("delete from `crm_lx` where `lx_id` in ($mapid)");
			//$save_jb=$this->ajax_sx();
			//echo $save_jb;
	}
	public function shaixuan(){
		$id=$_GET['id'];
		//$id="kehujibie,3|kehujibie,1|kehujibie,2|kehujibie,3|kehujibie,3|";
		$new_id=substr($id,0,strlen($id)-1); 
		

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
		$xiashu=$this->get_xiashu_id();
		
		$ex=explode(',',$xiashu);
		foreach ($ex as $k=>$v){
			if($v!=$my){
				$xs[]=$v;
			}
		}
		$xs1=implode(',', $xs);
	//	echo "<pre>";
	//	var_dump($xs);exit;  
		if($get['kehujibie']['1']=="0"){
			echo "quanbu";die;
			
		}elseif($get['kehujibie']['1']=="1"){
			$sql=$lx_base->query("select * from `crm_lx` where `lx_yh` = $fid  and  `lx_cj` = $my");        //我的

		}elseif($get['kehujibie']['1']=="2"){ 
			$sql=$lx_base->query("select * from `crm_lx` where `lx_yh` = $fid  and  `lx_cj` in ($xs1)"); //全部我的                                        //下属的
		}
		foreach ($sql as $k=>$v)
		{
			foreach($v as $k1=>$v1)
			{
				//echo "<pre>";
					//var_dump($v);exit;
				if($k1!='lx_data'){
					$sql_rh[$k1]=$v1;
				}else{
					$json=json_decode($v[$k1],true);
					foreach($json as $k2=>$v2)
					{
						$sql_rh[$k2]=$v2;
					}
				}
				
					
			}$lianxiren[]=$sql_rh;
		}
		



		$ywzd= $this->ywzd();    //业务字段信息 
		$kh_name= $this->kehu();    //业务字段信息 
		$dpt_arr= $this->department();    //部门字段信息 
															//联系人标题
		foreach($ywzd as $k=>$v)
		{
			if($v['qy']==1)
			{
				$ywzd2[$v['id']]=$v;
				//$ywzd2[]=$ywzd1;
			}
		}
		$array_jiansuo=array('lx_cj'=>"创建人",'lx_cj_date'=>"创建时间",'lx_gx_date'=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array[$new_str1['id']]=$new_str1;
					}

		$lx_biaoti1=array_merge_recursive($ywzd2,$new_array);//联系人标题名字

							//联系人显示内容
		if($lianxiren=='' || $lianxiren==null){
				$content="<span style='height:30px;line-height:30px;margin-left:100px;'>没有这条数据,快去<span onclick='addshangji()' style='color:#07d;cursor:pointer;'>添加</span>一条吧</span>";
				echo $content;die;
		}
		else{
		foreach($lianxiren as $k=>$v)
		{
			$id=$v['lx_id'];
			//echo "<pre>";
			//var_dump($lianxiren);exit;
			$show_bt.="<tr><td ><input type='checkbox' class='chbox_duoxuan' id='".$v['lx_id']."'></td>";
				foreach($lx_biaoti1 as $k1=>$v1)
				{
					if($v[$k1]!="")
					{

						if($k1=="zdy0")    //商机标题  跳转到商机页面
						{ 
							$show_bt.="<td><a href='".$_GET['root_dir']."/index.php/Home/Lianxirenmingcheng/Lianxirenmingcheng/id/$id'>".$v[$k1]." </a></td>"	;
						}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
							$kh_id=$v[$k1];
							$kh_mc=$kh_name[$v[$k1]]['name'];
							$show_bt.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id'>".$kh_name[$v[$k1]]['name']." </a></td>"	;
						}else{
							$show_bt.="<td> ".$v[$k1]." </td>"	;
						}

					}else{
						$show_bt.="<td> ---- </td>"	;
					}
				}	
			$show_bt.="</tr>";
		} }
		echo $show_bt;

	}
	public function user(){                 //负责人和部门
		$xiaji= $this->get_xiashu_id();// 
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
	 	$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门ddddddd
		}

		$fuzeren=M('user');
		
	
		
	
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
	 public function kehu_add(){
    	$xiaji= $this->get_xiashu_id();//  查询下级ID
    //	$lxr=$this->lxr();
    
		$user=$this->user();
  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="2";
  		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		foreach($a_arr as $k=>$v)
		{	if($v['qy']==1){
			$canm[$v['id']]=$v;
			}
		}
		$ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 		foreach($ywcs_sql_json as $kywcs=>$vywcs)
			{
				$ywcs_new[$vywcs['id']]=$vywcs;
			}
			
		foreach($ywcs_new as $k=>$v)
		{
			foreach($v['qy'] as $k1=>$v1)
			{
				if($v1==1){
					$ywcs_wys[$k1]=$v[$k1];
				}

			}
			$ywcs_wysend[$k]=$ywcs_wys;
		}
		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){

				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		// echo "<pre>";
		// var_dump($new_qy);exit;
		$a_arr=$new_qy;
		foreach($a_arr as $k=>$v)
		{
			if($v['bt']==1)
			{
				if($v['id']=="zdy1" || $v['id']=="zdy9" || $v['id']=="zdy10" || $v['id']=="zdy11" || $v['id']=="zdy12")
				{
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><select  class='required1' name='".$v['id']."'>";
							$show_bt.="<option value=''>--请选择--</option>";
						foreach($ywcs_wysend[$v['id']] as $k=>$v)
						{
							$show_bt.="<option value='".$k."'>".$v."</option>";
						}
					$show_bt.="<select></td>";	
					$show_bt.="</tr>";
				}elseif($v['id']=='zdy13'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
						$show_bt.="<td><input type='text' name='".$v['id']."'  class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td></tr>";	
				}elseif($v['id']=='zdy6'){
					$show_bt.="<tr class='addtr' data-toggle='distpicker' style='overflow:hidden'>";
					$show_bt.="<td><span style='color:red'>*</span>".$v['name'].":</td><td class='form-group' style='width:80%;'>";

					$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
		          	$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
		         	$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
	 				$show_bt.="</td></tr>";
				}elseif($v['id']=='zdy15'){
					
				
				}elseif($v['id']=='zdy3'){
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1 qingyx' name='".$v['id']."'  onchange='yxyz(this)' maxlength='35'></td></tr>";	
				}elseif($v['id']=='zdy0'){
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1' id= 'wyszdy0' onkeyup='kh_name_if(this)' name='".$v['id']."' maxlength='50'></td></tr>";	
				}elseif($v['id']=='zdy2'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
						$show_bt.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkp(this,this.value)' name='".$v['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodian' name='".$v['id']."' maxlength='25'></td></tr>";
				}elseif($v['id']=='zdy14'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
						$show_bt.="<td><textarea name='".$v['id']."' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td></tr>";
				}else{
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1' name='".$v['id']."' maxlength='50'></td></tr>";	
				}	
			}
	
						
		}
			$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>乙方负责人:</td>";
			$show_bt.="<td><select name='ht_fz'  class ='required' onchange='get_bm(this)'>";
			$show_bt.="<option  value=''>请选择负责人</option>";	
				foreach($user as $k=>$v)
				{
					$show_bt.="<option  value='".$v['user_id']."'>".$v['user_name']."</option>";
				}
			$show_bt.=" </select></td></tr>	";
			$show_bt.="<tr class='addtr '><td>部门:</td>";
			$show_bt.="<td class='bm_th' ><input type='text' name='ht_department' disabled value='' > </td>";
		
		  echo 	$show_bt;


    }
    public function add_kh()
    {
    	$a=$_GET['id'];
		//$a="zdy0:哥哥哥,zdy1:canshu1,zdy2:5565656,zdy3:54454,zdy4:55,zdy5:6,zdy15:142,zdy8:,zdy12:--请选择--,zdy13:,zdy6[]:北京市-北京市市辖区-东城区,zdy7:,zdy9:--请选择--,zdy10:--请选择--,zdy11:--请选择--,zdy14:,ht_fz:45,ht_department:销售部-国贸1,";
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
			if($ex['0']=="zdy6[]")
			{
				$substr=substr($ex['0'],0,strlen($ex['0'])-2); //id
					$ex1[$substr]=$ex['1'];
			}elseif($ex['0']=="ht_fz")
			{
				$data['kh_fz']=$ex['1'];
			}elseif($ex['0']=="ht_department")
			{
				$data['kh_bm']=$ex['1'];
			}else{
				$ex1[$ex['0']]=$ex['1'];
			}
			
		}
		$data["kh_data"]=json_encode($ex1,true);
		$data["kh_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["kh_cj"]=	cookie('user_id');//本人ID  ;
		$data["kh_cj_date"]=time();//本人ID  ;
		$lx_base=M('kh');
		$add_lx=$lx_base->add($data);
		if($add_lx){
       			$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$add_lx;//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增客户:".$ex1['zdy0'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'
				echo $add_lx;
			
		}else{
			echo "no";
		}
 
}	
	
}