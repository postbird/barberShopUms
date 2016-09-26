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
	
<title>BSUMS|报表查看</title>

</head>
<body class="black-body"style="background-image:url(/barbershopums/Public/images/bg/bg3.jpg);background-repeat:no-repeat;background-size:cover;background-size:contain:; ">
<div class="container">
  <div class="row">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/barbershopums/index.php/Home/Index/"><i class="fa fa-object-ungroup"></i> BarberShopUMS</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="navbar-link"><a href="/barbershopums/index.php/Home/Index/"><img src="/barbershopums/Public/images/icon/back-b.png" width="20px"alt="">  欢迎页面</a></li>
            <li class="navbar-link navbar-link-1"><a href="/barbershopums/index.php/Home/User/addUser"><img src="/barbershopums/Public/images/icon/zc-b.png" width="20px"alt="">  新客办卡</a></li>
            <li class="navbar-link navbar-link-2"><a href="/barbershopums/index.php/Home/User/"><img src="/barbershopums/Public/images/icon/rmb-b.png" width="20px"alt="">  会员操作</a></li>
            <!-- <li class="navbar-link navbar-link-3"><a href="#"><img src="/barbershopums/Public/images/icon/jf-b.png" width="20px"alt="">  积分系统</a></li> -->
            <li class="navbar-link navbar-link-4"><a href="/barbershopums/index.php/Home/System/"><img src="/barbershopums/Public/images/icon/sys-b.png" width="20px"alt="">  系统设置</a></li>
            <li class="navbar-link navbar-link-5"><a href="/barbershopums/index.php/Home/Report/"><img src="/barbershopums/Public/images/icon/report-b.png" width="20px"alt="">  报表</a></li>
            <li class="navbar-link navbar-link-6"><a href="/barbershopums/index.php/Home/Help/"><img src="/barbershopums/Public/images/icon/help-b.png" width="20px"alt="">  联系帮助</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li ><a title="退出系统" href="/barbershopums/index.php/Home/Login/logout"><img src="/barbershopums/Public/images/icon/logout-r.png" width="20px"alt="">  <font class="red-font">退出</font></a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </div>
</div>
  
<!--提示modal-->
<div class="modal " id="msModal" tabindex="-1" role="dialog" aria-labelledby="msModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msModalLabel">提示信息</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <h4><i class="fa fa-info-circle"></i></h4>
	      <p class="text-danger">   <span class="alert-msg">未知错误！</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--查看report的modal-->
<div class="modal fade" id="reportShowModal" tabindex="-1" role="dialog" aria-labelledby="reportShowModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="reportShowModalLabel">提示信息</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	     <table class="text-center table table-striped  table-bordered table-hover table-condensed margin-top-px report-show-table">
			
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--container content box-->
<div class="container">
	<div class="row">
		<div class="col-md-12 panel">
			<div class="margin-top-px">
				<div class="col-sm-2 text-right"><h4>时间从</h4></div>
				<div class="col-sm-3">
					<input type="text" class="form-control report-start-time" id="pickReportStartTime"placeholder="选择开始时间...." value="">
                          <script>
                  		      $('#pickReportStartTime').val(new Date().getFullYear()+"-"+(new Date().getMonth()+1)+"-"+(new Date().getDate()*1-1));
                              $('#pickReportStartTime').datepicker({
                                  format: "yyyy-mm-dd",
                                  language: "cn",
                                  autoclose: true,
                                  todayHighlight: true
                              });
                          </script>
				</div>
				<div class="col-sm-1 text-center"><h4>到</h4></div>
				<div class="col-sm-3">
					<input type="text" class="form-control report-end-time" id="pickReportEndTime"placeholder="选择结束时间...." value="">
                          <script>
                  		      $('#pickReportEndTime').val(new Date().getFullYear()+"-"+(new Date().getMonth()+1)+"-"+new Date().getDate());
                              $('#pickReportEndTime').datepicker({
                                  format: "yyyy-mm-dd",
                                  language: "cn",
                                  autoclose: true,
                                  todayHighlight: true
                              });
                          </script>
				</div>
				<div class="col-sm-3"><button class="btn btn-primary " onclick="reportController();">查询报表</button></div>
			</div>
		</div>
	</div><!--row end-->
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>报表一览  <small><font color="#ccc">由上面查询结果进行显示</font></small></h4>
			</div>
			<div class="panel-body">
				<table class="text-center table table-striped  table-bordered table-hover table-condensed margin-top-px report-all-table">
			
				</table>
			</div>
		</div>
	</div>
</div><!--container end-->


<script>
	$("document").ready(function(){
		addActiveClass("navbar-link-5");
		initReport();
	});
	
	
</script>
</body>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>