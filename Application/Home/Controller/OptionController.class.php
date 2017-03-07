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
	//角色和权限设置
	public function juesequanxian(){
		$this->display();
	}
	//公司信息设置
	public function companyinfo(){
		$this->display();
	}
	//公告管理
	public function gonggaoguanli(){
		$this->display();
	}
	//业绩目标
	public function yejimubiao(){
		$this->display();
	}
	//工作报告
	public function gongzuobaogao(){
		$this->display();
	}
	//自定义业务字段
	public function zdyyw_ziduan(){
		$this->display();
	}
	//自定义业务参数
	public function zdyyw_canshu(){
		$this->display();
	}
	//自定审批
	public function shenpi(){
		$this->display();
	}
	//日志
	public function rizhi(){
		$this->display();
	}
}



