<?php

namespace Mall\Model;

/**
 * Class AttrModel
 * @package Mall\Model
 */
class SpecModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_spec';

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
        array('spec_name', 'require', '规格名称不能为空！', 1),
        array('type_id', 'require', '规格类型不能为空！', 1),
    );

    /**
     * @var array
     */
    protected $_link = array(
        'type' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'GoodsType',
            'foreign_key' => 'type_id',
        ),
        'items' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'SpecItem',
            'foreign_key' => 'spec_id',
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
     * Get spec by cate id
     *
     * @param $cateid
     *
     * @return mixed
     */
    public function getSpecByCateid($cateid)
    {
        return $this->where(array('cate_id' => $cateid))->relation("items")->select();
    }

    /**
     * To generate a grid
     *
     * @param       $specid
     * @param array $specitems
     *
     * @return array
     */
    public static function genGrid($specid, array $specitems = array())
    {
        return array_map(function ($item) use ($specid) {
            return array(
                'spec_id' => $specid,
                'item' => $item,
                'create_time' => NOW_TIME
            );
        }, $specitems);
    }

    /**
     * Get specs by type id
     *
     * @param $typeid
     *
     * @return mixed
     */
    public function getByTypeId($typeid)
    {
        $this->where['type_id'] = $typeid;
        $this->where['is_del'] = array('neq', 1);

        return $this->where($this->where)->relation('items')->select();
    }

}
