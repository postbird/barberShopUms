<?php
/*
	powered by postbird 
	2016-08-12
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class ReportController extends AclController {
	private $bsumsDB;
	public function newDBConstruct(){
		$this->bsumsDB=new \Think\Model();
	}

	public function index(){
		$this->display("index");
	}

	public function showReport(){
		$this->newDBConstruct();
		$start=strtotime($_REQUEST['start']." 00:00:00");
		$end=strtotime($_REQUEST['end']." 23:59:59");
		$sql="SELECT * FROM bsums_mcard WHERE UNIX_TIMESTAMP(card_regtime)>=".$start." AND UNIX_TIMESTAMP(card_regtime)<=".$end.";";
		$ansData=array();
		$allMcard=array();
		$allTcard=array();
		$allMcard=$this->bsumsDB->query($sql);
		$sql="SELECT * FROM bsums_tcard,bsums_consume_type WHERE bsums_tcard.card_consume_type = bsums_consume_type.ctype_id AND  UNIX_TIMESTAMP(card_regtime)>=".$start." AND UNIX_TIMESTAMP(card_regtime)<=".$end.";";
		$allTcard=$this->bsumsDB->query($sql);
		$sql="SELECT * FROM bsums_recharge WHERE  UNIX_TIMESTAMP(recharge_time)>=".$start." AND UNIX_TIMESTAMP(recharge_time)<=".$end.";;";
		$allCardRecharge=$this->bsumsDB->query($sql);
		$ansData['allCardRecharge']=$allCardRecharge;
		//总的卡的数量
		$ansData['allCardCount']=count($allMcard)+count($allTcard);
		$ansData['allMcard']=$allMcard;
		$ansData['allTcard']=$allTcard;
		// 卡的充值收入= 卡的注册金额+充值记录
		$ansData["allMcardRegMoney"]=0;
		for($i=0;$i<count($allMcard);$i++){
			$ansData["allMcardRegMoney"]+=$allMcard[$i]['card_regmoney'];
		}
		for($i=0;$i<count($allCardRecharge);$i++){
			if($allCardRecharge[$i]['recharge_type']==1){
				$ansData["allMcardRegMoney"]+=$allCardRecharge[$i]['recharge_money'];
			}
		}
		$ansData["allTcardRegMoney"]=0;
		for($i=0;$i<count($allMcard);$i++){
			$ansData["allTcardRegMoney"]+=$allTcard[$i]['card_regmoney'];
		}
		for($i=0;$i<count($allCardRecharge);$i++){
			if($allCardRecharge[$i]['recharge_type']==0){
				$ansData["allTcardRegMoney"]+=$allCardRecharge[$i]['recharge_money'];
			}
		}
		// 卡的剩余金额
		$ansData["allMcardMoney"]=0;
		for($i=0;$i<count($allMcard);$i++){
			$ansData["allMcardMoney"]+=$allMcard[$i]['card_money'];
		}
		$ansData["allTcardMoney"]=0;
		for($i=0;$i<count($allMcard);$i++){
			$ansData["allTcardMoney"]+=$allTcard[$i]['card_money'];
		}
		//退卡金额
		$sql="SELECT * FROM bsums_card_off_log  WHERE  UNIX_TIMESTAMP(col_time)>=".$start." AND UNIX_TIMESTAMP(col_time)<=".$end.";";
		$ansData['allCardOff']=$this->bsumsDB->query($sql);
		$ansData['allCardOffMoney']=0;
		for($i=0;$i<count($ansData['allCardOff']);$i++){
			$ansData["allCardOffMoney"]+=$ansData['allCardOff'][$i]['col_money'];
		}
		//男客女客数量
		$ansData["allManCount"]=0;
		$ansData["allWomanCount"]=0;
		for($i=0;$i<count($allMcard);$i++){
			if($allMcard[$i]['card_usersex']==1){
				$ansData["allManCount"]+=1;
				$allMcard[$i]['card_usersex']="男";
			}else{
				$ansData["allWomanCount"]+=1;
				$allMcard[$i]['card_usersex']="女";

			}
		}
		for($i=0;$i<count($allTcard);$i++){
			if($allTcard[$i]['card_usersex']==1){
				$ansData["allManCount"]+=1;
				$allTcard[$i]['card_usersex']="男";
			}else{
				$ansData["allWomanCount"]+=1;
				$allTcard[$i]['card_usersex']="女";
			}
		}
		$ansData["allMcard"]=$allMcard;
		$ansData["allTcard"]=$allTcard;
		//消费统计
		$ansData['allConsumeMcard'];
		$ansData['allConsumeTcard'];
		$sql="SELECT * FROM bsums_consume_mcard WHERE  UNIX_TIMESTAMP(mc_time)>=".$start." AND UNIX_TIMESTAMP(mc_time)<=".$end.";";
		$ansData['allConsumeMcard']=$this->bsumsDB->query($sql);
		$sql="SELECT * FROM bsums_consume_tcard WHERE  UNIX_TIMESTAMP(tc_time)>=".$start." AND UNIX_TIMESTAMP(tc_time)<=".$end.";";
		$ansData['allConsumeTcard']=$this->bsumsDB->query($sql);
		//统计项目数量
		$ansData['allConsumeCount']=count($ansData['allConsumeMcard'])+count($ansData['allConsumeTcard']);
		//统计大活数量
		//顺便统计点客数量
		$ansData['allConsumeBigCount']=0;
		$ansData['allConsumeOrderCount']=0;
		for($i=0;$i<count($ansData['allConsumeMcard']);$i++){
			if($ansData['allConsumeMcard'][$i]['mc_big']==1){
				$ansData["allConsumeBigCount"]+=1;
			}
			if($ansData['allConsumeMcard'][$i]['mc_order1']==1){
				$ansData["allConsumeOrderCount"]+=1;
			}
			if($ansData['allConsumeMcard'][$i]['mc_order2']==1){
				$ansData["allConsumeOrderCount"]+=1;
			}
			if($ansData['allConsumeMcard'][$i]['mc_order3']==1){
				$ansData["allConsumeOrderCount"]+=1;
			}
		}
		for($i=0;$i<count($ansData['allConsumeTcard']);$i++){
			if($ansData['allConsumeTcard'][$i]['tc_big']==1){
				$ansData["allConsumeBigCount"]+=1;
			}
			if($ansData['allConsumeTcard'][$i]['tc_order']==1){
				$ansData["allConsumeOrderCount"]+=1;
			}
		}
		//卡内消费金额
		$ansData['allConsumeMoney']=0;
		for($i=0;$i<count($ansData['allConsumeMcard']);$i++){
				$ansData["allConsumeMoney"]+=$ansData['allConsumeMcard'][$i]['mc_money'];
		}
		for($i=0;$i<count($ansData['allConsumeTcard']);$i++){
				$ansData["allConsumeMoney"]+=$ansData['allConsumeTcard'][$i]['tc_money'];
		}

		$ansData['status']="ok";
		$ansData['msg']="成功返回消息";
		$this->ajaxReturn($ansData,"json");
	}
}