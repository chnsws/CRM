<?php

namespace Home\Controller;
use Think\Controller;


class CpflController extends DBController {
    //产品分类主页
	public function cpfl_index()
	{
        $this->is_login();
		$this->display();
	}
    //获得产品分类树形结构
    public function get_fl_level_html()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $back_html=$this->sel_one_data("crm_config","config_cp_fl_tree","config_name='$fid'");
        if($back_html)
        {
            echo $back_html;
        }
        else
        {
            $flarr=$this->sel_more_data("crm_chanpinfenlei","cpfl_id,cpfl_name,cpfl_jianjie","cpfl_company='$fid'");
            foreach($flarr as $v)
            {
                $jianjie=$v['cpfl_jianjie']==''?'无':$v['cpfl_jianjie'];
                $returnstr.='<li class="uk-nestable-item"> <div class="uk-nestable-panel"> <div class="uk-nestable-toggle" data-nestable-action="toggle"></div> '.$v['cpfl_name'].' <div class="fljg_mod" id="fl_id_'.$v['cpfl_id'].'"><span style="display:none;">'.$jianjie.'</span><i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i> <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i> <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i> </div> </div> </li>';
            }
            echo $returnstr;
        }
    }
    //保存当前分类结构
    public function save_tree_html()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $tree_html=addslashes($_POST['tree_html']);
        $this->edit_one_data("crm_config","config_cp_fl_tree",$tree_html,"config_name='$fid'");
    }
    //添加一条新的分类
    public function add_new_fl()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $flname=addslashes($_GET['flname']);
        if($flname=='')
        {
            echo 0;die;
        }
        $zd_sys_str='[{"id":"zdy0","name":"\u4ea7\u54c1\u540d\u79f0","qy":"1","bt":"1","cy":"1","bj":"0","sc":"0","type":"0"},{"id":"zdy1","name":"\u4ea7\u54c1\u7f16\u53f7","qy":"1","bt":"1","cy":"0","bj":"1","sc":"0","type":"0"},{"id":"zdy2","name":"\u6807\u51c6\u5355\u4ef7","qy":"1","bt":"1","cy":"0","bj":"1","sc":"0","type":"0"},{"id":"zdy3","name":"\u9500\u552e\u5355\u4f4d","qy":"1","bt":"0","cy":"0","bj":"1","sc":"0","type":"0"},{"id":"zdy4","name":"\u5355\u4f4d\u6210\u672c","qy":"1","bt":"0","cy":"0","bj":"1","sc":"0","type":"0"},{"id":"zdy5","name":"\u6bdb\u5229\u7387","qy":"1","bt":"0","cy":"0","bj":"1","sc":"0","type":"0"},{"id":"zdy6","name":"\u4ea7\u54c1\u5206\u7c7b","qy":"1","bt":"1","cy":"0","bj":"1","sc":"0","type":"3"},{"id":"zdy7","name":"\u4ea7\u54c1\u56fe\u7247","qy":"1","bt":"0","cy":"0","bj":"1","sc":"0","type":"5"},{"id":"zdy8","name":"\u4ea7\u54c1\u4ecb\u7ecd","qy":"1","bt":"0","cy":"0","bj":"1","sc":"0","type":"0"}]';
        //判断分类是否存在
        $fl_is_cz=$this->sel_one_data("crm_chanpinfenlei","cpfl_name","cpfl_name='$flname' and cpfl_company='$fid' ");
        if($fl_is_cz)
        {
            echo '2,0';
            die;
        }
        $this->add_one_data("crm_chanpinfenlei","'','$flname','','$fid',''");
        $new_fl_id=$this->sel_one_data("crm_chanpinfenlei","cpfl_id"," cpfl_name='$flname' and cpfl_company='$fid' ");
        //自定义业务字段-插入一条默认字段
        $zd_sys_str=str_replace('\\','\\\\',$zd_sys_str);
        $this->add_one_data("crm_yewuziduan","'','$zd_sys_str','7,".$new_fl_id."','$fid'");
        echo '1,'.$new_fl_id;
    }
    //保存快捷方式
    public function edit_cpfl_link()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $link_id_str=addslashes($_GET['link_id_str']);
        $this->edit_one_data("crm_config","config_cp_fl_link","$link_id_str"," config_name='$fid' ");
    }
    //获取产品分类的快捷方式
    public function get_fl_link()
    {
        $this->is_login();
        $fid=$this->get_fid();
        echo $this->sel_one_data("crm_config","config_cp_fl_link","config_name='$fid'");
    }
    //查询一个
    public function sel_one_data($basename,$field='*',$tj)
    {
        $bk=$this->basename_do($basename);
        $onequery=$bk['basemod']->query("select $field from ".$bk['qz'].$bk['basename']." where $tj limit 1");
        $returnarr=$field=='*'?$onequery[0]:$onequery[0][$field];
        return $returnarr;
    }
    //查询多个
    public function sel_more_data($basename,$field='*',$tj,$key=0)
    {
        $bk=$this->basename_do($basename);
        $morequery=$bk['basemod']->query("select $field from ".$bk['qz'].$bk['basename']." where $tj ");
        if($key==0)
        {
            return $morequery;
        }
        else
        {
            foreach($morequery as $v)
            {
                $returnarr[$v[$key]]=$v;
            }
        }
        return $returnarr;
    }
    //添加一条
    public function add_one_data($basename,$setstr,$field='',$value='')
    {
        $bk=$this->basename_do($basename);
        $z=$field==''?"values($setstr)":"set $field='$value' ";
        $bk['basemod']->query("insert into ".$bk['qz'].$bk['basename']." $z");
    }
    //修改一条
    public function edit_one_data($basename,$field,$value,$tj)
    {
        $bk=$this->basename_do($basename);
        $bk['basemod']->query("update ".$bk['qz'].$bk['basename']." set $field='$value' where $tj limit 1 ");
    }
    //处理数据表名称
    public function basename_do($basename)
    {
        $rt['qz']=substr($basename,0,4);
        $rt['basename']=substr($basename,4);
        $rt['basemod']=M($basename);
        return $rt;
    }
    //获取父id
    public function get_fid()
    {
        $this->is_login();
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
        return $fid;
    }
    //验证登录
    public function is_login()
    {
        if(cookie("islogin")!='1')
		{
			$this->main_gotopage($_GET['root_dir'].'/index.php/Home/Login');
			die();
		}
    }
    //窗口跳转
    public function main_gotopage($pageurl)
    {
        echo "<script>window.parent.location='".$pageurl."'</script>";
        die;
    }
    public function self_gotopage($pageurl)
    {
        echo "<script>window.location='".$pageurl."'</script>";
        die;
    }
    //根据数据库中储存的分类结构来构造html结构
    public function old_fl(){
        $this->is_login();
		//echo "<script>alert(".$_GET['flid'].")</script>";
        $fid=$this->get_fid();
        //产品表操作，根据产品分类统计产品数量
        $cp_all_arr=$this->sel_more_data("crm_chanpin","cp_data,cp_id"," cp_yh='$fid' and cp_del='0' ");
        $fl_cp_num=array();
        foreach($cp_all_arr as $v)
        {
            $thisjsonarr=json_decode($v['cp_data'],true);
            if($thisjsonarr['zdy6'])
            {
                $fl_cp_num[$thisjsonarr['zdy6']]+=1;
            }
        }
        //echo "<pre>";print_r($fl_cp_num);die;
        //产品分类表操作
		$cpflbase=M("chanpinfenlei");
		$cpflarr=$cpflbase->query("select * from crm_chanpinfenlei where cpfl_company='$fid' ");

		foreach($cpflarr as $cpflarrKey=>$cpflarrVal)//格式化产品分类分级
		{
            $fl_jj0[$cpflarrVal['cpfl_id']]=$cpflarrVal['cpfl_jianjie'];
			$bumenNewArr0[$cpflarrVal['cpfl_id']]=array("cpfl_name"=>$cpflarrVal['cpfl_name'],"cpfl_fid"=>$cpflarrVal['cpfl_fid']);
        }
        //产品分类排序
        $pxConfigArr=parent::sel_more_data("crm_config","config_cp_fl_tree_px","config_name='$fid' limit 1");
        $flpxarr=explode(',',$pxConfigArr[0]['config_cp_fl_tree_px']);
        foreach($flpxarr as $v)
        {
            $fl_jj[$v]=$fl_jj0[$v];
            unset($fl_jj0[$v]);
            $bumenNewArr[$v]=$bumenNewArr0[$v];
            unset($bumenNewArr0[$v]);
        }
        foreach($fl_jj0 as $k=>$v)
        {
            $fl_jj[$k]=$v;
            $bumenNewArr[$k]=$bumenNewArr0[$k];
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
		foreach($bmLvArr as $k=>$v)
		{
            //一级
           $jj=$fl_jj[$k]==''?'无':$fl_jj[$k];
           $cp_num=$fl_cp_num[$k]==''?'0':$fl_cp_num[$k];
           //echo $cp_num;
           //print_r($fl_cp_num);
           $bmList.='  <li class="uk-nestable-item">
                            <div class="uk-nestable-panel">
                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                '.$v['cpfl_name'].'
                                <div class="fljg_mod" id="fl_id_'.$k.'">
                                    <span style="display:none;">'.$jj.'</span>
                                    <span style="display:none;">'.$cp_num.'</span>
                                    <i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i>
                                    <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i>
                                    <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i>
                                    <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i>
                                </div>
                            </div>';
			if(count($v['lv2'])>0)
			{
                $bmList.='<ul class="uk-nestable-list">';
				foreach($v['lv2'] as $lv2k=>$lv2v)
				{
                    //二级
                    $jj=$fl_jj[$lv2k]==''?'无':$fl_jj[$lv2k];
                    $cp_num=$fl_cp_num[$lv2k]==''?'0':$fl_cp_num[$lv2k];
                    $bmList.='<li class="uk-nestable-item">
                                    <div class="uk-nestable-panel">
                                        <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                        '.$lv2v['cpfl_name'].'
                                        <div class="fljg_mod" id="fl_id_'.$lv2k.'">
                                            <span style="display:none;">'.$jj.'</span>
                                            <span style="display:none;">'.$cp_num.'</span>
                                            <i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i>
                                            <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i>
                                            <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i>
                                            <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i>
                                        </div>
                                    </div>';
					if(count($lv2v['lv3'])>0)
					{
                        $bmList.='<ul class="uk-nestable-list">';
						foreach($lv2v['lv3'] as $lv3k=>$lv3v)
						{
                            //三级
                            $jj=$fl_jj[$lv3k]==''?'无':$fl_jj[$lv3k];
                            $cp_num=$fl_cp_num[$lv3k]==''?'0':$fl_cp_num[$lv3k];
                            $bmList.='<li class="uk-nestable-item">
                                            <div class="uk-nestable-panel">
                                                <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                                '.$lv3v['cpfl_name'].'
                                                <div class="fljg_mod" id="fl_id_'.$lv3k.'">
                                                    <span style="display:none;">'.$jj.'</span>
                                                    <span style="display:none;">'.$cp_num.'</span>
                                                    <i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i>
                                                    <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i>
                                                    <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i>
                                                    <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i>
                                                </div>
                                            </div>';
							if(count($lv3v['lv4'])>0)
							{
                                $bmList.='<ul class="uk-nestable-list">';
								foreach($lv3v['lv4'] as $lv4k=>$lv4v)
								{
                                    //四级
                                    $jj=$fl_jj[$lv4k]==''?'无':$fl_jj[$lv4k];
                                    $cp_num=$fl_cp_num[$lv4k]==''?'0':$fl_cp_num[$lv4k];
                                    $bmList.='<li class="uk-nestable-item">
                                                <div class="uk-nestable-panel">
                                                    <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                                    '.$lv4v['cpfl_name'].'
                                                    <div class="fljg_mod" id="fl_id_'.$lv4k.'">
                                                        <span style="display:none;">'.$jj.'</span>
                                                        <span style="display:none;">'.$cp_num.'</span>
                                                        <i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i>
                                                        <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i>
                                                        <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i>
                                                        <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i>
                                                    </div>
                                                </div>';
									if(count($lv4v['lv5'])>0)
									{
                                        $bmList.='<ul class="uk-nestable-list">';
										foreach($lv4v['lv5'] as $lv5k=>$lv5v)
										{
                                            //五级
                                            $jj=$fl_jj[$lv5k]==''?'无':$fl_jj[$lv5k];
                                            $cp_num=$fl_cp_num[$lv5k]==''?'0':$fl_cp_num[$lv5k];
                                            $bmList.='<li class="uk-nestable-item">
                                                        <div class="uk-nestable-panel">
                                                            <div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
                                                            '.$lv5v['cpfl_name'].'
                                                            <div class="fljg_mod" id="fl_id_'.$lv5k.'">
                                                                <span style="display:none;">'.$jj.'</span>
                                                                <span style="display:none;">'.$cp_num.'</span>
                                                                <i class="uk-icon-arrow-right" aria-hidden="true" title="添加快捷方式"></i>
                                                                <i class="uk-icon-trash-o" aria-hidden="true" title="删除分类"></i>
                                                                <i class="uk-icon-pencil" aria-hidden="true" title="修改分类名称"></i>
                                                                <i class="uk-icon-folder-open-o" aria-hidden="true" title="查看产品"></i>
                                                            </div>
                                                        </div>';
										}
                                        $bmList.='</ul></li>';
									}
                                    else
                                    {
                                        $bmList.='</li>';
                                    }
								}
                                $bmList.='</ul></li>';
							}
                            else
                            {
                                $bmList.='</li>';
                            }
						}
                        $bmList.='</ul></li>';
					}
                    else
                    {
                        $bmList.='</li>';
                    }
				}
                $bmList.='</ul></li>';
			}
            else
            {
                $bmList.='</li>';
            }
		}
        echo $bmList;
    }
    //改变数据库中产品分类的结构数据
    public function edit_db_tree_old()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $get_jg=$_GET['json_str'];
        $get_jg=explode(',',substr(str_replace('"','',$get_jg),1,-1));
        $sql_str='';
        $fldb=M("chanpinfenlei");
        foreach($get_jg as $v)
        {
            $varr=explode(":",$v);
            $sql_str.=" WHEN '".$varr[1]."' THEN '".$varr[0]."' ";
            $idarr[]=$varr[1];
        }
        $idstr="'".implode("','",$idarr)."'";
        $main_sql="update crm_chanpinfenlei set cpfl_fid = CASE cpfl_id $sql_str ELSE `cpfl_fid` END where cpfl_id in ($idstr) ";
        
        $fldb->query($main_sql);
    }
    //修改产品分类的简介
    public function edit_fl_jj()
    {
        $this->is_login();
        $fid=$this->get_fid();
        $cpflid=$this->getok("cpflid");
        $jj_content=$this->getok("jj_content");
        if($cpflid==''||$jj_content=='')
        {
            echo 2;die;
        }
        $this->edit_one_data("crm_chanpinfenlei","cpfl_jianjie","$jj_content"," cpfl_id='$cpflid' ");
        echo 1;
    }
    //保存产品分类的树形结构顺序
    public function edit_tree_px()
    {
        $getPx=$_POST['jsonstr'];
        $px=json_decode($getPx,true);
        $pxstr=implode(',',$px);
        $fid=parent::get_fid();
        $configbase=M("config");
        $configbase->query("update crm_config set config_cp_fl_tree_px='$pxstr' where config_name='$fid' limit 1 ");
    }
    //产品全局查询
    public function search_cp_list()
    {
        $inputText=addslashes($_GET['searchstr']);
        $searchJsonStr=json_encode($inputText);
        $searchJsonStr=substr($searchJsonStr,1,-1);
        if($searchJsonStr=='')
        {
            echo '0';
            die;
        }
        $searchJsonStr=str_replace('\\','\\\\\\\\',$searchJsonStr);
        $fid=parent::get_fid();
        $searchDbArr=parent::sel_more_data("crm_chanpin","cp_id,cp_data","cp_yh='$fid' and cp_del='0' and cp_data like '%$searchJsonStr%' ");
        //parent::rr("cp_yh='$fid' and cp_del='0' and cp_data like '%$searchJsonStr%'");
        //parent::rr($searchDbArr);
        if(count($searchDbArr)>0)
        {
            $cpflArr=parent::sel_more_data("crm_chanpinfenlei","*","cpfl_company='$fid'");
            foreach($cpflArr as $v)
            {
                $cpfl[$v['cpfl_id']]=$v['cpfl_name'];
            }
        }
        //echo "cp_yh='$fid' and cp_del='0' and cp_data like '$searchJsonStr' ";die;
        //select cp_data from crm_chanpin where cp_yh='3' and cp_del='0' and cp_data like '\\u4e3a'  
        $jsonData=array();
        foreach($searchDbArr as $v)
        {
            $jsonDecode=json_decode($v['cp_data'],true);
            //parent::rr($jsonDecode);
            //echo strpos($jsonDecode['zdy0'],$inputText).'-----';
            /*
            $exarr=explode($inputText,$jsonDecode['zdy0']);
            if(count($exarr)<2)
            {
                continue;
            }
            */
            /*
            if(strpos($jsonDecode['zdy0'],$inputText)=='')
            {
                if(strpos($jsonDecode['zdy0'],$inputText)!='0')
                {
                    //再次判断产品名称中是否存在搜索的字符串
                    continue;
                }
            }
            */
            //0:名称    6:分类    1:编号
            $jsonData[]=array(
                "id"=>$v['cp_id'],
                "name"=>$jsonDecode['zdy0'],
                "number"=>$jsonDecode['zdy1'],
                "flid"=>$jsonDecode['zdy6'],
                "flname"=>($cpfl[$jsonDecode['zdy6']]==''?'--':$cpfl[$jsonDecode['zdy6']])
            );
        }
        $returnJson=json_encode($jsonData);
        echo $returnJson;
        
        
    }
    //GET&POST处理方法
    public function getok($var_name)
    {
        return addslashes($_GET[$var_name]);
    }
    public function postok($var_name)
    {
        return addslashes($_POST[$var_name]);
    }
    //插入日志方法
    public function insertrizhi($con)
    {
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
        $fid=$this->get_fid();
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','1','7','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");
        return '1';
    }
}