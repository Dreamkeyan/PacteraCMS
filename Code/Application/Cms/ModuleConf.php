<?php

/**
 * 模块配置文件
 */
return array(

    // 模块基本信息【必须】
    'module_info' => array(
        'module_name'  => 'Cms',  // 模块名称
        'module_title' => '内容', // 模块标题
        'developer'    => '文思海辉西安分公司',
        'description'  => '这是一个非常好用的内容管理系统', // 模块描述
        'version'      => '1.0.0', // 当前版本
    ),
    // 前台导航【可选】 注：user_nav 不可变
    'user_nav' => array(
        // Key 可自定义
        'title'  => array(
            'center' => '个人中心'
        ),
        'center' => array(
            '0' => array(
                'title' => '修改密码',
                'url'   => 'Cms/User/changePwd'
            ),
            '1' => array(
                'title' => '个人信息',
                'url'   => 'Cms/User/getUserInfo'
            )
        )
        // 其它功能可根据具体需求来定
    ),
    // 模块配置
    'module_config' => array(
        'register' => array(
            'title'   => '注册开关',
            'options' => array(
                '1' => '开启',
                '0' => '关闭'
            )
        )
    ),
    // 后台菜单及权限节点
    'module_menu' => array(
        array(
            'id'       => 1,
            'pid'      => 0,
            'menu_key' => 'Cms_nav',
            'title'    => 'CMS',
        ),
        array(
            'id'       => 2,
            'pid'      => 1,
            'menu_key' => 'Cms_manage',
            'title'    => '用户管理'
        ),
        array(
            'id'       => 3,
            'pid'      => 2,
            'title'    => '用户设置',
            'menu_key' => 'Cms_setting',
            'is_show'  => 1,
            'url'      => 'Cms/User/settings',
        ),
        array(
            'id'       => 4,
            'pid'      => 2,
            'is_show'  => 1,
            'title'    => '用户',
            'menu_key' => 'Cms_count',
            'url'      => 'Cms/User/count',
        ),
        array(
            'id'       => 5,
            'pid'      => 2,
            'title'    => '用户列表',
            'menu_key' => 'Cms_list',
            'is_show'  => 1,
            'url'      => 'Cms/User/list',
        ),
        array(
            'id'       => 6,
            'pid'      => 5,
            'title'    => '新增',
            'menu_key' => 'Cms_add',
            'is_show'  => 0,
            'url'      => 'Cms/User/add',
        ),
        array(
            'id'       => 7,
            'pid'      => 3,
            'title'    => '删除',
            'menu_key' => 'Cms_delete',
            'is_show'  => 0,
            'url'      => 'Cms/User/delete',
        )
    )

);