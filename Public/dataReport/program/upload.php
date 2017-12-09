<?php
$hostName='http://124.193.66.43:8012';//远程服务器
$dirname=dirname(__FILE__);//当前的绝对路径
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

