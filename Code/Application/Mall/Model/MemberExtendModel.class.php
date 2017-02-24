<?php

/**
 * 用户扩展模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;
use Think\Exception;

class MemberExtendModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_member_extend';
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    public function update($param) {
        try {
            $datail = $this->getInfoByMember($param['member_id']);
            if (empty($datail)) {
                if($this->create($param)){
                    $res = $this->add();
                }else{
                    throw new Exception('用户扩展信息验证失败');
                }
            } else {
                $param['id'] = $datail['id'];
                $param['update_time'] = NOW_TIME;
                $res = $this->save($param);
            }

            if(empty($res)){
                throw new Exception('用户扩展信息修改失败');
            }
            return $res;
        } catch (Exception $e) {
            throw $e;
        }

        
    }

    public function defaultAddr($param) {
        try {
            $param['update_time'] = NOW_TIME;
            $res_extend = $this->update($param);
            if(empty($res_extend)){
                throw new Exception('默认地址修改失败');
            }
        } catch (Exception $exc) {
            throw $e;
        }
    }

    public function getInfoByMember($member_id) {
        $where = array(
            'member_id' => $member_id,
        );
        $datail = $this->where($where)->find();
        return $datail;
    }

}
