<?php

namespace Mall\Model;

use Think\model;

/**
 * Class NotificationReceiveModel
 * @package Mall\Model
 */
class NotificationReceiveModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_notification_receive';

    /**
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * Handle the batch data
     *
     * @param integer $notice_id
     * @param array   $oauth_ids
     *
     * @return array
     */
    public function batchData($notice_id, array $oauth_ids)
    {
        return array_map(function ($oauth_id) use ($notice_id) {
            return array(
                'notification_id' => $notice_id,
                'oauth_id' => $oauth_id,
                'create_time' => NOW_TIME
            );
        }, $oauth_ids);
    }

    /**
     * Get all notices by oauth
     *
     * @param $oauth_id
     *
     * @return array
     */
    public function getAllByOauth($oauth_id)
    {
        return $this->alias('m')->join('__MALL_NOTIFICATION__ n ON n.id = m.notification_id')
            ->where(array(
                'm.oauth_id' => $oauth_id,
                'n.is_delete' => array('neq', 1)
            ))->order('m.create_time desc')
            ->field('n.id nid, n.content, n.type_id, n.create_time, m.is_read')
            ->select();
    }
    
    /**
     * Get unread notices number by member
     *
     * @param $member_id
     *
     * @return count
     */
    public function getUnReadCount($member_id) {
        return $this->where('is_read = 0 and oauth_id='.$member_id)->count('id');
    }
}
