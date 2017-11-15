<?php
namespace Home\Controller;
use Think\Controller;


class XiansuoController extends DBController {
	public function index(){
		parent::is_login2(2);
		$fid=parent::get_fid();
		parent::have_qx2("qx_xs_open");
		//业务参数，用于筛选和展示数据
		$ywcs=$this->get_xs_zd_canshu($fid);
		$cs_name=$this->get_cs_name($ywcs);

		//业务字段查询
		$zdarr=$this->get_xs_ziduan($fid);
		
		//筛选的参数
		$sx_cs=array();
		foreach($cs_name as $k=>$v)
		{
			foreach($v as $kk=>$vv)
				$sx_cs[$k].='<span class="sx_xx" name="'.$kk.'">'.$vv.'</span>';
		}
		//用户对应的部门
		$user_bm_arr=$this->get_user_bm($fid);
		//部门下拉框
		$bm_option=$this->get_bm_option($fid);
		//创建人，负责人，前负责人下拉框
		$chuangjian_user_option=$this->get_user_option($fid);
		$fuzeren_option=$chuangjian_user_option;
		$qianfuzeren_option=$chuangjian_user_option;

		//筛选设置查询
		$con=M("config");
		$conarr=$con->query("select config_xs_sx_config from crm_config where config_name='".cookie("user_id")."' limit 1");
		$conarr=count($conarr)<1?'1,2,3,4,5':$conarr[0]['config_xs_sx_config'];
		//添加弹出框内容查询
		$px=$this->get_xs_px($fid);
		
		$pxzdarr=$px==''?$zdarr:$this->px_zd($zdarr,$px);

		$add_table_show='';
		$add_table_hide='';
		$search_option='';
		foreach($pxzdarr as $k=>$v)
		{
			$add_table='';
			if($v['qy']!='1')
			{
				continue;
			}
			$search_option.='<option value="'.$k.'">'.$v['name'].'</option>';
			$bt=$v['bt']=='1'?'<span class="redstar">*</span>':'';
			//地区特殊处理
			if($k=='zdy11')
			{
				//加载地区数据文件
				$a=file_get_contents("./Public/index_js_css/datas/area_data.js");
				$a=substr($a,14,-1);
				$a=str_replace("[]",'""',$a);
				$a=json_decode($a,true);
				$opt='';
				foreach($a as $v)
				{
					$opt.='<option value="'.$v['provinceCode'].'">'.$v['provinceName'].'</option>';
				}
				$add_table='<tr id="add_zdy11">
								<td>'.$bt.'地区</td>
								<td>
									<select class="add_diqu">
										<option value="0">请选择省</option>
										'.$opt.'
									</select>
									<select class="add_diqu">
										<option value="0">请选择市</option>
									</select>
									<select class="add_diqu">
										<option value="0">请选择区</option>
									</select>
								</td>
							</tr>';
			}
			else if($k=='zdy4')
			{
				$add_table='<tr id="add_zdy4">
								<td>'.$bt.$v['name'].'</td>
								<td><input type="text" style="width:60px;"><span style="display:inline-block;width:10px;text-align:center;">-</span><input type="text" style="width:280px;float:right;"></td>
							</tr>';
			}
			//备注特殊处理
			else if($k=='zdy17')
			{
				$add_table='<tr class="beizhu" id="add_zdy17">
								<td>'.$bt.$v['name'].'</td>
								<td><textarea class="add_textarea"></textarea></td>
							</tr>';
			}
			//下次跟进时间特殊处理
			else if($k=='zdy16')
			{
				$add_table='<tr id="add_zdy16">
								<td>'.$bt.$v['name'].'</td>
								<td>
									<input class="layui-input" placeholder="请选择下次跟进时间" onclick="layui.laydate({elem: this, istime: true, format: \'YYYY-MM-DD hh:mm\'})">
								</td>
							</tr>';
			}
			//关联自定义参数的特殊处理
			else if($cs_name[$k]!='')
			{
				$tsoption='';
				foreach($cs_name[$k] as $csk=>$csv)
				{
					$tsoption.='<option value="'.$csk.'">'.$csv.'</option>';
				}
				$add_table='<tr id="add_'.$k.'">
								<td>'.$bt.$v['name'].'</td>
								<td>
									<select>
										<option value="0">请选择'.$v['name'].'</option>
										'.$tsoption.'
									</select>
								</td>
							</tr>';
			}
			//其他的都是文本框
			else
			{
				$add_table='<tr id="add_'.$k.'">
								<td>'.$bt.$v['name'].'</td>
								<td><input type="text" ></td>
							</tr>';
			}
			//判断显示在上面还是隐藏
			if($v['bt']=='1'||$v['cy']=='1')
			{
				$add_table_show.=$add_table;
			}
			else
			{
				$add_table_hide.=$add_table;
			}
		}
		$xitong_info='<tr id="add_fuzeren">
								<td>负责人</td>
								<td>
									<select>
										<option value="0">请选择负责人</option>
										'.$chuangjian_user_option.'
									</select>
								</td>
							</tr>';
		
		//下方表格数据
		//配置分页设置
		$page_now=$_GET['page']!=''?$_GET['page']:1;
		$page_size=10;
		$page_db_start=($page_now-1)*$page_size;
		//选项卡选项
		$tab_val=$_GET['main_type']=='to_kh'?'1':'0';

		//筛选
		$sx_1='';
		$sx_2='';
		$sx_3='';
		$sx_4='';
		$sx_5='';
		$sx_6='';
		$sx_7='';
		$sx_8='';
		$sx_9='';
		$sx_10='';
		$sx_11='';
		$sx_12='';
		$sx_13='';
		$sx_14='';
		$sx_15='';
		$xs_search='';
		//----线索来源
		$sx_1=$_GET['xiansuolaiyuan']==''?'':" and xs_data like '%\"zdy15\":\"".$_GET['xiansuolaiyuan']."\"%'";
		//----跟进状态
		$sx_2=$_GET['genjinzhuangtai']==''?'':" and xs_data like '%\"zdy14\":\"".$_GET['genjinzhuangtai']."\"%'";
		//----省
		$sx_3=!$_GET['sheng']?'':" and xs_data like '%\"zdy11\":\"".$_GET['sheng']."%'";
		//----市
		$sx_4=!$_GET['shi']?'':" and xs_data like '%\"zdy11\":\"".$_GET['sheng'].",".$_GET['shi']."%'";
		//----区
		$sx_5=!$_GET['qu']?'':" and xs_data like '%\"zdy11\":\"".$_GET['sheng'].",".$_GET['shi'].",".$_GET['qu']."\"%'";
		//----创建人
		$sx_6=$_GET['chuangjianren']==''?'':" and xs_create_user='".addslashes($_GET['chuangjianren'])."'";
		//----负责人
		$sx_7=!$_GET['fuzeren']?'':" and xs_fz='".addslashes($_GET['fuzeren'])."'";
		//----前负责人
		$sx_8=!$_GET['qianfuzeren']?'':" and xs_qfz='".addslashes($_GET['qianfuzeren'])."'";
		//----我的线索
		$sx_9=$_GET['main_type']=='my'?" and xs_fz='".cookie("user_id")."'":'';
		//----所属部门
		if($_GET['suoshubumen'])
		{
			$bmuser=$this->get_bm_user($_GET['suoshubumen'],$fid);
			$sx_10=" and xs_fz in ($bmuser)";
		}
		
		//----我下属的线索
		$myXsStr=$this->get_xiashu_id();
		if($_GET['main_type']=='my_xs')
		{
			
			$lsstr=substr($myXsStr,1,-1);
			$lsarr=explode("','",$lsstr);
			foreach($lsarr as $k=>$v)
			{
				if($v==cookie("user_id"))
				{
					unset($lsarr[$k]);//去掉我自己的线索
				}
			}
			$my_xs_arr=$lsarr;
			$myxs=implode("','",$my_xs_arr);
			$myxs="'".$myxs."'";
			$sx_11=" and xs_fz in ($myxs)";
		}
		//----实际跟进时间
		if($_GET['shijigenjinshijian']!=''&&$_GET['shijigenjinshijian']!='1')
		{
			//查询跟进表中选中时间跟进的线索id
			$tarr=$this->get_time_mod($_GET['shijigenjinshijian']);
			$tarr['s']=strtotime($tarr['s']);
			$tarr['e']=strtotime($tarr['e']);
			$genjindb=M("crm_xiegenjin");
			$genjinarr=$genjindb->query("select kh_id from crm_xiegenjin where genjin_yh='$fid' and mode_id='1' and add_time>='".$tarr['s']."' and add_time<='".$tarr['e']."' ");
			$genjin_xs_id=array();
			foreach($genjinarr as $v)
			{
				$genjin_xs_id[$v['kh_id']]=$v['kh_id'];
			}
			$genjin_xs_id=implode("','",$genjin_xs_id);
			$genjin_xs_id="'".$genjin_xs_id."'";
			$sx_12=" and xs_id in ($genjin_xs_id)";
		}
		//----创建时间
		if($_GET['chuangjianshijian']!=''&&$_GET['chuangjianshijian']!='1')
		{
			$tarr=$this->get_time_mod($_GET['chuangjianshijian']);
			$sx_13=" and xs_create_time>='".$tarr['s']."' and xs_create_time<='".$tarr['e']."'";
		}
		//----更新于
		if($_GET['gengxinyu']!=''&&$_GET['gengxinyu']!='1')
		{
			$tarr=$this->get_time_mod($_GET['gengxinyu']);
			$sx_14=" and xs_last_edit_time>='".$tarr['s']."' and xs_last_edit_time<='".$tarr['e']."'";
		}
		
		//----下次跟进时间
		if($_GET['xiacigenjinshijian']!=''&&$_GET['xiacigenjinshijian']!='1')
		{
			$tarr=$this->get_time_mod($_GET['xiacigenjinshijian']);

			$xc_xs_arr=parent::sel_more_data("crm_xiansuo","xs_id,xs_data","xs_yh='$fid' and xs_is_del='0'");
			
			$xc_xsid='';
			foreach($xc_xs_arr as $v)
			{
				$j=json_decode($v['xs_data'],true);
				if($j['zdy16']<=$tarr['s']||$j['zdy16']>=$tarr['e'])
				{
					continue;
				}
				$xc_xsid.=$v['xs_id']."','";
			}
			$xc_xsid=substr($xc_xsid,0,-2);
			$xc_xsid="'".$xc_xsid;
			$sx_15=" and xs_id in ($xc_xsid)";
		}
		
		//搜索的筛选开始
		if($_GET['search']!='')
		{
			$searcharr=explode(',',$_GET['search']);
			$xc_xs_arr=parent::sel_more_data("crm_xiansuo","xs_id,xs_data","xs_yh='$fid' and xs_is_del='0'");
			$this->assign("search_input_str",$searcharr[1]);
			foreach($xc_xs_arr as $v)
			{
				$this_xs_json=json_decode($v['xs_data'],true);

				if($searcharr[0]=='zdy14'||$searcharr[0]=='zdy15')
				{
					if(count(explode($searcharr[1],$cs_name[$searcharr[0]][$this_xs_json[$searcharr[0]]]))<2)
					{
						continue;
					}
				}
				else
				{
					if(count(explode($searcharr[1],$this_xs_json[$searcharr[0]]))<2)
					{
						continue;
					}
				}
				$sx_search.=$v['xs_id']."','";
			}
			$sx_search=substr($sx_search,0,-2);
			$sx_search="'".$sx_search;
			$xs_search=" and xs_id in ($sx_search)";
			
		}//搜索筛选结束
		$sx_arr=$sx_1.$sx_2.$sx_3.$sx_4.$sx_5.$sx_6.$sx_7.$sx_8.$sx_9.$sx_10.$sx_11.$sx_12.$sx_13.$sx_14.$sx_15.$xs_search;

		$fzwhere="and xs_fz in ($myXsStr)";
		//echo "xs_yh='$fid' $fzwhere and xs_is_del='0' and xs_is_to_kh='$tab_val' $sx_arr ";die;
		$max_number=parent::sel_more_data("crm_xiansuo","count(xs_id)","xs_yh='$fid' $fzwhere and xs_is_del='0' and xs_is_to_kh='$tab_val' $sx_arr ");
		$max_number=$max_number[0]['count(xs_id)'];
		$max_page=$max_number<=10?1:ceil($max_number/$page_size);

		$xiansuo_arr=parent::sel_more_data("crm_xiansuo","*","xs_yh='$fid' $fzwhere and xs_is_del='0' and xs_is_to_kh='$tab_val' $sx_arr order by xs_id desc limit ".$page_db_start.",".$page_size);
		
		$bottomtable='';
		$bottomtable_have_th=0;
		$bottomtable_th='<th><input type="checkbox"></th>';

		$user_name_arr=$this->option_to_arr($chuangjian_user_option);
		foreach($xiansuo_arr as $v)
		{
			$this_xs_json=array();
			$this_xs_json=json_decode($v['xs_data'],true);
			$diqu_num=$this_xs_json['zdy11'];
			$diqu_num_arr=explode(',',$diqu_num);
			$this_xs_json['zdy11']=$this_xs_json['diquname'];

			$bottomtable.='<tr class="xs_id_'.$v['xs_id'].'">
								<td><input type="checkbox"></td>';
			foreach($pxzdarr as $pxzdk=>$pxzdv)
			{
				if($pxzdv['qy']!='1')
				{
					continue;
				}
				$bottomtable_th.=$bottomtable_have_th==0?'<th>'.$pxzdv['name'].'</th>':'';
				$bottomtable.='<td>'.($cs_name[$pxzdk]==''?$this_xs_json[$pxzdk]:$cs_name[$pxzdk][$this_xs_json[$pxzdk]]).'</td>';
			}

			$zhuankehu_th='';
			$zhuankehu_td='';
			if($_GET['main_type']=='to_kh')
			{
				$zhuankehu_th='<th>转客户时间</th>';
				$zhuankehu_td='<td>'.$v['xs_to_kh_time'].'</td>';
			}
			//系统的一些字段
			$bottomtable_th.=$bottomtable_have_th==0?'<th>负责人</th><th>前负责人</th><th>创建人</th><th>创建时间</th><th>更新于</th>'.$zhuankehu_th:'';
			$bottomtable.='<td>'.$user_name_arr[$v['xs_fz']].'</td><td>'.$user_name_arr[$v['xs_qfz']].'</td><td>'.$user_name_arr[$v['xs_create_user']].'</td><td>'.$v['xs_create_time'].'</td><td>'.$v['xs_last_edit_time'].'</td>'.$zhuankehu_td;

			//parent::rr($user_name_arr);
			$bottomtable.='</tr>';
			$bottomtable_have_th=1;
		}
		if($bottomtable=='')
		{
			$colspan=0;
			foreach($pxzdarr as $pxzdk=>$pxzdv)
			{
				if($pxzdv['qy']!='1')
				{
					continue;
				}
				$bottomtable_th.=$bottomtable_have_th==0?'<th>'.$pxzdv['name'].'</th>':'';
				$colspan++;
			}
			$colspan=$colspan+4;
			$tdtext=$_GET['search']==''?'当前还没有线索，快去<a onclick="getElementById(\'xinzengxiansuo\').click()">添加</a>一条吧':'没有搜索结果';
			$bottomtable_th.=$bottomtable_have_th==0?'<th>负责人</th><th>前负责人</th><th>创建人</th><th>创建时间</th><th>更新于</th>':'';
			$bottomtable='<tr class="noinfo"><td><input type="checkbox" disabled /></td><td></td><td colspan="'.$colspan.'">'.$tdtext.'</td></tr>';
		}



		
		//parent::rr($sx_cs);
		//变量输出--
		//批量转移用户下拉框
		$this->assign("chuangjian_user_option",$chuangjian_user_option);
		//表格上方的搜索下拉框
		$this->assign("search_option",$searcharr[0]!=''?str_replace("value=\"".$searcharr[0]."\"","value='".$searcharr[0]."' selected ",$search_option):$search_option);
		//表格-表头
		$this->assign("table_head",$bottomtable_th);
		//表格-表数据
		$this->assign("table_body",$bottomtable);
		//当前页
		$this->assign("page_now",$page_now);
		//分几页
		$this->assign("max_page",$max_page);
		//添加弹出框变量
		$this->assign("add_table_str",$add_table_show.'<tr><td colspan="2"><div class="add_show_btn">展开更多信息<i class="fa fa-chevron-down" aria-hidden="true"></i></div><td></tr>'.$add_table_hide.$xitong_info);
		//筛选设置
		$this->assign("conarr",$conarr);
		//部门下拉框
		$this->assign("bm_option",($_GET['suoshubumen']?str_replace("value='".$_GET['suoshubumen']."'","value='".$_GET['suoshubumen']."' selected ",$bm_option):$bm_option));
		//创建人，负责人，前负责人下拉框
		$this->assign("chuangjian_user_option",($_GET['chuangjianren']?str_replace("value='".$_GET['chuangjianren']."'","value='".$_GET['chuangjianren']."' selected ",$chuangjian_user_option):$chuangjian_user_option));
		$this->assign("fuzeren_option",($_GET['fuzeren']?str_replace("value='".$_GET['fuzeren']."'","value='".$_GET['fuzeren']."' selected ",$fuzeren_option):$fuzeren_option));
		$this->assign("qianfuzeren_option",($_GET['qianfuzeren']?str_replace("value='".$_GET['qianfuzeren']."'","value='".$_GET['qianfuzeren']."' selected ",$qianfuzeren_option):$qianfuzeren_option));
		//筛选参数
		$this->assign("sx_cs",$sx_cs);
		$this->display();
	}
	//线索详情展示页
	public function xsinfo()
	{
		parent::is_login2(2);
		$fid=parent::get_fid();
		parent::have_qx2("qx_xs_open");
		//业务字段查询
		$zdarr=$this->get_xs_ziduan($fid);
		//业务参数，用于筛选和展示数据
		$ywcs=$this->get_xs_zd_canshu($fid);
		$cs_name=$this->get_cs_name($ywcs);
		//用户下拉框
		$user_option=$this->get_user_option($fid);
		//用户id=>名称数组
		$username_arr=$this->option_to_arr($user_option);
		//部门信息
		$bm_option=$this->get_bm_option($fid);
		$bm_name_arr=$this->option_to_arr($bm_option);
		//用户对应的部门
		$user_bm_arr=$this->get_user_bm($fid);
		$no_gj_html='<div class="no_gj">
						<span class="layui-icon">&#xe64d;</span>
						<div>暂无跟进记录</div>
					</div>';
		//查询本条线索的信息
		$xiansuoid=substr(addslashes($_GET['xs_id']),6);
		if($xiansuoid==''||$xiansuoid=='0')
		{
			echo "<script>window.location='".$_GET['root_dir']."/index.php/Home/Xiansuo/index'</script>";
			die;
		}
		$myXsStr=$this->get_xiashu_id();
		$this_xs_arr=parent::sel_one_data("crm_xiansuo","*","xs_yh='$fid' and xs_fz in ($myXsStr) and xs_id='$xiansuoid'");
		

		$this_json_data=json_decode($this_xs_arr['xs_data'],true);
		foreach($this_xs_arr as $k=>$v)
		{
			if($k=='xs_id'||$k=='xs_data')
			{
				continue;
			}
			$this_json_data[$k]=$v;
		}
		//添加弹出框内容查询
		$px=$this->get_xs_px($fid);
		$pxzdarr=$this->px_zd($zdarr,$px);
		
		$add_table_show='';
		$add_table_hide='';
		$search_option='';
		$xinxi_table='';//左侧的信息表
		foreach($pxzdarr as $k=>$v)
		{
			$add_table='';
			if($v['qy']!='1')
			{
				continue;
			}
			$bt=$v['bt']=='1'?'<span class="redstar">*</span>':'';
			//地区特殊处理
			if($k=='zdy11')
			{
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$this_json_data['diquname'].'</td></tr>';
				//分割地区编号
				$diqu_bianhao_arr=explode(',',$this_json_data['zdy11']);
				
				//加载地区数据文件
				$a=file_get_contents("./Public/index_js_css/datas/area_data.js");
				$a=substr($a,14,-1);
				$a=str_replace("[]",'""',$a);
				$a=json_decode($a,true);
				$opt='';
				$opt2='';
				$opt3='';
				foreach($a as $v)
				{
					if($diqu_bianhao_arr[0]==$v['provinceCode'])
					{
						$sel1='selected';
						$a2=$v['mallCityList'];
						foreach($a2 as $v2)
						{
							if($diqu_bianhao_arr[1]==$v2['cityCode'])
							{
								$sel2='selected';
								$a3=$v2['mallAreaList'];
								foreach($a3 as $v3)
								{
									$sel3=$diqu_bianhao_arr[2]==$v3['areaCode']?'selected':'';
									$opt3.='<option value="'.$v3['areaCode'].'" '.$sel3.' >'.$v3['areaName'].'</option>';
								}
							}
							else
							{
								$sel2='';
							}
							$opt2.='<option value="'.$v2['cityCode'].'" '.$sel2.' >'.$v2['cityName'].'</option>';
						}
					}
					else
					{
						$sel1='';
					}
					
					$opt.='<option value="'.$v['provinceCode'].'" '.$sel1.' >'.$v['provinceName'].'</option>';
				}
				$add_table='<tr id="add_zdy11">
								<td>'.$bt.$v['name'].'</td>
								<td>
									<select class="add_diqu">
										<option value="0">请选择省</option>
										'.$opt.'
									</select>
									<select class="add_diqu">
										<option value="0">请选择市</option>
										'.$opt2.'
									</select>
									<select class="add_diqu">
										<option value="0">请选择区</option>
										'.$opt3.'
									</select>
								</td>
							</tr>';
			}
			else if($k=='zdy4')
			{
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$this_json_data[$k].'</td></tr>';
				$phone=explode("-",$this_json_data[$k]);
				if(count($phone)<2)
				{
					$phone[1]=$phone[0];
					$phone[0]='';
				}
				$add_table='<tr id="add_zdy4">
								<td>'.$bt.$v['name'].'</td>
								<td><input type="text" style="width:60px;" value="'.$phone[0].'"><span style="display:inline-block;width:10px;text-align:center;">-</span><input type="text" style="width:280px;float:right;" value="'.$phone[1].'"></td>
							</tr>';
			}
			//备注特殊处理
			else if($k=='zdy17')
			{
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$this_json_data[$k].'</td></tr>';
				$add_table='<tr class="beizhu" id="add_zdy17">
								<td>'.$bt.$v['name'].'</td>
								<td><textarea class="add_textarea">'.$this_json_data[$k].'</textarea></td>
							</tr>';
			}
			//下次跟进时间特殊处理
			else if($k=='zdy16')
			{
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$this_json_data[$k].'</td></tr>';
				$add_table='<tr id="add_zdy16">
								<td>'.$bt.$v['name'].'</td>
								<td>
									<input class="layui-input" placeholder="请选择下次跟进时间" value="'.$this_json_data[$k].'" onclick="layui.laydate({elem: this, istime: true, format: \'YYYY-MM-DD hh:mm\'})">
								</td>
							</tr>';
				$next_genjin_time=$this_json_data[$k];
			}
			//关联自定义参数的特殊处理
			else if($cs_name[$k]!='')
			{
				
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$cs_name[$k][$this_json_data[$k]].'</td></tr>';
				$tsoption='';
				foreach($cs_name[$k] as $csk=>$csv)
				{
					//右上角修改跟进动态快捷方式数据获取
					if($k=='zdy14')
					{
						$nowdongtai=$this_json_data[$k]==$csk?$csv:$nowdongtai;
						$top_right_dongtai.='<li id="top_right_dongtai'.$csk.'"><a href="#">'.$csv.'</a></li>';
						$xiegenjin_zhuangtai.='<option value="'.$csk.'">'.$csv.'</option>';
					}
					$thisseled=$this_json_data[$k]==$csk?'selected':'';
					$tsoption.='<option value="'.$csk.'" '.$thisseled.'>'.$csv.'</option>';
				}
				$add_table='<tr id="add_'.$k.'">
								<td>'.$bt.$v['name'].'</td>
								<td>
									<select>
										<option value="0">请选择'.$v['name'].'</option>
										'.$tsoption.'
									</select>
								</td>
							</tr>';
				
			}
			//其他的都是文本框
			else
			{
				$xinxi_table.='<tr><td>'.$v['name'].'</td><td>'.$this_json_data[$k].'</td></tr>';
				$add_table='<tr id="add_'.$k.'">
								<td>'.$bt.$v['name'].'</td>
								<td><input type="text" value="'.$this_json_data[$k].'"></td>
							</tr>';
			}
			//判断显示在上面还是隐藏
			if($v['bt']=='1'||$v['cy']=='1')
			{
				$add_table_show.=$add_table;
			}
			else
			{
				$add_table_hide.=$add_table;
			}
		}
		//parent::rr($this_json_data);
		$xitong_info='<tr id="add_fuzeren">
								<td>负责人</td>
								<td>
									<select>
										<option value="0">请选择负责人</option>
										'.str_replace("value='".$this_json_data['xs_fz']."'","value='".$this_json_data['xs_fz']."' selected ",$user_option).'
									</select>
								</td>
							</tr>';
		//查询跟进方式，用于填写跟进记录
		$fangshidb=M("ywcs");
		$fangshiarr=$fangshidb->query("select ywcs_data from crm_ywcs where ywcs_yh='$fid' and ywcs_yw='7' limit 1");
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
		//跟进记录的查询
		$genjinarr=parent::sel_more_data("crm_xiegenjin","genjin_id,user_id,type,content,date,add_time","mode_id='1' and genjin_yh='$fid' and kh_id='$xiansuoid' order by add_time desc");
		$genjin_str='';
		if(count($genjinarr)>0)
		{
			$nextdate='';
			foreach($genjinarr as $v)
			{
				$v['date']=date("Y-m-d H:i",$v['date']);
				$v['add_time']=date("Y-m-d H:i",$v['add_time']);
				$add_time_date=substr($v['add_time'],0,10);
				$add_time_time=substr($v['add_time'],10);
				$genjin_time_html=$add_time_date!=$nextdate?'<div class="gj_head"><div class="gj_head_point"></div><div class="gj_head_date">'.$add_time_date.'</div></div>':'';
				$nextdate=$add_time_date;
				$genjin_str.='<div class="gj_mod">
										'.$genjin_time_html.'
										<div class="gj_body">
											<div class="gj_body_icon"><i class="fa fa-pencil"></i></div>
											<div class="gj_body_content">
												<div class="gj_body_content_head">
													<img src="" class="gj_headimg" />
													<span class="user_name">
													'.$username_arr[$v['user_id']].
													'</span>：<span class="timestyle">'.$add_time_time.'</span><i class="fa fa-caret-right"></i><span class="gj_fangshi">'.$genjinfangshi_name_arr[$v['type']].'
													</span>
													<span class="gj_body_content_shiji_time"><a onclick="del_gj('.$v['genjin_id'].')" class="uk-icon-hover uk-icon-trash"></a></span>
												</div>
												<div class="gj_body_content_content">'.$v['content'].'</div>
												<div class="gj_body_content_time">下次跟进时间：'.$v['date'].'</div>
												<div class="gj_body_content_from">来自线索：'.$this_json_data['zdy0'].'</div>
												<div class="gj_body_content_button">
													<button class="layui-btn layui-btn-primary">评论</button>
												</div>
											</div>
										</div>
									</div>';
			}
			$genjin_str.="<div class='gj_no_more'>没有更多了</div>";

		}
		else
		{
			$genjin_str=$no_gj_html;
		}
		
		//线索附件的查询
		$xsfile=parent::sel_more_data("crm_xiansuo_file","*","xsf_xs_id='$xiansuoid'");
		$fjtable='';
		foreach($xsfile as $v)
		{
			$fjtable.="<tr>
						<td>".$v['xsf_upload_time']."</td>
						<td title='".$v['xsf_old_name']."'>".(mb_strlen($v['xsf_old_name'])>20?mb_substr($v['xsf_old_name'],0,20).'...':$v['xsf_old_name'])."</td>
						<td>".$v['xsf_size']."</td>
						<td title='".$v['xsf_bz']."'>".(mb_strlen($v['xsf_bz'])>20?mb_substr($v['xsf_bz'],0,20).'...':$v['xsf_bz'])."</td>
						<td><a onclick='file_xiazai(".$v['xsf_id'].")'>下载</a><a onclick='file_shanchu(".$v['xsf_id'].")'>删除</a></td>
						</tr>";
		}
		$fjtable=$fjtable==''?'<tr class="fujian_no_data"><td colspan="5" style="text-align:center;">没有数据</td></tr>':$fjtable;
		

		//变量映射
		//写跟进-当前时间
		$this->assign("xiegenjin_now_time",date("Y-m-d H:i",time()));
		$this->assign("genjinfangshi_option",$genjinfangshi_option);
		$this->assign("tingxingshuikan",$user_option);
		$this->assign("xiegenjin_zhuangtai",$xiegenjin_zhuangtai);
		$this->assign("genjin_str",$genjin_str);

		//左上角标题和负责人
		$this->assign("title_title",$this_json_data['zdy0']);
		$this->assign("title_fuzeren",$username_arr[$this_json_data['xs_fz']]);
		//右上角快捷修改状态
		$this->assign("nowdongtai",($nowdongtai==''?'--':$nowdongtai));
		$this->assign("next_genjin_time",$next_genjin_time);
		$this->assign("top_right_dongtai",$top_right_dongtai);
		//基本信息
		$this->assign("xinxi_table",$xinxi_table);
		//系统信息
		$this->assign("xt_fuzeren",$username_arr[$this_json_data['xs_fz']]);
		$this->assign("xt_suoshubumen",$bm_name_arr[$user_bm_arr[$this_json_data['xs_fz']]]);
		$this->assign("xt_chuangjianshijian",$this_json_data['xs_create_time']);
		$this->assign("xt_gengxinyu",$this_json_data['xs_last_edit_time']);
		$this->assign("xt_chuangjianren",$username_arr[$this_json_data['xs_create_user']]);
		$this->assign("xt_qianfuzeren",$username_arr[$this_json_data['xs_qfz']]);
		$this->assign("xt_qianfuzebumen",$bm_name_arr[$user_bm_arr[$this_json_data['xs_qfz']]]);
		
		//添加弹出框变量
		$this->assign("add_table_str",$add_table_show.'<tr><td colspan="2"><div class="add_show_btn">展开更多信息<i class="fa fa-chevron-down" aria-hidden="true"></i></div><td></tr>'.$add_table_hide.$xitong_info);

		//附件
		$this->assign("fjtable",$fjtable);

		//公司名称
		$this->assign("kh_name",$this_json_data['zdy1']);
		//本条线索是否已经转成客户了
		$this->assign("is_to_kh",$this_xs_arr['xs_is_to_kh']);
		//本条线索转客户时的电话
		$this->assign("lxphone",$this_json_data['zdy4']);
		
		$this->display();
	}

	//保存筛选设置
	public function change_sx()
	{
		parent::is_login();
		$sel_str=addslashes($_GET['sel_str']);
		$iscz=parent::sel_more_data("crm_config","*","config_name='".cookie("user_id")."'");
		if(count($iscz))
		{
			parent::edit_one_data("crm_config","config_xs_sx_config",$sel_str,"config_name='".cookie("user_id")."'");
		}
		else
		{
			parent::add_one_data("crm_config",'',"config_xs_sx_config",$sel_str);
		}
		$this->insertrizhi('0','2','修改了筛选设置');
		echo 1;
	}
	//新增线索
	public function add_xs()
	{
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_xs_open");
		$ajax_str=$_POST['ajax_str'];
		if($ajax_str=='')
		{
			echo 0;die;
		}
		$ajax_arr=json_decode($ajax_str,true);
		$fuzeren=$ajax_arr['fuzeren'];
		unset($ajax_arr['fuzeren']);
		$json_str=json_encode($ajax_arr);
		$json_str=str_replace('\\','\\\\',$json_str);
		$nowtime=date("Y-m-d H:i:s",time());
		parent::add_one_data("crm_xiansuo","'','$json_str','".$fuzeren."','','$nowtime','".cookie("user_id")."','$nowtime','0','','$fid','0' ");
		$this->insertrizhi('0','1','新增了线索:'.$ajax_arr['zdy0']);
		echo 1;
	}
	//批量转移线索
	public function change_fuzeren()
	{
		parent::is_login();
		$touser=$_GET['to_user_id'];
		$need_to_user_xs=$_GET['need_to_user_xs'];
		if($touser==''||$need_to_user_xs=='')
		{
			echo 0;
			die;
		}
		parent::have_qx("qx_xs_open");
		$need_to_user_xs="('".str_replace(',',"','",$need_to_user_xs)."')";
		$nowdatetime=date("Y-m-d H:i:s",time());
		$fid=parent::get_fid();
		$xiansuodb=M("crm_xiansuo");
		$xiansuodb->query("update crm_xiansuo set xs_qfz=xs_fz,xs_fz='$touser',xs_last_edit_time='$nowdatetime' where xs_yh='$fid' and xs_id in $need_to_user_xs ");
		$num=explode(',',$_GET['need_to_user_xs']);
		$this->insertrizhi('0','10','批量转移了'.count($num).'条线索');
		echo 1;
	}
	//批量删除
	public function del_more()
	{
		parent::is_login();
		$sel_xs=$_GET['sel_xs'];
		if($sel_xs=='')
		{
			echo 0;
			die;
		}
		parent::have_qx("qx_xs_del");
		$fid=parent::get_fid();
		$sel_xs="('".str_replace(',',"','",$sel_xs)."')";
		$xiansuodb=M("crm_xiansuo");
		$xiansuodb->query("update crm_xiansuo set xs_is_del='1' where xs_yh='$fid' and xs_id in $sel_xs ");
		$num=explode(',',$_GET['sel_xs']);
		$this->insertrizhi('0','3','批量删除了'.count($num).'条线索');
		echo 1;
	}
	//写跟进
	public function add_new_genjin()
	{
		parent::is_login();
		$new_genjin_fangshi=addslashes($_POST['new_genjin_fangshi']);
		$new_genjin_time=addslashes($_POST['new_genjin_time']);
		$new_genjin_content=addslashes($_POST['new_genjin_content']);
		$new_genjin_xiansuo=addslashes($_POST['new_genjin_xiansuo']);
		$new_genjin_zhuangtai=addslashes($_POST['new_genjin_zhuangtai']);
		$new_genjin_next_genjin_time=addslashes($_POST['new_genjin_next_genjin_time']);
		if($new_genjin_next_genjin_time==''||$new_genjin_content==''||$new_genjin_time=='')
		{
			echo '0';
			die;
		}
		$fid=parent::get_fid();
		parent::have_qx("qx_xs_open");
		//修改这条线索的下次跟进时间
		$xiansuoarr=parent::sel_one_data("crm_xiansuo","xs_data","xs_is_del='0' and xs_yh='$fid' and xs_id='$new_genjin_xiansuo'");
		if(count($xiansuoarr)<1)
		{
			echo 0;
			die;
		}
		$xs_arr=json_decode($xiansuoarr,true);
		$xs_arr['zdy16']=$new_genjin_next_genjin_time;
		$xs_arr_json=json_encode($xs_arr);

		$nowtime=date("Y-m-d H:i:s",time());
		parent::edit_more_data("crm_xiansuo","xs_data='".str_replace("\\","\\\\",$xs_arr_json)."',xs_last_edit_time='$nowtime'","xs_is_del='0' and xs_yh='$fid' and xs_id='$new_genjin_xiansuo'");
		//插入跟进表
		$new_genjin_time=strtotime($new_genjin_time);
		$new_genjin_next_genjin_time=strtotime($new_genjin_next_genjin_time);
		parent::add_one_data("crm_xiegenjin","'','1','$new_genjin_xiansuo','".cookie("user_id")."','$new_genjin_fangshi','$new_genjin_content','$new_genjin_next_genjin_time','$new_genjin_time','$fid','',''");
		
		echo 1;
	}
	//右上角修改状态按钮
	public function change_zhuangtai()
	{
		parent::is_login();
		$this_xs_id=addslashes($_GET['this_xs_id']);
		$this_canshu_id=addslashes($_GET['this_canshu_id']);
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_xs_open");
		$this_xs_arr=parent::sel_one_data("crm_xiansuo","xs_data","xs_is_del='0' and xs_yh='$fid' and xs_id='$this_xs_id'");
		$this_xs_arr=json_decode($this_xs_arr,true);
		$this_xs_arr['zdy14']='canshu'.$this_canshu_id;
		$new_json=str_replace("\\","\\\\",json_encode($this_xs_arr));
		$nowtime=date("Y-m-d H:i:s",time());
		parent::edit_more_data("crm_xiansuo","xs_data='$new_json',xs_last_edit_time='$nowtime'","xs_is_del='0' and xs_yh='$fid' and xs_id='$this_xs_id'");
		$this->insertrizhi($this_xs_id,'2','修改了'.$this_xs_arr['zdy0'].'的跟进状态');
		echo 1;
	}
	//编辑线索
	public function edit_xs()
	{
		parent::is_login();
        $fid=parent::get_fid();
		$ajax_str=$_POST['ajax_str'];
		$this_xs_id=addslashes($_POST['this_xs_id']);
		$now_fz=addslashes($_POST['now_fz']);
		if($ajax_str==''||$this_xs_id=='')
		{
			echo 0;
			die;
		}
		parent::have_qx("qx_xs_open");
		$ajax_arr=json_decode($ajax_str,true);
		$fuzeren=$ajax_arr['fuzeren'];
		$qfuze=$ajax_arr['fuzeren']==$now_fz?'':",xs_qfz='$now_fz'";//前负责人的判断
		unset($ajax_arr['fuzeren']);
		$json_str=json_encode($ajax_arr);
		$json_str=str_replace('\\','\\\\',$json_str);
		$nowtime=date("Y-m-d H:i:s",time());
		parent::edit_more_data("crm_xiansuo","xs_data='$json_str',xs_last_edit_time='$nowtime',xs_fz='$fuzeren'$qfuze"," xs_id='$this_xs_id' and xs_yh='$fid' and xs_is_del='0' ");
		$this->insertrizhi($this_xs_id,'2','更新了'.$ajax_arr['zdy0'].'的信息');
		echo 1;
	}
	//线索转客户
	public function xs_to_kh()
	{
		parent::is_login();
		$fid=parent::get_fid();
		parent::have_qx("qx_xs_to_kh");
		$xsid=$_GET['thisxsid'];
		if($xsid==''||$xsid=='0')
		{
			echo 0;
			die;
		}
		//获取本条线索的信息
		$myXsStr=$this->get_xiashu_id();
		$thisxsarr=parent::sel_one_data("crm_xiansuo","*","xs_id='$xsid' and xs_fz in ($myXsStr) and xs_yh='$fid' and xs_is_del='0' and xs_is_to_kh='0' ");
		if(count($thisxsarr)<1)
		{
			echo 0;
			die;
		}
		if($thisxsarr['xs_fz']==''||$thisxsarr['xs_fz']=='0')
		{
			echo 2;
			die;
		}
		$xs_json_arr=json_decode($thisxsarr['xs_data'],true);
		//将本条线索的信息填写到一个新客户中
		/*
		xs-     	kh-
		zdy1		zdy0-公司名称
		zdy4		zdy2-电话
		zdy9		zdy3-邮箱
		zdy10		zdy5-网址
		diquname	zdy6-地区
		zdy14		zdy9-跟进状态
		zdy16		zdy13-下次跟进时间
		zdy17		zdy14-备注
		*/
		$to_kh_data=array(
			"zdy0"=>$_GET['zdy0'],
			"zdy2"=>$xs_json_arr['zdy4'],
			"zdy3"=>$xs_json_arr['zdy9'],
			"zdy5"=>$xs_json_arr['zdy10'],
			"zdy6"=>$xs_json_arr['diquname'],
			"zdy9"=>$xs_json_arr['zdy14'],
			"zdy13"=>$xs_json_arr['zdy16'],
			"zdy14"=>$xs_json_arr['zdy17'],
		);
		//用户对应的部门
		$user_bm_arr=$this->get_user_bm($fid);
		//部门信息
		$bm_option=$this->get_bm_option($fid);
		$bm_name_arr=$this->option_to_arr($bm_option);

		//字段参数
		$csArr=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='7' limit 1");
		$csArr=json_decode($csArr[0]['ywcs_data'],true);
		$cs=array();
		foreach($csArr[0] as $k=>$v)
		{
			if(substr($k,0,6)=='canshu')
			{
				$cs[$k]=$v;
			}
		}

		$this_time=time();
		$this_time_str=date("Y-m-d H:i:s",$this_time);

		$to_kh_data_json=str_replace("\\","\\\\",json_encode($to_kh_data));
		$khdb=M("kh");
		//插入客户
		$khdb->query("insert into crm_kh set kh_data='$to_kh_data_json',kh_fz='".$thisxsarr['xs_fz']."',kh_bm='".$bm_name_arr[$user_bm_arr[$thisxsarr['xs_fz']]]."',kh_cj='".cookie("user_id")."',kh_old_fz='".$thisxsarr['xs_qfz']."',kh_old_bm='".$bm_name_arr[$user_bm_arr[$thisxsarr['xs_fz']]]."',kh_cj_date='$this_time',kh_yh='$fid' ");
		//获得刚才插入的id
		$lastinsert=$khdb->query("select LAST_INSERT_ID()");
		$last_insert_id=$lastinsert[0]['LAST_INSERT_ID()'];//客户id
		//基本信息转化完成后，将跟进记录信息转化
		//跟进记录查询
		$gjarr=parent::sel_more_data("crm_xiegenjin","*","genjin_yh='$fid' and mode_id='1' and kh_id='$xsid' ");
		$to_kh_gj=array();
		$insert_str='';
		if(count($gjarr)>0)
		{
			foreach($gjarr as $v)
			{
				$insert_str.="(null,'2','".$last_insert_id."','".$v['user_id']."','".$cs[$v['type']]."','".$v['content']."','".date("Y-m-d H:i:s",$v['date'])."','".date("Y-m-d H:i:s",$v['add_time'])."','$fid','',''),";
			}
			$insert_str=substr($insert_str,0,-1);
		}
		$genjin_base=M("xiegenjin");
		$genjin_base->query("insert into crm_xiegenjin values $insert_str ");
		//$a=parent::sel_more_data("crm_yewuziduan",'zd_data',"zd_yh='$fid' and zd_yewu='4' limit 1");
		//parent::rr(json_decode($a[0]['zd_data'],true));
		//跟进记录迁移完成--开始添加联系人
		//0:姓名    1:对应客户id    5:电话
		$lxrarr=array(
			"zdy0"=>addslashes($_GET['lxrname']),
			"zdy1"=>$last_insert_id,
			"zdy5"=>addslashes($_GET['lxrphone'])
		);
		$lxrjson=str_replace('\\','\\\\',json_encode($lxrarr));
		$lxrbase=M("lx");
		$lxrbase->query("insert into crm_lx set 
						lx_data='$lxrjson',
						lx_cj='".$_COOKIE['user_id']."',
						lx_cj_date='".time()."',
						lx_yh='$fid'
					");
		//联系人插入完成--需要将刚插入的联系人ID添加到对应的客户中
		//获得刚才插入的联系人ID
		$lastinsert=$lxrbase->query("select LAST_INSERT_ID()");
		$last_insert_lxr_id=$lastinsert[0]['LAST_INSERT_ID()'];//联系人ID
		//将联系人id添加到对应客户中
		$to_kh_data['zdy15']=$last_insert_lxr_id;
		$to_kh_data_json=str_replace("\\","\\\\",json_encode($to_kh_data));
		$khdb->query("update crm_kh set kh_data='$to_kh_data_json' where kh_id='$last_insert_id' and kh_yh='$fid' limit 1");
		//将本条线索的状态改为已转客户
		parent::edit_more_data("crm_xiansuo","xs_is_to_kh='1',xs_to_kh_time='$this_time_str',xs_last_edit_time='$this_time_str'","xs_id='$xsid'");
		$this->insertrizhi($xsid,'11','将 '.$to_kh_data['zdy0'].' 转成客户');
		echo 1;
	}
	//上传线索附件
	public function xs_file()
	{
		//文件保存
        if(count($_FILES['xs_file'])<1)
        {
            echo '{"res":0}';
            die();
		}
		parent::have_qx("qx_xs_open");
		$getFileArr=$_FILES['xs_file'];
        $fid=parent::get_fid();
		$oldname=mb_strlen($getFileArr['name'])>15?mb_substr($getFileArr['name'],0,15).'...':$getFileArr['name'];
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
        $newname=time().$fid.cookie("user_id").'.'.$oldnamehz;
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/xiansuofile/'.$newname);
        if(!file_exists('./Public/xiansuofile/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
       

        echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$oldname.'","oldoldname":"'.$getFileArr['name'].'"}';
	}
	
	//删除旧文件
	public function del_old_file()
	{
		parent::is_login();
		$oldname=$_GET['oldname'];
		if($oldname=='')die;
		unlink('./Public/xiansuofile/'.$oldname);
	}
	//保存线索附件的文件信息
	public function add_xsfile_info()
	{
		parent::is_login();
		$fjbz=$_POST['fjbz'];
		$fjmc=$_POST['fjmc'];
		$fjdx=$_POST['fjdx'];
		$fjxsid=$_POST['fjxsid'];
		$oldoldname=$_POST['oldoldname'];
		if($oldoldname==''||$fjxsid==''||$fjmc==''||$fjdx=='')
		{
			echo 2;
			die;
		}
		parent::have_qx("qx_xs_open");
		$nowtime=date("Y-m-d H:i:s",time());
		parent::add_one_data("crm_xiansuo_file","'','$nowtime','$fjmc','$oldoldname','$fjdx','$fjbz','$fjxsid'");
		$xsname=parent::sel_more_data("crm_xiansuo","xs_data","xs_id='$fjxsid' limit 1");
		$xsname=json_decode($xsname[0]['xs_data'],true);
		$xsname=$xsname['zdy0'];
		$this->insertrizhi($fjxsid,'30','为'.$xsname.'添加附件：'.$oldoldname);
		echo 1;
	}
	//附件下载
	public function fj_download()
	{
		$fjid=$_GET['fjid'];
		parent::is_login();
		$fid=parent::get_fid();

		$as=parent::sel_more_data("crm_xiansuo_file","xsf_name,xsf_old_name","xsf_id='$fjid' limit 1");
		$file=$as[0]['xsf_name'];
		if($file=='')
		{
			die;
		}
		parent::have_qx("qx_xs_open");
		$filename=$as[0]['xsf_old_name'];
		$filepath="./Public/xiansuofile/".$file;
		header("Content-type:application/octet-stream");
		header("Content-disposition:attachment;filename=".$filename.";");
		ob_clean();
		@readfile($filepath);
		die;
	}
	//附件删除
	public function del_fujian()
	{
		parent::have_qx("qx_xs_open");
		$fjid=addslashes($_GET['fjid']);
		$as=parent::sel_more_data("crm_xiansuo_file","xsf_name,xsf_old_name,xsf_xs_id","xsf_id='$fjid' limit 1");
		unlink('./Public/xiansuofile/'.$as[0]['xsf_name']);
		$asd=M("xiansuo_file");
		$asd->query("delete from crm_xiansuo_file where xsf_id='$fjid' limit 1");
		$xsname=parent::sel_more_data("crm_xiansuo","xs_data","xs_id='".$as[0]['xsf_xs_id']."' limit 1");
		$xsname=json_decode($xsname[0]['xs_data'],true);
		$xsname=$xsname['zdy0'];
		$this->insertrizhi($as[0]['xsf_xs_id'],'3','删除了'.$xsname.'的附件：'.$as[0]['xsf_old_name']);
		echo 1;
	}
	//导入线索--上传需要导入的文件
	public function daoru_upload()
	{
		//文件保存
        if(count($_FILES['daoru'])<1)
        {
            echo '{"res":0}';
            die();
		}
		parent::have_qx("qx_xs_open");
		$getFileArr=$_FILES['daoru'];
        $fid=parent::get_fid();
		$oldname=mb_strlen($getFileArr['name'])>25?mb_substr($getFileArr['name'],0,25).'...':$getFileArr['name'];
        $oldnamehz=substr(strrchr($getFileArr['name'], '.'), 1);
		if($oldnamehz!='xls'&&$oldnamehz!='xlsx')
		{
			echo '{"res":2}';
			die;
		}
        $newname=time().$fid.cookie("user_id").'.'.$oldnamehz;
        $ss=move_uploaded_file($getFileArr['tmp_name'],'./Public/xiansuofile/xiansuo_daoru_file/'.$newname);
        if(!file_exists('./Public/xiansuofile/xiansuo_daoru_file/'.$newname))//验证上传是否成功
        {
            echo '{"res":0}';
            die();
        }
        
		$sizestr=$getFileArr['size']>=1048576?round(($getFileArr['size']/1048576),2).'M':round(($getFileArr['size']/1024),2).'K';
       

        echo '{"res":1,"newname":"'.$newname.'","newsize":"'.$sizestr.'","oldname":"'.$oldname.'","oldoldname":"'.$getFileArr['name'].'"}';
	}
	//导入线索--解析文件并插入数据库
	public function daoru_start()
	{
		parent::is_login();
		$filename=$_GET['upname'];
		if($filename=='')
		{
			echo '0';die;
		}
		parent::have_qx("qx_xs_open");
		$hz=substr(strrchr($filename, '.'), 1);
		//获取文件内容
		$daoruClass=A("Filedo");
		$file_content_arr=$daoruClass->getdata("./Public/xiansuofile/xiansuo_daoru_file/".$filename,$hz);
		//查询当前系统中的字段，判断导入的数据是否与系统中的字段对应
		$fid=parent::get_fid();
		$zdarr=parent::sel_more_data("crm_yewuziduan","zd_data"," zd_yh='$fid' and zd_yewu='1' limit 1");
		$zdarr=json_decode($zdarr[0]['zd_data'],true);

		foreach($file_content_arr[1] as $v)
		{
			$file_head[]=$v;
		}
		$k=0;
		foreach($zdarr as $v)
		{
			if($v['qy']!='1')
			{
				continue;
			}
			if($v['id']=='zdy14')
			{
				continue;
			}
			if($v['id']=='zdy15')
			{
				continue;
			}
			if($file_head[$k]!=$v['name'])
			{
				echo '2';die;
			}
			$daorukey[]=$v['id'];
			$k++;
		}
		//字段匹配正确后开始构造sql语句
		//删除表头
		unset($file_content_arr[1]);
		
		$nowtime=date("Y-m-d H:i:s",time());
		$insertdbstr='';
		$cot=0;
		foreach($file_content_arr as $v)
		{
			$dk=0;
			$row_arr=array();
			$kongbai=0;
			$this_row_num=count($v);//本行一共多少列
			foreach($v as $vv)
			{
				$this_td_val=trim($vv);//去除字符串开头和结尾的空格
				if($this_td_val=='')
				{
					$kongbai++;
				}
				$row_arr[$daorukey[$dk]]=$this_td_val;
				$row_str=json_encode($row_arr);
				$dk++;
			}
			//如果本行是空，就不插入
			if($kongbai==$this_row_num)
			{
				continue;
			}
			$cot++;
			$insertdbstr.="('','".str_replace('\\','\\\\',$row_str)."','0','0','$nowtime','".cookie("user_id")."','$nowtime','0','','$fid','0'),";
		}
		$insertdbstr=substr($insertdbstr,0,-1);//去掉最后一个逗号
		if($insertdbstr=='')
		{
			echo 3;
			die;
		}
		
		$xsdb=M("xiansuo");
		$xsdb->query("insert into crm_xiansuo values $insertdbstr ");
		$this->insertrizhi('0','8','导入了'.$cot.'条线索');
		echo 1;
	}
	//导入线索--下载模板
	public function download_mod()
	{
		parent::have_qx("qx_xs_open");
		$fid=parent::get_fid();
		//查询字段
		$zdarr=parent::sel_more_data("crm_yewuziduan","zd_data","zd_yh='3' and zd_yewu='1' limit 1");
		$zdarr=json_decode($zdarr[0]['zd_data'],true);
		$head=array();
		foreach($zdarr as $v)
		{
			if($v['qy']!='1')
			{
				continue;
			}
			if($v['id']=='zdy14')
			{
				continue;
			}
			if($v['id']=='zdy15')
			{
				continue;
			}
			$head[]=$v['name'];
		}
		for($a=0;$a<20;$a++)
		{
			for($b=0;$b<count($head);$b++)
			{
				$data[$a][]=' ';
			}
		}
		$f=A("Filedo");
		$f->getExcel("线索导入模板",$head,$data);
	}
	//删除线索中的跟进记录
	public function delgenjin()
	{
		parent::is_login();
		parent::have_qx("qx_xs_del");
		$fid=parent::get_fid();
		$xsid=addslashes($_GET['xsid']);
		$gjid=addslashes($_GET['gjid']);
		if($xsid==''||$gjid=='')
		{
			echo 0;die;
		}
		$genjin=M("xiegenjin");
		$genjin->query("delete from crm_xiegenjin where genjin_id='$gjid' limit 1");
		//查询线索名称
		$xs=parent::sel_more_data("crm_xiansuo","xs_data","xs_id='".substr($xsid,6)."' limit 1");
		$json=json_decode($xs[0]['xs_data'],true);
		$xsname=$json['zdy0'];
		//parent::rr($json);
		echo $this->insertrizhi('0','3','删除了线索：'.$xsname.'中的跟进记录');
	}
	/*
	======================================
	||									||
	||	    线索模块的一些通用操作函数 	 ||
	||									||		
	======================================
	*/
	//线索字段查询
	protected function get_xs_ziduan($fid)
	{
		$zd=parent::sel_more_data("crm_yewuziduan",'zd_data',"zd_yh='$fid' and zd_yewu='1'");
		$jsondata=json_decode($zd[0]['zd_data'],true);
		foreach($jsondata as $v)
		{
			$returnzd[$v['id']]=$v;
		}
		return $returnzd;
	}
	//线索字段参数查询
	protected function get_xs_zd_canshu($fid)
	{
		$xscs=parent::sel_more_data("crm_ywcs","ywcs_data","ywcs_yh='$fid' and ywcs_yw='1'");
		$jsondata=json_decode($xscs[0]['ywcs_data'],true);
		return $jsondata;
	}
	//处理参数数组，得到参数名称
	protected function get_cs_name($csarr)
	{
		$canshuname=array();
		foreach($csarr as $v)
		{
			foreach($v as $kk=>$vv)
			{
				if(substr($kk,0,6)!='canshu')
				{
					continue;
				}
				if($v['qy'][$kk]!='1')
				{
					continue;
				}
				$canshuname[$v['id']][$kk]=$vv;
			}
			
		}
		return $canshuname;
	}
	//线索字段的排序查询
	protected function get_xs_px($fid)
	{
		$px=parent::sel_more_data("crm_paixu","px_px","px_yh='$fid' and px_mod='1' ");
		return $px[0]['px_px'];
	}
	//获得排序后的字段数组
	protected function px_zd($zd,$px)
	{
		$px_arr=explode(',',$px);
		if(count($px_arr)&&$px!='')
		{
			foreach($px_arr as $k=>$v)
			{
				if($zd[$v]!='')
				{
					$pxzdarr[$v]=$zd[$v];
					unset($zd[$v]);
				}
			}
			foreach($zd as $k=>$v)
			{
				$pxzdarr[$k]=$v;
			}
		}
		else
		{
			$pxzdarr=$zd;
		}
		return $pxzdarr;
	}
	//获得部门下拉内容
    protected function get_bm_option($fid)
    {
        $bm_arr=parent::sel_more_data("crm_department","bm_id,bm_name","bm_company='$fid'");
        foreach($bm_arr as $v)
        {
            $bm_option.="<option value='".$v['bm_id']."'>".$v['bm_name']."</option>";
        }
        return $bm_option;
    }
    //获得用户下拉框内容
    protected function get_user_option($fid)
    {
        $user_arr=parent::sel_more_data("crm_user","user_id,user_name","user_del='0' and user_act='1' and (user_fid='$fid' or user_id='$fid')");
        foreach($user_arr as $v)
        {
            $user_option.="<option value='".$v['user_id']."'>".$v['user_name']."</option>";
        }
        return $user_option;
    }
    //获得用户的部门
    protected function get_user_bm($fid)
    {
        $user_arr=parent::sel_more_data("crm_user","user_id,user_zhu_bid","user_del='0' and (user_fid='$fid' or user_id='$fid')");
        foreach($user_arr as $v)
        {
            $user_bm[$v['user_id']]=$v['user_zhu_bid'];
        }
        return $user_bm;
    }
	//根据用户id获得用户名称
    protected function get_user_id_name($fid)
    {
        $userarr=parent::sel_more_data("crm_user","user_id,user_name","(user_id='$fid' or user_fid='$fid') and user_del='0'");
        foreach($userarr as $v)
        {
            $rarr[$v['user_id']]=$v['user_name'];
        }
        return $rarr;
    }
	//将返回的下拉框处理成数组格式，优化重复查数据库的问题
    protected function option_to_arr($op)
    {
        $c=explode("</option><option value='",$op);
        foreach($c as $v)
        {
            $d=str_replace("<option value='",'',$v);
            $d=str_replace("</option>",'',$d);
            $d=explode("'>",$d);
            $arr[$d[0]]=$d[1];
        }
        return $arr;
    }
	//时间段方法
	public function get_time_mod($num)
	{
		$sj_arr=$t=$t1=$t2='';
		if(strlen($num)<2)
		{
			if($num=='2')
			{
				//今天
				$t=date("Y-m-d",time());
				$t1=$t.' 00:00:00';
				$t2=$t.' 23:59:59';
			}
			else if($num=='3')
			{
				//昨天
				$t=date("Y-m-d",strtotime(date("Y-m-d",time()).' -1 day'));
				$t1=$t.' 00:00:00';
				$t2=$t.' 23:59:59';
			}
			else if($num=='4')
			{
				//本周
				$t1=date("Y-m-d H:i:s",strtotime("Monday"));
        		$t2=date("Y-m-d",strtotime("Sunday")).' 23:59:59';     
			}
			else if($num=='5')
			{
				//上周
				$t1=date("Y-m-d H:i:s",strtotime("-1 week Monday"));
        		$t2=date("Y-m-d",strtotime("-1 week Sunday")).' 23:59:59';   
			}
			else if($num=='6')
			{
				//本月
				$t=date("Y-m",time());
				$t1=$t.'-01 00:00:00';
				$t2=date("Y-m-d",strtotime(date("Y-m",strtotime($t.' +1 month')).'-01 -1 day')).' 23:59:59';  
			}
			else if($num=='7')
			{
				//上月
				$t=date("Y-m",time());
				$t1=date("Y-m",strtotime($t.' -1 month')).'-01 00:00:00';
				$t2=date("Y-m-d",strtotime($t.'-01 -1 day')).' 23:59:59';   
			}
		}
		else
		{
			$t=explode(',',$num);
			$t1=$t[0].' 00:00:00';
			$t2=$t[1].' 23:59:59';
		}
		$sj_arr['s']=$t1;
		$sj_arr['e']=$t2;

		return $sj_arr;
	}
	//获取我的下属
	public function get_my_xs($fid)
	{
		$data=parent::sel_more_data("crm_user","user_id","(user_fid='$fid' or user_id='$fid') and user_zhuguan_id='".cookie("user_id")."' ");
		$arr=array();
		foreach($data as $v)
		{
			if($v['user_id']==cookie("user_id"))
				continue;
			$arr[]=$v['user_id'];
		}
		return $arr;
	}
	//获取该部门下的所有用户
	public function get_bm_user($bmid,$fid)
	{
		$bm_user_arr=parent::sel_more_data("crm_user","user_id","(user_id='$fid' or user_fid='$fid') and user_del='0' and user_act='1' and user_zhu_bid='$bmid' ");
		foreach($bm_user_arr as $v)
		{
			$a[]=$v['user_id'];
		}
		$a=implode("','",$a);
		$a="'".$a."'";
		return $a;
	}
	////
	public function get_xiashu_id()
	{
		$nowloginid=cookie("user_id");
		$nowloginfid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');
		$userbase=M("user");
		$qxbase=M("juesequanxian");
		$bmbase=M("department");
		$userarr=$userbase->query("select * from crm_user where (user_fid='$nowloginfid' or user_id='$nowloginfid') and user_del='0'");
		foreach($userarr as $v)
		{
			$userkeyid[$v['user_id']]=$v;
		}
		$nowloginqx=$userkeyid[$nowloginid]['user_quanxian'];
		$nowloginbid=$userkeyid[$nowloginid]['user_zhu_bid'];

		$qxarr=$qxbase->query("select qx_data_qx from crm_juesequanxian where qx_yh='$nowloginfid' and qx_id='$nowloginqx'");
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
		return "'".implode("','",$nowzgid)."'";
	}
	//插入日志方法
    public function insertrizhi($xsid,$cztype,$con)
    {
        //更新系统日志 	操作时间	操作人员	模块	操作内容	操作设备	操作设备IP
		$xitongrizhibase=M("rz");
		$loginIp=$_SERVER['REMOTE_ADDR'];//IP 
        $fid=cookie('user_fid')=='0'?cookie('user_id'):cookie('user_fid');//获取所属用户（所属公司）
		//登录地点
		$addressArr=getCity($nowip);
		$loginDidianStr=$addressArr["country"].$addressArr["region"].$addressArr["city"];
		$sysbroinfo=getSysBro();//一维数组 sys->系统 bro->浏览器
		//进行插入操作
		$xitongrizhibase->query("insert into crm_rz values('','1','1','".cookie("user_id")."','$xsid','$cztype','0','0','0','$con','$loginIp','$loginDidianStr','".$sysbroinfo['sys'].'/'.$sysbroinfo['bro']."','$fid','".time()."')");

        return '1';
    }
}