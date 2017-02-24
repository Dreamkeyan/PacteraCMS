<?php
/**
 *
 *
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */
namespace Manage\Controller;

class IndexController extends CommonController
{

    public function index()
    {
        $menu = D('Menu')->where(array('is_show' => 1))->order('orderby asc')->select();
        $tmp = array();
        foreach($menu as $v){
            $tmp[$v['menu_id']] = $v;
        }
        $menu = $tmp; unset($tmp);
        if ($this->_admin['role_id'] != 1) {
            if ($this->_admin['menu_list']) {
                foreach ($menu as $k => $val) {
                    if (!empty($val['menu_action']) && !in_array($k, $this->_admin['menu_list'])) {
                        unset($menu[$k]);
                    }
                }
                foreach ($menu as $k1 => $v1) {
                    if ($v1['parent_id'] == 0) {
                        foreach ($menu as $k2 => $v2) {
                            if ($v2['parent_id'] == $v1['menu_id']) {
                                $unset = true;
                                foreach ($menu as $k3 => $v3) {
                                    if ($v3['parent_id'] == $v2['menu_id']) {
                                        $unset = false;
                                    }
                                }
                                if ($unset)
                                    unset($menu[$k2]);
                            }
                        }
                    }
                }
                foreach ($menu as $k1 => $v1) {
                    if ($v1['parent_id'] == 0) {
                        $unset = true;
                        foreach ($menu as $k2 => $v2) {
                            if ($v2['parent_id'] == $v1['menu_id']) {
                                $unset = false;
                            }
                        }
                        if ($unset)
                            unset($menu[$k1]);
                    }
                }
            } else {
                $menu = array();
            }
        }
        $this->assign('menuList', $menu);
        $this->display();
    }

    public function main()
    {
        $this->display();
    }
}
