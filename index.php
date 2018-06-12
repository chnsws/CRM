<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
      
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./Application/');
//超全局变量
//$a=$_SERVER['SERVER_NAME'];
//$_GET['public_dir']='http://'.$a.'/Public';//public的路径
//$_GET['root_dir']='http://'.$a;//根目录路径
//获取浏览器信息函数
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
    /*
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
    */
}
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

