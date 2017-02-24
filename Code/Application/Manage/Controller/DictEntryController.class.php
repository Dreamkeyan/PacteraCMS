<?php
namespace Manage\Controller;

/**
 * 字典项
 *
 * @package Manage\Controller
 */
class DictEntryController extends CommonController
{
    /**
     * 字典项列表
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function index()
    {
        $this->display();
    }

    /**
     * 添加字典项
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 保存字典项
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function save()
    {
        $data = I('post.');

        D('DictEntry')->addDictEntry($data);

    }

    public function edit()
    {
        $id = I('get.id', 0);

        $this->assign('dictEntry', D('DictEntry')->getDictEntryInfo($id));
        $this->display();
    }

    public function delete()
    {
        $id = I('get.id', 0);

        $result = D('DictEntry')->save(array('status' => -1,'id' => $id));
        if ($result === false) {
            $this->error(L('delete_error', array('name' => '字典项')));
        }

        $this->success(L('delete_success', array('name' => '字典项')));
    }
}