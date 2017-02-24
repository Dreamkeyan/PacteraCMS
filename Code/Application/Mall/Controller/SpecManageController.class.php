<?php

namespace Mall\Controller;

use Mall\Model\SpecModel;

/**
 * Class SpecManageController
 *
 * @package Mall\Controller
 */
class SpecManageController extends ManageBaseController
{

    /**
     * This is the Goods spec list page
     */
    public function index()
    {
        $model = D('Spec');
        $list = $model->search(I());
        $types = D('GoodsType')->getOptions();
        // render
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage(),
            'types' => $types
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
            $data = D('Spec')->relation('items')->find($id);
            $this->assign('data', $data);
        }
        $types = D('GoodsType')->getOptions();
        $this->assign(array(
            'types' => $types
        ));
        $this->display();
    }

    /**
     * This is the save data action
     */
    public function save()
    {
        $model = D('Spec');
        if ($model->create()) {
            try {
                M()->startTrans();
                if ($model->id) {
                    $specid = $model->id;
                    $model->save();
                    D('SpecItem')->where(array('spec_id' => $specid))->delete();
                } else {
                    $specid = $model->add();
                }
                $items = SpecModel::genGrid($specid, I('items'));
                D('SpecItem')->addAll($items);
                M()->commit();
                $this->ajaxReturn(array('status' => 'success'));
            } catch (commonException $e) {
                M()->rollback();
                $this->ajaxReturn(array('status' => 'error'));
            }
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
        $model = D("Spec");
        $model->is_del = 1;
        $model->where(array('id' => $id));
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}