<?php
namespace Home\Controller;
use Think\Controller;


class IndexController extends Controller {
    public function index(){
    	$now_dir='aaa';
        $this->display();
    }


    public function kehu(){//客户页面

        $this->display();
    }
}
