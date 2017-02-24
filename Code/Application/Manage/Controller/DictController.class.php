<?php
namespace Manage\Controller;

use Think\Exception;

class DictController extends CommonController
{

    /**
     * 查看字典
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function index()
    {
//        dd(M()->query('show table status'));
        $this->display();
    }

    /**
     * 添加字典
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 保存字典
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function save()
    {
        try {

            $data = I('post.');
            D('Dict')->saveDict($data);

            $this->success(L('common_success'));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * 编辑字典
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function edit()
    {
        $id = I('get.id', 0);

        $this->assign('dict', D('Dict')->getDictInfo($id));
        $this->display();
    }

    /**
     * 删除字典
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function delete()
    {
        $id = I('get.id', 0);

        // 是否存在字典项
        $dictEntry = M('SystemDictEntry')->where(array('dict_id' => array('eq', $id)))->count();
        if ($dictEntry > 0) {
            $this->error(L('exist_to_entry'));
        }

        $result = M('Dict')->where(array('id' => array('eq', $id)))->save(array('status' => -1));
        if ($result === false) {
            $this->error(L('delete_error',array('name' => '字典')));
        }

        $this->success(L('delete_success',array('name' => '字典')));
    }
}                              ;