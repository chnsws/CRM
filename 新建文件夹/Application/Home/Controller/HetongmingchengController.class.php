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
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		if(cookie('user_fid')=='0')
		{
			$map['user_id']=$fid;
		}
		else
		{
			$map['user_fid']=$fid;
		}
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
		public function hetongmingcheng(){
			$ywzd=$this->ywzd();
			$user=$this->user();

			$kehu=$this->kehu();
			$ywcs=$this->ywcs();
			$shangji=$this->shangji();
			$chanpin=$this->chanpin();
		//	echo "<pre>";
			//var_dump($ywcs);exit;
			$ht_id=$_GET['id'];
			$map['ht_id']=$ht_id;//联系人条件
			$map['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件          
			$lx_base=M("hetong");
			$sql_lianxi=$lx_base->where($map)->find();
			$ht_json=json_decode($sql_lianxi['ht_data'],true);
			foreach ($ywzd as $k => $v){
				$show.="<table><tr style='line-height:40px'><td style='width :150px'>".$v['name']."：</td>";
				if($ht_json[$k]!=""){
					if($k == 'zdy1')
					{
						$show.="<td >".$kehu[$ht_json[$k]]['name']."</td>";	
					}elseif($k=='zdy2'){
						$show.="<td >".$shangji[$ht_json[$k]]['zdy0']."</td>";	
					}elseif($k=='zdy7' || $k=='zdy10' || $k=='zdy11'){
						$show.="<td >".$ywcs[$k][$ht_json[$k]]."</td>";
					}else{
						$show.="<td >".$ht_json[$k]."</td>";	
					}	
				}else{
					$show.="<td >未填写</td>";
				}
				$show.="</tr></table>";
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
				$show1.="<table><tr style='line-height:40px'><td style='width :150px'>".$v['name']."：</td>";
				if($sql_lianxi[$k]!=""){
						if($k=='ht_fz' || $k=='ht_old_fz' ||$k=='ht_cj')
						{
							$show1.="<td >".$user[$sql_lianxi[$k]]['user_name']."</td>";
						}elseif($k=='ht_spzt'){
								
						}elseif($k=='ht_new_gj'){
								$show1.="<td >".$sql_lianxi[$k]."</td>";
						}elseif($k=='ht_bm'){
								$show1.="<td >".$sql_lianxi[$k]."</td>";
						}else{
							$show1.="<td >".date("Y-m-d H:i:s", $sql_lianxi[$k])."</td>";
						}
							
				}else{
					$show1.="<td >未填写</td>";
				}
				$show1.="</tr></table>";
			} 
		$show3.="<tr><td></td><td><input type='text' name='ht_id' value='".$ht_id."'></td></tr>";
			foreach ($ywzd as $k => $v){
				if($k=="zdy9" || $k=='zdy14'){
					continue;
				}
				$show3.="<table class='uk-form'>";
			
				$show3.="<tr style='line-height:40px'><td style='width :150px'>".$v['name']."：</td>";
	
					if($k == 'zdy1')
					{
						$show3.="<td ><select name='$k' onchange='get_sj(this)' class='bjwh'>";

						
						foreach($kehu as $k2=>$v2)
						{
							if($k2==$ht_json[$k])
							$show3.="<option value='".$v2['id']."' selected='selected'>".$v2['name']."</option>";
							else
							$show3.="<option value='".$v2['id']."' >".$v2['name']."</option>";
						}
						$show3.="</select></td>";	
					}elseif($k=='zdy2'){

						$show3.="<td class='th_sj'><select name='".$k."' class='bjwh'>";
						
							foreach($shangji as $k3=>$v3)
							{
								if($ht_json['zdy1']==$v3['zdy1']){
									if($v3['zdy2']==$ht_json['zdy2'])
										$show3.="<option value='".$v3['sj_id']."' selected='selecteed'>".$v3['zdy0']."</option>";	
									else{
										$show3.="<option value='".$v3['sj_id']."' >".$v3['zdy0']."</option>";	
									}
									
								}
								
							}
						if($ht_json[$k]=='012'){
									$show3.="<option value='' selected='selected'>--未填写--</option>";
							}
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
						$show3.="<td ><input type='text' class='bjwh' name='$k' value='".$ht_json[$k]."' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."></td>";	
					}else{
						$show3.="<td ><input type='text' class='bjwh' name='$k' value='".$ht_json[$k]."'></td>";	
					}	
				
				$show3.="</tr></table>";

			}
			//合同附件查询
			$file['mk']=6;
			$file['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$file['name_id']=$ht_id;
			$file_base=M('file');
			$sql_file=$file_base->where($file)->select();
			foreach($sql_file as $k=>$v)
			{
				$file_show.="<tr class='".$v['id']."'>
				  				<td >".date("Y-m-d H:i:s", $v['sc_data'])."</td>
				  				<td >".$v['fujian_name']."</td>
				  				<td >".$v['big']."</td>
				  				<td >".$v['beizhu']."</td>
				  				<td ><input type='button' value='删除' onclick='fujian_del(this)' name='".$v['id']."'></td>
							</tr> ";
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
				<td>".$v['zdy3']."</td>
				<td>".$v['zdy6']."</td>
				<td>".$v['cp_beizhu']."</td>
				<td><input type='button' name='".$v['cp_id1']."' onclick='cp_del(this)' value='删除'></td>
				</tr>";
			}

		$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id' onchange='cp_aj(this)' class ='clk_fzr' style='width:300px;height:26px;'>";
							$chanpin1.="<option value='s'>请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0']." </option>";
					}
					$chanpin1.="</select> </td></tr>";
			$this->assign('chanpin1',$chanpin1); 
			$this->assign('ht_id',$ht_id);
			$this->assign('show2',$show2); //合同残品
			$this->assign('show3',$show3); //合同编辑
			$this->assign('file_show',$file_show); //合同附件
			$this->assign('show',$show); //合同基本信息
			$this->assign('show1',$show1); //合同系统信息
			$this->assign('name',$ht_json['zdy0']); //合同名字
			$this->assign('fuzeren',$user[$sql_lianxi['ht_fz']]['user_name']);//合同负责人
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
				<td>".$v['zdy3']."</td>
				<td>".$v['zdy6']."</td>
				<td>".$v['cp_beizhu']."</td>
				<td><input type='button' name='".$v['cp_id1']."' onclick='cp_del(this)' value='删除'></td>
				</tr>";
			}
			echo $show2;
			 						
		} else{
			echo "2";
		}
	
		}
			public function fj_shangchuan(){//http://www.jb51.net/article/74353.htm   筛选第二天要看的


				$ht_id=$_GET['id'];
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
 
    			 $data['name_id']=$ht_id;
    			 $data['sc_data']= date("Y-m-d h:i:s");
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
       			 				alert("上传成功");
       			 				window.location="'.$_GET['root_dir'].'/index.php/Home/Hetongmingcheng/Hetongmingcheng/id/'.$ht_id.'";
       			 				</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
}
	public function fujian_del(){
				$data['id']=$_GET['id'];
				 $sql_file=M('file');
				 $data['mk']="6";
				 $data['yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
				 $sql_del=$sql_file->where($data)->delete();
				 
			}
}