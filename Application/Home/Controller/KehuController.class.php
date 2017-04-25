<?php
namespace Home\Controller;
use Think\Controller;


class KehuController extends Controller {

    public function kehu(){
   // echo "<pre>";
    	//print_r(cookie());
    	//die;

  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		
		$kehu=M('kh');                             //显示客户所需字段data
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
		//echo "<pre>";
		//var_dump($pl_bj_arr);exit;
$this->assign("pl_bj",$pl_bj_arr);
		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_array[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($a_arr,$new_array);//客户标题名字

		$conf=M('config');
		$conf_sql=$conf->field("config_kh_data")->find();
		$conf_sql_json=json_decode($conf_sql['config_kh_data'],true);
        $ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=1;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 		foreach($ywcs_sql_json as $kywcs=>$vywcs)
			{
				$ywcs_new[$vywcs['id']]=$vywcs;
			}

		foreach($kehu as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk!='kh_data')
					$ronghe[$k][$kk]=$vv;
				else
				{
					$rowjson=json_decode($vv,true);
					foreach($rowjson as $kkk=>$vvv)
					{	
						if($kkk=='zdy1' || $kkk=='zdy9' ||$kkk=='zdy10' ||$kkk=='zdy11' ||$kkk=='zdy12')
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
	   			}	
	   		}
	 } 
		foreach($ywcs_sql_json as $k=>$v)
		{

			$ywcs_sql_json[$v['id']]=$v;
			unset($ywcs_sql_json[$k]);
		}

		foreach ($pl_bj_arr as $k=>$v){ //多条编辑 弹出框对应数据
			//echo "<pre>";
	//	var_dump($ywcs_sql_json);exit;
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
		$new_html.="<div class='sxzddiv' id='kehujibie'>";
					$new_html.=" <div class='sx_title' >客户范围：</div>";
							$new_html.=" <span class='sx_yes'>全部客户</span>";
							$new_html.="<span class='sx_no'>我的客户</span>";
							$new_html.="<span class='sx_no'>我下属的客户</span>";					
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
		echo "<pre>";
		var_dump($sql_peizhi);exit;
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
		//	echo "<pre>";
		//	var_dump($xiaji);exit;
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
		
					foreach($ronghe as $r_k=>$r_v)
					{	

						$a_fuzeren=$r_v['fuzeren'];
						$v=$r_v['zdy0'];
						//echo"<pre>";
						//var_dump($ronghe);
			
						$id=$r_v['kh_id'];
						$table.="<tr id='tr".$r_v['kh_id']."'>";
								$xs123=$r_v['kh_id'];
								$table.="
										<td >
											<input type='checkbox' class='chbox_duoxuan' id='$xs123'>$xs123
										</td>";
								foreach($kh_biaoti1 as $k_biaoti=>$v_biaoti)

								{	
									
									if($r_v[$v_biaoti['id']]!="")	
									{
											$a_fuzeren=$r_v['fuzeren'];
											if($v_biaoti['id']=='zdy0')
												$xs123="<a href='kehumingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/kh_id/$id'>".$r_v[$v_biaoti['id']]."
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
											elseif($v_biaoti['id']=="kh_old_fz")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['kh_old_fz'])
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
		$this->assign('kehu',$a_arr);//新增客户标题
        $this->display();
    }


		public function add(){
		    $data['kh_data']=$_GET['id'];
		    	$a_arr=json_decode( $data['kh_data'],true);
	
			$shi=M('kh');
			$sql=$shi->add($data);

				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$shi->where($data)->field('kh_id')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$id['kh_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
				$rz_map['rz_bz']="新增了客户".$a_arr['zdy0'];
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

			$bianji_id['kh_id']= $_GET['bianji_id'];//81


			$bianji_name= $_GET['bianji_name'];//zdy2  fuzeren
			//echo $bianji_name;exit;
			$bianji_val= $_GET['bianji_val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('kh'); 

		if($sql=='zdy'){
			$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="2";
 				$yw_cs['zd_yh']=1;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
				foreach($sql_json as $k=>$v){
					if($v['id']==$bianji_name){
						$name_rz=$v['name'];
					}
				}                                    //获取完了
				$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field('kh_data')->find();
				$sql_json_rz=json_decode($kh_old_val['kh_data'],true);
				foreach($sql_json_rz as $krz=>$vrz){
					if($krz==$bianji_name){
						$b_rz=$vrz;
					}
				}
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['kh_id'];	
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

			$sql_json=json_decode($sql_bianji['kh_data'],true);

			foreach($sql_json as $kt=>$vt){
				

				if($kt==$bianji_name){
					$sql_json[$kt]=$bianji_val;
					
				}
					 
			}
			$map['kh_id']= $bianji_id['kh_id']; 
			$save_data=$sql_json;

			$a_arr['kh_data']=json_encode($save_data,true);

			$save=$kehus->where($map)->save($a_arr);
			if($save){
				echo "ok";
			}else{
				echo "no";
			}
			


		}else{ 		

				$kehus=M('kh'); 
				$map['kh_id']= $bianji_id['kh_id'];  
				$data[$bianji_name] = $_GET['bianji_val']; 

	     //只是为了获取 不能自定义   的中文名字放备注中

				$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");
				foreach($array_jiansuo as $k=>$v){
					if($bianji_name==$k){
						$name_rz=$v;
					}
				}

				//结束
 				                               //获取完了
				$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
				$kh_old_val=$kehus->where(array($map_rz))->field($bianji_name)->find();
				
						$b_rz=$kh_old_val[$bianji_name];
				
				$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];

		   		$id=$bianji_id['kh_id'];	
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


		public function kehumingcheng(){
			$a_id=$_GET['id'];//客户名称
			$kh_id=$_GET['kh_id'];//客户ID=$_GET['kh_id'];//客户ID
			$fuzeren=$_GET['fuzeren'];
			$id=$_GET['id1'];//客户名称ID
			$this->assign('kh_id',$kh_id);//这里是添加附件的ID渲染到模板
			$kh=M('kh');
			$kh_map['kh_id']=$kh_id;
			$sql_kh=$kh->where($kh_map)->field('kh_data')->find();
			$sql_json=json_decode($sql_kh['kh_data'],true);
			$kh_type=$sql_json['zdy1'];//客户类型canshu1
			$kh_phone=$sql_json['zdy2'];//客户电话

			
			$ywcs=M('ywcs');                 //获取ywcs表中的 数据
	 		$yw_cs['ywcs_yw']="2";
	 		$yw_cs['ywcs_yh']=1;
	 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
	 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
	 		foreach($ywcs_sql_json as $k=>$v){
	 			if($v['id']=='zdy1'){
	 				$kh_type2=$v[$kh_type];
	 			}
	 		}

	 		$this->assign('kh_phone',$kh_phone);//客户电话
	 		$this->assign('kh_type2',$kh_type2);//客户类型
			
	 		//写跟进查询
	 		$rz=M('rz');
	 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
	 		$rz_map['rz_mode']=2;//这个是模块ID也是死的
			$rz_map['rz_object']=$kh_id;//客户名称ID
			$rz_sql=$rz->where(array($rz_map))->field('rz_bz,rz_time,rz_user')->order("rz_time desc")->select();//查询出日志记录、
//echo "<pre>";
//var_dump($rz_sql);exit;

			$rz_caozuo=$rz->where(array($rz_map))->field('rz_id,rz_type,rz_mode,rz_user,rz_object,rz_bz,rz_time')->order("rz_time desc")->select();//操作日志

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
		//echo "<pre>";
		///	var_dump($where);exit;
			$nachu=array();
				foreach($sql_xiaji as $k=>$v){
					$nachu[$k]=json_decode($v['kh_data'],true);
				}
				//echo "<pre>";
//var_dump($nachu);exit;
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

			foreach($sql_xiaji as $k=>$val){
			$valav=array_merge($guanlianw[$k],$val);
			$dantiao=$valav['kh_id'];//获取到id
			unset($valav['kh_id']); 
			unset($valav['kh_data']); 
			array_unshift($valav,$dantiao); //整理好的单条信息
			
				$ronghe_xiaji[]=$valav;	 //多条融合	
				}


			$this->assign('xiaji_kh',$ronghe_xiaji);//下级客户信息
			//查询提醒消息
			$tixing_base=M('tixing');
			$tixing_map['tx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$tixing_map['tx_mk']=$kh_id;
			$tixing_map['tx_people']=$fuzeren;
			$sql_tixing=$tixing_base->where($tixing_map)->order("tx_bijiao desc")->select();
			$this->assign('tixing_tx',$sql_tixing);
			//var_dump($sql_tixing);exit;
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
				$ko[]=$v;  //显示跟进记录  操作数据的
			}
				$xiegenjin_base=M('xiegenjin');//查询写跟进记录
				$map_xiegenjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				$map_xiegenjin['mode_id']=2;
				$map_xiegenjin['kh_id']=$id;
				$sql_xiegenjin=$xiegenjin_base->where($map_xiegenjin)->field('user_id,type,content,date')->select();
				foreach($sql_xiegenjin as $k=>$v)
				{
					foreach($user_sql as $k1 =>$v1)
					{
						if($v['user_id']==$v1['user_id'])
						{
							$v['user_id']= $v1['user_name'];
							$v['date']=date("Y-m-d H:i:s",$v['date']);
						}
					}
					$ko[]=$v;         //表操作的和写的跟进融合在一起 
				}
				



foreach($ko as $k=>$v)
{
	if($v['date']!='')
	{
		$ko[$k]['rz_time']=$v['date'];
		unset($ko[$k]["date"]);
	}
	$ko[$ko[$k]['rz_time']]=$ko[$k];
	unset($ko[$k]);
}
//echo "<pre>";
//var_dump($ko);exit;
krsort($ko);

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

		//客户资料标题开始
		$fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kehuziliao=M('yewuziduan');
		$yewuziduan['zd_yewu']="2";
		$yewuziduan['zd_yh']=$fid;
		$sql_ywzd=$kehuziliao->where($yewuziduan)->find();
		$ywzd_json=json_decode($sql_ywzd['zd_data'],true);

		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");

		foreach($array_jiansuo as $k3=>$v3){
			$guiding['id']=$k3;
			$guiding['name']=$v3;
			$guiding['type']=9;
			$guidingend[]=$guiding;//自定义 的键值
		}
		//echo "<pre>";
		//var_dump($guidingend);exit;
		//$ywzd_json=array_marge($ywzd_json,$guidingend);
		foreach($ywzd_json as $k=>$v){
			
				
				if ($v['qy']==1){
					$ywcs_get['id']=$v['id'];
					$ywcs_get['name']=$v['name'];
					$ywcs_get['type']=$v['type'];
				}
				$end_ywcs[]=$ywcs_get;
				
			unset($ywcs_get); 
			
		}
		foreach($guidingend as $k=>$v){
			$end_ywcs[]=$v;
		}
		
		//客户信息
		$kh_ziliao=M('kh');
		$map_kh['kh_id']=$id;
		$sql_kh=$kh_ziliao->where($map_kh)->find();
		$sql_kh_json=json_decode($sql_kh['kh_data'],true);
		$valav=array_merge($sql_kh_json,$sql_kh);
		$kh_id=$valav['kh_id'];
		unset($valav['kh_id']); 
		unset($valav['kh_data']); 
		array_unshift($valav,$kh_id);//单挑查询完

		//查询关联字段
		$ywcs_base=M('ywcs');
		$ywcs_map['ywcs_yw']=2;
		$ywcs_map['ywcs_yh']=1;
		$ywcs_sql=$ywcs_base->where($ywcs_map)->field('ywcs_data')->find();
		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
		foreach($ywcs_sql_json as $k6 =>$v6)
		{
			if($v6['id']=="zdy9")
			{
				$dan_ywcs=$v6;
			}
		}

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
		$this->assign('valav',$valav);//写跟进弹出框
		//var_dump($valav);exit;
			$tabl='';
			
			//echo"<pre>";
			//var_dump($end_ywcs);exit;
			foreach($end_ywcs as $k=>$v)
			{
				if($v['type']==0)
				$tabl.='<tr><td>'.$v['name'].':</td><td>1<input type="text" id="'.$kh_id.'" name="'.$v['id'].'" class="ziliao_right" value="'.$valav[$v["id"]].'"   onblur=""><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				else if($v['type']==1){
					$tabl.='<tr><td>'.$v['name'].':</td><td>2<input type="text" id="'.$v['id'].'" class="ziliao_right" value="'.$valav[$v['id']].'"><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				}else if($v['type']==2){
					$tabl.='<tr><td>'.$v['name'].':</td><td>3<input type="text" id="'.$v['id'].'"  value="'.$valav[$v['id']].'" class="text ui-widget-content ui-corner-all ziliao_right" onfocus="WdatePicker({dateFmt:\'yyyy-M-d H:mm:ss\'})"><i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
				}else if($v['type']==3){
						foreach ($ywcs_sql_json as $k3 =>$v3)
						{
							if($v["id"]==$v3['id'])
							{
								foreach($v3 as $k4=>$v4)
								{
									
									if($valav[$v["id"]]==$v4)
									{

										$ss="selected";
									}
									else
									{
										$ss="";
									}
									if(substr($v4,0,3)!='zdy'&& $k4 != 'qy')
									{
										$aaa.='<option value="" '.$ss.' >'.$v4.'</option>';
									}
								}
							}			
						}
					$tabl.='<tr><td>'.$v['name'].':</td><td>4 <select id="'.$v['id'].'" class="ziliao_right1">
														
																
																'.$aaa.'
																
																
																
															 </select>
					<i class="fa fa-pencil" aria-hidden="true"></i></td></tr>';
					unset($aaa);
				}else if($v['type']==9){
					$tabl.='<tr><td>'.$v['name'].':</td><td><input type="text" id="'.$v['id'].'" readonly="readonly" class="ziliao_right" value="'.$valav[$v['id']].'"></td></tr>';
				}
			}
		$this->assign("data_kh",$table1);
	//echo $tabl;exit;
		$this->assign("biaoti_ywzd",$tabl);
	
			$this->assign('rz_caozuo',$koo);
			
			$this->assign('genjin',$ko);
			
		
			$sql=M('file');
			$sql_select=$sql->select();
			$this->assign('sql',$sql_select);
			$this->assign('a_id',$a_id);
			$this->assign('fuzeren',$kh_name);//上面是 客户全景  和附件


			
			$hetong=M('ywcs');
			$map_ywcs_ht['ywcs_yw']="6";
			$ht_ywcs=$hetong->where($map_ywcs_ht)->field('ywcs_data')->find();
			$ht_json_ywcs=json_decode($ht_ywcs['ywcs_data'],true);
			//echo "<pre>";
		//var_dump($ht_json_ywcs);exit;

			$hetong=M('hetong');
				$tiaojian='"zdy1":"'.$id.'"';
				
			$sql_hetong=$hetong->query("select * from crm_hetong where ht_data like '%$tiaojian%'");
			//echo "<pre>";
		//var_dump($sql_hetong);exit;
		$number=0;
			foreach($sql_hetong as $k=>$v){

					$sql_json_htong=json_decode($v['ht_data'],true);
					
					$number=$number+$sql_json_htong['zdy3'];
					$ht_end[]=$sql_json_htong;
			}
			$this->assign('number',$number);//合同总金额
			foreach($ht_end as $k1=>$v1){
				foreach($ht_json_ywcs as $k2=>$v2){
					if('zdy7'==$v2['id']){
						$v1['zdy7']=$v2[$v1['zdy7']];

					}
				}
				$hetong_end1[]=$v1;
			}
			
			$this->assign('ht_end',$hetong_end1);
			//echo "<pre>";0,3,5,6,7,17
			//var_dump($ht_end);exit;
			$this->display();
		}
		public function delete(){

			$sql['id']=$_GET['id'];
			
			 $sql_delete=M('file');
       		
       		

       			//删除增加日志
       		 $loginIp=$_SERVER['REMOTE_ADDR'];//IP 
           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
            	$addressArr=getCity($nowip);//登录地点
            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
            	$fujian=$sql_delete->where($sql)->field('name_id,fujian_name')->find();	
		   		$rz=M('rz');
		 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
		 		$rz_map['rz_mode']=2;
		 		$rz_map['rz_object']=$fujian['name_id'];//客户名称ID
		 		$rz_map['rz_cz_type']=1;//1代表新建
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
				$sql=M('file');
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
					

					echo $table ;

			}
		}
		public function upload(){//http://www.jb51.net/article/74353.htm   筛选第二天要看的


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
		 		$rz_map['rz_mode']=2;
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




       			 $sql_file=M('file');
       			 $sql_file_select=$sql_file->add($data);
       			 if($sql_file_select)
       			 {
       			 	//$this->success("上传成功");
       			 	echo '<script>alert("上传成功");window.location="'.$_GET['root_dir'].'/index.php/Home/Kehu/kehumingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/kh_id/'.$_GET['kh_id'].'"</script>';
       			 	
       			 }else{
       			 	$this->error("上传失败");
       			 }
		}
	


}
		public function bianji_ziliao(){
			$bianji_id['kh_id']= $_GET['aid'];//81
			$bianji_name= $_GET['name'];//zdy2  fuzeren
			$bianji_val= $_GET['val'];//修改内容
			$sql=substr($bianji_name,0,3);
			$kehus=M('kh'); 
			if($sql=='zdy')
			{
				$ywzd=M('yewuziduan');              //只是为了获取  zd0   的中文名字放备注中
				$yw_cs['zd_yewu']="2";
 				$yw_cs['zd_yh']=1;
				$ywzd_sql=$ywzd->where($yw_cs)->find();
				$sql_json=json_decode($ywzd_sql['zd_data'],true);
					foreach($sql_json as $k=>$v)
					{
						if($v['id']==$bianji_name)
						{
							$name_rz=$v['name'];
						}
					}                                    //获取完了
					$map_rz['kh_id']=$bianji_id['kh_id'];  //这里获取修改之前的值 日志记录用
					$kh_old_val=$kehus->where(array($map_rz))->field('kh_data')->find();
					$sql_json_rz=json_decode($kh_old_val['kh_data'],true);
					foreach($sql_json_rz as $krz=>$vrz)
					{
						if($krz==$bianji_name)
						{
							$b_rz=$vrz;
						}
					}
					$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
	           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
	            	$addressArr=getCity($nowip);//登录地点
	            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
			   		$id=$bianji_id['kh_id'];	
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
					$sql_json=json_decode($sql_bianji['kh_data'],true);
					foreach($sql_json as $kt=>$vt)
					{
						if($kt==$bianji_name)
						{
							$sql_json[$kt]=$bianji_val;	
						}
					 
					}
					$map['kh_id']= $bianji_id['kh_id']; 
					$save_data=$sql_json;
					$a_arr['kh_data']=json_encode($save_data,true);
					$save=$kehus->where($map)->save($a_arr);
					if($save)
					{
						echo "ok";
					}else
					{
						echo "no";
					}
			}
    
		}

		public function genjin_bianji(){
			$genjin['mode_id']=2;
			$genjin['kh_id']=$_POST['kh_id'];
			$genjin['user_id']=cookie('user_id');
			$genjin['type']=$_POST['fangshi'];
			$genjin['content']=$_POST['wenbenyu'];
			$genjin['date']=time();
			$genjin['genjin_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');;
			$genjin_base=M('xiegenjin');
			$sql_add=$genjin_base->add($genjin);
			if($sql_add){

				echo '<script>alert("添加成功");window.location="'.$_GET['root_dir'].'/index.php/Home/Kehu/kehumingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/kh_id/'.$_GET['kh_id'].'"</script>';
				
			}else{

			}
		
		}
		public function tixing_add(){
			$data=$_POST;
			$rizhi=substr($data['tx_bijiao'],0,strlen($data['tx_bijiao'])-8);//日期
			$shijian=substr($data['tx_bijiao'], -8); 
			$data['tx_date']=$rizhi;
			$data['tx_time']=$shijian;

			$data['tx_bijiao']=strtotime($data['tx_bijiao']);
			$data['tx_kh_name']=2;
			$data["tx_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$tixing=M('tixing');
			$sql=$tixing->add($data);

			if($sql){
				echo '<script>alert("添加成功");window.location="'.$_GET['root_dir'].'/index.php/Home/Kehu/kehumingcheng/id/'.$_GET['pageid'].'/fuzeren/'.$_GET['fuzeren'].'/id1/'.$_GET['id1'].'/kh_id/'.$_GET['kh_id'].'"</script>';
			}else{
				echo "添加失败";
			}
		}
		public function del_kehu(){
			$mapid=$_GET['id'];
			$kehudel_base=M('kh');
			$sql_del=$kehudel_base->query("delete from `crm_kh` where `kh_id` in ($mapid)");
										
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
			$kehu_base=M('kh');
			$sql=$kehu_base->query("select * from `crm_kh` where `kh_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['kh_data'],true);
			
				foreach($json as $k1=>$v2)
				{
					if($ziduan == $k1 )
					{
					$json[$k1]=$content;
					$da=$json;//data替换完成
					$map['kh_id']=$v['kh_id'];//条件
					$data['kh_data']=json_encode($da,true);//修改内容
					$save=$kehu_base->where($map)->save($data);
						if($save)
						{
								$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
				           	 	$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
				            	$addressArr=getCity($nowip);//登录地点
				            	$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
						   	
						   		$rz=M('rz');
						 		$rz_map['rz_type']=1;//这个1是操作日志类型  死的
						 		$rz_map['rz_mode']=2;
						 		$rz_map['rz_object']=$v['kh_id'];//客户名称ID
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
			$kh_id=$_GET['kh_id'];
			$id=substr($kh_id,0,strlen($kh_id)-1); //id
			$kehu_base=M('kh');
			$sql=$kehu_base->query("select * from `crm_kh` where `kh_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['kh_data'],true);
				$data['kh_old_fz']=$json['fuzeren'];
				foreach($json as $k1=>$v2)
					{
						if($ziduan == $k1 )
						{
							$json[$k1]=$fuzeren;
							$da=$json;//data替换完成
							$map['kh_id']=$v['kh_id'];//条件

							$data['kh_data']=json_encode($da,true);//修改内容
							
							
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
						 		$rz_map['rz_mode']=2;
						 		$rz_map['rz_object']=$v['kh_id'];//客户名称ID
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
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('kh');
		$kh_map['kh_yh']="19950228";                            
		$kehu2=$kehu->where($kh_map)->find();
		$kh_data_json=json_decode($kehu2['kh_data'],true);

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
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=1;
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 	
 		$a=M('yewuziduan');                    
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
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
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		$kehu=M('kh');
	$kh_map['kh_yh']="19950228";                            
		$kehu2=$kehu->where($kh_map)->find();
		$kh_data_json=json_decode($kehu2['kh_data'],true);

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

			$data['kh_data']=json_encode($v);
			//echo $data['kh_data'];
			
			$kh_add=M("kh");
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
  		$map['zd_yewu']="2";
  		$map['zd_yh']="1";//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();         //业务参数查询
		$a_arr=json_decode($sql['zd_data'],true);

		$kehu=M('kh'); 
		             //显示客户所需字段data
		$kehu=$kehu->select();                                   //客户内容查询

		//查询所有用户
		$array_jiansuo=array('fuzeren'=>"负责人",'department'=>"部门",'kh_lx'=>"联系人",'kh_cj_cp'=>"已经成交产品",'kh_new_gj'=>"最新跟进记录",'kh_sj_gj_date'=>"实际跟进时间",'kh_cj'=>"创建人",'kh_old_fz'=>"前负责人",'kh_old_bm'=>"前所属部门",'kh_cj_date'=>"创建时间",'kh_gx_date'=>"更新于",'kh_gh_date'=>"划入公海时间",'kh_yh'=>"所属公司");
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
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=1;
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
				
				if($kk!='kh_data')
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
				if($k1=='zdy1' || $k1=='zdy9' ||$k1=='zdy10' ||$k1=='zdy11' ||$k1=='zdy12')
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
		
					foreach($ronghe as $r_k=>$r_v)
					{	

						$a_fuzeren=$r_v['fuzeren'];
						$v=$r_v['zdy0'];
						
			
						$id=$r_v['kh_id'];
						$table.="<tr id='tr".$r_v['kh_id']."'>";
								$xs123=$r_v['kh_id'];
								$table.="
										<td >
											<input type='checkbox' class='chbox_duoxuan' id='$xs123'>$xs123
										</td>";
								foreach($kh_biaoti1 as $k_biaoti=>$v_biaoti)

								{
									
									if($r_v[$v_biaoti['id']]!="")	
									{
											$a_fuzeren=$r_v['fuzeren'];
											if($v_biaoti['id']=='zdy0')
												$xs123="<a href='kehumingcheng/id/$v/fuzeren/$a_fuzeren/id1/$id/kh_id/$id'>".$r_v[$v_biaoti['id']]."</a>";
											elseif($v_biaoti['id']=="fuzeren")
											{	//echo "<pre>";
												//var_dump($fzr_only);exit;
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['fuzeren'])
															//$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";
															$xs123="<span id='wys{$id}'>".$v44['user_name']."</span>";

													}
													
												}
											}elseif($v_biaoti['id']=="kh_old_fz")
												foreach($fzr_only as $k44=>$v44 )
												{	
													foreach($v44 as $k=>$v)
													{
														if($v44['user_id']==$r_v['kh_old_fz'])
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
						$table.="</tr>";	
					}
		echo $table;
	

	}

}