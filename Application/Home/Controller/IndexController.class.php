<?php
namespace Home\Controller;
use Think\Controller;


class IndexController extends Controller {
    public function index(){
        if(cookie("islogin")!='1')
        {
            echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
        }
        $sp_base=M('sp');
        $map['sp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
        $map['sp_jg']=0;
        $map['sp_user']=cookie('user_id');
        $sql_count=$sp_base->where($map)->count();
       // echo "<pre>";
     //   var_dump($sql_count);exit;
        $this->assign("sql_count",$sql_count);
        $this->display();
    }
    //安全退出
    public function tuichu()
    {
        cookie("islogin",0);
        echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
    }

}
