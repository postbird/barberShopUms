<?php
/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	private $bsumsDB;
	public function _initialize(){
		$this->bsumsDB=new \Think\Model();
	}
    public function index(){
    	$this->display("index");
    }
    public function loginCheck(){
    	$adminname=trim($_POST['adminname']);
    	$adminpassword=md5(trim($_POST['adminpassword']));
    	$sql="SELECT adminname,adminpassword FROM bsums_admin WHERE adminname='".$adminname."'";
    	$adminInfo=array();
    	$returnData=array();
    	$tempAdminInfo=$this->bsumsDB->query($sql);
        if(count($tempAdminInfo)==0){
            $sql="SELECT card_guid,card_password,card_active FROM bsums_mcard WHERE card_active=1 AND card_guid='".$adminname."'";
            $userInfo=array();
            $userMcardInfo=array();
            $userTcardInfo=array();
            $userMcardInfo=$this->bsumsDB->query($sql);
            $sql="SELECT card_guid,card_password,card_active FROM bsums_tcard WHERE card_active=1 AND card_guid='".$adminname."'";
            $userTcardInfo=$this->bsumsDB->query($sql);
            $userInfo=array_merge($userMcardInfo,$userTcardInfo);
            if(count($userInfo)<1){
                $this->error("账户或密码错误或该卡处于挂失注销状态!",U('index'));
                exit();
            }else{
                if($adminpassword==$userInfo[0]["card_password"]){
                    session("isLogin","yes2");
                    session("card",$adminname);
                    $this->redirect("Show/index");
                }else{
                    $this->error("账户或密码错误或该卡处于挂失注销状态!",U('index'));
                    exit();
                }
            }
        }else{
            $adminInfo=$tempAdminInfo[0];
            if(count($adminInfo)<1){
                $this->error("账户或密码错误!",U('index'));
                exit();
            }else{
                if($adminpassword==$adminInfo["adminpassword"]){
                    session("isLogin","yes1");
                    $this->redirect("Index/index");
                }else{
                    $this->error("账户或密码错误!",U('index'));
                    exit();
                }
            }
        }
    }
    public function logout(){
		session("isLogin",null);
    	$this->redirect("Login/index");
    }
    

}