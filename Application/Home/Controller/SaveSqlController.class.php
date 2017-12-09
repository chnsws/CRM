<?php
namespace Home\Controller;
use Think\Controller;
class SaveSqlController extends Controller {
	public function savefile()
    {
        //拿到Post的数据
        $content=$_POST['content'];
        $mac=$_POST['mac'];
        
        $nowdate=date("Y_m_d",time());
        //文件目录是否存在
        $dir = './Public/dataReport/getdata/mac-'.$mac;
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        //写入到文件中
        $file=fopen("./Public/dataReport/getdata/mac-".$mac.'/'.$nowdate.".txt",'w');
        fwrite($file, $content);
        fclose($file);
        //返回值
        echo '1';
        return true;
    }
}