<?php
namespace Home\Controller;
use Think\Controller;


class IndexController extends DBController {
    public function index(){
        parent::is_login2(1);
        $fid=parent::get_fid();
        $navs='[{"title":"工作台","icon":"fa-table","href":"","spread":false},{"title":"线索","icon":"fa-search","href":"index.php/Home/Xiansuo/index","spread":false},{"title":"客户","icon":"fa-group","href":"index.php/Home/Kehu/kehu","spread":false},{"title":"客户公海","icon":"fa-group","href":"index.php/Home/Gonghai/gonghai","spread":false},{"title":"联系人","icon":"fa-address-book","href":"index.php/Home/Lianxiren/lianxiren","spread":false},{"title":"商机","icon":"fa-money","href":"index.php/Home/Shangji/shangji","spread":false},{"title":"合同","icon":"fa-file","href":"index.php/Home/Hetong/hetong","spread":false},{"title":"产品","icon":"fa-book","href":"index.php/Home/Cpfl/cpfl_index","spread":false},{"title":"审批","icon":"fa-search","href":"index.php/Home/Shenpi/shenpi","spread":false},{"title":"报表中心","icon":"fa-align-left","href":"index.php/Home/Report/index","spread":false},{"title":"问题反馈","icon":"fa-envelope","href":"index.php/Home/Fankui/index","spread":false},{"title":"收起","icon":"fa-chevron-left","href":"#","spread":false}]';
        $newnavjson=$navs;
        if(cookie("user_quanxian")!='1')
        {
            //权限获取
            $qx['qx_xs_open']=cookie("qx_xs_open");
            $qx['qx_kh_open']=cookie("qx_kh_open");
            $qx['qx_khgh_open']=cookie("qx_khgh_open");
            $qx['qx_lxr_open']=cookie("qx_lxr_open");
            $qx['qx_sj_open']=cookie("qx_sj_open");
            $qx['qx_ht_open']=cookie("qx_ht_open");
            $qx['qx_cp_open']=cookie("qx_cp_open");
            $qx['qx_sp_open']=cookie("qx_sp_open");
            $qx['qx_bb_open']=cookie("qx_bb_open");
            //$qx['qx_bb_open']='0';
            //导航栏遍历
            $nav_index=array(
                "1"=>"qx_xs_open",
                "2"=>"qx_kh_open",
                "3"=>"qx_khgh_open",
                "4"=>"qx_lxr_open",
                "5"=>"qx_sj_open",
                "6"=>"qx_ht_open",
                "7"=>"qx_cp_open",
                "8"=>"qx_sp_open",
                "9"=>"qx_bb_open"
            );
            $navarr=json_decode($navs,true);
            foreach($navarr as $k=>$v)
            {
                $v['title']=urlencode($v['title']);
                if($k<1||$k>8)
                {
                    $newnav[]=$v;
                    continue;
                }
                if($qx[$nav_index[$k]]!='1')
                {
                    continue;
                }
                $newnav[]=$v;
            }
            //构造json
            $newnavjson=urldecode(json_encode($newnav));
        }

        $this->assign("navs",$newnavjson);
        $this->display();
    }
    //安全退出
    public function tuichu()
    {
        $time=time()-(3600*3);
        //unset($_COOKIE);
        //parent::rr(cookie("user_id"));
        //parent::rr($_COOKIE);
        //setCookie('qx_name','999999',$time);
        foreach($_COOKIE as $key=>$value){
            cookie($key,null,$time);
        }
        echo "<script>window.location='$_GET[root_dir]/index.php/Home/Login'</script>";
    }
    //无权页面
    public function nopower()
    {
        $this->display();
    }
}

