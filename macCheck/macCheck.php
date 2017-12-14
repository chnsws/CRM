<?php
/*
配置项
*/
$url='http://124.193.66.43:8012/macCheck/macConfirm.php';//远程路径






/*
    程序
*/
$dirName=dirname(__FILE__);//当前的绝对路径
$mac = new GetMacAddr(PHP_OS); 
$mac=$mac->mac_addr; 
$p['mac']=$mac;
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
    if(rename($dirName.'/../index.php',$dirName.'/../index2.php'))
    {
        if(rename($dirName.'/../nopower.php',$dirName.'/../index.php'))
        {
            if(rename($dirName.'/../index2.php',$dirName.'/../nopower.php'))
            {
                
            }
        }
    }
    
}



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
