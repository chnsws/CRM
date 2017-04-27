<?php
namespace Home\Controller;
use Think\Controller;


class HetongController extends Controller {

    public function hetong(){
    //	echo "<pre>";
    	//print_r(cookie());
    	//die;

  		$b=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="6";
  		$map['zd_yh']="2";//这里通过查询获得
  		$sql=$b->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		
		$kehu=M('hetong');                             //显示客户所需字段data
		$kehu=$kehu->select();

		//查询所有用户


		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){

				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
			

		}
		$a_arr=$new_qy;
		foreach ($a_arr as $kbj=>$vbj )//客户批量编辑用
		{
			if($vbj['type']=="3")
			{
				$pl_bj=$vbj;
				$pl_bj_arr[]=$pl_bj;
			}
		}
$this->assign("pl_bj",$pl_bj_arr);
		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"实际跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"前负责人",'ht_old_bm'=>"前所属部门",'ht_cj_date'=>"创建时间",'ht_gx_date'=>"更新于",'ht_yh'=>"所属公司",'ht_xiezuo'=>"协作人",'ht_yihui'=>"已回款金额",'ht_weihui'=>"未回款金额",'ht_yikai'=>"已开票金额",'ht_weikai'=>"未开票金额");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($a_arr,$new_array);//合同标题名字
//echo "<pre>";
//var_dump($kh_biaoti1);exit;
		$conf=M('config');
		$conf_sql=$conf->field("config_ht_data")->find();
		
		$conf_sql_json=json_decode($conf_sql['config_ht_data'],true);
		//echo "<pre>";
		//var_dump($conf_sql_json);exit;
        $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="6";
 		$yw_cs['ywcs_yh']=2;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 		//echo "<pre>";
		//var_dump($ywcs_sql_json);exit;
 		foreach($ywcs_sql_json as $kywcs=>$vywcs)
			{
				$ywcs_new[$vywcs['id']]=$vywcs;
			}
         //echo "<pre>";
		//var_dump($ywcs_new);exit;
		foreach($kehu as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk!='ht_data')
					$ronghe[$k][$kk]=$vv;
				else
				{
					$rowjson=json_decode($vv,true);//把js data解析成数组
					     //echo "<pre>";
		                 //var_dump($rowjson);exit;
					foreach($rowjson as $kkk=>$vvv)
					{	
						if($kkk=='zdy7' || $kkk=='zdy10' ||$kkk=='zdy11')
						{
							//echo $kkk;
							foreach($ywcs_new as $kcs=>$vcs)
							{
								if($kkk==$kcs)
								{
									$ronghe[$k][$kkk]=$vcs[$vvv];
								}
									
							}
					}else{
						$ronghe[$k][$kkk]=$vvv;

					}
						

						

					}
				}
			}
		}//融合整条信息
		//echo "<pre>";
		//var_dump($ronghe);exit;
		foreach ($ronghe as $key1 => $val1){
			foreach($val1 as $key2 =>$val2){  

				$ceshi2[]=$val1[$key2];
			}
			
			$adddd[]=$ceshi2;
			unset($ceshi2);
		}

 		foreach($ywcs_sql_json as $ywcs_k=>$ywcs_v){
 			foreach($ywcs_v as $k=>$v){
 				$ywcs_jianzhi[]=$k;
 			}
 			$abc[]=$ywcs_jianzhi;
 			unset($ywcs_jianzhi);
 		}

      $sql_peizhi=array();
	   foreach($a_arr as $k=>$v){     //显示配置左边标题头
	   		foreach($conf_sql_json as $key=>$val){
	   			if($v['id']==$val){
	   			$sql_peizhi[]=array('name'=>$v['name'],'id'=>$val,'type'=>$v['type']);
	   			//echo "<pre>";
		        //var_dump($sql_peizhi);exit;
	   			}	
	   		}
	 } 
		foreach($ywcs_sql_json as $k=>$v)
		{

			$ywcs_sql_json[$v['id']]=$v;
			unset($ywcs_sql_json[$k]);
		}
		//echo "<pre>";
		//var_dump($ywcs_sql_json);exit;
		foreach ($pl_bj_arr as $k=>$v){ //多条编辑 弹出框对应数据
	//echo "<pre>";
		//var_dump($pl_bj_arr);exit;
			$bj_tab.="<tr class='yincang top_pl_bj' style='line-height:70px' id='wc".$v['id']."'><td>".$v['name'].":</td>";
			
			if($v['type']=='3')
			{
				//echo $v['id'];
				$bj_tab.="<td>";
				$bj_tab.="<select id='".$v['id'].'wys'."'  style='width:260px;height:26px;'>";
				foreach($ywcs_sql_json[$v['id']] as $k=>$vv)
				{
					//var_dump($ywcs_sql_json[$v['id']]);exit;
					if($k!='id'&&$k!='qy')
						$bj_tab.="<option value='$k'>".$vv."</option>";
				}
				$bj_tab.="</select>";
				$bj_tab.="</td>";
			}
			$bj_tab.="</tr>";    //多条编辑 弹出框对应数据
		}
		$this->assign('bj_tab',$bj_tab);
		//echo "<pre>";
		//var_dump($bj_tab);exit;
		$new_html.="<div class='sxzddiv' id='kehujibie'>";
					$new_html.=" <div class='sx_title' >合同范围：</div>";
							$new_html.=" <span class='sx_yes'>全部合同</span>";
							$new_html.="<span class='sx_no'>我的合同</span>";
							$new_html.="<span class='sx_no'>我协作的合同</span>";
							$new_html.="<span class='sx_no'>待的合同</span>";					
				$new_html.="</div>";
		foreach($sql_peizhi as $v)
		{
				$new_html.="<div class='sxzddiv' id='".$v['id']."'>";
					$new_html.=" <div class='sx_title' >".$v['name']."：</div>";
						$new_html.=" <span class='sx_yes'>全部</span>";
					foreach($ywcs_sql_json[$v['id']] as $k=>$vv)
					{
						if($k!='id'&&$k!='qy')
							$new_html.="<span class='sx_no'>".$vv."</span>";
					}
				$new_html.="</div>";

		}
		//echo "<pre>";
		//var_dump($new_html);exit;		
		$this->assign('sx_tj',$sql_peizhi);    
	$this->assign('new_html',$new_html);           //配置信息

	 /**	if($_GET['id3']=='0128'){//配置进来的筛选
	 		$get_id=$_GET['id']; //canshu1
			$get_id1=$_GET['id1'];//重要客户	
			$get_id2=$_GET['id2'];//zdy1
			$get_id3=$_GET['id3'];//0128

			foreach( $ronghe as $k=>$v){
				foreach ($v as $key=>$val ){
					if ($key==$get_id2&&$val==$get_id1){
							$shaixuan1[]=$v;//获取到新的筛选的单条信息

					}
	 		
				}
				
			}
			$ronghe1[]=$shaixuan1;
			//筛选最终信息
	 	}**/
	 	$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
	 		$xiaji= $this->get_xiashu_id();//  查询下级ID
			$new_xiaji=$xiaji; 
			$new_array=explode(',',$new_xiaji);
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren=$v;
						$fzr_only[]=$new_fuzeren;
					}
						
				}
			}

			  $xiaji= $this->get_xiashu_id();

			$new_xiaji=substr($xiaji,0,strlen($xiaji)-2); 
			
			$xiaji_base=M('kh');
			$new_array=explode(',',$new_xiaji);
			//echo"<pre>";
			//var_dump($new_array);exit;
			foreach($new_array as $k=>$v){

				//$where.="fuzeren like '. ' %'.$v.'% ' .'or";
				$where.='kh_data like   \'%"fuzeren":"'.$v.'"%\' or ';
			}
			$zhixing_xiaji=substr($where,0,strlen($where)-3); 
         
          $sql_xiaji=$xiaji_base->query("select * from crm_kh where $zhixing_xiaji");//下级数据
        
          $nachu=array();
				foreach($sql_xiaji as $k=>$v){
					$nachu=json_decode($v['kh_data'],true);
					$khoption.="<option value='".$v['kh_id']."'>".$nachu['zdy0']."</option>";
				}
      
	 	$this->assign('khoption',$khoption);
	 	$gu=$xiaji_base->select();

	  //echo "<pre>";
	// var_dump($gu);exit;
	 	foreach($ronghe as $k=>$v)
	 	{

	 		foreach($gu as $k1=>$v1)
	 		{	//var_dump( $v['zdy1']);
	 			//echo "2"; 
	 			//echo $v1['kh_id'];
	 			//echo "<pre>";exit;
	 			if($v['zdy1']==$v1['kh_id'])
	 			{

						$nachu=json_decode($v1['kh_data'],true);
						$v['zdy1']=$nachu['zdy0'];
						$new_rong=$v;	
						$ronghee[]=$new_rong;
							
	 			}
	 			
	 		}
	 		
	 	}

    $ronghe=$ronghee;
			//echo "<pre>";
			//var_dump($fzr_only);exit;
	 	$this->assign('fuzeren',$fzr_only);
	 	$this->assign("ywcs_biao",$ywcs_sql_json);
    	$this->assign('left_conf',$sql_peizhi);
		$this->assign('list',$jianzhi); 
		
	//	echo "<pre>";
		//var_dump($ronghe);exit;
		foreach($ywcs_sql_json as $k=>$v)
		{

			$ywcs_sql_json[$v['id']]=$v;
			unset($ywcs_sql_json[$k]);
		}
		
					foreach($ronghe as $r_k=>$r_v)//$r_v融合完的第一条数据
					{	

						$a_fuzeren=$r_v['fuzeren'];//查出第一条融合完的数据的第一条
						$v=$r_v['zdy0'];//查出我合同名称
						
			
						$id=$r_v['ht_id'];//查出我第一条融合完信息的ID
						
						$table.="<tr id='tr".$r_v['ht_id']."'>";
								$xs123=$r_v['ht_id'];//第一条融合完信息的ID
								
								$table.="
										<td >
											<input type='checkbox' class='chbox_duoxuan' id='$xs123'>$xs123
										</td>";
								foreach($kh_biaoti1 as $k_biaoti=>$v_biaoti)//$kh_biaoti1为合同与后台数据联系起来的地方
                                //$v_biaoti为zdy0合同标题
								{	
									
									if($r_v[$v_biaoti['id']]!="")	
									{
											$a_fuzeren=$r_v['fuzeren'];//负责人
											 $a_a=$r_v['zdy7'];
						                     $a_b=$r_v['zdy10'];
						                     $a_c=$r_v['zdy11'];
											
											if($v_biaoti['id']=='zdy0')
												$xs123="<a href='hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c'>".$r_v[$v_biaoti['id']]."
												</a>";
											
											elseif($v_biaoti['id']=="fuzeren")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['fuzeren'])
															$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";

													}
													
												}
											elseif($v_biaoti['id']=="ht_old_fz")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['ht_old_fz'])
															$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";

													}
													
												}
											else
												$xs123="
												<span id='wys{$id}'>".$r_v[$v_biaoti['id']]."</span>
												<i class='fa fa-pencil' aria-hidden='true' >	</i>
												<input type='text'  name='".$v_biaoti['id']."'  id='{$id}' class='bianji bianji_hide' value='".$r_v[$v_biaoti['id']]."' onblur=''  >";

									
												$table.="<td name='$k'>
													$xs123
												</td>";
									}else{

												$xs123="
												<span id='wys{$id}'>未填写</span>
												<i class='fa fa-pencil' aria-hidden='true' >	</i>
												<input type='text' name='".$v_biaoti['id']."' id='{$id}' class='bianji bianji_hide' value='' onblur=''  >";
												$table.="<td name='$k'>
													$xs123
												</td>";

									}
									
									
								}
						//	}
						//}
						$table.="</tr>";	//echo $table;exit;
						
		}
		
		$this->assign('table',$table);
		$this->assign('kehu1',$kh_biaoti1);//显示客户标题
		$this->assign('kehu',$a_arr);//新增合同标题
        $this->display();
    }


		public function add(){
		    $data['ht_data']=$_GET['id'];

		    	$a_arr=json_decode( $data['ht_data'],true);
	
			$shi=M('hetong');
			$sql=$shi->add($data);

				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$shi->where($data)->field('ht_id')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
		 		$rz_map['rz_object']=$id['ht_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了合同".$a_arr['zdy0'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'
			if($sql){
				echo "ok";
			
			}else{
				echo "no";
		     
		    }

}
 


		public function index(){//这才是修改

			$bianji_id['ht_id']= $_GET['bianji_id'];//81

	
			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			//echo $bianji_name;exit;
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('hetong'); 

		if($sql=='zdy'){
			$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="6";
 				$yw_cs['zd_yh']=2;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
				foreach($sql_json as $k=>$v){
					if($v['id']==$bianji_name){
						$name_rz=$v['name'];
					}
				}                                    //获取完了
				$map_rz['ht_id']=$bianji_id['ht_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field('ht_data')->find();
				$sql_json_rz=json_decode($kh_old_val['ht_data'],true);
				foreach($sql_json_rz as $krz=>$vrz){
					if($krz==$bianji_name){
						$b_rz=$vrz;
					}
				}
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['ht_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$id;//客户名称ID
				$rz_map['rz_bz']="把".$name_rz.'的'.$b_rz."改为".$bianji_val;
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_cz_type']=2;//2代表编辑
				$rz_map['rz_time']=time();
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'

			$sql_bianji=$kehus->where($bianji_id)->find();

			$sql_json=json_decode($sql_bianji['ht_data'],true);

			foreach($sql_json as $kt=>$vt){
				

				if($kt==$bianji_name){
					$sql_json[$kt]=$bianji_val;
					
				}
					 
			}
			$map['ht_id']= $bianji_id['ht_id']; 
			$save_data=$sql_json;

			$a_arr['ht_data']=json_encode($save_data,true);

			$save=$kehus->where($map)->save($a_arr);
			if($save){
				echo "ok";
			}else{
				echo "no";
			}
			


		}else{ 		

				$kehus=M('hetong'); 
				$map['ht_id']= $bianji_id['ht_id'];  
				$data[$bianji_name] = $_GET['bianji_val']; 

	     //只是为了获取 不能自定义   的中文名字放备注中

				$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"实际跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"前负责人",'ht_old_bm'=>"前所属部门",'ht_cj_date'=>"创建时间",'ht_gx_date'=>"更新于",'ht_yh'=>"所属公司",'ht_xiezuo'=>"协作人",'ht_yihui'=>"已回款金额",'ht_weihui'=>"未回款金额",'ht_yikai'=>"已开票金额",'ht_weikai'=>"未开票金额");
				foreach($array_jiansuo as $k=>$v){
					if($bianji_name==$k){
						$name_rz=$v;
					}
				}

				//结束
 				                               //获取完了
				$map_rz['ht_id']=$bianji_id['ht_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field($bianji_name)->find();
				
						$b_rz=$kh_old_val[$bianji_name];
				
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['ht_id'];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
		 		$rz_map['rz_object']=$id;//客户名称ID
				$rz_map['rz_bz']="把".$name_rz.'的'.$b_rz."改为".$bianji_val;
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_cz_type']=2;//2代表编辑
				$rz_map['rz_time']=time();
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'










				                     //显示客户所需字段data
				$kehu=$kehus->where($map)->save($data);
				if($kehu){
					echo "ok";
				}else{
					echo "no";
				}
		}

	 	
		}







	
		/**public function shaixuan(){

				$kehu=M('kh');                             //显示客户所需字段data
						$kehu=$kehu->select();
						//echo"<pre>";

						foreach($kehu as $k=>$v){
							$nachu[$k]=json_decode($v['kh_data'],true);
						}
					
						foreach($nachu as $k=>$v){
						 			foreach($v as $k1=>$v1){
						 				foreach ($ywcs_sql_json as $key=>$val){		 				
						 					if($k1==$val['id']){
						 						$v[$k1]=$val[$v1];						
						 					} 		 					
						 				}
						 			}
						 			$guanlianw[]=$v;
						 		}

					foreach($kehu as $k=>$val){
						$valav=array_merge($guanlianw[$k],$val);
							echo "<pre>";
							print_r($k);exit;
						$dantiao=$valav['kh_id'];//获取到id
						unset($valav['kh_id']); 
						unset($valav['kh_data']); 
						array_unshift($valav,$dantiao); //整理好的单条信息
						
							$ronghe[]=$valav;	 //多条融合	
					}
				//echo "<pre>";
				//print_r($ronghe);exit;

		}**/

		public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("quanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0'");
		foreach($userarr as $v)
		{
			$userkeyid[$v['user_id']]=$v;
		}
		$nowloginqx=$userkeyid[$nowloginid]['user_quanxian'];
		$nowloginbid=$userkeyid[$nowloginid]['user_zhu_bid'];

		$qxarr=$qxbase->query("select qx_data_qx from crm_quanxian where qx_company='$nowloginfid' and qx_id='$nowloginqx'");
		$dataqx=$qxarr[0]['qx_data_qx'];
		$bmbasearr=$bmbase->query("select * from crm_department where bm_company='$nowloginfid'");
		for($a=0;$a<10;$a++)
		{
			foreach($bmbasearr as $v)
			{
				if($v['bm_id']==$nowloginbid||in_array($v['bm_fid'],$bmid))
					$bmid[$v['bm_id']]=$v['bm_id'];
			}
		}
		if($dataqx=='1')
		{
			return "'".$nowloginid."'";
		}
		$foreachnum=0;
		foreach($userkeyid as $v)
		{
			if($v['user_zhuguan_id']=='0')
			{
				continue;
			}
			foreach($userkeyid as $kk=>$vv)
			{
				if($vv['user_zhuguan_id']==$nowloginid||in_array($vv['user_zhuguan_id'],$nowzgid))
				{
					$nowzgid[$vv['user_id']]=$vv['user_id'];
				}
			}
			if($foreachnum=='50')
			{
				break;
			}
			$foreachnum++;
		}
		$nowzgid[$nowloginid]=$nowloginid;
		foreach($nowzgid as $k=>$v)
		{
			if($dataqx=='2')
			{
				if($userkeyid[$v]['user_zhu_bid']!=$nowloginbid)
					unset($nowzgid[$k]);
			}
			if($dataqx=='3')
			{
				if(!in_array($userkeyid[$v]['user_zhu_bid'],$bmid))
					unset($nowzgid[$k]);
			}
		}
		return implode(",",$nowzgid);
	}


		public function hetongmingcheng(){
			$a_id=$_GET['id'];

            $p_id=$_GET['ht_id'];
          
			$kh_id['ht_id']=$_GET['ht_id'];
		
			$this->assign('kh_id',$kh_id['ht_id']);
            $ht_id=$_GET['ht_id'];
            
			//var_dump($kh_id);exit;
			$id=$_GET['id1'];
       
			$b_id=M('hetong');
			$c_id=$b_id->where($kh_id)->find();

			$this->assign('c_id',$c_id);
            $d_id=json_decode($c_id['ht_data'],true);
			$fuzeren=$_GET['fuzeren'];
			//var_dump($fuzeren);exit;
			$a_a=$_GET['zdy7'];
			$a_b=$_GET['zdy10'];
			$a_c=$_GET['zdy11'];
			$sql=M('file_hetong');
			$sql_select=$sql->select();

			$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 		$rz_map['rz_mode']=6;//这个是模块ID也是死的
			$rz_map['rz_object']=$ht_id;//客户名称ID
			
			$rz_sql=$rz->where(array($rz_map))->field('rz_bz,rz_time,rz_user')->order("rz_time desc")->select();//查询出日志记录、

			$rz_caozuo=$rz->where(array($rz_map))->field('rz_id,rz_type,rz_mode,rz_user,rz_object,rz_bz,rz_time')->order("rz_time desc")->select();//操作日志
          
//echo "<pre>";
//var_dump($rz_sql);exit;

			$rz_user=M('user');
			$user_sql=$rz_user->field('user_id,user_name')->select();
			$kh_map1['user_id']=$fuzeren;
			$kh_name=$rz_user->where($kh_map1)->field("user_name")->find();
           
			foreach($rz_sql as $k=>$v){//跟进循环的数据
				foreach($user_sql as $k1 =>$v1){
					if($v['rz_user']==$v1['user_id'])
					{
						$v['rz_user']= $v1['user_name'];
						$v['rz_time']=date("Y-m-d H:i:s",$v['rz_time']);
					}
				}
				$ko[]=$v;
			}
			foreach($rz_caozuo as $k=>$v){//跟进循环的数据
				foreach($user_sql as $k1 =>$v1){
					if($v['rz_user']==$v1['user_id'])
					{
						$v['rz_user']= $v1['user_name'];
						$v['rz_time']=date("Y-m-d H:i:s",$v['rz_time']);
						
					}
				}
				$koo[]=$v;//操作日志
			}
			//echo "<pre>";
			//print_r($koo);exit;
			$sql=M('file_hetong');
			$sql_select=$sql->select();

          
			//客户信息
		$kh_ziliao=M('hetong');
		$map_kh['ht_id']=$id;
		$sql_kh=$kh_ziliao->where($map_kh)->find();
		$sql_kh_json=json_decode($sql_kh['ht_data'],true);
		$valav=array_merge($sql_kh_json,$sql_kh);
		$kh_id=$valav['ht_id'];
		unset($valav['ht_id']); 
		unset($valav['ht_data']); 
		array_unshift($valav,$kh_id);//单挑查询完

          
        $ywcs=M('ywcs');                 //回款计划
 		$yw_cs['ywcs_yw']="6";
 		$yw_cs['ywcs_yh']=2;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 			
          foreach($ywcs_sql_json as $k6 =>$v6)
		{
			if($v6['id']=="hktype")
			{
				$dan_ywcs=$v6;
			}
		}
//var_dump($dan_ywcs);exit;
		foreach($dan_ywcs['qy'] as $k7 =>$v7){
			foreach($dan_ywcs as $k8=>$v8){
				if($k8=='id'){
					$xin_dan['id']=$v8;
				}
				if($v7==1&& $k7==$k8)
				{	

					$xin_dan[$k7]=$v8;
				} 

			}
		}

		foreach($ywcs_sql_json as $ka =>$va)
		{
			if($va['id']=="zdy12")
			{
				$dan_ywcs=$va;
			}
		}

		foreach($dan_ywcs['qy'] as $k7 =>$v7){
			foreach($dan_ywcs as $k8=>$v8){
				if($k8=='id'){
					$fukuan['id']=$v8;
				}
				if($v7==1&& $k7==$k8)
				{	

					$fukuan[$k7]=$v8;
				} 

			}
		}
      
foreach($ywcs_sql_json as $kb =>$vb)
		{
			if($vb['id']=="pjtype")
			{
				$dan_ywcs=$vb;
			}
		}

		foreach($dan_ywcs['qy'] as $k7 =>$v7){
			foreach($dan_ywcs as $k8=>$v8){
				if($k8=='id'){
					$piaoju['id']=$v8;
				}
				if($v7==1&& $k7==$k8)
				{	

					$piaoju[$k7]=$v8;
				} 

			}
		}

		foreach($valav as $k => $v){

			foreach($ywcs_sql_json as $k1=>$v1){
				//echo $k;
				//echo $k1;exit;
				if($k==$v1['id']){

					$valav[$k]=$v1[$v];
				}
			}
}//把关联信息替换

		$this->assign('dan_ywcs',$xin_dan);//弹窗 弹跳的跟进状态
		 $this->assign('fukuan',$fukuan);
		  $this->assign('piaoju',$piaoju);
		$this->assign('valav',$valav);//写跟进弹出框


               if($_POST) {
           		$add = array(
           			'jihua_date' =>$_POST['jihua_date'],
           			'jihua_jine'=>trim($_POST['jihua_jine']),
           			'jihua_type'=>trim($_POST['jihua_type']),
           			'jihua_beizhu'=>trim($_POST['jihua_beizhu']),
           			'jilu_date' =>$_POST['jilu_date'],
           			'jilu_jine'=>trim($_POST['jilu_jine']),
           			'jilu_type'=>trim($_POST['jilu_type']),
           			'jilu_beizhu'=>trim($_POST['jilu_beizhu']),
           		    'jilu_fukuan'=>trim($_POST['jilu_fukuan']),
           			'jilu_shoukuanren'=>trim($_POST['jilu_shoukuanren']),
                    'kaipiao_date' =>$_POST['kaipiao_date'],
                    'kaipiao_neirong'=>trim($_POST['kaipiao_neirong']),
                    'kaipiao_jine'=>trim($_POST['kaipiao_jine']),
                    'kaipiao_type'=>trim($_POST['kaipiao_type']),
                    'kaipiao_haoma'=>trim($_POST['kaipiao_haoma']),
                    'kaipiao_jingshouren'=>trim($_POST['kaipiao_jingshouren']),
                    'kaipiao_beizhu'=>trim($_POST['kaipiao_beizhu']),
                    'ht_id'=>trim($_POST['ht_id']),
                    'hui_name'=>trim($_POST['hui_name']),
                     'hui_id'=>trim($_POST['hui_id'])
           			);
        
	           		
	           		 $shi=M('ht_jihua');
	                 $sql=$shi->add($add);

	                
                    
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="新增了合同回款".$_POST['hui_name'];
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					
               } 
        
           $map['ht_id']=$p_id;
         
           $m=M('ht_jihua');

           $jihuahuikuan=$m->where($map)->field("hui_id,jihua_date,jihua_jine,jihua_type,jihua_beizhu,hui_name")->select();//回款计划
        
           $jihua_jine=$m->where($map)->field("jihua_jine")->select();

           $jihua_zjine = 0;
           foreach($jihua_jine as $key=>$value){//算出回款计划总金额
           $jihua_zjine += array_sum($value);

           }
           $this->assign('jihua_zjine',$jihua_zjine);

          
           	foreach($jihuahuikuan as $k=>$v){
			foreach($xin_dan as $k1=>$v1){
				//echo "<pre>";
					//var_dump($xin_dan);echo "<pre>";
					//var_dump($v['jihua_type']);
					//exit;
                 if($v['jihua_type']==$k1){
                  
              			 $v['jihua_type']= $v1;
			
				}
			}
			$lidong[]=$v;
		}

	
		//echo "<pre>";
		//var_dump($lidong);exit;
		

		   $s=M('ht_jihua');
           $huikuanjilu=$s->where($map)->field("hui_id,jilu_date,jilu_jine,jilu_type,jilu_beizhu,jilu_fukuan,jilu_shoukuanren,hui_name")->select();//回款记录

           $jilu_jine=$m->where($map)->field("jilu_jine")->select();
           $ht_yihui = 0;
           foreach($jilu_jine as $key=>$value){//算出已回款总金额
           $ht_yi += array_sum($value);

           }  
       
           $ae=M("hetong");
           $map['ht_id']=$p_id;
           $data['ht_yihui'] = $ht_yi ;

           $ht_yihui = $ae->where($map)->save($data);

           $this->assign('ht_yihui',$ht_yihui);

           //算出未回款总金额
           $a_weihui=$ae->where($map)->field("ht_data")->find();
         
           foreach($a_weihui as $k=>$v){
                 
             $b=json_decode($v);
             foreach($b as $k1=>$v1){
                 if($k1=='zdy3'){
                    $c=$v1;
                 }

             }
          
           }
           $b_weihui=$c-$ht_yi;
           $data1['ht_weihui'] = $b_weihui; 
           $ht_weihui = $ae->where($map)->save($data1);
        
           foreach($huikuanjilu as $k=>$v){
               
			foreach($xin_dan as $k1=>$v1){
				//echo "<pre>";
					//var_dump($v['jihua_type']);
					//exit;
                 if($v['jilu_fukuan']==$k1){
                  
              			 $v['jilu_fukuan']= $v1;
              			}
                  if($v['jilu_type']==$k1){
                  
              			 $v['jilu_type']= $v1;
              			}
			}
			$li_dong[]=$v;
		}

         $a=M('ht_jihua');
           $piaojujilu=$a->where($map)->field("hui_id,kaipiao_date,kaipiao_neirong,kaipiao_jine,kaipiao_type,kaipiao_haoma,kaipiao_jingshouren,kaipiao_beizhu,hui_name")->select();//开票记录

           $kaipiao_jine=$m->where($map)->field("kaipiao_jine")->select();
           $ht_yihui = 0;
           foreach($kaipiao_jine as $key=>$value){//算出已开票总金额
           $ht_yik += array_sum($value);

           }  
           $aw=M("hetong");
           $datb['ht_yikai'] = $ht_yik ;
       
           $ht_yikai = $aw->where($map)->save($datb);
           
           $this->assign('ht_yikai',$ht_yikai );

           //算出未回款总金额
           $a_weikai=$ae->where($map)->field("ht_data")->find();
         
           foreach($a_weihui as $k=>$v){
                 
             $b=json_decode($v);
             foreach($b as $k1=>$v1){
                 if($k1=='zdy3'){
                    $c=$v1;
                 }

             }
          
           }
           $b_weikai=$c-$ht_yik;
           $data2['ht_weikai'] = $b_weikai; 
           $ht_weikai = $ae->where($map)->save($data2);

           foreach($piaojujilu as $k=>$v){
               
			foreach($xin_dan as $k1=>$v1){
				//echo "<pre>";
					//var_dump($xin_dan);echo "<pre>";
					//var_dump($v['jihua_type']);
					//exit;
                  if($v['kaipiao_type']==$k1){
                  
              			 $v['kaipiao_type']= $v1;
              			}
			}
			$lid_ong[]=$v;
		}

	        $m_chanpin=M('chanpin');
  		    $spu['cp_yh']="2";//这里通过查询获得
            $guanpin=$m_chanpin->where($spu)->field('cp_id,cp_data')->select();
            foreach($guanpin as $k=>$v){
            $b=json_decode($v['cp_data'],true);
          
            $c['zdy0']=$b['zdy0'];
            $c['zdy2']=$b['zdy2'];
            	$a_arp[$v['cp_id']]=$c;
            	
            }
        
         
            $this->assign('a_arp',$a_arp);


           	$gc=M('gp');
           	$gc_chan=$gc->where($map)->select();

            $this->assign('gc_chan',$gc_chan);
           
            //var_dump($gc_lc);exit;
        

        
		//合同date外字段显示
	
            $this->assign('arr',$lidong);
            $this->assign('arrp',$li_dong);
            $this->assign('arrq',$lid_ong);  

		
			$this->assign('rz_caozuo',$koo);
			$this->assign('genjin',$ko);
			$this->assign('sql',$sql_select);
            $this->assign('fuzeren',$kh_name);
	        $this->assign('d_id',$d_id);
		
			$this->assign('a_id',$a_id);
			$this->assign('zdy7',$a_a);

			$this->assign('zdy11',$a_c);
			$this->display();
		}
		public function guanlianchanpin(){
         

			  //关联产品
            if($_POST) {

                $a=$_POST['gp_jianyi']*$_POST['gp_shuliang'];
               
           		$ada = array(
                'gp_name'=>trim($_POST['gp_name']),		
           	    'gp_shuliang'=>trim($_POST['gp_shuliang']),
           		'gp_jianyi'=>trim($_POST['gp_jianyi']),		        
           	    'gp_zongjia'=>$a,	
           		'gp_beizhu'=>trim($_POST['gp_beizhu']),           
           		'ht_id'=>trim($_POST['ht_id'])		     
                );
          
            	
               
           			 $shi=M('gp');
           			
	                 $sql=$shi->add($ada);
                    
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="新增了关联产品".$_POST['gp_name'];
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
           			
           	}
      
		}
		public function delete_chan(){

		$a=$_GET['gp_id'];

		$b=M('gp');
        
		$c['gp_id']=$a;

		       $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
                    $chanpin=$b->where($c)->field('gp_id,gp_name')->find();
                    //var_dump($huikuan);exit;	
					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$chanpin['gp_id'];//客户名称ID
                  
					$rz_map['rz_cz_type']=3;//1代表新建
					$rz_map['rz_bz']="删除了关联产品".$chanpin['gp_name'];
			
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'

		$d=$b->where($c)->delete();	
		if($d){
           $this->success('删除成功！',U('Hetong/hetongmingcheng/id/$v/fuzeren/$a_fuzeren/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c/'));
		}else{
           $this->success('删除失败！');
		}
		}

		public function delete_hui(){

		$a=$_GET['hui_id'];

		$b=M('ht_jihua');
        
		$c['hui_id']=$a;

		       $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
                    $huikuan=$b->where($c)->field('ht_id,hui_name')->find();
                    //var_dump($huikuan);exit;	
					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$huikuan['ht_id'];//客户名称ID
                  
					$rz_map['rz_cz_type']=3;//1代表新建
					$rz_map['rz_bz']="删除了合同回款".$huikuan['hui_name'];
			
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'

		$d=$b->where($c)->delete();	
		if($d){
           $this->success('删除成功！',U('Hetong/hetongmingcheng/'));
		}else{
           $this->success('删除失败！');
		}
		}

		
		public function delete(){

			$sql['id']=$_GET['id'];
			
			 $sql_delete=M('file_hetong');
       		
       		

       			//删除增加日志
       		 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            	$fujian=$sql_delete->where($sql)->field('name_id,fujian_name')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
		 		$rz_map['rz_object']=$fujian['name_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=3;//1代表新建
				$rz_map['rz_bz']="删除了附件:".$fujian['fujian_name'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'


				$sql_file_select=$sql_delete->where($sql)->delete();

       		if($sql_file_select){
				$sql=M('file_hetong');
				$sql_select=$sql->field('id,sc_data,fujian_name,big,beizhu')->select();

		foreach($sql_select as $k=>$v)
					{
						$id=$v['id'];
						
						
			$table.="<tr>";
					foreach($v as $k_a=>$v_a)
						
					{
						
						$table.="<td name='$k'>


						{$v_a}

								
						</td>";
					}
					$table.="<td>预览|<span class='del' id=$id>删除</span></td></tr>";
					
				}
					

					echo $table;

			}
		}
		public function upload(){


				$kh_id=$_GET['id'];
			    $upload = new \Think\Upload();// 实例化上传类
    			$upload->maxSize   =     3145728 ;// 设置附件上传大小
   				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','txt','pptx','xls');// 设置附件上传类型
    			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
   				$upload->autoSub = false;
   				$upload->hash = false;
    		// 上传文件 
   				 $info   =   $upload->upload();
    				if(!$info) {// 上传错误提示错误信息
        		$this->error($upload->getError());
    				}// 上传成功
    					    foreach($info as $file){
       						$save_name= 'Uploads/'.$file['savename'];//获取报存路径
       						$save_oldname=$file['name'];//原始吗，
       						$save_size=$file['size'] *'0.0009766';//大小
       						$sql=substr($save_size,0,3).'kb';//换算
 
    			 $data['name_id']=$kh_id;
    			 $data['sc_data']= date("Y-m-d h:i:s");
    			 $data['fujian_name']=$save_oldname;
    			 $data['lujing']=$save_name;
    			 $data['big']=$sql;
       			 $data['beizhu']=$_POST['wenbenyu'];
 


       			 		//x新增附件时记录日志
       			 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=6;
		 		$rz_map['rz_object']=$kh_id;//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了附件:".$data['fujian_name'];
				$rz_map['rz_time']=time();
				$rz_map['rz_user']=cookie('user_id');
				$rz_map['rz_ip']=$loginIp;//ip
				$rz_map['rz_place']=$loginDidianStr;//登录地点
				$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
				$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$rz_map['rz_yh']=$fid;
				$rz_sql=$rz->add($rz_map);//查'




       			 $sql_file=M('file_hetong');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	//$this->success("上传成功");
       			 	echo '<script>alert("上传成功");window.location="'.$_GET['root_dir'].'/index.php/Home/hetong/hetongmingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/ht_id/'.$_GET['ht_id'].'"</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	


}

		public function dantiaobj(){

		    $ywcs=M('ywcs');                 //回款计划
	 		$yw_cs['ywcs_yw']="6";
	 		$yw_cs['ywcs_yh']=2;
	 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
	 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);

		 foreach($ywcs_sql_json as $k6 =>$v6)
			{
				if($v6['id']=="hktype")
				{
					$dan_ywcs=$v6;
				}
			}
	//var_dump($dan_ywcs);exit;
			foreach($dan_ywcs['qy'] as $k7 =>$v7){
				foreach($dan_ywcs as $k8=>$v8){
					if($k8=='id'){
						$xin_dan['id']=$v8;
					}
					if($v7==1&& $k7==$k8)
					{	

						$xin_dan[$k7]=$v8;
					} 

				}
			}

			$id=$_GET['id'];
		
			$hui_base=M('ht_jihua');
			$map['hui_id']=$id;
			$sql=$hui_base->where($map)->find();
			if($sql){

                   
                    $table.="<div id = 'addform' style='margin-left:10px;'>";
				    $table.="<table  id='formtable'";
					$table.="<td><input type='hidden' name='hui_id' id='hui_id' required lay-verify='required' value='".$sql['hui_id']."' class='layui-input'/>
						    </td>";
					$table.="<tr >";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>计划回款名称</td>";
						$table.="<td><input type='text' name='hui_name' id='hui_name' required lay-verify='required' value='".$sql['hui_name']."' class='layui-input'/>
						</td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>计划回款日期</td>";
						$table.="<td><input type='text' name='jihua_date' id='jihua_date' required lay-verify='required' value='".$sql['jihua_date']."eee' class='text ui-widget-content ui-corner-all layui-input' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>计划回款金额</td>";
						$table.="<td><input type='text' name='jihua_jine' id='jihua_jine' required lay-verify='required' value='".$sql['jihua_jine']."' class='layui-input' /><input type='hidden' name='ht_id' id='ht_id' required lay-verify='required' value='".$sql['ht_id']."' class='layui-input' /></td>";
					$table.="</tr>";

						$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>回款类型</td>";
						$table.="<td>";
						$table.="<select name='".$sql['jihua_type']."' id='jihua_type' style='width:260px;height:26px;'>";
                        foreach($xin_dan as $k=>$vv)
						{
							//var_dump($vv);exit;
							if($k!='id'&&$k!='qy')
								$table.="<option value='$k'>".$vv."</option>";
						}

					    $table.="</select>";
						$table.="</td>";
					    $table.="</tr>";
			        
			        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>备注</td>";
						$table.="<td><input type='text' name='jihua_beizhu' id='jihua_beizhu' required lay-verify='required' value='".$sql['jihua_beizhu']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td align='right' colspan='3'>";
						$table.="<td><input type='button' class='layui-btn' value='确定' onclick='test_value()'/></td>";
					$table.="</tr>";

				$table.="</table>"; 
                $table.="</div>";
             
			echo $table;
			}else{
				echo "2";
			}
			
		}   

		public function bianjihuikuan1(){

              $b['hui_id']=$_POST['hui_id'];
             
			  $a['hui_name']=$_POST['hui_name'];
			  $a['jihua_date']=$_POST['jihua_date'];
			  $a['jihua_jine']=$_POST['jihua_jine'];
			  $a['ht_id']=$_POST['ht_id'];
			  $a['jihua_type']=$_POST['jihua_type'];
	          $a['jihua_beizhu']=$_POST['jihua_beizhu'];

                     
                     $shi=M('ht_jihua');
	                 $sql=$shi->where($b)->save($a);
            
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="修改了合同回款".$_POST['hui_name'];
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					if($sql){
                       echo '编辑成功';
					}else{
                       echo '编辑失败';
					}

              
}
		public function bianji2(){

		    $ywcs=M('ywcs');                 //回款计划
	 		$yw_cs['ywcs_yw']="6";
	 		$yw_cs['ywcs_yh']=2;
	 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
	 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);

		 foreach($ywcs_sql_json as $k6 =>$v6)
			{
				if($v6['id']=="hktype")
				{
					$dan_ywcs=$v6;
				}
			}
	//var_dump($dan_ywcs);exit;
			foreach($dan_ywcs['qy'] as $k7 =>$v7){
				foreach($dan_ywcs as $k8=>$v8){
					if($k8=='id'){
						$xin_dan['id']=$v8;
					}
					if($v7==1&& $k7==$k8)
					{	

						$xin_dan[$k7]=$v8;
					} 

				}
			}

		foreach($ywcs_sql_json as $ka =>$va)
		{
			if($va['id']=="zdy12")
			{
				$dan_ywcs=$va;
			}
		}

		foreach($dan_ywcs['qy'] as $k7 =>$v7){
			foreach($dan_ywcs as $k8=>$v8){
				if($k8=='id'){
					$fukuan['id']=$v8;
				}
				if($v7==1&& $k7==$k8)
				{	

					$fukuan[$k7]=$v8;
				} 

			}
		}

			$id=$_GET['id'];
		
			$hui_base=M('ht_jihua');
			$map['hui_id']=$id;
			$sql=$hui_base->where($map)->find();
			if($sql){

                   
                    $table.="<div id = 'addform' style='margin-left:10px;'>";
				    $table.="<table  id='formtable'";
				    $table.="<td><input type='hidden' name='hui_id' id='hui_id' required lay-verify='required' value='".$sql['hui_id']."' class='layui-input'/>
						    </td>";
					$table.="<tr >";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>回款记录名称</td>";
						$table.="<td><input type='text' name='hui_name' id='hui_name' required lay-verify='required' value='".$sql['hui_name']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>回款日期</td>";
						$table.="<td><input type='text' name='jilu_date' id='jilu_date' required lay-verify='required' value='".$sql['jilu_date']."' class='text ui-widget-content ui-corner-all layui-input' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>回款金额</td>";
						$table.="<td><input type='text' name='jilu_jine' id='jilu_jine' required lay-verify='required' value='".$sql['jilu_jine']."'class='layui-input' /><input type='hidden' name='ht_id' id='ht_id' required lay-verify='required'
						 value='".$sql['ht_id']."' class='layui-input' /></td>";
					$table.="</tr>";

                        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>付款方式</td>";
						$table.="<td>";
						$table.="<select name='".$sql['jilu_fukuan']."'  id='jilu_fukuan' style='width:260px;height:26px;'>";
                        foreach($fukuan as $k=>$vv)
						{
							//var_dump($vv);exit;
							if($k!='id'&&$k!='qy')
								$table.="<option value='$k'>".$vv."</option>";
						}

					    $table.="</select>";
						$table.="</td>";
					    $table.="</tr>";

						$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>回款类型</td>";
						$table.="<td>";
						$table.="<select name='".$sql['jilu_type']."' id='jilu_type'  style='width:260px;height:26px;'>";
                        foreach($xin_dan as $k=>$vv)
						{
							//var_dump($vv);exit;
							if($k!='id'&&$k!='qy')
								$table.="<option value='$k'>".$vv."</option>";
						}

					    $table.="</select>";
						$table.="</td>";
					    $table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>收款人</td>";
						$table.="<td><input type='text' name='jilu_shoukuanren' id='jilu_shoukuanren'  required lay-verify='required' value='".$sql['jilu_shoukuanren']."' class='layui-input'/></td>";
					$table.="</tr>";
			        
			        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>备注</td>";
						$table.="<td><input type='text' name='jilu_beizhu' id='jilu_beizhu' required lay-verify='required' value='".$sql['jilu_beizhu']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td align='right' colspan='3'>";
					$table.="<td><input type='button' class='layui-btn' value='确定' onclick='test_value2()'/></td>";
					$table.="</tr>";


				$table.="</table>"; 
                $table.="</div>";
             
			echo $table;
			}else{
				echo "2";
			}
			
		}

			public function bianjihuikuan2(){

              $b['hui_id']=$_POST['hui_id'];
             
			  $a['hui_name']=$_POST['hui_name'];
			  $a['jilu_date']=$_POST['jilu_date'];
			  $a['jilu_jine']=$_POST['jilu_jine'];
			  $a['ht_id']=$_POST['ht_id'];
			  $a['jilu_type']=$_POST['jilu_type'];
	          $a['jilu_beizhu']=$_POST['jilu_beizhu'];
	          $a['jilu_fukuan']=$_POST['jilu_fukuan'];
	          $a['jilu_shoukuanren']=$_POST['jilu_shoukuanren'];
	   
                     
                     $shi=M('ht_jihua');
	                 $sql=$shi->where($b)->save($a);
            
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="修改了合同回款".$_POST['hui_name'];
				
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					if($sql){
                       echo '编辑成功';
					}else{
                       echo '编辑失败';
					}

              
}

	
		public function bianji3(){

		    $ywcs=M('ywcs');                 //回款计划
	 		$yw_cs['ywcs_yw']="6";
	 		$yw_cs['ywcs_yh']=2;
	 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
	 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);

			foreach($ywcs_sql_json as $kb =>$vb)
				{
					if($vb['id']=="pjtype")
					{
						$dan_ywcs=$vb;
					}
				}

				foreach($dan_ywcs['qy'] as $k7 =>$v7){
					foreach($dan_ywcs as $k8=>$v8){
						if($k8=='id'){
							$piaoju['id']=$v8;
						}
						if($v7==1&& $k7==$k8)
						{	

							$piaoju[$k7]=$v8;
						} 

					}
				}


			$id=$_GET['id'];
		
			$hui_base=M('ht_jihua');
			$map['hui_id']=$id;
			$sql=$hui_base->where($map)->find();
			if($sql){

                    $table.="<div id = 'addform' style='margin-left:10px;'>";
				    $table.="<table  id='formtable'";
				    $table.="<td><input type='hidden' name='hui_id' id='hui_id' required lay-verify='required' value='".$sql['hui_id']."' class='layui-input'/>
						    </td>";
					$table.="<tr >";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>开票记录名称</td>";
						$table.="<td><input type='text' name='hui_name' id='hui_name' required lay-verify='required' value='".$sql['hui_name']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>开票日期</td>";
						$table.="<td><input type='text' name='kaipiao_date' id='kaipiao_date' required lay-verify='required' value='".$sql['kaipiao_date']."' class='text ui-widget-content ui-corner-all layui-input' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-M-d H:mm:ss'".'})"'."/></td>";
					$table.="</tr>";

				    $table.="<tr >";
				    $table.="<td class='redstar'>*</td>";
				    $table.="<td>开票内容</td>";
				    $table.="<td><input type='text' name='kaipiao_neirong' id='kaipiao_neirong' required lay-verify='required' value='".$sql['kaipiao_neirong']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>开票金额</td>";
						$table.="<td><input type='text' name='kaipiao_jine' id='kaipiao_jine' required lay-verify='required' value='".$sql['kaipiao_jine']."'class='layui-input' /><input type='hidden' name='ht_id' id='ht_id' required lay-verify='required'
						 value='".$sql['ht_id']."' class='layui-input' /></td>";
					$table.="</tr>";

						$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>票据类型</td>";
						$table.="<td>";
						$table.="<select name='".$sql['kaipiao_type']."' id='kaipiao_type' style='width:260px;height:26px;'>";
                        foreach($piaoju as $k=>$vv)
						{
						
							if($k!='id'&&$k!='qy')
								$table.="<option value='$k'>".$vv."</option>";
						}

					    $table.="</select>";
						$table.="</td>";
					    $table.="</tr>";

					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>发票号码</td>";
						$table.="<td><input type='text' name='kaipiao_haoma' id='kaipiao_haoma'  required lay-verify='required' value='".$sql['kaipiao_haoma']."' class='layui-input'/></td>";
					$table.="</tr>";
			        		
			
					$table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>经手人</td>";
						$table.="<td><input type='text' name='kaipiao_jingshouren' id='kaipiao_jingshouren'  required lay-verify='required' value='".$sql['kaipiao_jingshouren']."' class='layui-input'/></td>";
					$table.="</tr>";
			
			        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>备注</td>";
						$table.="<td><input type='text' name='kaipiao_beizhu' id='kaipiao_beizhu' required lay-verify='required' value='".$sql['kaipiao_beizhu']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td align='right' colspan='3'>";
					    $table.="<td><input type='button' class='layui-btn' value='确定' onclick='test_value3()'/></td>";
					$table.="</tr>";


				$table.="</table>"; 
                $table.="</div>";
             
			echo $table;
			}else{
				echo "2";
			}
			
		}   

		public function bianjihuikuan3(){

              $b['hui_id']=$_POST['hui_id'];
             
			  $a['hui_name']=$_POST['hui_name'];
			  $a['kaipiao_date']=$_POST['kaipiao_date'];
			  $a['kaipiao_jine']=$_POST['kaipiao_jine'];
			  $a['ht_id']=$_POST['ht_id'];
			  $a['kaipiao_type']=$_POST['kaipiao_type'];
	          $a['kaipiao_beizhu']=$_POST['kaipiao_beizhu'];
	          $a['kaipiao_haoma']=$_POST['kaipiao_haoma'];
	          $a['kaipiao_jingshouren']=$_POST['kaipiao_jingshouren'];
	          $a['kaipiao_neirong']=$_POST['kaipiao_neirong'];
	   
                     
                     $shi=M('ht_jihua');
	                 $sql=$shi->where($b)->save($a);
            
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="修改了合同回款".$_POST['hui_name'];
				
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					if($sql){
                       echo '编辑成功';
					}else{
                       echo '编辑失败';
					}

              
}
	public function guanlian(){

		    $m_chanpin=M('chanpin');
  		    $spu['cp_yh']="2";//这里通过查询获得
            $guanpin=$m_chanpin->where($spu)->field('cp_id,cp_data')->select();
            foreach($guanpin as $k=>$v){
            $b=json_decode($v['cp_data'],true);
          
            $c['zdy0']=$b['zdy0'];
            $c['zdy2']=$b['zdy2'];
            	$a_arp[$v['cp_id']]=$c;
            	
            }
        
	    
			$id=$_GET['id'];
	
			$guan_l=M('gp');
			$map['gp_id']=$id;

			$sql=$guan_l->where($map)->find();
		
           if($sql){

                 
                    $table.="<div id = 'addform' style='margin-left:10px;'>";
				    $table.="<table  id='formtable'";
					$table.="<td><input type='hidden' name='gp_id' id='gp_id' required lay-verify='required' value='".$sql['gp_id']."' class='layui-input'/>
						    </td>";
					$table.="<tr >";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>产品名称价格</td>";
						$table.="<td>";
						$table.="<select name='".$sql['gp_name']."' id='gp_name' style='width:260px;height:26px;'>";
                        foreach($a_arp as $k=>$v)
						{
							
				                if($k!=$v['cp_id'])
								$table.="<option value='$k'>".$v['zdy0']."</option>";
						}

					    $table.="</select>";
						$table.="</td>";
					    $table.="</tr>";

				
				        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>建议价格</td>";
						$table.="<td><input type='text' name='gp_jianyi' id='gp_jianyi' required lay-verify='required' value='".$sql['gp_jianyi']."' class='layui-input'/></td>";
					    $table.="</tr>";


					    $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>产品数量</td>";
						$table.="<td><input type='text' name='gp_shuliang' id='gp_shuliang' required lay-verify='required' value='".$sql['gp_shuliang']."' class='layui-input'/></td>";
					$table.="</tr>";
			    
			        $table.="<tr>";
						$table.="<td class='redstar'>*</td>";
						$table.="<td>备注</td>";
						$table.="<td><input type='text' name='gp_beizhu' id='gp_beizhu' required lay-verify='required' value='".$sql['gp_beizhu']."' class='layui-input'/></td>";
					$table.="</tr>";

					$table.="<tr>";
						$table.="<td align='right' colspan='3'>";
						$table.="<td><input type='button' class='layui-btn' value='确定' onclick='test_value5()'/></td>";
					$table.="</tr>";

				$table.="</table>"; 
                $table.="</div>";
             
			echo $table;
			}else{
				echo "2";
			}
			
		} 

		public function guanlianchanpin1(){

              $b['gp_id']=$_POST['gp_id'];
             
			  $a['gp_name']=$_POST['gp_name'];
			  $a['gp_jianyi']=$_POST['gp_jianyi'];
			  $a['gp_shuliang']=$_POST['gp_shuliang'];
			  $a['ht_id']=$_POST['ht_id'];
			  $a['gp_beizhu']=$_POST['gp_beizhu'];
	        

                     
                     $shi=M('gp');
	                 $sql=$shi->where($b)->save($a);
            
                    $loginIp=$_SERVER['REMOTE_ADDR'];//
                    $sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
					$addressArr=getCity($nowip);//登录地点
					$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

					$rz=M('rz');
					$rz_map['rz_type']=1;//这个1是操作日志类型  死的
					$rz_map['rz_mode']=6;
					$rz_map['rz_object']=$_POST['ht_id'];//客户名称ID

					$rz_map['rz_cz_type']=1;//1代表新建
					$rz_map['rz_bz']="修改了关联产品".$_POST['gp_name'];
					$rz_map['rz_time']=time();
					$rz_map['rz_user']=cookie('user_id');
					$rz_map['rz_ip']=$loginIp;//ip
					$rz_map['rz_place']=$loginDidianStr;//登录地点
					$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//
					$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
					$rz_map['rz_yh']=$fid;
					$rz_sql=$rz->add($rz_map);//查'
					if($sql){
                       echo '编辑成功';
					}else{
                       echo '编辑失败';
					}

              
}  

		public function del_kehu(){
			$mapid=$_GET['id'];
			$kehudel_base=M('hetong');
			$sql_del=$kehudel_base->query("delete from `crm_hetong` where `ht_id` in ($mapid)");
										
			if($sql_del){
				echo "1";
			}else{
				echo "2";
			}
		}
		public function pl_bianji(){
			$id=$_GET['id'];
			$id=substr($id,0,strlen($id)-1); //id
			//$id="168,169";
			$ziduan=$_GET['ziduan'];//zdy123445
		
			$content=$_GET['content'];//修改内容
		//	echo $id;
			$kehu_base=M('hetong');
			$sql=$kehu_base->query("select * from `crm_hetong` where `ht_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['ht_data'],true);
			
				foreach($json as $k1=>$v2)
				{
					if($ziduan == $k1 )
					{
					$json[$k1]=$content;
					$da=$json;//data替换完成
					$map['ht_id']=$v['ht_id'];//条件
					$data['ht_data']=json_encode($da,true);//修改内容
					$save=$kehu_base->where($map)->save($data);
						if($save)
						{
								$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
				           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
				            	$addressArr=getCity($nowip);//登录地点
				            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
						   	
						   		$rz=M('rz');
						 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
						 		$rz_map['rz_mode']=6;
						 		$rz_map['rz_object']=$v['ht_id'];//客户名称ID
								$rz_map['rz_bz']="把".$_GET['xgzd2']."的值改为".$_GET['content2'];
								$rz_map['rz_user']=cookie('user_id');
								$rz_map['rz_cz_type']=2;//2代表编辑
								$rz_map['rz_time']=time();
								$rz_map['rz_ip']=$loginIp;//ip
								$rz_map['rz_place']=$loginDidianStr;//登录地点
								$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
								$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
								$rz_map['rz_yh']=$fid;
								$rz_sql=$rz->add($rz_map);//查'			//删除增加日志
			       		 
						}

					}
				}
			
				
			}

	
		}
		public function pl_zhuanyi(){
			$fuzeren=$_GET['id'];
			$rz_fuzeren=$_GET['ziduan'];
			$ziduan="fuzeren";
			$kh_id=$_GET['ht_id'];
			$id=substr($kh_id,0,strlen($kh_id)-1); //id
			$kehu_base=M('hetong');
			$sql=$kehu_base->query("select * from `crm_hetong` where `kh_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['ht_data'],true);
				$data['ht_old_fz']=$json['fuzeren'];
				foreach($json as $k1=>$v2)
					{
						if($ziduan == $k1 )
						{
							$json[$k1]=$fuzeren;
							$da=$json;//data替换完成
							$map['ht_id']=$v['ht_id'];//条件

							$data['ht_data']=json_encode($da,true);//修改内容
							
							
							//$sql_sel=$kehu_base->where($map)->save($old);
							$save=$kehu_base->where($map)->save($data);
							
							if($save)
							{
								$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
				           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
				            	$addressArr=getCity($nowip);//登录地点
				            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
						   	
						   		$rz=M('rz');
						 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
						 		$rz_map['rz_mode']=6;
						 		$rz_map['rz_object']=$v['ht_id'];//客户名称ID
								$rz_map['rz_bz']="把客户的转移给了".$rz_fuzeren;
								$rz_map['rz_user']=cookie('user_id');
								$rz_map['rz_cz_type']=2;//2代表编辑
								$rz_map['rz_time']=time();
								$rz_map['rz_ip']=$loginIp;//ip
								$rz_map['rz_place']=$loginDidianStr;//登录地点
								$rz_map['rz_sb']=$sysbroinfo['sys'].'/'.$sysbroinfo['bro'];//ip
								$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
								$rz_map['rz_yh']=$fid;
								$rz_sql=$rz->add($rz_map);//查'			//删除增加日志
							}
						}
					}
			}
		}

		//导入模板下载
	public function xiazaimuban()
	{

  		$a=M('yewuziduan');                    
  		$map['zd_yewu']="6";
  		$map['zd_yh']="2";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('hetong');
		$kh_map['ht_yh']="19950228";                            
		$kehu2=$kehu->where($kh_map)->find();
		$kh_data_json=json_decode($kehu2['ht_data'],true);

		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		$a_arr=$new_qy;   //模板标题
		foreach($a_arr as $k=>$v)
		{
			if($v['bt']=="1")
			{
				if($v['type']=="3")
				{
					$array[]=$v["name"]."(必填请对照参数填写)";
				}else{
					$array[]=$v["name"]."(必填)";
				}
				
			}else{
				$array[]=$v["name"];     //标题
			}
			foreach($kh_data_json as $k3=>$v3)
			{
				if($v['id']==$k3)
					$arr_new[]=$v3;   //值
			}
			
		}

		//r_dump($array);exit;
		$name="客户数据导入模板";
		//$name=iconv("utf-8","gbk//IGNORE",$name);
		
		$head=$array;

		//连接标题
		$r = implode(',',$head);
		$r .="\n";
		//$r = iconv("utf-8","gbk//IGNORE",$r);
		$body[0]=$arr_new;
		foreach($body as $arr)
		{
			$line=implode(',',$arr);
			$r.=$line;
			//$r .= iconv("utf-8","gbk//IGNORE",$line);
			$r.="\n";
		}
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $r;
		die;
	}
	public function xiazaimubancanshu()
	{
	    $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="6";
 		$yw_cs['ywcs_yh']=2;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 	
 		$a=M('yewuziduan');                    
  		$map['zd_yewu']="6";
  		$map['zd_yh']="2";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);

		

//echo "<pre>";
//	var_dump($ywcs_sql_json);exit;

		foreach($ywcs_sql_json as $kzd => $vzd)
		{
			
			foreach($a_arr as $kzd1=>$vzd1)
			{
				//var_dump($vzd1);exit;
				if($vzd1['id']==$vzd['id'])
				{
					
					foreach($vzd as $k2=>$v2)
					{
						//var_dump($vzd);exit;
						if($k2=="id")
						{
							$vzd3['id']=$vzd1['name'];
						}elseif($k2=="qy"){
							
						}else{
							$vzd3[$k2]=$k2."=>".$v2;
						}
						
						
						
					}

					$name2[]=$vzd3;
				}	
				
			}
		}
	//	echo "<pre>";
	//	var_dump($name2);exit;
	
	//	echo "<pre>";
 		//var_dump($ywcs_sql_json);exit;
		$a_arr=$new_qy;   //模板标题
		
		//r_dump($array);exit;
		$name="客户参数导入模板";
		//$name=iconv("utf-8","gbk//IGNORE",$name);
		
		$head="";
		//连接标题
		$r = implode(',',$head);
		$r .="\n";
		//$r = iconv("utf-8","gbk//IGNORE",$r);
		$body=$name2;
		foreach($body as $arr)
		{
			$line=implode(',',$arr);
			$r.=$line;
			//$r .= iconv("utf-8","gbk//IGNORE",$line);
			$r.="\n";
		}
		$name = $name.'.csv';
		header('Content-type: application/csv');
		header("Content-Disposition: attachment; filename=\"$name\""); 
		echo $r;
		die;
	}
	 
		public function wjsc_dr()
	{
		//文件保存
        if(count($_FILES['csv_up'])<1)
        {
            echo '{"res":0}';
            die();
        }
		$getFileArr=$_FILES['csv_up'];
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
		if(strtolower($oldnamehz)!='csv')
		{
			echo '{"res":2}';
			die();
		}
        $newname=time().$getFileArr['name'];
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/chanpinfile/cpfile/linshi/'.$newname);
        if(!file_exists('./Public/chanpinfile/cpfile/linshi/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
       

        echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$getFileArr['name'].'"}';
	}
	//删除旧附件
	public function del_old_file()
	{
		$oldname=addslashes($_GET['oldname']);
		if($oldname=='')die;
		unlink('./Public/chanpinfile/cpfile/'.$oldname);
	}
	//开始导入产品信息
	public function daoru_chanpin()
	{

		$a=M('yewuziduan');                    
  		$map['zd_yewu']="6";
  		$map['zd_yh']="2";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('hetong');
	    $kh_map['ht_yh']="19950228";                            
		$kehu2=$kehu->where($kh_map)->find();
		$kh_data_json=json_decode($kehu2['ht_data'],true);

		foreach($a_arr as $k2=>$v2){//
			if($v2['qy']=="1"){
				//$key[]=$v2['id'];
				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		$a_arr=$new_qy;   //模板标题
	
		foreach($a_arr as $k=>$v)
		{
			if($v['bt']=="1")
			{	$key[]=$v['id'];
				if($v['type']=="3")
				{
					$array[]=$v["name"]."(必填请对照参数填写)";
				}else{
					$array[]=$v["name"]."(必填)";
				}

				
			}else{
				$key[]=$v['id'];
				$array[]=$v["name"];     //标题
			}

			foreach($kh_data_json as $k3=>$v3)
			{
				if($v['id']==$k3)
					$arr_new[]=$v3;   //值
			}
			
		}
//var_dump($key);exit;
	$num=count($array);


		$csvfilename=addslashes($_GET['csvfilename']);
		if($csvfilename=='')
		{
			echo '2';
			die;
		}
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$file_path="./Public/chanpinfile/cpfile/linshi/".$csvfilename;
		$bs=fopen($file_path,"r");
		$str = fread($bs,filesize($file_path));
		$str=iconv("gbk","utf-8//IGNORE",$str);
		$filearr=explode("\n",$str);
		$first='0';
		$insertstr='';
		$filerowsnum=0;
		$nowdatetime=date("Y-m-d H:i:s",time());
		foreach($filearr as $v)
		{
			if($first=='0')
			{
				$first='1';
				continue;
			}
			if($v=='')	continue;
			$varr='';
			$varr=explode(',',$v);
	
			if(count($varr)!=$num){
				echo "8";//提示模板不对
				die;
			}	
			if($varr[0]==''||$varr[1]==''||$varr[2]==''||$varr[3]=='') continue;
			
			//构造数据表数组
			
			foreach($key as $k=>$v)
			{	
				$basearr[$filerowsnum][$v]=$varr[$k];
				
				//echo $varr[$k]."......";
			}
			$basearr[$filerowsnum]['fuzeren']="";
				$basearr[$filerowsnum]['department']="";
			$filerowsnum++;
	
		}

		if(count($basearr)<1)
		{
			echo '2';die;
		}
		foreach($basearr as $k=>$v)
		{	

			$data['ht_data']=json_encode($v);
			//echo $data['kh_data'];
			
			$kh_add=M("hetong");
			$sql=$kh_add->add($data);
			unset($data);
		
		}
		if($sql){
			echo "1";
			
		}
		
		//echo $this->insertrizhi("导入了".count($basearr)."条产品数据");
	}
	
	public function shaixuan(){

		$id=$_GET['id'];
		$new_id=substr($id,0,strlen($id)-1); 
	//	$new_id="zdy1,1|zdy9,2|zdy10,1|kehujibie,3";
		$new_arr=explode("|",$new_id);
		foreach($new_arr as $k=>$v)
		{
			$new_arr2=explode(",",$v);
			$new_arr3[]=$new_arr2;
		}
		//$new_arr_daoxu=array_reverse($new_arr3);
		foreach($new_arr3 as $kget=>$vget)
		{
			$get[$vget[0]]=$vget;         //  zdy0   dom 下标4   求完每个标题的唯一了
		}
	
foreach($get as $kqb=>$vqb)
{
	if($vqb['1']!='1')
	{
		$get1[$vqb['0']]=$vqb;
	}
}

$get=$get1;

	foreach($get as $kkh =>$vkh)
	{
		if($kkh=="kehujibie")
		{
			$kehu_jibie=$vkh['1'];
		}
	}
	//echo "<pre>";
//ar_dump($kehu_jibie);exit;		//客户信息查询
		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="6";
  		$map['zd_yh']="2";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();         //业务参数查询
		$a_arr=json_decode($sql['zd_data'],true);

		$kehu=M('hetong'); 
		             //显示客户所需字段data
		$kehu=$kehu->select();                                   //客户内容查询

		//查询所有用户
		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'ht_spzt'=>"审批状态",'ht_new_gj'=>"最新跟进记录",'ht_sj_gj_date'=>"实际跟进时间",'ht_cj'=>"创建人",'ht_old_fz'=>"前负责人",'ht_old_bm'=>"前所属部门",'ht_cj_date'=>"创建时间",'ht_gx_date'=>"更新于",'ht_yh'=>"所属公司",'ht_xiezuo'=>"协作人",'ht_yihui'=>"已回款金额",'ht_weihui'=>"未回款金额",'ht_yikai'=>"已开票金额",'ht_weikai'=>"未开票金额");
				foreach($array_jiansuo as $k=>$v)
				{
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array[]=$new_str1;
				}
				$kh_biaoti1=array_merge_recursive($a_arr,$new_array);//客户标题名字

		$ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="6";
 		$yw_cs['ywcs_yh']=2;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 		$number="1";
 		foreach($ywcs_sql_json as $k=>$v)
		{
			foreach($v as $k1=>$v2)
			{	
				if($k1=="id")
				{
					$new_ywcs[$number]=$v2;
				}else{
					$new_ywcs[$number]=$k1;
				}
				
				$number++;
			}
			$number="1";
			$new_ywcs2[]=$new_ywcs;  //实现  dom 下标 对应 canshu***
			unset($new_ywcs);
		}

		foreach($get as $knum=>$vnum)  //匹配  筛选
		{	
				foreach($new_ywcs2 as $knew_cs=>$vnew_cs)
				{	

					if($knum==$vnew_cs['1'])
					{
					
						$vnum['1']=$vnew_cs[$vnum['1']];
						//var_dump($vnum);exit;
						$end[]=$vnum;          
					}
					

				}

		}
		foreach($end as $kr=>$vr)
		{
			$save[$vr['0']]=$vr['1']; //得到结果 下步找客户数据匹配
		}
		
		//echo "<pre>";
		//var_dump($save);exit;
	foreach($ywcs_sql_json as $kywcs=>$vywcs)
			{
				$ywcs_new[$vywcs['id']]=$vywcs;
			}


		foreach($kehu as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				
				if($kk!='ht_data')
					$ronghe[$k][$kk]=$vv;
				else
				{
					$rowjson=json_decode($vv,true);
					foreach($rowjson as $kkk=>$vvv)
					{	
						//if($kkk=='zdy1' || $kkk=='zdy9' ||$kkk=='zdy10' ||$kkk=='zdy11' ||$kkk=='zdy12')
						//{
							//echo $kkk;
						/**	foreach($ywcs_new as $kcs=>$vcs)
							{
								if($kkk==$kcs)
								{
									$ronghe[$k][$kkk]=$vcs[$vvv];
								}
									
							}
						}else{**/
							$ronghe[$k][$kkk]=$vvv;

						//}
						
	

					}
				}
			}
		}//融合整条信息
//echo "<pre>";
   			//var_dump($ronghe);
		if($kehu_jibie=="2")
		{
   			foreach($ronghe as $kfw=>$vfw)
   			{
   				if($vfw['fuzeren']==cookie('user_id'))
   				{
   					$rh_fw=$vfw;
   					$rh_fw1[]=$rh_fw;
   					$ronghe5=$rh_fw1;

   				}
   			}
   			
   			
		}
		elseif($kehu_jibie=="3")
		{
			foreach($ronghe as $kfw=>$vfw)
   			{	

   				if($vfw['fuzeren']!=cookie('user_id'))
   				{
   					$rh_fw=$vfw;
   					$rh_fw1[]=$rh_fw;
   					$ronghe5=$rh_fw1;

   				}
   			}
		}
		else{
			$ronghe5=$ronghe;	
		}  
		
		$ronghe=$ronghe5;
//echo "<pre>";
   			//var_dump($ronghe);exit;
		foreach($ronghe as $ksx=>$vsx)
		{
			//echo "<pre>";
		//	var_dump($ronghe);exit;
			foreach($vsx as $ksx1=>$vsx1)
			{
			//echo $ksx1;
		//echo "<pre>";
				//var_dump($save);exit;
					if($save[$ksx1]!="")
					{
						if( $vsx[$ksx1]==$save[$ksx1])
						{
							$arary_new=$vsx;
						}else{
							continue 2;
						}

					}else{
						$arary_new=$vsx;
					}
			}
			
			
			$rongh[$ksx]=$arary_new;	
		}

		 $fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
	 		$xiaji= $this->get_xiashu_id();//  查询下级ID
			$new_xiaji=$xiaji; 
			$new_array=explode(',',$new_xiaji);
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren=$v;
						$fzr_only[]=$new_fuzeren;
					}
						
				}
			}
		foreach($rongh as $krh=>$vrh)
		{
			foreach ($vrh as $k1=>$v1)
			{
				if($k1=='zdy7' || $k1=='zdy10' || $k1=='zdy11')
					{
						//echo $kkk;
					foreach($ywcs_new as $kcs=>$vcs)
						{
							if($k1==$kcs)
							{
								$rongh[$krh][$k1]=$vcs[$v1];
							}
								
						}
					}
			}
		}
$ronghe=$rongh;


		foreach($ywcs_sql_json as $k=>$v)
		{

			$ywcs_sql_json[$v['id']]=$v;
			unset($ywcs_sql_json[$k]);
		}
		
					foreach($ronghe as $r_k=>$r_v)//$r_v融合完的第一条数据
					{	

						$a_fuzeren=$r_v['fuzeren'];//查出第一条融合完的数据的第一条
						$v=$r_v['zdy0'];//查出我合同名称
						
			
						$id=$r_v['ht_id'];//查出我第一条融合完信息的ID
						
						$table.="<tr id='tr".$r_v['ht_id']."'>";
								$xs123=$r_v['ht_id'];//第一条融合完信息的ID
								
								$table.="
										<td >
											<input type='checkbox' class='chbox_duoxuan' id='$xs123'>$xs123
										</td>";
								foreach($kh_biaoti1 as $k_biaoti=>$v_biaoti)//$kh_biaoti1为合同与后台数据联系起来的地方
                                //$v_biaoti为zdy0合同标题
								{	
									
									if($r_v[$v_biaoti['id']]!="")	
									{
											$a_fuzeren=$r_v['fuzeren'];//负责人
											 $a_a=$r_v['zdy7'];
						                     $a_b=$r_v['zdy10'];
						                     $a_c=$r_v['zdy11'];
											
											if($v_biaoti['id']=='zdy0')
												$xs123="<a href='hetongmingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/ht_id/$id/zdy7/$a_a/zdy10/$a_b/zdy11/$a_c'>".$r_v[$v_biaoti['id']]."
												</a>";
											
											elseif($v_biaoti['id']=="fuzeren")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['fuzeren'])
															$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";

													}
													
												}
											elseif($v_biaoti['id']=="ht_old_fz")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['ht_old_fz'])
															$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";

													}
													
												}
											else
												$xs123="
												<span id='wys{$id}'>".$r_v[$v_biaoti['id']]."</span>
												<i class='fa fa-pencil' aria-hidden='true' >	</i>
												<input type='text'  name='".$v_biaoti['id']."'  id='{$id}' class='bianji bianji_hide' value='".$r_v[$v_biaoti['id']]."' onblur=''  >";

									
												$table.="<td name='$k'>
													$xs123
												</td>";
									}else{

												$xs123="
												<span id='wys{$id}'>未填写</span>
												<i class='fa fa-pencil' aria-hidden='true' >	</i>
												<input type='text' name='".$v_biaoti['id']."' id='{$id}' class='bianji bianji_hide' value='' onblur=''  >";
												$table.="<td name='$k'>
													$xs123
												</td>";

									}
									
									
								}
						//	}
						//}
						$table.="</tr>";	//echo $table;exit;
						
		}

		echo $table;
	

	}

}