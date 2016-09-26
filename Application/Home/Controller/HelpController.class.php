<?php
/*
	powered by postbird 
	2016-08-12
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class HelpController extends AclController {
	private $bsumsDB;
	public function newDBConstruct(){
		$this->bsumsDB=new \Think\Model();
	}

	public function index(){
		$this->display("index");
	}
}