/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-26 11:29:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsu_dtdx_original`
-- ----------------------------
DROP TABLE IF EXISTS `tsu_dtdx_original`;
CREATE TABLE `tsu_dtdx_original` (
  `id` int(11) NOT NULL,
  `dn` int(11) NOT NULL,
  `dtxtime` int(4) NOT NULL,
  `area` varchar(3) NOT NULL,
  `icdda` varchar(6) NOT NULL,
  `dttx` varchar(7) NOT NULL,
  `charge` int(5) NOT NULL,
  `rcptno` int(8) NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `flag_status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dn` (`dn`),
  KEY `icdda` (`icdda`),
  KEY `dttx` (`dttx`)
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of tsu_dtdx_original
-- ----------------------------
