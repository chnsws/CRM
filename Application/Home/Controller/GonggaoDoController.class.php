<?php
namespace Home\Controller;
use Think\Controller;


class gonggaoDoController extends DBController {
    //获得部门列表
    public function getbumen()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $bmbase=M("department");
        $bmarr=$bmbase->query("select bm_id,bm_name from crm_department where bm_company='$fid'");
        $checkboxstr='';
        foreach($bmarr as $v)
        {
            $checkboxstr.="<input type='checkbox' value='".$v['bm_id']."' name='bm".$v['bm_id']."' title='".$v['bm_name']."' /><br />";
        }
        echo $checkboxstr;
    }
    
    //获得角色列表
    public function getjuese()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $jsbase=M("juesequanxian");
        $juesearr=$jsbase->query("select qx_id,qx_name from crm_juesequanxian where qx_yh='$fid'");
        $jusestr='';
        foreach($juesearr as $v)
        {
            $juesestr.="<input type='checkbox' value='".$v['qx_id']."' name='js".$v['qx_id']."' title='".$v['qx_name']."' /><br />";
        }
        echo $juesestr;
    }
    //公告发布
    public function gonggaoadd()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $ggname=addslashes($_POST['ggname']);
        $ggfanwei=addslashes($_POST['ggfanwei']);
        $ggneirong=addslashes($_POST['ggneirong']);
        $fanweicheck=addslashes($_POST['fanweicheck']);
        if($ggname==''||$ggfanwei=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $ggbase=M("ggshezhi");
        $ggbase->query("insert into crm_ggshezhi values('','$ggname','$ggfanwei','$fanweicheck','$ggneirong','".date("Y-m-d H:i:s")."','".cookie("user_id")."','0','0','0','$fid')");
        
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','4','".cookie("user_id")."','0','0','0','0','0','新增公告$ggname','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo '1';
    }
    //编辑时获取公告的详细信息
    public function getgginfo()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $thisggid=addslashes($_GET['ggid']);
        if($thisggid=='')
        {
            echo 2;
            die();
        }
        $ggbase=M("ggshezhi");
        $gginfoarr=$ggbase->query("select * from crm_ggshezhi where ggsz_id='$thisggid' limit 1");
        $gginfostr=$gginfoarr[0]['ggsz_id'].",@,".$gginfoarr[0]['ggsz_name'].",@,".$gginfoarr[0]['ggsz_kjfw'].",@,".$gginfoarr[0]['ggsz_kjid'].",@,".$gginfoarr[0]['ggsz_ggnr'];

        echo $gginfostr;
    }
    //公告修改
    public function ggedit()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $ggeditid=addslashes($_GET['ggeditid']);
        $ggeditstr=addslashes(substr($_GET['ggeditstr'],0,-3));
        if($ggeditid==''||$ggeditstr=='')
        {
            echo 2;
            die();
        }
        $neededitarr=explode(',@,',$ggeditstr);
        $updatestr='';
        foreach($neededitarr as $v)
        {
            $kv=explode('::',$v);
            $updatestr.=$kv[0]."='".$kv[1]."',";
            //获取到公告名称，用于更新日志
            if($kv[0]=='ggsz_name')
            {
                $ggnamerz=$kv[1];
            }
        }
        $updatestr=substr($updatestr,0,-1);
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $ggbase=M("ggshezhi");
        $ggbase->query("update crm_ggshezhi set $updatestr where ggsz_id='$ggeditid' ");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','4','".cookie("user_id")."','0','0','0','0','0','编辑公告$ggnamerz','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo '1';
    }
    //删除公告
    public function ggdel()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $delstr=addslashes($_GET['delstr']);
        $deltype=addslashes($_GET['deltype']);
        $delggname=addslashes($_GET['delggname']);
        if($delstr==''||$deltype=='')
        {
            echo 2;
            die();
        }
        $ggbase=M("ggshezhi");
        $xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
        if($deltype=='1')//单条删除
        {
            $wherestr="ggsz_id='$delstr' limit 1";
        }
        if($deltype=='2')//多条删除
        {
            $delstr=str_replace(',',"','",$delstr);
            $delggarr=$ggbase->query("select ggsz_name from crm_ggshezhi where ggsz_id in ('$delstr')");
            foreach($delggarr as $v)
            {
                $rzstr.="('','3','4','".cookie("user_id")."','0','0','0','0','0','删除公告".$v['ggsz_name']."','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."'),";
            }
            $rzstr=substr($rzstr,0,-1);
            $wherestr="ggsz_id in ('$delstr')";
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        
        $ggbase->query("delete from crm_ggshezhi where $wherestr");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		
		//进行插入操作
        if($deltype=='1')
		    $xitongrizhibase->query("insert into crm_rz values('','3','4','".cookie("user_id")."','0','0','0','0','0','删除公告$delggname','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        if($deltype=='2')
            $xitongrizhibase->query("insert into crm_rz values $rzstr");
        echo '1';
    }
    //公告置顶的操作
    public function ggzd()
    {
        parent::is_login();
        parent::have_qx("qx_sys_gsxx");
        $zdid=addslashes($_GET['zdid']);
        $zdval=addslashes($_GET['zdval']);
        if($zdid==''||$zdval=='')
        {
            echo 2;
            die;
        }
        if($zdval=='0')
        {
            $zdtime='0';
            $zdstr='取消置顶';
        }
        else
        {
            $zdtime=date("Y-m-d H:i:s",time());
            $zdstr='置顶';
        }
        $ggbase=M("ggshezhi");
        $ggbase->query("update crm_ggshezhi set ggsz_zd='$zdval',ggsz_zd_sj='$zdtime' where ggsz_id='$zdid' limit 1");
        $rzggname=$ggbase->query("select ggsz_name from crm_ggshezhi where ggsz_id='$zdid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','4','".cookie("user_id")."','0','0','0','0','0','".$zdstr."公告".$rzggname[0]['ggsz_name']."','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo '1';
    }
}