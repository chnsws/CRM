<?php
header("Content-type: text/html; charset=utf-8"); 
error_reporting(0); 
$hostname='192.168.1.51';//数据库地址
$hostuser='root';//数据库用户名
$hostpwd='9654321';//数据库密码
$dbname='mac';//数据库名称









$mac=addslashes($_POST['mac']);

if($mac=='')
{
    die(0);
    //die("mac is null");
}
//$mac='08-60-6E-F0-F1-A4';
mysql_connect($hostname,$hostuser,$hostpwd);
mysql_select_db($dbname);
mysql_set_charset("utf8");

$query=mysql_query("select * from maclist where mac_content='$mac' limit 1");
$arr=mysql_fetch_assoc($query);
$res=0;
//判断存不存在
if($arr)
{
    //判断状态
    if($arr['mac_act']=='1')
    {
        //判断过没过期
        $overdate=strtotime($arr['mac_overdate']);
        if($overdate>time())
        {
            $res=1;
        }
    }
}

echo $res;

die;

