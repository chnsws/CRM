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

    /*
    $u 用户信息数组
    $id 访问的详情id
    */
    public function xiansuoinfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and xs_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_xiansuo where xs_id='$id' and xs_yh='$u[fid]' and xs_is_del='0' and xs_is_to_kh='0' $adminsql  limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $canshufields=array(
            "zdy14",
            "zdy15",
        );
        $sysfields=array(
            "创建人"=>"xs_create_user",
            "负责人"=>"xs_fz",
            "前负责人"=>"xs_qfz",
            "创建时间"=>"xs_create_time",
            "最后修改时间"=>"xs_last_edit_time"
        );
        $res=$this->createInfo($u,$d,'1','xs_data',$canshufields,$sysfields);
        echo json_encode($res);
        /*
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
            $data[$k]['content']=$con==''?'--':$con;
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
                $con=$username[$d[0][$v]]==''?'(此用户已被删除)':$username[$d[0][$v]];
            }
            $sysinfo[$v]['content']=$con==''?'--':$con;
        }
        $res['code']='0';
        $res['data']['info']=$data;
        $res['data']['sysinfo']=$sysinfo;
        echo json_encode($res);
        */
    }
    //客户模块详情页展示
    public function kehuinfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_kh where kh_id='$id' and kh_yh='$u[fid]' and kh_gonghai='0' $adminsql limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $canshufields=array(
            "zdy1",
            "zdy9",
            "zdy10",
            "zdy11",
            "zdy12"
        );
        $sysfields=array(
            "创建人"=>"kh_cj",
            "负责人"=>"kh_fz",
            "前负责人"=>"kh_old_fz",
            "创建时间"=>"kh_cj_date",
            "最后修改时间"=>"kh_gx_date"
        );
        $res=$this->createInfo($u,$d,'2','kh_data',$canshufields,$sysfields);
        echo json_encode($res);

        /*
        $adminsql=$u['admin']==1?"":"kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_kh where kh_id='$id' and kh_yh='$u[fid]' and kh_gonghai='0' $adminsql ");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        //查询字段信息,data中的json数据
        $zdarr=$this->getZdData($u['fid'],2,'');
        $json=json_decode($d[0]['kh_data'],true);
        //parent::rr("select * from crm_kh where kh_id='$id' kh_yh='$u[fid]' and kh_gonghai='0' $adminsql ");
        $data=array();
        $canshufields=array(
            "zdy1",
            "zdy9",
            "zdy10",
            "zdy11",
            "zdy12"
        );
        $canshu=$this->getCanshuData($u['fid'],2);
        //parent::rr($canshu);
        foreach($zdarr as $k=>$v)
        {
            $con=$json[$k];
            if(in_array($k,$canshufields))
            {
                $con=$canshu[$k][$con];
            }
            $data[$k]['title']=$v;
            $data[$k]['content']=$con==''?'--':$con;
        }
        //系统信息
        $sysinfo=array();
        $sysfields=array(
            "创建人"=>"kh_cj",
            "负责人"=>"kh_fz",
            "前负责人"=>"kh_old_fz",
            "创建时间"=>"kh_cj_date",
            "最后修改时间"=>"kh_gx_date"
        );
        //获取本公司所有的人名
        $username=$this->getusername($u['fid']);
        foreach($sysfields as $k=>$v)
        {
            $sysinfo[$v]['title']=$k;
            $con=$d[0][$v];
            if(in_array($v,array("kh_cj","kh_fz","kh_old_fz")))
            {
                $con=$username[$d[0][$v]]==''?'(此用户已被删除)':$username[$d[0][$v]];
            }
            $sysinfo[$v]['content']=$con==''?'--':$con;
        }
        $res['code']='0';
        $res['data']['info']=$data;
        $res['data']['sysinfo']=$sysinfo;
        echo json_encode($res);
        */
    }
    public function kehugonghaiinfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and kh_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_kh where kh_id='$id' and kh_yh='$u[fid]' and kh_gonghai='1' $adminsql limit 1");

        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $canshufields=array(
            "zdy1",
            "zdy9",
            "zdy10",
            "zdy11",
            "zdy12"
        );
        $sysfields=array(
            "创建人"=>"kh_cj",
            "负责人"=>"kh_fz",
            "前负责人"=>"kh_old_fz",
            "创建时间"=>"kh_cj_date",
            "最后修改时间"=>"kh_gx_date"
        );
        $res=$this->createInfo($u,$d,'2','kh_data',$canshufields,$sysfields);
        echo json_encode($res);
    }
    public function lianxireninfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and lx_cj='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_lx where lx_id='$id' and lx_yh='$u[fid]' $adminsql limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $sysfields=array(
            "负责人"=>"lx_cj",
            "创建时间"=>"lx_cj_date"
        );
        $res=$this->createInfo($u,$d,'4','lx_data','',$sysfields);
        echo json_encode($res);
    }
    public function shangjiinfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and sj_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        
        $d=$m->query("select * from crm_shangji where sj_id='$id' and sj_yh='$u[fid]' $adminsql limit 1");
        
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $canshufields=array(
            "zdy5",
            "zdy7",
            "zdy9"
        );
        $sysfields=array(
            "创建人"=>"sj_cj",
            "负责人"=>"sj_fz",
            "创建时间"=>"sj_cj_date",
            "最后修改时间"=>"sj_gx_date"
        );
        $res=$this->createInfo($u,$d,'5','sj_data',$canshufields,$sysfields);
        echo json_encode($res);
    }
    public function hetonginfo($u,$id)
    {
        $adminsql=$u['admin']==1?"":"and ht_fz='$u[user_id]'";//如果不是管理员，就只查自己的
        $m=M();
        $d=$m->query("select * from crm_hetong where ht_id='$id' and ht_yh='$u[fid]' $adminsql limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $canshufields=array(
            "zdy7",
            "zdy10",
            "zdy11",
            "hktype",
            "pjtype"
        );
        $sysfields=array(
            "创建人"=>"ht_cj",
            "负责人"=>"ht_fz",
            "前负责人"=>"ht_old_fz",
            "创建时间"=>"ht_cj_date",
            "最后修改时间"=>"ht_gx_date"
        );
        $res=$this->createInfo($u,$d,'6','ht_data',$canshufields,$sysfields);
        echo json_encode($res);
    }
    //产品信息查询
    public function chanpininfo($u,$id)
    {
        $m=M();
        $d=$m->query("select * from crm_chanpin where cp_id='$id' and cp_yh='$u[fid]' and cp_del='0' limit 1");
        if(count($d)<1)
        {
            //查询不到
            parent::errorreturn(6);
        }
        $json=json_decode($d[0]['cp_data'],true);
        //拿到分类
        $fl=$json['zdy6'];
        $zdarr=$this->getZdData($u['fid'],'7,'.$fl,'');
        $data=array();
        foreach($zdarr as $k=>$v)
        {
            $con=$json[$k];
            $data[$k]['title']=$v;
            if($k=='zdy6')
            {
                //分类
                $flarr=$this->getcpflname($u['fid']);
                $data[$k]['content']=$flarr[$con]==''?'该分类不存在或已被删除':$flarr[$con];
            }
            else if($k=='zdy7')
            {
                //图片
                if($con=='')
                {
                    $data[$k]['content']='无产品图片';
                }
                else
                {
                    $data[$k]['img']='1';
                    $data[$k]['content']='/Public/chanpinfile/cpimg/'.$con;
                }
            }
            else
            {
                
                $data[$k]['content']=$con==''?'--':$con;
            }
            
        }
        
        //系统信息
        $sysinfo=array();
        //获取本公司所有的人名
        $username=$this->getusername($u['fid']);
        $sysfields=array(
            "创建人"=>"cp_add_user",
            "创建时间"=>"cp_add_time",
            "最后修改时间"=>"cp_edit_time"
        );
        foreach($sysfields as $k=>$v)
        {
            $sysinfo[$v]['title']=$k;
            $con=$d[0][$v];
            if(in_array($v,array('cp_add_user')))
            {
                $con=$username[$d[0][$v]]==''?'(用户不存在或已被删除)':$username[$d[0][$v]];
            }
            $sysinfo[$v]['content']=$con==''?'--':$con;
        }
        $res['code']='0';
        $res['data']['info']=$data;
        $res['data']['sysinfo']=$sysinfo;
        echo json_encode($res);
    }
    //字段数据
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
    //参数数据
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
    //..
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
    //构造数据信息统一方法
    protected function createInfo($u,$d,$zdmod,$dataname,$canshufields,$sysfields)
    {
        /*
        u:用户信息数组
        d:本条信息数组
        zdmod:字段模块代码
        dataname:data字段的字段名
        canshufields:需要查询参数表的字段
        sysfields:系统信息的字段名
        */
        //查询字段信息,data中的json数据
        $zdarr=$this->getZdData($u['fid'],$zdmod,'');
        $json=json_decode($d[0][$dataname],true);
        $data=array();
        $canshu=$this->getCanshuData($u['fid'],$zdmod);
        foreach($zdarr as $k=>$v)
        {
            $con=$json[$k];
            if(in_array($k,$canshufields))
            {
                $con=$canshu[$k][$con];
            }
            $data[$k]['title']=$v;
            $data[$k]['content']=$con==''?'--':$con;
        }
        if($zdmod!='1'&&$zdmod!='7')
        {
            $data=$this->elseinfo($data,$zdmod);
        }
        
        //系统信息
        $sysinfo=array();
        //获取本公司所有的人名
        $username=$this->getusername($u['fid']);
        $namearray=array(
            $sysfields['创建人'],
            $sysfields['负责人'],
            $sysfields['前负责人']
        );
        foreach($sysfields as $k=>$v)
        {
            $sysinfo[$v]['title']=$k;
            $con=$d[0][$v];
            if(in_array($v,$namearray))
            {
                $con=$username[$d[0][$v]]==''?'(用户不存在或已被删除)':$username[$d[0][$v]];
            }
            else
            {
                $con=preg_match("/^\d*$/",$con)?date("Y-m-d H:i:s",$con):$con;
            }
            $sysinfo[$v]['content']=$con==''?'--':$con;
        }
        $res['code']='0';
        $res['data']['info']=$data;
        $res['data']['sysinfo']=$sysinfo;
        return $res;
    }
    //对关联数据的处理
    protected function elseinfo($data,$zdmod)
    {
        
        if($zdmod=='2'||$zdmod=='3')
        {
            $data['zdy15']['content']=$this->getlxname($data['zdy15']['content']);
        }
        else if($zdmod=='4')
        {
            $data['zdy1']['content']=$this->getkhname($data['zdy1']['content']);
        }
        else if($zdmod=='5')
        {
            $data['zdy1']['content']=$this->getkhname($data['zdy1']['content']);
            $data['zdy2']['content']=$this->getlxname($data['zdy2']['content']);
        }
        else if($zdmod=='6')
        {
            $data['zdy1']['content']=$this->getkhname($data['zdy1']['content']);
            $data['zdy2']['content']=$this->getsjname($data['zdy2']['content']);
        }
        else
        {

        }
        return $data;
    }
    protected function getkhname($id)
    {
        $m=M();
        $d=$m->query("select kh_data from crm_kh where kh_id='$id' limit 1");
        if(count($d)<1)
        {
            return '客户不存在或已被删除';
        }
        else
        {
            $d=json_decode($d[0]['kh_data'],true);
            return $d['zdy0'];
        }
    }
    protected function getlxname($id)
    {
        $m=M();
        $d=$m->query("select lx_data from crm_lx where lx_id='$id' limit 1");
        if(count($d)<1)
        {
            return '联系人不存在或已被删除';
        }
        else
        {
            $d=json_decode($d[0]['lx_data'],true);
            return $d['zdy0'];
        }
    }
    protected function getsjname($id)
    {
        $m=M();
        $d=$m->query("select sj_data from crm_shangji where sj_id='$id' limit 1");
        if(count($d)<1)
        {
            return '商机不存在或已被删除';
        }
        else
        {
            $d=json_decode($d[0]['sj_data'],true);
            return $d['zdy0'];
        }
    }
    //获取产品分类
    protected function getcpflname($fid)
    {
        $m=M();
        $d=$m->query("select cpfl_name,cpfl_id from crm_chanpinfenlei where cpfl_company='$fid'");
        $r=array();
        foreach($d as $v)
        {
            $r[$v['cpfl_id']]=$v['cpfl_name'];
        }
        return $r;
    }
}