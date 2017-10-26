<?php
namespace Home\Controller;
use Think\Controller;


class FankuiController extends Controller {
	//模板框架
    public function index(){
		$mod=A("Cpfl");
        $mod->is_login();
        $user_id=cookie("user_id");
        $listbtn='';
        if($user_id<5)
        {
            $listbtn='<input type="button" style="height:40px;line-height: 40px;border-radius: 5px;color:#fff;font-weight: bold;margin-top:10px;width:200px;" onclick="window.location=\''.$_GET['root_dir'].'/index.php/Home/Fankui/fk_list\'" class="layui-btn layui-btn-danger" value="查看已提交反馈" />';
        }
        $this->assign("listbtn",$listbtn);
        $this->display();
    }
    //处理提交的反馈
    public function feedback_to_db()
    {
        $mod=A("Cpfl");
        $fid=$mod->get_fid();
        $user_id=cookie("user_id");
        $bro_info=$_SERVER['HTTP_USER_AGENT'];
        $fk_time=date("Y-m-d H:i:s",time());
        $feedback_title = addslashes($_POST['feedback_title']);
        $feedback_mod   = addslashes($_POST['feedback_mod']);
        $feedback_type  = addslashes($_POST['feedback_type']);
        $feedback_more  = addslashes($_POST['feedback_more']);
        $feedback_img=$_FILES['feedback_img'];
        $newfilename='';
        //处理图片
        if(!$feedback_img[error])
        {
            $hz=substr(strrchr($feedback_img['name'], '.'), 1);//后缀
            $newfilename=$fid.'_'.$user_id.'_'.time().'.'.$hz;
            $ismove=move_uploaded_file($feedback_img['tmp_name'],'./Public/feedbackImg/'.$newfilename);
            if(!file_exists('./Public/feedbackImg/'.$newfilename))//验证上传是否成功
            {
                echo "<script>alert('图片上传失败，请稍后再试');</script>";
                echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Fankui/index';</script>";
                die();
            }
        }
        $mod->add_one_data("crm_feedback","'','$feedback_title','$feedback_more','$newfilename','$feedback_mod','$feedback_type','$user_id','$bro_info','$fk_time','0'");
        echo "<script>alert('您的反馈已经收录，我们会认真对您所提出来的建议对系统进行相应的改进，感激您宝贵的意见和建议。');</script>";
        echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Fankui/index';</script>";
    }
    public function fk_list()
    {
        $user_id=cookie("user_id");
        if($user_id>5)
        {
            echo "无权限";
            die;
        }
        $modarr=array(
            '1'=>'线索',
            '2'=>'客户',
            '3'=>'客户公海',
            '4'=>'联系人',
            '5'=>'商机',
            '6'=>'合同',
            '7'=>'产品',
            '8'=>'报表中心',
            '9'=>'工作报告',
            '10'=>'跟进记录',
            '11'=>'知识库',
            '12'=>'设置中心',
            '13'=>'部门和用户设置',
            '14'=>'角色和权限设置',
            '15'=>'公司信息',
            '16'=>'公告管理',
            '17'=>'业绩目标',
            '18'=>'客户公海（后台设置）',
            '19'=>'工作报告',
            '20'=>'自定义业务字段',
            '21'=>'自定义业务参数',
            '22'=>'自定义审批',
            '23'=>'自定义筛选',
            '24'=>'日志查询',
            '25'=>'其他'
        );
        $typearr=array(
            '1'=>'优化建议',
            '2'=>'BUG提交',
            '3'=>'逻辑有误',
            '4'=>'运行速度',
            '5'=>'其他'
        );
        $fkbase=M("feedback");
        $tj='';
        
        if($_GET['mod'])
        {
            $tj.=" and crm_feedback.fk_mod='".$_GET['mod']."' ";
        }
        if($_GET['type'])
        {
            $tj.=" and crm_feedback.fk_type='".$_GET['type']."' ";
        }
        if($_GET['act'])
        {
            $tj.=" and crm_feedback.fk_act='".$_GET['act']."' ";
        }
        else
        {
            $tj.=" and crm_feedback.fk_act='0' ";
        }
        $fkarr=$fkbase->query("select crm_feedback.*,crm_user.user_name from crm_feedback left join crm_user on crm_feedback.fk_user_id=crm_user.user_id where 1 $tj ");
        
        $tablestr='';
        foreach($fkarr as $v)
        {
            $a1=mb_strlen($v['fk_title'])>15?substr($v['fk_title'],0,15).'...':$v['fk_title'];
            $a2=mb_strlen($v['fk_content'])>15?substr($v['fk_content'],0,15).'...':$v['fk_content'];
            $tupian=$v['fk_img']==''?'无图片':'<a href="'.$_GET['public_dir'].'/feedbackImg/'.$v['fk_img'].'" data-uk-lightbox >查看图片</a>';
            $button=$_GET['act']?'禁止操作':'<button class="layui-btn" id="wancheng'.$v['fk_id'].'">完成</button><button class="layui-btn" id="hulve'.$v['fk_id'].'">忽略</button>';
            $tablestr.='<tr>
                            <td title="'.$v['fk_title'].'">'.$a1.'</td>
                            <td>'.$modarr[$v['fk_mod']].'</td>
                            <td>'.$tupian.'</td>
                            <td title="'.$v['fk_content'].'">'.$a2.'</td>
                            <td>'.$typearr[$v['fk_type']].'</td>
                            <td>'.$v['user_name'].'</td>
                            <td>'.$v['fk_date'].'</td>
                            <td title="'.$v['fk_browser'].'">浏览器信息</td>
                            <td>
                                '.$button.'
                            </td>
                        </tr>';
        }
        $this->assign("tablestr",$tablestr);
        $this->display();
    }
    public function change_act()
    {
        $fkbase=M("feedback");
        $fkbase->query("update crm_feedback set fk_act='".$_GET['act']."' where fk_id='".$_GET['fk_id']."' limit 1");
        echo 1;
    }
}



