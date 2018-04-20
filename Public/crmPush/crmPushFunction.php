<?php
header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/' . 'igetui/utils/AppConditions.php');

//http的域名
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//https的域名
//define('HOST','https://api.getui.com/apiex.htm');
               

/*
define('APPKEY','dAc2Um6YI894fgAVx649q4');
define('APPID','A5Oh0PvreFAWscCCpYEzs7');
define('MASTERSECRET','4eF2ooRBtW73w5KGebUpm1');
//define('CID','687b063149326fccc215e282ccf6b580');
*/


define('APPKEY','kIyqawwQZS8fD7Yn6CC1e7');
define('APPID','Z3psEHZSNg6vm9LwL6TlmA');
define('MASTERSECRET','DPjfeCNfC8Ali37waDbgL8');

function tosingle($pushTitle,$pushContent,$pushData,$pushCid)
{

    $igt = new IGeTui(NULL,APPKEY,MASTERSECRET,false);

  	$template = IGtNotificationTemplateDemo($pushTitle,$pushContent,$pushData);
    //个推信息体
    $message = new IGtSingleMessage();

    $message->set_isOffline(true);//是否离线
    $message->set_offlineExpireTime(3600*12*1000);//离线时间
    $message->set_data($template);//设置推送消息类型
//	$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
    //接收方
    $target = new IGtTarget();
    $target->set_appId(APPID);
    $target->set_clientId($pushCid);
//    $target->set_alias(Alias);


    try {
        $rep = $igt->pushMessageToSingle($message, $target);
        return ($rep);

    }catch(RequestException $e){
        $requstId =e.getRequestId();
        $rep = $igt->pushMessageToSingle($message, $target,$requstId);
        return ($rep);
    }
}
function toapp($pushTitle,$pushContent,$pushData)
{
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    $template = IGtNotificationTemplateDemo($pushTitle,$pushContent,$pushData);
    //$template = IGtLinkTemplateDemo();
    //个推信息体
    //基于应用消息体
    $message = new IGtAppMessage();
    $message->set_isOffline(true);
    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    $message->set_data($template);

    $appIdList=array(APPID);

    //$phoneTypeList=array('ANDROID');
    //$provinceList=array('浙江');
    //$tagList=array('haha');
    //用户属性
    //$age = array("0000", "0010");


    //$cdt = new AppConditions();
   // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
   // $cdt->addCondition(AppConditions::REGION, $provinceList);
    //$cdt->addCondition(AppConditions::TAG, $tagList);
    //$cdt->addCondition("age", $age);

    $message->set_appIdList($appIdList);
    //$message->set_conditions($cdt->getCondition());

    $rep = $igt->pushMessageToApp($message,"任务组名");

    return ($rep);
}

//以通知栏点击透传的方式推送
function IGtNotificationTemplateDemo($pushTitle,$pushContent,$pushData){
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);//应用appid
    $template->set_appkey(APPKEY);//应用appkey
    $template->set_transmissionType(1);//透传消息类型
    $template->set_transmissionContent($pushData);//透传内容
    $template->set_title($pushTitle);//通知栏标题
    $template->set_text($pushContent);//通知栏内容
    $template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
    $template->set_isRing(true);//是否响铃
    $template->set_isVibrate(true);//是否震动
    $template->set_isClearable(true);//通知栏是否可清除
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    return $template;
}



?>