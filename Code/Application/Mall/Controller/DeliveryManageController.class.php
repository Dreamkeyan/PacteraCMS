<?php

namespace Mall\Controller;

use Mall\Service\TreeService;

/**
 * Class DeliveryManageController
 *
 * @package Mall\Controller
 */
class DeliveryManageController extends ManageBaseController
{

    /**
     * delivery manage list page
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $this->display();
    }

}