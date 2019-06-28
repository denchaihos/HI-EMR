/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-23 15:57:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsu_oprt_original`
-- ----------------------------
DROP TABLE IF EXISTS `tsu_oprt_original`;
CREATE TABLE `tsu_oprt_original` (
  `id` int(11) NOT NULL,
  `vn` int(11) NOT NULL,
  `opdttm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `an` int(8) NOT NULL,
  `icd9cm` varchar(7) NOT NULL,
  `icd9name` varchar(90) NOT NULL,
  `dct` varchar(5) CHARACTER SET tis620 COLLATE tis620_bin DEFAULT NULL,
  `orno` int(8) NOT NULL,
  `charge` int(5) NOT NULL,
  `oppnote` longtext NOT NULL,
  `rcptno` int(8) NOT NULL,
  `codeicd9id` varchar(7) NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `flag_status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vn` (`vn`),
  KEY `dt` (`opdttm`) USING BTREE,
  KEY `an` (`an`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of tsu_oprt_original
-- ----------------------------
