<?php
namespace Mall\Controller;

/**
 * Class MemberManageController
 *
 * @package Mall\Controller
 */
class MemberManageController extends ManageBaseController
{

    /**
     * This action is search member by keywords for select2
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $q
     */
    public function select2search($q)
    {
        $data = D('Member')->searchKeyword($q);
        $this->ajaxReturn(json_encode($data));
    }

}
