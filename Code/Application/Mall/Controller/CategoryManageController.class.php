<?php

namespace Mall\Controller;

use Mall\Service\TreeService;

/**
 * Class CategoryManageController
 *
 * @package Mall\Controller
 */
class CategoryManageController extends ManageBaseController
{

    /**
     * This is the category list page
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $list = D('Category', 'Service')->getTreeList();
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * This is the category add action
     */
    public function add()
    {
        $cates = D('Category')->getOptions();
        $this->assign('cates', $cates);
        $this->display('form');
    }

    /**
     * This is the category edit action
     *
     * @param $id
     */
    public function edit($id)
    {
        $data = D('Category')->find($id);
        $cates = D('Category')->getOptions();
        $this->assign(array(
            'data' => $data,
            'cates' => $cates
        ));
        $this->display('form');
    }

    /**
     * This is the save category action
     */
    public function save()
    {
        $model = D('Category');
        if ($model->create()) {
            if ($model->id) {
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
     * This is the delete category action
     *
     * @param $id
     */
    public function delete($id)
    {
        $model = D('Category');
        $data = $model->find($id);
        if (!$model->delCheck($id)) {
            $this->ajaxReturn(array('status' => 'error', 'code' => 1));
        }
        $data['is_del'] = 1;
        if ($model->save($data)) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}