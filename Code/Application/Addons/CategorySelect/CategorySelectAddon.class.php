<?php
/**
 * 商品类别下拉框插件
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 2016.4.18
 */

namespace Addons\CategorySelect;

use Common\Controller\Addon;

class CategorySelectAddon extends Addon
{
    
    public $info = array(
        'name'         => 'CategorySelect',
        'status'       => 1,
        'author'       => '王荣',
        'version'      => '0.1',
        'description' => '商品类别下拉框'
    );
    
    public function install()
    {
        return true;
    }
    
    public function uninstall()
    {
        return true;
    }
    
    /**
     * {:hook('categorySelect', array('name' => 'pid', 'value' => I('get.pid', 0), 'merge' => array(id => 0, 'text' => '全部商品'), 'div' =>0))}
     */
    public function categorySelect($param)
    {
        echo 'dsds';return;
        //获取类别树
        $category = D('Category')->getAll(null, 'id, name, title, pid');
        $category = A('Category')->categoryLists2Tree($category);
        !isset($param['div']) && $param['div'] = 1;
        $this->assign('category', $category);
        $this->assign('param', $param);
        $this->display('categorySelect');
    }
}

