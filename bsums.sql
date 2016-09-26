-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2016 at 03:30 PM
-- Server version: 5.1.46
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `barbershopums`
--
CREATE DATABASE `barbershopums` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `barbershopums`;

-- --------------------------------------------------------

--
-- Table structure for table `bsums_admin`
--

CREATE TABLE IF NOT EXISTS `bsums_admin` (
  `adminid` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `adminname` varchar(255) NOT NULL DEFAULT 'admin' COMMENT '管理员登录名',
  `adminpassword` varchar(255) NOT NULL DEFAULT 'md5(''123456'')' COMMENT '管理员密码',
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bsums_admin`
--

INSERT INTO `bsums_admin` (`adminid`, `adminname`, `adminpassword`) VALUES
(2, '666', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `bsums_card_off_log`
--

CREATE TABLE IF NOT EXISTS `bsums_card_off_log` (
  `col_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `col_card` varchar(255) NOT NULL,
  `col_money` double NOT NULL,
  `col_username` varchar(255) NOT NULL,
  `col_userphone` varchar(255) NOT NULL,
  `col_type` int(1) NOT NULL DEFAULT '1',
  `col_time` varchar(255) NOT NULL DEFAULT '2016-08-04',
  PRIMARY KEY (`col_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_card_off_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_consume_inte`
--

CREATE TABLE IF NOT EXISTS `bsums_consume_inte` (
  `ci_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `ci_money` int(155) NOT NULL DEFAULT '1' COMMENT '消费1元消耗1积分',
  PRIMARY KEY (`ci_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bsums_consume_inte`
--

INSERT INTO `bsums_consume_inte` (`ci_id`, `ci_money`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bsums_consume_mcard`
--

CREATE TABLE IF NOT EXISTS `bsums_consume_mcard` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_consume_mcard`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_consume_tcard`
--

CREATE TABLE IF NOT EXISTS `bsums_consume_tcard` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_consume_tcard`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_consume_type`
--

CREATE TABLE IF NOT EXISTS `bsums_consume_type` (
  `ctype_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT,
  `ctype_name` varchar(255) NOT NULL COMMENT '消费类型',
  PRIMARY KEY (`ctype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bsums_consume_type`
--

INSERT INTO `bsums_consume_type` (`ctype_id`, `ctype_name`) VALUES
(1, '剪发'),
(2, '洗发'),
(3, '染发'),
(4, '烫发'),
(5, '护发'),
(6, '其他');

-- --------------------------------------------------------

--
-- Table structure for table `bsums_emp`
--

CREATE TABLE IF NOT EXISTS `bsums_emp` (
  `emp_id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工id',
  `emp_name` varchar(12) NOT NULL COMMENT '员工姓名',
  `emp_password` varchar(255) NOT NULL DEFAULT 'md5(''123456'')' COMMENT '员工密码',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bsums_emp`
--

INSERT INTO `bsums_emp` (`emp_id`, `emp_name`, `emp_password`) VALUES
(1, '管理员', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `bsums_level`
--

CREATE TABLE IF NOT EXISTS `bsums_level` (
  `level_id` bigint(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '等级id',
  `level_rank` int(255) NOT NULL DEFAULT '1' COMMENT '等级名称 1,2,3,4,5',
  `level_money` int(255) NOT NULL DEFAULT '8' COMMENT '等级提成贡献比例用时需要/100',
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=11 ;

--
-- Dumping data for table `bsums_level`
--

INSERT INTO `bsums_level` (`level_id`, `level_rank`, `level_money`) VALUES
(1, 1, 8),
(2, 2, 16),
(3, 3, 4),
(4, 4, 3),
(5, 5, 3),
(6, 6, 3),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bsums_mcard`
--

CREATE TABLE IF NOT EXISTS `bsums_mcard` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_mcard`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_pay_up_card`
--

CREATE TABLE IF NOT EXISTS `bsums_pay_up_card` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_pay_up_card`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_recharge`
--

CREATE TABLE IF NOT EXISTS `bsums_recharge` (
  `recharge_id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT '充值id',
  `recharge_cardid` varchar(255) NOT NULL COMMENT '充值用户卡号',
  `recharge_time` varchar(255) NOT NULL DEFAULT '2016-08-03' COMMENT '充值时间',
  `recharge_money` double NOT NULL DEFAULT '0' COMMENT '充值合计金额',
  `recharge_emp` int(255) NOT NULL DEFAULT '0' COMMENT '充值员工',
  `recharge_type` int(1) NOT NULL DEFAULT '1' COMMENT '卡的类型',
  PRIMARY KEY (`recharge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_recharge`
--


-- --------------------------------------------------------

--
-- Table structure for table `bsums_tcard`
--

CREATE TABLE IF NOT EXISTS `bsums_tcard` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bsums_tcard`
--

