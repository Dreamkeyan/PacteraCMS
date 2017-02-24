<?php

namespace Mall\Model;

use Think\model;

/**
 * Class NotificationModel
 * @package Mall\Model
 */
class NotificationTypeModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_notification_type';

    /**
     * @var array
     */
    protected $_validate = array(
        array('name', 'require', '类别名称不能为空！'),
        array('name', '', '类别名称已经存在！', 0, 'unique', 1),
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
     * This function is handle the request params
     *
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {
        if ($params['name']) {
            $this->where['name'] = array('like', '%' . $params['name'] . '%');
        }
        if ($params['status'] || $params['status'] === '0') {
            $this->where['status'] = $params['status'];
        }
    }

}
