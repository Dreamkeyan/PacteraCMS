<?php

/**
 * 评价模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

class AppraiseModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_appraise';
    
    /**
     * 获取商品评价
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-11-3
     **/
    public function getAppraiseList($param = array()) {

        $where = array(
            'status'=>1
        );
        if($param['type'] == 1){
            $where['goods_id'] = $param['goods_id'];
        }else{
            $where['member_id'] = $param['member_id'];
        }

        $data = $this->where($where)->order('id DESC')->select();

        $result = array();
        array_walk($data, function($value, $key) use (&$result) {
            $result[$key] = $value;
            $result[$key]['appraise'] = explode(',', $value['word_ids']);
        });

        return $result;
    }
    
    public function totalCount($goods_id = 0) {
        $where = array(
            'status'=>1
        );
        
        if($goods_id){
            $where['goods_id'] = $goods_id;
        }
        return $this->where($where)->count();
    }
    
    public function totalLevel($goods_id = 0) {
        $where = array(
            'status'=>1
        );
        
        if($goods_id){
            $where['goods_id'] = $goods_id;
        }
        return $this->where($where)->sum('level');
    }
}
