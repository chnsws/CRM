<?php
/*
    推送核心方法

*/
date_default_timezone_set('Asia/Shanghai');
include_once($_SERVER['DOCUMENT_ROOT']."/Public/crmPush/crmPushFunction.php");
$db=include($_SERVER['DOCUMENT_ROOT']."/Application/Common/conf/config.php");//数据库配置信息

$connect_count=3;//连接失败重新连接次数

connectMysql($db);//连接数据库


/*
    查询跟进表，取出需要的跟进记录
    根据对应数据id,对应用户id，查询出用户移动设备的cid和用户名
    生成消息，插入消息数据库，推送
*/
$thistime=time();
$thistime=strtotime("2017-04-13 17:44:08");
$sqltime=getM($thistime);
$thisdate=date("Y-m-d H:i",$thistime);


$query=mysql_query("select * from crm_xiegenjin where date like '$thisdate%' or date between '$sqltime[s]' and '$sqltime[e]'");
if(!mysql_num_rows($query))
{
    nodata();
}
while($row=mysql_fetch_assoc($query))
{
    $genjinDbData[]=$row;
    //$userData[$row['user_id']]=$row['user_id'];
    $modData[$row['mode_id']][$row['kh_id']]=$row['kh_id'];
    
}

//字段
$modDbInfo[1]['name']="crm_xiansuo";
$modDbInfo[1]['id']="xs_id";
$modDbInfo[1]['data']="xs_data";
$modDbInfo[1]['fz']="xs_fz";

$modDbInfo[2]['name']="crm_kh";
$modDbInfo[2]['id']="kh_id";
$modDbInfo[2]['data']="kh_data";
$modDbInfo[2]['fz']="kh_fz";

$modDbInfo[5]['name']="crm_shangji";
$modDbInfo[5]['id']="sj_id";
$modDbInfo[5]['data']="sj_data";
$modDbInfo[5]['fz']="sj_fz";

$modDbInfo[6]['name']="crm_hetong";
$modDbInfo[6]['id']="ht_id";
$modDbInfo[6]['data']="ht_data";
$modDbInfo[6]['fz']="ht_fz";
//获取各模块的各个信息名称
foreach($modData as $modid=>$v)
{
    $inSql="'".implode("','",$v)."'";

    $name=$modDbInfo[$modid]['name'];
    $id=$modDbInfo[$modid]['id'];
    $data=$modDbInfo[$modid]['data'];
    $fz=$modDbInfo[$modid]['fz'];

    
    $query=mysql_query("select $id,$data,$fz from $name where $id in ($inSql)");
    while($row=mysql_fetch_assoc($query))
    {
        $j=json_decode($row[$data],true);
        $dataName[$modid][$row[$id]]=$j['zdy0'];
        $modDataToFz[$modid][$row[$id]]=$row[$fz];//各模块的数据对应的负责人
        $fzData[$row[$fz]]=$row[$fz];
    }
}

if(count($fzData))
{
    //首先查询用户表，如果该用户没有登录过移动端，或者移动端身份已过期，就不推送该用户的消息，降低服务器压力
    $inSql="'".implode("','",$fzData)."'";
    $limit=count($fzData);
    $overdate=date("Y-m-d H:i:s",($thistime-604800));
    $query=mysql_query("select a_user_id,a_cid from crm_app_user_info where a_push_act='1' and a_user_last_login_date>'$overdate' and a_user_id in ($inSql) limit $limit ");
    while($row=mysql_fetch_assoc($query))
    {
        $cidData[$row['a_user_id']]=$row['a_cid'];//储存用户cid的数组
        $pushUserId[$row['a_user_id']]=$row['a_user_id'];//可以推送的用户id
    }
}


foreach($genjinDbData as $row)
{
    //筛选可以进行推送的数据
    
    if(in_array($modDataToFz[$row['mode_id']][$row['kh_id']],$pushUserId))
    {
        $genjinData[$row['mode_id']][]=$row;
        $modData[$row['mode_id']][$row['kh_id']]=$row['kh_id'];
        $fidData[$row['mode_id']][$row['genjin_yh']]=$row['genjin_yh'];
    }
}


if(count($modData[1]))
{
    //如果有线索数据，则需要查询参数的名称
    $fidSql="'".implode("','",$fidData[1])."'";
    $limit=count($fidData);
    
    $query=mysql_query("select ywcs_data,ywcs_yh from crm_ywcs where ywcs_yw='7' and ywcs_yh in ($fidSql) limit $limit");
    while($row=mysql_fetch_assoc($query))
    {
        $j=json_decode($row['ywcs_data'],true);
        $canshuData[$row['ywcs_yh']]=$j[0];
    }
    foreach($genjinData[1] as $k=>$v)
    {
        $genjinData[1][$k]['type']=$canshuData[$v['genjin_yh']][$v['type']];
    }
}


//组合信息
$modName=array(
    "1"=>"线索",
    "2"=>"客户",
    "3"=>"客户公海",
    "4"=>"联系人",
    "5"=>"商机",
    "6"=>"合同",
    "7"=>"产品"
);
$pushMsgInSql='';
foreach($genjinData as $modid=>$v)
{
    foreach($v as $vv)
    {
        $title='有'.$modName[$modid].'需要跟进';
        $content=$modName[$modid].'名称：'.$dataName[$modid][$vv['kh_id']];

        $pushData=array();
        $pushData['type']='1';
        $pushData['id']=$vv['kh_id'];
        $pushData['mod']=$modid;
        
        $pushData=json_encode($pushData);
        
        $userCid=$cidData[$vv['user_id']];
        if($userCid=='')
        {
            continue;
        }
        $res=tosingle($title,$content,$pushData,$userCid);
        $res=json_encode($res);
        
        $pushMsgInSql[]="('','$vv[user_id]','$content','".time()."','$res','1','$modid:$vv[kh_id]','$vv[genjin_yh]','0')";
    }
    
}
if(count($pushMsgInSql))
{
    //插入消息数据库
    $insertSql=implode(',',$pushMsgInSql);
    $r=mysql_query("insert into crm_push values $insertSql");
    if($r)
    {
        echo "执行成功";
    }
    else
    {
        echo "执行失败";
    }
}
else
{
    nodata();
}

#####################程序结束，以下为封装的方法######################

function nodata()
{
    global $thisdate;
    echo $thisdate."，没有需要推送的跟进数据";
    die;
}



function connectMysql($db)
{
    @$con=mysql_connect($db['DB_HOST'],$db['DB_USER'],$db['DB_PWD']);//连接数据库
    Global $connect_count;
    if(!$con)
    {
        if($connect_count>0)
        {
            //如果连接失败，并且还有重新连接的次数
            $connect_count--;
            connectMysql($db);
        }
        else
        {
            echo "数据库连接失败";
            die;
        }
    }
    else
    {
        //如果连接成功
        mysql_select_db($db['DB_NAME']);
        mysql_set_charset("utf8");
    }
}
function getM($time)
{
    /*
        通过已给的时间戳，获取该分钟的开始和结束时间戳
        $time [string] 时间戳
        return [array] 开始时间戳和结束时间戳
    */
    $s=date("s",$time);
    $r['s']=$time-$s;
    $r['e']=$time+(59-$s);
    return $r;
}
function r($a)
{
    echo "<pre>";
    print_r($a);
}