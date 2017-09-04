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
    //赢单商机汇总报表
    public function yingdanshangjihuizong()
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

        //赢单金额
        $yj_sum=array(
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
        //赢单数
        $yj_num=$yj_sum;
        //总金额、数量
        $yj_zong_sum=0;
        $yj_zong_num=0;
        //上一年最后一个月的数量和金额
        $last_y_m_sum=0;
        $last_y_m_num=0;

        $sj_arr=parent::sel_more_data("crm_shangji","sj_id,sj_data,sj_fz","sj_yh='$fid'");
        foreach($sj_arr as $v)
        {
            
            //金额zdy3,日期zdy4
            $sj_json=json_decode($v['sj_data'],true);
            
            //排除不是已经赢单的商机
            if($sj_json['zdy5']!='canshu5')
            {
                continue;
            }
            if($last_year.'-12'==substr($this->date_to_date($sj_json['zdy4']),0,7))
            {
                $last_y_m_sum+=$sj_json['zdy3'];
                $last_y_m_num++;
            }
            
            //确保是选择年份的商机
            $sj_date_arr=explode('-',$this->date_to_date($sj_json['zdy4']));
            if($sj_date_arr[0]!=$now_year)
            {
                continue;
            }
            if($_GET['sx_2']!='0'&&$_GET['sx_2']!='')
            {
                if($user_bm[$v['sj_fz']]!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            if($_GET['sx_3']!='0'&&$_GET['sx_3']!='')
            {
                if($v['sj_fz']!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            //月份去0
            $this_sj_m=substr($sj_date_arr[1],0,1)==0?substr($sj_date_arr[1],1):$sj_date_arr[1];

            $yj_sum[$this_sj_m]+=$sj_json['zdy3'];//每个月的金额数组
            $yj_num[$this_sj_m]++;//每个月的数量数组

            //总金额、数量
            $yj_zong_sum+=$sj_json['zdy3'];
            $yj_zong_num++;

        }
        
        //图形数据
        $sj_sum_chart='["'.implode('","',$yj_sum).'"]';
        $sj_num_chart='["'.implode('","',$yj_num).'"]';

        //表格数据
        $data_table='';
        foreach($yj_sum as $k=>$v)
        {
            $hb_num=$this->get_hb($last_y_m_num,$yj_num[$k]);
            $hb_sum=$this->get_hb($last_y_m_sum,$v);
            $last_y_m_num=$yj_num[$k];
            $last_y_m_sum=$v;
            $data_table.="<tr>
                            <td>".$k."月</td>
                            <td>".$yj_num[$k]."</td>
                            <td>".$hb_num."</td>
                            <td>￥".number_format($v,2)."</td>
                            <td>".$hb_sum."</td>
                            <td>￥".number_format(($v/$yj_num[$k]),2)."</td>
                        </tr>";
        }

        //年份下拉框
        $this->assign("year_option",$year_option);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //负责人下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        //图形数据
        $this->assign("sj_sum_chart",$sj_sum_chart);
        $this->assign("sj_num_chart",$sj_num_chart);
        //表格数据
        $this->assign("data_table",$data_table);
        $this->display();
    }
    //客户类型统计报表
    public function kehuleixingtongji()
    {
        parent::is_login();
        $fid=parent::get_fid();

        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //用户下拉框
        $user_option=$this->get_user_option($fid);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);

        //获得跟进状态字段
        $cs_arr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='2'");
        $cs_json=json_decode($cs_arr[0]['ywcs_data'],true);
        $genjinzhuangtai=array();
        $genjinzhuangtai_span='';
        foreach($cs_json as $v)
        {
            if($v['id']=='zdy9')
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
                    $genjinzhuangtai[$kk]=$vv;
                    $genjinzhuangtai_span.="<span class='sx_xx' lang='$kk'>$vv</span>";
                }
            }
            if($v['id']=='zdy1')
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
                    $chart['name'][$kk]=$vv;
                    $chart['num'][$kk]=0;
                }
            }
        }
        
        //查询客户表
        $kh_arr=parent::sel_more_data("crm_kh","kh_id,kh_data,kh_fz","kh_yh='$fid'");
        $zong=0;
        foreach($kh_arr as $v)
        {
            $kh_json=json_decode($v['kh_data'],true);
            //zdy1客户类型、zdy9跟进状态
            if($kh_json['zdy1']==''||substr($kh_json['zdy1'],0,6)!='canshu')
            {
                continue;
            }
            if($_GET['sx_1']!=''&&$_GET['sx_1']!='0')
            {
                if($kh_json['zdy9']!=$_GET['sx_1'])
                {
                    continue;
                }
            }
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($user_bm[$v['kh_fz']]!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
            {
                if($v['kh_fz']!=$_GET['sx_3'])
                {
                    continue;
                }
            }
            $chart['num'][$kh_json['zdy1']]++;
            $zong++;
        }
        $chart_title='["'.implode('","',$chart['name']).'"]';
        $chart_val='["'.implode('","',$chart['num']).'"]';

        //模板数据
        $data_table='';
        foreach($chart['num'] as $k=>$v)
        {
            $data_table.="<tr>
                            <td>".$chart['name'][$k]."</td>
                            <td>".$chart['num'][$k]."</td>
                        </tr>";
        }

        //变量
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        $this->assign("chart_title",$chart_title);
        $this->assign("chart_val",$chart_val);
        $this->assign("zong",$zong);
        $this->assign("data_table",$data_table);
        $this->assign("genjinzhuangtai_span",$genjinzhuangtai_span);;
        $this->display();
    }
    //客户数量排名报表
    public function kehushuliangpaiming()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        $montharr=$this->get_last_month();

        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        $get_stime=0;
        $get_etime=0;
        if($_GET['sx_3'])
        {
            $sx_3=addslashes($_GET['sx_3']);
            $get_time_arr=explode(",",$_GET['sx_3']);
            $get_stime=$get_time_arr[0];
            $get_etime=$get_time_arr[1];
        }
        //时间筛选
        $montharr['s']=$get_stime?$get_stime:$montharr['s'];
        $montharr['e']=$get_etime?$get_etime:$montharr['e'];

        $times=strtotime($montharr['s'].' 00:00:00');
        $timee=strtotime($montharr['e'].' 23:59:59');

        //查询公司用户
        $user_arr=parent::sel_more_data("crm_user","user_id,user_name,user_zhu_bid","user_id='$fid' or user_fid='$fid'");
        foreach($user_arr as $v)
        {
            $user_name_arr[$v['user_id']]['name']=$v['user_name'];
            $user_name_arr[$v['user_id']]['bm']=$user_bm[$v['user_zhu_bid']];

        }

        //查询客户
        $kh_arr=parent::sel_more_data("crm_kh","kh_fz","kh_yh='$fid' and kh_cj_date>='".$times."' and kh_cj_date<='".$timee."' ");

        //根据负责人对客户进行分类
        foreach($kh_arr as $v)
        {
            if($_GET['sx_1']!='0'&&$_GET['sx_1']!='')
            {
                if($user_name_arr[$v['kh_fz']]['bm']!=$_GET['sx_1'])
                {
                    continue;
                }
            }
            $user_kh[$v['kh_fz']]++;
        }
        

        //对每个人的客户数量进行排序
        $dx='';
        if($_GET['sx_2']=='1')
        {
            //升序
            asort($user_kh);
            $dx='selected';
        }
        else
        {
            //降序
            arsort($user_kh);
        }

        
        //表格数据
        $data_table='';
        $paiming=1;
        $zong=0;
        foreach($user_kh as $k=>$v)
        {
            if($user_name_arr[$k]['name']=='')
            {
                continue;
            }
            $data_table.="<tr>
                            <td>".$paiming."</td>
                            <td>".$user_name_arr[$k]['name']."</td>
                            <td>".($user_name_arr[$k]['bm']==''?'未分配部门':$user_name_arr[$k]['bm'])."</td>
                            <td>".$v."</td>
                        </tr>";
            $zong+=$v;
            $paiming++;
        }
        
        

        $this->assign("dx",$dx);
        $this->assign("zong",$zong);
        $this->assign("data_table",$data_table);
        $this->assign("data_table_num",count($user_kh));
        $this->assign("st",$montharr['s']);
        $this->assign("et",$montharr['e']);
        $this->assign("bm_option",$bm_option);
        $this->assign("bm_option",($_GET['sx_1']?str_replace("value='".$_GET['sx_1']."'","value='".$_GET['sx_1']."' selected ",$bm_option):$bm_option));
        $this->display();
    }
    //客户数量排名报表
    public function kehushuliangpaiming2()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        $montharr=$this->get_last_month();

        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        $bm_arr=$this->option_to_arr($bm_option);

        $get_stime=0;
        $get_etime=0;
        if($_GET['sx_3'])
        {
            $sx_3=addslashes($_GET['sx_3']);
            $get_time_arr=explode(",",$_GET['sx_3']);
            $get_stime=$get_time_arr[0];
            $get_etime=$get_time_arr[1];
        }
        //时间筛选
        $montharr['s']=$get_stime?$get_stime:$montharr['s'];
        $montharr['e']=$get_etime?$get_etime:$montharr['e'];

        $times=strtotime($montharr['s'].' 00:00:00');
        $timee=strtotime($montharr['e'].' 23:59:59');

        //查询公司用户
        $user_arr=parent::sel_more_data("crm_user","user_id,user_name,user_zhu_bid","user_id='$fid' or user_fid='$fid'");
        foreach($user_arr as $v)
        {
            $user_name_arr[$v['user_id']]['bm']=$user_bm[$v['user_zhu_bid']];

        }

        //查询客户
        $kh_arr=parent::sel_more_data("crm_kh","kh_fz","kh_yh='$fid' and kh_cj_date>='".$times."' and kh_cj_date<='".$timee."' ");

        //根据负责人对客户进行分类
        foreach($kh_arr as $v)
        {
            if($_GET['sx_1']!='0'&&$_GET['sx_1']!='')
            {
                if($user_name_arr[$v['kh_fz']]['bm']!=$_GET['sx_1'])
                {
                    continue;
                }
            }
            $bm=$user_name_arr[$v['kh_fz']]['bm']==''?'no':$user_name_arr[$v['kh_fz']]['bm'];
            $user_kh[$bm]++;
        }
        

        //对每个人的客户数量进行排序
        $dx='';
        if($_GET['sx_2']=='1')
        {
            //升序
            asort($user_kh);
            $dx='selected';
        }
        else
        {
            //降序
            arsort($user_kh);
        }

        
        //表格数据
        $data_table='';
        $paiming=1;
        $zong=0;
        foreach($user_kh as $k=>$v)
        {
            $bmname=$k=='no'?'未分配部门':$bm_arr[$k];
            $data_table.="<tr>
                            <td>".$paiming."</td>
                            <td>".$bmname."</td>
                            <td>".$v."</td>
                        </tr>";
            $zong+=$v;
            $paiming++;
        }
        
        

        $this->assign("dx",$dx);
        $this->assign("zong",$zong);
        $this->assign("data_table",$data_table);
        $this->assign("data_table_num",count($user_kh));
        $this->assign("st",$montharr['s']);
        $this->assign("et",$montharr['e']);
        $this->assign("bm_option",$bm_option);
        $this->assign("bm_option",($_GET['sx_1']?str_replace("value='".$_GET['sx_1']."'","value='".$_GET['sx_1']."' selected ",$bm_option):$bm_option));
        $this->display();
    }
    //销售额排名报表-合同金额
    public function xiaoshouepaiming()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //部门名称
        $bm_name=$this->option_to_arr($bm_option);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        //用户id ->用户名
        $user_id_name=$this->get_user_id_name($fid);
        //查询合同
        $ht_arr=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid'");
        //日期
        $datearr=$this->get_now_month();
        if($_GET['sx_1']!='')
        {
            $getdatearr=explode(',',addslashes($_GET['sx_1']));
        }
        $datearr['s']=$getdatearr[0]?$getdatearr[0]:$datearr['s'];
        $datearr['e']=$getdatearr[1]?$getdatearr[1]:$datearr['e'];


        $user_ht_num=array();
        foreach($ht_arr as $v)
        {
            
            //合同金额：zdy3 ,合同开始时间：zdy5
            $ht_json=json_decode($v['ht_data'],true);
            if($this->date_to_date($ht_json['zdy5'])<$datearr['s']||$this->date_to_date($ht_json['zdy5'])>$datearr['e'])
            {
                continue;
            }
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($user_bm[$v['ht_fz']]!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            $user_ht_num[$v['ht_fz']]+=$ht_json['zdy3'];
        }
        //降序操作
        arsort($user_ht_num);

        //图形数据&表格数据
        $data_table='';
        $paiming=1;
        $zong=0;
        $chart_name='';
        $chart_val='';
        $suofang='';
        $data_table_num=count($user_ht_num);
        if($data_table_num>15)
        {
            $suofang="dataZoom: [
                    {   // 这个dataZoom组件，默认控制x轴。
                        type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                        start: 0,      // 左边在 10% 的位置。
                        end: 60         // 右边在 60% 的位置。
                    },
                    {   // 这个dataZoom组件，默认控制x轴。
                        type: 'inside', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                        start: 0,      // 左边在 10% 的位置。
                        end: 60         // 右边在 60% 的位置。
                    }
                ],";
        }
        foreach($user_ht_num as $k=>$v)
        {
            $data_table.="<tr>
                            <td>".$paiming."</td>
                            <td>".$user_id_name[$k]."</td>
                            <td>".$bm_name[$user_bm[$k]]."</td>
                            <td>￥".number_format($v,2)."</td>
                        </tr>";
            $chart_name.=$user_id_name[$k].'","';
            $chart_val.=$v.'","';
            $zong+=$v;
            $paiming++;
        }
        $chart_name='["'.substr($chart_name,0,-3).'"]';
        $chart_val='["'.substr($chart_val,0,-3).'"]';


        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        $this->assign("zong",number_format($zong,2));
        $this->assign("st",$datearr['s']);
        $this->assign("et",$datearr['e']);
        $this->assign("suofang",$suofang);
        $this->assign("data_table",$data_table);
        $this->assign("data_table_num",$data_table_num);
        $this->assign("chart_name",$chart_name);
        $this->assign("chart_val",$chart_val);
        $this->display();
    }
    //销售额排名-赢单商机金额
    public function xiaoshouepaiming2()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //部门名称
        $bm_name=$this->option_to_arr($bm_option);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        //用户id ->用户名
        $user_id_name=$this->get_user_id_name($fid);
        //zdy3
        //日期
        $datearr=$this->get_now_month();
        if($_GET['sx_1']!='')
        {
            $getdatearr=explode(',',addslashes($_GET['sx_1']));
        }
        $datearr['s']=$getdatearr[0]?$getdatearr[0]:$datearr['s'];
        $datearr['e']=$getdatearr[1]?$getdatearr[1]:$datearr['e'];

        //查询商机
        $sj_arr=parent::sel_more_data("crm_shangji","sj_data,sj_fz","sj_yh='$fid'");
        
        $sj_user_data=array();
        foreach($sj_arr as $v)
        {
            $sj_json=json_decode($v['sj_data'],true);
            if($sj_json['zdy5']==''||$sj_json['zdy5']!='canshu5')
            {
                continue;
            }
            if($this->date_to_date($sj_json['zdy4'])<$datearr['s']||$this->date_to_date($sj_json['zdy4'])>$datearr['e'])
            {
                continue;
            }
            if($_GET['sx_2']!=0&&$_GET['sx_2']!='')
            {
                if($user_bm[$v['sj_fz']]!=$_GET['sx_2'])
                {
                    continue;
                }
            }
            $sj_user_data[$v['sj_fz']]+=$sj_json['zdy3'];
            
        }
        //降序
        arsort($sj_user_data);

        $data_table='';
        $paiming=1;
        $zong=0;
        $data_table_num=count($sj_user_data);
        if($data_table_num>15)
        {
            $suofang="dataZoom: [
                    {   // 这个dataZoom组件，默认控制x轴。
                        type: 'slider', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                        start: 0,      // 左边在 10% 的位置。
                        end: 60         // 右边在 60% 的位置。
                    },
                    {   // 这个dataZoom组件，默认控制x轴。
                        type: 'inside', // 这个 dataZoom 组件是 slider 型 dataZoom 组件
                        start: 0,      // 左边在 10% 的位置。
                        end: 60         // 右边在 60% 的位置。
                    }
                ],";
        }
        foreach($sj_user_data as $k=>$v)
        {
            $data_table.="<tr>
                            <td>".$paiming."</td>
                            <td>".$user_id_name[$k]."</td>
                            <td>".$bm_name[$user_bm[$k]]."</td>
                            <td>￥".number_format($v,2)."</td>
                        </tr>";
            $chart_name.=$user_id_name[$k].'","';
            $chart_val.=$v.'","';
            $zong+=$v;
            $paiming++;
        }
        $chart_name='["'.substr($chart_name,0,-3).'"]';
        $chart_val='["'.substr($chart_val,0,-3).'"]';


        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        $this->assign("zong",number_format($zong,2));
        $this->assign("st",$datearr['s']);
        $this->assign("et",$datearr['e']);
        $this->assign("suofang",$suofang);
        $this->assign("data_table",$data_table);
        $this->assign("data_table_num",$data_table_num);
        $this->assign("chart_name",$chart_name);
        $this->assign("chart_val",$chart_val);
        $this->display();
    }
    //销售漏斗报表
    public function xiaoshouloudou()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //用户下拉框
        $user_option=$this->get_user_option($fid);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        //本周本月本季度本年时间获取
        $time_more=parent::time_more();
        //排序
        $pxarr=parent::sel_more_data("crm_paixu","px_px","px_yh='$fid' and px_mod='52'");
        $pxarr=explode(',',$pxarr[0]['px_px']);

        //销售阶段字段参数查询
        $cs_arr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='5'");
        $cs_arr=json_decode($cs_arr[0]['ywcs_data'],true);
        foreach($cs_arr[1] as $k=>$v)
        {
            if(substr($k,0,6)!='canshu')
            {
                continue;
            }
            if($cs_arr[1]['qy'][$k]!=1)
            {
                continue;
            }
            $cs_name[$k]=$v;
        }
        $cs_knx=$cs_arr[1]['knx'];
        //商机查询
        $fz_where='';
        if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
        {
            $fz_where="and sj_fz='".$_GET['sx_3']."'";
        }
        $sj_arr=parent::sel_more_data("crm_shangji","sj_data,sj_fz,sj_qiandan","sj_yh='$fid' $fz_where ");
        foreach($sj_arr as $v)
        {
            if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
            {
                if($_GET['sx_2']!=$user_bm[$v['sj_fz']])
                {
                    continue;
                }
            }
            $sj_json=json_decode($v['sj_data'],true);
            
            //预计销售金额 zdy3   预计签单日期 zdy4   销售阶段zdy5
            if($sj_json['zdy5']=='')
            {
                continue;
            }
            if($_GET['sx_1']!='0'&&$_GET['sx_1']!='')
            {
                $yjqdrq=$this->date_to_date($sj_json['zdy4']);
                if(strlen($_GET['sx_1'])==1)
                {
                    $time_index=$_GET['sx_1']+1;
                    if($yjqdrq<$time_more[$time_index]['s']||$yjqdrq>$time_more[$time_index]['e'])
                    {
                        continue;
                    }
                }
                else
                {
                    $sx_1_arr=explode($_GET['sx_1']);
                    if($yjqdrq<$sx_1_arr[0]||yjqdrq>$sx_1_arr[1])
                    {
                        continue;
                    }
                }
            }
            $sj_num[$sj_json['zdy5']]++;
            $sj_sum[$sj_json['zdy5']]+=$sj_json['zdy3'];
        }
        
        //遍历排序数组，按照排序来
        $data_table='';
        $zong_num=0;
        $zong_sum=0;
        $zong_sum_g=0;
        foreach($pxarr as $v)
        {
            $sjs=$sj_num[$v]==''?'0':$sj_num[$v];
            $gailv=$sj_sum[$v]==''?'0':($sj_sum[$v]*($cs_knx[$v]/100));
            $data_table.="<tr>
                            <td>".$cs_name[$v]."</td>
                            <td>".($sj_num[$v]==''?'0':$sj_num[$v])."</td>
                            <td>￥".number_format(($sj_sum[$v]==''?0:$sj_sum[$v]),2)."</td>
                            <td>￥".number_format($gailv,2)."</td>
                        </tr>";
            $zong_num+=$sj_num[$v];
            $zong_sum+=$sj_sum[$v];
            $zong_sum_g+=$gailv;
            $chart.="['".$cs_name[$v]."',".($sj_sum[$v]==''?0:$sj_sum[$v])."],";
        }
        $chart=substr($chart,0,-1);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //部门下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        $this->assign("zong_num",$zong_num);
        $this->assign("zong_sum",number_format($zong_sum,2));
        $this->assign("zong_sum_g",number_format($zong_sum_g,2));
        $this->assign("data_table",$data_table);
        $this->assign("chart",$chart);
        $this->display();
    }
    //销售预测报表
    public function xiaoshouyuce()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //用户下拉框
        $user_option=$this->get_user_option($fid);
        //获取每个用户对应着的部门
        $user_bm=$this->get_user_bm($fid);
        //获取最近的三个月
        $m=date("Y-m",time());
        $now_month=date("m",time())<10?substr(date("m",time()),1,1):date("m",time());
        $m3[$now_month]=date("Y年m月",time());
        $m3[$now_month+1]=date("Y年m月",strtotime($m.' +1 month'));
        $m3[$now_month+2]=date("Y年m月",strtotime($m.' +2 month'));

        //销售阶段字段参数查询
        $cs_arr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='5'");
        $cs_arr=json_decode($cs_arr[0]['ywcs_data'],true);
        $cs_knx=$cs_arr[1]['knx'];
        //查询商机表
        $fz_where='';
        if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
        {
            $fz_where="and sj_fz='".$_GET['sx_2']."'";
        }
        $sj_arr=parent::sel_more_data("crm_shangji","sj_data,sj_fz,sj_qiandan","sj_yh='$fid' $fz_where ");
        //预计销售金额 zdy3   预计签单日期 zdy4   销售阶段zdy5
        foreach($sj_arr as $v)
        {
            $sj_json=json_decode($v['sj_data'],true);
            if($sj_json['zdy4']=='')
            {
                continue;
            }
            if($_GET['sx_1']!=''&&$_GET['sx_1']!='0')
            {
                if($_GET['sx_1']!=$user_bm[$v['sj_fz']])
                {
                    continue;
                }
            }
            $sjdate=$this->date_to_date($sj_json['zdy4']);//预计销售日期
            $sjm=explode('-',$sjdate);
            $sjm=$sjm[1]<10?substr($sjm[1],1,1):$sjm[1];
            if(substr($sjdate,0,7)!=$m&&substr($sjdate,0,7)!=date("Y-m",strtotime($m.' +1 month'))&&substr($sjdate,0,7)!=date("Y-m",strtotime($m.' +2 month')))
            {
                continue;
            }
            $sj_data[$sjm]['yuji']+=$sj_json['zdy3'];
            $sj_data[$sjm]['num']++;
            //预计销售金额、销售阶段、销售阶段的签单可能性之中如果有一条为空，就不计算概率金额
            if($sj_json['zdy3']==''||$sj_json['zdy5']==''||$cs_knx[$sj_json['zdy5']]=='')
            {
                $sj_data[$sjm]['gailv']+=0;
            }
            else
            {
                //概率金额=预计签单金额*签单可能性
                $gl=($sj_json['zdy3']*$cs_knx[$sj_json['zdy5']])/100;
                $sj_data[$sjm]['gailv']+=$gl;
            }
        }

        $data_table='';
        $zong_num=0;
        $zong_sum=0;
        $zong_sum_gl=0;
        $chart_sum='';
        $chart_sum_gl='';
        $chart_num='';
        foreach($m3 as $k=>$v)
        {
            $data_table.="<tr>
                            <td>".$v."</td>
                            <td>".($sj_data[$k]['num']==''?'0':$sj_data[$k]['num'])."</td>
                            <td>￥".number_format(($sj_data[$k]['yuji']==''?'0':$sj_data[$k]['yuji']),2)."</td>
                            <td>￥".number_format(($sj_data[$k]['gailv']==''?'0':$sj_data[$k]['gailv']),2)."</td>
                        </tr>";
            
            $chart_time.=$v.'","';
            $chart_sum.=($sj_data[$k]['yuji']==''?'0':$sj_data[$k]['yuji']).'","';
            $chart_sum_gl.=($sj_data[$k]['gailv']==''?'0':$sj_data[$k]['gailv']).'","';
            $chart_num.=($sj_data[$k]['num']==''?'0':$sj_data[$k]['num']).'","';

            $zong_num+=$sj_data[$k]['num'];
            $zong_sum+=$sj_data[$k]['yuji'];
            $zong_sum_gl=$sj_data[$k]['gailv'];
        }

        //部门下拉框
        $this->assign("bm_option",($_GET['sx_1']?str_replace("value='".$_GET['sx_1']."'","value='".$_GET['sx_1']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$user_option):$user_option));
        $this->assign("zong_num",$zong_num);
        $this->assign("zong_sum",$zong_sum);
        $this->assign("zong_sum_gl",$zong_sum_gl);

        $this->assign("chart_time",'["'.substr($chart_time,0,-3).'"]');
        $this->assign("chart_sum",'["'.substr($chart_sum,0,-3).'"]');
        $this->assign("chart_sum_gl",'["'.substr($chart_sum_gl,0,-3).'"]');
        $this->assign("chart_num",'["'.substr($chart_num,0,-3).'"]');

        $this->assign("data_table",$data_table);
        $this->display();
    }
    //业务新增汇总报表
    public function yewuxinzenghuizong()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //时间判断
        $tarr=parent::time_more();
        $tk='4';
        if($_GET['sx_1']!='')
        {
            $tk=$_GET['sx_1']=='3'?'6':$_GET['sx_1']+2;
        }
        $tarr=$tarr[$tk];
        //parent::rr($tarr);
        $s=strtotime($tarr['s']);
        $e=strtotime($tarr['e']);
        //sql语句之前判断get到的参数 ，进行sql语句条件拼接
        if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
        {
            $bmuser=$this->get_bm_user(addslashes($_GET['sx_2']));
            $bmuser="'".implode("','",$bmuser)."'";
            $sql_bm=" and rz_user in ($bmuser)";
        }
        if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
        {
            $sql_user=" and rz_user ='".addslashes($_GET['sx_3'])."'";
        }
        $rz=parent::sel_more_data("crm_rz","rz_mode,rz_time","rz_yh='$fid' and rz_cz_type='1' and rz_type='1' and rz_time>='$s' and rz_time<='$e' and rz_mode in ('1','2','5','6') $sql_bm $sql_user");
        //parent::rr("rz_yh='$fid' and rz_cz_type='1' and rz_type='1' and rz_time>='$s' and rz_time<='$e'");
        
        //图形数据处理
        //线索1客户2联系人4商机5合同6产品7
        $tableDataTimeType=$_GET['sx_1']==3?'Y-m':'Y-m-d';
        foreach($rz as $v)
        {
            $rz_data[$v['rz_mode']][date("Y-m-d",$v['rz_time'])]++;
            $topArr[$v['rz_mode']][]=1;
            $tableData[date($tableDataTimeType,$v['rz_time'])][$v['rz_mode']]++;
        }
        $nowMonthDaysNum=$tk=='3'?7:parent::get_day_num($s);
        $nowMonthDaysNum=$tk=='6'?parent::get_year_num($s):$nowMonthDaysNum;
        $startDay=date("Y-m-d",$s);
        for($a=0;$a<$nowMonthDaysNum;$a++)
        {
            $toAdd1=$rz_data[1][$startDay]==''?0:$rz_data[1][$startDay];
            $toAdd2=$rz_data[2][$startDay]==''?0:$rz_data[2][$startDay];
            $toAdd5=$rz_data[5][$startDay]==''?0:$rz_data[5][$startDay];
            $toAdd6=$rz_data[6][$startDay]==''?0:$rz_data[6][$startDay];
            $r[1][$startDay]+=$toAdd1;
            $r[2][$startDay]+=$toAdd2;
            $r[5][$startDay]+=$toAdd5;
            $r[6][$startDay]+=$toAdd6;
            $chartKey[]=$startDay;
            $startDay=date("Y-m-d",strtotime($startDay." +1 days"));
        }
        $topInfo[1]=count($topArr[1]);
        $topInfo[2]=count($topArr[2]);
        $topInfo[3]=count($topArr[5]);
        $topInfo[4]=count($topArr[6]);
        //表格数据处理
        //parent::rr($chartKey);
        $startDay=date($tableDataTimeType,$s);
        $nowMonthDaysNum=$tk=='3'?7:parent::get_day_num($s);
        $nowMonthDaysNum=$tk=='6'?12:$nowMonthDaysNum;
        $tableHtml='';
        $addTimeStr=$tk=='6'?' +1 month':' +1 day';
        for($a=0;$a<$nowMonthDaysNum;$a++)
        {
            $tableHtml.='<tr>
                <td>'.$startDay.'</td>
                <td>'.($tableData[$startDay][1]==''?0:$tableData[$startDay][1]).'</td>
                <td>'.($tableData[$startDay][2]==''?0:$tableData[$startDay][2]).'</td>
                <td>'.($tableData[$startDay][5]==''?0:$tableData[$startDay][5]).'</td>
                <td>'.($tableData[$startDay][6]==''?0:$tableData[$startDay][6]).'</td>
            </tr>';
            $startDay=$startDay=date($tableDataTimeType,strtotime($startDay.$addTimeStr));
        }
        $chartXName=implode("','",$chartKey);
        $chartXName="'".$chartXName."'";

        $chartValue1=implode(',',$r[1]);
        $chartValue2=implode(',',$r[2]);
        $chartValue3=implode(',',$r[5]);
        $chartValue4=implode(',',$r[6]);

        //获取部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //获取用户下拉框
        $user_option=$this->get_user_option($fid);
        

        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        $this->assign("chartValue1",$chartValue1);
        $this->assign("chartValue2",$chartValue2);
        $this->assign("chartValue3",$chartValue3);
        $this->assign("chartValue4",$chartValue4);
        $this->assign("chartXName",$chartXName);
        $this->assign("tableHtml",$tableHtml);
        $this->assign("topInfo",$topInfo);
        $this->display();
    }
    //业务新增汇总报表---按创建人汇总
    public function yewuxinzenghuizong2()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //获得用户下拉框
        $user_option=$this->get_user_option($fid);
        $userarr=$this->option_to_arr($user_option);
        //获得部门下拉框
        $bm_option=$this->get_bm_option($fid);
        //时间判断
        $tarr=parent::time_more();
        $tk=$_GET['sx_1']==''?"3":$_GET['sx_1'];
        
        $tarr=$tarr[$tk];
        $s=strtotime($tarr['s']);
        $e=strtotime($tarr['e']);
        $sql_time=$_GET['sx_1']!='1'?"and rz_time>='$s' and rz_time<='$e'":'';
        //sql语句之前判断get到的参数 ，进行sql语句条件拼接
        if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
        {
            $bmuser=$this->get_bm_user(addslashes($_GET['sx_2']));
            $bmuser="'".implode("','",$bmuser)."'";
            $sql_bm=" and rz_user in ($bmuser)";
        }
        if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
        {
            $sql_user=" and rz_user ='".addslashes($_GET['sx_3'])."'";
        }
        $rz=parent::sel_more_data("crm_rz","rz_mode,rz_time,rz_user","rz_yh='$fid' and rz_cz_type='1' and rz_type='1' $sql_time and rz_mode in ('1','2','5','6') $sql_bm $sql_user");
        
        //图形数据处理
        foreach($rz as $v)
        {
            $r[$v['rz_user']][$v['rz_mode']]++;
            $topArr[$v['rz_mode']][]=1;
        }
        //表格上方显示的数据
        $topInfo[1]=count($topArr[1]);
        $topInfo[2]=count($topArr[2]);
        $topInfo[3]=count($topArr[5]);
        $topInfo[4]=count($topArr[6]);
        //----
        foreach($userarr as $k=>$v)
        {
            $chartname[]=$v;
            $chartValue1[]=$r[$k][1];
            $chartValue2[]=$r[$k][2];
            $chartValue3[]=$r[$k][5];
            $chartValue4[]=$r[$k][6];
        }
        //parent::rr($userarr);
        //下方表格数据//线索1   客户2    联系人4    商机5    合同6    产品7
        $tableHTML='';
        foreach($r as $k=>$v)
        {
            $tableHTML.="<tr>
                            <td>".$userarr[$k]."</td>
                            <td>".($v[1]==''?0:$v[1])."</td>
                            <td>".($v[2]==''?0:$v[2])."</td>
                            <td>".($v[5]==''?0:$v[5])."</td>
                            <td>".($v[6]==''?0:$v[6])."</td>
                        </tr>";
        }


        $chartname="'".implode("','",$chartname)."'";
        $chartValue1=implode(",",$chartValue1);
        $chartValue2=implode(",",$chartValue2);
        $chartValue3=implode(",",$chartValue3);
        $chartValue4=implode(",",$chartValue4);
        
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        $this->assign("chartname",$chartname);
        $this->assign("chartValue1",$chartValue1);
        $this->assign("chartValue2",$chartValue2);
        $this->assign("chartValue3",$chartValue3);
        $this->assign("chartValue4",$chartValue4);
        $this->assign("topInfo",$topInfo);
        $this->assign("tableHTML",$tableHTML);
        $this->display();
    }
    //跟进记录报表
    public function genjinjilu()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);
        //时间判断
        $tarr=parent::time_more();
        
        
        $tk=$_GET['sx_1']==''?'1':$_GET['sx_1'];
        $tarr=$tarr[$tk];
        
        //parent::rr($tarr);
        $s=strtotime($tarr['s']);
        $e=strtotime($tarr['e']);
        //查询跟进
        if($_GET['sx_2']!=''&&$_GET['sx_2']!='0')
        {
            $bmuser=$this->get_bm_user(addslashes($_GET['sx_2']));
            $bmuser="'".implode("','",$bmuser)."'";
            $sql_bm=" and user_id in ($bmuser)";
        }
        if($_GET['sx_3']!=''&&$_GET['sx_3']!='0')
        {
            $sql_user=" and user_id ='".addslashes($_GET['sx_3'])."'";
        }
        $sql_time=$tk=='1'?'':"and ((add_time>='".$tarr['s']."' and add_time<='".$tarr['e']."') or (add_time>='$s' and add_time<='$e'))";
        $genjin=parent::sel_more_data("crm_xiegenjin","mode_id,user_id,add_time","genjin_yh='$fid' and mode_id in ('1','2','5','6') $sql_time $sql_bm $sql_user ");
        //将跟进根据用户分组
        foreach($genjin as $v)
        {
            $chartData[$v['user_id']][$v['mode_id']]++;//每个用户每个模块的跟进次数
            $userAllData[$v['user_id']]++;//每个用户的跟进总次数
            $modeData[$v['mode_id']]++;//每个模块跟进总次数
            $allData++;//本公司总跟进次数
        }
        $tableTopData="跟进次数: ".($allData==''?0:$allData)."， 跟进线索次数: ".($modeData[1]==''?0:$modeData[1])."， 跟进客户学生次数: ".($modeData[2]==''?0:$modeData[2])."， 跟进商机次数: ".($modeData[5]==''?0:$modeData[5])."， 跟进合同次数: ".($modeData[6]==''?0:$modeData[6]);
        //获取用户
        $userarr=$this->option_to_arr($user_option);
        //根据用户遍历
        $tableData='';//表格字符串
        //获取用户的部门
        $userbmarr=$this->get_user_bm($fid);
        //部门名称
        $bmnamearr=$this->option_to_arr($bm_option);
        //parent::rr($bmnamearr);
        foreach($userarr as $k=>$v)
        {
            $b1=$userAllData[$k]==''?0:$userAllData[$k];
            $b2=$chartData[$k][1]==''?0:$chartData[$k][1];
            $b3=$chartData[$k][2]==''?0:$chartData[$k][2];
            $b4=$chartData[$k][5]==''?0:$chartData[$k][5];
            $b5=$chartData[$k][6]==''?0:$chartData[$k][6];
            $chartValue1[]=$b1;
            $chartValue2[]=$b2;
            $chartValue3[]=$b3;
            $chartValue4[]=$b4;
            $chartValue5[]=$b5;
            $chartName[]=$v;
            //表格数据
            $tableData.='<tr>
                <td>'.$v.'</td>
                <td>'.$bmnamearr[$userbmarr[$k]].'</td>
                <td>'.$b1.'</td>
                <td>'.$b2.'</td>
                <td>'.$b3.'</td>
                <td>'.$b4.'</td>
                <td>'.$b5.'</td>
            </tr>';
        }
        //构造图形数据
        $chartValue1=implode(',',$chartValue1);
        $chartValue2=implode(',',$chartValue2);
        $chartValue3=implode(',',$chartValue3);
        $chartValue4=implode(',',$chartValue4);
        $chartValue5=implode(',',$chartValue5);
        $chartName="'".implode("','",$chartName)."'";
        //parent::rr($chartName);
        

        //图形数据
        $this->assign("chartValue1",$chartValue1);
        $this->assign("chartValue2",$chartValue2);
        $this->assign("chartValue3",$chartValue3);
        $this->assign("chartValue4",$chartValue4);
        $this->assign("chartValue5",$chartValue5);
        $this->assign("chartName",$chartName);
        //筛选数据
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        //表格数据
        $this->assign("tableTopData",$tableTopData);
        $this->assign("tableData",$tableData);
        $this->display();
    }
    //业绩目标完成度报表
    public function yejimubiaowanchengdu()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);
        $nowYear=$_GET['sx_1']?$_GET['sx_1']:date("Y",time());
        //默认选中日期
        $dateOption='   <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>';
        $dateOption=$_GET['sx_1']?str_replace('value="'.$_GET['sx_1'].'"','value="'.$_GET['sx_1'].'" selected ',$dateOption):str_replace('value="'.$nowYear.'"','value="'.$nowYear.'" selected ',$dateOption);


        //业绩目标名称和年度
        $yjarr=parent::sel_more_data("crm_yjmb","yjmb_id,yjmb_type_more,yjmb_type","yjmb_yh='$fid' and yjmb_nd='$nowYear'");
        $firstId=$_GET['sx_2']?$_GET['sx_2']:'';
        $firstId=count($yjarr)?$firstId:'0';
        $firstType='';
        $firstMore='';
        $firstNd='';
        $sxName='';
        foreach($yjarr as $v)
        {
           
            if($firstId=='')
            {
                //获取第一条的id和年度 并且给第一条默认选中
                $firstId=$v['yjmb_id'];
                $firstType=$v['yjmb_type'];
                $firstMore=$v['yjmb_type_more'];
                $firstNd=$v['yjmb_nd'];
                $sxName.='<span class="sx_xx sx_this" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
                continue;
            }
            else
            {
                if($firstId==$v['yjmb_id'])
                {
                    //获取第一条的id和年度 并且给第一条默认选中
                    $firstId=$v['yjmb_id'];
                    $firstType=$v['yjmb_type'];
                    $firstMore=$v['yjmb_type_more'];
                    $firstNd=$v['yjmb_nd'];
                    $sxName.='<span class="sx_xx sx_this" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
                    continue;
                }
            }
            $sxName.='<span class="sx_xx" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
        }
        $sxName=count($yjarr)?$sxName:'<span class="sx_xx" name="none" style="padding-left:0px;" >'.$nowYear.'年度尚未设置业绩目标</span>';

        //查询全公司的业绩目标数据
        $getBm=$_GET['sx_3']?addslashes($_GET['sx_3']):'0';
        $getUser=$_GET['sx_4']?addslashes($_GET['sx_4']):'0';
        $this->get_bm_user($bm);
        $selUserSql='';

        if($getBm!='0'&&$getUser=='0')
        {
            $bmarr=$this->get_bm_user($getBm);
            foreach($bmarr as $v)
            {
                $u[]=$v['user_id'];
            }
            $u=implode("','",$u);
            $u="'".$u."'";
            $selUserSql=" and yjm_uid in ($u)";
        }
        if($getUser!='0')
        {
            $selUserSql=" and yjm_uid='$getUser'";
        }
        $userMbArr=parent::sel_more_data("crm_yjmb_user","*","yjm_fid='$fid' and yjm_yid='$firstId' $selUserSql ");
        $allMonthMb=array();
        foreach($userMbArr as $v)
        {
            foreach($v as $kk=>$vv)
            {
                if(substr($kk,0,5)!='yjm_m')
                {
                    continue;
                }
                $allMonthMb[substr($kk,5)]+=$vv;
            }
        }
        //每月的业绩目标图数据
        $chart1=implode("','",$allMonthMb);
        $chart1="['".$chart1."']";
        //查询该业绩目标的每个月的实际数据
        $noneArr=array();
        

        $getYjArr=$firstType==''?$noneArr:$this->get_yjmb($firstType,$firstMore,$nowYear,$getBm,$getUser);  
        $dataTable='';
        for($a=1;$a<=12;$a++)
        {
            $chart2Arr[$a]=$getYjArr[$a]==''?0:$getYjArr[$a];
            $chart3Arr[$a]=$chart2Arr[$a]/$allMonthMb[$a];
            if($chart3Arr[$a]>1)
            {
                $chart3Arr[$a]=1;
            }
            if($chart3Arr[$a]<0)
            {
                $chart3Arr[$a]=0;
            }
            $chart3Arr[$a]=($chart3Arr[$a]*100);
            //表格数据
            $dataTable.='<tr>
                            <td>'.$a.'月</td>
                            <td>'.$chart2Arr[$a].'</td>
                            <td>'.$allMonthMb[$a].'</td>
                            <td>'.$chart3Arr[$a].'%</td>
                        </tr>';
            $zongYj+=$allMonthMb[$a];
            $zongWc+=$chart2Arr[$a];
        }
        $chart2=implode("','",$chart2Arr);
        $chart2="['".$chart2."']";
        $chart3=implode("','",$chart3Arr);
        $chart3="['".$chart3."']";

        //表格上方的完成提示
        $tableTopTip='销售金额：¥ '.number_format($zongWc,2).'  目标金额：¥ '.number_format($zongYj,2).'完成率：'.((number_format($zongWc,2)/number_format($zongYj,2))*100).'%';

        //业绩目标类型
        $this->assign("sxName",$sxName);
        //年度选择下拉框
        $this->assign("dateOption",$dateOption);
        //图形数据
        $this->assign("chart1",$chart1);//图形1，系统设置的目标数据
        $this->assign("chart2",$chart2);//图形2，公司内的实际数据
        $this->assign("chart3",$chart3);//图形3，公司内的实际数据/系统设置的业绩目标 的百分比
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$user_option):$user_option));
        //表格上方数据
        $this->assign("tableTopTip",$tableTopTip);
        //下方表格
        $this->assign("dataTable",$dataTable);
        $this->display();
    }
    //回款计划汇总报表
    public function huikuanjihuahuizong()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);

        $nowYear=$_GET['sx_1']?addslashes($_GET['sx_1']):date("Y",time());

        $getBm=$_GET['sx_2']?addslashes($_GET['sx_2']):'0';
        $getUser=$_GET['sx_3']?addslashes($_GET['sx_3']):'0';

        $where1='';
        $where2='';
        if($getBm!='0'&&$getUser=='0')
        {
            $bmarr=$this->get_bm_user($getBm);
            foreach($bmarr as $v)
            {
                $u[]=$v['user_id'];
            }
            $u=implode("','",$u);
            $u="'".$u."'";
            $htidarr=parent::sel_more_data("crm_hetong","ht_id","ht_yh='$fid' and ht_fz in ($u)");
            foreach($htidarr as $v)
            {
                $hu[]=$v['ht_id'];
            }
            $hu=implode("','",$hu);
            $hu="'".$hu."'";

            $where1=" and hk_ht in ($hu)";
            $where2=" and hk_htid in ($hu)";
        }
        if($getUser!='0')
        {
            $htidarr=parent::sel_more_data("crm_hetong","ht_id","ht_yh='$fid' and ht_fz='$getUser'");
            foreach($htidarr as $v)
            {
                $hu[]=$v['ht_id'];
            }
            $hu=implode("','",$hu);
            $hu="'".$hu."'";
            $where1=" and hk_ht in ($hu)";
            $where2=" and hk_htid in ($hu)";
        }

        //获得全公司今年已回款金额
        $hkarr=parent::sel_more_data("crm_hkadd","hk_data,hk_je","hk_yh='$fid' and hk_sp='1' and hk_data like '$nowYear%' $where1 ");
        //parent::rr($hkarr);
        foreach($hkarr as $v)
        {
            $thisdata=$this->date_to_date($v['hk_data']);
            $d=substr($thisdata,5,2);
            $d2=$this->get_int($d);
            $hkMonthArr[$d2]+=$v['hk_je'];
        }

        //获得全公司计划回款金额
        $jhhkarr=parent::sel_more_data("crm_hk","hk_data,hk_je","hk_yh='$fid' and hk_data like '$nowYear%' $where2 ");
        foreach($jhhkarr as $v)
        {
            $thisdata=$this->date_to_date($v['hk_data']);
            $d=substr($thisdata,5,2);
            $d2=$this->get_int($d);
            $jhMonthArr[$d2]+=$v['hk_je'];
        }

        //一年十二个月的循环
        $chart1='';//计划回款数据
        $chart2='';//已回款数据
        $chart3='';//完成率
        $dataTable='';//下方表格数据
        for($a=1;$a<=12;$a++)
        {
            $chart1[$a]=$jhMonthArr[$a]==''?0:$jhMonthArr[$a];
            $chart2[$a]=$hkMonthArr[$a]==''?0:$hkMonthArr[$a];
            $c3=round(($hkMonthArr[$a]/$jhMonthArr[$a]),2)*100;
            $chart3[$a]=$c3;
            $c[$a]=(($jhMonthArr[$a]-$hkMonthArr[$a])<0?0:($jhMonthArr[$a]-$hkMonthArr[$a]));
            $dataTable.="<tr>
                <td>".$a."月</td>
                <td>￥".number_format($jhMonthArr[$a],2)."</td>
                <td>￥".number_format($hkMonthArr[$a],2)."</td>
                <td>".$chart3[$a]."%</td>
                <td>￥".number_format($c[$a],2)."</td>
            </tr>";

            $z1+=$chart1[$a];
            $z2+=$chart2[$a];
            $z3+=$c[$a];
        
        }
        $ztip='计划回款金额 ：¥ '.number_format($z1,2).'， 已完成金额 ：¥ '.number_format($z2,2).'， 完成率 ：'.round((($z2/$z1)*100),2).'%， 未完成金额 ：¥ '.number_format($z3,2).'';//表格上方的总数据
        $chart1="['".implode("','",$chart1)."']";
        $chart2="['".implode("','",$chart2)."']";
        $chart3="['".implode("','",$chart3)."']";

        $yearOption='
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>';
        $yearOption=str_replace('value="'.$nowYear.'"','value="'.$nowYear.'" selected ',$yearOption);
        //图形数据
        $this->assign("chart1",$chart1);
        $this->assign("chart2",$chart2);
        $this->assign("chart3",$chart3);
        //表格数据
        $this->assign("dataTable",$dataTable);
        //表格上方的总数据
        $this->assign("ztip",$ztip);
        //年度下拉框
        $this->assign("yearOption",$yearOption);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));
        $this->display();
    }
    //销售回款排名报表
    public function xiaoshouhuikuanpaiming()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门下拉框
        $bmarr=parent::sel_more_data("crm_department","bm_id,bm_name","bm_company='$fid'");
        foreach($bmarr as $v)
        {
            $bmname[$v['bm_id']]=$v['bm_name'];
        }

        //查询公司每个人
        $userarr=parent::sel_more_data("crm_user","user_name,user_id,user_zhu_bid","(user_id='$fid' or user_fid='$fid') and user_del='0'");
        foreach($userarr as $v)
        {
            $username[$v['user_id']]=$v['user_name'];
            $userbm[$v['user_id']]=$bmname[$v['user_zhu_bid']];
        }
        //所有合同
        $htarr=parent::sel_more_data("crm_hetong","ht_id,ht_fz","ht_yh='$fid' ");
        $htuser=array();
        foreach($htarr as $v)
        {
            //每个合同对应着哪个用户
            $htuser[$v['ht_id']]=$v['ht_fz'];
        }
        //查询所有销售回款。并根据公司员工进行分组
        $hkarr=parent::sel_more_data("crm_hkadd","hk_je,hk_ht,hk_data","hk_yh='$fid' and hk_sp='1' ");
        foreach($hkarr as $v)
        {
            if($_GET['sx_1']!='')
            {
                $t=explode(',',$_GET['sx_1']);
                $s=$this->date_to_date($v['hk_data']);
                if($s<$t[0]||$s>$t[1])
                {
                    continue;
                }
            }
            $res[$htuser[$v['hk_ht']]]+=$v['hk_je'];
            $res2[$htuser[$v['hk_ht']]]++;
            
        }
        arsort($res);
        $dataTable='';
        $number=1;
        foreach($res as $k=>$v)
        {
            $dataTable.='
            <td>'.$number.'</td>
            <td>'.$username[$k].'</td>
            <td>'.$userbm[$k].'</td>
            <td>'.$res2[$k].'</td>
            <td>￥'.number_format($v,2).'</td>';
            $number++;
            $zong+=$v;
        }
        //parent::rr($res);
        $this->assign("sts",$t[0]);
        $this->assign("ste",$t[1]);
        $this->assign("dataTable",$dataTable);
        //总
        $this->assign("zong",number_format($zong,2));
        $this->display();
    }
    //线索转化率报表--转化率
    public function xiansuozhuanhualv()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);

        $nowYear=$_GET['sx_1']?addslashes($_GET['sx_1']):date("Y",time());
        
        $yearOption='
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>';
        $yearOption=str_replace('value="'.$nowYear.'"','value="'.$nowYear.'" selected ',$yearOption);

        //查询本年度所有线索
        $sql_date_s=$nowYear.'-01-01 00:00:00';
        $sql_date_e=$nowYear.'-12-31 23:59:59';
        //是否进行部门或者用户筛选
        $sqlWhere='';
        if($_GET['sx_2']&&!$_GET['sx_3'])
        {
            //部门
            //获得本部门下的所有用户id
            $bmuserid=$this->get_bm_user(addslashes($_GET['sx_2']));
            if(count($bmuserid))
            {
                $sqlWhere=" and xs_fz in ('".implode("','",$bmuserid)."')";
            }
        }
        if($_GET['sx_3'])
        {
            //用户
            $sqlWhere=" and xs_fz = '".addslashes($_GET['sx_3'])."'";
        }

        //查询本年添加的线索
        $xsarr=parent::sel_more_data("crm_xiansuo","xs_create_time,xs_to_kh_time,xs_is_to_kh","xs_yh='$fid' and xs_is_del='0' and xs_create_time>='$sql_date_s' and xs_create_time<='$sql_date_e' $sqlWhere ");
        
        
        foreach($xsarr as $v)
        {
            $d=substr($v['xs_create_time'],5,2);
            $d2=$this->get_int($d);
            $xsMonthArr[$d2]++;
            if($v['xs_is_to_kh']=='1')
            {
                $toKhArr[$d2]++;
            }
        }
        $dataTable='';
        for($a=1;$a<=12;$a++)
        {
            $chart1Arr[$a]=$xsMonthArr[$a]==''?'0':$xsMonthArr[$a];
            $chart2Arr[$a]=$toKhArr[$a]==''?'0':$toKhArr[$a];
            $chart3Arr[$a]=round((($chart2Arr[$a]/$chart1Arr[$a])*100),2);
            $dataTable.='<tr>
                            <td>'.$a.'月</td>
                            <td>'.$chart1Arr[$a].'</td>
                            <td>'.$chart2Arr[$a].'</td>
                            <td>'.$chart3Arr[$a].'%</td>
                        </tr>';
            $zong1+=$chart1Arr[$a];
            $zong2+=$chart2Arr[$a];
        }
        $zong3=round((($zong2/$zong1)*100),2);

        $tableTopTip='新增线索数 ：'.$zong1.'， 已转化线索数 ：'.$zong2.'， 转化率 ：'.$zong3.'%';

        $chart1="['".implode("','",$chart1Arr)."']";
        $chart2="['".implode("','",$chart2Arr)."']";
        $chart3="['".implode("','",$chart3Arr)."']";
        //parent::rr($chart3Arr);




        $this->assign("chart1",$chart1);//新增线索数
        $this->assign("chart2",$chart2);//已转化线索数
        $this->assign("chart3",$chart3);//转化率

        //表格数据
        $this->assign("dataTable",$dataTable);
        //表格上方的总数
        $this->assign("tableTopTip",$tableTopTip);
        //年度下拉框
        $this->assign("yearOption",$yearOption);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));

        $this->display();
    }
    //线索转化率报表--转化时长
    public function xiansuozhuanhualv2()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);

        $nowYear=$_GET['sx_1']?addslashes($_GET['sx_1']):date("Y",time());
        
        $yearOption='
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>';
        $yearOption=str_replace('value="'.$nowYear.'"','value="'.$nowYear.'" selected ',$yearOption);

        //查询本年度所有线索
        $sql_date_s=$nowYear.'-01-01 00:00:00';
        $sql_date_e=$nowYear.'-12-31 23:59:59';
        //是否进行部门或者用户筛选
        $sqlWhere='';
        if($_GET['sx_2']&&!$_GET['sx_3'])
        {
            //部门
            //获得本部门下的所有用户id
            $bmuserid=$this->get_bm_user(addslashes($_GET['sx_2']));
            if(count($bmuserid))
            {
                $sqlWhere=" and xs_fz in ('".implode("','",$bmuserid)."')";
            }
        }
        if($_GET['sx_3'])
        {
            //用户
            $sqlWhere=" and xs_fz = '".addslashes($_GET['sx_3'])."'";
        }

        //查询本年添加的线索
        $xsarr=parent::sel_more_data("crm_xiansuo","xs_create_time,xs_to_kh_time,xs_is_to_kh","xs_yh='$fid' and xs_is_del='0' and xs_create_time>='$sql_date_s' and xs_create_time<='$sql_date_e' $sqlWhere ");
        
        $chart1=0;
        $chart2=0;
        $chart3=0;
        $chart4=0;
        $chart5=0;
        $chart6=0;
        $chart7=0;
        $chart8=0;
        $zong=0;
        $zong1=0;
        $zong2=0;
        foreach($xsarr as $v)
        {
            if($v['xs_is_to_kh']=='0')
            {
                $chart8++;//未转化
                $zong1++;
            }
            else
            {
                $zong2++;
                $createTime=strtotime($v['xs_create_time']);
                $zhTime=strtotime($v['xs_to_kh_time']);
                $rt=$zhTime-$createTime;//单位为：秒
                //parent::rr($v['xs_create_time'].$v['xs_to_kh_time'].$resTime);
                if($rt<86400)
                {
                    //一天内  一天=86400秒
                    $chart1++;
                }
                else if($rt>=86400&&$rt<259200)
                {
                    //一天到三天  三天=259200秒
                    $chart2++;
                }
                else if($rt>=259200&&$rt<604800)
                {
                    //3~7天内
                    $chart3++;
                }
                else if($rt>=604800&&$rt<1296000)
                {
                    //7~15天内
                    $chart4++;
                }
                else if($rt>=1296000&&$rt<2592000)
                {
                    //15~30天内
                    $chart5++;
                }
                else if($rt>=2592000&&$rt<7776000)
                {
                    //30~90天内
                    $chart6++;
                }
                else
                {
                    //90天以上
                    $chart7++;
                }
            }
        }
        $zong=$zong1+$zong2;
        $tableTopTip='新增线索数 ：'.($zong1+$zong2).'， 已转化线索数 ：'.$zong2.'， 转化率 ：'.round((($zong2/$zong)*100),2).'%';
        



        //表格数据
        $this->assign("t11",$chart1);
        $this->assign("t12",round((($chart1/$zong)*100),2).'%');
        $this->assign("t21",$chart2);
        $this->assign("t22",round((($chart2/$zong)*100),2).'%');
        $this->assign("t31",$chart3);
        $this->assign("t32",round((($chart3/$zong)*100),2).'%');
        $this->assign("t41",$chart4);
        $this->assign("t42",round((($chart4/$zong)*100),2).'%');
        $this->assign("t51",$chart5);
        $this->assign("t52",round((($chart5/$zong)*100),2).'%');
        $this->assign("t61",$chart6);
        $this->assign("t62",round((($chart6/$zong)*100),2).'%');
        $this->assign("t71",$chart7);
        $this->assign("t72",round((($chart7/$zong)*100),2).'%');
        $this->assign("t81",$chart8);
        $this->assign("t82",round((($chart8/$zong)*100),2).'%');

        //表格上方的总数
        $this->assign("tableTopTip",$tableTopTip);
        //年度下拉框
        $this->assign("yearOption",$yearOption);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_2']?str_replace("value='".$_GET['sx_2']."'","value='".$_GET['sx_2']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_3']?str_replace("value='".$_GET['sx_3']."'","value='".$_GET['sx_3']."' selected ",$user_option):$user_option));

        $this->display();
    }
    //业绩目标完成度排名报表
    public function yejimubiaowanchengdupaiming()
    {
        parent::is_login();
        $fid=parent::get_fid();
        //部门，用户下拉框
        $user_option=$this->get_user_option($fid);
        $bm_option=$this->get_bm_option($fid);
        //年度下拉框
        $yearOption='<option value="2014">2014</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>';
        
        $monthOption='<option value="0">全部</option>
        <option value="1">1月</option>
        <option value="2">2月</option>
        <option value="3">3月</option>
        <option value="4">4月</option>
        <option value="5">5月</option>
        <option value="6">6月</option>
        <option value="7">7月</option>
        <option value="8">8月</option>
        <option value="9">9月</option>
        <option value="10">10月</option>
        <option value="11">11月</option>
        <option value="12">12月</option>';
        //当前年度
        $nowYear=$_GET['sx_1']?$_GET['sx_1']:date("Y",time());
        //当前月份
        $nowMonth=$_GET['sx_2']?$_GET['sx_2']:'0';
        $nowMonthInt=$this->get_int($nowMonth);

        $yearOption=$_GET['sx_1']?str_replace('value="'.$_GET['sx_1'].'"','value="'.$_GET['sx_1'].'" selected ',$yearOption):str_replace('value="'.$nowYear.'"','value="'.$nowYear.'" selected ',$yearOption);
        $monthOption=$_GET['sx_2']?str_replace('value="'.$_GET['sx_2'].'"','value="'.$_GET['sx_2'].'" selected ',$monthOption):str_replace('value="'.$nowMonthInt.'"','value="'.$nowMonthInt.'" selected ',$monthOption);
        
        //本年的业绩目标查询
        //业绩目标名称和年度
        $yjarr=parent::sel_more_data("crm_yjmb","yjmb_id,yjmb_type_more,yjmb_type","yjmb_yh='$fid' and yjmb_nd='$nowYear'");

        $firstId=$_GET['sx_3']?$_GET['sx_3']:'';
        $firstId=count($yjarr)?$firstId:'0';
        $firstType='';
        $firstMore='';
        $firstNd='';
        $sxName='';
        foreach($yjarr as $v)
        {
           
            if($firstId=='')
            {
                //获取第一条的id和年度 并且给第一条默认选中
                $firstId=$v['yjmb_id'];
                $firstType=$v['yjmb_type'];
                $firstMore=$v['yjmb_type_more'];
                $firstNd=$v['yjmb_nd'];
                $sxName.='<span class="sx_xx sx_this" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
                continue;
            }
            else
            {
                if($firstId==$v['yjmb_id'])
                {
                    //获取第一条的id和年度 并且给第一条默认选中
                    $firstId=$v['yjmb_id'];
                    $firstType=$v['yjmb_type'];
                    $firstMore=$v['yjmb_type_more'];
                    $firstNd=$v['yjmb_nd'];
                    $sxName.='<span class="sx_xx sx_this" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
                    continue;
                }
            }
            $sxName.='<span class="sx_xx" name="'.$v['yjmb_id'].'">'.$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']).'</span>';
        }
        $sxName=count($yjarr)?$sxName:'<span class="sx_xx" name="none" style="padding-left:0px;" >'.$nowYear.'年度尚未设置业绩目标</span>';

        //查询全公司的业绩目标数据
        $getBm=$_GET['sx_4']?addslashes($_GET['sx_4']):'0';
        $getUser=$_GET['sx_5']?addslashes($_GET['sx_5']):'0';
        $this->get_bm_user($bm);
        $selUserSql='';

        if($getBm!='0'&&$getUser=='0')
        {
            $bmarr=$this->get_bm_user($getBm);
            foreach($bmarr as $v)
            {
                $u[]=$v['user_id'];
            }
            $u=implode("','",$u);
            $u="'".$u."'";
            $selUserSql=" and yjm_uid in ($u)";
        }
        if($getUser!='0')
        {
            $selUserSql=" and yjm_uid='$getUser'";
        }
        $userMbArr=parent::sel_more_data("crm_yjmb_user","*","yjm_fid='$fid' and yjm_yid='$firstId' $selUserSql ");
        
        $chart2Arr=array();//用户需要完成的业绩目标图形数据
        if($_GET['sx_2'])
        {
            $m=addslashes($_GET['sx_2']);
            //如果指定了哪个月
            foreach($userMbArr as $v)
            {
                $chart2Arr[$v['yjm_uid']]=$v['yjm_m'.$m];
            }
        }
        else
        {
            //没有指定月份，取全年的数据
            foreach($userMbArr as $v)
            {
                $a=0;
                for($a=1;$a<=12;$a++)
                {
                    $chart2Arr[$v['yjm_uid']]+=$v['yjm_m'.$a];
                }
            }
        }
        //每个用户的计划数据已拿到

        //查询每个用户的真实数据
        $noneArr=array();
        $getYjArr=$firstType==''?$noneArr:$this->get_yjmb_for_user($firstType,$firstMore,$nowYear,$nowMonth,$getBm,$getUser);
        //parent::rr($getYjArr);
        
        $userarr=$this->option_to_arr($user_option);//拿到全公司的用户
        $allDataArr=array();
        
        foreach($userarr as $k=>$v)
        {
            $mbv=$chart2Arr[$k]==''?'0':$chart2Arr[$k];
            $sjv=$getYjArr[$k]==''?'0':$getYjArr[$k];
            $wcd[$k]=round((($sjv/$mbv)*100),2);
        }
        //parent::rr($wcd);
        arsort($wcd);
        $dataTable='';
        $a=1;
        $userbmid=$this->get_user_bm($fid);
        $bmnamearr=$this->option_to_arr($bm_option);
        $zong1=0;
        $zong2=0;
        foreach($wcd as $k=>$v)
        {
            
            $allDataArr[1][$k]=$chart2Arr[$k]==''?'0':$chart2Arr[$k];//设置的目标
            $allDataArr[2][$k]=$getYjArr[$k]==''?'0':$getYjArr[$k];//实际的目标
            $allDataArr[3][$k]=$userarr[$k]==''?'已删除':$userarr[$k];//下方的用户名
            $allDataArr[4][$k]=round((($allDataArr[2][$k]/$allDataArr[1][$k])*100),2);//百分比
            $dataTable.='<tr>
                <td>'.$a.'</td>
                <td>'.$allDataArr[3][$k].'</td>
                <td>'.$bmnamearr[$userbmid[$k]].'</td>
                <td>'.number_format($allDataArr[2][$k],2).'</td>
                <td>'.number_format($allDataArr[1][$k],2).'</td>
                <td>'.$allDataArr[4][$k].'%</td>
            </tr>';

            $zong1+=$allDataArr[1][$k];
            $zong2+=$allDataArr[2][$k];

            $a++;
        }
        $zong3=number_format(($zong2/$zong1),2);
        $tableTopTip='回款金额：¥ '.number_format($zong2,2).'  目标金额：¥ '.number_format($zong1,2).'  完成率：'.$zong3.'%';

        $chart1=implode("','",$allDataArr[1]);
        $chart1="['".$chart1."']";
        $chart2=implode("','",$allDataArr[2]);
        $chart2="['".$chart2."']";
        $chart3=implode("','",$allDataArr[3]);
        $chart3="['".$chart3."']";
        $chart4=implode("','",$allDataArr[4]);
        $chart4="['".$chart4."']";


        //parent::rr($allDataArr);

      

        //年度-月份下拉框
        $this->assign("yearOption",$yearOption);
        $this->assign("monthOption",$monthOption);
        //业绩目标类型
        $this->assign("sxName",$sxName);
        //部门下拉框
        $this->assign("bm_option",($_GET['sx_4']?str_replace("value='".$_GET['sx_4']."'","value='".$_GET['sx_4']."' selected ",$bm_option):$bm_option));
        //用户下拉框
        $this->assign("user_option",($_GET['sx_5']?str_replace("value='".$_GET['sx_5']."'","value='".$_GET['sx_5']."' selected ",$user_option):$user_option));
        //图形数据
        $this->assign("chart1",$chart1);//设置的目标
        $this->assign("chart2",$chart2);//实际的业绩
        $this->assign("chart3",$chart3);//下方的用户名
        $this->assign("chart4",$chart4);//百分比
        //表格数据
        $this->assign("dataTable",$dataTable);
        //表格上方总计
        $this->assign("tableTopTip",$tableTopTip);
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
    //获得指定部门下的所有用户id
    public function get_bm_user($bmid)
    {
        $fid=parent::get_fid();
        $useridarr=parent::sel_more_data("crm_user","user_id","(user_fid='$fid' or user_id='$fid') and user_del='0' and user_zhu_bid='$bmid'");
        foreach($useridarr as $v)
        {
            $r[]=$v['user_id'];
        }
        return $r;
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
    //根据用户id获得用户名称
    public function get_user_id_name($fid)
    {
        $userarr=parent::sel_more_data("crm_user","user_id,user_name","(user_id='$fid' or user_fid='$fid') and user_del='0'");
        foreach($userarr as $v)
        {
            $rarr[$v['user_id']]=$v['user_name'];
        }
        return $rarr;
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
    //获得前一个月的时间和本日的时间
    public function get_last_month()
    {
        $dt['e']=date("Y-m-d",time());
        $dt['s']=date("Y-m-d",strtotime($nowdate.' -1 month'));
        return $dt;
    }
    //获得本月第一天和本月最后一天的日期
    public function get_now_month()
    {
        $s=date("Y-m",time()).'-01';
        $e=date("Y-m-d",strtotime(date("Y-m-d",strtotime($s.' +1 month')).' -1 day'));
        $d['s']=$s;
        $d['e']=$e;
        return $d;
    }
    //获取业绩目标名称
    public function get_yjmb_name($yjmbtype,$yjmbmore)
    {
        $yjmbtypearr=array(
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
        $yjname='';
        if($yjmbtype=='6'||$yjmbtype=='7')
        {
            //和产品有关的业绩目标，需要查询产品名称
            $cp=parent::sel_more_data("crm_chanpin","cp_data","cp_id='$yjmbmore' limit 1");
            $cpname=json_decode($cp[0]['cp_data'],true);
            $yjname=$yjmbtypearr[$yjmbtype].'('.$cpname['zdy0'].')';
        }
        else if($yjmbtype=='8'||$yjmbtype=='9')
        {
            //和产品分类有关的业绩目标，需要查询产品分类的名称
            $cpfl=parent::sel_more_data("crm_chanpinfenlei","cpfl_name","cpfl_id='$yjmbmore'");
            $yjname=$yjmbtypearr[$yjmbtype].'('.$cpfl[0]['cpfl_name'].')';
        }
        else
        {
            $yjname=$yjmbtypearr[$yjmbtype];
        }
        return $yjname;
    }
    //业绩目标的算法-返回本公司每个月的业绩目标的已完成的值
    public function get_yjmb($yjmbtype,$yjmbmore,$year,$bm,$user)
    {
        //$yjmbtype,$yjmbmore,$year
        //$yjmbtype=9;
        //$yjmbmore=16;
        //$year=2017;


        $fid=parent::get_fid();
        $usersx='';
        //部门用户的筛选
        if($bm!='0'&&$user=='0')
        {
            $bmarr=$this->get_bm_user($bm);
            foreach($bmarr as $v)
            {
                $u[]=$v['user_id'];
            }
            $u=implode("','",$u);
            $u="'".$u."'";
            $usersx=" in ($u)";
        }
        if($user!='0')
        {
            $usersx=" ='$user'";
        }


        $r=array();
        //判断时间
        $tarr['s']=$year.'-01-01 00:00:00';
        $tarr['e']=$year.'-12-31 23:59:59';
        //parent::rr($tarr);
        if($yjmbtype=='1')
        {
            //赢单商机金额
            /*
                本公司所有人的商机中  赢单的金额
            */
            //查询商机数据  预计销售金额zdy3  预计签单日期zdy4  销售阶段zdy5  赢单canshu5
            $usersx=$usersx==''?'':" and sj_fz $usersx ";
            $shangji=parent::sel_more_data("crm_shangji","sj_data","sj_yh='$fid' $usersx ");
            
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
               
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=$this->date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $sjt=substr($sjt,5,2);
                $sjt2=$this->get_int($sjt);
                $r[$sjt2]+=$j['zdy3'];
            }
        }
        else if($yjmbtype=='2')
        {
            //赢单商机数
            $usersx=$usersx==''?'':" and sj_fz $usersx ";
            $shangji=parent::sel_more_data("crm_shangji","sj_data","sj_yh='$fid' $usersx ");
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=$this->date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $sjt=substr($sjt,5,2);
                $sjt2=$this->get_int($sjt);
                $r[$sjt2]++;
            }
        }
        else if($yjmbtype=='3')
        {
            //合同回款金额
            /*
                找到本公司的合同
            */
            //查询我的合同回款
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_id"," ht_yh='$fid' $usersx");
            foreach($myht as $v)
            {
                $hk_in_str.="'".$v['ht_id']."',";
            }
            $hk_in_str=substr($hk_in_str,0,-1);
            //查询回款
            $myhk=parent::sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_sp='1' and hk_ht in ($hk_in_str)");
            foreach($myhk as $v)
            {
                $htt=$this->date_to_date($v['hk_data']);
                if($htt<$tarr['s']||$htt>$tarr['e'])
                {
                    continue;
                }
                
                $htt=substr($htt,5,2);
                $htt2=$this->get_int($htt);
                $r[$htt2]+=$v['hk_je'];
            }
        }
        else if($yjmbtype=='4')
        {
            //合同金额
            /*
                合同总金额zdy3  签约日期zdy4
            */
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_data","ht_yh='$fid' $usersx ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($j['zdy7']!='canshu3')
                {
                    //判断是否为成功结束
                    continue;
                }
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $d=substr($d,5,2);
                $d2=$this->get_int($d);
                $r[$d2]+=$j['zdy3'];
            }
        }
        else if($yjmbtype=='5')
        {
            //合同数
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_data","ht_yh='$fid' $usersx ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($j['zdy7']!='canshu3')
                {
                    //判断是否为成功结束
                    continue;
                }
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $d=substr($d,5,2);
                $d2=$this->get_int($d);
                $r[$d2]++;
            }
        }
        else if($yjmbtype=='6')
        {
            //产品销量
            //合同查询
            $h=$this->get_my_htid($fid,$tarr,$usersx);
            $htid=$h["id"];
            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='7')
        {
            //产品销售额
            //合同查询
            $h=$this->get_my_htid($fid,$tarr,$usersx);
            $htid=$h["id"];
            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_zj'];
            }
        }
        else if($yjmbtype=='8')
        {
            //产品分类销量
            //合同查询
            $h=$this->get_my_htid($fid,$tarr,$usersx);
            $htid=$h["id"];
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='9')
        {
            //产品分类销售额
            //合同查询
            $h=$this->get_my_htid($fid,$tarr,$usersx);
            $htid=$h["id"];
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_zj'];
            }
        }
        else
        {
            echo "未知错误";die;
        }
 
        return $r;
    }
    //查询本公司指定年的合同
    public function get_my_htid($fid,$tarr,$usersx)
    {
        //合同查询
        $usersx=$usersx==''?'':" and ht_fz $usersx ";
        $myht=parent::sel_more_data("crm_hetong","ht_id,ht_data","ht_yh='$fid' $usersx ");
        $htid='';
        foreach($myht as $v)
        {
            $j=json_decode($v['ht_data'],true);
            $d=$this->date_to_date($j['zdy4']);
            if($j['zdy7']!='canshu3')
            {
                //判断是否为成功结束
                continue;
            }
            if($d<$tarr['s']||$d>$tarr['e'])
            {
                continue;
            }
            $htt=substr($d,5,2);
            $htt2=$this->get_int($htt);
            $htdate[$v['ht_id']]=$htt2;
            $htid.="'".$v['ht_id']."',";
        }
        $htid=substr($htid,0,-1);
        $r['id']=$htid;
        $r['darr']=$htdate;
        return $r;
    }
    //查询本公司指定年的合同
    public function get_my_htid_and_user($fid,$tarr,$usersx)
    {
        //合同查询
        $usersx=$usersx==''?'':" and ht_fz $usersx ";
        $myht=parent::sel_more_data("crm_hetong","ht_id,ht_data,ht_fz","ht_yh='$fid' $usersx ");
        $htid='';
        foreach($myht as $v)
        {
            $j=json_decode($v['ht_data'],true);
            $d=$this->date_to_date($j['zdy4']);
            if($j['zdy7']!='canshu3')
            {
                //判断是否为成功结束
                continue;
            }
            if($d<$tarr['s']||$d>$tarr['e'])
            {
                continue;
            }
            $htdate[$v['ht_id']]=$v['ht_fz'];
            $htid.="'".$v['ht_id']."',";
        }
        $htid=substr($htid,0,-1);
        $r['id']=$htid;
        $r['darr']=$htdate;
        return $r;
    }
    //将带0的小于10的数字转化成一个数的数字
    public function get_int($num)
    {
        $r=$num;
        if($num<10)
        {
            if(strlen($num)==2)
            {
                $r=substr($num,1);
            }
        }
        return $r;
    }
    //查询公司指定日期内每个员工的业绩目标
    public function get_yjmb_for_user($yjmbtype,$yjmbmore,$year,$month,$bm,$user)
    {
        $fid=parent::get_fid();
        $usersx='';
        //部门用户的筛选
        if($bm!='0'&&$user=='0')
        {
            $bmarr=$this->get_bm_user($bm);
            foreach($bmarr as $v)
            {
                $u[]=$v['user_id'];
            }
            $u=implode("','",$u);
            $u="'".$u."'";
            $usersx=" in ($u)";
        }
        if($user!='0')
        {
            $usersx=" ='$user'";
        }
        $r=array();
        //判断时间
        if($month)
        {
            $month=($month<10&&strlen($month)=='1')?'0'.$month:$month;
            $tarr['s']=$year.'-'.$month.'-01 00:00:00';
            $tarr['e']=date("Y-m-d",strtotime(date("Y-m",strtotime($year.'-'.$month.'-01 +1 month')).'-01 -1 day')).' 23:59:59';
        }
        else
        {
            $tarr['s']=$year.'-01-01 00:00:00';
            $tarr['e']=$year.'-12-31 23:59:59';
        }
        //parent::rr($tarr);

        if($yjmbtype=='1')
        {
            //赢单商机金额
            /*
                本公司所有人的商机中  赢单的金额
            */
            //查询商机数据  预计销售金额zdy3  预计签单日期zdy4  销售阶段zdy5  赢单canshu5
            $usersx=$usersx==''?'':" and sj_fz $usersx ";
            $shangji=parent::sel_more_data("crm_shangji","sj_data,sj_fz","sj_yh='$fid' $usersx ");
            
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
               
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=$this->date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $r[$v['sj_fz']]+=$j['zdy3'];
            }
        }
        else if($yjmbtype=='2')
        {
            //赢单商机数
            $usersx=$usersx==''?'':" and sj_fz $usersx ";
            $shangji=parent::sel_more_data("crm_shangji","sj_data,sj_fz","sj_yh='$fid' $usersx ");
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=$this->date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
             
                $r[$v['sj_fz']]++;
            }
        }
        else if($yjmbtype=='3')
        {
            //合同回款金额
            /*
                找到本公司的合同
            */
            //查询我的合同回款
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz"," ht_yh='$fid' $usersx");
            foreach($myht as $v)
            {
                $hk_in_str.="'".$v['ht_id']."',";
                $httofz[$v['ht_id']]=$v['ht_fz'];
            }
            $hk_in_str=substr($hk_in_str,0,-1);
            //查询回款
            $myhk=parent::sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_sp='1' and hk_ht in ($hk_in_str)");
            foreach($myhk as $v)
            {
                $htt=$this->date_to_date($v['hk_data']);
                
                if($htt<$tarr['s']||$htt>$tarr['e'])
                {
                    continue;
                }
                
                $r[$httofz['hk_ht']]+=$v['hk_je'];
            }
        }
        else if($yjmbtype=='4')
        {
            //合同金额
            /*
                合同总金额zdy3  签约日期zdy4
            */
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_data,ht_fz","ht_yh='$fid' $usersx ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($j['zdy7']!='canshu3')
                {
                    //判断是否为成功结束
                    continue;
                }
                
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $r[$v['ht_fz']]+=$j['zdy3'];
                
            }
        }
        else if($yjmbtype=='5')
        {
            //合同数
            $usersx=$usersx==''?'':" and ht_fz $usersx ";
            $myht=parent::sel_more_data("crm_hetong","ht_data,ht_fz","ht_yh='$fid' $usersx ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($j['zdy7']!='canshu3')
                {
                    //判断是否为成功结束
                    continue;
                }
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $r[$v['ht_fz']]++;
            }
        }
        else if($yjmbtype=='6')
        {
            //产品销量
            //合同查询
            $h=$this->get_my_htid_and_user($fid,$tarr,$usersx);
            $htid=$h["id"];
            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='7')
        {
            //产品销售额
            //合同查询
            $h=$this->get_my_htid_and_user($fid,$tarr,$usersx);
            $htid=$h["id"];
            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_zj'];
            }
        }
        else if($yjmbtype=='8')
        {
            //产品分类销量
            //合同查询
            $h=$this->get_my_htid_and_user($fid,$tarr,$usersx);
            $htid=$h["id"];
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='9')
        {
            //产品分类销售额
            //合同查询
            $h=$this->get_my_htid_and_user($fid,$tarr,$usersx);
            $htid=$h["id"];
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            foreach($cp as $v)
            {
                $r[$h['darr'][$v['sj_id']]]+=$v['cp_zj'];
            }
        }
        else
        {
            echo "未知错误";die;
        }
        

        return $r;

    }
}