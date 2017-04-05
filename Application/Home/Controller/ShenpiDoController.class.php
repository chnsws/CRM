<?php
namespace Home\Controller;
use Think\Controller;


class ShenpiDoController extends Controller {
    public function change_on_off()
    {
        $kqval=addslashes($_GET['kqval']);
        $kqtype=addslashes($_GET['kqtype']);
        if($kqtype==''||$kqval=='')
        {
            echo '2';
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）

        $spbase=M("shenpi");
        $spbase->query("update crm_shenpi set sp_kq='$kqval' where sp_yh='$fid' and sp_type='$kqtype'");

        $kqstr=$kqval=='1'?'开启':'关闭';
        $htstr=$kqtype=='1'?'':'回款';

        echo $this->insertrizhi($kqstr.'了合同'.$htstr.'审批');
    }
    //开启或关闭审批人
    public function change_ck_onoff()
    {
        $ckid=addslashes($_GET['ckid']);
        $ckval=addslashes($_GET['ckval']);
        if($ckid==''||$ckval=='')
        {
            echo '2';
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $spbase=M("shenpi");
        $spbase->query("update crm_shenpi set sp_kq='$kqval' where sp_yh='$fid' and sp_type='$kqtype'");
    }
    //审批保存
    public function baocun()
    {
        $ajaxstr=addslashes($_POST['ajaxstr']);
        $sptype=addslashes($_POST['sptype']);
        if($ajaxstr=='')
        {
            echo 2;
            die();
        }
        $ajaxarr=explode(",",$ajaxstr);
        $setstr='';
        foreach($ajaxarr as $k=>$v)
        {
            if($v=='sp_qy_1:2'||$v=='sp_qy_2:2'||$v=='sp_qy_3:2'||$v=='sp_tb:2')
                continue;
            $val=explode(':',$v);
            if(substr($val[0],0,-1)=='sp_qy_'||$val[0]=='sp_tb')
            {
                $val[1]=$val[1]=='true'?1:0;
            }
            if(substr($val[0],0,-1)=='sp_value_')
            {
                $val[1]=str_replace('.',',',$val[1]);
            }
            $setstr.=$val[0]."='".$val[1]."',";
        }
        $setstr=substr($setstr,0,-1);
        
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $spbase=M("shenpi");
        $spbase->query("update crm_shenpi set $setstr where sp_yh='$fid' and sp_type='$sptype'");
        
        $hkrz=$sptype=='1'?'':'回款';
        echo $this->insertrizhi("修改了合同".$hkrz."审批设置");
    }
    //插入日志方法
    public function insertrizhi($con)
    {
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','10','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}