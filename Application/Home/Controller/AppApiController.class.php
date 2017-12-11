<?php
namespace Home\Controller;
use Think\Controller;


class AppApiController extends AppPublicController {
    protected $pagesize=20;
    public function index(){
        echo "error";
    }
    public function getlist()
    {
        //parent::rr(getallheaders());
        /*
        1:线索
        2:客户
        3:客户公海
        4:联系人
        5:商机
        6:合同
        7:产品
        8:审批
        ....
        */
    }
    public function login()
    {
        $username=addslashes($_POST['username']);
        $userpwd=addslashes($_POST['md5pwd']);
        if($username==''||$userpwd=='')
        {
            parent::errorreturn("3");
        }
        
        $userbase=M("user");
        $baseuser=$userbase->query("select * from `crm_user` where user_phone='$username' and user_pwd_md5='$userpwd' and user_del='0' ");
        if(count($baseuser)>0)//用户名密码验证通过
        {
            
            //判断该用户是否被冻结
            if($baseuser[0]['user_act']=='0')
            {
                parent::errorreturn("2");
            }
            /*
                生成token
                token是当前时间字符串+用户id+随机生成的一个四位数字,md5加密后的一个字符串
            */
            $token=md5(time().$baseuser[0]['user_id'].rand(1000,9999));

            //修改该用户的最后登录时间，浏览器，IP
            $sysbroinfo=parent::getSysBro();//一维数组 sys->系统 bro->浏览器
            $nowtime=date("Y-m-d H:i:s",time());//当前时间
            $nowip=$_SERVER['REMOTE_ADDR'];//当前登录IP地址
            $userbase->query("update crm_user set user_pwd='$token',user_lastlogintime='$nowtime',user_lastloginbrower='".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."' where user_id='".$baseuser[0]['user_id']."'");
            //添加登录日志
            if($baseuser[0]['user_fid']=='0')
                $fid=$baseuser[0]['user_id'];//获取所属用户（所属公司）
            else 
                $fid=$baseuser[0]['user_fid'];
            $logtime=time();
            $addressArr=parent::getCity($nowip);
            $address=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            $userbase->query("insert into crm_rz values('','2','0','".$baseuser[0]['user_id']."','0','0','0','0','0','0','$nowip','$address','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','".$fid."','".$logtime."')");
            
            
            
            /*
            //查询该用户权限,用于展示主页模块
            $userQuanxian=$userbase->query("select * from crm_juesequanxian where qx_id='".$baseuser[0]['user_quanxian']."' limit 1");
            
            $data['qx']=$userQuanxian[0];
            $data['token']=$token;

            $res['code']=0;
            $res['data']=$data;
            */

            $res['code']=0;
            $res['token']=$token;
            echo json_encode($res);
            die;
        }
        else
        {
            parent::errorreturn("1");
        }
    }
    //通过用户的权限id获得用户的权限
    public function getUserQx($qxid)
    {
        $m=M();
        $userQuanxian=$m->query("select * from crm_juesequanxian where qx_id='".$qxid."' limit 1");
        return $userQuanxian[0];
    }
    /*判断是否登录，如果登录则返回登录用户的user信息*/
    public function isLogin($userphone,$token)
    {
        $m=M();
        $q=$m->query("select * from crm_user where user_phone='$userphone' and user_pwd='$token' limit 1");
        if(!count($q))
        {
            parent::errorreturn("3");
        }
        else
        {
            return $q[0];
        }
    }

    //首页数据
    public function getMain()
    {
        $header=getallheaders();
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            parent::errorreturn("3");
        }
        //用户信息
        $userinfo=$this->isLogin($userphone,$token);
        //用户权限
        $userqx=$this->getUserQx($userinfo['user_quanxian']);

        $res['code']='0';
        $res['data']=$userqx;

        echo json_encode($res);
    }

    //模块列表数据获取
    public function getListData()
    {
        $header=getallheaders();
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            parent::errorreturn("3");
        }

        //当前请求的模块
        $openmod=addslashes($header['openmod']);
        //当前页
        $pagenum=addslashes($header['pagenum'])?addslashes($header['pagenum']):'1';

        //用户信息
        $userinfo=$this->isLogin($userphone,$token);
        //验证权限
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }

        /*
            登录通过，权限通过。就开始查询数据
        */

        if($userinfo['user_fid']==0)
        {
            $userinfo['admin']=1;
            $userinfo['fid']=$userinfo['user_id'];
        }
        else
        {
            $userinfo['admin']=0;
            $userinfo['fid']=$userinfo['user_fid'];
        }

        $nowlimit=($pagenum-1)*$this->pagesize;
        $listcontroller=A("AppList");
        //查询分发
        if($openmod=='xiansuo')
        {
            $listcontroller->xiansuolist($userinfo,$nowlimit);
        }
        else if($openmod=='kehu')
        {
            $listcontroller->kehulist($userinfo,$nowlimit);
        }
        else if($openmod=='kehugonghai')
        {
            $listcontroller->kehugonghailist($userinfo,$nowlimit);
        }
        else if($openmod=='lianxiren')
        {
            $listcontroller->lianxirenlist($userinfo,$nowlimit);
        }
        else if($openmod=='shangji')
        {
            $listcontroller->shangjilist($userinfo,$nowlimit);
        }
        else if($openmod=='hetong')
        {
            $listcontroller->hetonglist($userinfo,$nowlimit);
        }
        else if($openmod=='chanpin')
        {
            $listcontroller->chanpinlist($userinfo,$nowlimit);
        }
        else
        {
            parent::errorreturn("5");
        }



    }
    //用户模块权限判断
    private function have_qx($qxid,$qxname)
    {
        $m=M();
        $userQuanxian=$m->query("select * from crm_juesequanxian where qx_id='".$qxid."' limit 1");
        return $userQuanxian[0][$qxname];
    }
    protected function modindex($mod)
    {
        $arr=array(
            "xiansuo"       =>"1",
            "kehu"          =>"2",
            "kehugonghai"   =>"3",
            "lianxiren"     =>"4",
            "shangji"       =>"5",
            "hetong"        =>"6",
            "chanpin"       =>"7"
        );
        return $arr[$mod];
    }
    protected function modopenqxname($mod)
    {
        $arr=array(
            "xiansuo"       =>"qx_xs_open",
            "kehu"          =>"qx_kh_open",
            "kehugonghai"   =>"qx_khgh_open",
            "lianxiren"     =>"qx_lxr_open",
            "shangji"       =>"qx_sj_open",
            "hetong"        =>"qx_ht_open",
            "chanpin"       =>"qx_cp_open"
        );
        return $arr[$mod];
    }

    public function getInfoData()
    {
        $header=getallheaders();
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            parent::errorreturn("3");
        }

        //当前请求的模块
        $openmod=addslashes($header['openmod']);
        

        //用户信息
        $userinfo=$this->isLogin($userphone,$token);
        //验证权限
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        $infoid=addslashes($header['infoid']);

        /*
            登录通过，权限通过。就开始查询数据
        */

        if($userinfo['user_fid']==0)
        {
            $userinfo['admin']=1;
            $userinfo['fid']=$userinfo['user_id'];
        }
        else
        {
            $userinfo['admin']=0;
            $userinfo['fid']=$userinfo['user_fid'];
        }

        
        $infocontroller=A("AppInfo");
        //查询分发
        if($openmod=='xiansuo')
        {
            $infocontroller->xiansuoinfo($userinfo,$infoid);
        }
        else if($openmod=='kehu')
        {
            $infocontroller->kehuinfo($userinfo,$infoid);
        }
        else if($openmod=='kehugonghai')
        {
            $infocontroller->kehugonghaiinfo($userinfo,$infoid);
        }
        else if($openmod=='lianxiren')
        {
            $infocontroller->lianxireninfo($userinfo,$infoid);
        }
        else if($openmod=='shangji')
        {
            $infocontroller->shangjiinfo($userinfo,$infoid);
        }
        else if($openmod=='hetong')
        {
            $infocontroller->hetonginfo($userinfo,$infoid);
        }
        else if($openmod=='chanpin')
        {
            $infocontroller->chanpininfo($userinfo,$infoid);
        }
        else
        {
            parent::errorreturn("5");
        }
    }
    public function test()
    {
        $m=M();
        //echo "select xs_id,xs_data from crm_xiansuo where xs_yh='3' and xs_is_del='0' order by xs_create_time desc limit 1,$this->pagesize ";die;
        $q=$m->query("select ywcs_data from crm_ywcs where ywcs_yh='3' and ywcs_yw='1' limit 1");
        $json=json_decode($q[0]['ywcs_data'],true);
        
        $csdata=array();
        foreach($json as $k=>$v)
        {
            foreach($v as $kk=>$vv)
            {
                if(substr($kk,0,6)!='canshu')
                {
                    continue;
                }
                if($v['qy'][$kk]!='1')
                {
                    continue;
                }
                $csdata[$v['id']][$kk]=$vv;
            }
        }
        parent::rr($csdata);
    }

}