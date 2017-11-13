<?php
namespace Home\Controller;
use Think\Controller;

/**
 *
 * ━━━━━━神兽出没━━━━━━
 * 　　　┏┓　　　┏┓
 * 　　┏┛┻━━━┛┻┓
 * 　　┃　　　　　　　┃
 * 　　┃　　　━　　　┃
 * 　　┃　┳┛　┗┳　┃
 * 　　┃　　　　　　　┃
 * 　　┃　　　┻　　　┃
 * 　　┃　　　　　　　┃
 * 　　┗━┓　　　┏━┛Code is far away from bug with the animal protecting
 * 　　　　┃　　　┃    神兽保佑,代码无bug
 * 　　　　┃　　　┃
 * 　　　　┃　　　┗━━━┓
 * 　　　　┃　　　　　　　┣┓
 * 　　　　┃　　　　　　　┏┛
 * 　　　　┗┓┓┏━┳┓┏┛
 * 　　　　　┃┫┫　┃┫┫
 * 　　　　　┗┻┛　┗┻┛
 *
 * ━━━━━━感觉萌萌哒━━━━━━
 */
  
/**
 * 　　　　　　　　┏┓　　　┏┓
 * 　　　　　　　┏┛┻━━━┛┻┓
 * 　　　　　　　┃　　　　　　　┃ 　
 * 　　　　　　　┃　　　━　　　┃
 * 　　　　　　　┃　＞　　　＜　┃
 * 　　　　　　　┃　　　　　　　┃
 * 　　　　　　　┃...　⌒　...　┃
 * 　　　　　　　┃　　　　　　　┃
 * 　　　　　　　┗━┓　　　┏━┛
 * 　　　　　　　　　┃　　　┃　Code is far away from bug with the animal protecting　　　　　　　　　　
 * 　　　　　　　　　┃　　　┃   神兽保佑,代码无bug
 * 　　　　　　　　　┃　　　┃　　　　　　　　　　　
 * 　　　　　　　　　┃　　　┃  　　　　　　
 * 　　　　　　　　　┃　　　┃
 * 　　　　　　　　　┃　　　┃　　　　　　　　　　　
 * 　　　　　　　　　┃　　　┗━━━┓
 * 　　　　　　　　　┃　　　　　　　┣┓
 * 　　　　　　　　　┃　　　　　　　┏┛
 * 　　　　　　　　　┗┓┓┏━┳┓┏┛
 * 　　　　　　　　　　┃┫┫　┃┫┫
 * 　　　　　　　　　　┗┻┛　┗┻┛
 */
  
/**
 *　　　　　　　　┏┓　　　┏┓+ +
 *　　　　　　　┏┛┻━━━┛┻┓ + +
 *　　　　　　　┃　　　　　　　┃ 　
 *　　　　　　　┃　　　━　　　┃ ++ + + +
 *　　　　　　 ████━████       ┃+
 *　　　　　　　┃　　　　　　　┃ +
 *　　　　　　　┃　　　┻　　　┃
 *　　　　　　　┃　　　　　　　┃ + +
 *　　　　　　　┗━┓　　　┏━┛
 *　　　　　　　　　┃　　　┃　　　　　　　　　　　
 *　　　　　　　　　┃　　　┃ + + + +
 *　　　　　　　　　┃　　　┃　　　　Code is far away from bug with the animal protecting　　　　　　　
 *　　　　　　　　　┃　　　┃ + 　　　　神兽保佑,代码无bug　　
 *　　　　　　　　　┃　　　┃
 *　　　　　　　　　┃　　　┃　　+　　　　　　　　　
 *　　　　　　　　　┃　 　　┗━━━┓ + +
 *　　　　　　　　　┃ 　　　　　　　┣┓
 *　　　　　　　　　┃ 　　　　　　　┏┛
 *　　　　　　　　　┗┓┓┏━┳┓┏┛ + + + +
 *　　　　　　　　　　┃┫┫　┃┫┫
 *　　　　　　　　　　┗┻┛　┗┻┛+ + + +
 */
class LianxirenmingchengController extends Controller {

	public function Lianxirenmingcheng(){
		$a=$_GET['id'];
	//	echo $a;exit;
		$map['lx_id']=$a;//联系人条件
		$map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件          
		$lx_base=M("lx");
		$sql_lianxi=$lx_base->where($map)->find();
		$lx_json=json_decode($sql_lianxi['lx_data'],true);

		$ywzd=$this->ywzd();
		$user=$this->user();
	
		$kh_id=$lx_json['zdy1'];
		//var_dump($kh_id);exit;
		$kehu=$this->kehu();//echo "<pre>";var_dump($kehu);exit;
		//$xg_lx['lx_data']=array('like','% \\"zdy1\\":\\"'.$kh_id.'\\" %');//var_dump($xg_lx['lx_data']);exit;
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
		$sql_xg=$lx_base->query("select * from crm_lx where lx_yh='$fid' and lx_data like '%\"zdy1\":\"".$kh_id."\"%' ");      
	//echo "<pre>";var_dump($sql_xg);exit;
		foreach($sql_xg as $k=>$v)
		{
			if($v['lx_id']!=$a){
				foreach($v as $k1=>$v1)
				{
					if($k1!='lx_data'){
						$lx_xgr[$k1]=$v1;
					}else{
						$lxr_json=json_decode($v1,true);
						foreach($lxr_json as $k2=>$v2)
						{
							$lx_xgr[$k2]=$v2;
						}
					}
				}
				$kh[]=$lx_xgr;        //相关联系人
			}
		}
		$shangji_base=M('shangji');
		$sql_shangji=$shangji_base->query("select * from crm_shangji where sj_yh ='$fid' and (sj_data like '%\"zdy2\":\"".$a."\"%' or sj_data like '%\"zdy2\":".$a."%') ");
		foreach($sql_shangji as $k=>$v)
		{
				foreach($v as $k1=>$v1)
				{
					if($k1!='sj_data'){
						$shangji[$k1]=$v1;
					}else{
						$sj_json=json_decode($v1,true);
						foreach($sj_json as $k2=>$v2)
						{
							$shangji[$k2]=$v2;
						}
					}
				}
				$sj_rh[]=$shangji;       //相关联系人

		}
	//	echo "<pre>";var_dump($sj_rh);exit;
		if($sj_rh==''||$sj_rh==null){
			$shangji1.="<tr><td colspan='30' align='center'><span>亲~没有数据哟！请添加相关联系人</td></tr>";
		}else{
			foreach ($sj_rh as $k=>$v){
				$shangji1.="<tr>";
					foreach($v as $k1=>$v1)
					{
						$id_sj=$v['sj_id'];
						if($k1=="zdy0"){
							$shangji1.="<td><a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id_sj'><span style='color:#07d'>".$v1."</span></a></td>";
						}elseif($k1=="zdy3" || $k1=="zdy11"|| $k1=="sj_qiandan"){
							$shangji1.="<td>".$v1." </td>";
						}elseif($k1=="zdy4"){
							$shangji1.="<td>".$v1." </td>";
						}elseif($k1=="zdy5"){
							$ywcs=$this->ywcs();
							$shangji1.="<td>".$ywcs['1'][$v1]." </td>";
						}
					}
				$shangji1.="</tr>";
			}
		}
	//	var_dump($shangji);exit;
		
		foreach ($ywzd as $k => $v){
			$show.="<tr style='line-height:40px'><td>".$v['name']."：</td>";
				if($lx_json[$k]!=""){
					if($k=='zdy1'){
						$kehu_nm=$kehu[$lx_json[$k]]['name'];
					//	var_dump($kehu);exit;
						$show.="<td><span style='margin-left:30px'>".$kehu[$lx_json[$k]]['name']."</span></td>";	
					}else{
						$show.="<td><span style='margin-left:30px'>".$lx_json[$k]."</span></td>";
					}
					
				}else{
					$show.="<td><span style='margin-left:30px'>未填写</span></td>";
				}
			$show.="</tr>";
		}
		$array_jiansuo=array('lx_cj'=>"创建人",'lx_cj_date'=>"创建时间",'lx_gx_date'=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array[$new_str1['id']]=$new_str1;
					}
		foreach ($new_array as $k => $v){
			$show1.="<tr style='line-height:40px'><td>".$v['name']."：</td>";
				if($sql_lianxi[$k]!=""){
					if($k=="lx_cj"){
						$show1.="<td><span style='margin-left:30px'>".$user[$sql_lianxi[$k]]['user_name']."</span></td>";
					}elseif($k=="lx_cj_date"){
					
						$show1.="<td><span style='margin-left:30px'>".date("Y-m-d H:i:s",$sql_lianxi[$k])."</span></td>";
					}else{
					$show1.="<td><span style='margin-left:30px'>".$sql_lianxi[$k]."</span></td>";
					}
				}else{
					$show1.="<td><span style='margin-left:30px'>未填写</span></td>";
				}
			$show1.="</tr>";
		}
		//	echo "<pre>";var_dump($show1);exit;
		foreach ($ywzd as $k => $v){
			$show3.="<tr ><td>".$v['name']."：</td>";
				if($lx_json[$k]!=""){
					if($k=='zdy1'){
						$show3.="<td><input type='hidden' name='".$k."' style='width:220px;height:26px;'  value='".$lx_json[$k]."'><span style='margin-left:30px;color:#07d'>".$kehu[$lx_json[$k]]['name']."</span></td>";	
					}elseif($k=='zdy2'){
						
						$show3.="<td>";
						
						if($lx_json[$k]=="男"){
								$show3.="<input type='radio' name='".$k."' style='width:40px;' checked='checked' value='男' />男";
						
								$show3.="<input type='radio' name='".$k."' style='width:40px;' value='女' />女";
					
						
								
						}else{
								$show3.="<input type='radio' name='".$k."' style='width:40px;' value='男' />男";
								$show3.="<input type='radio' name='".$k."' style='width:40px;' checked='checked' value='女' />女";
							
						}
						
						$show3.="</td>";
					}elseif($k=='zdy15'){
						$show3.="<td><input type='text' name='".$k."' class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."  style='width:220px;height:26px;' value='".$lx_json[$k]."'></td>";

					}elseif($k=='zdy6'){
						$show3.="<td><input type='text' name='".$k."' class='required1 qingyx1 ' onclick='sjyz(this)' value='".$lx_json[$k]."'></td>";

					
					}elseif($k=='zdy10'){

						$show3.="<td><input type='text' name='".$k."'  class='qingyx'  onchange='yxyz(this)' style='width:220px;height:26px;' value='".$lx_json[$k]."'></td>";
					}elseif($k=='zdy5'){
								$zuoji = explode('-',$lx_json[$k]);
								if($zuoji[1]==''||$zuoji[1]==null){
									$zuoji[1]=$zuoji[0];
									$zuoji[0]='';
								}
								$show3.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$k."'' style='width:48px;height:26px;' value='".$zuoji[0]."'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:148px;height:26px;' class='jiaodiana' name='".$k."' value='".$zuoji[1]."'></td>";	
					}else{
						$show3.="<td><input type='text' name='".$k."' style='width:220px;height:26px;' value='".$lx_json[$k]."'></td>";
					}
					
				}else{
					if($k=='zdy2'){
						
						$show3.="<td>";
						
						
								$show3.="<input type='radio' name='".$k."' style='width:40px;' checked='checked' value='男' />男";
						
								$show3.="<input type='radio' name='".$k."' style='width:40px;' value='女' />女</td>";
					
						
						}elseif($k=='zdy15'){
						$show3.="<td><input type='text' name='".$k."' class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."  style='width:220px;height:26px;' placeholder='未填写'></td>";

					
						}elseif($k=='zdy10'){

						$show3.="<td><input type='text' name='".$k."'  class='qingyx'  onchange='yxyz(this)' style='width:220px;height:26px;' placeholder='未填写'></td>";		
						}elseif($k=='zdy5'){
								$show3.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$k."'' style='width:48px;height:26px;' value='".$zuoji[0]."'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:148px;height:26px;' class='jiaodiana' name='".$k."' value='".$zuoji[1]."'></td>";	
						}else{
							$show3.="<td><input type='text' name='".$k."' style='width:220px;height:26px;' placeholder='未填写' ></td>";
						}
				}
			$show3.="</tr>";
		}
		$show3.="<tr><td></td><td><input type='hidden' class='lx_id97'  name='lx_id' value='".$a."'></td></tr>";
	//	echo "<pre>";
//	var_dump($lx_json);exit;
		$this->assign('show',$show);
		$this->assign('show1',$show1);
		$this->assign('show3',$show3);
		$this->assign('kehu_nm',$kehu_nm);
		$this->assign('lx_json',$lx_json);
		$this->assign('kh',$kh);	
				$this->assign('shangji1',$shangji1);	
		$this->display();
	}
public function ywzd(){                               //业务字段表--联系人
		$data['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件              
		$data['zd_yewu']=4;//所属模块
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
	public function ywcs(){
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$ywcs['ywcs_yw']=5;
		$ywcs_base=M('ywcs');
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$json=json_decode($ywcs_sql['ywcs_data'],true);
		return $json;
		//echo "<pre>";
//	var_dump($json);exit;
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
			$ex=explode(":￥￥",$v);
			if($ex['0']=="lx_id")
			{
				$map['lx_id']=$ex['1'];
			}
			else
			{
				$ex1[$ex['0']]=$ex['1'];
			}
		}
		$data['lx_data']=json_encode($ex1,true);
		$data['lx_gx_date'] =date('Y-m-d H:i:s');
		$sj_base=M('lx');
		$user=$this->user();
		$sql_save=$sj_base->where($map)->save($data);
		if($sql_save){
				$a=$map['lx_id'];
				$map['lx_id']=$a;//联系人条件
				$map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件          
				$lx_base=M("lx");
				$sql_lianxi=$lx_base->where($map)->find();
				$lx_json=json_decode($sql_lianxi['lx_data'],true);
				$ywzd=$this->ywzd();
		
				$kehu=$this->kehu();echo "<pre>";var_dump($kehu);exit;
				foreach ($ywzd as $k => $v){
					$show.="<tr style='line-height:40px'><td>".$v['name']."：</td>";
						if($lx_json[$k]!=""){
							if($k=='zdy1'){
								$kehu_nm=$kehu[$lx_json[$k]]['name'];
								$show.="<td><span style='margin-left:30px'>".$kehu[$lx_json[$k]]['name']."</span></td>";	
							}else{
								$show.="<td><span style='margin-left:30px'>".$lx_json[$k]."</span></td>";
							}
							
						}else{
							$show.="<td><span style='margin-left:30px'>未填写</span></td>";
						}
					$show.="</tr>";
				}
				echo $show;
		}else{
			echo "no";
		}
	}
}