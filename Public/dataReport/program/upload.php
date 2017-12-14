<?php
/*
    配置项
*/
//$hostName='http://192.168.1.51';//远程服务器
$hostName='http://124.193.66.43:8012';//远程服务器












/*
    程序
*/
$dirName=dirname(__FILE__);//当前的绝对路径
$nowDate=date("Y-m-d",time());//当前日期
$nowtime=date("Y-m-d H:i:s",time());//当前日期时间
$yesterdayDate=date("Y_m_d",strtotime($nowDate.' -1 day'));//昨天的日期，用于文件名
$yesterdayDate2=date("Y-m-d",strtotime($nowDate.' -1 day'));//昨天的日期，用于计算


//如果记录最后一次上传的文件不存在，就创建
if(!is_file($dirName."/../data/lastUpload.txt"))
{
    $file=fopen($dirName."/../data/lastUpload.txt","w");
    fclose($file);
}
//获取最后一次上传的时间
$lastUpload=file_get_contents($dirName."/../data/lastUpload.txt");
$lastUpload=$lastUpload==''?$yesterdayDate2:$lastUpload;//如果没有最后一次上传时间，就拿昨天的数据
//计算最后一次上传时间距离现在有几天
$days=(strtotime($nowDate)-strtotime($lastUpload))/86400;



//循环着些天，如果有文件的话就获取内容
$content='';
for($i=0;$i<$days;$i++)
{
    $lastfilename=date("Y_m_d",strtotime($lastUpload));//当天的文件名
    if(is_file($dirName."/../data/".$lastfilename.".txt"))
    {
        $content.=file_get_contents($dirName."/../data/".$lastfilename.".txt");
    }
    $lastUpload=date("Y-m-d",strtotime($lastUpload.' +1 day'));//天数加1
}

//所有需要上传的数据都取到后，开始curl上传
if($content=='')
{
    die("no data need to upload");
}

$mac = new GetMacAddr(PHP_OS); 
$p['mac']=$mac->mac_addr; //机器的真实MAC地址
$p['content']=$content;
$url = $hostName."/index.php/Home/SaveSql/savefile";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $p);

$output = curl_exec($ch);
curl_close($ch);


if(!$output)
{
    die("upload error ,code :".$output);
}
else
{
    //修改lastUpload.txt文件中储存的最后一次上传时间
    $file=fopen($dirName."/../data/lastUpload.txt","w");
    fwrite($file, $nowDate);
    fclose($file);
}

//输出结果
echo $nowDate.":upload ".$yesterdayDate." data success. code:".$output;



die;
class GetMacAddr{ 
    
    var $return_array = array(); // 返回带有MAC地址的字串数组 
    var $mac_addr; 
    
    function GetMacAddr($os_type){ 
    switch ( strtolower($os_type) ){ 
    case "linux": 
    $this->forLinux(); 
    break; 
    case "solaris": 
    break; 
    case "unix": 
    break; 
    case "aix": 
    break; 
    default: 
    $this->forWindows(); 
    break; 
    
    } 
    
    $temp_array = array(); 
    foreach ( $this->return_array as $value ){ 
    
    if ( 
    preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value, 
    $temp_array ) ){ 
    $this->mac_addr = $temp_array[0]; 
    break; 
    } 
    
    } 
    unset($temp_array); 
    return $this->mac_addr; 
    } 
    
    function forWindows(){ 
    @exec("ipconfig /all", $this->return_array); 
    if ( $this->return_array ) 
    return $this->return_array; 
    else{ 
    $ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe"; 
    if ( is_file($ipconfig) ) 
    @exec($ipconfig." /all", $this->return_array); 
    else 
    @exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $this->return_array); 
    return $this->return_array; 
    } 
    } 
    
    function forLinux(){ 
    @exec("ifconfig -a", $this->return_array); 
    return $this->return_array; 
    } 
    
    } 