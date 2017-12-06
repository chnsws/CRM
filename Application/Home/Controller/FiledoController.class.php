<?php
namespace Home\Controller;
use Think\Controller;


class FiledoController extends DBController {
	public function index(){
        echo 'error';
        die;
    }
    
    //导出引用方法  
    public  function getExcel($fileName,$headArr,$data)  
    {  
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入  
        import("Org.Util.PHPExcel");  
        import("Org.Util.PHPExcel.Writer.Excel5");  
        import("Org.Util.PHPExcel.IOFactory.php");  

        $date = date("Y_m_d",time());  
        $fileName .= "_{$date}.xls";  

        //创建PHPExcel对象，注意，不能少了\  
        $objPHPExcel = new \PHPExcel();  
        $objProps = $objPHPExcel->getProperties();  

        //设置表头  
        $key = ord("A");//A--65  
        $key2 = ord("@");//@--64
        foreach($headArr as $v){  
            if($key>ord("Z")){  
                $key2 += 1;  
                $key = ord("A");  
                $colum = chr($key2).chr($key);//超过26个字母时才会启用  dingling 20150626  
            }else{  
                if($key2>=ord("A")){  
                    $colum = chr($key2).chr($key);  
                }else{  
                    $colum = chr($key);  
                }  
            } 
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);  
            $key += 1;  
        }
        $column = 2;  
        $objActSheet = $objPHPExcel->getActiveSheet();            
        foreach($data as $key => $rows){ //行写入  
            $span = ord("A");  
            $span2 = ord("@");
            foreach($rows as $k=>$v){  
                
                if($span>ord("Z")){  
                    $span2 += 1;             
                    $span = ord("A");  
                    $j = chr($span2).chr($span);//超过26个字母时才会启用  dingling 20150626  
                }else{  
                    if($span2>=ord("A")){  
                        $j = chr($span2).chr($span);  
                    }else{  
                        $j = chr($span);  
                    }  
                }
                //echo $rows[$v['FIELD']];
                //$j = chr($span);  
                $objActSheet->setCellValue($j.$column, strip_tags($v));  
                $span++;  
            }  
            $column++;  
        }   
        $fileName = iconv("utf-8", "gb2312", $fileName);  

        //重命名表  
        //$objPHPExcel->getActiveSheet()->setTitle('test');  
        //设置活动单指数到第一个表,所以Excel打开这是第一个表  
        $objPHPExcel->setActiveSheetIndex(0);  
        ob_end_clean();//清除缓冲区,避免乱码  
        header('Content-Type: application/vnd.ms-excel');  
        header("Content-Disposition: attachment;filename=\"$fileName\"");  
        header('Cache-Control: max-age=0');  

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); //文件通过浏览器下载  
        exit;  
            
    }
    //获取excel文件、读取数据方法  
    public function getdata($file_name,$exts='xls')  
    {  
          
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入  
        import("Org.Util.PHPExcel");  
        //创建PHPExcel对象，注意，不能少了\  
        $PHPExcel=new \PHPExcel();  
          
        if($exts=="xls")  
        {  
            import("Org.Util.PHPExcel.Reader.Excel5");  
            $PHPReader=new \PHPExcel_Reader_Excel5();  
        }  
        else if($exts=="xlsx")  
        {  
            import("Org.Util.PHPExcel.Reader.Excel2007");  
            $PHPReader=new \PHPExcel_Reader_Excel2007();  
        }  
        //载入文件  
        $PHPExcel=$PHPReader->load($file_name);  
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推  
        $currentSheet=$PHPExcel->getSheet(0);  
          
        //获取总列数  
        $allColumn=$currentSheet->getHighestColumn();  
          
        //获取总行数  
        $allRow=$currentSheet->getHighestRow();  
          
        $excelData = array();   
        $filehead=0;
        $fileheadcount=0;
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始  
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            if($filehead==0)
            {
                //从哪列开始，A表示第一列  
                for($currentColumn='A';$currentColumn<='Z';$currentColumn++){  
                    //数据坐标  
                    $address=$currentColumn.$currentRow;  
                    //读取到的数据，保存到数组$arr中  
                    $old_content=$currentSheet-> getCell($address)-> getValue(); 

                    if(is_object($old_content))  $old_content= $old_content->__toString();
                    if(!$old_content)
                    {
                        continue;
                    }
                    $excelData[$currentRow][$currentColumn] = $old_content;
                }
                $fileheadcount=count($excelData[1]);
                $filehead=1;
            }
            else
            {
                $currentColumn='A';
                $nullNum=0;
                for($c=0;$c<$fileheadcount;$c++)
                {
                    $address=$currentColumn.$currentRow;  
                    $old_content=$currentSheet-> getCell($address)-> getValue(); 
                    if(is_object($old_content))  $old_content= $old_content->__toString();
                    $old_content=trim($old_content);//移除空格
                    $excelData[$currentRow][$currentColumn] = $old_content;
                    //计算空格数量
                    if(!$old_content)
                    {
                        $nullNum++;
                    }
                    $currentColumn++;
                }
                //如果本条所有数据都是空，就删除本条
                //echo $nullNum.'-'.$fileheadcount.'/';
                if($nullNum>=$fileheadcount)
                {
                    //echo $nullNum.'>='.$fileheadcount;
                    unset($excelData[$currentRow]);
                }
            }
            
        }  
         return $excelData;  
    }
}