<?php
namespace Home\Controller;
use Think\Controller;


class QuanxianDoController extends DBController {
	//获取某个角色的权限
    public function oneqx()
    {
        parent::is_login();
        $fid=parent::get_fid();

        $jueseid=addslashes($_GET['nowclickid']);

        $findqxarr=parent::sel_more_data("crm_juesequanxian","*","qx_id='$jueseid' and qx_yh='$fid' limit 1");
        


        //$qxbase=M("quanxian");
        //$findqxarr=$qxbase->query("select * from crm_quanxian where qx_id='$jueseid' and qx_company='$fid' limit 1");
        $qxonestart='0';
        foreach($findqxarr[0] as $k=>$v)
        {
            if($k=='qx_xs_open')
            {
                $qxonestart='1';
            }
            if($qxonestart=='1')
            {
                if($v=='1')
                $qxArr.=$k.',';
            }
        }
        echo substr($qxArr,0,-1);
    }
    //改变权限状态
    public function changeqxval()
    {
        $changefiled=addslashes($_GET['changefiled']);//字段名
        $changejuese=addslashes($_GET['changejuese']);//角色id
        $changefiledvalue=addslashes($_GET['changefiledvalue']);//修改成的值 true/false
        $changefiledname=addslashes($_GET['changefiledname']);//角色名称
        $fid=parent::get_fid();

        if($changefiled==''||$changejuese==''||$changefiledvalue=='')
        {
            echo 2;
            die();
        }
        $qxnameArr=array(
            'qx_xs_open'=>'线索查看',
            'qx_xs_del'=>'线索删除',
            'qx_xs_to_kh'=>'线索转成客户',
            'qx_kh_open'=>'客户查看',
            'qx_kh_del'=>'客户删除',
            'qx_lxr_open'=>'联系人查看',
            'qx_lxr_del'=>'联系人删除',
            'qx_sj_open'=>'商机查看',
            'qx_sj_del'=>'商机删除',
            'qx_ht_open'=>'合同查看',
            'qx_ht_del'=>'合同删除',
            'qx_cp_open'=>'产品查看',
            'qx_cp_add'=>'产品添加',
            'qx_cp_edit'=>'产品修改',
            'qx_cp_del'=>'产品删除',
            'qx_bb_open'=>'报表查看',
            'qx_sys_bmyh'=>'部门和用户设置',
            'qx_sys_jsqx'=>'角色权限设置',
            'qx_sys_gsxx'=>'公司信息设置',
            'qx_sys_gggl'=>'公告管理',
            'qx_sys_yjmb'=>'业绩目标设置',
            'qx_sys_khgh'=>'客户公海设置',
            'qx_sys_ywzd'=>'业务字段设置',
            'qx_sys_ywcs'=>'业务参数设置',
            'qx_sys_sp'=>'审批设置',
            'qx_sys_sx'=>'产品筛选设置',
            'qx_sys_rz'=>'日志查询'
        );

        $baseval=array("true"=>'1',"false"=>'0');
        $qxdo=array("true"=>'开启',"false"=>'关闭');
        $qxbase=M("juesequanxian");
        $qxbase->query("update crm_juesequanxian set $changefiled='".$baseval[$changefiledvalue]."' where qx_id='$changejuese' and qx_yh='$fid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','".$changefiledname.' '.$qxdo[$changefiledvalue].' '.$qxnameArr[$changefiled]." 权限','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
    }
    //修改角色名
    public function jsedit()
    {
        parent::is_login();
        $fid=parent::get_fid();
        $editjsid=addslashes($_GET['editjsid']);
        $editnewname=addslashes($_GET['editnewname']);
        if($editjsid==''||$editnewname=='')
        {
            echo 2;
            die();
        }
        $qxbase=M("juesequanxian");
        $cfjs=$qxbase->query("select * from crm_juesequanxian where qx_name='$editnewname' and qx_yh='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        $qxbase->query("update crm_juesequanxian set qx_name='".$editnewname."' where qx_id='$editjsid' and qx_yh='$fid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','更改了角色名:$editnewname','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
        
    }
    //删除角色
    public function jsdel()
    {
        parent::is_login();
        $fid=parent::get_fid();
        $deljsid=addslashes($_GET['jsid']);
        $deljsname=addslashes($_GET['jsname']);
        if($deljsid==''||$deljsname=='')
        {
            echo 2;
            die();
        }
        
        $qxbase=M("juesequanxian");
        $qxbase->query("delete from crm_juesequanxian where qx_id='$deljsid' and  qx_yh='$fid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','删除角色:$deljsname','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
    }
    //添加角色
    public function jsadd()
    {
        parent::is_login();
        $fid=parent::get_fid();
        $addnewname=addslashes($_GET['addnewname']);
        if($addnewname=='')
        {
            echo 2;
            die();
        }
        $qxbase=M("juesequanxian");
        $cfjs=$qxbase->query("select * from crm_juesequanxian where qx_name='$addnewname' and qx_yh='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        //$qxbase->query("insert into crm_quanxian values('','$addnewname','1','$fid'".$valstr.")");
        $qxbase->query("insert into crm_juesequanxian set qx_name='$addnewname',qx_yh='$fid'");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','添加角色:$addnewname','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
       
    }
    //获得带有option标签的最新角色的字符串
    public function newjslist()
    {
        parent::is_login();
        $fid=parent::get_fid();
        
        $qxbase=M("juesequanxian");
        $newjsarr=$qxbase->query("select qx_id,qx_name from crm_juesequanxian where qx_yh='$fid' or qx_yh='0' ");
        $newjsstr="<option value=''>请选择角色</option>";
        foreach($newjsarr as $v)
        {
            $newjsstr.="<option value='".$v['qx_id']."'>".$v['qx_name']."</option>";
        }
        echo $newjsstr;
    }
    //角色复制
    public function jscopy()
    {
        parent::is_login();
        $fid=parent::get_fid();

        $copyfromid=addslashes($_GET['copyfromid']);
        $copyjsnameinput=addslashes($_GET['copyjsnameinput']);
        if($copyfromid==''||$copyjsnameinput=='')
        {
            echo 2;
            die();
        }
        $qxbase=M("juesequanxian");
        $cfjs=$qxbase->query("select * from crm_juesequanxian where qx_name='$addnewname' and qx_yh='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        //获取复制的角色数据
        $fromjsdata=$qxbase->query("select * from crm_juesequanxian where qx_id='$copyfromid' limit 1");
        foreach($fromjsdata[0] as $k=>$v )
        {
            if($k!='qx_id'&&$k!='qx_name')
            {
                if($k=='qx_yh')
                {
                    $copyinsertstr.=",'$fid'";
                }
                else
                {
                    $copyinsertstr.=",'$v'";
                }
            }
        }
        $qxbase->query("insert into crm_juesequanxian values('','$copyjsnameinput'$copyinsertstr)");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','通过复制添加角色:$copyjsnameinput','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
    }
    public function dataqxedit()
    {
        $changeid=addslashes($_GET['changeid']);
        $changeradioval=addslashes($_GET['changeradioval']);
        $thisjsName=addslashes($_GET['thisjsName']);
        if($changeradioval==''||$changeid=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $qxbase->query("update crm_quanxian set qx_data_qx='$changeradioval' where qx_id='$changeid' and qx_company='$fid' limit 1");
        $dataqxname=array("1"=>"个人","2"=>"所属部门","3"=>"所属部门及下属部门","4"=>"全公司");
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','".$thisjsName."数据权限改为".$dataqxname[$changeradioval]."','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
    }
}