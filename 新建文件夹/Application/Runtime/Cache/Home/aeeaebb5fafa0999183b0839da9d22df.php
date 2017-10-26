<?php if (!defined('THINK_PATH')) exit();?><HTML>
<HEAD>
<META http-equiv='Content-Type' content='text/html; charset=utf-8'>
<TITLE>js实现可输入的下拉框</TITLE>
</HEAD>
<BODY>
    <style>
        option{height:30px;padding:0px;}
        </style>
<div style="position:relative;">
<span style="margin-left:300px;width:18px;overflow:hidden;">
<select style="width:300px;height:30px;line-height:30px;margin-left:-300px;" id="student"  onchange="this.parentNode.nextSibling.value=this.value;">
<option value="" id="qxz"></option>
<option value="德国">德国</option>
<option value="德国">美国</option>
<option value="德国">中国</option>
<option value="德国">阿拉伯国</option>
<option value="挪威">挪威</option>
<option value="瑞士">瑞士</option>
</select>
</span><input type="text" name="box" id="sss" style="border:1px solid #000;width:300px;position:absolute;left:0px;height:30px;line-height:30px;">
</div>
<script src="./Public/jquery/jquery.js"></script>
<script>
        $("#sss").on("click",function(){
            var main_height=$("option").length*32;
            $("#student").css("height",main_height+"px");
            $("#student").attr("size","20");
        })

        $("#sss").on("keyup",function(){
            //$("option").show();
            var in_text=$("#sss").val();
            if(in_text=='')
            {
                $("option").show();
                return;
            }
            var main_height=$("option").length*32;
            $("#student").css("height",main_height+"px");
            $("#student").attr("size","20");
            
            $("option").each(function(){
                if($(this).text().search(in_text)>=0)
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
                $("#qxz").show();
            });
        });
</script>
</BODY>
</HTML>