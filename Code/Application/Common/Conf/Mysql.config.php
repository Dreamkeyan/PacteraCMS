<?php
/**
 * Mysql 数据库配置
 *
 */

return array(
    'DB_TYPE'    => 'mysql',            // 数据库类型
    'DB_HOST'    => '106.75.93.18',     // 服务器地址
    'DB_NAME'    => 'db_pacteracms',    // 数据库名
    'DB_USER'    => 'wsadmin',          // 用户名
    'DB_PWD'     => 'AzSxDc890567??',  // 密码
    'DB_PORT'    => 3306,               // 端口
    'DB_PREFIX'  => 'pactera_',         // 数据库表前缀
    'DB_CHARSET' => 'utf8',             // 字符集
    'DB_DEBUG'   => true,               // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    'DB_PARAMS'  => array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL)
);