<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
            

 


 
 <table>
 <?php if(is_array($list)): foreach($list as $key=>$kkk): ?><tr><td><?php echo ($kkk["user_name"]); ?></td></tr><?php endforeach; endif; ?>
 </table>

<div id="demo7"></div>
 



<script>
layui.use(['laypage', 'layer'], function(){
  var laypage = layui.laypage
  ,layer = layui.layer;
  
 
 
  laypage({
    cont: 'demo7'
    ,pages: 3
    ,skip: true,
    jump: function(obj, first){
      if(!first){
        alert('第 '+ obj.curr +' 页');

      }
  }
  });
  
  
  //将一段数组分页展示
  
  //测试数据
  
  var nums = 7; //每页出现的数据量
  
  //模拟渲染
  var render = function(data, curr){
    var arr = []
    ,thisData = data.concat().splice(curr*nums-nums, nums);
    layui.each(thisData, function(index, item){
      arr.push('<li>'+ item +'</li>');
    });
    return arr.join('');
  };
  
  //调用分页
  laypage({
    cont: 'demo8'
    ,pages: Math.ceil(data.length/nums) //得到总页数
    ,jump: function(obj){
      document.getElementById('biuuu_city_list').innerHTML = render(data, obj.curr);
    }
  });
  
});
</script>

</body>
</html>