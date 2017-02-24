<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class WeixinmsgModel extends CommonModel{
    protected $pk   = 'msg_id';
    protected $tableName =  'weixin_msg';
    protected $token =  'weixin_msg';
    
}