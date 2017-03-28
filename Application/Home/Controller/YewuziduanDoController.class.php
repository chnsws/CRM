<?php
namespace Home\Controller;
use Think\Controller;


class YewuziduanDoController extends Controller {
    public $pageidarr=array(
            "paixu_xiansuo"=>'1',
            "paixu_kehu"=>'2',            
            "paixu_lianxiren"=>'4',
            "paixu_shangji"=>'5',
            "paixu_hetong"=>'6',
            "paixu_chanpin"=>'7'
            );
    public $pagenamearr=array(
            "paixu_xiansuo"=>'线索',
            "paixu_kehu"=>'客户',            
            "paixu_lianxiren"=>'联系人',
            "paixu_shangji"=>'商机',
            "paixu_hetong"=>'合同',
            "paixu_chanpin"=>'产品'
            );
    //连表3    地区1  时间2
	//业务字段排序
    public function paixu()
    {
        $thispage=addslashes($_POST['thispage']);
        $shunxu=addslashes(substr($_POST['shunxu'],0,-1));
        if($thispage==''||$shunxu=='')
        {
            echo '2';
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $pageidarr=$this->pageidarr;
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select * from crm_paixu where px_yh='$fid' and px_mod='".$pageidarr[$thispage]."'");
        if(count($pxarr)>0)
        {
            $pxbase->query("update crm_paixu set px_px='$shunxu' where px_yh='$fid' and px_mod='".$pageidarr[$thispage]."' limit 1");
        }
        else
        {
            $pxbase->query("insert into crm_paixu values('','$shunxu','$fid','".$pageidarr[$thispage]."')");
        }
        echo 1;
    }
    //添加字段
    public function addziduan()
    {
        $thispage=addslashes($_GET['thispage']);
        $ziduanname=addslashes($_GET['ziduanname']);
        if($thispage==''||$ziduanname=='')
        {
            echo '2';
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $pageidarr=$this->pageidarr;
        
        $pagenamearr=$this->pagenamearr;
        $zdbase=M("yewuziduan");
        $dataarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='".$pageidarr[$thispage]."' and zd_yh='$fid'");
        $dataarr=json_decode($dataarr[0]['zd_data'],true);
        $maxzdyid='0';
        foreach($dataarr as $k=>$v)
        {
            if($v['name']==$ziduanname)
            {
                echo '3';
                die;
            }
            $nowid=substr($v['id'],3);
            $maxzdyid=$nowid>$maxzdyid?$nowid:$maxzdyid; 
            $newkey=$k;
        }
        $maxzdyid=$maxzdyid+1;
        $newid='zdy'.$maxzdyid;
        $dataarr[$newkey+1]=array(
            "id"=>$newid,
            "name"=>$ziduanname,
            "qy"=>'1',
            "bt"=>'0',
            "cy"=>'0',
            "bj"=>'1',
            "sc"=>'1',
            "type"=>'0'
        );
        $jsonstr=str_replace('\\','\\\\',json_encode($dataarr));
        $zdbase->query("update crm_yewuziduan set zd_data='$jsonstr' where zd_yewu='".$pageidarr[$thispage]."' and zd_yh='$fid'");
        //将新添加的字段加入到排序表中
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='".$pageidarr[$thispage]."'");
        $pxpx=$pxarr[0]['px_px'].','.$newid;
        $pxbase->query("update crm_paixu set px_px='$pxpx' where px_yh='$fid' and px_mod='".$pageidarr[$thispage]."' limit 1");
        
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','8','".cookie("user_id")."','0','0','0','0','0','新增".$pagenamearr[$thispage]."字段".$ziduanname."','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        echo '1';
    }
    //修改值（启用、必填、常用）时执行的方法
    public function changecheckbox()
    {
        $nowpage=addslashes($_GET['nowpage']);
        $changeval=addslashes($_GET['changeval']);
        $changename=addslashes($_GET['changename']);
        if($nowpage==''||$changeval==''||$changename=='')
        {
            echo 2;
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $checkval=$changeval=='true'?'1':'0';
        $changetype=substr($changename,0,2);
        $changeid=substr($changename,2);
        $pageidarr=$this->pageidarr;
        $pagenamearr=$this->pagenamearr;
        $pageval=$pageidarr[$nowpage];
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        $dataarr=json_decode($zdarr[0]['zd_data'],true);
        foreach($dataarr as $k=>$v)
        {
            if($v['id']==$changeid)
            {
                $dataarr[$k][$changetype]=$checkval;
                $updatename=$v['name'];
                break;
            }
        }
        $newjsonstr=json_encode($dataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $zdbase->query("update crm_yewuziduan set zd_data='$newjsonstr' where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        
        echo $this->insertrizhi("修改了".$pagenamearr[$nowpage]."的".$updatename."字段");
    }
    //修改字段名称方法
    public function changename()
    {
        $nowpage=addslashes($_GET['nowpage']);
        $newname=addslashes($_GET['newname']);
        $changeid=addslashes($_GET['changeid']);
        if($nowpage==''||$newname==''||$changeid=='')
        {
            echo 2;
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $pageidarr=$this->pageidarr;
        $pagenamearr=$this->pagenamearr;
        $pageval=$pageidarr[$nowpage];
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        $dataarr=json_decode($zdarr[0]['zd_data'],true);
        foreach($dataarr as $k=>$v)
        {
            if($v['id']==$changeid)
            {
                $dataarr[$k]['name']=$newname;
                break;
            }
        }
        $newjsonstr=json_encode($dataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $zdbase->query("update crm_yewuziduan set zd_data='$newjsonstr' where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        echo $this->insertrizhi("修改了".$pagenamearr[$nowpage]."的".$newname."的字段名称");
    }
    //延迟加载其他页面
    public function loadpage()
    {
        $nowpage=addslashes($_GET['thispage']);
        $pageidarr=$this->pageidarr;
        $pageval=$pageidarr[$nowpage];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='$pageval' limit 1");
        $json2arr=json_decode($zdarr[0]['zd_data'],true);
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$pageval'");

        if(count($pxarr)>0)
		{
			$pxarr=explode(",",$pxarr[0]['px_px']);
			foreach($pxarr as $pxv)
			{
				foreach($json2arr as $v)
				{
					if($v['id']==$pxv)
					{
						$qy=$v['qy']=='0'?'':'checked';
						$bt=$v['bt']=='0'?'':'checked';
						$cy=$v['cy']=='0'?'':'checked';
						if($v['bj']=='0')
						{
							$instyle1="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
							$instyle2="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
							$instyle3="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
						}
						else
						{
							$instyle1="<input type='checkbox' $qy name='qy".$v['id']."'>";
							$instyle2="<input type='checkbox' $bt name='bt".$v['id']."'>";
							$instyle3="<input type='checkbox' $cy name='cy".$v['id']."'>";
						}
						$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' onmousedown='tuozhuai()'><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td><a onclick=bianji('".$v['id']."')>编辑</a></td></tr>";
						continue 2; 
					}
				}
			}
		}
		else
		{
			foreach($json2arr as $v)
			{
				$qy=$v['qy']=='0'?'':'checked';
				$bt=$v['bt']=='0'?'':'checked';
				$cy=$v['cy']=='0'?'':'checked';
				if($v['bj']=='0')
				{
					$instyle1="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
					$instyle2="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
					$instyle3="<input type='checkbox' checked  disabled='disabled'><span class='teshu'>(特殊字段，不能修改)</span>";
				}
				else
				{
					$instyle1="<input type='checkbox' $qy name='qy".$v['id']."'>";
					$instyle2="<input type='checkbox' $bt name='bt".$v['id']."'>";
					$instyle3="<input type='checkbox' $cy name='cy".$v['id']."'>";
				}
				$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' onmousedown='tuozhuai()'><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td><a onclick=bianji('".$v['id']."')>编辑</a></td></tr>";
			}
		}
        echo $tablestr;

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
}