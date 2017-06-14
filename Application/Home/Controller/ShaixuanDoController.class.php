<?php
namespace Home\Controller;
use Think\Controller;


class ShaixuanDoController extends Controller {
    public $ywarr=array(
            '7'=>"客户"
        );
    //启用禁用
    public function sxqy(){
        $cval=addslashes($_GET['cval']);
        $thisyewu=addslashes($_GET['thisyewu']);
        $flid=addslashes($_GET['flid']);
        $flname=addslashes($_GET['flname']);
        if($cval==''||$thisyewu=='')
        {
            echo '2';
            die;
        }
        $ywarr=$this->ywarr;
        $rzstr=$ywarr[$thisyewu];
        //如果是产品，组合
        if($thisyewu=='7')
        {
            if($flid=='')
            {
                echo 2;die;
            }
            $thisyewu=$thisyewu.','.$flid;
            $rzstr="产品分类：".$flname.' 的';
        }
        
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $sxbase=M("shaixuan");
        $iscz=$sxbase->query("select * from crm_shaixuan where sx_yh='$fid' and sx_yewu='$thisyewu' ");
        if(count($iscz))
        {
            $sxbase->query("update crm_shaixuan set sx_qy='$cval' where sx_yh='$fid' and sx_yewu='$thisyewu'");
        }
        else
        {
            $sxbase->query("insert into crm_shaixuan values('','','$cval','$thisyewu','$fid','')");
        }
        $kq=$cval=='1'?'开启':'关闭';
        echo $this->insertrizhi($kq."了".$rzstr."筛选");
    }
    //保存设置
    public function bcsz()
    {
        $qyid=addslashes($_GET['qyid']);
        $selectval=addslashes($_GET['selectval']);
        $qjnum=addslashes($_GET['qjnum']);
        $yewu=addslashes($_GET['yewu']);
        $flid=addslashes($_GET['flid']);
        $flname=addslashes($_GET['flname']);
        if($yewu=='')
        {
            echo '2';
        }
        $ywarr=$this->ywarr;
        $rzstr=$ywarr[$yewu];
        if($yewu=='7')
        {
            $yewu=$yewu.','.$flid;
            $rzstr="产品分类：".$flname." 的";
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $injson='';
        if($qyid!=''&&$selectval!='')
        {
            $qyarr=explode(",",$qyid);
            $selarr=explode(",",$selectval);
            $qjarr=explode(",",$qjnum);
            foreach($qyarr as $k=>$v)
            {
                $sqlarr[$v]["qy"]=1;
                $sqlarr[$v]["xx"]=$selarr[$k];
                $sqlarr[$v]["qj"]=$qjarr[$k];
            }
            $injson=json_encode($sqlarr);
        }
        $sxbase=M("shaixuan");
        $iscz=$sxbase->query("select sx_id from crm_shaixuan where sx_yh='$fid' and sx_yewu='$yewu' limit 1 ");
        if(count($iscz))
        {
            $sxbase->query("update crm_shaixuan set sx_data ='$injson' where sx_yh='$fid' and sx_yewu='$yewu' limit 1");
        }
        else
        {
            $sxbase->query("insert into crm_shaixuan values('','$injson','1','$yewu','$fid','')");
        }
        echo $this->insertrizhi("更新了".$rzstr."筛选设置");
    }
    //生成模板
    public function createmb()
    {
        $yewu=addslashes($_GET['thisyewu']);
        $flid=addslashes($_GET['flid']);
        $flname=addslashes($_GET['flname']);
        if($yewu=='7')
        {
            $yewu=$yewu.','.$flid;
        }
        if($yewu == '') die;
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        //查询筛选设置表
        $sxbase=M("shaixuan");
        $sxbasearr=$sxbase->query("select * from crm_shaixuan where sx_yh='$fid' and sx_yewu='$yewu' limit 1");
        $sxarr=$sxbasearr[0];
        if($sxarr['sx_qy']!='1') die;
        if($sxarr['sx_data']=='')
        {
            echo 2;
            die;
        }
        $sxjsonarr=json_decode($sxarr['sx_data'],true);
        foreach($sxjsonarr as $k=>$v)
        {
            if($v['qy']!='1')   continue;
            if($v['xx']=='1'||$v['xx']=='2'||$v['xx']=='5') $needselbase=1;//需不需要查询数据库
            $needsx[$k]=$k;
            $sxtj[$k]=$v['xx'];
            $qj[$k]=$v['qj'];
        }
        $ywarr=$this->ywarr;
        $rzstr=$ywarr[$yewu];
        if(substr($yewu,0,1)=='7')//产品筛选判断
        {
            $rzstr="产品分类：".$flname." 的";
            if($needselbase=='1')
            {
                $cpbase=M("chanpin");
                $cpbasearr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$flid."\"%' ");
                foreach($cpbasearr as $cprow)
                {
                    $rowjsonarr=json_decode($cprow['cp_data'],true);
                    foreach($needsx as $k)
                    {
                        $thisstr=$rowjsonarr[$k];
                        if($thisstr!='')
                        $cpsxarr[$k][$thisstr]=$thisstr;//去重
                    }
                }
            }
            
            foreach($needsx as $k)//k=zdy1
            {
                $intarr='';//最大值的初始化
                if($sxtj[$k]=='1'||$sxtj[$k]=='2'||$sxtj[$k]=='5')//125都是要取唯一值的
                {
                    if($sxtj[$k]=='5')//5是自动判断区间
                    {
                        foreach($cpsxarr[$k] as $v)
                        {
                            $intarr[$v]=(int)$v;
                        }
                        ksort($intarr);
                        $minval=reset($intarr);//最小值
                        $maxval=end($intarr);//最大值
                        if($qj[$k]=='') $injson[$k]['data']='';
                        else $injson[$k]['data']=$this->qujian($maxval,$qj[$k]);
                    }
                    else
                    {
                        $newarr12=$cpsxarr[$k];
                        ksort($newarr12);
                        $injson[$k]['data']=$newarr12;
                    }
                }
                $injson[$k]['tj']=$sxtj[$k];
            }
        }
        if($yewu=='123456')//其他模块的筛选
        {
            echo '....';
            die;
        }
        //echo "<pre>";print_r($injson);die;
        $injsonstr=json_encode($injson);
        $injsonstr=str_replace('\\','\\\\',$injsonstr);
        $sxcbase=M("sx_cache");
        $iscc=$sxcbase->query("select * from crm_sx_cache where sxc_yewu='$yewu' and sxc_yh='$fid' limit 1 ");
        if(count($iscc)<1)
        {
            $sxcbase->query("insert into crm_sx_cache values ('','".$injsonstr."','$yewu','$fid')");
        }
        else
        {
            $sxcbase->query("update crm_sx_cache set sxc_data='".$injsonstr."' where sxc_yewu='$yewu' and sxc_yh='$fid' limit 1 ");
        }
        $nowtime=date("Y-m-d H:i:s",time());
        $sxbase->query("update crm_shaixuan set sx_time='$nowtime' where sx_yewu='$yewu' and sx_yh='$fid' limit 1");
        
        $rzr=$this->insertrizhi("更新了".$rzstr."筛选模块");
        echo $rzr.'#'.$nowtime;
    }

    //自动区间（旧）
    public function qujian2($a,$qjnum)
    {
        $a=$a>1?number_format($a,0,'',''):ceil($a);
        $c=strlen($a);
        $aaa='1';
        for($aa=0;$aa<$c-1;$aa++)
        {
            $aaa=$aaa*10;
        }
        $zzz=ceil($a/$aaa)*$aaa;

        $z1=floor($zzz/$qjnum);
        $lastnum=$z1;
        for($cc=1;$cc<=$qjnum;$cc++)
        {
            if($cc==1)
            {
                $nownum=($cc*$z1);
                $tjarr[]='小于'.$nownum;
            }
            else if($cc==$qjnum)
            {
                $tjarr[]='大于'.$lastnum;
            }
            else
            {
                $nownum=$z1>1?(($cc*$z1)-1):(($cc*$z1)-0.1);
                $tjarr[]=$lastnum.'-'.$nownum;
            }
            $lastnum=$cc*$z1;
        }
        return $tjarr;
    }
    //自动生成区间(新)
    public function qujian($a,$qjnum)
    {
        $olda=$a;
        $a=$a>1?number_format($a,0,'',''):ceil($a);
        $c=strlen($a);
        $aaa='1';
        for($aa=0;$aa<$c-1;$aa++)
        {
            $aaa=$aaa*10;
        }
        $zzz=ceil($a/$aaa)*$aaa;
        $roundnum=0;
        if($olda<1)
        {
            $dnum=explode(".",$olda);
            $roundnum=strlen($dnum[1]);
        }
        $z1=$olda>1?floor($zzz/$qjnum):round(($zzz/$qjnum),$roundnum);
        $lastnum=$z1;
        $jian=1;
        for($s=0;$s<$roundnum;$s++)
        {
            $jian=$jian/10;
        }
        for($cc=1;$cc<=$qjnum;$cc++)
        {
            if($cc==1)
            {
                $nownum=($cc*$z1);
                $tjarr[]='小于'.$nownum;
            }
            else if($cc==$qjnum)
            {
                $tjarr[]='大于'.$lastnum;
            }
            else
            {
                $nownum=$z1>1?(($cc*$z1)-1):(($cc*$z1)-$jian);
                $tjarr[]=$lastnum.'-'.$nownum;
            }
            $lastnum=$cc*$z1;
        }
        return $tjarr;
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
		$xitongrizhibase->query("insert into crm_rz values('','3','11','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}