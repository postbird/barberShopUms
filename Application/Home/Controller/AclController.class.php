<?php
/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class AclController extends Controller {
    public function _initialize(){
    	$sessionFlag=session("isLogin");
       if($sessionFlag!="yes1" && $sessionFlag!="yes2"){
				$this->redirect("Login/index");
				exit();
		}
		// else if($sessionFlag=="yes1" ){
		// 		$this->redirect("Index/index");
		// 		exit();
		// }else if($sessionFlag=="yes2" ){
		// 		$this->redirect("Show/index");
		// 		exit();
		// }
    }
}