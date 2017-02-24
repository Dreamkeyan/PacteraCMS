<?php

namespace Mall\Model;

/**
 * Class BrandModel
 * @package Mall\Model
 */
class BrandModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_brand';

    /**
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * get the shops options
     */
    public function getOptions()
    {
        return $this->where(array('is_del' => array('neq', 1)))->getField('id, name');
    }

}
