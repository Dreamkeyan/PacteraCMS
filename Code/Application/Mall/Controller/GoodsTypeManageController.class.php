<?php

namespace Mall\Controller;

/**
 * Class GoodsTypeManageController
 *
 * @package Mall\Controller
 */
class GoodsTypeManageController extends ManageBaseController
{

    /**
     * This is the Goods type list page
     */
    public function index()
    {
        $model = D('GoodsType');
        $list = $model->search();
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage()
        ));
        $this->display();
    }

    /**
     * This is the page form
     *
     * @param null $id
     */
    public function form($id = null)
    {
        if ($id) {
            $data = D('GoodsType')->find($id);
            $this->assign('data', $data);
        }
        $this->display();
    }

    /**
     * This is the save data action
     */
    public function save()
    {
        $model = D('GoodsType');
        if ($model->create()) {
            if ($model->id) {
                $data = $model->data();
                if (!$model->checkEidt($data)) {
                    $this->ajaxReturn(array(
                        'status' => 'error',
                        'message' => '模型名称已存在！'
                    ));
                }
                $model->save();
            } else {
                $model->add();
            }
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array(
                'status' => 'error',
                'message' => $model->getError()
            ));
        }
    }

    /**
     * This is the delete type action
     *
     * @param $id
     */
    public function delete($id)
    {
        $model = D("GoodsType");
        $model->is_del = 1;
        $model->where(array('id' => $id));
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}