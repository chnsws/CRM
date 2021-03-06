<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>控制台</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">
<meta charset="utf-8">
<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
<script src="<?php echo ($_GET['public_dir']); ?>/echarts/echarts.min.js"></script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/main/main.css">

<!--layUI-->
<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
<!--UIkit-->
<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/uikit/css/uikit.almost-flat.min.css" />
<script src="<?php echo ($_GET['public_dir']); ?>/uikit/js/uikit.min.js"></script>

</head>
<body>
<div id="box">
  <div class="main_top">
    <div class="main_left">
      <div class="main_left_top">
        <div class="main_left_top_left">
          <div class="main_left_top_left_top">
            <div class="gonggao_title">最新公告<span class='gonggao_more'>更多>></span></div>
            <div class="gonggao_body">
              <?php echo ($gonggaostr); ?>
            </div>
          </div>
        </div>
        <div class="main_left_top_right">
          <div class="yejimubiao_chart">
            <div class="chart_top_select uk-form">
              <span class="mubiao_title">业绩目标</span>
              <select id="mubiaotime_sel" style="width:80px;">
                <option value="1">本月</option>
                <option value="2">本季度</option>
                <option value="3">今年</option>
              </select>
              <select id="mubiaotype_sel">
                <?php echo ($yjmbselstr); ?>
              </select>
            </div>
            <div id="charts">

            </div>
            <div class="chart_info">
              <div class="chart_info_title"></div>
              <div class="chart_info_title2">已完成</div>
              <div class="chart_info_value"><?php echo ($chart_wancheng2); ?></div>
              <div class="chart_info_title2">目标</div>
              <div class="chart_info_value"><?php echo ($chart_mubiao2); ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="main_left_top_bottom">
        <div class="xiaoshoujianbao">
          <div class="jianbao_head uk-form">
            销售简报
            <select id="jianbao_sel">
              <option value="0">本周</option>
              <option value="1">本月</option>
              <option value="2">本季度</option>
              <option value="3">今年</option>
            </select>
          </div>
          <div class="jianbao_body">
            <div class="jianbao">
              <div>
                <div class="jianbao_icon">
                  <i class="fa fa-money"></i>
                  <span>成交</span>
                </div>
                <div class="jianbao_info">
                  <div>合同数</div>
                  <div>合同总金额</div>
                  <div>已回款金额</div>
                  <div><?php echo ($jianbaoarr[1]); ?></div>
                  <div>￥<?php echo ($jianbaoarr[2]); ?></div>
                  <div>￥<?php echo ($jianbaoarr[3]); ?></div>
                </div>
              </div>
            </div>
            <div class="jianbao">
              <div>
                <div class="jianbao_icon">
                  <i class="uk-icon-line-chart"></i>
                  <span>预测</span>
                </div>
                <div class="jianbao_info">
                  <div>预测签单数</div>
                  <div>预计签单金额</div>
                  <div>计划回款金额</div>
                  <div><?php echo ($jianbaoarr[4]); ?></div>
                  <div>￥<?php echo ($jianbaoarr[5]); ?></div>
                  <div>￥<?php echo ($jianbaoarr[6]); ?></div>
                </div>
              </div>
            </div>
            <div class="jianbao">
              <div>
                <div class="jianbao_icon">
                  <i class="fa fa-plus"></i>
                  <span>新增</span>
                </div>
                <div class="jianbao_info">
                  <div>线索数</div>
                  <div>客户数</div>
                  <div>商机数</div>
                  <div><?php echo ($jianbaoarr[7]); ?></div>
                  <div><?php echo ($jianbaoarr[8]); ?></div>
                  <div><?php echo ($jianbaoarr[9]); ?></div>
                </div>
              </div>
            </div>
            <div class="jianbao">
              <div>
                <div class="jianbao_icon">
                  <i class="fa fa-edit"></i>
                  <span>跟进</span>
                </div>
                <div class="jianbao_info">
                  <div>跟进次数</div>
                  <div><!--拜访签到次数--></div>
                  <div></div>
                  <div><?php echo ($jianbaoarr[10]); ?></div>
                  <div><!--12--></div>
                  <div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main_right">
      <div class="rightdiv">
        <div class="shenpi_btn">
          <button class="layui-btn to_sp" <?php echo ($sp['color']); ?> >待审批&nbsp;(<?php echo ($sp['num']); ?>)</button>
        </div>
        <div class='paihangtitle'>销售排行</div>
        <div class="paimingdiv">
          <div class="sel_mubiao_sel_div uk-form">
            <select id="paihang_sel">
              <?php echo ($yjmbselstr); ?>
            </select>
          </div>
          <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
              <li class="layui-this">本月</li>
              <li>本季度</li>
              <li>今年</li>
            </ul>
            <div class="layui-tab-content">
              <div class="layui-tab-item layui-show">
                <?php echo ($paihang1); ?>
              </div>
              <!--2-->
              <div class="layui-tab-item">
                <?php echo ($paihang2); ?>
              </div>
              <!--3-->
              <div class="layui-tab-item">
                <?php echo ($paihang3); ?>
              </div>
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>
  <div class="main_foot">
    <div class="main_foot_tab">
      <div class="zs_mod">
        <div class="zs_icon">
          <i class="uk-icon-birthday-cake"></i>
          <div>联系人</div>
        </div>
        <div class="zs_body">
          <div>七天内过生日</div>
          <div><?php echo ($zhushou['num'][1]); ?></div>
        </div>
      </div>
    </div>
    <div class="main_foot_tab">
      <div class="zs_mod">
        <div class="zs_icon">
          <i class="uk-icon-group"></i>
          <div>客户</div>
        </div>
        <div class="zs_body">
          <div>超过七天未跟进</div>
          <div><?php echo ($zhushou['num'][2]); ?></div>
        </div>
      </div>
    </div>
    <div class="main_foot_tab">
      <div class="zs_mod">
        <div class="zs_icon">
          <i class="uk-icon-clone"></i>
          <div>合同</div>
        </div>
        <div class="zs_body">
          <div>七天内需要回款</div>
          <div><?php echo ($zhushou['num'][3]); ?></div>
        </div>
      </div>
    </div>
    <div class="main_foot_tab">
      <div class="zs_mod">
        <div class="zs_icon">
          <i class="uk-icon-smile-o"></i>
          <div>敬请期待</div>
        </div>
        <div class="zs_body">
          <div>敬请期待</div>
          <div>敬请期待</div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

<script>
//获取URL的绝对路径
window.root_dir="<?php echo ($_GET['root_dir']); ?>";
layui.use('element', function(){
  var element = layui.element();
});
//初始化
layui.use('layer', function(){
    window.layer = layui.layer;
});
//黑色半透明提示
function tishi(neirong)
{
    layer.msg(neirong, {
        time: 1500, 
        color:"#fff"
    });
}
$(function(){
  
  
  option = {
      tooltip: {
          trigger: 'item'
      },
      color:["#91C7AE","#C23531"],
      legend: {
          data:['已完成','未完成']
      },
      series: [
          {
              type:'pie',
              radius: ['50%', '70%'],
              avoidLabelOverlap: false,
              label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '15',
                        fontWeight: 'bold'
                    }
                }
              },
        
              data:[
                  {value:<?php echo ($chart_wancheng); ?>, name:'已完成'},
                  {value:<?php echo ($chart_mubiao); ?>, name:'未完成'}
              ]
          }
      ]
  };
  
  // 使用刚指定的配置项和数据显示图表。
  
  //  myChart.showLoading();   //加载动画

  //监听业绩目标切换
  $("#mubiaotype_sel").on("change",function(){
    layer.load(2);
    var mubiaotime="<?php echo ($_GET['mubiaotime']); ?>";
    var mubiaotype=$(this).val();
    var mubiaotime_url=mubiaotime==''?'':'&mubiaotime='+mubiaotime;
    window.location=root_dir+"/index.php/Home/Main/index?mubiaotype="+mubiaotype+mubiaotime_url;
  });
  //初始化业绩目标类型显示
  var mubiaotype="<?php echo ($_GET['mubiaotype']); ?>";
  if(mubiaotype!='')
  {
    $("#mubiaotype_sel").find("option[value='"+mubiaotype+"']").prop("selected",true);
  }
  //监听业绩目标时间切换
  $("#mubiaotime_sel").on("change",function(){
    layer.load(2);
    var mubiaotime=$(this).val();
    var mubiaotype="<?php echo ($_GET['mubiaotype']); ?>";
    var mubiaotype_url=mubiaotype==''?'':'&mubiaotype='+mubiaotype;
    window.location=root_dir+"/index.php/Home/Main/index?mubiaotime="+mubiaotime+mubiaotype_url;
  });
  //初始化业绩目标时间显示
  var mubiaotime="<?php echo ($_GET['mubiaotime']); ?>";
  if(mubiaotime!='')
  {
    $("#mubiaotime_sel").find("option[value='"+mubiaotime+"']").prop("selected",true);
  }
  //监听简报时间切换
  $("#jianbao_sel").on("change",function(){
    layer.load(2);
    var thisval=$(this).val();
    window.location=root_dir+"/index.php/Home/Main/index?jianbaotime="+thisval;
  });
  //初始化简报时间显示
  var jianbaotime="<?php echo ($_GET['jianbaotime']); ?>";
  if(jianbaotime!='')
  {
    $("#jianbao_sel").find("option[value='"+jianbaotime+"']").prop("selected",true);
  }
  //监听销售排行目标切换
  $("#paihang_sel").on("change",function(){
    layer.load(2);
    var thisval=$(this).val();
    window.location=root_dir+"/index.php/Home/Main/index?paihangtype="+thisval;
  });
  //初始化销售排行显示
  var paihangtype="<?php echo ($_GET['paihangtype']); ?>";
  if(paihangtype!='')
  {
    $("#paihang_sel").find("option[value='"+paihangtype+"']").prop("selected",true);
  }
  //销售助手按钮监听
  $(".zs_mod").on("click",function(){
    var thisindex=$(this).index(".zs_mod");
    var idstr='';
    var to_url='';
    var findtext='';
    if(thisindex==0)
    {
      idstr="<?php echo ($zhushou['id'][1]); ?>";
      to_url=root_dir+"/index.php/Home/Lianxiren/lianxiren?returnid="+idstr;
      findtext='联系人';
      
    }
    else if(thisindex==1)
    {
      idstr="<?php echo ($zhushou['id'][2]); ?>";
      to_url=root_dir+"/index.php/Home/Kehu/kehu?returnid="+idstr;
      findtext='客户';
    }
    else if(thisindex==2)
    {
      idstr="<?php echo ($zhushou['id'][3]); ?>";
      to_url=root_dir+"/index.php/Home/Hetong/hetong?returnid="+idstr;
      findtext='合同';
    }
    else
    {
      return;
    }
    if(idstr!='')
    {
      var fdom=$('.layui-side-scroll', window.parent.document);
      var khindex='';
      fdom.children("ul").children("li").each(function(){
        var thistext=$(this).children("a").text();
        if(thistext==findtext)
        {
          khindex=$(this).index();
        }
      });
      fdom.children("ul").children("li").eq(khindex).click();
      $('.layui-tab-content', window.parent.document).find(".layui-show").children("iframe").prop("src",to_url);
    }
  });
  //审批跳转
  $(".to_sp").on("click",function(){
    //权限
    var sp_qx="<?php echo ($_COOKIE['qx_sp_open']); ?>";
    if(sp_qx!='1')
    {
      tishi("您当前没有进入审批模块的权限");
      return;
    }
    var need_sp_num="<?php echo ($sp['num']); ?>";
    if(need_sp_num<1)
    {
      return;
    }
    else
    {
      var fdom=$('.layui-side-scroll', window.parent.document);
      var khindex='';
      fdom.children("ul").children("li").each(function(){
        var thistext=$(this).text();
        if(thistext.search('审批')!='-1')
        {
          khindex=$(this).index();
        }
      });
      fdom.children("ul").children("li").eq(khindex).click();
    }
  });
  //更多公告跳转
  $(".gonggao_more").on("click",function(){
    location=root_dir+"/index.php/Home/Option/gonggaoguanli?from=main"
  });
  //页面显示
  setTimeout(function() {
    $("#box").fadeIn();
    var myChart = echarts.init(document.getElementById('charts'));
    myChart.setOption(option);
  }, 100);
});
  
</script>
</html>