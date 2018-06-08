/*
Navicat MySQL Data Transfer

Source Server         : 本地机
Source Server Version : 50714
Source Host           : 192.168.16.215:25686
Source Database       : webchat

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-06-08 18:11:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chat
-- ----------------------------
DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `from_uid` int(10) unsigned NOT NULL,
  `to_uid` int(10) unsigned NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `send_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of chat
-- ----------------------------
INSERT INTO `chat` VALUES ('1', '1', '2', '2', '2018-06-07 13:54:37');
INSERT INTO `chat` VALUES ('2', '1', '2', '1', '2018-06-07 14:01:00');
INSERT INTO `chat` VALUES ('3', '1', '2', '3', '2018-06-08 14:01:49');
INSERT INTO `chat` VALUES ('4', '2', '1', '4', '2018-06-08 14:02:03');
INSERT INTO `chat` VALUES ('5', '1', '2', '5', '2018-06-08 14:33:45');
INSERT INTO `chat` VALUES ('6', '1', '2', '5', '2018-06-08 14:33:47');
INSERT INTO `chat` VALUES ('7', '1', '2', '6', '2018-06-08 14:34:32');
INSERT INTO `chat` VALUES ('8', '1', '2', '1', '2018-06-08 14:59:46');
INSERT INTO `chat` VALUES ('9', '2', '1', '2', '2018-06-08 14:59:52');
INSERT INTO `chat` VALUES ('10', '2', '1', '6', '2018-06-08 15:55:55');
INSERT INTO `chat` VALUES ('11', '1', '2', '7', '2018-06-08 15:59:31');
INSERT INTO `chat` VALUES ('12', '1', '2', '8', '2018-06-08 15:59:52');
INSERT INTO `chat` VALUES ('13', '1', '2', '9', '2018-06-08 16:02:58');
INSERT INTO `chat` VALUES ('14', '1', '2', '11', '2018-06-08 16:04:12');
INSERT INTO `chat` VALUES ('15', '1', '2', '12', '2018-06-08 16:05:15');
INSERT INTO `chat` VALUES ('16', '1', '2', '13', '2018-06-08 16:06:02');
INSERT INTO `chat` VALUES ('17', '1', '2', '14', '2018-06-08 16:06:13');
INSERT INTO `chat` VALUES ('18', '1', '2', '1', '2018-06-08 16:08:49');
INSERT INTO `chat` VALUES ('19', '1', '2', '111', '2018-06-08 16:08:59');
INSERT INTO `chat` VALUES ('20', '1', '2', '333', '2018-06-08 16:10:51');
INSERT INTO `chat` VALUES ('21', '2', '1', '222', '2018-06-08 16:15:48');
INSERT INTO `chat` VALUES ('22', '2', '1', '111', '2018-06-08 16:16:10');
INSERT INTO `chat` VALUES ('23', '1', '2', '444', '2018-06-08 16:51:36');
INSERT INTO `chat` VALUES ('24', '1', '2', '4444', '2018-06-08 16:51:52');
INSERT INTO `chat` VALUES ('25', '2', '1', '6666', '2018-06-08 16:52:14');

-- ----------------------------
-- Table structure for fd_tmp
-- ----------------------------
DROP TABLE IF EXISTS `fd_tmp`;
CREATE TABLE `fd_tmp` (
  `fd` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FD值与用户ID绑定';

-- ----------------------------
-- Records of fd_tmp
-- ----------------------------
INSERT INTO `fd_tmp` VALUES ('10', '2');

-- ----------------------------
-- Table structure for friend
-- ----------------------------
DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
  `from_uid` int(10) unsigned DEFAULT NULL,
  `to_uid` int(10) unsigned NOT NULL,
  `nickname` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='好友列表';

-- ----------------------------
-- Records of friend
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `nickname` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '昵称',
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆名称',
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆密码',
  `login_time` datetime NOT NULL COMMENT '最后登陆时间',
  `login_num` int(10) unsigned DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户列表';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'wisonlau', 'wisonlau', '3f3c875d0d1ede92ccb9e7848934cf02', '2018-06-08 11:08:39', '4');
INSERT INTO `users` VALUES ('2', 'wison', 'wison', '3f3c875d0d1ede92ccb9e7848934cf02', '2018-06-08 13:59:42', '2');
INSERT INTO `users` VALUES ('3', 'wisons', 'wisons', '3f3c875d0d1ede92ccb9e7848934cf02', '2018-06-08 17:50:40', '1');
