<?php
namespace Home\Controller;
use Think\Controller;


class AppBenchController extends AppPublicController {
    public function getMain($u)
    {
        $m=M();
        //业绩目标列表
        $mblist=$this->mblist($u);
        //默认首个业绩目标的值
        $firstmb=$mblist[0];
        $firstmbdata=$this->mbInfo($u,$firstmb['yjmb_id'],$firstmb['yjmb_type'],$firstmb['yjmb_type_more']);
        //最近的五个公告
        $gonggaodata=$this->gonggao($u,5);//5个公告,置顶优先
        //待审批的数量
        $spnum=$this->shenpi_num($u);
        $r['code']='0';
        $r['mblist']=$mblist;
        $r['firstmbdata']=$firstmbdata;
        $r['gonggaodata']=$gonggaodata;
        $r['spnum']=$spnum;
        echo json_encode($r);
    }
    //当切换业绩目标类型时调用的方法
    public function changemb($u,$id)
    {
        $m=M();
        $nowyear=date("Y",time());
        $data=$m->query("select * from crm_yjmb where yjmb_id='$id' and yjmb_yh='$u[fid]' and yjmb_nd='$nowyear'");
        $mbinfo=$this->mbInfo($u,$id,$data[0]['yjmb_type'],$data[0]['yjmb_type_more']);
        $res['code']='0';
        $res['data']=$mbinfo;
        echo json_encode($res);
    }
    /*
        获取业绩目标详情
        $u 用户信息数组
        $mbid 获取业绩目标的id
        $mbtype  业绩目标的种类
        $mbtypemore 产品或产品分类的id 
    */
    protected function mbInfo($u,$mbid,$mbtype,$mbtypemore)
    {
        $fid=$u['fid'];
        $r=array();
        //时间。使用本月的
        //$tarr=$this->detime($timetype);
        $tarr['s']=date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
        $tarr['e']=date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));
        if($mbtype=='1')
        {
            //赢单商机金额
            /*
                负责人为登录用户的商机中  赢单的金额
            */
            //查询商机数据  预计销售金额zdy3  预计签单日期zdy4  销售阶段zdy5  赢单canshu5
            $shangji=$this->sel_more_data("crm_shangji","sj_data","sj_yh='$fid' and sj_fz='".$u['user_id']."'");
            $je=0;
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=parent::date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $je+=$j['zdy3'];
            }
            $r[0]=$je;
        }
        else if($mbtype=='2')
        {
            //赢单商机数
            $shangji=$this->sel_more_data("crm_shangji","sj_data","sj_yh='$fid' and sj_fz='".$u['user_id']."'");
            $num=0;
            foreach($shangji as $v)
            {
                $j=json_decode($v['sj_data'],true);
                //parent::rr($j);
                if($j['zdy5']!='canshu5')
                {
                    continue;
                }
                $sjt=parent::date_to_date($j['zdy4']);
                if($sjt<$tarr['s']||$sjt>$tarr['e'])
                {
                    continue;
                }
                $num++;
            }
            $r[0]=$num;
        }
        else if($mbtype=='3')
        {
            //合同回款金额
            /*
                找到我负责的合同
            */
            //查询我的合同回款
            $myht=$this->sel_more_data("crm_hetong","ht_id","ht_fz='".$u['user_id']."' and ht_yh='$fid' and ht_sp='1' ");
            foreach($myht as $v)
            {
                $hk_in_str.="'".$v['ht_id']."',";
            }
            $hk_in_str=substr($hk_in_str,0,-1);
            //查询回款
            $myhk=$this->sel_more_data("crm_hkadd","*","hk_yh='$fid' and hk_sp='1' and hk_ht in ($hk_in_str)");
            $hknum=0;
            foreach($myhk as $v)
            {
                if(parent::date_to_date($v['hk_data'])<$tarr['s']||parent::date_to_date($v['hk_data'])>$tarr['e'])
                {
                    continue;
                }
                $hknum+=$v['hk_je'];
            }
            $r[0]=$hknum;
        }
        else if($mbtype=='4')
        {
            //合同金额
            /*
                合同总金额zdy3  签约日期zdy4
            */
            $myht=$this->sel_more_data("crm_hetong","ht_data","ht_yh='$fid' and ht_fz='".$u['user_id']."' and ht_sp='1'");
            $je=0;
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=parent::date_to_date($j['zdy4']);
        
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $je+=$j['zdy3'];
            }
            $r[0]=$je;
        }
        else if($mbtype=='5')
        {
            //合同数
            $myht=$this->sel_more_data("crm_hetong","ht_data","ht_yh='$fid' and ht_fz='".$u['user_id']."' and ht_sp='1'");
            $num=0;
            foreach($myht as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $d=parent::date_to_date($j['zdy4']);
 
                if($d<$tarr['s']||$d>$tarr['e'])
                {
                    continue;
                }
                $num++;
            }
            $r[0]=$num;
        }
        else if($mbtype=='6')
        {
            //产品销量
            //合同查询
            $htid=$this->get_my_htid($fid,$u,$tarr);
            $cp=$this->sel_more_data("crm_cp_sj","cp_num1","cp_yh='$fid' and cp_id='$mbtypemore' and sj_id in ($htid)");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_num1'];
            }
            $r[0]=$num;
        }
        else if($mbtype=='7')
        {
            //产品销售额
            //合同查询
            $htid=$this->get_my_htid($fid,$u,$tarr);
            $cp=$this->sel_more_data("crm_cp_sj","cp_zj","cp_yh='$fid' and cp_id='$mbtypemore' and sj_id in ($htid)");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_zj'];
            }
            $r[0]=$num;
        }
        else if($mbtype=='8')
        {
            //产品分类销量
            //合同查询
            $htid=$this->get_my_htid($fid,$u,$tarr);
            //该分类的产品查询--获得本分类下的所有产品
            $cp=$this->sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$mbtypemore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=$this->sel_more_data("crm_cp_sj","cp_num1","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            $num=0;
            foreach($cp as $v)
            {
                $num++;
            }
            $r[0]=$num;
        }
        else if($mbtype=='9')
        {
            //产品分类销售额
            //合同查询
            $htid=$this->get_my_htid($fid,$u,$tarr);
            //该分类的产品查询--获得本分类下的所有产品
            $cp=$this->sel_more_data("crm_chanpin","cp_id","cp_yh='$fid' and cp_del='0' and cp_data like '%\"zdy6\":\"".$mbtypemore."\"%' ");
            $cpid='';
            foreach($cp as $v)
            {
                $cpid.="'".$v['cp_id']."',";
            }
            $cpid=substr($cpid,0,-1);

            $cp=$this->sel_more_data("crm_cp_sj","cp_zj","cp_yh='$fid' and cp_id in ($cpid) and sj_id in ($htid) ");
            $num=0;
            foreach($cp as $v)
            {
                $num+=$v['cp_zj'];
            }
            $r[0]=$num;
        }
        else
        {
            echo "0";die;
        }
        //查询目标数据
        $mbje=$this->get_yj_all($mbid,$fid,$u);
        $mbje=$mbje==''?0:$mbje;
        $c=$mbje-$r[0];
        $c=$c<0?0:$c;
        $r[1]=$c;
        $r[2]=$mbje;
        /*
        0已完成
        1未完成
        2总
        */
        return $r;
    }
    public function get_yj_all($yjid,$fid,$u)
    {
        $yjarr=$this->sel_more_data("crm_yjmb_user","*","yjm_fid='$fid' and yjm_yid='$yjid' and yjm_uid='".$u["user_id"]."' limit 1");
        $yjarr=$yjarr[0];
        $nowm=date("m",time());
        $nowm=$nowm<10?substr($nowm,1):$nowm;
        return $yjarr['yjm_m'.$nowm];
    }
    //查询多个
    protected function sel_more_data($basename,$field='*',$tj,$key=0)
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
    //处理数据表名称
    protected function basename_do($basename)
    {
        $rt['qz']=substr($basename,0,4);
        $rt['basename']=substr($basename,4);
        $rt['basemod']=M($basename);
        return $rt;
    }
    //查询我的合同
    public function get_my_htid($fid,$u,$tarr)
    {
        //合同查询
        $myht=$this->sel_more_data("crm_hetong","ht_id,ht_data","ht_yh='$fid' and ht_fz='".$u['user_id']."' and ht_sp='1'");
        $htid='';
        foreach($myht as $v)
        {
            $j=json_decode($v['ht_data'],true);
            $d=parent::date_to_date($j['zdy4']);
         
            if($d<$tarr['s']||$d>$tarr['e'])
            {
                continue;
            }
            $htid.="'".$v['ht_id']."',";
        }
        $htid=substr($htid,0,-1);
        return $htid;
    }
    //获取业绩目标列表
    protected function mblist($u)
    {
        $yjmbTypeName=array(
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
        $nowyear=date("Y",time());
        $nowmonth=date("m",time());
        $m=M();
        $yjselarr=$m->query("select yjmb_id,yjmb_type,yjmb_type_more from crm_yjmb where yjmb_yh='$u[fid]' and yjmb_nd='$nowyear'");
        
        /*
            yjmb_id
            yjmb_type
            yjmb_type_more
        */
        $cp_name='';
        $fl_name='';
        if(count($yjselarr)>0)//如果有业绩目标
        {
            foreach($yjselarr as $k=>$v)
            {
                if($v['yjmb_type']=='6'||$v['yjmb_type']=='7')
                {
                    $cp_name.="'".$v['yjmb_type_more']."',";
                }
                if($v['yjmb_type']=='8'||$v['yjmb_type']=='9')
                {
                    $fl_name.="'".$v['yjmb_type_more']."',";
                }
                $yjselarr[$k]['yjmb_name']=$yjmbTypeName[$v['yjmb_type']];
            }
            //查询产品或产品分类名称
            if($cp_name!='')
            {
                $cp_name=substr($cp_name,0,-1);
                $cparr=$m->query("select cp_id,cp_data from crm_chanpin where cp_yh='$u[fid]' and cp_id in ($cp_name)");
                foreach($cparr as $v)
                {
                    $thisname=json_decode($v['cp_data'],true);
                    $thisname=$thisname['zdy0'];
                    $cpNameArr[$v['cp_id']]=$thisname;
                }
            }
            if($fl_name!='')
            {
                $fl_name=substr($fl_name,0,-1);
                $flarr=$m->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$u[fid]' and cpfl_id in ($fl_name)");
                foreach($flarr as $v)
                {
                    $flNameArr[$v['cpfl_id']]=$v['cpfl_name'];
                }
            }
            if($cp_name!=''||$fl_name!='')
            {
                foreach($yjselarr as $k=>$v)
                {
                    if($v['yjmb_type']=='6'||$v['yjmb_type']=='7')
                    {
                        $yjselarr[$k]['yjmb_name']=$yjselarr[$k]['yjmb_name'].'('.$cpNameArr[$v['yjmb_type_more']].')';
                    }
                    if($v['yjmb_type']=='8'||$v['yjmb_type']=='9')
                    {
                        $yjselarr[$k]['yjmb_name']=$yjselarr[$k]['yjmb_name'].'('.$flNameArr[$v['yjmb_type_more']].')';
                    }
                }
            }
            return $yjselarr;
        }
    }



    /*
        获取公告
        $u 用户信息数组
        $size 获取公告数量
    */
    protected function gonggao($u,$size)
    {
        $m=M();
        $gonggao=$m->query("select ggsz_id,ggsz_name,ggsz_kjfw,ggsz_kjid,ggsz_fbsj,ggsz_fbr,ggsz_zd,ggsz_zd_sj from crm_ggshezhi where ggsz_yh='$u[fid]' order by ggsz_id desc");
        //parent::rr($gonggao);
        foreach($gonggao as $v)
        {
            //先判断权限--首先判断如果不是超级管理员，就判断权限
            if($u["user_fid"]!='0')
            {
                if($v['ggsz_kjfw']=='2')
                {
                    $quanxianarr=explode(',',$v['ggsz_kjid']);
                    if(!in_array($u["user_zhu_bid"],$quanxianarr))
                    {
                        continue;
                    }
                }
                if($v['ggsz_kjfw']=='3')
                {
                    $quanxianarr=explode(',',$v['ggsz_kjid']);
                    if(!in_array($u["user_quanxian"],$quanxianarr))
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
        $k=0;
        $gonggaoData='';
        foreach($zhiding as $v)
        {
            if($k==$size)
            {
                break;
            }
            $gonggaoData[]=$v;
            $k++;
        }
        if($k!=$size)
        {
            foreach($buzhiding as $v)
            {
                if($k==$size)
                {
                    break;
                }
                $gonggaoData[]=$v;
                $k++;
            }
        }

        /*
            公告ID
            公告名称
            公告时间
            是否置顶
        */
        foreach($gonggaoData as $kk=>$v)
        {
            unset($gonggaoData[$kk]['ggsz_kjfw']);
            unset($gonggaoData[$kk]['ggsz_kjid']);
            unset($gonggaoData[$kk]['ggsz_fbr']);
            unset($gonggaoData[$kk]['ggsz_zd_sj']);
        }
        return $gonggaoData;
    }
    //需要审批的数量获取
    public function shenpi_num($u)
    {
        $fid=$u['fid'];
        $spu=$fid==$u["user_id"]?"":"and sp_user='".$u["user_id"]."'";
        $sp=$this->sel_more_data("crm_sp","sp_sjid","sp_yh='$fid' $spu  and sp_jg='0' ");
        $sp2='';
        foreach($sp as $k=>$v)
        {
            $sp2[$v['sp_sjid']]=$v;
        }
        
        $sp=$sp2;
        $spnum=$sp==''?0:count($sp);
        return $spnum;
    }
}