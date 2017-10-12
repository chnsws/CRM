<?php
namespace Home\Controller;
use Think\Controller;


class OptionController extends DBController {
	
	//模板框架
    public function index(){
		parent::is_login();
		$fid=parent::get_fid();

		$nav='[{"title":"设置中心","icon":"fa-table","href":"","spread":true},{"title":"系统设置","icon":"fa-search","href":"","spread":true,"children":[{"title":"部门和用户设置","icon":"&#xe641;","href":"'.__ROOT__.'/index.php/Home/Option/bumenyonghu"},{"title":"角色和权限设置","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Option/juesequanxian"},{"title":"公司信息","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Option/companyinfo"},{"title":"公告管理","icon":"&#xe609;","href":"'.__ROOT__.'/index.php/Home/Option/gonggaoguanli"}]},{"title":"业务设置","icon":"fa-group","href":"","spread":true,"children":[{"title":"业绩目标","icon":"&#xe641;","href":"'.__ROOT__.'/index.php/Home/Option/yejimubiao"},{"title":"客户公海","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Option/kehugonghai"}]},{"title":"自定义设置","icon":"fa-address-book","href":"","spread":true,"children":[{"title":"自定义业务字段","icon":"&#xe641;","href":"'.__ROOT__.'/index.php/Home/Yewuziduan/index"},{"title":"自定义业务参数","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Yewucanshu/index"},{"title":"自定义审批","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Option/shenpi"},{"title":"产品筛选设置","icon":"&#xe63c;","href":"'.__ROOT__.'/index.php/Home/Option/shaixuan"}]},{"title":"查询","icon":"fa-money","href":"","spread":true,"children":[{"title":"日志查询","icon":"&#xe641;","href":"'.__ROOT__.'/index.php/Home/Option/rizhi"}]}]';

		$navarr=json_decode($nav,true);
		//parent::rr($navarr);
		if(cookie("user_quanxian")!='0')
		{
			//如果不是超级管理员，就开始判断权限
			//--权限开始
			//查询后台设置相关的权限
			$qx_sys_bmyh=cookie("qx_sys_bmyh");
			$qx_sys_jsqx=cookie("qx_sys_jsqx");
			$qx_sys_gsxx=cookie("qx_sys_gsxx");
			$qx_sys_gggl=cookie("qx_sys_gggl");
			$qx_sys_yjmb=cookie("qx_sys_yjmb");
			$qx_sys_khgh=cookie("qx_sys_khgh");
			$qx_sys_ywzd=cookie("qx_sys_ywzd");
			$qx_sys_ywcs=cookie("qx_sys_ywcs");
			$qx_sys_sp=cookie("qx_sys_sp");
			$qx_sys_sx=cookie("qx_sys_sx");
			$qx_sys_rz=cookie("qx_sys_rz");
			if($qx_sys_bmyh=='0'&&$qx_sys_jsqx=='0'&&$qx_sys_gsxx=='0'&&$qx_sys_gggl=='0')
			{
				unset($navarr[1]);
			}
			else
			{
				if($qx_sys_bmyh=='0')
				{
					unset($navarr[1]['children'][0]);
				}
				if($qx_sys_jsqx=='0')
				{
					unset($navarr[1]['children'][1]);
				}
				if($qx_sys_gsxx=='0')
				{
					unset($navarr[1]['children'][2]);
				}
				if($qx_sys_gggl=='0')
				{
					unset($navarr[1]['children'][3]);
				}
			}
			if($qx_sys_yjmb=='0'&&$qx_sys_khgh=='0')
			{
				unset($navarr[2]);
			}
			else
			{
				if($qx_sys_yjmb=='0')
				{
					unset($navarr[2]['children'][0]);
				}
				if($qx_sys_khgh=='0')
				{
					unset($navarr[2]['children'][1]);
				}
			}
			if($qx_sys_ywzd=='0'&&$qx_sys_ywcs=='0'&&$qx_sys_sp=='0'&&$qx_sys_sx=='0')
			{
				unset($navarr[3]);
			}
			else
			{
				if($qx_sys_ywzd=='0')
				{
					unset($navarr[3]['children'][0]);
				}
				if($qx_sys_ywcs=='0')
				{
					unset($navarr[3]['children'][1]);
				}
				if($qx_sys_sp=='0')
				{
					unset($navarr[3]['children'][2]);
				}
				if($qx_sys_sx=='0')
				{
					unset($navarr[3]['children'][3]);
				}
			}
			if($qx_sys_rz=='0')
			{
				unset($navarr[4]);
			}
			//--权限结束
		}
		foreach($navarr as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk=='title')
				{
					$navarr[$k][$kk]=urlencode($vv);
				}
				if($kk=='children')
				{
					foreach($vv as $kkk=>$vvv)
					{
						$navarr[$k][$kk][$kkk]['title']=urlencode($vvv['title']);
					}
				}
			}
		}
		foreach($navarr as $k=>$v)
		{
			if(count($v['children'])>0)
			{
				$ls='';
				foreach($v['children'] as $kk=>$vv)
				{
					
					$ls[]=$vv;
				}
				unset($v['children']);
				$v['children']=$ls;
			}
			$newnavarr[]=$v;
		}
		//parent::rr($newnavarr);
		//parent::rr(urldecode(json_encode($navarr)));
		$username=mb_strlen(cookie("user_name"))>5?mb_substr(cookie("user_name"),0,5).'...':cookie("user_name");
		$this->assign("loginusername",$username);
		$this->assign("navs",urldecode(json_encode($newnavarr)));
        $this->display();
    }
    //设置中心
    public function optioncenter(){
		//echo "<pre>";print_r($_COOKIE);
		parent::is_login();
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userbase=M("user");
		$f_user_info=$userbase->query("select user_sign_time,user_youxiaoqi from crm_user where user_id='$fid' limit 1");
		$usercount=$userbase->query("select count(user_id) from crm_user where user_del='0' and  (user_id='$fid' or user_fid='$fid') ");
		$can_show_gg=$this->gonggao_can_show();
		$gg_str='';
		foreach($can_show_gg as $v)
		{
			$gg_str.='<tr><td><a href="./gonggaomore?ggid='.$v['ggsz_id'].'&center=1">'.$v['ggsz_name'].'</a><span class="gg_right">'.$v['ggsz_fbsj'].'</span></td></tr>';
			$a++;
			if($a==5) break;
		}
		$this->assign("gg_str",$gg_str);
		$this->assign("usercount",$usercount[0]['count(user_id)']);
		$this->assign("stime",substr($f_user_info[0]['user_sign_time'],0,10));
		$this->assign("etime",substr($f_user_info[0]['user_youxiaoqi'],0,10));
		$this->display();
	}
	//返回登录用户有权限看的公告
	public function gonggao_can_show()
	{
		parent::is_login();
		//系统公告
		$ggbase=M("ggshezhi");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ggbasearr=$ggbase->query("select ggsz_id,ggsz_kjid,ggsz_name,ggsz_fbsj,ggsz_kjfw,ggsz_fbr from crm_ggshezhi where ggsz_yh='$fid' ");
		//公司总管理或者超级管理员可以看到全部的公告
		//if(cookie("user_fid")=='0'||cookie("user_quanxian")=='1')
		if(cookie("user_quanxian")=='1')
		{
			return $ggbasearr;
		}
		else
		{
			//筛选出登录用户可以看的公告
			foreach($ggbasearr as $k=>$v)
			{
				$kjid=explode(",",$v['ggsz_kjid']);
				//指定部门
				if($v['ggsz_kjfw']=='2')
				{
					$zhu_bid=cookie("user_zhu_bid");
					$fu_bid=cookie("user_zhu_bid");
					if(!in_array($zhu_bid,$kjid)&&!in_array($fu_bid,$kjid))
					{
						unset($ggbasearr[$k]);
					}
				}
				//指定角色
				if($v['ggsz_kjfw']=='3')
				{
					$juese=cookie("user_quanxian");
					if(!in_array($juese,$kjid))
					{
						unset($ggbasearr[$k]);
					}
				}
			}
			return $ggbasearr;
		}
	}
	//部门和用户设置
	public function bumenyonghu(){
		//是否已经登录
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
		foreach($bumenArr as $v)
		{
			$bumenFname[$v['bm_id']]=$v['bm_name'];
			$bumenoption.='<option value="'.$v['bm_id'].'">'.$v['bm_name'].'</option>';
			$bmKeyArr[$v['bm_id']]=$v;
		}
		/*检索部门的排序*/
		$bmpx=parent::sel_more_data("crm_config","config_option_bm_px","config_name='$nowUserFid'");
		if($bmpx[0]['config_option_bm_px']!='')
		{
			//如果存在排序，就重新排列部门数组
			$bmPxArr=explode(',',$bmpx[0]['config_option_bm_px']);
			foreach($bmPxArr as $v)
			{
				$bmarr_have_px[$v]=$bmKeyArr[$v];
				unset($bmKeyArr[$v]);
			}
			foreach($bmKeyArr as $k=>$v)
			{
				$bmarr_have_px[$k]=$v;
			}
			unset($bumenArr);
			$bumenArr=$bmarr_have_px;
		}
		$bmLvArr=$this->get_bm_tree($bumenArr);
		$bmLvList='';
		//构造结构HTML
		foreach($bmLvArr as $k=>$v)
		{
            //一级
           //echo $cp_num;
           //print_r($fl_cp_num);
           $bmLvList.=' <li class="uk-nestable-item">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                '.$v['bm_name'].'
                                <div class="fl_mod" id="bm_id_'.$k.'">
									<i class="uk-icon-trash-o" onclick="bmdel('.$k.')" aria-hidden="true" title="删除部门"></i>
									<i class="uk-icon-pencil" onclick="bmedit('.$k.')" aria-hidden="true" title="修改部门名称"></i>
								</div>
                            </div>';
			if(count($v['lv2'])>0)
			{
                $bmLvList.='<ul class="uk-nestable-list">';
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
                    //二级
                    $bmLvList.='<li class="uk-nestable-item">
									<div class="uk-nestable-panel">
										<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
										'.$lv2v['bm_name'].'
										<div class="fl_mod" id="bm_id_'.$lv2k.'">
											<i class="uk-icon-trash-o" onclick="bmdel('.$lv2k.')" aria-hidden="true" title="删除部门"></i>
											<i class="uk-icon-pencil" onclick="bmedit('.$lv2k.')" aria-hidden="true" title="修改部门名称"></i>
										</div>
									</div>';
					if(count($lv2v['lv3'])>0)
					{
                        $bmLvList.='<ul class="uk-nestable-list">';
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
                            //三级
                            $bmLvList.='<li class="uk-nestable-item">
											<div class="uk-nestable-panel">
												<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
												'.$lv3v['bm_name'].'
												<div class="fl_mod" id="bm_id_'.$lv3k.'">
													<i class="uk-icon-trash-o" onclick="bmdel('.$lv3k.')" aria-hidden="true" title="删除部门"></i>
													<i class="uk-icon-pencil" onclick="bmedit('.$lv3k.')" aria-hidden="true" title="修改部门名称"></i>
												</div>
											</div>';
							if(count($lv3v['lv4'])>0)
							{
                                $bmLvList.='<ul class="uk-nestable-list">';
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
                                    //四级
                                    
                                    $bmLvList.='<li class="uk-nestable-item">
													<div class="uk-nestable-panel">
														<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
														'.$lv4v['bm_name'].'
														<div class="fl_mod" id="bm_id_'.$lv4k.'">
															<i class="uk-icon-trash-o" onclick="bmdel('.$lv4k.')" aria-hidden="true" title="删除部门"></i>
															<i class="uk-icon-pencil" onclick="bmedit('.$lv4k.')" aria-hidden="true" title="修改部门名称"></i>
														</div>
													</div>';
									if(count($lv4v['lv5'])>0)
									{
                                        $bmLvList.='<ul class="uk-nestable-list">';
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
                                            //五级
                                            $bmLvList.='<li class="uk-nestable-item">
															<div class="uk-nestable-panel">
																<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
																'.$lv5v['bm_name'].'
																<div class="fl_mod" id="bm_id_'.$lv5k.'">
																	<i class="uk-icon-trash-o" onclick="bmdel('.$lv5k.')" aria-hidden="true" title="删除部门"></i>
																	<i class="uk-icon-pencil" onclick="bmedit('.$lv5k.')" aria-hidden="true" title="修改部门名称"></i>
																</div>
															</div>';
										}
                                        $bmLvList.='</ul></li>';
									}
                                    else
                                    {
                                        $bmLvList.='</li>';
                                    }
								}
                                $bmLvList.='</ul></li>';
							}
                            else
                            {
                                $bmLvList.='</li>';
                            }
						}
                        $bmLvList.='</ul></li>';
					}
                    else
                    {
                        $bmLvList.='</li>';
                    }
				}
                $bmLvList.='</ul></li>';
			}
            else
            {
                $bmLvList.='</li>';
            }
		}
		//echo $bmLvList;
		
		//查询公司名称
		$companybase=M("gongsixinxi");
		$nowCompanyArr=$companybase->query("select `gsxx_name` from crm_gongsixinxi where gsxx_yh='$nowUserId' or gsxx_yh='".cookie("user_fid")."' limit 1");
		//查询角色名称
		$quanxianbase=M("juesequanxian");
		$qxNameArr=$quanxianbase->query("select qx_id,qx_name from crm_juesequanxian where qx_yh='".$nowUserFid."' or qx_yh='0' ");
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
			$caozuoBtn="<div class='uk-button-dropdown' data-uk-dropdown=\"{mode:'click'}\" data-uk-dropdown style='overflow:visible;'><button class='layui-btn layui-btn-primary' style='border-radius:90px;height:30px;width:30px;line-height:30px;margin:0;padding:0;' ><i class='uk-icon-cogs'></i></button><div class='uk-dropdown uk-dropdown-small' style='border:1px solid #ccc;'><ul class='uk-nav uk-nav-dropdown'>".$moveList."</ul></div></div>";
			if($userval['user_act']=='0')
			{
				$dongjieList.="<tr style='color:#ccc'><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval['user_zhuguan_id']]."</td><td>".$bumenFname[$userval['user_zhu_bid']]."</td><td>".$bumenFname[$userval['user_fu_bid']]."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
			}
			else
			{
				$userList.="<tr><td>$userval[user_name]</td><td>".$userSex[$userval[user_sex]]."</td><td>$userval[user_phone]</td><td>".$qxName[$userval[user_quanxian]]."</td><td>".$userName[$userval[user_zhuguan_id]]."</td><td>".$bumenFname[$userval['user_zhu_bid']]."</td><td>".$bumenFname[$userval['user_fu_bid']]."</td><td>$userval[user_lastlogintime]</td><td>$caozuoBtn</td></tr>";
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
		$companyname=$nowCompanyArr[0]['gsxx_name']==''?'（暂无公司名称）':$nowCompanyArr[0]['gsxx_name'];
		$this->assign("companyName",$companyname);
		$this->assign("bmList",$bmLvList);
		$this->display();
	}
	//角色和权限设置
	public function juesequanxian(){
		parent::is_login();
		parent::have_qx("qx_sys_jsqx");
		$fid=parent::get_fid();
		$loginuserid=cookie("user_id");

		$qxarr=parent::sel_more_data("crm_juesequanxian","*","qx_yh='$fid' or qx_yh='0' ");
		
		$juesestr='';
		foreach($qxarr as $qxk=>$qxv)
		{
			if($qxv['qx_yh']=='0')
			{
				$juesestr.="<div class='left-juese is-selected' onclick='morenJsClick()' id='qx".$qxv['qx_id']."'>".$qxv['qx_name']."<span>系统默认</span></div>";
			}
			else
			{
				$juesestr.="<div class='left-juese' onclick='jsClick($qxv[qx_id])' id='qx".$qxv['qx_id']."'>".$qxv['qx_name']."<i class='fa fa-trash-o' aria-hidden='true' onclick='jsdel(".$qxv['qx_id'].")' ></i><i class='fa fa-pencil' aria-hidden='true' onclick='jsedit(".$qxv['qx_id'].")'></i></div>";
			}
		}
		//parent::rr($qxarr);
		$this->assign("jueselist",$juesestr);
		$this->display();
	}
	//公司信息设置
	public function companyinfo(){
		parent::is_login();
		parent::have_qx("qx_sys_gsxx");
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
		parent::is_login();
		parent::have_qx("qx_sys_gggl");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ggbase=M("ggshezhi");
		$ggarr=$ggbase->query("select ggsz_id,ggsz_name,ggsz_ydcs,ggsz_fbsj,ggsz_zd,user_name from crm_ggshezhi left join crm_user on ggsz_yh=user_id where ggsz_yh='$fid' order by ggsz_zd_sj desc,ggsz_fbsj desc");
		$ggzdliststr='';
		$ggliststr='';
		$from=$_GET['from']=='main'?'&from=main':'';
		foreach($ggarr as $v)
		{
			if($v['ggsz_zd']=='1')
			{
				$ggzdliststr.="<tr><td class='checkbox_row'><input type='checkbox' value='".$v['ggsz_id']."' name='ggcheckbox'></td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/gonggaomore?ggid=".$v['ggsz_id']."$from'>".$v['ggsz_name']."</a></td><td>".$v['ggsz_ydcs']."</td><td>".$v['user_name']."</td><td>".$v['ggsz_fbsj']."</td><td><a onclick='ggbianji(".$v['ggsz_id'].")'>编辑</a><a onclick='ggzhiding(".$v['ggsz_id'].",0)'>取消置顶</a><a onclick=ggshanchu('".$v['ggsz_id']."','".$v['ggsz_name']."')>删除</a></td></tr>";
			}
			else
			{
				$ggliststr.="<tr><td class='checkbox_row'><input type='checkbox' value='".$v['ggsz_id']."' name='ggcheckbox'></td><td><a href='".$_GET['root_dir']."/index.php/Home/Option/gonggaomore?ggid=".$v['ggsz_id']."$from'>".$v['ggsz_name']."</a></td><td>".$v['ggsz_ydcs']."</td><td>".$v['user_name']."</td><td>".$v['ggsz_fbsj']."</td><td><a onclick='ggbianji(".$v['ggsz_id'].")'>编辑</a><a onclick='ggzhiding(".$v['ggsz_id'].",1)'>置顶</a><a onclick=ggshanchu('".$v['ggsz_id']."','".$v['ggsz_name']."')>删除</a></td></tr>";
			}
			
		}
		$this->assign("gglist",$ggzdliststr.$ggliststr);
		$this->display();
	}
	//公告详情页
	public function gonggaomore()
	{
		parent::is_login();
		parent::have_qx("qx_sys_gggl");
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
		parent::is_login();
		parent::have_qx("qx_sys_yjmb");
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
	//客户公海
	public function kehugonghai()
	{
		parent::is_login();
		parent::have_qx("qx_sys_khgh");
		$fid=parent::get_fid();
		$gharr=parent::sel_more_data("crm_gonghaishezhi","*","gh_yh='$fid' limit 1");
		if(!count($gharr))
		{
			$ghbase=M("gonghaishezhi");
			$ghbase->execute("insert into crm_gonghaishezhi set gh_open='0',gh_days='0',gh_yh='$fid'");
			$gharr[0]=array(
				"yh_open"=>"0",
				"gh_days"=>"0"
			);
		}
		$g=$gharr[0];
		$this->assign("open",$g['gh_open']);
		$this->assign("days",$g['gh_days']);
		
		$this->display();
	}
	//业绩目标详细
	public function yejimubiao_more(){
		parent::is_login();
		parent::have_qx("qx_sys_yjmb");
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
		parent::is_login();
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$baogaobase=M("gzbg");
		$bgval=$baogaobase->query("select * from crm_gzbg where gzbg_yh='$fid' limit 1");
		$this->assign("bgvalue",$bgval[0]['gzbg_val']);
		$this->display();
	}
	//工作报告
	public function gzbgdo()
	{
		parent::is_login();
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
		parent::is_login();
		parent::have_qx("qx_sys_ywzd");
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
						$can_bj=$v['bj']=='0'?"不可编辑":"<a onclick=bianji('".$v['id']."','".$v['sc']."')>编辑</a>";
						$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' ><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td>".$can_bj."</td></tr>";
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
				$can_bj=$v['bj']=='0'?"不可编辑":"<a onclick=bianji('".$v['id']."','".$v['sc']."')>编辑</a>";
				$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' ><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td>".$can_bj."</td></tr>";
			}
		}
		$this->assign("tablestr",$tablestr);
		$this->display();
	}
	//自定义业务参数
	public function zdyyw_canshu(){
		parent::is_login();
		parent::have_qx("qx_sys_ywcs");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select * from crm_yewuziduan where zd_yh='$fid' and zd_yewu!='7' ");
		$yw_key=array("1"=>"paixu_xiansuo","2"=>"paixu_kehu","4"=>"paixu_lianxiren","5"=>"paixu_shangji","6"=>"paixu_hetong");
		foreach($zdarr as $v1)
		{
			$zddataarr=json_decode($v1['zd_data'],true);
			foreach($zddataarr as $k=>$v)
			{
				$zdnamearr[$yw_key[$v1['zd_yewu']]][$v['id']]=$v['name'];
			}
		}
		$zdnamearr['paixu_qita']['gjtype']='其他';
		$zdnamearr['paixu_hetong']['hktype']='回款类型';
		$zdnamearr['paixu_hetong']['pjtype']='票据类型';
		$zdnamearr['paixu_lianxiren']['juese']='联系人角色';
		$pageidarr=array(
            "paixu_xiansuo"=>"1",
            "paixu_kehu"=>"2",
            "paixu_lianxiren"=>"4",
            "paixu_shangji"=>"5",
            "paixu_hetong"=>"6",
            "paixu_qita"=>"7",
            );
		$pxbase=M("paixu");
		$pxbasearr=$pxbase->query("select * from crm_paixu where px_yh='$fid' and px_mod>'10' ");
		foreach($pxbasearr as $v)
		{
			$pxarr[$v['px_mod']]=explode(',',$v['px_px']);
		}
		$csbase=M("ywcs");
		$csarr=$csbase->query("select * from crm_ywcs where ywcs_yh='$fid' order by ywcs_yw asc");
		//echo "<pre>";
		//print_r($pxarr);
		$csdataarr=json_decode($csarr[0]['ywcs_data'],true);
		$tableid=array("paixu_xiansuo1","paixu_xiansuo2","paixu_kehu1","paixu_kehu2","paixu_kehu3","paixu_kehu4","paixu_kehu5","paixu_lianxiren1","paixu_shangji1","paixu_shangji2","paixu_shangji3","paixu_hetong1","paixu_hetong2","paixu_hetong3","paixu_hetong4","paixu_hetong5","paixu_qita1");
		$tableidnum='0';
		$xshtmlstr="<div class='layui-tab-item layui-show'><div class='accordion'>";
		foreach($csarr as $row)
		{
			if($tableidnum!='0')
			{
				$xshtmlstr.="<div class='layui-tab-item'><div class='accordion'>";
			}
			$csdataarr=json_decode($row['ywcs_data'],true);
			foreach($csdataarr as $v)
			{	
				$xshtmlstr.="<h3>".$zdnamearr[substr($tableid[$tableidnum],0,-1)][$v['id']]."</h3><div><table class='layui-table' lay-skin='line' id='".$tableid[$tableidnum]."'>";
				$headstr=substr($tableid[$tableidnum],0,-1);
				$lastnum=substr($tableid[$tableidnum],-1,1);
				$pxkey=$pageidarr[$headstr].$lastnum;
				if(isset($pxarr[$pxkey]))
				{
					foreach($pxarr[$pxkey] as $k=>$val)
					{
						$knxstr='';
						if($tableid[$tableidnum]=='paixu_shangji2')
						{
							$knxstr="<td class='canshuwidth'>签单可能性：".$v['knx'][$val]."%<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></a></td>";
						}
						$checkstr=$v['qy'][$val]=='1'?'checked':'';
						$xshtmlstr.="<tr id='$val'><td class='tuozhuaiclass tuozhuaiwidth' ><i class='fa fa-reorder' aria-hidden='true'></i></td><td class='qiyongwidth'>&nbsp;&nbsp;<input type='checkbox' $checkstr ><span class='teshu'>启用</span></td><td class='canshuwidth'>".$v[$val]."<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></a></td>".$knxstr."</tr>";
					}
				}
				else
				{
					foreach($v['qy'] as $k=>$val)
					{
						if($k=='id'||$k=='qy'||$k=='knx')
						{
							continue;
						}
						$knxstr='';
						if($tableid[$tableidnum]=='paixu_shangji2')
						{
							$knxstr="<td class='canshuwidth'>签单可能性：".$v['knx'][$k]."%<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></a></td>";
						}
						$checkstr=$val=='1'?'checked':'';
						$xshtmlstr.="<tr id='$k'><td class='tuozhuaiclass tuozhuaiwidth'><i class='fa fa-reorder' aria-hidden='true'></i></td><td class='qiyongwidth'>&nbsp;&nbsp;<input type='checkbox' $checkstr ><span class='teshu'>启用</span></td><td class='canshuwidth'>".$v[$k]."<a class='xiugai'><i class='fa fa-pencil' aria-hidden='true'></a></td>".$knxstr."</tr>";
					}
				}
				$xshtmlstr.="</table><button class='layui-btn' onclick='addnewcanshu()'>添加</button></div>";
				$tableidnum++;
			}
			$xshtmlstr.="</div></div>";
		}
		$this->assign("xshtmlstr",$xshtmlstr);
		$this->display();
	}
	//自定审批
	public function shenpi(){
		parent::is_login();
		parent::have_qx("qx_sys_sp");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userbase=M("user");
		$userarr=$userbase->query("select user_name,user_id from crm_user where user_fid='$fid' or user_id='$fid'");
		foreach($userarr as $v)
		{
			$useroption.="<option value='".$v['user_id']."' class='class".$v['user_id']."'>".$v['user_name']."</option>";
			$usernamearr[$v['user_id']]=$v['user_name'];
		}
		$spbase=M("shenpi");
		$sparr1=$spbase->query("select * from crm_shenpi where sp_yh='$fid' and sp_type in ('1','2','3')");

		//初始化操作
		$spTypeArr=array('1'=>'1','2'=>'2','3'=>'3');
		if(count($sparr1)==0||count($sparr1)<3)
		{
			if(count($sparr1)==0)
			{
				//如果是个新用户，没有任何配置文件，就生成配置文件
				foreach($spTypeArr as $v)
				{
					$spbase->query("insert into crm_shenpi set sp_yh='$fid',sp_type='$v'");
				}
			}
			if(count($sparr1)<3)
			{
				
				foreach($sparr1 as $v)
				{
					unset($spTypeArr[$v['sp_type']]);
				}
				foreach($spTypeArr as $v)
				{
					$spbase->query("insert into crm_shenpi set sp_yh='$fid',sp_type='$v'");
				}
			}
			unset($sparr1);
			$sparr1=$spbase->query("select * from crm_shenpi where sp_yh='$fid' and sp_type in ('1','2','3')");
		}



		$sparr[$sparr1[0]['sp_type']]=$sparr1[0];
		$sparr[$sparr1[1]['sp_type']]=$sparr1[1];
		$sparr[$sparr1[2]['sp_type']]=$sparr1[2];

		
		
		//合同审批页--开启或关闭1/2/3级审批人按钮
		for($a=1;$a<=3;$a++)
		{
			$ischeck='';
			if($sparr[1]['sp_qy_'.$a]=='1')
			{
				$ischeck='checked';
			}
			$checkboxarr[$a]="<input type='checkbox' lay-filter='sp_qy_".$a."' id='sp_qy_".$a."' title='".$a."级审批人' $ischeck />";

			//开票
			$ischeck='';
			if($sparr[3]['sp_qy_'.$a]=='1')
			{
				$ischeck='checked';
			}
			$checkboxarr2[$a]="<input type='checkbox' lay-filter='kpsp_qy_".$a."' id='kpsp_qy_".$a."' title='".$a."级审批人' $ischeck />";
			
		}
		
		//审批同步按钮
		foreach($sparr as $k=>$v)
		{
			$tb=$sparr[$k]['sp_tb']==0?'':"checked";
			$tbbtn[$k]="<input type='checkbox' id='sptb".$k."' lay-filter='sp_tb".$k."' title='&nbsp;审批同步&nbsp;' $tb>";
		}
		//合同审批页--审批人下拉框
		$optionarr=array("提交人上级","固定审批人","超级管理员");
		for($key=1;$key<=3;$key++)
		{
			for($a=0;$a<3;$a++)
			{
				$isselected='';
				
				if($sparr[1]['sp_type_'.$key]==($a+1))
				{
					$isselected='selected';
					if($sparr[1]['sp_type_'.$key]=='2')
					{
						$spuserarr=explode(',',$sparr[1]['sp_value_'.$key]);
						$spanstr='';
						foreach($spuserarr as $v)
						{
							$spanstr.="<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span".$v."'>".$usernamearr[$v]."<a onclick=guanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
						}
						$btnstr[$key]="<button class='layui-btn' style='height:30px;line-height:30px;margin-right:30px;' onclick='spxuanze(this)'>选择审批人</button>".$spanstr;
					}
				}
				$spsel[$key].="<option value='".($a+1)."' $isselected >$optionarr[$a]</option>";
			}
		}
		//开票
		for($key=1;$key<=3;$key++)
		{
			for($a=0;$a<3;$a++)
			{
				$isselected='';
				
				if($sparr[3]['sp_type_'.$key]==($a+1))
				{
					$isselected='selected';
					if($sparr[3]['sp_type_'.$key]=='2')
					{
						$spuserarr=explode(',',$sparr[3]['sp_value_'.$key]);
						$spanstr2='';
						foreach($spuserarr as $v)
						{
							$spanstr2.="<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span".$v."'>".$usernamearr[$v]."<a onclick=guanbi2(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
						}
						$btnstr2[$key]="<button class='layui-btn' style='height:30px;line-height:30px;margin-right:30px;' onclick='spxuanze2(this)'>选择审批人</button>".$spanstr2;
					}
				}
				$spsel2[$key].="<option value='".($a+1)."' $isselected >$optionarr[$a]</option>";
			}
		}
		//合同回款审批--审批人复选框
		$hkuserarr=array("","超级管理员","提交人上级","固定审批人");
		for($a=1;$a<=3;$a++)
		{
			$hkchecked='';
			if($sparr[2]['sp_qy_'.$a]=='1')
			{
				$hkchecked='checked';
			}
			$hkboxarr[$a]="<input type='checkbox' lay-filter='hksp_qy_".$a."' id='hksp_qy_".$a."' $hkchecked title='".$hkuserarr[$a]."' />";
		}
		if($sparr[2]['sp_value_3']!='')
		{
			$hkspanstr='';
			$hkuserarr=explode(",",$sparr[2]['sp_value_3']);
			foreach($hkuserarr as $v)
			{
				$hkspanstr.="<span style='display:inline-block;border-radius:5px;background-color:#33AB9F;height:20px;margin-bottom:5px;padding:5px;color:#fff;margin-right:10px;' class='span".$v."'>".$usernamearr[$v]."<a onclick=huikuanguanbi(this)  style='color:#fff;margin-left:10px;'>×</a></span>";
			}
		}


		$this->assign("tbbtn",$tbbtn);
		$this->assign("hkspanstr",$hkspanstr);
		$this->assign("hkboxarr",$hkboxarr);
		$this->assign("btnstr",$btnstr);
		$this->assign("btnstr2",$btnstr2);//开票
		$this->assign("spsel",$spsel);
		$this->assign("spsel2",$spsel2);//开票
		$this->assign("checkboxarr",$checkboxarr);
		$this->assign("checkboxarr2",$checkboxarr2);//开票
		$this->assign("sparr",$sparr[1]);
		$this->assign("hksparr",$sparr[2]);
		$this->assign("kpsparr",$sparr[3]);
		$this->assign("useroption",$useroption);
		$this->display();
	}
	//自定义筛选
	public function shaixuan()
	{
		parent::is_login();
		parent::have_qx("qx_sys_sx");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		//筛选条件html结构
		$sxtjoption="<select><option value='1'>单条件筛选</option><option value='2'>多条件筛选</option><option value='3'>文本筛选</option><option value='4'>文本区间</option><option value='5'>自动区间</option></select>";
		//产品分类
		$cpflbase=M("chanpinfenlei");
		$cpflbasearr=$cpflbase->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid' ");
		
		$cpfl_option='';
		foreach($cpflbasearr as $v)
		{
			$cpfl_option.="<option value='".$v['cpfl_id']."'>".$v['cpfl_name']."</option>";
		}
		//筛选表操作
		$sxbase=M("shaixuan");
		$sxbasearr=$sxbase->query("select * from crm_shaixuan where sx_yh='$fid' ");
		foreach($sxbasearr as $sxrow)
		{
			$sxarr[$sxrow['sx_yewu']]=json_decode($sxrow['sx_data'],true);
			$sxarr[$sxrow['sx_yewu']]["qy"]=$sxrow['sx_qy'];
			$sxarr[$sxrow['sx_yewu']]["sctime"]=$sxrow['sx_time'];
		}
		//字段表操作,生成html表结构
		$zdbase=M("yewuziduan");
		$zdbasearr=$zdbase->query("select * from crm_yewuziduan where zd_yh='$fid'");
		foreach($zdbasearr as $zdrow)
		{
			$yewu=$zdrow['zd_yewu'];
			$zdjsonarr=json_decode($zdrow['zd_data'],true);
			foreach($zdjsonarr as $jsonrow)
			{
				if($jsonrow['qy']!='1')	continue;
				$thisid=$jsonrow['id'];
				if(substr($yewu,0,1)=='7')
				{
					if($thisid=='zdy7'||$thisid=='zdy6')	continue;//这个是产品图片
				}
				$checkedstr=$sxarr[$yewu][$thisid]['qy']=='1'?'checked':'';
				$thisoption=$sxarr[$yewu][$thisid]['xx']>0?str_replace("value='".$sxarr[$yewu][$thisid]['xx']."'","value='".$sxarr[$yewu][$thisid]['xx']."' selected",$sxtjoption):$sxtjoption;
				$thisoption=str_replace("<select>","<select class='ys".$yewu."' name='".$thisid."'>",$thisoption);
				$displaynone=$sxarr[$yewu][$thisid]['xx']=='5'?'':"display:none;";
				$qjzhi=$sxarr[$yewu][$thisid]['xx']=='5'?$sxarr[$yewu][$thisid]['qj']:'';
				$sxtable[$yewu].="<tr><td>".$jsonrow['name']."</td><td><input type='checkbox' $checkedstr name='".$thisid."' class='y".$yewu."' /></td><td>".$thisoption."<span class='qjspan' style='margin-left:10px;".$displaynone."'>区间数：<input class='qj".$yewu."' type='number' name='qjnum".$thisid."' style='width:60px' value='".$qjzhi."'></span></td></tr>";
			}
			$ntime='0000-00-00 00:00:00';
			$sctime[$yewu]=$sxarr[$yewu]['sctime']==''?$ntime:$sxarr[$yewu]['sctime'];
			$qy[$yewu]=$sxarr[$yewu]['qy'];
		}
		$this->assign("cpfl_option",$cpfl_option);
		$this->assign("qy",json_encode($qy));
		$this->assign("sxtable",json_encode($sxtable));
		$this->assign("sctime",json_encode($sctime));
		$this->display();
	}
	//日志
	public function rizhi(){
		parent::is_login();
		parent::have_qx("qx_sys_rz");
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
	//构造部门的分级结构
	public function get_bm_tree($bumenArr)
	{
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
		return $bmLvArr;
	}
	
	public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("juesequanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0'");
		foreach($userarr as $v)
		{
			$userkeyid[$v['user_id']]=$v;
		}
		$nowloginqx=$userkeyid[$nowloginid]['user_quanxian'];
		$nowloginbid=$userkeyid[$nowloginid]['user_zhu_bid'];

		$qxarr=$qxbase->query("select qx_data_qx from crm_juesequanxian where qx_yh='$nowloginfid' and qx_id='$nowloginqx'");
		$dataqx=$qxarr[0]['qx_data_qx'];
		$bmbasearr=$bmbase->query("select * from crm_department where bm_company='$nowloginfid'");
		for($a=0;$a<10;$a++)
		{
			foreach($bmbasearr as $v)
			{
				if($v['bm_id']==$nowloginbid||in_array($v['bm_fid'],$bmid))
					$bmid[$v['bm_id']]=$v['bm_id'];
			}
		}
		if($dataqx=='1')
		{
			return "'".$nowloginid."'";
		}
		$foreachnum=0;
		foreach($userkeyid as $v)
		{
			if($v['user_zhuguan_id']=='0')
			{
				continue;
			}
			foreach($userkeyid as $kk=>$vv)
			{
				if($vv['user_zhuguan_id']==$nowloginid||in_array($vv['user_zhuguan_id'],$nowzgid))
				{
					$nowzgid[$vv['user_id']]=$vv['user_id'];
				}
			}
			if($foreachnum=='50')
			{
				break;
			}
			$foreachnum++;
		}
		$nowzgid[$nowloginid]=$nowloginid;
		foreach($nowzgid as $k=>$v)
		{
			if($dataqx=='2')
			{
				if($userkeyid[$v]['user_zhu_bid']!=$nowloginbid)
					unset($nowzgid[$k]);
			}
			if($dataqx=='3')
			{
				if(!in_array($userkeyid[$v]['user_zhu_bid'],$bmid))
					unset($nowzgid[$k]);
			}
		}
		return "'".implode("','",$nowzgid)."'";
	}
}



