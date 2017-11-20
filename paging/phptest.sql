/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : phptest

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-11-21 03:25:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `psw` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'cy', 'cy', '2017-07-20 23:03:42');
INSERT INTO `admin` VALUES ('2', 'chenyi', 'chenyi', '2017-06-20 23:29:37');
INSERT INTO `admin` VALUES ('3', null, null, null);
INSERT INTO `admin` VALUES ('4', null, null, null);
INSERT INTO `admin` VALUES ('5', null, null, null);
INSERT INTO `admin` VALUES ('6', null, null, null);
INSERT INTO `admin` VALUES ('7', null, null, null);
INSERT INTO `admin` VALUES ('8', null, null, null);
INSERT INTO `admin` VALUES ('9', null, null, null);
INSERT INTO `admin` VALUES ('10', null, null, null);
INSERT INTO `admin` VALUES ('11', null, null, null);
INSERT INTO `admin` VALUES ('12', null, null, null);
INSERT INTO `admin` VALUES ('13', null, null, null);
INSERT INTO `admin` VALUES ('14', null, null, null);
INSERT INTO `admin` VALUES ('15', null, null, null);
INSERT INTO `admin` VALUES ('16', null, null, null);
INSERT INTO `admin` VALUES ('17', null, null, null);
INSERT INTO `admin` VALUES ('18', null, null, null);
INSERT INTO `admin` VALUES ('19', null, null, null);
INSERT INTO `admin` VALUES ('20', null, null, null);
INSERT INTO `admin` VALUES ('21', null, null, null);
INSERT INTO `admin` VALUES ('22', null, null, null);
INSERT INTO `admin` VALUES ('23', null, null, null);
INSERT INTO `admin` VALUES ('24', null, null, null);
INSERT INTO `admin` VALUES ('25', null, null, null);
INSERT INTO `admin` VALUES ('26', null, null, null);
INSERT INTO `admin` VALUES ('27', null, null, null);
INSERT INTO `admin` VALUES ('28', null, null, null);
INSERT INTO `admin` VALUES ('29', null, null, null);
INSERT INTO `admin` VALUES ('30', null, null, null);
