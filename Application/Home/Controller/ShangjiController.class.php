<?php
namespace Home\Controller;
use Think\Controller;


class ShangjiController extends Controller {

	public function kehu(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map' and kh_gonghai=0 ");
		
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh_name[$vkh['kh_id']]=$kh;
		}
	
		return $kh_name;
	}
	public function kehu1(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('kh');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_kh where kh_yh='$map' and kh_gonghai=0 and kh_fz in ($xiaji)");
		
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['kh_data'],true);
			
					$kh['id']=$vkh['kh_id'];
					$kh['name']=$kh_json['zdy0'];
					$kh_name[$vkh['kh_id']]=$kh;
		}
	
		return $kh_name;
	}
	public function shangji(){
		$data['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件               
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		//var_dump($new_array);exit;
		
		$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);   
	//	echo "<pre>";
		//var_dump($ywcs_json);exit;                       //获取商机配置表参数
		$fenye=$_GET['fenye'];
		if($fenye==null || $fenye=='')
		{
			$list_num=20;
		}else{
			$list_num=$fenye;
		}
		$dijiye=$_GET['dijiye'];
		if($dijiye==null || $dijiye=="")
		{
			$new=0;
			$dijiye=1;
		}else{
			$new=($dijiye-1)*$list_num;
		}

      	$ssaaa=$_GET['sousuo'];
      	$sxaaa=$_GET['sxab'];
       // $sxaaa="zdy5,2|";
      	if($ssaaa!="")
      	{
			$yzdl=A('DB');
			$yzdl->is_login2(2);//跳转 登录验证
			$yzdl->have_qx2("qx_sj_open");//跳转权限验证
			$json_name=json_encode($ssaaa,true);
			$newstr = substr($json_name,0,strlen($json_name)-1); 
			$first =substr($newstr,1);  
			$tihuan= str_replace("\\", "\\\\\\\\", $first);
			$sj_base=M('shangji');
			$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh = '$yh' and sj_gonghai=0 and sj_fz IN ($xiaji) and  sj_data like '%".$tihuan."%'");
		
			$this->assign('ssaaa',$ssaaa);
		}elseif($sxaaa!=""){
					$yzdl=A('DB');
					$yzdl->is_login();
					$yzdl->have_qx("qx_sj_open");//跳转权限验证
					$new_id=substr($sxaaa,0,strlen($sxaaa)-1); 
					//$new_id="zdy7,1|kehujibie,3";
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
					$anum=0;
					foreach($get as $kqb=>$vqb)
					{
						
							
								if($vqb['1']!='1')
								{
									$anum++;
								}
							
						
					}
					if($anum==0)
					{
						echo "quanbu";die;
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
							$kehu_jibie=$vkh['1'];                  //判断商机 是全部商机  我的商机还是 我下属的商机
						}
					}
				

					$sj_base=M('shangji');
					$xiaji= $this->get_xiashu_id();// 全部商机
					$myid=cookie('user_id');//本人ID  
					$myid2=$myid."0";
					$myidcount=strlen($myid2); //查询下级时候用
					$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
					$new_number=substr($xiaji,0,strlen($xiaji)-$myidcount);

					if($kehu_jibie=="3"){ 
						$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map'  and sj_gonghai=0 and sj_fz IN ($new_number)");                  //全部客户
						
					}elseif($kehu_jibie=="2"){               //我的客户
						$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_gonghai=0 and sj_fz ='$myid' ");

					}else{                                   //我下属的客户
						$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_gonghai=0 and sj_fz IN ($xiaji)");
					}	
		}else{
			$yzdl=A('DB');
			$yzdl->is_login2(2);//跳转 登录验证
			$yzdl->have_qx2("qx_sj_open");//跳转权限验证
			$sj_base=M('shangji');
			$xiaji= $this->get_xiashu_id();//  查询下级ID
			$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_gonghai=0 and sj_fz IN ($xiaji) order by sj_id desc limit ".$new.",".$list_num." ");// 查询商机信息
			$sj_count=$sj_base->query("select count(sj_id) from crm_shangji where sj_yh='$map' and sj_fz IN ($xiaji)");
			//var_dump($sj_count) ;exit;
			$ys= ceil($sj_count['0']['count(sj_id)']/$list_num);//多少页
		}
		foreach($ywcs_json as $kcs => $vcs)
		{
			foreach($vcs['qy'] as $kqy=>$vqy)
			{

				if($vqy=='1')
				{
					$cs_new[$kqy]=$vcs[$kqy];

				}
			}
			
			$new_ywcs[$vcs['id']]=$cs_new;            //获取到启用了的参数
			unset($cs_new);
			
		}
	//	echo "<pre>";
//ar_dump($ywcs_json );exit;
//echo "<pre>";
//var_dump($new_ywcs);exit;
		
		$kh_name=$this->kehu();
		$kh_name1=$this->kehu1();
		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
	//echo "<pre>";
		//var_dump($dpt_arr);exit;
		$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id IN ($xiaji)");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
					}
						
				}
			}  
		if($sxaaa!='')
		{		
				$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);   
		foreach($ywcs_json as $kcs => $vcs)
		{
			foreach($vcs['qy'] as $kqy=>$vqy)
			{

				if($vqy=='1')
				{
					$cs_new[$kqy]=$vcs[$kqy];

				}
			}
			$new_ywcsa[$vcs['id']]=$cs_new;            //获取到启用了的参数
			unset($cs_new);
			
		}
		$cs_th=$new_ywcsa;

			$number="1";
	 		foreach($ywcs_json as $k=>$v)
			{
				foreach($v as $k1=>$v2)
				{	
					if($k1=="id")
					{
						$new_ywcsa[$number]=$v2;
					}else{
						$new_ywcsa[$number]=$k1;
					}
					
					$number++;
				}
				$number="1";
				$new_ywcs2[]=$new_ywcsa;  //实现  dom 下标 对应 canshu***
				unset($new_ywcsa);
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
				

				foreach($userarr as $k=>$v)
					{
						foreach($v as $kk=>$vv)
						{
							if($kk!='sj_data')
									$ronghea[$k][$kk]=$vv;
							else
							{
								$rowjson=json_decode($vv,true);
								foreach($rowjson as $kkk=>$vvv)
								{	
											$ronghea[$k][$kkk]=$vvv;
								}
							}
						}
					}
					
					foreach ($ronghea as $k=>$v)
					{
						foreach($v as $k1=>$v1)
						{
							
				
								if($v["zdy5"]==$save["zdy5"] || $save["zdy5"]=="" )
								{	

									if($v["zdy7"]==$save["zdy7"] || $save["zdy7"]=="")
									{	
										
										if($v["zdy9"]==$save["zdy9"] ||$save["zdy9"]=="")
										{	
											$new_rongheq[$k]=$v;
										}continue 2;
									}continue 2;
								}continue 2;
							
						}
					}
					$ronghe=$new_rongheq;

//echo "<pre>";
	//var_dump($ronghe);exit;
				
		}else{
			foreach($userarr as $k=>$v)
			{
				foreach($v as $kk=>$vv)
				{
					if($kk!='sj_data')
						
							$ronghe[$k][$kk]=$vv;

					else
					{
						$rowjson=json_decode($vv,true);
						foreach($rowjson as $kkk=>$vvv)
						{	

									$ronghe[$k][$kkk]=$vvv;
						}
					}
				}
			}
			
		}

		foreach($ywzd_sql_json as $k=>$v)
		{
			if($v['qy']==1)
			{
				if($v['id']=='zdy5' || $v['id']=='zdy7' || $v['id']=='zdy9')
				{
					$bir[]=$v;           //批量编辑用
				}
			}
		}
	//echo "<pre>";
//	var_dump($bir);exit;
		$array_jiansuo=array('sj_qiandan'=>"签单可能性",'sj_new_gj'=>"最新跟进记录",'sj_sj_date'=>"实际跟进时间",'sj_fz'=>"负责人",'sj_bm'=>"部门",'sj_cj'=>"创建人",'sj_cj_date'=>"创建时间","sj_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($ywzd_sql_json,$new_arrayoo);//客户标题名字
		
		$lx_name=$this->lxr();
			
		$lx_name1=$this->lxr1();
		$fzr_only1=$this->user1();
		foreach($kh_biaoti1 as $k=>$v)
		{
			$biaoti[$v['id']]=$v;             //给标题数组赋值键
		}
		if($ronghe=='' || $ronghe==null)
		{
				$show.="<tr><td colspan='30'><span >亲~没有数据哟！请<span  onclick='addshangji()'style='color:#1AA094;cursor:pointer;' >新增</span>商机</td></tr>";
				if($sxaaa!='')
				{
					echo $show;exit;
				}else{
					$this->assign('budong','budong');
				}
		}else{ 

		foreach ($ronghe as $k =>$v)    
		{
			$id=$v['sj_id'];
			$kh_mc=$v['zdy1'];
			$kh_id=$v['kh_id'];
			//$fuzeren=$
			$show.="<tr>";
			$show.="
				<td >
				<input type='checkbox' class='chbox_duoxuan' id='".$v['sj_id']."'>
				</td>";
			foreach($biaoti as $k1=>$v1)
			{
				if($v[$k1]!="")
				{
					if($k1=="zdy0")    //商机标题  跳转到商机页面
					{ 
						$show.="<td > <a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id' title='".$v[$k1]."'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/kh_id/$kh_mc' title='".$kh_name[$v[$k1]]['name']."'>".$kh_name[$v[$k1]]['name']." </a></td>";
					}elseif($k1=="zdy2"){
						
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Lianxirenmingcheng/lianxirenmingcheng/id/".$v[$k1]."' title='".$lx_name1[$v[$k1]]['name']."'>".$lx_name1[$v[$k1]]['name']." </a></td>";
						
					}elseif($k1=="zdy5" || $k1=="zdy7" || $k1=="zdy9"){
				
						$show.="<td>".$new_ywcs[$k1][$v[$k1]]."</td>";
					}elseif($k1=="zdy11"){
							$aaa=strlen($v[$k1]);
							if($aaa>40)
							{
								$bzhu=mb_substr($v[$k1],0,40,'utf-8')."···";	
							}else{
								$bzhu=$v[$k1];
							}
							$show.="<td> <span title='".$v[$k1]."' style='cursor:pointer'>".$bzhu." </span></td>";
					}elseif($k1=="sj_fz" ||  $k1=="sj_cj" ){
						$show.="<td>".$fzr_only1[$v[$k1]]["user_name"]." </td>"	;
				
					}elseif($k1=="sj_bm"){
						$show.="<td>".$fzr_only1[$v["sj_fz"]]["department"]." </td>"	;
					}
					elseif($k1=="sj_cj_date"){
						$show.="<td>".date('Y-m-d H:i:s',$v[$k1])." </td>"	;
					}else{
						$show.="<td> ".$v[$k1]." </td>"	;
					}
					}else{
					$show.="<td> ---- </td>"	;
					}
				}
				$show.="</tr>";                                          //显示商机信息模板
			}
		}
		if($sxaaa!='')
		{
			echo $show;exit;
		}
		//echo "<pre>";var_dump($ywzd_sql_json);exit;
		foreach($ywzd_sql_json as $kzd=>$vzd)                                      //后台判断生成模板
		{
			if($vzd['qy']=="1")
			{
				if($vzd['bt']=="1")
				{
					$table.="<tr class='addtr '>";
						$table.="<td><span style='color:red'>*</span>".$vzd['name'].":</td>";
						if($vzd['type']=="0") 
							if($vzd['id']=='zdy11'){
								$table.="<td><textarea name='".$vzd['id']."' class='required' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
							}else{
							$table.="<td><input type='text' class='required' name='".$vzd['id']."' value='' maxlength='40'></td>";   //  0文本框
							}
						elseif($vzd['type']=="2")
							$table.="<td><input type='text' class='required' name='".$vzd['id']."'   class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd '".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table.="<td id='sj_zdy1'>";
								$table.="<select id='ss1' class='required lxr_ajax xlss' id='ac' name='".$vzd['id']."'  style='width:230px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
										$table.="<option value='tiaozhuan' style='color:red'>点我添加新客户</option>";
								foreach($kh_name1 as $k=>$v)
									{
										$table.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
									$table.="</select>";	
							
							}elseif($vzd['id']=="zdy2")
							{
								$table.="<td class='lx_th' id='sj_zdy2'>";
								$table.="<select id='ss2' name='".$vzd['id']."' class='required '  id='bc' style='width:300px;height:30px;'>";
										$table.="<option value=''>请先选择公司</option>";
									$table.="</select>";	
								$table.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."'  class='required ' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."' class='required' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table.="<td>";
								$table.="<select name='".$vzd['id']."'  class='required' style='width:300px;height:30px;'>";
										$table.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table.="<option value='".$k."'>".$v."</option>";
									}
								$table.="</td>";
								
							}else{
						
							$table.="<td>";

								$table.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品' maxlength='40'>";
								
								$table.="</td>";
								
				
							}
						}	
																//  3下拉选择
					$table.="</tr>";																						
				}elseif($vzd['cy']=="1"){
					$table1.="<tr class='addtr'>";
						$table1.="<div class='".$vzd['id']."'><td >".$vzd['name'].":</td></div>";
						if($vzd['type']=="0") 
							if($vzd['id']=='zdy11'){
								$table1.="<td><textarea name='".$vzd['id']."'  maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
							}else{
							$table1.="<td><input type='text' name='".$vzd['id']."' maxlength='40' ></td>";   //  0文本框
							}
						elseif($vzd['type']=="2")
							$table1.="<td><input type='text' name='".$vzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' onchange='get_lx(this)' style='width:300px;height:30px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table1.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
										$table1.="</select>";
								$table1.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table1.="<td class='lxr'>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table1.="<option value=''>请先选择公司</option>";
								$table1.="</select>";	
								$table1.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
									$table1.="</select>";	
								$table1.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table1.="<td>";
								$table1.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table1.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table1.="<option value='".$k."'>".$v."</option>";
									}
								$table1.="</td>";
								
							
							}else{
					
								
							$table1.="<td>";

								$table1.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品'  >";
								

								
								$table1.="</td>";

							}
						}	
																//  3下拉选择
					$table1.="</tr>";

					
				}else{
					$table2.="<tr class='addtr ncy'>";
						$table2.="<div class='".$vzd['id']."'><td >".$vzd['name'].":</td></div>";
						if($vzd['type']=="0") 
							if($vzd['id']=='zdy11'){
								$table2.="<td><textarea name='".$vzd['id']."'  maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
							}else{
							$table2.="<td><input type='text' name='".$vzd['id']."'  ></td>";   //  0文本框
							}
						elseif($vzd['type']=="2")
							$table2.="<td><input type='text' name='".$vzd['id']."'  class='text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td>";   //  2 日期 
						elseif($vzd['type']=="3")
						{	
							//echo $vzd['id'];
							if($vzd['id']=="zdy1")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' onchange='get_lx(this)' style='width:300px;height:30px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($kh_name as $k=>$v)
									{
										$table2.="<option value='".$v['id']."'>".$v['name']."</option>";
									}
										$table2.="</select>";
								$table1.="</td>";
							}elseif($vzd['id']=="zdy2")
							{
								$table2.="<td class='lxr'>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table2.="<option value=''>请先选择公司</option>";
								$table2.="</select>";	
								$table2.="</td>";
							}elseif($vzd['id']=="zdy9")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
									$table2.="</select>";	
								$table2.="</td>";
							}elseif($vzd['id']=="zdy5")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
								$table2.="</td>";
								
							}elseif($vzd['id']=="zdy7")
							{
								$table2.="<td>";
								$table2.="<select name='".$vzd['id']."' style='width:300px;height:30px;'>";
										$table2.="<option value=''>--请选择--</option>";
								foreach($new_ywcs[$vzd['id']] as $k=>$v)
									{
										$table2.="<option value='".$k."'>".$v."</option>";
									}
								$table2.="</td>";
								
							
							}else{
					
								
							$table2.="<td>";

								$table2.="<input type='button' name='xiaodan' onclick='add_cp()' value='+添加产品'  >";
								

								
								$table2.="</td>";

							}
						}	
																//  3下拉选择
					$table2.="</tr>";

				}
				
				}if($vzd['id']=="zdy6"){
				$table2.="<tr><td colspan='2'>";
					$table2.="<table class='layui-table'   style='display: none;border:1px'>";
								 	 $table2.="<thead>
								  				<th >产品名称</th>
						  						<th >产品原价</th>
						  						<th >建议价格</td>
						  						<th >数量</th>
						  						<th >折扣</th>
						  						<th >总价</th>
						  						<th >操作</th>
											</thead>";
									  $table2.="<tbody class='tihuan'>";
								
									  $table2.="</tbody>
										 </table>";
					$table2.="</td></tr>";
			}
		}
		//echo "<pre>";
	//var_dump($bir);exit;
		foreach($bir as $k=>$v)
		{
			$bj_tab.="<tr class='yincang top_pl_bj' style='line-height:70px' id='wc".$v['id']."'><td>".$v['name'].":</td>";
			if($v['type']=="3")                     //下拉框样式
			{
				$bj_tab.="<td>";
				$bj_tab.="<select id='".$v['id'].'wys'."'  style='width:300px;height:30px;'>";
				foreach($new_ywcs[$v['id']] as $k=>$vv)
				{
					//var_dump($ywcs_sql_json[$v['id']]);exit;
					if($k!='id'&&$k!='qy')
						$bj_tab.="<option value='$k'>".$vv."</option>";
				}
				$bj_tab.="</select>";
				$bj_tab.="</td>";
			}
			$bj_tab.="</tr>";    //
		}

		$new_html.="<div class='sxzddiv' id='kehujibie'>";
						$new_html.=" <div class='sx_title' >商机范围：</div>";
								$new_html.=" <span class='sx_yes'>全部商机</span>";
								$new_html.="<span class='sx_no'>我的商机</span>";
								$new_html.="<span class='sx_no'>我下属的商机</span>";					
					$new_html.="</div>";
			foreach($bir as $v)
			{
					$new_html.="<div class='sxzddiv' id='".$v['id']."'>";
						$new_html.=" <div class='sx_title' >".$v['name']."：</div>";
							$new_html.=" <span class='sx_yes'>全部</span>";
						foreach($new_ywcs[$v['id']] as $k=>$vv)
						{
	
						
								$new_html.="<span class='sx_no'>".$vv."</span>";
						}
					$new_html.="</div>";

			}
			$chanpin=$this->chanpin();
		

			$chanpin1.="<tr  class='addtr'>";
				$chanpin1.="<td><span style='color:red'>*</span>产品名称：</td>";
					$chanpin1.="<td><select name='cp_id'  id='cp_caozuo' class ='clk_fzr xlss' style='width:300px;height:30px;'>";
							$chanpin1.="<option value='s' >请选择产品 </option>";
					foreach ($chanpin as $k=>$v)
					{
							$chanpin1.="<option value='".$v['cp_id']."'>".$v['zdy0']."(".$v['zdy1'].") </option>";
					}
					$chanpin1.="</select> </td></tr>";
//var_dump($chanpin1);exit;
		$this->assign('chanpin1',$chanpin1); 
		$this->assign('new_html',$new_html); 	
		$this->assign('bj_tab',$bj_tab); 			
		$add=$table;  //必填
		$add1=$table1;//非必填
		$this->assign('show',$show);
		$this->assign('add1',$add1);		
		$this->assign('add',$add);	
		$this->assign('add2',$table2);
		$this->assign('fuzeren',$fzr_only);	
		$this->assign('biaoti',$biaoti);	
		$this->assign('biaoti1',$bir);	
		$this->assign('ys',$ys);//页数
		$this->assign('dijiye',$dijiye);
		$this->assign('list_num',$list_num);
		$this->display();
	}
	public function xiazaimuban(){
		$dy=A("Filedo");

		$a=M('yewuziduan'); 

		//商机 标题下载
		$mapsj['zd_yewu']="5";
		$mapsj['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$sqlsj=$a->where($mapsj)->field('zd_data')->find();
		$sj_arr=json_decode($sqlsj['zd_data'],true);
		foreach($sj_arr as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arrsj=$v2;
				$new_qysj[]=$qy_arrsj;
			}
		}
		foreach($new_qysj as $k=>$v)
		{
			if($v['id']!='zdy1' && $v['id']!='zdy2'  && $v['id']!='zdy6'){
				if($v['bt']=="1")
				{
					if($v['type']=="3")
					{
						$array[]=$v["name"]."(必填请对照参数填写)";
					}else{
						$array[]=$v["name"]."(必填)";
					}
					
				}else{
					
					if($v['type']=="3")
					{
						$array[]=$v["name"]."(请对照参数填写)";
					}else{
						$array[]=$v["name"];
					}
				}
			}
		}
		$fenge="分隔栏";
		$array[]=$fenge; 
		//下面客户标题                   
		$map['zd_yewu']="2";
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$sql=$a->where($map)->field('zd_data')->find();
	 	 $a_arr=json_decode($sql['zd_data'],true); 
		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		$a_arr=$new_qy;   //模板标题 
		foreach($a_arr as $k=>$v)
		{
			if($v['id']!='zdy15'){
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
			}
		}
		$fenge="分隔栏";
		$array[]=$fenge; 
		//下面联系人标题
		$maplx['zd_yewu']="4";
		$maplx['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）


		$sqllx=$a->where($maplx)->field('zd_data')->find();
		$a_arrlx=json_decode($sqllx['zd_data'],true); 
		foreach($a_arrlx as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arrlx=$v2;
				$new_qylx[]=$qy_arrlx;
			}
		}
		$a_arrlx=$new_qylx;   //模板标题 
		foreach($a_arrlx as $k=>$v)
		{
			if($v['id']!='zdy1')
			{
				if($v['bt']=="1")
				{
					
						$array[]=$v["name"]."(必填)";
				
					
				}else{
					
					$array[]=$v["name"];     //标题
				}
			}
		
		}


		
		$title=$array;
    	$data[15]=array("1","canshu1");
    	$dy->getExcel("导入商机",$title,$data);

	}
	public function drcshi(){
		$name=$_GET['name'];
		if($name=="" || $name==null)
		{
			echo "亲~请上传导入文件";exit;
		}
		$dy=A("Filedo");
		$aaa=$dy->getdata("./Public/chanpinfile/cpfile/linshi/".$name);
		
		$a=M('yewuziduan'); 
	
		//商机标题
		$mapsj['zd_yewu']="5";
		$mapsj['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$sqlsj=$a->where($mapsj)->field('zd_data')->find();
		$sj_arr=json_decode($sqlsj['zd_data'],true);
		foreach($sj_arr as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arrsj=$v2;
				$new_qysj[]=$qy_arrsj;
			}
		}
		$aa=A;
		foreach($new_qysj as $k=>$v)
		{
			if($v['id']!='zdy1' && $v['id']!='zdy2'  && $v['id']!='zdy6'){
				if($v['bt']=="1")
				{
					if($v['type']=="3")
					{
						$array[]=$v["name"]."(必填请对照参数填写)";
					}else{
						$array[]=$v["name"]."(必填)";
					}
					
				}else{
					
					if($v['type']=="3")
					{
						$array[]=$v["name"]."(请对照参数填写)";
					}else{
						$array[]=$v["name"];
					}
				}
				$sj_addyong[$aa]=$v['id'];
				$aa++;
			}
		
			
		}
		$sj_number=count($array);
		$fenge="分隔栏";
		$array[]=$fenge; 
		$aa++;
		//下面客户标题                   
		$map['zd_yewu']="2";
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$sql=$a->where($map)->field('zd_data')->find();
		  $a_arr=json_decode($sql['zd_data'],true); 
		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		$a_arr=$new_qy;   //模板标题 
		
		foreach($a_arr as $k=>$v)
		{
			if($v['id']!='zdy15'){
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
				$kh_addyong[$aa]=$v['id'];
				$aa++;
			}
		}
		$kh_number=count($array);
		$aa++;
	
		
		$fenge="分隔栏";
		$array[]=$fenge; 
	
		//下面联系人标题
		$maplx['zd_yewu']="4";
		$maplx['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	
	
		$sqllx=$a->where($maplx)->field('zd_data')->find();
		$a_arrlx=json_decode($sqllx['zd_data'],true); 
		foreach($a_arrlx as $k2=>$v2){
			if($v2['qy']=="1"){
				$qy_arrlx=$v2;
				$new_qylx[]=$qy_arrlx;
			}
		}
		$a_arrlx=$new_qylx;   //模板标题 
		foreach($a_arrlx as $k=>$v)
		{
			if($v['id']!='zdy1')
			{
				if($v['bt']=="1")
				{
					
						$array[]=$v["name"]."(必填)";
				
					
				}else{
					
					$array[]=$v["name"];     //标题
				}
				$lx_addyong[$aa]=$v['id'];
				$aa++;
			}
		
		}
	
	
	
	
	
		$drnum=count($aaa[1]);
		$dqbt=$array;
	
		$num=0;
		foreach($aaa[1] as $k=>$v)
		{
			if($v!=$dqbt[$num])
			{
				echo "亲~请下载最新模板";exit;
			}
			$num++;
		}
	
		if(count($aaa[1])  != count($dqbt))
		{
			echo "亲~请下载最新模板";exit;
		}
		
		//上面判断出新的模板并且客户没有乱修改
		//把客户和联系人的数据分离开
		$excelhang="1"; 
		
		$sj_numbera=$sj_number+2;
		$sj_numberb=A;
		for($i=1;$i<$sj_numbera;$i++){
			$sj_numberb++;//客户第N 栏求出
		}
		$kha_numberb=$sj_numberb;
		for($i;$i<$kh_number+2;$i++)
		{
			$kha_numberb++;//联系人姓名 第N 栏
		}
		
		foreach($aaa as $k=>$v)
		{		

				if($v["A"]=='' || $v["A"]==null)
				{
					echo "亲~第".$excelhang."行的商机名称不能为空";exit;
				}
				if($v[$sj_numberb]=='' || $v[$sj_numberb]==null)
				{
					echo "亲~第".$excelhang."行的客户名称不能为空";exit;
				}
				if($v[$kha_numberb]=='' || $v[$kha_numberb]==null){
					echo "亲~第".$excelhang."行的联系人名称不能为空";exit;
				}
		
			$excelhang++;
			}
		//上面判断完成，符合要求，进行添加 客户 联系人
		$sj_numbera=$sj_number+1;
		foreach($aaa as $k=>$v)
		{
			if($k!=1)
			{	
				$i=0;
			
				foreach($v as $ka=>$va)
				{
					
					
					
					if($i<$sj_number)
					{	
						$new_addsj[$sj_addyong[$ka]]=$va;//商机单条完成
						//echo "<pre>";var_dump($sj_addyong);exit;
					}elseif($sj_number<$i){
					
						if($i<$kh_number){
						
							$new_addkh[$kh_addyong[$ka]]=$va;//客户单条完成
						}elseif($kh_number<$i){
							
							if($i<count($dqbt)){
							
										$new_addlx[$lx_addyong[$ka]]=$va;//联系人单条完成
									}
						}
					}
				
					$i++;
		
					
				}
		
						$userc=$this->user();
						$mapkh['kh_data']=json_encode($new_addkh,true);
						$mapkh['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
						$mapkh['kh_fz']=cookie('user_id');
						$mapkh['kh_bm']=$userc[$mapkh['kh_fz']]['department'];
						$mapkh['kh_cj']=cookie('user_id');
						$mapkh['kh_cj_date']=time();
						$khbase=M('kh');
						$khadd=$khbase->add($mapkh);
				
						if($khadd)
						{	
							$new_addlx['zdy1']=$khadd;
							$maplxa['lx_data']=json_encode($new_addlx,true);
							$maplxa['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
						
							$maplxa['lx_cj']=cookie('user_id');
							$maplxa['lx_cj_date']=time();
							$lxbasea=M('lx');
							$lxadda=$lxbasea->add($maplxa);
							if($lxadda){
								$new_addsj['zdy1']=$khadd;
								$new_addsj['zdy2']=$lxadda;
								$mapsja['sj_data']=json_encode($new_addsj,true);
								$mapsja['sj_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
								$mapsja['sj_fz']=cookie('user_id');
								$mapsja['sj_bm']=$userc[$mapsja['sj_fz']]['department'];
								$mapsja['sj_cj']=cookie('user_id');
								$mapsja['sj_cj_date']=time();
								$sjbasea=M('shangji');
								$sjadda=$sjbasea->add($mapsja);
								

							}
							
						}
				}
	
				
				
			
			
		}
		echo "导入成功";
	
	
	}
		public function chanpin(){
		$map['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$cp_base=M('chanpin');
		$map['cp_del']=0;
		$sql=$cp_base->where($map)->select();
		foreach($sql as $k=>$v)
		{
			$cp_sql='';
			foreach($v as $k1=>$v1){
				if($k1!='cp_data'){
					$cp_sql[$k1]=$v1;
				}else{
					$json=json_decode($v[$k1],true);
					foreach($json as $k2=>$v2){
						$cp_sql[$k2]=$v2;
					}
					
				}
			}$sql_cp[$v['cp_id']]=$cp_sql;
			
		}
		
		return $sql_cp;
	}
	
	public function cp_ajax(){
		$chanpin =$this->chanpin();
		$id=$_GET['id'];
		foreach($chanpin as $k=>$v)
		{
			if($v['cp_id']==$id){
				$yj=$v['zdy2'];
			}
		}
		echo $yj;
	}
	
	public function gongyou(){
		$kh_name=$this->kehu();
		$lx_name=$this->lxr();
						$data['zd_yh']=cookie('user_id');//本人ID                     
		$data['zd_yewu']=5;//所属模块
		$yewuziduan_base=M('yewuziduan');
		$ywzd_sql=$yewuziduan_base->where($data)->field("zd_data")->find();        //添加商机 查询
		$ywzd_sql_json=json_decode($ywzd_sql['zd_data'],true);
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		//var_dump($new_array);exit;
		
		$ywcs_base=M('ywcs');
		$ywcs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$ywcs['ywcs_yw']=5;
		$ywcs_sql=$ywcs_base->where($ywcs)->field('ywcs_data')->find();
		$ywcs_json=json_decode($ywcs_sql['ywcs_data'],true);                          //获取商机配置表参数
		$sj_base=M('shangji');
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userarr=$sj_base->query("select * from crm_shangji where sj_yh='$map' and sj_fz IN ($xiaji)");// 查询商机信息
		foreach($ywcs_json as $kcs => $vcs)
		{
			foreach($vcs['qy'] as $kqy=>$vqy)
			{
				if($vqy=='1')
				{
					$cs_new[$kqy]=$vcs[$kqy];
				}
			}
			$new_ywcs[$vcs['id']]=$cs_new;            //获取到启用了的参数
		}
	

		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
	//echo "<pre>";
		//var_dump($dpt_arr);exit;
		$fuzeren=M('user');
	 	$fuzeren_sql=$fuzeren->select();//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
					}
						
				}
			}  
	
		foreach($userarr as $k=>$v)
		{
			foreach($v as $kk=>$vv)
			{
				if($kk!='sj_data')
					if($kk=="sj_fz")
					{
						$ronghe[$k][$kk]=$fzr_only[$vv]["user_name"];
					}elseif($kk=="sj_bm")
					{
						$ronghe[$k][$kk]=$dpt_arr[$vv]["bm_name"];
					}else{
						$ronghe[$k][$kk]=$vv;
					}
					
				else
				{
					$rowjson=json_decode($vv,true);
					foreach($rowjson as $kkk=>$vvv)
					{	

						if($new_ywcs[$kkk]!="")
						{
							$ronghe[$k][$kkk]=$new_ywcs[$kkk][$rowjson[$kkk]];   //下拉框 关联表的匹配
	
						}else{
							if($kkk=="zdy1")
							{
								$ronghe[$k][$kkk]=$kh_name[$vvv]['name'];         //匹配客户名字
								$ronghe[$k]['kh_id']  = $vvv;     
							}else{
								$ronghe[$k][$kkk]=$vvv;
							}
						}
						

						

					}
				}
			}
		}

	
		
		$array_jiansuo=array('sj_qiandan'=>"签单可能性",'sj_new_gj'=>"最新跟进记录",'sj_sj_date'=>"实际跟进时间",'sj_fz'=>"负责人",'sj_bm'=>"部门",'sj_cj'=>"创建人",'sj_cj_date'=>"创建时间","sj_gx_date"=>"更新时间");
				foreach($array_jiansuo as $k=>$v){
						$new_str1['id']=$k;
						$new_str1['name']=$v;
						$new_str1['qy']=1;
						$new_str1['type']=0;
						$new_arrayoo[]=$new_str1;
					}

		$kh_biaoti1=array_merge_recursive($ywzd_sql_json,$new_arrayoo);//客户标题名字
		foreach($kh_biaoti1 as $k=>$v)
		{
			$biaoti[$v['id']]=$v;             //给标题数组赋值键
		}

//echo "<pre>";
//var_dump($ronghe);exit;
		foreach ($ronghe as $k =>$v)    
		{
			$id=$v['sj_id'];
			$kh_mc=$v['zdy1'];
			$kh_id=$v['kh_id'];
			$show.="<tr>";
			$show.="
				<td >
				<input type='checkbox' class='chbox_duoxuan' id='".$v['sj_id']."'>".$v['sj_id']."
				</td>";
			foreach($biaoti as $k1=>$k2)
			{
				if($v[$k1]!="")
				{
					if($k1=="zdy0")    //商机标题  跳转到商机页面
					{ 
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Shangjimingcheng/shangjimingcheng/id/$id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy1"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Kehu/kehumingcheng/id/$kh_mc/kh_id/$kh_id'>".$v[$k1]." </a></td>"	;
					}elseif($k1=="zdy2"){     //k客户标题 跳转到客户页面
						$show.="<td> <a href='".$_GET['root_dir']."/index.php/Home/Lianxirenmingcheng/lianxirenmingcheng/id/".$v[$k1]."'>".$lx_name[$v[$k1]]['name']." </a></td>"	;
					
					}else{
						$show.="<td> ".$v[$k1]." </td>"	;
					}
				}else{
					$show.="<td> ---- </td>"	;
				}
			}
			$show.="</tr>";                                          //显示商机信息模板
		}
					
					return $show;;
	}
	public function add(){
		$yzdl=A('DB');
		$yzdl->is_login();
		$yzdl->have_qx("qx_sj_open");//跳转权限验证
		$a=$_GET['id'];

		$new_number=substr($a,0,strlen($a)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
	//	echo $ex['0'];
			if($ex['0']=="fuzeren")
			{
				$data['sj_fz']=$ex['1'];
			}elseif($ex['0']=="department")
			{
				$data['sj_bm']=$ex['1'];
			}
			elseif($ex['0']!="xiaodan")
			{
				$ex1[$ex['0']]=$ex['1'];
			}
			

		}
		
		$data["sj_data"]=json_encode($ex1,true);
		$data["sj_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["sj_cj"]=cookie('user_id');//本人ID  
		$data["sj_cj_date"]=time();
		$sj_base=M('shangji');
		$add_sj=$sj_base->add($data);
		if($add_sj){
						//以下方法不好 需要完善
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$dat['sj_id']=$add_sj;
					$sql_add=$cp_sj_base->where($sql)->save($dat);
					//echo "<pre>";
					//var_dump($sql);exit;
			
	}
	}
	public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("quanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0' and  user_act!='0'");
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
			return $nowloginid;
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
	public function del_shangji(){
			$yzdl=A('DB');
			$yzdl->is_login();
			$yzdl->have_qx("qx_sj_del");//跳转权限验证
			$mapid=$_GET['id'];
			$shangjidel_base=M('shangji');
			$sql_del=$shangjidel_base->query("delete from `crm_shangji` where `sj_id` in ($mapid)");
		
			
	}
	public function pl_bianji(){
			$yzdl=A('DB');
			$yzdl->is_login();
			$yzdl->have_qx("qx_sj_open");//跳转权限验证
			$id=$_GET['id'];
			$id=substr($id,0,strlen($id)-1); //id
			//$id="5,6";
			$ziduan=$_GET['ziduan'];//zdy123445
		
			$content=$_GET['content'];//修改内容
		//	echo $id;
			$kehu_base=M('shangji');
			$sql=$kehu_base->query("select * from `crm_shangji` where `sj_id` in ($id)");
			foreach($sql as $k => $v)
			{
				$json=json_decode($v['sj_data'],true);
			
				foreach($json as $k1=>$v2)
				{
					if($ziduan == $k1 )
					{
						$json[$k1]=$content;
						$da=$json;//data替换完成
						$map['sj_id']=$v['sj_id'];//条件
						$data['sj_data']=json_encode($da,true);//修改内容
						$data['sj_gx_date'] = date('Y-m-d H:i:s');//更新时间
						$save=$kehu_base->where($map)->save($data);
						if($save){
							
						}
					}
				}
			
				
			}
			

	}
	public function pl_zhuanyi(){
		$yzdl=A('DB');
		$yzdl->is_login();
		$yzdl->have_qx("qx_sj_open");//跳转权限验证
		$fuzeren=$_GET['id']; 
		$rz_fuzeren=$_GET['ziduan']; 
		$sj_id=$_GET['sj_id']; //商机ID          //负责人ID
		$id=substr($sj_id,0,strlen($sj_id)-1); //id
		$map['sj_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$data['sj_fz']=$fuzeren;
		$idex=explode(",",$id);
		$sj_base=M('shangji');
		$kh = $_GET['kh'];
		$ht=$_GET['ht'];
		$ht_base=M('hetong');
		$data_ht=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$userarr=$ht_base->where($data_ht)->select();

			foreach($userarr as $v3)
			{
				foreach($v3 as $k1 =>$v1)
				{
					if($k1!='ht_data')
					{
						$ht_sql[$k1]=$v1;
					}else{
						$ht_json=json_decode($v3[$k1],true);
						foreach($ht_json as $k2=>$v2)
						{
							$ht_sql[$k2]=$v2;
						}
					}
					$ht_sql2[$v3['ht_id']]=$ht_sql;
				}
				
			}
		foreach($idex as $k=>$v){
			$map['sj_id']=$v;
			

			$data['sj_gx_date'] = date('Y-m-d H:i:s');//更新时间
			$sql_save=$sj_base->where($map)->save($data);
			$sql_sel=$sj_base->where($map)->find();
			$sj_idid=json_decode($sql_sel['sj_data'],true);//解析json
			if($sql_save){
				if($kh=="ok"){
					$map_kh['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //所属公司
					$map_kh['kh_id']=$sj_idid['zdy1'];
					$where_kh['kh_fz']=$fuzeren;
					$base_kh=M('kh');
					$save_kh=$base_kh->where($map_kh)->save($where_kh);
				}
				if($ht=="ok")
				{
				
					
						$map_ht['ht_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
						foreach($ht_sql2 as $k4=>$v4)
						{
							if($v4['zdy2']==$map['sj_id'])
							{
								$map_ht['ht_id']=$v4['ht_id'];
								$save_ht['ht_fz']=$fuzeren;
								$save_sqlht=$ht_base->where($map_ht)->save($save_ht);
								
							}
						}
				}
			}

		}
		
	}
	public function ceshia(){
	
	}
	
	public function lxr_get(){
		$a=$_GET['id'];
		
			$lxr_base=M('lx');
	 		$yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
	 		$tiaojian='"zdy1":"'.$a.'"';
	 		$tiaojian1='"zdy1":'.$a.'';
			$sql=$lxr_base->query("select * from crm_lx where lx_yh = '$yh' and (lx_data like '%$tiaojian%' or lx_data like '%$tiaojian1%' )");



		
		foreach($sql as $k=>$v)
		{
			foreach($v as $k1=>$v1)
			{
				if($k1!="lx_data")
				{
					$new_sql[$k1]=$v1;
				}else{
					$json_sql=json_decode($v[$k1],true);
							//  json_decode($ywzd_sql['zd_data'],true);
							
					foreach($json_sql as $kjson=>$vjson)
					{
						$new_sql[$kjson]=$vjson;
					}
				}
				
			}
			$new_lx[]=$new_sql;
		}

		foreach($new_lx as $k=>$v)
		{
			if($v['zdy1']==$a)
			{	
				$lx_arr['id']=$v['lx_id'];
				$lx_arr['name']=$v['zdy0'];
				$lx_end[$v['zdy0']]=$lx_arr;
			}
		}
		$table.="<select name='zdy2' style='width:300px;height:30px;'>";
		foreach($lx_end as $k=>$v)
		{
			$table.="<option value='".$v['id']."'>".$v['name']."</option>";
		}
		$table.="</select>";	


			echo $table;
	
		
		
	}
	public function add_cp(){
		$id=$_GET['id'];
		//$id= "cp_id:58,cp_yj:6666,cp_jy:6666,cp_num1:1,cp_zk:100.0%,cp_zj:6666,cp_beizhu:		7";
		$ex=explode(',',$id);
		foreach($ex as $v)
		{
			$a=explode(":",$v);
			$sql[$a['0']]=$a['1'];
		}
		$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
		$sql['sj_id']='0'; 
		$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
		$cp_sj_base=M('cp_sj');
		$sql_add=$cp_sj_base->add($sql);
		if($sql_add){
			$map['cp_sj_cj']=$sql['cp_sj_cj'];
			$map['cp_yh']=$sql['cp_yh'];
			$map['sj_id']=$sql['sj_id'];
			$sql_cp_cha=$cp_sj_base->where($map)->select();
			$chanpin=$this->chanpin();
		//	echo "<pre>";
			//var_dump($sql_cp_cha);exit;
			foreach($sql_cp_cha as $v)
			{
					 $table1.="<tr  class='".$v['cp_id1']."'>
		  				<td >".$chanpin[$v['cp_id']]['zdy0']."</td>
		  				<td >".$v['cp_yj']."</td>
		  				<td >".$v['cp_jy']."</td>
		  				<td >".$v['cp_num1']."</td>
		  				<td >".$v['cp_zk']."</td>
		  				<td >".$v['cp_zj']."</td>
		  				<td ><input type='button' value='删除' onclick='cp_del(this)' name='".$v['cp_id1']."' ></td>
					</tr> ";
			}
			echo $table1;
			 						
		} else{
			echo "2";
		}
	
		}	
			public function cp_del(){
				$id['cp_id1']=$_GET['id'];
				$cp_sj_base=M('cp_sj');
				$sql_del=$cp_sj_base->where($id)->delete();
				if($sql_del){
					echo "1";
				}else{
					echo "2";
				}
			}
			public function del_all(){
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$sql_add=$cp_sj_base->where($sql)->delete();
			}	
			public function get_bm(){
			$id=$_GET['id'];
			$user=$this->user();
			//echo "<pre>";
			//var_dump($user);exit;
				$jw.="<input type='text' name='ht_department' disabled value='".$user[$id]['department']."' > ";
				
			echo $jw;
	}

	public function user(){                 //负责人和部门
		$xiaji= $this->get_xiashu_id();// 
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
	 	$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门ddddddd
		}

		$fuzeren=M('user');
		
	
		
			$map['user_id']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
	
	 	$fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id IN ($xiaji)");//缺少条件
			foreach ($fuzeren_sql as $k=>$v)
			{
				foreach ($new_array as $k1=>$v1)
				{
					if($v['user_id']==$v1)
					{
						$new_fuzeren['user_id']=$v['user_id'];
						$new_fuzeren['user_name']=$v['user_name'];
						$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
						$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
						$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
					}
						
				}
			}  
//echo "<pre>";
//var_dump($fzr_only);exit;
return $fzr_only;



	}
	public function user1(){                 //负责人和部门
		
			 $department=M('department');
			$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
				//echo $dpmet['bm_company'];exit;
			$sql_de=$department->where($dpt)->select();
			foreach($sql_de as $kdpt => $vdpt)
			{
				
				$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
			}
	
	
			$fuzeren=M('user');
			
				$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）;
		
			 $fuzeren_sql=$fuzeren->query("select * from  crm_user where  user_id = $map or user_fid=$map");//缺少条件
				foreach ($fuzeren_sql as $k=>$v)
				{
					
						
							$new_fuzeren['user_id']=$v['user_id'];
							$new_fuzeren['user_name']=$v['user_name'];
							$new_fuzeren['user_zhu_bid']=$v['user_zhu_bid'];
							$new_fuzeren['department']=$dpt_arr[$v['user_zhu_bid']]['bm_name'];
							$fzr_only[$v['user_id']]=$new_fuzeren;       //负责人
						
					
				} 
		
				
	return $fzr_only;
		}
	public function lxr(){
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$new_xiaji=$xiaji;          
		$new_array=explode(',',$new_xiaji);
		$kh_base=M('lx');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_lx where lx_yh='$map' and lx_cj IN ($xiaji) and lx_gonghai=0");
		
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['lx_data'],true);
			
					$lx['id']=$vkh['lx_id'];
					$lx['name']=$kh_json['zdy0'];
					$lx['kh_id']=$kh_json['zdy1'];
					$lx_name[$vkh['lx_id']]=$lx;
		}
		
		return $lx_name;
	}
	public function lxr1(){
		
		$kh_base=M('lx');
		$map=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		$kh_sql=$kh_base->query("select * from  crm_lx where lx_yh='$map'  and lx_gonghai=0");
		
		foreach($kh_sql as $kkh =>$vkh)
		{
			$kh_json=json_decode($vkh['lx_data'],true);
			
					$lx['id']=$vkh['lx_id'];
					$lx['name']=$kh_json['zdy0'];
					$lx['kh_id']=$kh_json['zdy1'];
					$lx_name[$vkh['lx_id']]=$lx;
		}
		
		return $lx_name;
	}
	public function lianxiren(){           // 6 月26确定暂时没用的方法
		$ywzd= $this->ywzd();    //业务字段信息 
		$kh_name= $this->kehu();    //业务字段信息 
	//	echo "<pre>";var_dump($kh_name);exit;
		$dpt_arr= $this->department();    //部门字段信息 
	
																	//联系人标题
		
		//echo "<pre>";
		//var_dump($ywzd);exit;
		foreach($ywzd as $kywzd=>$vywzd)
		{
			if($vywzd['qy']==1)
			{
				if($vywzd['bt']==1)
				{	
				
					if($vywzd['type']==3)
					{
						if($vywzd['id']=='zdy1')
						{
						
						}
					}elseif($vywzd['type']==2){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text'  class=' required1 text ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."  name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
					}elseif($vywzd['type']==1){	
						$add_yw.="<tr class='addtr nncy' data-toggle='distpicker' style='overflow:hidden'>";
						$add_yw.="<td>".$vywzd['name'].":</td><td class='form-group' style='width:80%;'>";
						$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			          	$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
			         	$add_yw.="<select name='".$vywzd['id']."[]' class='form-control'   ></select>";
		 				$add_yw.="</td></tr>";
					}else{
						if($vywzd['id']=='zdy2'){
							$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input class='required1' checked='checked'  name='".$vywzd['id']."' type='radio' value='男' style='width:30px'/>男<input name='".$vywzd['id']."' class='required1'  type='radio' value='女' style='width:30px'/>女</td>";
						$add_yw.="</tr>";
						}elseif($vywzd['id']=='zdy5'){
								$add_yw.="<tr class='addtr'><td><span style='color:red'>*</span>".$vywzd['name'].":</td>";
								$add_yw.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkpa(this,this.value)' name='".$vywzd['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodiana' name='".$vywzd['id']."' maxlength='40'></td></tr>";	
						
						}elseif($vywzd['id']=='zdy6'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'  class='required1 qingyx1' onchange='sjyz(this)'  id='lxr".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
						}elseif($vywzd['id']=='zdy15'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'." name='".$vywzd['id']."'></td>";
						$add_yw.="</tr>";
						}elseif($vywzd['id']=='zdy16'){
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><textarea name='".$vywzd['id']."' class='required' maxlength='400' style='width:300px' rows='4' cols='38' placeholder='最大长度400'></textarea></td>";
						$add_yw.="</tr>";
						}else{
						$add_yw.="<tr class='addtr'>";
						$add_yw.="<td><span style='color:red'>*</span>".$vywzd['name'].":</td> <td><input type='text' name='".$vywzd['id']."'  class='required1'   id='lxr".$vywzd['id']."' maxlength='40'></td>";
						$add_yw.="</tr>";
						}
					}
		
				}
			}
		}
		
	echo $add_yw;
		$this->assign('add_yw',$add_yw);

		
	//	$this->display();
  
	}
	public function ywzd(){                               //业务字段表--联系人
		$ywzd_base=M('yewuziduan');
		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件
		$map['zd_yewu']=4;
		$sql_ywzd=$ywzd_base->where($map)->find();
		$sql_json=json_decode($sql_ywzd['zd_data'],true);
		return $sql_json;
	}
	public function department(){                                   //部门表查询
		$department=M('department');
		$dpt['bm_company']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
			//echo $dpmet['bm_company'];exit;
		$sql_de=$department->where($dpt)->select();
		foreach($sql_de as $kdpt => $vdpt)
		{
			
			$dpt_arr[$vdpt['bm_id']]= $vdpt;             //得到部门
		}
		return $dpt_arr;
	}
	 public function kehu_add(){
    	$xiaji= $this->get_xiashu_id();//  查询下级ID
    	$lxr=$this->lxr();
    $kehu_name= $this->kehu();
 //   echo "<pre>";
 //   var_dump($kehu_name);exit;
		$user=$this->user();
  		$a=M('yewuziduan');                      //新增客户所需字段     
  		$map['zd_yewu']="2";
  		$map['zd_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//这里通过查询获得
  		$sql=$a->where($map)->field('zd_data')->find();
		$a_arr=json_decode($sql['zd_data'],true);
		foreach($a_arr as $k=>$v)
		{	if($v['qy']==1){
			$canm[$v['id']]=$v;
			}
		}
		$ywcs=M('ywcs');                 //获取ywcs表中的 数据
 		$yw_cs['ywcs_yw']="2";
 		$yw_cs['ywcs_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
 		$ywcs_sql=$ywcs->where($yw_cs)->field('ywcs_data')->find();
 		$ywcs_sql_json=json_decode($ywcs_sql['ywcs_data'],true);
 		foreach($ywcs_sql_json as $kywcs=>$vywcs)
			{
				$ywcs_new[$vywcs['id']]=$vywcs;
			}
			
		foreach($ywcs_new as $k=>$v)
		{
			foreach($v['qy'] as $k1=>$v1)
			{
				if($v1==1){
					$ywcs_wys[$k1]=$v[$k1];
				}

			}
			$ywcs_wysend[$k]=$ywcs_wys;
		}
		foreach($a_arr as $k2=>$v2){
			if($v2['qy']=="1"){

				$qy_arr=$v2;
				$new_qy[]=$qy_arr;
			}
		}
		$a_arr=$new_qy;
		//echo "<pre>";var_dump($a_arr);exit;
		foreach($a_arr as $k=>$v)
		{
			if($v['bt']==1)
			{
				if($v['id']=="zdy1" || $v['id']=="zdy9" || $v['id']=="zdy10" || $v['id']=="zdy11" || $v['id']=="zdy12")
				{
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><select  class='required1' name='".$v['id']."'>";
							$show_bt.="<option value=''>--请选择--</option>";
						foreach($ywcs_wysend[$v['id']] as $k=>$v)
						{
							$show_bt.="<option value='".$k."'>".$v."</option>";
						}
					$show_bt.="<select></td>";	
					$show_bt.="</tr>";
				}elseif($v['id']=='zdy13'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
						$show_bt.="<td><input type='text' name='".$v['id']."'  class='required1 ui-widget-content ui-corner-all' onfocus=".'"WdatePicker({dateFmt:'."'yyyy-MM-dd'".'})"'."></td></tr>";	
				}elseif($v['id']=='zdy6'){
					$show_bt.="<tr class='addtr' data-toggle='distpicker' style='overflow:hidden'>";
					$show_bt.="<td><span style='color:red'>*</span>".$v['name'].":</td><td class='form-group' style='width:80%;'>";

					$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
		          	$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
		         	$show_bt.="<select name='".$v['id']."[]' class='form-control'   ></select>";
	 				$show_bt.="</td></tr>";
				}elseif($v['id']=='zdy15'){
						$show_bt.="<tr class='addtr' ><td><span style='color:red;width:30px'>*</span>".$v['name']."：</td>";
						$show_bt.="<td id='zdy15th'><select  class='required1 xlss2' name='".$v['id']."' id='ss2' >";
								$show_bt.="<option value=''>--请选择--</option>";
									$show_bt.="<option value='add_lxr'>新增联系人</option>";
								foreach($lxr as $k1=>$v1)
								{
									$show_bt.="<option value='".$v1['id']."'>".$v1['name']."(".$kehu_name[$v1['kh_id']]['name'].")</option>";
								}
						
							
						$show_bt.="</select><td></tr>";
					
				}elseif($v['id']=='zdy0'){
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1' id= 'wyszdy0' onkeyup='kh_name_if(this)' name='".$v['id']."' maxlength='40'></td></tr>";	
				}elseif($v['id']=='zdy2'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
						$show_bt.="<td><input  tabindex='1' type='text' size='4' maxlength='4' onkeyup='checkp(this,this.value)' name='".$v['id']."'' style='width:48px'><span style='margin-right:10px;margin-left:10px'>-</span><input type='text' style='width:228px' class='jiaodian' name='".$v['id']."' maxlength='25'></td></tr>";
				}elseif($v['id']=='zdy3'){
						$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1 qingyx'  onchange='yxyz(this)' name='".$v['id']."' maxlength='40'></td></tr>";	
				
				}elseif($v['id']=='zdy14'){
						$show_bt.="<tr class='addtr'>";
						$show_bt.="<td><span style='color:red'>*</span>".$v['name'].":</td> <td><textarea name='".$v['id']."' class='required' maxlength='400' style='width:300px' rows='4' cols='38' class='required1' placeholder='最大长度400'></textarea></td>";
						$show_bt.="</tr>";
					}
				else{
					$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>".$v['name']."：</td>";
					$show_bt.="<td><input type='text'  class='required1' name='".$v['id']."' maxlength='40'></td></tr>";	
				}	
			}
	
						
		}
			$show_bt.="<tr class='addtr'><td><span style='color:red'>*</span>乙方负责人:</td>";
			$show_bt.="<td><select name='kh_fz'  class ='required1'  onchange='kh_bmo(this)'>";
			$show_bt.="<option  value=''>请选择负责人</option>";	
				foreach($user as $k=>$v)
				{
					$show_bt.="<option  value='".$v['user_id']."'>".$v['user_name']."</option>";
				}
			$show_bt.=" </select></td></tr>	";
			$show_bt.="<tr class='addtr '><td>部门:</td>";
			$show_bt.="<td class='khbm_th' ><input type='text' name='kh_bm' disabled value='' > </td>";
		
		  echo 	$show_bt;


    }
    
	public function lxr_if(){ //弹出客户 的联系人判断选择的还是添加的
		$lxr=$this->lxr();
		$id=$_GET['id'];
		if($lxr[$id]=="" || $lxr[$id]==null)
		{
			echo "ok";
		}else{
			echo $lxr[$id]['name'];
		}

	}
	public function add_end(){
		
		$yzdl=A('DB');
		$yzdl->is_login();
		$yzdl->have_qx("qx_sj_open");//跳转权限验证
		$xiaji= $this->get_xiashu_id();//  查询下级ID
		$kehu=$_GET['id'];
		
	//	$kehu="zdy0:￥￥4444444444444,zdy1:￥￥canshu2,zdy2:￥￥2342-4234234,zdy3:￥￥2@qq.com,zdy9:￥￥canshu3,zdy10:￥￥canshu4,zdy13:￥￥2017-12-09,zdy15:￥￥434,kh_fz:￥￥46,ht_department:￥￥技术部,";
		$new_number=substr($kehu,0,strlen($kehu)-1); 
		$new_arr=explode(',',$new_number);
		foreach($new_arr as $k=>$v)
		{
			$ex=explode(":￥￥",$v);
			
			if($ex['0']=="kh_fz")
			{
				$data["kh_fz"]=	$ex['1'];//本人ID  ;
				$aca=$data["kh_fz"];
			}elseif($ex['0']=="ht_department")
			{
				$data["kh_bm"]=$ex['1'];//本人ID ]
			
			}else{
				$ex1[$ex['0']]=$ex['1'];
			}		
		}
	
		$data["kh_data"]=json_encode($ex1,true);
		$data["kh_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$data["kh_cj"]=	cookie('user_id');//本人ID  ;
		$data["kh_cj_date"]=time();//本人ID  ;
		
		//var_dump($data["kh_data"]);
		$kh_base=M('kh');
		$add_kh=$kh_base->add($data);
		if($add_kh)
		{	

			$lxr=$_GET['lxr'];
		//	$lxr="zdy0:wang,zdy2:lxrzdy2,zdy4:lxrzdy4,zdy6:lxrzdy6,zdy10:lxrzdy10,zdy12[]:北京市-北京市市辖区-东城区,";	var_dump($add_kh);
			$lx_base=M('lx');
			if($lxr=="" || $lxr==null)
			{
				$lxr_id=$_GET['lxr_id'];
				$new_xiaji=$xiaji;          
				$new_array=explode(',',$new_xiaji);
				$lx_yh=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$lx_sql=$lx_base->query("select * from  crm_lx where lx_yh='$lx_yh' and lx_id='$lxr_id' and lx_cj IN ($xiaji)");
				$lxr_json=json_decode($lx_sql['0']['lx_data'],true);
				$lxr_json['zdy1']=$add_kh;
				$lxr_map['lx_data']=json_encode($lxr_json,true);
				$lxr_map['lx_cj_date']=time();
				$lxr_map['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$lxr_map['lx_cj']=cookie('user_id');
				$lxr_add=$lx_base->add($lxr_map);
			}else{
				$lxr_number=substr($lxr,0,strlen($lxr)-1); 
				$lxr_ex=explode(',',$lxr_number);
				foreach($lxr_ex as $k=>$v)
				{
					$exv=explode(":￥￥",$v);
					if($exv['0']=="zdy12[]")
					{
					$exv1['zdy12']=$exv['1'];
					}else{
					$exv1[$exv['0']]=$exv['1'];
					}
				}
				$exv1['zdy1']=$add_kh;
				
				$lxr_map1['lx_data']=json_encode($exv1,true);
				$lxr_map1['lx_cj_date']=time();
				$lxr_map1['lx_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$lxr_map1['lx_cj']=cookie('user_id');
				$lxr_add=$lx_base->add($lxr_map1);
				
		
			}
			//修改客户里的联系人
			$sql_save_kh=$kh_base->query("select * from crm_kh where kh_yh ='".$data["kh_yh"]."' and kh_id = '$add_kh' and kh_fz IN ($xiaji) ");

			foreach($sql_save_kh['0'] as $k=>$v)
			{

				if($k=="kh_data")
				{
				
			
					$kh_save_json=json_decode($sql_save_kh['0']['kh_data'],true);
	
					foreach($kh_save_json as $k1=>$v1)
					{
						if($k1!="zdy15")
						{
							$kh_encod[$k1]=$v1;
						}else{
							$kh_encod["zdy15"]=$lxr_add;
						}

					}

				}
			}
			$khu_data['kh_data']=json_encode($kh_encod,true);
			$khu_map['kh_id']=$add_kh;
			$khu_map['kh_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
			$kehu_save=$kh_base->where($khu_map)->save($khu_data);
		//	$lx_sql=$lx_base->query("select * from  crm_lx where lx_yh='$lx_yh' and lx_id='$lxr_id' and lx_cj IN ($xiaji)");
			if($kehu_save)
			{
				$shangji=$_GET['shangji'];
				$shangji_qd=substr($shangji,0,strlen($shangji)-1); 
				$shangji_arr=explode(",", $shangji_qd);
				foreach($shangji_arr as $k=>$v){
					$sj_ex=explode(":￥￥",$v);
					if($sj_ex['0']=="fuzeren")
					{
						$data_sj_map['sj_fz']=$sj_ex['1'];
					}elseif($sj_ex['0']=="department"){
						$data_sj_map['sj_bm']=$sj_ex['1'];
					}elseif($sj_ex['0']!="xiaodan"){
						if($sj_ex['0']=="zdy1")
						{
 						$data_shang['zdy1']=$add_kh;
						}elseif($sj_ex['0']=="zdy2"){
						$data_shang['zdy2']=$lxr_add;
						}else{
						 $data_shang[$sj_ex['0']]=$sj_ex['1'];
						 }
					}
				} 

				$data_sj_map["sj_data"]=json_encode($data_shang,true);
				$data_sj_map["sj_yh"]=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
				$data_sj_map["sj_cj"]=cookie('user_id');//本人ID  
				$data_sj_map["sj_cj_date"]=time();
				$sj_base=M('shangji');
				$add_sj=$sj_base->add($data_sj_map);
			if($add_sj){
						//以下方法不好 需要完善
					$sql['cp_yh']=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid'); //通用条件    
					$sql['sj_id']='0'; 
					$sql['cp_sj_cj']=cookie('user_id'); //通用条件   
					$cp_sj_base=M('cp_sj');
					$dat['sj_id']=$add_sj;
					$sql_add=$cp_sj_base->where($sql)->save($dat);
					echo "成功";
				}else{echo "失败";}

		}
	}
} 
}