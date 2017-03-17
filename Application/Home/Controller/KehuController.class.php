<?php
namespace Home\Controller;
use Think\Controller;


class KehuController extends Controller {
    public function kehu(){

  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="客户";
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
 		$yw_cs['ywcs_yw']="客户";
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
			{
		$id=$r_v['0'];
		//var_dump($k);exit;
		//echo "<pre>";
		//	var_dump($r_v['0']);exit;
				if($k=='zdy0')
					$xs123="<a href='kehumingcheng'><input type='text' width='20px' name='{$k}' id='{$id}' value='{$v}' readonly='true' style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
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
			$shi=M('kh');
			$sql=$shi->add($data);
			if($sql){
				echo "ok";
		
			}else{
				echo "no";
		}
		       
		    }


 


		public function index(){//测试
			$bianji_id['kh_id']= $_GET['bianji_id'];//81

			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);

			
			
		$kehus=M('kh'); 


		if($sql=='zdy'){
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
				$data[$bianji_name] = $_GET['bianji_val'];                      //显示客户所需字段data
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
				echo "<pre>";
				print_r($ronghe);exit;

		}
		public function kehumingcheng(){
			$sql=M('file');
			$sql_select=$sql->select();
			$this->assign('sql',$sql_select);
			$this->display();
		}
		public function delete(){
			$sql['id']=$_GET['id'];
			 $sql_delete=M('file');
       		$sql_file_select=$sql_delete->where($sql)->delete();
       		if($sql_file_select){
       				$this->success("删除成功",U('Kehu/kehumingcheng'));
       		}else{
       			 	$this->error("删除失败");
       			 }
		}
		public function upload(){
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
    							}
    			 $data['name_id']=12;
    			 $data['sc_data']= date("Y-m-d h:i:s");
    			 $data['fujian_name']=$save_oldname;
    			 $data['lujing']=$save_name;
    			 $data['big']=$sql;
       			 $data['beizhu']=$_POST['wenbenyu'];
       			 
       			 $sql_file=M('file');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	$this->success("上传成功",U('Kehu/kehumingcheng'));
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	



    
}
