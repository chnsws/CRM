<?php
namespace Home\Controller;
use Think\Controller;


class RizhiDoController extends DBController {
	//模板框架
    public function shaixuan(){
		parent::is_login();
        parent::have_qx("qx_sys_rz");
        //echo $_GET['rz_type'].'----'.$_GET['rz_mode'].'----'.$_GET['rz_cz_type'].'----'.$_GET['rz_user'].'----'.$_GET['stime'].'----'.$_GET['etime'];
        $rz_type=addslashes($_GET['rz_type']);
        $rz_mode=addslashes($_GET['rz_mode']);
        $rz_cz_type=addslashes($_GET['rz_cz_type']);
        $rz_user=addslashes($_GET['rz_user']);
        $stime=strtotime(addslashes($_GET['stime']));
        $etime=strtotime(addslashes($_GET['etime']));
        if($rz_type=='')
        {
            echo 2;
            die();
        }
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
        $wherestr="rz_type='$rz_type' and ";
        if($rz_mode!='')
        {
            $wherestr.="rz_mode='$rz_mode' and ";
        }
        if($rz_cz_type!='')
        {
            $wherestr.="rz_cz_type='$rz_cz_type' and ";
        }
        if($rz_user!='')
        {
            $wherestr.="rz_user='$rz_user' and ";
        }
		$stime==''?'':$stime.' 00:00:00';
		$etime==''?'':$etime.'23:59:59';
        if($stime!=''&&$etime=='')//只填了开始时间就查询开始时间到当前时间的数据
        {
            $wherestr.="rz_time>='$stime'";
        }
        if($stime==''&&$etime!='')//只填了结束时间，就查询结束时间之前的数据
        {
            $wherestr.="rz_time<='$etime'";
        }
        if($stime!=''&&$etime!='')//开始时间结束时间都填了，就查询开始时间到结束时间之间的数据
        {
            $wherestr.="rz_time>='$stime' and rz_time<='$etime'";
        }
        if($stime==''&&$etime=='')//如果都为空
        {
            $wherestr=substr($wherestr,0,-4);
        }
        //echo "select rz_id,rz_time,rz_user,rz_mode,rz_cz_type,rz_bz from crm_rz where rz_yh='$fid' and  $wherestr  order by rz_time desc ";die;
        $rzbase=M("rz");
        $czrzarr=$rzbase->query("select * from crm_rz where rz_yh='$fid' and  $wherestr  order by rz_time desc ");
        $userbase=M("user");
		$userarr=$userbase->query("select user_name,user_id from crm_user where user_id='$fid' or user_fid='$fid'");
		foreach($userarr as $v)
		{
			$usernamearr[$v['user_id']]=$v['user_name'];
		}
		$lsstr='1000000000';
		$caozuoarr=array(
			"1"=>"新建",
			"2"=>"编辑",
			"3"=>"删除",
			"4"=>"处理",
			"5"=>"提交",
			"6"=>"通过",
			"7"=>"否决",
			"8"=>"导入",
			"9"=>"导出",
			"10"=>"转移给他人",
			"11"=>"转成客户",
			"12"=>"导入至客户公海",
			"13"=>"转入客户公海",
			"14"=>"抢公海客户",
			"15"=>"客户公海删除",
			"16"=>"导入跟进记录",
			"17"=>"添加回款记录",
			"18"=>"编辑回款记录",
			"19"=>"删除回款记录",
			"20"=>"提交回款记录审批",
			"21"=>"否决回款记录审批",
			"22"=>"驳回回款记录审批",
			"23"=>"通过回款记录审批",
			"24"=>"添加回款计划",
			"25"=>"编辑回款计划",
			"26"=>"删除回款计划",
			"27"=>"添加开票记录",
			"28"=>"编辑开票记录",
			"29"=>"删除开票记录",
			"30"=>"添加附件",
			"31"=>"删除附件",
			"32"=>"删除跟进记录",
			"33"=>"添加关联产品",
			"34"=>"编辑关联产品",
			"35"=>"删除关联产品",
			"36"=>"添加关联联系人",
			"37"=>"编辑关联联系人",
			"38"=>"删除关联联系人",
			"39"=>"转成合同",
			"40"=>"批阅",
			"41"=>"交接",
			"42"=>"启用",
			"43"=>"关闭"
		);
		$mokuaiarr=array(
			"1"=>"线索",
			"2"=>"客户",
			"3"=>"客户公海",
			"4"=>"联系人",
			"5"=>"商机",
			"6"=>"合同",
			"7"=>"产品",
			"8"=>"报表中心",
			"9"=>"工作报告",
			"10"=>"跟进记录",
			"11"=>"知识库"
		);
        $sysmokuaiarr=array(
            "1"=>"部门和用户设置",
			"2"=>"角色和权限设置",
			"3"=>"公司信息",
			"4"=>"公告管理",
			"5"=>"业绩目标",
			"6"=>"客户公海",
			"7"=>"工作报告",
			"8"=>"自定义业务字段",
			"9"=>"自定义业务参数",
			"10"=>"自定义审批",
			"11"=>"自定义筛选"
        );
		foreach($czrzarr as $v)
		{
            if($rz_type=='1')
            {
			    $caozuostr.="<tr><td>".substr($lsstr.$v['rz_id'],-10)."</td><td>".date("Y-m-d H:i:s",$v['rz_time'])."</td><td>".$usernamearr[$v["rz_user"]]."</td><td>".$mokuaiarr[$v['rz_mode']]."</td><td>".$caozuoarr[$v['rz_cz_type']]."</td><td>".$v['rz_bz']."</td></tr>";
            }
            if($rz_type=='2')
            {
			    $caozuostr.="<tr><td>".substr($lsstr.$v['rz_id'],-10)."</td><td>".$usernamearr[$v["rz_user"]]."</td><td>".$v['rz_place']."</td><td>".$v['rz_ip']."</td><td>".date("Y-m-d H:i:s",$v['rz_time'])."</td><td>".$v['rz_sb']."</td></tr>";
            }
            if($rz_type=='3')
            {
			    $caozuostr.="<tr><td>".substr($lsstr.$v['rz_id'],-10)."</td><td>".date("Y-m-d H:i:s",$v['rz_time'])."</td><td>".$usernamearr[$v["rz_user"]]."</td><td>".$sysmokuaiarr[$v['rz_mode']]."</td><td>".$v['rz_bz']."</td><td>".$v['rz_sb']."</td><td>".$v['rz_ip']."</td></tr>";
            }
		}
        echo $caozuostr;
    }
}