/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50620
Source Host           : 127.0.0.1:8631
Source Database       : contacts

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-08-25 00:08:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for addresses
-- ----------------------------
DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `addressid` int(11) NOT NULL AUTO_INCREMENT,
  `countryid` int(11) DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL,
  `regionid` int(11) DEFAULT NULL,
  `locationid` int(11) DEFAULT NULL,
  `comments` text,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`addressid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of addresses
-- ----------------------------

-- ----------------------------
-- Table structure for aliases
-- ----------------------------
DROP TABLE IF EXISTS `aliases`;
CREATE TABLE `aliases` (
  `aliasid` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`aliasid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aliases
-- ----------------------------

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `cityid` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`cityid`),
  UNIQUE KEY `city` (`city`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cities
-- ----------------------------

-- ----------------------------
-- Table structure for coordinates
-- ----------------------------
DROP TABLE IF EXISTS `coordinates`;
CREATE TABLE `coordinates` (
  `coordinatesid` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  PRIMARY KEY (`coordinatesid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coordinates
-- ----------------------------

-- ----------------------------
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `countryid` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(15) NOT NULL,
  `phonecode` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`countryid`),
  UNIQUE KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of countries
-- ----------------------------

-- ----------------------------
-- Table structure for locations
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `locationid` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(30) NOT NULL,
  PRIMARY KEY (`locationid`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of locations
-- ----------------------------

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `userid` int(11) NOT NULL,
  `REMOTE_ADDR` varchar(100) DEFAULT NULL,
  `REMOTE_PORT` varchar(10) DEFAULT NULL,
  `HTTP_USER_AGENT` varchar(255) DEFAULT NULL,
  `REQUEST_URI` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of logs
-- ----------------------------




-- ----------------------------
-- Table structure for persons
-- ----------------------------
DROP TABLE IF EXISTS `persons`;
CREATE TABLE `persons` (
  `personid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `sex` varchar(6) NOT NULL,
  `birthday` date DEFAULT NULL,
  `comments` text,
  `number_of_childs` int(11) NOT NULL DEFAULT '0',
  `motherid` int(11) DEFAULT NULL,
  `fatherid` int(11) DEFAULT NULL,
  `photopath` varchar(255) DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `got_alias` bit(1) NOT NULL,
  PRIMARY KEY (`personid`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of persons
-- ----------------------------
INSERT INTO `persons` VALUES ('1', '1', 'Name1', 'Surname', 'male', '1988-07-30', 'Comments place!', '1', '8', '9', '', '2014-09-11 22:47:52', '');
INSERT INTO `persons` VALUES ('2', '1', 'Name2', 'Surname', 'male', '1986-04-13', 'Comments place!', '0', '8', '9', '', '2014-09-11 22:52:16', '\0');
INSERT INTO `persons` VALUES ('3', '1', 'Name3', 'Surname', 'female', null, 'Comments place!', '0', '8', '9', '', '2014-09-11 22:52:17', '\0');
INSERT INTO `persons` VALUES ('4', '1', 'Name4', 'Surname', 'female', null, 'Comments place!', '0', '11', '10', '', '2014-09-11 22:52:17', '\0');
INSERT INTO `persons` VALUES ('5', '1', 'Name5', 'Surname', 'male', null, 'Comments place!', '0', '11', '10', '', '2014-09-11 22:52:18', '\0');
INSERT INTO `persons` VALUES ('6', '1', 'Name6', 'Surname', 'male', null, 'Comments place!', '0', '12', '13', '', '2014-09-11 22:52:19', '\0');
INSERT INTO `persons` VALUES ('7', '1', 'Name7', 'Surname', 'male', null, 'Comments place!', '0', '12', '13', '', '2014-09-11 22:52:19', '\0');
INSERT INTO `persons` VALUES ('8', '1', 'Name8', 'Surname', 'female', null, 'Comments place!', '3', '14', '15', '', '2014-09-11 22:52:20', '\0');
INSERT INTO `persons` VALUES ('9', '1', 'Name9', 'Surname', 'male', null, 'Comments place!', '3', '16', '17', '', '2014-09-11 22:52:20', '\0');
INSERT INTO `persons` VALUES ('10', '1', 'Name10', 'Surname', 'male', null, 'Comments place!', '2', '16', '17', '', '2014-09-11 22:52:21', '\0');
INSERT INTO `persons` VALUES ('11', '1', 'Name11', 'Surname', 'female', null, 'Comments place!', '2', '0', '0', '', '2014-09-11 22:52:22', '\0');
INSERT INTO `persons` VALUES ('12', '1', 'Name12', 'Surname', 'female', '1945-11-06', 'Comments place!', '2', '16', '17', '', '2014-09-11 22:52:23', '\0');
INSERT INTO `persons` VALUES ('13', '1', 'Name13', 'Surname', 'male', null, 'Comments place!', '2', '0', '0', '', '2014-09-11 22:52:23', '\0');
INSERT INTO `persons` VALUES ('14', '1', 'Name14', 'Surname', 'female', null, 'Comments place!', '1', '23', '22', '', '2014-09-11 22:52:24', '\0');
INSERT INTO `persons` VALUES ('15', '1', 'Name15', 'Surname', 'male', null, 'Comments place!', '1', '0', '0', '', '2014-09-11 22:52:25', '\0');
INSERT INTO `persons` VALUES ('16', '1', 'Name16', 'Surname', 'female', null, 'Comments place!', '4', '0', '0', '', '2014-09-11 22:52:26', '\0');
INSERT INTO `persons` VALUES ('17', '1', 'Name17', 'Surname', 'male', '0000-00-00', 'Comments place!', '4', '0', '0', '', '2014-09-11 22:52:27', '\0');
INSERT INTO `persons` VALUES ('20', '1', 'Name18', 'Surname', 'female', '2012-12-12', 'Comments place!', '0', '16', '17', '', '2014-09-14 19:53:28', '\0');
INSERT INTO `persons` VALUES ('26', '1', 'Name19', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:46:21', '\0');
INSERT INTO `persons` VALUES ('27', '1', 'Name20', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:24:07', '\0');
INSERT INTO `persons` VALUES ('30', '1', 'Name21', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:28:42', '\0');
INSERT INTO `persons` VALUES ('31', '1', 'Name22', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:30:30', '\0');
INSERT INTO `persons` VALUES ('32', '1', 'Name23', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:34:03', '\0');
INSERT INTO `persons` VALUES ('33', '1', 'Name24', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:35:05', '\0');
INSERT INTO `persons` VALUES ('34', '1', 'Name25', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:36:22', '\0');
INSERT INTO `persons` VALUES ('36', '1', 'Name26', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:39:31', '\0');
INSERT INTO `persons` VALUES ('37', '1', 'Name27', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:40:51', '\0');
INSERT INTO `persons` VALUES ('39', '1', 'Name28', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:44:18', '\0');
INSERT INTO `persons` VALUES ('40', '1', 'Name29', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:48:50', '\0');
INSERT INTO `persons` VALUES ('41', '1', 'Name30', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:49:56', '\0');
INSERT INTO `persons` VALUES ('42', '1', 'Name31', 'Surname', 'female', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:52:41', '\0');
INSERT INTO `persons` VALUES ('43', '1', 'Name32', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-25 00:00:00', '\0');
INSERT INTO `persons` VALUES ('44', '1', 'Name33', 'Surname', 'female', '1984-09-25', 'Comments place!', '0', null, null, '', '2013-01-25 20:39:58', '\0');
INSERT INTO `persons` VALUES ('45', '1', 'Name34', 'Surname', 'female', null, 'Comments place!', '0', null, null, '', '2013-01-25 20:41:47', '\0');
INSERT INTO `persons` VALUES ('46', '1', 'Name35', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-25 20:48:55', '\0');
INSERT INTO `persons` VALUES ('48', '1', 'Name36', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:15:35', '\0');
INSERT INTO `persons` VALUES ('49', '1', 'Name37', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:16:12', '\0');
INSERT INTO `persons` VALUES ('50', '1', 'Name38', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:17:29', '\0');
INSERT INTO `persons` VALUES ('51', '1', 'Name39', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:18:25', '\0');
INSERT INTO `persons` VALUES ('52', '1', 'Name40', 'Surname', 'male', null, 'Comments place!', '0', null, null, '', '2013-01-29 00:20:08', '\0');

-- ----------------------------
-- Table structure for phones
-- ----------------------------
DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `phoneid` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY (`phoneid`),
  KEY `PHONE` (`phone`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phones
-- ----------------------------

-- ----------------------------
-- Table structure for regions
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `regionid` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(30) NOT NULL,
  PRIMARY KEY (`regionid`),
  UNIQUE KEY `region` (`region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of regions
-- ----------------------------

-- ----------------------------
-- Table structure for relations
-- ----------------------------
DROP TABLE IF EXISTS `relations`;
CREATE TABLE `relations` (
  `relationid` int(11) NOT NULL AUTO_INCREMENT,
  `table1` varchar(10) NOT NULL,
  `table2` varchar(10) NOT NULL,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  PRIMARY KEY (`relationid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of relations
-- ----------------------------

-- ----------------------------
-- Table structure for relations_reltype
-- ----------------------------
DROP TABLE IF EXISTS `relations_reltype`;
CREATE TABLE `relations_reltype` (
  `relationid` int(11) NOT NULL,
  `reltypeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of relations_reltype
-- ----------------------------

-- ----------------------------
-- Table structure for reltypes
-- ----------------------------
DROP TABLE IF EXISTS `reltypes`;
CREATE TABLE `reltypes` (
  `reltypeid` int(11) NOT NULL AUTO_INCREMENT,
  `reltype` varchar(30) NOT NULL,
  PRIMARY KEY (`reltypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of reltypes
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `userid` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`,`option_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'items_per_page', '5');
INSERT INTO `settings` VALUES ('1', 'timeout', '2');

-- ----------------------------
-- Table structure for streets
-- ----------------------------
DROP TABLE IF EXISTS `streets`;
CREATE TABLE `streets` (
  `streetid` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`streetid`),
  UNIQUE KEY `street` (`street`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of streets
-- ----------------------------

-- ----------------------------
-- Table structure for streetsnum
-- ----------------------------
DROP TABLE IF EXISTS `streetsnum`;
CREATE TABLE `streetsnum` (
  `relationid` int(11) NOT NULL,
  `streetnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of streetsnum
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `userpass` varchar(32) NOT NULL,
  `confid` varchar(35) DEFAULT NULL,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `REGISTER_REMOTE_ADDR` varchar(100) NOT NULL,
  `REGISTER_REMOTE_PORT` varchar(10) NOT NULL,
  `REGISTER_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `CURRENT_REMOTE_ADDR` varchar(100) NOT NULL,
  `CURRENT_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `lastactive` varchar(35) DEFAULT NULL,
  `active` varchar(35) NOT NULL,
  `got_person` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'demo@demo.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '173c7d875bb937b92f1dedd2a07afdb9', '2015-08-15 14:24:30', '88.197.66.116', '34154', 'Mozilla/5.0 (Linux; Android 4.1.2; GT-I8260 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36', '88.197.66.116', 'Mozilla/5.0 (Linux; Android 4.1.2; GT-I8260 Build/JZO54K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36', 'Logout', 'Activated', '\0');
