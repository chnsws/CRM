<?php
namespace Home\Controller;
use Think\Controller;


class ChanpinController extends DBController {
	//主页
    public function index(){
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$get_flid=addslashes($_GET['flid']);
		$page=addslashes($_GET['page']);
		if($get_flid=='')
		{
			//不允许没有产品分类id
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Cpfl/cpfl_index'</script>";
			die;
		}
		//分页
		$page=$page?$page:1;//当前页
		$page_size=10;//每页显示多少条
		$page_limit_head=$page==1?0:($page-1)*10;//sql中的开始页
		$page_limit=str_replace(',','',number_format($page_limit_head)).','.str_replace(',','',number_format($page_size));//sql语句中的limit值


		//echo $page_limit;die;
		//echo "<script>alert(".$_GET['flid'].")</script>";
        //产品分类表操作
		$cpflbase=M("chanpinfenlei");
		$cpflarr=$cpflbase->query("select * from crm_chanpinfenlei where cpfl_company='$fid' ");
		$cpfloption="<option value='0'>选择产品分类</option>";//添加产品时的产品分类下拉框
		foreach($cpflarr as $cpflarrKey=>$cpflarrVal)//格式化产品分类分级
		{
			$bumenNewArr[$cpflarrVal['cpfl_id']]=array("cpfl_name"=>$cpflarrVal['cpfl_name'],"cpfl_fid"=>$cpflarrVal['cpfl_fid']);
			$flidlist.="<tr><td>".$cpflarrVal['cpfl_name']."</td><td>".$cpflarrVal['cpfl_id']."</td></tr>";
			
			$cpfloption.="<option value='".$cpflarrVal['cpfl_id']."'>".$cpflarrVal['cpfl_name']."</option>";
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
        //$cpfloption="<option value='0'>选择产品分类</option>";
		//生成部门结构HTML
		foreach($bmLvArr as $k=>$v)
		{
			$bmList.="<li class='lv1 lv-on' id='id".$k."' value='1' name='1'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
            //$cpfloption.="<option value='".$k."'>".$v['cpfl_name']."</option>";
			if(count($v['lv2'])>0)
			{
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
					$bmList.="<li class='lv2 lv-on lv1".$k."' id='id".$lv2k."' value='1' name='2'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv2v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv2k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv2k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv2k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv2k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                    //$cpfloption.="<option value='".$lv2k."'>&nbsp;&nbsp;&nbsp;".$lv2v['cpfl_name']."</option>";
					if(count($lv2v['lv3'])>0)
					{
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
							$bmList.="<li class='lv3 lv-on lv2".$lv2k." lv1".$k."' id='id".$lv3k."' value='1' name='3'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv3v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv3k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv3k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv3k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv3k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                            //$cpfloption.="<option value='".$lv3k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv3v['cpfl_name']."</option>";
							if(count($lv3v['lv4'])>0)
							{
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
									$bmList.="<li class='lv4 lv-on lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv4k."' value='1' name='4'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv4v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv4k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv4k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpfladd(".$lv4k.")'><i class='fa fa-plus' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv4k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                                    //$cpfloption.="<option value='".$lv4k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv4v['cpfl_name']."</option>";
									if(count($lv4v['lv5'])>0)
									{
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
											$bmList.="<li class='lv5 lv-on lv4".$lv4k." lv3".$lv3k." lv2".$lv2k." lv1".$k."' id='id".$lv5k."' value='1' name='5'><i class='fa fa-folder-open' aria-hidden='true'></i><span class='left-li'>".$lv5v['cpfl_name']."</span><span class='right-span'><a style='margin-right:5px;'  onclick='cpfldel(".$lv5k.")'><i class='fa fa-trash-o' aria-hidden='true'></i></a><a style='margin-right:5px;'  onclick='cpfledit(".$lv5k.")'><i class='fa fa-pencil' aria-hidden='true'></i></a><a style='margin-right:5px;' onclick='cpflshowlist(".$lv5k.")'><i class='fa fa-reorder' aria-hidden='true'></i></a></span></li>";
                                            //$cpfloption.="<option value='".$lv5k."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lv5v['cpfl_name']."</option>";
										}
									}
								}
							}
						}
					}
				}
			}
		}
		//查询自定义字段中的值，用于添加表单
		$zdbase=M("yewuziduan");
		$get_yewu='7,'.$get_flid;
		//echo $get_yewu;die;
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid'  and  zd_yewu='$get_yewu' limit 1");
		$zdjsonstr=$zdarr[0]['zd_data'];
		$zdarr=json_decode($zdjsonstr,true);

		$cydiv="<div id='add_cy_div'><table>";//常用div
		$ncydiv="<div id='add_yc_body' style='display:none;'><table>";//不常用div（隐藏）
		$redstarspan="<span class='redstart'>*</span>";//红色星星（必填）

		//系统规定的字段
		$old_zd_arr=array(
			"zdy6"=>"<select id='addflsel'  name='zdy6'>".$cpfloption."</select>",
			"zdy7"=>"<input type='file' name='cpimage' lay-type='images'  id='imm' class='imm'  /><button class='layui-btn layui-btn-primary' style='height:30px;line-height:30px;' onclick='sel_img(this)' >选择图片</button></td></tr><tr><td class='add_left'></td><td id='cpimg_show'><img id='cpimg' name='cpimgshow' style='margin-bottom: 10px;'>",
			"zdy8"=>"<textarea id='cp_jieshao' name='zdy8'></textarea>"
		);

		foreach($zdarr as $v)
		{
			$newzdarr[$v['id']]=$v;
		}
		//需要隐藏的表格列
		$pzbase=M("config");
		$pzarr=$pzbase->query("select config_cp_table_data from crm_config where config_name='".cookie("user_id")."' limit 1");
		$pzarr=json_decode($pzarr[0]['config_cp_table_data'],true);
		$pzarr=$pzarr[$get_flid];
		foreach($pzarr as $k=>$v)
		{
			$pzarr[$v]=1;
			unset($pzarr[$k]);
		}
		//排序查询
		$pxbase=M("paixu");
		$pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$get_yewu' limit 1");
		//根据已存的排序重新打乱数组
		if(count($pxarr)>0)
		{
			$pxarr=explode(',',$pxarr[0]['px_px']);
			foreach($pxarr as $v)
			{
				$pxzdarr[$v]=$newzdarr[$v];
			}
		}
		else
		{
			$pxzdarr=$newzdarr;
		}
		$thnum=0;
		//echo "<pre>";print_r($pxzdarr);die;
		//开始循环添加表单&&表头th
		foreach($pxzdarr as $zdy_k=>$zd_data)
		{
			//字段显示配置窗
			if($zd_data['qy']=='1'&&$zd_data['id']!='zdy7')
			{
				$langval=$pzarr[$zdy_k]=='1'?"0":'1';
				$ccc=$pzarr[$zdy_k]=='1'?"style='background-color:#ccc'":'';
				$pxdiv.="<span class='pxthcss' $ccc lang='".$langval."' id='st_option".$zdy_k."' onselectstart='return false'>".$zd_data['name']."</span>";
			}
			//数据表的表头
			if($zd_data['qy']=='1'&&$zd_data['id']!='zdy7'&&$pzarr[$zdy_k]!='1')
			{
				$left_t='';
				if($thnum=='0')
				{
					$left_t="class='left_t_th'";
					$a="<th id='thpxid".$zdy_k."'>".$zd_data['name']."</th>";
				}
				$thstr.="<th $left_t >".$zd_data['name']."</th>".$a;
				$a='';
				if($zdy_k!='zdy5'&&$zdy_k!='zdy6')
					$searchoption.="<option value='".$zdy_k."'>".$zd_data['name']."</option>";
				$thnum++;
			}
			//没启用的话就跳出去,zdy5=毛利率
			if($zd_data['qy']!='1'||$zdy_k=='zdy5')
			{
				continue;
			}
			//项目名称
			$titlename=$zd_data['bt']=='1'?$redstarspan.$zd_data['name']:'&nbsp'.$zd_data['name'];
			//控件字符串
			$rightinput=$old_zd_arr[$zdy_k]==''?"<input type='text' name='$zdy_k'>":$old_zd_arr[$zdy_k];
			//是否常用(必填的必须在上面)
			if($zd_data['cy']=='1'||$zd_data['bt']=='1')
			{
				$cydiv.="<tr><td class='add_left'>".$titlename."</td><td>".$rightinput."</td></tr>";
			}
			else
			{
				$ncydiv.="<tr><td class='add_left'>".$titlename."</td><td>".$rightinput."</td></tr>";
			}
		}
		$thstr="<th style='width:12px;' id='checkboxcss1'><input  type='checkbox' id='checkall'></th>".$thstr."<th>创建时间</th><th>更新于</th>";
		$cydiv.="</table></div>";
		$ncydiv.="</table></div>";
		$show_more="<div id='add_yc_div'><span onclick='more_info()' style='cursor:pointer;'>展开更多信息<i class='fa fa-chevron-down' aria-hidden='true'></i></span></div>";
		$addlist=$ncydiv=="<div id='add_yc_body' style='display:none;'><table></table></div>"?$cydiv:$cydiv.$show_more.$ncydiv;//自定义添加表单

		//==表单查询模块结束
		//开始产品列表查询
		$cpbase=M("chanpin");
		//搜索内容
		$is_search=addslashes($_GET['searchInfo']);
		$sea_arr=explode(',',$is_search);
		$sea_arr[1]=substr(json_encode($sea_arr[1]),1,-1);

		$search_tj=$is_search==''?'':' and cp_data like \'%"'.$sea_arr[0].'":"'.$sea_arr[1].'"%\' ';//搜索内容结束
		$getfl=$_GET['flid']?"and cp_data like '%\"zdy6\":\"".$_GET['flid']."\"%'  $search_tj ":'';
		//echo "select * from crm_chanpin where cp_yh='$fid'  $getfl  and cp_del='0' order by cp_id desc limit $page_limit ";die;
		//分页参数中-应该分几页
		$page_max_page=$cpbase->query("select count(cp_id) from crm_chanpin where cp_yh='$fid'  $getfl  and cp_del='0' ");
		$page_max_page=$page_max_page[0]['count(cp_id)'];
		$page_max_page=$page_max_page<=10?1:ceil($page_max_page/10);
		//开始查询产品
		$cparr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid'  $getfl  and cp_del='0' order by cp_id desc limit $page_limit ");
		if(count($cparr)>0)
		{
			$cpliststr='';
			foreach($cparr as $v)
			{
				$rowsarr=json_decode($v['cp_data'],true);
				$tdstr='';
				$tdclass=$v['cp_qy']=='1'?'':"style='color:#ccc;'";
				$tdnum=0;
				//echo "<pre>";print_r($pxzdarr);die;
				foreach($pxzdarr as $k=>$zdinfo)
				{
					if($pzarr[$zdinfo['id']]=='1')
					{
						continue;
					}
					if($zdinfo['qy']!='1')
					{
						continue;
					}
					if($k=='zdy5')//毛利率
					{
						//只有销售单价和成本都启用的情况下才进行计算
						if($pxzdarr['zdy2']['qy']=='1'&&$pxzdarr['zdy4']['qy']=='1')
						{
							$tddata=(($rowsarr['zdy2']-$rowsarr['zdy4'])/$rowsarr['zdy2'])*100;
							$tddata=round($tddata,2).'%';
						}
						else
						{
							$tddata='-';
						}
					}
					else if($k=='zdy7')
					{
						continue;
					}
					else if($k=='zdy6')
					{
						$tddata=$bumenNewArr[$rowsarr[$k]]['cpfl_name'];
					}
					else
					{
						$tddata=$rowsarr[$k];
					}
					$tddata=$tddata==''?'-':$tddata;
					$titledata=$tddata;
					$tddata=$tddata;
					$left_t='';
					if($tdnum=='0')
					{
						$tddata=$tddata;
						$left_t="class='left_t'";
						$b="<td $tdclass  style='width:200px'  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' title='".$titledata."'>".$tddata."</td>";
						
					}
					$tdstr.="<td $tdclass  $left_t  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' title='".$titledata."'>".$tddata."</td>".$b;
					$b='';
					$tdnum++;
				}
				$checkboxstr="<td id='checkboxcss2'><input  type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td>";
				$add_edit_date="<td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_add_time']."</td><td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_edit_time']."</td>";
				if($v['cp_qy']=='1')
				{
					$qytrstr.="<tr>".$checkboxstr.$tdstr.$add_edit_date."</tr>";
				}
				else
				{
					$jytrstr.="<tr>".$checkboxstr.$tdstr.$add_edit_date."</tr>";
				}
				//$cpnewarr[$v['cp_id']]=$rowsarr;
			}
			$cplist=$qytrstr.$jytrstr;
		}
		else
		{
			$thnum=$thnum+3;
			$cplist="<tr><td colspan=".$thnum." style='color:#666;height:100px;border:none;'><center>暂无产品数据，现在<span class='link_span' onclick='cp_add()'>添加</span>一条试试吧</center></td></tr>";
		}
		//筛选模块开始
		$sxbase=M("shaixuan");
		$sxbasearr=$sxbase->query("select sx_qy from crm_shaixuan where sx_yh='$fid' and sx_yewu='7,".$get_flid."' limit 1");
		$sxarr=$sxbasearr[0];
		
		$kqsx=$sxarr['sx_qy'];
		if($kqsx=='1')
		{
			$sxcbase=M("sx_cache");
			$sxcbasearr=$sxcbase->query("select sxc_data from crm_sx_cache where sxc_yh='$fid' and sxc_yewu='7,".$get_flid."' limit 1 ");
			
			if(count($sxcbasearr)<1)
			{
				$kqsx='0';
			}
			else
			{
				$sxhtmlarr[1][1]="<div class='sxzddiv'><div class='sx_title'>";
				$sxhtmlarr[1][2]="</div><span class='sx_yes'>全部</span>";
				$sxhtmlarr[1][3]="</div>";

				$sxhtmlarr[2][1]="<div class='sxzddiv_d'><div class='sx_title'>";
				$sxhtmlarr[2][2]="</div><span class='sx_yes'>全部</span>";
				$sxhtmlarr[2][3]="<button class='layui-btn sxdbtn' >确定</button></div>";

				$sxhtmlarr[3][1]="<div class='sxzddiv_w'><div class='sx_title'>";
				$sxhtmlarr[3][2]="</div><span class='sx_yes'>全部</span><input type='search' class='sxsea' /><button class='layui-btn sxdbtn' >确定</button></div>";

				$sxhtmlarr[4][1]="<div class='sxzddiv_q'><div class='sx_title'>";
				$sxhtmlarr[4][2]="</div><span class='sx_yes'>全部</span><input type='number' min='0' max='50' class='sxsea'> - <input type='number' min='0' max='50' class='sxsea'><button class='layui-btn sxdbtn' >确定</button></div>";

				$sxhtmlarr[5][1]="<div class='sxzddiv' id='zdqj'><div class='sx_title'>";
				$sxhtmlarr[5][2]="</div><span class='sx_yes'>全部</span>";
				$sxhtmlarr[5][3]="</div>";

				$sxcarr=json_decode($sxcbasearr[0]['sxc_data'],true);
				
				$sxhtml='';
				foreach($sxcarr as $k=>$v)
				{
					if($pxzdarr[$k]['name']==''||$v['tj']=='')
					{
						continue;
					}
					$tj=$v['tj'];
					$sxhtml2='';
					if(in_array($tj,array("1","2","5")))
					{
						/*
						if($v['data']=='')
						{
							continue;
						}
						*/
						foreach($v['data'] as $sxz)
						{
							$sxhtml2.="<span class='sx_no'>".$sxz."</span>";
						}
					}
					$sxhtml.=$sxhtmlarr[$tj][1].$pxzdarr[$k]['name'].'：'.$sxhtmlarr[$tj][2].$sxhtml2.$sxhtmlarr[$tj][3];
				}
			}
		}//筛选模块结束
		
		$this->assign("kqsx",$kqsx);		
		$this->assign("sxhtml",$sxhtml);		
		$this->assign("pxzdjson",json_encode($pxzdarr));		
		$this->assign("pzjson",json_encode($pzarr));		
		$this->assign("pxdiv",$pxdiv);		
		$this->assign("cplist",$cplist);		
		$this->assign("searchoption",$searchoption);		
		$this->assign("page_max_page",$page_max_page);		
		$this->assign("thstr",$thstr);		
		$this->assign("flidlist",$flidlist);		
		$this->assign("bmlist",$bmList);
		$this->assign("addlist",$addlist);
		$this->assign("cpfloption",$cpfloption);
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpid=addslashes($_GET['cpid']);
		$flid=addslashes($_GET['flid']);

		$cpbase=M("chanpin");
		$cpinfoarr=$cpbase->query("select * from crm_chanpin where cp_id='$cpid' and cp_yh='$fid' and cp_del='0' limit 1");
		$cpinfoarr=$cpinfoarr[0];
		if($cpinfoarr['cp_id']==''||$cpinfoarr['cp_yh']!=$fid)//如果没有接收到传参,或者此用户不属于本公司
		{
			die();
		}
		$cpjsonarr=json_decode($cpinfoarr['cp_data'],true);
		//产品分类数据查询
		$cp_flbase=M("chanpinfenlei");
		$cpflarr1=$cp_flbase->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid'");
		
		$cpfloption='<option value="0">未选择</option>';
		foreach($cpflarr1 as $k=>$v)
		{
			$cpflarr[$v['cpfl_id']]=$v['cpfl_name'];
			$canNotChangeOption=$flid==$v['cpfl_id']?"selected":'';
			//产品分类下拉框
			$cpfloption.="<option value='".$v['cpfl_id']."' $canNotChangeOption >".$v['cpfl_name']."</option>";
		}
		//查询自定义字段表
		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='7,".$flid."' limit 1");
		
		
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		//格式化业务字段数组
		foreach($zdarr as $k=>$v)
		{
			$zdarr[$v['id']]=$v;
			unset($zdarr[$k]);
		}
		//查询排序表
		$pxbase=M("paixu");
		$pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='7,".$flid."' limit 1");
		//$pxarr[0]['px_px']=count($pxarr)==0?'zdy0,zdy1,zdy2,zdy3,zdy4,zdy5,zdy6,zdy7,zdy8';
		if(count($pxarr)==0)
		{
			foreach($zdarr as $k=>$v)
			{
				$pxarr[0]['px_px'].=$k.',';
			}
			$pxarr[0]['px_px']=substr($pxarr[0]['px_px'],0,-1);
		}
		$pxarr=explode(',',$pxarr[0]['px_px']);
		//根据排序构造产品信息表的html字符串
		$infostr='';
		foreach($pxarr as $v)
		{
			$xxstr='';
			$cpimgid='';
			if($zdarr[$v]['qy']!='1')
			{
				continue;
			}
			$xxstr=$cpjsonarr[$v];
			if($v=='zdy0')
			{
				$cpname['cp_name']=str_replace("\n",'',str_replace("\r",'',$cpjsonarr[$v]));
			}
			if($v=='zdy5')//毛利率
			{
				if($zdarr['zdy2']['qy']=='1'&&$zdarr['zdy4']['qy']=='1')
				{
					$xxstr=(($cpjsonarr['zdy2']-$cpjsonarr['zdy4'])/$cpjsonarr['zdy2'])*100;
					$xxstr=round($xxstr,2).'%';
				}
				else
				{
					$xxstr="当前没有启用[".$zdarr['zdy2']['name']."](单价)和[".$zdarr['zdy4']['name']."](成本)字段，无法计算利率。";
				}
			}
			if($v=='zdy6')//分类
			{
				$flid=$cpjsonarr[$v];
				$xxstr=$cpflarr[$cpjsonarr[$v]];
			}
			if($v=='zdy7')//图片
			{
				if($cpjsonarr[$v]!='')
				{
					$titlestr='<div style="float:right;"><span class="link_span" style="color:#fff;font-size:22px;font-weight:bold;padding-top:10px;" onclick="xiazai(this)"><i class="fa fa-cloud-download" aria-hidden="true"></i></span>&nbsp;&nbsp;&nbsp;<span class="link_span" style="color:#fff;font-size:22px;font-weight:bold;padding-top:10px;" onclick="shanchu(this)"><i class="fa fa-trash" aria-hidden="true"></i></span></div>';
					$xxstr="<a onclick='sc()'>查看图片</a><span id='spanaaa' href='".$_GET['public_dir']."/chanpinfile/cpimg/".$cpjsonarr[$v]."' data-uk-lightbox title='".$titlestr."' ></span>";
				}
				else
				{
					$xxstr='暂无产品图片';
				}
				$cpimgid="id='cptp'";
			}
			$infostr.="<tr><td class='info_title'>".$zdarr[$v]['name']."：</td><td class='info_content' $cpimgid >".$xxstr."</td></tr>";
			$pxzdarr[$v]=$zdarr[$v];
		}
		//选中当前产品分类
		$cpfloption=str_replace("value='".$flid."'","value='".$flid."' selected",$cpfloption);
		//禁用、启用按钮映射
		$jy_btn=$cpinfoarr['cp_qy']=='1'?"<button id='qyjybtn' class='layui-btn' onclick='jy_qy_chanpin(0)'><i class='fa fa-lock' aria-hidden='true'></i>禁用</button>":"<button id='qyjybtn' class='layui-btn' onclick='jy_qy_chanpin(1)'><i class='fa fa-unlock' aria-hidden='true'></i>启用</button>";
		//系统信息
		$xitonginfo["add"]=$cpinfoarr['cp_add_time'];
		$xitonginfo["edit"]=$cpinfoarr['cp_edit_time'];

		//编辑表单模块
		$cptp=$cpjsonarr['zdy7']==''?"style='display:none'":"";
		//系统规定的字段
		//"zdy7"=>"<input type='file' name='cpimage' lay-type='images' class='layui-upload-file' id='imm'  /></td></tr><tr><td class='add_left'></td><td id='cpimg_show'><img id='cpimg' $cptp src='".$_GET['public_dir']."/chanpinfile/cpimg/".$cpjsonarr['zdy7']."' style='margin-bottom: 10px;'>",
		$old_zd_arr=array(
			"zdy6"=>"<select id='addflsel' name='zdy6' disabled=disabled >".$cpfloption."</select>",
			"zdy7"=>"<input type='file' name='cpimage' lay-type='images'  id='imm' class='imm'  /><button class='layui-btn layui-btn-primary' style='height:30px;line-height:30px;' onclick='sel_img(this)' >选择图片</button></td></tr><tr><td class='add_left'></td><td id='cpimg_show'><img id='cpimg' $cptp src='".$_GET['public_dir']."/chanpinfile/cpimg/".$cpjsonarr['zdy7']."' name='cpimgshow' style='margin-bottom: 10px;'>",

			"zdy8"=>"<textarea id='cp_jieshao' name='zdy8'>".$cpjsonarr['zdy8'].
			"</textarea>"
		);
		$redstarspan="<span class='redstart'>*</span>";//红色星星（必填）
		//开始循环编辑表单
		foreach($pxzdarr as $zdy_k=>$zd_data)
		{
			
			//没启用的话就跳出去,zdy5=毛利率
			if($zd_data['qy']!='1'||$zdy_k=='zdy5')
			{
				continue;
			}
			//项目名称,判断是否必填，然后加红色星
			$titlename=$zd_data['bt']=='1'?$redstarspan.$zd_data['name']:'&nbsp'.$zd_data['name'];
			//控件字符串，是否属于系统字段
			$rightinput=$old_zd_arr[$zdy_k]==''?"<input type='text' name='$zdy_k' value='".$cpjsonarr[$zdy_k]."'>":$old_zd_arr[$zdy_k];
			//是否常用(必填的必须在上面)
			if($zd_data['cy']=='1'||$zd_data['bt']=='1')
			{
				$cydiv.="<tr><td class='add_left'>".$titlename."</td><td>".$rightinput."</td></tr>";
			}
			else
			{
				$ncydiv.="<tr><td class='add_left'>".$titlename."</td><td>".$rightinput."</td></tr>";
			}
		}
		//附件
		$fjbase=M("cp_file");
		$fjinfoarr=$fjbase->query("select * from crm_cp_file where fj_del='0' and fj_yh='$fid' and fj_cp='$cpid' ");
		foreach($fjinfoarr as $v)
		{
			$fjtable.="<tr><td>".$v['fj_date']."</td><td>".substr($v['fj_name'],10)."</td><td>".$v['fj_size']."</td><td>".$v['fj_bz']."</td><td><span class='link_span' onclick='down_fujian(".$v['fj_id'].")'>下载</span><span class='link_span' onclick='del_fujian(".$v['fj_id'].")'>删除</span></td></tr>";
		}
		$fjtable=$fjtable==''?"<tr><td colspan='5' align='center'>没有附件</td></tr>":$fjtable;
		$this->assign("jy_btn",$jy_btn);
		$this->assign("cydiv",$cydiv);
		$this->assign("ncydiv",$ncydiv);
		$this->assign("infostr",$infostr);
		$this->assign("xitonginfo",$xitonginfo);
		$this->assign("cpinfoarr",$cpname);
		$this->assign("cpfloption",$cpfloption);
		$this->assign("fjtable",$fjtable);
		$this->assign("oldimgname",$cpjsonarr['zdy7']);
		$this->display();
	}
	public function hahaha()
	{
		echo phpinfo();
	}
	//新增产品
	public function cp_add()
	{
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$addstr=$_POST['addstr'];
		if($addstr=='')
		{
			echo 2;
			die;
		}
		//获取json里面的图片数据
		$json_arr=json_decode($addstr,true);
		$imginfo=$json_arr['zdy7'];
		if($imginfo!='')
		{
			$bcres=$this->Base64ToImg($imginfo);
			
			if(!$bcres)
			{
				echo '3';
				die;
			}
			$json_arr['zdy7']=$bcres;
		}
		//对单引号双引号进行处理
		foreach($json_arr as $k=>$v)
		{
			if($k=='zdy7')
			{
				continue;
			}
			$thisa=str_replace('"','&quot;',$v);
			$json_arr[$k]=str_replace("'",'&apos;',$thisa);
		}
		$jsonstr=json_encode($json_arr);
		//parent::rr($json_arr);
		//转换并保存图片
		//将新图片的文件名添加到json中
		//插入数据库





		//die;

		//开始解析格式
		//$kvarr=$this->jiexi($addstr);
		//$jsonstr=json_encode($kvarr);
		$jsonstr=str_replace('\\','\\\\',$jsonstr);
		$nowdatetime=date("Y-m-d H:i:s",time());		
		$cpbase=M("chanpin");
		//parent::rr("insert into crm_chanpin values('','$jsonstr','$nowdatetime','$nowdatetime','1','0','".cookie("user_id")."','$fid')");
		$cpbase->query("insert into crm_chanpin values('','$jsonstr','$nowdatetime','$nowdatetime','1','0','".cookie("user_id")."','$fid')");
		echo $this->insertrizhi("新增产品：".$json_arr['zdy0']);
	}
	//新增产品图片
	public function cp_img_add()
	{
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		//文件保存
        
        if(count($_FILES['cpimage'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['cpimage'];
		$user_id=cookie("user_id");
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=$fid.'_'.$user_id.'_'.time().'.'.$oldnamehz;
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$sel_id=addslashes($_GET['sel_id']);
		$newflid=addslashes($_GET['newflid']);
		if($sel_id==''||$newflid=='')
		{
			echo '2';
			die;
		}
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_del");
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
		$flid=addslashes($_POST['flid']);
		$px=$_POST['px'];
		$pz=$_POST['pz'];
		$old_sea_text=$sea_text;
		$sea_text=str_replace("\\","%",substr(json_encode($sea_text),1,-1));
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpbase=M("chanpin");
		//$fenlei_where=$old_sea_text!=''?"and cp_data like '%\"zdy6\":\"".$flid."\"%' ":'';
		$newcparr=$cpbase->query("select * from crm_chanpin where  cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$flid."\"%' ");
		//解析当前页面的配置数据
		$pxarr=json_decode($px,true);
		$pzarr=json_decode($pz,true);
		if(count($newcparr)<1)
		{
			echo "<tr><td colspan='100'><center>没有产品数据</center></td></tr>";
			die;
		}
		//分类查询
		$cpflbase=M("chanpinfenlei");
		$cpflbasearr=$cpflbase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid' ");
		foreach($cpflbasearr as $v)
		{
			$cpflarr[$v['cpfl_id']]=$v['cpfl_name'];
		}
		//分类结束
		$newtablestr='';//新表格数据字符串
		foreach($newcparr as $v)
		{
			$rowjsonarr=json_decode($v['cp_data'],true);
			$iscz=count(explode($old_sea_text,$rowjsonarr[$sea_type]));
			if($iscz<=1&&$old_sea_text!='')//二次匹配
			{
				continue;
			}
			$isfirst='0';
			$rowtdstr='';
			foreach($pxarr as $k=>$vv)
			{
				if($k=='zdy7'||$pzarr[$k]=='1'||$vv['qy']!='1')
				{
					continue;
				}
				$tdclass=$v['cp_qy']=='1'?'':"style='color:#ccc;'";
				$rowjsonarr[$k]=$k=='zdy6'?$cpflarr[$rowjsonarr[$k]]:$rowjsonarr[$k];
				$tdstr=$rowjsonarr[$k];
				$tdstr=$tdstr==''?'-':$tdstr;
				$left_t='';
				if($isfirst=='0')
				{
					$left_t="class='left_t'";
					$firsttd="<td $tdclass style='width:200px'  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;'>".$rowjsonarr[$k]."</td>";
				}
				$rowtdstr.="<td $tdclass $left_t  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' title='".$rowjsonarr[$k]."'>".$tdstr."</td>".$firsttd;
				$firsttd='';
				$isfirst++;
			}
			$checkboxstr="<td id='checkboxcss2'><input  type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td>";
			$add_edit_date="<td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_add_time']."</td><td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_edit_time']."</td>";
			if($v['qy']=='1')
			{
				$qytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
			else
			{
				$jytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
		}
		$newtablestr=$qytr.$jytr;
		if($newtablestr=='')
		{
			echo "<tr><td colspan='100'><center>没有产品数据</center></td></tr>";
			die;
		}
		echo $newtablestr;
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
        parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_edit");
		$user_id=cookie("user_id");
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=$fid.'_'.$user_id.'_'.time().'.'.$oldnamehz;
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$editstr=$_POST['editstr'];
		$nowpageid=addslashes($_POST['nowpageid']);
		$oldimgname=addslashes($_POST['oldimgname']);
		$nowpagename=addslashes($_POST['nowpagename']);
		if($nowpageid==''||$editstr=='')
		{
			echo '2';
			die;
		}
		//判断是否修改了图片
		
		
		$jsondata=json_decode($editstr,true);
		
		if(substr($jsondata['zdy7'],0,5)=='http:'||substr($jsondata['zdy7'],0,6)=='https:')
		{
			//如果没修改就截取图片名称
			$imgname=explode('/',$jsondata['zdy7']);
			$maxindex=count($imgname)-1;
			$imgname=$imgname[$maxindex];
			$jsondata['zdy7']=$imgname;
		}
		else
		{
			//如果修改就生成新图片
			$jsondata['zdy7']=$this->Base64ToImg($jsondata['zdy7']);
			//删除旧图片
			unlink('./Public/chanpinfile/cpimg/'.$oldimgname);
		}
		

		
		//对单引号双引号进行处理
		foreach($jsondata as $k=>$v)
		{
			if($k=='zdy7')
			{
				continue;
			}
			$thisa=str_replace('"','&quot;',$v);
			$jsondata[$k]=str_replace("'",'&apos;',$thisa);
		}
		$jsonstr=json_encode($jsondata);


		//parent::rr($jsondata);

		$jsonstr=str_replace('\\','\\\\',$jsonstr);
		$nowdatetime=date("Y-m-d H:i:s",time());		
		$cpbase=M("chanpin");
		//parent::rr("insert into crm_chanpin values('','$jsonstr','$nowdatetime','$nowdatetime','1','0','".cookie("user_id")."','$fid')");
		$cpbase->query("update crm_chanpin set cp_data = '$jsonstr',cp_edit_time='$nowdatetime' where cp_yh='$fid' and cp_id='$nowpageid' limit 1");
		echo $this->insertrizhi("修改了产品：".$nowpagename);
		die;
	}
	//根据左边产品分类改变右边产品列表
	public function get_fl_cplist()
	{
		$clickflid=addslashes($_POST['clickflid']);
		$px=$_POST['px'];//排序
		$pz=$_POST['pz'];//配置隐藏
		if($clickflid=='')
		{
			echo '';
			die;
		}
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpbase=M("chanpin");
		$fenlei_where=$clickflid>0?"cp_data like '%\"zdy6\":\"".$clickflid."\"%' and ":'';
		$newcparr=$cpbase->query("select * from crm_chanpin where $fenlei_where cp_yh='$fid' and cp_del='0' ");
		
		//解析当前页面的配置数据
		$pxarr=json_decode($px,true);
		$pzarr=json_decode($pz,true);
		if(count($newcparr)<1)
		{
			echo "<tr><td colspan='100'><center>没有产品数据</center></td></tr>";
			die;
		}
		//分类查询
		$cpflbase=M("chanpinfenlei");
		$cpflbasearr=$cpflbase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid' ");
		foreach($cpflbasearr as $v)
		{
			$cpflarr[$v['cpfl_id']]=$v['cpfl_name'];
		}
		//分类结束
		$newtablestr='';//新表格数据字符串
		foreach($newcparr as $v)
		{
			$rowjsonarr=json_decode($v['cp_data'],true);
			$isfirst='0';
			$rowtdstr='';
			foreach($pxarr as $k=>$vv)
			{
				if($k=='zdy7'||$pzarr[$k]=='1'||$vv['qy']!='1')
				{
					continue;
				}
				$tdclass=$v['cp_qy']=='1'?'':"style='color:#ccc;'";
				$rowjsonarr[$k]=$k=='zdy6'?$cpflarr[$rowjsonarr[$k]]:$rowjsonarr[$k];
				$tdstr=$rowjsonarr[$k];
				$tdstr=$tdstr==''?'-':$tdstr;
				$left_t='';
				if($isfirst=='0')
				{
					$left_t="class='left_t'";
					$firsttd="<td $tdclass style='width:200px'  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;'>".$rowjsonarr[$k]."</td>";
				}
				$rowtdstr.="<td $tdclass $left_t  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' title='".$rowjsonarr[$k]."'>".$tdstr."</td>".$firsttd;
				$firsttd='';
				$isfirst++;
			}
			$checkboxstr="<td id='checkboxcss2'><input  type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td>";
			$add_edit_date="<td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_add_time']."</td><td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_edit_time']."</td>";
			if($v['qy']=='1')
			{
				$qytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
			else
			{
				$jytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
		}
		$newtablestr=$qytr.$jytr;
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
        parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_edit");
		$fjbase=M("cp_file");
		$fjbase->query("insert into crm_cp_file values('','$fjmc','$fjdx','$fjbz','$fjcpid','".date("Y-m-d H:i:s",time())."','0','".cookie("user_id")."','$fid')");
		echo $this->insertrizhi("上传了附件：".$upoldname);
	}
	//重载附件列表
	public function reload_file_list()
	{
		$reloadcpid=addslashes($_GET['reloadcpid']);
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
	//下载附件
	public function fujian_download()
	{
		$fjid=$_GET['fjid'];
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpfjbase=M("cp_file");
		$fjname=$cpfjbase->query("select fj_name from crm_cp_file where fj_yh='$fid' and fj_id='$fjid' and fj_del='0' limit 1");
		$file=$fjname[0]['fj_name'];
		if($file=='')
		{
			die;
		}
		$filename=substr($file,10);
		$filepath="./Public/chanpinfile/cpfile/".$file;
		header("Content-type:application/octet-stream");
		header("Content-disposition:attachment;filename=".$filename.";");
		ob_clean();
		@readfile($filepath);
		die;

	}
	//根据附件id删除附件
	public function del_fj()
	{
		$delfjid=addslashes($_GET['delfjid']);
		$fjname=addslashes($_GET['fileyname']);
		parent::have_qx("qx_cp_edit");
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
		$flid=$_GET['flid'];
		if(!$flid)
		{
			echo "<script>alert('未获取到产品分类ID');history.go(-1);</script>";
			die;
		}
		$name="产品数据导入模板";
		//$name=iconv("utf-8","gbk//IGNORE",$name);
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='7,".$flid."' limit 1");
		if(count($zdarr)<=0)
		{
			echo "<script>alert('未获取到产品分类ID');history.go(-1);</script>";
			die;
		}
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		foreach($zdarr as $v)
		{
			if($v['qy']!='1'||$v['id']=='zdy5'||$v['id']=='zdy6'||$v['id']=='zdy7')
			{
				continue;
			}
			$btstr=$v['bt']=='1'?"(必填)":"";
			$flstr=$v['id']=='zdy6'?"(根据分类ID表填写)":'';
			$head[]=$v['name'].$btstr.$flstr;
		}
		//构造空字段
		
		$nulldata=array();
		//parent::rr($name);
		$filedo=A("Filedo");
		$filedo->getExcel($name,$head,$nulldata);
		/*
		//连接标题
		$r = implode(',',$head);
		$r .="\n";
		//$r = iconv("utf-8","gbk//IGNORE",$r);
		
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $r;
		die;
		*/
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
		/*
		if(strtolower($oldnamehz)!='csv')
		{
			echo '{"res":2}';
			die();
		}
		*/
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
		$flid=addslashes($_GET['flid']);
		if($csvfilename==''||$flid=='')
		{
			echo '2';
			die;
		}
		$cpflbase=M("chanpinfenlei");
		$flname=$cpflbase->query("select cpfl_name from crm_chanpinfenlei where cpfl_id='$flid' limit 1");
		$flname=$flname[0]['cpfl_name'];
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		/*
		//读取文件
		$file_path="./Public/chanpinfile/cpfile/linshi/".$csvfilename;
		$bs=fopen($file_path,"r");
		$str = fread($bs,filesize($file_path));
		$str=iconv("gbk","utf-8//IGNORE",$str);
		$filearr=explode("\n",$str);
		//文件读取完毕
		*/
		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='7,".$flid."' and zd_yh='$fid' limit 1");
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		$first='0';
		$insertstr='';
		$filerowsnum=0;
		$nowdatetime=date("Y-m-d H:i:s",time());
		$filedo=A("Filedo");
		
		$filearr=$filedo->getdata("./Public/chanpinfile/cpfile/linshi/".$csvfilename,'xls');
		//parent::rr($aqw);
		foreach($filearr as $v)
		{
			if($v=='')
			{
				continue;
			}
			//echo "<pre>";
			//print_r($v);
			if($first=='0')
			{
				//判断是否符合数据库中的字段
				$newzdarr='';
				$newzdarrk=0;
				foreach($zdarr as $vv)
				{
					
					if($vv['qy']!='1'||$vv['id']=='zdy5'||$vv['id']=='zdy6'||$vv['id']=='zdy7')
						continue;
					$newzdarr[$newzdarrk]['bt']=$vv['bt'];
					$newzdarr[$newzdarrk]['id']=$vv['id'];
					$btstr=$vv['bt']=='1'?"(必填)":"";
					$flstr=$vv['id']=='zdy6'?"(根据分类ID表填写)":'';
					$zdstr.=$vv['name'].$btstr.$flstr.',';
					$newzdarrk++;
				}
				$a=implode(',',$v);
				$a=str_replace("\r",'',$a);
				$a=str_replace("\n",'',$a);
				$a=str_replace('﻿','',$a);
				
				if($zdstr!=($a.','))
				{
					echo '4';
					die;
				}//判断结束
				$first='1';
				continue;
				
			}
			$varr='';
			$drarr='';
			$varr=$v;
			$countv=count($v);//总共有多少列（多少个字段）
			$null_num=0;//这一行有多少个空值

			//echo "<pre>";
			//print_r($v);
			//echo "<br><br>";
			$zdindex=0;
			foreach($varr as $k=>$vv)
			{
				
				if($vv=='')
				{
					$null_num++;
				}
				if($vv==''&&$newzdarr[$k]['bt']=='1')//如果这一条中有一个必填字段没有填，这一条就导入不进去
				{
					continue 2;
				}
				//将本条中的引号转义
				$vv=str_replace("'",'&apos;',$vv);
				$vv=str_replace('"','&quot;',$vv);

				$drarr[$newzdarr[$zdindex]['id']]=$vv;
				$zdindex++;
				//echo $k;
			}
			//parent::rr($drarr);
			if($null_num==$countv)
			{
				continue;
			}
			//完善json数据
			foreach($zdarr as $vv)
			{
				$insertarr[$filerowsnum][$vv['id']]=$drarr[$vv['id']];
			}
			$insertarr[$filerowsnum]["zdy6"]=$flid;
			$filerowsnum++;
		}
		//parent::rr();
		//die;
		if(count($insertarr)<1)
		{
			echo '2';die;
		}
		foreach($insertarr as $v)
		{
			$injsonstr=str_replace('\\','\\\\',json_encode($v));
			$insertstr.="('','".$injsonstr."','".$nowdatetime."','".$nowdatetime."','1','0','".cookie("user_id")."','$fid'),";
		}
		$insertstr=substr($insertstr,0,-1);
		$cpbase=M("chanpin");
		$cpbase->query("insert into crm_chanpin values $insertstr ");
		echo $this->insertrizhi("产品分类：".$flname." 导入了".count($insertarr)."条数据");
	}
	//获取导入记录
	public function get_dr_history()
	{
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
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
		$flid=$_GET['flid'];
		if(!$flid)
		{
			echo "<script>alert('未获取到产品分类ID');history.go(-1);</script>";
			die;
		}
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");		
		$name="产品数据";
		//字段表
		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='7,".$flid."' limit 1");
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		foreach($zdarr as $k=>$v)
		{
			$zdarr[$v['id']]=$v;
			if($v['id']!='zdy7'&&$v['qy']=='1')
				$head[]=$v['name'];
			unset($zdarr[$k]);
		}
		$head[]="创建时间";
		$head[]="更新于";
		//分类表
		$cpflbase=M("chanpinfenlei");
		$cpflarr=$cpflbase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid' ");
		foreach($cpflarr as $v)
		{
			$flarr[$v['cpfl_id']]=$v['cpfl_name'];
		}
		//产品表
		$cpbase=M("chanpin");
		$cparr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$flid."\"%' ");
		$body='';
		foreach($cparr as $v)
		{
			$rowjsonarr=json_decode($v['cp_data'],true);
			//过滤引号转义字符
			foreach($rowjsonarr as $k=>$v)
			{
				$rowjsonarr[$k]=str_replace('&apos;',"'",$v);
				$rowjsonarr[$k]=str_replace('&quot;','"',$rowjsonarr[$k]);
			}
			$line='';
			foreach($zdarr as $zdk=>$zdv)
			{
				if($zdv['qy']!='1'||$zdk=='zdy7')//不启用||图片
				{
					continue;
				}
				$rowval=$rowjsonarr[$zdk];
				if($zdk=='zdy5')//利率
				{
					if($zdarr['zdy2']['qy']=='1'&&$zdarr['zdy4']['qy']=='1')
					{
						$rowval=(($rowjsonarr['zdy2']-$rowjsonarr['zdy4'])/$rowjsonarr['zdy2'])*100;
						$rowval=round($rowval,2).'%';
					}
					else
					{
						$rowval="-";
					}
				}
				if($zdk=='zdy6')//分类
				{
					$rowval=$flarr[$rowjsonarr[$zdk]];
				}
				$rowval=str_replace('
','',str_replace("\n",'',str_replace("\r",'',$rowval)));
				$line[]=$rowval;
			}
			$line[]=$v['cp_add_time'];
			$line[]=$v['cp_edit_time'];
			$body[]=$line;
		}
		$filedo=A("Filedo");
		$filedo->getExcel($name,$head,$body);
		/*
		//连接标题
		$line = implode(',',$head);
		$line .="\r\n";
		$line.=$body;
		
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $line;
		die;
		*/
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
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpbase=M("chanpin");
		$oldcparr=$cpbase->query("select cp_data from crm_chanpin where cp_id='$cpid' and cp_yh='$fid' limit 1");
		$oldcparr=json_decode($oldcparr[0]['cp_data'],true);
		$oldcparr['zdy7']='';
		$newjson=str_replace("\\","\\\\",json_encode($oldcparr));

		$cpbase->query("update crm_chanpin set cp_data='$newjson' where cp_id='$cpid' and cp_yh='$fid' limit 1");
		echo $this->insertrizhi("删除了产品：".$cpname."的产品图片");
	}
	//修改表格的隐藏与显示（存的是隐藏的）
	public function show_option()
	{
		$checkid=addslashes($_POST['checkid']);
		$flid=addslashes($_POST['flid']);
		if($checkid==''||$flid=='')
		{
			echo 2;
			die;
		}
		$checkid=substr($checkid,0,-1);
		$checkarr=explode(",",$checkid);
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");

		foreach($checkarr as $k=>$v)
		{
			$row=substr($v,9);
			$checkarr[$row]=1;
			unset($checkarr[$k]);
		}

		$zdbase=M("yewuziduan");
		$zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='7,".$flid."' limit 1");
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		foreach($zdarr as $k=>$v)
		{
			if($checkarr[$v['id']]!=1&&$v['id']!='zdy7')
			{
				$jsondata[]=$v['id'];
			}
		}

		$pzbase=M("config");
		$iscz=$pzbase->query("select config_cp_table_data from crm_config where config_name='".cookie("user_id")."' limit 1");
		if($iscz[0]['config_cp_table_data']!='')
		{
			$olddata=json_decode($iscz[0]['config_cp_table_data'],true);
		}
		$olddata[$flid]=$jsondata;
		$jsonstr=json_encode($olddata);
		
		$sql=count($iscz)>0?"update crm_config set config_cp_table_data='$jsonstr' where config_name='".cookie("user_id")."' limit 1":"insert into crm_config set config_cp_table_data='$jsonstr',config_name='".cookie("user_id")."' ";
		$pzbase->query($sql);
		echo 1;
	}
	//筛选
	public function shaixuan()
	{
		$ajaxstr=addslashes($_POST['ajaxstr']);
		$flid=addslashes($_POST['flid']);
		$px=$_POST['px'];
		$pz=$_POST['pz'];
		//$ajaxstr="[0]:[4],[1]:[2,6,7,8],[2]:[1000],[3]:[[0][1000]],[4]:[7]";
		//$ajaxstr="[0]:[3],[1]:[2],[2]:[9],[3]:[[0]],[4]:[10]";
		if($ajaxstr=='')
		{
			echo '2';
			die;
		}
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_cp_open");
		$cpflbase=M("chanpinfeilei");
		$cpflbasearr=$cpflbase->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid'");
		foreach($cpflbasearr as $v)
		{
			$cpflarr[$v['cpfl_name']]=$v['cpfl_id'];
		}

		
		$sxcbase=M("sx_cache");
		$sxcbasearr=$sxcbase->query("select * from crm_sx_cache where sxc_yh='$fid' and sxc_yewu='7,".$flid."' limit 1");
		//echo "select * from crm_sx_cache where sxc_yh='$fid' and sxc_yewu='7,".$flid."' limit 1";die;
		//echo $ajaxstr;die;
		$sxcarr=json_decode($sxcbasearr[0]['sxc_data'],true);
		
		$autok=0;
		foreach($sxcarr as $k=>$v)
		{
			$sxcarr[$autok]['id']=$k;
			$newdata='';
			if($v['data']!='')
			{
				$vnum=0;
				foreach($v['data'] as $vv)
				{
					$dda=$k=='zdy6'?$cpflarr[$vv]:$vv;
					$newdata[$vnum]=$dda;
					$vnum++;
				}
			}
			$sxcarr[$k]['ndata']=$newdata;
			$sxcarr[$autok]['data']=$newdata;
			//$ttj=$k=='zdy6'?$cpflarr[$v['tj']]:$v['tj'];
			$sxcarr[$autok]['tj']=$v['tj'];
			//unset($sxcarr[$k]);
			$autok++;
		}
		
		$ajaxarr=$this->jiexi($ajaxstr);
		
		foreach($ajaxarr as $ak=>$av)
		{
			$tj=$sxcarr[$ak]['tj'];
			$zdy=$sxcarr[$ak]['id'];
			if($av=='[1]')
			{
				continue;
			}
			$wherearr[$zdy]['tj']=$tj;
			$wherearr[$zdy]['val']=$av;
		}
		
		$cpbase=M("chanpin");
		$cpbasearr=$cpbase->query("select * from crm_chanpin where cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$flid."\"%' ");
		foreach($cpbasearr as $cpbk=>$v)
		{
			$cpdata=json_decode($v['cp_data'],true);
			//$cpdata['qy']=$v['qy'];
			//$cparr[]=$cpdata;
			foreach($wherearr as $cpdk=>$fw)
			{
				$cpdv=$cpdata[$cpdk];
				if($fw!='')
				{
					if($fw['tj']=='1')
					{
						//echo "<pre>";
						//print_r($ajaxarr);
						if($cpdv!=$sxcarr[$cpdk]['ndata'][$fw['val']-2])
						{
							continue 2;
						}
					}
					if($fw['tj']=='2')
					{
						$thisvalarr=explode(',',$fw['val']);
						foreach($thisvalarr as $thisk1=>$thisv1)
						{
							$thisvalarr[$thisk1]=$sxcarr[$cpdk]['ndata'][$thisv1-2];
						}
						if(!in_array($cpdv,$thisvalarr))
						{
							continue 2;
						}
					}
					
					if($fw['tj']=='3')
					{
						$iscz=explode($fw['val'],$cpdv);
						if(count($iscz)=='1')
						{
							continue 2;
						}
					}
					
					if($fw['tj']=='4')
					{
						$thisval4=explode('][',substr($fw['val'],1,-1));
						$val1=$thisval4[0];
						$val2=$thisval4[1];
						if($cpdv<$val1||$cpdv>$val2)
						{
							
							continue 2;
						}
					}
					if($fw['tj']=='5')
					{
						//echo $cpdk;
						$thisqj=$sxcarr[$cpdk]['ndata'][$fw['val']-2];
						//echo $thisqj;
						if(count(explode('大于',$thisqj))!=1)
						{
							$dayu=explode('大于',$thisqj);
							
							if(str_replace(' ','',$cpdv)<$dayu[1])
							{
								continue 2;
							}
						}
						else if(count(explode('小于',$thisqj))!=1)
						{
							$xiaoyu=explode('小于',$thisqj);
							
							if(str_replace(' ','',$cpdv)>$xiaoyu[1])
							{
								
								continue 2;
							}
							//$aa.=$cpdv.'<'.$xiaoyu[1]."\r\n";
						}
						else
						{
							$qjarr=explode('-',$thisqj);
							if(str_replace(' ','',$cpdv)<$qjarr[0]||str_replace(' ','',$cpdv)>$qjarr[1])
							{
								continue 2;
							}
						}
					}
				}
			}
			$sxcp[$cpbk]=$v;
		}
		//die;
		//echo $aa;die;
		if(count($sxcp)<1)
		{
			echo "<tr><td colspan='100'><center>没有产品数据</center></td></tr>";
			die;
		}
		//分类查询
		$cpflbase=M("chanpinfenlei");
		$cpflbasearr=$cpflbase->query("select cpfl_id,cpfl_name from crm_chanpinfenlei where cpfl_company='$fid' ");
		foreach($cpflbasearr as $v)
		{
			$cpflarr[$v['cpfl_id']]=$v['cpfl_name'];
		}
		//分类结束
		//解析当前页面的配置数据
		$pxarr=json_decode($px,true);
		$pzarr=json_decode($pz,true);


		$newtablestr='';//新表格数据字符串
		foreach($sxcp as $v)
		{
			$rowjsonarr=json_decode($v['cp_data'],true);
			$isfirst='0';
			$rowtdstr='';
			foreach($pxarr as $k=>$vv)
			{
				if($k=='zdy7'||$pzarr[$k]=='1'||$vv['qy']!='1')
				{
					continue;
				}
				$tdclass=$v['cp_qy']=='1'?'':"style='color:#ccc;'";
				$rowjsonarr[$k]=$k=='zdy6'?$cpflarr[$rowjsonarr[$k]]:$rowjsonarr[$k];
				$tdstr=$rowjsonarr[$k];
				$tdstr=$tdstr==''?'-':$tdstr;
				$left_t='';
				if($isfirst=='0')
				{
					$left_t="class='left_t'";
					$firsttd="<td $tdclass style='width:200px'  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;'>".$tdstr."</td>";
				}
				$rowtdstr.="<td $tdclass $left_t  onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' title='".$rowjsonarr[$k]."'>".$tdstr."</td>".$firsttd;
				$firsttd='';
				$isfirst++;
			}
			$checkboxstr="<td id='checkboxcss2'><input  type='checkbox' class='tbbox' id='chid".$v['cp_id']."'></td>";
			$add_edit_date="<td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_add_time']."</td><td $tdclass onclick='link_info(".$v['cp_id'].")' style='cursor:pointer;' >".$v['cp_edit_time']."</td>";
			if($v['qy']=='1')
			{
				$qytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
			else
			{
				$jytr.="<tr>".$checkboxstr.$rowtdstr.$add_edit_date."</tr>";
			}
		}
		$newtablestr=$qytr.$jytr;
		if($newtablestr=='')
		{
			echo "<tr><td colspan='100'><center>没有产品数据</center></td></tr>";
			die;
		}
		echo $newtablestr;

		//==========================================
		/*
		


		
		
		
		*/
	}
	//自用解析字符串传值方法
	public function jiexi($str)
	{
		$str=substr($str,1,-1);
		$strarr=explode("],[",$str);
		foreach($strarr as $v)
		{
			$vv=explode("]:[",$v);
			$rtnarr[$vv[0]]=$vv[1];
		}
		return $rtnarr;
	}
	//图片储存
	public function Base64ToImg($imginfo)
	{
		$base64_image_content = $imginfo;
		//匹配出图片的格式
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
			$type = $result[2];
			$new_file ="./Public/chanpinfile/cpimg/";
			if(!file_exists($new_file))
			{
				//检查是否有该文件夹，如果没有就创建，并给予最高权限
				mkdir($new_file, 0700);
			}
			$rand=rand(1,9);
			$filename=time().time().$rand.".{$type}";
			$new_file = $new_file.$filename;
			if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
				return $filename;
			}else{
				return false;
			}
		}
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