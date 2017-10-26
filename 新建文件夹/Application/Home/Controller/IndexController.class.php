<?php
namespace Home\Controller;
use Think\Controller;


class IndexController extends Controller {
    public function index(){
        if(cookie("islogin")!='1')
        {
            echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
        }
        $this->display();
    }
    //安全退出
    public function tuichu()
    {
        cookie("islogin",0);
        echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
    }

}
