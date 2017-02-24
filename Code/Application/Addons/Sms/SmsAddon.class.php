<?php
/**
 * 短信验证码插件
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 2016.9.18
 */

namespace Addons\Sms;

use Common\Controller\Addon;

class SmsAddon extends Addon
{
    public $info = array(
        'name'        => 'Sms',
        'status'      => 1,
        'author'      => '王荣',
        'version'     => '0.1',
        'description' => '短信验证码'
    );

    /**
     * 安装插件
     */
    public function install()
    {
        return true;
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        return true;
    }
    
    /**
     * {:hook('sms', array('div' =>0))}
     */
    public function sms($param)
    {
        $this->assign('param', $param);
        $this->display('sms');
    }
}

