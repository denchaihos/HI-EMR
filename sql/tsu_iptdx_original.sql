/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : hi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-26 11:35:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tsu_iptdx_original`
-- ----------------------------
DROP TABLE IF EXISTS `tsu_iptdx_original`;
CREATE TABLE `tsu_iptdx_original` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `an` int(8) NOT NULL,
  `itemno` int(2) NOT NULL,
  `dct` varchar(5) CHARACTER SET tis620 COLLATE tis620_bin DEFAULT NULL,
  `icd10` varchar(7) CHARACTER SET tis620 COLLATE tis620_bin DEFAULT NULL,
  `icd10name` varchar(90) NOT NULL,
  `spclty` varchar(2) NOT NULL,
  `date_update` datetime NOT NULL,
  `flag_status` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `an` (`an`),
  KEY `itemno` (`itemno`)
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of tsu_iptdx_original
-- ----------------------------
