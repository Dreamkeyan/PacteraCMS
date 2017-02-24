<?php
return array(
    'app_begin' => array('Behavior\CheckLangBehavior'),
    'app_init'=>array('Common\Behavior\InitHookBehavior', //插件
                      'Snowair\Think\Behavior\HookAgent' //.env
                    )  
);