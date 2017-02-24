<?php

namespace Mall\Model;

use Think\model;

/**
 * Class NotificationModel
 * @package Mall\Model
 */
class NotificationModel extends MallBaseModel
{

    // const
    const TYPE_DRAW = 'draw';
    const TYPE_DEAL = 'deal';
    const TYPE_NOTI = 'noti';
    const TYPE_ANNO = 'anno';

    /**
     * @var string
     */
    protected $tableName = 'mall_notification';

    /**
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * This is the data model validate
     *
     * @var array
     */
    protected $_validate = array(
        array('content', 'require', '通知内容不能为空！'),
        array('type', 'checkType', '通知类型错误！', 3, 'callback'),
    );

    /**
     * This get all the notice types
     *
     * @return array
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_DRAW => '交易消息',
            self::TYPE_DEAL => '提款记录',
            self::TYPE_NOTI => '通知消息',
            self::TYPE_ANNO => '网站公告',
        );
    }

    /**
     * Check the type is exist
     *
     * @param $type string
     *
     * @return bool
     */
    public function checkType($type)
    {
        return array_key_exists($type, self::getTypes());
    }

}
