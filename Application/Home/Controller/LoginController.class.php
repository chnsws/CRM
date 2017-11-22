<?php
namespace Home\Controller;
use Think\Controller;


class LoginController extends DBController {
    public function index(){
        $this->display();
    }
    public function yanzheng(){
        $getname =addslashes($_POST['name']);   //前端页面传过来的用户名
        $getpwd  =addslashes($_POST['pwd']);    //前端页面传过来的md5加密后的密码
        $getcode =strtolower(addslashes($_POST['code']));    //前端页面传过来的验证码
        $jizhu   =addslashes($_POST['jizhu']);  //是否记住账号

        //echo rand(1000,9999);die;
        //echo md5(time().$baseuser[0]['user_id'].rand(1000,9999));die;
        $codeinfo=session("verify_py");//time ,code 
        $secode=strtolower($codeinfo['code']);

        if(($codeinfo['time']+600)<time())
        {
            die("6");//验证码过期
        }
        if($secode!=$getcode)
        {
            
            die("5");//验证码不正确
        }
        
        $userbase=M("user");
        $baseuser=$userbase->query("select * from `crm_user` where user_phone='$getname' and user_pwd_md5='$getpwd' and user_del='0' ");
        if(count($baseuser)>0)//用户名密码验证通过
        {
            //判断该用户的身份是否到期
            if($baseuser[0]['user_youxiaoqi']>=date("Y-m-d",time()))
            {
                //判断该用户是否被冻结
                if($baseuser[0]['user_act']=='0')
                {
                    echo '4';
                    die;
                }
                /*
                    生成token
                    token是当前时间字符串+用户id+随机生成的一个四位数字,md5加密后的一个字符串
                */
                $token=md5(time().$baseuser[0]['user_id'].rand(1000,9999));

                //修改该用户的最后登录时间，浏览器，IP
                $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
                $nowtime=date("Y-m-d H:i:s",time());//当前时间
                $nowip=$_SERVER['REMOTE_ADDR'];//当前登录IP地址
                $userbase->query("update crm_user set user_pwd='$token',user_lastlogintime='$nowtime',user_lastloginbrower='".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."' where user_id='".$baseuser[0][user_id]."'");
                //添加登录日志
                if($baseuser[0]['user_fid']=='0')
                    $fid=$baseuser[0]['user_id'];//获取所属用户（所属公司）
                else 
                    $fid=$baseuser[0]['user_fid'];
                $logtime=time();
                $addressArr=getCity($nowip);
                $address=$addressArr["country"].$addressArr["region"].$addressArr["city"];
                $userbase->query("insert into crm_rz values('','2','0','".$baseuser[0][user_id]."','0','0','0','0','0','0','$nowip','$address','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','".$fid."','".$logtime."')");
                //查询该用户权限
                $userQuanxian=$userbase->query("select * from crm_juesequanxian where qx_id='".$baseuser[0]['user_quanxian']."' limit 1");
                //查询公司名称
                $companybase=M("crm_gongsixinxi");
                $gsxxquery=$companybase->query("select gsxx_name,gsxx_img from crm_gongsixinxi where gsxx_yh='$fid' limit 1");
                $gsname=$gsxxquery[0]['gsxx_name']?$gsxxquery[0]['gsxx_name']:"中软远景CRM系统";
                $gsimg=$gsxxquery[0]['gsxx_img']?'<img src="'.__ROOT__.'Public/head-img/'.$gsxxquery[0]['gsxx_img'].'" />':'';
                cookie("gsname",$gsname,3600*3);
                cookie("gsimg",$gsimg,3600*3);
                //将权限遍历存到cookie中
                foreach($userQuanxian[0] as $qxName=>$qxValue)
                {
                    cookie($qxName,$qxValue,3600*3);
                }
                //将个人信息存入cookie
                foreach($baseuser[0] as $userkey=>$userValue)
                {
                    if($userkey=='user_pwd')
                    {
                        cookie($userkey,$token);
                    }
                    else
                    {
                        cookie($userkey,$userValue,3600*3);
                    }
                }
                //储存登录标识，
                cookie("islogin","1",3600*3);
                //是否记住用户名
                if($jizhu=='1')
                {
                    //setcookie("jizhu",$getname,time()+3600*720);
                }
                else
                {
                    //setcookie("jizhu",'0',time()-3600);
                }
                //登录标识
                $returnstr='1';
            }
            else
            {
                $returnstr='3';
            }
        }
        else
        {
            $returnstr='0';
        }
        //print_r($_COOKIE);
        echo $returnstr;
       
    }
    public function yanzheng2(){
        parent::is_login();
        $getname =addslashes($_POST['name']);   //前端页面传过来的用户名
        $getpwd  =addslashes($_POST['pwd']);    //前端页面传过来的md5加密后的密码
        $userbase=M("user");
        $baseuser=$userbase->query("select * from `crm_user` where user_phone='$getname' and user_pwd_md5='$getpwd' and user_del='0' ");
        if(count($baseuser)>0)//用户名密码验证通过
        {
            $returnstr='1';
        }
        else
        {
            $returnstr='0';
        }
        echo $returnstr;
    }
    
 
}
