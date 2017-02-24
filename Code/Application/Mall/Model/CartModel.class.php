<?php

/**
 * 用户购物车模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-11-08
 * @version
 */

namespace Mall\Model;
use Think\Exception;

class CartModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_cart';
    
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    
    public function update($param, $cid = 0) {
        try {
            $where = array(
                'member_id' => $param['member_id'],
                'goods_id' => $param['goods_id'],
                'spec_key' => $param['spec_key']
            );
            
            $datail = $this->where($where)->find();
            if(empty($datail)){
                if($this->create($param)){
                    $res = $this->add();
                }else{
                    throw new Exception('购物车验证失败');
                }
            }else{
                $param['id'] = $datail['id'];
                if($cid ==0){
                    $param['goods_number'] += $datail['goods_number'];
                }
                $param['update_time'] = NOW_TIME;
                $res = $this->save($param);
                if($datail['id'] == $cid && $cid != 0 && !empty($res)){
                    $res = $cid;
                }
            }
            if(empty($res)){
                throw new Exception('购物车添加失败');
            }
            return $res;
        } catch (Exception $e) {
            throw $e;
        }

        
    }
    
    public function cartList($param) {
        $where = empty($param) ? array():$param;
        $where['status'] = 1;
        
        $list = $this->where($where)->select();
        
        //有效和无效
        $valid = array();
        $invalid = array();
        foreach ($list as $key => $value) {
            $goods_id = $value['goods_id'];
            if(1==get_goods_info($goods_id, 'is_putaway')){
                $valid[] = $value;
            }else {
                $invalid[] = $value;
            }
        }

        $result = array(
            'invalid' => $invalid
        );
        $result['valid'] = $this->arrayColumn($valid, 'shop_id');

        return $result;
    }
    
    public function arrayColumn($list, $field) {
        $result = array();
        foreach ($list as $key => $value) {
            $item_id = $value[$field];
            $result[$item_id][$key] = $value;
        }

        return $result;
    }
    
    
    public function saveAllSql($data) {
        
        $ids = array();
        $col = array();
        foreach ($data as $key => $value) {
            if($key=='num'){
                $field_sql = ' goods_number = (CASE id ';
                foreach ($value as $k => $val) {
                    $field_sql .= ' WHEN '.$k.' THEN  '.$val;
                    $ids[] = $k;
                }
                $field_sql .= ' END) ';
                $col[] = $field_sql;
            }
        }
        $col[] = "update_time = ".NOW_TIME;
        $sql = "UPDATE ".$this->trueTableName." SET ";
        $sql .= implode(',', $col). " where id in (".  implode(',', array_unique($ids)).");";
        
        $res =  $this->execute($sql);
        return $res;
    }
    
    public function moveCollect($data) {
        $map = array(
            'member_id' => $_SESSION['member_id'],
            'type' => 1,
            'status' =>1
        );
        $collectinfo = D('MemberCollect')->getMemberInfo($map);
        $collect_ids = array_column($collectinfo, 'collect_id');

        $del = array();
        $collect = array();
        
        array_walk($data, function($val, $k) use (&$collect_ids, &$del, &$collect) {
            if(!in_array($val['gid'], $collect_ids)){
                $del['del'][$val['id']] = 0;
                $collect[] = array(
                    'member_id' => $_SESSION['member_id'],
                    'type' => 1,
                    'collect_id' => $val['gid'],
                    'status' => 1
                );
            }
        });
        
        $flag = 0;
        if(!empty($del) && !empty($collect)){
            $flag = 1;
            $res_del = $this->saveAllSql($del);
            $res_collect = D('MemberCollect')->addAll($collect);
        }
        
        if(($flag && $res_del && $res_collect) || ($flag==0)){

            return empty($del)? []:array_keys($del['del']);
        }

        return false;
    }
}
