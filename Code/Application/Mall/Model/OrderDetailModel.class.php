<?php

/**
 * 订单详情模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-11-15
 * @version
 */

namespace Mall\Model;

class OrderDetailModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_order_detail';
    
    /**
     * 获取订单商品的列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-11-15
     **/
    public function getList($param) {
        $where = array(
            'order_id' => array('in', $param['order_id']),
            'status' => array('egt', 0)
        );
        $list = $this->where($where)->select();
        
        $result = array();
        foreach ($list as $key => $value) {
            $order_id = $value['order_id'];
            $result[$order_id][$key] = $value;
        }

        return $result;
    }
    
   
}
