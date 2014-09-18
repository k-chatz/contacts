/*
Navicat MySQL Data Transfer

Source Server         : MyCnts
Source Server Version : 50505
Source Host           : db31.grserver.gr:3306
Source Database       : kostis_mycnts

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2014-09-14 14:55:33
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for aliases
-- ----------------------------
DROP TABLE IF EXISTS `aliases`;
CREATE TABLE `aliases` (
  `aliasid` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`aliasid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `cityid` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`cityid`),
  UNIQUE KEY `city` (`city`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `companyid` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(100) NOT NULL,
  `comments` text,
  PRIMARY KEY (`companyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for countries
-- ----------------------------
DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `countryid` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(15) NOT NULL,
  `phonecode` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`countryid`),
  UNIQUE KEY `country` (`country`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for emails
-- ----------------------------
DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails` (
  `emailid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `emailtype` varchar(20) NOT NULL,
  PRIMARY KEY (`emailid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for locations
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `locationid` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(30) NOT NULL,
  PRIMARY KEY (`locationid`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
-- Table structure for persons
-- ----------------------------
DROP TABLE IF EXISTS `persons`;
CREATE TABLE `persons` (
  `personid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Πρωτεύων κλειδί',
  `userid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `sex` varchar(6) NOT NULL,
  `birthday` date DEFAULT NULL,
  `acquaintance` date DEFAULT NULL,
  `comments` text,
  `got_childs` bit(1) NOT NULL DEFAULT b'0',
  `motherid` int(11) DEFAULT NULL,
  `fatherid` int(11) DEFAULT NULL,
  `photopath` varchar(255) DEFAULT NULL,
  `got_alias` bit(1) DEFAULT b'0',
  `got_phone` bit(1) DEFAULT b'0',
  `got_email` bit(1) DEFAULT b'0',
  `got_website` bit(1) DEFAULT b'0',
  `got_address` bit(1) DEFAULT b'0',
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`personid`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Πίνακας για καταχώρηση οντότητας ανθρώπων';

-- ----------------------------
-- Table structure for phones
-- ----------------------------
DROP TABLE IF EXISTS `phones`;
CREATE TABLE `phones` (
  `phoneid` int(11) NOT NULL AUTO_INCREMENT,
  `countryid` int(11) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `phonetype` int(1) NOT NULL,
  `operator` varchar(40) DEFAULT NULL,
  `packet` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`phoneid`),
  KEY `PHONE` (`phone`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for regions
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `regionid` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(30) NOT NULL,
  PRIMARY KEY (`regionid`),
  UNIQUE KEY `region` (`region`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for relations_reltype
-- ----------------------------
DROP TABLE IF EXISTS `relations_reltype`;
CREATE TABLE `relations_reltype` (
  `relationid` int(11) NOT NULL,
  `reltypeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Table structure for schools
-- ----------------------------
DROP TABLE IF EXISTS `schools`;
CREATE TABLE `schools` (
  `schoolid` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`schoolid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for streets
-- ----------------------------
DROP TABLE IF EXISTS `streets`;
CREATE TABLE `streets` (
  `streetid` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`streetid`),
  UNIQUE KEY `street` (`street`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for streetsnum
-- ----------------------------
DROP TABLE IF EXISTS `streetsnum`;
CREATE TABLE `streetsnum` (
  `relationid` int(11) NOT NULL,
  `streetnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Είναι χρήσιμο για τη καταγραφή μοναδικού αναγνωριστικού του χρήστη.',
  `username` varchar(100) NOT NULL COMMENT 'Είναι χρήσιμο για τη καταγραφή ονόματος σύνδεσης του χρήστη.',
  `userpass` varchar(32) NOT NULL COMMENT 'Είναι χρήσιμο για τη καταγραφή κωδικού πρόσβασης (MD5) του χρήστη.',
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Είναι χρήσιμο για τη καταγραφή ημερομηνίας και ώρας εγγραφής του χρήστη.',
  `REGISTER_REMOTE_ADDR` varchar(100) NOT NULL,
  `REGISTER_REMOTE_PORT` varchar(10) NOT NULL,
  `REGISTER_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `CURRENT_REMOTE_ADDR` varchar(100) NOT NULL,
  `CURRENT_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `lastactive` varchar(19) DEFAULT NULL COMMENT 'Είναι χρήσιμο για την εύρεση των online χρηστών. (Όταν είναι όλα 0 τότε ο χρήστης είναι εκτώς, αλιώς online).',
  `active` varchar(35) NOT NULL,
  `got_person` bit(1) NOT NULL DEFAULT b'0',
  `got_company` bit(1) NOT NULL DEFAULT b'0',
  `got_school` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for websites
-- ----------------------------
DROP TABLE IF EXISTS `websites`;
CREATE TABLE `websites` (
  `websiteid` int(11) NOT NULL AUTO_INCREMENT,
  `website` varchar(100) NOT NULL,
  `websitetype` varchar(20) NOT NULL,
  PRIMARY KEY (`websiteid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
