<?php

/**
 * 活动模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

class ActivitiesModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_activities';
    
    /**
     * 位置获取活动
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function fetchPostion($postion) {

        $where = array(
            'postion'=>$postion,
            'status'=>1
        );
        return $this->where($where)->order('id DESC')->select();
    }
}
