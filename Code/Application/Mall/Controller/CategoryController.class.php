<?php
/**
 * 商品分类控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 **/

namespace Mall\Controller;

class CategoryController extends MobileBaseController {
    
    public function index(){
        $category = D('category')->fetchAll();
        $res = list_to_tree($category, 'id', 'pid');
        
        $search = D('Search')->getList();
        
        $data = array(
            'cate' => $res,
            'search' => $search
        );
//        debug($res);
        $this->assign('data', $data);
        $this->display();
    }
    
}