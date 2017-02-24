<?php

/**
 * 银行卡模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-12-27
 * @version
 */

namespace Mall\Model;
use Think\Exception;

class BankCardModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_bank_card';
    
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    
    public function saveData($data) {
        try {
            if($this->create($data)){
                $res = $this->add();
                if(empty($res)){
                    throw new Exception('添加失败');
                }
                return $res;
            }else{
                throw new Exception('验证失败');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function deleteData($data) {
        try {
            $data['update_time'] = NOW_TIME;
            $res = $this->save($data);
            if(empty($res)){
                throw new Exception('删除失败');
            }
            return $res;
        } catch (Exception $e) {
            throw $e;
        }
    }

}
