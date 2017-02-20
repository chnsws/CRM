<?php
namespace Home\Controller;
use Think\Controller;


class IndexController extends Controller {
    public function index(){
    	$now_dir='aaa';
        $this->display();
    }

 public function add(){
    	$data['data']=$_GET['id'];
$shi=M('kh');
$sql=$shi->add($data);
if($sql){
	echo "1";

}else{
	echo "2";
}
        $this->display();
    }

  
}
