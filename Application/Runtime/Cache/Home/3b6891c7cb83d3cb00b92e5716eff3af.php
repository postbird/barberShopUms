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
	

<title>BSUMS-会员系统|查看会员信息</title>

</head>
<body class="black-body"style="background-image:url(/barbershopums/Public/images/bg/bg3.jpg);background-repeat:no-repeat;background-size:cover;background-size:contain:; ">
<!--提示modal-->
<div class="modal " id="msModal" tabindex="-1" role="dialog" aria-labelledby="msModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="msModalLabel">提示信息</h5>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <h5><i class="fa fa-info-circle"></i></h5>
	      <p class="text-danger">   <span class="alert-msg">未知错误！</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					 <h2 class="visible-lg"><i class="fa fa-object-ungroup"></i>  <strong>BarberShopUMS 用户查询</strong></h2>
				    <h5  class="visible-xs"><i class="fa fa-object-ungroup"></i>  <strong>BarberShopUMS 用户查询</strong></h5>
					<img src="/barbershopums/Public/images/bg/gumu.jpg" class="center-block"alt=""style="max-height:50px;" > 	
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-primary" >
				<div class="panel-heading">
					<h5><i class="fa fa-credit-card"></i>  <font class="user-show-card"><?php echo ($card); ?></font> 会员卡信息</h5>
				</div>
				<div class="panel-body col-md-12 col-xs-12" >
					<div class="col-sm-6  col-xs-6"><h5><i class="fa fa-credit-card"></i>  卡类型：</h5></div>
					<div class="col-sm-6  col-xs-6"><h5><font class="user-show-card-type">充值金额卡</font></h5></div>
					<div class="col-sm-6  col-xs-6"><h5><i class="fa fa-user"></i>   姓名：</h5></div>
					<div class="col-sm-6  col-xs-6"><h5> <font class="user-show-name"> 0</font></h5></div>
					<div class="col-sm-6  col-xs-6"><h5><i class="fa fa-phone"></i>  手机号：</h5></div>
					<div class="col-sm-6  col-xs-6"><h5>  <font class="user-show-phone">0</font></h5></div>
					<div class="col-sm-6  col-xs-6"><h5><i class="fa fa-rmb"></i>   账户余额：</h5></div>
					<div class="col-sm-6  col-xs-6"><h5><font class="user-show-money">0</font></h5></div>
				</div>
				<div class="panel-footer text-right">
					<a class="btn btn-danger " href="/barbershopums/index.php/Home/Login/logout">退出</a>
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>
						<i class="fa fa-line-chart"></i>  会员卡提成
					</h5>
				</div>
				<div class="panel-body">
					<!--等级记录-->
					<div class="col-md-4 col-xs-12" >
						<div class="col-sm-6 col-xs-6"><h5>提成收入(总计)</h5></div>
						<div class="col-sm-3  col-xs-3 text-left"><h5><span class="level-total-count red-font">0</span> 次</h5></div>
						<div class="col-sm-3  col-xs-3 text-left"><h5><i class="fa fa-jpy"></i>   <span class="level-total-money red-font">0</span></h5></div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="col-sm-6 col-xs-6"><h5>已付提成 : </h5></div>
						<div class="col-sm-3  col-xs-3 text-left"><h5><span class="level-pay-count red-font">0</span> 次</h5></div>
						<div class="col-sm-3  col-xs-3 text-left"><h5><i class="fa fa-jpy"></i>   <span class="level-pay-money red-font">0</span></h5></div>
					</div>
					<div class="col-md-4">
						<div class="col-sm-6  col-xs-6"><h5>未付提成 : </h5></div>
						<div class="col-sm-3 col-xs-3  text-left"><h5><span class="level-nopay-count red-font">0</span> 次</h5></div>
						<div class="col-sm-3  col-xs-3 text-left"><h5><i class="fa fa-jpy"></i>   <span class="level-nopay-money red-font">0</span></h5></div>
					</div>
					<div class="col-sm-12">
						<hr>
						<p class="text-danger"><i class="fa fa-info"></i>：  下述提成收入结构第一级(根)是当前卡本身,往后依次为二级会员(当前卡下属会员)、三级会员...共五级.</p>
						<p class="text-danger"><i class="fa fa-info"></i>：  点击下属会员会在下一级显示该下属会员推荐的会员,以此构成树结构.(第5级没有点击查看功能).</p>
					</div>
					<div class=" level-info-table-box">
					<hr>
						<div class="col-sm-12 col-xs-12  margin-top-px level-info-user-1" LEVEL="1">
							<div class="col-sm-2 col-xs-4">
								<img src="/barbershopums/Public/images/icon/v1.png" width="80px;"alt="v1">
								<p>本卡办卡提成</p>
							</div>
							<div class="col-sm-10  col-xs-8 level-info-box-1">
								<div class="level-user-info-box-user-show level-user-info-box-root  text-center center-block" CARD="">
									<p class="text-danger"><i class="fa fa-user"></i>   <span class="level-user-info-box-root-card">0</span></p>
									<p> ( 本卡 )</p>
									<p class="">提成金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-root-money">0</span></p>
									<p class="level-user-info-box-root-btn"></p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-xs-12 margin-top-px level-info-user-2" LEVEL="2">
							<div class="col-sm-2  col-xs-4">
								<img src="/barbershopums/Public/images/icon/v2.png" width="80px;"alt="v2">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-2"></span></p>
							</div>
							<div class="col-sm-10  col-xs-8 level-info-box-2">
								
							</div>
						</div>
						<div class="col-sm-12  col-xs-12 margin-top-px level-info-user-3" LEVEL="3">
							<div class="col-sm-2  col-xs-4 ">
								<img src="/barbershopums/Public/images/icon/v3.png" width="80px;"alt="v3">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-3"></span></p>
							</div>
							<div class="col-sm-10   col-xs-8 level-info-box-3"></div>
						</div>
						<div class="col-sm-12 col-xs-12  margin-top-px level-info-user-4" LEVEL="4">
							<div class="col-sm-2  col-xs-4">
								<img src="/barbershopums/Public/images/icon/v4.png" width="80px;"alt="v4">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-4"></span></p>
							</div>
							<div class="col-sm-10 col-xs-8 level-info-box-4"></div>
						</div>
						<div class="col-sm-12  col-xs-12 margin-top-px level-info-user-5" LEVEL="5" style="margin-bottom:30px;">
							<div class="col-sm-2  col-xs-4">
								<img src="/barbershopums/Public/images/icon/v5.png" width="80px;"alt="v5">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-5"></span></p>
							</div>
							<div class="col-sm-10   col-xs-8 level-info-box-5"></div>
						</div>
					</div>
				</div>
				<div class="panel-footer text-right">
				</div>
			</div>
		</div>
	</div>
		
</div>

</body>
<script>
$("document").ready(function(){
	initUserShow();
});
</script>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>