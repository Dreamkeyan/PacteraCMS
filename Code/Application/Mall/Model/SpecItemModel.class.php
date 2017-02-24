<?php

namespace Mall\Model;

/**
 * Class AttrModel
 * @package Mall\Model
 */
class SpecItemModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_spec_item';

    /**
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * @var array
     */
    protected $_link = array(
        'spec' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Spec',
            'foreign_key' => 'spec_id',
            'as_fields' => 'cate_id,spec_name'
        ),
    );

    /**
     * Get item by specids
     *
     * @param array $ids
     *
     * @return mixed
     */
    public function getItemBySpecids(array $ids = array())
    {
        return $this->where(array(
            'id' => array('in', $ids)
        ))->relation("spec")->field('id, spec_id, item')->select();
    }

}
