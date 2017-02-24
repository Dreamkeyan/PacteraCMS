<?php

namespace Mall\Model;

/**
 * Class CategoryParamModel
 * @package Mall\Model
 */
class CategoryParamModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $pk = 'id';

    /**
     * @var string
     */
    protected $tableName = 'mall_category_param';

    /**
     * @var array
     */
    protected $_auto = array(
        array('sort', 0, self::MODEL_INSERT, 'string'),
        array('status', 0, self::MODEL_INSERT, 'string'),
        array('is_del', 0, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * get all by category id
     *
     * @param $cateid
     *
     * @return mixed
     */
    public function getAllByCateId($cateid)
    {
        return $this->where(array(
            'category_id' => $cateid,
            'is_del' => 0
        ))->field('id, category_id, name, type, option_type, options, text_param')->select();
    }

}
