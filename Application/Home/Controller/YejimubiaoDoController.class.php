<?php
namespace Home\Controller;
use Think\Controller;


class YejimubiaoDoController extends DBController {
	//模板框架
    public function chanpinload(){
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
        $cploadtype=addslashes($_GET['cploadtype']);
        if($cploadtype=='')
        {
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $cpbase=M("chanpin");
        $cpflbase=M("chanpinfenlei");
        if($cploadtype=='1')
        {
            $cpoption="<option value=''>请选择产品</option>";
            $cparr=$cpbase->query("select cp_id,cp_data from crm_chanpin where cp_yh='$fid'");
            foreach($cparr as $v)
            {
                $decodedata=json_decode($v['cp_data'],true);
                $cpoption.="<option value='".$v['cp_id']."'>".$decodedata['zdy0']."</option>";
            }
        }
        else
        {
            $cpoption="<option value=''>请选择产品分类</option>";
            $cpflarr=$cpflbase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid'");
            foreach($cpflarr as $v)
            {
                $cpoption.="<option value='".$v['cpfl_id']."'>".$v['cpfl_name']."</option>";
            }

        }
        echo $cpoption;
    }
    //新增业绩目标
    public function yjmbadd()
    {
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
        $addniandu=addslashes($_GET['addniandu']);
        $addyejitype=addslashes($_GET['addyejitype']);
        $yjmbtypemore=addslashes($_GET['yjmbtypemore']);

        if($addniandu==''||$addyejitype=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $yjmbbase=M("yjmb"); 
        //查重操作
        $cpselval=array('6','7','8','9');
        if(in_array($addyejitype,$cpselval))
        {
            $wherestr=" and yjmb_type_more='$yjmbtypemore' ";
            if($addyejitype=='6'||$addyejitype=='7')
            {
                $cpbase=M("chanpin");
                $cpname=$cpbase->query("select cp_data from crm_chanpin where cp_id='$yjmbtypemore' limit 1");
                $decodearr=json_decode($cpname[0]['cp_data'],true);
                $rzcpname=$decodearr['zdy0'];
            }
            else
            {
                $cpbase=M("chanpinfenlei");
                $cpname=$cpbase->query("select cpfl_name from crm_chanpinfenlei where cpfl_id='$yjmbtypemore' limit 1");
                $rzcpname=$cpname[0]['cpfl_name'];
            }
            $rzcpname='('.$rzcpname.')';
        }
        $mbname=array(
            '1'=>'赢单商机金额',
            '2'=>'赢单商机数',
            '3'=>'合同回款金额',
            '4'=>'合同金额',
            '5'=>'合同数',
            '6'=>'产品销量',
            '7'=>'产品销售额',
            '8'=>'产品分类销量',
            '9'=>'产品分类销售额'
        );
        $iscunzai=$yjmbbase->query("select yjmb_id from crm_yjmb where yjmb_yh='$fid' and yjmb_nd='$addniandu' and yjmb_type='$addyejitype'  $wherestr  limit 1");
        if(count($iscunzai)>0)
        {
            echo "3";
            die();
        }
        $isinsert=$yjmbbase->query("insert into crm_yjmb values('','$fid','$addniandu','$addyejitype','$yjmbtypemore')");
        if($isinsert=='')
        {
            echo 2;
            die;
        }
        $lastinsertid=$yjmbbase->query("select yjmb_id from crm_yjmb where yjmb_yh='$fid' and yjmb_nd='$addniandu' and yjmb_type='$addyejitype'  $wherestr limit 1");
        //echo $lastinsertid[0]['yjmb_id'];die;
        //生成每个用户的该项业绩
        $userbase=M("user");
        $userarr=$userbase->query("select user_id from crm_user where (user_id='$fid' or user_fid='$fid') and user_del='0' ");
        $insertstr='';
        foreach($userarr as $v)
        {
            $insertstr.="('','".$v['user_id']."','".$lastinsertid[0]['yjmb_id']."','$fid','0','0','0','0','0','0','0','0','0','0','0','0'),";
        }
        $insertstr=substr($insertstr,0,-1);
        $yjmbmorebase=M("yjmb_user");
        $yjmbmorebase->query("insert into crm_yjmb_user values $insertstr");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','5','".cookie("user_id")."','0','0','0','0','0','新增".$addniandu."年 ".$mbname[$addyejitype].$rzcpname." 业绩目标','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        echo '1';
    }
    //复制业绩目标
    public function yjmbcopy()
    {
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
        $yjid=addslashes($_GET['yjid']);
        $addniandu=addslashes($_GET['addniandu']);
        $addyejitype=addslashes($_GET['addyejitype']);
        $yjmbtypemore=addslashes($_GET['yjmbtypemore']);

        if($addniandu==''||$addyejitype==''||$yjid=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        //获得产品名称，用于添加日志
        $yjmbbase=M("yjmb"); 
        $cpselval=array('6','7','8','9');
        if(in_array($addyejitype,$cpselval))
        {
            $wherestr=" and yjmb_type_more='$yjmbtypemore' ";
            if($addyejitype=='6'||$addyejitype=='7')
            {
                $cpbase=M("chanpin");
                $cpname=$cpbase->query("select cp_data from crm_chanpin where cp_id='$yjmbtypemore' limit 1");
                $decodearr=json_decode($cpname[0]['cp_data'],true);
                $rzcpname=$decodearr['zdy0'];
            }
            else
            {
                $cpbase=M("chanpinfenlei");
                $cpname=$cpbase->query("select cpfl_name from crm_chanpinfenlei where cpfl_id='$yjmbtypemore' limit 1");
                $rzcpname=$cpname[0]['cpfl_name'];
            }
            $rzcpname='('.$rzcpname.')';
        }
        $mbname=array(
            '1'=>'赢单商机金额',
            '2'=>'赢单商机数',
            '3'=>'合同回款金额',
            '4'=>'合同金额',
            '5'=>'合同数',
            '6'=>'产品销量',
            '7'=>'产品销售额',
            '8'=>'产品分类销量',
            '9'=>'产品分类销售额'
        );
        //查重操作
        $iscunzai=$yjmbbase->query("select yjmb_id from crm_yjmb where yjmb_yh='$fid' and yjmb_nd='$addniandu' and yjmb_type='$addyejitype'  $wherestr  limit 1");
        if(count($iscunzai)>0)
        {
            echo "3";
            die();
        }
        $isinsert=$yjmbbase->query("insert into crm_yjmb values('','$fid','$addniandu','$addyejitype','$yjmbtypemore')");
        if($isinsert=='')
        {
            echo 2;
            die;
        }
        $lastinsertid=$yjmbbase->query("select yjmb_id from crm_yjmb where yjmb_yh='$fid' and yjmb_nd='$addniandu' and yjmb_type='$addyejitype'  $wherestr limit 1");

        $yjmbtypemorebase=M("yjmb_user");
        $yjmarr=$yjmbtypemorebase->query("select * from crm_yjmb_user where yjm_yid='$yjid'");
        $insertstr='';
        foreach($yjmarr as $v)
        {
            $insertstr.='(';
            foreach($v as $k=>$val)
            {
                if($k=='yjm_id')
                {
                    $insertstr.="'',";
                }
                else if($k=='yjm_yid')
                {
                    $insertstr.="'".$lastinsertid[0]['yjmb_id']."',";
                }
                else
                {
                    $insertstr.="'".$val."',";
                }
            }
            $insertstr=substr($insertstr,0,-1);
            $insertstr.='),';
        }
        $insertstr=substr($insertstr,0,-1);
        $yjmbtypemorebase->query("insert into crm_yjmb_user values $insertstr ");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','5','".cookie("user_id")."','0','0','0','0','0','复制".$addniandu."年 ".$mbname[$addyejitype].$rzcpname." 业绩目标','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo 1;
    }

    //删除业绩目标
    public function yjmbdel()
    {
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
        $yjid=addslashes($_GET['yjid']);
        if($yjid=='')
        {
            echo 2;die;
        }
        $yjbase=M("yjmb");
        $yjuserbase=M("yjmb_user");
        $yjbase->query("select yjmb_nd,yjmb_type,yjmb_type_more from crm_yjmb where yjmb_id='$yjid' limit 1");


        $cpselval=array('6','7','8','9');
        if(in_array($addyejitype,$cpselval))
        {
            $wherestr=" and yjmb_type_more='$yjmbtypemore' ";
            if($addyejitype=='6'||$addyejitype=='7')
            {
                $cpbase=M("chanpin");
                $cpname=$cpbase->query("select cp_data from crm_chanpin where cp_id='$yjmbtypemore' limit 1");
                $decodearr=json_decode($cpname[0]['cp_data'],true);
                $rzcpname=$decodearr['zdy0'];
            }
            else
            {
                $cpbase=M("chanpinfenlei");
                $cpname=$cpbase->query("select cpfl_name from crm_chanpinfenlei where cpfl_id='$yjmbtypemore' limit 1");
                $rzcpname=$cpname[0]['cpfl_name'];
            }
            $rzcpname='('.$rzcpname.')';
        }


        $yjbase->query("delete from crm_yjmb where yjmb_id='$yjid' limit 1");
        $yjuserbase->query("delete from crm_yjmb_user where yjm_yid='$yjid' ");
        echo 1;
    }
    //业绩详情里面对用户的单月业绩进行修改
    public function edituseryj()
    {
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
        //数据接收
        $trid=addslashes($_POST['trid']);
        $rzbz=addslashes($_POST['rzbz']);
        $newval=addslashes($_POST['newval']);
        $mnum=addslashes($_POST['mnum'])-1;
        //缓存解析
        $bmlvarr=json_decode($bmlvarr,true);
        $bmsumarr=json_decode($bmsumarr,true);
        //空值判断
        if($trid==''||$rzbz==''||$newval==''||$mnum=='')
        {
            echo 2;
            die();
        }
        //数据库修改
        $yjuserbase=M("yjmb_user");
        $updatestr='yjm_m'.$mnum;
        $yjuserbase->query("update crm_yjmb_user set $updatestr='$newval' where yjm_id='$trid' limit 1");

        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','5','".cookie("user_id")."','0','0','0','0','0','修改了".$rzbz."业绩目标','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo 1;
    }
    //重新载入部门列表
    public function bmshuaxin()
    {
        parent::is_login();
        parent::have_qx("qx_sys_yjmb");
		$moreyjid=addslashes($_GET['pageid']);
        $pagetype=addslashes($_GET['pagetype']);
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		
		$yjuserbase=M("yjmb_user");
		
		if($pagetype=='1'||$pagetype=='3'||$pagetype=='4'||$pagetype=='7'||$pagetype=='9')
		{
			$listdanwei='￥';
			$ismoney='1';
		}
		else
		{
			$listdanwei='';
			$ismoney='0';
		}
		//构造右边表格
		$yjuserarr=$yjuserbase->query("select * from crm_yjmb_user left join crm_user on yjm_uid=user_id where yjm_yid='$moreyjid' and user_del='0' ");
		foreach($yjuserarr as $v)
		{
			$sumyj='0';//每个人的总业绩
			//总量
			foreach($v as $k=>$vv)
			{
				if(substr($k,0,5)=='yjm_m')
				{
					$sumyj+=$vv;
					$companysum+=$vv;//整个公司的总业绩
				}		
			}		
			//每个部门的总业绩
			$bmsumarr[$v['user_zhu_bid']]+=$sumyj;
		}

		//部门表操作
		$bumenbase=M("department");
		$bumenArr=$bumenbase->query("select * from crm_department where bm_company='$fid' ");
		foreach($bumenArr as $bumenArrKey=>$bumenArrVal)//格式化部门分级
		{
			$bumenNewArr[$bumenArrVal['bm_id']]=array("bm_name"=>$bumenArrVal['bm_name'],"bm_fid"=>$bumenArrVal['bm_fid']);
		}
		//部门遍历排序
		foreach($bumenNewArr as $bmNewKey=>$bmNewVal)
		{
			$bumenFname[$bmNewKey]=$bumenNewArr[$bmNewVal['bm_fid']]['bm_name'];
			if($bmNewVal['bm_fid']=='0')//顶级部门
			{
				$bmLvArr[$bmNewKey]['bm_name']=$bmNewVal['bm_name'];
			}
			else
			{
				if($bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']=='0')
				{
					$bmLvArr[$bmNewVal['bm_fid']]["lv2"][$bmNewKey]["bm_name"]=$bmNewVal['bm_name'];
				}
				else
				{
					if($bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']=='0')
					{
						$bmLvArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['lv2'][$bmNewVal['bm_fid']]['lv3'][$bmNewKey]["bm_name"]=$bmNewVal['bm_name'];
					}
					else
					{
						if($bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']]['bm_fid']=='0')
						{
							$bmLvArr[$bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']]['lv2'][$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['lv3'][$bmNewVal['bm_fid']]['lv4'][$bmNewKey]["bm_name"]=$bmNewVal['bm_name'];
						
						}
						else
						{
							if($bumenNewArr[$bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']]['bm_fid']]['bm_fid']=='0')
							{
								$bmLvArr[$bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']]['bm_fid']]['lv2'][$bumenNewArr[$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['bm_fid']]['lv3'][$bumenNewArr[$bmNewVal['bm_fid']]['bm_fid']]['lv4'][$bmNewVal['bm_fid']]['lv5'][$bmNewKey]["bm_name"]=$bmNewVal['bm_name'];
							}
						}
					}
				}
			}
		}
		//总销量分级
		foreach($bmLvArr as $k=>$v)
		{
			$bmsum=$bmsumarr[$k]==''?'0':$bmsumarr[$k];
			$bmallarr[$k]+=$bmsum;
			if(count($v['lv2'])>0)
			{
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
					$bmsum=$bmsumarr[$lv2k]==''?'0':$bmsumarr[$lv2k];
					$bmallarr[$k]+=$bmsum;
					$bmallarr[$lv2k]+=$bmsum;
					if(count($lv2v['lv3'])>0)
					{
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
							$bmsum=$bmsumarr[$lv3k]==''?'0':$bmsumarr[$lv3k];
							$bmallarr[$k]+=$bmsum;
							$bmallarr[$lv2k]+=$bmsum;
							$bmallarr[$lv3k]+=$bmsum;
							if(count($lv3v['lv4'])>0)
							{
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
									$bmsum=$bmsumarr[$lv4k]==''?'0':$bmsumarr[$lv4k];
									$bmallarr[$k]+=$bmsum;
									$bmallarr[$lv2k]+=$bmsum;
									$bmallarr[$lv3k]+=$bmsum;
									$bmallarr[$lv4k]+=$bmsum;
									if(count($lv4v['lv5'])>0)
									{
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
											$bmsum=$bmsumarr[$lv5k]==''?'0':$bmsumarr[$lv5k];
											$bmallarr[$k]+=$bmsum;
											$bmallarr[$lv2k]+=$bmsum;
											$bmallarr[$lv3k]+=$bmsum;
											$bmallarr[$lv4k]+=$bmsum;
											$bmallarr[$lv5k]+=$bmsum;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		
		//生成部门结构HTML
		foreach($bmLvArr as $k=>$v)
		{
			$bmList.="<li class='lv1 lv-on' id='id".$k."' value='1' name='1'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$v['bm_name']."</span><span class='right-span'>".$listdanwei.$this->yjmbdanwei($bmallarr[$k],$ismoney)."</span></li>";
			if(count($v['lv2'])>0)
			{
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
					$bmList.="<li class='lv2 lv-on lv1".$k."' id='id".$lv2k."' value='1' name='2'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv2v['bm_name']."</span><span class='right-span'>".$listdanwei.$this->yjmbdanwei($bmallarr[$lv2k],$ismoney)."</span></li>";
					if(count($lv2v['lv3'])>0)
					{
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
							$bmList.="<li class='lv3 lv-on lv2".$lv2k." lv1".$k."' id='id".$lv3k."' value='1' name='3'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv3v['bm_name']."</span><span class='right-span'>".$listdanwei.$this->yjmbdanwei($bmallarr[$lv3k],$ismoney)."</span></li>";
							if(count($lv3v['lv4'])>0)
							{
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
									$bmList.="<li class='lv4 lv-on lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv4k."' value='1' name='4'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv4v['bm_name']."</span><span class='right-span'>".$listdanwei.$this->yjmbdanwei($bmallarr[$lv4k],$ismoney)."</span></li>";
							
									if(count($lv4v['lv5'])>0)
									{
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
											$bmList.="<li class='lv5 lv-on lv4".$lv4k." lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv5k."' value='1' name='5'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv5v['bm_name']."</span><span class='right-span'>".$listdanwei.$this->yjmbdanwei($bmallarr[$lv5k],$ismoney)."</span></li>";
										}
									}
								}
							}
						}
					}
				}
			}
		}
        echo $bmList;
    }
    function yjmbdanwei($str,$val)
	{
		if($val=='0')
		{
			$returnstr=$str;
		}
		else
		{
			$returnstr=number_format($str,2);
		}
		return $returnstr;
	}
}