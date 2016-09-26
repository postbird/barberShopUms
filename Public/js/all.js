/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
/***************************************通用的js函数*************************************/
//阻止click的冒泡事件  主要用在显示等级会员上

//此处定义全局变量
window.ajaxUrl="http://localhost/barbershopums/index.php/Home"
// window.ajaxUrl="http://127.0.0.1/barbershopums/index.php/Home"
cardInfo=null;//用于保存卡的信息  进行相关的操作时不用再次请求数据库
cardConsumeType=new Array();
allEmp=new Array();//用于保存所有的员工信息,后面都要用,开了一个新js函数 API不变
allPayUpCard=null;//用于保存所有的等级关系
allCard=new Array();
allReport=new Object();//存储返回的报表消息  进行相关数据的初始化0操作	
allReport.allCardCount=0;
allReport.allMcardRegMoney=0;
allReport.allTcardRegMoney=0;
allReport.allConsumeMoney=0;
allReport.allCardOffMoney=0;
allReport.allMcardMoney=0;
allReport.allTcardMoney=0;
allReport.allManCount=0;
allReport.allWomanCount=0;
allReport.allConsumeCount=0;
allReport.allConsumeBigCount=0;
allReport.allConsumeOrderCount=0;
userShowInfo=null;//用于保存用户查询的时候卡的信息
userShowPayUpCard=null;//用于用户查询时候保存的上下级关系


//去掉字符串两边空格
String.prototype.trim=function() { return this.replace(/(^\s*)|(\s*$)/g, ""); }
//当前页面的active选项的添加  参数是css类名
function addActiveClass(cl){
	$("."+cl).addClass("active");
}
//用于显示modal 参数是modal的id
function showModalController(modalID){
	$('#'+modalID).modal("show");
}
//用于隐藏modal 参数是modal的id
function hideModalController(modalID){
	$('#'+modalID).modal("hide");
}
//用于提示alert 的modal
function showErrorModal(msg){
	$(".modal").modal("hide");
	$(".alert-msg").text(msg);
	$("#msModal").modal("show");
}
//用于自己构建的confirm框  
//第一个参数是显示的文字  第二个参数是调用的函数的名字加载到onclick上
function showConfirmModal(msg,func){
	$(".modal").modal("hide");
	$(".confirm-modal-btn").attr("onclick","");
	$(".confirm-msg").text(msg);
	$(".confirm-modal-btn").attr("onclick",func);
	$("#confirmModal").modal("show");
}
/****************************************系统页面的 js**************************************/
//显示消费类型的设置
function showSysConsumeControl(obj){
	showSysControl(obj);
	searchConsumeType();//结果保存在 cardConsumeType全局变量中
	var htm='<tr>'+
			'<th>标号</th>'+
			'<th>服务项目名称</th>'+
			'<th>操作</th>'+
			'</tr>';
	if(cardConsumeType!=null){
		for(var i=0;i<cardConsumeType.length;i++){
			htm+='<tr>'+
		'<td>'+cardConsumeType[i].ctype_id+'</td>'+
		'<td>'+cardConsumeType[i].ctype_name+'</td>'+
		'<td><button class="btn btn-danger btn-sm" GUID="'+cardConsumeType[i].ctype_id+'" onclick="deleteConsumeType(this)">删除</button></td>'+
		'<tr>';
		}
	}

	$(".consume-show-table").html(htm);
}
//添加消费类型 
// API /System/addConsumeType  参数  type:名称
function addSysConsumeWork(){

	var ctypeName=$(".add-consume-type-text").val().trim();
	if(ctypeName.length==0){
		$(".add-consume-type-success-alert").hide();
		$(".add-consume-type-error-alert-text").text("名称不能为空!");
		$(".add-consume-type-error-alert").fadeIn();
		setInterval(function(){$(".add-consume-type-error-alert").fadeOut();},3000);
		return 0;
	}else{
		if(cardConsumeType!=null){
			for(var i=0;i<cardConsumeType.length;i++){
				if(cardConsumeType[i].ctype_name==ctypeName){
					$(".add-consume-type-success-alert").hide();
					$(".add-consume-type-error-alert-text").text("该名称已经存在!");
					$(".add-consume-type-error-alert").fadeIn();
					setInterval(function(){$(".add-consume-type-error-alert").fadeOut();},3000);
					return ;
				}
			}
		}
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/addConsumeType",
        data:"type="+ctypeName,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".add-consume-type-error-alert").hide();
            	$(".add-consume-type-success-alert-text").text(data.msg);
				$(".add-consume-type-success-alert").fadeIn();
				setInterval(function(){$(".add-consume-type-success-alert").fadeOut();},3000);
				searchConsumeType();//结果保存在 cardConsumeType全局变量中
				var htm='<tr>'+
						'<th>标号</th>'+
						'<th>服务项目名称</th>'+
						'<th>操作</th>'+
						'</tr>';
				for(var i=0;i<cardConsumeType.length;i++){
					htm+='<tr>'+
						'<td>'+cardConsumeType[i].ctype_id+'</td>'+
						'<td>'+cardConsumeType[i].ctype_name+'</td>'+
						'<td><button class="btn btn-danger btn-sm" GUID="'+cardConsumeType[i].ctype_id+'" onclick="deleteConsumeType(this)">删除</button></td>'+
						'<tr>';
				}
				$(".consume-show-table").html(htm);
            }else{
            	$(".add-consume-type-success-alert").hide();
				$(".add-consume-type-error-alert-text").text(data.msg);
				$(".add-consume-type-error-alert").fadeIn();
				setInterval(function(){$(".add-consume-type-error-alert").fadeOut();},3000);
            }
        }
	});
}
//function  删除消费类型 直接删除好了  不需要验证了
// API /System/deleteConsumeType   参数 type:消费类型的id
function deleteConsumeType(obj){
	var cTypeId=$(obj).attr("GUID");
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/deleteConsumeType",
        data:"type="+cTypeId,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".add-consume-type-error-alert").hide();
            	$(".add-consume-type-success-alert-text").text(data.msg);
				$(".add-consume-type-success-alert").fadeIn();
				setInterval(function(){$(".add-consume-type-success-alert").fadeOut();},3000);
				searchConsumeType();//结果保存在 cardConsumeType全局变量中
				var htm='<tr>'+
						'<th>标号</th>'+
						'<th>服务项目名称</th>'+
						'<th>操作</th>'+
						'</tr>';
				for(var i=0;i<cardConsumeType.length;i++){
					htm+='<tr>'+
						'<td>'+cardConsumeType[i].ctype_id+'</td>'+
						'<td>'+cardConsumeType[i].ctype_name+'</td>'+
						'<td><button class="btn btn-danger btn-sm" GUID="'+cardConsumeType[i].ctype_id+'" onclick="deleteConsumeType(this)">删除</button></td>'+
						'<tr>';
				}
				$(".consume-show-table").html(htm);
            }else{
            	$(".add-consume-type-success-alert").hide();
				$(".add-consume-type-error-alert-text").text(data.msg);
				$(".add-consume-type-error-alert").fadeIn();
				setInterval(function(){$(".add-consume-type-error-alert").fadeOut();},3000);
            }
        }
	});
}

//用于系统设置页面的box显示
function showSysControl(obj){
	$(".sys-nav-box").removeClass("sys-active");
	$(".sys-content-box").addClass("hidden");
	$(obj).addClass("sys-active");
	$("."+$(obj).attr("GUCLASS")).removeClass("hidden");
}
//用户显示和修改消费积分问题
function showConsumeInte(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showConsumeInte",
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".consume-inte-text").val(data.ci_money);
            }else{
				$(".consume-inte-text").val(1);
            }
        }
	});
}
function editConsumeInte(){
	var ciMoney=$(".consume-inte-text").val().trim();
	if(ciMoney<1){
		showErrorModal("最少为 1 ！");
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/editConsumeInte",
        data:"cimoney="+ciMoney,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	showConsumeInte();
            	$(".edit-consume-success-alert").show();
            }else{
				showErrorModal("修改消费积分失败，请重试！");
				return;
            }
        }
	});
}

//员工box  用于同时调用多个函数
function showSysEmpControl(obj){
	showSysControl(obj);
	showEmp();
}
//员工管理请求数据
function showEmp(){
	$(".emp-show-table").html('<tbody><tr>'+
								'<th>员工编号</th>'+
								'<th>姓名</th>'+
								'<th>密码(加密显示)</th>'+
								'<th>修改</th>'+
								'<th>删除</th>'+
							'</tr><tbody>');
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showEmp",
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".emp-no-show").hide();
            	for(var i=0;i<data.emp.length;i++){
            		var htm='<tr><td class="emp-'+i+'-id">'+data.emp[i].emp_id+'</td><td class="emp-'+i+'-name">'+data.emp[i].emp_name+'</td><td class="emp-'+i+'-password">'+data.emp[i].emp_password+'</td><td><i empGUID="'+i+'"class="fa fa-edit fa-2x" onclick="editEmpController('+i+')"></i></td><td empGUID="'+i+'"><i onclick="deleteEmpController('+i+');"class="fa fa-trash-o  fa-2x"></i></td></tr>';
            		$(".emp-show-table").append(htm);
            	}
            	$(".emp-show-table").show();
            }else{
				$(".emp-no-show").show();
            	$(".emp-show-table").hide();
            }
        }
	});
}
//添加新员工的controller
function addEmpController(modalID){
	$(".add-emp-name").val("");
	$(".add-emp-password").val("123456");
	showModalController(modalID);
}
//添加新员工work
function addEmpWork(){
	hideModalController("addEmpModal");
	var empName=$(".add-emp-name").val().trim();
	var empPassword=$(".add-emp-password").val().trim();
	if(empName.length==0 || empPassword.length==0){
		showErrorModal("信息填写不完整");
		return;
	}else{
		$.ajax({
        dataType: "json",
        url: ajaxUrl+"/System/addEmp",
        data: "empname="+empName+"&emppassword="+empPassword,
        cache: false,
        async: true,
        success: function (data) {
           if(data.status=="ok"){
 				showEmp();
           }else{
            	showErrorModal("添加失败，请重试！");
           }
        }
    });
	}
}
//编辑员工信息
function editEmpController(obt){
	$(".edit-emp-id").val($(".emp-"+obt+"-id").text());
	$(".edit-emp-name").val($(".emp-"+obt+"-name").text());
	$(".edit-emp-password").val("");
	showModalController("editEmpModal");
}
//编辑员工信息保存
function editEmpWork(){
	hideModalController("editEmpModal");
	var empId=$(".edit-emp-id").val().trim();
	var empName=$(".edit-emp-name").val().trim();
	var empPassword=$(".edit-emp-password").val().trim();
	if(empPassword.length==0){
		empPassword=null;
	}
	$.ajax({
        dataType: "json",
        url: ajaxUrl+"/System/editEmp",
        data: "empname="+empName+"&emppassword="+empPassword+"&empid="+empId,
        cache: false,
        async: true,
        success: function (data) {
           if(data.status=="ok"){
 				showEmp();
           }else{
            	showErrorModal("修改失败，请重试！");
           }
        }
    });
//删除员工
}
function deleteEmpController(obt){
	$(".delete-emp-id").text($(".emp-"+obt+"-id").text());
	$(".delete-emp-name").text($(".emp-"+obt+"-name").text());
	showModalController("deleteEmpModal");
}
//删除员工work
function deleteEmpWork(){
	hideModalController("deleteEmpModal");
	var empId=$(".delete-emp-id").text().trim();
	$.ajax({
        dataType: "json",
        url: ajaxUrl+"/System/deleteEmp",
        data: "empid="+empId,
        cache: false,
        async: true,
        success: function (data) {
           if(data.status=="ok"){
 				showEmp();
           }else{
            	showErrorModal("删除失败，请重试！");
           }
        }
    });	

}
function showLevelController(obj){
	showSysControl(obj);
	 showLevel();
}
//查看level 提成比例
function showLevel(){
	$(".level-show-table").html("");
	$.ajax({
        dataType: "json",
        url: ajaxUrl+"/System/showLevel",
        cache: false,
        async: true,
        success: function (data) {
           if(data.status=="ok"){
           		var htm="<tbody><tr><th>级别</th><th>提成比例</th></tr>";
				for(var i=0;i<data.level.length;i++){
					htm+='<tr><td>第 '+data.level[i].level_rank+' 级</td><td>'+data.level[i].level_money+'  %</td><tr>';
				}
				htm+="</tbody>";
				$(".level-show-table").html(htm);
           }else{
            	var htm='<i class="fa fa-warning"></i>  查询失败！';
            	$(".level-show-table").html(htm);
           }
        }
    });	
}
////修改管理员登录密码显示 控制
function editAdminPasswordController(obj){
	$(".old-admin-password").val("");
	$(".new-admin-password").val("");
	$(".new-admin-password-again").val("");

	showSysControl(obj);
}
//修改管理员登录密码
function editAdminPassword(){
	var oldAdminPassword=$(".old-admin-password").val().trim();
	var newAdminPassword=$(".new-admin-password").val().trim();
	var newAdminPasswordAgain=$(".new-admin-password-again").val().trim();
	if(newAdminPassword != newAdminPasswordAgain){
		$(".edit-admin-alert").hide();
		$(".edit-admin-password-alert-msg-error").text(" 两次密码不一致！ ");
		$(".edit-admin-password-alert-error").show();
		return;
	}
	if(newAdminPassword == oldAdminPassword){
		$(".edit-admin-alert").hide();
		$(".edit-admin-password-alert-msg-error").text(" 新旧密码不能一样！ ");
		$(".edit-admin-password-alert-error").show();
		return;
	}
	$.ajax({
        dataType: "json",
        url: ajaxUrl+"/System/editAdminPassword",
        data:"oldadminpassword="+oldAdminPassword+"&newadminpassword="+newAdminPassword+"&newadminpasswordagain="+newAdminPasswordAgain,
        cache: false,
        async: true,
        success: function (data) {
           if(data.status=="ok"){
         	  	$(".edit-admin-alert").hide();
           		$(".edit-admin-password-alert-msg").text(data.msg);
				$(".edit-admin-password-alert").show();
				$(".old-admin-password").val("");
				$(".new-admin-password").val("");
				$(".new-admin-password-again").val("");
           }else{
				$(".edit-admin-alert").hide();
            	$(".edit-admin-password-alert-msg-error").text(data.msg);
				$(".edit-admin-password-alert-error").show();
           }
        }
    });	
}
/***************************************登录页面的js******************************************/
//此函数用于登录页面的公告效果，同样用于欢迎页面的上下拉动效果
$(".login-up-message-btn-up").click(function(){
	$(".login-message").slideUp();
	$(".login-message-hidden").show();
});
$(".login-up-message-btn-down").click(function(){
	$(".login-message").slideDown();
	$(".login-message-hidden").hide();
});


/***************************************功能页面的js******************************************/

/***************************************添加新卡的js******************************************/

//也就是初始化办理新卡的页面同时|显示出员工以及消费类型以供选择|进行金额的绑定
function initAddUser(){
	moneyCaculator();
	showNowEmpList();
	showConsumeType();
}
//进行金额的绑定和计算
function moneyCaculator(){
	$('.new-mcard-money').bind('input propertychange', function() {
    	$('.new-mcard-money-total').val($('.new-mcard-money').val()*1.00+$('.new-mcard-money-give').val()*1.00);
	});
	$('.new-mcard-money-give').bind('input propertychange', function() {
    	$('.new-mcard-money-total').val($('.new-mcard-money').val()*1.00+$('.new-mcard-money-give').val()*1.00);
	});
}
//初始化显示当前的员工（该函数可以通用于所有需要员工的地方）
//通用子函数
//与上面不同的是，该函数是为了构造一个select 而上面的会员管理则不是
//当然使用的API是一样的
function showNowEmpList(){
	$(".no-emp-alert-msg").hide();
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showEmp",
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	var htm="";
            	for(var i=0;i<data.emp.length;i++){
            		htm+='<option value="'+data.emp[i].emp_id+'">'+data.emp[i].emp_name+'</optipn>';
            	}	
            	$(".new-card-emp").html(htm);
            }else{
				$(".no-emp-alert-msg").show();
				return;
            }
        }
	});
}
//用于查找上属会员的modal
function showNewCardUpcard(){
	showAllUser();
	$("#newCardUpcardModal").modal("show");
}
//用于返回所有的会员并在modal中显示
// API为通用API 用于返回所有的会员结果或者搜索结果
function showAllUser(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showAllUser",
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".no-search-upcard").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="upcard-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-upcard-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisUpCard(this);"><i class="fa fa-check"></i> 选择</button></div>'+
						'<br>';
            		}
            	}	
            	$(".show-all-upcard").html(htm);
            }else{
				$(".no-search-upcard").show();
				$(".no-search-upcard-msg").text(data.msg);
				$(".search-upcard").hide();
				return;
            }
        }
	});
}
//用于返回搜索结果
// API为通用API 进行手机号或者姓名查询  
//查询flag为 search 1表示手机号 0表示姓名(必需参数)

//通过手机号查询
function searchUserByPhone(){
	var phone=$(".search-upcard-text").val().trim();
	if(phone.length!=11){
		$(".search-upcard").hide();
		$(".no-search-upcard").show();
		$(".no-search-upcard-msg").text("手机号格式不正确!");
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/searchUser",
        cache: false,
        async: true,
        data:"search=1&phone="+phone,
        success: function (data) {
            if(data.status=="ok"){
            	$(".no-search-upcard").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="upcard-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-upcard-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisUpCard(this);"><i class="fa fa-check"></i> 选择</button></div>';
            		}
            	}	
            	$(".search-upcard-result").html(htm);
            	$(".search-upcard").show();
            }else{
            	$(".search-upcard").hide();
				$(".no-search-upcard").show();
				$(".no-search-upcard-msg").text(data.msg);
				return;
            }
        }
	});
}	
//通过姓名模糊查询
function searchUserByName(){
	var name=$(".search-upcard-text").val().trim();
	if(name.length==0){
		$(".search-upcard").hide();
		$(".no-search-upcard").show();
		$(".no-search-upcard-msg").text("名称不能为空!");
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/searchUser",
        cache: false,
        async: true,
        data:"search=0&name="+name,
        success: function (data) {
            if(data.status=="ok"){
            	$(".no-search-upcard").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="upcard-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-upcard-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisUpCard(this);"><i class="fa fa-check"></i> 选择</button></div>';
            		}
            	}	
            	$(".search-upcard-result").html(htm);
            	$(".search-upcard").show();
            }else{
            	$(".search-upcard").hide();
				$(".no-search-upcard").show();
				$(".no-search-upcard-msg").text(data.msg);
				return;
            }
        }
	});
}
//选择上属会员 通过点击选择按钮
function selectThisUpCard(obj){
	$(".new-card-upcard").val($(obj).attr("CARD_GUID"));
	$("#newCardUpcardModal").modal("hide");
}	
//请求显示消费类型  使用的是通用的API 请求路径在System/showConsumeType
function showConsumeType(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showConsumeType",
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	var htm="";
            	for(var i=0;i<data.consumeType.length;i++){
            		htm+='<option value="'+data.consumeType[i].ctype_id+'">'+data.consumeType[i].ctype_name+'</option>';
            	}	
            	$(".new-tard-consume-type").html(htm);
            }else{
            	console.log("消费类型-请求失败!");
				return;
            }
        }
	});
}


//添加新卡  两种卡 一种金额卡 一种次数卡
//add 为添加的flag  1 表示金额卡 0 表示次数卡
function addNewUserMcard(){
	var cardGuid=$(".new-card-text").val().trim();
	var name=$(".new-card-name").val().trim();
	var sex=$(".new-card-sex").val().trim();
	var birth=$(".new-card-birth").val().trim();
	var phone=$(".new-card-phone").val().trim();
	var emp=$(".new-card-emp").val().trim();
	var upcard=$(".new-card-upcard").val().trim();
	var password=$(".new-card-password").val().trim();

	if(upcard.length==0){
		upcard=0;
	}
	var regMoney=$(".new-mcard-money-total").val();
	if(cardGuid.length==0 || name.length==0 || phone.length==0 ||regMoney<=0 ||password.length==0){
		$('.add-User-alert-error-msg').text("姓名/卡号/手机/密码 不能为空,金额必需大于0!");
		$(".add-User-alert-error").fadeIn();
		setInterval(function(){$(".add-User-alert-error").fadeOut()},5000);
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/addUserWork",
        cache: false,
        async: true,
        data:"add=1&cardguid="+cardGuid+"&name="+name+"&sex="+sex+"&birth="+birth+"&phone="+phone+"&emp="+emp+"&upcard="+upcard+"&regMoney="+regMoney+"&password="+password,
        success: function (data) {
            if(data.status=="ok"){
            	$(".add-user-alert-success-msg").text(data.msg);
            	$(".add-user-alert-success").fadeIn();
            	setInterval(function(){$(".add-user-alert-success").fadeOut()},5000);
            	$(".new-card-text").val("");
            	$(".new-card-name").val("");
            	$(".new-card-phone").val("");
            	$(".new-card-upcard").val("");
				$(".new-card-upcard").val("");
				showUpCardInfo(cardGuid);
            }else{
				$(".add-user-alert-error").fadeIn();
				$(".add-user-alert-error-msg").text(data.msg);
				setInterval(function(){$(".add-user-alert-error").fadeOut()},5000);
				return;
            }
        }
	});
}

function addNewUserTcard(){
	var cardGuid=$(".new-card-text").val().trim();
	var name=$(".new-card-name").val().trim();
	var sex=$(".new-card-sex").val().trim();
	var birth=$(".new-card-birth").val().trim();
	var phone=$(".new-card-phone").val().trim();
	var emp=$(".new-card-emp").val().trim();
	var upcard=$(".new-card-upcard").val().trim();
	var password=$(".new-card-password").val().trim();
	if(upcard.length==0){
		upcard=0;
	}
	var regMoney=$(".new-tcard-money").val();
	var count=$(".new-tcard-count").val();
	var consumeType=$(".new-tard-consume-type").val();
	if(cardGuid.length==0 || name.length==0 || phone.length==0 ||regMoney<=0 ||password.length==0 || count<=0){
		$('.add-user-alert-error-msg-tcard').text("姓名/卡号/手机/密码 不能为空,金额必需大于0,次数必须大于0 !");
		$(".add-user-alert-error-tcard").fadeIn();
		setInterval(function(){$(".add-user-alert-error-tcard").fadeOut()},5000);
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/addUserWork",
        cache: false,
        async: true,
        data:"add=0&cardguid="+cardGuid+"&name="+name+"&sex="+sex+"&birth="+birth+"&phone="+phone+"&emp="+emp+"&upcard="+upcard+"&regMoney="+regMoney+"&password="+password+"&count="+count+"&consumetype="+consumeType,
        success: function (data) {
            if(data.status=="ok"){
            	$(".add-user-alert-success-msg-tcard").text(data.msg);
            	$(".add-user-alert-success-tcard").fadeIn();
            	setInterval(function(){$(".add-user-alert-success-tcard").fadeOut()},5000);
            	$(".new-card-text").val("");
            	$(".new-card-name").val("");
            	$(".new-card-phone").val("");
            	$(".new-card-upcard").val("");
				$(".new-card-upcard").val("");
				showUpCardInfo(cardGuid);
            }else{
				$(".add-user-alert-error-tcard").fadeIn();
				$(".add-user-alert-error-msg-tcard").text(data.msg);
				setInterval(function(){$(".add-user-alert-error-tcard").fadeOut()},5000);
				return;
            }
        }
	});
}

//函数 用于返回卡的提成信息  参数cardGuid为卡号  只用在添加函数这一块
function showUpCardInfo(cardGuid){
	//显示提成的信息 请求API  /User/showUpCard  参数 card 卡号
	$(".pay-up-card-guid").text(cardGuid);//显示panel标题上的卡号
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showUpCard",
        cache: false,
        async: true,
        data:"card="+cardGuid,
        success: function (data) {
        	if(data.status=="ok"){
        		$(".pay-up-card-error").hide();
        		var htm='<tr>'+
							'<th>卡号</th>'+
							'<th>姓名</th>'+
							'<th>手机号</th>'+
							'<th>会员等级</th>'+
							'<th>提成比例</th>'+
							'<th>提成金额</th>'+
							'<th>支付(点击可确认支付)</th>'+
						'</tr>';
					for(var i=0;i<data.card.length;i++){
						htm+='<tr>';
						if(data.card[i].puc_up_card==cardGuid){
							htm+='<td>'+data.card[i].puc_up_card+'  (本卡)</td>';
						}else{
							htm+='<td>'+data.card[i].puc_up_card+'</td>';
						}
						htm+='<td>'+data.card[i].puc_up_name+'</td>'+
							'<td>'+data.card[i].puc_up_phone+'</td>'+
							'<td>第 '+data.card[i].puc_level+' 级</td>'+
							'<td>'+data.card[i].puc_percent+' %</td>'+
							'<td>'+data.card[i].puc_money+' 元</td>';
						if(data.card[i].puc_flag*1==0){
							htm+='<td><span class=" up-card-puc-flag"><button class="btn btn-primary btn-xs "  GUID="'+data.card[i].puc_id+'" onclick="payUpCardWork(this);">确认支付该提成</button></span></td>';
						}else{
							 htm+='<td><span class=" up-card-puc-flag"><button disabled class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</button></span></td>';
						}		
						htm+='</tr>';
					}
					$(".pay-up-card-table").html(htm);
					$(".pay-up-card-table").show();
        	}else{
        		$(".pay-up-card-error-msg").text(data.msg);
        		$(".pay-up-card-table").hide();
				$(".pay-up-card-error").show();
        	}
        }
    });
}
//函数 用于确认提成的支付  通用函数 通用点在于<span class=" up-card-puc-flag"> 里面的button内容进行替换即可
//函数参数为 this    使用obj.attr("GUID")=0 进行判断
	//<span class=" up-card-puc-flag"><button class="btn btn-primary btn-xs "  GUID="111111" onclick="payUpCardWork(this);">确认支付该提成</button></span>
	//<span class=" up-card-puc-flag"><button disabled class="btn btn-defalut btn-xs" GUID="0" ><i class="fa fa-check"></i> 已支付</button></span>
//请求的API为  /User/payUpCard  参数为puc
function payUpCardWork(obj){
	var pucGuid=$(obj).attr("GUID");
	if(pucGuid == 0){
		return false;
	}else{
		$.ajax({
		    dataType: "json",
	        url: ajaxUrl+"/User/payUpCard",
	        cache: false,
	        async: true,
	        data:"puc="+pucGuid,
	        success: function (data) {
	        	if(data.status=="ok"){
	        		var htm='<button disabled class="btn btn-defalut btn-xs" GUID="0" ><i class="fa fa-check"></i> 已支付</button>';
	        		$(obj).parent().html(htm);
	        		return false;
	        	}else{
	        		return false;
	        	}
	        }
    	});
	}
}
//调用一次 payUpCardWork  再重新请求一边提成树
function payUpCardWork2(obj){
	payUpCardWork(obj);
	searchLevelInfoController();
}
/***************************************卡的操作的的js 包括充值/消费/修改信息/******************************************/



//当前的相关监听工作  包括账户查询的监听以及金额计算的监听 有点冗余
//进行账户监听 保证账户正确性！
//进行金额的绑定和计算
function listenCardChange(){
	$('.card-input-text').bind('input propertychange', function() {
    	cardInfo=null;
	});
	$('.recharge-mcard-money').bind('input propertychange', function() {
    	$('.recharge-mcard-money-total').val($('.recharge-mcard-money').val()*1.00+$('.recharge-mcard-money-give').val()*1.00);
	});
	$('.recharge-mcard-money-give').bind('input propertychange', function() {
    	$('.recharge-mcard-money-total').val($('.recharge-mcard-money').val()*1.00+$('.recharge-mcard-money-give').val()*1.00);
	});
}

//卡的操作的初始化 用于保存相关的全局变量
function initCard(){
	listenCardChange();
	searchConsumeType();
	searchAllEmp();
	showAllCard();

}

//用来控制显示出modal和初始化数据
function searchAllCard(){
	$("#showAllCardModal").modal("show");
}

//用于在右侧显示会员信息，以及将会员信息保存成全局变量
//使用的API是 /User/searchUserByGuid  参数 search=2 表示的是通过id  card表示卡号
//通用API 返回所有信息  并且保存 使用同步ajax请求

function showCardInfo(){
	$(".search-result-row").hide();
	$(".search-info-box").hide();
	$(".card-info-box").hide();
	var cardGuid=$(".card-input-text").val().trim();
	if(cardGuid.length==0){
		$(".card-info-m-ok").hide();
		$(".card-info-user-ok").hide();
		$(".card-info-t-ok").hide();
		$(".card-info-no").fadeOut();
		$(".card-info-no-msg").text("请正确刷卡或者选择正确的会员卡号!");
		$(".card-info-no").fadeIn();
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/searchUserByGuid",
        data:"search=2&card="+cardGuid,
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	cardInfo=data.card[0];//保存全局变量
            	//进行卡的类型的判断 填充html并进行显示
            	$(".card-info-no").hide();
            	if(cardInfo.card_active==0){
            		$(".card-info-m-ok").hide();
					$(".card-info-user-ok").hide();
					$(".card-info-t-ok").hide();
            		$(".card-info-no").fadeOut();
					$(".card-info-no-msg").text("该卡已经被挂失或者注销,请点击卡务进行管理!");
					$(".card-info-no").fadeIn();
            		return;
            	}else{
            		$(".card-info-guid").text(cardInfo.card_guid);
					$(".card-info-name").text(cardInfo.card_username);
					if(cardInfo.card_usersex==1){
						$(".card-info-sex").text("男");
					}else{
						$(".card-info-sex").text("女");
					}
					$(".card-info-phone").text(cardInfo.card_userphone);
					$(".card-info-birth").text(cardInfo.card_userbirth);
					$(".card-info-regtime").text(cardInfo.card_regtime);
					if(cardInfo.card_upcard==0){
						$(".card-info-upcard").text("无推荐人");
					}else{
						$(".card-info-upcard").text(cardInfo.card_upcard);
					}
					for(var i=0;i<allEmp.length;i++){
						if(allEmp[i].emp_id==cardInfo.card_emp){
							$(".card-info-emp").text(allEmp[i].emp_name);
							break;
						}
					}
            	}
            	if(cardInfo.card_type==1){//金额卡
					$(".card-info-type").text("充值金额卡");
					$(".card-info-money").text(cardInfo.card_money);
					$(".card-info-regmoney").text(cardInfo.card_regmoney);
					$(".card-info-inte").text(cardInfo.card_inte);
					if(cardInfo.card_password_active==1){
						$(".card-info-password-active").text("需要");
					}else{
						$(".card-info-password-active").text("不需要");
					}
					$(".card-info-t-ok").hide();
					$(".card-info-user-ok").fadeIn();
					$(".card-info-m-ok").fadeIn();
            	}else if(cardInfo.card_type==0){//次数卡
					$(".card-info-type").text("充值次数卡");
					for(var i=0;i<cardConsumeType.length;i++){
						if(cardInfo.card_consume_type==cardConsumeType[i].ctype_id){
							$(".card-info-consume-type").text(cardConsumeType[i].ctype_name);
							break;
						}
					}
					$(".card-info-money").text(cardInfo.card_money);
					$(".card-info-regmoney").text(cardInfo.card_regmoney);
					$(".card-info-regcount").text(cardInfo.card_regcount);
					$(".card-info-usecount").text(cardInfo.card_usecount);
					$(".card-info-inte").text(cardInfo.card_inte);
					if(cardInfo.card_password_active==1){
						$(".card-info-password-active").text("需要");
					}else{
						$(".card-info-password-active").text("不需要");
					}
					$(".card-info-m-ok").hide();
					$(".card-info-user-ok").fadeIn();
					$(".card-info-t-ok").fadeIn();
            	}
            }else{
            	$(".card-info-m-ok").hide();
				$(".card-info-user-ok").hide();
				$(".card-info-t-ok").hide();
				$(".card-info-no").hide();
				$(".card-info-no-msg").text(data.msg);
				$(".card-info-no").fadeIn();
				return;
            }
        }
	});
}
//返回所有的员工信息，并且存储成全局变量的数组 使用同步ajax请求
function searchAllEmp(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showEmp",
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	allEmp=data.emp;
            }else{
				console.log("员工信息请求失败!");
				if(allEmp.length==0){
					$(".alert-msg").text(data.msg);
					$(".msModal").modal("show");
					return;
				}
            }
        }
	});
}


//此处存在代码冗余，暂未修改
//冗余代码如下：
/***
		代码冗余的部分为  onclick="selectThisUpCard(this);"  selectThisUpCard函数 以及信息的全局变量的保存
**/

/***********************************************************************************************************************************************/
/*******************************************冗余代码如下*******************************************************/
/***********************************************************************************************************************************************/

//选择会员 通过点击选择按钮  将会员卡号输入到输入框中
function selectThisCard(obj){
	$(".card-input-text").val($(obj).attr("CARD_GUID"));
	$("#showAllCardModal").modal("hide");
}	

//用于返回所有的会员并在modal中显示
// API为通用API 用于返回所有的会员结果或者搜索结果
function showAllCard(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showAllUser",
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	allCard=data.user;
            	$(".search-card-no").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="card-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="card-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="card-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-card-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisCard(this);"><i class="fa fa-check"></i> 选择</button></div>'+
						'<br>';
					}
            	}	
            	$(".show-all-card").html(htm);
            }else{
				$(".search-card-no").show();
				$(".search-card-no-msg").text(data.msg);
				$(".search-card-ok").hide();
				return;
            }
        }
	});
}
//用于返回搜索结果
// API为通用API 进行手机号或者姓名查询  
//查询flag为 search 1表示手机号 0表示姓名(必需参数)

//通过手机号查询
function searchCardByPhone(){
	var phone=$(".search-card-text").val().trim();
	if(phone.length!=11){
		$(".search-card-ok").hide();
		$(".search-card-no").show();
		$(".search-card-no-msg").text("手机号格式不正确!");
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/searchUser",
        cache: false,
        async: true,
        data:"search=1&phone="+phone,
        success: function (data) {
            if(data.status=="ok"){
            	$(".search-card-no").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="card-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="card-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="card-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-card-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisCard(this);"><i class="fa fa-check"></i> 选择</button></div>';
            		}
            	}	
            	$(".search-card-ok-result").html(htm);
            	$(".search-card-ok").show();
            }else{
            	$(".search-card-ok").hide();
				$(".search-card-no").show();
				$(".search-card-no-msg").text(data.msg);
				return;
            }
        }
	});
}	
//通过姓名模糊查询
function searchCardByName(){
	var name=$(".search-card-text").val().trim();
	if(name.length==0){
		$(".search-card-ok").hide();
		$(".search-card-no").show();
		$(".search-card-no-msg").text("名称不能为空!");
		return;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/searchUser",
        cache: false,
        async: true,
        data:"search=0&name="+name,
        success: function (data) {
            if(data.status=="ok"){
            	$(".search-card-no").hide();
            	var htm="";
            	for(var i=0;i<data.user.length;i++){
            		if(data.user[i].card_off==0){
            			htm+='<div class="col-sm-3"><span class="upcard-search-guid">'+data.user[i].card_guid+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-name">'+data.user[i].card_username+'</span></div>'+
						'<div class="col-sm-3"><span class="upcard-search-phone">'+data.user[i].card_userphone+'</span></div>'+
						'<div class="col-sm-3"><button class="btn btn-defalut btn-xs select-upcard-search" CARD_GUID="'+data.user[i].card_guid+'" onclick="selectThisCard(this);"><i class="fa fa-check"></i> 选择</button></div>';
            		}
            	}	
            	$(".search-card-ok-result").html(htm);
            	$(".search-card-ok").show();
            }else{
            	$(".search-card-ok").hide();
				$(".search-card-no").show();
				$(".search-card-no-msg").text(data.msg);
				return;
            }
        }
	});
}


//请求消费类型  并将消费类型保存成全局变量以供使用
//使用的是通用的API 请求路径在System/showConsumeType
function searchConsumeType(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/System/showConsumeType",
        cache: false,
        async: false,//保存请求类型使用同步加载，防止数据未加载成功
        success: function (data) {
            if(data.status=="ok"){
            	cardConsumeType=data.consumeType;
            }else{
            	cardConsumeType=null;
            }
        }
	});
}
/***********************************************************************************************************************************************/
/*******************************************冗余代码如上*******************************************************/
/***********************************************************************************************************************************************/

//账户充值相关操作
//将员工和消费类型通过js加载到html
//提高公用性参数classname 自动加载到该类名下
function showEmpToHtml(className){
	var htm="";
	for(var i=0;i<allEmp.length;i++){
		htm+='<option value="'+allEmp[i].emp_id+'">'+allEmp[i].emp_name+'</option>';
	}
	$("."+className).html(htm)
}
//提高公用性参数classname 自动加载到该类名下
function showConsumeTypeToHtml(className){
	var htm="";
	htm+='<option value="0">请选择</option>';
	for(var i=0;i<cardConsumeType.length;i++){
		htm+='<option value="'+cardConsumeType[i].ctype_id+'">'+cardConsumeType[i].ctype_name+'</option>';
	}
	$("."+className).html(htm)
}
//账户充值 controller
function rechargeController(){
	$(".card-info-box").hide();
	$(".search-info-box").hide();
	$(".search-result-row").hide();
	showEmpToHtml("recharge-mcard-emp");
	showEmpToHtml("recharge-tcard-emp");
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid){
		showErrorModal("为保证充值正确,请先刷卡或选择会员后点击确定查询会员卡信息,再进行充值操作!若卡号更改,则必须重新确认会员卡信息!");
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行充值,请点击卡务进行处理!");
			return ;
	}else{
		$(".recharge-info-type").text(function(){
			if(cardInfo.card_type==1){
				$(".recharge-tcard").hide();
				$(".recharge-mcard").show();
				return "充值金额卡";
			}else{
				$(".recharge-mcard").hide();
				$(".recharge-tcard").show();
				for(var i=0;i<cardConsumeType.length;i++){
					if(cardConsumeType[i].ctype_id==cardInfo.card_consume_type){
						$(".recharge-tcard-consume-type").val(cardConsumeType[i].ctype_name);
						break;
					}
				}
				return "充值次数卡";
			}
		});
		$(".recharge-info-card").text(cardInfo.card_guid);
		$(".recharge-info-name").text(cardInfo.card_username);
		$(".recharge-info-phone").text(cardInfo.card_userphone);
		$(".recharge-mcard-money").val(0);
		$(".recharge-mcard-money-give").val(0);
		$(".recharge-mcard-money-total").val(0);
		$(".recharge-tcard-money").val(0);
		$(".recharge-tcard-count").val(0)
		showModalController("rechargeModal");
	}
}
//金额卡的账户充值的work
//写了两个API 服务两种充值  访问路径为 /User/rechargeMcard   /User/rechargeTcard   count为tcard的充值次数
//通用API请求类型为  card=卡号  money: 总的金额  emp 员工
function rechargeMcardWork(){
	var guid=cardInfo.card_guid;
	var money=$(".recharge-mcard-money-total").val();
	var emp=$(".recharge-mcard-emp").val();
	if(money<=0){
		$(".recharge-alert-error-msg").text("充值金额不能为0");
		$(".recharge-alert-error").fadeIn();
		setInterval(function(){$(".recharge-alert-error").fadeOut();},5000);
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/rechargeMcard",
        data:"card="+guid+"&money="+money+"&emp="+emp+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	showCardInfo();
				$(".recharge-alert-error").hide();
            	$(".recharge-alert-success-msg").text(data.msg);
            	$(".recharge-alert-success").fadeIn();
				setInterval(function(){$(".recharge-alert-success").fadeOut();},5000);
            }else{
            	$(".recharge-alert-success").hide();
            	$(".recharge-alert-error-msg").text(data.msg);
				$(".recharge-alert-error").fadeIn();
				setInterval(function(){$(".recharge-alert-error").fadeOut();},5000);
            }
        }
	});
}

//次数卡的账户充值的work
function rechargeTcardWork(){
	var guid=cardInfo.card_guid;
	var money=$(".recharge-tcard-money").val();
	var emp=$(".recharge-tcard-emp").val();
	var count=$(".recharge-tcard-count").val();
	if(money<=0 ||count<=0){
		$(".recharge-alert-error-msg").text("充值金额或次数不能为0");
		$(".recharge-alert-error").fadeIn();
		setInterval(function(){$(".recharge-alert-error").fadeOut();},5000);
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/rechargeTcard",
        data:"card="+guid+"&money="+money+"&emp="+emp+"&count="+count+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	showCardInfo();
				$(".recharge-alert-error").hide();
            	$(".recharge-alert-success-msg").text(data.msg);
            	$(".recharge-alert-success").fadeIn();
				setInterval(function(){$(".recharge-alert-success").fadeOut();},5000);
            }else{
            	$(".recharge-alert-success").hide();
            	$(".recharge-alert-error-msg").text(data.msg);
				$(".recharge-alert-error").fadeIn();
				setInterval(function(){$(".recharge-alert-error").fadeOut();},5000);
            }
        }
	});
}

//账户消费相关操作
//消费API /User/consumeMcard   /User/consumeTcard
//将员工和消费类型通过js加载到html
//2016-8-11 增加验证密码消费的问题
function consumeControllerPassword(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid){
		showErrorModal("为保证正确消费,请先刷卡或选择会员后点击确定查询会员卡信息,再进行消费操作!若卡号更改,则必须重新确认会员卡信息!");
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行消费,请点击卡务进行处理!");
			return ;
	}else if(cardInfo.card_password_active==1){
		$(".card-password-check-alert-error").hide();
		$(".card-password-check-card").text(cardInfo.card_guid);
		showModalController("cardPasswordCheckModal");
	}else{
	    consumeController();
	}
}
//2016-8-11 增加验证密码消费的work
// API /User/cardPasswordCheck  
	//  参数 card:卡号  password:密码  type:类型 1 0
function consumeControllerPasswordWork(){
	var cardPassword=$(".card-password-check-input").val().trim();
	if(cardPassword.length==0){
		$(".card-password-check-alert-error-text").text("密码不能为空");
		$(".card-password-check-alert-error").show();
	}else{
		$.ajax({
		    dataType: "json",
	        url: ajaxUrl+"/User/cardPasswordCheck",
	        data:"card="+cardInfo.card_guid+"&password="+cardPassword+"&type="+cardInfo.card_type,
	        async: true,
	        success: function (data) {
	            if(data.status=="ok"){
	            	hideModalController("cardPasswordCheckModal");
	            	consumeController();
	            }else{
	            	$(".card-password-check-alert-error-text").text(data.msg);
					$(".card-password-check-alert-error").show();
	            }
	        }
		});
	}
}
function consumeController(){
	$(".card-info-box").hide();
	$(".search-info-box").hide();
	$(".search-result-row").hide();
	$(".consume-mcard-use-money").val(0);
	$("#bigWork").attr("checked",false);
	$("#consumeEmpOrder1").attr("checked",false);
	$("#consumeEmpOrder2").attr("checked",false);
	$("#consumeEmpOrder3").attr("checked",false);
	$("#bigWorkTcard").attr("checked",false);
	$("#tcardEmpOrder").attr("checked",false);
	showEmpToHtml("recharge-tcard-emp");
		$(".consume-info-type").text(function(){
			if(cardInfo.card_type==1){
				showEmpToHtml("consume-info-cemp-1");
				showEmpToHtml("consume-info-cemp-2");
				showEmpToHtml("consume-info-cemp-3");
				showEmpToHtml("consume-mcard-emp");
				showConsumeTypeToHtml("consume-info-consume-type-1");
				showConsumeTypeToHtml("consume-info-consume-type-2");
				showConsumeTypeToHtml("consume-info-consume-type-3");
				$(".consume-tcard").hide();
				$(".consume-mcard").show();
				$(".consume-info-mcard-money").text(cardInfo.card_money);
				return "充值金额卡";
			}else{
				$(".consume-mcard").hide();
				$(".consume-tcard").show();
				showEmpToHtml("consume-tcard-emp");
				showEmpToHtml("consume-tcard-consume-emp");
				for(var i=0;i<cardConsumeType.length;i++){
					if(cardConsumeType[i].ctype_id==cardInfo.card_consume_type){
						$(".consume-tcard-consume-type").val(cardConsumeType[i].ctype_name);
						break;
					}
				}
				$(".consume-info-tcard-money").text(cardInfo.card_money);
				$(".consume-info-tcard-count").text(cardInfo.card_regcount*1);
				return "充值次数卡";
			}
		});
		$(".consume-info-card").text(cardInfo.card_guid);
		$(".consume-info-name").text(cardInfo.card_username);
		$(".consume-info-phone").text(cardInfo.card_userphone);
		$(".consume-mcard-money").val(0);
		$(".consume-mcard-money-give").val(0);
		$(".consume-mcard-money-total").val(0);
		$(".consume-tcard-use-money").val(0);
		$(".consume-info-tcard-comment").val("");
		$(".consume-tcard-count").val(1);
		showModalController("consumeModal");
}

//充值金额卡本次消费  consumeMcardWork
//发送的ajax  card 卡号 、 money 金额  、consumeount 服务数目 1 2 3  然后代表每次的服务项目 员工以及是否点客   、 big 大活 、emp  处理员工、comment 备注
function consumeMcardWork(){
	var cardGuid=cardInfo.card_guid;
	var money=$(".consume-mcard-use-money").val();
	var emp=$(".consume-mcard-emp").val();
	var comment=$(".consume-info-mcard-comment").val().trim();
	if(comment.length==0){
		comment="无备注";
	}
	var big=0;
	if($("#bigWork").is(":checked")){
		var big=1;
	}
	var consumeCount=0;
	var consumeEmpOrder1=0;
	var consumeEmpOrder2=0;
	var consumeEmpOrder3=0;
	var consumeType1=$(".consume-info-consume-type-1").val();
	var consumeType2=$(".consume-info-consume-type-2").val();
	var consumeType3=$(".consume-info-consume-type-3").val();
	consumeEmp1=0;
	consumeEmp2=0;
	consumeEmp3=0;
	if($(".consume-info-consume-type-1").val()!=0){
		consumeCount=consumeCount+1;
		var consumeType1=$(".consume-info-consume-type-1").val();
		var consumeEmp1=$(".consume-info-cemp-1").val();
		if($("#consumeEmpOrder1").is(":checked")){
			consumeEmpOrder1=1;
		}
	} 
	if($(".consume-info-consume-type-2").val()!=0){
		consumeCount=consumeCount+1;
		var consumeType2=$(".consume-info-consume-type-2").val();
		var consumeEmp2=$(".consume-info-cemp-2").val();
		if($("#consumeEmpOrder2").is(":checked")){
			consumeEmpOrder2=1;
		}
	} 

	if($(".consume-info-consume-type-3").val()!=0){
		consumeCount=consumeCount+1;
		var consumeType3=$(".consume-info-consume-type-3").val();
		var consumeEmp3=$(".consume-info-cemp-3").val();
		if($("#consumeEmpOrder3").is(":checked")){
			 consumeEmpOrder3=1;
		}
	} 
	if(consumeCount<1){
		$(".consume-alert-error-msg").text("服务项目至少选择一个,最多选择三个!");
		$(".consume-alert-error").fadeIn();
		setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
		return 0;
	}else if(money<1){
		$(".consume-alert-error-msg").text("消费金额不能为0!");
		$(".consume-alert-error").fadeIn();
		setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
		return 0;
	}else if(money*1>cardInfo.card_money*1){
		$(".consume-alert-error-msg").text("卡内余额不足!");
		$(".consume-alert-error").fadeIn();
		setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
		return 0;
	}

	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/consumeMcard",
        data:"card="+cardGuid+"&money="+money+"&emp="+emp+"&big="+big+"&comment="+comment+"&consumecount="+consumeCount+"&type1="+consumeType1+"&emp1="+consumeEmp1+"&order1="+consumeEmpOrder1+"&type2="+consumeType2+"&emp2="+consumeEmp2+"&order2="+consumeEmpOrder2+"&type3="+consumeType3+"&emp3="+consumeEmp3+"&order3="+consumeEmpOrder3,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	showCardInfo();
				$(".consume-alert-error").hide();
            	$(".consume-alert-success-msg").text(data.msg);
            	$(".consume-alert-success").fadeIn();
				setInterval(function(){$(".consume-alert-success").fadeOut();},5000);
            }else{
            	$(".consume-alert-success").hide();
            	$(".consume-alert-error-msg").text(data.msg);
				$(".consume-alert-error").fadeIn();
				setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
            }
        }
	});

}
//次数卡卡本次消费  consumeTcardWork
//发送的ajax  card 卡号 、 money 金额  、 type 服务项目 、 big 大活 、order 点客 、emp  处理员工、comment 备注、consumeemp 服务员工、count 冲减次数 1
function consumeTcardWork(){
	var cardGuid=cardInfo.card_guid;
	var money=$(".consume-tcard-use-money").val()*1;
	var emp=$(".consume-tcard-emp").val();
	var consumeEmp=$(".consume-tcard-consume-emp").val();
	var comment=$(".consume-info-tcard-comment").val().trim();
	if(comment.length==0){
		comment="无备注";
	}
	var big=0;
	if($("#bigWorkTcard").is(":checked")){
		var big=1;
	}
	var order=0;
	if($("#tcardEmpOrder").is(":checked")){
		var order=1;
	}
	var type=cardInfo.card_consume_type;
	var count=$(".consume-tcard-count").val();
	if(money<1){
		$(".consume-alert-error-msg").text("消费金额不能为0!");
		$(".consume-alert-error").fadeIn();
		setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
		return 0;
	}else if(count*1>=(cardInfo.card_regcount*1)){
		$(".consume-alert-error-msg").text("卡内余额或者剩余次数不足!");
		$(".consume-alert-error").fadeIn();
		setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
		return 0;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/consumeTcard",
        data:"card="+cardGuid+"&money="+money+"&emp="+emp+"&big="+big+"&comment="+comment+"&count="+count+"&consumeemp="+consumeEmp+"&type="+type+"&order="+order,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	showCardInfo();
				$(".consume-alert-error").hide();
            	$(".consume-alert-success-msg").text(data.msg);
            	$(".consume-alert-success").fadeIn();
				setInterval(function(){$(".consume-alert-success").fadeOut();},5000);
            }else{
            	$(".consume-alert-success").hide();
            	$(".consume-alert-error-msg").text(data.msg);
				$(".consume-alert-error").fadeIn();
				setInterval(function(){$(".consume-alert-error").fadeOut();},5000);
            }
        }
	});

}
//查询服务   充值记录查询  消费记录查询  等级关系以及提成金额 查询
//查询controller  显示查询的标签菜单
function searchInfoController(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid){
			showErrorModal("为保证正确查询,请先刷卡或选择会员后点击确定查询会员卡信息,再进行查询操作!若卡号更改,则必须重新确认会员卡信息!");
			return ;
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行查询,请点击卡务进行处理!");
			return ;
	}else{
		$(".card-info-box").hide();
		$(".search-info-box").fadeIn();
		$(".search-result-row").show();
		$(".search-info-box-recharge").hide();
		$(".search-info-box-consume").hide();
		$(".search-info-box-level").hide();
	}

}
//查询充值记录 controller 
//API /User/showRechargeInfo    参数 card 卡号
function searchRechargeInfoController(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid){
			showErrorModal("为保证正确查询,请先刷卡或选择会员后点击确定查询会员卡信息,再进行查询操作!若卡号更改,则必须重新确认会员卡信息!");
			return ;
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行查询,请点击卡务进行处理!");
			return ;
	}else{
		$(".search-info-box-consume").hide();
		$(".search-info-box-level").hide();
		$(".search-info-box-recharge-card").text(cardInfo.card_guid);
		$(".recharge-total-count").text("0");
		$(".recharge-total-money").text("0");
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showRechargeInfo",
        data:"card="+cardInfo.card_guid,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".recharge-total-count").text(data.count);
            	$(".recharge-total-money").text(data.totalMoney);
            	var htm='<table class=" text-center  table table-striped  table-bordered table-hover table-condensed margin-top-px ">';
            	htm+='<tr>'+
	            	'<th>卡号</th>'+
	            	'<th>金额</th>'+
	            	'<th>日期</th>'+
	            	'<th>操作员工</th>'+
	            	'</tr>';
            	for(var i=0;i<data.recharge.length;i++){
            		htm+='<tr>'+
		            		'<td>'+cardInfo.card_guid+'</td>'+
		            		'<td>'+data.recharge[i].recharge_money+'</td>'+
		            		'<td>'+data.recharge[i].recharge_time+'</td>';
		            		for(var j=0;j<allEmp.length;j++){
		            			if(allEmp[j].emp_id == data.recharge[i].recharge_emp){
		            				htm+='<td>'+allEmp[j].emp_name+'</td>';
		            				break;
		            			}
		            		}
    				htm+='</tr>';
            	}
            	htm+='</table>';
            	$(".recharge-info-table-box").html(htm);
            }else{
            	htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	$(".recharge-info-table-box").html(htm);
            }
        }
	});
	//最后显示
	$(".search-info-box-recharge").show();
}
/***************

//全局变量

//cardInfo=null;//用于保存卡的信息  进行相关的操作时不用再次请求数据库
//cardConsumeType=new Array();
//allEmp=new Array();//用于保存所有的员工信息,后面都要用,开了一个新js函数 API不变

*********************/

//查询消费记录 controller
//API /User/showConsumeInfo    参数 card 卡号  type  1金额卡  0次数卡
function searchConsumeInfoController(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid){
			showErrorModal("为保证正确查询,请先刷卡或选择会员后点击确定查询会员卡信息,再进行查询操作!若卡号更改,则必须重新确认会员卡信息!");
			return ;
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行查询,请点击卡务进行处理!");
			return ;
	}else{
		$(".search-info-box-level").hide();
		$(".search-info-box-recharge").hide();
		$(".search-info-box-consume-card").text(cardInfo.card_guid);
		$(".consume-total-count").text("0");
		$(".consume-total-money").text("0");
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showConsumeInfo",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$(".consume-total-count").text(data.count);
            	$(".consume-total-money").text(data.totalMoney);
            	var htm='<table class=" text-center  table table-striped  table-bordered table-hover table-condensed margin-top-px ">';
            	if(cardInfo.card_type==1){
					htm+='<tr>'+
	            	'<th>卡号</th>'+
	            	'<th>金额</th>'+
	            	'<th>大活</th>'+
	            	'<th>点客</th>'+
	            	'<th>日期</th>'+
	            	'<th>收银员工</th>'+
	            	'<th>备注</th>'+
	            	'</tr>';
	            	for(var i=0;i<data.consume.length;i++){
	            		htm+='<tr>'+
			            		'<td>'+cardInfo.card_guid+'</td>'+
			            		'<td>'+data.consume[i].mc_money+'</td>';
			            if(data.consume[i].mc_big==1){
			            	htm+='<td class="text-success"><i class="fa fa-check"></i></td>';
			            }else{
			            	htm+='<td class="text-danger"><i class="fa fa-times"></i></td>';
			            }
			            if(data.consume[i].mc_order==1){
			            	htm+='<td class="text-success"><i class="fa fa-check"></i></td>';
			            }else{
			            	htm+='<td class="text-danger"><i class="fa fa-times"></i></td>';
			            }
	            		htm+='<td>'+data.consume[i].mc_time+'</td>';
	            		for(var j=0;j<allEmp.length;j++){
	            			if(allEmp[j].emp_id == data.consume[i].mc_emp){
	            				htm+='<td>'+allEmp[j].emp_name+'</td>';
	            				break;
	            			}
	            		}
	            		htm+='<td>'+data.consume[i].mc_comment+'</td>';
	    				htm+='</tr>';
	            	}
	        		htm+='</table>';
            	}else{
            		htm+='<tr>'+
	            	'<th>卡号</th>'+
	            	'<th>金额</th>'+
	            	'<th>项目</th>'+
	            	'<th>大活</th>'+
	            	'<th>点客</th>'+
	            	'<th>服务员工</th>'+
	            	'<th>日期</th>'+
	            	'<th>收银员工</th>'+
	            	'<th>备注</th>'+
	            	'</tr>';
	            	for(var i=0;i<data.consume.length;i++){
	            		htm+='<tr>'+
			            		'<td>'+cardInfo.card_guid+'</td>'+
			            		'<td>'+data.consume[i].tc_money+'</td>';
			            for(var j=0;j<cardConsumeType.length;j++){
			            	if(cardConsumeType[j].ctype_id ==data.consume[i].tc_type){
			            		htm+='<td>'+cardConsumeType[j].ctype_name+'</td>';
			            		break;
			            	}
			            }
			            if(data.consume[i].tc_big==1){
			            	htm+='<td class="text-success"><i class="fa fa-check"></i></td>';
			            }else{
			            	htm+='<td class="text-danger"><i class="fa fa-times"></i></td>';
			            }
			            if(data.consume[i].tc_order==1){
			            	htm+='<td class="text-success"><i class="fa fa-check"></i></td>';
			            }else{
			            	htm+='<td class="text-danger"><i class="fa fa-times"></i></td>';
			            }
	            		for(var j=0;j<allEmp.length;j++){
	            			if(allEmp[j].emp_id == data.consume[i].tc_consume_emp){
	            				htm+='<td>'+allEmp[j].emp_name+'</td>';
	            				break;
	            			}
	            		}
	            		htm+='<td>'+data.consume[i].tc_time+'</td>';
	            		for(var j=0;j<allEmp.length;j++){
	            			if(allEmp[j].emp_id == data.consume[i].tc_emp){
	            				htm+='<td>'+allEmp[j].emp_name+'</td>';
	            				break;
	            			}
	            		}
	            		htm+='<td>'+data.consume[i].tc_comment+'</td>';
	    				htm+='</tr>';
	            	}
	        		htm+='</table>';
            	}
            	$(".consume-info-table-box").html(htm);
            }else{
            	htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	$(".consume-info-table-box").html(htm);
            }
        }
	});

	//最后显示
	$(".search-info-box-consume").show();
}

//查看关系树 controller API /User/showLevelPercent/
//参数列表 card:卡号 用于计算当前该卡号赚了多少钱等等
//返回值  包括 totalCount totalMoney payCount payMoney noPayCount noPayMoney level(array)-所有的等级提成信息
function searchLevelInfoController(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid ){
			showErrorModal("为保证正确查询,请先刷卡或选择会员后点击确定查询会员卡信息,再进行查询操作!若卡号更改,则必须重新确认会员卡信息!");
			return ;
	}else if(cardInfo.card_active!=1){
			showErrorModal("该会员卡目前处于非激活状态,可能/挂失/注销/,不能进行查询,请点击卡务进行处理!");
			return ;
	}else{
		$(".search-info-box-recharge").hide();
		$(".search-info-box-consume").hide();
		$(".search-info-box-level-card").text(cardInfo.card_guid);
		$(".level-total-count").text("0");
		$(".level-total-money").text("0");
		$(".level-pay-count").text("0");
		$(".level-pay-money").text("0");
		$(".level-nopay-count").text("0");
		$(".level-nopay-money").text("0");
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showLevelPercent",
        data:"card="+cardInfo.card_guid,
        cache: false,
        async: false,//为了确保信息保存到全局变量中
        success: function (data) {
            if(data.status=="ok"){
            	allPayUpCard=data;
            	$(".level-total-count").text(data.totalCount);
				$(".level-total-money").text(data.totalMoney);
				$(".level-pay-count").text(data.payCount);
				$(".level-pay-money").text(data.payMoney);
				$(".level-nopay-count").text(data.noPayCount);
				$(".level-nopay-money").text(data.noPayMoney);
				//等级提成控制
				//根节点 就是该卡本身
				for(var i=0;i<data.level.length;i++){
					if((data.level[i].puc_down_card==data.level[i].puc_up_card) && (data.level[i].puc_up_card == cardInfo.card_guid)){
						$(".level-user-info-box-root-card").text(cardInfo.card_guid);
						$(".level-user-info-box-root-regmoney").text(data.level[i].puc_money/(data.level[i].puc_percent*0.01));
						$(".level-user-info-box-root-money").text(data.level[i].puc_money);
						if(data.level[i].puc_flag==0){
							var htm2='<span class=" up-card-puc-flag"><button class="btn btn-primary btn-xs "  GUID="'+data.level[i].puc_id+'" onclick="payUpCardWork2(this);">确认支付该提成</button></span>';
						}else{
							var htm2='<span class=" up-card-puc-flag"><button disabled class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</button></span>';
						}
						$(".level-user-info-box-root-btn").html(htm2);
						break;
					}
				}
				var htm2="";
            	for(var i=0;i<data.level.length;i++){
            		if((data.level[i].puc_level==2) && (data.level[i].puc_up_card == cardInfo.card_guid)){
            		htm2+='<div class="level-user-info-box  text-center" LEVEL="2" CARD="'+data.level[i].puc_down_card+'" onclick="showNextLevel(this);">'+
									'<p class="text-danger"><i class="fa fa-user"></i> <span class="level-user-info-box-2-card">'+data.level[i].puc_down_card+'</span></p>'+
									'<p class="">注册金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-regmoney">'+data.level[i].puc_money/(data.level[i].puc_percent*0.01)+'</span></p>'+
									'<p class="">提成金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-money">'+data.level[i].puc_money+'</span></p>';
					if(data.level[i].puc_flag==0){
							 htm2+='<span class=" up-card-puc-flag"><button class="btn btn-primary btn-xs "  GUID="'+data.level[i].puc_id+'" onclick="payUpCardWork2(this);">确认支付该提成</button></span>';
						}else{
							 htm2+='<span class=" up-card-puc-flag"><button disabled class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</button></span>';
						}				
					 htm2+='</div>';
            		}
            	}
            	$(".level-up-user-card-2").text(cardInfo.card_guid);
            	$(".level-info-box-2").html(htm2);
            }else{
            	var htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	$(".level-info-table-box").html(htm);
            }
        }
	});

	//最后显示
	$(".search-info-box-level").show();

}
// showNextLevel  用来显示下一级别的会员  111111->111112->111113
// 先是111112已经确定是111111的下属会员了 而且等级已经确定了 现在只要找到111113是111112的下一级别会员就可以
// 然后查询方式为： 先找到 111112 和 111113 的等级 （假如是2）然后看  111113 是不是 111111的（2+1）等级提成     
//也就是111113是111112的二级会员  一定是111111的三级会员 
	// 应该将 参数 tempLevel=2 的2+1=3及以下的所有html清空                           xxxxxx  (失效---更改时间为 2016-8-10) xxxxxx 
// 上述函数参数改为 this  通过attr(LEVEL) 和 attr(CARD) 获取需要的内容
// 需要修改函数  进行单独的支付确认后 不进行重新刷新结构树 而是改为js控制html+数据库API请求结合的方式
function showNextLevel(obj){
	var upLevel=$(obj).attr("LEVEL");
	var upCard=$(obj).attr("CARD");
	var tmpClassName="";
	$(".level-up-user-card-2").text(cardInfo.card_guid);
	//将html清空
	for(var i=upLevel*1+1;i<=5;i++){
		tmpClassName=".level-info-box-"+i;
		$(tmpClassName).html("");
		tmpClassName=".level-up-user-card-"+i;
		$(tmpClassName).text("");
	}
	//保存结果
	var tmpDownLevel=new Array();
	var tmpCount=0;
	for(var i=0;i<allPayUpCard.level.length;i++){
		// console.log(allPayUpCard.level[i].puc_up_card +" "+  upCard +" "+allPayUpCard.level[i].puc_level);
		if(allPayUpCard.level[i].puc_up_card == upCard && allPayUpCard.level[i].puc_level==2){
			for(var j=0;j<allPayUpCard.level.length;j++){
				if((allPayUpCard.level[i].puc_down_card == allPayUpCard.level[j].puc_down_card) &&(allPayUpCard.level[j].puc_up_card == cardInfo.card_guid)){
					tmpDownLevel[tmpCount]=new Object();
					tmpDownLevel[tmpCount]=allPayUpCard.level[j];
					tmpCount++;
				}
			}
			
		}
	}
	//保存结果成功以后 再进行html更新 每次更新一级别
	var htm2="";
	for(var i=0;i<tmpDownLevel.length;i++){
	htm2+='<div class="level-user-info-box  text-center" LEVEL="'+(upLevel*1+1)+'" CARD="'+tmpDownLevel[i].puc_down_card+'" onclick="showNextLevel(this);">'+
					'<p class="text-danger"><i class="fa fa-user"></i> <span class="level-user-info-box-2-card">'+tmpDownLevel[i].puc_down_card+'</span></p>'+
					'<p class="">注册金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-regmoney">'+tmpDownLevel[i].puc_money/(tmpDownLevel[i].puc_percent*0.01)+'</span></p>'+
					'<p class="">提成金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-money">'+tmpDownLevel[i].puc_money+'</span></p>';
	if(tmpDownLevel[i].puc_flag==0){
			 htm2+='<span class=" up-card-puc-flag"><button class="btn btn-primary btn-xs "  GUID="'+tmpDownLevel[i].puc_id+'" onclick="payUpCardWork2(this);">确认支付该提成</button></span>';
		}else{
			 htm2+='<span class=" up-card-puc-flag"><button disabled class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</button></span>';
		}				
	 htm2+='</div>';
	}
	tmpClassName=".level-up-user-card-"+(upLevel*1+1);
	$(tmpClassName).text(upCard);
	tmpClassName=".level-info-box-"+(upLevel*1+1);
	$(tmpClassName).html(htm2);
}

//查看所有已付等级提成
// API /User/showPayLevelPercent   参数 card:卡号
function showPayLevelHistory(){
	$(".show-pay-level-card").text(cardInfo.card_guid);
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showPayLevelPercent",
        data:"card="+cardInfo.card_guid,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	var htm='<div class="margin-top-px">';
            		htm+='<div class="col-sm-4">会员卡关系</div>';
            		htm+='<div class="col-sm-4 text-center">提成比例</div>';
            		htm+='<div class="col-sm-4 text-center">提成金额</div>';
    				htm+='<div class="col-sm-12"><hr></div>';
        			for(var i=0;i<data.payLevel.length;i++){
        				htm+='<div class="col-sm-4"><span class="text-danger">'+data.payLevel[i].puc_down_card+'</span> <i class="fa fa-long-arrow-right"></i> '+data.payLevel[i].puc_up_card+'</div>';
        				htm+='<div class="col-sm-4 text-center">'+data.payLevel[i].puc_percent+'  <i class="fa fa-percent"></i> </div>';
        				htm+='<div class="col-sm-4 text-center"> <i class="fa fa-jpy"></i> '+data.payLevel[i].puc_money+' </div>';
        			}
            		htm+='</div>';
            		$(".show-pay-level-box").html(htm);
            }else{
            	var htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	$(".show-pay-level-box").html(htm);
            }
        }
	});

	//显示modal
	showModalController("showPayLevelModal");
}
//查看所有未付等级提成  --最好提供一键完成功能
// API /User/showNoPayLevelPercent   参数 card:卡号
function showNoPayLevelHistory(){
	$(".show-no-pay-level-card").text(cardInfo.card_guid);
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showNoPayLevelPercent",
        data:"card="+cardInfo.card_guid,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	var htm='<div class=" margin-top-px">';
            		htm+='<div class="col-sm-4">会员卡关系</div>';
            		htm+='<div class="col-sm-4 text-center">提成比例</div>';
            		htm+='<div class="col-sm-4 text-center">提成金额</div>';
            		htm+='<div class="col-sm-12"><hr></div>';
        			for(var i=0;i<data.noPayLevel.length;i++){
        				htm+='<div class="col-sm-4"><span class="text-danger">'+data.noPayLevel[i].puc_down_card+'</span> <i class="fa fa-long-arrow-right"></i> '+data.noPayLevel[i].puc_up_card+'</div>';
        				htm+='<div class="col-sm-4 text-center">'+data.noPayLevel[i].puc_percent+'  <i class="fa fa-percent"></i> </div>';
        				htm+='<div class="col-sm-4 text-center"> <i class="fa fa-jpy"></i> '+data.noPayLevel[i].puc_money+' </div>';
        			}
            		htm+='</div>';
            		$(".show-no-pay-level-btn").attr("onclick","payAllNoPayLevelController();");
            		$(".show-no-pay-level-box").html(htm);
            }else{
            	var htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	var tmpMsg='showErrorModal("'+data.msg+'");';
            	$(".show-no-pay-level-btn").attr("onclick",tmpMsg);
            	$(".show-no-pay-level-box").html(htm);
            }
        }
	});
	//显示modal
	showModalController("showNoPayLevelModal");
}
//进行一键完成 未支付的等级提交信息
//API /User/payAllNoPayLevel   参数 card:卡号
//需要显示确认框
function payAllNoPayLevelController(){
	$("#showNoPayLevelModal").modal("hide");
	showConfirmModal("一键完成提成支付？","payAllNoPayLevelWork();");
}
function payAllNoPayLevelWork(){
	$("#confirmModal").modal("hide");
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/payAllNoPayLevel",
        data:"card="+cardInfo.card_guid,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	searchLevelInfoController();
            }else{
            	$("#confirmModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}

//卡务相关 
// 卡务要求也先进行卡的查询 然后进行卡务的处理
// 在进行卡的查询之后 发现卡处于非激活状态 然后才能调用卡务
// 当然正常的调用也没有问题 也需要请求卡内容  保留成全局变量
function cardInfoController(){
	if(cardInfo==null ||$('.card-input-text').val()!=cardInfo.card_guid ){
			showErrorModal("为保证正确卡务处理,请先刷卡或选择会员后点击确定查询会员卡信息,再进行卡务处理操作!若卡号更改,则必须重新确认会员卡信息!");
			return ;
	}else if(cardInfo.card_off==1){
			showErrorModal("该卡已经被注销!");
			return ;
	}else{
		$(".card-info-box").hide();
		$(".search-info-box").hide();
		$(".search-result-row").hide();
		$(".search-info-box-recharge").hide();
		$(".search-info-box-consume").hide();
		$(".search-info-box-level").hide();
		$(".card-info-box").fadeIn();
	}
}
//卡的挂失和解除挂失操作
function cardLossController(){
	$("#cardLossModal").modal("show");
	$(".card-loss-card").text(cardInfo.card_guid);
	if(cardInfo.card_loss==1){
		$(".card-loss-box").hide();
		$(".card-loss-cancel-box").show();
	}else{
		$(".card-loss-box").show();
		$(".card-loss-cancel-box").hide();
	}
}
//卡的挂失操作 
//API /User/cardLoss
// 参数  card:卡的账户   type:卡的类型 1 0
function cardLossWork(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardLoss",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardLossModal").modal("hide");
            	showCardInfo();
            	showAllCard();
            }else{
            	$("#cardLossModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//卡的解除挂失操作 
//API /User/cardLossCancel
// 参数  card:卡的账户   type:卡的类型 1 0
function cardLossCancelWork(){
	
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardLossCancel",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardLossModal").modal("hide");
            	showAllCard();
            	showCardInfo();
            }else{
            	$("#cardLossModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//卡的注销操作
function cardOffController(){
	$("#cardOffModal").modal("show");
	$(".card-off-box").show();
	$(".card-off-card").text(cardInfo.card_guid);
}
//卡注销 采用confirm框进行确认
function cardOffWorkConfirm(){
	showConfirmModal("仍旧注销该会员卡？","cardOffWork();");
}
//卡注销work
// API /User/cardOff 
// 参数 card:卡号  type:1 0 金融卡和次数卡
function cardOffWork(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardOff",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardOffModal").modal("hide");
            	showCardInfo();
            	showAllCard();
            	$("#confirmModal").modal("hide");
            	 showErrorModal("卡注销成功,应当退还 "+data.money+" 元");
            }else{
            	$("#cardOffModal").modal("hide");
            	$("#confirmModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//卡的补办操作
function cardReissueController(){
	$("#cardReissueModal").modal("show");
	$(".card-reissue-box").show();
	$(".card-reissue-card").text(cardInfo.card_guid);
}
//卡的补办 confirm提示框
function cardReissueWorkConfirm(){
	var cardCopy=$(".card-reissue-card-copy").val().trim();
	if(cardCopy.length==0){
		$("#cardReissueModal").modal("hide");
    	showErrorModal("卡号不能为0！");
        	return false;
	}
	for(var i=0;i<allCard.length;i++){
		if(allCard[i].card_guid == cardCopy){
			$("#cardReissueModal").modal("hide");
        	showErrorModal("新卡卡号已经存在！");
        	return false;
		}
	}
	var func="cardReissueWork('"+cardCopy+"');"
	showConfirmModal("确定补办会员卡？",func);
}
//卡补办work
// API /User/cardReissue
// 参数 card:卡号  type:1 0 金融卡和次数卡
function cardReissueWork(cardCopy){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardReissue",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type+"&new="+cardCopy,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardReissueModal").modal("hide");
            	$(".card-input-text").val(cardCopy);
            	showCardInfo();
            	showAllCard();
            	$("#confirmModal").modal("hide");
            }else{
            	$("#cardReissueModal").modal("hide");
            	$("#confirmModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//卡的密码消费操作
function cardPasswordController(){
	$("#cardPasswordModal").modal("show");
	$(".card-password-change-alert-error").hide();
	if(cardInfo.card_password_active==0){
		$(".card-password-box").show();
		$(".card-password-cancel-box").hide();
	}else{
		$(".card-password-box").hide();
		$(".card-password-cancel-box").show();

	}
	$(".card-password-card").text(cardInfo.card_guid);
}
//开启密码消费功能:
//API /User/cardPassword  参数  card:卡号  type:1 0 类型
function cardPasswordActiveWork(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardPassword",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardPasswordModal").modal("hide");
            	showCardInfo();
            	showAllCard();
            }else{
            	$("#cardPasswordModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//取消密码消费功能:
//API /User/cardPasswordCancel  参数  card:卡号  type:1 0 类型
function cardPasswordCancelWork(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardPasswordCancel",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardPasswordModal").modal("hide");
            	showCardInfo();
            	showAllCard();
            }else{
            	$("#cardPasswordModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
//更改密码功能
//API /User/cardChangePassword  参数  card:卡号  type:1 0 类型
function cardPasswordChangeWork(){
	var newPassword=$(".card-password-new").val().trim();
	var newPasswordCopy=$(".card-password-new-copy").val().trim();
	if(newPassword.length==0){
		$(".card-password-change-alert-error-text").text("密码不能为空！");
		$(".card-password-change-alert-error").fadeIn();
		return false;
	}
	if(newPassword!=newPasswordCopy){
		$(".card-password-change-alert-error-text").text("两次密码不一致");
		$(".card-password-change-alert-error").fadeIn();
		return false;
	}
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardChangePassword",
        data:"card="+cardInfo.card_guid+"&type="+cardInfo.card_type+"&password="+newPassword,
        cache: false,
        async: true,
        success: function (data) {
            if(data.status=="ok"){
            	$("#cardPasswordModal").modal("hide");
            	showCardInfo();
            	showAllCard();
            }else{
            	$("#cardPasswordModal").modal("hide");
            	 showErrorModal(data.msg);
            }
        }
	});
}
/***********************************************************报表生成的js**********************************************************************/
//初始化 根据默认的input value值进行第一次查询
function initReport(){
	reportController();
}
//查询报表
//办卡数量 充值收入 充次收入 卡内消费 退卡金额  存款余额  男客数量  女客人数量  大活数量 点客数量  项目统计
function reportController(){
	var start=$('.report-start-time').val().trim();
	var end=$('.report-end-time').val().trim();
	if(start.length==0 || end.length==0){
		showErrorModal("起止时间不能为空!");
		return ;
	}
	reportWork(start,end);
	// console.log(allReport);
	showReportToHtml();
}
//查询报表的work 
//参数 需要开始和结束时间段
// API /Report/showReport  参数   start:开始时间   end:结束时间
function reportWork(start,end){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/Report/showReport",
        data:"start="+start+"&end="+end,
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	allReport=data;
            }else{
            	 showErrorModal(data.msg);
            }
        }
	});
}
//进行相关的控制来显示相应的内容
function showReportToHtml(){
	var htm='<tr>'+
		'<th>项目名称</th>'+
		'<th>值</th>'+
		'<th>操作</th>'+
		'</tr>';
	htm+='<tr><td>办卡数量</td><td>'+allReport.allCardCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allCardCountReport();">查看</button></td></tr>';
	htm+='<tr><td>充值收入</td><td>'+allReport.allMcardRegMoney+'</td><td><button class="btn btn-primary btn-sm" onclick="allMcardRegMoneyReport();">查看</button></td></tr>';
	htm+='<tr><td>充次收入</td><td>'+allReport.allTcardRegMoney+'</td><td><button class="btn btn-primary btn-sm" onclick="allTcardRegMoneyReport();">查看</button></td></tr>';
	htm+='<tr><td>卡内消费</td><td>'+allReport.allConsumeMoney+'</td><td><button class="btn btn-primary btn-sm" onclick="allConsumeMoneyReport();">查看</button></td></tr>';
	htm+='<tr><td>退卡金额</td><td>'+allReport.allCardOffMoney+'</td><td><button class="btn btn-primary btn-sm" onclick="allCardOffMoneyReport();">查看</button></td></tr>';
	htm+='<tr><td>存款余额</td><td>'+(allReport.allMcardMoney+allReport.allTcardMoney)+'</td><td><button class="btn btn-primary btn-sm" onclick="allCardMoneyReport();">查看</button></td></tr>';
	htm+='<tr><td>男客数量</td><td>'+allReport.allManCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allManCountReport();">查看</button></td></tr>';
	htm+='<tr><td>女客数量</td><td>'+allReport.allWomanCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allWomanCountReport();">查看</button></td></tr>';
	htm+='<tr><td>项目统计</td><td>'+allReport.allConsumeCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allConsumeCountReport();">查看</button></td></tr>';
	htm+='<tr><td>大活数量</td><td>'+allReport.allConsumeBigCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allConsumeBigCountReport();">查看</button></td></tr>';
	htm+='<tr><td>点客数量</td><td>'+allReport.allConsumeOrderCount+'</td><td><button class="btn btn-primary btn-sm" onclick="allConsumeOrderCountReport();">查看</button></td></tr>';
	$(".report-all-table").html(htm);
}
function allCardCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>性</th>'+
		'<th>手机</th>'+
		'<th>注册金额</th>'+
		'<th>余额</th>'+
		'<th>积分</th>'+
		'<th>办卡日期</th>'+
		'</tr>';
	for(var i=0;i<allReport.allMcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allMcard[i].card_guid+'</td>'+
		'<td>'+allReport.allMcard[i].card_username+'</td>'+
		'<td>'+allReport.allMcard[i].card_usersex+'</td>'+
		'<td>'+allReport.allMcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allMcard[i].card_regmoney+'</td>'+
		'<td>'+allReport.allMcard[i].card_money+'</td>'+
		'<td>'+allReport.allMcard[i].card_inte+'</td>'+
		'<td>'+allReport.allMcard[i].card_regtime+'</td>'+
		'</tr>';
	}
	for(var i=0;i<allReport.allTcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allTcard[i].card_guid+'</td>'+
		'<td>'+allReport.allTcard[i].card_username+'</td>'+
		'<td>'+allReport.allTcard[i].card_usersex+'</td>'+
		'<td>'+allReport.allTcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allTcard[i].card_regmoney+'</td>'+
		'<td>'+allReport.allTcard[i].card_money+'</td>'+
		'<td>'+allReport.allTcard[i].card_inte+'</td>'+
		'<td>'+allReport.allTcard[i].card_regtime+'</td>'+
		'</tr>';
	}
	$("#reportShowModalLabel").text("所有办卡信息");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allMcardRegMoneyReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>性</th>'+
		'<th>手机</th>'+
		'<th>注册金额</th>'+
		'<th>余额</th>'+
		'<th>积分</th>'+
		'<th>办卡日期</th>'+
		'</tr>';
	for(var i=0;i<allReport.allMcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allMcard[i].card_guid+'</td>'+
		'<td>'+allReport.allMcard[i].card_username+'</td>'+
		'<td>'+allReport.allMcard[i].card_usersex+'</td>'+
		'<td>'+allReport.allMcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allMcard[i].card_regmoney+'</td>'+
		'<td>'+allReport.allMcard[i].card_money+'</td>'+
		'<td>'+allReport.allMcard[i].card_inte+'</td>'+
		'<td>'+allReport.allMcard[i].card_regtime+'</td>'+
		'</tr>';
	}
	htm+='<tr>'+
		'<th>充值记录一览</th>'+
		'</tr>';
	htm+='<tr>'+
		'<th>卡号</th>'+
		'<th>金额</th>'+
		'<th>时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allCardRecharge.length;i++){
		if(allReport.allCardRecharge[i].recharge_type==1){
			htm+='<tr>'+
			'<td>'+allReport.allCardRecharge[i].recharge_cardid+'</td>'+
			'<td>'+allReport.allCardRecharge[i].recharge_money+'</td>'+
			'<td>'+allReport.allCardRecharge[i].recharge_time+'</td>'+
			'</tr>';
		}
	}
	$("#reportShowModalLabel").text("金额卡充值金额列表-最下面显示充值记录");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allTcardRegMoneyReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>性</th>'+
		'<th>手机</th>'+
		'<th>注册金额</th>'+
		'<th>服务类型</th>'+
		'<th>余额</th>'+
		'<th>积分</th>'+
		'<th>办卡日期</th>'+
		'</tr>';
	for(var i=0;i<allReport.allTcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allTcard[i].card_guid+'</td>'+
		'<td>'+allReport.allTcard[i].card_username+'</td>'+
		'<td>'+allReport.allTcard[i].card_usersex+'</td>'+
		'<td>'+allReport.allTcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allTcard[i].card_regmoney+'</td>'+
		'<td>'+allReport.allTcard[i].card_consume_type+'</td>'+
		'<td>'+allReport.allTcard[i].card_money+'</td>'+
		'<td>'+allReport.allTcard[i].card_inte+'</td>'+
		'<td>'+allReport.allTcard[i].card_regtime+'</td>'+
		'</tr>';
	}
	htm+='<tr>'+
		'<th>充值记录一览</th>'+
		'</tr>';
	htm+='<tr>'+
		'<th>卡号</th>'+
		'<th>金额</th>'+
		'<th>时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allCardRecharge.length;i++){
		if(allReport.allCardRecharge[i].recharge_type==0){
			htm+='<tr>'+
			'<td>'+allReport.allCardRecharge[i].recharge_cardid+'</td>'+
			'<td>'+allReport.allCardRecharge[i].recharge_money+'</td>'+
			'<td>'+allReport.allCardRecharge[i].recharge_time+'</td>'+
			'</tr>';
		}
	}
	$("#reportShowModalLabel").text("次数卡充值金额列表-最下面显示充值记录");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allConsumeMoneyReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>消费金额</th>'+
		'<th>消费时间</th>'+
		'<th>消费备注</th>'+
		'</tr>';
	for(var i=0;i<allReport.allConsumeMcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allConsumeMcard[i].mc_card+'</td>'+
		'<td>'+allReport.allConsumeMcard[i].mc_money+'</td>'+
		'<td>'+allReport.allConsumeMcard[i].mc_time+'</td>'+
		'<td>'+allReport.allConsumeMcard[i].mc_comment+'</td>'+
		'</tr>';
	}
	for(var i=0;i<allReport.allConsumeTcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allConsumeTcard[i].tc_card+'</td>'+
		'<td>'+allReport.allConsumeTcard[i].tc_money+'</td>'+
		'<td>'+allReport.allConsumeTcard[i].tc_time+'</td>'+
		'<td>'+allReport.allConsumeTcard[i].tc_comment+'</td>'+
		'</tr>';
	}
	$("#reportShowModalLabel").text("消费记录一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allCardOffMoneyReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>手机号</th>'+
		'<th>退款金额</th>'+
		'<th>销卡时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allCardOff.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allCardOff[i].col_card+'</td>'+
		'<td>'+allReport.allCardOff[i].col_username+'</td>'+
		'<td>'+allReport.allCardOff[i].col_userphone+'</td>'+
		'<td>'+allReport.allCardOff[i].col_money+'</td>'+
		'<td>'+allReport.allCardOff[i].col_time+'</td>'+
		'</tr>';
	}
	
	$("#reportShowModalLabel").text("销卡退款记录");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allCardMoneyReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>手机号</th>'+
		'<th>卡内金额</th>'+
		'</tr>';
	for(var i=0;i<allReport.allMcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allMcard[i].card_guid+'</td>'+
		'<td>'+allReport.allMcard[i].card_username+'</td>'+
		'<td>'+allReport.allMcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allMcard[i].card_money+'</td>'+
		'</tr>';
	}
	for(var i=0;i<allReport.allTcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allTcard[i].card_guid+'</td>'+
		'<td>'+allReport.allTcard[i].card_username+'</td>'+
		'<td>'+allReport.allTcard[i].card_userphone+'</td>'+
		'<td>'+allReport.allTcard[i].card_money+'</td>'+
		'</tr>';
	}
	$("#reportShowModalLabel").text("各卡余额一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allManCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>性</th>'+
		'<th>手机</th>'+
		'<th>注册金额</th>'+
		'<th>余额</th>'+
		'<th>积分</th>'+
		'<th>办卡日期</th>'+
		'</tr>';
	for(var i=0;i<allReport.allMcard.length;i++){
		if(allReport.allMcard[i].card_usersex=="男"){
			htm+='<tr>'+
			'<td>'+allReport.allMcard[i].card_guid+'</td>'+
			'<td>'+allReport.allMcard[i].card_username+'</td>'+
			'<td>'+allReport.allMcard[i].card_usersex+'</td>'+
			'<td>'+allReport.allMcard[i].card_userphone+'</td>'+
			'<td>'+allReport.allMcard[i].card_regmoney+'</td>'+
			'<td>'+allReport.allMcard[i].card_money+'</td>'+
			'<td>'+allReport.allMcard[i].card_inte+'</td>'+
			'<td>'+allReport.allMcard[i].card_regtime+'</td>'+
			'</tr>';
		}
	}
	for(var i=0;i<allReport.allTcard.length;i++){
		if(allReport.allTcard[i].card_usersex=="男"){
			htm+='<tr>'+
			'<td>'+allReport.allTcard[i].card_guid+'</td>'+
			'<td>'+allReport.allTcard[i].card_username+'</td>'+
			'<td>'+allReport.allTcard[i].card_usersex+'</td>'+
			'<td>'+allReport.allTcard[i].card_userphone+'</td>'+
			'<td>'+allReport.allTcard[i].card_regmoney+'</td>'+
			'<td>'+allReport.allTcard[i].card_money+'</td>'+
			'<td>'+allReport.allTcard[i].card_inte+'</td>'+
			'<td>'+allReport.allTcard[i].card_regtime+'</td>'+
			'</tr>';
		}
	}
	$("#reportShowModalLabel").text("男客一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allWomanCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>姓名</th>'+
		'<th>性</th>'+
		'<th>手机</th>'+
		'<th>注册金额</th>'+
		'<th>余额</th>'+
		'<th>积分</th>'+
		'<th>办卡日期</th>'+
		'</tr>';
	for(var i=0;i<allReport.allMcard.length;i++){
		if(allReport.allMcard[i].card_usersex=="女"){
			htm+='<tr>'+
			'<td>'+allReport.allMcard[i].card_guid+'</td>'+
			'<td>'+allReport.allMcard[i].card_username+'</td>'+
			'<td>'+allReport.allMcard[i].card_usersex+'</td>'+
			'<td>'+allReport.allMcard[i].card_userphone+'</td>'+
			'<td>'+allReport.allMcard[i].card_regmoney+'</td>'+
			'<td>'+allReport.allMcard[i].card_money+'</td>'+
			'<td>'+allReport.allMcard[i].card_inte+'</td>'+
			'<td>'+allReport.allMcard[i].card_regtime+'</td>'+
			'</tr>';
		}
	}
	for(var i=0;i<allReport.allTcard.length;i++){
		if(allReport.allTcard[i].card_usersex=="女"){
			htm+='<tr>'+
			'<td>'+allReport.allTcard[i].card_guid+'</td>'+
			'<td>'+allReport.allTcard[i].card_username+'</td>'+
			'<td>'+allReport.allTcard[i].card_usersex+'</td>'+
			'<td>'+allReport.allTcard[i].card_userphone+'</td>'+
			'<td>'+allReport.allTcard[i].card_regmoney+'</td>'+
			'<td>'+allReport.allTcard[i].card_money+'</td>'+
			'<td>'+allReport.allTcard[i].card_inte+'</td>'+
			'<td>'+allReport.allTcard[i].card_regtime+'</td>'+
			'</tr>';
		}
	}
	$("#reportShowModalLabel").text("女客一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
/*
="allConsumeCountReport()
	htm+='<tr><td>大活数量onclick="allConsumeBigCountReport();">查看
	htm+='<tr><td>点客数量 onclick="allConsumeOrderCountReport();">查看

*/
function allConsumeCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>金额</th>'+
		'<th>大活</th>'+
		'<th>点客</th>'+
		'<th>备注</th>'+
		'<th>时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allConsumeMcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allConsumeMcard[i].mc_card+'</td>'+
		'<td>'+allReport.allConsumeMcard[i].mc_money+'</td>';
		if(allReport.allConsumeMcard[i].mc_big==1){
				htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
		}else{
				htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
		}
		if(allReport.allConsumeMcard[i].mc_order1==1 ||allReport.allConsumeMcard[i].mc_order2==1 ||allReport.allConsumeMcard[i].mc_order3==1){
				htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
		}else{
				htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
		}
		htm+='<td>'+allReport.allConsumeMcard[i].mc_comment+'</td>'+
		'<td>'+allReport.allConsumeMcard[i].mc_time+'</td>'+
		'</tr>';
	}	
	for(var i=0;i<allReport.allConsumeTcard.length;i++){
		htm+='<tr>'+
		'<td>'+allReport.allConsumeTcard[i].tc_card+'</td>'+
		'<td>'+allReport.allConsumeTcard[i].tc_money+'</td>';
		if(allReport.allConsumeTcard[i].tc_big==1){
				htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
		}else{
				htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
		}
		if(allReport.allConsumeTcard[i].tc_order==1){
				htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
		}else{
				htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
		}
		htm+='<td>'+allReport.allConsumeTcard[i].tc_comment+'</td>'+
		'<td>'+allReport.allConsumeTcard[i].tc_time+'</td>'+
		'</tr>';
	}	
	$("#reportShowModalLabel").text("项目统计一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allConsumeBigCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>金额</th>'+
		'<th>大活</th>'+
		'<th>点客</th>'+
		'<th>备注</th>'+
		'<th>时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allConsumeMcard.length;i++){
		if(allReport.allConsumeMcard[i].mc_big==1){
			htm+='<tr>'+
			'<td>'+allReport.allConsumeMcard[i].mc_card+'</td>'+
			'<td>'+allReport.allConsumeMcard[i].mc_money+'</td>';
			if(allReport.allConsumeMcard[i].mc_big==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			if(allReport.allConsumeMcard[i].mc_order1==1 ||allReport.allConsumeMcard[i].mc_order2==1 ||allReport.allConsumeMcard[i].mc_order3==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			htm+='<td>'+allReport.allConsumeMcard[i].mc_comment+'</td>'+
			'<td>'+allReport.allConsumeMcard[i].mc_time+'</td>'+
			'</tr>';
		}
	}	
	for(var i=0;i<allReport.allConsumeTcard.length;i++){
		if(allReport.allConsumeTcard[i].tc_big==1){
			htm+='<tr>'+
			'<td>'+allReport.allConsumeTcard[i].tc_card+'</td>'+
			'<td>'+allReport.allConsumeTcard[i].tc_money+'</td>';
			if(allReport.allConsumeTcard[i].tc_big==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			if(allReport.allConsumeTcard[i].tc_order==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			htm+='<td>'+allReport.allConsumeTcard[i].tc_comment+'</td>'+
			'<td>'+allReport.allConsumeTcard[i].tc_time+'</td>'+
			'</tr>';
		}
	}	
	$("#reportShowModalLabel").text("大活统计一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
function allConsumeOrderCountReport(){
	var htm='<tr>'+
		'<th>卡号</th>'+
		'<th>金额</th>'+
		'<th>大活</th>'+
		'<th>点客</th>'+
		'<th>备注</th>'+
		'<th>时间</th>'+
		'</tr>';
	for(var i=0;i<allReport.allConsumeMcard.length;i++){
		if(allReport.allConsumeMcard[i].mc_order1==1 ||allReport.allConsumeMcard[i].mc_order2==1 ||allReport.allConsumeMcard[i].mc_order3==1){
			htm+='<tr>'+
			'<td>'+allReport.allConsumeMcard[i].mc_card+'</td>'+
			'<td>'+allReport.allConsumeMcard[i].mc_money+'</td>';
			if(allReport.allConsumeMcard[i].mc_big==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			if(allReport.allConsumeMcard[i].mc_order1==1 ||allReport.allConsumeMcard[i].mc_order2==1 ||allReport.allConsumeMcard[i].mc_order3==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			htm+='<td>'+allReport.allConsumeMcard[i].mc_comment+'</td>'+
			'<td>'+allReport.allConsumeMcard[i].mc_time+'</td>'+
			'</tr>';
		}
	}	
	for(var i=0;i<allReport.allConsumeTcard.length;i++){
		if(allReport.allConsumeTcard[i].tc_order==1){
			htm+='<tr>'+
			'<td>'+allReport.allConsumeTcard[i].tc_card+'</td>'+
			'<td>'+allReport.allConsumeTcard[i].tc_money+'</td>';
			if(allReport.allConsumeTcard[i].tc_big==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			if(allReport.allConsumeTcard[i].tc_order==1){
					htm+='<td><p class="text-success"><i class="fa fa-check"><i></p></td>';
			}else{
					htm+='<td><p class="text-danger"><i class="fa fa-times"><i></p></td>';
			}
			htm+='<td>'+allReport.allConsumeTcard[i].tc_comment+'</td>'+
			'<td>'+allReport.allConsumeTcard[i].tc_time+'</td>'+
			'</tr>';
		}
	}	
	$("#reportShowModalLabel").text("点客统计一览");
	$(".report-show-table").html(htm);
	$("#reportShowModal").modal("show");
}
/****************************************************用户查看自己的信息**************************************************************/
// userShowInfo=null;//用于保存用户查询的时候卡的信息
// userShowPayUpCard=null;//用于用户查询时候保存的上下级关系
//会员查询初始化
function initUserShow(){
	var cardGuid=$(".user-show-card").text();
	if(cardGuid.length==0){
		self.location=ajaxUrl;
	}
	userShowCardInfo(cardGuid);

	if(userShowInfo.card_type*1==1){
		$(".user-show-card-type").text("充值金额卡");
	}else{
		$(".user-show-card-type").text("充值次数卡");
	}
	$(".user-show-name").text(userShowInfo.card_username);
	$(".user-show-phone").text(userShowInfo.card_userphone);
	$(".user-show-money").text(userShowInfo.card_money);

	userShowSearchLevelInfoController();
}	
//返回会员卡账务余额信息
//参数是cardGuid
function userShowCardInfo(card){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/cardShowInfo",
        data:"card="+card,
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	userShowInfo=data.cardShowInfo;
            }else{
            	 showErrorModal(data.msg);
            }
        }
	});
}
//返回账户提成等级信息
function userShowUpCard(card){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showUpCard",
        data:"card="+card,
        cache: false,
        async: false,
        success: function (data) {
            if(data.status=="ok"){
            	userShowPayUpCard=data.card;
            }else{
            	 showErrorModal(data.msg);
            }
        }
	});
}

//冗余代码 目前没有更噶
// 冗余代码如下


//查看关系树 controller API /User/showLevelPercent/
//参数列表 card:卡号 用于计算当前该卡号赚了多少钱等等
//返回值  包括 totalCount totalMoney payCount payMoney noPayCount noPayMoney level(array)-所有的等级提成信息
function userShowSearchLevelInfoController(){
	$.ajax({
	    dataType: "json",
        url: ajaxUrl+"/User/showLevelPercent",
        data:"card="+userShowInfo.card_guid,
        cache: false,
        async: false,//为了确保信息保存到全局变量中
        success: function (data) {
            if(data.status=="ok"){
            	allPayUpCard=data;
            	$(".level-total-count").text(data.totalCount);
				$(".level-total-money").text(data.totalMoney);
				$(".level-pay-count").text(data.payCount);
				$(".level-pay-money").text(data.payMoney);
				$(".level-nopay-count").text(data.noPayCount);
				$(".level-nopay-money").text(data.noPayMoney);
				//等级提成控制
				//根节点 就是该卡本身
				for(var i=0;i<data.level.length;i++){
					if((data.level[i].puc_down_card==data.level[i].puc_up_card) && (data.level[i].puc_up_card == userShowInfo.card_guid)){
						$(".level-user-info-box-root-card").text(userShowInfo.card_guid);
						$(".level-user-info-box-root-money").text(data.level[i].puc_money);
						$(".level-user-info-box-root-btn").html(htm2);
						break;
					}
				}
				var htm2="";
            	for(var i=0;i<data.level.length;i++){
            		if((data.level[i].puc_level==2) && (data.level[i].puc_up_card == userShowInfo.card_guid)){
            		htm2+='<div class="level-user-info-box-user-show  text-center" LEVEL="2" CARD="'+data.level[i].puc_down_card+'" onclick="userShowNextLevel(this);">'+
									'<p class="text-danger"><i class="fa fa-user"></i> <span class="level-user-info-box-2-card">'+data.level[i].puc_down_card+'</span></p>'+
									'<p class="">提成:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-money">'+data.level[i].puc_money+'</span></p>';
					if(data.level[i].puc_flag==0){
						 htm2+='<span class=" up-card-puc-flag"><a  class="btn btn-primary btn-xs ">未支付</a></span>';
					}else{
						 htm2+='<span class=" up-card-puc-flag"><a  class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</a></span>';
					}	
					 htm2+='</div>';
            		}
            	}
            	$(".level-up-user-card-2").text(userShowInfo.card_guid);
            	$(".level-info-box-2").html(htm2);
            }else{
            	var htm='<h4 style="text-align:center;"><i class="fa fa-warning fa-2x"></i><br><span class="red-font">'+data.msg+'<span></h4>';
            	$(".level-info-table-box").html(htm);
            }
        }
	});

	//最后显示
	$(".search-info-box-level").show();

}
// showNextLevel  用来显示下一级别的会员  111111->111112->111113
// 先是111112已经确定是111111的下属会员了 而且等级已经确定了 现在只要找到111113是111112的下一级别会员就可以
// 然后查询方式为： 先找到 111112 和 111113 的等级 （假如是2）然后看  111113 是不是 111111的（2+1）等级提成     
//也就是111113是111112的二级会员  一定是111111的三级会员 
	// 应该将 参数 tempLevel=2 的2+1=3及以下的所有html清空                           xxxxxx  (失效---更改时间为 2016-8-10) xxxxxx 
// 上述函数参数改为 this  通过attr(LEVEL) 和 attr(CARD) 获取需要的内容
// 需要修改函数  进行单独的支付确认后 不进行重新刷新结构树 而是改为js控制html+数据库API请求结合的方式
function userShowNextLevel(obj){
	var upLevel=$(obj).attr("LEVEL");
	var upCard=$(obj).attr("CARD");
	var tmpClassName="";
	$(".level-up-user-card-2").text(userShowInfo.card_guid);
	//将html清空
	for(var i=upLevel*1+1;i<=5;i++){
		tmpClassName=".level-info-box-"+i;
		$(tmpClassName).html("");
		tmpClassName=".level-up-user-card-"+i;
		$(tmpClassName).text("");
	}
	//保存结果
	var tmpDownLevel=new Array();
	var tmpCount=0;
	for(var i=0;i<allPayUpCard.level.length;i++){
		// console.log(allPayUpCard.level[i].puc_up_card +" "+  upCard +" "+allPayUpCard.level[i].puc_level);
		if(allPayUpCard.level[i].puc_up_card == upCard && allPayUpCard.level[i].puc_level==2){
			for(var j=0;j<allPayUpCard.level.length;j++){
				if((allPayUpCard.level[i].puc_down_card == allPayUpCard.level[j].puc_down_card) &&(allPayUpCard.level[j].puc_up_card == userShowInfo.card_guid)){
					tmpDownLevel[tmpCount]=new Object();
					tmpDownLevel[tmpCount]=allPayUpCard.level[j];
					tmpCount++;
				}
			}
			
		}
	}
	//保存结果成功以后 再进行html更新 每次更新一级别
	var htm2="";
	for(var i=0;i<tmpDownLevel.length;i++){
	htm2+='<div class="level-user-info-box-user-show  text-center" LEVEL="'+(upLevel*1+1)+'" CARD="'+tmpDownLevel[i].puc_down_card+'" onclick="userShowNextLevel(this);">'+
					'<p class="text-danger"><i class="fa fa-user"></i> <span class="level-user-info-box-2-card">'+tmpDownLevel[i].puc_down_card+'</span></p>'+
					'<p class="">提成金额:  <i class="fa fa-jpy"></i>  <span class="level-user-info-box-2-money">'+tmpDownLevel[i].puc_money+'</span></p>';
	if(tmpDownLevel[i].puc_flag==0){
			 htm2+='<span class=" up-card-puc-flag"><a  class="btn btn-primary btn-xs ">未支付</a></span>';
		}else{
			 htm2+='<span class=" up-card-puc-flag"><a  class="btn btn-defalut btn-xs"GUID="0"><i class="fa fa-check"></i> 已支付</a></span>';
		}				
	 htm2+='</div>';
	}
	tmpClassName=".level-up-user-card-"+(upLevel*1+1);
	$(tmpClassName).text(upCard);
	tmpClassName=".level-info-box-"+(upLevel*1+1);
	$(tmpClassName).html(htm2);
}

