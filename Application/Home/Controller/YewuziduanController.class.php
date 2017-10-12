<?php
namespace Home\Controller;
use Think\Controller;


class YewuziduanController extends DBController {
	
	
	//自定义业务字段
	public function index(){
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();
        



		$this->display();
    }
    public function get_zd_list()
    {
        parent::is_login();//登录
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();
        
        $zdtype=addslashes($_GET['zdtype']);
        if($zdtype=='')
        {
            die('0');
        }
        //字段的查询
        $zddata=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yewu='$zdtype' and zd_yh='$fid' limit 1");
        $zdarr=$zddata[0]['zd_data'];
        if(count($zddata)<1)
        {
            $is_cp=substr($zdtype,0,1);
            
            //如果为空，就插入一条默认的
            $default_zd=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yewu='$is_cp' and zd_yh='0' limit 1");
            $zdmod=M("yewuziduan");
            $zdmod->query("insert into crm_yewuziduan set zd_data='".str_replace("\\","\\\\",$default_zd[0]['zd_data'])."',zd_yh='$fid',zd_yewu='$zdtype'");
            $zdarr=$default_zd[0]['zd_data'];
        }
        //字段的排序查询
        $pxdata=parent::sel_more_data("crm_paixu","px_px","px_yh='$fid' and px_mod='$zdtype' limit 1");
        $pxarr=explode(",",$pxdata[0]['px_px']);
        //parent::rr($pxarr);
        $zdarr=json_decode($zdarr,true);
        foreach($zdarr as $k=>$v)
        {
            $zdarr[$v['id']]=$v;
            unset($zdarr[$k]);
        }
        if(count($pxarr)>0)
        {
            //如果有排序就对数组进行排序处理
            
            $zd_have_px=array();
            foreach($pxarr as $v)
            {
                if($zdarr[$v]=='')
                {
                    continue;
                }
                $zd_have_px[$v]=$zdarr[$v];
                unset($zdarr[$v]);
            }
            foreach($zdarr as $k=>$v)
            {
                $zd_have_px[$k]=$v;
            }
        }
        else
        {
            $zd_have_px=$zdarr;
        }
        //echo $zdarr;
        //parent::rr($zd_have_px);
        $zdjsonstr=json_encode($zd_have_px);
        echo $zdjsonstr;
    }
    public function get_cpfl_option()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();
        
        $flarr=parent::sel_more_data("crm_chanpinfenlei","cpfl_id,cpfl_name","cpfl_company='$fid' ");
        $rearr=array();
        foreach($flarr as $v)
        {
            $rearr[$v['cpfl_id']]=$v['cpfl_name'];
        }
        echo json_encode($rearr);
    }
    //修改排序
    public function changepx()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();

        $px=addslashes($_POST['pxstr']);
        $mod=addslashes($_POST['thismod']);
        if($px==''||$mod=='')
        {
            die('0');
        }
        //首先查询数据库有没有这条排序
        $havepx=parent::sel_more_data("crm_paixu","px_px","px_yh='$fid' and px_mod='$mod' limit 1");
        //如果有就修改，如果没有就插入一条
        $pxbase=M("paixu");
        if(count($havepx)>0)
        {
            $pxbase->query("update crm_paixu set px_px='$px' where px_yh='$fid' and px_mod='$mod' limit 1 ");
        }
        else
        {
            $pxbase->query("insert into crm_paixu set px_px='$px',px_yh='$fid',px_mod='$mod' ");
        }
        echo 1;
    }
    public function changecheckbox()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();

        $thismod=addslashes($_GET['thismod']);//mod
        $thisval=addslashes($_GET['thisval']);//0 or 1
        $thisid=addslashes($_GET['thisid']);//zdy*
        $thisname=addslashes($_GET['thisname']);//qy||bt||cy

        if($thismod==''||$thisval==''||$thisid==''||$thisname=='')
        {
            die('0');
        }
        //查询本条记录
        $zdarr=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yh='$fid' and zd_yewu='$thismod' limit 1");
        $zddata=json_decode($zdarr[0]['zd_data'],true);
        //修改json数据
        foreach($zddata as $k=>$v)
        {
            if($v['id']==$thisid)
            {
                $zddata[$k][$thisname]=$thisval;
            }
        }
        $jsondata=json_encode($zddata);
        $jsondata=str_replace("\\","\\\\",$jsondata);
        //修改数据库数据
        $zdmod=M("yewuziduan");
        $zdmod->query("update crm_yewuziduan set zd_data='$jsondata' where zd_yh='$fid' and zd_yewu='$thismod' limit 1 ");
        echo 1;
    }
    //删除字段
    public function zd_del()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();

        $thismod=addslashes($_GET['thismod']);//mod
        $thisid=addslashes($_GET['thisid']);//zdy*
        if($thismod==''||$thisid=='')
        {
            die('0');
        }

        //查询本条记录
        $zdarr=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yh='$fid' and zd_yewu='$thismod' limit 1");
        $zddata=json_decode($zdarr[0]['zd_data'],true);
        //修改json数据
        $zdname='';
        foreach($zddata as $k=>$v)
        {
            if($v['id']==$thisid)
            {
                $zdname=$v['name'];
                continue;
            }
            $newzddata[]=$v;
        }
        $jsondata=json_encode($newzddata);
        $jsondata=str_replace("\\","\\\\",$jsondata);
        //修改数据库数据
        $zdmod=M("yewuziduan");
        $zdmod->query("update crm_yewuziduan set zd_data='$jsondata' where zd_yh='$fid' and zd_yewu='$thismod' limit 1 ");
        $this->insertrizhi("删除字段：$zdname");
        echo 1;
    }
    //添加字段
    public function addzd()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();

        $thismod=addslashes($_GET['thismod']);//mod
        $newname=trim(addslashes($_GET['newname']));//新增字段名称
        if($thismod==''||$newname=='')
        {
            die('0');
        }
        //先查询本条信息
        $zdarr=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yh='$fid' and zd_yewu='$thismod' limit 1");
        $zddata=json_decode($zdarr[0]['zd_data'],true);
        //判断是否存在同样名称的字段
        foreach($zddata as $k=>$v)
        {
            if($v['name']==$newname)
            {
                die('2');
            }
        }
        //如果允许添加，查询字段的id号
        $zdid=parent::sel_more_data("crm_config","config_option_zd_num","config_name='$fid'");
        $zdid=$zdid[0]['config_option_zd_num'];
        if($zdid=='0'||$zdid=='')
        {
            $zdid='30';
        }
        //将最新编号存入数据库
        $configbase=M("config");
        $configbase->query("update crm_config set config_option_zd_num='".($zdid+1)."' where config_name='$fid' limit 1");
        //添加json数据
        $zddata[]=array(
            "id"=>"zdy".$zdid,
            "name"=>$newname,
            "qy"=>"1",
            "bt"=>"1",
            "cy"=>"1",
            "bj"=>"1",
            "sc"=>"1",
            "type"=>"0"
        );

        $jsondata=json_encode($zddata);
        $jsondata=str_replace("\\","\\\\",$jsondata);
        //修改数据库数据
        $zdmod=M("yewuziduan");
        $zdmod->query("update crm_yewuziduan set zd_data='$jsondata' where zd_yh='$fid' and zd_yewu='$thismod' limit 1 ");
        $this->insertrizhi("新增字段：$newname");
        echo 1;

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
		$xitongrizhibase->query("insert into crm_rz values('','3','8','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
    //编辑字段
    public function editzd()
    {
        parent::is_login();
        parent::have_qx("qx_sys_ywzd");//权限
        $fid=parent::get_fid();

        $thismod=addslashes($_GET['thismod']);//mod
        $newname=trim(addslashes($_GET['newname']));//字段名称
        $thisid=addslashes($_GET['thisid']);//字段id  zdy

        if($thismod==''||$newname==''||$thisid=='')
        {
            die('0');
        }
        //先查询本条信息
        $zdarr=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yh='$fid' and zd_yewu='$thismod' limit 1");
        $zddata=json_decode($zdarr[0]['zd_data'],true);
        //判断是否存在同样名称的字段
        foreach($zddata as $k=>$v)
        {
            if($v['name']==$newname)
            {
                die('2');
            }
            if($v['id']==$thisid)
            {

                $oldname=$zddata[$k]['name'];
                $zddata[$k]['name']=$newname;
            }
        }

        $jsondata=json_encode($zddata);
        $jsondata=str_replace("\\","\\\\",$jsondata);
        //修改数据库数据
        $zdmod=M("yewuziduan");
        $zdmod->query("update crm_yewuziduan set zd_data='$jsondata' where zd_yh='$fid' and zd_yewu='$thismod' limit 1 ");
        $this->insertrizhi("将字段 $oldname 改为 $newname ");
        echo 1;
    }
}



