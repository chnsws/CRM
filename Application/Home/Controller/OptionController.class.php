<?php
namespace Home\Controller;
use Think\Controller;


class OptionController extends Controller {
	//模板框架
    public function index(){
		if(cookie("islogin")!='1')
        {
            echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
        }
        $this->display();
    }
    //设置中心
    public function optioncenter(){
		$this->display();
	}
	//部门和用户设置
	public function bumenyonghu(){
		//是否已经登录
		if(cookie("islogin")!='1')
        {
            echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
        }
		$hangyeArr=array(
			1=>"电信",
			2=>"教育",
			3=>"高科技",
			4=>"政府",
			5=>"制造业",
			6=>"服务业",
			7=>"能源",
			8=>"零售",
			9=>"媒体",
			10=>"娱乐",
			11=>"咨询",
			12=>"金融",
			13=>"公共事业",
			14=>"非盈利事业",
			15=>"其他"
		);
		//echo "<pre>";
		$gongsiSize=array(
			1=>"<10人",
			2=>"10-20人",
			3=>"20-50人",
			4=>"50-100人",
			5=>"100-500人",
			6=>"500人以上"
		);
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
		//查询公司名称
		$companybase=M("gongsixinxi");
		$nowCompanyArr=$companybase->query("select `gsxx_name` from crm_gongsixinxi where gsxx_yh='$nowUserId' or gsxx_yh='".cookie("user_fid")."' limit 1");
		//查询角色名称
		$quanxianbase=M("quanxian");
		$qxNameArr=$quanxianbase->query("select qx_id,qx_name from crm_quanxian where qx_company='".$nowUserId."' or qx_company='0' ");
		$jueseoption="<option value=''>请选择角色</option>";
		$zhuguanoption="<option value=''>请选择主管</option>";
		foreach($qxNameArr as $qxk=>$qxv)
		{
			$qxName[$qxv['qx_id']]=$qxv['qx_name'];
			$jueseoption.="<option value='".$qxv['qx_id']."'>".$qxv['qx_name']."</option>";//添加用户弹窗中的角色下拉框内容
		}
		//实例化用户表
		$userbase=M("user");
		$userAllArr=$userbase->query("select * from crm_user where (user_id='$nowUserId' or user_fid='$nowUserId') and user_del='0'");
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
				$dongjieList.="<tr style='color:#ccc'><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval['user_zhuguan_id']]."</td><td>".$bumenNewArr[$userval['user_zhu_bid']]['bm_name']."</td><td>".$bumenNewArr[$userval['user_fu_bid']]['bm_name']."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
			}
			else
			{
				$userList.="<tr><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval[user_zhuguan_id]]."</td><td>".$bumenNewArr[$userval['user_zhu_bid']]['bm_name']."</td><td>".$bumenNewArr[$userval['user_fu_bid']]['bm_name']."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
			}
		}
		$userList=$userList.$dongjieList;
		$bumenFname=json_encode($bumenFname);
		//添加用户弹出框需要的数据
		$this->assign("zhuguanoption",$zhuguanoption);
		$this->assign("jueseoption",$jueseoption);
		$this->assign("bumenoption",$bumenoption);
		$this->assign("bumenFname",$bumenFname);

		$this->assign("userList",$userList);
		$this->assign("companyName",$nowCompanyArr[0]['gsxx_name']);
		$this->assign("bmList",$bmList);
		$this->display();
	}
	//角色和权限设置
	public function juesequanxian(){
		$loginuserid=cookie("user_id");
		$qxbase=M("quanxian");
		$qxArr=$qxbase->query("select * from crm_quanxian where qx_company='$loginuserid' or qx_company='0' ");
		$juesestr='';
		foreach($qxArr as $qxk=>$qxv)
		{
			if($qxv['qx_company']=='0')
			{
				$juesestr.="<div class='left-juese is-selected' onclick='morenJsClick()' id='qx".$qxv['qx_id']."'>".$qxv['qx_name']."<span>系统默认</span></div>";
			}
			else
			{
				$juesestr.="<div class='left-juese' onclick='jsClick($qxv[qx_id])' id='qx".$qxv['qx_id']."'>".$qxv['qx_name']."<i class='fa fa-trash-o' aria-hidden='true' onclick='jsdel(".$qxv['qx_id'].")' ></i><i class='fa fa-pencil' aria-hidden='true' onclick='jsedit(".$qxv['qx_id'].")'></i></div>";
			}
		}
		$this->assign("jueselist",$juesestr);
		$this->display();
	}
	//公司信息设置
	public function companyinfo(){
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$gsbase=M("gongsixinxi");
		$gsxxarr=$gsbase->query("select * from crm_gongsixinxi where gsxx_yh='$fid' limit 1");
		if($gsxxarr[0]['gsxx_img']=='0'||$gsxxarr[0]['gsxx_img']=='')
        {
            $gsxxarr[0]['gsxx_img']="moren.jpg";
        }
		else
		{
			$gsxxarr[0]['gsxx_img']=$gsxxarr[0]['gsxx_img'];
		}
		$gsguimo=array(0=>'',1=>'<10人',2=>'10-20人',3=>'20-50人',4=>'50-100人',5=>'100-500人',6=>'500人以上');
		$hangye=array(0=>'',1=>'电信',2=>'教育',3=>'高科技',4=>'政府',5=>'制造业',6=>'服务业',7=>'能源',8=>'零售',9=>'媒体',10=>'娱乐',11=>'咨询',12=>'金融',13=>'公共事业',14=>'非营利事业',15=>'其他');

		$this->assign("hangye",$hangye);
		$this->assign("gsguimo",$gsguimo);
		$this->assign("gsxxarr",$gsxxarr[0]);
		$this->display();
	}
	//公告管理
	public function gonggaoguanli(){
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ggbase=M("ggshezhi");
		$ggarr=$ggbase->query("select ggsz_id,ggsz_name,ggsz_ydcs,ggsz_fbsj,ggsz_zd,user_name from crm_ggshezhi left join crm_user on ggsz_yh=user_id where ggsz_yh='$fid' order by ggsz_zd_sj desc,ggsz_fbsj desc");
		$ggzdliststr='';
		$ggliststr='';
		foreach($ggarr as $v)
		{
			if($v['ggsz_zd']=='1')
			{
				$ggzdliststr.="<tr><td class='checkbox_row'><input type='checkbox' value='".$v['ggsz_id']."' name='ggcheckbox'></td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/gonggaomore?ggid=".$v['ggsz_id']."'>".$v['ggsz_name']."</a></td><td>".$v['ggsz_ydcs']."</td><td>".$v['user_name']."</td><td>".$v['ggsz_fbsj']."</td><td><a onclick='ggbianji(".$v['ggsz_id'].")'>编辑</a><a onclick='ggzhiding(".$v['ggsz_id'].",0)'>取消置顶</a><a onclick=ggshanchu('".$v['ggsz_id']."','".$v['ggsz_name']."')>删除</a></td></tr>";
			}
			else
			{
				$ggliststr.="<tr><td class='checkbox_row'><input type='checkbox' value='".$v['ggsz_id']."' name='ggcheckbox'></td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/gonggaomore?ggid=".$v['ggsz_id']."'>".$v['ggsz_name']."</a></td><td>".$v['ggsz_ydcs']."</td><td>".$v['user_name']."</td><td>".$v['ggsz_fbsj']."</td><td><a onclick='ggbianji(".$v['ggsz_id'].")'>编辑</a><a onclick='ggzhiding(".$v['ggsz_id'].",1)'>置顶</a><a onclick=ggshanchu('".$v['ggsz_id']."','".$v['ggsz_name']."')>删除</a></td></tr>";
			}
			
		}
		$this->assign("gglist",$ggzdliststr.$ggliststr);
		$this->display();
	}
	//公告详情页
	public function gonggaomore()
	{
		$ggid=addslashes($_GET['ggid']);
		if($ggid=='')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Option/gonggaoguanli'</script>";
			die();
		}
		$ggbase=M("ggshezhi");
		$gginfoarr=$ggbase->query("select * from crm_ggshezhi where ggsz_id='$ggid'");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userbase=M("user");
		$userbasearr=$userbase->query("select user_name from crm_user where user_id='".$gginfoarr[0]['ggsz_fbr']."' limit 1");
		$this->assign("username",$userbasearr[0]['user_name']);
		$this->assign("gginfo",$gginfoarr[0]);
		$this->display();
	}
	//业绩目标
	public function yejimubiao(){
		$this->display();
	}
	//工作报告
	public function gongzuobaogao(){
		$this->display();
	}
	//自定义业务字段
	public function zdyyw_ziduan(){
		$this->display();
	}
	//自定义业务参数
	public function zdyyw_canshu(){
		$this->display();
	}
	//自定审批
	public function shenpi(){
		$this->display();
	}
	//日志
	public function rizhi(){
		$this->display();
	}
}



