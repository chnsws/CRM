<?php
namespace Home\Controller;
use Think\Controller;


class AppPageController extends DBController {
    public function fabu()
    {
        //获得最高版本号
        $m=M();
        $version=$m->query("select v_version from crm_app_version order by v_id desc limit 1");
        $version=$version[0]['v_version'];
        //parent::rr($version);
        //echo ini_get('upload_max_filesize');
        $this->assign("version",$version);//当前版本
        $this->assign("allowMax",ini_get('upload_max_filesize'));//服务器允许上传的文件的最大值
        $this->display();
    }
    public function fabu2()
    {
        
        $vid=$_POST['versionid'];
        $vinfo=$_POST['versioninfo'];

        $file=$_FILES['versionfile'];
        //parent::rr($file);
        $oldnamehz=substr(strrchr($file['name'], '.'), 1);
        $newfilename=time().'.'.$oldnamehz;

        $ss=move_uploaded_file($file['tmp_name'],'./Public/appUpdateWgt/'.$newfilename);

        if(!file_exists('./Public/appUpdateWgt/'.$newfilename))
        {
            echo '<script>alert("上传失败");window.location="./fabu";</script>';
            die();
        }

        $nowdate=date("Y-m-d H:i:s",time());

        $m=M();
        $m->query("insert into crm_app_version values('','$vid','$newfilename','$file[size]','$nowdate','$vinfo')");

        echo '<script>alert("上传成功");window.location="./fabu";</script>';
    
    }
}