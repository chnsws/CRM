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
		$qxNameArr=$quanxianbase->query("select qx_id,qx_name from crm_quanxian where qx_company='".$nowUserFid."' or qx_company='0' ");
		$jueseoption="<option value=''>请选择角色</option>";
		$zhuguanoption="<option value=''>请选择主管</option>";
		foreach($qxNameArr as $qxk=>$qxv)
		{
			$qxName[$qxv['qx_id']]=$qxv['qx_name'];
			$jueseoption.="<option value='".$qxv['qx_id']."'>".$qxv['qx_name']."</option>";//添加用户弹窗中的角色下拉框内容
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
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$qxArr=$qxbase->query("select * from crm_quanxian where qx_company='$fid' or qx_company='0' ");
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
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
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
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
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
		$cpidarr=array('6','7');
		$cptypearr=array('6','7');
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$yjmbbase=M("yjmb");
		
		
		$yjmbarr=$yjmbbase->query("select * from crm_yjmb where yjmb_yh='$fid' order by yjmb_nd desc");
		foreach($yjmbarr as $v)
		{
			if($v['yjmb_type']=='6'||$v['yjmb_type']=='7')
			{
				$cpinstr.="'".$v['yjmb_type_more']."',";//产品
			}
			if($v['yjmb_type']=='8'||$v['yjmb_type']=='9')
			{
				$cptypeinstr.="'".$v['yjmb_type_more']."',";//产品分类
			}
		}
		if($cpinstr!='')
		{
			$cpinstr=substr($cpinstr,0,-1);
			$cpbase=M("chanpin");
			$cparr=$cpbase->query("select cp_id,cp_data from crm_chanpin where cp_yh='$fid' and cp_id in ($cpinstr)");
			foreach($cparr as $v)
			{
				$decodecp=json_decode($v['cp_data'],true);
				$cpname[$v['cp_id']]=$decodecp['zdy0'];
			}
		}
		if($cptypeinstr!='')
		{
			$cptypeinstr=substr($cptypeinstr,0,-1);
			$cptypebase=M("chanpinfenlei");
			$cptypearr=$cptypebase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid' and cpfl_id in ($cptypeinstr)");
			foreach($cptypearr as $v)
			{
				$cptypename[$v['cpfl_id']]=$v['cpfl_name'];
			}
		}
		$yjmorebase=M("yjmb_user");
		$alluseryjarr=$yjmorebase->query("select * from crm_yjmb_user left join crm_user on yjm_uid=user_id where yjm_fid='$fid' and user_del='0' ");
		foreach($alluseryjarr as $v)
		{
			$sum='0';
			foreach($v as $k=>$val)
			{
				if(substr($k,0,5)=='yjm_m')
					$sum=$val+$sum;
			}
			$zongmubiao[$v['yjm_yid']]=$zongmubiao[$v['yjm_yid']]+$sum;
		}
		foreach($yjmbarr as $v)
		{
			if($v['yjmb_type']=='6'||$v['yjmb_type']=='7')
			{
				$relname='('.$cpname[$v['yjmb_type_more']].')';
			}
			else if($v['yjmb_type']=='8'||$v['yjmb_type']=='9')
			{
				$relname='('.$cptypename[$v['yjmb_type_more']].')';
			}
			else
			{
				$relname='';
			}
			$yjtable.="<tr><td>".$v['yjmb_nd']."</td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/yejimubiao_more?yjid=".$v['yjmb_id']."'>".$mbname[$v['yjmb_type']].$relname."</a></td><td>".$zongmubiao[$v['yjmb_id']]."</td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/yejimubiao_more?yjid=".$v['yjmb_id']."'>查看</a><a onclick='yjcopy(".$v['yjmb_nd'].",".$v['yjmb_id'].",".$v['yjmb_type'].",".$v['yjmb_type_more'].")'>复制</a><a onclick='yjdel(".$v['yjmb_id'].")'>删除</a></td></tr>";
		}
		$this->assign("yjtable",$yjtable);
		$this->display();
	}
	//业绩目标详细
	public function yejimubiao_more(){
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$moreyjid=addslashes($_GET['yjid']);
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$yjbase=M("yjmb");
		$yjuserbase=M("yjmb_user");
		$yjarr=$yjbase->query("select * from crm_yjmb where yjmb_id='$moreyjid' limit 1");
		if($yjarr[0]['yjmb_type']=='1'||$yjarr[0]['yjmb_type']=='3'||$yjarr[0]['yjmb_type']=='4'||$yjarr[0]['yjmb_type']=='7'||$yjarr[0]['yjmb_type']=='9')
		{
			$danwei='￥';
			$danwei2='￥';
			$listdanwei='￥';
			$ismoney='1';
		}
		else
		{
			$danwei='总数量：';
			$danwei2='';
			$listdanwei='';
			$ismoney='0';
		}
		//业绩类型名称
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
		if($yjarr[0]['yjmb_type']=='6'||$yjarr[0]['yjmb_type']=='7')
		{
			$cpbase=M("chanpin");
			$cpnamearr=$cpbase->query("select cp_data from crm_chanpin where cp_id='".$yjarr[0]['yjmb_type_more']."'");
			$cpnamearr=json_decode($cpnamearr[0]['cp_data'],true);
			$cpname=$mbname[$yjarr[0]['yjmb_type']].'('.$cpnamearr['zdy0'].')';//产品
		}
		else if($yjarr[0]['yjmb_type']=='8'||$yjarr[0]['yjmb_type']=='9')
		{
			$cptypebase=M("chanpinfenlei");
			$cpnamearr=$cptypebase->query("select cpfl_name from crm_chanpinfenlei where cpfl_id='".$yjarr[0]['yjmb_type_more']."'");
			$cpname=$mbname[$yjarr[0]['yjmb_type']].'('.$cpnamearr[0]['cpfl_name'].')';//产品
		}
		else
		{
			$cpname=$mbname[$yjarr[0]['yjmb_type']];
		}
		//构造右边表格
		$yjuserarr=$yjuserbase->query("select * from crm_yjmb_user left join crm_user on yjm_uid=user_id where yjm_yid='$moreyjid' and user_del='0' ");
		//每个人和每个部门的业绩，组成业绩表格
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
			//构造用户表
			$tablestr.="<tr id='tr".$v['yjm_id']."'><td>".$v['user_name']."</td><td class='sumyj'>".$sumyj."</td><td class='change-text'>".$v['yjm_m1']."</td><td class='change-text'>".$v['yjm_m2']."</td><td class='change-text'>".$v['yjm_m3']."</td><td class='change-text'>".$v['yjm_m4']."</td><td class='change-text'>".$v['yjm_m5']."</td><td class='change-text'>".$v['yjm_m6']."</td><td class='change-text'>".$v['yjm_m7']."</td><td class='change-text'>".$v['yjm_m8']."</td><td class='change-text'>".$v['yjm_m9']."</td><td class='change-text'>".$v['yjm_m10']."</td><td class='change-text'>".$v['yjm_m11']."</td><td class='change-text'>".$v['yjm_m12']."</td></tr>";
		}
		//echo "<pre>";
		//print_r($yjuserarr);
		//构造左边部门
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
		//echo "<pre>";
		//print_r($bmallarr);
		//部门排序结束 $bmLvArr:部门分级数组
		//echo "<pre>";
		//print_r($bmLvArr);
		//echo number_format(floor('22'),2);
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
		//公司名称查询
		$gsbase=M("gongsixinxi");
		$gsname=$gsbase->query("select gsxx_name from crm_gongsixinxi where gsxx_yh='$fid' limit 1");
		//变量映射
		$this->assign("pageid",$moreyjid);
		$this->assign("pagetype",$yjarr[0]['yjmb_type']);
		$this->assign("danwei",$danwei);//右上角返回按钮附近的单位
		$this->assign("danwei2",$danwei2);
		$this->assign("companysum",$this->yjmbdanwei($companysum,$ismoney));//全公司的总量
		$this->assign("gsname",$gsname[0]['gsxx_name']);//公司名称
		$this->assign("bmlist",$bmList);//部门列表
		$this->assign("tablestr",$tablestr);//用户列表
		$this->assign("biaoti",$yjarr[0]['yjmb_nd'].'年度业绩目标');//标题
		$this->assign("cpname",$cpname);//业绩类型
		$this->display();
	}
	//工作报告
	public function gongzuobaogao(){
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$baogaobase=M("gzbg");
		$bgval=$baogaobase->query("select * from crm_gzbg where gzbg_yh='$fid' limit 1");
		$this->assign("bgvalue",$bgval[0]['gzbg_val']);
		$this->display();
	}
	//工作报告
	public function gzbgdo()
	{
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$bgstr=addslashes($_GET['bgstr']);
		if($bgstr=='')
		{
			echo 2;
			die;
		}
		$baogaobase=M("gzbg");
		$baogaobase->query("update crm_gzbg set gzbg_val='$bgstr' where gzbg_yh='$fid' limit 1");

		//更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','7','".cookie("user_id")."','0','0','0','0','0','修改了工作报告设置','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        echo '1';
	}
	//自定义业务字段
	public function zdyyw_ziduan(){
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$pxbase=M("paixu");
		$pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='1'");
		$zdbase=M("yewuziduan");
		$xiansuoarr=$zdbase->query("select * from crm_yewuziduan where zd_yh='$fid' and zd_yewu='1' ");
		$xiansuoarr=$xiansuoarr[0];
		$json2arr=json_decode($xiansuoarr['zd_data'],true);
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















		$this->assign("tablestr",$tablestr);
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
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$rzbase=M("rz");
		$czrzarr=$rzbase->query("select rz_id,rz_time,rz_user,rz_mode,rz_cz_type,rz_bz from crm_rz where rz_yh='$fid' and rz_type='1' order by rz_time desc");
		$userbase=M("user");
		$userarr=$userbase->query("select user_name,user_id from crm_user where user_id='$fid' or user_fid='$fid'");
		foreach($userarr as $v)
		{
			$usersel.="<option value='".$v['user_id']."'>".$v['user_name']."</option>";
			$usernamearr[$v['user_id']]=$v['user_name'];
		}
		$lsstr='1000000000';
		$caozuoarr=array(
			"1"=>"新建",
			"2"=>"编辑",
			"3"=>"删除",
			"4"=>"处理",
			"5"=>"提交",
			"6"=>"通过",
			"7"=>"否决",
			"8"=>"导入",
			"9"=>"导出",
			"10"=>"转移给他人",
			"11"=>"转成客户",
			"12"=>"导入至客户公海",
			"13"=>"转入客户公海",
			"14"=>"抢公海客户",
			"15"=>"客户公海删除",
			"16"=>"导入跟进记录",
			"17"=>"添加回款记录",
			"18"=>"编辑回款记录",
			"19"=>"删除回款记录",
			"20"=>"提交回款记录审批",
			"21"=>"否决回款记录审批",
			"22"=>"驳回回款记录审批",
			"23"=>"通过回款记录审批",
			"24"=>"添加回款计划",
			"25"=>"编辑回款计划",
			"26"=>"删除回款计划",
			"27"=>"添加开票记录",
			"28"=>"编辑开票记录",
			"29"=>"删除开票记录",
			"30"=>"添加附件",
			"31"=>"删除附件",
			"32"=>"删除跟进记录",
			"33"=>"添加关联产品",
			"34"=>"编辑关联产品",
			"35"=>"删除关联产品",
			"36"=>"添加关联联系人",
			"37"=>"编辑关联联系人",
			"38"=>"删除关联联系人",
			"39"=>"转成合同",
			"40"=>"批阅",
			"41"=>"交接",
			"42"=>"启用",
			"43"=>"关闭"
		);
		$mokuaiarr=array(
			"1"=>"线索",
			"2"=>"客户",
			"3"=>"客户公海",
			"4"=>"联系人",
			"5"=>"商机",
			"6"=>"合同",
			"7"=>"产品",
			"8"=>"报表中心",
			"9"=>"工作报告",
			"10"=>"跟进记录",
			"11"=>"知识库"
		);
		foreach($czrzarr as $v)
		{
			$caozuostr.="<tr><td>".substr($lsstr.$v['rz_id'],-10)."</td><td>".date("Y-m-d H:i:s",$v['rz_time'])."</td><td>".$usernamearr[$v["rz_user"]]."</td><td>".$mokuaiarr[$v['rz_mode']]."</td><td>".$caozuoarr[$v['rz_cz_type']]."</td><td>".$v['rz_bz']."</td></tr>";
		}
		$this->assign("caozuostr",$caozuostr);
		$this->assign("usersel",$usersel);
		$this->display();
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



