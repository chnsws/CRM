<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>中国省市区地址三级联动jQuery插件</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	

	<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/main.css" rel="stylesheet">
	<link href="<?php echo ($_GET['public_dir']); ?>/diqu/css/css/demo.css" rel="stylesheet">

	
	<!--[if IE]>
		<script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
	<![endif]-->
</head>
<body>
	

    <h5>Demo:</h5>
    <form class="form-inline">
      <div data-toggle="distpicker">
        <div class="form-group">
          <label class="sr-only" for="province1">Province</label>
          <select class="form-control" id="province1"></select>
        </div>
        <div class="form-group">
          <label class="sr-only" for="city1">City</label>
          <select class="form-control" id="city1"></select>
        </div>
        <div class="form-group">
          <label class="sr-only" for="district1">District</label>
          <select class="form-control" id="district1"></select>
        </div>
      </div>
    </form>

 


	
	

	<script>window.jQuery || document.write('<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/jquery-1.11.0.min.js"><\/script>')</script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.data.js"></script>
	  <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/distpicker.js"></script>
	  <script src="<?php echo ($_GET['public_dir']); ?>/diqu/js/main.js"></script>



</body>
</html>