<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class Messages extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'messages';

    public function getType(){
        return $this->types;
    }
    
}