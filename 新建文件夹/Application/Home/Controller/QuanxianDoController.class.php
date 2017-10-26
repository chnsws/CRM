<?php
namespace Home\Controller;
use Think\Controller;


class QuanxianDoController extends Controller {
	//获取某个角色的权限
    public function oneqx()
    {
        $jueseid=addslashes($_GET['nowclickid']);
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $findqxarr=$qxbase->query("select * from crm_quanxian where qx_id='$jueseid' and qx_company='$fid' limit 1");
        $qxonestart='0';
        foreach($findqxarr[0] as $k=>$v)
        {
            if($k=='qx_xs_ck')
            {
                $qxonestart='1';
            }
            if($qxonestart=='1')
            {
                if($v=='1')
                $qxArr.=$k.',';
            }
        }
        echo substr($qxArr,0,-1).'@@'.$findqxarr[0]['qx_data_qx'];
    }
    //改变权限状态
    public function changeqxval()
    {
        $changefiled=addslashes($_GET['changefiled']);
        $changejuese=addslashes($_GET['changejuese']);
        $changefiledvalue=addslashes($_GET['changefiledvalue']);
        $changefiledname=addslashes($_GET['changefiledname']);
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        if($changefiled==''||$changejuese==''||$changefiledvalue=='')
        {
            echo 2;
            die();
        }
        $qxnameArr=array(
            'qx_xs_ck'=>'线索查看',
            'qx_xs_xz'=>'线索新增',
            'qx_xs_bj'=>'线索编辑',
            'qx_xs_sc'=>'线索删除',
            'qx_xs_dr'=>'线索导入',
            'qx_xs_dc'=>'线索导出',
            'qx_xs_zy'=>'线索转移给他人',
            'qx_kh_ck'=>'客户查看',
            'qx_kh_xz'=>'客户新增',
            'qx_kh_bj'=>'客户编辑',
            'qx_kh_sc'=>'客户删除',
            'qx_kh_dr'=>'客户导入',
            'qx_kh_dc'=>'客户导出',
            'qx_kh_zy_tr'=>'客户转移给他人',
            'qx_kh_zy_gh'=>'客户转移到公海',
            'qx_kh_dr_gh'=>'客户导入到公海',
            'qx_kh_ck_gh'=>'查看客户公海',
            'qx_lx_ck'=>'联系人查看',
            'qx_lx_xz'=>'联系人新增',
            'qx_lx_bj'=>'联系人编辑',
            'qx_lx_sc'=>'联系人删除',
            'qx_lx_dr'=>'联系人导入',
            'qx_lx_dc'=>'联系人导出',
            'qx_sj_ck'=>'商机查看',
            'qx_sj_xz'=>'商机新增',
            'qx_sj_bj'=>'商机编辑',
            'qx_sj_sc'=>'商机删除',
            'qx_sj_dr'=>'商机导入',
            'qx_sj_dc'=>'商机导出',
            'qx_sj_zy'=>'商机转移给他人',
            'qx_ht_ck'=>'合同查看',
            'qx_ht_xz'=>'合同新增',
            'qx_ht_bj'=>'合同编辑',
            'qx_ht_sc'=>'合同删除',
            'qx_ht_dr'=>'合同导入',
            'qx_ht_dc'=>'合同导出',
            'qx_ht_zy'=>'合同转移给他人',
            'qx_cp_ck'=>'产品查看',
            'qx_cp_xz'=>'产品新增',
            'qx_cp_bj'=>'产品编辑',
            'qx_cp_sc'=>'产品删除',
            'qx_cp_dr'=>'产品导入',
            'qx_cp_dc'=>'产品导出',
            'qx_cp_fl'=>'产品分类设置',
            'qx_gj_sc'=>'跟进记录删除',
            'qx_gj_dr'=>'跟进记录导入',
            'qx_gj_dc'=>'跟进记录导出',
            'qx_zs_ck'=>'知识库查看',
            'qx_zs_xz'=>'知识库新增',
            'qx_zs_bj'=>'知识库编辑',
            'qx_zs_sc'=>'知识库删除',
            'qx_zs_zd'=>'知识库置顶',
            'qx_zs_sz'=>'知识库版块设置',
            'qx_bb_dc'=>'报表导出',
            'qx_bb_ck'=>'报表查看',
            'qx_xt_ckbmyh'=>'查看部门和用户',
            'qx_xt_ckjsqx'=>'查看角色权限',
            'qx_xt_ckgsxx'=>'查看公司信息',
            'qx_xt_ggsz'=>'设置公告',
            'qx_xt_szyjmb'=>'设置业绩目标',
            'qx_xt_ccsz'=>'设置客户查重',
            'qx_xt_ghsz'=>'设置公海',
            'qx_xt_bgsz'=>'设置工作报告',
            'qx_xt_sbsz'=>'设置数据上报',
            'qx_xt_hjzx'=>'设置呼叫中心',
            'qx_xt_zdyzd'=>'设置自定义业务字段',
            'qx_xt_zdycs'=>'设置自定义业务参数',
            'qx_xt_zdysp'=>'设置自定义审批',
            'qx_xt_cxrz'=>'查询日志',
            'qx_xt_szbmyh'=>'设置部门用户',
            'qx_xt_szjsqx'=>'设置角色权限',
            'qx_xt_bjgsxx'=>'编辑公司信息',
            'qx_xt_ckyjmb'=>'查看业绩目标',
            'qx_xt_gzbgdc'=>'导出工作报告'
        );
        $baseval=array("true"=>'1',"false"=>'0');
        $qxdo=array("true"=>'开启',"false"=>'关闭');
        $qxbase=M("quanxian");
        $qxbase->query("update crm_quanxian set $changefiled='".$baseval[$changefiledvalue]."' where qx_id='$changejuese' and qx_company='$fid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','".$changefiledname.$qxdo[$changefiledvalue].$qxnameArr[$changefiled]."权限','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
    }
    //修改角色名
    public function jsedit()
    {
        $editjsid=addslashes($_GET['editjsid']);
        $editnewname=addslashes($_GET['editnewname']);
        if($editjsid==''||$editnewname=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $cfjs=$qxbase->query("select * from crm_quanxian where qx_name='$editnewname' and qx_company='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        $qxbase->query("update crm_quanxian set qx_name='".$editnewname."' where qx_id='$editjsid' and qx_company='$fid' limit 1");

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
        $deljsid=addslashes($_GET['jsid']);
        $deljsname=addslashes($_GET['jsname']);
        if($deljsid==''||$deljsname=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $qxbase->query("delete from crm_quanxian where qx_id='$deljsid' and  qx_company='$fid' limit 1");

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
        $addnewname=addslashes($_GET['addnewname']);
        if($addnewname=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $cfjs=$qxbase->query("select * from crm_quanxian where qx_name='$addnewname' and qx_company='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        for($a=0;$a<74;$a++)
        {
            $valstr.=",'0'";
        }
        $qxbase->query("insert into crm_quanxian values('','$addnewname','1','$fid'".$valstr.")");

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
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $newjsarr=$qxbase->query("select qx_id,qx_name from crm_quanxian where qx_company='$fid' or qx_company='0' ");
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
        $copyfromid=addslashes($_GET['copyfromid']);
        $copyjsnameinput=addslashes($_GET['copyjsnameinput']);
        if($copyfromid==''||$copyjsnameinput=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $qxbase=M("quanxian");
        $cfjs=$qxbase->query("select * from crm_quanxian where qx_name='$addnewname' and qx_company='$fid'");
        if(count($cfjs)>0)
        {
            echo 3;
            die();
        }
        //获取复制的角色数据
        $fromjsdata=$qxbase->query("select * from crm_quanxian where qx_id='$copyfromid' limit 1");
        foreach($fromjsdata[0] as $k=>$v )
        {
            if($k!='qx_id'&&$k!='qx_name')
            {
                if($k=='qx_company')
                {
                    $copyinsertstr.=",'$fid'";
                }
                else
                {
                    $copyinsertstr.=",'$v'";
                }
            }
        }
        $qxbase->query("insert into crm_quanxian values('','$copyjsnameinput'$copyinsertstr)");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','2','".cookie("user_id")."','0','0','0','0','0','复制角色:$copyjsnameinput','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
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