<?php
/**
 * Pactera 全局配置文件
 */

$_config = array(

    /**
     * 产品配置
     */
    'PRODUCT_NAME'         => 'PacteraCms',     // 产品名称
    'PRODUCT_LOGO'         => '',               // 产品 Logo
    'PRODUCT_VERSION'      => '1.0.0',          // 产品版本
    'WEBSITE_DOMAIN'       => 'http://www.pactera.com',    // 官方网站
    'COMPANY_NAME'         => '文思海辉技术有限公司西安分司',

    // 产品描述
    'PRODUCT_DESC'         => 'PacteraCms 模块化电商平台',

    // 公司描述
    'COMPANY_DESC'         => '文思海辉技术有限公司西安分公司',

    // URL 模式
    'URL_MODEL'            => 0,

    // URL配置
    'URL_CASE_INSENSITIVE' => false,  // 不区分大小写

    // 应用配置
    'DEFAULT_MODULE'       => 'Home',
    'MODULE_DENY_LIST'     => array('Common'),

    // 全局过滤配置
    'DEFAULT_FILTER'       => 'htmlspecialchars,stripslashes',

    // 多语言配置
    'LANG_SWITCH_ON'   => true,           // 开启多语言
    'LANG_AUTO_DETECT' => true,           // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'        => 'zh-cn,en-us,zh-tw',  // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'     => 'l',            // 默认语言切换变量

    // 模板相关配置
    'TMPL_PARSE_STRING'    => array(
        '__ASSET__' => 'http://static.pacteracms.51unite.com',
        '__PUBLIC__' => __ROOT__ . '/Asset/Common',
        '__LOCAL_ASSET__'  => __ROOT__.'/Asset'
    ),
    //验证码
    'VERIFY' => array(
        'length' => 4, //验证码长度
        'fontSize' => 18, //字体大小
        'imageH' => 45, // 验证码图片高度
        'imageW' => 120
    ),

    //自定义标签
    'TAGLIB_BUILD_IN'       => 'Cx,Common\TagLib\DataBase',

    // 模块配置
    "MODULE_CONFIG" => array(
        'DB_PREFIX' => 'pactera'
    ),

    //后台分页数
    'LIST_ROWS' => 10,

    //短信模板
    'SMS' => array(
        'DEBUG' => 1,
        'RESEND_SECOND' => '60',
        'TEMPLATE_REGISTER' => '注册验证码为：[CODE]'
    ),

    // 钩子配置
    'AUTOLOAD_NAMESPACE'   => array('Addons' => APP_PATH.'Addons'.DS), //扩展模块列表
    'ADDONS_PATH'          => APP_PATH.'Addons'.DS,

    // 路由映射
    "URL_ROUTER_ON" => true,
    'URL_ROUTE_RULES' => array( //定义路由规则
        'api/uc'  => 'UCenter/Api/test',    // UCenter 通讯地址
    ),

    //字段缓存
    'DB_FIELDS_CACHE'=>false,//关闭
);

// 加载数据库配置文件
$mysqlConf    = include 'Mysql.config.php';
// 加载微信配置
$wechatConf = include 'Wechat.config.php';
// 加载会员系统配置
$memberConf = include 'Member.config.php';
return array_merge($_config, $mysqlConf, $wechatConf, $memberConf);
