/*
Navicat MySQL Data Transfer

Source Server         : lo
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : onlineshop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-06-02 23:32:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `os_admin`
-- ----------------------------
DROP TABLE IF EXISTS `os_admin`;
CREATE TABLE `os_admin` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Password` varchar(255) NOT NULL COMMENT '管理员密码md5加密最短8位',
  `Name` varchar(255) NOT NULL COMMENT '管理员真实姓名',
  `Sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别1：男 2：女 0：未知 默认0',
  `Phone` varchar(20) NOT NULL COMMENT '手机号(用作用户名)',
  `HeadImgUrl` varchar(255) DEFAULT NULL COMMENT '头像url',
  PRIMARY KEY (`Id`,`Sex`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_admin
-- ----------------------------
INSERT INTO `os_admin` VALUES ('1', '42d4f6828456a8cad5ca3d3c89ab2730', '冯管理', '1', '17862700650', '/onlineShop/uploaddate/admins/headimg/2017-05-26d5jqpe.jpeg');

-- ----------------------------
-- Table structure for `os_advertisement`
-- ----------------------------
DROP TABLE IF EXISTS `os_advertisement`;
CREATE TABLE `os_advertisement` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Url` varchar(255) DEFAULT NULL COMMENT '连接路径',
  `ImgUrl` varchar(255) NOT NULL COMMENT '照片路径',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_advertisement
-- ----------------------------
INSERT INTO `os_advertisement` VALUES ('12', '/onlineShop/webContent/webPre/goods/goods.php?id=19', '/onlineShop/uploaddate/advertisement/photos/2017-06-02cm4y7q.png');
INSERT INTO `os_advertisement` VALUES ('13', '/onlineShop/webContent/webPre/goods/goods.php?id=20', '/onlineShop/uploaddate/advertisement/photos/2017-06-020tn1u3.png');
INSERT INTO `os_advertisement` VALUES ('14', '/onlineShop/webContent/webPre/goods/goods.php?id=17', '/onlineShop/uploaddate/advertisement/photos/2017-06-02m1duwe.png');

-- ----------------------------
-- Table structure for `os_city`
-- ----------------------------
DROP TABLE IF EXISTS `os_city`;
CREATE TABLE `os_city` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL COMMENT '城市名称',
  `ProvinceId` int(255) NOT NULL COMMENT '省份id',
  PRIMARY KEY (`Id`),
  KEY `Province-Id4` (`ProvinceId`),
  CONSTRAINT `Province-Id4` FOREIGN KEY (`ProvinceId`) REFERENCES `os_province` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_city
-- ----------------------------
INSERT INTO `os_city` VALUES ('1', '威海市', '1');
INSERT INTO `os_city` VALUES ('2', '济南市', '1');
INSERT INTO `os_city` VALUES ('3', '北京市', '3');

-- ----------------------------
-- Table structure for `os_goods`
-- ----------------------------
DROP TABLE IF EXISTS `os_goods`;
CREATE TABLE `os_goods` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Name` varchar(255) NOT NULL COMMENT '商品名称',
  `UserId` int(255) DEFAULT NULL COMMENT '用户id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  `Number` int(255) NOT NULL DEFAULT '0' COMMENT '数量默认0',
  `Price` int(255) NOT NULL DEFAULT '0' COMMENT '单价 默认0',
  `Introduce` varchar(255) NOT NULL COMMENT '商品介绍文件url',
  `Type` int(255) NOT NULL COMMENT '货物类型id\r\n[外键删除时：RESTRICT]\r\n[外键更改时：CASCADE]',
  `ImgUrl` varchar(255) NOT NULL COMMENT '展示图片Url',
  PRIMARY KEY (`Id`),
  KEY `os_goods_ibfk_1` (`UserId`),
  KEY `Type` (`Type`),
  CONSTRAINT `os_goods_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `os_user` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `os_goods_ibfk_2` FOREIGN KEY (`Type`) REFERENCES `os_goods_type` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_goods
-- ----------------------------
INSERT INTO `os_goods` VALUES ('6', '测试商品2', '2', '10', '220', '/onlineShop/uploaddate/goods/Introduce/2017-05-2326psia.txt', '1', '/onlineShop/uploaddate/goods/headimg/2017-05-2315vw3q.jpeg');
INSERT INTO `os_goods` VALUES ('8', '卫龙辣条', '1', '90', '200', '/onlineShop/uploaddate/goods/Introduce/2017-06-02lnv4hq.txt', '4', '/onlineShop/uploaddate/goods/headimg/2017-06-02w97ds1.jpeg');
INSERT INTO `os_goods` VALUES ('9', '新鲜大樱桃车厘子', '1', '3000', '5', '/onlineShop/uploaddate/goods/Introduce/2017-06-02og5wn4.txt', '5', '/onlineShop/uploaddate/goods/headimg/2017-06-02e91gk6.jpeg');
INSERT INTO `os_goods` VALUES ('10', '牙刷', '1', '100', '10', '/onlineShop/uploaddate/goods/Introduce/2017-06-02hkc8vw.txt', '6', '/onlineShop/uploaddate/goods/headimg/2017-06-02bcutx5.jpeg');
INSERT INTO `os_goods` VALUES ('11', '九成新高数课本', '4', '10', '10', '/onlineShop/uploaddate/goods/Introduce/2017-06-02l7zim0.txt', '1', '/onlineShop/uploaddate/goods/headimg/2017-06-0205wym6.png');
INSERT INTO `os_goods` VALUES ('12', '夏威夷果（1kg）', '4', '1000', '30', '/onlineShop/uploaddate/goods/Introduce/2017-06-02ud2w1r.txt', '4', '/onlineShop/uploaddate/goods/headimg/2017-06-02mcawyu.png');
INSERT INTO `os_goods` VALUES ('13', '烟台大苹果（1kg）', '4', '50', '5', '/onlineShop/uploaddate/goods/Introduce/2017-06-02oy15iz.txt', '5', '/onlineShop/uploaddate/goods/headimg/2017-06-02qh4dgp.png');
INSERT INTO `os_goods` VALUES ('14', '精致500ml玻璃水杯', '4', '50', '20', '/onlineShop/uploaddate/goods/Introduce/2017-06-023v64lz.txt', '6', '/onlineShop/uploaddate/goods/headimg/2017-06-028kn3sd.png');
INSERT INTO `os_goods` VALUES ('15', '全新正版考研数学书（一套）', '4', '50', '100', '/onlineShop/uploaddate/goods/Introduce/2017-06-0292xqr3.txt', '7', '/onlineShop/uploaddate/goods/headimg/2017-06-02wcq4ik.png');
INSERT INTO `os_goods` VALUES ('16', '英语四六级辅导', '5', '10', '200', '/onlineShop/uploaddate/goods/Introduce/2017-06-022k9o01.txt', '3', '/onlineShop/uploaddate/goods/headimg/2017-06-02ezsxmn.png');
INSERT INTO `os_goods` VALUES ('17', '全新女式mp4', '5', '10', '500', '/onlineShop/uploaddate/goods/Introduce/2017-06-02o1479v.txt', '8', '/onlineShop/uploaddate/goods/headimg/2017-06-02d02ey3.png');
INSERT INTO `os_goods` VALUES ('18', '沙瓤西瓜（1块约500g）', '5', '10', '3', '/onlineShop/uploaddate/goods/Introduce/2017-06-02vrlpun.txt', '5', '/onlineShop/uploaddate/goods/headimg/2017-06-02mxeytb.png');
INSERT INTO `os_goods` VALUES ('19', '纯棉毛巾', '5', '20', '5', '/onlineShop/uploaddate/goods/Introduce/2017-06-02bst8hk.txt', '6', '/onlineShop/uploaddate/goods/headimg/2017-06-029k2sc8.png');
INSERT INTO `os_goods` VALUES ('20', '行楷字帖', '4', '10', '20', '', '7', '/onlineShop/uploaddate/goods/headimg/2017-06-029di5ct.png');

-- ----------------------------
-- Table structure for `os_goods_photo`
-- ----------------------------
DROP TABLE IF EXISTS `os_goods_photo`;
CREATE TABLE `os_goods_photo` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Url` varchar(255) NOT NULL COMMENT '照片路径',
  `GoodsId` int(255) NOT NULL COMMENT '商品Id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  PRIMARY KEY (`Id`),
  KEY `GoodsId` (`GoodsId`),
  CONSTRAINT `os_goods_photo_ibfk_1` FOREIGN KEY (`GoodsId`) REFERENCES `os_goods` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_goods_photo
-- ----------------------------
INSERT INTO `os_goods_photo` VALUES ('2', '/onlineShop/uploaddate/goods/photos/2017-05-30t76qhl.png', '6');
INSERT INTO `os_goods_photo` VALUES ('3', '/onlineShop/uploaddate/goods/photos/2017-05-3061mnvi.jpeg', '6');
INSERT INTO `os_goods_photo` VALUES ('6', '/onlineShop/uploaddate/goods/photos/2017-06-017ac4mk.jpeg', '8');
INSERT INTO `os_goods_photo` VALUES ('7', '/onlineShop/uploaddate/goods/photos/2017-06-01ovj752.jpeg', '8');
INSERT INTO `os_goods_photo` VALUES ('8', '/onlineShop/uploaddate/goods/photos/2017-06-01xesawi.jpeg', '8');
INSERT INTO `os_goods_photo` VALUES ('9', '/onlineShop/uploaddate/goods/photos/2017-06-02csa7oe.jpeg', '9');
INSERT INTO `os_goods_photo` VALUES ('10', '/onlineShop/uploaddate/goods/photos/2017-06-02pgl3a4.jpeg', '10');
INSERT INTO `os_goods_photo` VALUES ('11', '/onlineShop/uploaddate/goods/photos/2017-06-02507q2s.jpeg', '10');

-- ----------------------------
-- Table structure for `os_goods_type`
-- ----------------------------
DROP TABLE IF EXISTS `os_goods_type`;
CREATE TABLE `os_goods_type` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Name` varchar(255) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_goods_type
-- ----------------------------
INSERT INTO `os_goods_type` VALUES ('1', '二手');
INSERT INTO `os_goods_type` VALUES ('3', '技能');
INSERT INTO `os_goods_type` VALUES ('4', '零食');
INSERT INTO `os_goods_type` VALUES ('5', '水果');
INSERT INTO `os_goods_type` VALUES ('6', '生活用品');
INSERT INTO `os_goods_type` VALUES ('7', '学习资料');
INSERT INTO `os_goods_type` VALUES ('8', '电子产品');

-- ----------------------------
-- Table structure for `os_login_record`
-- ----------------------------
DROP TABLE IF EXISTS `os_login_record`;
CREATE TABLE `os_login_record` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `UserId` int(255) DEFAULT NULL COMMENT '用户表id',
  `Time` datetime NOT NULL COMMENT '最后一次登录时间',
  `Number` int(255) NOT NULL DEFAULT '0' COMMENT '登陆次数，默认0',
  `Ip` varchar(255) NOT NULL COMMENT '用户Ip',
  PRIMARY KEY (`Id`),
  KEY `User-id7` (`UserId`),
  CONSTRAINT `User-id7` FOREIGN KEY (`UserId`) REFERENCES `os_user` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_login_record
-- ----------------------------
INSERT INTO `os_login_record` VALUES ('1', '1', '2017-05-29 20:58:11', '2', '::1');
INSERT INTO `os_login_record` VALUES ('2', '1', '2017-05-30 17:51:42', '5', '::1');
INSERT INTO `os_login_record` VALUES ('3', '2', '2017-05-30 17:52:06', '2', '::1');
INSERT INTO `os_login_record` VALUES ('4', '1', '2017-05-31 22:19:17', '4', '::1');
INSERT INTO `os_login_record` VALUES ('5', '1', '2017-06-01 15:40:57', '4', '::1');
INSERT INTO `os_login_record` VALUES ('6', '2', '2017-06-01 15:40:13', '3', '::1');
INSERT INTO `os_login_record` VALUES ('7', '1', '2017-06-02 22:11:47', '1', '::1');
INSERT INTO `os_login_record` VALUES ('8', '4', '2017-06-02 23:27:46', '4', '172.30.17.75');
INSERT INTO `os_login_record` VALUES ('9', '5', '2017-06-02 22:49:35', '1', '172.30.17.75');

-- ----------------------------
-- Table structure for `os_order`
-- ----------------------------
DROP TABLE IF EXISTS `os_order`;
CREATE TABLE `os_order` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `UserId` int(255) NOT NULL COMMENT '用户Id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  `GoodsId` int(255) NOT NULL COMMENT '商品Id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  `Type` int(1) NOT NULL DEFAULT '0' COMMENT '订单状态\r\n0：待确认\r\n1：已接单\r\n2：配送中\r\n3：取消订单\r\n4：买家确认收货\r\n5：完成订单',
  `CustomerEvaluate` int(1) DEFAULT NULL COMMENT '买家评价\r\n0：好评\r\n1：中评\r\n2：差评',
  `CustomerEvaluateText` varchar(255) DEFAULT NULL COMMENT '买家评价文字内容',
  `BusinessmanEvaluate` int(1) DEFAULT NULL COMMENT '卖家评价\r\n0：好评\r\n1：中评\r\n2：差评',
  `BusinessmanEvaluateText` varchar(255) DEFAULT NULL COMMENT '卖家评价文字内容',
  `Number` int(255) NOT NULL DEFAULT '1' COMMENT '数量',
  `Price` int(255) NOT NULL DEFAULT '0' COMMENT '价格',
  `Time` datetime NOT NULL DEFAULT '2017-05-24 00:00:00' COMMENT '下单时间',
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `GoodsId` (`GoodsId`),
  CONSTRAINT `os_order_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `os_user` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `os_order_ibfk_2` FOREIGN KEY (`GoodsId`) REFERENCES `os_goods` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_order
-- ----------------------------
INSERT INTO `os_order` VALUES ('1', '1', '6', '0', null, null, '0', null, '1', '220', '2017-05-31 22:17:32');
INSERT INTO `os_order` VALUES ('2', '2', '8', '5', '0', '真好吃', '0', null, '10', '2000', '2017-06-01 15:13:41');
INSERT INTO `os_order` VALUES ('5', '2', '8', '0', null, null, '0', null, '10', '2000', '2017-06-01 15:28:34');
INSERT INTO `os_order` VALUES ('6', '2', '8', '3', null, null, null, null, '1', '200', '2017-06-01 15:40:27');
INSERT INTO `os_order` VALUES ('7', '4', '8', '0', null, null, null, null, '10', '2000', '2017-06-02 22:48:41');
INSERT INTO `os_order` VALUES ('8', '4', '6', '0', null, null, null, null, '1', '220', '2017-06-02 23:19:28');

-- ----------------------------
-- Table structure for `os_province`
-- ----------------------------
DROP TABLE IF EXISTS `os_province`;
CREATE TABLE `os_province` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL COMMENT '省份名称',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_province
-- ----------------------------
INSERT INTO `os_province` VALUES ('1', '山东省');
INSERT INTO `os_province` VALUES ('2', '河北省');
INSERT INTO `os_province` VALUES ('3', '北京市');
INSERT INTO `os_province` VALUES ('8', '江苏省');

-- ----------------------------
-- Table structure for `os_school`
-- ----------------------------
DROP TABLE IF EXISTS `os_school`;
CREATE TABLE `os_school` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL COMMENT '城市名称',
  `CityId` int(255) NOT NULL COMMENT '城市id',
  PRIMARY KEY (`Id`),
  KEY `City-Id4` (`CityId`),
  CONSTRAINT `City-Id4` FOREIGN KEY (`CityId`) REFERENCES `os_city` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_school
-- ----------------------------
INSERT INTO `os_school` VALUES ('1', '哈工大', '1');
INSERT INTO `os_school` VALUES ('2', '山东大学', '1');
INSERT INTO `os_school` VALUES ('3', '北方工业大学', '3');

-- ----------------------------
-- Table structure for `os_shopping_cart`
-- ----------------------------
DROP TABLE IF EXISTS `os_shopping_cart`;
CREATE TABLE `os_shopping_cart` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `UserId` int(255) NOT NULL COMMENT '用户Id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  `GoodsId` int(255) NOT NULL COMMENT '商品Id\r\n[外键删除时：CASCADE]\r\n[外键更改时：CASCADE]',
  `Number` int(255) NOT NULL DEFAULT '1' COMMENT '数量默认为1',
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `GoodsId` (`GoodsId`),
  CONSTRAINT `os_shopping_cart_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `os_user` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `os_shopping_cart_ibfk_2` FOREIGN KEY (`GoodsId`) REFERENCES `os_goods` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_shopping_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `os_user`
-- ----------------------------
DROP TABLE IF EXISTS `os_user`;
CREATE TABLE `os_user` (
  `Id` int(255) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `Name` varchar(255) NOT NULL COMMENT '用户真实姓名',
  `Sex` int(1) NOT NULL DEFAULT '0' COMMENT '性别1：男 2：女 0：未知 默认0',
  `SchoolId` int(255) NOT NULL COMMENT '学校id（只允许改一次）\r\n[外键删除时：RESTRICT]\r\n[外键更改时：CASCADE]',
  `ProvinceId` int(255) NOT NULL COMMENT '省份id（只允许改一次）\r\n[外键删除时：RESTRICT]\r\n[外键更改时：CASCADE]',
  `CityId` int(255) NOT NULL COMMENT '城市id（只允许改一次）\r\n[外键删除时：RESTRICT]\r\n[外键更改时：CASCADE]',
  `HeadImgUrl` varchar(255) DEFAULT NULL COMMENT '头像url',
  `Phone` varchar(255) NOT NULL COMMENT '电话，用来当做账户',
  `Password` varchar(255) NOT NULL COMMENT '密码，MD5加密',
  `Good` int(255) NOT NULL DEFAULT '0' COMMENT '好评数量默认0',
  `Middle` int(255) NOT NULL DEFAULT '0' COMMENT '中评数量默认0',
  `Bad` int(255) NOT NULL DEFAULT '0' COMMENT '差评数量默认0',
  `Deadline` datetime NOT NULL DEFAULT '2017-05-18 00:00:00' COMMENT '封号截止日期，默认2017-5-18 00:00:00',
  `Time` datetime NOT NULL DEFAULT '2017-05-29 00:00:00' COMMENT '注册时间',
  PRIMARY KEY (`Id`),
  KEY `SchoolId` (`SchoolId`),
  KEY `ProvinceId` (`ProvinceId`),
  KEY `CityId` (`CityId`),
  CONSTRAINT `os_user_ibfk_1` FOREIGN KEY (`SchoolId`) REFERENCES `os_school` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `os_user_ibfk_2` FOREIGN KEY (`ProvinceId`) REFERENCES `os_province` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `os_user_ibfk_3` FOREIGN KEY (`CityId`) REFERENCES `os_city` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of os_user
-- ----------------------------
INSERT INTO `os_user` VALUES ('1', '冯鈜鉝', '1', '1', '1', '1', '/onlineShop/uploaddate/users/headimg/2017-05-26ezkx97.jpeg', '17862700650', '42d4f6828456a8cad5ca3d3c89ab2730', '1', '0', '0', '2017-05-02 00:00:00', '2017-05-29 00:00:00');
INSERT INTO `os_user` VALUES ('2', '杨竣淇', '0', '1', '1', '1', '/onlineShop/uploaddate/users/headimg/2017-06-01vb158i.jpeg', '17862700651', '42d4f6828456a8cad5ca3d3c89ab2730', '0', '0', '0', '2017-05-15 00:00:00', '2017-05-29 00:00:00');
INSERT INTO `os_user` VALUES ('3', '无名氏', '0', '1', '1', '1', '', '17862700652', '42d4f6828456a8cad5ca3d3c89ab2730', '0', '0', '0', '2017-05-15 00:00:00', '2017-05-29 00:00:00');
INSERT INTO `os_user` VALUES ('4', '王玉', '2', '1', '1', '1', '/onlineShop/uploaddate/users/headimg/2017-06-023i7rvw.jpeg', '17862700001', '25d55ad283aa400af464c76d713c07ad', '0', '0', '0', '2017-05-18 00:00:00', '2017-06-02 00:00:00');
INSERT INTO `os_user` VALUES ('5', '王小玉', '0', '2', '1', '1', '', '17862700002', '25d55ad283aa400af464c76d713c07ad', '0', '0', '0', '2017-05-18 00:00:00', '2017-06-02 00:00:00');
