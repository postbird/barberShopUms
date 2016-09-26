<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!--meta:vp 响应式布局-->
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
	<!--meta:compat IE7兼容-->
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<link rel="stylesheet" href="/barbershopums/Public/css/bootstrap.min.css">
	<link rel="stylesheet" href="/barbershopums/Public/css/font-awesome.min.css">
	<link rel="stylesheet" href="/barbershopums/Public/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="/barbershopums/Public/css/all.css">
	<script src="/barbershopums/Public/js/jquery.2.1.4.min.js"></script>
	<script src="/barbershopums/Public/js/bootstrap.min.js"></script>
	<script src="/barbershopums/Public/js/bootstrap-datepicker.js"></script>
	
<title>BSUMS-管理系统|首页</title>
</head>
<body class="black-body" style="background-image:url(/barbershopums/Public/images/bg/bg4.jpg);background-repeat:no-repeat;background-size:cover; ">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div hidden class="jumbotron login-message">
			  <p><i class="fa fa-object-ungroup"></i>  <strong>欢迎使用BarberShopUMS</strong></p>
			  <p>此页面为欢迎页面,可直接选择需要的操作！</p>
			  <p><small>管理员默认账户666 密码 123456</small></p>
			  <p class="text-danger"><small>管理员不提供忘记密码服务,若忘记密码,请联系开发者!</small></p>
			  <p>快速熟悉系统可点击： <a href="/barbershopums/index.php/Home/Help/" class=" btn btn-warning" >快速上手BSUMS管理系统 <i class="fa fa-angle-double-right"></i></a></p>
			  <a href="http://contact.ptbird.cn" class="pull-left btn btn-primary" target="_blank"><i class="fa fa-envelope-o"></i>  联系开发者</a>
			  <button class="login-up-message-btn-up pull-right btn  ">收起  <i class="fa fa-angle-double-up"></i></button>
			</div>
		</div>
		<div class="col-md-12">
			<div  class=" jumbotron login-message-hidden">
			  <p>
		 	    <i class="fa fa-object-ungroup"></i>  <strong>欢迎使用BarberShopUMS</strong>
			    <button class="login-up-message-btn-down pull-right btn  ">展开  <i class="fa fa-angle-double-down"></i></button>
			  </p>
			</div>
		</div>
	</div>
</div>
<div class="container white-font">
	<div class="row">
		<div class="col-md-12">
			<div class="col-sm-6 welcome-item-box text-center">
				<a href="/barbershopums/index.php/Home/User/addUser">
					<div class="welcome-img-box center-block">
						<img src="/barbershopums/Public/images/icon/zc.png" width="100px"height="100px"alt="">
						<h3>新客办卡</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-6  welcome-item-box text-center">
				<a href="/barbershopums/index.php/Home/User/">
					<div class="welcome-img-box center-block">
						<img src="/barbershopums/Public/images/icon/rmb.png" width="100px"height="100px"alt="">
						<h3>会员操作</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-6  welcome-item-box text-center">
				<a href="">
					<div class="welcome-img-box center-block">
						<img src="/barbershopums/Public/images/icon/jf.png" width="100px"height="100px"alt="">
						<h3>会员积分(暂未开放)</h3>
					</div>
				</a>
			</div>
			<div class="col-sm-6  welcome-item-box text-center">
				<a href="/barbershopums/index.php/Home/System/">
					<div class="welcome-img-box center-block">
						<img src="/barbershopums/Public/images/icon/sys.png" width="100px"height="100px"alt="">
						<h3>系统设置</h3>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
</body>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>