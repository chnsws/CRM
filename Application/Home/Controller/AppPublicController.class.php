<?php
namespace Home\Controller;
use Think\Controller;
class AppPublicController extends Controller {
    //开发测试输出数组
    public function rr($arr)
    {
        echo "<pre>";print_r($arr);die;
    }
    function getSysBro(){  
        $agent = $_SERVER['HTTP_USER_AGENT'];  
        $brower = array(  
            'MSIE' => 1,  
            'Firefox' => 2,  
            'QQBrowser' => 3,  
            'QQ/' => 3,  
            'UCBrowser' => 4,  
            'MicroMessenger' => 9,  
            'Edge' => 5,  
            'Chrome' => 6,  
            'Opera' => 7,  
            'OPR' => 7,  
            'Safari' => 8,  
            'Trident/' => 1  
        );  
        $system = array(  
            'Windows Phone' => 4,  
            'Windows' => 1,  
            'Android' => 2,  
            'iPhone' => 3,  
            'iPad' => 5  
        );  
        $browser_num = 0;//未知  
        $system_num = 0;//未知  
        foreach($brower as $bro => $val){  
            if(stripos($agent, $bro) !== false){  
                $browser_num = $bro;  
                break;  
            }  
        }  
        foreach($system as $sys => $val){  
            if(stripos($agent, $sys) !== false){  
                $system_num = $sys;  
                break;  
            }  
        }  
        return array('sys' => $system_num, 'bro' => $browser_num);  
    } 
    //获取登录地点方法
    function getCity($ip = '')
    {
        return '';die;



        
        if($ip=='::1')
            $ip="127.0.0.1";
        if($ip == ''){
            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
            $ip=json_decode(file_get_contents($url),true);
            $data = $ip;
        }else{
            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
            $ip=json_decode(file_get_contents($url));   
            if((string)$ip->code=='1'){
                return false;
            }
            $data = (array)$ip->data;
        }
    
        return $data;   
    }
    
    public function errorreturn($c)
    {
        if($c=='1')
        {
            die('{
                "code":"1",
                "data":"账号或密码错误"
            }');
        }
        else if($c=='2')
        {
            die('{
                "code":"2",
                "data":"该账号已被冻结"
            }');
        }
        else if($c=='3')
        {
            die('{
                "code":"3",
                "data":"身份已到期或在别处登录"
            }');
        }
        else if($c=='4')
        {
            die('{
                "code":"4",
                "data":"没有当前操作权限"
            }');
        }
        else if($c=='6')
        {
            die('{
                "code":"6",
                "data":"数据不存在"
            }');
        }
        else
        {
            die('{
                "code":"5",
                "data":"未知错误"
            }');
        }
        
    }

    /*判断是否登录，如果登录则返回登录用户的user信息*/
    public function isLogin($userphone,$token)
    {
        $m=M();
        $q0=$m->query("select * from crm_app_user_info where a_user_phone='$userphone' and a_login_token='$token' limit 1");
        if(!count($q0))
        {
            $this->errorreturn("3");
        }
        else
        {
            //604800  一周
            $datetime=strtotime($q0[0]['a_user_last_login_date']);//最后一次操作时间
            $nowtime=time();//当前时间
            if(($nowtime-$datetime)>604800)
            {
                //超过一周，身份过期
                $this->errorreturn("3");
            }
            else
            {
                $nowdate=date("Y-m-d H:i:s",time());
                $aid=$q0[0]['a_id'];
                $m->query("update crm_app_user_info set a_user_last_login_date='$nowdate' where a_id='' limit 1");
            }

            $userid=$q0[0]['a_user_id'];
            $q=$m->query("select * from crm_user where user_id='$userid' limit 1");
            $r=array_merge($q[0],$q0[0]);
            return $r;
        }
    }
    public function loginStatus($header)
    {
        $userphone=addslashes($header['userphone']);
        $token=addslashes($header['token']);
        if($userphone==''||$token=='')
        {
            $this->errorreturn("3");
        }
        //用户信息
        $userinfo=$this->isLogin($userphone,$token);
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
        return $userinfo;
    }
    public function getAreaName($areaId)
    {
        $idArr=explode(',',$areaId);
        $a=file_get_contents("./Public/index_js_css/datas/area_data.js");
        $a=substr($a,14,-1);
        $a=json_decode($a,true);
        $areaName='';
        foreach($a as $k=>$v)
        {
            $areaName[$v['provinceCode']]=$v['provinceName'];
            foreach($v['mallCityList'] as $kk=>$vv)
            {
                $areaName[$vv['cityCode']]=$vv['cityName'];
                foreach($vv['mallAreaList'] as $kkk=>$vvv)
                {
                    $areaName[$vvv['areaCode']]=$vvv['areaName'];
                }
        
            }
        }
        $res=$areaName[$idArr[0]].','.$areaName[$idArr[1]].','.$areaName[$idArr[2]];
        return $res;
    }
    //规范时间格式
    public function date_to_date($str)
    {
        $s=explode(' ',$str);
        $e=explode('-',$s[0]);
        if($e[1]<10&&strlen($e[1])==1)
        {
            $e[1]='0'.$e[1];
        }
        if($e[2]<10&&strlen($e[2])==1)
        {
            $e[2]='0'.$e[2];
        }
        return implode('-',$e);
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
}