<?php
/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class SystemController extends AclController {
	private $bsumsDB;
	public function newDBConstruct(){
		$this->bsumsDB=new \Think\Model();
	}
    public function index(){
		$this->display("index");
    }
    public function showEmp(){
    	$this->newDBConstruct();
		$ansData=array();
		$sql="SELECT * FROM bsums_emp;";
		$ansData['status']="ok";
		$ansData['emp']=$this->bsumsDB->query($sql);
		if(count($ansData["emp"])<1){
			$ansData['status']="no";
			$ansData['msg']="当前系统没有员工,请在系统设置中添加!";
		}
		$this->ajaxReturn($ansData,"json");
    }
    public function addEmp(){
    	$this->newDBConstruct();
    	$empName=$_REQUEST["empname"];
    	$empPassword=md5($_REQUEST["emppassword"]);
    	$sql="INSERT INTO bsums_emp  (emp_name,emp_password) VALUES ('".$empName."','".$empPassword."');";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$sql="SELECT * FROM bsums_emp;";
			$ansData['emp']=$this->bsumsDB->query($sql);
		}else{
			$ansData['status']="error";
			$ansData['emp']=null;
		}
		$this->ajaxReturn($ansData,"json");
    }
    public function editEmp(){
    	$this->newDBConstruct();
    	$empId=$_REQUEST["empid"];
    	$empName=$_REQUEST["empname"];
    	$empPassword=$_REQUEST["emppassword"];
    	if($empPassword==null){
    		$sql="UPDATE bsums_emp SET emp_name='".$empName."' WHERE emp_id = ".$empId;
    	}else{
    		$empPassword=md5($empPassword);
    		$sql="UPDATE bsums_emp SET emp_name='".$empName."',emp_password='".$empPassword."' WHERE emp_id = ".$empId;
    	}
    	$ansData=Array();
    	if($this->bsumsDB->execute($sql)){
    		$ansData['status']="ok";
    	}else{
    		$ansData['status']="no";
    	}
    	$this->ajaxReturn($ansData,"json");
    }
     public function deleteEmp(){
    	$this->newDBConstruct();
    	$empId=$_REQUEST["empid"];
		$sql="DELETE FROM bsums_emp WHERE emp_id=".$empId;
    	$ansData=Array();
    	if($this->bsumsDB->execute($sql)){
    		$ansData['status']="ok";
    	}else{
    		$ansData['status']="no";
    	}
    	$this->ajaxReturn($ansData,"json");
    }
    public function showConsumeInte(){
    	$this->newDBConstruct();
    	$sql="SELECT * FROM bsums_consume_inte ;";
    	$ansData=array();
    	$ansData['status']="ok";
    	$aaa=$this->bsumsDB->query($sql);
        $ansData["ci_money"]=$aaa[0]["ci_money"];
    	$this->ajaxReturn($ansData,"json");
    }
    public function editConsumeInte(){
    	$this->newDBConstruct();
    	$ciMoney=$_REQUEST['cimoney'];
    	$sql="UPDATE bsums_consume_inte SET ci_money=".$ciMoney;
    	$ansData=array();
    	if($this->bsumsDB->execute($sql)){
    		$ansData['status']="ok";
    	}else{
			$ansData['status']="no";
    	}
    	$this->ajaxReturn($ansData,"json");

    }
    public function showLevel(){
    	$this->newDBConstruct();
    	$sql="SELECT * FROM bsums_level;";
    	$ansData=array();
    	$ansData['status']="ok";
    	$ansData['level']=$this->bsumsDB->query($sql);
    	$this->ajaxReturn($ansData,"json");
    }
    public function editAdminPassword(){
    	$this->newDBConstruct();
    	$oldAdminPassword=md5($_REQUEST['oldadminpassword']);
    	$newAdminPassword=md5($_REQUEST['newadminpassword']);
    	$newAdminPasswordAgain=md5($_REQUEST['newadminpasswordagain']);
    	$sql="SELECT adminpassword FROM bsums_admin;";
    	$ansData=array();
    	$aaa=$this->bsumsDB->query($sql);
        $ansData['adminpassword']=$aaa[0]["adminpassword"];
    	if($ansData['adminpassword']!=$oldAdminPassword || $newAdminPassword!=$newAdminPasswordAgain){
    		$ansData['status']="no";
    		$ansData['msg']="旧密码错误！";
    	}else{
    		$sql="UPDATE bsums_admin SET adminpassword='".$newAdminPassword."';";
    		if($this->bsumsDB->execute($sql)){
    			$ansData['status']="ok";
    			$ansData['msg']="密码成功修改";
    		}else{
    			$ansData['status']="no";
    			$ansData['msg']="密码修改失败";
    		}
    		
    	}
    	$this->ajaxReturn($ansData,"json");
    }
    public function showConsumeType(){
    	$this->newDBConstruct();
    	$sql="SELECT * FROM bsums_consume_type ;";
		$ansData=array();
		$ansData['consumeType']=$this->bsumsDB->query($sql);
		if(count($ansData['consumeType'])==0){
			$ansData["status"]="no";
			$ansData["msg"]="请求失败！";
		}else{
			$ansData["status"]="ok";
			$ansData["msg"]="请求成功并返回!";
		}
		$this->ajaxReturn($ansData,"json");
    }
    //添加消费类型API 
    // 参数  type:项目名称
    public function addConsumeType(){
    	$this->newDBConstruct();
    	$type=$_REQUEST['type'];
    	$sql="INSERT INTO bsums_consume_type (ctype_name) VALUES ('".$type."')";
    	$ansData=array();
    	if($this->bsumsDB->execute($sql)){
			$ansData["status"]="ok";
			$ansData["msg"]="成功添加消费类型";
    	}else{
    		$ansData["status"]="no";
			$ansData["msg"]="添加消费类型失败";
    	}
    	$this->ajaxReturn($ansData,"json");
    }
     //删除消费类型API 
    // 参数  type:项目id
    public function deleteConsumeType(){
    	$this->newDBConstruct();
    	$type=$_REQUEST['type'];
    	$sql="DELETE From bsums_consume_type WHERE ctype_id=".$type;
    	$ansData=array();
    	if($this->bsumsDB->execute($sql)){
			$ansData["status"]="ok";
			$ansData["msg"]="成功删除消费类型";
    	}else{
    		$ansData["status"]="no";
			$ansData["msg"]="删除消费类型失败";
    	}
    	$this->ajaxReturn($ansData,"json");
    }
}