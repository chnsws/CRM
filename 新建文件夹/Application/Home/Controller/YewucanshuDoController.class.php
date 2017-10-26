<?php
namespace Home\Controller;
use Think\Controller;


class YewucanshuDoController extends Controller {
    public $pageidarr=array(
            "paixu_xiansuo"=>"1",
            "paixu_kehu"=>"2",
            "paixu_lianxiren"=>"4",
            "paixu_shangji"=>"5",
            "paixu_hetong"=>"6",
            "paixu_qita"=>"7",
            );
    //修改排序
    public function editpaixu()
    {
        $thistableid=addslashes($_POST['thistableid']);
        $shunxu=addslashes(substr($_POST['shunxu'],0,-1));
        if($thistableid==''||$shunxu=='')
        {
            echo 2;
            die;   
        }
        $lastnum=substr($thistableid,-1,1);
        $headstr=substr($thistableid,0,-1);
        $pageidarr=$this->pageidarr;
        $pageid=$pageidarr[$headstr].$lastnum;//插入排序数据库的px_mod

        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）

        $pxbase=M("paixu");
        $ishave=$pxbase->query("select px_id from crm_paixu where px_yh='$fid' and px_mod='$pageid' ");
        if(count($ishave)>0)
        {
            $pxbase->query("update crm_paixu set px_px='$shunxu' where px_yh='$fid' and px_mod='$pageid' limit 1");
        }
        else
        {
            $pxbase->query("insert into crm_paixu values('','$shunxu','$fid','$pageid')");
        }
        echo 1;
    }
    //修改参数值
    public function editcsval()
    {
        $nowpageid=addslashes($_GET['nowpageid']);
        $newval=addslashes($_GET['newval']);
        $trid=addslashes($_GET['trid']);
        $thistagname=addslashes($_GET['thistagname']);
        $isknx=addslashes($_GET['isknx']);

        $pageidarr=$this->pageidarr;
        $lastnum=substr($nowpageid,-1,1)-1;
        $headstr=substr($nowpageid,0,-1);
        $pageid=$pageidarr[$headstr];    //ywcs_yw中存的值
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');

        $csbase=M("ywcs");
        $csbasearr=$csbase->query("select ywcs_data from crm_ywcs where ywcs_yw='$pageid' and ywcs_yh='$fid' limit 1");
        $csdataarr=json_decode($csbasearr[0]['ywcs_data'],true);
        
        if($isknx=='0')
        {
            $csdataarr[$lastnum][$trid]=$newval;
            $rzstr="修改了".$thistagname."的".$newval."参数";
        }
        if($isknx=='1')
        {
            $csdataarr[$lastnum]['knx'][$trid]=$newval;
            $csname=$csdataarr[$lastnum][$trid];
            $rzstr="将".$thistagname."中".$csname."的签单可能性修改为".$newval."%";
        }
        if($isknx=='3')
        {
            $csboxval=$newval=='true'?'1':'2';
            $rzboxval=$newval=='true'?'开启':'关闭';
            $csdataarr[$lastnum]['qy'][$trid]=$csboxval;
            $csname=$csdataarr[$lastnum][$trid];
            $rzstr=$rzboxval.$thistagname."中".$csname.'参数';
        }
        $newjsonstr=json_encode($csdataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $csbase->query("update crm_ywcs set ywcs_data='$newjsonstr' where ywcs_yw='$pageid' and ywcs_yh='$fid' limit 1");
        echo $this->insertrizhi($rzstr);
    }
    //添加新参数
    public function addnewval()
    {
        $nowpageid=addslashes($_GET['nowpageid']);
        $thistagname=addslashes($_GET['thistagname']);
        $newval1=addslashes($_GET['newval1']);
        $newval2=addslashes($_GET['newval2']);
        $valnum=addslashes($_GET['valnum']);
        if($nowpageid==''||$thistagname==''||$newval1==''||$valnum=='')
        {
            echo '2';
            die();
        }
        $pageidarr=$this->pageidarr;
        $lastnum=substr($nowpageid,-1,1)-1;
        $headstr=substr($nowpageid,0,-1);
        $pageid=$pageidarr[$headstr];    //ywcs_yw中存的值
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
        
        $csbase=M("ywcs");
        $csbasearr=$csbase->query("select ywcs_data from crm_ywcs where ywcs_yw='$pageid' and ywcs_yh='$fid' limit 1");
        $csdataarr=json_decode($csbasearr[0]['ywcs_data'],true);
        $maxcs=0;
        
        foreach($csdataarr[$lastnum] as $k=>$v)
        {
            if(substr($k,0,6)!='canshu') continue;
            $thiscsnum=substr($k,6);
            $maxcs=$maxcs>$thiscsnum?$maxcs:$thiscsnum;
        }
        $maxcs=$maxcs+1;
        $canshuname='canshu'.$maxcs;
        $csdataarr[$lastnum][$canshuname]=$newval1;
        $csdataarr[$lastnum]['qy'][$canshuname]='1';
        //echo $lastnum;die;
        if($valnum=='1')
        {
            $rzstr='新增'.$thistagname.'的'.$newval1.'参数';
        }
        if($valnum=='2')
        {
            $csdataarr[$lastnum]['knx'][$canshuname]=$newval2;
            $rzstr='新增'.$thistagname.'的'.$newval1.'参数，签单可能性为'.$newval2.'%';
        }
        $newjsonstr=json_encode($csdataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $csbase->query("update crm_ywcs set ywcs_data='$newjsonstr' where ywcs_yw='$pageid' and ywcs_yh='$fid' limit 1");
        $pxbase=M("paixu");
        $lastnum=$lastnum+1;
        $pageid=$pageid.$lastnum;
        $pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$pageid' limit 1");
        //echo "select px_px from crm_paixu where px_yh='$fid' and px_mod='$pageid' limit 1";die;
        if(count($pxarr)>0)
        {
            $newpx=$pxarr[0]['px_px'].','.$canshuname;
            $pxbase->query("update crm_paixu set px_px='$newpx' where px_yh='$fid' and px_mod='$pageid' limit 1");
        }
        
        echo $canshuname.','.$this->insertrizhi($rzstr);
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
		$xitongrizhibase->query("insert into crm_rz values('','3','9','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}