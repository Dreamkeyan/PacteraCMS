<?php

namespace Mall\Service;

/**
 * Class NoticeService
 * @package Mall\Service
 */
class NoticeService
{
    // const
    const TYPE_DRAW = '2';
    const TYPE_DEAL = '1';
    const TYPE_NOTI = '5';
    const TYPE_ANNO = '3';
    const TYPE_ORDER = '4';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $oauth;

    /**
     * @var string
     */
    private $error;

    /**
     * NoticeService constructor.
     *
     * @param string
     */
    private function __construct($type, $content, $oauth)
    {
        $this->type = $type;
        $this->content = $content;
        $this->oauth = $oauth;
    }

    /**
     * This get all the notice types
     *
     * @return array
     */
    public static function getTypes()
    {
//        return array(
//            self::TYPE_DRAW => '交易消息',
//            self::TYPE_DEAL => '提款记录',
//            self::TYPE_NOTI => '通知消息',
//            self::TYPE_ANNO => '网站公告',
//            self::TYPE_ORDER => '订单消息',
//        );
        $data = D('NotificationType')->where('status = 1 and is_del = 0')->getField('id,name,img_url');
        return $data;
    }

    /**
     * Send notice
     *
     * @param $content
     * @param $oauth
     * @param $type
     *
     * @return mixed
     */
    public static function send($content, $oauth, $type)
    {
        $instance = new self($type, $content, $oauth);
        // create notice
        $notice_id = $instance->_createNotice();
        if (!$notice_id) {
            return $instance->_getError();
        }
        // create receivers
        if (!$instance->_checkReceiver()) {
            return $instance->_getError();
        }
        // execute
        return $instance->_execute($notice_id);
    }

    /**
     * Get the notice list
     *
     * @param $oauth_id
     *
     * @return array
     */
    public static function getNoticeList($oauth_id)
    {
        $data = D('NotificationReceive')->getAllByOauth($oauth_id);
        $result = array_flip(array_unique(array_column($data, 'type_id')));
        
        foreach ($data as $item) {
            if (array_key_exists($item['type_id'], $result)) {
                $types = self::getTypes();
                if (!is_array($result[$item['type_id']])) {
                    $result[$item['type_id']] = array(
                        'unread' => 0,
                        'title' => $types[$item['type_id']]['name'],
                        'image' => $types[$item['type_id']]['img_url'],
                        'data' => array()
                    );
                }
                if (!$item['is_read']) {
                    $result[$item['type_id']]['unread'] += 1;
                }
                $result[$item['type_id']]['data'][] = $item;
            }
        }
        return $result;
    }

    /**
     * Execute the send notice
     *
     * @param $notice_id
     *
     * @return bool|string
     */
    private function _execute($notice_id)
    {
        $model = D('NotificationReceive');
        $data = $model->batchData($notice_id, $this->oauth);

        return $model->addAll($data);
    }

    /**
     * Check receiver
     *
     * @return bool
     */
    private function _checkReceiver()
    {
        $oauth_ids = is_array($this->oauth) ? $this->oauth : array($this->oauth);
        $receiver_ids = M('MemberOauth')->where(array(
            'id' => array('in', $oauth_ids)
        ))->getField('id', true);
        if (!$receiver_ids) {
            $this->_setError('没有接收者！');
            return false;
        } else {
            $this->oauth = $receiver_ids;
            return true;
        }
    }

    /**
     * Create notice
     *
     * @return bool|mixed
     */
    private function _createNotice()
    {
        $model = D('Notification');
        $data['content'] = $this->content;
        $data['type'] = $this->type;
        // create data
        if (!$model->create($data)) {
            $this->_setError($model->getError());
            return false;
        } else {
            return $model->add();
        }
    }

    /**
     * Get the error
     *
     * @return string
     */
    private function _getError()
    {
        return $this->error;
    }

    /**
     * Set the error
     *
     * @param $error
     */
    private function _setError($error)
    {
        $this->error = $error;
    }

}
