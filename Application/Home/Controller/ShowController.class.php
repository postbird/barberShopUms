<?php
/*
	powered by postbird 
	2016-08-29
	http://www.ptbird.cn
	license:MIT
*/
	namespace Home\Controller;
use Think\Controller;
class ShowController extends AclController {
	private $bsumsDB;
	public function newDBConstruct(){
		$this->bsumsDB=new \Think\Model();
	}
	public function index(){
		if(session("isLogin")!="yes2"){
			$this->redirect("Login/index");
			exit();
		}
		$card=session("card");
		$this->assign("card",$card);
		$this->display("index");
	}
	
}