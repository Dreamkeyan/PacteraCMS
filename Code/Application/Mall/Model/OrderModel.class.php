<?php

/**
 * 订单模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-11-15
 * @version
 */

namespace Mall\Model;
use Think\Exception;

class OrderModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_order';
    
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    
    /**
     * 获取订单列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-11-15
     * */
    public function getListInfo($param) {

        $where = array(
            'member_id' => $param['member_id'],
            'status' => isset($param['status']) ? $param['status'] : array('egt', 0),
            'is_scan' => isset($param['scan']) ? $param['scan'] : array('egt', 0),
            'deliver_type' => isset($param['type']) ? $param['type'] : array('gt', 0),
            'is_del' => 0
        );
        $list = $this->where($where)->order('id desc')->select();
        
        $order_ids = array_column($list, 'id');
        !$order_ids && $order_ids = [0];

        $details = D('OrderDetail')->getList(array('order_id' => $order_ids));

        array_walk($list, function(&$value, $key) use($details) {
            $order_id = $value['id'];
            $value['detail'] = $details[$order_id];
        });
        return $list;
    }
    
    /**
     * 获取订单详情
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-11-15
     * */
    public function getDetailInfo($param) {

        $where = array(
            'member_id' => $param['member_id'],
            'id' => $param['id'],
            'is_del' => 0
        );
        $detail = $this->where($where)->find();

        $goods = D('OrderDetail')->getList(['order_id' => [$param['id']]]);

        $result = $detail;
        $result['detail'] = $goods[$detail['id']];
        return $result;
    }
    
    public function insertOrder($param, $goods) {
        $result = array();
        $tmp_goods = array();
        try {
            foreach ($param as $key => $value) {
                if($this->create($value)){
                    $order_id = $this->add();
                }else{
                    throw new Exception('订单验证失败');
                }
                
                if(empty($order_id)){
                    throw new Exception('订单添加失败');
                }

                array_push($result, $order_id);
                
                foreach ($goods[$key] as $k => $val) {

                    $tmp_goods[] = array(
                        'order_id' => $order_id,
                        'shop_id' => $key,
                        'goods_id' => $val['goods_id'],
                        'goods_name' => $val['goods_name'],
                        'spec_key' => $val['spec_key'],
                        'goods_spec' => $val['goods_spec'],
                        'goods_price' => $val['goods_price'],
                        'goods_number' =>$val['goods_number'],
                        'amount' => $val['goods_price']*$val['goods_number'],
                        'member_id' => $val['member_id'],
                        'status' => 0,
                        'create_time' => NOW_TIME,
                        'update_time' => NOW_TIME
                    );
                }
                
            }

            $detail_insert = D('OrderDetail')->addAll($tmp_goods);

            if (empty($detail_insert)) {
                throw new Exception('订单详情添加失败');    
            }
            
            return $result;
                    
        } catch (Exception $e) {

            throw $e;
        }

    }
    
    public function updateInfo($order_id, $data) {
        $result = $this->where(array('id'=>$order_id))->save($data);
        return $result;
    }
    
}
