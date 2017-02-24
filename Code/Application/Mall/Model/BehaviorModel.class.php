<?php

/**
 * 用户行为模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2017-1-11
 * @version
 */

namespace Mall\Model;

class BehaviorModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_behavior';
    
    /**
     * 用户行为信息插入
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function insert($data) {
        return $this->add($data);
    }
}
