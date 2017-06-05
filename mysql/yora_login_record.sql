/*
Navicat MySQL Data Transfer

Source Server         : lo
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : yora

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-05-29 19:12:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yora_login_record`
-- ----------------------------
DROP TABLE IF EXISTS `yora_login_record`;
CREATE TABLE `yora_login_record` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `UserId` int(255) DEFAULT NULL COMMENT '用户表id',
  `Time` datetime NOT NULL COMMENT '最后一次登录时间',
  `Number` int(255) NOT NULL DEFAULT '0' COMMENT '登陆次数，默认0',
  `Ip` varchar(255) NOT NULL COMMENT '用户Ip',
  PRIMARY KEY (`Id`),
  KEY `User-id7` (`UserId`),
  CONSTRAINT `User-id7` FOREIGN KEY (`UserId`) REFERENCES `yora_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yora_login_record
-- ----------------------------
