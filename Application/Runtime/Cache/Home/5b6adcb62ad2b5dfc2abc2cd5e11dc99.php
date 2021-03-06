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
	
<title>BSUMS-会员系统|用户登录</title>
</head>
<body class="black-body" style="background-image:url(/barbershopums/Public/images/bg/bg2.jpg);background-repeat:no-repeat;background-size:cover;background-size:contain:; ">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div hidden class="jumbotron login-message">
			  <p><i class="fa fa-object-ungroup"></i>  <strong>BarberShopUMS登录须知</strong></p>
			  <p>账户为卡号</p>
			  <p class="text-danger"><small>会员不提供修改密码服务,修改密码需要到店联系管理员更改!</small></p>
			  <p>BarberShopUMS-理发店会员系统 | 2016-09</p>
			  <p>Powered by <a href="http://www.ptbird.cn" target="_blank">Postbird</a></p>
			  <a href="http://contact.ptbird.cn" class="pull-left btn btn-primary" target="_blank"><i class="fa fa-envelope-o"></i>  联系开发者</a>
			  <button class="login-up-message-btn-up pull-right btn  ">收起  <i class="fa fa-angle-double-up"></i></button>
			</div>
		</div>
		<div class="col-md-12">
			<div  class=" jumbotron login-message-hidden">
			  <p>
		 	    <i class="fa fa-object-ungroup"></i>  <strong>BarberShopUMS登录须知</strong>
		 	    <img src="/barbershopums/Public/images/bg/gumu.jpg" class="center-block"alt=""style="max-height:50px;" >
			    <button class="login-up-message-btn-down pull-right btn  ">展开  <i class="fa fa-angle-double-down"></i></button>
			  </p>
			  
			</div>
		</div>
	</div>
</div>
<div class="container white-font">
			<div class="row col-md-12">

					<h3 class="text-center"><strong><i class="fa fa-user-secret"></i>  用户登录</strong><small></small></h3><hr>
					<form action="/barbershopums/index.php/Home/Login/loginCheck" method="post">
						<div class="form-group col-md-12 col-xs-12">
							<div class="col-sm-4 text-center col-xs-4">
								<h4><label for="adminname">账户：</label></h4>
							</div>
							<div class="col-sm-8 col-xs-8">
								<input type="text" name="adminname" id="adminname"value="" class="form-control" placeholder="请输入账户">
							</div>	
						</div>
						<div class="form-group col-md-12  col-xs-12">
							<div class="col-sm-4 text-center  col-xs-4">
								<h4><label for="adminpassword">密码：</label></h4>
							</div>
							<div class="col-sm-8  col-xs-8">
								<input type="password" name="adminpassword" id="adminpassword"value=""  class="form-control" placeholder="请输入密码">
							</div>	
						</div>
						<div class="form-group">
							<div class="col-xs-6 text-right">
								<input type="submit"  value="登录"  class="btn btn-primary ">
							</div>
							<div class="col-xs-6 text-left">
								<input type="reset"  value="重置"  class="btn btn-danger ">
							</div>	
							
						</div>
					</form>
			</div>
			<div class="row col-md-12">
				
			</div>
	</div>
</body>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>