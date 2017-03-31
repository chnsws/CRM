<?php
namespace Home\Controller;
use Think\Controller;


class KehuController extends Controller {
    public function kehu(){

  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('kh');                             //显示客户所需字段data
		$kehu=$kehu->select();
		//echo"<pre>";
//var_dump($kehu);exit;
		$conf=M('config');
		$conf_sql=$conf->field("config_kh_data")->find();
		$conf_sql_json=json_decode($conf_sql['config_kh_data'],true);
        $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=1;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);

		$nachu=array();
		foreach($kehu as $k=>$v){
			$nachu[$k]=json_decode($v['kh_data'],true);
		}
		//echo "<pre>";
//var_dump($nachu);exit;
		foreach($nachu as $k=>$v){
		 			foreach($v as $k1=>$v1){
		 				foreach ($ywcs_sql_json as $key=>$val){		 				
		 					if($k1==$val['id']){
		 						$v[$k1]=$val[$v1];						
		 					} 		 					
		 				}
		 			}
		 			$guanlianw[]=$v;
		 		}
 					
//var_dump();exit;
		foreach($kehu as $k=>$val){
			$valav=array_merge($guanlianw[$k],$val);
			$dantiao=$valav['kh_id'];//获取到id
			unset($valav['kh_id']); 
			unset($valav['kh_data']); 
			array_unshift($valav,$dantiao); //整理好的单条信息
			
				$ronghe[]=$valav;	 //多条融合	
		}


		foreach ($ronghe as $key1 => $val1){
			foreach($val1 as $key2 =>$val2){  

				$ceshi2[]=$val1[$key2];
			}
			
			$adddd[]=$ceshi2;
			unset($ceshi2);
		}
		
		//echo "<pre>";
		//var_dump($adddd);exit;
		foreach($ronghe as $k=>$v ){               //获取键值用于循环客户信息
			foreach($v as $key=>$val){
				$jianzhi[]=$key;	
			}
				break;
		}

		
 		foreach($ywcs_sql_json as $ywcs_k=>$ywcs_v){
 			foreach($ywcs_v as $k=>$v){
 				$ywcs_jianzhi[]=$k;
 			}
 			$abc[]=$ywcs_jianzhi;
 			unset($ywcs_jianzhi);
 		}

      $sql_peizhi=array();
	   foreach($a_arr as $k=>$v){     //显示配置左边标题头
	   		foreach($conf_sql_json as $key=>$val){
	   			if($v['id']==$val){
	   			$sql_peizhi[]=array('name'=>$v['name'],'id'=>$val,'type'=>$v['type']);
	   			}	
	   		}
	 } 


	 	if($_GET['id3']=='0128'){//配置进来的筛选
	 		$get_id=$_GET['id']; //canshu1
			$get_id1=$_GET['id1'];//重要客户	
			$get_id2=$_GET['id2'];//zdy1
			$get_id3=$_GET['id3'];//0128

			foreach( $ronghe as $k=>$v){
				foreach ($v as $key=>$val ){
					if ($key==$get_id2&&$val==$get_id1){
							$shaixuan1[]=$v;//获取到新的筛选的单条信息

					}
	 		
				}
				
			}
			$ronghe1[]=$shaixuan1;
			//筛选最终信息
	 	}//echo "<pre>";
	 //	var_dump($ronghe);exit;
	 	$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
	 	$this->assign('fuzeren',$fuzeren_sql);
	 	$this->assign("ywcs_biao",$ywcs_sql_json);
    	$this->assign('left_conf',$sql_peizhi);
		$this->assign('list',$jianzhi); 
		//echo "<pre>";
		//print_r($ronghe);exit;
		

		
		foreach($ronghe as $r_k=>$r_v)
		{
			$table.="<tr id='tr".$r_v['0']."'>";
			foreach($r_v as $k=>$v)
			{//echo "<pre>";
			//	var_dump($r_v);exit;

				$a_fuzeren=$r_v['fuzeren'];

		$id=$r_v['0'];
		//var_dump($k);exit;
		//echo "<pre>";
		//	var_dump($r_v['0']);exit;
				if($k=='zdy0')
					$xs123="<a href='kehumingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/kh_id/$id'><input type='text' width='20px' name='{$k}' id='{$id}' value='{$v}' readonly='true' style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
					</a>";
				
				else
					$xs123="<input type='text' width='20px' name='{$k}' id='{$id}' class='bianji' value='{$v}' onblur=''  style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
					<i class='fa fa-pencil' aria-hidden='true'>	</i>";
				$table.="<td name='$k'>
					$xs123
				
		
				</td>";
			}
			$table.="</tr>";
			
			
		}


		$this->assign('table',$table);


		$this->assign('kehu',$a_arr);
        $this->display();
    }


		public function add(){
		    $data['kh_data']=$_GET['id'];
		    	$a_arr=json_decode( $data['kh_data'],true);
	
			$shi=M('kh');
			$sql=$shi->add($data);

				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$shi->where($data)->field('kh_id')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$id['kh_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了客户".$a_arr['zdy0'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'
			if($sql){
				echo "ok";
			
			}else{
				echo "no";
		     
		    }

}
 


		public function index(){//这才是修改

			$bianji_id['kh_id']= $_GET['bianji_id'];//81

			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('kh'); 

		if($sql=='zdy'){
			$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="2";
 				$yw_cs['zd_yh']=1;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
				foreach($sql_json as $k=>$v){
					if($v['id']==$bianji_name){
						$name_rz=$v['name'];
					}
				}                                    //获取完了
				$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field('kh_data')->find();
				$sql_json_rz=json_decode($kh_old_val['kh_data'],true);
				foreach($sql_json_rz as $krz=>$vrz){
					if($krz==$bianji_name){
						$b_rz=$vrz;
					}
				}
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['kh_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$id;//客户名称ID
				$rz_map['rz_bz']="把".$name_rz.'的'.$b_rz."改为".$bianji_val;
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_cz_type']=2;//2代表编辑
				$rz_map['rz_time']=time();
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'

			$sql_bianji=$kehus->where($bianji_id)->find();

			$sql_json=json_decode($sql_bianji['kh_data'],true);

			foreach($sql_json as $kt=>$vt){
				

				if($kt==$bianji_name){
					$sql_json[$kt]=$bianji_val;
					
				}
					 
			}
			$map['kh_id']= $bianji_id['kh_id']; 
			$save_data=$sql_json;

			$a_arr['kh_data']=json_encode($save_data,true);

			$save=$kehus->where($map)->save($a_arr);
			if($save){
				echo "ok";
			}else{
				echo "no";
			}
			


		}else{ 		

				$kehus=M('kh'); 
				$map['kh_id']= $bianji_id['kh_id'];  
				$data[$bianji_name] = $_GET['bianji_val']; 

	     //只是为了获取 不能自定义   的中文名字放备注中

				$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");
				foreach($array_jiansuo as $k=>$v){
					if($bianji_name==$k){
						$name_rz=$v;
					}
				}

				//结束
 				                               //获取完了
				$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field($bianji_name)->find();
				
						$b_rz=$kh_old_val[$bianji_name];
				
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['kh_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$id;//客户名称ID
				$rz_map['rz_bz']="把".$name_rz.'的'.$b_rz."改为".$bianji_val;
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_cz_type']=2;//2代表编辑
				$rz_map['rz_time']=time();
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'










				                     //显示客户所需字段data
				$kehu=$kehus->where($map)->save($data);
				if($kehu){
					echo "ok";
				}else{
					echo "no";
				}
		}

	 	
		}







		public function jb_bianji(){//测试
			$kehu=M('kh');                             //显示客户所需字段data
			$kehu=$kehu->select();
			//echo"<pre>";

			foreach($kehu as $k=>$v){
				$nachu[$k]=json_decode($v['kh_data'],true);
			}
		
			foreach($nachu as $k=>$v){
			 			foreach($v as $k1=>$v1){
			 				foreach ($ywcs_sql_json as $key=>$val){		 				
			 					if($k1==$val['id']){
			 						$v[$k1]=$val[$v1];						
			 					} 		 					
			 				}
			 			}
			 			$guanlianw[]=$v;
			 		}
	 				

		foreach($kehu as $k=>$val){
			$valav=array_merge($guanlianw[$k],$val);
			$dantiao=$valav['kh_id'];//获取到id
			unset($valav['kh_id']); 
			unset($valav['kh_data']); 
			array_unshift($valav,$dantiao); //整理好的单条信息
			
				$ronghe[]=$valav;	 //多条融合	
		}
	
		foreach($ronghe as $r_k=>$r_v)
		{
			$table.="<tr id='tr".$r_v['0']."'>";
			foreach($r_v as $k=>$v)
			{//echo "<pre>";
			//	var_dump($r_v);exit;

				$a_fuzeren=$r_v['fuzeren'];

		$id=$r_v['0'];
		//var_dump($k);exit;
		//echo "<pre>";
		//	var_dump($r_v['0']);exit;
				if($k=='zdy0')
					$xs123="<a href='kehumingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/kh_id/$id'><input type='text' width='20px' name='{$k}' id='{$id}' value='{$v}' readonly='true' style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
					</a>";
				
				else
					$xs123="<input type='text' width='20px' name='{$k}' id='{$id}' class='bianji' value='{$v}' onblur=''  style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
					<i class='fa fa-pencil' aria-hidden='true'>	</i>";
				$table.="<td name='$k'>
					$xs123
				
		
				</td>";
			}
			$table.="</tr>";
			
			
		}

					$hidden=json_encode($ronghe,true);
					

					echo $table;
					



		}
		public function shaixuan(){

				$kehu=M('kh');                             //显示客户所需字段data
						$kehu=$kehu->select();
						//echo"<pre>";

						foreach($kehu as $k=>$v){
							$nachu[$k]=json_decode($v['kh_data'],true);
						}
					
						foreach($nachu as $k=>$v){
						 			foreach($v as $k1=>$v1){
						 				foreach ($ywcs_sql_json as $key=>$val){		 				
						 					if($k1==$val['id']){
						 						$v[$k1]=$val[$v1];						
						 					} 		 					
						 				}
						 			}
						 			$guanlianw[]=$v;
						 		}

					foreach($kehu as $k=>$val){
						$valav=array_merge($guanlianw[$k],$val);
							echo "<pre>";
							print_r($k);exit;
						$dantiao=$valav['kh_id'];//获取到id
						unset($valav['kh_id']); 
						unset($valav['kh_data']); 
						array_unshift($valav,$dantiao); //整理好的单条信息
						
							$ronghe[]=$valav;	 //多条融合	
					}
				//echo "<pre>";
				//print_r($ronghe);exit;

		}
		public function kehumingcheng(){
			$a_id=$_GET['id'];//客户名称
			$kh_id=$_GET['kh_id'];//客户ID=$_GET['kh_id'];//客户ID
			$fuzeren=$_GET['fuzeren'];
			$id=$_GET['id1'];//客户名称ID
			$this->assign('kh_id',$kh_id);//这里是添加附件的ID渲染到模板
			$kh=M('kh');
			$kh_map['kh_id']=$kh_id;
			$sql_kh=$kh->where($kh_map)->field('kh_data')->find();
			$sql_json=json_decode($sql_kh['kh_data'],true);
			$kh_type=$sql_json['zdy1'];//客户类型canshu1
			$kh_phone=$sql_json['zdy2'];//客户电话

			
			$ywcs=M('ywcs');                 //获取ywcs表中的 数据
	 		$yw_cs['ywcs_yw']="2";
	 		$yw_cs['ywcs_yh']=1;
	 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
	 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
	 		foreach($ywcs_sql_json as $k=>$v){
	 			if($v['id']=='zdy1'){
	 				$kh_type2=$v[$kh_type];
	 			}
	 		}

	 		$this->assign('kh_phone',$kh_phone);//客户电话
	 		$this->assign('kh_type2',$kh_type2);//客户类型
			
	 		//写跟进查询
	 		$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 		$rz_map['rz_mode']=2;//这个是模块ID也是死的
			$rz_map['rz_object']=$kh_id;//客户名称ID
			$rz_sql=$rz->where(array($rz_map))->field('rz_bz,rz_time,rz_user')->order("rz_time desc")->select();//查询出日志记录、
//echo "<pre>";
//var_dump($rz_sql);exit;

			$rz_caozuo=$rz->where(array($rz_map))->field('rz_id,rz_type,rz_mode,rz_user,rz_object,rz_bz,rz_time')->order("rz_time desc")->select();//操作日志


			
			$rz_user=M('user');
			$user_sql=$rz_user->field('user_id,user_name')->select();
			$kh_map1['user_id']=$fuzeren;
			$kh_name=$rz_user->where($kh_map1)->field("user_name")->find();
			
			foreach($rz_sql as $k=>$v){//跟进循环的数据
				foreach($user_sql as $k1 =>$v1){
					if($v['rz_user']==$v1['user_id'])
					{
						$v['rz_user']= $v1['user_name'];
						$v['rz_time']=date("Y-m-d H:i:s",$v['rz_time']);

					}
				}
				$ko[]=$v;  //显示跟进记录  操作数据的
			}
				$xiegenjin_base=M('xiegenjin');//查询写跟进记录
				$map_xiegenjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$map_xiegenjin['mode_id']=2;
				$map_xiegenjin['kh_id']=$id;
				$sql_xiegenjin=$xiegenjin_base->where($map_xiegenjin)->field('user_id,type,content,date')->select();
				foreach($sql_xiegenjin as $k=>$v)
				{
					foreach($user_sql as $k1 =>$v1)
					{
						if($v['user_id']==$v1['user_id'])
						{
							$v['user_id']= $v1['user_name'];
							$v['date']=date("Y-m-d H:i:s",$v['date']);
						}
					}
					$ko[]=$v;         //表操作的和写的跟进融合在一起 
				}
				



foreach($ko as $k=>$v)
{
	if($v['date']!='')
	{
		$ko[$k]['rz_time']=$v['date'];
		unset($ko[$k]["date"]);
	}
	$ko[$ko[$k]['rz_time']]=$ko[$k];
	unset($ko[$k]);
}
//echo "<pre>";
//var_dump($ko);exit;
krsort($ko);

			foreach($rz_caozuo as $k=>$v){//跟进循环的数据
				foreach($user_sql as $k1 =>$v1){
					if($v['rz_user']==$v1['user_id'])
					{
						$v['rz_user']= $v1['user_name'];
						$v['rz_time']=date("Y-m-d H:i:s",$v['rz_time']);
						
					}
				}
				$koo[]=$v;//操作日志
			}

		//客户资料标题开始
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kehuziliao=M('yewuziduan');
		$yewuziduan['zd_yewu']="2";
		$yewuziduan['zd_yh']=$fid;
		$sql_ywzd=$kehuziliao->where($yewuziduan)->find();
		$ywzd_json=json_decode($sql_ywzd['zd_data'],true);

		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");

		foreach($array_jiansuo as $k3=>$v3){
			$guiding['id']=$k3;
			$guiding['name']=$v3;
			$guiding['type']=9;
			$guidingend[]=$guiding;//自定义 的键值
		}
		//echo "<pre>";
		//var_dump($guidingend);exit;
		//$ywzd_json=array_marge($ywzd_json,$guidingend);
		foreach($ywzd_json as $k=>$v){
			
				
				if ($v['qy']==1){
					$ywcs_get['id']=$v['id'];
					$ywcs_get['name']=$v['name'];
					$ywcs_get['type']=$v['type'];
				}
				$end_ywcs[]=$ywcs_get;
				
			unset($ywcs_get); 
			
		}
		foreach($guidingend as $k=>$v){
			$end_ywcs[]=$v;
		}
		
		//客户信息
		$kh_ziliao=M('kh');
		$map_kh['kh_id']=$id;
		$sql_kh=$kh_ziliao->where($map_kh)->find();
		$sql_kh_json=json_decode($sql_kh['kh_data'],true);
		$valav=array_merge($sql_kh_json,$sql_kh);
		$kh_id=$valav['kh_id'];
		unset($valav['kh_id']); 
		unset($valav['kh_data']); 
		array_unshift($valav,$kh_id);//单挑查询完

		//查询关联字段
		$ywcs_base=M('ywcs');
		$ywcs_map['ywcs_yw']=2;
		$ywcs_map['ywcs_yh']=1;
		$ywcs_sql=$ywcs_base->where($ywcs_map)->field('ywcs_data')->find();
		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
		foreach($ywcs_sql_json as $k6 =>$v6)
		{
			if($v6['id']=="zdy9")
			{
				$dan_ywcs=$v6;
			}
		}

		foreach($dan_ywcs['qy'] as $k7 =>$v7){
			foreach($dan_ywcs as $k8=>$v8){
				if($k8=='id'){
					$xin_dan['id']=$v8;
				}
				if($v7==1&& $k7==$k8)
				{	

					$xin_dan[$k7]=$v8;
				} 

			}
		}
		foreach($valav as $k => $v){

			foreach($ywcs_sql_json as $k1=>$v1){
				//echo $k;
				//echo $k1;exit;
				if($k==$v1['id']){

					$valav[$k]=$v1[$v];
				}
			}

		}//把关联信息替换
		$this->assign('dan_ywcs',$xin_dan);//弹窗 弹跳的跟进状态
		$this->assign('valav',$valav);//写跟进弹出框
		//var_dump($valav);exit;
			$tabl='';
			
			//echo"<pre>";
			//var_dump($end_ywcs);exit;
			foreach($end_ywcs as $k=>$v)
			{
				if($v['type']==0)
				$tabl.='<tr><td>'.$v['name'].':</td><td>1<input type="text" id="'.$kh_id.'" name="'.$v['id'].'" class="ziliao_right" value="'.$valav[$v["id"]].'"   onblur=""><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				else if($v['type']==1){
					$tabl.='<tr><td>'.$v['name'].':</td><td>2<input type="text" id="'.$v['id'].'" class="ziliao_right" value="'.$valav[$v['id']].'"><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				}else if($v['type']==2){
					$tabl.='<tr><td>'.$v['name'].':</td><td>3<input type="text" id="'.$v['id'].'"  value="'.$valav[$v['id']].'" class="text ui-widget-content ui-corner-all ziliao_right" onfocus="WdatePicker({dateFmt:\'yyyy-M-d H:mm:ss\'})"><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				}else if($v['type']==3){
						foreach ($ywcs_sql_json as $k3 =>$v3)
						{
							if($v["id"]==$v3['id'])
							{
								foreach($v3 as $k4=>$v4)
								{
									
									if($valav[$v["id"]]==$v4)
									{

										$ss="selected";
									}
									else
									{
										$ss="";
									}
									if(substr($v4,0,3)!='zdy'&& $k4 != 'qy')
									{
										$aaa.='<option value="" '.$ss.' >'.$v4.'</option>';
									}
								}
							}			
						}
					$tabl.='<tr><td>'.$v['name'].':</td><td>4 <select id="'.$v['id'].'" class="ziliao_right1">
														
																
																'.$aaa.'
																
																
																
															 </select>
					<i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
					unset($aaa);
				}else if($v['type']==9){
					$tabl.='<tr><td>'.$v['name'].':</td><td><input type="text" id="'.$v['id'].'" readonly="readonly" class="ziliao_right" value="'.$valav[$v['id']].'"></td></tr>';
				}
			}
		$this->assign("data_kh",$table1);
	//echo $tabl;exit;
		$this->assign("biaoti_ywzd",$tabl);
	
			$this->assign('rz_caozuo',$koo);
			
			$this->assign('genjin',$ko);
			
		
			$sql=M('file');
			$sql_select=$sql->select();
			$this->assign('sql',$sql_select);
			$this->assign('a_id',$a_id);
			$this->assign('fuzeren',$kh_name);//上面是 客户全景  和附件


			
			$hetong=M('ywcs');
			$map_ywcs_ht['ywcs_yw']="6";
			$ht_ywcs=$hetong->where($map_ywcs_ht)->field('ywcs_data')->find();
			$ht_json_ywcs=json_decode($ht_ywcs['ywcs_data'],true);
			//echo "<pre>";
		//var_dump($ht_json_ywcs);exit;

			$hetong=M('hetong');
				$tiaojian='"zdy1":"'.$id.'"';
				
			$sql_hetong=$hetong->query("select * from crm_hetong where ht_data like '%$tiaojian%'");
			//echo "<pre>";
		//var_dump($sql_hetong);exit;
		$number=0;
			foreach($sql_hetong as $k=>$v){

					$sql_json_htong=json_decode($v['ht_data'],true);
					
					$number=$number+$sql_json_htong['zdy3'];
					$ht_end[]=$sql_json_htong;
			}
			$this->assign('number',$number);//合同总金额
			foreach($ht_end as $k1=>$v1){
				foreach($ht_json_ywcs as $k2=>$v2){
					if('zdy7'==$v2['id']){
						$v1['zdy7']=$v2[$v1['zdy7']];

					}
				}
				$hetong_end1[]=$v1;
			}
			
			$this->assign('ht_end',$hetong_end1);
			//echo "<pre>";0,3,5,6,7,17
			//var_dump($ht_end);exit;
			$this->display();
		}
		public function delete(){

			$sql['id']=$_GET['id'];
			
			 $sql_delete=M('file');
       		
       		

       			//删除增加日志
       		 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            	$fujian=$sql_delete->where($sql)->field('name_id,fujian_name')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$fujian['name_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="删除了附件:".$fujian['fujian_name'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'


				$sql_file_select=$sql_delete->where($sql)->delete();

       		if($sql_file_select){
				$sql=M('file');
				$sql_select=$sql->field('id,sc_data,fujian_name,big,beizhu')->select();

		foreach($sql_select as $k=>$v)
					{
						$id=$v['id'];
						
						
			$table.="<tr>";
					foreach($v as $k_a=>$v_a)
						
					{
						
						$table.="<td name='$k'>


						{$v_a}

								
						</td>";
					}
					$table.="<td>预览|<span class='del' id=$id>删除</span></td></tr>";
					
				}
					

					echo $table;

			}
		}
		public function upload(){


				$kh_id=$_GET['id'];
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
 
    			 $data['name_id']=$kh_id;
    			 $data['sc_data']= date("Y-m-d h:i:s");
    			 $data['fujian_name']=$save_oldname;
    			 $data['lujing']=$save_name;
    			 $data['big']=$sql;
       			 $data['beizhu']=$_POST['wenbenyu'];
 


       			 		//x新增附件时记录日志
       			 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$kh_id;//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了附件:".$data['fujian_name'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'




       			 $sql_file=M('file');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	//$this->success("上传成功");
       			 	echo '<script>alert("上传成功");window.location="'.$_GET['root_dir'].'/index.php/Home/Kehu/kehumingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/kh_id/'.$_GET['kh_id'].'"</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	


}
		public function bianji_ziliao(){
			$bianji_id['kh_id']= $_GET['aid'];//81
			$bianji_name= $_GET['name'];//zdy2  fuzeren
			$bianji_val= $_GET['val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('kh'); 
			if($sql=='zdy')
			{
				$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="2";
 				$yw_cs['zd_yh']=1;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
					foreach($sql_json as $k=>$v)
					{
						if($v['id']==$bianji_name)
						{
							$name_rz=$v['name'];
						}
					}                                    //获取完了
					$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
					$kh_old_val=$kehus->where(array($map_rz))->field('kh_data')->find();
					$sql_json_rz=json_decode($kh_old_val['kh_data'],true);
					foreach($sql_json_rz as $krz=>$vrz)
					{
						if($krz==$bianji_name)
						{
							$b_rz=$vrz;
						}
					}
					$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
	           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
	            	$addressArr=getCity($nowip);//登录地点
	            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
			   		$id=$bianji_id['kh_id'];	
			   		$rz=M('rz');
			 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
			 		$rz_map['rz_mode']=2;
			 		$rz_map['rz_object']=$id;//客户名称ID
					$rz_map['rz_bz']="把".$name_rz.'的'.$b_rz."改为".$bianji_val;
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_cz_type']=2;//2代表编辑
					$rz_map['rz_time']=time();
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					$sql_bianji=$kehus->where($bianji_id)->find();
					$sql_json=json_decode($sql_bianji['kh_data'],true);
					foreach($sql_json as $kt=>$vt)
					{
						if($kt==$bianji_name)
						{
							$sql_json[$kt]=$bianji_val;	
						}
					 
					}
					$map['kh_id']= $bianji_id['kh_id']; 
					$save_data=$sql_json;
					$a_arr['kh_data']=json_encode($save_data,true);
					$save=$kehus->where($map)->save($a_arr);
					if($save)
					{
						echo "ok";
					}else
					{
						echo "no";
					}
			}
    
		}

		public function genjin_bianji(){
			$genjin['mode_id']=2;
			$genjin['kh_id']=$_POST['kh_id'];
			$genjin['user_id']=cookie('user_id');
			$genjin['type']=$_POST['fangshi'];
			$genjin['content']=$_POST['wenbenyu'];
			$genjin['date']=time();
			$genjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');;
			$genjin_base=M('xiegenjin');
			$sql_add=$genjin_base->add($genjin);
			if($sql_add){

				echo '<script>alert("添加成功");window.location="'.$_GET['root_dir'].'/index.php/Home/Kehu/kehumingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/kh_id/'.$_GET['kh_id'].'"</script>';
				
			}else{
echo "添加失败";
			}
		
		}

}