<?php
namespace Home\Controller;
use Think\Controller;


class HetongController extends Controller {
  public function hetong(){

        $b=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="合同";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$b->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('hetong');                             //显示客户所需字段data
		$kehu=$kehu->select();
		//echo"<pre>";
//var_dump($kehu);exit;
		$conf=M('config');
		$conf_sql=$conf->field("config_ht_data")->find();
		$conf_sql_json=json_decode($conf_sql['config_ht_data'],true);

        $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="合同";
 		$yw_cs['ywcs_yh']=1;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();

 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 
		$nachu=array();
			
		foreach($kehu as $k=>$v){
			$nachu[$k]=json_decode($v['ht_data'],true);
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
 					

		foreach($kehu as $k=>$val){
			$valav=array_merge($guanlianw[$k],$val);
			$dantiao=$valav['ht_id'];//获取到id
			unset($valav['ht_id']); 
			unset($valav['ht_data']); 
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
			{   //echo "<pre>";
				//var_dump($r_v);exit;

				$a_fuzeren=$r_v['fuzeren'];
				$a_a=$r_v['zdy7'];
				$a_b=$r_v['zdy10'];
				$a_c=$r_v['zdy11'];

		$id=$r_v['0'];
		
		//echo "<pre>";
		//var_dump($a_fuzeren);exit;
				if($k=='zdy0')
					$xs123="<a href='hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c'><input type='text' width='20px' name='{$k}' id='{$id}' value='{$v}' readonly='true' style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
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


		$this->assign('hetong',$a_arr);
        $this->display();
    }


		public function add(){
		     $data['ht_data']=$_GET['id'];
		     $a_arr=json_decode( $data['ht_data'],true);
	         
			$shi=M('hetong');
			$sql=$shi->add($data);

				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$shi->where($data)->field('ht_id')->find();

		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
		 		$rz_map['rz_object']=$id['ht_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了合同".$a_arr['zdy0'];
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

			$bianji_id['ht_id']= $_GET['bianji_id'];//81

			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('hetong'); 

		if($sql=='zdy'){
			$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="合同";
 				$yw_cs['zd_yh']=1;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
				foreach($sql_json as $k=>$v){
					if($v['id']==$bianji_name){
						$name_rz=$v['name'];
					}
				}                                    //获取完了
				$map_rz['ht_id']=$bianji_id['ht_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field('ht_data')->find();
				$sql_json_rz=json_decode($kh_old_val['ht_data'],true);
				//var_dump($sql_json_rz);exit;
				foreach($sql_json_rz as $krz=>$vrz){
					if($krz==$bianji_name){
						$b_rz=$vrz;
					}
				}
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['ht_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
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

			$sql_json=json_decode($sql_bianji['ht_data'],true);

			foreach($sql_json as $kt=>$vt){
				

				if($kt==$bianji_name){
					$sql_json[$kt]=$bianji_val;
					
				}
					 
			}
			$map['ht_id']= $bianji_id['ht_id']; 
			$save_data=$sql_json;

			$a_arr['ht_data']=json_encode($save_data,true);

			$save=$kehus->where($map)->save($a_arr);
			if($save){
				echo "ok";
			}else{
				echo "no";
			}
			


		}else{ 		

				$kehus=M('hetong'); 
				$map['ht_id']= $bianji_id['ht_id'];  
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
				$map_rz['ht_id']=$bianji_id['ht_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field($bianji_name)->find();
				
						$b_rz=$kh_old_val[$bianji_name];
				
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['ht_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
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
			$kehu=M('hetong');                             //显示客户所需字段data
			$kehu=$kehu->select();
			//echo"<pre>";

			foreach($kehu as $k=>$v){
				$nachu[$k]=json_decode($v['ht_data'],true);
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
			$dantiao=$valav['ht_id'];//获取到id
			unset($valav['ht_id']); 
			unset($valav['ht_data']); 
			array_unshift($valav,$dantiao); //整理好的单条信息
			
				$ronghe[]=$valav;	 //多条融合	
		}
	
			foreach($ronghe as $r_k=>$r_v)
				{
					$table.="<tr id='tr".$k."'>";
					foreach($r_v as $k=>$v)
					{
				$id=$r_v['0'];
						
						$table.="<td name='$k'>



							<input type='text' width='20px' name='$k' id='$id' class='bianji' value='{$v}' onblur=''  style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
							<i class='fa fa-pencil' aria-hidden='true'>	</i>

								
						</td>";
					}
					$table.="</tr>";
					
				}
					$hidden=json_encode($ronghe,true);
					

					echo $table;
					



		}
		public function shaixuan(){

				$kehu=M('hetong');                             //显示客户所需字段data
						$kehu=$kehu->select();
						//echo"<pre>";

						foreach($kehu as $k=>$v){
							$nachu[$k]=json_decode($v['ht_data'],true);
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
						$dantiao=$valav['ht_id'];//获取到id
						unset($valav['ht_id']); 
						unset($valav['ht_data']); 
						array_unshift($valav,$dantiao); //整理好的单条信息
						
							$ronghe[]=$valav;	 //多条融合	
					}
				//echo "<pre>";
				//print_r($ronghe);exit;

		}
		public function hetongmingcheng(){
			$a_id=$_GET['id'];
			$kh_id['ht_id']=$_GET['ht_id'];
			//echo $kh_id['ht_id'];exit;
			$this->assign('kh_id',$kh_id['ht_id']);
            $ht_id=$_GET['ht_id'];
            
			//var_dump($kh_id);exit;
			$id=$_GET['id1'];
          
			$b_id=M('hetong');
			$c_id=$b_id->where($kh_id)->find();
            $d_id=json_decode($c_id['ht_data'],true);
			//var_dump($d_id);exit; 
			$fuzeren=$_GET['fuzeren'];
			//var_dump($fuzeren);exit;
			$a_a=$_GET['zdy7'];
			$a_b=$_GET['zdy10'];
			$a_c=$_GET['zdy11'];
			$sql=M('file_hetong');
			$sql_select=$sql->select();

			$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 		$rz_map['rz_mode']=6;//这个是模块ID也是死的
			$rz_map['rz_object']=$ht_id;//客户名称ID
			
			$rz_sql=$rz->where(array($rz_map))->field('rz_bz,rz_time,rz_user')->order("rz_time desc")->select();//查询出日志记录、

			$rz_caozuo=$rz->where(array($rz_map))->field('rz_id,rz_type,rz_mode,rz_user,rz_object,rz_bz,rz_time')->order("rz_time desc")->select();//操作日志
            $this->assign('rz_caozuo',$rz_caozuo);
//echo "<pre>";
//var_dump($rz_sql);exit;

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
				$ko[]=$v;
			}
			//echo "<pre>";
			//print_r($ko);exit;
			
			$this->assign('genjin',$ko);
			$this->assign('sql',$sql_select);
            $this->assign('fuzeren',$kh_name);
	        $this->assign('d_id',$d_id);
			$this->assign('sql',$sql_select);
			$this->assign('a_id',$a_id);
			$this->assign('zdy7',$a_a);
			$this->assign('zdy10',$a_b);
			$this->assign('zdy11',$a_c);
			$this->display();
		}
		public function delete(){

			$sql['id']=$_GET['id'];
			
			 $sql_delete=M('file_hetong');
       		
       		

       			//删除增加日志
       		 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            	$fujian=$sql_delete->where($sql)->field('name_id,fujian_name')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
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
				$sql=M('file_hetong');
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
		 		$rz_map['rz_mode']=6;
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




       			 $sql_file=M('file_hetong');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	$this->success("上传成功",U('hetong/hetongmingcheng'));
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	


}
    
}