<?php
namespace Home\Controller;
use Think\Controller;
class DBController extends Controller {
    //首页默认显示跟进记录的报表，并且是今日的
	public function index()
    {
        echo "This is a Class.";
    }
    //查询一个
    public function sel_one_data($basename,$field='*',$tj)
    {
        $bk=$this->basename_do($basename);
        $onequery=$bk['basemod']->query("select $field from ".$bk['qz'].$bk['basename']." where $tj limit 1");
        $returnarr=$field=='*'?$onequery[0]:$onequery[0][$field];
        return $returnarr;
    }
    //查询多个
    public function sel_more_data($basename,$field='*',$tj,$key=0)
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
    //添加一条
    public function add_one_data($basename,$setstr,$field='',$value='')
    {
        $bk=$this->basename_do($basename);
        $z=$field==''?"values($setstr)":"set $field='$value' ";
        $bk['basemod']->query("insert into ".$bk['qz'].$bk['basename']." $z");
    }
    //修改一条
    public function edit_one_data($basename,$field,$value,$tj)
    {
        $bk=$this->basename_do($basename);
        $bk['basemod']->query("update ".$bk['qz'].$bk['basename']." set $field='$value' where $tj limit 1 ");
    }
    //修改多条
    public function edit_more_data($basename,$field,$tj)
    {
        $bk=$this->basename_do($basename);
        $bk['basemod']->query("update ".$bk['qz'].$bk['basename']." set $field where $tj limit 1 ");
    }
    //处理数据表名称
    public function basename_do($basename)
    {
        $rt['qz']=substr($basename,0,4);
        $rt['basename']=substr($basename,4);
        $rt['basemod']=M($basename);
        return $rt;
    }
    //获取父id
    public function get_fid()
    {
        $this->is_login();
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
        return $fid;
    }
    //验证登录
    public function is_login()
    {
        if(cookie("islogin")!='1')
		{
			$this->main_gotopage($_GET['root_dir'].'/index.php/Home/Login');
			die();
		}
    }
    //窗口跳转
    public function main_gotopage($pageurl)
    {
        echo "<script>window.parent.location='".$pageurl."'</script>";
        die;
    }
    public function self_gotopage($pageurl)
    {
        echo "<script>window.location='".$pageurl."'</script>";
        die;
    }
    //开发测试输出数组
    public function rr($arr)
    {
        echo "<pre>";print_r($arr);die;
    }
    //今日、本周、本月、本季度、本年
    public function time_more()
    {
        $timearr=array();
        //本日
        $timearr['2']['s']=date("Y-m-d",time()).' 00:00:00';
        $timearr['2']['e']=date("Y-m-d",time()).' 23:59:59';
        //本周
        $timearr['3']['s']=date("Y-m-d H:i:s",strtotime("-1 week Monday"));//本周一
        $timearr['3']['e']=date("Y-m-d",strtotime("Sunday")).' 23:59:59';         //本周末
        //本月
        $timearr['4']['s']=date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
        $timearr['4']['e']=date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));
        //本季度
        $nowm=date("m",time());
        $nowyear=date("Y",time());
        if($nowm>=1&&$nowm<4)
        {
            //第一季度
            $timearr['5']['s']=$nowyear.'-01-01 00:00:00';
            $timearr['5']['e']=$nowyear.'-03-31 23:59:59';
        }
        else if($nowm>=4&&$nowm<7)
        {  
            //第二季度
            $timearr['5']['s']=$nowyear.'-04-01 00:00:00';
            $timearr['5']['e']=$nowyear.'-06-30 23:59:59';
        }
        else if($nowm>=7&&$nowm<10)
        {
            //第三季度
            $timearr['5']['s']=$nowyear.'-07-01 00:00:00';
            $timearr['5']['e']=$nowyear.'-09-30 23:59:59';
        }
        else
        {
            //第四季度
            $timearr['5']['s']=$nowyear.'-10-01 00:00:00';
            $timearr['5']['e']=$nowyear.'-12-31 23:59:59';
        }
        //本年
        $timearr['6']['s']=date('Y',time()).'-01-01 00:00:00';
        $timearr['6']['e']=date('Y',time()).'-12-31 23:59:59';
        return $timearr;
    }
    //获取的本月多少天
    public function get_day_num($unix){  
        $month = date('m', $unix);  
        $year = date('Y', $unix);  
        $nextMonth = (($month+1)>12) ? 1 : ($month+1);  
        $year      = ($nextMonth>12) ? ($year+1) : $year;  
        $days   = date('d',mktime(0,0,0,$nextMonth,0,$year));  
        return $days;  
    }  
    //获得本年多少天
    public function get_year_num($unix)
    {
        $year = date("Y",$unix);
        $time = mktime(20,20,20,4,20,$year);//取得一个日期的 Unix 时间戳;  
        if (date("L",$time)==1){ //格式化时间，并且判断是不是闰年，后面的等于一也可以省略；  
            return 366; 
        }else{  
            return 365; 
        }  
    }
}