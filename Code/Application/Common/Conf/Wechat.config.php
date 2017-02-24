<?php
/**
 * 微信配置
 */
return array(
    // 微信相关配置
    'WECHAT' => array(

        // 基本信息
        'app_id'  => 'wxfbcc98d8d873dfb7', // AppID
        'secret'  => '8add0969c69e3331c10ca802c9ff5575', // AppSecret
//        'token'   => 'HSPBtj4yGiV1AMHv', // Token
//        'aes_key' => 'Pojfc6gd6tjIJTZ4VUetigDRG8bs1iZbAh9OAMe0XKd', // EncodingAESKey 在安全模式下必须填写

        // 调试模式
        'debug'   => false,

        // 日志
        'log'     => array(
            'level' => 'debug',
            'file'  => RUNTIME_PATH.'/Wechat/'.date('Ymd').'.log'
        ),

        // Oauth 配置
        'oauth'   => array(
            'scopes'   => array('snsapi_base'),
            'callback' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
        ),

        // 微信支付
        'payment' => array(
            'merchant_id' => '',
            'key'         => '',
            'cert_path'   => '',
            'key_path'    => '',

        )
    )
);