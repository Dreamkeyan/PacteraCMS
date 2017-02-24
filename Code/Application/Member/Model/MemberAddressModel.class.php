<?php

namespace Member\Model;
use Think\Exception;

/**
 * 用户地址模型
 *
 * @author   liym <yanming.li1@pactera.com>
 * @version  0.0.0.1
 * @datetime 2016-11-11
 */
class MemberAddressModel extends MemberBaseModel
{

    protected $tableName = 'member_address';

    /**
     * 自动验证
     * @var array
     */
    protected $_validate = array(
        array('member_id', 'require', '会员ID不能为空', 1),
        array('province_id', 'require', '请所选择省份', 1),
        array('city_id', 'require', '请所选择城市', 1),
        array('county_id', 'require', '请选择地区', 1),
        array('name', 'require', '收货人姓名不能为空', 1),
        array('address', 'require', '收货地址不能为空', 1),
        array('phone', '/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\d{8}$/', '手机号不正确或不合法', 1, 'regex')

    );

    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 获取用户收货地址
     *
     * @param int $memberId
     *
     * @return bool|mixed
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function getMemberAddressInfo($memberId = 0)
    {
        if (empty($memberId)) return false;

        $addressInfo = $this->where(array('member_id' => array('eq', $memberId),'status' => array('eq', 1)))->field(true)->select();
        if (empty($addressInfo)) return false;

        return $addressInfo;

    }

    /**
     * 获取收货地址信息
     * @param int $id
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function getAddressInfo($id = 0)
    {
        if (empty($id)) return false;

        $result = $this->where(array('id' => $id, 'status' => 1))->field(true)->find();

        return $result ?: false;

    }

    /**
     * 添加收货地址
     * @param array $data
     *
     * @return mixed|string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function addMemberAddress(array $data)
    {
        try {
            if (!$data = $this->create($data)) {
                throw new Exception($this->getError());
            }

            $id = $this->add($data);
            if (empty($id)) {
                throw new Exception(L('add_error',array('name'=>'收货地址')));
            }

            return json_encode(array('status' => 1, 'msg' => L('add_success',array('name' => '收货地址')),'data' => $id),JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            return json_encode(array('status' => 0, 'msg' => $e->getMessage(),'data'=>''),JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 编辑收货地址
     * @param int   $id
     * @param array $data
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function editMemberAddress($id = 0, array $data)
    {
        if (empty($id)) return false;

        $data = $this->filterAddressFields($data);
        if (empty($data)) return false;

        $map['id'] = array('eq', $id);
        $result = $this->where($map)->save($data);

        return ($result !== false) ? true : false;
    }

    /**
     * 设置默认地址
     * @param int $id
     * @param int $status
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function setDefaultAddress($id = 0, $status = 1)
    {
        if (empty($id)) return false;

        $result = $this->where(array('id' => $id))->save(array('is_default' => $status));

        return ($result !== false) ? true : false;

    }

    /**
     * 删除收货地址
     * @param int $id
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function deleteAddress($id = 0)
    {
        if (empty($id)) return false;

        $result = $this->where(array('id' => $id))->save(array('status' => 0));

        return ($result !== false) ? true : false;
    }

    /**
     * 过滤字段数据
     * @param array $data
     *
     * @return array|bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function filterAddressFields(array $data)
    {
        // 获取收货地址所有字段
        $fields = $this->getDbFields();
        if (empty($fields)) return false;

        // 获取收货地址所有字段
        $fields = $this->getDbFields();
        if (empty($fields)) return false;

        // 过滤空数据
        $data = array_filter($data);

        // 对 id, member_id
        $filterSensitiveFields = array_intersect_key($data,array_flip(array('id','member_id')));
        if (!empty($filterSensitiveFields)) return false;

        return array_intersect_key($data,array_flip($fields));

    }



    public function update($param = array())
    {
        if ($param['id']) {
            $res = $this->save($param);
        } else {
            $param['create_time'] = NOW_TIME;
            $res = $this->add($param);
        }

        return $res;
    }

    public function getInfoByWhere($param)
    {
        $where = empty($param) ? array() : $param;
        $where['status'] = 1;

        return $this->where($where)->find();
    }
}
