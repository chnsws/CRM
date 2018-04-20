<?php
namespace Home\Controller;
use Think\Controller;


class AppGenjinController extends AppPublicController {
    public function genjinList()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);

        $fid=$userinfo['fid'];

        $openmod=addslashes($header['openmod']);
        $infoid=addslashes($header['infoid']);

        $modindex=parent::modindex($openmod);
        //parent::rr($userinfo);
        $m=M();
        $genjindata=$m->query("select user_id,type,content,date,add_time,xgj_czr from crm_xiegenjin where genjin_yh='$fid' and mode_id='$modindex' and kh_id='$infoid' order by add_time desc ");

        //如果没有数据，就不进行其他操作了
        if(!count($genjindata))
        {
            $r['code']='0';
            $r['data']='';
            die(json_encode($r));
        }

        if($modindex=='1')
        {
            //如果是线索模块  就去查询参数
            $fangshiarr=$m->query("select ywcs_data from crm_ywcs where ywcs_yh='$fid' and ywcs_yw='7' limit 1");
            $fangshiarr=json_decode($fangshiarr[0]['ywcs_data'],true);
            //parent::rr($fangshiarr);
            foreach($fangshiarr[0] as $k=>$v)
            {
                if(substr($k,0,6)!='canshu')
                {
                    continue;
                }
                if($fangshiarr[0]['qy'][$k]!='1')
                {
                    continue;
                }
                $genjinfangshi_option.="<option value='$k'>$v</option>";
                $genjinfangshi_name_arr[$k]=$v;
            }
        }
        //本部门的用户名称查询
        $username=$m->query("select user_name,user_id from crm_user where (user_id='$fid' or user_fid='$fid') and user_del='0'");
        foreach($username as $v)
        {
            $usernamearr[$v['user_id']]=$v['user_name'];
        }
        $lianxirenIdArr=array();//联系人数组，先把联系人放到这个数组中，如果数组为空就不去查询联系人表
        foreach($genjindata as $v)
        {
            $row=$v;
            $row['user_id']=$usernamearr[$v['user_id']]?$usernamearr[$v['user_id']]:'用户已被删除';
            if($modindex=='1')
            {
                $row['type']=$genjinfangshi_name_arr[$v['type']];
                $row['date']=date("Y-m-d H:i:s",$v['date']);
                $row['add_time']=date("Y-m-d H:i:s",$v['add_time']);
            }
            $thisdate=substr($row['add_time'],0,10);
            $data[$thisdate][]=$row;

            //联系人
            if($v["xgj_czr"]!='')
            {
                $lianxirenIdArr[$v['xgj_czr']]=$v['xgj_czr'];
            }
        }
        //如果需要查询联系人表
        $sql_count=count($lianxirenIdArr);
        if($sql_count>0)
        {
            $sql_in="'".implode("','",$lianxirenIdArr)."'";
            
            $lx=$m->query("select lx_id,lx_data from crm_lx where lx_id in ($sql_in) limit $sql_count  ");
            foreach($lx as $k=>$v)
            {
                $j=json_decode($v['lx_data'],true);
                $lxName[$v['lx_id']]=$j['zdy0'];
            }
        }
        
        foreach($data as $k=>$v)
        {
            foreach($v as $kk=>$vv)
            {
                $data[$k][$kk]['lxr_name']=$lxName[$vv['xgj_czr']]==''?'联系人不存在或已被删除':$lxName[$vv['xgj_czr']];
            }
        }


        $res['code']='0';
        $res['data']=$data;
        
        echo json_encode($res);
        //parent::rr($data);
    }
    public function genjinCanshu()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        $fid=$userinfo['fid'];

        $m=M();
        $csdata=$m->query("select ywcs_data,ywcs_yw from crm_ywcs where ywcs_yh='$fid' and ywcs_yw in ('1','7') limit 2");
        
        foreach($csdata as $v)
        {
            $csarr[$v['ywcs_yw']]=$v;
        }
        //跟进方式
        $canshu['fangshi']=json_decode($csarr['7']['ywcs_data'],true)[0];
        
        //跟进状态
        $canshu['zhuangtai']=json_decode($csarr['1']['ywcs_data'],true);
        foreach($canshu['zhuangtai'] as $v)
        {
            if($v['id']=='zdy14')
            {
                $canshu['zhuangtai']=$v;
                break;
            }
        }


        foreach($canshu as $k=>$v)
        {
            unset($canshu[$k]['id']);
            $row_qy=$v['qy'];
            unset($canshu[$k]['qy']);
            foreach($row_qy as $qyk=>$qyv)
            {
                if(!$qyv)
                {
                    unset($canshu[$k][$kk]);
                }
            }
        }
        $res['code']='0';
        $res['serDate']=date("Y-m-d H:i",time());
        $res['canshu']=$canshu;
        echo json_encode($res);
        //parent::rr(json_encode($canshu));
        //echo '{"code":"0"}';
    }
    public function getlianxiren()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        $fid=$userinfo['fid'];

        $m=M();

        $thismod=addslashes($header['thisviewname']);

        $thisid=addslashes($header['thisinfoid']);

        $khid='';
        //先匹配到对应的客户
        if($thismod=='kehu')
        {
            $khid=$thisid;
        }
        else if($thismod=='shangji')
        {
            $sjdata=$m->query("select sj_data from crm_shangji where sj_id='$thisid' and sj_yh='$fid' limit 1");
            $sjdata=json_decode($sjdata[0]['sj_data'],true);
            $khid=$sjdata['zdy1'];
        }
        else if($thismod=='hetong')
        {
            $htdata=$m->query("select ht_data from crm_hetong where ht_id='$thisid' and ht_yh='$fid' limit 1");
            $htdata=json_decode($htdata[0]['ht_data'],true);
            $khid=$htdata['zdy1'];
        }
        else
        {
            $res['code']='-1';
            $res['data']='查询不到匹配的联系人';
            die(json_encode($res));
        }
        //根据匹配到的客户，查询属于该客户的联系人
        $lxrdata=$m->query("select lx_id,lx_data from crm_lx where lx_yh='$fid' and lx_data like '%".$khid."%' ");
        $wordArr=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        foreach($lxrdata as $k=>$v)
        {
            $j=json_decode($v['lx_data'],true);
            if($j['zdy1']!=$khid)
            {
                continue;
            }
            $pinyin=$this->strToWord($j['zdy0']);
            $thisFirstWord=$pinyin[0];
            $pinyin=implode('',$pinyin);
            $thisFirstWord=in_array($thisFirstWord,$wordArr)?$thisFirstWord:'#';
            $data[$thisFirstWord][]=array(
                "firstWord"=>$thisFirstWord,
                "pinyin"=>$pinyin,
                "name"=>$j['zdy0'],
                "id"=>$v['lx_id']
            );
        }
        //按照字母的顺序排序
        foreach($wordArr as $v)
        {
            if(!count($data[$v]))
            {
                continue;
            }
            $data2[$v]=$data[$v];
        }
        if(count($data["#"]))
        {
            $data2["#"]=$data["#"];
        }
        $data=$data2;
        if(!count($data))
        {
            $res['code']='0';
            $res['data']='';
        }
        else
        {
            $res['code']='0';
            $res['data']=$data;
        }
        die(json_encode($res));
    }


    public function genjinBaocun()
    {
        $header=getallheaders();
        //用户信息
        $userinfo=parent::loginStatus($header);
        $fid=$userinfo['fid'];

        $content        =addslashes($_POST['content']);//内容
        $fangshi        =addslashes($_POST['fangshi']);//方式
        $zhuangtai      =addslashes($_POST['zhuangtai']);//状态
        $lianxiren      =$_POST['lianxiren'];//联系人
        $nowdate        =addslashes($_POST['nowdate']);//实际跟进时间
        $nextdate       =addslashes($_POST['nextdate']);//下次跟进时间
        $nowinfoid      =addslashes($_POST['nowinfoid']);//当前数据id
        $thisviewname   =addslashes($_POST['thisviewname']);//当前数据所属模块

        //验证数据完整性
        if($content==''||$fangshi==''||$zhuangtai==''||$nowdate==''||$nextdate==''||$nowinfoid==''||$thisviewname=='')
        {
            $r['code']='-1';
            $r['data']='参数不全';
            die(json_encode($r));
        }
        //如果不是线索模块和合同模块，再验证联系人数据的完整性
        if($thisviewname!='xiansuo'&&$thisviewname!='hetong')
        {
            if(!count($lianxiren))
            {
                $r['code']='-1';
                $r['data']='参数不全';
                die(json_encode($r));
            }
            if(count($lianxiren)>1)
            {
                $r['code']='-1';
                $r['data']='暂不支持多个联系人';
                die(json_encode($r));
            }

        }
        //线索的话，时间都改成时间戳
        if($thisviewname=='xiansuo')
        {
            $nowdate=strtotime($nowdate);
            $nextdate=strtotime($nextdate);
        }

        $m=M();
        //插入跟进表
        $modid=parent::modindex($thisviewname);
        $lianxiren=$lianxiren[0];
        //如果是合同的话  要查询该合同属于哪个客户
        $ht2kh='';
        if($modid=='6')
        {
            
            $htinfo=$m->query("select ht_data from crm_hetong where ht_id='$nowinfoid' and ht_yh='$fid' limit 1");
            $ht2kh=json_decode($htinfo[0]['ht_data'],true)['zdy2'];
        }
        //执行插入
        $m->query("insert into crm_xiegenjin set 
            mode_id='$modid',
            kh_id='$nowinfoid',
            user_id='$userinfo[user_id]',
            type='$fangshi',
            content='$content',
            date='$nextdate',
            add_time='$nowdate',
            genjin_yh='$fid',
            xgj_czr='$lianxiren',
            gl_khid='$ht2kh'
        ");

        $r['code']='0';
        echo json_encode($r);






    }




    protected function strToWord($str)
    {
        $str= iconv("UTF-8","gb2312", $str);
        $i=0;
        $r='';
        while($i<strlen($str) ) {
        $tmp=bin2hex(substr($str,$i,1));
        if($tmp>='B0'){ //汉字的开始
            $t=$this->getLetter(hexdec(bin2hex(substr($str,$i,2))));
            $r[]=sprintf("%c",$t==-1 ? '*' : $t );
            $i+=2;
        }
        else{
            $r[]=sprintf("%s",substr($str,$i,1));
            $i++;
        }
        }
        return $r;
    }
    protected function getLetter($num){
        $limit = array( //gb2312 拼音排序
            array(45217,45252), //A
            array(45253,45760), //B
            array(45761,46317), //C
            array(46318,46825), //D
            array(46826,47009), //E
            array(47010,47296), //F
            array(47297,47613), //G
            array(47614,48118), //H
            array(0,0),     //I
            array(48119,49061), //J
            array(49062,49323), //K
            array(49324,49895), //L
            array(49896,50370), //M
            array(50371,50613), //N
            array(50614,50621), //O
            array(50622,50905), //P
            array(50906,51386), //Q
            array(51387,51445), //R
            array(51446,52217), //S
            array(52218,52697), //T
            array(0,0),     //U
            array(0,0),     //V
            array(52698,52979), //W
            array(52980,53688), //X
            array(53689,54480), //Y
            array(54481,55289), //Z
            );
    $char_index=65;
    foreach($limit as $k=>$v){
        if($num>=$v[0] && $num<=$v[1]){
        $char_index+=$k;
        return $char_index;
        }
    }
    return -1;
    }
}