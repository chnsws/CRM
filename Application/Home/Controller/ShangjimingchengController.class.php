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
	public function ywcs(){
			$ywcs_base=M('ywcs');
			$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$ywcs['ywcs_yw']=5;
			$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
			$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);  
			foreach($ywcs_json as $k=>$v)
			{
				$sql_ywcs[$v['id']]=$v;
			} 
			
			return $sql_ywcs;
	}
	public function user(){                 //负责人和部门
		$xiaji= $this->get_xiashu_id();//  查询下级ID
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
		$map['user_act']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	 	$fuzeren_sql=$fuzeren->where($map)->select();//缺少条件
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
		//echo $sj_id;exit;
		$sj_base=M('shangji');
		$map_sj['sj_id']=$sj_id;
		$sql_sj=$sj_base->where($map_sj)->find();
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
			$show.="<table>";
			if($kbt!='zdy2'){
				$show.="<tr style='line-height:30px'><td style='width:160px'><b>".$vbt['name'].":</b></td>";
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
							
					}else{
						$show.="<td>".$sql_rh[$kbt]."</td> ";
					}
					
				}
						$show.="</tr>";
			}
					$show.="</table>";

		}

		$user_dpment=$this->user();
	//	echo "<pre>";
//		var_dump($new_arrayoo);exit;
		foreach ($new_arrayoo as $k=>$v)
		{
			$show1.="<table>";
			$show1.="<tr style='line-height:30px'><td style='width:160px'><b>".$v['name'].":</b></td>";
			if($sql_rh[$k]=="")
			{
				$show1.="<td>未填写</td>";
			}else{
				//echo $k;
				if($k=="sj_fz")
				{	
						$show1.="<td>".$user_dpment[$sql_rh[$k]]['user_name']."</td> ";	
				}elseif($k=="sj_bm"){
					foreach ($user_dpment as $k2=>$v2)
					{
						if($v2['user_zhu_bid']==$sql_rh[$k])
						{
						$show1.="<td>".$v2['department']."</td> ";	
						}
					}
						
				}elseif($k=="sj_cj"){

						$show1.="<td>".$user_dpment[$sql_rh[$k]]['user_name']."</td> ";	
				}elseif($k=="sj_cj_date"){
									$show1.="<td>".date('Y-m-d H:i:s',$sql_rh[$k])."</td>";

				}else{}
				
			}
			$show1.="</tr>";
			$show1.="</table>";
		}//exit;
	//echo "<pre>";
		//var_dump($sql_rh);exit;
	$show2.="<table>";
			$show2.="<tr><td></td><td><input type='hidden' name='sj_id' value='".$sql_rh['sj_id']."' ></td> </tr>";
			$show2.="<tr><td></td><td><input type='hidden' name='zdy1' value='".$sql_rh['zdy1']."' ></td> </tr>";
			$show2.="<tr><td></td><td><input type='hidden' name='zdy2' value='".$sql_rh['zdy2']."' ></td> </tr>";
			foreach($biaoti as $kbt=>$vbt)
		{

			if($kbt!='zdy2' && $kbt!='zdy1' && $kbt!="zdy6"){
				$show2.="<tr style='line-height:40px'><td style='width:160px'>".$vbt['name'].":</td>";
				if($sql_rh[$kbt]=="")
			{
				$show2.="<td><input type='text' name='".$kbt."' value='未填写'></td>";
			}else{
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
				}else{
					$show2.="<td><input type='text' name='".$kbt."' value='".$sql_rh[$kbt]."' ></td> ";
				}
				
			}	
			}
			
					$show2.="</tr>";
				
		}
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
		}
		foreach($cp_rh as $k=>$v){
			$cp_show.="<tr class='".$v['cp_id1']."'><td >".$v['zdy0']."</td>
					  <td >".$v['zdy1']."</td>
					  <td >".$v['cp_yj']."</td>
					  <td >".$v['cp_jy']."</td>
					  <td >".$v['cp_num1']."</td>
					  <td >".$v['cp_zk']."</td>
					  <td >".$v['cp_zj']."</td>
					  <td >".$v['zdy4']."</td>
					  <td >".$v['zdy5']."</td>
					  <td >".$v['cp_beizhu']."</td>
					  	<td ><input type='button' name='".$v['cp_id1']."' onclick='cp_sj_del(this)' value='删除'></td>
					 </tr> ";

		}
		$file_sj['name_id']=$sj_id;
		$file_sj['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$file_sj['mk']='5';
		$file_sj_base=M('file');
		$sql_file_sj=$file_sj_base->where($file_sj)->select();
		foreach($sql_file_sj as $k=>$v)
		{
			$file_sj_show.="<tr class='".$v['id']."'><td>".$v['id']."</td><td>".$v['sc_data']."</td><td>".$v['fujian_name']."</td><td>".$v['big']."</td><td>".$v['beizhu']."</td><td><button onclick='fujian_del(this)' name='".$v['id']."' class='layui-btn layui-btn-primary layui-btn-small'>
    <i class='layui-icon'>&#xe642;</i>删除
  </button></td>";
			$file_sj_show.="</tr>";
		}
		$this->assign('file_sj_show',$file_sj_show);
	//echo "<pre>";
		//var_dump($sql_file_sj);exit;
			$this->assign('cp_show',$cp_show);
		$this->assign('fuzeren',$user_dpment[$sql_rh['sj_fz']]['user_name']);
		$this->assign('show',$show);
		$this->assign('show1',$show1);
		$this->assign('sj_id',$sj_id);

		$this->assign('sql_rh',$sql_rh);
		$this->assign('lx_json',$lx_json);
		$this->assign('sql_lianxi',$sql_lianxi);
		
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
		//echo "<pre>";
		//var_dump($data);exit;
		$sj_base=M('shangji');
		$sql_save=$sj_base->where($map)->save($data);
		if($sql_save){
				$sj_id=$map['sj_id'];
				$sj_base=M('shangji');
				$map_sj['sj_id']=$sj_id;
				$sql_sj=$sj_base->where($map_sj)->find();
				foreach($sql_sj as $k=>$v)
				{
					if($k!='sj_data')
					{
						$sql_rh[$k]=$v;
					}else{
						
						$sj_json=json_decode($sql_sj['sj_data'],true);
						foreach ($sj_json as $k1=>$v1)
						{
							$sql_rh[$k1]=$v1;
						}
					}

				}    //商机信息查询

				$biaoti=$this->ywzd(); //标题过来了
				$ywcs=$this->ywcs(); //参数过来了
				//echo "<pre>";
				//var_dump($biaoti);exit;
				foreach($biaoti as $kbt=>$vbt)
				{
					$show.="<table>";
					if($kbt!='zdy2')
						$show.="<tr style='line-height:30px'><td style='width:160px'><b>".$vbt['name'].":<b></td>";
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
								
						}else{
							$show.="<td>".$sql_rh[$kbt]."</td> ";
						}
						
					}
							$show.="</tr>";
						$show.="</table>";
						

				}echo $show;

		}else{
			echo "no";
		}
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
    			$upload->maxSize   =     3145728 ;// 设置附件上传大小
   				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','pptx','xls');// 设置附件上传类型
    			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
   				$upload->autoSub = false;
   				$upload->hash = false;
    		// 上传文件 
   				 $info   =   $upload->upload();
    			if(!$info) {// 上传错误提示错误信息
        		$this->error($upload->getError());
    				}// 上传成功
    					    foreach($info as $file){
       						$save_name= 'Uploads/'.$file['savename'];//获取报存路径
       						$save_oldname=$file['name'];//原始吗，
       						$save_size=$file['size'] *'0.0009766';//大小
       						$sql=substr($save_size,0,3).'kb';//换算
 
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
       			 				window.location="'.$_GET['root_dir'].'/index.php/Home/Shangjimingcheng/shangjimingcheng/id/'.$sj_id.'";
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
}