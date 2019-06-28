/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-26 11:35:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsu_ioprt_original`
-- ----------------------------
DROP TABLE IF EXISTS `tsu_ioprt_original`;
CREATE TABLE `tsu_ioprt_original` (
  `id` int(11) NOT NULL,
  `an` int(8) NOT NULL,
  `hn` int(8) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` int(4) NOT NULL,
  `dct` varchar(5) CHARACTER SET tis620 COLLATE tis620_bin DEFAULT NULL,
  `orno` int(8) NOT NULL,
  `icd9cm` varchar(7) NOT NULL,
  `icd9name` varchar(90) NOT NULL,
  `optype` varchar(1) NOT NULL,
  `charge` int(5) NOT NULL,
  `rcptno` int(8) NOT NULL,
  `codeicd9id` varchar(7) NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `flag_status` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `an` (`an`),
  KEY `date` (`date`) USING BTREE,
  KEY `time` (`time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of tsu_ioprt_original
-- ----------------------------
