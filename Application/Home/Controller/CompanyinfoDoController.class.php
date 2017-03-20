<?php
namespace Home\Controller;
use Think\Controller;


class CompanyinfoDoController extends Controller {
    public function imageuplode()
    {
        //文件保存
        $getFileArr=$_FILES['headimg'];
        if(count($_FILES['headimg'])<1)
        {
            echo '{"res":0}';
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname='gsxx'.$fid.time().'.'.$oldnamehz;
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/head-img/'.$newname);
        if(!file_exists('./Public/head-img/'.$newname))
        {
            echo '{"res":0}';
            die();
        }
        //数据库插入
        $gsbase=M("gongsixinxi");
        $oldxx=$gsbase->query("select * from crm_gongsixinxi where gsxx_yh='$fid'");
        if($oldxx[0]['gsxx_img']!='0'&&$oldxx[0]['gsxx_img']!='')
        {
            unlink('./Public/head-img/'.$oldxx[0]['gsxx_img']);
        }
        $gsbase->query("update crm_gongsixinxi set gsxx_img='$newname' where gsxx_yh='$fid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','修改了公司logo图片','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        echo '{"res":1,"newpath":"'.$newname.'"}';
        //echo json_encode($_FILES['headimg']);
        //echo $_FILES;
    }
    //公司信息修改
    public function companyinfoedit()
    {
        $neededitstr=substr($_GET["editinfo"],0,-2);
        if($neededitstr=='')
        {
            echo '2';
            die();
        }
        $neededitarr=explode(',,',$neededitstr);
        $setstr='';
        foreach($neededitarr as $k=>$v)
        {
            $kv=explode(':',$v);
            $setstr.=$kv[0]."='".$kv[1]."',";
        }
        $setstr=substr($setstr,0,-1);
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $gsbase=M("gongsixinxi");
        $gsbase->query("update crm_gongsixinxi set $setstr where gsxx_yh='$fid'");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','修改了公司信息','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        echo '1';
    }
}