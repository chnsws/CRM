<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>客户</title>
		

		<!--jq ui-->
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery/jquery.js"></script>
		<script src="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.js"></script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/jquery-ui/jquery-ui.css">
  		<!--jqui 结束-->
  		<script src="<?php echo ($_GET['public_dir']); ?>/bootstrap/My97DatePicker/WdatePicker.js"'" ></script><!- 时间插件-->
  		<script src="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/layui.js"> </script>
		<link rel="stylesheet" href="<?php echo ($_GET['public_dir']); ?>/index_js_css/plugins/layui/css/layui.css" media="all">
  		
		<style>
			.onError{color:red;}
			.onSuccess{color:green;}
		</style>
	</head>
	<body >
		<form>
			<li>姓名：<input type='text' id='one' name="one" class="required" ></li>
			<li>电话：<input type='text'  id='two' name="two" class="required"></li>
		<li>	邮箱：<input type='text'  id='three' name="three" class="required"></li>
			<li>不必填：<input type='text' name="four"></li>
			<span id='end' > 提交</span>
		</form>
	</body>
	<script>
			
		$('form :input').blur(function(){
			
			var $parent =$(this).parent();
			$parent.find(".formtips").remove();
			  if( $(this).is('#one') ){
				if(this.value==""){
					var error ="用户名不能为空";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px'>&#xe618;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
			 if( $(this).is('#two') ){
				if(this.value==""){
					var error ="用户名不能为空";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px'>&#xe618;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
			 if( $(this).is('#three') ){
				if(this.value==""){
					var error ="用户名不能为空";
					$parent.append('<span class="formtips onError">'+error+'</span>');
				}else{
					var error ="<i class='layui-icon' style='font-size: 21px'>&#xe618;</i> "
					$parent.append('<span class="formtips onSuccess">'+error+'</span>');
				}

			}
		}).keyup(function(){
           $(this).triggerHandler("blur");
        }).focus(function(){
             $(this).triggerHandler("blur");
        });//end blur

		 $('#end').click(function(){
                $("form :input.required").trigger('blur');
                var numError = $('form .onError').length;
                if(numError){
                    return false;
                } 
                alert("注册成功,密码已发到你的邮箱,请查收.");
         });
	</script>