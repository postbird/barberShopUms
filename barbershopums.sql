/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.6.26 : Database - barbershopums
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`barbershopums` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `barbershopums`;

/*Table structure for table `bsums_admin` */

DROP TABLE IF EXISTS `bsums_admin`;

CREATE TABLE `bsums_admin` (
  `adminid` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `adminname` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '管理员登录名',
  `adminpassword` varchar(255) NOT NULL DEFAULT 'md5(''123456'')' COMMENT '管理员密码',
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_admin` */

insert  into `bsums_admin`(`adminid`,`adminname`,`adminpassword`) values (1,'666','e10adc3949ba59abbe56e057f20f883e');

/*Table structure for table `bsums_card_off_log` */

DROP TABLE IF EXISTS `bsums_card_off_log`;

CREATE TABLE `bsums_card_off_log` (
  `col_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `col_card` varchar(255) NOT NULL,
  `col_money` double NOT NULL,
  `col_username` varchar(255) NOT NULL,
  `col_userphone` varchar(255) NOT NULL,
  `col_type` int(1) NOT NULL DEFAULT '1',
  `col_time` varchar(255) NOT NULL DEFAULT '2016-08-04',
  PRIMARY KEY (`col_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_card_off_log` */

insert  into `bsums_card_off_log`(`col_id`,`col_card`,`col_money`,`col_username`,`col_userphone`,`col_type`,`col_time`) values (4,'111111',223,'小明','13816244919',1,'2016-08-04'),(5,'211115',100,'211115','211115',1,'2016-08-13'),(6,'211114',1000,'211114','211114',1,'2016-08-13');

/*Table structure for table `bsums_consume_inte` */

DROP TABLE IF EXISTS `bsums_consume_inte`;

CREATE TABLE `bsums_consume_inte` (
  `ci_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `ci_money` int(155) NOT NULL DEFAULT '1' COMMENT '消费1元消耗1积分',
  PRIMARY KEY (`ci_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_consume_inte` */

insert  into `bsums_consume_inte`(`ci_id`,`ci_money`) values (1,1);

/*Table structure for table `bsums_consume_mcard` */

DROP TABLE IF EXISTS `bsums_consume_mcard`;

CREATE TABLE `bsums_consume_mcard` (
  `mc_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '消费id',
  `mc_card` varchar(255) NOT NULL DEFAULT '0' COMMENT '消费用户卡号',
  `mc_money` double NOT NULL DEFAULT '0' COMMENT '消费金额',
  `mc_type1` int(255) NOT NULL DEFAULT '0' COMMENT '消费类型',
  `mc_emp1` int(255) NOT NULL DEFAULT '0' COMMENT '收银员工',
  `mc_order1` int(1) NOT NULL DEFAULT '0' COMMENT '是否点客 1 是 0否',
  `mc_type2` int(255) NOT NULL DEFAULT '0',
  `mc_emp2` int(255) NOT NULL DEFAULT '0',
  `mc_order2` int(1) NOT NULL DEFAULT '0',
  `mc_type3` int(255) NOT NULL DEFAULT '0',
  `mc_emp3` int(255) NOT NULL DEFAULT '0',
  `mc_order3` int(1) NOT NULL DEFAULT '0',
  `mc_comment` varchar(255) NOT NULL DEFAULT '无备注' COMMENT '备注',
  `mc_time` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '消费时间',
  `mc_big` int(1) NOT NULL DEFAULT '0' COMMENT '默认不是大活 0  1是大活',
  `mc_count` int(1) NOT NULL DEFAULT '1' COMMENT '活的数量 默认1 最高3',
  `mc_emp` int(255) NOT NULL DEFAULT '0' COMMENT '收银员工',
  PRIMARY KEY (`mc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_consume_mcard` */

insert  into `bsums_consume_mcard`(`mc_id`,`mc_card`,`mc_money`,`mc_type1`,`mc_emp1`,`mc_order1`,`mc_type2`,`mc_emp2`,`mc_order2`,`mc_type3`,`mc_emp3`,`mc_order3`,`mc_comment`,`mc_time`,`mc_big`,`mc_count`,`mc_emp`) values (14,'111111',100,1,8,1,0,0,0,0,0,0,'测试','2016-08-08 21:08:31',1,1,8),(15,'111111',30,1,9,0,0,0,0,0,0,0,'无备注','2016-08-08 21:08:08',0,1,8),(17,'111111',20,2,8,1,0,0,0,0,0,0,'无备注','2016-08-13 23:08:02',0,1,8),(18,'111111',20,2,8,1,0,0,0,0,0,0,'无备注','2016-08-13 23:08:03',0,1,8);

/*Table structure for table `bsums_consume_tcard` */

DROP TABLE IF EXISTS `bsums_consume_tcard`;

CREATE TABLE `bsums_consume_tcard` (
  `tc_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '次数消费',
  `tc_time` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '次数消费时间',
  `tc_money` double NOT NULL DEFAULT '0' COMMENT '次数消费金额',
  `tc_count` int(255) NOT NULL DEFAULT '0' COMMENT '次数消费冲减次数',
  `tc_big` int(1) NOT NULL DEFAULT '0' COMMENT '次数消费大活',
  `tc_emp` int(255) NOT NULL DEFAULT '0' COMMENT '次数消费办理员工',
  `tc_comment` varchar(255) NOT NULL DEFAULT '无备注' COMMENT '次数消费备注',
  `tc_card` varchar(255) NOT NULL DEFAULT '000000' COMMENT '次数消费卡号',
  `tc_type` int(255) NOT NULL DEFAULT '1' COMMENT '次数消费类型',
  `tc_consume_emp` int(255) NOT NULL DEFAULT '0' COMMENT '服务员工',
  `tc_order` int(1) NOT NULL DEFAULT '0' COMMENT '是否点客',
  PRIMARY KEY (`tc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_consume_tcard` */

insert  into `bsums_consume_tcard`(`tc_id`,`tc_time`,`tc_money`,`tc_count`,`tc_big`,`tc_emp`,`tc_comment`,`tc_card`,`tc_type`,`tc_consume_emp`,`tc_order`) values (2,'2016-08-06 21:08:23',20,1,1,8,'无备注','123456',1,8,1),(3,'2016-08-06 21:08:31',20,1,1,8,'无备注','123456',1,8,1),(4,'2016-08-06 21:08:35',20,1,1,8,'无备注','123456',1,8,1),(5,'2016-08-06 21:08:46',20,1,0,8,'beizhu','123456',1,8,0),(6,'2016-08-06 21:08:55',20,1,0,8,'beizhu','123456',1,8,0),(7,'2016-08-13 23:08:07',20,1,0,8,'发质一般！','666666',17,8,1);

/*Table structure for table `bsums_consume_type` */

DROP TABLE IF EXISTS `bsums_consume_type`;

CREATE TABLE `bsums_consume_type` (
  `ctype_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `ctype_name` varchar(255) NOT NULL COMMENT '消费类型',
  PRIMARY KEY (`ctype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_consume_type` */

insert  into `bsums_consume_type`(`ctype_id`,`ctype_name`) values (1,'剪发'),(2,'洗发'),(3,'染发'),(4,'烫发'),(5,'护发'),(6,'其他'),(17,'剪发2');

/*Table structure for table `bsums_emp` */

DROP TABLE IF EXISTS `bsums_emp`;

CREATE TABLE `bsums_emp` (
  `emp_id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工id',
  `emp_name` varchar(12) NOT NULL COMMENT '员工姓名',
  `emp_password` varchar(255) NOT NULL DEFAULT 'md5(''123456'')' COMMENT '员工密码',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_emp` */

insert  into `bsums_emp`(`emp_id`,`emp_name`,`emp_password`) values (8,'李瞻文','e10adc3949ba59abbe56e057f20f883e'),(9,'姜世强','e10adc3949ba59abbe56e057f20f883e');

/*Table structure for table `bsums_level` */

DROP TABLE IF EXISTS `bsums_level`;

CREATE TABLE `bsums_level` (
  `level_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级id',
  `level_rank` int(255) NOT NULL DEFAULT '1' COMMENT '等级名称 1,2,3,4,5',
  `level_money` int(255) NOT NULL DEFAULT '8' COMMENT '等级提成贡献比例用时需要/100',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_level` */

insert  into `bsums_level`(`level_id`,`level_rank`,`level_money`) values (1,1,8),(2,2,16),(3,3,4),(4,4,3),(5,5,3),(6,6,3),(7,7,2),(8,8,2),(9,9,2),(10,10,1);

/*Table structure for table `bsums_mcard` */

DROP TABLE IF EXISTS `bsums_mcard`;

CREATE TABLE `bsums_mcard` (
  `card_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '金额卡id',
  `card_guid` varchar(255) NOT NULL COMMENT '金额卡卡号',
  `card_money` double NOT NULL COMMENT '金额卡剩余钱',
  `card_regmoney` double NOT NULL COMMENT '金额卡注册时金额',
  `card_regtime` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '金额卡注册时间',
  `card_username` varchar(255) NOT NULL COMMENT '金额卡注册姓名',
  `card_usersex` int(1) NOT NULL DEFAULT '1' COMMENT '金额卡性别1男0女',
  `card_userbirth` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '金额卡生日',
  `card_userphone` varchar(255) NOT NULL DEFAULT '00000000000' COMMENT '金额卡电话',
  `card_emp` int(255) NOT NULL DEFAULT '0' COMMENT '金额卡注册员工',
  `card_inte` int(255) NOT NULL DEFAULT '0' COMMENT '金额卡积分',
  `card_off` int(1) NOT NULL DEFAULT '0' COMMENT '金额卡注销1注销0未注销',
  `card_loss` int(1) NOT NULL DEFAULT '0' COMMENT '金额卡挂失1挂失0未挂失',
  `card_reissue` int(255) NOT NULL DEFAULT '0' COMMENT '补卡次数',
  `card_active` int(1) NOT NULL DEFAULT '1' COMMENT '卡状态 1可用 0不可用（与挂失和注销状态有关）',
  `card_password` varchar(255) NOT NULL DEFAULT 'md5("123456'')' COMMENT '卡密码',
  `card_password_active` int(1) NOT NULL DEFAULT '0' COMMENT '是否使用密码',
  `card_type` int(1) NOT NULL DEFAULT '1' COMMENT '金额卡',
  `card_upcard` varchar(255) NOT NULL DEFAULT '0' COMMENT '上级',
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_mcard` */

insert  into `bsums_mcard`(`card_id`,`card_guid`,`card_money`,`card_regmoney`,`card_regtime`,`card_username`,`card_usersex`,`card_userbirth`,`card_userphone`,`card_emp`,`card_inte`,`card_off`,`card_loss`,`card_reissue`,`card_active`,`card_password`,`card_password_active`,`card_type`,`card_upcard`) values (1,'111111',383,100,'2016-08-05 22:08:09','小明',1,'2016-08-04','13816244919',8,230,0,0,2,1,'e10adc3949ba59abbe56e057f20f883e',1,1,'0'),(2,'111113',200,100,'2016-08-08 22:08:49','小刚',1,'2016-08-17','13816244919',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111112'),(3,'111114',100,100,'2016-08-10 02:08:31','11111',1,'2016-8-10','11111111111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(4,'111115',100,100,'2016-08-10 02:08:42','11111',1,'2016-8-10','11111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(5,'111116',100,100,'2016-08-10 02:08:52','11111',1,'2016-8-10','11111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(6,'111117',100,100,'2016-08-10 02:08:05','11111',1,'2016-8-10','11111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(7,'111118',100,100,'2016-08-10 02:08:15','11111',1,'2016-8-10','11111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(8,'111119',100,100,'2016-08-10 02:08:28','11111',1,'2016-8-10','11111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111111'),(9,'211111',1000,1000,'2016-08-10 22:08:09','211111',1,'2016-8-10','211111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'111113'),(10,'211112',1000,1000,'2016-08-10 22:08:27','211111',1,'2016-8-10','211111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'211111'),(11,'211113',1000,1000,'2016-08-10 22:08:44','211111',1,'2016-8-10','211111',8,0,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,1,'211112'),(12,'211114',1000,1000,'2016-08-10 22:08:02','211114',1,'2016-8-10','211114',8,0,1,0,0,0,'e10adc3949ba59abbe56e057f20f883e',0,1,'211113'),(13,'211115',100,100,'2016-08-10 22:08:50','211115',1,'2016-8-10','211115',8,0,1,0,0,0,'e10adc3949ba59abbe56e057f20f883e',0,1,'111114');

/*Table structure for table `bsums_pay_up_card` */

DROP TABLE IF EXISTS `bsums_pay_up_card`;

CREATE TABLE `bsums_pay_up_card` (
  `puc_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `puc_down_card` varchar(255) NOT NULL DEFAULT '0' COMMENT '下属会员卡号',
  `puc_up_card` varchar(255) NOT NULL DEFAULT '0' COMMENT '上属会员卡号',
  `puc_flag` int(1) NOT NULL DEFAULT '0' COMMENT '是否已经付款1是0否',
  `puc_level` int(255) NOT NULL DEFAULT '1' COMMENT '0表示自己和自己  其他为等级',
  `puc_up_name` varchar(255) NOT NULL COMMENT '上级手机号',
  `puc_up_phone` varchar(255) NOT NULL DEFAULT '0' COMMENT '上级姓名',
  `puc_percent` int(255) NOT NULL DEFAULT '8' COMMENT '提成比例',
  `puc_money` double NOT NULL DEFAULT '0' COMMENT '提成金额',
  PRIMARY KEY (`puc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_pay_up_card` */

insert  into `bsums_pay_up_card`(`puc_id`,`puc_down_card`,`puc_up_card`,`puc_flag`,`puc_level`,`puc_up_name`,`puc_up_phone`,`puc_percent`,`puc_money`) values (107,'123456','123456',0,1,'小红','11111111111',8,8),(108,'123456','111111',0,2,'小明','13816244919',16,16),(109,'111113','111113',0,1,'小刚','13816244919',8,8),(110,'111113','123456',0,2,'小红','11111111111',16,16),(111,'111113','111111',0,3,'小明','13816244919',4,4),(112,'111111','111111',0,1,'小明','13816244919',8,8),(113,'111114','111114',0,1,'11111','11111111111',8,8),(114,'111114','111111',0,2,'小明','13816244919',16,16),(115,'111115','111115',0,1,'11111','11111',8,8),(116,'111115','111111',0,2,'小明','13816244919',16,16),(117,'111116','111116',0,1,'11111','11111',8,8),(118,'111116','111111',0,2,'小明','13816244919',16,16),(119,'111117','111117',0,1,'11111','11111',8,8),(120,'111117','111111',0,2,'小明','13816244919',16,16),(121,'111118','111118',0,1,'11111','11111',8,8),(122,'111118','111111',0,2,'小明','13816244919',16,16),(123,'111119','111119',0,1,'11111','11111',8,8),(124,'111119','111111',0,2,'小明','13816244919',16,16),(125,'211111','211111',0,1,'211111','211111',8,80),(126,'211111','111113',0,2,'小刚','13816244919',16,16),(127,'211111','123456',0,3,'小红','11111111111',4,4),(128,'211111','111111',0,4,'小明','13816244919',3,3),(129,'211112','211112',0,1,'211111','211111',8,80),(130,'211112','211111',0,2,'211111','211111',16,160),(131,'211112','111113',0,3,'小刚','13816244919',4,4),(132,'211112','123456',0,4,'小红','11111111111',3,3),(133,'211112','111111',0,5,'小明','13816244919',3,3),(134,'211113','211113',0,1,'211111','211111',8,80),(135,'211113','211112',0,2,'211111','211111',16,160),(136,'211113','211111',0,3,'211111','211111',4,40),(137,'211113','111113',0,4,'小刚','13816244919',3,3),(138,'211113','123456',0,5,'小红','11111111111',3,3),(139,'211114','211114',0,1,'211114','211114',8,80),(140,'211114','211113',0,2,'211111','211111',16,160),(141,'211114','211112',0,3,'211111','211111',4,40),(142,'211114','211111',0,4,'211111','211111',3,30),(143,'211114','111113',0,5,'小刚','13816244919',3,3),(144,'211115','211115',0,1,'211115','211115',8,8),(145,'211115','111114',0,2,'11111','11111111111',16,16),(146,'211115','111111',0,3,'小明','13816244919',4,4),(147,'666666','666666',0,1,'postbird','1111111111',8,16),(148,'666666','111111',0,2,'小明','13816244919',16,32);

/*Table structure for table `bsums_recharge` */

DROP TABLE IF EXISTS `bsums_recharge`;

CREATE TABLE `bsums_recharge` (
  `recharge_id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '充值id',
  `recharge_cardid` varchar(255) NOT NULL COMMENT '充值用户卡号',
  `recharge_time` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '充值时间',
  `recharge_money` double NOT NULL DEFAULT '0' COMMENT '充值合计金额',
  `recharge_emp` int(255) NOT NULL DEFAULT '0' COMMENT '充值员工',
  `recharge_type` int(1) NOT NULL DEFAULT '1' COMMENT '卡的类型',
  PRIMARY KEY (`recharge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_recharge` */

insert  into `bsums_recharge`(`recharge_id`,`recharge_cardid`,`recharge_time`,`recharge_money`,`recharge_emp`,`recharge_type`) values (1,'111111','2016-08-08 00:08:12',100,8,1),(2,'111111','2016-08-08 00:08:43',100,8,1),(3,'111113','2016-08-09 00:08:10',100,9,1),(4,'123456','2016-08-12 21:08:25',100,8,0),(6,'666666','2016-08-13 23:08:21',200,8,0),(7,'111111','2016-08-13 23:08:25',200,8,1);

/*Table structure for table `bsums_tcard` */

DROP TABLE IF EXISTS `bsums_tcard`;

CREATE TABLE `bsums_tcard` (
  `card_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '次数卡id',
  `card_guid` varchar(255) NOT NULL DEFAULT '000000' COMMENT '次数卡卡号',
  `card_money` double NOT NULL DEFAULT '0' COMMENT '次数卡充值金额',
  `card_regtime` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '次数卡注册时间',
  `card_regcount` int(255) NOT NULL DEFAULT '0' COMMENT '次数卡剩余次数',
  `card_usecount` int(255) NOT NULL DEFAULT '0' COMMENT '次数卡已使用次数',
  `card_username` varchar(255) NOT NULL COMMENT '次数卡姓名',
  `card_usersex` int(1) NOT NULL DEFAULT '1' COMMENT '次数卡性别',
  `card_userbirth` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '次数卡生日',
  `card_userphone` varchar(255) NOT NULL DEFAULT '00000000000' COMMENT '次数卡电话',
  `card_emp` int(255) NOT NULL DEFAULT '0' COMMENT '次数卡员工',
  `card_off` int(1) NOT NULL DEFAULT '0' COMMENT '次数卡注销',
  `card_loss` int(1) NOT NULL DEFAULT '0' COMMENT '次数卡挂失',
  `card_reissue` int(255) NOT NULL DEFAULT '0' COMMENT '次数卡补卡',
  `card_active` int(1) NOT NULL DEFAULT '1' COMMENT '次数卡状态',
  `card_password` varchar(255) NOT NULL DEFAULT 'md5("123456")' COMMENT '次数卡密码',
  `card_password_active` int(1) NOT NULL DEFAULT '0' COMMENT '次数卡密码启用状态',
  `card_type` int(1) NOT NULL DEFAULT '0' COMMENT '次数卡',
  `card_upcard` varchar(255) NOT NULL DEFAULT '0' COMMENT '上级',
  `card_consume_type` int(255) NOT NULL DEFAULT '1' COMMENT '次数卡的消费类型',
  `card_regmoney` double NOT NULL DEFAULT '0' COMMENT '次数卡的注册金额',
  `card_inte` int(255) NOT NULL DEFAULT '0' COMMENT '次数卡的积分',
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `bsums_tcard` */

insert  into `bsums_tcard`(`card_id`,`card_guid`,`card_money`,`card_regtime`,`card_regcount`,`card_usecount`,`card_username`,`card_usersex`,`card_userbirth`,`card_userphone`,`card_emp`,`card_off`,`card_loss`,`card_reissue`,`card_active`,`card_password`,`card_password_active`,`card_type`,`card_upcard`,`card_consume_type`,`card_regmoney`,`card_inte`) values (8,'123456',200,'2016-08-07 22:08:34',20,0,'小红',0,'2016-08-10','11111111111',8,0,0,5,1,'e10adc3949ba59abbe56e057f20f883e',0,0,'111111',1,100,0),(9,'666666',380,'2016-08-13 23:08:13',19,1,'postbird',1,'2016-08-10','1111111111',8,0,0,0,1,'e10adc3949ba59abbe56e057f20f883e',0,0,'111111',17,200,20);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
