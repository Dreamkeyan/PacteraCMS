<?php

namespace Mall\Model;

/**
 * Class GoodsTypeModel
 * @package Mall\Model
 */
class GoodsTypeModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_goods_type';

    /**
     * @var array
     */
    protected $_auto = array(
        array('is_del', 0, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * @var array
     */
    protected $_validate = array(
        array('name', 'require', '模型名称不能为空！', 1),
        array('name', '', '模型已经存在！', 0, 'unique', 1),
    );

    /**
     * This function is for search init
     */
    protected function _initSearch()
    {
        $this->where['is_del'] = array('eq', 0);
        $this->order = 'create_time desc';
    }

    /**
     * get the goods type options
     */
    public function getOptions()
    {
        return $this->where(array('is_del' => array('neq', 1)))->getField('id, name');
    }

    /**
     * check the edit name
     *
     * @param array $data
     *
     * @return mixed
     */
    public function checkEidt(array $data)
    {
        $where['name'] = $data['name'];
        $where['id'] = array('neq', $data['id']);

        return $this->where($where)->count() ? false : true;
    }

}
