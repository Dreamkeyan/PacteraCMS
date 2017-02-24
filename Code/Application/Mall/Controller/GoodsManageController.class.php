<?php

namespace Mall\Controller;

use Mall\Service\GoodsService;
use Mall\Service\SpecService;

/**
 * Class GoodsManageController
 *
 * @package Mall\Controller
 */
class GoodsManageController extends ManageBaseController
{

    /**
     * This is the goods list page
     */
    public function index()
    {
        $model = D('Goods');
        $list = $model->search(I());
        $cates = D('Category')->getOptions();
        $brand = D('Brand')->getOptions();
        // render
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage(),
            'cates' => $cates,
            'brand' => $brand
        ));
        $this->display();
    }

    /**
     * This is the add goods page
     */
    public function add()
    {
        $this->assign(GoodsService::formOptions());
        $this->display('form');
    }

    /**
     * This is the edit goods page
     *
     * @param $id
     */
    public function edit($id)
    {
        $data = D('Goods')->getFormData($id);
        $this->assign('data', $data);
        $this->assign(GoodsService::formOptions());
        $this->display('form');
    }

    /**
     * Get the specs and attrs
     *
     * @param $mid
     */
    public function getSpecAttr($mid)
    {
        $this->ajaxReturn(array(
            'attr' => D('Attr')->getByTypeId($mid),
            'spec' => D('Spec')->getByTypeId($mid),
        ));
    }

    /**
     * Get the specs tables
     */
    public function getSpecTable()
    {
        $specitems = D('SpecItem')->getItemBySpecids(I('specs'));
        $service = new SpecService($specitems);
        $this->assign(array(
            'thead' => $service->getThead(),
            'tbody' => $service->getTbody()
        ));
        $this->display('spectable');
    }

    /**
     * save the goods release data
     */
    public function save()
    {
        $model = D('Goods');
        if ($model->create()) {
            try {
                M()->startTrans();
                if (!$model->id) {
                    $gid = $model->add();
                } else {
                    $gid = $model->id;
                    $model->save();
                    // clear
                    GoodsService::clearAll($gid);
                }
                GoodsService::saveImages($gid, I('images'));
                GoodsService::saveAttrs($gid, I('attrs'));
                GoodsService::saveSpecs($gid, I('specs'));
                // commit
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
        $model = D("Goods");
        $model->is_del = 1;
        $model->where(array('id' => $id));
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}