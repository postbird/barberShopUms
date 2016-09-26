<?php
/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class IndexController extends AclController {
	private $bsumsDB;
	public function _construct(){
		$this->bsumsDB=new \Think\Model();

	}
    public function index(){
    	if(session("isLogin")!="yes1"){
			$this->redirect("Login/index");
			exit();
		}
        $this->display("index");
    }
    
}