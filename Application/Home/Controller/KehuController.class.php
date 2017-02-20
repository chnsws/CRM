<?php
namespace Home\Controller;
use Think\Controller;


class KehuController extends Controller {
    public function kehu(){
  		$a=M('yewuziduan');
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
		$this->assign('kehu',$need);
        $this->display();
    }


    
}
