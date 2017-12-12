<?php
namespace Home\Controller;
use Think\Controller;


class MainController extends DBController {
    public $no_mb='<div class="no_mb">未设置业绩目标<br />无法计算排名<br /><span class="no_mb_ts">可在设置中心设置业绩目标</span></div>';
    public $no_mb2='<div class="no_mb">无排名</div>';
    public function index(){
        parent::is_login2(2);
        $fid=parent::get_fid();
        //公告查询
        $gonggao=parent::sel_more_data("crm_ggshezhi","ggsz_id,ggsz_name,ggsz_kjfw,ggsz_kjid,ggsz_fbsj,ggsz_fbr,ggsz_zd,ggsz_zd_sj","ggsz_yh='$fid' order by ggsz_id desc");
        //parent::rr($gonggao);
        foreach($gonggao as $v)
        {
            //先判断权限--首先判断如果不是超级管理员，就判断权限
            if(cookie("user_fid")!='0')
            {
                if($v['ggsz_kjfw']=='2')
                {
                    $quanxianarr=explode(',',$v['ggsz_kjid']);
                    if(!in_array(cookie("user_zhu_bid",$quanxianarr)))
                    {
                        continue;
                    }
                }
                if($v['ggsz_kjfw']=='3')
                {
                    $quanxianarr=explode(',',$v['ggsz_kjid']);
                    if(!in_array(cookie("user_quanxian",$quanxianarr)))
                    {
                        continue;
                    }
                }
            }
            
            if($v['ggsz_zd']!='0')
            {
                $tosj=strtotime($v['ggsz_zd_sj']);
                $zhiding[$tosj]=$v;
            }
            else
            {
                $buzhiding[]=$v;
            }
        }
        $zhidingnum=count($zhiding);
        $gonggaostr='';
        if($zhidingnum)
        {
            krsort($zhiding);
            foreach($zhiding as $v)
            {
                $gonggaostr.='<div><span class="gonggao_row_title"><a href="'.__ROOT__.'/index.php/Home/Option/gonggaomore?ggid='.$v['ggsz_id'].'&from=main2">'.$v['ggsz_name'].'</a></span><span class="zhiding">置顶</span><span class="gonggao_row_time">'.substr($v['ggsz_fbsj'],5).'</span></div>';
            }
            if($zhidingnum<7)
            {
                $buzhidingnum=7-$zhidingnum;
                foreach($buzhiding as $v)
                {
                    if($buzhidingnum==0)
                    {
                        break;
                    }
                    $buzhidingnum--;
                    $gonggaostr.='<div><span class="gonggao_row_title"><a href="'.__ROOT__.'/index.php/Home/Option/gonggaomore?ggid='.$v['ggsz_id'].'&from=main2">'.$v['ggsz_name'].'</a></span><span class="gonggao_row_time">'.substr($v['ggsz_fbsj'],5).'</span></div>';
                }
            }
        }
        else
        {
            $buzhidingnum=7;
            foreach($buzhiding as $v)
            {
                if($buzhidingnum==0)
                {
                    break;
                }
                $buzhidingnum--;
                $gonggaostr.='<div><span class="gonggao_row_title"><a href="'.__ROOT__.'/index.php/Home/Option/gonggaomore?ggid='.$v['ggsz_id'].'&from=main2">'.$v['ggsz_name'].'</a></span><span class="gonggao_row_time">'.substr($v['ggsz_fbsj'],5).'</span></div>';
            }
        }
        $gonggaostr=$gonggaostr==''?'<div><span class="gonggao_row_title" style="text-align:center;">暂无公告</span><span class="gonggao_row_time"></span></div>':$gonggaostr;
        
        //业绩目标下拉框的显示
        $nowyear=date("Y",time());
        $nowmonth=date("m",time());
        $yjselarr=parent::sel_more_data("crm_yjmb","yjmb_id,yjmb_type,yjmb_type_more","yjmb_yh='$fid' and yjmb_nd='$nowyear'");
        
        if(count($yjselarr)>0)
        {
            foreach($yjselarr as $v)
            {
                $thisname=$this->get_yjmb_name($v['yjmb_type'],$v['yjmb_type_more']);
                $yjmbselstr.="<option value='".$v['yjmb_id']."'>".$thisname."</option>";
                $mbid_to_type[$v['yjmb_id']]=$v['yjmb_type'];
                $mbid_to_more[$v['yjmb_id']]=$v['yjmb_type_more'];
            }
            
            //业绩目标显示
            //----获取默认显示的业绩目标类型
            $get_mubiao_id=$_GET['mubiaotype'];
            $yji1=$get_mubiao_id==''?$yjselarr[0]['yjmb_id']:$get_mubiao_id;
            $yj1=$get_mubiao_id==''?$yjselarr[0]['yjmb_type']:$mbid_to_type[$get_mubiao_id];
            $yjm1=$get_mubiao_id==''?$yjselarr[0]['yjmb_type_more']:$mbid_to_more[$get_mubiao_id];
            $yjt1=$_GET['mubiaotime']==''?'1':$_GET['mubiaotime'];//本月

            $mbinfo=$this->get_yjmb($yj1,$yjm1,$yjt1,$yji1);
            //parent::rr($mbinfo);
            //销售排名
            $get_paihangtype=$_GET['paihangtype'];
            $paihang_yj1=$get_paihangtype==''?$yjselarr[0]['yjmb_type']:$mbid_to_type[$get_paihangtype];
            $paihang_yjm1=$get_paihangtype==''?$yjselarr[0]['yjmb_type_more']:$mbid_to_more[$get_paihangtype];
            
            $pm=$this->xiaoshoupaihang($paihang_yj1,$paihang_yjm1);
        }
        else
        {
            //数据为空时的展示信息
            $mbinfo[0]=$mbinfo[1]=$mbinfo[2]=0;
            //$jb[1]=$jb[2]=$jb[3]=$jb[4]=$jb[5]=$jb[6]=$jb[7]=$jb[8]=$jb[9]=$jb[10]=0;
            $pm[0]=$pm[1]=$pm[2]=$this->no_mb;
            $yjmbselstr='<option value="">未设置业绩目标</option>';
        }
        //销售简报
        $jianbaotime=$_GET['jianbaotime']==''?'0':$_GET['jianbaotime'];
        $jb=$this->xiaoshoujianbao($fid,$jianbaotime);

        //销售助手
        $zhushouarr=$this->xiaoshouzhushou();
        //审批数量
        $spnum=$this->shenpi_num();


        //公告字符串
        $this->assign("gonggaostr",$gonggaostr);
        //业绩目标下拉框
        $this->assign("yjmbselstr",$yjmbselstr);
        //扇图的数据--完成
        $this->assign("chart_wancheng",$mbinfo[0]);
        $this->assign("chart_wancheng2",number_format($mbinfo[0],2));
        //扇图的数据--目标
        $this->assign("chart_mubiao",$mbinfo[1]);
        $this->assign("chart_mubiao2",number_format($mbinfo[2],2));
        //销售简报的数据
        $this->assign("jianbaoarr",$jb);
        //销售排名的数据
        $this->assign("paihang1",($pm[0]==''?$this->no_mb2:$pm[0]));
        $this->assign("paihang2",($pm[1]==''?$this->no_mb2:$pm[1]));
        $this->assign("paihang3",($pm[2]==''?$this->no_mb2:$pm[2]));
        //销售助手数据
        $this->assign("zhushou",$zhushouarr);
        //审批数量数据
        $this->assign("sp",$spnum);
        $this->display();
    }



    //业绩目标的算法
    public function get_yjmb($yjmbtype,$yjmbmore,$timetype,$yjid)
    {
        $fid=parent::get_fid();
        $r=array();
        //判断时间
        $tarr=$this->detime($timetype);
        if($yjmbtype=='1')
        {
            //赢单商机金额
            /*
                负责人为登录用户的商机中  赢单的金额
            */
            //查询商机数据  预计销售金额zdy3  预计签单日期zdy4  销售阶段zdy5  赢单canshu5
            $shangji=parent::sel_more_data("crm_shangji","sj_data","sj_yh='$fid' and sj_fz='".cookie("user_id")."'");
            $je=0;
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $je+=$j['zdy3'];
            }
            $r[0]=$je;
        }
        else if($yjmbtype=='2')
        {
            //赢单商机数
            $shangji=parent::sel_more_data("crm_shangji","sj_data","sj_yh='$fid' and sj_fz='".cookie("user_id")."'");
            $num=0;
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $num++;
            }
            $r[0]=$num;
        }
        else if($yjmbtype=='3')
        {
            //合同回款金额
            /*
                找到我负责的合同
            */
            //查询我的合同回款
            $myht=parent::sel_more_data("crm_hetong","ht_id","ht_fz='".cookie("user_id")."' and ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $hk_in_str.="'".$v['ht_id']."',";
            }
            $hk_in_str=substr($hk_in_str,0,-1);
            //查询回款
            $myhk=parent::sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_sp='1' and hk_ht in ($hk_in_str)");
            $hknum=0;
            foreach($myhk as $v)
            {
                if($this->date_to_date($v['hk_data'])<$tarr['s']||$this->date_to_date($v['hk_data'])>$tarr['e'])
                {
                    continue;
                }
                $hknum+=$v['hk_je'];
            }
            $r[0]=$hknum;
        }
        else if($yjmbtype=='4')
        {
            //合同金额
            /*
                合同总金额zdy3  签约日期zdy4
            */
            $myht=parent::sel_more_data("crm_hetong","ht_data","ht_yh='$fid' and ht_fz='".cookie('user_id')."' and ht_sp='1'");
            $je=0;
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
                $je+=$j['zdy3'];
            }
            $r[0]=$je;
        }
        else if($yjmbtype=='5')
        {
            //合同数
            $myht=parent::sel_more_data("crm_hetong","ht_data","ht_yh='$fid' and ht_fz='".cookie('user_id')."' and ht_sp='1'");
            $num=0;
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
                $num++;
            }
            $r[0]=$num;
        }
        else if($yjmbtype=='6')
        {
            //产品销量
            //合同查询
            $htid=$this->get_my_htid($fid);
            $cp=parent::sel_more_data("crm_cp_sj","cp_num1","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_num1'];
            }
            $r[0]=$num;
        }
        else if($yjmbtype=='7')
        {
            //产品销售额
            //合同查询
            $htid=$this->get_my_htid($fid);
            $cp=parent::sel_more_data("crm_cp_sj","cp_zj","cp_yh='$fid' and cp_id='$yjmbmore' and sj_id in ($htid)");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_zj'];
            }
            $r[0]=$num;
        }
        else if($yjmbtype=='8')
        {
            //产品分类销量
            //合同查询
            $htid=$this->get_my_htid($fid);
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_num1","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            $num=0;
            foreach($cp as $v)
            {
                $num++;
            }
            $r[0]=$num;
        }
        else if($yjmbtype=='9')
        {
            //产品分类销售额
            //合同查询
            $htid=$this->get_my_htid($fid);
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_zj","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_zj'];
            }
            $r[0]=$num;
        }
        else
        {
            echo "未知错误";die;
        }
        //查询目标数据
        $mbje=$this->get_yj_all($timetype,$yjid,$fid);
        $c=$mbje-$r[0];
        $c=$c<0?0:$c;
        $r[1]=$c;
        $r[2]=$mbje;
        return $r;
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
    //获取开始时间和结束时间
    public function detime($timenum)
    {
        
        if($timenum=='1')
        {
            //本月
            $t1=date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
            $t2=date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));

        }
        else if($timenum=='0')
        {
            //本周
            $t1=date("Y-m-d H:i:s",strtotime("Monday"));
            $t2=date("Y-m-d",strtotime("Sunday")).' 23:59:59';   
        }
        else if($timenum=='2')
        {
            //本季度
            $nowm=date("m",time());
            $nowyear=date("Y",time());
            if($nowm>=1&&$nowm<4)
            {
                //第一季度
                $t1=$nowyear.'-01-01 00:00:00';
                $t2=$nowyear.'-03-31 23:59:59';
            }
            else if($nowm>=4&&$nowm<7)
            {  
                //第二季度
                $t1=$nowyear.'-04-01 00:00:00';
                $t2=$nowyear.'-06-30 23:59:59';
            }
            else if($nowm>=7&&$nowm<10)
            {
                //第三季度
                $t1=$nowyear.'-07-01 00:00:00';
                $t2=$nowyear.'-09-30 23:59:59';
            }
            else
            {
                //第四季度
                $t1=$nowyear.'-10-01 00:00:00';
                $t2=$nowyear.'-12-31 23:59:59';
            }
        }
        else
        {
            //本年
            $t1=date('Y',time()).'-01-01 00:00:00';
            $t2=date('Y',time()).'-12-31 23:59:59';
        }
        $t['s']=$t1;
        $t['e']=$t2;
        return $t;
    }
    //查询我的合同
    public function get_my_htid($fid)
    {
        //合同查询
        $myht=parent::sel_more_data("crm_hetong","ht_id,ht_data","ht_yh='$fid' and ht_fz='".cookie('user_id')."' and ht_sp='1'");
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
            $htid.="'".$v['ht_id']."',";
        }
        $htid=substr($htid,0,-1);
        return $htid;
    }

    //规范时间
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
    //获得业绩总额
    public function get_yj_all($ttype,$yjid,$fid)
    {
        $yjarr=parent::sel_more_data("crm_yjmb_user","*","yjm_fid='$fid' and yjm_yid='$yjid' and yjm_uid='".cookie("user_id")."' limit 1");
        $yjarr=$yjarr[0];
        $nowm=date("m",time());
        $nowm=$nowm<10?substr($nowm,1):$nowm;
        if($ttype=='1')
        {
            return $yjarr['yjm_m'.$nowm];
        }
        if($ttype=='2')
        {
            if($nowm=='1'||$nowm=='2'||$nowm=='3')
            {
                return ($yjarr['yjm_m1']+$yjarr['yjm_m2']+$yjarr['yjm_m3']);
            }
            if($nowm=='4'||$nowm=='5'||$nowm=='6')
            {
                return ($yjarr['yjm_m4']+$yjarr['yjm_m5']+$yjarr['yjm_m6']);
            }
            if($nowm=='7'||$nowm=='8'||$nowm=='9')
            {
                return ($yjarr['yjm_m7']+$yjarr['yjm_m8']+$yjarr['yjm_m9']);
            }
            if($nowm=='10'||$nowm=='11'||$nowm=='12')
            {
                return ($yjarr['yjm_m10']+$yjarr['yjm_m11']+$yjarr['yjm_m12']);
            }
        }
        if($ttype=='3')
        {
            return ($yjarr['yjm_m1']+$yjarr['yjm_m2']+$yjarr['yjm_m3']+$yjarr['yjm_m4']+$yjarr['yjm_m5']+$yjarr['yjm_m6']+$yjarr['yjm_m7']+$yjarr['yjm_m8']+$yjarr['yjm_m9']+$yjarr['yjm_m10']+$yjarr['yjm_m11']+$yjarr['yjm_m12']);
        }
    }
    //销售简报
    protected function xiaoshoujianbao($fid,$timenum)
    {
        $tarr=$this->detime($timenum);
        //合同--成交
        $htnum=0;//合同数
        $zongnum=0;//合同总金额
        $hknum=0;//已回款金额
        $hknum2=0;//计划回款
        $myht=parent::sel_more_data("crm_hetong","ht_id,ht_data","ht_fz='".cookie("user_id")."' and ht_yh='$fid' and ht_sp='1' ");
        foreach($myht as $v)
        {
            $j=json_decode($v['ht_data'],true);
            /*
            2017年11月28日10:45:19将取成交状态的合同改为取审批通过的合同
            if($j['zdy7']!='canshu3')
            {
                //判断是否为成交
                continue;
            }
            */
            $zongnum+=$j['zdy3'];
            $htnum++;
            $hk_in_str.="'".$v['ht_id']."',";
        }
        $hk_in_str=substr($hk_in_str,0,-1);
        //查询回款
        $myhk=parent::sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_ht in ($hk_in_str)");
        foreach($myhk as $v)
        {
            if($this->date_to_date($v['hk_data'])<$tarr['s']||$this->date_to_date($v['hk_data'])>$tarr['e'])
            {
                continue;
            }
            if($v['hk_sp']='1')
            {
                //已回款
                $hknum+=$v['hk_je'];
            }
            if($v['hk_sp']!='1')
            {
                //计划回款
                $hknum2+=$v['hk_je'];
            }
        }

        //预测--商机 预计金额zdy3预计日期zdy4
        $mysj=parent::sel_more_data("crm_shangji","sj_data","sj_yh='$fid' and sj_fz='".cookie("user_id")."'");
        $yjnum=0;//预计签单数
        $yjje=0;//预计金额
        foreach($mysj as $v)
        {
            $j=json_decode($v['sj_data'],true);
            $d=$this->date_to_date($j['zdy4']);
            if($d<$tarr['s']||$d>$tarr['e'])
            {
                continue;
            }
            $yjnum++;
            $yjje+=$j['zdy3'];
        }

        //新增线索1客户2联系人4商机5合同6产品7
        $ts2=strtotime($tarr['s']);
        $te2=strtotime($tarr['e']);
        $xinzeng=parent::sel_more_data("crm_rz","rz_mode","rz_type='1' and rz_yh='$fid' and rz_cz_type='1' and rz_user='".cookie("user_id")."' and rz_mode in ('1','2','5') and rz_time>='$ts2' and rz_time<='$te2' ");
        $add[1]=0;
        $add[2]=0;
        $add[5]=0;
        foreach($xinzeng as $v)
        {
            $add[$v['rz_mode']]++;
        }
        //写跟进次数
        $genjin=parent::sel_more_data("crm_xiegenjin","*","genjin_yh='$fid' and user_id='".cookie("user_id")."' and ((add_time>='$ts2' and add_time<='$te2') or (add_time>='".$tarr['s']."' and add_time<='".$tarr['e']."'))");
        $genjinnum=count($genjin);
        $r[1]=$htnum;
        $r[2]=number_format($zongnum,2);
        $r[3]=number_format($hknum,2);
        $r[4]=$yjnum;
        $r[5]=number_format($yjje,2);
        $r[6]=number_format($hknum2,2);
        $r[7]=$add[1];
        $r[8]=$add[2];
        $r[9]=$add[5];
        $r[10]=$genjinnum;

        return $r;
    }
    //销售排行
    protected function xiaoshoupaihang($yjmbtype,$yjmbmore)
    {
        $paiming_num=7;//排名数量

        $fid=parent::get_fid();

        //获取所有用户
        $alluser=parent::sel_more_data("crm_user","user_id,user_name","user_del='0' and (user_id='$fid' or user_fid='$fid')");
        foreach($alluser as $v)
        {
            $usernamearr[$v['user_id']]=$v['user_name'];
        }
        
        //获取所有业绩//根据用户划分业绩
        //--时间：获取今年一年的
        $tarr=$this->detime(3);//本年
        $tarr1=$this->detime(2);//本季度
        $tarr2=$this->detime(1);//本月
        $r=array();
        if($yjmbtype=='1')
        {
            //赢单商机金额
            /*
                负责人为登录用户的商机中  赢单的金额
            */
            //查询商机数据  预计销售金额zdy3  预计签单日期zdy4  销售阶段zdy5  赢单canshu5
            $shangji=parent::sel_more_data("crm_shangji","sj_data,sj_fz","sj_yh='$fid'");
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                if($v['sj_fz']=='')
                {
                    continue;
                }
                if($sjt>=$tarr1['s']&&$sjt<=$tarr1['e'])
                {
                    $r1[$v['sj_fz']]+=$j['zdy3'];
                }
                if($sjt>=$tarr2['s']&&$sjt<=$tarr2['e'])
                {
                    $r2[$v['sj_fz']]+=$j['zdy3'];
                }
                $r[$v['sj_fz']]+=$j['zdy3'];
            }
        }
        else if($yjmbtype=='2')
        {
            //赢单商机数
            $shangji=parent::sel_more_data("crm_shangji","sj_data,sj_fz","sj_yh='$fid' ");
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                if($v['sj_fz']=='')
                {
                    continue;
                }
                if($sjt>=$tarr1['s']&&$sjt<=$tarr1['e'])
                {
                    $r1['sj_fz']++;
                }
                if($sjt>=$tarr2['s']&&$sjt<=$tarr2['e'])
                {
                    $r2['sj_fz']++;
                }
                $r['sj_fz']++;
            }
        }
        else if($yjmbtype=='3')
        {
            //合同回款金额
            /*
                找到我负责的合同
            */
            //查询我的合同回款
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz"," ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $ht_fz[$v['ht_id']]=$v['ht_fz'];
            }
            //查询回款
            $myhk=parent::sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_sp='1' ");
            foreach($myhk as $v)
            {
                $tt=$this->date_to_date($v['hk_data']);
                if($tt<$tarr['s']||$tt>$tarr['e'])
                {
                    continue;
                }
                if($tt>=$tarr1['s']&&$tt<=$tarr1['e'])
                {
                    $r1[$ht_fz[$v['hk_ht']]]+=$v['hk_je'];
                }
                if($tt>=$tarr2['s']&&$tt<=$tarr2['e'])
                {
                    $r2[$ht_fz[$v['hk_ht']]]+=$v['hk_je'];
                }
                $r[$ht_fz[$v['hk_ht']]]+=$v['hk_je'];
            }
        }
        else if($yjmbtype=='4')
        {
            //合同金额
            /*
                合同总金额zdy3  签约日期zdy4
            */
            $myht=parent::sel_more_data("crm_hetong","ht_data,ht_fz","ht_yh='$fid' and ht_sp='1' ");
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
                if($v['ht_fz']=='')
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $r1[$v['ht_fz']]+=$j['zdy3'];
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $r2[$v['ht_fz']]+=$j['zdy3'];
                }
                $r[$v['ht_fz']]+=$j['zdy3'];
            }
        }
        else if($yjmbtype=='5')
        {
            //合同数
            $myht=parent::sel_more_data("crm_hetong","ht_data,ht_fz","ht_yh='$fid' and ht_sp='1'");
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
                if($v['ht_fz']=='')
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $r1[$v['ht_fz']]++;
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $r2[$v['ht_fz']]++;
                }
                $r[$v['ht_fz']]++;
            }
        }
        else if($yjmbtype=='6')
        {
            //产品销量
            //合同查询
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz,ht_data"," ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $ht_fz1[$v['ht_id']]=$v['ht_fz'];
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $ht_fz2[$v['ht_id']]=$v['ht_fz'];
                }
                $ht_fz[$v['ht_id']]=$v['ht_fz'];
            }
            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id='$yjmbmore' ");
            foreach($cp as $v)
            {
                if(in_array($v['sj_id'],$ht_fz1))
                {
                    $r1[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                if(in_array($v['sj_id'],$ht_fz2))
                {
                    $r2[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                $r[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='7')
        {
            //产品销售额
            //合同查询
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz"," ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $ht_fz1[$v['ht_id']]=$v['ht_fz'];
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $ht_fz2[$v['ht_id']]=$v['ht_fz'];
                }
                $ht_fz[$v['ht_id']]=$v['ht_fz'];
            }
            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id='$yjmbmore'");
            foreach($cp as $v)
            {
                if(in_array($v['sj_id'],$ht_fz1))
                {
                    $r1[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                if(in_array($v['sj_id'],$ht_fz2))
                {
                    $r2[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                $r[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='8')
        {
            //产品分类销量
            //合同查询
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz"," ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $ht_fz1[$v['ht_id']]=$v['ht_fz'];
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $ht_fz2[$v['ht_id']]=$v['ht_fz'];
                }
                $ht_fz[$v['ht_id']]=$v['ht_fz'];
            }
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_num1,sj_id","cp_yh='$fid' and cp_id in ($cpid)");
            foreach($cp as $v)
            {
                if(in_array($v['sj_id'],$ht_fz1))
                {
                    $r1[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                if(in_array($v['sj_id'],$ht_fz2))
                {
                    $r2[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                $r[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else if($yjmbtype=='9')
        {
            //产品分类销售额
            //合同查询
            $myht=parent::sel_more_data("crm_hetong","ht_id,ht_fz"," ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=$this->date_to_date($j['zdy4']);
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                if($d>=$tarr1['s']&&$d<=$tarr1['e'])
                {
                    $ht_fz1[$v['ht_id']]=$v['ht_fz'];
                }
                if($d>=$tarr2['s']&&$d<=$tarr2['e'])
                {
                    $ht_fz2[$v['ht_id']]=$v['ht_fz'];
                }
                $ht_fz[$v['ht_id']]=$v['ht_fz'];
            }
            //该分类的产品查询--获得本分类下的所有产品
            $cp=parent::sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$yjmbmore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=parent::sel_more_data("crm_cp_sj","cp_zj,sj_id","cp_yh='$fid' and cp_id in ($cpid) ");
            foreach($cp as $v)
            {
                if(in_array($v['sj_id'],$ht_fz1))
                {
                    $r1[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                if(in_array($v['sj_id'],$ht_fz2))
                {
                    $r2[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
                }
                $r[$ht_fz[$v['sj_id']]]+=$v['cp_num1'];
            }
        }
        else
        {
            echo "未知错误";die;
        }
        
        //进行排名操作
        arsort($r);
        arsort($r1);
        arsort($r2);



        //抽出前N名的用户和业绩
        $pmhtml='';
        $pmhtml1='';
        $pmhtml2='';
        $pmhead=array(
            "0"=>"1st",
            "1"=>"2nd",
            "2"=>"3rd",
            "3"=>"4",
            "4"=>"5",
            "5"=>"6",
            "6"=>"7"
        );
        $fnum=0;
        foreach($r as $k=>$v)
        {
            if($fnum==$paiming_num)
            {
                $fnum=0;
                break;
            }
            if($usernamearr[$k]=='')
            {
                continue;
            }
            $phmod2=$fnum>2?'phmod2':'';
            $pmhtml.='  <div class="ph_mod '.$phmod2.'">
                            <div class="ph_num">'.$pmhead[$fnum].'</div>
                            <div class="ph_body">
                                <div class="ph_name">'.$usernamearr[$k].'</div>
                                <div class="ph_je">'.number_format($v,2).'</div>
                            </div>
                        </div>';
            $fnum++;
        }
        $fnum=0;
        foreach($r1 as $k=>$v)
        {
            if($fnum==$paiming_num)
            {
                $fnum=0;
                break;
            }
            $phmod2=$fnum>2?'phmod2':'';
            $pmhtml1.='  <div class="ph_mod '.$phmod2.'">
                            <div class="ph_num">'.$pmhead[$fnum].'</div>
                            <div class="ph_body">
                                <div class="ph_name">'.$usernamearr[$k].'</div>
                                <div class="ph_je">'.number_format($v,2).'</div>
                            </div>
                        </div>';
            $fnum++;
        }
        $fnum=0;
        foreach($r2 as $k=>$v)
        {
            if($fnum==$paiming_num)
            {
                $fnum=0;
                break;
            }
            $phmod2=$fnum>2?'phmod2':'';
            $pmhtml2.='  <div class="ph_mod '.$phmod2.'">
                            <div class="ph_num">'.$pmhead[$fnum].'</div>
                            <div class="ph_body">
                                <div class="ph_name">'.$usernamearr[$k].'</div>
                                <div class="ph_je">'.number_format($v,2).'</div>
                            </div>
                        </div>';
            $fnum++;
        }
        $res['0']=$pmhtml2;
        $res['1']=$pmhtml1;
        $res['2']=$pmhtml;

        return $res;
    }
    //销售助手的一些查询
    public function xiaoshouzhushou()
    {
        $fid=parent::get_fid();
        $zhushou1=0;
        $zhushou2=0;
        $zhushou3=0;
        $zhushouid1='';
        $zhushouid2='';
        $zhushouid3='';
        //七天内过生日的联系人
            /*查找属于我的客户，再找到属于这些客户的联系人*/
        $kehu=parent::sel_more_data("crm_kh","kh_id","kh_yh='$fid' and kh_fz='".cookie("user_id")."'");
        foreach($kehu as $v)
        {
            $kh_arr[]=$v['kh_id'];
        }
        $lianxiren=parent::sel_more_data("crm_lx","lx_id,lx_data","lx_yh='$fid'");
        //parent::rr($lianxiren);
        //从现在开始到七天后的日期
        $s=date("Y-m-d",time());
        $e=date("Y-m-d",strtotime($s.' +7 days'));
        foreach($lianxiren as $v)
        {
            if($v['lx_data']=='')
            {
                continue;
            }
            $j=json_decode($v['lx_data'],true);
            //去掉不属于登录用户的客户的联系人
            if(!in_array($j['zdy1'],$kh_arr))
            {
                continue;
            }
            //去掉未填写生日的联系人
            $sr=$j['zdy15'];
            if($sr=='')
            {
                continue;
            }
            if($sr<$s||$sr>$e)
            {
                continue;
            }
            $zhushou1++;
            $zhushouid1.=$v['lx_id'].',';
        }
        //超过七天未跟进的客户
        $kh=parent::sel_more_data("crm_kh","kh_id,kh_sj_gj_date","kh_yh='$fid' and kh_fz='".cookie("user_id")."'");
        
        foreach($kh as $v)
        {
            if($v['kh_sj_gj_date']=='')
            {
                continue;
            }
            $d=$this->date_to_date($v['kh_sj_gj_date']);
            if($d>=$s&&$d<=$e)
            {
                $zhushou2++;
                $zhushouid2.=$v['kh_id'].',';
            }
        }
        
        //七天内需要回款的合同
        //合同查询
        $myht=parent::sel_more_data("crm_hetong","ht_id","ht_yh='$fid' and ht_fz='".cookie('user_id')."' and ht_sp='1'");
        $htid='';
        foreach($myht as $v)
        {
            $htid.="'".$v['ht_id']."',";
        }
        $htid=substr($htid,0,-1);

        $hkarr=parent::sel_more_data("crm_hk","hk_id","hk_yh='$fid' and hk_htid in ($htid) and hk_data>='$s' and hk_data<='$e'");
        foreach($hkarr as $v)
        {
            $zhushou3++;
            $zhushouid3.=$v['hk_id'].',';
        }
        $zhushouid1=substr($zhushouid1,0,-1);
        $zhushouid2=substr($zhushouid2,0,-1);
        $zhushouid3=substr($zhushouid3,0,-1);
        
        $r['num'][1]=$zhushou1;
        $r['num'][2]=$zhushou2;
        $r['num'][3]=$zhushou3;
        $r['id'][1]=$zhushouid1;
        $r['id'][2]=$zhushouid2;
        $r['id'][3]=$zhushouid3;
        
        return $r;
    }
    //需要审批的数量获取
    public function shenpi_num()
    {
        $fid=parent::get_fid();
        $u=$fid==cookie("user_id")?"":"and sp_user='".cookie("user_id")."'";
        $sp=parent::sel_more_data("crm_sp","sp_sjid","sp_yh='$fid' $u  and sp_jg='0' ");
        
        $sp2='';
        foreach($sp as $k=>$v)
        {
            $sp2[$v['sp_sjid']]=$v;
        }
        
        $sp=$sp2;
        $spnum=$sp==''?0:count($sp);
        $style='';
        if($spnum<1)
        {
            $style='style="background:#1AA094"';
        }
        else if($spnum>=1&&$spnum<=15)
        {
            $style='style="background:#FF6633"';
        }
        else
        {
            $style='';
        }
        $r['color']=$style;
        $r['num']=$spnum;
        return $r;
    }
}
