<?php
namespace Home\Controller;
use Think\Controller;
class SaveSqlController extends Controller {
	public function savefile()
    {
        //拿到Post的数据
        $content=$_POST['content'];
        //写入到文件中
        $nowdate=date("Y_m_d",time());
        $file=fopen("./Public/dataReport/data/".$nowdate.".txt",'w');
        fwrite($file, $content);
        fclose($file);
        //返回值
        return true;
    }
}