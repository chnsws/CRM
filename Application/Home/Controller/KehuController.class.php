<?php
namespace Home\Controller;
use Think\Controller;


class KehuController extends Controller {
    public function kehu(){

  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="客户";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->select();
  		$json=$sql['0']["zd_data"];
  		$a_arr=json_decode($json,true);
  		$need=array();
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
		//$ronghe=array($nachu);
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




 $a= array("zdy0","zdy1","zdy2","zdy3","zdy4" );
 
echo "<pre>";
var_dump($a);exit;


		$this->assign('list',$jianzhi);
		$this->assign('kh_xinxi',$ronghe);
		$this->assign('kehu',$need);
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
