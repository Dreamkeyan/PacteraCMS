<?php

namespace Mall\Controller;

/**
 * Class SpecManageController
 *
 * @package Mall\Controller
 */
class AttrManageController extends ManageBaseController
{

    /**
     * This is the Goods spec list page
     */
    public function index()
    {
        $model = D('Attr');
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
            $data = D('Attr')->find($id);
            $data['attr_values'] = json_decode($data['attr_values']);
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
        $model = D('Attr');
        if ($model->create()) {
            if ($model->attr_values) {
                $model->attr_values = json_encode($model->attr_values);
            }
            if ($model->id) {
                $model->save();
            } else {
                $data = $model->data();
                if ($model->checkRepeat($data)) {
                    $this->ajaxReturn(array(
                        'status' => 'error',
                        'message' => '该模型下的属性已存在！'
                    ));
                }
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
        $model = D("Attr");
        $model->is_del = 1;
        $model->where(array('id' => $id));
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}