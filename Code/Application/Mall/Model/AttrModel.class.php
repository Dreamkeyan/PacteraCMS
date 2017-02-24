<?php

namespace Mall\Model;

/**
 * Class AttrModel
 * @package Mall\Model
 */
class AttrModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_attr';

    /**
     * @var bool
     */
    protected $relation = true;

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
        array('attr_name', 'require', '属性名称不能为空！'),
        array('type_id', 'require', '所属模型不能为空！'),
    );

    /**
     * @param array $data
     *
     * @return bool
     */
    public function checkRepeat(array $data)
    {
        $where['attr_name'] = $data['attr_name'];
        $where['type_id'] = $data['type_id'];

        return $this->where($where)->find() ? true : false;
    }

    /**
     * @var array
     */
    protected $_link = array(
        'type' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'GoodsType',
            'foreign_key' => 'type_id',
        ),
    );

    /**
     * This function is for search init
     */
    protected function _initSearch()
    {
        $this->where['is_del'] = array('neq', 1);
        $this->order = 'create_time desc';
    }

    /**
     * This function is handle the request params
     *
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {
        if ($params['type']) {
            $this->where['type_id'] = array('eq', $params['type']);
        }
    }

    /**
     * This is format the search data
     *
     * @param array $data
     *
     * @return array
     */
    protected function _searchDataFormat(array $data = array())
    {
        return array_map(function ($item) {
            if ($item['attr_values']) {
                $item['attr_values'] = json_decode($item['attr_values']);
            }
            return $item;
        }, $data);
    }

    /**
     * Get attr by cate id
     *
     * @param $cateid
     *
     * @return mixed
     */
    public function getAttrByCateid($cateid)
    {
        return $this->where(array('cate_id' => $cateid))->select();
    }

    /**
     * Get attrs by type id
     *
     * @param $typeid
     *
     * @return mixed
     */
    public function getByTypeId($typeid)
    {
        $this->where['type_id'] = $typeid;
        $this->where['is_del'] = array('neq', 1);
        $data = $this->where($this->where)->select();

        return $data ? $this->_formatValues($data) : array();
    }

    /**
     * Format the attrs values
     *
     * @param array $data
     *
     * @return array
     */
    private function _formatValues(array $data)
    {
        return array_map(function ($item) {
            $item['attr_values'] = $item['attr_values'] ? json_decode($item['attr_values']) : array();
            return $item;
        }, $data);
    }

}
