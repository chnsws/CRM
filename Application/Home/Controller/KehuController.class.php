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

  		$need=array($a_arr);
  		//echo"<pre>";
  		//var_dump($need);exit;
		foreach($a_arr as $k=>$v)
		{
			if($v['qy']==1)
			{
			$need[$k]['id']=$v['id'];
			$need[$k]['name']=$v['name'];
			$need[$k]['bt']=$v['bt'];
			}
	
		}

		$kehu=M('kh');                             //显示客户所需字段
		$kehu=$kehu->select();
		$nachu=array();
		foreach($kehu as $k=>$v){
			$nachu[$k]=json_decode($v['kh_data'],true);
		}
		foreach($kehu as $k=>$val){
				array_splice($val,1,1,$nachu[$k]);
				$ronghe[]=$val;	 	
		}
	
		foreach($ronghe as $k=>$v ){               //获取键值用于循环客户信息
			foreach($v as $key=>$val){
				$jianzhi[]=$key;
				
			}
				break;
		}


		$conf=M('config');
		$conf_sql=$conf->field("config_kh_data")->find();
		$conf_sql_json=json_decode($conf_sql['config_kh_data'],true);
        $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="客户";
 		$yw_cs['ywcs_yh']=1;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 
 		foreach($ywcs_sql_json as $ywcs_k=>$ywcs_v){
 			
 			foreach($ywcs_v as $k=>$v){
 				$ywcs_jianzhi[]=$k;
 		
 			}
 			$abc[]=$ywcs_jianzhi;
 			unset($ywcs_jianzhi);
 		}
;
      $sql_peizhi=array();
	   foreach($a_arr as $k=>$v){     //显示配置左边标题头
	   		foreach($conf_sql_json as $key=>$val){
	   			if($v['id']==$val){
	   			$sql_peizhi[]=array('name'=>$v['name'],'id'=>$val,'type'=>$v['type']);
	   			}	
	   		}
	 } 

		$this->assign("ywcs_biao",$ywcs_sql_json);
    	$this->assign('left_conf',$sql_peizhi);
		$this->assign('list',$jianzhi);
		$this->assign('kh_xinxi',$ronghe);
		//echo "<pre>";
		//var_dump($need);exit;
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

    
}
