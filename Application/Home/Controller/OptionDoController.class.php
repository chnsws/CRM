<?php
namespace Home\Controller;
use Think\Controller;


class OptionDoController extends DBController {
	//部门添加操作
    public function bumenadd()
    {
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
	//保存部门树形结构
	function save_bm_tree()
	{
		if($_POST['cdd']=='')
		{
			echo 0;
			die;
		}
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
		$fid=parent::get_fid();
		$tree_str=substr($_POST['cdd'],0,-1);
		$treearr=explode(',',str_replace('"','',$tree_str));
		foreach($treearr as $v)
        {
            $varr=explode(":",$v);
            $sql_str.=" WHEN '".$varr[1]."' THEN '".$varr[0]."' ";
            $idarr[]=$varr[1];
        }
		$idstr="'".implode("','",$idarr)."'";
		$main_sql="update crm_department set bm_fid = CASE bm_id $sql_str ELSE `bm_fid` END where bm_company='$fid' and bm_id in ($idstr) ";
		$bmbase=M("department");
		$bmbase->query($main_sql);
		echo 1;
	}
	//保存部门排序
	function save_bm_px()
	{
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
		if($_POST['bmpxjson']=='')
		{
			echo '0';
			die;
		}
		$bmpxjson=$_POST['bmpxjson'];
		$bmpxArr=json_decode($bmpxjson,true);
		$bmpxstr=implode(',',$bmpxArr);
		$fid=parent::get_fid();

		$configbase=M("config");
		$configbase->query("update crm_config set config_option_bm_px='$bmpxstr' where config_name='$fid' limit 1");
		echo 1;
	}

	//修改部门名称
	public function bumenedit()
	{
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
			//与业绩目标模块进行关联，增加新用户的业绩目标数据
			$yjbase=M("yjmb_user");
			$yjarr=$yjbase->query("select distinct yjm_yid from crm_yjmb_user where yjm_fid='$fid'");
			if(count($yjarr)>0)
			{
				$lastinsertuser=$userbase->query("select user_id from crm_user where user_fid='$fid' order by user_id desc limit 1");
				$yj_insert_str='';
				foreach($yjarr as $v)
				{
					$yj_insert_str.="('','".$lastinsertuser[0]['user_id']."','".$v['yjm_yid']."','$fid','0','0','0','0','0','0','0','0','0','0','0','0'),";
				}
				$yj_insert_str=substr($yj_insert_str,0,-1);
				//插入操作
				$yjbase->query("insert into crm_yjmb_user values $yj_insert_str ");
			}
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
		$quanxianbase=M("juesequanxian");
		$qxNameArr=$quanxianbase->query("select qx_id,qx_name from crm_juesequanxian where qx_yh='".$nowUserId."' or qx_yh='0' ");
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
		$newpwd=addslashes($_GET['pwd']);
		$thisId=addslashes($_GET['editid']);
		if($newpwd!='')
		{
			$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$relfid=$thisId==$fid?'0':$fid;
			$md5newpwd=md5($newpwd);
			$userbase=M("user");
			$userbase->query("update crm_user set user_pwd_md5='$md5newpwd' where user_id='$thisId'  and user_fid='$relfid' limit 1");
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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
		//删除业绩目标中的用户业绩
		$yjbase=M("yjmb_user");
		$yjbase->query("delete from crm_yjmb_user where yjm_uid='$deluserid' and yjm_fid='$fid'");

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
		parent::is_login();
		parent::have_qx("qx_sys_bmyh");
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
	//修改客户公海设置开启或关闭状态
	public function changestatus()
	{
		parent::is_login();
		parent::have_qx("qx_sys_khgh");
		if($_GET['sta']=='')
		{
			die("error");
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$sta=$_GET['sta']=='1'?'1':'0';
		$ghbase=M("gonghaishezhi");
		$ghbase->execute("update crm_gonghaishezhi set gh_open='$sta' where gh_yh='$fid' limit 1");
		
		echo '1';
	}
	//保存客户公海设置的天数
	public function changeopen()
	{
		parent::is_login();
		parent::have_qx("qx_sys_khgh");
		if($_GET['ts']=='')
		{
			die("error");
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$ts=addslashes($_GET['ts']);
		$ghbase=M("gonghaishezhi");
		$ghbase->execute("update crm_gonghaishezhi set gh_days='$ts' where gh_yh='$fid' limit 1");
		
		echo '1';
		
	}
}



