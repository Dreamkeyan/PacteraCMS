<?php

namespace Manage\Controller;

use Common\Controller\ManageCommonController;


class CommonController extends ManageCommonController
{
    /**
     * manage 模块 common
     *
     * CommonController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function checkFields($data = array(), $fields = array())
    {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    /**
     * 更新数据
     */
    public function editRow($model, $id, $data, $msg)
    {
        $result = M($model)->where("id={$id}")->save($data);
        if ($result !== false) {
            $this->simpleSuccess($msg['success'], U('index'));
        } else {
            $this->simpleError($msg['error']);
        }
    }

}