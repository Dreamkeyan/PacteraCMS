<?php

namespace Mall\Controller;

use Mall\Service\TreeService;
use Mall\Service\SpecService;

/**
 * Class ParamManageController
 *
 * @package Mall\Controller
 */
class ParamManageController extends ManageBaseController
{

    /**
     * category manage list page
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $tree_data = D('Category')->getTreeData();
        $service = new TreeService($tree_data);
        $data = $service->getTreeData();
        $this->assign('data', json_encode($data));
        $this->display();
    }

    /**
     * get params by category id
     *
     * @param $cateid
     */
    public function getParams($cateid)
    {
        $this->ajaxReturn(array(
            'attr' => D('Attr')->getAttrByCateid($cateid),
            'spec' => D('Spec')->getSpecByCateid($cateid),
        ));
    }

    /**
     * get spec talbe
     */
    public function spectable()
    {
        $specitems = D('SpecItem')->getItemBySpecids(I('itemids'));
        $service = new SpecService($specitems);
        $thead = $service->getThead();
        $tbody = $service->getTbody();
        $this->assign(array(
            'thead' => $thead,
            'tbody' => $tbody
        ));
        $this->display();
    }

}