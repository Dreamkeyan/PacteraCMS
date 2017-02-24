<?php

namespace Member\Model;

/**
 * 用户oauth模型
 *
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016-8-26  9:28:31
 */
class MemberOauthModel extends MemberBaseModel
{
    
    public function getInfo($where) {
        return $this->where($where)->find();
    }
    
    public function update($where, $data) {
        return $this->where($where)->save($data);
    }
}
