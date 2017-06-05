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
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map' and kh_fz IN ($xiaji)");
		
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
	public function lianxiren_sel(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;
		//$new_xiaji="1,3,4,6,7,8";       
		$new_array=explode(',',$new_xiaji);
		
		
		$lxr_base=M('lx');
		$map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司
		$map['lx_cj']=array('in',$new_array);//cid在这个数组中，
		$lxr_sql=$lxr_base->where($map)->select();  //查询出我的我的下级联系人
			//echo "<pre>";
		//var_dump($lxr_sql);exit;
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
			
			}$new_lxr[]=$sql;
			unset($sql );
			
		}
		return $new_lxr;

	}
	public function ajax_sx(){
		$ywzd= $this->ywzd();    //业务字段信息 
		$kh_name= $this->kehu();    //业务字段信息 
		$dpt_arr= $this->department();    //部门字段信息 
		$lianxiren= $this->lianxiren_sel();    //业务字段信息 
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
		foreach($lianxiren as $k=>$v)
		{
			$id=$v['lx_id'];
			//echo "<pre>";
			//var_dump($lianxiren);exit;
			$show_bt.="<tr><td ><input type='checkbox' class='chbox_duoxuan' id='".$v['lx_id']."'>".$v['lx_id']."</td>";
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
		}
		return $show_bt;
	}
	public function lianxiren(){
		$ywzd= $this->ywzd();    //业务字段信息 
		$kh_name= $this->kehu();    //业务字段信息 
	//	echo "<pre>";var_dump($kh_name);exit;
		$dpt_arr= $this->department();    //部门字段信息 
		$lianxiren= $this->lianxiren_sel();    //业务字段信息 
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
		//echo "<pre>";var_dump($lx_biaoti1);exit;					
				//echo "<pre>";
			//	var_dump($lianxiren);
			//	echo "<pre>";
				//var_dump($lx_biaoti1);exit;														//联系人显示内容
		foreach($lianxiren as $k=>$v)
		{
			$id=$v['lx_id'];
			//echo "<pre>";
			//var_dump($lianxiren);exit;
			$show_bt.="<tr><td ><input type='checkbox' class='chbox_duoxuan' id='".$v['lx_id']."'>".$v['lx_id']."</td>";
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
									$add_yw.="<td>
							 		<select  name='".$vywzd['id']."' class='required' style='width:300px;height:26px;'>
							 			<option>--请选择--</option>";
							 		foreach ($kh_name as $kkh => $vkh)
							 		{
							 			 $add_yw.="<option value='".$vkh['id']."'>".$vkh['name']."</option>";
							 		} 
							 $add_yw.=	"</select> </td>";
							$add_yw.="</tr>";
						}
					}elseif($vywzd['type']==2){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text'  class=' required text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."  name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['type']==1){	
													$add_yw.="<form class='form-inline'>";
     													$add_yw.="<div data-toggle='distpicker' style='overflow:hidden'>";
	       													$add_yw.="<div class='form-group' style='width:33.3%; float:left'>";
	          													$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
	        													$add_yw.="</div>";
														        $add_yw.="<div class='form-group' style='width:33.3%; float:left'>";
														          		$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
														        $add_yw.="</div>";
														        $add_yw.="<div class='form-group' style='width:33.3%; float:left'>";
														         	 $add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
														        $add_yw.="</div>";
													     	$add_yw.="</div>";
							 							$add_yw.="</form>";
					}else{
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' class='required' name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					}
				}elseif($vywzd['cy']==1)
				{
					if($vywzd['type']==3)
					{
						if($vywzd['id']=='zdy1')
						{
							$add_yw1.="<tr class='addtr'>";
							$add_yw1.="<td>".$vywzd['name'].":</td>";
									$add_yw1.="<td>
							 		<select  name='' style='width:300px;height:26px;'>
							 			<option>--请选择--</option>";
							 		foreach ($kh_name as $kkh => $vkh)
							 		{
							 			 $add_yw1.="<option value='".$vkh['id']."'>".$vkh['name']."</option>";
							 		} 
							 $add_yw1.=	"</select> </td>";
							$add_yw1.="</tr>";
						}
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
					}else{
						$add_yw1.="<tr class='addtr'>";
						$add_yw1.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'></td>";
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
							 		<select  name='' style='width:300px;height:26px;'>
							 			<option>--请选择--</option>";
							 		foreach ($kh_name as $kkh => $vkh)
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
					}else{
						$add_yw2.="<tr class='addtr ncy'>";
						$add_yw2.="<td>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'></td>";
						$add_yw2.="</tr>";
					}
				}
			}
		}
		
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
	public function add(){
		$a=$_GET['id'];
		//$a="zdy0:王玉帅,zdy1:公司二,zdy2:男,zdy3:技术部,zdy4:程序员,zdy5:15101574324,zdy6:1510157324,zdy7:guanzhuwoba666,zdy8:792732447,zdy9:没有,zdy10:792732447@qq.com,zdy11:www.nmm.com,zdy12[]:北京市-北京市市辖区-东城区,zdy13:劲松富顿中心C座1201,zdy14:548976,zdy15:2017-4-27 17:11:46,zdy16:2222,";
		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":",$v);
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
			$xiaji= $this->ajax_sx();
			echo $xiaji;
		}else{
			echo "2";
		}
	}
	public function del(){
			$mapid=$_GET['id'];
		//	echo $mapid;
			$shangjidel_base=M('lx');
			$sql_del=$shangjidel_base->query("delete from `crm_lx` where `lx_id` in ($mapid)");
			$save_jb=$this->ajax_sx();
			echo $save_jb;
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
		$lx_base=M('lx');
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$my= cookie('user_id'); 
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
			$sql=$lx_base->query("select * from `crm_lx` where `lx_yh` = $fid  and  `lx_cj` in ($xiashu)"); //全部
			
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
		foreach($lianxiren as $k=>$v)
		{
			$id=$v['lx_id'];
			//echo "<pre>";
			//var_dump($lianxiren);exit;
			$show_bt.="<tr><td ><input type='checkbox' class='chbox_duoxuan' id='".$v['lx_id']."'>".$v['lx_id']."</td>";
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
		}
		echo $show_bt;

	}
}