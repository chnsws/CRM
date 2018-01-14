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
    public function loginAuto()
    {
        $header=getallheaders();
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            parent::errorreturn("3");
        }
        $this->isLogin($userphone,$token);//这里判断是否登录，原方法是获取用户信息的，因为该方法中如果判断没有登录就自动停止运行的机制，所以可以在这里判断是否已经登录，如果没有登录程序就会自动停止运行
        //如果登录了，就返回已登录的信息
        $r['code']='0';
        echo json_encode($r);
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

        $nowlimit=addslashes($header['pagenum'])=='select'?'':($pagenum-1)*$this->pagesize;
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
            $flid=addslashes($header['flid']);
            $listcontroller->chanpinlist($userinfo,$nowlimit,$flid);
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
    //新增
    public function getAddList()
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
        //parent::rr($openmod);
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        /*
            身份验证通过
        */
        
        /*
            设置字段的整体配置
            1:纯文本
            2:下拉框，关联参数
            3：地区
            4：日期时间
            5：人员下拉框
            6：跳转页面选择
        */
        $fieldsOption=array(
            "1"=>array(
                "zdy14"=>"2",//跟进状态
                "zdy15"=>"2",//线索来源
                "zdy16"=>"4",//下次跟进时间
                "zdy11"=>"3"//地区
            ),
            "2"=>array(
                "zdy1"=>"2",//客户类型
                "zdy9"=>"2",//跟进状态
                "zdy12"=>"2",//人员规模
                "zdy10"=>"2",//客户来源
                "zdy11"=>"2",//所属行业
                "zdy6"=>"3",//地区
                "zdy13"=>"4",//下次跟进时间
                "zdy15"=>"6"//甲方联系人
            ),
            "3"=>array(
                "zdy1"=>"2",//客户类型
                "zdy9"=>"2",//跟进状态
                "zdy12"=>"2",//人员规模
                "zdy10"=>"2",//客户来源
                "zdy11"=>"2",//所属行业
                "zdy6"=>"3",//地区
                "zdy13"=>"4",//下次跟进时间
                "zdy15"=>"6"//甲方联系人
            ),
            "4"=>array(
                "zdy1"=>"6",//对应客户
                "zdy2"=>"2",//性别
                "zdy15"=>"4",//生日
            ),
            "5"=>array(
                "zdy1"=>"6",//对应客户
                "zdy2"=>"6",//关联联系人
                "zdy4"=>"4",//预计签单日期
                "zdy8"=>"4",//商机获取日期
                "zdy10"=>"4",//下次跟进时间
                "zdy6"=>"6",//关联产品
                "zdy5"=>"2",//销售阶段
                "zdy7"=>"2",//商机类型
                "zdy9"=>"2",//商机来源
            ),
            "6"=>array(
                "zdy4"=>"4",//商机来源
                "zdy5"=>"4",//商机来源
                "zdy6"=>"4",//商机来源
                "zdy15"=>"4",//商机来源
                "zdy1"=>"6",//对应客户
                "zdy2"=>"6",//对应商机
                "zdy9"=>"6",//关联产品
                "zdy13"=>"5",//对应商机
                "zdy7"=>"2",//对应商机
                "zdy10"=>"2",//对应商机
                "zdy11"=>"2",//对应商机
            ),
            "7"=>array(
                "zdy6"=>"2"
            )
        );

        //获取当前mod
        $thismod=$this->modindex($openmod);
        $fid=$userinfo['user_fid']=='0'?$userinfo['user_id']:$userinfo['user_fid'];
        $infocontroller=A("AppInfo");
        
        //是否展示关联产品字段
        $haveglcp=addslashes($header['haveglcp'])==''?'0':addslashes($header['haveglcp']);

        $zdarr=$infocontroller->getZdData($fid,$thismod,'',$haveglcp);
        //遍历这些字段，对每个字段都打上type的标签
        $n=array();
        foreach($zdarr as $k=>$v)
        {
            $n[$k]['type']=$fieldsOption[$thismod][$k]==''?'1':$fieldsOption[$thismod][$k];
            $n[$k]['name']=$v;
        }
        
        $zdarr=$n;

        //参数信息
        $canshu=$infocontroller->getCanshuData($fid,$thismod);
        //parent::rr($canshu);


        if($thismod!='4'&&$thismod!='7')
        {
            $zdarr['fz']['type']='2';
            $zdarr['fz']['name']='负责人';
            $user=$infocontroller->getusername($fid);
            $canshu['fz']=$user;
        }
        if($thismod=='4')
        {
            $xb['男']='男';
            $xb['女']='女';
            $canshu['zdy2']=$xb;
        }
        if($thismod=='6')
        {
            $user=$infocontroller->getusername($fid);
            $canshu['zdy13']=$user;
        }
        if($thismod=='7')
        {
            //如果是产品，就查询产品分类
            $m=M();
            $fl=$m->query("select * from crm_chanpinfenlei where cpfl_company='$fid' ");
            foreach($fl as $v)
            {
                $flarr[$v['cpfl_id']]=$v['cpfl_name'];
            }
            $canshu['zdy6']=$flarr;
        }
        $res['code']='0';
        $res['data']['zd']=$zdarr;
        $res['data']['cs']=$canshu;
        echo json_encode($res);
        
    }
    
    /*数据添加*/
    public function AddData()
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
        //parent::rr($openmod);
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        /*
            身份验证通过
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


        $data=$_POST['data'];
        $jsondata=json_decode($data,true);

        $addcontroller=A("AppAdd");
        //添加操作分发
        if($openmod=='xiansuo')
        {
            $addcontroller->xiansuoadd($userinfo,$jsondata);
        }
        else if($openmod=='kehu')
        {
            $addcontroller->kehuadd($userinfo,$jsondata);
        }
        else if($openmod=='lianxiren')
        {
            $addcontroller->lianxirenadd($userinfo,$jsondata);
        }
        else if($openmod=='shangji')
        {
            $addcontroller->shangjiadd($userinfo,$jsondata);
        }
        else if($openmod=='hetong')
        {
            $addcontroller->hetongadd($userinfo,$jsondata);
        }
        else if($openmod=='chanpin')
        {
            $addcontroller->chanpinadd($userinfo,$jsondata);
        }
        else
        {
            parent::errorreturn("5");
        }

    }
    //删除某条数据信息
    public function deleteInfoData()
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
        //parent::rr($openmod);
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        /*
            身份验证通过
        */

        $tableName=array(
            "xiansuo"=>"crm_xiansuo",
            "kehu"=>"crm_kh",
            "kehugonghai"=>"crm_kh",
            "lianxiren"=>"crm_lx",
            "shangji"=>"crm_shangji",
            "hetong"=>"crm_hetong",
            "chanpin"=>"crm_chanpin"
        );
        $tableIdName=array(
            "xiansuo"=>"xs_id",
            "kehu"=>"kh_id",
            "kehugonghai"=>"kh_id",
            "lianxiren"=>"lx_id",
            "shangji"=>"sj_id",
            "hetong"=>"ht_id",
            "chanpin"=>"cp_id"
        );
        //执行删除语句
        $infoid=addslashes($header['infoid']);
        $m=M();
        $m->query("delete from $tableName[$openmod] where $tableIdName[$openmod]='$infoid' limit 1");
        
        $res['code']='0';
        
        echo json_encode($res);
    }
    //修改数据
    public function EditData()
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
        //parent::rr($openmod);
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        /*
            身份验证通过
        */
        $infoid=addslashes($header['infoid']);

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


        $data=$_POST['data'];
        $jsondata=json_decode($data,true);

        $editcontroller=A("AppEdit");
        //添加操作分发
        if($openmod=='xiansuo')
        {
            $editcontroller->xiansuoedit($userinfo,$jsondata,$infoid);
        }
        else if($openmod=='kehu')
        {
            $editcontroller->kehuedit($userinfo,$jsondata,$infoid);
        }
        else if($openmod=='lianxiren')
        {
            $editcontroller->lianxirenedit($userinfo,$jsondata,$infoid);
        }
        else if($openmod=='shangji')
        {
            $editcontroller->shangjiedit($userinfo,$jsondata,$infoid);
        }
        else if($openmod=='hetong')
        {
            $editcontroller->hetongedit($userinfo,$jsondata,$infoid);
        }
        else if($openmod=='chanpin')
        {
            $editcontroller->chanpinedit($userinfo,$jsondata,$infoid);
        }
        else
        {
            parent::errorreturn("5");
        }
    }
    //产品模块入口，获取产品分类
    public function getCPFL()
    {
        $header=getallheaders();
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            parent::errorreturn("3");
        }
        //当前请求的模块(必须，需要根据模块判断权限)
        $openmod=addslashes($header['openmod']);
       
        //用户信息
        $userinfo=$this->isLogin($userphone,$token);
        //验证权限
        //parent::rr($openmod);
        if(!$this->have_qx($userinfo['user_quanxian'],$this->modopenqxname($openmod)))
        {
            parent::errorreturn("4");
        }
        /*
            身份验证通过
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


        $m=M();
        $f=$m->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='".$userinfo['fid']."' order by cpfl_id desc ");
        foreach($f as $k=>$v)
        {
            $data[$v['cpfl_id']]=$v['cpfl_name'];
        }

        $res['code']='0';
        $res['data']=$data;
        echo json_encode($res);
    }
}