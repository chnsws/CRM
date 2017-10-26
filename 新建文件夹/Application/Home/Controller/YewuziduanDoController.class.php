<?php
namespace Home\Controller;
use Think\Controller;


class YewuziduanDoController extends Controller {
    public $pageidarr=array(
            "paixu_xiansuo"=>'1',
            "paixu_kehu"=>'2',            
            "paixu_lianxiren"=>'4',
            "paixu_shangji"=>'5',
            "paixu_hetong"=>'6',
            "paixu_chanpin"=>'7'
            );
    public $pagenamearr=array(
            "paixu_xiansuo"=>'线索',
            "paixu_kehu"=>'客户',            
            "paixu_lianxiren"=>'联系人',
            "paixu_shangji"=>'商机',
            "paixu_hetong"=>'合同',
            "paixu_chanpin"=>'产品'
            );
    //连表3    地区1  时间2
	//业务字段排序
    public function paixu()
    {
        $thispage=addslashes($_POST['thispage']);
        $shunxu=addslashes(substr($_POST['shunxu'],0,-1));
        if($thispage==''||$shunxu=='')
        {
            echo '2';
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        if(substr($thispage,0,1)=='7')
        {
            $pxmod=$thispage;
        }
        else
        {
            $pageidarr=$this->pageidarr;
            $pxmod=$pageidarr[$thispage];
        }
        
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select * from crm_paixu where px_yh='$fid' and px_mod='".$pxmod."'");
        if(count($pxarr)>0)
        {
            $pxbase->query("update crm_paixu set px_px='$shunxu' where px_yh='$fid' and px_mod='".$pxmod."' limit 1");
        }
        else
        {
            $pxbase->query("insert into crm_paixu values('','$shunxu','$fid','".$pxmod."')");
        }
        echo 1;
    }
    //添加字段
    public function addziduan()
    {
        $thispage=addslashes($_GET['thispage']);
        $ziduanname=addslashes($_GET['ziduanname']);
        $thisflname=addslashes($_GET['thisflname']);
        if($thispage==''||$ziduanname=='')
        {
            echo '2';
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        if(substr($thispage,0,1)=='7')
        {
            $rzname="产品分类 ".$thisflname;
            $zdyw=$thispage;
        }
        else
        {
            $pageidarr=$this->pageidarr;
            $zdyw=$pageidarr[$thispage];
            $pagenamearr=$this->pagenamearr;
            $rzname=$pagenamearr[$thispage];
        }
        $zdbase=M("yewuziduan");
        $dataarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='".$zdyw."' and zd_yh='$fid'");
        $dataarr=json_decode($dataarr[0]['zd_data'],true);
        $zdy_max_db=M("config");
        $zdy_max=$zdy_max_db->query("select config_option_zd_num from crm_config where config_name='$fid' limit 1");
        $zdy_max_db->query("update crm_config set config_option_zd_num=config_option_zd_num+1 where config_name='$fid' limit 1");
        foreach($dataarr as $k=>$v)
        {
            if($v['name']==$ziduanname)
            {
                echo '3';
                die;
            }
            $nowid=substr($v['id'],3);
            $newkey=$k;
        }
        $maxzdyid=$zdy_max[0]['config_option_zd_num'];
        $newid='zdy'.$maxzdyid;
        $dataarr[$newkey+1]=array(
            "id"=>$newid,
            "name"=>$ziduanname,
            "qy"=>'1',
            "bt"=>'0',
            "cy"=>'0',
            "bj"=>'1',
            "sc"=>'1',
            "type"=>'0'
        );
        $jsonstr=str_replace('\\','\\\\',json_encode($dataarr));
        $zdbase->query("update crm_yewuziduan set zd_data='$jsonstr' where zd_yewu='".$zdyw."' and zd_yh='$fid'");
        //将新添加的字段加入到排序表中
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='".$zdyw."'");
        $pxpx=$pxarr[0]['px_px'].','.$newid;
        $pxbase->query("update crm_paixu set px_px='$pxpx' where px_yh='$fid' and px_mod='".$zdyw."' limit 1");
        
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','3','8','".cookie("user_id")."','0','0','0','0','0','新增".$rzname."字段".$ziduanname."','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        echo '1';
    }
    //修改值（启用、必填、常用）时执行的方法
    public function changecheckbox()
    {
        $nowpage=addslashes($_GET['nowpage']);
        $thisflname=addslashes($_GET['thisflname']);
        $changeval=addslashes($_GET['changeval']);
        $changename=addslashes($_GET['changename']);
        if($nowpage==''||$changeval==''||$changename=='')
        {
            echo 2;
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $checkval=$changeval=='true'?'1':'0';
        $changetype=substr($changename,0,2);
        $changeid=substr($changename,2);
        
        if(substr($nowpage,0,1)==7)
        {
            $pageval=$nowpage;
            $rz_str1="产品分类：".$thisflname.' ';
        }
        else
        {
            $pagenamearr=$this->pagenamearr;
            $rz_str1=$pagenamearr[$nowpage];
            $pageidarr=$this->pageidarr;
            $pageval=$pageidarr[$nowpage];
        }
        
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        $dataarr=json_decode($zdarr[0]['zd_data'],true);
        foreach($dataarr as $k=>$v)
        {
            if($v['id']==$changeid)
            {
                $dataarr[$k][$changetype]=$checkval;
                $updatename=$v['name'];
                break;
            }
        }
        $newjsonstr=json_encode($dataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $zdbase->query("update crm_yewuziduan set zd_data='$newjsonstr' where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        
        echo $this->insertrizhi("修改了".$rz_str1."的 ".$updatename." 字段");
    }
    //修改字段名称方法
    public function changename()
    {
        $nowpage=addslashes($_GET['nowpage']);
        $newname=addslashes($_GET['newname']);
        $changeid=addslashes($_GET['changeid']);
        $flname=addslashes($_GET['flname']);
        if($nowpage==''||$newname==''||$changeid=='')
        {
            echo 2;
            die;
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $pageidarr=$this->pageidarr;
        $pagenamearr=$this->pagenamearr;
        $rzname=substr($nowpage,0,1)=='7'?"产品分类：".$flname:$pagenamearr[$nowpage];
        $pageval=substr($nowpage,0,1)=='7'?$nowpage:$pageidarr[$nowpage];
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        $dataarr=json_decode($zdarr[0]['zd_data'],true);
        foreach($dataarr as $k=>$v)
        {
            if($v['id']==$changeid)
            {
                $dataarr[$k]['name']=$newname;
                break;
            }
        }
        $newjsonstr=json_encode($dataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $zdbase->query("update crm_yewuziduan set zd_data='$newjsonstr' where zd_yewu='$pageval' and zd_yh='$fid' limit 1");
        echo $this->insertrizhi("修改了".$rzname." 中 ".$newname." 的字段名称");
    }
    //延迟加载其他页面
    public function loadpage()
    {
        $nowpage=addslashes($_GET['thispage']);
        $pageidarr=$this->pageidarr;
        $pageval=$pageidarr[$nowpage];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='$pageval' limit 1");
        $json2arr=json_decode($zdarr[0]['zd_data'],true);
        $pxbase=M("paixu");
        $pxarr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$pageval'");

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
						$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' onmousedown='tuozhuai()'><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td><a onclick=bianji('".$v['id']."','".$v['sc']."')>编辑</a></td></tr>";
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
				$tablestr.="<tr id='".$v['id']."'><td class='tuozhuaiclass' onmousedown='tuozhuai()'><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td><a onclick=bianji('".$v['id']."','".$v['sc']."')>编辑</a></td></tr>";
			}
		}
        echo $tablestr;

    }
    //删除字段方法
    public function delzd()
    {
        $nowpage=addslashes($_GET['nowpage']);
        $changeid=addslashes($_GET['changeid']);
        $flname=addslashes($_GET['flname']);
        if($nowpage==''||$changeid=='')
        {
            echo 2;
            die;
        }
        
        $pageidarr=$this->pageidarr;
        $pageval=substr($nowpage,0,1)=='7'?$nowpage:$pageidarr[$nowpage];
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $zdbase=M("yewuziduan");
        $zdarr=$zdbase->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='$pageval' limit 1");
        $pxbase=M("paixu");
        $pxbasearr=$pxbase->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$pageval' limit 1");
        $pxarr=explode(",",$pxbasearr);
        foreach($pxarr as $k=>$v)
        {
            if($v==$changeid)
            {
                unset($pxarr[$k]);
                break;
            }
        }
        $pxnewarr=implode(",",$pxarr);
        $pxbase->query("update crm_paixu set px_px='$pxnewarr' where px_yh='$fid' and px_mod='$pageval' limit 1 ");
        $dataarr=json_decode($zdarr[0]['zd_data'],true);
        foreach($dataarr as $k=>$v)
        {
            if($v['id']==$changeid)
            {
                $delname=$v['name'];
                unset($dataarr[$k]);
                break;
            }
        }
        $newjsonstr=json_encode($dataarr);
        $newjsonstr=str_replace('\\','\\\\',$newjsonstr);
        $zdbase->query("update crm_yewuziduan set zd_data='$newjsonstr' where zd_yh='$fid' and zd_yewu='$pageval' limit 1");
        $pagenamearr=$this->pagenamearr;
        $pagename=substr($nowpage,0,1)=='7'?"产品分类：".$flname:$pagenamearr[$nowpage];
        echo $this->insertrizhi("删除了".$pagename." 的 ".$delname.' 字段');

    }
    //根据产品分类获取产品字段
	public function zd_for_chanpin()
	{
		$mod=A("Cpfl");
		$mod->is_login();
		$fid=$mod->get_fid();
		//查询产品分类
		$cpflarr=$mod->sel_more_data("crm_chanpinfenlei","cpfl_id,cpfl_name"," cpfl_company='$fid' ");
		//查询产品字段
		$cpzdarr=$mod->sel_more_data("crm_yewuziduan","zd_data,zd_yewu"," zd_yh='$fid' and zd_yewu like '7,%' ");
        //首先先判断是否需要排序
        $cp_px_arr=$mod->sel_more_data("crm_paixu","px_px,px_mod","px_yh='$fid' and px_mod like '7,%' ");
        foreach($cp_px_arr as $v)
        {
            $yewu=explode(",",$v['px_mod']);
            $have_px[$yewu[1]]=explode(',',$v['px_px']);
        }
        //格式化字段数据，如果有排序就进行排序
        foreach($cpzdarr as $k=>$v)
        {
            $this_zd_fl=explode(',',$v['zd_yewu']);
            $this_zd_arr=json_decode($v['zd_data'],true);
            
            foreach($this_zd_arr as $zdarr_k=>$zdarr_v)
            {
                $this_zd_arr[$zdarr_v['id']]=$zdarr_v;
                unset($this_zd_arr[$zdarr_k]);
            }
            $newcpzdarr[$this_zd_fl[1]]=$this_zd_arr;
            //如果有排序,就覆写本条字段
            if(count($have_px[$this_zd_fl[1]])>0)
            {
                foreach($have_px[$this_zd_fl[1]] as $v)
                {
                    $this_zd_arr_have_px[$v]=$this_zd_arr[$v];
                }
                $newcpzdarr[$this_zd_fl[1]]=$this_zd_arr_have_px;
            }
        }
		//处理产品字段
		$cpzd=array();
		foreach($newcpzdarr as $fl_key=>$zd_arr)
		{
			foreach($zd_arr as $v)
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
				$tablestr[$fl_key].="<tr id='".$v['id']."'><td class='tuozhuaiclass uk-sortable-handle'><i class='fa fa-reorder' aria-hidden='true'></i></td><td>".$v['name']."</td><td>&nbsp;&nbsp;$instyle1</td><td>&nbsp;&nbsp;$instyle2</td><td>&nbsp;&nbsp;$instyle3</td><td><a onclick=bianji('".$v['id']."','".$v['sc']."',this.parentNode.parentNode.parentNode.id.substr(14))>编辑</a></td></tr>";
                $mod_height[$fl_key]=$mod_height[$fl_key]+51;
			}
		}
		$return_str='';
		foreach($cpflarr as $v)
		{
			$return_str.='<h3 class="uk-accordion-title">'.$v['cpfl_name'].'</h3>
                            <div class="uk-accordion-content" style="height:'.($mod_height[$v['cpfl_id']]+150).'px;"><button onclick="xinzeng(this)" class="layui-btn">新增字段</button>
                                <table lay-skin="line" style="width:100%;">
                                    <thead>
                                        <th style="width:10%">排序</th>
                                        <th style="width:18%;">字段名称</th>
                                        <th style="width:18%;">启用</th>
                                        <th style="width:18%;">必填</th>
                                        <th style="width:18%;">常用</th>
                                        <th style="width:18%;">操作</th>
                                    </thead>
									<tbody id="tbody_chanpin_'.$v['cpfl_id'].'" class="uk-sortable" data-uk-sortable="{handleClass:\'uk-sortable-handle\'}" style="width:100%;" >';
									$return_str.=$tablestr[$v['cpfl_id']];
			$return_str.="	</tbody>
							</table>
                            </div>";
		}
		echo $return_str;
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
		$xitongrizhibase->query("insert into crm_rz values('','3','8','".cookie("user_id")."','0','0','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}