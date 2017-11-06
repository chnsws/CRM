<?php
namespace Home\Controller;
use Think\Controller;


class YewucanshuController extends DBController {
	
	
	//自定义业务参数
	public function index(){
		parent::is_login2(2);//登录
		parent::have_qx2("qx_sys_ywcs");//权限
		$fid=parent::get_fid();
		
		$this->display();
	}
	//获取参数数据
	public function get_cs_data()
	{
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywcs");//权限
		$fid=parent::get_fid();

		$mod=addslashes($_GET['mod']);

		if($mod=='')
		{
			die('0');
		}
		//字段名称
		if($mod<7)
		{
			$zddata=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yewu='$mod' and zd_yh='$fid' limit 1");
			$zdarr=json_decode($zddata[0]['zd_data'],true);
			foreach($zdarr as $v)
			{
				$zdname[$v['id']]=$v['name'];
			}
			if($mod=='6')
			{
				$zdname['hktype']='回款类型';
				$zdname['pjtype']='票据类型';
			}
		}
		else
		{
			$zdname['gjtype']='跟进方式';
		}
		

		
		/*
			需要让程序自动识别并找到这些字段
			线索：
				14:跟进状态   15:线索来源
			客户：
				1：客户类型  9：跟进状态  12人员规模  10客户来源   11所属行业
			商机
				9商机来源   5销售阶段    7商机类型
			合同、
				7合同状态   10合同类型   11付款方式  hktype回款类型   pjtype票据类型
			其他
				gjtype跟进方式
		*/
		$zd_key_arr=array(
			"1"=>array(
				"zdy15"=>"zdy15",
				"zdy14"=>"zdy14"
			),
			"2"=>array(
				"zdy1"=>"zdy1",
				"zdy9"=>"zdy9",
				"zdy12"=>"zdy12",
				"zdy10"=>"zdy10",
				"zdy11"=>"zdy11"
			),
			"5"=>array(
				"zdy9"=>"zdy9",
				"zdy5"=>"zdy5",
				"zdy7"=>"zdy7"
			),
			"6"=>array(
				"zdy7"=>"zdy7",
				"zdy10"=>"zdy10",
				"zdy11"=>"zdy11",
				"hktype"=>"hktype",
				"pjtype"=>"pjtype"
			),
			"7"=>array(
				"gjtype"=>"gjtype"
			)
		);
		$px_key_arr=array(
			"11"=>"zdy15",
			"12"=>"zdy14",
			"21"=>"zdy1",
			"22"=>"zdy9",
			"23"=>"zdy12",
			"24"=>"zdy10",
			"25"=>"zdy11",
			"51"=>"zdy9",
			"52"=>"zdy5",
			"53"=>"zdy7",
			"61"=>"zdy7",
			"62"=>"zdy10",
			"63"=>"zdy11",
			"64"=>"hktype",
			"65"=>"pjtype",
			"71"=>"gjtype"
		);
		//查询参数
		$csarr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yw='$mod' and ywcs_yh='$fid' limit 1");
		$csarr=json_decode($csarr[0]['ywcs_data'],true);
		
		foreach($csarr as $k=>$v)
		{
			$row_cs=array();
			foreach($v as $canshu=>$name)
			{
				if(substr($canshu,0,6)!='canshu')
				{
					continue;
				}
				if($mod=='5'&&$v['id']=='zdy5')
				{
					$row_cs[$canshu]=array(
						"name"=>$name,
						"qy"=>$v['qy'][$canshu],
						"knx"=>$v['knx'][$canshu]
					);
				}
				else
				{
					$row_cs[$canshu]=array(
						"name"=>$name,
						"qy"=>$v['qy'][$canshu]
					);
				}
				
			}
			$csarr[$v['id']]=$row_cs;
			unset($csarr[$k]);
		}
		//查询排序
		$px_mod_arr=array(
			"1"=>"'11','12'",
			"2"=>"'21','22','23','24','25'",
			"5"=>"'51','52','53'",
			"6"=>"'61','62','63','64','65'",
			"7"=>"'71'"
		);
		$pxarr=parent::sel_more_data("crm_paixu","px_px,px_mod","px_yh='$fid' and px_mod in (".$px_mod_arr[$mod].")");

		//根据数据库中的排序，重新排列参数的顺序
		$cs_have_px=array();
		foreach($pxarr as $v)
		{
			if($v['px_px']!='')
			{
				$row_px=explode(',',$v['px_px']);
				foreach($row_px as $vv)
				{
					$cs_have_px[$px_key_arr[$v['px_mod']]][$vv]=$csarr[$px_key_arr[$v['px_mod']]][$vv];
					unset($csarr[$px_key_arr[$v['px_mod']]][$vv]);
				}
			}
			else
			{
				$cs_have_px=$csarr;
				unset($csarr);
			}
		}
		foreach($csarr as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				$cs_have_px[$k][$kk]=$vv;
				unset($csarr[$k][$kk]);
			}
		}
		foreach($zd_key_arr[$mod] as $v)
		{
			$res['name'][$v]=$zdname[$v];
		}
		$res['data']=$cs_have_px;
		//parent::rr($res);
		echo json_encode($res);
	}
	//添加参数
	public function addcs()
	{
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywcs");//权限
		$fid=parent::get_fid();

		$thismod=addslashes($_GET['thismod']);
		$thisid=addslashes($_GET['thisid']);
		$name=addslashes($_GET['name']);
		$knx=addslashes($_GET['knx']);

		//$thismod='5';
		//$thisid='zdy5';
		//$name='666a';
		//$knx='10';
		if($thismod==''||$thisid==''||$name=='')
		{
			$res=array(
				"res"=>'0'
			);
			echo json_encode($res);
			die;
		}
		if($thismod=='5'&&$thisid=='zdy5'&&$knx=='')
		{
			$res=array(
				"res"=>'0'
			);
			echo json_encode($res);
			die;
		}
		//查询数据库中存在的数据
		$csarr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		$csarr=json_decode($csarr[0]['ywcs_data'],true);
		//查询最大参数和是否有重复名称的参数
		$maxcanshu='';
		$thiszdkey='';
		foreach($csarr as $k=>$v)
		{
			if($v['id']==$thisid)
			{
				$thiszdkey=$k;
				foreach($v as $kk=>$vv)
				{
					if(substr($kk,0,6)!='canshu')
					{
						continue;
					}
					else
					{
						if($vv==$name)
						{
							$res=array(
								"res"=>'2'
							);
							echo json_encode($res);
							die;
						}
						$thiscsnum=substr($kk,6);
						$maxcanshu=$maxcanshu>=$thiscsnum?$maxcanshu:$thiscsnum;
					}
				}
			}
		}
		$maxcanshu++;
		$csarr[$thiszdkey]['canshu'.$maxcanshu]=$name;
		$csarr[$thiszdkey]['qy']['canshu'.$maxcanshu]=1;
		if($thismod=='5'&&$thisid='zdy5')
		{
			$csarr[$thiszdkey]['knx']['canshu'.$maxcanshu]=$knx;
		}
		$newjson=json_encode($csarr);
		$newjson=str_replace("\\","\\\\",$newjson);
		$csdb=M("ywcs");
		$csdb->query("update crm_ywcs set ywcs_data='$newjson' where ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		$res=array(
			"res"=>'1',
			"num"=>$maxcanshu
		);
		echo json_encode($res);
	}
	//参数修改方法
	public function editcs()
	{
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywcs");//权限
		$fid=parent::get_fid();

		$thismod=addslashes($_GET['thismod']);
		$thisid=addslashes($_GET['thisid']);
		$thiscsid=addslashes($_GET['thiscsid']);
		$name=addslashes($_GET['name']);
		$knx=addslashes($_GET['knx']);

		if($thismod==''||$thiscsid==''||$thisid==''||$name=='')
		{
			die('0');
		}
		if($thismod=='5'&&$thisid=='zdy5'&&$knx=='')
		{
			die('0');
		}
		//查询数据库中存在的数据
		$csarr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		$csarr=json_decode($csarr[0]['ywcs_data'],true);
		//查询是否有重复名称的参数

		$thiszdkey='';
		foreach($csarr as $k=>$v)
		{
			if($v['id']==$thisid)
			{
				$thiszdkey=$k;
				$csarr[$k][$thiscsid]=$name;
				//判断新参数名称是否重复
				foreach($v as $kk=>$vv)
				{
					if(substr($kk,0,6)!='canshu')
					{
						continue;
					}
					else
					{
						if($vv==$name&&$kk!=$thiscsid)
						{
							die('2');
						}
					}
				}
			}
		}

		//如果没有重复就执行修改数据库操作
		if($thismod=='5'&&$thisid='zdy5')
		{
			//如果存在签单可能性的值
			$csarr[$thiszdkey]['knx'][$thiscsid]=$knx;
		}

		
		$newjson=json_encode($csarr);
		$newjson=str_replace("\\","\\\\",$newjson);
		$csdb=M("ywcs");
		$csdb->query("update crm_ywcs set ywcs_data='$newjson' where ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		echo '1';
	}
	//点击复选框更改
	public function change_checkbox()
	{
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywcs");//权限
		$fid=parent::get_fid();

		$thiszd=addslashes($_GET['thiszd']);//字段
		$thisid=addslashes($_GET['thisid']);//参数id
		$thismod=addslashes($_GET['thismod']);//模块编号
		$thisval=addslashes($_GET['thisval']);//值

		if($thiszd==''||$thisid==''||$thismod==''||$thisval=='')
		{
			die("0");
		}

		//在数据库找到该条数据
		$csarr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		$csarr=json_decode($csarr[0]['ywcs_data'],true);

		//修改字段的值
		foreach($csarr as $k=>$v)
		{
			if($v['id']==$thiszd)
			{
				$csarr[$k]['qy'][$thisid]=$thisval;
				continue;
			}
		}

		
		//压缩并存入数据库
		$newjson=json_encode($csarr);
		$newjson=str_replace("\\","\\\\",$newjson);
		$csdb=M("ywcs");
		$csdb->query("update crm_ywcs set ywcs_data='$newjson' where ywcs_yh='$fid' and ywcs_yw='$thismod' limit 1");
		echo '1';
	}
	//改变排序
	public function change_paixu()
	{
		parent::is_login();//登录
		parent::have_qx("qx_sys_ywcs");//权限
		$fid=parent::get_fid();

		$thissx=addslashes($_POST['thissx']);
		$thiszd=addslashes($_POST['thiszd']);
		$thismod=addslashes($_POST['thismod']);
		if($thissx==''||$thiszd==''||$thismod=='')
		{
			die("0");
		}
		$px_key_arr=array(
			"1"=>array(
				"zdy15"=>"11",
				"zdy14"=>"12"
			),
			"2"=>array(
				"zdy1"=>"21",
				"zdy9"=>"22",
				"zdy12"=>"23",
				"zdy10"=>"24",
				"zdy11"=>"25"
			),
			"5"=>array(
				"zdy9"=>"51",
				"zdy5"=>"52",
				"zdy7"=>"53"
			),
			"6"=>array(
				"zdy7"=>"61",
				"zdy10"=>"62",
				"zdy11"=>"63",
				"hktype"=>"64",
				"pjtype"=>"65"
			),
			"7"=>array(
				"gjtype"=>"71"
			)
		);
		$pxmod=$px_key_arr[$thismod][$thiszd];
		//查询本条
		$pxdb=M("paixu");
		$olddata=parent::sel_more_data("crm_paixu","px_px","px_yh='$fid' and px_mod='$pxmod' limit 1");
		//如果存在就修改，如果不存在就插入
		if(!count($olddata))
		{
			$pxdb->query("insert into crm_paixu set px_px='$thissx',px_yh='$fid',px_mod='$pxmod' ");
		}
		else
		{
			$pxdb->query("update crm_paixu set px_px='$thissx' where px_yh='$fid' and px_mod='$pxmod' limit 1");
		}
		echo 1;
	}
}



