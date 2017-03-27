<?php
namespace Home\Controller;
use Think\Controller;


class OptionDoController extends Controller {
	//部门添加操作
    public function bumenadd()
    {
        $ajaxName=addslashes($_GET['newname']);
        $ajaxFid=addslashes($_GET['fid']);
        $nowloguser=cookie("user_id");
        if($ajaxFid!=''&&$ajaxName!=''&&$nowloguser!='')
        {
			if(cookie('user_fid')=='0')
                $fid=cookie('user_id');//获取所属用户（所属公司）
            else 
                $fid=cookie('user_fid');

            //部门添加操作
            $bumenbase=M("department");
			$iscf=$bumenbase->query("select * from crm_department where bm_name='".$ajaxName."' and bm_company='".$fid."'");
			if(count($iscf)>0)
			{
				echo 2;die;
			}
            $addsuccess=$bumenbase->query("insert into crm_department values('','$ajaxName','$ajaxFid','$fid')");


            //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
            $xitongrizhibase=M("rz");
            $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
            $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            $addressArr=getCity($nowip);//登录地点
            $loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
			
            $xitongrizhibase->query("insert into crm_rz values('','3','1','$nowloguser','0','0','0','0','0','新增部门$ajaxName','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
			echo 1;

        }
		else
		{
			echo 3;
		}
	}


    //部门局部刷新数据
    public function bumenshuaxin()
    {
        //获取当前登录用户的信息（在cookie中）
		$nowUserId=cookie("user_id");
		//所属用户
		if(cookie("user_fid")>0)
			$nowUserFid=cookie("user_fid");
		else
			$nowUserFid=$nowUserId;
        //部门表操作
		$bumenbase=M("department");
		$bumenArr=$bumenbase->query("select * from crm_department where bm_company='$nowUserFid' ");
		foreach($bumenArr as $bumenArrKey=>$bumenArrVal)//格式化部门分级
		{
			$bumenNewArr[$bumenArrVal['bm_id']]=array("bm_name"=>$bumenArrVal['bm_name'],"bm_fid"=>$bumenArrVal['bm_fid']);
		}
		//部门遍历排序
		foreach($bumenNewArr as $bmNewKey=>$bmNewVal)
		{
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
							else
							{

							}
						}
					}
				}
			}
		}
		//部门排序结束 $bmLvArr:部门分级数组
		$bumenoption="<option value=''>请选择部门</option>";
		//生成部门结构HTML
		foreach($bmLvArr as $k=>$v)
		{
			$bmList.="<li class='lv1 lv-on' id='id".$k."' value='1' name='1'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$v['bm_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='bmdel(".$k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='bmedit(".$k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='bmadd(".$k.")'><i class='fa fa-plus' aria-hidden='true'></i></a></span></li>";
			$bumenoption.="<option value='".$k."'>".$v['bm_name']."</option>";
			if(count($v['lv2'])>0)
			{
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
					$bmList.="<li class='lv2 lv-on lv1".$k."' id='id".$lv2k."' value='1' name='2'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv2v['bm_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='bmdel(".$lv2k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='bmedit(".$lv2k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='bmadd(".$lv2k.")'><i class='fa fa-plus' aria-hidden='true'></i></a></span></li>";
					$bumenoption.="<option value='".$lv2k."'>----".$lv2v['bm_name']."</option>";
					if(count($lv2v['lv3'])>0)
					{
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
							$bmList.="<li class='lv3 lv-on lv2".$lv2k." lv1".$k."' id='id".$lv3k."' value='1' name='3'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv3v['bm_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='bmdel(".$lv3k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='bmedit(".$lv3k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='bmadd(".$lv3k.")'><i class='fa fa-plus' aria-hidden='true'></i></a></span></li>";
							$bumenoption.="<option value='".$lv3k."'>--------".$lv3v['bm_name']."</option>";
							if(count($lv3v['lv4'])>0)
							{
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
									$bmList.="<li class='lv4 lv-on lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv4k."' value='1' name='4'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv4v['bm_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='bmdel(".$lv4k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='bmedit(".$lv4k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='bmadd(".$lv4k.")'><i class='fa fa-plus' aria-hidden='true'></i></a></span></li>";
									$bumenoption.="<option value='".$lv4k."'>------------".$lv4v['bm_name']."</option>";
									if(count($lv4v['lv5'])>0)
									{
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
											$bmList.="<li class='lv5 lv-on lv4".$lv4k." lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv5k."' value='1' name='5'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv5v['bm_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='bmdel(".$lv5k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='bmedit(".$lv5k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a></span></li>";
											$bumenoption.="<option value='".$lv5k."'>----------------".$lv5v['bm_name']."</option>";
										}
									}
								}
							}
						}
					}
				}
			}
		}
        echo $bmList.'@@'.$bumenoption;
    }

	//修改部门名称
	public function bumenedit()
	{
		$thisBmId=addslashes($_GET['thisid']);
		$thisNewName=addslashes($_GET['newname']);
		if($thisBmId!=''&&$thisNewName!='')
		{
			//查重操作
			if(cookie('user_fid')=='0')
                $fid=cookie('user_id');//获取所属用户（所属公司）
            else 
                $fid=cookie('user_fid');
			$bmbase=M("department");
			$iscf=$bmbase->query("select * from crm_department where bm_name='".$thisNewName."' and bm_company='".$fid."'");
			if(count($iscf)>0)
			{
				echo 2;die;
			}
			//更新数据库数据
			$bmbase->query("update crm_department set bm_name='".$thisNewName."' where bm_id='".$thisBmId."' limit 1");//更新部门名称
			//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
            $xitongrizhibase=M("rz");
            $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
            $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            $addressArr=getCity($nowip);//登录地点
            $loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            $xitongrizhibase->query("insert into crm_rz values('','3','1','$nowloguser','0','0','0','0','0','更新部门$thisNewName','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
			echo 1;
		}
		else
		{
			echo 3;
		}
	}
	//删除部门
	public function bumendel()
	{
		$thisBmId=addslashes($_GET['thisid']);
		$thisName=addslashes($_GET['thisname']);
		if($thisBmId!='')
		{
			if(cookie('user_fid')=='0')
                $fid=cookie('user_id');//获取所属用户（所属公司）
            else 
                $fid=cookie('user_fid');
			$bumenbase=M("department");
			$bumenbase->query("delete from crm_department where bm_company='".$fid."' and bm_id='".$thisBmId."' limit 1 ");
			//判断是否删除成功，（数据库中是否还存在这一条数据）
			$thisIdStatus=$bumenbase->query("select * from crm_department where bm_company='".$fid."' and bm_id='".$thisBmId."' ");
			if(count($thisIdStatus)=='0')//如果数据库中不存在这一条数据，则说明删除成功,然后将该部门下的所有用户的部门id清空
			{
				$userbase=M("user");
				//修改主部门为此部门的用户数据
				$userbase->query("update crm_user set user_zhu_bid='0' where user_zhu_bid='".$thisBmId."' and (user_fid='".$fid."' or user_id='".$fid."')");
				//修改辅部门为此部门的用户数据
				$userbase->query("update crm_user set user_zhu_bid='0' where user_fu_bid='".$thisBmId."' and (user_fid='".$fid."' or user_id='".$fid."')");
				//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
				$xitongrizhibase=M("rz");
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
				$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
				$addressArr=getCity($nowip);//登录地点
				$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
				$xitongrizhibase->query("insert into crm_rz values('','3','1','$nowloguser','0','0','0','0','0','删除部门$thisName','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
				echo 1;

			}
			else
			{
				echo 2;
			}
		}
	}
	//用户添加
	public function useradd()
	{
		$addusername    =addslashes($_GET['addusername']);//用户名
		$addusersex     =addslashes($_GET['addusersex']);//性别
		$adduserphone   =addslashes($_GET['adduserphone']);//手机号
		$adduseremail   =addslashes($_GET['adduseremail']);//邮箱
		$adduserjuese   =addslashes($_GET['adduserjuese']);//角色
		$adduserzhuguan =addslashes($_GET['adduserzhuguan']);//主管
		$adduserzhubm   =addslashes($_GET['adduserzhubm']);//主部门
		$adduserfubm    =addslashes($_GET['adduserfubm']);//辅部门
		//如果必填项不为空
		if($addusername&&$adduserphone&&$adduseremail&&$adduserjuese&&$adduserzhubm)
		{
			//执行添加操作
			$userbase=M("user");
			//查询手机号是否已经被注册
			$olduserinfo=$userbase->query("select * from crm_user where user_phone='".$adduserphone."' ");
			if(count($olduserinfo)>0)
			{
				echo "该手机号已被注册";
				die();
			}
			//随机6位数密码
			$chars = '0123456789';
			$suijipassword = '';
			for ( $i = 0; $i < 6; $i++ ) 
			{
				$suijipassword .= $chars[ mt_rand(0, strlen($chars) - 1) ];
			}
			$md5password=md5($suijipassword);
			if(cookie('user_fid')=='0')
                $fid=cookie('user_id');//获取所属用户（所属公司）
            else 
                $fid=cookie('user_fid');
			$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
			$companyyouxiaoqi=$userbase->query("select user_youxiaoqi from crm_user where user_id='$fid' limit 1");//使用超级管理员的身份有效期
			//进行插入操作
			$userbase->query("insert into crm_user values('','$addusername','$md5password','$suijipassword','$adduserjuese','$fid','$adduserzhuguan','$adduserzhubm','$adduserfubm','$addusersex','$adduserphone','".date("Y-m-d H:i:s",time())."','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','','$adduseremail','".date("Y-m-d H:i:s",time())."','".$companyyouxiaoqi[0]['user_youxiaoqi']."','0','1')");
			//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
			$xitongrizhibase=M("rz");
			$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
			//登录地点
			$addressArr=getCity($nowip);
			$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
			//进行插入操作
			$xitongrizhibase->query("insert into crm_rz values('','3','1','$nowloguser','0','0','0','0','0','新增用户$addusername','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
			echo '1&&'.$suijipassword;
		}
		else
		{
			echo '2';
		}
	}
	//添加或修改后刷新用户列表
	public function usershuaxin()
	{
		//获取当前登录用户的信息（在cookie中）
		$nowUserId=cookie("user_id");
		//所属用户
		if(cookie("user_fid")>0)
			$nowUserFid=cookie("user_fid");
		else
			$nowUserFid=$nowUserId;
		//部门表操作
		$bumenbase=M("department");
		$bumenArr=$bumenbase->query("select * from crm_department where bm_company='$nowUserFid' ");
		foreach($bumenArr as $bumenArrKey=>$bumenArrVal)//格式化部门分级
		{
			$bumenNewArr[$bumenArrVal['bm_id']]=array("bm_name"=>$bumenArrVal['bm_name'],"bm_fid"=>$bumenArrVal['bm_fid']);
		}
		//查询角色名称
		$quanxianbase=M("quanxian");
		$qxNameArr=$quanxianbase->query("select qx_id,qx_name from crm_quanxian where qx_company='".$nowUserId."' or qx_company='0' ");
		$zhuguanoption="<option value=''>请选择主管</option>";
		foreach($qxNameArr as $qxk=>$qxv)
		{
			$qxName[$qxv['qx_id']]=$qxv['qx_name'];
		}
		//实例化用户表
		$userbase=M("user");
		$userAllArr=$userbase->query("select * from crm_user where (user_id='$nowUserFid' or user_fid='$nowUserFid') and user_del='0'");
		$userSex=array('1'=>'男','2'=>'女');
		foreach($userAllArr as $userk=>$userv)
		{
			$userName[$userv['user_id']]=$userv['user_name'];
			$zhuguanoption.="<option value='".$userv['user_id']."'>".$userv['user_name']."</option>";//添加用户弹窗中的主管下拉框内容
		}
		
		foreach($userAllArr as $userkey=>$userval)
		{
			if($userval[user_fid]=='0')
			{
				$moveList="<li><a onclick=\"useredit('$userval[user_id]','$userval[user_name]','$userval[user_sex]','$userval[user_phone]','$userval[user_email]','$userval[user_quanxian]','$userval[user_zhuguan_id]','$userval[user_zhu_bid]','$userval[user_fu_bid]')\">编辑</a></li><li><a onclick='pwdedit($userval[user_id])'>修改密码</a></li>";
			}
			else
			{
				if($userval['user_act']=='0')
				{
					$dongjie="<a onclick='dongjie($userval[user_id],1)'>取消冻结</a>";
				}
				else
				{
					$dongjie="<a onclick='dongjie($userval[user_id],0)'>冻结</a>";
				}
				$moveList="<li><a onclick=\"useredit('$userval[user_id]','$userval[user_name]','$userval[user_sex]','$userval[user_phone]','$userval[user_email]','$userval[user_quanxian]','$userval[user_zhuguan_id]','$userval[user_zhu_bid]','$userval[user_fu_bid]')\">编辑</a></li><li><a onclick='pwdedit($userval[user_id])'>修改密码</a></li><li><a>交接</a></li><li><a onclick=\"userdel($userval[user_id],'$userval[user_name]')\">删除</a></li><li>$dongjie</li>";
			}
			$caozuoBtn="<div class='uk-button-dropdown' data-uk-dropdown style='overflow:visible;'><button class='layui-btn layui-btn-primary' style='border-radius:90px;height:30px;width:30px;line-height:30px;margin:0;padding:0;' ><i class='uk-icon-cogs'></i></button><div class='uk-dropdown uk-dropdown-small' style='border:1px solid #ccc;'><ul class='uk-nav uk-nav-dropdown'>".$moveList."</ul></div></div>";
			if($userval['user_act']=='0')
			{
				$dongjieList.="<tr style='color:#ccc'><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval[user_zhuguan_id]]."</td><td>".$bumenNewArr[$userval['user_zhu_bid']]['bm_name']."</td><td>".$bumenNewArr[$userval['user_fu_bid']]['bm_name']."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
			}
			else
			{
				$userList.="<tr><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval[user_zhuguan_id]]."</td><td>".$bumenNewArr[$userval['user_zhu_bid']]['bm_name']."</td><td>".$bumenNewArr[$userval['user_fu_bid']]['bm_name']."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
			}
		}
		$userList=$userList.$dongjieList;
		echo $zhuguanoption.'@@&&'.$userList;
	}
	//冻结
	public function dongjie()
	{
		$dongjieid=addslashes($_GET['thisTrId']);
		$dongjietype=addslashes($_GET['DJtype']);
		if(!$dongjieid||$dongjietype=='')
		{
			echo '2';
			die();
		}
	
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	
		
		$userbase=M("user");

		$userbase->query("update crm_user set user_act='$dongjietype' where user_id='$dongjieid' and user_fid='$fid' limit 1");
		$djname=$userbase->query("select user_name from crm_user where user_id='$dongjieid' limit 1");
		$cznr=$dongjietype=='1'?'取消冻结:'.$djname[0]['user_name']:'冻结:'.$djname[0]['user_name'];
		//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','1','".cookie("user_id")."','0','0','0','0','0','$cznr','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
	}

	//修改密码
	public function pwdedit()
	{
		$newpwd=addslashes($_GET['pwd']);
		$thisId=addslashes($_GET['editid']);
		if($newpwd!='')
		{
			$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$relfid=$thisId==$fid?'0':$fid;
			$md5newpwd=md5($newpwd);
			$userbase=M("user");
			$userbase->query("update crm_user set user_pwd_md5='$md5newpwd',user_pwd='$newpwd' where user_id='$thisId'  and user_fid='$relfid' limit 1");
			$xgname=$userbase->query("select user_name from crm_user where user_id='$dongjieid' limit 1");
			//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
			$xitongrizhibase=M("rz");
			$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
			//登录地点
			$addressArr=getCity($nowip);
			$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
			$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
			//进行插入操作
			$xitongrizhibase->query("insert into crm_rz values('','3','1','".cookie("user_id")."','0','0','0','0','0','修改了".$xhname[0]['user_name']."的密码','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
			echo '1';
		}
		else
		{
			echo 2;
		}
	}
	//删除用户
	public function userdel()
	{
		//删除用户操作并不是真正的删除操作，而是把用户的状态改为已删除，以免引起误操作而引起的重大损失
		$deluserid=addslashes($_GET['deluserid']);
		$delusername=addslashes($_GET['delusername']);
		if($deluserid=='')
		{
			echo '2';die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userbase=M("user");
		$userbase->query("update crm_user set user_del='1' where user_id='$deluserid' and user_fid='$fid' limit 1");


		//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','1','".cookie("user_id")."','0','0','0','0','0','删除了用户:$delusername','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
	}
	//用户修改
	public function useredit()
	{
		$edituserid=addslashes($_GET['usereditid']);
		$edituserdata=addslashes($_GET['usereditdata']);
		$editusername=addslashes($_GET['editusername']);
		if($edituserid==''||$edituserdata=='')
		{
			echo '2';
			die();
		}
		$edituserdata=substr($edituserdata,0,-1);//去掉最后的逗号
		$edituserArr=explode(",",$edituserdata);
		$setstr='';
		foreach($edituserArr as $v)
		{
			$kv=explode(":",$v);
			$setstr.=$kv[0]."='".$kv[1]."',";
		}
		$setstr=substr($setstr,0,-1);
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$relfid=$edituserid==$fid?'0':$fid;//user表里的真实id

		$userbase=M("user");
		$userbase->query("update crm_user set $setstr where user_id='$edituserid' and user_fid='$relfid' limit 1");

		//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','1','".cookie("user_id")."','0','0','0','0','0','编辑了用户:$editusername','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
		echo '1';
	}
}



