<?php
// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 根据所运行系统不同显示不同的路径分割符
define("DS", DIRECTORY_SEPARATOR);

// 获取当前文件所在目录                           
define("PACTERA_ROOT", realpath(__DIR__) . DS);   

//模块列表
define('BUILD_CONTROLLER_LIST','ManageBase,ApiBase,FrontBase,Index');

// 定义应用目录
define('APP_PATH',PACTERA_ROOT.'..'.DS.'Application'.DS);

// 定义缓存目录
define('RUNTIME_PATH', PACTERA_ROOT.'..'.DS.'Runtime'.DS);

// uc_client目录
define('UC_CLIENT_PATH', dirname(dirname(__FILE__)).DS.'api'.DS.'uc_client');

//composer
require_once './vendor/autoload.php';

// 引入Core入口文件
require PACTERA_ROOT.'..'.DS.'Core'.DS.'ThinkPHP.php';

