<?php
namespace Home\Controller;
use Think\Controller;


class AppInfoController extends AppPublicController {
    protected $modcode=array(
        "xiansuo"       =>"1",
        "kehu"          =>"2",
        "kehugonghai"   =>"3",
        "lianxiren"     =>"4",
        "shangji"       =>"5",
        "hetong"        =>"6",
        "chanpin"       =>"7"
    );
    public function xiansuoinfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"xs_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_xiansuo where xs_id='$id' and xs_yh='$u[fid]' and xs_is_del='0' and xs_is_to_kh='0' $adminsql  limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        //查询字段信息,data中的json数据
        $zdarr=$this->getZdData($u['fid'],1,'');
        $json=json_decode($d[0]['xs_data'],true);
        $data=array();
        $canshufields=array(
            "zdy14",
            "zdy15",
        );
        $canshu=$this->getCanshuData($u['fid'],1);
        foreach($zdarr as $k=>$v)
        {
            $con=$json[$k];
            if(in_array($k,$canshufields))
            {
                $con=$canshu[$k][$con];
            }
            $data[$k]['title']=$v;
            $data[$k]['content']=$con;
        }
        //系统信息
        $sysinfo=array();
        $sysfields=array(
            "创建人"=>"xs_create_user",
            "负责人"=>"xs_fz",
            "前负责人"=>"xs_qfz",
            "创建时间"=>"xs_create_time",
            "最后修改时间"=>"xs_last_edit_time"
        );
        //获取本公司所有的人名
        $username=$this->getusername($u['fid']);
        foreach($sysfields as $k=>$v)
        {
            $sysinfo[$v]['title']=$k;
            $con=$d[0][$v];
            if(in_array($v,array("xs_create_user","xs_fz","xs_qfz")))
            {
                $con=$username[$d[0][$v]]==''?'--':$username[$d[0][$v]];
            }
            $sysinfo[$v]['content']=$con;
        }
        $res['code']='0';
        $res['data']['info']=$data;
        $res['data']['sysinfo']=$sysinfo;
        echo json_encode($res);
    }
    public function kehuinfo()
    {
        
    }
    public function kehugonghaiinfo()
    {
        
    }
    public function lianxireninfo()
    {
        
    }
    public function shangjiinfo()
    {
        
    }
    public function hetonginfo()
    {
        
    }
    public function chanpininfo()
    {
        
    }
    protected function getZdData($fid,$modcode,$fenlei)
    {
        $m=M();
        $mod=$fenlei==''?$modcode:$modcode.','.$fenlei;
        $px=$m->query("select px_px from crm_paixu where px_yh='$fid' and px_mod='$mod' limit 1");
        $zd=$m->query("select zd_data from crm_yewuziduan where zd_yh='$fid' and zd_yewu='$mod' limit 1");
        $px=explode(',',$px[0]['px_px']);
        $zd=json_decode($zd[0]['zd_data'],true);
        foreach($zd as $k=>$v)
        {
            $zd[$v['id']]=$v;
            unset($zd[$k]);
        }
        foreach($px as $v)
        {
            if($zd[$v]['name']=='')
            {
                //去掉空字段
                unset($zd[$v]);
                continue;
            }
            if($zd[$v]['qy']!='1')
            {
                //去掉不启用的
                unset($zd[$v]);
                continue;
            }
            //只取名称
            $pxzd[$v]=$zd[$v]['name'];
            unset($zd[$v]);
        }
        foreach($zd as $k=>$v)
        {
            $pxzd[$k]=$v['name'];
            unset($zd[$k]);
        }
        return $pxzd;
    }
    protected function getCanshuData($fid,$modcode)
    {
        $m=M();
        $c=$m->query("select ywcs_data from crm_ywcs where ywcs_yh='$fid' and ywcs_yw='$modcode' limit 1");
        $json=json_decode($c[0]['ywcs_data'],true);
        $csdata=array();
        foreach($json as $k=>$v)
        {
            foreach($v as $kk=>$vv)
            {
                if(substr($kk,0,6)!='canshu')
                {
                    continue;
                }
                if($v['qy'][$kk]!='1')
                {
                    continue;
                }
                $csdata[$v['id']][$kk]=$vv;
            }
        }
        return $csdata;
    }
    protected function getusername($fid)
    {
        $m=M();
        $q=$m->query("select user_id,user_name from crm_user where user_del='0' and user_act='1' and (user_id='$fid' or user_fid='$fid') ");
        foreach($q as $v)
        {
            $data[$v['user_id']]=$v['user_name'];
        }
        return $data;
    }
}