<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class WeixinkeywordModel extends CommonModel{
    protected $pk   = 'keyword_id';
    protected $tableName =  'weixin_keyword';
    protected $token = 'weixin_keyword';
  
    public  function checkKeyword($keyword){
        $words = $this->fetchAll();
        foreach($words as $val){
            if($val['keyword'] == $keyword)
                return  $val;
        }
        return false;
    }
}