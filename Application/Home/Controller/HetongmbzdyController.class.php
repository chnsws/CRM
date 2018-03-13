<?php
namespace Home\Controller;
use Think\Controller;


class HetongmbzdyController extends Controller {

	public function zdy(){
		
		$m=M('zdymb');
		$where['logo']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$sql=$m->where($where)->select();
		$rongqi.="<select onchange='shaixuana()' class='shaixuan' style='height: 30px;
		max-width: 100%;
		width:300px;
		padding: 4px 6px;
		border: 1px solid #ddd;
		background: #fff;
		color: #444;
		-webkit-transition: all linear .2s;
		transition: all linear .2s;
		border-radius: 4px;' name='' >";
			foreach($sql as $k=>$v)
			{
				$rongqi.="<option value=".$v['id']." >".$v['name']."</option>";
			}
			$rongqi.="</select  >";
		
			$this->assign("rongqi",$rongqi);
		$this->display();
	}
	public function pdf1(){
		
		/*$header =  
		//页眉设置  
		 '<pageheader name="myHeader" content-left="" content-center="xxxx报告" content-right="{DATE Y-m-d}" '  
				. 'header-style="font-family:sans-serif; font-size:8pt;color:#880000;" '  
				. 'header-style-right="font-size:8pt; font-weight:normal; font-style:italic;color:#880000;" line="on" />'.  
		//页脚设置  
				'<pagefooter name="myFooter" content-left="" content-center="xxxxxx平台" content-right="{PAGENO}" '  
				. 'footer-style="font-family:sans-serif; font-size:8pt; font-weight:normal; color:#880000;"'  
				. ' footer-style-left="" line="on" />'.  
		//封面内容  
				'<h1 align="center">xxxxx平台</h1><h2 align="right">xxxx报告</h2>  
					<br><br><br><br><br>  
				<h2 align="right">创建者：'.$userName.'</h2>'.'<h2 align="right">创建日期：'.date("Y-m-d H:i:s")  
		//关键代码，关联上面的<pageheader>代码，使页眉，页脚和目录生成，具体的功能，其实看字段也能猜测出，或者尝试该值看效果。这里奇偶也的页眉页脚相同，根据需求可以设置为不同的格式。       
		 . '<tocpagebreak  font="mono" font-size="16"  paging="on" links="on"   
		resetpagenum="1" pagenumstyle="1"  
		odd-header-name="myHeader" odd-header-value="on" even-header-name="myHeader" even-header-value="on"   
		odd-footer-name="myFooter" odd-footer-value="on" even-footer-name="myFooter" even-footer-value="on"    
		toc-odd-header-name="myHeader" toc-odd-header-value="on" toc-even-header-name="myHeader"   
		toc-even-header-value="on" toc-odd-footer-name="" toc-odd-footer-value="on" toc-even-footer-name="" toc-even-footer-value="on"  
		toc-preHTML="<h1 align="center">目 录</h1>" />';//使用转义符号<==<    >==> ,即写入的html代码要用转义符号  
		$content = 'blablabla....';  
		$html = $header.$content;  */
		//引入mpdf类  
	
	}
	public function pdf(){
	
		$htmla=$_POST['upfile'];
		
		Vendor('mpdf.mpdf');
		//字段含义按顺序分别为：  
		//$mode,$format,默认字体大小，默认字体，左页边距25（默认），右页边距（25），上页边距16，下页边距16，mgh:16,mgf:13,orientation  
		$mpdf=new \mPDF('utf-8','A4','','',25,25,26,16); //'utf-8' 或者 '+aCJK' 或者 'zh-CN'都可以显示中文  
				//设置PDF页眉内容 
$header='<table width="100%" style="margin:0 auto;border-bottom: 1px solid black; vertical-align: middle; font-family: 
serif; font-size: 9pt; color: #000;"><tr> 
<td width="10%"><img src="'.__ROOT__.'/Public/new_pdf/logo.png" width="270px" ></td> 
<td width="30%"></td> 
<td width="60%"  style="font-size:20px;color:#000"><b>北京智子科技
</b><p style="font-size:17px;color:#000">提供一流服务、很牛逼提供一流服务</p></td> 
</tr></table>'; 
  
//设置PDF页脚内容 
$footer='<table width="100%" style=" vertical-align: bottom; font-family: 
serif; font-size: 9pt; color: #000;"><tr style="height:30px"></tr><tr> 
<td width="10%"></td> 
<td width="80%" align="center" style="font-size:14px;color:#000">页脚</td> 
<td width="10%" style="text-align: left;">页码：{PAGENO}/{nb}</td> 
</tr></table>'; 
  
//添加页眉和页脚到pdf中 
$mpdf->SetHTMLHeader($header); 
$mpdf->SetHTMLFooter($footer); 
		//设置字体，解决中文乱码  
		$mpdf -> useAdobeCJK = TRUE;  
		$mpdf ->autoScriptToLang = true;  
		$mpdf -> autoLangToFont = true;  
		//$mpdf-> showImageErrors = true; //显示图片无法加载的原因，用于调试，注意的是,我的机子上gif格式的图片无法加载出来。  
		//设置pdf显示方式  
		$mpdf->SetDisplayMode('fullpage');  
		//目录相关设置：  
		//Remember bookmark levels start at 0(does not work inside tables)H1 - H6 must be uppercase  
		//$this->h2bookmarks = array('H1'=>0, 'H2'=>1, 'H3'=>2);  
		$mpdf->h2toc = array('H3'=>0,'H4'=>1,'H5'=>2);  
		$mpdf->h2bookmarks = array('H3'=>0,'H4'=>1,'H5'=>2);  
		$mpdf->mirrorMargins = 1;  
		//是否缩进列表的第一级  
		$mpdf->list_indent_first_level = 0;  
		  
		//导入外部css文件：  
		$stylesheet1 = file_get_contents(CSS_PATH.'target.css');  
		$mpdf->WriteHTML($stylesheet1,1);  

		$mpdf->WriteHTML($htmla);  //$html中的内容即为变成pdf格式的html内容。  
		$fileName = '测试合同.pdf';  
		//输出pdf文件  
		$mpdf->Output($fileName,'I'); //'I'表示在线展示 'D'则显示下载窗口  
		exit;  
		
		
	}
	public function baocun(){
	
		
	/*	
		*/
		$m=M("zdymb");
		$where['name']=$_POST['name'];
		$where['content']=$_POST['upfile'];
		$where['logo']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$a=0;
		if($a<1)
		{
		$sql=$m->add($where);
		redirect('zdy', 1, '添加成功~页面跳转中...');
		
		}
		
	
	}
}