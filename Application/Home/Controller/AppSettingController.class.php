<?php
namespace Home\Controller;
use Think\Controller;


class AppSettingController extends AppPublicController {
    public function index(){
        echo "error";
    }
    public function settingList()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        $fid=$userinfo['fid'];

        /*
            用户设置主页的一些信息获取
        */
        $res['code']='0';
        $res['data']['push']=$userinfo['a_push_act'];

        die(json_encode($res));

    }
    public function changePushSet()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        $fid=$userinfo['fid'];

        $act=addslashes($header['act']);

        if($act=='')
        {
            parent::errorreturn("-1");
        }

        $m=M();
        $aid=$userinfo['a_id'];
        $m->query("update crm_app_user_info set a_push_act='$act' where a_id='$aid' limit 1");

        $r['code']='0';
        die(json_encode($r));
    }
}