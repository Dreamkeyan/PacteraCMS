<?php
namespace Manage\Controller;
use Think\Exception;

/**
 * 标准管理
 *
 * @package Manage\Controller
 */
class StandardController extends CommonController
{
    /**
     * 查看标准
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function index()
    {

    }

    /**
     * 添加标准
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 保存标准
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function save()
    {

        try {
            $data = I('post.');
            $result = D('Standard')->saveStandard($data);
            $this->success(L('common_success'));
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

    }

    /**
     * 编辑标准
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function edit()
    {
        $id = I('get.id', 0);

        $this->assign('standard', D('Standard')->getStandardInfo($id));
        $this->display();
    }

    /**
     * 删除标准
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function delete()
    {
        $id = I('get.id',0);
        if (empty($id)) {
            $this->error(L('param_error'));
        }

        if (M('SystemDict')->where(['standard_id' => ['eq', $id]])->count()) {
            $this->error(L('exist_to_dict'));
        }

        if (M('Standard')->save(['id' => $id, 'status' => -1]) !== false) {
            $this->success(L('delete_success',array('name' => '标准')));
        } else {
            $this->error(L('delete_error',array('name' => '标准')));
        }


    }
}