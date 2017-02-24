/*
Navicat MySQL Data Transfer

Source Server         : pacteracms
Source Server Version : 50550
Source Host           : 47.90.32.191:3306
Source Database       : db_pacteracms

Target Server Type    : MYSQL
Target Server Version : 50550
File Encoding         : 65001

Date: 2016-09-19 14:10:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pactera_cms_category
-- ----------------------------
DROP TABLE IF EXISTS `pactera_cms_category`;
CREATE TABLE `pactera_cms_category` (
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
-- Records of pactera_cms_category
-- ----------------------------
INSERT INTO `pactera_cms_category` VALUES ('1', '0', '1', '3', '产品中心', '', '', '', '', '1', 'fa fa-send-o', '1431926468', '1446449005', '0', '1');
INSERT INTO `pactera_cms_category` VALUES ('2', '0', '1', '3', '新闻动态', '', '', '', '', '1', 'fa-search', '1446449071', '1446449394', '0', '1');
INSERT INTO `pactera_cms_category` VALUES ('3', '0', '1', '3', '客户服务', '', '', '', '', '1', 'fa-heart', '1446449078', '1446449400', '0', '1');
INSERT INTO `pactera_cms_category` VALUES ('4', '0', '1', '3', '案例展示', '', '', '', '', '1', 'fa-th', '1446449673', '1446449673', '0', '1');
INSERT INTO `pactera_cms_category` VALUES ('5', '0', '1', '3', '品牌专区', '', '', '', '', '1', 'fa-arrows', '1446449686', '1446449686', '0', '1');
INSERT INTO `pactera_cms_category` VALUES ('6', '0', '1', '3', '联系我们', '', '', '', '', '1', 'fa-envelope-o', '1446449697', '1446449697', '0', '1');

-- ----------------------------
-- Table structure for pactera_cms_index
-- ----------------------------
DROP TABLE IF EXISTS `pactera_cms_index`;
CREATE TABLE `pactera_cms_index` (
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
-- Records of pactera_cms_index
-- ----------------------------
INSERT INTO `pactera_cms_index` VALUES ('1', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('2', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('3', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('4', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('5', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('6', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('7', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');
INSERT INTO `pactera_cms_index` VALUES ('8', '1', '3', '1', '0', '0', '0', '0', '0', '1449839213', '1449839263', '0', '1');

-- ----------------------------
-- Table structure for pactera_cms_type
-- ----------------------------
DROP TABLE IF EXISTS `pactera_cms_type`;
CREATE TABLE `pactera_cms_type` (
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
-- Records of pactera_cms_type
-- ----------------------------
INSERT INTO `pactera_cms_type` VALUES ('1', 'link', '链接', 'fa fa-link', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `pactera_cms_type` VALUES ('2', 'page', '单页', 'fa fa-file-text', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `pactera_cms_type` VALUES ('3', 'article', '文章', 'fa fa-file-word-o', '11', '11', '', '{\"1\":[\"1\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\"],\"2\":[\"9\",\"7\"]}', '1:基础\n2:扩展', '0', '1426580628', '1426580628', '0', '1');

-- ----------------------------
-- Table structure for pactera_manage_access
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_access`;
CREATE TABLE `pactera_manage_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `manage_user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `manage_group_id` int(10) unsigned NOT NULL COMMENT '分组ID',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of pactera_manage_access
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_group
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_group`;
CREATE TABLE `pactera_manage_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `group_name` varchar(32) NOT NULL COMMENT '分组名称',
  `group_auth` text NOT NULL COMMENT '分组权限菜单，Key为模块 Value为菜单权限ID',
  `description` text NOT NULL COMMENT '分组描述',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '组状态：0禁用 1启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分组表';

-- ----------------------------
-- Records of pactera_manage_group
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_menu
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_menu`;
CREATE TABLE `pactera_manage_menu` (
  `menu_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(32) DEFAULT NULL,
  `menu_action` varchar(64) DEFAULT NULL,
  `parent_id` smallint(5) DEFAULT '0',
  `orderby` tinyint(3) unsigned DEFAULT '100' COMMENT '1排序第一',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '0代表不直接显示',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=549 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pactera_manage_menu
-- ----------------------------
INSERT INTO `pactera_manage_menu` VALUES ('1', '管理中心', null, '0', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('2', '设置', null, '0', '2', '1');
INSERT INTO `pactera_manage_menu` VALUES ('8', '工具', null, '0', '11', '1');
INSERT INTO `pactera_manage_menu` VALUES ('9', '管理员管理', null, '1', '2', '1');
INSERT INTO `pactera_manage_menu` VALUES ('11', '后台菜单管理', null, '1', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('12', '菜单列表', 'menu/index', '11', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('13', '新增菜单', 'menu/create', '11', '5', '0');
INSERT INTO `pactera_manage_menu` VALUES ('14', '编辑菜单', 'menu/edit', '11', '2', '0');
INSERT INTO `pactera_manage_menu` VALUES ('15', '删除菜单', 'menu/delete', '11', '3', '0');
INSERT INTO `pactera_manage_menu` VALUES ('16', '更新菜单', 'menu/update', '11', '4', '0');
INSERT INTO `pactera_manage_menu` VALUES ('17', '批量菜单', 'menu/action', '11', '6', '0');
INSERT INTO `pactera_manage_menu` VALUES ('18', '角色管理', 'Role/index', '9', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('25', '新增角色', 'Role/create', '9', '2', '0');
INSERT INTO `pactera_manage_menu` VALUES ('26', '编辑角色', 'Role/edit', '9', '3', '0');
INSERT INTO `pactera_manage_menu` VALUES ('27', '删除角色', 'Role/delete', '9', '4', '0');
INSERT INTO `pactera_manage_menu` VALUES ('28', '角色授权', 'Role/auth', '9', '5', '0');
INSERT INTO `pactera_manage_menu` VALUES ('29', '管理员管理', 'User/index', '9', '11', '1');
INSERT INTO `pactera_manage_menu` VALUES ('30', '新增管理员', 'User/create', '9', '12', '0');
INSERT INTO `pactera_manage_menu` VALUES ('31', '编辑管理员', 'User/edit', '9', '13', '0');
INSERT INTO `pactera_manage_menu` VALUES ('32', '删除管理员', 'User/delete', '9', '14', '0');
INSERT INTO `pactera_manage_menu` VALUES ('34', '会员管理', 'user/index', '33', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('35', '新增会员', 'user/create', '33', '5', '0');
INSERT INTO `pactera_manage_menu` VALUES ('36', '编辑会员', 'user/edit', '33', '6', '0');
INSERT INTO `pactera_manage_menu` VALUES ('37', '删除会员', 'user/delete', '33', '4', '0');
INSERT INTO `pactera_manage_menu` VALUES ('39', '缓存管理', null, '8', '2', '1');
INSERT INTO `pactera_manage_menu` VALUES ('40', '清空缓存', 'clean/cache', '39', '100', '1');
INSERT INTO `pactera_manage_menu` VALUES ('41', '审核会员', 'user/audit', '33', '3', '0');
INSERT INTO `pactera_manage_menu` VALUES ('49', '基本设置', null, '2', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('278', '积分兑换', 'integralexchange/index', '234', '2', '0');
INSERT INTO `pactera_manage_menu` VALUES ('80', '站点设置', 'setting/site', '49', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('81', '附件设置', 'setting/attachs', '49', '2', '1');
INSERT INTO `pactera_manage_menu` VALUES ('90', '异步选择会员', 'user/select', '33', '2', '0');
INSERT INTO `pactera_manage_menu` VALUES ('115', '敏感词过滤', 'sensitive/index', '49', '3', '1');
INSERT INTO `pactera_manage_menu` VALUES ('116', '新增敏感词', 'sensitive/create', '49', '4', '0');
INSERT INTO `pactera_manage_menu` VALUES ('117', '编辑敏感词', 'sensitive/edit', '49', '5', '0');
INSERT INTO `pactera_manage_menu` VALUES ('118', '删除敏感词', 'sensitive/delete', '49', '6', '0');
INSERT INTO `pactera_manage_menu` VALUES ('124', 'UC整合', 'setting/ucenter', '33', '30', '1');
INSERT INTO `pactera_manage_menu` VALUES ('134', '优惠券', null, '5', '5', '0');
INSERT INTO `pactera_manage_menu` VALUES ('156', '短信设置', 'setting/sms', '49', '11', '1');
INSERT INTO `pactera_manage_menu` VALUES ('157', '邮件设置', 'setting/mail', '49', '12', '1');
INSERT INTO `pactera_manage_menu` VALUES ('158', '模版管理', null, '2', '4', '1');
INSERT INTO `pactera_manage_menu` VALUES ('547', '测试添加', 'User/test', '9', '12', '1');
INSERT INTO `pactera_manage_menu` VALUES ('259', '积分设置', 'setting/integral', '49', '13', '0');
INSERT INTO `pactera_manage_menu` VALUES ('212', '增加积分', 'user/integral', '33', '8', '0');
INSERT INTO `pactera_manage_menu` VALUES ('546', '钩子列表', 'hooks/index', '545', '100', '1');
INSERT INTO `pactera_manage_menu` VALUES ('545', '钩子管理', null, '544', '1', '1');
INSERT INTO `pactera_manage_menu` VALUES ('544', '扩展管理', null, '0', '100', '1');
INSERT INTO `pactera_manage_menu` VALUES ('233', '会员卡列表', 'usercard/index', '232', '1', '0');
INSERT INTO `pactera_manage_menu` VALUES ('240', '会员等级', 'userrank/index', '33', '21', '1');
INSERT INTO `pactera_manage_menu` VALUES ('241', '新增等级', 'userrank/create', '33', '22', '0');
INSERT INTO `pactera_manage_menu` VALUES ('242', '编辑等级', 'userrank/edit', '33', '23', '0');
INSERT INTO `pactera_manage_menu` VALUES ('243', '删除等级', 'userrank/delete', '33', '24', '0');
INSERT INTO `pactera_manage_menu` VALUES ('262', '新增地址', 'useraddr/create', '260', '2', '0');
INSERT INTO `pactera_manage_menu` VALUES ('261', '收货地址', 'useraddr/index', '260', '1', '0');
INSERT INTO `pactera_manage_menu` VALUES ('263', '编辑地址', 'useraddr/edit', '260', '3', '0');
INSERT INTO `pactera_manage_menu` VALUES ('264', '删除地址', 'useraddr/delete', '260', '4', '0');
INSERT INTO `pactera_manage_menu` VALUES ('274', '微信消息列表', 'weixinmsg/index', '216', '11', '1');
INSERT INTO `pactera_manage_menu` VALUES ('275', '第三方登录', 'setting/connect', '33', '10', '1');
INSERT INTO `pactera_manage_menu` VALUES ('290', '威望设置', 'setting/prestige', '49', '14', '0');
INSERT INTO `pactera_manage_menu` VALUES ('292', '余额日志', 'usermoneylogs/index', '291', '43', '1');
INSERT INTO `pactera_manage_menu` VALUES ('326', '增加余额', 'user/money', '33', '100', '0');
INSERT INTO `pactera_manage_menu` VALUES ('336', '自定义菜单', 'setting/weixinmenu', '216', '6', '1');
INSERT INTO `pactera_manage_menu` VALUES ('337', '删除微信消息', 'weixinmsg/delete', '216', '12', '0');
INSERT INTO `pactera_manage_menu` VALUES ('391', '群发消息', 'weixinkeyword/mass', '216', '7', '1');

-- ----------------------------
-- Table structure for pactera_manage_metadata
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_metadata`;
CREATE TABLE `pactera_manage_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `metadata_sn` varchar(32) NOT NULL COMMENT '数据ID',
  `zh_cn_name` varchar(32) NOT NULL COMMENT '中文名称',
  `en_us_name` varchar(32) NOT NULL COMMENT '英文名称',
  `alias` varchar(32) NOT NULL COMMENT '别名（短名）',
  `data_type` int(10) unsigned NOT NULL COMMENT '数据类型',
  `widget_type` int(10) unsigned NOT NULL COMMENT '控件类型',
  `data_length` int(10) unsigned NOT NULL COMMENT '数据长度',
  `decimal_point` smallint(5) unsigned NOT NULL COMMENT '小数点保留位数',
  `default_value` varchar(64) NOT NULL COMMENT '默认值',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='元数据管理表';

-- ----------------------------
-- Records of pactera_manage_metadata
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_model
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_model`;
CREATE TABLE `pactera_manage_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `model_name` varchar(32) NOT NULL COMMENT '模型名称(数据库表名)',
  `field_sn` varchar(32) NOT NULL COMMENT '字段ID',
  `field_type` tinyint(3) unsigned NOT NULL COMMENT '自动类型',
  `field_title` varchar(32) NOT NULL COMMENT '显示名称',
  `field_name` varchar(32) NOT NULL COMMENT '英文名称',
  `metadata_id` int(10) unsigned NOT NULL COMMENT '元数据ID',
  `is_show` tinyint(3) unsigned NOT NULL COMMENT '是否显示',
  `is_empty` tinyint(3) unsigned NOT NULL COMMENT '是否为空',
  `is_require` tinyint(3) unsigned NOT NULL COMMENT '是否必填',
  `is_select` tinyint(3) unsigned NOT NULL COMMENT '是否为列表页',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `status` tinyint(4) NOT NULL COMMENT '状态：-1删除 0 禁用 1 启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型管理';

-- ----------------------------
-- Records of pactera_manage_model
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_module
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_module`;
CREATE TABLE `pactera_manage_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `module_name` varchar(32) NOT NULL COMMENT '模块名',
  `module_title` varchar(32) NOT NULL COMMENT '模块标题',
  `description` varchar(255) NOT NULL COMMENT '模块描述',
  `developer` varchar(255) NOT NULL COMMENT '开发团队',
  `version` varchar(32) NOT NULL COMMENT '模块当前版本',
  `user_nav` text NOT NULL COMMENT '前台导航',
  `module_config` text NOT NULL COMMENT '模块配置',
  `module_menu` text NOT NULL COMMENT '菜单列表',
  `is_system` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统模块：1系统 0非系统模块',
  `sort` int(10) unsigned NOT NULL COMMENT '排序',
  `status` tinyint(3) NOT NULL COMMENT '模块状态：-1未安装 0禁用 1启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`),
  KEY `module_name` (`module_name`),
  KEY `is_system` (`is_system`),
  KEY `status` (`status`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='模块表';

-- ----------------------------
-- Records of pactera_manage_module
-- ----------------------------
INSERT INTO `pactera_manage_module` VALUES ('16', 'Cms', '内容', '这是一个非常好用的内容管理系统', '', '1.0.0', '{\"title\":{\"center\":\"\\u4e2a\\u4eba\\u4e2d\\u5fc3\"},\"center\":[{\"title\":\"\\u4fee\\u6539\\u5bc6\\u7801\",\"url\":\"Cms\\/User\\/changePwd\"},{\"title\":\"\\u4e2a\\u4eba\\u4fe1\\u606f\",\"url\":\"Cms\\/User\\/getUserInfo\"}]}', '{\"register\":{\"title\":\"\\u6ce8\\u518c\\u5f00\\u5173\",\"options\":{\"1\":\"\\u5f00\\u542f\",\"0\":\"\\u5173\\u95ed\"}}}', '{\"1\":{\"id\":1,\"pid\":\"0\",\"title\":\"CMS\"},\"2\":{\"id\":2,\"pid\":\"1\",\"title\":\"\\u7528\\u6237\\u7ba1\\u7406\",\"url\":\"Cms\\/User\\/manage\"},\"3\":{\"id\":3,\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u8bbe\\u7f6e\",\"url\":\"Cms\\/User\\/settings\"},\"4\":{\"id\":4,\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u7edf\\u8ba1\",\"url\":\"Cms\\/User\\/count\"},\"5\":{\"id\":5,\"pid\":\"2\",\"title\":\"\\u7528\\u6237\\u5217\\u8868\",\"url\":\"Cms\\/User\\/list\"},\"6\":{\"id\":6,\"pid\":\"5\",\"title\":\"\\u65b0\\u589e\",\"url\":\"Cms\\/User\\/add\"}}', '0', '0', '1', '1472804300', '0');

-- ----------------------------
-- Table structure for pactera_manage_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_operation_log`;
CREATE TABLE `pactera_manage_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `log_type` smallint(5) unsigned NOT NULL COMMENT '日志类型',
  `manage_user_id` int(10) unsigned NOT NULL COMMENT '操作用户',
  `operation` varchar(255) NOT NULL COMMENT '操作',
  `operation_description` varchar(255) NOT NULL COMMENT '操作描述',
  `operation_data` text NOT NULL COMMENT '操作数据',
  `operation_time` int(10) unsigned NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台操作日志表';

-- ----------------------------
-- Records of pactera_manage_operation_log
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_role
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_role`;
CREATE TABLE `pactera_manage_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pactera_manage_role
-- ----------------------------
INSERT INTO `pactera_manage_role` VALUES ('1', '超级管理员');
INSERT INTO `pactera_manage_role` VALUES ('2', '测试管理');
INSERT INTO `pactera_manage_role` VALUES ('10', '测试角色');
INSERT INTO `pactera_manage_role` VALUES ('11', '测试员');

-- ----------------------------
-- Table structure for pactera_manage_role_maps
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_role_maps`;
CREATE TABLE `pactera_manage_role_maps` (
  `role_id` smallint(5) DEFAULT NULL,
  `menu_id` smallint(5) DEFAULT NULL,
  UNIQUE KEY `role_id` (`role_id`,`menu_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pactera_manage_role_maps
-- ----------------------------
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '12');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '18');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '29');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '40');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '80');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '81');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '115');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '156');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '157');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '546');
INSERT INTO `pactera_manage_role_maps` VALUES ('2', '547');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '12');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '13');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '14');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '15');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '16');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '17');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '18');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '25');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '26');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '27');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '28');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '29');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '30');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '31');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '32');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '40');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '80');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '81');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '115');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '116');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '117');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '118');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '156');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '157');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '259');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '290');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '546');
INSERT INTO `pactera_manage_role_maps` VALUES ('3', '547');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '34');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '36');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '40');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '503');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '504');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '505');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '506');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '520');
INSERT INTO `pactera_manage_role_maps` VALUES ('5', '521');
INSERT INTO `pactera_manage_role_maps` VALUES ('6', '12');
INSERT INTO `pactera_manage_role_maps` VALUES ('6', '40');
INSERT INTO `pactera_manage_role_maps` VALUES ('9', '80');
INSERT INTO `pactera_manage_role_maps` VALUES ('9', '81');
INSERT INTO `pactera_manage_role_maps` VALUES ('9', '115');
INSERT INTO `pactera_manage_role_maps` VALUES ('9', '156');
INSERT INTO `pactera_manage_role_maps` VALUES ('9', '157');

-- ----------------------------
-- Table structure for pactera_manage_standard
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_standard`;
CREATE TABLE `pactera_manage_standard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `standard_sn` varchar(32) NOT NULL COMMENT '标准化ID',
  `standard_title` varchar(32) NOT NULL COMMENT '标准化名称',
  `standard_name` varchar(32) NOT NULL COMMENT '标准化英文名称',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `standard_name` (`standard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标准化管理表';

-- ----------------------------
-- Records of pactera_manage_standard
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_manage_user
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_user`;
CREATE TABLE `pactera_manage_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(11) NOT NULL COMMENT '登录帐号，和mobile相同',
  `username` varchar(32) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT '0',
  `password` char(32) DEFAULT NULL,
  `salt` char(5) NOT NULL DEFAULT '',
  `avatar` varchar(300) DEFAULT '' COMMENT '头像',
  `role_id` smallint(5) DEFAULT '0',
  `create_ip` varchar(15) DEFAULT '0',
  `last_time` int(11) DEFAULT '0',
  `last_login_ip` varchar(15) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pactera_manage_user
-- ----------------------------
INSERT INTO `pactera_manage_user` VALUES ('1', 'admin', 'admin', '15000000000', 'e10adc3949ba59abbe56e057f20f883e', '', '', '1', '122.188.221.184', '1474256889', '0.0.0.0', '0', '0', '0');
INSERT INTO `pactera_manage_user` VALUES ('37', 'sunny', 'sunny', '15678901234', 'a906449d5769fa7361d7ecc6aa3f6d28', '', '', '6', '127.0.0.1', '0', '0', '0', '0', '0');
INSERT INTO `pactera_manage_user` VALUES ('38', 'mma', 'mma', '15678901234', 'a906449d5769fa7361d7ecc6aa3f6d28', '', '', '6', '127.0.0.1', '0', '0', '0', '0', '0');
INSERT INTO `pactera_manage_user` VALUES ('39', 'mmma', null, '18710839146', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2', '127.0.0.1', '0', '0', '1', '1472025448', '0');
INSERT INTO `pactera_manage_user` VALUES ('40', 'mmma1', null, '18710839141', '3d2172418ce305c7d16d4b05597c6a59', '', '', '1', '127.0.0.1', '0', '0', '0', '1472025491', '0');
INSERT INTO `pactera_manage_user` VALUES ('41', 'mmma3', 'mmma3', '18710839142', 'e10adc3949ba59abbe56e057f20f883e', '', '', '2', '127.0.0.1', '0', '0', '0', '1472025569', '0');

-- ----------------------------
-- Table structure for pactera_manage_user_zhlbak
-- ----------------------------
DROP TABLE IF EXISTS `pactera_manage_user_zhlbak`;
CREATE TABLE `pactera_manage_user_zhlbak` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `email` varchar(64) NOT NULL COMMENT '邮箱地址',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `salt` varchar(32) NOT NULL COMMENT '动态密码核验字符串',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `login_ip` varchar(64) NOT NULL COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登陆时间',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新日期',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：-1删除 0禁用 1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of pactera_manage_user_zhlbak
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_member
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member`;
CREATE TABLE `pactera_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` char(40) NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '加密密码',
  `salt` char(10) NOT NULL COMMENT '随机加密码',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` char(20) NOT NULL COMMENT '手机号码',
  `avatar` varchar(255) NOT NULL COMMENT '头像地址',
  `money` decimal(10,2) unsigned NOT NULL COMMENT 'RMB',
  `score` int(10) unsigned NOT NULL COMMENT '虚拟币',
  `experience` int(10) unsigned NOT NULL COMMENT '经验值',
  `group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  `level_id` smallint(5) unsigned NOT NULL COMMENT '会员级别',
  `overdue` int(10) unsigned NOT NULL COMMENT '到期时间',
  `regist_ip` varchar(15) NOT NULL COMMENT '注册ip',
  `regist_time` int(10) unsigned NOT NULL COMMENT '注册时间',
  `randcode` mediumint(6) unsigned NOT NULL COMMENT '随机验证码',
  `is_mobile` tinyint(1) unsigned NOT NULL COMMENT '手机认证标识',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `group_id` (`group_id`),
  KEY `username` (`username`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of pactera_member
-- ----------------------------
INSERT INTO `pactera_member` VALUES ('4', '9801836@qq.com', 'wangrong1', '6550bd99559ed23b5ff00dafb067e330', 'UyDhvj', '', '', '', '0.00', '0', '0', '0', '0', '0', '0.0.0.0', '1471588274', '0', '0');
INSERT INTO `pactera_member` VALUES ('6', 'dffsa@qq.com', 'wang', 'b0a46b6e12e3dfed832ab88ac4715cef', 'ndhVlY', '', '', '', '0.00', '0', '0', '0', '0', '0', '0.0.0.0', '1471924232', '0', '0');
INSERT INTO `pactera_member` VALUES ('29', 'qq951418@qq.com', 'tmp_qq_517689', 'a6dc92d92fac11cfeba9234f9aa4e5b4', 'nOMvfo', '', '', '', '0.00', '0', '0', '0', '0', '0', '219.145.41.1', '1472190895', '0', '0');
INSERT INTO `pactera_member` VALUES ('33', 'qingqi@qingqi.com', 'qingqi', 'b4568060f3b7701e5729ccdf6831bcc2', 'mfikYh', '', '', '', '0.00', '0', '0', '0', '0', '0', '0.0.0.0', '1472525523', '0', '0');

-- ----------------------------
-- Table structure for pactera_member_address
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member_address`;
CREATE TABLE `pactera_member_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `city_id` int(11) unsigned NOT NULL COMMENT '城市id',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` varchar(20) NOT NULL COMMENT '电话',
  `zipcode` varchar(10) NOT NULL COMMENT '邮编',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `is_default` tinyint(1) unsigned NOT NULL COMMENT '是否默认',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`,`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员收货地址表';

-- ----------------------------
-- Records of pactera_member_address
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_member_invite
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member_invite`;
CREATE TABLE `pactera_member_invite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invite_member_id` int(10) unsigned NOT NULL COMMENT '邀请者',
  `invite_username` varchar(50) NOT NULL COMMENT '邀请人账号',
  `member_id` int(10) unsigned NOT NULL COMMENT '被邀请者',
  `member_name` varchar(50) NOT NULL COMMENT '被邀请者名称',
  `regist_time` int(10) NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`),
  KEY `invite_member_id` (`invite_member_id`),
  KEY `member_id` (`member_id`),
  KEY `regist_time` (`regist_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员邀请注册表';

-- ----------------------------
-- Records of pactera_member_invite
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_member_login_log
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member_login_log`;
CREATE TABLE `pactera_member_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned DEFAULT NULL COMMENT '会员uid',
  `oauth` varchar(30) NOT NULL COMMENT '快捷登录方式',
  `login_ip` varchar(50) NOT NULL COMMENT '登录Ip',
  `login_time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `useragent` varchar(255) NOT NULL COMMENT '客户端信息',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `login_ip` (`login_ip`),
  KEY `login_time` (`login_time`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='登录日志记录';

-- ----------------------------
-- Records of pactera_member_login_log
-- ----------------------------
INSERT INTO `pactera_member_login_log` VALUES ('8', '29', 'qq', '219.145.41.1', '1472190894', '');
INSERT INTO `pactera_member_login_log` VALUES ('9', '32', '', '0.0.0.0', '1472525079', '');
INSERT INTO `pactera_member_login_log` VALUES ('10', '32', '', '0.0.0.0', '1472525456', '');
INSERT INTO `pactera_member_login_log` VALUES ('11', '33', '', '0.0.0.0', '1472525535', '');
INSERT INTO `pactera_member_login_log` VALUES ('12', '33', '', '0.0.0.0', '1472525567', '');

-- ----------------------------
-- Table structure for pactera_member_oauth
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member_oauth`;
CREATE TABLE `pactera_member_oauth` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` mediumint(8) unsigned NOT NULL COMMENT '会员uid',
  `open_id` varchar(255) NOT NULL COMMENT 'OAuth返回id',
  `oauth` varchar(255) NOT NULL COMMENT 'oauth类型',
  `avatar` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `expire_at` int(10) unsigned NOT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `refresh_token` varchar(255) DEFAULT NULL,
  `create_time` int(10) DEFAULT '0',
  `update_time` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员OAuth2授权表';

-- ----------------------------
-- Records of pactera_member_oauth
-- ----------------------------
INSERT INTO `pactera_member_oauth` VALUES ('3', '29', 'B92FF7A9F50F86E8BDBC5155DBC63DCD', 'qq', 'http://qzapp.qlogo.cn/qzapp/100539081/B92FF7A9F50F86E8BDBC5155DBC63DCD/50', ' 清启', '7776000', '065D1296D3DD68300D64277D3A47306A', '5DFE93D526D04B206196889DEDCE8D21', '1472190894', '1472190894');

-- ----------------------------
-- Table structure for pactera_member_paylog
-- ----------------------------
DROP TABLE IF EXISTS `pactera_member_paylog`;
CREATE TABLE `pactera_member_paylog` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) unsigned NOT NULL,
  `money` decimal(10,2) NOT NULL COMMENT '价格',
  `type` varchar(20) NOT NULL COMMENT '类型',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单号',
  `module_id` varchar(30) NOT NULL COMMENT '应用或模块目录',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `pay_time` int(10) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `order_id` (`order_id`,`module_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付记录表';

-- ----------------------------
-- Records of pactera_member_paylog
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_system_addons
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_addons`;
CREATE TABLE `pactera_system_addons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '插件名称',
  `description` text NOT NULL COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态；0-禁用；1-启用；',
  `config` varchar(200) NOT NULL DEFAULT '' COMMENT '配置',
  `author` varchar(40) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '版本',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='插件表';

-- ----------------------------
-- Records of pactera_system_addons
-- ----------------------------
INSERT INTO `pactera_system_addons` VALUES ('1', 'CategorySelect', '商品类别下拉框', '1', 'null', '王荣', '0.1', '1460945470');
INSERT INTO `pactera_system_addons` VALUES ('2', 'Sms', '短信验证码', '1', 'null', '王荣', '0.1', '1460945470');

-- ----------------------------
-- Table structure for pactera_system_dict
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_dict`;
CREATE TABLE `pactera_system_dict` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `standard_id` int(10) unsigned NOT NULL COMMENT '标准ID',
  `dict_sn` varchar(32) NOT NULL COMMENT '字典ID',
  `dict_title` varchar(32) NOT NULL COMMENT '字典名称',
  `dict_name` varchar(32) NOT NULL COMMENT '字典英文名称',
  `dict_code` varchar(32) NOT NULL COMMENT '字典编码',
  `dict_sort` int(10) unsigned NOT NULL COMMENT '字典排序码',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：-1 删除 0 禁用 1 启用',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='字典管理表';

-- ----------------------------
-- Records of pactera_system_dict
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_system_dict_entry
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_dict_entry`;
CREATE TABLE `pactera_system_dict_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `dict_id` int(10) unsigned NOT NULL COMMENT '模块名',
  `dict_entry_sn` varchar(32) NOT NULL COMMENT '字典项ID',
  `dict_entry_name` varchar(32) NOT NULL COMMENT '字典项名称',
  `dict_entry_code` varchar(32) NOT NULL COMMENT '字典项代码',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态:-1删除 0 禁用 1启用',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(11) NOT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='字典项管理';

-- ----------------------------
-- Records of pactera_system_dict_entry
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_system_domain
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_domain`;
CREATE TABLE `pactera_system_domain` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块id',
  `domain` varchar(200) NOT NULL DEFAULT '' COMMENT '域名',
  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='域名管理';

-- ----------------------------
-- Records of pactera_system_domain
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_system_hooks
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_hooks`;
CREATE TABLE `pactera_system_hooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型；0-控制器；1-视图',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='钩子表';

-- ----------------------------
-- Records of pactera_system_hooks
-- ----------------------------
INSERT INTO `pactera_system_hooks` VALUES ('1', 'categorySelect', '商品类别下拉框', '1', '1460945369', '0', 'CategorySelect');
INSERT INTO `pactera_system_hooks` VALUES ('2', 'sms', '短信验证码', '1', '1460945369', '0', 'Sms');

-- ----------------------------
-- Table structure for pactera_system_setting
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_setting`;
CREATE TABLE `pactera_system_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `k` varchar(255) NOT NULL COMMENT '键',
  `v` text NOT NULL COMMENT '值',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`k`),
  UNIQUE KEY `k` (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='站点设置';

-- ----------------------------
-- Records of pactera_system_setting
-- ----------------------------

-- ----------------------------
-- Table structure for pactera_system_sms
-- ----------------------------
DROP TABLE IF EXISTS `pactera_system_sms`;
CREATE TABLE `pactera_system_sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL COMMENT '手机号',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '发送类型：1注册',
  `code` int(6) unsigned NOT NULL COMMENT '验证码',
  `text` varchar(255) NOT NULL COMMENT '短信内容',
  `response` varchar(255) NOT NULL COMMENT '接口响应',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pactera_system_sms
-- ----------------------------
INSERT INTO `pactera_system_sms` VALUES ('1', '15398097335', '1', '780092', '注册验证码为：[780092]', '', '1', '1474188416', '1474188416');
INSERT INTO `pactera_system_sms` VALUES ('2', '15398097335', '1', '215653', '注册验证码为：[215653]', '', '1', '1474188459', '1474188459');
INSERT INTO `pactera_system_sms` VALUES ('3', '15398097335', '1', '381382', '', '', '1', '1474188909', '1474188909');
INSERT INTO `pactera_system_sms` VALUES ('4', '15398097335', '1', '396256', '注册验证码为：[396256]', '', '1', '1474189099', '1474189099');
INSERT INTO `pactera_system_sms` VALUES ('5', '15398097335', '1', '22726', '注册验证码为：[022726]', '', '1', '1474189182', '1474189182');
INSERT INTO `pactera_system_sms` VALUES ('6', '15398097335', '1', '326837', '注册验证码为：[326837]', '', '1', '1474189197', '1474189197');
INSERT INTO `pactera_system_sms` VALUES ('7', '15398097335', '1', '658902', '注册验证码为：[658902]', '', '1', '1474189242', '1474189242');
INSERT INTO `pactera_system_sms` VALUES ('8', '15398097335', '1', '830176', '注册验证码为：[830176]', '', '1', '1474189247', '1474189247');
INSERT INTO `pactera_system_sms` VALUES ('9', '15398097335', '1', '837022', '注册验证码为：[837022]', '', '1', '1474189263', '1474189263');
INSERT INTO `pactera_system_sms` VALUES ('10', '15398097335', '1', '81491', '注册验证码为：[081491]', '', '1', '1474189356', '1474189356');
INSERT INTO `pactera_system_sms` VALUES ('11', '15398097335', '1', '411872', '注册验证码为：[411872]', '', '1', '1474189982', '1474189982');
INSERT INTO `pactera_system_sms` VALUES ('12', '15398097335', '1', '756879', '注册验证码为：[756879]', '', '1', '1474190050', '1474190050');
INSERT INTO `pactera_system_sms` VALUES ('13', '15398097335', '1', '442908', '注册验证码为：[442908]', '', '1', '1474190052', '1474190052');
INSERT INTO `pactera_system_sms` VALUES ('14', '15398097335', '1', '400397', '注册验证码为：[400397]', '', '1', '1474190063', '1474190063');
INSERT INTO `pactera_system_sms` VALUES ('15', '15398097335', '1', '592482', '注册验证码为：[592482]', '', '1', '1474190089', '1474190089');
INSERT INTO `pactera_system_sms` VALUES ('16', '15398097335', '1', '71758', '注册验证码为：[071758]', '', '1', '1474190144', '1474190144');
INSERT INTO `pactera_system_sms` VALUES ('17', '15398097335', '1', '880909', '注册验证码为：[880909]', '', '1', '1474190147', '1474190147');
INSERT INTO `pactera_system_sms` VALUES ('18', '15398097335', '1', '253735', '注册验证码为：[253735]', '', '1', '1474190184', '1474190184');
INSERT INTO `pactera_system_sms` VALUES ('19', '15398097335', '1', '289934', '注册验证码为：[289934]', '', '1', '1474190205', '1474190205');
INSERT INTO `pactera_system_sms` VALUES ('20', '15398097335', '1', '236388', '注册验证码为：[236388]', '', '1', '1474190212', '1474190212');
INSERT INTO `pactera_system_sms` VALUES ('21', '15398097335', '1', '741556', '注册验证码为：[741556]', '', '1', '1474190272', '1474190272');
INSERT INTO `pactera_system_sms` VALUES ('22', '15398097335', '1', '426079', '注册验证码为：[426079]', '', '1', '1474190274', '1474190274');
INSERT INTO `pactera_system_sms` VALUES ('23', '15398097335', '1', '837236', '注册验证码为：[837236]', '', '1', '1474190331', '1474190331');
INSERT INTO `pactera_system_sms` VALUES ('24', '15398097335', '1', '159096', '注册验证码为：[159096]', '', '1', '1474190345', '1474190345');
INSERT INTO `pactera_system_sms` VALUES ('25', '15398097335', '1', '996155', '注册验证码为：[996155]', '', '1', '1474190433', '1474190433');
INSERT INTO `pactera_system_sms` VALUES ('26', '15398097335', '1', '316080', '注册验证码为：[316080]', '', '1', '1474190479', '1474190479');
INSERT INTO `pactera_system_sms` VALUES ('27', '15398097335', '1', '385452', '注册验证码为：[385452]', '', '1', '1474190521', '1474190521');
INSERT INTO `pactera_system_sms` VALUES ('28', '15398097335', '1', '875408', '注册验证码为：[875408]', '', '1', '1474190559', '1474190559');
INSERT INTO `pactera_system_sms` VALUES ('29', '15398097335', '1', '589691', '注册验证码为：[589691]', '', '1', '1474190678', '1474190678');
INSERT INTO `pactera_system_sms` VALUES ('30', '15398097335', '1', '609987', '注册验证码为：[609987]', '', '1', '1474190707', '1474190707');
INSERT INTO `pactera_system_sms` VALUES ('31', '15398097335', '1', '652710', '注册验证码为：[652710]', '', '1', '1474190748', '1474190748');
INSERT INTO `pactera_system_sms` VALUES ('32', '15398097335', '1', '64631', '注册验证码为：[064631]', '', '1', '1474190961', '1474190961');
INSERT INTO `pactera_system_sms` VALUES ('33', '15398097335', '1', '604317', '注册验证码为：[604317]', '', '1', '1474191099', '1474191099');
INSERT INTO `pactera_system_sms` VALUES ('34', '15398097335', '1', '257623', '注册验证码为：[257623]', '', '1', '1474191126', '1474191126');
INSERT INTO `pactera_system_sms` VALUES ('35', '15398097335', '1', '590714', '注册验证码为：[590714]', '', '1', '1474191129', '1474191129');
INSERT INTO `pactera_system_sms` VALUES ('36', '15398097335', '1', '596341', '注册验证码为：[596341]', '', '1', '1474191136', '1474191136');
INSERT INTO `pactera_system_sms` VALUES ('37', '15398097335', '1', '161585', '注册验证码为：[161585]', '', '1', '1474191201', '1474191201');
INSERT INTO `pactera_system_sms` VALUES ('38', '15398097335', '1', '964583', '注册验证码为：[964583]', '', '1', '1474191240', '1474191240');
INSERT INTO `pactera_system_sms` VALUES ('39', '15398097335', '1', '294659', '注册验证码为：[294659]', '', '1', '1474191327', '1474191327');
INSERT INTO `pactera_system_sms` VALUES ('40', '15398097335', '1', '465430', '注册验证码为：[465430]', '', '1', '1474191533', '1474191533');
INSERT INTO `pactera_system_sms` VALUES ('41', '15398097335', '1', '778854', '注册验证码为：[778854]', '', '1', '1474191571', '1474191571');
INSERT INTO `pactera_system_sms` VALUES ('42', '15398097335', '1', '736130', '注册验证码为：[736130]', '', '1', '1474191670', '1474191670');
INSERT INTO `pactera_system_sms` VALUES ('43', '15398097335', '1', '956691', '注册验证码为：[956691]', '', '1', '1474191698', '1474191698');
INSERT INTO `pactera_system_sms` VALUES ('44', '15398097335', '1', '920536', '注册验证码为：[920536]', '', '1', '1474191821', '1474191821');
INSERT INTO `pactera_system_sms` VALUES ('45', '15398097335', '1', '861745', '注册验证码为：[861745]', '', '1', '1474191878', '1474191878');
INSERT INTO `pactera_system_sms` VALUES ('46', '15398097335', '1', '83477', '注册验证码为：[083477]', '', '1', '1474191883', '1474191883');
INSERT INTO `pactera_system_sms` VALUES ('47', '15398097335', '1', '104055', '注册验证码为：[104055]', '', '1', '1474191992', '1474191992');
INSERT INTO `pactera_system_sms` VALUES ('48', '15398097335', '1', '507086', '注册验证码为：[507086]', '', '1', '1474192339', '1474192339');
INSERT INTO `pactera_system_sms` VALUES ('49', '15398097335', '1', '113737', '注册验证码为：[113737]', '', '1', '1474192580', '1474192580');
INSERT INTO `pactera_system_sms` VALUES ('50', '15398097335', '1', '595324', '注册验证码为：[595324]', '', '1', '1474192646', '1474192646');
INSERT INTO `pactera_system_sms` VALUES ('51', '15398097335', '1', '140604', '注册验证码为：[140604]', '', '1', '1474192725', '1474192725');
INSERT INTO `pactera_system_sms` VALUES ('52', '15398097335', '1', '709726', '注册验证码为：[709726]', '', '1', '1474192871', '1474192871');
INSERT INTO `pactera_system_sms` VALUES ('53', '15398097335', '1', '364051', '注册验证码为：[364051]', '', '1', '1474193102', '1474193102');
INSERT INTO `pactera_system_sms` VALUES ('54', '15398097335', '1', '563531', '注册验证码为：[563531]', '', '1', '1474193106', '1474193106');
INSERT INTO `pactera_system_sms` VALUES ('55', '15398097335', '1', '293329', '注册验证码为：[293329]', '', '1', '1474193107', '1474193107');
INSERT INTO `pactera_system_sms` VALUES ('56', '15398097335', '1', '314581', '注册验证码为：[314581]', '', '1', '1474193108', '1474193108');
INSERT INTO `pactera_system_sms` VALUES ('57', '15398097335', '1', '987766', '注册验证码为：[987766]', '', '1', '1474193110', '1474193110');
INSERT INTO `pactera_system_sms` VALUES ('58', '15398097335', '1', '400567', '注册验证码为：[400567]', '', '1', '1474193113', '1474193113');
INSERT INTO `pactera_system_sms` VALUES ('59', '15398097335', '1', '176842', '注册验证码为：[176842]', '', '1', '1474193115', '1474193115');
INSERT INTO `pactera_system_sms` VALUES ('60', '15398097335', '1', '914784', '注册验证码为：[914784]', '', '1', '1474193116', '1474193116');
INSERT INTO `pactera_system_sms` VALUES ('61', '15398097335', '1', '573467', '注册验证码为：[573467]', '', '1', '1474193118', '1474193118');
INSERT INTO `pactera_system_sms` VALUES ('62', '15398097335', '1', '462204', '注册验证码为：[462204]', '', '1', '1474193119', '1474193119');
INSERT INTO `pactera_system_sms` VALUES ('63', '15398097335', '1', '461227', '注册验证码为：[461227]', '', '1', '1474193120', '1474193120');
INSERT INTO `pactera_system_sms` VALUES ('64', '15398097335', '1', '392567', '注册验证码为：[392567]', '', '1', '1474193362', '1474193362');
INSERT INTO `pactera_system_sms` VALUES ('65', '15398097335', '1', '354985', '注册验证码为：[354985]', '', '1', '1474193364', '1474193364');
INSERT INTO `pactera_system_sms` VALUES ('66', '15398097335', '1', '548727', '注册验证码为：[548727]', '', '1', '1474193880', '1474193880');
INSERT INTO `pactera_system_sms` VALUES ('67', '15398097335', '1', '360363', '注册验证码为：[360363]', '', '1', '1474193883', '1474193883');
INSERT INTO `pactera_system_sms` VALUES ('68', '15398097335', '1', '969154', '注册验证码为：[969154]', '', '1', '1474193884', '1474193884');
INSERT INTO `pactera_system_sms` VALUES ('69', '15398097335', '1', '812120', '注册验证码为：[812120]', '', '1', '1474193885', '1474193885');
INSERT INTO `pactera_system_sms` VALUES ('70', '15398097335', '1', '986392', '注册验证码为：[986392]', '', '1', '1474193887', '1474193887');
INSERT INTO `pactera_system_sms` VALUES ('71', '15398097335', '1', '706972', '注册验证码为：[706972]', '', '1', '1474193888', '1474193888');
INSERT INTO `pactera_system_sms` VALUES ('72', '15398097335', '1', '296832', '注册验证码为：[296832]', '', '1', '1474193912', '1474193912');
INSERT INTO `pactera_system_sms` VALUES ('73', '15398097335', '1', '882831', '注册验证码为：[882831]', '', '1', '1474193913', '1474193913');
INSERT INTO `pactera_system_sms` VALUES ('74', '15398097335', '1', '267424', '注册验证码为：[267424]', '', '1', '1474193914', '1474193914');
INSERT INTO `pactera_system_sms` VALUES ('75', '15398097335', '1', '49276', '注册验证码为：[049276]', '', '1', '1474193916', '1474193916');
INSERT INTO `pactera_system_sms` VALUES ('76', '15398097335', '1', '572978', '注册验证码为：[572978]', '', '1', '1474193917', '1474193917');
INSERT INTO `pactera_system_sms` VALUES ('77', '15398097335', '1', '202759', '注册验证码为：[202759]', '', '1', '1474193918', '1474193918');
INSERT INTO `pactera_system_sms` VALUES ('78', '15398097335', '1', '630266', '注册验证码为：[630266]', '', '1', '1474193920', '1474193920');
INSERT INTO `pactera_system_sms` VALUES ('79', '15398097335', '1', '249830', '注册验证码为：[249830]', '', '1', '1474193921', '1474193921');
INSERT INTO `pactera_system_sms` VALUES ('80', '15398097335', '1', '981594', '注册验证码为：[981594]', '', '1', '1474193996', '1474193996');
INSERT INTO `pactera_system_sms` VALUES ('81', '15398097335', '1', '747566', '注册验证码为：[747566]', '', '1', '1474194013', '1474194013');
INSERT INTO `pactera_system_sms` VALUES ('82', '15398097335', '1', '341653', '注册验证码为：[341653]', '', '1', '1474194147', '1474194147');
INSERT INTO `pactera_system_sms` VALUES ('83', '15398097335', '1', '962250', '注册验证码为：[962250]', '', '1', '1474194148', '1474194148');
INSERT INTO `pactera_system_sms` VALUES ('84', '15398097335', '1', '893726', '注册验证码为：[893726]', '', '1', '1474194215', '1474194215');
INSERT INTO `pactera_system_sms` VALUES ('85', '15398097335', '1', '217436', '注册验证码为：[217436]', '', '1', '1474194322', '1474194322');
INSERT INTO `pactera_system_sms` VALUES ('86', '15398097335', '1', '989463', '注册验证码为：[989463]', '', '1', '1474249224', '1474249224');
INSERT INTO `pactera_system_sms` VALUES ('87', '15398097335', '1', '122049', '注册验证码为：[122049]', '', '1', '1474249340', '1474249340');
INSERT INTO `pactera_system_sms` VALUES ('88', '15398097335', '1', '150907', '注册验证码为：[150907]', '', '1', '1474249398', '1474249398');
INSERT INTO `pactera_system_sms` VALUES ('89', '15398097335', '1', '530920', '注册验证码为：[530920]', '', '1', '1474249409', '1474249409');
INSERT INTO `pactera_system_sms` VALUES ('90', '15398097335', '1', '920761', '注册验证码为：[920761]', '', '1', '1474255384', '1474255384');
INSERT INTO `pactera_system_sms` VALUES ('91', '15398097335', '1', '270342', '注册验证码为：[270342]', '', '1', '1474255410', '1474255410');
INSERT INTO `pactera_system_sms` VALUES ('92', '15398097331', '1', '114194', '注册验证码为：[114194]', '', '1', '1474255611', '1474255611');
INSERT INTO `pactera_system_sms` VALUES ('93', '15398097331', '1', '529702', '注册验证码为：[529702]', '', '1', '1474255672', '1474255672');
INSERT INTO `pactera_system_sms` VALUES ('94', '15398097335', '1', '670455', '注册验证码为：[670455]', '', '1', '1474255691', '1474255691');
INSERT INTO `pactera_system_sms` VALUES ('95', '15398097335', '1', '407959', '注册验证码为：[407959]', '', '1', '1474255692', '1474255692');
INSERT INTO `pactera_system_sms` VALUES ('96', '15398097335', '1', '632861', '注册验证码为：[632861]', '', '1', '1474255725', '1474255725');
INSERT INTO `pactera_system_sms` VALUES ('97', '15398097335', '1', '607125', '注册验证码为：[607125]', '', '1', '1474255790', '1474255790');
INSERT INTO `pactera_system_sms` VALUES ('98', '15398097335', '1', '548801', '注册验证码为：[548801]', '', '1', '1474255874', '1474255874');
INSERT INTO `pactera_system_sms` VALUES ('99', '15398097335', '1', '289232', '注册验证码为：[289232]', '', '1', '1474255936', '1474255936');
