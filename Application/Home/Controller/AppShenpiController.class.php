<?php
namespace Home\Controller;
use Think\Controller;


class AppShenpiController extends AppPublicController {
    public function needshenpi($u)
    {
        $m=M();
        $fid=$u['fid'];
        $spu=$fid==$u["user_id"]?"":"and sp_user='".$u["user_id"]."'";//对超级管理员的特殊处理，超级管理员可以看到所有审批
        $spdata=$m->query("select 
            sp_id,
            sp_yy,
            sp_sjid,
            sp_user,
            sp_sj,
            sp_yuanyin,
            sp_dq_jj,
            sp_zg_jj,
            sp_tp
         from crm_sp where sp_yh='$fid' $spu and sp_jg='0' order by sp_sj desc ");
        /*
            sp_id  -------
            sp_yy 模块--------
            sp_sjid 对应id------
            sp_jg 结果
            sp_yh 
            sp_user 发起人------
            sp_sj 时间---------
            sp_yuanyin 备注---------
            sp_dq_jj 当前第几级------
            sp_tp 是否同步
            sp_zg_jj 总共几级--------
            sp_xgr 
        */

        //将重复的审批去重
        $sp2='';
        $type='';
        foreach($spdata as $k=>$v)
        {
            $sp2[$v['sp_yy']][$v['sp_sjid']]=$v;//根据分类去重
            $type[$v['sp_yy']][$v['sp_sjid']]=$v['sp_sjid'];
        }
        /*
            合同：合同名称
            回款：合同名称 第几期回款
            开票：合同名称 票据名称
        */
        
        if(count($type[2]))
        {
            //需不需要查询回款信息
            $hksql="'".implode("','",$type[2])."'";
            $hkarr=$m->query("select hk_id,hk_data,hk_je,hk_qici,hk_ht from crm_hkadd where hk_yh='$fid' and hk_id in ($hksql)");
            foreach($hkarr as $v)
            {
                $type[1][$v['hk_ht']]=$v['hk_ht'];//需要查询合同名称的合同id
                $sp2[2][$v['hk_id']]=array_merge($sp2[2][$v['hk_id']],$v);//将回款审批的回款信息合并入主数组中
            }
        }
        if(count($type[3]))
        {
            //需不需要查询开票名称
            $kpsql="'".implode("','",$type[3])."'";
            $kparr=$m->query("select kp_id,kp_je,kp_type,kp_ht from crm_kp where wocao='$fid' and kp_id in ($kpsql)");
            foreach($kparr as $v)
            {
                $type[1][$v['kp_ht']]=$v['kp_ht'];//需要查询合同名称的合同id
                $sp2[3][$v['kp_id']]=array_merge($sp2[3][$v['kp_id']],$v);//将回款审批的回款信息合并入主数组中
            }
        }
        //合同放到最后判断
        if(count($type[1]))
        {
            //需不需要查询合同名称
            $htsql="'".implode("','",$type[1])."'";
            $htarr=$m->query("select ht_id,ht_data from crm_hetong where ht_yh='$fid' and ht_id in ($htsql)");
            foreach($htarr as $v)
            {
                $j=json_decode($v['ht_data'],true);
                $htnamearr[$v['ht_id']]=$j['zdy0'];
            }
        }
        $htnamekey=array(
            "1"=>"sp_sjid",
            "2"=>"hk_ht",
            "3"=>"kp_ht"
        );
        //查询本公司全部人的名字
        if(count($sp2))
        {
            $user=$m->query("select user_id,user_name from crm_user where user_fid='$fid' or user_id='$fid'");
            foreach($user as $v)
            {
                $uname[$v['user_id']]=$v['user_name'];
            }
        }
        //开票类型
        $kpTypeName=array(
            "0"=>"增值税普通发票",
            "1"=>"增值税专用发票",
            "2"=>"国税通用机打发票",
            "3"=>"地税通用机打发票"
        );
        foreach($sp2 as $k=>$v)
        {
            foreach($v as $kk=>$vv)
            {
                $thishtname=$htnamearr[$vv[$htnamekey[$k]]];
                $sp2[$k][$kk]['htname']=($thishtname==''||$thishtname==null)?'该合同已被删除':$thishtname;
                $sp2[$k][$kk]['sp_user']=$uname[$sp2[$k][$kk]['sp_user']];
                if($k=='3')
                {
                    $sp2[$k][$kk]['kp_type']=$kpTypeName[$sp2[$k][$kk]['kp_type']];
                }
            }
        }
        
        
        $res['code']='0';
        $res['data']=$sp2;
        //parent::rr($res);
        echo json_encode($res);
    }
    /*
        //打开缓冲区
        ob_start();
        echo '1';
        //清除缓冲区，此时不会输出1
        ob_clean();
        //输出缓冲区。但是因为上面已经清除过缓冲区了，所以不会输出 1
        ob_end_flush();
        echo '2';
    */

    public function tongguo()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        /*
            登录信息验证通过
        */
        $spid  =addslashes($header['spid']);
        $spmod =addslashes($header['spmod']);
        $sptb  =addslashes($header['sptb']);
        $htid  =addslashes($header['htid']);
        $nowjj =addslashes($header['nowjj']);
        $alljj =addslashes($header['alljj']);

        if(!$spid||!$spmod||!$htid)
        {
            $res['code']='1';
            $res['data']='参数不全';
            echo json_encode($res);die;
        }

        if($spmod=='1')
        {
            $url="localhost/index.php/Home/Shenpi/ht_tongguo?id=".$spid."&tb=".$sptb."&ht_id=".$htid."&tjr=".$nowjj."&zgjj=".$alljj."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else if($spmod=='2')
        {
            $url="localhost/index.php/Home/Shenpi/tongguo?id=".$spid."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else if($spmod=='3')
        {
            $url="localhost/index.php/Home/Shenpi/kp_tongguo?id=".$spid."&tb=".$sptb."&kp_id=".$htid."&tjr=".$nowjj."&zgjj=".$alljj."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else
        {
            $res['code']='1';
            $res['data']='参数不全';
            echo json_encode($res);die;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);


        $res['code']='0';
        $res['data']=$data=='123'?'审批通过':$data;
        echo json_encode($res);
        
    }
    //对接驳回
    public function bohui()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        /*
            登录信息验证通过
        */
        $spid  =addslashes($header['spid']);
        $spmod =addslashes($header['spmod']);
        $sptb  =addslashes($header['sptb']);
        $htid  =addslashes($header['htid']);
        $nowjj =addslashes($header['nowjj']);
        $alljj =addslashes($header['alljj']);
        
        $yuanyin=addslashes($_POST['yuanyin']);
        echo $yuanyin;die;
        if(!$spid||!$spmod||!$htid)
        {
            $res['code']='1';
            $res['data']='参数不全';
            echo json_encode($res);die;
        }

        if($spmod=='1')
        {
            $url="localhost/index.php/Home/Shenpi/ht_bohui?id=".$spid."&yuanyin=".$yuanyin."&tb=".$sptb."&ht_id=".$htid."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else if($spmod=='2')
        {
            $url="localhost/index.php/Home/Shenpi/bohui?id=".$spid."&yuanyin=".$yuanyin."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else if($spmod=='3')
        {
            $url="localhost/index.php/Home/Shenpi/kp_bohui?id=".$spid."&tb=".$sptb."&kp_id=".$htid."&yuanyin=".$yuanyin."&from=app&userphone=".addslashes($header['userphone'])."&usertoken=".addslashes($header['token']);
        }
        else
        {
            $res['code']='1';
            $res['data']='参数不全';
            echo json_encode($res);die;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);


        $res['code']='0';
        $res['data']="操作成功";
        echo json_encode($res);
    }
}