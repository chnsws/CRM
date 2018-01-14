<?php
namespace Home\Controller;
use Think\Controller;


class AppEditController extends AppPublicController {
    public function index(){
        echo "error";
    }
    public function xiansuoedit($u,$j,$id)
    {
        //查询数据库中的本条数据
        $m=M();
        $o=$m->query("select * from crm_xiansuo where xs_id='$id' and xs_yh='$u[fid]' limit 1");
        if(count($o)<1)
        {
            //如果数据不存在
            parent::errorreturn("6");
        }

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
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);


        //为了兼容PC端  需要比对数据
        $nj=$j;
        $oj=json_decode($o[0]['xs_data'],true);
        $allJson=array();
        foreach($nj as $k=>$v)
        {
            //将移动端的数据替换到原数据中
            $oj[$k]=$v;
        }

        //将数组数据转换成json格式
        $jsonData=json_encode($oj);
        $jsonData=str_replace("\\","\\\\",$jsonData);
        $qfz=$fz==$o['xs_fz']?'':",xs_qfz='".$o['xs_fz']."'";//判断是否修改了负责人，如果修改了，就把原来的负责人放到前负责人的字段上
        $m->query("update crm_xiansuo set
            xs_data='$jsonData',
            xs_fz='$fz',
            xs_last_edit_time='$nowDateTimeStr'
            ".$qfz."
        where xs_id='$id' and xs_yh='$u[fid]' limit 1");
        $res['code']='0';
        echo json_encode($res);

    }
    public function kehuedit($u,$j,$id)
    {
        //查询数据库中的本条数据
        $m=M();
        $o=$m->query("select * from crm_kh where kh_id='$id' and kh_yh='$u[fid]' limit 1");
        if(count($o)<1)
        {
            //如果数据不存在
            parent::errorreturn("6");
        }
        //抽取负责人
        $fz=$j['fz'];
        unset($j['fz']);
        //地区处理
        $dq=$j['zdy6'];
        if($dq!='')
        {
            $dq=explode('-',$dq);
            $j['zdy6']=$dq[1];
        }
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //为了兼容PC端  需要比对数据
        $nj=$j;
        $oj=json_decode($o[0]['kh_data'],true);
        $allJson=array();
        foreach($nj as $k=>$v)
        {
            //将移动端的数据替换到原数据中
            $oj[$k]=$v;
        }
        //将数组数据转换成json格式
        $jsonData=json_encode($oj);
        $jsonData=str_replace("\\","\\\\",$jsonData);
        $qfz=$fz==$o['kh_fz']?'':",kh_old_fz='".$o['kh_fz']."'";//判断是否修改了负责人，如果修改了，就把原来的负责人放到前负责人的字段上
        $m->query("update crm_kh set
            kh_data='$jsonData',
            kh_fz='$fz',
            kh_gx_date='$nowDateTimeStr'
            ".$qfz."
        where kh_id='$id' and kh_yh='$u[fid]' limit 1");
        $res['code']='0';
        echo json_encode($res);

    }
    public function lianxirenedit($u,$j,$id)
    {
        //查询数据库中的本条数据
        $m=M();
        $o=$m->query("select * from crm_lx where lx_id='$id' and lx_yh='$u[fid]' limit 1");
        if(count($o)<1)
        {
            //如果数据不存在
            parent::errorreturn("6");
        }
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //为了兼容PC端  需要比对数据
        $nj=$j;
        $oj=json_decode($o[0]['lx_data'],true);
        $allJson=array();
        foreach($nj as $k=>$v)
        {
            //将移动端的数据替换到原数据中
            $oj[$k]=$v;
        }
        //将数组数据转换成json格式
        $jsonData=json_encode($oj);
        $jsonData=str_replace("\\","\\\\",$jsonData);
        
        $m->query("update crm_lx set
            lx_data='$jsonData',
            lx_gx_date='$nowDateTimeStr'
        where lx_id='$id' and lx_yh='$u[fid]' limit 1");
        $res['code']='0';
        echo json_encode($res);
 
    }
    public function shangjiedit($u,$j,$id)
    {
        //查询数据库中的本条数据
        $m=M();
        $o=$m->query("select * from crm_shangji where sj_id='$id' and sj_yh='$u[fid]' limit 1");
        if(count($o)<1)
        {
            //如果数据不存在
            parent::errorreturn("6");
        }

        //抽取负责人
        $fz=$j['fz'];
        unset($j['fz']);

        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);


        //为了兼容PC端  需要比对数据
        $nj=$j;
        $oj=json_decode($o[0]['sj_data'],true);
        $allJson=array();
        foreach($nj as $k=>$v)
        {
            //将移动端的数据替换到原数据中
            $oj[$k]=$v;
        }

        //将数组数据转换成json格式
        $jsonData=json_encode($oj);
        $jsonData=str_replace("\\","\\\\",$jsonData);
       
        $m->query("update crm_shangji set
            sj_data='$jsonData',
            sj_fz='$fz',
            sj_gx_date='$nowDateTimeStr'
        where sj_id='$id' and sj_yh='$u[fid]' limit 1");
        $res['code']='0';
        echo json_encode($res);
    }
    public function hetongedit($u,$j,$id)
    {
        //查询数据库中的本条数据
        $m=M();
        $o=$m->query("select * from crm_hetong where ht_id='$id' and ht_yh='$u[fid]' limit 1");
        if(count($o)<1)
        {
            //如果数据不存在
            parent::errorreturn("6");
        }
        //抽取负责人
        $fz=$j['fz'];
        unset($j['fz']);
        //当前时间
        $nowDateTimeUinx=time();
        $nowDateTimeStr=date("Y-m-d H:i:s",$nowDateTimeUinx);
        //为了兼容PC端  需要比对数据
        $nj=$j;
        $oj=json_decode($o[0]['ht_data'],true);
        $allJson=array();
        foreach($nj as $k=>$v)
        {
            //将移动端的数据替换到原数据中
            $oj[$k]=$v;
        }
        //将数组数据转换成json格式
        $jsonData=json_encode($oj);
        $jsonData=str_replace("\\","\\\\",$jsonData);
        $qfz=$fz==$o['ht_fz']?'':",ht_old_fz='".$o['ht_fz']."'";//判断是否修改了负责人，如果修改了，就把原来的负责人放到前负责人的字段上
        $m->query("update crm_hetong set
            ht_data='$jsonData',
            ht_fz='$fz',
            ht_gx_date='$nowDateTimeStr'
            ".$qfz."
        where ht_id='$id' and ht_yh='$u[fid]' limit 1");
        $res['code']='0';
        echo json_encode($res);
    }
    public function chanpinedit($u,$j,$id)
    {
        die;
    }
}