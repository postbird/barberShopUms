<?php
/*
	powered by postbird 
	2016-08-04
	http://www.ptbird.cn
	license:MIT
*/
namespace Home\Controller;
use Think\Controller;
class UserController extends AclController {
	private $bsumsDB;
	public function newDBConstruct(){
		$this->bsumsDB=new \Think\Model();
	}
	public function index(){
		$this->display("index");
	}
	public function addUser(){
		$this->display("addUser");
	}
	
	//增加会员卡的上下级关系处理
	//于 2016-8-7 19:20更改1  增加level up_phone up_name标签 （同步数据库增加puc_level puc_up_name puc_up_phone字段）
	//于 2016-8-7 20:12更改2  将函数调用移动到会员卡添加成功后（写两遍）,返回所有的会员信息中遍历姓名和电话
	//于 2016-8-7 21:20更改3  将level表请求以及金额计算直接添加到pay_up_card表中,（同步数据库增加puc_money puc_percent 字段）表示提成比例和金额
		/*** 更改备注：将pay_up_card表结构完善，将内容完整，以供后面js使用减少ajax数目。***/
		//提成金额通过更改2一样能够查询出来进行计算
	public function setUpCard($nowCard,$nowUpCard){
		$this->newDBConstruct();
		//先把自己对自己的关系对应上去
		$levelFlag=1;//自己的对应等级为1  --- 这个是和产品需求商协定的  1表示自身的8%返现 1-5 本系统5级
		$allCard=array();//先将所有的会员卡弄出来
		$tempLevelRank=array();   //用于临时存储level提成比例和等级
		$levelRank=array();   //用于存储level提成比例和等级  构造map数组
		$sql="SELECT * FROM bsums_level";
		$tempLevelRank=$this->bsumsDB->query($sql);
		for($i=0;$i<count($tempLevelRank);$i++){
			$levelRank[$tempLevelRank[$i]["level_rank"]]=$tempLevelRank[$i]["level_money"];
		}
		$tempAllCard1=array();
		$tempAllCard2=array();
		$sql="SELECT card_guid,card_upcard,card_username,card_userphone,card_regmoney FROM bsums_mcard";
		$tempAllCard1=$this->bsumsDB->query($sql);
		$sql="SELECT card_guid,card_upcard,card_username,card_userphone,card_regmoney FROM bsums_tcard";
		$tempAllCard2=$this->bsumsDB->query($sql);
		$allCard=array_merge($tempAllCard1,$tempAllCard2);
		$nowCardInfo;
		for($i=0;$i<count($allCard);$i++){
			if($allCard[$i]['card_guid']==$nowCard){
				$sql="INSERT INTO bsums_pay_up_card (puc_down_card,puc_up_card,puc_level,puc_up_name,puc_up_phone,puc_percent,puc_money) VALUES ('".$nowCard."','".$nowCard."',".$levelFlag.",'".$allCard[$i]['card_username']."','".$allCard[$i]['card_userphone']."',".$levelRank[$levelFlag].",".ceil($allCard[$i]['card_regmoney']*($levelRank[$levelFlag]/100)).")";
				$nowCardInfo=$allCard[$i];
				$this->bsumsDB->execute($sql);
				break;
			}
		}
		$tempNowCard=$nowCard;
		$tempNowUpCard=$nowUpCard;
		while($tempNowUpCard!='0'){
			for($i=0;$i<count($allCard);$i++){
				if($allCard[$i]['card_guid']==$tempNowUpCard){
					$levelFlag=$levelFlag+1;
					$sql="INSERT INTO bsums_pay_up_card (puc_down_card,puc_up_card,puc_level,puc_up_name,puc_up_phone,puc_percent,puc_money) VALUES ('".$nowCard."','".$tempNowUpCard."',".$levelFlag.",'".$allCard[$i]['card_username']."','".$allCard[$i]['card_userphone']."',".$levelRank[$levelFlag].",".ceil($nowCardInfo['card_regmoney']*$levelRank[$levelFlag]/100).")";
					$this->bsumsDB->execute($sql);
					$tempNowCard=$tempNowUpCard;
					$tempNowUpCard=$allCard[$i]['card_upcard'];
					break;
				}
			}
			if($tempNowUpCard==0 || $levelFlag>=5){
				break;
			}
		}
	}
	//显示会员的上下级提成关系 请求的参数为会员卡ID  查出所有的提成信息 （当前系统显示5级  到第4级下属会员）
	public function showUpCard(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$sql="SELECT * FROM bsums_pay_up_card WHERE puc_down_card='".$card."'";
		$ansData=array();
		$ansData["card"]=$this->bsumsDB->query($sql);
		if(count($ansData["card"])==0){
			$ansData["status"]="no";
			$ansData["msg"]="查询失败,系统发生错误,请保证操作正确!";
		}else{
			$ansData["status"]="ok";
			$ansData["msg"]="成功返回信息!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//进行上下级提成的确认操作 参数pay 该pay为pay_up_card表的id（唯一）
	public function payUpCard(){
		$this->newDBConstruct();

		$pucGuid=$_REQUEST["puc"];
		$sql="SELECT * FROM bsums_pay_up_card WHERE puc_id=".$pucGuid;
		$tempAnsData=array();
		$ansData=array();
		$tempAnsData=$this->bsumsDB->query($sql);
		if(count($tempAnsData)==0){
			$ansData['status']="no";
			$ansData['msg']="该提成不存在!";
			$this->ajaxReturn($ansData,"json");
			exit();
		}else{
			$sql="UPDATE bsums_pay_up_card SET puc_flag=1 WHERE puc_id=".$pucGuid;
			if($this->bsumsDB->execute($sql)){
				$ansData['status']="ok";
				$ansData['msg']="修改成功!";
				$this->ajaxReturn($ansData,"json");
				exit();
			}else{
				$ansData['status']="no";
				$ansData['msg']="修改失败,系统错误!";
				$this->ajaxReturn($ansData,"json");
				exit();
			}
		}
	}
	//添加会员卡操作
	public function addUserWork(){
		$this->newDBConstruct();
		
		$add=$_REQUEST['add'];
		$cardGuid=$_REQUEST['cardguid'];
		$name=$_REQUEST['name'];
		$sex=$_REQUEST['sex'];
		$birth=$_REQUEST['birth'];
		$phone=$_REQUEST['phone'];
		$emp=$_REQUEST['emp'];
		$upcard=$_REQUEST['upcard'];
		$password=md5($_REQUEST['password']);
		$regMoney=$_REQUEST['regMoney'];
		$regTime=date("Y-m-d H:m:s");
		$sql="SELECT card_guid FROM bsums_mcard WHERE card_guid='".$cardGuid."';";
		$sql2="SELECT card_guid FROM bsums_tcard WHERE card_guid='".$cardGuid."';";
		if(count($this->bsumsDB->query($sql))>0 || count($this->bsumsDB->query($sql2))>0){
			$ansData['status']="no";
			$ansData['msg']="该会员卡号已经存在!";
			$this->ajaxReturn($ansData,"json");
			exit();
		}
		$sql="SELECT card_guid FROM bsums_mcard WHERE card_guid='".$cardGuid."';";

		if($add==1){
			
			$sql="INSERT INTO bsums_mcard (card_guid,card_money,card_regmoney,card_regtime,card_username,card_usersex,card_userbirth,card_userphone,card_emp,card_password,card_upcard) VALUES('".$cardGuid."','".$regMoney."','".$regMoney."','".$regTime."','".$name."','".$sex."','".$birth."','".$phone."','".$emp."','".$password."','".$upcard."');";
			$ansData=array();
			if($this->bsumsDB->execute($sql)){
				$ansData['status']="ok";
				$ansData['msg']="成功添加新的会员卡!";

				$this->setUpCard($cardGuid,$upcard);//设置上下关系 放在后面是为了在添加卡后搜索名字和手机

				$this->ajaxReturn($ansData,"json");
			}else{
				$ansData['status']="no";
				$ansData['msg']="添加会员卡失败!系统错误!";
				$this->ajaxReturn($ansData,"json");
			}
		}else{
        // data:"add=0&cardguid="+cardGuid+"&name="+name+"&sex="+sex+"&birth="+birth+"&phone="+phone+"&emp="+emp+"&upcard="+upcard+"&regMoney="+regMoney+"&password="+password+"&count="+count+"&consumetype="+consumeType,
			$consumeType=$_REQUEST['consumetype'];
			$count=$_REQUEST['count'];
			$sql="INSERT INTO bsums_tcard (card_guid,card_money,card_regmoney,card_regtime,card_username,card_usersex,card_userbirth,card_userphone,card_emp,card_password,card_upcard,card_regcount,card_consume_type) VALUES('".$cardGuid."','".$regMoney."','".$regMoney."','".$regTime."','".$name."','".$sex."','".$birth."','".$phone."','".$emp."','".$password."','".$upcard."','".$count."','".$consumeType."');";
			$ansData=array();
			if($this->bsumsDB->execute($sql)){
				$ansData['status']="ok";
				$ansData['msg']="成功添加新的会员卡!";

				$this->setUpCard($cardGuid,$upcard);//设置上下关系 放在后面是为了在添加卡后搜索名字和手机

				$this->ajaxReturn($ansData,"json");
			}else{
				$ansData['status']="no";
				$ansData['msg']="添加会员卡失败!系统错误!";
				$this->ajaxReturn($ansData,"json");
			}
		}
		
	}
	public function showAllUser(){
		$this->newDBConstruct();

		$sql="SELECT card_guid,card_username,card_userphone,card_active,card_off,card_loss FROM bsums_mcard;";
		$ansData=array();
		$ansData1=array();
		$ansData2=array();
		$ansData1=$this->bsumsDB->query($sql);
		$sql="SELECT card_guid,card_username,card_userphone,card_active,card_off,card_loss FROM bsums_tcard;";
		$ansData2=$this->bsumsDB->query($sql);
		$ansData['user']=array_merge($ansData1,$ansData2);
		if(count($ansData['user'])==0){
			$ansData['status']="no";
			$ansData['msg']="当前系统没有会员,请直接添加新会员!";
			$this->ajaxReturn($ansData,"json");
		}else{
			$ansData['status']="ok";
			$ansData['msg']="会员信息成功返回";
			$this->ajaxReturn($ansData,"json");
		}
	}
	public function searchUser(){
		$this->newDBConstruct();
		$searchFlag=$_REQUEST['search'];
		if($searchFlag==1){
			$phone=$_REQUEST['phone'];
			$ansData=array();
			$ansData1=array();
			$ansData2=array();
			$sql="SELECT card_guid,card_username,card_type,card_userphone,card_active,card_off,card_loss FROM bsums_mcard WHERE card_userphone='".$phone."'; ";
			$ansData1=$this->bsumsDB->query($sql);
			$sql="SELECT card_guid,card_username,card_type,card_userphone,card_active,card_off,card_loss  FROM bsums_tcard WHERE card_userphone='".$phone."'; ";
			$ansData2=$this->bsumsDB->query($sql);
			$ansData['user']=array_merge($ansData1,$ansData2);
			if(count($ansData['user'])==0){
				$ansData['status']="no";
				$ansData['msg']="没有搜索到该会员!";
				$this->ajaxReturn($ansData,"json");
			}else{
				$ansData['status']="ok";
				$ansData['msg']="会员信息成功返回";
				$this->ajaxReturn($ansData,"json");
			}
		}else{
			$name=$_REQUEST['name'];
			$ansData=array();
			$ansData1=array();
			$ansData2=array();
			$sql="SELECT card_guid,card_username,card_type,card_userphone,card_active,card_off,card_loss FROM bsums_mcard WHERE card_username LIKE '%".$name."%'; ";
			$ansData1=$this->bsumsDB->query($sql);
			$sql="SELECT card_guid,card_username,card_type,card_userphone,card_active,card_off,card_loss FROM bsums_tcard WHERE card_username  LIKE '%".$name."%'; ";
			$ansData2=$this->bsumsDB->query($sql);
			$ansData['user']=array_merge($ansData1,$ansData2);
			if(count($ansData['user'])==0){
				$ansData['status']="no";
				$ansData['msg']="没有搜索到该会员!";
				$this->ajaxReturn($ansData,"json");
			}else{
				$ansData['status']="ok";
				$ansData['msg']="会员信息成功返回";
				$this->ajaxReturn($ansData,"json");
			}
		}
	}
	//刻意写了一个这样的函数 用于返回所有的信息
	//上面的函数只是返回卡号和姓名以及手机号
	public function searchUserByGuid(){
		$this->newDBConstruct();
		$searchFlag=$_REQUEST['search'];
		if($searchFlag==2){//象征性的搜索flag
			$cardDuid=$_REQUEST['card'];
			$ansData=array();
			$ansData1=array();
			$ansData2=array();
			$sql="SELECT * FROM bsums_mcard WHERE card_guid='".$cardDuid."'; ";
			$ansData1=$this->bsumsDB->query($sql);
			$sql="SELECT *  FROM bsums_tcard WHERE card_guid='".$cardDuid."'; ";
			$ansData2=$this->bsumsDB->query($sql);
			$ansData['card']=array_merge($ansData1,$ansData2);
			if(count($ansData['card'])==0){
				$ansData['status']="no";
				$ansData['msg']="没有搜索到该会员卡,请确保卡号正确!";
				$this->ajaxReturn($ansData,"json");
			}else{
				$ansData['status']="ok";
				$ansData['msg']="会员卡信息成功返回!";
				$this->ajaxReturn($ansData,"json");
			}
		}
	}
	//将金额卡和次数卡的充值进行分开API策略
	//充值金额卡
	public function rechargeMcard(){
		$this->newDBConstruct();
		$guid=$_REQUEST['card'];
		$money=$_REQUEST['money'];
		$emp=$_REQUEST['emp'];
		$type=$_REQUEST['type'];
		$sql="UPDATE bsums_mcard SET card_money=card_money+".$money." WHERE card_guid='".$guid."'";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="账户充值成功,本次充值金额 ".$money;
		}else{
			$ansData['status']="no";
			$ansData['msg']="账户充值失败,发生系统错误,请重试";
		}
	$sql="INSERT INTO bsums_recharge (recharge_cardid,recharge_time,recharge_money,recharge_emp,recharge_type) VALUES('".$guid."','".date("Y-m-d H:m:s")."',".$money.",".$emp.",".$type.")";
		if($this->bsumsDB->execute($sql)){
			$ansData['status2']="ok";
			$ansData['msg2']="账户充值成功,本次充值金额 ".$money;
		}else{
			$ansData['status2']="no";
			$ansData['msg2']="账户充值失败,发生系统错误,请重试";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//充值次数卡
	public function rechargeTcard(){
		$this->newDBConstruct();
		$guid=$_REQUEST['card'];
		$money=$_REQUEST['money'];
		$emp=$_REQUEST['emp'];
		$count=$_REQUEST['count'];
		$type=$_REQUEST['type'];
		$sql="UPDATE bsums_tcard SET card_money=card_money+".$money.",card_regcount=card_regcount+".$count." WHERE card_guid='".$guid."'";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="账户充值成功,本次充值金额 ".$money." 次数 ".$count;
		}else{
			$ansData['status']="no";
			$ansData['msg']="账户充值失败,发生系统错误,请重试";
		}
		$sql="INSERT INTO bsums_recharge (recharge_cardid,recharge_time,recharge_money,recharge_emp,recharge_type) VALUES('".$guid."','".date("Y-m-d H:m:s")."',".$money.",".$emp.",".$type.")";
		if($this->bsumsDB->execute($sql)){
			$ansData['status2']="ok";
			$ansData['msg2']="账户充值成功,本次充值金额 ".$money." 次数 ".$count;
		}else{
			$ansData['status2']="no";
			$ansData['msg2']="账户充值失败,发生系统错误,请重试";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//金额卡消费
	public function consumeMcard(){
		$this->newDBConstruct();
		$sql="SELECT * FROM bsums_consume_inte ";
		$aaa=$this->bsumsDB->query($sql);
		$consumeInte=$aaa[0]['ci_money'];
		$guid=$_REQUEST['card'];
		$money=$_REQUEST['money'];
		$emp=$_REQUEST['emp'];
		$big=$_REQUEST['big'];
		$comment=$_REQUEST['comment'];
		$consumeCount=$_REQUEST['consumecount'];
		$type1=$_REQUEST['type1'];
		$emp1=$_REQUEST['emp1'];
		$order1=$_REQUEST['order1'];
		$type2=$_REQUEST['type2'];
		$emp2=$_REQUEST['emp2'];
		$order2=$_REQUEST['order2'];
		$type3=$_REQUEST['type3'];
		$emp3=$_REQUEST['emp3'];
		$order3=$_REQUEST['order3'];
		$time=date("Y-m-d H:m:s");
		$inte=ceil($money/$consumeInte);
		$sql="UPDATE bsums_mcard SET card_money=card_money-".$money.",card_inte=card_inte+".$inte." WHERE card_guid='".$guid."'";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="本次消费￥ ".$money." 获得积分 ".$inte;
		}else{
			$ansData['status']="no";
			$ansData['msg']="收银失败,发生系统错误,请重试";
		}
		$sql="INSERT INTO bsums_consume_mcard (mc_card,mc_money,mc_type1,mc_emp1,mc_order1,mc_type2,mc_emp2,mc_order2,mc_type3,mc_emp3,mc_order3,mc_big,mc_count,mc_time,mc_comment,mc_emp) VALUES('".$guid."',".$money.",".$type1.",".$emp1.",".$order1.",".$type2.",".$emp2.",".$order2.",".$type3.",".$emp3.",".$order3.",".$big.",".$consumeCount.",'".date("Y-m-d H:m:s")."','".$comment."',".$emp.")";
		if($this->bsumsDB->execute($sql)){
			$ansData['status2']="ok";
			$ansData['msg']="本次消费￥ ".$money." 获得积分 ".$inte;
		}else{
			$ansData['status2']="no";
			$ansData['msg2']="收银失败,发生系统错误,请重试";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//次数卡消费
	 // data:"card="+cardGuid+"&money="+money+"&emp="+emp+"&big="+big+"&comment="+comment+"&count="+count+"&consumeemp="+consumeEmp+"&type="+type+"&order="+order,
	public function consumeTcard(){
		$this->newDBConstruct();
		$sql="SELECT * FROM bsums_consume_inte ";
		$aaa=$this->bsumsDB->query($sql);
		$consumeInte=$aaa[0]['ci_money'];
		$guid=$_REQUEST['card'];
		$money=$_REQUEST['money'];
		$emp=$_REQUEST['emp'];
		$big=$_REQUEST['big'];
		$comment=$_REQUEST['comment'];
		$count=$_REQUEST['count'];//表示冲减次数
		$consumeEmp=$_REQUEST['consumeemp'];//项目服务员工
		$type=$_REQUEST["type"];
		$order=$_REQUEST['order'];
		$time=date("Y-m-d H:m:s");
		$inte=ceil($money/$consumeInte);
		$sql="UPDATE bsums_tcard SET card_money=card_money-".$money.",card_inte=card_inte+".$inte.",card_regcount=card_regcount-".$count.",card_usecount=card_usecount+".$count." WHERE card_guid='".$guid."'";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="本次金额 ".$money." 冲减次数 ".$count." 获得积分 ".$inte;
		}else{
			$ansData['status']="no";
			$ansData['msg']="收银失败,发生系统错误,请重试";
		}
		$sql="INSERT INTO bsums_consume_tcard (tc_card,tc_money,tc_type,tc_consume_emp,tc_emp,tc_order,tc_big,tc_count,tc_time,tc_comment) VALUES('".$guid."',".$money.",".$type.",".$consumeEmp.",".$emp.",".$order.",".$big.",".$count.",'".date("Y-m-d H:m:s")."','".$comment."')";
		
		if($this->bsumsDB->execute($sql)){
			$ansData['status2']="ok";
			$ansData['msg']="本次金额 ".$money." 冲减次数 ".$count." 获得积分 ".$inte;
		}else{
			$ansData['status2']="no";
			$ansData['msg2']="收银失败,发生系统错误,请重试";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 返回卡的充值信息  参数为card   id
	public function showRechargeInfo(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$sql="SELECT * FROM bsums_recharge WHERE recharge_cardid = '".$card."'";
		$ansData=array();
		$ansData['recharge']=$this->bsumsDB->query($sql);
		$ansData['count']=0;
		$ansData['totalMoney']=0;
		for($i=0;$i<count($ansData['recharge']);$i++){
			$ansData['count']++;
			$ansData['totalMoney']=$ansData['totalMoney']+$ansData['recharge'][$i]['recharge_money'];
		}
		if(count($ansData['recharge'])==0){
			$ansData['status']='no';
			$ansData['msg']='没有充值记录!';
		}else{
			$ansData['status']='ok';
			$ansData['msg']='充值记录返回成功!';
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 返回卡的消费信息 根据卡的类型进行判断和获取  参数 card:卡id  type:卡的类型  1表示充值金额卡 0表示充值消费卡	
	public function showConsumeInfo(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		$ansData['count']=0;
		$ansData['totalMoney']=0;
		if($type==1){
			$sql="SELECT * FROM bsums_consume_mcard WHERE mc_card='".$card."'";
			$ansData['consume']=$this->bsumsDB->query($sql);
			for($i=0;$i<count($ansData['consume']);$i++){
				$ansData['count']++;
				$ansData['totalMoney']=$ansData['totalMoney']+$ansData['consume'][$i]['mc_money'];
			}
			if(count($ansData['consume'])==0){
				$ansData['status']='no';
				$ansData['msg']='没有消费记录!';
				$this->ajaxReturn($ansData,"json");
				exit();
			}else{
				$ansData['status']='ok';
				$ansData['msg']='成功返回消费记录!';
				$this->ajaxReturn($ansData,"json");
				exit();
			}
		}else{
			$sql="SELECT * FROM bsums_consume_tcard WHERE tc_card='".$card."'";
			$ansData['consume']=$this->bsumsDB->query($sql);
			for($i=0;$i<count($ansData['consume']);$i++){
				$ansData['count']++;
				$ansData['totalMoney']=$ansData['totalMoney']+$ansData['consume'][$i]['tc_money'];
			}
			if(count($ansData['consume'])==0){
				$ansData['status']='no';
				$ansData['msg']='没有消费记录!';
				$this->ajaxReturn($ansData,"json");
				exit();
			}else{
				$ansData['status']='ok';
				$ansData['msg']='成功返回消费记录!';
				$this->ajaxReturn($ansData,"json");
				exit();
			}
		}
	}
	//API 用于返回上下级的关系树 
	// 直接返回所有的等级信息 在前端进行操作
	// 增加修改  返回某会员能够获取的提成数目和金额  以及提成的已付数目/金额和未付数目/金额  需要参数card:卡号
	public function showLevelPercent(){
		$card=$_REQUEST['card'];
		$this->newDBConstruct();
		$sql="SELECT * FROM bsums_pay_up_card";
		$ansData=array();
		$ansData['totalCount']=0;
		$ansData['totalMoney']=0;
		$ansData['payCount']=0;
		$ansData['payMoney']=0;
		$ansData['noPayCount']=0;
		$ansData['noPayMoney']=0;
		$ansData['level']=$this->bsumsDB->query($sql);
		for($i=0;$i<count($ansData['level']);$i++){
			if($ansData['level'][$i]['puc_up_card']==$card){
				$ansData['totalCount']++;
				$ansData['totalMoney']+=$ansData['level'][$i]['puc_money'];
				if($ansData['level'][$i]['puc_flag']==1){
					$ansData['payCount']++;
					$ansData['payMoney']+=$ansData['level'][$i]['puc_money'];
				}else{
					$ansData['noPayCount']++;
					$ansData['noPayMoney']+=$ansData['level'][$i]['puc_money'];
				}
			}
		}
		$ansData['status']="ok";
		$ansData['msg']="成功返回等级提成信息!";
		if(count($ansData['level'])==0){
			$ansData['status']="no";
			$ansData['msg']="等级信息为空!";
		}
		$this->ajaxReturn($ansData,"json");
	}	
	//API 用于返回已经支付的提成  
	// 参数  card:卡号（当前提成卡）
	public function showPayLevelPercent(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$sql="SELECT * FROM bsums_pay_up_card WHERE puc_flag=1 AND puc_up_card='".$card."'";
		$ansData=array();
		$ansData['payLevel']=$this->bsumsDB->query($sql);
		if(count($ansData['payLevel'])==0){
			$ansData['status']="no";
			$ansData['msg']="该卡没有已经支付的提成!";
		}else{
			$ansData['status']="ok";
			$ansData['msg']="成功返回已经支付的提成!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 用于返回没有支付的提成
	// 参数  card:卡号（当前提成卡）
	public function showNoPayLevelPercent(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$sql="SELECT * FROM bsums_pay_up_card WHERE puc_flag=0 AND puc_up_card='".$card."'";
		$ansData=array();
		$ansData['noPayLevel']=$this->bsumsDB->query($sql);
		if(count($ansData['noPayLevel'])==0){
			$ansData['status']="no";
			$ansData['msg']="该卡没有未支付的提成!";
		}else{
			$ansData['status']="ok";
			$ansData['msg']="成功返回未支付的提成!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 一键完成所有的未支付提成
	// 参数  card:卡号（当前提成卡）
	public function payAllNoPayLevel(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$sql="UPDATE bsums_pay_up_card SET puc_flag=1 WHERE puc_up_card='".$card."'";
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功一键支付提成!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="一键支付提成失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 会员卡挂失
	// 参数  card:卡号; type=1金额卡 type=0次数卡
	public function cardLoss(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_active=0,card_loss=1 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_active=0,card_loss=1 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功挂失卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="挂失卡失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 会员卡解除挂失
	// 参数  card:卡号; type=1金额卡 type=0次数卡
	public function cardLossCancel(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_active=1,card_loss=0 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_active=1,card_loss=0 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功解除挂失卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="解除挂失卡失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 会员卡注销
	// 参数  card:卡号; type=1金额卡 type=0次数卡
	//注销后 不能取消卡的注销
	public function cardOff(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_active=0,card_off=1 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_active=0,card_off=1 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功注销会员卡,不可恢复!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="注销会员卡失败!";
		}
		if($type==1){
			$sql="SELECT card_guid,card_money,card_regmoney,card_username,card_userphone,card_type FROM bsums_mcard WHERE card_guid='".$card."'";
		}else{
			$sql="SELECT card_guid,card_money,card_regmoney,card_username,card_userphone,card_type FROM bsums_tcard WHERE card_guid='".$card."'";
		}
		$aaa=$this->bsumsDB->query($sql);
		$tempData=$aaa[0];
		$colTime=date("Y-m-d");
		$sql="INSERT INTO bsums_card_off_log (col_card,col_money,col_username,col_userphone,col_type,col_time) VALUES ('".$tempData['card_guid']."','".$tempData['card_money']."','".$tempData['card_username']."','".$tempData['card_userphone']."','".$tempData['card_type']."','".$colTime."')";
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功注销会员卡,不可恢复!";
			$ansData['money']=$tempData['card_money'];
		}else{
			$ansData['status']="no";
			$ansData['msg']="注销会员卡失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 会员卡密码消费
	// 参数  card:卡号; type=1金额卡 type=0次数卡
	public function cardPassword(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_password_active=1 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_password_active=1 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="会员卡改为密码消费!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="会员卡改为密码消费失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 取消会员卡密码消费
	// 参数  card:卡号; type=1金额卡 type=0次数卡
	public function cardPasswordCancel(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_password_active=0 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_password_active=0 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="取消会员卡密码消费!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="取消会员卡密码消费失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 更改会员卡密码 默认密码123456
	// 参数  card:卡号; type=1金额卡 type=0次数卡 ; password:新密码
	public function cardChangePassword(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		$password=md5($_REQUEST['password']);
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_password='".$password."' WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_password='".$password."' WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功更改会员卡密码!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="更改会员卡密码失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//API 会员卡补卡 将所有的表中的卡号给换掉
	// 参数  card:卡号; type=1金额卡 type=0次数卡 ; new:新卡号
	public function cardReissue(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$type=$_REQUEST['type'];
		$newCard=$_REQUEST['new'];
		//先将卡号更换掉
		if($type==1){
			$sql="UPDATE bsums_mcard SET card_guid='".$newCard."',card_reissue=card_reissue+1 WHERE card_guid='".$card."'";
		}else{
			$sql="UPDATE bsums_tcard SET card_guid='".$newCard."',card_reissue=card_reissue+1 WHERE card_guid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功补办会员卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="卡信息更改失败!";
		}
		//将消费记录更换掉
		if($type==1){
			$sql="UPDATE bsums_consume_mcard SET mc_card='".$newCard."' WHERE mc_card='".$card."'";
		}else{
			$sql="UPDATE bsums_consume_tcard SET tc_card='".$newCard."' WHERE tc_card='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功补办会员卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="消费记录更改失败!";
		}
		//将充值记录更换掉
		if($type==1){
			$sql="UPDATE bsums_recharge SET recharge_cardid='".$newCard."' WHERE recharge_cardid='".$card."'";
		}else{
			$sql="UPDATE bsums_recharge SET recharge_cardid='".$newCard."' WHERE recharge_cardid='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功补办会员卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="充值记录更改失败!";
		}
		//将上下级提成记录更换掉   更换下级
		if($type==1){
			$sql="UPDATE bsums_pay_up_card SET puc_down_card='".$newCard."' WHERE puc_down_card='".$card."'";
		}else{
			$sql="UPDATE bsums_pay_up_card SET puc_down_card='".$newCard."' WHERE puc_down_card='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功补办会员卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="提成下级会员记录更改失败!";
		}
		//将上下级提成记录更换掉   更换上级
		if($type==1){
			$sql="UPDATE bsums_pay_up_card SET puc_up_card='".$newCard."' WHERE puc_up_card='".$card."'";
		}else{
			$sql="UPDATE bsums_pay_up_card SET puc_up_card='".$newCard."' WHERE puc_up_card='".$card."'";
		}
		$ansData=array();
		if($this->bsumsDB->execute($sql)){
			$ansData['status']="ok";
			$ansData['msg']="成功补办会员卡!";
		}else{
			$ansData['status']="no";
			$ansData['msg']="提成上级会员记录更改失败!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	//验证卡密码的API
	//  参数 card:卡号  password:密码  type:类型 1 0
	public function cardPasswordCheck(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$password=md5($_REQUEST['password']);
		$type=$_REQUEST['type'];
		if($type==1){
			$sql="SELECT card_password FROM bsums_mcard WHERE card_guid = '".$card."'";
		}else{
			$sql="SELECT card_password FROM bsums_tcard WHERE card_guid = '".$card."'";
		}
		$ansData=array();
		$aaa['password']=$this->bsumsDB->query($sql);
		$ansData=$aaa[0]['card_password'];
		if($ansData['password']!=$password){
			$ansData['status']="no";
			$ansData['msg']="会员卡密码错误!";
		}else{
			$ansData['status']="ok";
			$ansData['msg']="会员卡密码验证成功!";
		}
		$this->ajaxReturn($ansData,"json");
	}
	public function cardShowInfo(){
		$this->newDBConstruct();
		$card=$_REQUEST['card'];
		$cardShowInfo=array();
		$mcardShowInfo=array();
		$tcardShowInfo=array();
		$sql="SELECT card_money,card_username,card_guid,card_userphone,card_type FROM bsums_mcard WHERE card_guid='".$card."'";
		$mcardShowInfo=$this->bsumsDB->query($sql);
		$mcardShowInfo=$mcardShowInfo;
		$sql="SELECT card_money,card_username,card_guid,card_userphone,card_type FROM bsums_tcard WHERE card_guid='".$card."'";
		$tcardShowInfo=$this->bsumsDB->query($sql);
		$tcardShowInfo=$tcardShowInfo;
		$cardShowInfo=array_merge($mcardShowInfo,$tcardShowInfo);
		$ansData=array();
		if(count($cardShowInfo)==0){
			$ansData['status']="error";
			$ansData['msg']="信息返回失败!";
		}else{
			$ansData['status']="ok";
			$ansData['msg']="信息成功返回!";
			$ansData['cardShowInfo']=$cardShowInfo[0];
		}
		$this->ajaxReturn($ansData,"json");
	}
	//用于测试的函数
	public function testFunction(){
			 // $this->showLevelPercent();
	}

}