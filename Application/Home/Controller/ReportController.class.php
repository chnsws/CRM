<?php
namespace Home\Controller;
use Think\Controller;
class ReportController extends Controller {
    //首页默认显示跟进记录的报表，并且是今日的
	public function index()
    {






        //首页默认显示跟进记录的报表
        $this->display();
    }
    public function nav()
    {
        $this->display();
    }
    public function yewuxinzenghuizong()
    {
        $this->display();
    }
    public function yewuxinzenghuizong2()
    {
        $this->display();
    }
}