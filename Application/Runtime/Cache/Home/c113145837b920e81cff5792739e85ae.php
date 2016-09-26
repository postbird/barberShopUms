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
	
<title>BSUMS-管理系统|系统设置</title>

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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msModalLabel">提示信息</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <h4><i class="fa fa-info-circle"></i>  <span class="alert-msg">未知错误！</span></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--添加用户modal-->
<div class="modal fade" id="addEmpModal" tabindex="-1" role="dialog" aria-labelledby="addEmpModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addEmpModalLabel">添加新员工</h4>
      </div>
      <div class="modal-body col-sm-12">
          
	      <div class="col-sm-12">
	      	<div class="col-sm-3 text-right ">员工姓名</div>
	       		<div class="col-sm-5 text-left" >
	       			<input type="text" class="add-emp-name">
	       		</div>
	      </div>
	       	<div class="col-sm-12 margin-top-px">
	       		<div class="col-sm-3  text-right">员工密码</div>
	       		<div class="col-sm-5  text-left">
	       			<input type="text" value="123456" class="add-emp-password">
	       		</div>
	       		<div class="col-sm-4"><p class="text-danger">默认密码为 123456</p></div>
	       	</div>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-success btn-sm" onclick="addEmpWork()">添加</button>
      </div>
    </div>
  </div>
</div>
<!--编辑用户信息modal-->
<div class="modal fade" id="editEmpModal" tabindex="-1" role="dialog" aria-labelledby="editEmpModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editEmpModalLabel">编辑员工信息</h4>
      </div>
      <div class="modal-body col-sm-12">
     	 <div class="col-sm-12">
	      	 	<div class="col-sm-4 text-right">员工编号</div>
	       		<div class="col-sm-5 text-left" >
	       			<input type="text" class="edit-emp-id " disabled readonly="true">
	       		</div>
	       		<div class="col-sm-3"><p class="text-danger">编号不可修改</p></div>

	      </div>
	      <div class="col-sm-12  margin-top-px">
	      	<div class="col-sm-4 text-right">员工姓名</div>
	       		<div class="col-sm-5 text-left" >
	       			<input type="text" class="edit-emp-name">
	       		</div>
	      </div>
	       	<div class="col-sm-12 margin-top-px">
	       		<div class="col-sm-4  text-right">密码(不显示原密)</div>
	       		<div class="col-sm-5  text-left">
	       			<input type="text" class="edit-emp-password">
	       		</div>
	       	</div>	
	       	<div class="col-sm-12 margin-top-px">
	      	 	<p class="text-danger">员工默认密码为123456，此处不进行显示，若修改密码直接输入即可，若不修改请不要填写密码框！！</p>
	       	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-success btn-sm" onclick="editEmpWork()">保存</button>
      </div>
    </div>
  </div>
</div>
<!--删除用户 modal-->
<div class="modal fade" id="deleteEmpModal" tabindex="-1" role="dialog" aria-labelledby="deleteEmpModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="deleteEmpModalLabel">删除员工</h4>
      </div>
      <div class="modal-body col-sm-12">
     	 <div class="col-sm-12">
				<h4><i class="fa fa-warning"></i>  是否删除编号为 <span class="delete-emp-id">未知编号</span> 的 <span class="delete-emp-name red-font">未知姓名</span> 员工</h4>
				<h4><small><span class="red-font">该删除仅为方便添加员工错误时用于删除错误的员工！</span></small></h4>
				<h4><small><span class="red-font">该操作不可恢复，若之前有该员工操作的记录（如办卡、收银等操作），则请勿删除该员工！</span></small></h4>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="deleteEmpWork()">删除</button>
      </div>
    </div>
  </div>
</div>
<!--content container -->
<div class="container ">
	<div class="row white-font">
		<div class="col-md-12">
			<div class="col-sm-2 text-center">
				<div class="col-sm-10  primary-box center-block sys-nav-box sys-active" GUCLASS="consume-inte-box"onclick="showSysControl(this);">
					消费积分
				</div>
			</div>
			<div class="col-sm-2 text-center">
				<div class="col-sm-10  primary-box center-block sys-nav-box "GUCLASS="consume-box"onclick="showSysConsumeControl(this);">
					服务项目
				</div>
			</div>
			<div class="col-sm-2 text-center">
				<div class="col-sm-10  primary-box center-block sys-nav-box "GUCLASS="emp-box"onclick="showSysEmpControl(this);">
					员工管理
				</div>
			</div>
			<div class="col-sm-2 text-center">
				<div class="col-sm-10  primary-box center-block sys-nav-box "GUCLASS="level-box"onclick="showLevelController(this);">
					提成比例
				</div>
			</div>
			<div class="col-sm-2 text-center ">
				<div class="col-sm-10  warning-box center-block sys-nav-box "GUCLASS="admin-password-box"onclick="showSysControl(this);">
					修改密码
				</div>
			</div>
		</div>
	</div><!--row end-->
	<div class="row" style="margin-top:30px;">
		<div class="col-md-12 sys-content-box consume-inte-box">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>消费积分设置</h5>
				</div>
				<div class="panel-body text-center">
					<h5>客 人 每 消 费  <input class="consume-inte-text"type="text" value="1"style="width:40px;">  元 积 1 分</h5>
					<h5><small>默认为1元积1分</small></h5>
				</div>
				<div  hidden class="alert alert-success alert-dismissible edit-consume-success-alert text-center" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Success! </strong>  消费积分关系修改成功！.
				</div>
				<div class="panel-footer text-right">
					<button class="btn btn-success" onclick="editConsumeInte();">更改</button>
				</div>
			</div>
		</div>
		<div class="hidden col-md-12 sys-content-box consume-box">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>服务项目设置</h5>
				</div>
				<div class="panel-body text-center">
					<div class="col-sm-12">
						<div class="col-sm-2">新服务项目</div>
						<div class="col-sm-2"><input class="add-consume-type-text" type="text" placeholder="新服务项目名称....."></div>
						<div class="col-sm-2"><button class="btn btn-success btn-sm" onclick="addSysConsumeWork();">添加</button></div>
					</div>
					<div class="col-sm-12 text-left">
						<hr>
						<h4>当前已有项目</h4>
					</div>
					<div class="col-sm-12 margin-top-px">
						<table class="text-center consume-show-table table table-striped  table-bordered table-hover table-condensed" >
													
						</table>
					</div>
				</div>
				<div  hidden class="alert alert-success alert-dismissible edit-consume-success-alert text-center" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Success! </strong>  <span class="add-consume-type-success-alert-text"></span>
				</div>
				<div  hidden class="alert alert-danger alert-dismissible add-consume-type-error-alert text-center" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error! </strong>  <span class="add-consume-type-error-alert-text"></span>
				</div>
			</div>
		</div>
		<div class="col-md-12 sys-content-box emp-box hidden">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>店内员工管理</h5>
				</div>
				<div class="panel-body text-center text-left">
					<button class="btn btn-info btn-sm" onclick="addEmpController('addEmpModal');">添加员工  <i class="fa fa-user-plus"></i></button>
					<h4 class="emp-no-show text-center"><i class="fa fa-warning"></i> 暂无员工</h4>
					<table hidden class="text-center emp-show-table table table-striped  table-bordered table-hover table-condensed margin-top-px " >
							
						
					</table>
				</div>
				<div class="panel-footer text-right">
					对店内员工进行相关管理
				</div>
			</div>
		</div>
		<div class="col-md-12 sys-content-box level-box hidden">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>查看提成比例</h5>
				</div>
				<div class="panel-body">
					<table  class="level-show-table text-centere table table-striped  table-bordered table-hover table-condensed margin-top-px text-center" >
					</table>
				</div>
				<div class="panel-footer text-right">
					<span class="red-font">目前只提供提成比例查看功能！</span>
				</div>
			</div>
		</div>
		<div class="col-md-12 sys-content-box admin-password-box hidden">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h5>管理员密码修改</h5>
				</div>
				<div class="panel-body text-center">
					<div  hidden class="col-sm-12 edit-admin-alert  edit-admin-password-alert">
						<div   class=" alert alert-success alert-dismissible  text-center" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Success! </strong>  <span class="edit-admin-password-alert-msg">操作成功！</span>.
						</div>
					</div>
					<div  hidden  class="col-sm-12 edit-admin-alert edit-admin-password-alert-error">
						<div class=" alert alert-danger alert-dismissible  text-center" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Error! </strong>  <span class="edit-admin-password-alert-msg-error">操作失败！</span>.
						</div>
					</div>
					<div class="col-sm-12">
						<div class="col-sm-4 text-right">原密码</div>
						<div class="col-sm-8 text-left"><input type="password" class="old-admin-password" placeholder="请输入原密码..."></div>
					</div>
					<div class="col-sm-12  margin-top-px">
						<div class="col-sm-4 text-right">新密码</div>
						<div class="col-sm-8 text-left"><input type="password" class="new-admin-password" placeholder="请输入新密码..."></div>
					</div>
					<div class="col-sm-12  margin-top-px">
						<div class="col-sm-4 text-right">确认新密码</div>
						<div class="col-sm-8 text-left"><input type="password" class="new-admin-password-again" placeholder="请确认新密码..."></div>
					</div>
					<div class="col-sm-12  margin-top-px">
						<p class="text-danger">
							<span class="red-font">目前该系统不提供「 忘记密码 」服务！如果忘记密码请联系开发者！</span>
						</p>
					</div>
				</div>
				<div class="panel-footer text-right">
					<button class="btn btn-success " onclick="editAdminPassword();">确认更改</button>
				</div>
			</div>
		</div>
	</div><!--row end-->
</div>

</body>
<script>
	$("document").ready(function(){
		addActiveClass("navbar-link-4");
		showConsumeInte();
	});
</script>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>