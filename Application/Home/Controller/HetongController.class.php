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
			$table.="<tr>";
			foreach($r_v as $k=>$v)
			{
		$id=$r_v['0'];
				
				$table.="<td name='$k'>



					<input type='text' width='20px' name='{$k}' id='{$id}' class='bianji' value='{$v}' onblur=''  style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
					<i class='fa fa-pencil' aria-hidden='true'>	</i>

						
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
			$shi=M('hetong');
			$sql=$shi->add($data);
			if($sql){
				echo "ok";
		
			}else{
				echo "no";
		}
		       
		    }





		public function index(){//测试
			$bianji_id['ht_id']= $_GET['bianji_id'];//81

			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);

			
			
		$kehus=M('hetong'); 


		if($sql=='zdy'){
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
					$table.="<tr>";
					foreach($r_v as $k=>$v)
					{
				$id=$r_v['0'];
						
						$table.="<td name='$k'>



							<input type='text' width='20px' name='{$k}' id='{$id}' class='bianji' value='{$v}' onblur=''  style='border-left:0px;border-top:0px;border-right:0px;border-bottom:1px '>
							<i class='fa fa-pencil' aria-hidden='true'>	</i>

								
						</td>";
					}
					$table.="</tr>";
					
				}

					echo $table;
		



		}

    
}