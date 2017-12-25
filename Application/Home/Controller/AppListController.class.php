<?php
namespace Home\Controller;
use Think\Controller;


class AppListController extends AppPublicController {
    public $pagesize=20;
    public function index(){
        echo "error";
    }

    //各个模块列表的查询
    public function xiansuolist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"xs_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select xs_id,xs_data from crm_xiansuo where xs_yh='$u[fid]' and xs_is_del='0' and xs_is_to_kh='0' $adminsql order by xs_create_time desc limit $l,$this->pagesize ");

        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['xs_data'],true);
            $arr[$v['xs_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;
        //$res['sql']="select * from crm_xiansuo where xs_yh='$u[fid]' and xs_is_del='0' and xs_is_to_kh='0' $adminsql order by xs_create_time desc limit $l,$this->pagesize ";

        echo json_encode($res);
    }
    public function kehulist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select kh_id,kh_data,kh_fz from crm_kh where kh_yh='$u[fid]' and kh_gonghai='0' $adminsql order by kh_cj_date desc limit $l,$this->pagesize ");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            if($v['kh_fz']=='')
            {
                continue;
            }
            $j=json_decode($v['kh_data'],true);
            $arr[$v['kh_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }
    public function kehugonghailist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select kh_id,kh_data from crm_kh where kh_yh='$u[fid]' and kh_gonghai='1' $adminsql order by kh_cj_date desc limit $l,$this->pagesize ");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['kh_data'],true);
            $arr[$v['kh_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }
    public function lianxirenlist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select lx_id,lx_data from crm_lx where lx_yh='$u[fid]' and lx_gonghai='0' $adminsql order by lx_cj_date desc limit $l,$this->pagesize ");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['lx_data'],true);
            $arr[$v['lx_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }
    public function shangjilist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select sj_id,sj_data from crm_shangji where sj_yh='$u[fid]' and sj_gonghai='0' $adminsql order by sj_cj_date desc limit $l,$this->pagesize");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['sj_data'],true);
            $arr[$v['sj_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }
    public function hetonglist($u,$l)
    {
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select ht_id,ht_data from crm_hetong where ht_yh='$u[fid]' $adminsql order by ht_cj_date desc limit $l,$this->pagesize ");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['ht_data'],true);
            $arr[$v['ht_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }
    public function chanpinlist($u,$l)
    {
        //$adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $q=$m->query("select cp_id,cp_data from crm_chanpin where cp_yh='$u[fid]' and cp_del='0' order by cp_add_time desc limit $l,$this->pagesize ");
        $datalimit=count($q);
        $nodata=$datalimit<$this->pagesize?true:false;//在此之后是否还有数据

        $arr=array();
        foreach($q as $v)
        {
            $j=json_decode($v['cp_data'],true);
            $arr[$v['cp_id']]=$j['zdy0'];
            //parent::rr($j);
        }
        $res['code']='0';
        $res['datalimit']=$datalimit;
        $res['nodata']=$nodata;
        $res['data']=$arr;

        echo json_encode($res);
    }

}