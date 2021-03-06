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
	
<title>BSUMS-|会员应用功能-充值/消费/卡务/查询</title>

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
<!--confirm modal-->
<div class="modal " id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="confirmModalLabel">操作确认</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <h4><i class="fa fa-info-circle"></i></h4>
	      <p class="text-danger">   <span class="confirm-msg">继续该操作?</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary btn-sm confirm-modal-btn" onclick="confirmClick();">确认</button>
      </div>
    </div>
  </div>
</div>
<!--卡的挂失操作  modal-->
<div class="modal fade" id="cardLossModal" tabindex="-1" role="dialog" aria-labelledby="cardLossModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardLossModalLabel">会员卡挂失/解除</h4>
      </div>
      <div class="modal-body col-sm-12 ">
	      <div hidden class="card-loss-box  text-center">
	      	<h4><i class="fa fa-warning"></i>  <span class="text-danger card-loss-card"></span>  会员卡处于<span class="red-font">正常使用</span>状态,确定挂失?</h4>
	      	<div class="margin-top-px">
	      		<button class="btn btn-danger" onclick="cardLossWork();">挂失会员卡</button>
	      	</div>
	      </div>
	      <div hidden class="card-loss-cancel-box  text-center">
	      	<h4><i class="fa fa-warning"></i>  <span class="text-danger card-loss-cancel-card"></span>  会员卡处于<span class="red-font">挂失</span>状态,确定解除挂失?</h4>
	      	<div class="margin-top-px">
	      		<button class="btn btn-success" onclick="cardLossCancelWork();">解除挂失会员卡</button>
	      	</div>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--卡的注销操作  modal-->
<div class="modal fade" id="cardOffModal" tabindex="-1" role="dialog" aria-labelledby="cardOffModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardOffModalLabel">会员卡注销</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <div hidden class="card-off-box  text-center">
	      	<h4><i class="fa fa-warning"></i>  <span class="text-danger card-off-card"></span>  会员卡处于<span class="red-font">正常使用</span>状态,确定挂失?</h4>
	      	<p class="text-danger margin-top-px text-left"><i class="fa fa-warning"></i>  会员卡注销以后，将不能使用所有功能，且卡的注销不可恢复！</p>
	      	<p class="text-danger margin-top-px text-left"><i class="fa fa-warning"></i>  请 谨慎!  谨慎!!  再谨慎!!  </p>
	      	<div class="margin-top-px">
	      		<button class="btn btn-danger" onclick="cardOffWorkConfirm();">仍旧注销会员卡</button>
	      	</div>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--卡的补办操作  modal-->
<div class="modal fade" id="cardReissueModal" tabindex="-1" role="dialog" aria-labelledby="cardReissueModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardReissueModalLabel">会员卡补办</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <div hidden class="card-reissue-box  text-center">
	      	<h4><i class="fa fa-warning"></i>  确定将 <span class="text-danger card-reissue-card"></span>  会员卡 <span class="red-font">补办新卡</span>？</h4>
	      	<p class="text-danger margin-top-px text-left"><i class="fa fa-warning"></i>  新卡补办后，旧卡将不能使用，会员卡补办操作不可恢复!</p>
	      	<p class="text-danger margin-top-px text-left"><i class="fa fa-warning"></i>  请 谨慎!  谨慎!!  再谨慎!!  </p>
	      	<div class="margin-top-px">
	      		<div class="col-sm-8">
					<div class="input-group">
				    	<span class="input-group-addon "><i class="fa fa-credit-card "></i>  新卡：  </span>
				    	<input type="text" class="form-control form-xs card-reissue-card-copy" placeholder="点击刷卡或输入新卡卡号...">
				    </div>
	      		</div>
	      		<div class="col-sm-4"><button class="btn btn-danger" onclick="cardReissueWorkConfirm();">补办新卡</button></div>
	      	</div>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--卡的密码消费操作  modal-->
<div class="modal fade" id="cardPasswordModal" tabindex="-1" role="dialog" aria-labelledby="cardPasswordModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardPasswordModalLabel">会员卡密码消费</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
	      <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
		    <ul id="cardPasswordTabs" class="nav nav-tabs" role="tablist">
		      <li role="presentation" class="active"><a href="#cardPasswordActive" id="cardPasswordActive-tab" role="tab" data-toggle="tab" aria-controls="cardPasswordActive" aria-expanded="true">激活/解除密码消费</a></li>
		      <li role="presentation" class=""><a href="#cardPasswordChange" role="tab" id="cardPasswordChange-tab" data-toggle="tab" aria-controls="cardPasswordChange" aria-expanded="false">修改会员卡密码</a></li>
		    </ul>
		    <div id="cardPasswordTabContent" class="tab-content">
		      <div role="tabpanel" class="tab-pane fade active in" id="cardPasswordActive" aria-labelledby="cardPasswordActive-tab">
		         <div hidden class="card-password-box  text-center margin-top-px">
			      	<h4><i class="fa fa-warning"></i>  <span class="text-danger card-password-card"></span>  会员卡当前 <span class="red-font"> 不需要 </span>使用密码消费.开启密码消费?</h4>
			      	<div class="margin-top-px">
			      		<button class="btn btn-danger" onclick="cardPasswordActiveWork();">开启密码消费</button>
			      	</div>
			      </div>
			      <div hidden class="card-password-cancel-box  text-center margin-top-px">
			      	<h4><i class="fa fa-warning"></i>  <span class="text-danger card-password-card"></span>   会员卡当前 <span class="red-font"> 需要 </span>使用密码消费.关闭密码消费?</h4>
			      	<div class="margin-top-px">
			      		<button class="btn btn-success" onclick="cardPasswordCancelWork();">关闭密码消费</button>
			      	</div>
			      </div>
		      </div>
		      <div role="tabpanel" class="tab-pane fade" id="cardPasswordChange" aria-labelledby="cardPasswordChange-tab">
		          <div class="col-sm-12 margin-top-px">
		          	<p class="text-danger text-left"><i class="fa fa-warning"></i>  默认会员卡密码为 123456</p>
		          	<p class="text-danger text-left"><i class="fa fa-warning"></i>  管理员可直接在此处充值会员卡密码</p>
		          	<div class="col-sm-4">
		          		<label for="">新密码:</label>
		          	</div>
		          	<div class="col-sm-8">
		          		<input type="password" class="form-control card-password-new" placeholder="输入新密码...">
		          	</div>
		          	<div class="col-sm-4 margin-top-px">
		          		<label for="">重复新密码:</label>
		          	</div>
		          	<div class="col-sm-8 margin-top-px">
		          		<input type="password" class="form-control card-password-new-copy" placeholder="重复输入的新密码...">
		          	</div>
		          	<div class="col-sm-12 text-right margin-top-px">
		          		<button class="btn btn-success " onclick="cardPasswordChangeWork();">确认修改密码</button>
		          	</div>
		          	<div hidden class="alert alert-danger alert-dismissible card-password-change-alert-error" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>ERROR!</strong> <span class="card-password-change-alert-error-text"></span>
					</div>
		          </div>
		      </div>
		    </div>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--卡的密码验证操作操作  modal-->
<div class="modal fade" id="cardPasswordCheckModal" tabindex="-1" role="dialog" aria-labelledby="cardPasswordCheckModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cardPasswordCheckModalLabel">消费密码验证</h4>
      </div>
      <div class="modal-body col-sm-12 text-center">
      	  <h4 class="margin-top-px"><i class="fa fa-info"></i>   请验证  <span class="red-font card-password-check-card"></span>  的会员卡密码</h4>
	      <div class="col-sm-8 margin-top-px">
	      	<input type="password" class="form-control card-password-check-input" placeholder="请输入密码...">
	      </div>
	      <div class="col-sm-4 margin-top-px">
	      	<button class="btn btn-success" onclick="consumeControllerPasswordWork();"> 验证密码</button>
	      </div>
      </div>
      <div hidden class="alert alert-danger alert-dismissible card-password-check-alert-error" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>ERROR!</strong> <span class="card-password-check-alert-error-text"></span>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--查找会员的modal  该modal 可以使用和添加用户时查找会员一样的modal  之后的查找会员都可以使用这个modal-->
<!--但是为了方便保存信息到全局的js函数，在此处进行function的改写！此处代码有冗余 暂未处理 详细查看js上的代码冗余部分-->
<div class="modal fade" id="showAllCardModal" tabindex="-1" role="dialog" aria-labelledby="showAllCardModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showAllCardModalLabel">查找会员</h4>
      </div>
      <div class="modal-body col-sm-12 ">
		<p class="text-danger col-sm-12"><i class="fa fa-info"></i>   <span class="alert-msg">可以查看所有会员或者通过手机号/姓名进行搜索</span></p>
		<div class="col-sm-12 ">
			<input type="text" class="search-card-text" style="width:100%" placeholder="输入姓名或手机号...">
		</div>
		<div class="col-ms-12">
			<div class="col-sm-4  margin-top-px">
				<button class="btn btn-default btn-sm" onclick="searchCardByPhone();"> <i class="fa fa-phone"></i> 按照手机号查找</button>
			</div>
			<div class="col-sm-4  margin-top-px">
				<button class="btn btn-default btn-sm" onclick="searchCardByName();"> <i class="fa fa-user"></i> 按照姓名查找</button>
			</div>
		</div>
		<div hidden class="col-sm-12 search-card-no">
			<div class="margin-top-px">
				<p class="text-success">搜索结果</p>
				<p class="text-danger search-card-no-msg"></p>
			</div>
		</div>
		<div hidden class="col-sm-12 search-card-ok">
			<div class="margin-top-px">
				<p class="text-success">搜索结果</p>
				<div class="search-card-ok-result">
					<div class="col-sm-3"><span class="card-search-guid">卡号</span></div>
					<div class="col-sm-3"><span class="card-search-name">姓名</span></div>
					<div class="col-sm-3"><span class="card-search-phone">手机号</span></div>
					<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-card-search"><i class="fa fa-check"></i> 选择</button></div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<hr>
		</div>
		<div class="col-sm-12">
			<button class="btn btn-default btn-sm" onclick="showAllCard();">点击查看所有会员  <i class="fa fa-chevron-down"></i></button>
			<div class="show-all-card">
				
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--充值modal-->
<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rechargeModalModalLabel">会员卡充值</h4>
      </div>
      <div class="modal-body col-sm-12 ">
			<p class="text-danger col-sm-12"><i class="fa fa-info"></i>   <span class="recharge-info">充值前请确认卡号和账户名称以及手机号码,避免充值错误!</span></p>
			<div  hidden class="alert alert-success alert-dismissible recharge-alert-success margin-top-px" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Success! </strong><span class="recharge-alert-success-msg">操作成功！</span> 
			</div>
			<div  hidden class="alert alert-danger alert-dismissible  recharge-alert-error margin-top-px" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error! </strong><span class=" recharge-alert-error-msg">操作失败</span> 
			</div>
			<div class="col-sm-12 ">
				<i class="fa fa-list"></i>  该卡类型为  <strong><span class="recharge-info-type red-font"></span></strong>
			</div>
			<div class="col-sm-12 ">
				<hr>
			</div>
			<div class="col-sm-12 ">
				<div class="col-sm-2"><i class="fa fa-credit-card"></i>  卡号</div>
				<div class="col-sm-3 text-center"><span class="recharge-info-card">000000</span></div>
				<div class="col-sm-2"><i class="fa fa-user"></i>  持卡人</div>
				<div class="col-sm-2 text-center"><span class="recharge-info-name">姓名</span></div>
				<div class="col-sm-2 text-center"><span class="recharge-info-phone">11111111111</span></div>
			</div>
			<div class="col-sm-12 ">
				<hr>
			</div>
			<div class="recharge-mcard">
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>实收金额：</span>
					</div>
					<div class="col-sm-6">
						<input type="number" class="recharge-mcard-money">
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>赠送金额：</span>
					</div>
					<div class="col-sm-6">
						<input type="number"  class="recharge-mcard-money-give">
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>合计金额：</span>
					</div>
					<div class="col-sm-5">
						<input  readonly="true"  disabled type="number"  class="recharge-mcard-money-total">
					</div>
					<div class="col-sm-4">
						<p class="text-danger">不可更改,自动计算</p>
					</div>
				</div>

				<div class="col-sm-12 text-right">
					<hr>
					<span>操作员工</span>
					<select class="recharge-mcard-emp"></select>
					<button class="btn btn-success btn-sm" onclick="rechargeMcardWork();">确认充值</button>
				</div>
			</div>
			<div hidden class="recharge-tcard">
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>充次金额：</span>
					</div>
					<div class="col-sm-6">
						<input type="number"  class="recharge-tcard-money">
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>服务项目：</span>
					</div>
					<div class="col-sm-6">
						<input type="text" readonly="true" disabled class="recharge-tcard-consume-type">
					</div>
					<div class="col-sm-3">
						<p class="text-danger">不可更改</p>
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>充值次数：</span>
					</div>
					<div class="col-sm-6">
						<input type="number"  class="recharge-tcard-count">
					</div>
				</div>
				<div  class="col-sm-12 text-right">
					<hr>
					<span>操作员工</span>
					<select class="recharge-tcard-emp"></select>
					<button class="btn btn-primary btn-sm" onclick="rechargeTcardWork();">确认充值</button>
				</div>
			</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--消费  modal-->
<div class="modal fade" id="consumeModal" tabindex="-1" role="dialog" aria-labelledby="consumeModalLabel">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="consumeModalLabel">会员卡消费</h4>
      </div>
      <div class="modal-body col-sm-12 ">
			<p class="text-danger col-sm-12"><i class="fa fa-info"></i>   <span class="consume-info">充值前请确认/卡号/账户名称/手机号码/消费金额/剩余金额/等,避免错误消费!</span></p>
			<div  hidden class="alert alert-success alert-dismissible consume-alert-success margin-top-px" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Success! </strong><span class="consume-alert-success-msg">操作成功！</span> 
			</div>
			<div  hidden class="alert alert-danger alert-dismissible  consume-alert-error margin-top-px" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error! </strong><span class=" consume-alert-error-msg">操作失败</span> 
			</div>
			<div class="col-sm-12 ">
				<i class="fa fa-list"></i>  该卡类型为  <strong><span class="consume-info-type red-font"></span></strong>
			</div>
			<div class="col-sm-12 ">
				<hr>
			</div>
			<div class="col-sm-12 ">
				<div class="col-sm-2"><i class="fa fa-credit-card"></i>  卡号</div>
				<div class="col-sm-3 text-center"><span class="consume-info-card">000000</span></div>
				<div class="col-sm-2"><i class="fa fa-user"></i>  持卡人</div>
				<div class="col-sm-2 text-center"><span class="consume-info-name">姓名</span></div>
				<div class="col-sm-2 text-center"><span class="consume-info-phone">11111111111</span></div>
			</div>
			<div class="col-sm-12 ">
				<hr>
			</div>
			<div class="consume-mcard">
				<div class="col-sm-12 ">
					<div class="col-sm-4"><i class="fa fa-money"></i> 会员卡余额</div>
					<div class="col-sm-3 text-center"><i class="fa fa-jpy"></i> <span class="consume-info-mcard-money red-font">0</span></div>
				</div>
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>本次消费金额：</span>
					</div>
					<div class="col-sm-4">
						<input type="number" class="consume-mcard-use-money">
					</div>
					<div class="col-sm-4">
						<label for="bigWork" style="cursor: pointer;"><input id="bigWork"type="checkbox" value="1">  <span>大活</span></label>
					</div>
				</div>
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>服务项目：</span>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-consume-type-1"></select>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-consume-type-2"></select>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-consume-type-3"></select>
					</div>
				</div>
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>员工</span>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-cemp-1"></select>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-cemp-2"></select>
					</div>
					<div class="col-sm-3">
						<select class="consume-info-cemp-3"></select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<span>点客</span>
					</div>
					<div class="col-sm-3">
						<label for="consumeEmpOrder1" style="cursor: pointer;"><input id="consumeEmpOrder1" type="checkbox" value="1">  <span>点客</span></label>
					</div>
					<div class="col-sm-3">
						<label for="consumeEOrder2" style="cursor: pointer;"><input id="consumeEOrder2" type="checkbox" value="1">  <span>点客</span></label>
					</div>
					<div class="col-sm-3">
						<label for="consumeEOrder3" style="cursor: pointer;"><input id="consumeEOrder3" type="checkbox" value="1">  <span>点客</span></label>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<span>备注</span>
					</div>
					<div class="col-sm-6">
						<textarea class="consume-info-mcard-comment" cols="50" rows="2" placeholder="备注...可以为空"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<p class="text-warning"><i class="fa fa-info"></i>  服务项目有几项则选择几项,如果只有一项,则后面的不需要进行选择,员工以及点客栏也不需要任何操作!</p>
				</div>
				<div class="col-sm-12 text-right">
					<hr>
					<span>操作员工</span>
					<select class="consume-mcard-emp"></select>
					<button class="btn btn-danger btn-sm" onclick="consumeMcardWork();">确认本次消费</button>
				</div>
			</div>
			<div hidden class="consume-tcard">
				<div class="col-sm-12">
					<div class="col-sm-4"><i class="fa fa-money"></i> 会员卡余额</div>
					<div class="col-sm-3 text-center"><i class="fa fa-jpy"></i> <span class="consume-info-tcard-money red-font">0</span></div>
					<div class="col-sm-3"><i class="fa fa-money"></i> 剩余次数</div>
					<div class="col-sm-2 text-center"><i class="fa fa-jpy"></i> <span class="consume-info-tcard-count red-font">0</span></div>
				</div>
				<div class="col-sm-12 margin-top-px">
					<div class="col-sm-3">
						<span>消费金额：</span>
					</div>
					<div class="col-sm-6">
						<input type="number"  class="consume-tcard-use-money">
					</div>
					<div class="col-sm-3">
						<label for="bigWorkTcard" style="cursor: pointer;"><input id="bigWorkTcard"type="checkbox" value="1">  <span>大活</span></label>
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>服务项目：</span>
					</div>
					<div class="col-sm-6">
						<input type="text" readonly="true" disabled class="consume-tcard-consume-type">
					</div>
					<div class="col-sm-3">
						<p class="text-danger">不可更改</p>
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>冲减次数：</span>
					</div>
					<div class="col-sm-6">
						<input type="number"  class="consume-tcard-count" value="1" disabled readonly>
					</div>
					<div class="col-sm-3">
						<p class="text-danger">不可更改</p>
					</div>
				</div>
				<div class="col-sm-12  margin-top-px">
					<div class="col-sm-3">
						<span>服务员工：</span>
					</div>
					<div class="col-sm-3">
						<select class="consume-tcard-consume-emp"></select>
					</div>
					<div class="col-sm-3">
						<label for="tcardEmpOrder" style="cursor: pointer;"><input id="tcardEmpOrder" type="checkbox" value="1">  <span>点客</span></label>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="col-sm-3">
						<span>备注</span>
					</div>
					<div class="col-sm-6">
						<textarea class="consume-info-tcard-comment" cols="50" rows="2" placeholder="备注...可以为空"></textarea>
					</div>
				</div>
				<div  class="col-sm-12 text-right">
					<hr>
					<span>操作员工</span>
					<select class="consume-tcard-emp"></select>
					<button class="btn btn-warning btn-sm" onclick="consumeTcardWork();">确认本次消费</button>
				</div>
			</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--显示 已付提成的 modal-->
<div class="modal fade" id="showPayLevelModal" tabindex="-1" role="dialog" aria-labelledby="showPayLevelModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showPayLevelModalLabel"><i class="fa fa-credit-card "></i>  <span class="red-font show-pay-level-card"></span>  已付提成</h4>
      </div>
      <div class="modal-body col-sm-12 show-pay-level-box">
	      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--显示 未付提成的 modal-->
<div class="modal fade" id="showNoPayLevelModal" tabindex="-1" role="dialog" aria-labelledby="showNoPayLevelModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="showNoPayLevelModalLabel"><i class="fa fa-credit-card "></i>  <span class="red-font show-no-pay-level-card"></span>  未付提成</h4>
      </div>
      <div class="modal-body col-sm-12 show-no-pay-level-box">
	     
      </div>
    <div class="modal-footer">
   	    <hr>
      	<p class="text-danger text-left"><i class="fa fa-info"></i>  进行一键确认支付前请仔细核对未提成金额,避免错误确认!</p>
        <button type="button" class="btn btn-success btn-sm pull-left show-no-pay-level-btn" onclick="payAllNoPayLevelController();" >一键确认支付</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!--container content box-->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-sm-6 " style="min-height: 220px;">
				<div class="panel panel-default ">
				  <div class="panel-body">
				    <div class="input-group col-sm-12">
				    	<span class="input-group-addon "><i class="fa fa-credit-card "></i>  刷卡：  </span>
				    	<input type="text" class="form-control form-xs card-input-text" placeholder="点击刷卡或右侧查找...">
				    	 <span class="input-group-btn"><button class="btn btn-success " onclick="showCardInfo();">确认</button></span>
				    	 <span class="input-group-btn" style="">&nbsp;&nbsp;</span>
				    	 <span class="input-group-addon" style="background-color: #fff;border:0px;padding:0px;padding-left:3px;"><img style="cursor: pointer;"src="/barbershopums/Public/images/icon/search-b.png" title="从已有卡中查找"width="20px" onclick="searchAllCard();"></span>
				    </div>
				   	<div class="col-sm-12 margin-top-px">
				   		<div class="col-sm-4 primary-box text-center user-select-item-box" onclick="rechargeController();">
				   			<span><i class="fa fa-plus-square-o"></i>  充值</span>
				   		</div>
				   		<div class="col-sm-2"></div>
				   		<div class="col-sm-4  primary-box text-center user-select-item-box" onclick="consumeControllerPassword();">
				   			<span><i class="fa fa-jpy"></i>  消费</span>
				   		</div>
				   		<div class="col-sm-4  primary-box margin-top-px text-center user-select-item-box"  onclick="searchInfoController();">
				   			<span><i class="fa fa-search-plus"></i>  查询</span>
				   		</div>
				   		<div class="col-sm-2"></div>
				   		<div class="col-sm-4  warning-box margin-top-px text-center user-select-item-box"  onclick="cardInfoController();">
				   			<span><i class="fa fa-credit-card-alt"></i>  卡务</span>
				   		</div>
				   	</div>	
				  </div>
				</div>
				<div hidden class="panel panel-default search-info-box">
				  <div class="panel-body">
				  <div class="col-sm-12">
				  	<span><i class="fa fa-th-large"></i>  查询功能菜单</span>
				  </div>
				   	<div class="col-sm-12 margin-top-px">
				   		<div class="col-sm-4 text-center" onclick="searchRechargeInfoController();">
				   			<button class="btn btn-default "><i class="fa fa-file-excel-o"></i>  充值记录</button>
				   		</div>
				   		<div class="col-sm-2"></div>
				   		<div class="col-sm-4  text-center" onclick="searchConsumeInfoController();">
				   			<button class="btn btn-default " ><i class="fa fa-file-excel-o"></i>  消费记录</button>
				   		</div>
				   		<div class="col-sm-4   margin-top-px text-center"  onclick="searchLevelInfoController();">
				   		<button class="btn btn-default " ><i class="fa fa-file-excel-o"></i>  提成关系</button>
				   		</div>
				   		<div class="col-sm-2"></div>
				   	</div>	
				  </div>
				</div>
				<div hidden class="panel panel-default card-info-box">
				  <div class="panel-body">
				   	<div class="col-sm-12 margin-top-px">
				   		<div class="col-sm-4 text-center" onclick="cardLossController();">
				   			<button class="btn btn-default "><i class="fa fa-ban"></i>  挂失/解除挂失</button>
				   		</div>
				   		<div class="col-sm-2"></div>
				   		<div class="col-sm-4 text-center" onclick="cardOffController();">
				   			<button class="btn btn-default "><i class="fa fa-power-off"></i>  会员卡注销</button>
				   		</div>
				   		<div class="col-sm-4 margin-top-px text-center"  onclick="cardReissueController();">
				   			<button class="btn btn-default "><i class="fa fa-clone"></i>  补办会员卡</button>
				   		</div>
				   		<div class="col-sm-2"></div>
				   		<div class="col-sm-4 margin-top-px text-center"  onclick="cardPasswordController();">
				   			<button class="btn btn-default "><i class="fa fa-key"></i>  密码消费</button>
				   		</div>
				   	</div>	
				  </div>
				</div>
			</div>
			<div  class="col-sm-6 card-info-no white-font"style="padding-top: 50px;">
				<div class="text-center" >
					<p><i class="fa fa-warning fa-2x"></i></p>
					<p class="card-info-no-msg">请刷卡或者查找会员卡</p>
					<p class="red-font"><strong>点击确认后查询会员卡信息!</strong></p>
				</div>
			</div>
			<div hidden class="col-sm-3 card-info-user-ok">
				<li class="list-group-item active">
					<i class="fa fa-credit-card"></i>  <strong><span class="card-info-guid ">111111</span></strong> 的会员信息
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-user"></i>  持有人</div>
					<div class="span-middle  text-center"> <span class="card-info-name">李瞻文</span>  （<span class="card-info-sex">男</span>）</div>
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-phone-square"></i>  手机号</div>
					<div class="span-middle  text-center"> <span class="card-info-phone">13816244919</span></div>
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-birthday-cake"></i>  生日</div>
					<div class="span-middle  text-center"> <span class="card-info-birth">1995-08-08</span></div>
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-clock-o"></i>  注册时间</div>
					<div class="span-middle  text-center"> <span class="card-info-regtime">1995-08-08</span></div>
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-users"></i> 推荐人卡号</div>
					<div class="span-middle  text-center"> <span class="card-info-upcard">11111111</span></div>
				</li>
				<li class="list-group-item">
					<div class="span-middle "><i class="fa fa-user-plus"></i> 办理员工</div>
					<div class="span-middle  text-center"> <span class="card-info-emp">11111111</span></div>
				</li>
			</div>
			<div hidden class="col-sm-3 card-info-m-ok">
				<li class="list-group-item active"><i class="fa fa-credit-card"></i>  <strong><span class="card-info-guid ">111111</span></strong> 的账户信息</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-list"></i>  类型</div>
					<div class="span-middle  text-center"> <span class="card-info-type red-font">充值金额卡</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><span class="red-font"><i class="fa fa-money"></i>  剩余金额</span></div>
					<div class="span-middle text-center"> <i class="fa fa-jpy"> </i>  <span class="card-info-money">200</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-money"></i>  注册金额</div>
					<div class="span-middle  text-center"> <i class="fa fa-jpy"></i>  <span class="card-info-regmoney">200</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-balance-scale"></i>  卡内积分</div>
					<div class="span-middle  text-center">  <span class="card-info-inte">0</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-user-secret"></i>  密码消费</div>
					<div class="span-middle  text-center">  <span class="card-info-password-active red-font">否</span></div>
				</li>
			</div>
			<div hidden class="col-sm-3 card-info-t-ok">
				<li class="list-group-item active"><i class="fa fa-credit-card"></i>  <strong><span class="card-info-guid ">111111</span></strong> 的账户信息</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-list"></i>  卡类型</div>
					<div class="span-middle  text-center"> <span class="card-info-type red-font">充值次数卡</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-street-view"></i>  服务类型</div>
					<div class="span-middle  text-center"> <span class="card-info-consume-type">剪发</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><span class="red-font" ><i class="fa fa-money"></i>  剩余金额</span></div>
					<div class="span-middle text-center"> <i class="fa fa-jpy"> </i>  <span class="card-info-money">200</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-money"></i>  注册金额</div>
					<div class="span-middle  text-center"> <i class="fa fa-jpy"></i>  <span class="card-info-regmoney">200</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><span  class="red-font"><i class="fa fa-plus-square-o"></i>  剩余次数</span></div>
					<div class="span-middle  text-center"><span class="card-info-regcount">10</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-minus-square-o"></i>  已使用次数</div>
					<div class="span-middle  text-center"><span class="card-info-usecount">10</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-balance-scale"></i>  卡内积分</div>
					<div class="span-middle  text-center">  <span class="card-info-inte">0</span></div>
				</li>
				<li class="list-group-item ">
					<div class="span-middle "><i class="fa fa-user-secret"></i>  密码消费</div>
					<div class="span-middle  text-center">  <span class="card-info-password-active red-font">否</span></div>
				</li>
			</div>
		</div>
	</div><!--row-->
	<!--查询的框-->
	<div class="row search-result-row">
		<div class="col-md-12 search-result-box">
			<!--充值记录-->
			<div hidden class="panel panel-default search-info-box-recharge">
				<div class="panel-heading">
					<h4><span class="red-font search-info-box-recharge-card"></span>  充值记录</h4>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-sm-3">
							<div class="col-sm-6"><h4>充值次数 : </h4></div>
							<div class="col-sm-6"><h4><span class="recharge-total-count red-font">0</span></h4></div>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-6"><h4>充值金额 : </h4></div>
							<div class="col-sm-6"><h4><i class="fa fa-jpy"></i>   <span class="recharge-total-money red-font">0</span></h4></div>
						</div>
					</div>
					<div class="col-sm-12 recharge-info-table-box">
						
					</div>
				</div>
			</div>
			<!--消费记录-->
			<div hidden class="panel panel-default search-info-box-consume">
				<div class="panel-heading">
					<h4><span class="red-font search-info-box-consume-card"></span>  消费记录</h4>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-sm-3">
							<div class="col-sm-6"><h4>消费次数 : </h4></div>
							<div class="col-sm-6"><h4><span class="consume-total-count red-font">0</span></h4></div>
						</div>
						<div class="col-sm-3">
							<div class="col-sm-6"><h4>消费金额 : </h4></div>
							<div class="col-sm-6"><h4><i class="fa fa-jpy"></i>   <span class="consume-total-money red-font">0</span></h4></div>
						</div>
					</div>
					<div class="col-sm-12 consume-info-table-box">
						
					</div>
				</div>
			</div>
			<!--等级记录-->
			<div hidden class="panel panel-default search-info-box-level">
				<div class="panel-heading">
					<h4>
						<span class="red-font search-info-box-level-card"></span>  等级提成一览
						<button class="btn btn-default  pull-right" style="margin-right:20px;" onclick="showPayLevelHistory();"><i class="fa fa-check"></i>  查看已付提成</button>
						<button class="btn btn-primary   pull-right"  style="margin-right:20px;"onclick="showNoPayLevelHistory();"><i class="fa fa-times"></i>  查看未付提成</button>
					</h4>
				</div>
				<div class="panel-body">
					<div class="col-sm-12">
						<div class="col-sm-4">
							<div class="col-sm-6"><h4>提成收入(总计) : </h4></div>
							<div class="col-sm-3 text-center"><h4><span class="level-total-count red-font">0</span> 次</h4></div>
							<div class="col-sm-3 text-center"><h4><i class="fa fa-jpy"></i>   <span class="level-total-money red-font">0</span></h4></div>
						</div>
						<div class="col-sm-4">
							<div class="col-sm-6"><h4>已付提成 : </h4></div>
							<div class="col-sm-3 text-center"><h4><span class="level-pay-count red-font">0</span> 次</h4></div>
							<div class="col-sm-3 text-center"><h4><i class="fa fa-jpy"></i>   <span class="level-pay-money red-font">0</span></h4></div>
						</div>
						<div class="col-sm-4">
							<div class="col-sm-6"><h4>未付提成 : </h4></div>
							<div class="col-sm-3 text-center"><h4><span class="level-nopay-count red-font">0</span> 次</h4></div>
							<div class="col-sm-3 text-center"><h4><i class="fa fa-jpy"></i>   <span class="level-nopay-money red-font">0</span></h4></div>
						</div>
					</div>
					<div class="col-sm-12">
						<hr>
						<p class="text-danger"><i class="fa fa-info"></i>：  会员提成支付可以在「查看未付提成」按钮中进行一键支付.</p>
						<p class="text-danger"><i class="fa fa-info"></i>：  下述提成收入结构第一级(根)是当前卡本身,往后依次为二级会员(当前卡下属会员)、三级会员...共五级.</p>
						<p class="text-danger"><i class="fa fa-info"></i>：  点击下属会员会在下一级显示该下属会员推荐的会员,以此构成树结构.(第5级没有点击查看功能).</p>
						<p class="text-danger"><i class="fa fa-info"></i>：  注册金额因通过计算得出,可能由于浮点移动导致计算误差,提成比例与提成金额没有差错.</p>
					</div>
					<div class=" level-info-table-box">
					<hr>
						<div class="col-sm-12 margin-top-px level-info-user-1" LEVEL="1">
							<div class="col-sm-2 ">
								<img src="/barbershopums/Public/images/icon/v1.png" width="80px;"alt="v1">
								<p>本卡办卡提成</p>
							</div>
							<div class="col-sm-10  level-info-box-1">
								<div class="level-user-info-box level-user-info-box-root  text-center center-block" CARD="">
									<p class="text-danger"><i class="fa fa-user"></i>   <span class="level-user-info-box-root-card">0</span>   (本卡)  </p>
									<p class="">注册金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-root-regmoney">0</span></p>
									<p class="">提成金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-root-money">0</span></p>
									<p class="level-user-info-box-root-btn"></p>
								</div>
							</div>
						</div>
						<div class="col-sm-12 margin-top-px level-info-user-2" LEVEL="2">
							<div class="col-sm-2 ">
								<img src="/barbershopums/Public/images/icon/v2.png" width="80px;"alt="v2">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-2"></span></p>
							</div>
							<div class="col-sm-10 level-info-box-2">
								
							</div>
						</div>
						<div class="col-sm-12 margin-top-px level-info-user-3" LEVEL="3">
							<div class="col-sm-2 ">
								<img src="/barbershopums/Public/images/icon/v3.png" width="80px;"alt="v3">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-3"></span></p>
							</div>
							<div class="col-sm-10  level-info-box-3"></div>
						</div>
						<div class="col-sm-12 margin-top-px level-info-user-4" LEVEL="4">
							<div class="col-sm-2 ">
								<img src="/barbershopums/Public/images/icon/v4.png" width="80px;"alt="v4">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-4"></span></p>
							</div>
							<div class="col-sm-10  level-info-box-4"></div>
						</div>
						<div class="col-sm-12 margin-top-px level-info-user-5" LEVEL="5" style="margin-bottom:30px;">
							<div class="col-sm-2 ">
								<img src="/barbershopums/Public/images/icon/v5.png" width="80px;"alt="v5">
								<p>上级会员<br><i class="fa fa-user"></i> <span class="level-up-user-card-5"></span></p>
							</div>
							<div class="col-sm-10  level-info-box-5"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



</body>
<script>
	$("document").ready(function(){
		addActiveClass("navbar-link-2");
		initCard();
	});
	
	
</script>
	<script  src="/barbershopums/Public/js/all.js"></script>
</html>