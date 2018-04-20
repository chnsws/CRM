<?php
namespace Home\Controller;
use Think\Controller;


class AppAddController extends AppPublicController {
    public function index(){
        echo "error";
    }
    public function xiansuoadd($u,$j)
    {
        //$u:用户信息 一维数组
        //$j:添加过来的数组数据 一维数组

        //print_r($u);die;
        //parent::rr($j);
        //抽取负责人
        $fz=$j['fz'];
        unset($j['fz']);
        //地区处理
        $dq=$j['zdy11'];
        if($dq!='')
        {
            $dq=explode('-',$dq);
            $j['zdy11']=$dq[0];
        }
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_xiansuo set 
            xs_data='$jsonData',
            xs_fz='$fz',
            xs_create_time='$nowDateTimeStr',
            xs_create_user='$createUserId',
            xs_last_edit_time='$nowDateTimeStr',
            xs_is_to_kh='0',
            xs_yh='$u[fid]',
            xs_is_del='0'
        ");
        //parent::rr($a);
        $res['code']='0';

        echo json_encode($res);

        //parent::rr($u);
        /*
       
        */
    }
    public function kehuadd($u,$j)
    {
        $fz=$j['fz'];
        unset($j['fz']);
        //地区处理
        $dq=$j['zdy6'];
        if($dq!='')
        {
            $dq=explode('-',$dq);
            $j['zdy6']=$dq[1];
        }
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_kh set 
            kh_data='$jsonData',
            kh_fz='$fz',
            kh_gonghai='0',
            kh_sj_gj_date='',
            kh_cj='$createUserId',
            kh_old_fz='',
            kh_cj_date='$nowDateTimeUinx',
            kh_gx_date='$nowDateTimeStr',
            kh_gh_date='',
            kh_yh='$u[fid]'
        ");
        $res['code']='0';
        echo json_encode($res);
    }
    public function lianxirenadd($u,$j)
    {
        
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_lx set
            lx_data='$jsonData',
            lx_cj='$createUserId',
            lx_cj_date='$nowDateTimeUinx',
            lx_gx_date='$nowDateTimeStr',
            lx_yh='$u[fid]',
            lx_gonghai='0'
        ");
        $res['code']='0';
        echo json_encode($res);
    }
    public function shangjiadd($u,$j)
    {
        $fz=$j['fz'];
        unset($j['fz']);
     
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);

        //关联产品处理
        $cpdata=$j['zdy6'];
        $cpdata=json_decode($cpdata,true);
        
        unset($j['zdy6']);


        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_shangji set 
            sj_data='$jsonData',
            sj_gonghai='0',
            sj_sj_date='',
            sj_fz='$fz',
            sj_cj='$createUserId',
            sj_cj_date='$nowDateTimeUinx',
            sj_gx_date='$nowDateTimeStr',
            sj_yh='$u[fid]'
        ");
        $lastinsertid=$m->query(" select LAST_INSERT_ID()");
        $lastinsertid=$lastinsertid[0]['LAST_INSERT_ID()'];

        //插入关联产品
        foreach($cpdata as $k=>$v)
        {
            $m->query("insert into crm_cp_sj set
                cp_id='$k',
                cp_yj='$v[gongkaijiage]',
                cp_jy='$v[hetongjiage]',
                cp_num1='$v[shuliang]',
                cp_zj='$v[zongjia]',
                cp_yh='$u[fid]',
                sj_id='$lastinsertid',
                cp_sj_cj='$createUserId',
                cp_mk='5'
            ");
        }

        $res['code']='0';
        echo json_encode($res);
    }
    public function hetongadd($u,$j)
    {
        $fz=$j['fz'];
        unset($j['fz']);
     
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);

        //关联产品处理
        $cpdata=$j['zdy9'];
        $cpdata=json_decode($cpdata,true);
        
        unset($j['zdy9']);



        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_hetong set 
           ht_data='$jsonData',
           ht_fz='$fz',
           ht_cj='$createUserId',
           ht_cj_date='$nowDateTimeUinx',
           ht_gx_date='$nowDateTimeStr',
           ht_yh='$u[fid]',
           ht_sp='0'
        ");
        $lastinsertid=$m->query(" select LAST_INSERT_ID()");
        $lastinsertid=$lastinsertid[0]['LAST_INSERT_ID()'];
        //插入关联产品
        foreach($cpdata as $k=>$v)
        {
            $m->query("insert into crm_cp_sj set
                cp_id='$k',
                cp_yj='$v[gongkaijiage]',
                cp_jy='$v[hetongjiage]',
                cp_num1='$v[shuliang]',
                cp_zj='$v[zongjia]',
                cp_yh='$u[fid]',
                sj_id='$lastinsertid',
                cp_sj_cj='$createUserId',
                cp_mk='6'
            ");
        }
        $res['code']='0';
        echo json_encode($res);
    }
    public function chanpinadd($u,$j,$flid)
    {
        //获取创建人
        $createUserId=$u['user_id'];
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);

        //产品分类插进去
        $j['zdy6']=$flid;
        //将数组数据转换成json格式
        $jsonData=json_encode($j);
        $jsonData=str_replace("\\","\\\\",$jsonData);

        $m=M();
        $m->query("insert into crm_chanpin set 
           cp_data='$jsonData',
           cp_add_time='$nowDateTimeStr',
           cp_edit_time='$nowDateTimeStr',
           cp_qy='1',
           cp_del='0',
           cp_add_user='$createUserId',
           cp_yh='$u[fid]'
        ");

        $res['code']='0';
        echo json_encode($res);
    }
}