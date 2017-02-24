/*
Navicat MySQL Data Transfer

Source Server         : 47.90.32.191
Source Server Version : 50550
Source Host           : 47.90.32.191:3306
Source Database       : db_pacteracms

Target Server Type    : MYSQL
Target Server Version : 50550
File Encoding         : 65001

Date: 2016-09-02 14:39:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pactera_[PACTERA_MODULE]_category
-- ----------------------------
DROP TABLE IF EXISTS `[PACTERA_PREFIX]_[PACTERA_MODULE]_category`;
CREATE TABLE `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父分类ID',
  `group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分组',
  `doc_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类模型',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `url` varchar(127) NOT NULL COMMENT '链接地址',
  `content` text NOT NULL COMMENT '内容',
  `index_template` varchar(32) NOT NULL DEFAULT '' COMMENT '列表封面模版',
  `detail_template` varchar(32) NOT NULL DEFAULT '' COMMENT '详情页模版',
  `post_auth` tinyint(4) NOT NULL DEFAULT '0' COMMENT '投稿权限',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='栏目分类表';

-- ----------------------------
-- Records of pactera_[PACTERA_MODULE]_category
-- ----------------------------
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('1', '0', '1', '3', '产品中心', '', '', '', '', '1', 'fa fa-send-o', '1431926468', '1446449005', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('2', '0', '1', '3', '新闻动态', '', '', '', '', '1', 'fa-search', '1446449071', '1446449394', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('3', '0', '1', '3', '客户服务', '', '', '', '', '1', 'fa-heart', '1446449078', '1446449400', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('4', '0', '1', '3', '案例展示', '', '', '', '', '1', 'fa-th', '1446449673', '1446449673', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('5', '0', '1', '3', '品牌专区', '', '', '', '', '1', 'fa-arrows', '1446449686', '1446449686', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_category` VALUES ('6', '0', '1', '3', '联系我们', '', '', '', '', '1', 'fa-envelope-o', '1446449697', '1446449697', '0', '1');

-- ----------------------------
-- Table structure for pactera_[PACTERA_MODULE]_index
-- ----------------------------
DROP TABLE IF EXISTS `[PACTERA_PREFIX]_[PACTERA_MODULE]_index`;
CREATE TABLE `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文档类型ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布者ID',
  `view` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `good` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赞数',
  `bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '踩数',
  `mark` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='文档类型基础表';

-- ----------------------------
-- Records of pactera_[PACTERA_MODULE]_index
-- ----------------------------
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('1', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('2', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('3', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('4', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('5', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('6', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('7', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_index` VALUES ('8', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');

-- ----------------------------
-- Table structure for pactera_[PACTERA_MODULE]_type
-- ----------------------------
DROP TABLE IF EXISTS `[PACTERA_PREFIX]_[PACTERA_MODULE]_type`;
CREATE TABLE `[PACTERA_PREFIX]_[PACTERA_MODULE]_type` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(16) NOT NULL DEFAULT '' COMMENT '模型名称',
  `title` char(16) NOT NULL DEFAULT '' COMMENT '模型标题',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `main_field` int(11) NOT NULL DEFAULT '0' COMMENT '主要字段',
  `list_field` varchar(127) NOT NULL DEFAULT '' COMMENT '列表显示字段',
  `filter_field` varchar(127) NOT NULL DEFAULT '' COMMENT '前台筛选字段',
  `field_sort` varchar(255) NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '' COMMENT '表单字段分组',
  `system` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '系统类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

-- ----------------------------
-- Records of pactera_[PACTERA_MODULE]_type
-- ----------------------------
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_type` VALUES ('1', 'link', '链接', 'fa fa-link', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_type` VALUES ('2', 'page', '单页', 'fa fa-file-text', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `[PACTERA_PREFIX]_[PACTERA_MODULE]_type` VALUES ('3', 'article', '文章', 'fa fa-file-word-o', '11', '11', '', '{\"1\":[\"1\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\"],\"2\":[\"9\",\"7\"]}', '1:基础\n2:扩展', '0', '1426580628', '1426580628', '0', '1');
