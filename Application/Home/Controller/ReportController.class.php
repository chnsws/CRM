<?php
namespace Home\Controller;
use Think\Controller;
class ReportController extends DBController {
    //首页默认显示跟进记录的报表，并且是今日的
	public function index()
    {
        //首页默认显示跟进记录的报表
        $this->display();
    }
    public function nav()
    {
        $this->display();
    }
    public function yewuxinzenghuizong()
    {
        $this->display();
    }
    public function yewuxinzenghuizong2()
    {
        $this->display();
    }
    //产品销售汇总表-按产品汇总
    public function chanpinxiaoshouhuizong()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //今日、本周、本月、本季度、本年
        $timearr=parent::time_more();
        //产品分类查询
        $cpfl_option=$this->get_cpfl_option($fid);
        $cpfl_name_arr=$this->option_to_arr($cpfl_option);
        //部门列表查询
        $bm_option=$this->get_bm_option($fid);
        //所有用户查询
        $user_option=$this->get_user_option($fid);
        //获得用户的部门
        $user_bm=$this->get_user_bm($fid);
        //所有产品查询
        //cp_del字段：该产品是否已经被删除（0：未被删除；1：已删除）
        $cp_arr=parent::sel_more_data("crm_chanpin","cp_id,cp_data,cp_del","cp_yh='$fid'");
        foreach($cp_arr as $v)
        {
            $cpname=json_decode($v['cp_data'],true);
            $cp_json_info[$v['cp_id']]=$cpname;
            $cp_name_arr[$v['cp_id']]=$cpname['zdy0'];
        }
        //所有合同查询 //合同zdy5:合同开始时间
        $ht_arr=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid'");
        foreach($ht_arr as $v)
        {
            $ht_json=json_decode($v['ht_data'],true);
            
            if($_GET['sx_1']!='')
            {
                //日周月季度
                if(strlen($_GET['sx_1'])==1)
                {
                    if($this->date_to_date($ht_json['zdy5'])<$timearr[$_GET['sx_1']][s]||$this->date_to_date($ht_json['zdy5'])>$timearr[$_GET['sx_1']][e])
                    {
                        continue;
                    }
                }
                else
                {
                    //自定义时间段
                    $zdytimearr=explode(',',$_GET['sx_1']);
                    if($this->date_to_date($ht_json['zdy5'])<$zdytimearr[0].' 00:00:00'||$this->date_to_date($ht_json['zdy5'])>$zdytimearr[1].' 23:59:59')
                    {
                        continue;
                    }
                }
            }
            if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
            {
                if($user_bm[$v['ht_fz']]!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            if($_GET['sx_4']!=''&&$_GET['sx_4']!='0')
            {
                if($v['ht_fz']!=$_GET['sx_4'])
                {
                    continue;
                }
            }
            $ht_dbtable_in_str[]=$v['ht_id'];
        }

        $ht_dbtable_in_str=implode("','",$ht_dbtable_in_str);
        $ht_dbtable_in_str="'".$ht_dbtable_in_str."'";
        
        //查询合同-产品||商机-产品 关联表
        $cp_info_arr=parent::sel_more_data("crm_cp_sj","cp_id,cp_num1,cp_zj,sj_id","cp_yh='$fid' and cp_mk='6' and sj_id in ($ht_dbtable_in_str) ");
        //图形数据
        foreach($cp_info_arr as $v)
        {
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($cp_json_info[$v['cp_id']]['zdy6']!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            $cp_sum[$v['cp_id']]+=$v['cp_zj'];
            $cp_xiaoliang[$v['cp_id']]+=$v['cp_num1'];
            $cp_name[$v['cp_id']]=$cp_name_arr[$v['cp_id']];
            $sum_sum+=$v['cp_zj'];
            $sum_xiaoliang+=$v['cp_num1'];
        }
        $cp_sum_chart='['.implode(",",$cp_sum).']';
        $cp_name_chart='["'.implode('","',$cp_name).'"]';
        //表格数据 产品名称-产品编号-产品分类-销量-销售额-平均单价
        $data_table='';
        foreach($cp_sum as $k=>$v)
        {
            $data_table.="<tr><td>".$cp_name_arr[$k]."</td><td>".($cp_json_info[$k]['zdy1']==''?'--':$cp_json_info[$k]['zdy1'])."</td><td>".($cpfl_name_arr[$cp_json_info[$k]['zdy6']]==''?'-':$cpfl_name_arr[$cp_json_info[$k]['zdy6']])."</td><td>".$cp_xiaoliang[$k]."</td><td>￥ ".number_format($v,2)."</td><td>￥ ".number_format(round(($v/$cp_xiaoliang[$k]),2),2)."</td></tr>";
        }
        //字段映射
        $this->assign("cpfl_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$cpfl_option):$cpfl_option));//产品分类下拉框
        $this->assign("bm_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$bm_option):$bm_option));//部门下拉框
        $this->assign("user_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$user_option):$user_option));//用户下拉框
        $this->assign("cp_sum_chart",$cp_sum_chart);//chart_value
        $this->assign("cp_name_chart",$cp_name_chart);//chart_name
        $this->assign("data_table",$data_table);//表格数据
        $this->assign("data_table_max_num",count($cp_sum));//表格数据
        $this->assign("sum_sum",number_format($sum_sum,2));//总销售额
        $this->assign("sum_xiaoliang",$sum_xiaoliang);//总销量
        $this->display();
    }
    //产品销售汇总表-按分类汇总
    public function chanpinxiaoshouhuizong2()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //今日、本周、本月、本季度、本年
        $timearr=parent::time_more();
        //产品分类查询
        $cpfl_option=$this->get_cpfl_option($fid);
        $cpfl_name_arr=$this->option_to_arr($cpfl_option);
        //部门列表查询
        $bm_option=$this->get_bm_option($fid);
        //所有用户查询
        $user_option=$this->get_user_option($fid);
        //获得用户的部门
        $user_bm=$this->get_user_bm($fid);
        //所有产品查询
        //cp_del字段：该产品是否已经被删除（0：未被删除；1：已删除）
        $cp_arr=parent::sel_more_data("crm_chanpin","cp_id,cp_data,cp_del","cp_yh='$fid'");
        $cp_option='';
        foreach($cp_arr as $v)
        {
            $cpname=json_decode($v['cp_data'],true);
            $cp_json_info[$v['cp_id']]=$cpname;
            $cp_name_arr[$v['cp_id']]=$cpname['zdy0'];
        }
        //所有合同查询 //合同zdy5:合同开始时间
        $ht_arr=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid'");
        foreach($ht_arr as $v)
        {
            $ht_json=json_decode($v['ht_data'],true);
            
            if($_GET['sx_1']!='')
            {
                //日周月季度
                if(strlen($_GET['sx_1'])==1)
                {
                    if($this->date_to_date($ht_json['zdy5'])<$timearr[$_GET['sx_1']][s]||$this->date_to_date($ht_json['zdy5'])>$timearr[$_GET['sx_1']][e])
                    {
                        continue;
                    }
                }
                else
                {
                    //自定义时间段
                    $zdytimearr=explode(',',$_GET['sx_1']);
                    if($this->date_to_date($ht_json['zdy5'])<$zdytimearr[0].' 00:00:00'||$this->date_to_date($ht_json['zdy5'])>$zdytimearr[1].' 23:59:59')
                    {
                        continue;
                    }
                }
            }
            if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
            {
                if($user_bm[$v['ht_fz']]!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            if($_GET['sx_4']!=''&&$_GET['sx_4']!='0')
            {
                if($v['ht_fz']!=$_GET['sx_4'])
                {
                    continue;
                }
            }
            $ht_dbtable_in_str[]=$v['ht_id'];
        }

        $ht_dbtable_in_str=implode("','",$ht_dbtable_in_str);
        $ht_dbtable_in_str="'".$ht_dbtable_in_str."'";
        
        //查询合同-产品||商机-产品 关联表
        $cp_info_arr=parent::sel_more_data("crm_cp_sj","cp_id,cp_num1,cp_zj,sj_id","cp_yh='$fid' and cp_mk='6' and sj_id in ($ht_dbtable_in_str) ");
        //图形数据
        foreach($cp_info_arr as $v)
        {
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($cp_json_info[$v['cp_id']]['zdy6']!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            $cp_sum[$cp_json_info[$v['cp_id']]['zdy6']]+=$v['cp_zj'];
            $cp_xiaoliang[$cp_json_info[$v['cp_id']]['zdy6']]+=$v['cp_num1'];
            $cp_name[$cp_json_info[$v['cp_id']]['zdy6']]=$cpfl_name_arr[$cp_json_info[$v['cp_id']]['zdy6']]==''?"已删除分类":$cpfl_name_arr[$cp_json_info[$v['cp_id']]['zdy6']];
            $sum_sum+=$v['cp_zj'];
            $sum_xiaoliang+=$v['cp_num1'];
        }
        $cp_sum_chart='['.implode(",",$cp_sum).']';
        $cp_name_chart='["'.implode('","',$cp_name).'"]';
        //表格数据 产品名称-产品编号-产品分类-销量-销售额-平均单价
        $data_table='';
        foreach($cp_sum as $k=>$v)
        {
          
            $data_table.="<tr>
                            <td>".($cpfl_name_arr[$k]==''?"已删除分类":$cpfl_name_arr[$k])."</td>
                            <td>".$cp_xiaoliang[$k]."</td>
                            <td>".number_format($v,2)."</td>
                        </tr>";
        }
        //字段映射
        $this->assign("cpfl_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$cpfl_option):$cpfl_option));//产品分类下拉框
        $this->assign("bm_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$bm_option):$bm_option));//部门下拉框
        $this->assign("user_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$user_option):$user_option));//用户下拉框
        $this->assign("cp_sum_chart",$cp_sum_chart);//chart_value
        $this->assign("cp_name_chart",$cp_name_chart);//chart_name
        $this->assign("data_table",$data_table);//表格数据
        $this->assign("data_table_max_num",count($cp_sum));//表格数据
        $this->assign("sum_sum",number_format($sum_sum,2));//总销售额
        $this->assign("sum_xiaoliang",$sum_xiaoliang);//总销量
        $this->display();
    }
    //产品销售汇总表-按时间汇总
    public function chanpinxiaoshouhuizong3()
    {
        parent::is_login();
        $fid=parent::get_fid();
        $now_year=$_GET['sx_1']?$_GET['sx_1']:date("Y",time());//今年
        $last_year=($now_year-1).'-12';
        //今日、本周、本月、本季度、本年
        $timearr=parent::time_more();
        //年份下拉框
        $year_option=$this->get_year_option($now_year);
        //产品分类查询
        $cpfl_option=$this->get_cpfl_option($fid);
        $cpfl_name_arr=$this->option_to_arr($cpfl_option);
        //部门列表查询
        $bm_option=$this->get_bm_option($fid);
        //所有用户查询
        $user_option=$this->get_user_option($fid);
        //获得用户的部门
        $user_bm=$this->get_user_bm($fid);
        //所有产品查询
        //cp_del字段：该产品是否已经被删除（0：未被删除；1：已删除）
        $cp_arr=parent::sel_more_data("crm_chanpin","cp_id,cp_data,cp_del","cp_yh='$fid'");
        foreach($cp_arr as $v)
        {
            $cpname=json_decode($v['cp_data'],true);
            $cp_json_info[$v['cp_id']]=$cpname;
            $cp_option.="<option value='".$v['cp_id']."'>".$cpname['zdy0']."</option>";
            $cp_name_arr[$v['cp_id']]=$cpname['zdy0'];
        }
        //所有合同查询 //合同zdy5:合同开始时间
        $ht_arr=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid'");
        
        foreach($ht_arr as $v)
        {
            $ht_json=json_decode($v['ht_data'],true);
            if(substr($this->date_to_date($ht_json['zdy5']),0,7)==$last_year)
            {
                $last_year_last_m_ht[$v['ht_id']]=1;
                $ht_dbtable_in_str[]=$v['ht_id'];
            }
            $ht_date_arr=explode('-',$this->date_to_date($ht_json['zdy5']));
            if($ht_date_arr[0]!=$now_year)
            {
                continue;
            }
            $ht_month_arr[$v['ht_id']]=substr($ht_date_arr[1],0,1)=='0'?substr($ht_date_arr[1],1):$ht_date_arr[1];

            
            if($_GET['sx_4']!=''&&$_GET['sx_4']!='0')
            {
                if($user_bm[$v['ht_fz']]!=$_GET['sx_4'])
                {
                    continue;
                }
            }
            if($_GET['sx_5']!=''&&$_GET['sx_5']!='0')
            {
                if($v['ht_fz']!=$_GET['sx_5'])
                {
                    continue;
                }
            }
            $ht_dbtable_in_str[]=$v['ht_id'];
        }
        $ht_dbtable_in_str=implode("','",$ht_dbtable_in_str);
        $ht_dbtable_in_str="'".$ht_dbtable_in_str."'";
        
        //查询合同-产品||商机-产品 关联表
        $cp_info_arr=parent::sel_more_data("crm_cp_sj","cp_id,cp_num1,cp_zj,sj_id","cp_yh='$fid' and cp_mk='6' and sj_id in ($ht_dbtable_in_str) ");
        //parent::rr($cp_info_arr);
        //图形数据
        $cp_sum=array(
            '1'=>0,
            '2'=>0,
            '3'=>0,
            '4'=>0,
            '5'=>0,
            '6'=>0,
            '7'=>0,
            '8'=>0,
            '9'=>0,
            '10'=>0,
            '11'=>0,
            '12'=>0
        );
        $cp_name=array(
            '1'=>"1月",
            '2'=>"2月",
            '3'=>"3月",
            '4'=>"4月",
            '5'=>"5月",
            '6'=>"6月",
            '7'=>"7月",
            '8'=>"8月",
            '9'=>"9月",
            '10'=>"10月",
            '11'=>"11月",
            '12'=>"12月"
        );
        $next_year_last_m_sum=0;//上一年最后一个月的销售额，用于计算环比增长
        foreach($cp_info_arr as $v)
        {
            if($last_year_last_m_ht[$v['sj_id']]==1)
            {
                $next_year_last_m_sum+=$v['cp_zj'];
                continue;
            }
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($cp_json_info[$v['cp_id']]['zdy6']!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
            {
                if($v['cp_id']!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            $cp_sum[$ht_month_arr[$v['sj_id']]]+=$v['cp_zj'];
            $cp_xiaoliang[$ht_month_arr[$v['sj_id']]]+=$v['cp_num1'];
            $sum_sum+=$v['cp_zj'];
            $sum_xiaoliang+=$v['cp_num1'];
        }
        $cp_sum_chart='['.implode(",",$cp_sum).']';
        $cp_name_chart='["'.implode('","',$cp_name).'"]';
        //表格数据 产品名称-产品编号-产品分类-销量-销售额-平均单价
        $data_table='';
        foreach($cp_sum as $k=>$v)
        {
            $hb=$this->get_hb($next_year_last_m_sum,$v);
            $data_table.="<tr>
                            <td>".$cp_name[$k]."</td>
                            <td>".($cp_xiaoliang[$k]==''?'0':$cp_xiaoliang[$k])."</td>
                            <td>￥".number_format($v,2)."</td>
                            <td>".$hb."</td>
                        </tr>";
            $next_year_last_m_sum=$v;
        }
        //字段映射
        //产品分类下拉框
        $this->assign("cpfl_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$cpfl_option):$cpfl_option));
        //年份下拉框
        $this->assign("year_option",$year_option);
        //产品下拉框
        $this->assign("cp_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$cp_option):$cp_option));
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_5']?str_replace("value='".$_GET['sx_5']."'","value='".$_GET['sx_5']."' selected ",$user_option):$user_option));
        
        $this->assign("cp_sum_chart",$cp_sum_chart);//chart_value
        $this->assign("cp_name_chart",$cp_name_chart);//chart_name
        $this->assign("data_table",$data_table);//表格数据
        $this->assign("data_table_max_num",count($cp_sum));//表格数据
        $this->assign("sum_sum",number_format($sum_sum,2));//总销售额
        $this->assign("sum_xiaoliang",$sum_xiaoliang);//总销量
        $this->display();
    }
    //合同汇总报表
    public function hetonghuizong()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //当前年度
        $now_year=$_GET['sx_1']==''?date("Y",time()):$_GET['sx_1'];
        $last_year=$now_year-1;//上一年

        //年份下拉框
        $year_option=$this->get_year_option($now_year);
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //用户下拉框
        $user_option=$this->get_user_option($fid);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        //获取合同类型参数,构造合同类型筛选栏
        $ht_cs_arr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='6'");
        $ht_cs_json_arr=json_decode($ht_cs_arr[0]['ywcs_data'],true);
        $ht_type_arr=array();
        $ht_type_span='';
        foreach($ht_cs_json_arr as $v)
        {
            if($v['id']=='zdy10')
            {
                foreach($v as $kk=>$vv)
                {
                    if(substr($kk,0,6)!='canshu')
                    {
                        continue;
                    }
                    if($v['qy'][$kk]!=1)
                    {
                        continue;
                    }
                    $ht_type_arr[$kk]=$vv;
                    $ht_type_span.='<span class="sx_xx" lang="'.$kk.'">'.$vv.'</span>';
                }
            }
        }

        //查询合同
        //初始化合同数量
        $ht_num=array(
            '1'=>0,
            '2'=>0,
            '3'=>0,
            '4'=>0,
            '5'=>0,
            '6'=>0,
            '7'=>0,
            '8'=>0,
            '9'=>0,
            '10'=>0,
            '11'=>0,
            '12'=>0
        );
        //初始化合同金额
        $ht_sum=$ht_num;
        //总金额、数量
        $ht_zong_sum=0;
        $ht_zong_num=0;
        $ht_arr=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid'");
        
        foreach($ht_arr as $v)
        {
            $ht_json=json_decode($v['ht_data'],true);
            //parent::rr($ht_json);
            //上一年最后一个月的合同信息
            if($last_year.'-12'==substr($this->date_to_date($ht_json['zdy5']),0,7))
            {
                $last_y_m_sum+=$ht_json['zdy3'];
                $last_y_m_num++;
            }
            //确保是选择年份的合同
            $ht_date_arr=explode('-',$this->date_to_date($ht_json['zdy5']));
            if($ht_date_arr[0]!=$now_year)
            {
                continue;
            }
            if($_GET['sx_2']!='0'&&$_GET['sx_2']!='')
            {
                if($ht_json['zdy10']!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            if($_GET['sx_3']!='0'&&$_GET['sx_3']!='')
            {
                if($user_bm[$v['ht_fz']]!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            if($_GET['sx_4']!='0'&&$_GET['sx_4']!='')
            {
                if($v['ht_fz']!=$_GET['sx_4'])
                {
                    continue;
                }
            }
            //月份去0
            $this_ht_m=substr($ht_date_arr[1],0,1)==0?substr($ht_date_arr[1],1):$ht_date_arr[1];
            $ht_sum[$this_ht_m]+=$ht_json['zdy3'];//每月合同金额
            $ht_num[$this_ht_m]++;//合同数量
            //总金额/数量
            $ht_zong_sum+=$ht_json['zdy3'];
            $ht_zong_num++;
        }
        $data_table='';
        foreach($ht_sum as $k=>$v)
        {
            $hb_num=$this->get_hb($last_y_m_num,$ht_num[$k]);
            $hb_sum=$this->get_hb($last_y_m_sum,$v);
            $last_y_m_num=$ht_num[$k];
            $last_y_m_sum=$v;
            $data_table.="<tr>
                            <td>".$k."月</td>
                            <td>".$ht_num[$k]."</td>
                            <td>".$hb_num."</td>
                            <td>".$v."</td>
                            <td>".$hb_sum."</td>
                            <td>".number_format($v/$ht_num[$k],2)."</td>
                        </tr>";
        }
        //parent::rr($ht_num);
        $ht_sum_chart='["'.implode('","',$ht_sum).'"]';
        $ht_num_chart='["'.implode('","',$ht_num).'"]';
        $this->assign("year_option",$year_option);//年份下拉框
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$user_option):$user_option));
        $this->assign('ht_type_span',$ht_type_span);//合同类型的选择框
        $this->assign('ht_sum_chart',$ht_sum_chart);//合同数量的图形数据
        $this->assign('ht_num_chart',$ht_num_chart);//合同金额的图形数据
        $this->assign('ht_zong_sum',number_format($ht_zong_sum,2));//总金额
        $this->assign('ht_zong_num',$ht_zong_num);//总数量
        $this->assign('data_table',$data_table);//表格的数据
        $this->display();
    }
    //获得部门下拉内容
    public function get_bm_option($fid)
    {
        $bm_arr=parent::sel_more_data("crm_department","bm_id,bm_name","bm_company='$fid'");
        foreach($bm_arr as $v)
        {
            $bm_option.="<option value='".$v['bm_id']."'>".$v['bm_name']."</option>";
        }
        return $bm_option;
    }
    //获得用户下拉框内容
    public function get_user_option($fid)
    {
        $user_arr=parent::sel_more_data("crm_user","user_id,user_name","user_del='0' and (user_fid='$fid' or user_id='$fid')");
        foreach($user_arr as $v)
        {
            $user_option.="<option value='".$v['user_id']."'>".$v['user_name']."</option>";
        }
        return $user_option;
    }
    //获得用户的部门
    public function get_user_bm($fid)
    {
        $user_arr=parent::sel_more_data("crm_user","user_id,user_zhu_bid","user_del='0' and (user_fid='$fid' or user_id='$fid')");
        foreach($user_arr as $v)
        {
            $user_bm[$v['user_id']]=$v['user_zhu_bid'];
        }
        return $user_bm;
    }
    //获得产品分类下拉框内容
    public function get_cpfl_option($fid)
    {
        $cpfl_arr=parent::sel_more_data("crm_chanpinfenlei"," cpfl_id,cpfl_name "," cpfl_company='$fid' ");
        //echo "<pre>";print_r($cpfl_arr);die;
        foreach($cpfl_arr as $v)
        {
            $cpfl_option.="<option value='".$v['cpfl_id']."'>".$v['cpfl_name']."</option>";
        }
        return $cpfl_option;
    }
    //获得前三年+当前年+后一年的option
    public function get_year_option($now_year)
    {
        $year_option='';
        $now_year2=$now_year;
        $now_year=date("Y",time());
        for($a=($now_year-3);$a<=($now_year+1);$a++)
        {
            $is_sel=$a==$now_year2?"selected":'';
            $year_option.="<option value='".$a."' $is_sel>".$a."</option>";
        }
        return $year_option;
    }
    //将返回的下拉框处理成数组格式，优化重复查数据库的问题
    public function option_to_arr($op)
    {
        $c=explode("</option><option value='",$op);
        foreach($c as $v)
        {
            $d=str_replace("<option value='",'',$v);
            $d=str_replace("</option>",'',$d);
            $d=explode("'>",$d);
            $arr[$d[0]]=$d[1];
        }
        return $arr;
    }
    //合同时间的处理方法
    public function date_to_date($str)
    {
        $s=explode(' ',$str);
        $e=explode('-',$s[0]);
        if($e[1]<10&&strlen($e[1])==1)
        {
            $e[1]='0'.$e[1];
        }
        if($e[2]<10&&strlen($e[2])==1)
        {
            $e[2]='0'.$e[2];
        }
        return implode('-',$e);
    }
    //计算环比增长
    public function get_hb($lastval,$nowval)
    {
        //if($lastval<=0||$nowval<=0)
        if($lastval<=0)
        {
            return '--';
        }
        $hb=0;
        $cha=$nowval-$lastval;
        $b=$cha/$lastval;
        $b=round(($b*100));
        $hb=$b;
        return $hb.'%';
    }
}