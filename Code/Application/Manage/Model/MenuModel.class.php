<?php

/**
 *
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class MenuModel extends CommonModel
{

    protected $pk = 'menu_id';
    protected $tableName = 'manage_menu';
    protected $orderby = array('orderby' => 'asc');
    protected $token = "manage_menu";

    public function checkAuth($auth)
    {
        $data = $this->fetchAll();
        foreach ($data as $row) {
            if ($auth == $row['menu_action']) {
                return true;
            }
        }
        return false;
    }
}