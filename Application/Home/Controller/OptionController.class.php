<?php
namespace Home\Controller;
use Think\Controller;


class OptionController extends Controller {
	//模板框架
    public function option(){
        $this->display();
    }
    //设置中心
    public function optioncenter(){
		$this->display();
	}
	//部门和用户设置
	public function bumenyonghu(){
		$this->display();
	}
}



