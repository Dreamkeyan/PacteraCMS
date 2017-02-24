<?php

namespace Mall\Controller;

/**
 * Class GoodsManageController
 *
 * @package Mall\Controller
 */
class ImageManageController extends ManageBaseController
{

    /**
     * this is advertisement page
     */
    public function advertisement()
    {
        $this->display();
    }

    /**
     * this is the default image manage page
     */
    public function index()
    {
        $this->display();
    }

    /**
     * this is the ad position manage page
     */
    public function position()
    {
        $this->display();
    }

}