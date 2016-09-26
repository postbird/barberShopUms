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
<!--c查找上属会员的modal-->
<div class="modal fade" id="newCardUpcardModal" tabindex="-1" role="dialog" aria-labelledby="newCardUpcardModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newCardUpcardModalLabel">查找上属会员</h4>
      </div>
      <div class="modal-body col-sm-12 ">
		<p class="text-danger col-sm-12"><i class="fa fa-info"></i>   <span class="alert-msg">上属会员即新办卡会员的推荐人</span></p>
		<div class="col-sm-12 ">
			<input type="text" class="search-upcard-text" style="width:100%" placeholder="输入姓名或手机号...">
		</div>
		<div class="col-ms-12">
			<div class="col-sm-4  margin-top-px">
				<button class="btn btn-default btn-sm" onclick="searchUserByPhone();"> <i class="fa fa-phone"></i> 按照手机号查找</button>
			</div>
			<div class="col-sm-4  margin-top-px">
				<button class="btn btn-default btn-sm" onclick="searchUserByName();"> <i class="fa fa-user"></i> 按照姓名查找</button>
			</div>
		</div>
		<div hidden class="col-sm-12 no-search-upcard">
			<div class="margin-top-px">
				<p class="text-success">搜索结果</p>
				<p class="text-danger no-search-upcard-msg"></p>
			</div>
		</div>
		<div hidden class="col-sm-12 search-upcard">
			<div class="margin-top-px">
				<p class="text-success">搜索结果</p>
				<div class="search-upcard-result">
					<div class="col-sm-3"><span class="upcard-search-guid">卡号</span></div>
					<div class="col-sm-3"><span class="upcard-search-name">姓名</span></div>
					<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-upcard-search"><i class="fa fa-check"></i> 选择</button></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<hr>
		</div>
		<div class="col-sm-12">
			<button class="btn btn-default btn-sm" onclick="showAllUser();">所有会员  <i class="fa fa-chevron-down"></i></button>
			<div class="show-all-upcard">
				
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--内容content container-->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4><i class="fa fa-user-plus"></i>  新客办卡</h4>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-sm-4 text-right"><h4>刷卡:</h4></div>
						<div class="col-sm-6"><input type="text" class="form-control new-card-text" placeholder="点击此处,并进行刷卡..."></div>
					</div>
					<div class="col-sm-12"><hr></div>
					<div class="col-sm-12 margin-top-px">
						<div class="col-sm-1 text-right">姓名:</div>
						<div class="col-sm-2"><input type="text" class=" new-card-name"></div>
					
						<div class="col-sm-1 text-right">性别:</div>
						<div class="col-sm-1">
							<select class="new-card-sex">]
								<option value="1">男</option>
								<option value="0">女</option>
							</select>
						</div>
						<div class="col-sm-1 text-right">生日:</div>
						<div class="col-sm-3" >
							<input style="width:100%;" type="text" id="pickCalendar" class="new-card-birth" placeholder="日期..." value=""  >
	                          <script>
                      		      $('#pickCalendar').val(new Date().getFullYear()+"-"+(new Date().getMonth()+1)+"-"+new Date().getDate());
	                              $('#pickCalendar').datepicker({
	                                  format: "yyyy-mm-dd",
	                                  language: "cn",
	                                  autoclose: true,
	                                  todayHighlight: true
	                              });
	                          </script>
						</div>
						<div class="col-sm-1 text-right">手机:</div>
						<div class="col-sm-2"><input type="text" class=" new-card-phone"></div>
					</div>
					<div class="col-sm-12 margin-top-px">
						<div class="col-sm-1">密码:</div>
						<div class="col-sm-4" >
							<input type="text" class="new-card-password" value="123456">
						</div>
						<div class="col-sm-4"><p class="text-danger">初始密码为：123456</p></div>
					</div>
					<div class="col-sm-12 margin-top-px">
						<div class="col-sm-1">办理员工:</div>
						<div class="col-sm-2" >
							<select class="new-card-emp" style="width:100%;">
								
							</select>
						</div>
						<div  hidden class="col-sm-4 no-emp-alert-msg"><p class="text-danger">员工信息请求失败  <button class="btn btn-danger btn-xs">重新加载</button></p></div>
					</div>
					<div class="col-sm-12 margin-top-px">
						<div class="col-sm-1">推荐会员:</div>
						<div class="col-sm-2" >
							<input type="text" class="new-card-upcard" placeholder="会员卡号..">
						</div>
						<div class="col-sm-2" >
							<button class="btn btn-xs btn-primary " onclick="showNewCardUpcard()"><i class="fa fa-search" ></i>   直接查找选择会员</button>
						</div>
						<div class="col-sm-4" >
							<p class="text-danger">添加推荐人，若没有请留空！</p>
						</div>
					</div>
					<div class="col-sm-12 margin-top-px">
						<div class="bs-example bs-example-tabs " data-example-id="togglable-tabs">
						    <ul id="newCardTypeTabs" class="nav nav-tabs " role="tablist">
						      <li role="presentation" class="active"><a href="#mCard" id="mCard-tab" role="tab" data-toggle="tab" aria-controls="mCard" aria-expanded="true">办理充金额卡</a></li>
						      <li role="presentation" class="text-center"><a href="#tCard" role="tab" id="tCard-tab" data-toggle="tab" aria-controls="tCard" aria-expanded="false">办理充次卡</a></li>
						    </ul>
						    <div id="myTabContent" class="tab-content margin-top-px">
						      <div role="tabpanel" class="tab-pane fade active in" id="mCard" aria-labelledby="tCard-tab">
						        <div class="col-sm-1">实收金额:</div>
						        <div class="col-sm-2"><input type="number" class="new-mcard-money" ></div>
						        <div class="col-sm-1 text-right">赠送金额:</div>
						        <div class="col-sm-2"><input type="number" class="new-mcard-money-give"></div>
						        <div class="col-sm-1 text-right">合计:</div>
						        <div class="col-sm-2"><input type="number" readonly="true" class="new-mcard-money-total"></div>
						        <div class="col-sm-2"><font class="red-font">不可更改</font></div>
						        <div class="col-sm-12  margin-top-px">
						        	<p class="text-danger"><i class="fa fa-warning"></i>  实收金额不能为空，合计金额不可更改，自动计算!</p>
						        </div>

						         <div hidden class="col-sm-12  margin-top-px add-user-alert-error">
						        	<div  class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  <strong>Error! </strong><span class="add-user-alert-error-msg">姓名/卡号/手机 不能为空且金额必需大于0!</span> 
									</div>
						        </div>

						         <div hidden class="col-sm-12  margin-top-px add-user-alert-success">
						        	<div  class="alert alert-success alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  <strong>Success! </strong><span class="add-user-alert-success-msg">操作成功！</span>
									</div>
						        </div>

						        <div class="col-sm-12  margin-top-px">
									<button class="btn btn-success" onclick="addNewUserMcard();">确认添加该卡</button>
						        </div>
						      </div>
						      <div role="tabpanel" class="tab-pane fade" id="tCard" aria-labelledby="tCard-tab">
						        <div class="col-sm-1">冲次金额:</div>
						        <div class="col-sm-2"><input type="number" class="new-tcard-money" ></div>
						        <div class="col-sm-1 text-right">服务项目:</div>
						        <div class="col-sm-2">
									<select class="new-tard-consume-type" style="width:100%;">
										<option value="0">请求中……</option>
									</select>
						        </div>
						        <div class="col-sm-1 text-right">使用次数:</div>
						        <div class="col-sm-2">
						        	<input type="number" class="new-tcard-count">
					        	</div>
						        <div  class="col-sm-12  margin-top-px">
						        	<p class="text-danger"><i class="fa fa-warning"></i>  冲次金额不能为空，使用次数不能为空且必须大于0！</p>
						        </div>
						         <div hidden class="col-sm-12  margin-top-px add-user-alert-error-tcard">
						        	<div class="alert alert-danger alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  <strong>Error! </strong> <span class="add-user-alert-error-msg-tcard">姓名/卡号/手机 不能为空且金额必需大于0!.</span>
									</div>
						        </div>
						        <div hidden class="col-sm-12  margin-top-px add-user-alert-success-tcard">
						        	<div  class="alert alert-success alert-dismissible" role="alert">
									  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									  <strong>Success! </strong><span class="add-user-alert-success-msg-tcard">操作成功！</span> 
									</div>
						        </div>
						        <div class="col-sm-12  margin-top-px">
									<button class="btn btn-info" onclick="addNewUserTcard();">确认添加该卡</button>
						        </div>
						      </div>
						    </div>
						  </div>
					</div>
				</div>
				
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4><i class="fa fa-money"></i>  新卡注册  <span class="red-font pay-up-card-guid"></span>  提成信息须知</h4>
				</div>
				<div class="panel-body">
					<p class="text-danger middle-font">
						<i class="fa fa-info"></i> :  您可以在此看到该会员卡注册后与其相关的提成返现信息</p>
					<p class="text-danger middle-font text-indent">
						（包括/卡号/姓名/会员等级(<strong>表示注册会员是提成对象的第几级会员</strong>)/提成比例/提成金额/）.  
					</p>
					<p class="text-danger middle-font">
						<i class="fa fa-info"></i> :  若某项提成已经付掉,可以点击后面<strong>确认提成支付</strong>按钮进行确认即可.</p>
					<p class=" middle-font text-indent">
						<a class="btn btn-primary btn-xs">确认支付该提成</a> ——该按钮表示此项提成没有支付,点击可以进行确认支付!
					</p>
					<p class=" middle-font text-indent">
						<a disabled class="btn btn-default btn-xs"><i class="fa fa-check"></i> 已支付</a> ——该按钮表示此项提成已经支付!
					</p>
					<table hidden class="pay-up-card-table text-center  table table-striped  table-bordered table-hover table-condensed margin-top-px " >
							<tr>
								<th>卡号</th>
								<th>姓名</th>
								<th>会员等级</th>
								<th>提成比例</th>
								<th>提成金额</th>
							</tr>
							
					</table>
					<div hidden class="pay-up-card-error text-center margin-top-px">
						<i class="fa fa-warning fa-2x"></i><br>
						<h4 class="text-center"><span class="pay-up-card-error-msg">请求失败!</span></h4>
					</div>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>


</body>
<script>
	$("document").ready(function(){
		addActiveClass("navbar-link-1");
		initAddUser();
	});
	
</script>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>