<?php

/**
 * 用户收藏模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;
use Think\Exception;

class MemberCollectModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_member_collect';
    
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
    
    public function update($param) {
        try {
            $where = array(
                'type' => $param['type'],
                'member_id' => $param['member_id'],
                'collect_id' => $param['collect_id']
            );
            $datail = $this->where($where)->find();
            
            if(empty($datail)){
                $res = $this->add($param);
                if(empty($res)){
                    throw new Exception('添加失败');
                }
            }else{
                $param['id'] = $datail['id'];
                $res = $this->save($param);
                if(empty($res)){
                    throw new Exception('修改失败');
                }
            }
            
            return $res;
        } catch (Exception $e) {
            throw $e;
        }

    }
    
    public function getMemberInfo($where) {

        return $this->where($where)->select();
    }
    
    public function getListValid($where=array()){
        
        $where['status'] = 1;
        $list = $this->where($where)->order('create_time DESC')->select();

        $result = array();
        foreach ($list as $key => $value) {
            
            $collect_id = $value['collect_id'];
            
            if($value['type'] == 1){
                $goods = get_goods_info($collect_id);

                if($goods['status'] >= 1 && $goods['is_putaway'] == 1){
                    $result['goods']['valid'][$key] = $value;
                    $result['goods']['valid'][$key]['goods'] = $goods;
                }else{
                    $result['goods']['invalid'][$key] = $value;
                    $result['goods']['invalid'][$key]['goods'] = $goods;
                }
            }else{
                
            }
            
        }
        
        return $result;
    }

}
