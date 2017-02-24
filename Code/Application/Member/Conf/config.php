<?php
return array(
	//'配置项'=>'配置值'
	'LANG_SWITCH_ON' => true,   // 开启语言包功能
	'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
	'DEFAULT_LANG' => 'zh-cn', // 默认语言
	'LANG_LIST'        => 'zh-cn,en-us,zh-tw', // 允许切换的语言列表 用逗号分隔
	'VAR_LANGUAGE'     => 'l', // 默认语言切换变量
    
//    'URL_MODEL'          => '2', //URL模式
    
    'LOGIN_SDK' => [
        'qq' => [
            'app_id' => '100539081',
            'app_key' => 'fcdaa0fc647f2aa04929b50771f65df0',
            'callback' => 'http://cms.olcms.com/index.php/Member/Passport/qqCallback'
        ]
    ],
  
);