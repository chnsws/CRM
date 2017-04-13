<?php
namespace Home\Controller;
use Think\Controller;


class ChanpinController extends Controller {
    public function index(){
        if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        //产品分类表操作
		$cpflbase=M("chanpinfenlei");
		$cpflarr=$cpflbase->query("select * from crm_chanpinfenlei where cpfl_company='$fid' ");
		foreach($cpflarr as $cpflarrKey=>$cpflarrVal)//格式化产品分类分级
		{
			$bumenNewArr[$cpflarrVal['cpfl_id']]=array("cpfl_name"=>$cpflarrVal['cpfl_name'],"cpfl_fid"=>$cpflarrVal['cpfl_fid']);
			$flidlist.="<tr><td>".$cpflarrVal['cpfl_name']."</td><td>".$cpflarrVal['cpfl_id']."</td></tr>";
		}
		//产品分类遍历排序
		foreach($bumenNewArr as $bmNewKey=>$bmNewVal)
		{
			$bumenFname[$bmNewKey]=$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_name'];
			if($bmNewVal['cpfl_fid']=='0')//1级分类
			{
				$bmLvArr[$bmNewKey]['cpfl_name']=$bmNewVal['cpfl_name'];
			}
			else
			{
				if($bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']=='0')
				{
					$bmLvArr[$bmNewVal['cpfl_fid']]["lv2"][$bmNewKey]["cpfl_name"]=$bmNewVal['cpfl_name'];
				}
				else
				{
					if($bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']=='0')
					{
						$bmLvArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['lv2'][$bmNewVal['cpfl_fid']]['lv3'][$bmNewKey]["cpfl_name"]=$bmNewVal['cpfl_name'];
					}
					else
					{
						if($bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['cpfl_fid']=='0')
						{
							$bmLvArr[$bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['lv2'][$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['lv3'][$bmNewVal['cpfl_fid']]['lv4'][$bmNewKey]["cpfl_name"]=$bmNewVal['cpfl_name'];
						
						}
						else
						{
							if($bumenNewArr[$bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['cpfl_fid']=='0')
							{
								$bmLvArr[$bumenNewArr[$bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['lv2'][$bumenNewArr[$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['cpfl_fid']]['lv3'][$bumenNewArr[$bmNewVal['cpfl_fid']]['cpfl_fid']]['lv4'][$bmNewVal['cpfl_fid']]['lv5'][$bmNewKey]["cpfl_name"]=$bmNewVal['cpfl_name'];
							}
							else
							{

							}
						}
					}
				}
			}
		}
        $cpfloption="<option value='0'>选择产品分类</option>";
		//生成部门结构HTML
		foreach($bmLvArr as $k=>$v)
		{
			$bmList.="<li class='lv1 lv-on' id='id".$k."' value='1' name='1'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
            $cpfloption.="<option value='".$k."'>".$v['cpfl_name']."</option>";
			if(count($v['lv2'])>0)
			{
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
					$bmList.="<li class='lv2 lv-on lv1".$k."' id='id".$lv2k."' value='1' name='2'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv2v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv2k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv2k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv2k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv2k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                    $cpfloption.="<option value='".$lv2k."'>&nbsp;&nbsp;&nbsp;".$lv2v['cpfl_name']."</option>";
					if(count($lv2v['lv3'])>0)
					{
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
							$bmList.="<li class='lv3 lv-on lv2".$lv2k." lv1".$k."' id='id".$lv3k."' value='1' name='3'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv3v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv3k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv3k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv3k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv3k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                            $cpfloption.="<option value='".$lv3k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv3v['cpfl_name']."</option>";
							if(count($lv3v['lv4'])>0)
							{
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
									$bmList.="<li class='lv4 lv-on lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv4k."' value='1' name='4'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv4v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv4k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv4k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv4k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv4k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                                    $cpfloption.="<option value='".$lv4k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv4v['cpfl_name']."</option>";
									if(count($lv4v['lv5'])>0)
									{
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
											$bmList.="<li class='lv5 lv-on lv4".$lv4k." lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv5k."' value='1' name='5'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv5v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv5k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv5k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv5k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                                            $cpfloption.="<option value='".$lv5k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv5v['cpfl_name']."</option>";
										}
									}
								}
							}
						}
					}
				}
			}
		}

		//开始产品列表操作
		$cpbase=M("chanpin");
		$cparr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid' and cp_del='0'");
		//echo "<pre>";
		//print_r($cparr);
		foreach($cparr as $v)
		{
			$m_lilv=(($v['cp_danjia']-$v['cp_chengben'])/$v['cp_danjia'])*100;
			$m_lilv=round($m_lilv,2).'%';
			if($v['cp_chengben']=='')
			{
				$m_lilv='-';
				$v['cp_chengben']='-';
			}
			$cp_fenlei=$bumenNewArr[$v['cp_fenlei']]['cpfl_name']==''?'-':$bumenNewArr[$v['cp_fenlei']]['cpfl_name'];
			$cp_jieshao=$v['cp_jieshao']==''?'-':$v['cp_jieshao'];
			$cp_jieshaoall=$cp_jieshao;
			$cp_jieshao=mb_strlen($cp_jieshao)>10?mb_substr($cp_jieshao,0,10).'...':$cp_jieshao;
			$jy_css='';
			if($v['cp_qy']=='0')
			{
				$jy_list.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td style='color:#ccc;'>".$v['cp_num']."</td><td style='color:#ccc;'>".$v['cp_danjia']."</td><td style='color:#ccc;'>".$v['cp_danwei']."</td><td style='color:#ccc;'>".$v['cp_chengben']."</td><td style='color:#ccc;'>".$m_lilv."</td><td style='color:#ccc;'>".$cp_fenlei."</td><td style='color:#ccc;'>".$cp_jieshao."</td><td style='color:#ccc;'>".$v['cp_add_time']."</td><td style='color:#ccc;'>".$v['cp_edit_time']."</td></tr>";
			}
			else
			{
				$cplist.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td>".$v['cp_num']."</td><td>".$v['cp_danjia']."</td><td>".$v['cp_danwei']."</td><td>".$v['cp_chengben']."</td><td>".$m_lilv."</td><td>".$cp_fenlei."</td><td title='".$cp_jieshaoall."'>".$cp_jieshao."</td><td>".$v['cp_add_time']."</td><td>".$v['cp_edit_time']."</td></tr>";
			}
		}
		
		$this->assign("flidlist",$flidlist);
		$this->assign("cplist",$cplist.$jy_list);
        $this->assign("cpfloption",$cpfloption);
        $this->assign("bmlist",$bmList);
        $this->display();
    }
    //导入时文件上传方法
    public function file_daoru()
    {
        echo '{"code": 0,"res": "1","data": {"src": "123"}}';   
    }
	//产品详情
	public function chanpininfo()
	{
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$cpid=addslashes($_GET['cpid']);
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）

		$cpbase=M("chanpin");
		$cpinfoarr=$cpbase->query("select * from crm_chanpin where cp_id='$cpid' and cp_yh='$fid' and cp_del='0' limit 1");
		$cpinfoarr=$cpinfoarr[0];
		if($cpinfoarr['cp_id']==''||$cpinfoarr['cp_yh']!=$fid)//如果没有接收到传参,或者没有登录
		{
			die("数据错误");
		}

		$cp_flbase=M("chanpinfenlei");
		$cpflarr1=$cp_flbase->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid'");
		$cpfloption='<option value="0">未选择</option>';
		foreach($cpflarr1 as $k=>$v)
		{
			$cpflarr[$v['cpfl_id']]=$v['cpfl_name'];
			$flseled=$cpinfoarr['cp_fenlei']==$v['cpfl_id']?'selected':'';
			$cpfloption.="<option value='".$v['cpfl_id']."' $flseled >".$v['cpfl_name']."</option>";
		}
		$jy_btn=$cpinfoarr['cp_qy']=='1'?"<button id='qyjybtn' class='layui-btn' onclick='jy_qy_chanpin(0)'><i class='fa fa-lock' aria-hidden='true'></i>禁用</button>":"<button id='qyjybtn' class='layui-btn' onclick='jy_qy_chanpin(1)'><i class='fa fa-unlock' aria-hidden='true'></i>启用</button>";
		$cpinfoarr['cpfl']=$cpflarr[$cpinfoarr['cp_fenlei']];
		$cpinfoarr['lilv']=((($cpinfoarr['cp_danjia']-$cpinfoarr['cp_chengben'])/$cpinfoarr['cp_danjia'])*100);
		$cpinfoarr['lilv']=round($cpinfoarr['lilv'],2).'%';

		//附件
		$fjbase=M("cp_file");
		$fjinfoarr=$fjbase->query("select * from crm_cp_file where fj_del='0' and fj_yh='$fid' and fj_cp='$cpid' ");
		foreach($fjinfoarr as $v)
		{
			$fjtable.="<tr><td>".$v['fj_date']."</td><td>".substr($v['fj_name'],10)."</td><td>".$v['fj_size']."</td><td>".$v['fj_bz']."</td><td><span class='link_span' onclick='down_fujian(".$v['fj_id'].")'>下载</span><span class='link_span' onclick='del_fujian(".$v['fj_id'].")'>删除</span></td></tr>";
		}
		$fjtable=$fjtable==''?"<tr><td colspan='5' align='center'>没有附件</td></tr>":$fjtable;

		$this->assign("jy_btn",$jy_btn);
		$this->assign("cpfloption",$cpfloption);
		$this->assign("fjtable",$fjtable);
		$this->assign("cpinfoarr",$cpinfoarr);
		$this->display();
	}
	//新增产品
	public function cp_add()
	{
		$cp_name=addslashes($_POST['cp_name']);
		$cp_num=addslashes($_POST['cp_num']);
		$cp_danjia=addslashes($_POST['cp_danjia']);
		$cp_danwei=addslashes($_POST['cp_danwei']);
		$cp_chengben=addslashes($_POST['cp_chengben']);
		$cp_fenlei=addslashes($_POST['cp_fenlei']);
		$cp_img=addslashes($_POST['cp_img']);
		$cp_jieshao=addslashes($_POST['cp_jieshao']);
		if($cp_name==''||$cp_num==''||$cp_danjia==''||$cp_danwei=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$adduser=cookie("user_id");
		$nowtime=date("Y-m-d H:i:s",time());
		$cpbase=M("chanpin");
		$cfarr=$cpbase->query("select cp_name,cp_num from crm_chanpin where (cp_name='$cp_name' or cp_num='$cp_num') and cp_yh='$fid' and cp_fenlei='$cp_fenlei' and cp_del='0' ");
		
		foreach($cfarr as $v)
		{
			$cfnamearr[$v['cp_name']]=1;
			$cfnumarr[$v['cp_num']]=1;
		}
		if($cfnamearr[$cp_name]=='1')
		{
			echo '3';
			die;
		}
		if($cfnumarr[$cp_num]=='1')
		{
			echo '4';
			die;
		}
		$cpbase->query("insert into crm_chanpin values('','$cp_name','$cp_num','$cp_danwei','$cp_danjia','$cp_chengben','$cp_fenlei','$cp_img','$cp_jieshao','$nowtime','$nowtime','1','0','$adduser','$fid')");
		echo $this->insertrizhi("新增产品：".$cp_name);
	}
	//新增产品图片
	public function cp_img_add()
	{
		
		//文件保存
        
        if(count($_FILES['cpimage'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['cpimage'];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=time().$getFileArr['name'];
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpimg/'.$newname);
        if(!file_exists('./Public/chanpinfile/cpimg/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		//$sizestr=$getFileArr['size']>=1048576?($getFileArr['size']/1048576).'M':($getFileArr['size']/1024).'K';
       

        echo '{"res":1,"newname":"'.$newname.'"}';
        //echo json_encode($_FILES['headimg']);
        //echo $_FILES;
		//echo '{"code": 0,"res": "1","data": {"src": "123"}}';  
	}
	//删除旧图片
	public function del_old_img()
	{
		$oldname=addslashes($_GET['oldname']);
		if($oldname=='')die;
		unlink('./Public/chanpinfile/cpimg/'.$oldname);
	}
	//批量转移
	public function zhuanyi()
	{
		$sel_id=addslashes($_GET['sel_id']);
		$newflid=addslashes($_GET['newflid']);
		if($sel_id==''||$newflid=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$instr="'".str_replace(',',"','",$sel_id)."'";
		$instr=str_replace('chid','',$instr);
		$cpbase=M("chanpin");
		$cpbase->query("update crm_chanpin set cp_fenlei='$newflid' where cp_id in ($instr) and cp_yh='$fid'");
		echo $this->insertrizhi("修改了多个产品的分类");
	}
	//批量启用、禁用
	public function qy_jy()
	{
		$sel_id=addslashes($_GET['sel_id']);
		$qyjy=addslashes($_GET['qyjy']);
		$pagename=addslashes($_GET['pagename']);
		if($sel_id==''||$qyjy=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$instr="'".str_replace(',',"','",$sel_id)."'";
		$instr=str_replace('chid','',$instr);
		$cpbase=M("chanpin");
		$cpbase->query("update crm_chanpin set cp_qy='$qyjy' where cp_id in ($instr) and cp_yh='$fid'");
		$rzstr=$qyjy=='1'?'启用':'禁用';
		$cpname=$pagename==''?'多个产品':$pagename;
		echo $this->insertrizhi($rzstr."了产品：".$cpname);
	}
	//多选删除
	public function del_more()
	{
		$sel_id=addslashes($_GET['sel_id']);
		$delname=addslashes($_GET['delname']);
		if($sel_id=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$instr="'".str_replace(',',"','",$sel_id)."'";
		$instr=str_replace('chid','',$instr);
		$cpbase=M("chanpin");
		$cpbase->query("update crm_chanpin set cp_del='1' where cp_id in ($instr) and cp_yh='$fid'");
		if($delname=='')
		{
			echo $this->insertrizhi("删除了多个产品");
		}
		else
		{
			echo $this->insertrizhi("删除产品：".$delname);
		}
	}
	//搜索
	public function searchfun()
	{
		$sea_type=addslashes($_POST['sea_type']);
		$sea_text=addslashes($_POST['sea_text']);
		$search_type=array("1"=>"cp_name","2"=>"cp_num","3"=>"cp_danwei","4"=>"cp_jieshao");
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		
		$wherestr=$sea_type>0?"and ".$search_type[$sea_type]." like '%$sea_text%'":'';
		//echo "select * from crm_chanpin where cp_yh='$fid' $wherestr  and cp_del='0'";die;
		$cpbase=M("chanpin");
		$seaarr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid' $wherestr  and cp_del='0'");
		if(count($seaarr)<1)
		{
			$seatable="<tr><td colspan='11'>没有搜索结果</td></tr>";
			echo $seatable;
			die;
		}
		$cpflbase=M("chanpinfenlei");
		$cpflarr=$cpflbase->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid'");
		foreach($cpflarr as $v)
		{
			$flarr[$v['cpfl_id']]=$v['cpfl_name'];
		}
		foreach($seaarr as $v)
		{
			$m_lilv=(($v['cp_danjia']-$v['cp_chengben'])/$v['cp_danjia'])*100;
			$m_lilv=round($m_lilv,2).'%';
			if($v['cp_chengben']=='')
			{
				$m_lilv='-';
				$v['cp_chengben']='-';
			}
			$cp_fenlei=$flarr[$v['cp_fenlei']]==''?'-':$flarr[$v['cp_fenlei']];
			$cp_jieshao=$v['cp_jieshao']==''?'-':$v['cp_jieshao'];
			$cp_jieshaoall=$cp_jieshao;
			$cp_jieshao=mb_strlen($cp_jieshao)>10?mb_substr($cp_jieshao,0,10).'...':$cp_jieshao;
			$jy_css='';
			if($v['cp_qy']=='0')
			{
				$jy_list.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td style='color:#ccc;'>".$v['cp_num']."</td><td style='color:#ccc;'>".$v['cp_danjia']."</td><td style='color:#ccc;'>".$v['cp_danwei']."</td><td style='color:#ccc;'>".$v['cp_chengben']."</td><td style='color:#ccc;'>".$m_lilv."</td><td style='color:#ccc;'>".$cp_fenlei."</td><td style='color:#ccc;'>".$cp_jieshao."</td><td style='color:#ccc;'>".$v['cp_add_time']."</td><td style='color:#ccc;'>".$v['cp_edit_time']."</td></tr>";
			}
			else
			{
				$cplist.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td>".$v['cp_num']."</td><td>".$v['cp_danjia']."</td><td>".$v['cp_danwei']."</td><td>".$v['cp_chengben']."</td><td>".$m_lilv."</td><td>".$cp_fenlei."</td><td title='".$cp_jieshaoall."'>".$cp_jieshao."</td><td>".$v['cp_add_time']."</td><td>".$v['cp_edit_time']."</td></tr>";
			}
		}
		echo $cplist.$jy_list;
	}
	//添加产品分类
	public function addfl()
	{
		$addfid=addslashes($_GET['addfid']);
		$newname=addslashes($_GET['newname']);
		if($addfid==''||$newname=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$flbase=M("chanpinfenlei");
		$flnum=$flbase->query("select cpfl_id from crm_chanpinfenlei where cpfl_name='$newname' and cpfl_company='$fid' limit 1");
		if(count($flnum)>0)
		{
			echo '3';
			die;
		}
		$flbase->query("insert into crm_chanpinfenlei values('','$newname','$addfid','$fid')");
		echo $this->insertrizhi("新增了产品分类：".$newname);
	}
	//修改产品分类
	public function editfl()
	{
		$editid=addslashes($_GET['editid']);
		$newname=addslashes($_GET['newname']);
		if($editid==''||$newname=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$flbase=M("chanpinfenlei");
		$flnum=$flbase->query("select cpfl_id from crm_chanpinfenlei where cpfl_name='$newname' and cpfl_company='$fid' limit 1");
		if(count($flnum)>0)
		{
			echo '3';
			die;
		}
		$flbase->query("update crm_chanpinfenlei set cpfl_name='$newname' where cpfl_id='$editid' and cpfl_company='$fid' limit 1");
		echo $this->insertrizhi("修改了产品分类：".$newname);
	}
	//删除产品分类
	public function delfl()
	{
		$delid=addslashes($_GET['delid']);
		$delname=addslashes($_GET['delname']);
		if($delid=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$flbase=M("chanpinfenlei");
		$flarr=$flbase->query("select * from crm_chanpinfenlei where cpfl_company='$fid' ");
		$inflarr[$delid]=$delid;
		for($a=0;$a<6;$a++)
		{
			foreach($flarr as $v)
			{
				if(in_array($v['cpfl_fid'],$inflarr))
				{
					$inflarr[$v['cpfl_id']]=$v['cpfl_id'];
					$aaa.=$v['cpfl_id'];
				}
			}
		}
		$instr="'".implode("','",$inflarr)."'";
		$flbase->query("delete from crm_chanpinfenlei where cpfl_id in ($instr) ");
		echo $this->insertrizhi("删除了产品分类：".$delname." 以及下级分类");
	}
	//修改产品文件
	public function editimg()
	{
			//文件保存
        
        if(count($_FILES['editcpimage'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['editcpimage'];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        //$oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=time().$getFileArr['name'];
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpimg/'.$newname);
        if(!file_exists('./Public/chanpinfile/cpimg/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		//$sizestr=$getFileArr['size']>=1048576?($getFileArr['size']/1048576).'M':($getFileArr['size']/1024).'K';
       

        echo '{"res":1,"newname":"'.$newname.'"}';
        //echo json_encode($_FILES['headimg']);
        //echo $_FILES;
		//echo '{"code": 0,"res": "1","data": {"src": "123"}}'; 

		//$cpbase=M("chanpin");
		//$cpbase->query("select cp_img from crm_chanpin where cp_");
		//$oldname=addslashes($_GET['oldname']);
		//if(!$oldname)die;
		//unlink('./Public/chanpinfile/cpimg/'.$oldname);
	}
	//修改产品数据
	public function editcp()
	{
		$editstr=addslashes($_POST['editstr']);
		$nowpageid=addslashes($_POST['nowpageid']);
		$nowpagename=addslashes($_POST['nowpagename']);
		if($nowpageid==''||$editstr=='')
		{
			echo '2';
			die;
		}
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cpbase=M("chanpin");
		
		$editarr=explode("],[",substr($editstr,1,-2));
		//print_r($editarr);
		$setstr='';
		foreach($editarr as $v)
		{
			$varr=explode("]:[",$v);
			if($varr[0]=='del_img')
			{
				unlink('./Public/chanpinfile/cpimg/'.$varr[1]);
				continue;
			}
			$setstr.=$varr[0]."='".$varr[1]."',";
		}
		$setstr.="cp_edit_time='".date("Y-m-d H:i:s",time())."'";
		//$setstr=substr($setstr,0,-1);

		$cpbase->query("update crm_chanpin set $setstr where cp_id='$nowpageid' and cp_yh='$fid' limit 1");

		echo $this->insertrizhi("修改了产品：".$nowpagename);


		//unlink('./Public/chanpinfile/cpimg/'.$oldname);
	}
	//根据左边产品分类改变右边产品列表
	public function get_fl_cplist()
	{
		$clickflid=addslashes($_GET['clickflid']);
		if($clickflid=='')
		{
			echo '';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cpbase=M("chanpin");
		$fenlei_where=$clickflid>0?"cp_fenlei='$clickflid' and ":'';
		$newcparr=$cpbase->query("select * from crm_chanpin left join crm_chanpinfenlei on cpfl_id=cp_fenlei  where $fenlei_where cp_yh='$fid' and cp_del='0' ");
		if(count($newcparr)<1)
		{
			echo "<tr><td colspan='11'><center>没有产品数据</center></td></tr>";
			die;
		}
		$newtablestr='';
		foreach($newcparr as $v)
		{
			$m_lilv=(($v['cp_danjia']-$v['cp_chengben'])/$v['cp_danjia'])*100;
			$m_lilv=round($m_lilv,2).'%';
			if($v['cp_chengben']=='')
			{
				$m_lilv='-';
				$v['cp_chengben']='-';
			}
			$cp_fenlei=$v['cpfl_name']==''?'-':$v['cpfl_name'];
			$cp_jieshao=$v['cp_jieshao']==''?'-':$v['cp_jieshao'];
			$cp_jieshaoall=$cp_jieshao;
			$cp_jieshao=mb_strlen($cp_jieshao)>10?mb_substr($cp_jieshao,0,10).'...':$cp_jieshao;
			$jy_css='';
			if($v['cp_qy']=='0')
			{
				$jy_list.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td style='color:#ccc;'>".$v['cp_num']."</td><td style='color:#ccc;'>".$v['cp_danjia']."</td><td style='color:#ccc;'>".$v['cp_danwei']."</td><td style='color:#ccc;'>".$v['cp_chengben']."</td><td style='color:#ccc;'>".$m_lilv."</td><td style='color:#ccc;'>".$cp_fenlei."</td><td style='color:#ccc;'>".$cp_jieshao."</td><td style='color:#ccc;'>".$v['cp_add_time']."</td><td style='color:#ccc;'>".$v['cp_edit_time']."</td></tr>";
			}
			else
			{
				$cplist.="<tr><td><input type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td><td class='cp_name_td' onclick='link_info(".$v['cp_id'].")'>".$v['cp_name']."</td><td>".$v['cp_num']."</td><td>".$v['cp_danjia']."</td><td>".$v['cp_danwei']."</td><td>".$v['cp_chengben']."</td><td>".$m_lilv."</td><td>".$cp_fenlei."</td><td title='".$cp_jieshaoall."'>".$cp_jieshao."</td><td>".$v['cp_add_time']."</td><td>".$v['cp_edit_time']."</td></tr>";
			}
		}
		$newtablestr=$cplist.$jy_list;
		echo $newtablestr;
	}
	//上传产品附件
	public function cp_file()
	{
		//文件保存
        if(count($_FILES['cp_file'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['cp_file'];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=time().$getFileArr['name'];
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpfile/'.$newname);
        if(!file_exists('./Public/chanpinfile/cpfile/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
       

        echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$getFileArr['name'].'"}';
	}
	//删除旧附件
	public function del_old_file()
	{
		$oldname=addslashes($_GET['oldname']);
		if($oldname=='')die;
		unlink('./Public/chanpinfile/cpfile/'.$oldname);
	}
	//保存产品附件
	public function bt_cpfj()
	{
		$fjbz=addslashes($_GET['fjbz']);
		$fjmc=addslashes($_GET['fjmc']);
		$fjdx=addslashes($_GET['fjdx']);
		$fjcpid=addslashes($_GET['fjcpid']);
		$upoldname=addslashes($_GET['upoldname']);
		if($fjmc==''||$fjdx=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$fjbase=M("cp_file");
		$fjbase->query("insert into crm_cp_file values('','$fjmc','$fjdx','$fjbz','$fjcpid','".date("Y-m-d H:i:s",time())."','0','".cookie("user_id")."','$fid')");
		echo $this->insertrizhi("上传了附件：".$upoldname);
	}
	//重载附件列表
	public function reload_file_list()
	{
		$reloadcpid=addslashes($_GET['reloadcpid']);
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$fjbase=M("cp_file");
		$reloadfjarr=$fjbase->query("select * from crm_cp_file where fj_cp='$reloadcpid' and fj_yh='$fid' and fj_del='0' ");
		$newfjtable='';
		foreach($reloadfjarr as $v)
		{
			$newfjtable.="<tr><td>".$v['fj_date']."</td><td>".substr($v['fj_name'],10)."</td><td>".$v['fj_size']."</td><td>".$v['fj_bz']."</td><td><span class='link_span' onclick='down_fujian(".$v['fj_id'].")'>下载</span><span class='link_span' onclick='del_fujian(".$v['fj_id'].")'>删除</span></td></tr>";
		}
		$newfjtable=$newfjtable==''?"<tr><td colspan='5' align='center'>没有附件</td></tr>":$newfjtable;
		
		echo $newfjtable;
	}
	//根据附件id删除附件
	public function del_fj()
	{
		$delfjid=addslashes($_GET['delfjid']);
		$fjname=addslashes($_GET['fileyname']);
		if($delfjid=='')
		{
			echo '2';
			die;
		}
		$fjbase=M("cp_file");
		$fjbase->query("update crm_cp_file set fj_del='1' where fj_id='$delfjid' limit 1");
		echo $this->insertrizhi("删除了产品附件：".$fjname);
	}
	//导入模板下载
	public function get_muban()
	{
		$name="产品数据导入模板";
		//$name=iconv("utf-8","gbk//IGNORE",$name);
		$head=array(
			"1"=>"产品名称(必填)",
			"2"=>"产品编号(必填)",
			"5"=>"销售单位(必填)",
			"3"=>"标准单价(必填)",
			"6"=>"单位成本",
			"7"=>"产品分类ID(根据分类id表填写)",
			"8"=>"产品介绍"
			);
		//连接标题
		$r = implode(',',$head);
		$r .="\n";
		//$r = iconv("utf-8","gbk//IGNORE",$r);
		$body[0]=array(
			0=>"小米note2",
			1=>"10086",
			3=>"部",
			2=>"3600",
			4=>"1000",
			5=>"3",
			6=>"双曲面手机",
			);
		foreach($body as $arr)
		{
			$line=implode(',',$arr);
			$r.=$line;
			//$r .= iconv("utf-8","gbk//IGNORE",$line);
			$r.="\n";
		}
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $r;
		die;
	}
	//上传csv文件
	public function chanpin_csv_upload()
	{
		//文件保存
        if(count($_FILES['csv_up'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['csv_up'];
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
		if(strtolower($oldnamehz)!='csv')
		{
			echo '{"res":2}';
			die();
		}
        $newname=time().$getFileArr['name'];
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpfile/linshi/'.$newname);
        if(!file_exists('./Public/chanpinfile/cpfile/linshi/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
       

        echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$getFileArr['name'].'"}';
	}
	//开始导入产品信息
	public function daoru_chanpin()
	{
		$csvfilename=addslashes($_GET['csvfilename']);
		if($csvfilename=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$file_path="./Public/chanpinfile/cpfile/linshi/".$csvfilename;
		$bs=fopen($file_path,"r");
		$str = fread($bs,filesize($file_path));
		$str=iconv("gbk","utf-8//IGNORE",$str);
		$filearr=explode("\n",$str);
		$first='0';
		$insertstr='';
		$filerowsnum=0;
		$nowdatetime=date("Y-m-d H:i:s",time());
		foreach($filearr as $v)
		{
			if($first=='0')
			{
				$first='1';
				continue;
			}
			if($v=='')	continue;
			$varr='';
			$varr=explode(',',$v);
			if(count($varr)!=7)	continue;
			if($varr[0]==''||$varr[1]==''||$varr[2]==''||$varr[3]=='') continue;
			//构造数据表数组
			$basearr[$filerowsnum]['id']='';
			$basearr[$filerowsnum]['name']=$varr[0];
			$basearr[$filerowsnum]['num']=$varr[1];
			$basearr[$filerowsnum]['danwei']=$varr[2];
			$basearr[$filerowsnum]['danjia']=$varr[3];
			$basearr[$filerowsnum]['chengben']=$varr[4];
			$basearr[$filerowsnum]['fenlei']=$varr[5];
			$basearr[$filerowsnum]['img']='';
			$basearr[$filerowsnum]['jieshao']=$varr[6];
			$basearr[$filerowsnum]['addtime']=$nowdatetime;
			$basearr[$filerowsnum]['edittime']=$nowdatetime;
			$basearr[$filerowsnum]['qy']='1';
			$basearr[$filerowsnum]['del']='0';
			$basearr[$filerowsnum]['user']=cookie("user_id");
			$basearr[$filerowsnum]['yh']=$fid;
			$filerowsnum++;
	
		}
		if(count($basearr)<1)
		{
			echo '2';die;
		}
		foreach($basearr as $v)
		{
			$insertstr.="('','".$v['name']."','".$v['num']."','".$v['danwei']."','".$v['danjia']."','".$v['chengben']."','".$v['fenlei']."','".$v['img']."','".$v['jieshao']."','".$v['addtime']."','".$v['edittime']."','".$v['qy']."','".$v['del']."','".$v['user']."','".$v['yh']."'),";
		}
		$insertstr=substr($insertstr,0,-1);
		$insertstr=str_replace("\r",'',$insertstr);
		$insertstr=str_replace("\n",'',$insertstr);
		$cpbase=M("chanpin");
		$cpbase->query("insert into crm_chanpin values $insertstr ");
		echo $this->insertrizhi("导入了".count($basearr)."条产品数据");
	}
	//获取导入记录
	public function get_dr_history()
	{
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$rzbase=M("rz");
		$drarr=$rzbase->query("select rz_time,rz_bz from crm_rz where rz_yh='$fid' and rz_type='1' and rz_mode='7' and rz_bz like '导入了%' order by rz_time desc");
		$drtable='';
		foreach($drarr as $v)
		{
			$drtable.="<tr><td>".date("Y-m-d H:i:s",$v['rz_time'])."</td><td>".$v['rz_bz']."</td></tr>";
		}	
		echo $drtable;
	}
	//导出数据
	public function daochu_data()
	{
		if(cookie("islogin")!='1')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Login'</script>";
			die();
		}
		$name="产品数据";
		//$name=iconv("utf-8","gbk//IGNORE",$name);
		$head=array(
			"1"=>"产品名称",
			"2"=>"产品编号",
			"3"=>"标准单价",
			"5"=>"销售单位",
			"6"=>"单位成本",
			"11"=>"毛利率",
			"7"=>"产品分类",
			"8"=>"产品介绍",
			"9"=>"创建时间",
			"10"=>"更新于"
			);
		//连接标题
		$line = implode(',',$head);
		$line .="\n";
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）		
		$cpbase=M("chanpin");
		$cparr=$cpbase->query("select * from crm_chanpin left join crm_chanpinfenlei on cp_fenlei=cpfl_id where cp_yh='$fid' and cp_del='0'");
		foreach($cparr as $v)
		{
			$m_lilv=(($v['cp_danjia']-$v['cp_chengben'])/$v['cp_danjia'])*100;
			$m_lilv=round($m_lilv,2).'%';
			$row=$v['cp_name'].','.$v['cp_num'].','.$v['cp_danjia'].','.$v['cp_danwei'].','.$v['cp_chengben'].','.$m_lilv.','.$v['cpfl_name'].','.$v['cp_jieshao'].','.$v['cp_add_time'].','.$v['cp_edit_time'];
			$row=str_replace("\r",'',$row);
			$row=str_replace("\n",'',$row);
			$line.=$row;
			$line.="\r\n";
		}
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $line;
		die;
	}
	//产品图片下载
	public function img_download()
	{
		$file = $_GET['file'];
		if($file=='')
		{
			die;
		}
		$filename=substr($file,10);
		$filepath="./Public/chanpinfile/cpimg/".$file;
		header("Content-type:application/x-img");
		header("Content-disposition:attachment;filename=".$filename.";");
		ob_clean();
		@readfile($filepath);
		die;
	}
	//删除产品图片
	public function img_del()
	{
		$cpid=$_GET['delcpid'];
		$cpname=$_GET['cpname'];
		$cpbase=M("chanpin");
		$cpbase->query("update crm_chanpin set cp_img='' where cp_id='$cpid' limit 1");
		echo $this->insertrizhi("删除了产品：".$cpname."的产品图片");
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
		$xitongrizhibase->query("insert into crm_rz values('','1','7','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}