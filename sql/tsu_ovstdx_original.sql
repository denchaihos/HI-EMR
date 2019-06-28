/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-26 11:32:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsu_ovstdx_original`
-- ----------------------------
DROP TABLE IF EXISTS `tsu_ovstdx_original`;
CREATE TABLE `tsu_ovstdx_original` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vn` int(11) NOT NULL,
  `icd10` varchar(7) CHARACTER SET tis620 COLLATE tis620_bin DEFAULT NULL,
  `icd10name` varchar(90) NOT NULL,
  `cnt` tinyint(1) NOT NULL DEFAULT '0',
  `date_update` datetime NOT NULL,
  `flag_status` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vn` (`vn`)
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of tsu_ovstdx_original
-- ----------------------------
