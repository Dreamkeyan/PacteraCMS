<?php
namespace Mall\Controller;

use Mall\Service\NoticeService as Notice;

/**
 * Class NoticeController
 * @package Mall\Controller
 */
class NoticeController extends MobileBaseController
{

    /**
     * This is
     *
     */
//    public function save()
//    {
//        $oauth_ids = array(3, 4, 11, 12, 14); // or $oauth_ids = 3;
//        Notice::send('This is the notice!', $oauth_ids, Notice::TYPE_ANNO);
//    }
    
    public function index() {
        $oauth_id = $this->mid;
        $data = Notice::getNoticeList($oauth_id);
//        debug($data);
        $this->assign('data', $data);
        $this->display();
    }
    
    /**
     * get the notice list
     */
    public function get() {
        $oauth_id = 3;
        $data = Notice::getNoticeList($oauth_id);
        dump($data);exit();
    }

}
