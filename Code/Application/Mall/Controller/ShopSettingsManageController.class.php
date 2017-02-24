<?php
namespace Mall\Controller;

/**
 * Class ShopSettingsManageController
 *
 * @package Mall\Controller
 */

class ShopSettingsManageController extends ManageBaseController
{

    /**
     * This is the shop setting list
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $model = D('Shop');
        $list = $model->search(I());
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage()
        ));
        $this->display();
    }

    /**
     * This is the open shop action
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $shop_id
     */
    public function open($shop_id)
    {
        $model = D('Shop');
        $model->find($shop_id);
        $model->status = 1;
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

}
